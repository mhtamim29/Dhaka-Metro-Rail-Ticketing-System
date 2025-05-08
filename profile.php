<?php
// Start the session to maintain user login state
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "metro_ticketing_system_schema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Initialize message variable
$message = "";

// Handle form submission for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if it's a profile update or password change
    if (isset($_POST['update_profile'])) {
        // Fetch current user data first to avoid overwriting with empty values
        $current_sql = "SELECT full_name, address, phone_number, email, nid_number FROM users WHERE user_id = $user_id";
        $current_result = $conn->query($current_sql);
        $current_data = $current_result->fetch_assoc();
        
        // Get form data, using current values as fallbacks
        $full_name = !empty($_POST['name']) ? $conn->real_escape_string($_POST['name']) : $current_data['full_name'];
        $address = !empty($_POST['address']) ? $conn->real_escape_string($_POST['address']) : $current_data['address'];
        $phone_number = !empty($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : $current_data['phone_number'];
        $email = !empty($_POST['email']) ? $conn->real_escape_string($_POST['email']) : $current_data['email'];
        $nid = !empty($_POST['nid']) ? $conn->real_escape_string($_POST['nid']) : $current_data['nid_number'];
        
        // Update user data
        $sql = "UPDATE users SET 
                full_name = '$full_name', 
                address = '$address', 
                phone_number = '$phone_number', 
                email = '$email', 
                nid_number = '$nid',
                updated_at = NOW()
                WHERE user_id = $user_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Profile updated successfully!";
        } else {
            $message = "Error updating profile: " . $conn->error;
        }
    }
    
    // Handle password change
    if (isset($_POST['change_password']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        
        if ($password === $confirmPassword) {
            // Hash password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Update password
            $sql = "UPDATE users SET 
                    password = '$hashed_password',
                    updated_at = NOW()
                    WHERE user_id = $user_id";
            
            if ($conn->query($sql) === TRUE) {
                $message = "Password changed successfully!";
            } else {
                $message = "Error changing password: " . $conn->error;
            }
        } else {
            $message = "Passwords do not match!";
        }
    }
    
    // Handle profile image upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_pic']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Verify file extension
        if (in_array(strtolower($filetype), $allowed)) {
            // Create unique filename
            $new_filename = "user_" . $user_id . "_" . time() . "." . $filetype;
            $upload_dir = "uploads/profile_pics/";
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $upload_path)) {
                // Update profile picture path in database
                $sql = "UPDATE users SET 
                        profile_pic = '$upload_path',
                        updated_at = NOW()
                        WHERE user_id = $user_id";
                
                if ($conn->query($sql) === TRUE) {
                    $message = "Profile picture updated successfully!";
                } else {
                    $message = "Error updating profile picture: " . $conn->error;
                }
            } else {
                $message = "Error uploading file.";
            }
        } else {
            $message = "Invalid file type. Only JPG, JPEG, PNG and GIF are allowed.";
        }
    }
}

// Fetch current user data
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    $message = "User not found!";
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhaka Metro Rail</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kameron:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/Footer.css">
    <script src="Js/index.js"></script>
    <!-- <style>
        /* Additional styles for messages */
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style> -->
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

    <!-- Profile Section -->
    <profile style="padding-top: 130px;" class="container">
        <div class="card">
            <h2>My Profile</h2>
            
            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="profile-picture-container">
                <?php 
                    $profile_pic = isset($user_data['profile_pic']) && !empty($user_data['profile_pic']) 
                        ? $user_data['profile_pic'] 
                        : "picture/default-avatar.png";
                ?>
                <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" id="profilePic">
                <form enctype="multipart/form-data" method="post" id="profilePicForm">
                    <input type="file" id="uploadPic" name="profile_pic" accept="image/*" hidden onchange="document.getElementById('profilePicForm').submit();">
                    <label for="uploadPic" class="upload-icon"><i class="fas fa-camera"></i></label>
                </form>
            </div>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="profileForm">
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['full_name']); ?>" readonly>
                    <i class="fas fa-edit edit-icon" onclick="toggleEdit('name')"></i>
                </div>
                
                <div class="input-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user_data['address']); ?>" readonly>
                    <i class="fas fa-edit edit-icon" onclick="toggleEdit('address')"></i>
                </div>
                
                <div class="input-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user_data['phone_number']); ?>" readonly>
                    <i class="fas fa-edit edit-icon" onclick="toggleEdit('phone')"></i>
                </div>
                
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly>
                    <i class="fas fa-edit edit-icon" onclick="toggleEdit('email')"></i>
                </div>
                
                <div class="input-group">
                    <label for="nid">NID Number</label>
                    <input type="text" id="nid" name="nid" value="<?php echo htmlspecialchars($user_data['nid_number']); ?>" readonly>
                    <i class="fas fa-edit edit-icon" onclick="toggleEdit('nid')"></i>
                </div>

                <div class="input-group">
                    <label for="password">Change Password</label>
                    <input type="password" id="password" name="password" placeholder="Change your password">
                </div>
                
                <div class="input-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password">
                </div>
                
                <button type="submit" name="update_profile" class="btn">SAVE PROFILE CHANGES</button>
                <button type="submit" name="change_password" class="btn" style="margin-top: 10px;">CHANGE PASSWORD</button>
            </form>
        </div>
    </profile>

    <!-- Sign Out Button -->
    <div class="sign-out-container">
        <a href="logout.php" class="btn-sign-out">LOG OUT</a>
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
                <p>Contact Us</p>
                <p>FAQs</p>
                <p>Terms & Conditions</p>
                <p>Privacy Policy</p>
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
        function toggleEdit(fieldId) {
            const field = document.getElementById(fieldId);
            
            // Toggle between readonly instead of disabled
            if (field.readOnly) {
                field.readOnly = false;
                field.focus();
            } else {
                field.readOnly = true;
            }
        }
        
        function toggleMenu() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('show');
        }
        
        // Preview image before upload
        const uploadPic = document.getElementById('uploadPic');
        const profilePic = document.getElementById('profilePic');
        
        if (uploadPic) {
            uploadPic.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePic.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
</body>
</html>