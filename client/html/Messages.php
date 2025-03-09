<?php
session_start();
$conn = new mysqli("localhost", "root", "", "DB1");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Функция для получения рекомендаций по обслуживанию
function getMaintenanceRecommendation($category, $dateAdded, $technicalCondition) {
    $today = new DateTime();
    $addedDate = new DateTime($dateAdded);
    $monthsDiff = ($today->diff($addedDate)->y * 12) + $today->diff($addedDate)->m;
    $recommendation = "";

    // Проверка на 5-летний срок для всех категорий
    if ($monthsDiff >= 60) { // 5 лет
        if ($technicalCondition === 'Не работает') {
            return "⚠️ Требуется замена - устройство не работает и превысило 5-летний срок службы";
        } else {
            return "ℹ️ Рекомендуется рассмотреть обновление - устройство старше 5 лет";
        }
    }

    // Рекомендации по категориям и сроку службы (каждые 6 месяцев)
    switch ($category) {
        case 'Процессоры':
            if ($monthsDiff >= 54) {
                $recommendation = "⚡ Полная диагностика и стресс-тест";
            } elseif ($monthsDiff >= 48) {
                $recommendation = "🔧 Проверка состояния сокета и контактов";
            } elseif ($monthsDiff >= 42) {
                $recommendation = "🌡️ Замена термопасты и проверка кулера";
            } elseif ($monthsDiff >= 36) {
                $recommendation = "📊 Тестирование производительности";
            } elseif ($monthsDiff >= 30) {
                $recommendation = "🔍 Проверка стабильности частот";
            } elseif ($monthsDiff >= 24) {
                $recommendation = "🧹 Очистка системы охлаждения";
            } elseif ($monthsDiff >= 18) {
                $recommendation = "🌡️ Мониторинг температур";
            } elseif ($monthsDiff >= 12) {
                $recommendation = "💨 Проверка работы кулера";
            } elseif ($monthsDiff >= 6) {
                $recommendation = "📱 Обновление микрокода процессора";
            }
            break;

        case 'Видеокарты':
            if ($monthsDiff >= 54) {
                $recommendation = "🔧 Рекомендуется полная диагностика и возможная замена вентиляторов";
            } elseif ($monthsDiff >= 48) {
                $recommendation = "🌡️ Необходима проверка температурного режима под нагрузкой";
            } elseif ($monthsDiff >= 42) {
                $recommendation = "🔧 Рекомендуется очистка от пыли и замена термопасты";
            } elseif ($monthsDiff >= 36) {
                $recommendation = "📊 Проверка производительности и стабильности работы";
            } elseif ($monthsDiff >= 30) {
                $recommendation = "🔍 Диагностика артефактов и проверка драйверов";
            } elseif ($monthsDiff >= 24) {
                $recommendation = "🧹 Профилактическая очистка от пыли";
            } elseif ($monthsDiff >= 18) {
                $recommendation = "🌡️ Проверка температурного режима";
            } elseif ($monthsDiff >= 12) {
                $recommendation = "🔧 Рекомендуется замена термопасты";
            } elseif ($monthsDiff >= 6) {
                $recommendation = "💻 Обновление драйверов и прошивки";
            }
            break;

        case 'Материнские платы':
            if ($monthsDiff >= 54) {
                $recommendation = "⚡ Полная диагностика всех компонентов платы";
            } elseif ($monthsDiff >= 48) {
                $recommendation = "🔌 Проверка всех разъемов и портов";
            } elseif ($monthsDiff >= 42) {
                $recommendation = "🔋 Проверка и замена батарейки BIOS";
            } elseif ($monthsDiff >= 36) {
                $recommendation = "📊 Тестирование стабильности системы";
            } elseif ($monthsDiff >= 30) {
                $recommendation = "🔍 Проверка конденсаторов на вздутие";
            } elseif ($monthsDiff >= 24) {
                $recommendation = "💾 Обновление BIOS/UEFI";
            } elseif ($monthsDiff >= 18) {
                $recommendation = "🧹 Очистка слотов расширения";
            } elseif ($monthsDiff >= 12) {
                $recommendation = "🌡️ Проверка температурных режимов";
            } elseif ($monthsDiff >= 6) {
                $recommendation = "💻 Проверка работы всех портов";
            }
            break;

        case 'Блоки питания':
            if ($monthsDiff >= 54) {
                $recommendation = "⚡ Полная диагностика всех напряжений";
            } elseif ($monthsDiff >= 48) {
                $recommendation = "🔌 Проверка кабелей и разъемов";
            } elseif ($monthsDiff >= 42) {
                $recommendation = "📊 Тест под нагрузкой";
            } elseif ($monthsDiff >= 36) {
                $recommendation = "🧹 Профилактическая очистка";
            } elseif ($monthsDiff >= 30) {
                $recommendation = "💨 Проверка работы вентилятора";
            } elseif ($monthsDiff >= 24) {
                $recommendation = "⚡ Измерение стабильности напряжения";
            } elseif ($monthsDiff >= 18) {
                $recommendation = "🔍 Осмотр конденсаторов";
            } elseif ($monthsDiff >= 12) {
                $recommendation = "📊 Проверка эффективности";
            } elseif ($monthsDiff >= 6) {
                $recommendation = "🧹 Очистка от пыли";
            }
            break;

        case 'Оперативная память':
            if ($monthsDiff >= 54) {
                $recommendation = "🔍 Полное тестирование всех модулей";
            } elseif ($monthsDiff >= 48) {
                $recommendation = "📊 Проверка стабильности частот";
            } elseif ($monthsDiff >= 42) {
                $recommendation = "⚡ Тест на совместимость модулей";
            } elseif ($monthsDiff >= 36) {
                $recommendation = "🔧 Проверка контактов и очистка";
            } elseif ($monthsDiff >= 30) {
                $recommendation = "💻 Тест на ошибки памяти";
            } elseif ($monthsDiff >= 24) {
                $recommendation = "📊 Проверка производительности";
            } elseif ($monthsDiff >= 18) {
                $recommendation = "🔍 Диагностика стабильности";
            } elseif ($monthsDiff >= 12) {
                $recommendation = "🧹 Очистка контактов";
            } elseif ($monthsDiff >= 6) {
                $recommendation = "💾 Проверка XMP профилей";
            }
            break;

        case 'Жёсткие диски':
            if ($monthsDiff >= 54) {
                $recommendation = "⚠️ Создание полной резервной копии данных";
            } elseif ($monthsDiff >= 48) {
                $recommendation = "🔍 Проверка на битые сектора";
            } elseif ($monthsDiff >= 42) {
                $recommendation = "📊 Тест скорости чтения/записи";
            } elseif ($monthsDiff >= 36) {
                $recommendation = "💾 Дефрагментация и очистка";
            } elseif ($monthsDiff >= 30) {
                $recommendation = "🔍 Проверка SMART-параметров";
            } elseif ($monthsDiff >= 24) {
                $recommendation = "💿 Резервное копирование важных данных";
            } elseif ($monthsDiff >= 18) {
                $recommendation = "📊 Анализ состояния диска";
            } elseif ($monthsDiff >= 12) {
                $recommendation = "🧹 Очистка от временных файлов";
            } elseif ($monthsDiff >= 6) {
                $recommendation = "📱 Проверка файловой системы";
            }
            break;

        case 'Мониторы':
            if ($monthsDiff >= 54) {
                $recommendation = "🔍 Полная диагностика матрицы";
            } elseif ($monthsDiff >= 48) {
                $recommendation = "⚡ Проверка блока питания монитора";
            } elseif ($monthsDiff >= 42) {
                $recommendation = "🎨 Калибровка цветопередачи";
            } elseif ($monthsDiff >= 36) {
                $recommendation = "📊 Тест на битые пиксели";
            } elseif ($monthsDiff >= 30) {
                $recommendation = "🔌 Проверка кабелей подключения";
            } elseif ($monthsDiff >= 24) {
                $recommendation = "🧹 Профилактическая очистка";
            } elseif ($monthsDiff >= 18) {
                $recommendation = "💡 Проверка яркости и контрастности";
            } elseif ($monthsDiff >= 12) {
                $recommendation = "⚡ Проверка кнопок управления";
            } elseif ($monthsDiff >= 6) {
                $recommendation = "🖥️ Очистка экрана и корпуса";
            }
            break;

        case 'Перефирия':
            if ($monthsDiff >= 54) {
                $recommendation = "⚠️ Рекомендуется полная замена устройств";
            } elseif ($monthsDiff >= 48) {
                $recommendation = "🔍 Проверка всех кнопок и клавиш";
            } elseif ($monthsDiff >= 42) {
                $recommendation = "🧹 Глубокая очистка механизмов";
            } elseif ($monthsDiff >= 36) {
                $recommendation = "⚡ Проверка кабелей на износ";
            } elseif ($monthsDiff >= 30) {
                $recommendation = "🔧 Чистка датчика мыши";
            } elseif ($monthsDiff >= 24) {
                $recommendation = "💻 Обновление драйверов";
            } elseif ($monthsDiff >= 18) {
                $recommendation = "🧹 Профилактическая чистка";
            } elseif ($monthsDiff >= 12) {
                $recommendation = "⌨️ Проверка работы всех клавиш";
            } elseif ($monthsDiff >= 6) {
                $recommendation = "🧼 Базовая очистка устройств";
            }
            break;
    }

    return $recommendation;
}

