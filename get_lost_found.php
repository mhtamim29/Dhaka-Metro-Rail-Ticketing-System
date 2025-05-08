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

// Get all items from the lost_found table
$sql = "SELECT * FROM lost_found ORDER BY date DESC";
$result = $conn->query($sql);

$items = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Include the isPublished field in the response
        $items[] = array(
            "id" => (int)$row["id"],
            "user_id" => (int)$row["user_id"],
            "type" => $row["type"],
            "description" => $row["description"],
            "location" => $row["location"],
            "date" => $row["date"],
            "photo_url" => $row["photo_url"],
            "name" => $row["name"],
            "email" => $row["email"],
            "phone_number" => $row["phone_number"],
            "isPublished" => (int)$row["isPublished"]
        );
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($items);

$conn->close();
?>