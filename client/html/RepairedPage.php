<?php
require_once '../../server/db_delete_page.php';

if (!$connect) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

$query = "SELECT c.name as component_name, r.description as repair_description, r.date_repair as repair_date 
          FROM Repaired r 
          JOIN Components c ON r.id_component = c.id_component 
          ORDER BY r.date_repair DESC";
          
$result = mysqli_query($connect, $query);

if (!$result) {
    $error = 'Ошибка базы данных: ' . mysqli_error($connect);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/DeletePage.Css">
    <title>Отремонтированные комплектующие</title>
</head>
<body>
    <div class="form-menu">
        <div class="menu-up">
            <div class="left-section">
                <a href="Menu.html" class="back-button">← Назад</a>
            </div>
            <h1 class="page-title">Отремонтированные комплектующие</h1>
            <div class="tetx_container">
            </div>
        </div>
    </div>
    
    <div class="table-container">
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php else: ?>
            <table class="removed-table">
                <thead>
                    <tr>
                        <th>Название комплектующего</th>
                        <th>Описание ремонта</th>
                        <th>Дата ремонта</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['component_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['repair_description']); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($row['repair_date'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html> 