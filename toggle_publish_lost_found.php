<?php
// Make sure the user is authenticated as admin
$requireAdmin = true;
include 'session_check.php';

// Database connection
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

// Check if ID and publish status are provided
if (isset($_GET['id']) && isset($_GET['publish'])) {
    $id = $_GET['id'];
    $publish = $_GET['publish'];
    
    // Validate input
    if (!is_numeric($id) || !in_array($publish, ['0', '1'])) {
        echo "Invalid input";
        exit;
    }
    
    // Update the item's publish status
    $sql = "UPDATE lost_found SET isPublished = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $publish, $id);
    
    if ($stmt->execute()) {
        echo "Item publish status updated successfully";
    } else {
        echo "Error updating publish status: " . $conn->error;
    }
    
    $stmt->close();
} else {
    echo "Missing required parameters";
}

$conn->close();
?>