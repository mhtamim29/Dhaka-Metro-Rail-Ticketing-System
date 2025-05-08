<?php
// Place this file in the same directory as your other PHP files
// This will help us diagnose database connection issues

ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html');

echo "<h1>Metro Ticket System - Debug Info</h1>";

// 1. Test Database Connection
echo "<h2>1. Database Connection Test</h2>";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_ticketing_system_schema";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        echo "<p style='color: red;'>Failed to connect to MySQL: " . $conn->connect_error . "</p>";
        echo "<p>Possible solutions:</p>";
        echo "<ul>";
        echo "<li>Check that your MySQL service is running</li>";
        echo "<li>Verify your database credentials (username/password)</li>";
        echo "<li>Ensure the database 'metro_ticketing_system_schema' exists</li>";
        echo "</ul>";
    } else {
        echo "<p style='color: green;'>Database connection successful!</p>";
        
        // 2. Check if tickets table exists and has the correct structure
        echo "<h2>2. Table Structure Test</h2>";
        $result = $conn->query("SHOW TABLES LIKE 'tickets'");
        
        if ($result->num_rows == 0) {
            echo "<p style='color: red;'>The tickets table does not exist!</p>";
            echo "<p>You need to create the tickets table. Here's the SQL to create it:</p>";
            echo "<pre>
CREATE TABLE tickets (
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ticket_no VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    origin_station VARCHAR(50) NOT NULL,
    destination_station VARCHAR(50) NOT NULL,
    fare DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_info TEXT NOT NULL
);
            </pre>";
        } else {
            echo "<p style='color: green;'>The tickets table exists.</p>";
            
            // Check the structure
            $result = $conn->query("DESCRIBE tickets");
            echo "<p>Table structure:</p>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            
            $expected_columns = [
                'ticket_id', 'user_id', 'ticket_no', 'date', 'time',
                'origin_station', 'destination_station', 'fare',
                'payment_method', 'payment_info'
            ];
            $missing_columns = $expected_columns;
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Field'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['Null'] . "</td>";
                echo "<td>" . $row['Key'] . "</td>";
                echo "<td>" . $row['Default'] . "</td>";
                echo "<td>" . $row['Extra'] . "</td>";
                echo "</tr>";
                
                if (in_array($row['Field'], $missing_columns)) {
                    $key = array_search($row['Field'], $missing_columns);
                    unset($missing_columns[$key]);
                }
            }
            
            echo "</table>";
            
            if (!empty($missing_columns)) {
                echo "<p style='color: red;'>Missing columns: " . implode(', ', $missing_columns) . "</p>";
            } else {
                echo "<p style='color: green;'>All required columns are present.</p>";
            }
        }
        
        // 3. Test a sample query insert
        echo "<h2>3. Sample Insert Test</h2>";
        
        // Session test
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "<p style='color: orange;'>Warning: No user_id in session. Setting a test user_id=1 for this test.</p>";
            $_SESSION['user_id'] = 1;  // Just for testing
        }
        
        // Try a test insert
        $user_id = $_SESSION['user_id'];
        $ticket_no = "TEST-" . rand(10000, 99999);
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $origin = "uttara-north";
        $destination = "motijheel";
        $fare = "100.00";
        $payment_method = "test";
        $payment_info = '{"method":"test","amount":100}';
        
        $stmt = $conn->prepare("INSERT INTO tickets (user_id, ticket_no, date, time, origin_station, destination_station, fare, payment_method, payment_info)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                
        if (!$stmt) {
            echo "<p style='color: red;'>Prepare failed: " . $conn->error . "</p>";
        } else {
            $stmt->bind_param("issssssss", $user_id, $ticket_no, $date, $time, $origin, $destination, $fare, $payment_method, $payment_info);
            
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Test record inserted successfully!</p>";
                echo "<p>Inserted test ticket with ID: " . $conn->insert_id . "</p>";
            } else {
                echo "<p style='color: red;'>Error inserting test record: " . $stmt->error . "</p>";
            }
            
            $stmt->close();
        }
        
        // 4. Check for existing records
        echo "<h2>4. Existing Records</h2>";
        $result = $conn->query("SELECT COUNT(*) as count FROM tickets");
        $row = $result->fetch_assoc();
        echo "<p>Total tickets in database: " . $row['count'] . "</p>";
        
        if ($row['count'] > 0) {
            echo "<p>Last 5 records:</p>";
            $result = $conn->query("SELECT * FROM tickets ORDER BY ticket_id DESC LIMIT 5");
            
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>User ID</th><th>Ticket #</th><th>Date</th><th>Time</th><th>From</th><th>To</th><th>Fare</th><th>Payment</th></tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ticket_id'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['ticket_no'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>" . $row['origin_station'] . "</td>";
                echo "<td>" . $row['destination_station'] . "</td>";
                echo "<td>" . $row['fare'] . "</td>";
                echo "<td>" . $row['payment_method'] . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        }
    }
    
    // 5. Check session variables
    echo "<h2>5. Session Variables</h2>";
    echo "<p>Current session variables:</p>";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Fatal error: " . $e->getMessage() . "</p>";
}

// 6. Add modified buy_ticket_handler.php with additional logging
echo "<h2>6. Improved buy_ticket_handler.php</h2>";
echo "<p>Replace your current buy_ticket_handler.php with the improved version provided in the second file.</p>";
?>
