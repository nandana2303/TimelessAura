<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['userid'])) {
    echo 0;
    exit;
}

$userid = $_SESSION['userid'];
$stmt = $conn->prepare("SELECT SUM(quantity) AS total FROM cart WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo $row['total'] ?? 0;
?>
    

