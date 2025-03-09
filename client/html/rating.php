<?php
session_start();
$conn = new mysqli("localhost", "root", "", "DB1");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем список активных комплектующих
$components_sql = "SELECT c.id_component, c.name 
                  FROM Components c 
                  LEFT JOIN Removed r ON c.id_component = r.id_component 
                  WHERE r.id_remove IS NULL";
$components_result = $conn->query($components_sql);

// Получаем список пользователей
$users_sql = "SELECT id_user, login FROM Users";
$users_result = $conn->query($users_sql);

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user'];
    $component_id = $_POST['component'];
    $grade = $_POST['grade'];

    // Проверяем, не ставил ли уже этот пользователь оценку данному комплектующему
    $check_sql = "SELECT id_rating FROM Rating 
                  WHERE id_user = ? AND id_component = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $component_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Вы уже оценивали это комплектующее!');</script>";
    } else {
        // Добавляем новую оценку
        $sql = "INSERT INTO Rating (id_component, id_user, grade) 
                VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $component_id, $user_id, $grade);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Оценка успешно добавлена');
                    window.location.href = 'Menu.php';
                  </script>";
        } else {
            echo "<script>alert('Ошибка при добавлении оценки');</script>";
        }
        $stmt->close();
    }
    $check_stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Оценка комплектующего</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/rating.css">
</head>
<body>
    <div class="rating-container">
        <h2>Оценка комплектующего</h2>
        <form method="POST" action="" class="rating-form">
            <div>
                <label for="user">Пользователь:</label>
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
                <label for="grade">Оценка (от 1 до 10):</label>
                <input type="number" id="grade" name="grade" min="1" max="10" required>
            </div>

            <button type="submit">Поставить оценку</button>
            <button type="button" onclick="window.location.href='Menu.php'">Назад</button>
        </form>
    </div>

    <script>
        // Валидация оценки
        document.getElementById('grade').addEventListener('input', function() {
            let value = parseInt(this.value);
            if (value < 1) this.value = 1;
            if (value > 10) this.value = 10;
        });
    </script>

    <?php $conn->close(); ?>
</body>
</html> 