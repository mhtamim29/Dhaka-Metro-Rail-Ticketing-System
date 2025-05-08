<?php
$requireAdmin = false; // Only normal users can access
include 'session_check.php';
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_ticketing_system_schema";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Process delete request if present
if (isset($_POST['delete_ticket_id'])) {
    $delete_id = $_POST['delete_ticket_id'];
    $delete_sql = "DELETE FROM tickets WHERE ticket_id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ii", $delete_id, $user_id);
    $delete_stmt->execute();
    $delete_stmt->close();
    
    // Redirect to avoid form resubmission
    header("Location: travelhistory.php?deleted=true");
    exit();
}

// Get filter parameters
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'date-desc';

// Base SQL query
$sql = "SELECT * FROM tickets WHERE user_id = ?";

// Add date filter if provided
if (!empty($date_filter)) {
    $sql .= " AND DATE(date) = ?";
}

// Add sorting
if ($sort_order == 'date-asc') {
    $sql .= " ORDER BY date ASC";
} else {
    $sql .= " ORDER BY date DESC";
}

// Prepare and execute query
$stmt = $conn->prepare($sql);

if (!empty($date_filter)) {
    $stmt->bind_param("is", $user_id, $date_filter);
} else {
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
$tickets = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

// Function to format date
function formatDisplayDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('d-m-Y');
}

// Function to format time
function formatTime($timeString) {
    $time = new DateTime($timeString);
    return $time->format('h:i A');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhaka Metro Rail</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kameron:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/history.css">
    <link rel="stylesheet" href="css/Footer.css">
    <script src="Js/index.js"></script>

</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <img src="picture/logo.png" alt="Dhaka Metro Rail" style="max-height: 80px;">
            </div>
            <button class="hamburger-btn" id="menu-toggle" aria-label="Toggle menu" aria-expanded="false">
                <i class="fas fa-bars"></i>
            </button>
            <nav>
            <ul class="nav-links">
                    <li><a href="home.php">HOME</a></li>
                    <li><a href="buyticket.php">BUY TICKET</a></li>
                    <li><a href="help&support.php">HELP & SUPPORT</a></li>
                    <li><a href="myticket.php">MY TICKETS</a></li>
                    <li><a href="travelhistory.php">TRAVEL HISTORY</a></li>
                    <li><a href="profile.php">PROFILE</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main style="padding-top: 60px; padding-bottom: 30px;" class="container">
        <div class="card travel-card">
            <h1 class="page-title">Travel History</h1>
             
            <div class="table-container">
                <table id="travelHistoryTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Fare (৳)</th>
                            <th>Ticket No</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($tickets) > 0): ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td><?php echo formatDisplayDate($ticket['date']); ?></td>
                                    <td><?php echo formatTime($ticket['time']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['origin_station']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['destination_station']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['fare']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['ticket_no']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['payment_method']); ?></td>
                                    <td>
                                        <a href="viewticket.php?id=<?php echo $ticket['ticket_id']; ?>" class="ticket-btn">View</a>
                                        <form method="POST" action="" style="display:inline-block">
                                            <input type="hidden" name="delete_ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                                            <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this ticket record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
    
            <div id="noResults" class="no-results">
                <i class="fas fa-train"></i>
                <p>No travel history found</p>
            </div>
        </div>
    </main>
    
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Company Information:</h3>
                <p>Dhaka Mass Transit Company Limited (DMTCL)</p>
                <p>Metro Rail Bhaban, Uttara, Dhaka-1230, Bangladesh</p>
                <p>Email: info@dmtcl.gov.bd</p>
                <p>☎ Helpline: +880 1234 567 890</p>
            </div>
            <div style="margin-left: 50px;padding-left: 50px;" class="footer-section">
                <h3>About</h3>
                <p style="line-height: 3ch; text-align: justify;">Dhaka Metro Rail is a modern mass rapid transit system operated by Dhaka Mass Transit Company Limited (DMTCL). It aims to provide a fast, safe, and eco-friendly transportation solution for the people of Dhaka, reducing congestion and improving urban mobility.</p>
            </div>
            <div style="margin-left: 120px;" class="footer-section">
                <h3>Quick Links:</h3>
                <p>Contact Us</a></p>
                </p>FAQs</a></p>
                <p>Terms & Conditions</a></p>
                <p>Privacy Policy</a></p>
                <h3>Follow Us:</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com" target="_blank" class="text-dark me-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="https://twitter.com" target="_blank" class="text-dark me-3"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="https://www.instagram.com" target="_blank" class="text-dark me-3"><i class="fab fa-instagram fa-2x"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Show notification if delete was successful
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
        window.onload = function() {
            showNotification('Ticket record deleted successfully');
        };
        <?php endif; ?>

        // Show notification function
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }

        // Clear date filter
        document.getElementById('clearDateBtn').addEventListener('click', function() {
            document.getElementById('dateInput').value = '';
            // Submit the form after clearing the date
            this.form.submit();
        });

        // Mobile menu toggle
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('nav-links').classList.toggle('show-mobile');
        });
    </script>
</body>
</html>