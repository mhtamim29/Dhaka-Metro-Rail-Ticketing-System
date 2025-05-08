<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "metro_ticketing_system_schema";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $origin = $_POST['from'] ?? '';
    $destination = $_POST['to'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $payment_info = $_POST['mobile-number'] ?? '';

    // Fare calculation logic
    $fareMatrix = [
        'uttara-north' => [
            'uttara-north' => 0, 'uttara-center' => 20, 'uttara-south' => 20, 'pallabi' => 30,
            'mirpur-11' => 30, 'mirpur-10' => 40, 'kazipara' => 40, 'shewrapara' => 50,
            'agargaon' => 60, 'bijoy-sarani' => 60, 'farmgate' => 70, 'karwan-bazar' => 80,
            'shahbagh' => 80, 'dhaka-university' => 90, 'bangladesh-secretariat' => 90, 'motijheel' => 100
        ],
        'uttara-center' => [
            'uttara-north' => 20, 'uttara-center' => 0, 'uttara-south' => 20, 'pallabi' => 20,
            'mirpur-11' => 30, 'mirpur-10' => 30, 'kazipara' => 40, 'shewrapara' => 40,
            'agargaon' => 50, 'bijoy-sarani' => 60, 'farmgate' => 60, 'karwan-bazar' => 70,
            'shahbagh' => 80, 'dhaka-university' => 90, 'bangladesh-secretariat' => 90, 'motijheel' => 100
        ],
        'uttara-south' => [
            'uttara-north' => 20, 'uttara-center' => 20, 'uttara-south' => 0, 'pallabi' => 20,
            'mirpur-11' => 20, 'mirpur-10' => 30, 'kazipara' => 30, 'shewrapara' => 40,
            'agargaon' => 40, 'bijoy-sarani' => 50, 'farmgate' => 60, 'karwan-bazar' => 60,
            'shahbagh' => 70, 'dhaka-university' => 80, 'bangladesh-secretariat' => 80, 'motijheel' => 90
        ],
        'pallabi' => [
            'uttara-north' => 30, 'uttara-center' => 20, 'uttara-south' => 20, 'pallabi' => 0,
            'mirpur-11' => 20, 'mirpur-10' => 20, 'kazipara' => 20, 'shewrapara' => 30,
            'agargaon' => 30, 'bijoy-sarani' => 40, 'farmgate' => 50, 'karwan-bazar' => 50,
            'shahbagh' => 60, 'dhaka-university' => 60, 'bangladesh-secretariat' => 70, 'motijheel' => 80
        ],
        'mirpur-11' => [
            'uttara-north' => 30, 'uttara-center' => 30, 'uttara-south' => 20, 'pallabi' => 20,
            'mirpur-11' => 0, 'mirpur-10' => 20, 'kazipara' => 20, 'shewrapara' => 20,
            'agargaon' => 30, 'bijoy-sarani' => 40, 'farmgate' => 40, 'karwan-bazar' => 50,
            'shahbagh' => 50, 'dhaka-university' => 60, 'bangladesh-secretariat' => 60, 'motijheel' => 70
        ],
        'mirpur-10' => [
            'uttara-north' => 40, 'uttara-center' => 30, 'uttara-south' => 30, 'pallabi' => 20,
            'mirpur-11' => 20, 'mirpur-10' => 0, 'kazipara' => 20, 'shewrapara' => 20,
            'agargaon' => 20, 'bijoy-sarani' => 30, 'farmgate' => 30, 'karwan-bazar' => 40,
            'shahbagh' => 50, 'dhaka-university' => 50, 'bangladesh-secretariat' => 60, 'motijheel' => 60
        ],
        'kazipara' => [
            'uttara-north' => 40, 'uttara-center' => 40, 'uttara-south' => 30, 'pallabi' => 20,
            'mirpur-11' => 20, 'mirpur-10' => 20, 'kazipara' => 0, 'shewrapara' => 20,
            'agargaon' => 20, 'bijoy-sarani' => 20, 'farmgate' => 30, 'karwan-bazar' => 40,
            'shahbagh' => 40, 'dhaka-university' => 50, 'bangladesh-secretariat' => 50, 'motijheel' => 60
        ],
        'shewrapara' => [
            'uttara-north' => 50, 'uttara-center' => 40, 'uttara-south' => 40, 'pallabi' => 30,
            'mirpur-11' => 20, 'mirpur-10' => 20, 'kazipara' => 20, 'shewrapara' => 0,
            'agargaon' => 20, 'bijoy-sarani' => 20, 'farmgate' => 20, 'karwan-bazar' => 30,
            'shahbagh' => 40, 'dhaka-university' => 40, 'bangladesh-secretariat' => 50, 'motijheel' => 50
        ],
        'agargaon' => [
            'uttara-north' => 60, 'uttara-center' => 50, 'uttara-south' => 40, 'pallabi' => 30,
            'mirpur-11' => 30, 'mirpur-10' => 20, 'kazipara' => 20, 'shewrapara' => 20,
            'agargaon' => 0, 'bijoy-sarani' => 20, 'farmgate' => 20, 'karwan-bazar' => 20,
            'shahbagh' => 30, 'dhaka-university' => 30, 'bangladesh-secretariat' => 40, 'motijheel' => 50
        ],
        'bijoy-sarani' => [
            'uttara-north' => 60, 'uttara-center' => 60, 'uttara-south' => 50, 'pallabi' => 40,
            'mirpur-11' => 40, 'mirpur-10' => 30, 'kazipara' => 20, 'shewrapara' => 20,
            'agargaon' => 20, 'bijoy-sarani' => 0, 'farmgate' => 20, 'karwan-bazar' => 20,
            'shahbagh' => 20, 'dhaka-university' => 30, 'bangladesh-secretariat' => 40, 'motijheel' => 40
        ],
        'farmgate' => [
            'uttara-north' => 70, 'uttara-center' => 60, 'uttara-south' => 60, 'pallabi' => 50,
            'mirpur-11' => 40, 'mirpur-10' => 40, 'kazipara' => 30, 'shewrapara' => 20,
            'agargaon' => 30, 'bijoy-sarani' => 20, 'farmgate' => 0, 'karwan-bazar' => 20,
            'shahbagh' => 20, 'dhaka-university' => 20, 'bangladesh-secretariat' => 30, 'motijheel' => 30
        ],
        'karwan-bazar' => [
            'uttara-north' => 80, 'uttara-center' => 70, 'uttara-south' => 60, 'pallabi' => 50,
            'mirpur-11' => 50, 'mirpur-10' => 40, 'kazipara' => 40, 'shewrapara' => 30,
            'agargaon' => 20, 'bijoy-sarani' => 20, 'farmgate' => 20, 'karwan-bazar' => 0,
            'shahbagh' => 20, 'dhaka-university' => 20, 'bangladesh-secretariat' => 20, 'motijheel' => 30
        ],
        'shahbagh' => [
            'uttara-north' => 80, 'uttara-center' => 80, 'uttara-south' => 70, 'pallabi' => 60,
            'mirpur-11' => 50, 'mirpur-10' => 50, 'kazipara' => 40, 'shewrapara' => 40,
            'agargaon' => 30, 'bijoy-sarani' => 20, 'farmgate' => 30, 'karwan-bazar' => 20,
            'shahbagh' => 0, 'dhaka-university' => 20, 'bangladesh-secretariat' => 20, 'motijheel' => 20
        ],
        'dhaka-university' => [
            'uttara-north' => 90, 'uttara-center' => 80, 'uttara-south' => 70, 'pallabi' => 60,
            'mirpur-11' => 60, 'mirpur-10' => 50, 'kazipara' => 50, 'shewrapara' => 40,
            'agargaon' => 30, 'bijoy-sarani' => 30, 'farmgate' => 20, 'karwan-bazar' => 20,
            'shahbagh' => 20, 'dhaka-university' => 0, 'bangladesh-secretariat' => 20, 'motijheel' => 20
        ],
        'bangladesh-secretariat' => [
            'uttara-north' => 90, 'uttara-center' => 90, 'uttara-south' => 80, 'pallabi' => 70,
            'mirpur-11' => 70, 'mirpur-10' => 60, 'kazipara' => 50, 'shewrapara' => 50,
            'agargaon' => 40, 'bijoy-sarani' => 40, 'farmgate' => 30, 'karwan-bazar' => 20,
            'shahbagh' => 20, 'dhaka-university' => 20, 'bangladesh-secretariat' => 0, 'motijheel' => 20
        ],
        'motijheel' => [
            'uttara-north' => 100, 'uttara-center' => 90, 'uttara-south' => 90, 'pallabi' => 80,
            'mirpur-11' => 70, 'mirpur-10' => 60, 'kazipara' => 60, 'shewrapara' => 50,
            'agargaon' => 50, 'bijoy-sarani' => 40, 'farmgate' => 30, 'karwan-bazar' => 30,
            'shahbagh' => 20, 'dhaka-university' => 20, 'bangladesh-secretariat' => 20, 'motijheel' => 0
        ]
    ];
    

    $fare = $fareMatrix[$origin][$destination] ?? null;

    if (!$fare) {
        echo "<script>alert('Invalid route selected.'); window.history.back();</script>";
        exit();
    }

    $ticket_no = 'DMR-' . rand(100000, 999999);
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $stmt = $conn->prepare("INSERT INTO tickets (user_id, ticket_no, date, time, origin_station, destination_station, fare, payment_method, payment_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssiss", $user_id, $ticket_no, $date, $time, $origin, $destination, $fare, $payment_method, $payment_info);

    if ($stmt->execute()) {
        echo "<script>alert('Ticket booked successfully!'); window.location.href='myticket.php';</script>";
    } else {
        echo "<script>alert('Database error: {$stmt->error}'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}

$conn->close();
?>
