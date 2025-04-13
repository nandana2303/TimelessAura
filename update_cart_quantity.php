<?php
session_start();
require 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['userid']) || !isset($data['product_id']) || !isset($data['change'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$userid = $_SESSION['userid'];
$product_id = $data['product_id'];
$change = (int)$data['change'];

$stmt = $conn->prepare("SELECT quantity FROM cart WHERE userid = ? AND product_id = ?");
$stmt->bind_param("ii", $userid, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not in cart']);
    exit;
}

$row = $result->fetch_assoc();
$new_quantity = $row['quantity'] + $change;

if ($new_quantity <= 0) {
    $stmt = $conn->prepare("DELETE FROM cart WHERE userid = ? AND product_id = ?");
    $stmt->bind_param("ii", $userid, $product_id);
    $stmt->execute();
    echo json_encode(['success' => true, 'action' => 'removed']);
} else {
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE userid = ? AND product_id = ?");
    $stmt->bind_param("iii", $new_quantity, $userid, $product_id);
    $stmt->execute();
    echo json_encode(['success' => true, 'action' => 'updated', 'new_quantity' => $new_quantity]);
}
?>
