<?php
// Start session and check admin permissions
$requireAdmin = true;
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

// Database configuration (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_ticketing_system_schema";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get total non-admin users
function getTotalUsers($conn) {
    $query = "SELECT COUNT(*) as total FROM users WHERE is_admin = 0";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to get passenger count
function getPassengerRatio($conn, $date = null) {
    if ($date) {
        $query = "SELECT COUNT(*) as total FROM tickets WHERE DATE(date) = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $query = "SELECT COUNT(*) as total FROM tickets";
        $result = $conn->query($query);
    }
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to get total income
function getIncomeRatio($conn, $date = null) {
    if ($date) {
        $query = "SELECT SUM(fare) as total FROM tickets WHERE DATE(date) = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $query = "SELECT SUM(fare) as total FROM tickets";
        $result = $conn->query($query);
    }
    $row = $result->fetch_assoc();
    return $row['total'] ? $row['total'] : 0;
}

// Get statistics
$totalUsers = getTotalUsers($conn);
$passengersDate = $_GET['passengersDate'] ?? null;
$incomeDate = $_GET['incomeDate'] ?? null;
$passengersRatio = getPassengerRatio($conn, $passengersDate);
$incomeRatio = getIncomeRatio($conn, $incomeDate);
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
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dasboard.css">
    <link rel="stylesheet" href="css/Footer.css">
    <script src="Js/dashboard.js"></script>
    <script src="Js/index.js"></script>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <img src="picture/logo.png" alt="Dhaka Metro Rail" style="max-height: 80px;">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="admindashboard.php">DASHBOARD</a></li>
                    <li><a href="updatenotice.html">UPDATE NOTICE</a></li>
                    <li><a href="lost&found.php">LOST & FOUND</a></li>
                    <li><a href="complain.php">COMPLAIN BOX</a></li>
                    <li><a href="logout.php" id="signout-link">LOGOUT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="stats-card">
        <div class="stats-container">
            <div class="stat-box">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Passengers</h3>
                <p><?php echo $passengersRatio; ?></p>
                <div class="date-picker">
                    <form method="GET">
                        <input type="date" name="passengersDate" value="<?php echo $passengersDate; ?>">
                        <button type="submit" class="btn">Filter</button>
                    </form>
                </div>
            </div>
            <div class="stat-box">
                <h3>Total Income</h3>
                <p>৳<?php echo number_format($incomeRatio, 2); ?></p>
                <div class="date-picker">
                    <form method="GET">
                        <input type="date" name="incomeDate" value="<?php echo $incomeDate; ?>">
                        <button type="submit" class="btn">Filter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <main class="container">
        <section>
            <div style="padding-top: 50px;" class="content-row">
                <div class="card schedule-card" style="margin-top: 0; padding-top: 0.1rem; text-align: center;background-color: #a7eede;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <select class="form-control" style="width: 120px; height: 40px; margin-top: 1rem;">
                            <option value="">Select Time</option>
                            <option value="08:00">08:00 AM</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="13:00">01:00 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="16:00">04:00 PM</option>
                            <option value="17:00">05:00 PM</option>
                            <option value="18:00">06:00 PM</option>
                            <option value="19:00">07:00 PM</option>
                            <option value="20:00">08:00 PM</option>
                            <option value="21:00">09:00 PM</option>
                            <option value="22:00">10:00 PM</option>
                        </select>
                        <h2 style="text-align:center;padding-top: 15px">Live Metro Schedule</h2>
                        <select class="form-control" style="width: 200px; height: 40px; margin-top: 1rem;">
                            <option value="" disabled selected>Select Your Station</option>
                            <option value="uttara-north">Uttara North</option>
                            <option value="uttara-center">Uttara Center</option>
                            <option value="uttara-south">Uttara South</option>
                            <option value="pallabi">Pallabi</option>
                            <option value="mirpur-11">Mirpur-11</option>
                            <option value="mirpur-10">Mirpur-10</option>
                            <option value="kazipara">Kazipara</option>
                            <option value="shewrapara">Shewrapara</option>
                            <option value="agargaon">Agargaon</option>
                            <option value="bijoy-sarani">Bijoy Sarani</option>
                            <option value="farmgate">Farmgate</option>
                            <option value="karwan-bazar">Karwan Bazar</option>
                            <option value="shahbagh">Shahbagh</option>
                            <option value="dhaka-university">Dhaka University</option>
                            <option value="bangladesh-secretariat">Bangladesh Secretariat</option>
                            <option value="motijheel">Motijheel</option>
                        </select>
                    </div>
                    
                    <table style="width: 100%; border-collapse: collapse; border-radius: 100px; border: #006a4e;">
                        <thead style="width: 100%; background-color: #006a4e">
                            <tr style="color: var(--white);">
                                <th style="padding: 1rem;"> Serial No</th>
                                <th style="padding: 1rem;">Arrival</th>
                                <th style="padding: 1rem;">Departure</th>
                            </tr>
                        </thead>
                        <tbody id="scheduleTable">
                            <tr style="background-color: var(--white);">
                                <td style="padding: 1rem; text-align: center;">1</td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="time-display">8:00 AM</span>
                                    <input type="time" class="time-edit" value="08:00" style="display: none;">
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="time-display">8:01 AM</span>
                                    <input type="time" class="time-edit" value="08:01" style="display: none;">
                                </td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 1rem; text-align: center;">2</td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="time-display">8:20 AM</span>
                                    <input type="time" class="time-edit" value="08:20" style="display: none;">
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="time-display">8:21 AM</span>
                                    <input type="time" class="time-edit" value="08:21" style="display: none;">
                                </td>
                            </tr>
                            <tr style="background-color: var(--white);">
                                <td style="padding: 1rem; text-align: center;">3</td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="time-display">8:40 AM</span>
                                    <input type="time" class="time-edit" value="08:40" style="display: none;">
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="time-display">8:41 AM</span>
                                    <input type="time" class="time-edit" value="08:41" style="display: none;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="card metro-times" style="margin-top: 0; padding-top: 0.1rem; text-align: center;background-color: #a7eede;border-radius: 20px;">
                    <h2 style="padding-top: 15px">First/Last Metro Time</h2>
                    
                    <h3>Motijheel</h3>
                    <div class="time-box" id="motijheel-first">
                        First Metro at <span class="time-display">8:00 AM</span>
                        <input type="time" class="time-input" value="08:00" style="display: none;">
                    </div>
                    <div class="time-box" id="motijheel-last">
                        Last Metro at <span class="time-display">10:40 PM</span>
                        <input type="time" class="time-input" value="22:40" style="display: none;">
                    </div>
                    
                    <h3>Uttara-North</h3>
                    <div class="time-box" id="uttara-first">
                        First Metro at <span class="time-display">7:30 AM</span>
                        <input type="time" class="time-input" value="07:30" style="display: none;">
                    </div>
                    <div class="time-box" id="uttara-last">
                        Last Metro at <span class="time-display">10:10 PM</span>
                        <input type="time" class="time-input" value="22:10" style="display: none;">
                    </div>
                    
                </div>
            </div>
        </section>

        <section class="content-row">
            <div class="card notices-card">
                <h2 class="section-title">Notices & Alerts</h2>
                <div class="notices">
                    <div class="notice-item">
                        <div class="notice-date">25/02/2025</div>
                        <h3 class="notice-title">Threat to Suspend Services</h3>
                        <p>Officials and employees of Dhaka Mass Transit Company Limited (DMTCL) have threatened to suspend metro rail services on February 21, 2025, due to unresolved issues.</p>
                    </div>
                    
                    <div class="notice-item">
                        <div class="notice-date">21/02/2025</div>
                        <h3 class="notice-title">Revised Friday Schedule</h3>
                        <p>As of January 16, 2025, the metro rail operates on Fridays from 3:00 PM to 9:00 PM, with departures from Uttara North to Motijheel starting at 3:00 PM and from Motijheel to Uttara North at 3:20 PM.</p>
                    </div>
                    
                    <div class="notice-item">
                        <div class="notice-date">27/02/2025</div>
                        <h3 class="notice-title">Caution Against Flying Lanterns</h3>
                        <p>In January 2025, DMTCL issued a notice advising the public to refrain from flying lanterns near metro rail areas to prevent potential hazards.</p>
                    </div>
                    <button id="viewAllBtn" class="btn">
                        <a href="notice.html">View More Notices</a>
                    </button>
                </div>
            </div>
            
            <div class="card metro-map-card">
                <h2>Dhaka Metro station Route</h2>
                <div class="map-container">
                    <img src="picture/station list.png" alt="Metro Map">
                </div>
            </div>
        </section>
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
    <div class="copyright">
        <p><strong>Copyright & Disclaimer:</strong></p>
        <p>&copy; 2025 Dhaka Mass Transit Company Limited (DMTCL). All rights reserved.</p>
    </div>
    
    <script>
        // JavaScript for editing schedule times
        document.addEventListener('DOMContentLoaded', function() {
            // Enable editing of schedule times
            const timeDisplays = document.querySelectorAll('.time-display');
            
            timeDisplays.forEach(display => {
                display.addEventListener('dblclick', function() {
                    const input = this.nextElementSibling;
                    this.style.display = 'none';
                    input.style.display = 'inline-block';
                    input.focus();
                });
            });
            
            const timeInputs = document.querySelectorAll('.time-edit, .time-input');
            
            timeInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    const display = this.previousElementSibling;
                    const timeValue = this.value;
                    const [hours, minutes] = timeValue.split(':');
                    const ampm = hours >= 12 ? 'PM' : 'AM';
                    const formattedHours = hours % 12 || 12;
                    display.textContent = `${formattedHours}:${minutes} ${ampm}`;
                    display.style.display = 'inline-block';
                    this.style.display = 'none';
                });
            });
            
            // Handle station selection
            const stationSelect = document.querySelector('select[style="width: 200px; height: 40px; margin-top: 1rem;"]');
            stationSelect.addEventListener('change', function() {
                // In a real application, you would fetch schedule data for the selected station
                console.log('Selected station:', this.value);
            });
            
            // Handle time selection
            const timeSelect = document.querySelector('select[style="width: 120px; height: 40px; margin-top: 1rem;"]');
            timeSelect.addEventListener('change', function() {
                // In a real application, you would filter schedule data by time
                console.log('Selected time:', this.value);
            });
        });
    </script>
</body>
</html>