// Получаем заявления и информацию о комплектующих
$query = "SELECT u.login, d.declaration, d.date_declaration, c.name as component_name, 
          c.date_added, c.technical_conditions, cat.name as category_name
          FROM Declarations d
          JOIN Users u ON d.id_user = u.id_user
          JOIN Components c ON d.id_component = c.id_component
          JOIN Categories cat ON c.id_categories = cat.id_categories
          ORDER BY d.date_declaration DESC";

// Изменим запрос для получения всех комплектующих
$componentsQuery = "SELECT c.name, c.date_added, c.technical_conditions, cat.name as category_name
                   FROM Components c
                   LEFT JOIN Categories cat ON c.id_categories = cat.id_categories
                   WHERE c.id_component NOT IN (SELECT id_component FROM Removed)";

$componentsResult = $conn->query($componentsQuery);
$recommendations = [];

if ($componentsResult) {
    while ($component = $componentsResult->fetch_assoc()) {
        // Добавим отладочный вывод
        echo "<!-- Категория из БД: " . $component['category_name'] . " -->";
        
        $recommendation = getMaintenanceRecommendation(
            $component['category_name'],
            $component['date_added'],
            $component['technical_conditions']
        );
        if ($recommendation) {
            $recommendations[] = [
                'component' => $component['name'],
                'category' => $component['category_name'],
                'recommendation' => $recommendation
            ];
        }
    }
}

