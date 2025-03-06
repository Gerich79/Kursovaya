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
    <link rel="stylesheet" href="../css/style.css">
    <style>
        :root {
            --background: #393E41;
            --block: #587B7F;
            --text: #FFFFFF;
            --border: #393E41;
            --accent: #E2C044;
            --accent-hover: #c9ab3d;
            --input-bg: #D3D0CB;
            --input-text: #393E41;
        }

        body {
            background-color: var(--background);
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .write-off-container {
            background-color: var(--block);
            border-radius: 10px;
            padding: 20px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .write-off-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .write-off-form select,
        .write-off-form input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background-color: var(--input-bg);
            color: var(--input-text);
            box-sizing: border-box;
        }

        .write-off-form div {
            width: 100%;
        }

        .write-off-form label {
            color: var(--text);
            font-weight: 500;
        }

        .write-off-form button {
            width: calc(100% - 20px);
            margin: 0 10px 10px 10px;
            background-color: var(--accent);
            color: var(--input-text);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .write-off-form button:hover {
            background-color: var(--accent-hover);
        }

        h2 {
            color: var(--text);
            margin-bottom: 20px;
        }
    </style>
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
            <button type="button" class="btn-back" onclick="window.location.href='form.html'">Назад</button>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>
</html>