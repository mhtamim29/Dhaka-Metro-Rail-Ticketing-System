<?php

// Database connection
$mysqli = new mysqli("localhost", "root", "", "metro_ticketing_system_schema");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get notices from notices table
$noticesQuery = "SELECT notice_id, title, category, content, date, priority FROM notices ORDER BY date DESC";
$noticesResult = $mysqli->query($noticesQuery);

// Get published lost & found items
$lostFoundQuery = "SELECT id, type, description, date FROM lost_found WHERE isPublished = 1 ORDER BY date DESC";
$lostFoundResult = $mysqli->query($lostFoundQuery);

// Combine both results into a single array
$allNotices = array();

// Add notices from notices table
if ($noticesResult->num_rows > 0) {
    while($row = $noticesResult->fetch_assoc()) {
        $notice = array(
            'id' => (int)$row['notice_id'],
            'date' => $row['date'],
            'title' => $row['title'],
            'content' => $row['content'],
            'category' => $row['category'],  // This can be Schedule, Maintenance, Safety, General, or Lost & Found
            'source' => 'notices',
            'priority' => $row['priority']
        );
        $allNotices[] = $notice;
    }
}

// Add published lost & found items
if ($lostFoundResult->num_rows > 0) {
    while($row = $lostFoundResult->fetch_assoc()) {
        $notice = array(
            'id' => (int)$row['id'],
            'date' => $row['date'],
            'title' => $row['type'],
            'content' => $row['description'],
            'category' => 'Lost & Found',  // Always set to Lost & Found for items from lost_found table
            'source' => 'lost_found',
            'priority' => 'normal'  // Default priority for lost & found items
        );
        $allNotices[] = $notice;
    }
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($allNotices);

$mysqli->close();
?>