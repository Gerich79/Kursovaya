<?php
session_start();
$conn = new mysqli("localhost", "root", "", "DB1");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем список комплектующих из заявлений
$declarations_sql = "SELECT d.id_declaration, c.name, d.declaration, d.id_component 
                    FROM Declarations d
                    JOIN Components c ON d.id_component = c.id_component";
$declarations_result = $conn->query($declarations_sql);

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $component_id = $_POST['component'];
    $description = $_POST['description'];
    $date = date('Y-m-d');
    $declaration_id = $_POST['declaration_id'];

    // Начинаем транзакцию
    $conn->begin_transaction();

    try {
        // Добавляем запись в таблицу Repaired
        $repair_sql = "INSERT INTO Repaired (date_repair, description, id_component) 
                      VALUES (?, ?, ?)";
        $repair_stmt = $conn->prepare($repair_sql);
        $repair_stmt->bind_param("ssi", $date, $description, $component_id);
        $repair_stmt->execute();

        // Удаляем запись из таблицы Declarations
        $delete_sql = "DELETE FROM Declarations WHERE id_declaration = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $declaration_id);
        $delete_stmt->execute();

        // Если всё успешно, фиксируем транзакцию
        $conn->commit();
        echo "<script>
                alert('Комплектующее успешно отремонтировано');
                window.location.href = 'Menu.html';
              </script>";
    } catch (Exception $e) {
        // В случае ошибки откатываем транзакцию
        $conn->rollback();
        echo "<script>alert('Ошибка при обработке данных');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ремонт комплектующих</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/repair.css">
</head>
<body>
    <div class="repair-container">
        <h2>Ремонт комплектующих</h2>
        <form method="POST" action="" class="repair-form">
            <div>
                <label for="component">Выберите комплектующее из заявлений:</label>
                <select id="component" name="component" required>
                    <option value="">Выберите комплектующее</option>
                    <?php
                    if ($declarations_result->num_rows > 0) {
                        while($row = $declarations_result->fetch_assoc()) {
                            echo "<option value='" . $row['id_component'] . "' 
                                  data-declaration-id='" . $row['id_declaration'] . "'>" 
                                  . $row['name'] . " - " . $row['declaration'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <input type="hidden" name="declaration_id" id="declaration_id">
            </div>

            <div>
                <label for="description">Описание ремонта:</label>
                <textarea id="description" name="description" rows="5" required 
                          placeholder="Опишите выполненный ремонт"></textarea>
            </div>

            <div>
                <label for="date">Дата ремонта:</label>
                <input type="text" id="date" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>

            <button type="submit">Подтвердить ремонт</button>
            <button type="button" onclick="window.location.href='form.html'">Назад</button>
        </form>
    </div>

    <script>
        // Обновляем скрытое поле id_declaration при выборе комплектующего
        document.getElementById('component').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('declaration_id').value = 
                selectedOption.getAttribute('data-declaration-id');
        });
    </script>

    <?php $conn->close(); ?>
</body>
</html> 