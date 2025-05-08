<?php
$requireAdmin = false; // Only normal users can access
include 'session_check.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_ticketing_system_schema";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT t.*, u.full_name, u.email, u.phone_number, u.nid_number FROM tickets t JOIN users u ON t.user_id = u.user_id WHERE t.user_id = ? ORDER BY t.ticket_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$ticket = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Prepare ticket data for QR code
$qrData = "";
if ($ticket) {
    $qrData = json_encode([
        'ticket_no' => $ticket['ticket_no'],
        'date' => $ticket['date'],
        'time' => $ticket['time'],
        'from' => $ticket['origin_station'],
        'to' => $ticket['destination_station'],
        'fare' => $ticket['fare'],
        'name' => $ticket['full_name'],
        'nid' => $ticket['nid_number']
    ]);
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
    <!-- QR Code library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- PDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/myticket.css">
    <link rel="stylesheet" href="css/Footer.css">
    <script src="Js/buyticket.js"></script>
    <style>
        #qrcode {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 10px;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .download-btn {
            display: inline-block;
            background-color: #006a4e;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-bottom: 15px;
            cursor: pointer;
            border: none;
        }
        .download-btn:hover {
            background-color: #006a4e;
        }
    </style>
</head>
<body>
<header>
        <div class="container header-content">
          <div class="logo">
            <img src="picture/logo.png" alt="Dhaka Metro Rail" />
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
    <div class="container" style="padding-top: 60px; padding-bottom: 30px;">
        <div class="card">
            <h2>Your Metro Rail Ticket</h2>
            <?php if ($ticket): ?>
            </div>
            <div id="ticket-content" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="picture/logo.png" alt="Dhaka Metro Rail" style="max-height: 60px;">
                    <h3>DHAKA MASS TRANSIT COMPANY LIMITED (DMTCL)</h3>
                    <h4>Congratulations, You Have Successfully Booked a Ticket</h4>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <div><strong>Ticket No:</strong> <?= htmlspecialchars($ticket['ticket_no']) ?></div>
                    <div><strong>Date:</strong> <?= htmlspecialchars($ticket['date']) ?></div>
                    <div><strong>Time:</strong> <?= htmlspecialchars($ticket['time']) ?></div>
                </div>

                <div style="margin: 20px 0;display: flex; justify-content: space-between;">
                    <div><strong>From:</strong> <?= htmlspecialchars($ticket['origin_station']) ?></div>
                     <div><strong>→<strong></div>
                    <div><strong>To:</strong> <?= htmlspecialchars($ticket['destination_station']) ?></div>
                </div>

                <div><strong>Fare:</strong> <?= htmlspecialchars($ticket['fare']) ?> Taka</div>
                <div><strong>Payment Method:</strong> <?= htmlspecialchars($ticket['payment_method']) ?></div>

                <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                    <div style="width: 60%;">
                        <h3>Passenger Information</h3>
                        <p><strong>Name:</strong> <?= htmlspecialchars($ticket['full_name']) ?></p>
                        <p><strong>NID:</strong> <?= htmlspecialchars($ticket['nid_number']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($ticket['email']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($ticket['phone_number']) ?></p>
                    </div>
                    </div>
                    <div style="display: flex; justify-content: center; width: 100%;">
                    <div style="width: 35%; text-align: center;">
                        <h3>QR Code</h3>
                        <div id="qrcode" style="margin: 0 auto; width: fit-content;"></div>
                        <p style="font-size: 0.8em; margin-top: 5px;">Scan at entry and exit gates</p>
                    </div>
                    </div>


                <div style="color: red; margin-top: 20px;text-align: center;">
                    <p>This ticket is valid for a single journey only. It is non-transferable and non-refundable.</p>
                    <p>Please ensure you scan your QR code at the entry and exit gates.</p>
                </div>
            </div>
            <script>
                // Create QR code when page loads
                window.onload = function() {
                    const qrcode = new QRCode(document.getElementById("qrcode"), {
                        text: <?= json_encode($qrData) ?>,
                        width: 180,
                        height: 180,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                };
                
                // Function to download ticket as PDF
                function downloadPDF() {
                    const element = document.getElementById('ticket-content');
                    const opt = {
                        margin: 10,
                        filename: 'dhaka-metro-ticket-<?= htmlspecialchars($ticket['ticket_no']) ?>.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2, useCORS: true },
                        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                    };
                    
                    // Create PDF
                    html2pdf().from(element).set(opt).save();
                }
            </script>
            <?php else: ?>
            <p style="color: red;">No ticket found. Please buy a ticket first.</p>
            <?php endif; ?>
        </div><br>
        <div style="text-align: center; margin-bottom: 15px;">
                <button class="download-btn" onclick="downloadPDF()">
                    <i class="fas fa-download"></i> Download Ticket
                </button>
            </div>
    </div>
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
        <div class="copyright">
            <p><strong>Copyright & Disclaimer:</strong></p>
            <p>&copy; 2025 Dhaka Mass Transit Company Limited (DMTCL). All rights reserved.</p>
        </div>
</body>
</html>