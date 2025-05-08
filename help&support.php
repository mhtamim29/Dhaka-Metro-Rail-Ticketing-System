<?php

$requireAdmin = false; 
include 'session_check.php';

$name = htmlspecialchars($_SESSION['full_name']);
$email = htmlspecialchars($_SESSION['email']);
$phone = htmlspecialchars($_SESSION['phone_number']);
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
    <link rel="stylesheet" href="css/help&support.css">
    <link rel="stylesheet" href="css/Footer.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <img src="picture/logo.png" alt="Dhaka Metro Rail" style="max-height: 80px;">
            </div>
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

    <div class="main-card" >
        <h1 class="section-title">Help & Support</h1>

        <!-- Lost & Found Section -->
        <div class="lost-found-section">
            <button class="toggle-btn" onclick="toggleSection('lost-found')">
                <b>Lost & Found</b>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="form-container" id="lost-found-form">
                <form id="lostFoundForm" action="submit_lost_found.php" method="POST" enctype="multipart/form-data">
                    <div class="radio-group">
                        <label><input type="radio" name="type" value="Lost" checked>I lost something</label>
                        <label><input type="radio" name="type" value="Found">I found something</label>
                    </div>

                    <div class="form-group">
                        <label for="item-description">Description of Item:</label>
                        <textarea id="item-description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="lost-location">Location (Station/Train):</label>
                        <select id="lost-location" name="location" required>
                            <option value="" disabled selected>Select Station</option>
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

                    <div class="form-group">
                        <label for="lost-date">Date:</label>
                        <input type="date" id="lost-date" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="contact-name">Your Name:</label>
                        <input type="text" id="contact-name" name="name" value="<?php echo $name; ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="contact-email">Email:</label>
                        <input type="email" id="contact-email" name="email" value="<?php echo $email; ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="contact-phone">Phone Number:</label>
                        <input type="tel" id="contact-phone" name="phone" value="<?php echo $phone; ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="file-upload">Upload Photo (if available):</label>
                        <input type="file" id="file-upload" name="photo" accept="image/*">
                    </div>

                    <button type="submit" class="submit-btn">Submit Report</button>
                </form>
            </div>
        </div>

        <!-- Complaint Section -->
        <div class="complaint-section">
            <button class="toggle-btn" onclick="toggleSection('complaint')">
                <b>Complaint Box</b>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="form-container" id="complaint-form">
                <form id="complaintForm" action="submit_complaint.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="complaint-type">Type of Complaint:</label>
                        <select id="complaint-type" name="type" required>
                            <option value="" disabled selected>Select complaint type</option>
                            <option value="service">Service Issue</option>
                            <option value="staff">Staff Behavior</option>
                            <option value="facility">Facility Problem</option>
                            <option value="safety">Safety Concern</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="complaint-description">Description:</label>
                        <textarea id="complaint-description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="complaint-location">Location (Station/Train):</label>
                        <select id="complaint-location" name="location" required>
                            <option value="" disabled selected>Select Station</option>
                            <!-- Same station options as Lost & Found -->
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

                    <div class="form-group">
                        <label for="complaint-date">Date of Incident:</label>
                        <input type="date" id="complaint-date" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="complaint-name">Your Name:</label>
                        <input type="text" id="complaint-name" name="name" value="<?php echo $name; ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="complaint-email">Email:</label>
                        <input type="email" id="complaint-email" name="email" value="<?php echo $email; ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="complaint-phone">Phone Number:</label>
                        <input type="tel" id="complaint-phone" name="phone" value="<?php echo $phone; ?>" readonly required>
                    </div>
                    
                    <div class="form-group">
                        <label for="complaint-photo">Upload Photo (if available):</label>
                        <input type="file" id="complaint-photo" name="photo" accept="image/*">
                    </div>


                    <button type="submit" class="submit-btn">Submit Complaint</button>
                </form>
            </div>
            </div>
            <!-- Important Contacts Section -->
            <div class="contacts-section">
            <h2 class="section-title">Important Contacts</h2>
            <div class="contacts-grid">
                <div class="contact-card">
                    <h3>Emergency</h3>
                    <div class="contact-info">
                        <i class="fas fa-phone"></i>
                        <span>+880 1234 567 890 (24/7)</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Emergency Hotline</span>
                    </div>
                </div>

                <div class="contact-card">
                    <h3>Customer Service</h3>
                    <div class="contact-info">
                        <i class="fas fa-headset"></i>
                        <span>+880 1234 567 891</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-clock"></i>
                        <span>8:00 AM - 10:00 PM (Daily)</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-envelope"></i>
                        <span>customercare@dmtcl.gov.bd</span>
                    </div>
                </div>

                <div class="contact-card">
                    <h3>Lost & Found</h3>
                    <div class="contact-info">
                        <i class="fas fa-box-open"></i>
                        <span>+880 1234 567 892</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-clock"></i>
                        <span>9:00 AM - 8:00 PM (Daily)</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Uttara North Station</span>
                    </div>
                </div>
            </div>
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
                <p style="line-height: 3ch;text-align: justify;">Dhaka Metro Rail is a modern mass rapid transit system operated by Dhaka Mass Transit Company Limited (DMTCL). It aims to provide a fast, safe, and eco-friendly transportation solution for the people of Dhaka, reducing congestion and improving urban mobility.</p>
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
        function toggleSection(sectionId) {
            const form = document.getElementById(`${sectionId}-form`);
            const icon = document.querySelector(`.toggle-btn[onclick="toggleSection('${sectionId}')"] i`);
            form.classList.toggle('active');
            icon.classList.toggle('fa-chevron-up');
            icon.classList.toggle('fa-chevron-down');
        }

        function toggleMenu() {
            const menu = document.getElementById('dropdownMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('lost-date').value = today;
            document.getElementById('complaint-date').value = today;
        });
    </script>
</body>
</html>
