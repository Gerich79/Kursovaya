<?php
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit('Unauthorized');
}

if (!isset($_GET['name'])) {
    http_response_code(400);
    exit('Name parameter is required');
}

$conn = new mysqli("localhost", "root", "", "DB1");
if ($conn->connect_error) {
    http_response_code(500);
    exit('Connection failed');
}

$conn->set_charset("utf8");

$stmt = $conn->prepare("SELECT * FROM Components WHERE name = ?");
$stmt->bind_param("s", $_GET['name']);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    header('Content-Type: application/json');
    echo json_encode($row);
} else {
    http_response_code(404);
    echo 'Component not found';
}

$stmt->close();
$conn->close(); 