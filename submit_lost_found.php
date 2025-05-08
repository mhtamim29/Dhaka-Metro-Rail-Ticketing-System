<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_ticketing_system_schema";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['full_name'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone_number'];

$type = $_POST['type']; // "lost" or "found"
$description = $_POST['description'];
$location = $_POST['location'];
$date = $_POST['date'];

$photo_url = '';
if (!empty($_FILES['photo']['name'])) {
    $upload_dir = "uploads/lost_found/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $file_name = basename($_FILES["photo"]["name"]);
    $target_file = $upload_dir . time() . "_" . $file_name;
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $photo_url = $target_file;
    }
}

$type_formatted = ucfirst(strtolower($type)); // Lost or Found

$sql = "INSERT INTO lost_found (user_id, type, description, location, date, photo_url, name, email, phone_number)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssssss", $user_id, $type_formatted, $description, $location, $date, $photo_url, $name, $email, $phone);

if ($stmt->execute()) {
    echo "Success: Lost & Found report submitted.";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