$result = $conn->query($query);

if (!$result) {
    $error = "Ошибка выполнения запроса: " . $conn->error;
} else {
    $num_rows = $result->num_rows;
    if ($num_rows === 0) {
        $error = "Записей не найдено";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Messages.css">
    <title>Сообщения</title>
</head>
<body>
    <div class="menu-up">
        <div class="left-section">
            <a href="Menu.php" class="back-button">← Назад</a>
        </div>
        <h1 class="page-title">Сообщения</h1>
        <div class="text_container"></div>
    </div>

    <?php if (!empty($recommendations)): ?>
    <div class="table-container">
        <h2>Рекомендации по обслуживанию</h2>
        <table class="declarations-table">
            <thead>
                <tr>
                    <th>Комплектующее</th>
                    <th>Категория</th>
                    <th>Рекомендация</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recommendations as $rec): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rec['component']); ?></td>
                        <td><?php echo htmlspecialchars($rec['category']); ?></td>
                        <td><?php echo $rec['recommendation']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="table-container">
        <h2>Заявления о неисправностях</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php else: ?>
            <table class="declarations-table">
                <thead>
                    <tr>
                        <th>Пользователь</th>
                        <th>Заявление</th>
                        <th>Дата</th>
                        <th>Комплектующее</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['login']); ?></td>
                            <td><?php echo htmlspecialchars($row['declaration']); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($row['date_declaration'])); ?></td>
                            <td><?php echo htmlspecialchars($row['component_name']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html> 