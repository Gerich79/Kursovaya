<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit();
}

// Получаем название компонента из URL
$name = $_GET['name'] ?? '';

// Получаем сообщение об ошибке или успехе, если оно есть
$message = $_SESSION['message'] ?? '';
$messageType = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);
?>
<!DOCTYPE html>
<html lang="rus">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Form.css">
    <title>Редактирование комплектующего</title>
</head>
<body>
    <div class="form-container">
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="../../server/update_component.php" id="editForm" onsubmit="return validateForm()">
            <div class="form-menu">
                <div class="top-row">
                    <div class="name-section">
                        <h2>Название комплектующего</h2>
                        <select name="name" class="component-name" id="componentSelect" required>
                            <option value="">Выберите комплектующее</option>
                            <?php
                            // Подключение к базе данных
                            $conn = new mysqli("localhost", "root", "", "DB1");
                            
                            if ($conn->connect_error) {
                                die("Ошибка подключения: " . $conn->connect_error);
                            }
                            
                            // Получаем список комплектующих
                            $sql = "SELECT name FROM Components";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $selected = ($row['name'] === $name) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($row['name']) . "' {$selected}>" . htmlspecialchars($row['name']) . "</option>";
                                }
                            }
                            
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="category-select">
                        <h3>Категория</h3>
                        <select name="category" required>
                            <option value="">Выберите категорию</option>
                            <option value="1">Процессоры</option>
                            <option value="2">Видеокарты</option>
                            <option value="3">Материнские платы</option>
                            <option value="4">Блоки питания</option>
                            <option value="5">Оперативная память</option>
                            <option value="6">Жёсткий диск</option>
                            <option value="7">Мониторы</option>
                            <option value="8">Мышки и клавиатуры</option>
                        </select>
                    </div>
                    <div class="technical-status">
                        <h3>Техническое состояние</h3>
                        <select name="technical_conditions" required>
                            <option value="">Выберите состояние</option>
                            <option value="Рабочее">Рабочее</option>
                            <option value="Требует ремонта">Требует ремонта</option>
                            <option value="Неисправно">Неисправно</option>
                        </select>
                    </div>
                </div>
                
                <div class="main-content">
                    <div class="specs-section">
                        <h3>Технические характеристики</h3>
                        <textarea name="specifications" rows="10" placeholder="Введите технические характеристики" required></textarea>
                    </div>
                    <div class="right-section">
                        <div class="dates-container">
                            <div class="date-input">
                                <label>Дата ввода в эксплуатацию:</label>
                                <input type="date" name="date_added" required>
                            </div>
                        </div>
                        <div class="location-container">
                            <h3>Место нахождения</h3>
                            <input type="text" name="location" placeholder="Укажите местоположение" required>
                        </div>
                        <div class="cost-container">
                            <h3>Стоимость</h3>
                            <input type="number" name="cost" step="0.01" min="0" max="999999" placeholder="Введите стоимость" required>
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <button type="button" class="btn-back" onclick="window.location.href='form.html'">Назад</button>
                    <button type="submit" class="add-btn">Сохранить изменения</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function validateForm() {
            const nameInput = document.querySelector('input[name="name"]');
            const costInput = document.querySelector('input[name="cost"]');
            const name = nameInput.value.trim();
            const cost = parseFloat(costInput.value);
            
            if (!name) {
                alert('Пожалуйста, введите название комплектующего');
                nameInput.focus();
                return false;
            }
            
            if (cost > 999999) {
                alert('Стоимость не может превышать 999999 рублей');
                costInput.value = 999999;
                return false;
            }
            
            if (cost < 0) {
                alert('Стоимость не может быть отрицательной');
                costInput.value = 0;
                return false;
            }
            
            // Проверяем, что все обязательные поля заполнены
            const requiredFields = document.querySelectorAll('[required]');
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    alert('Пожалуйста, заполните все обязательные поля');
                    field.focus();
                    return false;
                }
            }
            
            return true;
        }

        // Обработчик изменения значения стоимости
        document.querySelector('input[name="cost"]').addEventListener('input', function(e) {
            let value = parseFloat(e.target.value);
            
            if (value > 999999) {
                e.target.value = 999999;
            }
            
            if (value < 0) {
                e.target.value = 0;
            }
        });

        function updateNameField(value) {
            document.querySelector('input[name="name"]').value = value;
        }
    </script>
</body>
</html> 