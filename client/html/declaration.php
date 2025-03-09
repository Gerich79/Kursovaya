<?php
session_start();
$conn = new mysqli("localhost", "root", "", "DB1");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем список пользователей
$users_sql = "SELECT id_user, login FROM Users";
$users_result = $conn->query($users_sql);

// Получаем список активных (не списанных) комплектующих
$components_sql = "SELECT c.id_component, c.name 
                  FROM Components c 
                  LEFT JOIN Removed r ON c.id_component = r.id_component 
                  WHERE r.id_remove IS NULL";
$components_result = $conn->query($components_sql);

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user'];
    $declaration_text = $_POST['declaration'];
    $component_id = $_POST['component'];
    $date = date('Y-m-d');

    $sql = "INSERT INTO Declarations (id_user, declaration, date_declaration, id_component) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $user_id, $declaration_text, $date, $component_id);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('Заявление успешно добавлено');
                window.location.href = 'Menu.php';
              </script>";
    } else {
        echo "<script>alert('Ошибка при добавлении заявления');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Заявление о поломке</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/declaration.css">
</head>
<body>
    <div class="declaration-container">
        <h2>Заявление о поломке</h2>
        <form method="POST" action="" class="declaration-form">
            <div>
                <label for="user">От кого:</label>
                <select id="user" name="user" required>
                    <option value="">Выберите пользователя</option>
                    <?php
                    if ($users_result->num_rows > 0) {
                        while($row = $users_result->fetch_assoc()) {
                            echo "<option value='" . $row['id_user'] . "'>" . $row['login'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="component">Комплектующее:</label>
                <select id="component" name="component" required>
                    <option value="">Выберите комплектующее</option>
                    <?php
                    if ($components_result->num_rows > 0) {
                        while($row = $components_result->fetch_assoc()) {
                            echo "<option value='" . $row['id_component'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="declaration">Текст заявления:</label>
                <textarea id="declaration" name="declaration" rows="5" required 
                          placeholder="Опишите проблему с комплектующим"></textarea>
            </div>

            <div>
                <label for="date">Дата:</label>
                <input type="text" id="date" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>

            <button type="submit">Отправить заявление</button>
            <button type="button" onclick="window.location.href='Menu.php'">Назад</button>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>
</html> 