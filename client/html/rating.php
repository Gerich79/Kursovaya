<?php
session_start();
$conn = new mysqli("localhost", "root", "", "DB1");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем список категорий из таблицы Components
$categories_sql = "SELECT DISTINCT c.id_categories, cat.name as category_name 
                  FROM Components c 
                  JOIN Categories cat ON c.id_categories = cat.id_categories 
                  LEFT JOIN Removed r ON c.id_component = r.id_component 
                  WHERE r.id_remove IS NULL";
$categories_result = $conn->query($categories_sql);

// Получаем список активных комплектующих с их категориями
$components_sql = "SELECT c.id_component, c.name, c.id_categories 
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
                <label for="category">Категория:</label>
                <select id="category" name="category" onchange="filterComponents()">
                    <option value="">Все категории</option>
                    <?php
                    if ($categories_result && $categories_result->num_rows > 0) {
                        while($row = $categories_result->fetch_assoc()) {
                            echo "<option value='" . $row['id_categories'] . "'>" 
                                 . htmlspecialchars($row['category_name']) . "</option>";
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
                    if ($components_result && $components_result->num_rows > 0) {
                        while($row = $components_result->fetch_assoc()) {
                            echo "<option value='" . $row['id_component'] . "' data-category='" 
                                 . $row['id_categories'] . "'>" 
                                 . htmlspecialchars($row['name']) . "</option>";
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

        function filterComponents() {
            const categorySelect = document.getElementById('category');
            const componentSelect = document.getElementById('component');
            const selectedCategory = categorySelect.value;

            // Получаем все опции комплектующих
            const options = componentSelect.getElementsByTagName('option');

            // Показываем первую опцию (placeholder)
            options[0].style.display = '';

            // Фильтруем остальные опции
            for (let i = 1; i < options.length; i++) {
                const option = options[i];
                if (!selectedCategory || option.getAttribute('data-category') === selectedCategory) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }

            // Сбрасываем выбор комплектующего
            componentSelect.value = '';
        }
    </script>

    <?php $conn->close(); ?>
</body>
</html> 