<?php

// Обновляем SQL запрос, добавляя поле cost
$componentsQuery = "SELECT c.name, c.date_added, c.technical_conditions, c.cost, cat.name as category_name
                   FROM Components c
                   LEFT JOIN Categories cat ON c.id_categories = cat.id_categories
                   WHERE c.id_component NOT IN (SELECT id_component FROM Removed)";

// ... existing code ...

// В таблице с рекомендациями добавляем новый столбец
<table class="declarations-table">
    <thead>
        <tr>
            <th>Название комплектующего</th>
            <th>Категория</th>
            <th>Дата добавления</th>
            <th>Техническое состояние</th>
            <th>Стоимость</th>
            <th>Рекомендация</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $componentsResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                <td><?php echo date('d.m.Y', strtotime($row['date_added'])); ?></td>
                <td><?php echo htmlspecialchars($row['technical_conditions']); ?></td>
                <td><?php echo number_format($row['cost'], 2, ',', ' ') . ' ₽'; ?></td>
                <td><?php echo getMaintenanceRecommendation($row['category_name'], $row['date_added']); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

// ... existing code ... 