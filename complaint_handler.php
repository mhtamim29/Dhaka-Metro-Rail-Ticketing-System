<?php
$mysqli = new mysqli("localhost", "root", "", "metro_ticketing_system_schema");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$action = $_GET['action'] ?? '';

if ($action === 'get') {
    $result = $mysqli->query("SELECT * FROM complaints ORDER BY date DESC");
    $complaints = [];
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($complaints);
}
elseif ($action === 'update' && isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $mysqli->real_escape_string($_GET['status']);
    $mysqli->query("UPDATE complaints SET status = '$status' WHERE complaint_id = $id");
    echo "Status updated to $status.";
}
else {
    http_response_code(400);
    echo "Invalid request.";
}
?>
