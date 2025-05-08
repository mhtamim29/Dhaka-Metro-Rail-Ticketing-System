<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['is_admin']) {
        header("Location: admindashboard.php");
    } else {
        header("Location: home.php");
    }
    exit();
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
    <link rel="stylesheet" href="css/login.css">
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
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="buyticket.php">BUY TICKET</a></li>
                    <li><a href="help&support.php">HELP & SUPPORT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- login part -->
    <login style="padding-top: 130px;padding-bottom: 30px;" class="container">
        <div class="card">
            <h2>Log in</h2>
            <?php
            if(isset($_GET['error'])) {
                echo '<div style="color: red; margin-bottom: 15px; text-align: center;">' . $_GET['error'] . '</div>';
            }
            if(isset($_GET['success'])) {
                echo '<div style="color: green; margin-bottom: 15px; text-align: center;">' . $_GET['success'] . '</div>';
            }
            if(isset($_GET['logout'])) {
                echo '<div style="color: green; margin-bottom: 15px; text-align: center;">You have been successfully logged out.</div>';
            }
            ?>
            <form id="loginForm" action="login_handler.php" method="post">
                <div class="input-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required minlength="8">
                    <div style="margin-top: 3px; color: red; display: none;" id="passwordError" class="error-message">Password must be at least 8 characters long</div>
                </div>
                <button style="background-color: #006a4e;" type="submit" class="btn">Log In</button>
            </form>
            <p class="text-center mt-3">You don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </login>

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
        // Client-side validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('passwordError');
            
            // Validate password length
            if (password.length < 8) {
                e.preventDefault();
                passwordError.style.display = 'block';
                return false;
            } else {
                passwordError.style.display = 'none';
            }
        });

        // Real-time password validation
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const passwordError = document.getElementById('passwordError');
            
            if (password.length > 0 && password.length < 8) {
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });
    </script>
</body>
</html>