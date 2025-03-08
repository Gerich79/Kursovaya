<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/CPU.css?v=1.1">
    <title>Жёсткие диски</title>
</head>
<body>
    <div class="menu-up">
        <div class="left-section">
            <a href="../Menu.html" class="back-button">← Назад</a>
        </div>
        <h1 class="page-title">Жёсткие диски</h1>
    </div>
    <div class="forms-container">
        <?php
        require_once '../../../server/db.php';

        $sql = "SELECT c.*, cat.name as category_name 
                FROM Components c 
                JOIN Categories cat ON c.id_categories = cat.id_categories 
                WHERE cat.name = 'Жёсткие диски'";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
            <div class="form-menu">
                <div class="top-row">
                    <div class="name-section">
                        <h2>Название</h2>
                        <input type="text" class="component-name" value="<?php echo htmlspecialchars($row['name']); ?>" readonly>
                    </div>
                    <div class="category-select">
                        <h3>Категория</h3>
                        <select disabled>
                            <option selected><?php echo htmlspecialchars($row['category_name']); ?></option>
                        </select>
                    </div>
                    <div class="cost-section">
                        <h3>Стоимость</h3>
                        <input type="text" value="<?php echo number_format($row['cost'], 0, '', ' '); ?> ₽" readonly>
                    </div>
                    <div class="technical-status">
                        <div class="status-header">
                            <h3>Техническое состояние</h3>
                            <button class="expand-btn">▼</button>
                        </div>
                        <select disabled>
                            <option selected><?php echo htmlspecialchars($row['technical_conditions']); ?></option>
                        </select>
                    </div>
                </div>
                <div class="main-content collapsed">
                    <div class="specs-section">
                        <h3>Технические характеристики</h3>
                        <textarea rows="10" readonly><?php echo htmlspecialchars($row['description']); ?></textarea>
                    </div>
                    <div class="right-section">
                        <div class="dates-container">
                            <div class="date-input">
                                <label>Дата ввода в эксплуатацию:</label>
                                <input type="date" value="<?php echo htmlspecialchars($row['date_added']); ?>" readonly>
                            </div>
                        </div>
                        <div class="location-container">
                            <h3>Место нахождения</h3>
                            <input type="text" value="<?php echo htmlspecialchars($row['adreess']); ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<p style='color: white; text-align: center;'>Жёсткие диски не найдены</p>";
        }
        $conn->close();
        ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.expand-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const mainContent = this.closest('.form-menu').querySelector('.main-content');
                    
                    if (mainContent.style.maxHeight) {
                        mainContent.style.maxHeight = null;
                        this.textContent = '▼';
                    } else {
                        mainContent.style.maxHeight = mainContent.scrollHeight + "px";
                        this.textContent = '▲';
                    }
                });
            });
        });
    </script>
</body>
</html> 