<?php
// Start session
session_start();

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_ticketing_system_schema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Fetch user including is_admin flag
    $sql = "SELECT user_id, full_name, email, phone_number, password, is_admin FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['phone_number'] = $row['phone_number'];
            $_SESSION['is_admin'] = (bool)$row['is_admin'];

            // Redirect based on role
            if ($row['is_admin']) {
                header("Location: admindashboard.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            header("Location: login.php?error=Invalid password");
            exit();
        }
    } else {
        header("Location: login.php?error=Email not found");
        exit();
    }
}

$conn->close();
?>
