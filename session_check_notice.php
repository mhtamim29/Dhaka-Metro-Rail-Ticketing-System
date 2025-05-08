<?php
// Start the session
session_start();

// Check if user is logged in using your existing session structure
$isLoggedIn = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

// Return JSON response with login status
header('Content-Type: application/json');
echo json_encode(['isLoggedIn' => $isLoggedIn]);
?>