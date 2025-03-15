<?php
$conn = new mysqli("localhost", "root", "", "DB1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

$sql = "SELECT c.id_component, c.name 
        FROM Components c 
        LEFT JOIN Removed r ON c.id_component = r.id_component 
        WHERE r.id_remove IS NULL 
        AND c.id_categories = ?
        ORDER BY c.name";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

$components = [];
while ($row = $result->fetch_assoc()) {
    $components[] = $row;
}

header('Content-Type: application/json');
echo json_encode($components);

$stmt->close();
$conn->close();
?> 