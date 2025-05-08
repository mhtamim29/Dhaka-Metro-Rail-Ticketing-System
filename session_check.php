<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php?error=Login required");
    exit;
}

// Optional: Check for required role
if (isset($requireAdmin) && $requireAdmin === true && $_SESSION["is_admin"] !== true) {
    header("Location: login.php?error=Admin access only");
    exit;
}

if (isset($requireAdmin) && $requireAdmin === false && $_SESSION["is_admin"] === true) {
    header("Location: admindashboard.php"); // Redirect admin away from user pages
    exit;
}
?>
