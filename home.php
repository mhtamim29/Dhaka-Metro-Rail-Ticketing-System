<?php
// Include session check
include 'session_check.php';
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
    <link rel="stylesheet" href="css/hero.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/Footer.css">
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

    <!-- <main style="padding-top: 130px; padding-bottom: 30px;" class="container"> -->
    <main>    
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["full_name"]); ?>!</h1>
        <p>You are now logged in to the Dhaka Metro Rail system.</p>

    <section class="hero">
        <!-- Background Video -->
        <video autoplay muted loop playsinline class="hero-video" id="hero-video">
            <source src="picture/bgv.mp4" type="video/mp4">
            <!-- Fallback image if video doesn't load -->
            <img src="picture/hero-section.png" alt="Dhaka Metro Rail">
        </video>
<div class="container">
    <div style="width: 60%;" class="journey-planner">
        <div>
            <h2 style="margin-top: 0; padding-top: 0.1rem; color: #006a4e;text-align: center;">Plan Your Journey</h2>
        </div>
        <form id="journey-form">
            <div class="form-group">
                <div>
                    <label for="from"><strong>From</strong></label>
                    <select id="from" class="form-control" style="margin-top: 0.5rem;">
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
                <div>
                    <label for="to"><strong>To</strong></label>
                    <select id="to" class="form-control" style="margin-top: 0.5rem;">
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
            </div>
            <button type="button" id="calculate-fare" class="btn btn-large" style="color: white; background-color: #006a4e;"><strong>Calculate Fare</strong></button>
        </form>
    </div>
</div>
</section>
    
    <main class="container">
        <section>
            <div style="padding-top: 50px;" class="content-row">
                <div class="card schedule-card" style="margin-top: 5px; padding-top: 0.1rem; text-align: center;background-color: #a7eede;">
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
                        <tbody>
                            <tr style="background-color: var(--white);">
                                <td style="padding: 1rem; text-align: center;">1</td>
                                <td style="padding: 1rem; text-align: center;">8:00 AM</td>
                                <td style="padding: 1rem; text-align: center;">8:01 AM</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 1rem; text-align: center;">2</td>
                                <td style="padding: 1rem; text-align: center;">8:20 AM</td>
                                <td style="padding: 1rem; text-align: center;">8:21 AM</td>
                            </tr>
                            <tr style="background-color: var(--white);">
                                <td style="padding: 1rem; text-align: center;">3</td>
                                <td style="padding: 1rem; text-align: center;">8:40 AM</td>
                                <td style="padding: 1rem; text-align: center;">8:41 AM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="card metro-times" style="margin-top: 0; padding-top: 0.1rem; text-align: center;background-color: #a7eede;border-radius: 20px;">
                    <h2 style="padding-top: 15px">First/Last Metro Time</h2>
                    <h3>Motijheel</h3>
                    <div class="time-box">
                        First Metro at 8:00 AM
                    </div>
                    <div class="time-box">
                        Last Metro at 10:40 PM
                    </div>
                    <h3>Uttara-North</h3>
                    <div class="time-box">
                        First Metro at 7:30 AM
                    </div>
                    <div class="time-box">
                        Last Metro at 10:10 PM
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
</body>
</html>