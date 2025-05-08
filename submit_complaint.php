<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
$name = $_SESSION['full_name'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone_number'];

$type = $_POST['type'];
$description = $_POST['description'];
$location = $_POST['location'];
$date = $_POST['date'];

$photo_url = '';
if (!empty($_FILES['photo']['name'])) {
    $upload_dir = "uploads/complaints/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $file_name = basename($_FILES["photo"]["name"]);
    $target_file = $upload_dir . time() . "_" . $file_name;
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $photo_url = $target_file;
    }
}

$sql = $sql = "INSERT INTO complaints (user_id, type, location, date, description, photo_url, name, email, phone_number)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssssss", $user_id, $type, $location, $date, $description, $photo_url, $name, $email, $phone);

if ($stmt->execute()) {
    echo "<script>
    alert('Success: Complaint report submitted.');
    window.location.href = 'help&support.php';
</script>";
} else {
    echo "Error: " . $stmt->error;

}

$conn->close();
?>
