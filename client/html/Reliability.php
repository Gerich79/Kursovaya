<?php
session_start();
$conn = new mysqli("localhost", "root", "", "DB1");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$query = "WITH MaxValues AS (
    SELECT 
        (SELECT MAX(average_rating) FROM AverageGrade) as max_rating,
        (SELECT MAX(cost) FROM Components) as max_cost,
        (SELECT MAX(couunt_breakdown) FROM CountBreakdown) as max_breakdowns,
        (SELECT MAX(count_date_last_breakdown) FROM CountDateLastBreakdown) as max_days_since_breakdown,
        (SELECT MAX(failures_per_month) FROM FailuresPerMonth) as max_failure_rate
)
SELECT 
    c.id_component,
    c.name AS component_name,
    cat.name AS category_name,
    c.technical_conditions,
    c.cost,
    COALESCE(ag.average_rating, 0) as rating,
    COALESCE(cb.couunt_breakdown, 0) as breakdowns,
    COALESCE(cdlb.count_date_last_breakdown, 0) as days_since_breakdown,
    COALESCE(fpm.failures_per_month, 0) as failure_rate,
    ROUND(
        (
            (COALESCE(ag.average_rating, 0) / mv.max_rating * 0.5) +
            (c.cost / mv.max_cost * 1.0) +
            (COALESCE(cb.couunt_breakdown, 0) / mv.max_breakdowns * 1.0) +
            (COALESCE(cdlb.count_date_last_breakdown, 0) / mv.max_days_since_breakdown * 0.8) +
            (COALESCE(fpm.failures_per_month, 0) / mv.max_failure_rate * 1.0)
        ), 
        2
    ) AS reliability_score
FROM 
    Components c
    INNER JOIN Categories cat ON c.id_categories = cat.id_categories
    CROSS JOIN MaxValues mv
    LEFT JOIN AverageGrade ag ON c.id_component = ag.id_component
    LEFT JOIN CountBreakdown cb ON c.id_component = cb.id_component
    LEFT JOIN CountDateLastBreakdown cdlb ON c.id_component = cdlb.id_component
    LEFT JOIN FailuresPerMonth fpm ON c.id_component = fpm.id_component
WHERE 
    c.id_component NOT IN (SELECT id_component FROM Removed)
ORDER BY 
    reliability_score DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рейтинг надёжности комплектующих</title>
    <link rel="stylesheet" href="../css/Reliability.css">
</head>
<body>
    <div class="menu-up">
        <div class="left-section">
            <a href="Menu.php" class="back-button">← Назад</a>
        </div>
        <h1 class="page-title">Рейтинг надёжности комплектующих</h1>
        <div class="text_container"></div>
    </div>

    <div class="filters">
        <input type="text" id="searchInput" placeholder="Поиск по названию..." class="search-input">
        <select id="categoryFilter" class="category-filter">
            <option value="">Все категории</option>
            <?php
            $categoryQuery = "SELECT DISTINCT cat.name FROM Categories cat 
                            INNER JOIN Components c ON cat.id_categories = c.id_categories 
                            WHERE c.id_component NOT IN (SELECT id_component FROM Removed)
                            ORDER BY cat.name";
            $categoryResult = $conn->query($categoryQuery);
            while ($category = $categoryResult->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($category['name']) . "'>" . 
                     htmlspecialchars($category['name']) . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="table-container">
        <?php if ($result && $result->num_rows > 0): ?>
            <table class="reliability-table">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Состояние</th>
                        <th>Стоимость</th>
                        <th>Средняя оценка</th>
                        <th>Количество поломок</th>
                        <th>Дней с последней поломки</th>
                        <th>Поломок в месяц</th>
                        <th>Показатель надёжности</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        $scoreClass = '';
                        if ($row['reliability_score'] >= 3) {
                            $scoreClass = 'score-high';
                        } elseif ($row['reliability_score'] >= 2) {
                            $scoreClass = 'score-medium';
                        } else {
                            $scoreClass = 'score-low';
                        }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['component_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['technical_conditions']); ?></td>
                            <td><?php echo number_format($row['cost'], 2, ',', ' ') . ' ₽'; ?></td>
                            <td><?php echo number_format($row['rating'], 1); ?></td>
                            <td><?php echo $row['breakdowns']; ?></td>
                            <td><?php echo $row['days_since_breakdown']; ?></td>
                            <td><?php echo number_format($row['failure_rate'], 2); ?></td>
                            <td class="<?php echo $scoreClass; ?>"><?php echo number_format($row['reliability_score'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="error-message">Нет данных для отображения</div>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const table = document.querySelector('.reliability-table');
            const rows = table.getElementsByTagName('tr');

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    const row = rows[i];
                    const name = row.cells[0].textContent.toLowerCase();
                    const category = row.cells[1].textContent.toLowerCase();
                    
                    const matchesSearch = name.includes(searchText);
                    const matchesCategory = !selectedCategory || category === selectedCategory;

                    row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
                }
            }

            searchInput.addEventListener('input', filterTable);
            categoryFilter.addEventListener('change', filterTable);
        });
    </script>
</body>
</html> 