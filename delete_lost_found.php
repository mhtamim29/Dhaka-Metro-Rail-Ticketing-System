<?php
$mysqli = new mysqli("localhost", "root", "", "metro_ticketing_system_schema");
$id = intval($_GET['id']);
$mysqli->query("DELETE FROM lost_found WHERE id = $id");
echo "Item deleted successfully.";
?>
