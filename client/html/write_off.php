<?php
$conn = new mysqli("localhost", "root", "", "DB1");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем список комплектующих, которые еще не списаны
$sql = "SELECT c.id_component, c.name 
        FROM Components c 
        LEFT JOIN Removed r ON c.id_component = r.id_component 
        WHERE r.id_remove IS NULL";
$result = $conn->query($sql);

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, не списано ли уже комплектующее
    $component_id = $_POST['component'];
    $check_sql = "SELECT id_remove FROM Removed WHERE id_component = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $component_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        echo "<script>alert('Это комплектующее уже было списано!');</script>";
    } else {
        $reason = $_POST['reason'];
        $date = date('Y-m-d');

        $sql = "INSERT INTO Removed (date_remove, reason, id_component) 
                VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $date, $reason, $component_id);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Комплектующее успешно списано');
                    // Обновляем страницу после списания
                    window.location.reload();
                  </script>";
        } else {
            echo "<script>alert('Ошибка при списании');</script>";
        }
        $stmt->close();
    }
    $check_stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Списание комплектующих</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/write_off.css">
</head>
<body>
    <div class="write-off-container">
        <h2>Списание комплектующих</h2>
        <form method="POST" action="" class="write-off-form">
            <div>
                <label for="component">Выберите комплектующее:</label>
                <select id="component" name="component" required>
                    <option value="">Выберите комплектующее</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_component'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="reason">Причина списания:</label>
                <input type="text" id="reason" name="reason" required>
            </div>

            <div>
                <label for="date">Дата списания:</label>
                <input type="text" id="date" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>

            <button type="submit">Списать</button>
            <button type="button" onclick="window.location.href='form.html'">Назад</button>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>
</html>