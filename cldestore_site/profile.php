<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Подключение к базе данных
$conn = new mysqli('localhost', 'root', '', 'cldestore');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение идентификатора пользователя из сессии
$user_id = $_SESSION['user_id'];

// Получение продуктов из корзины пользователя
$sql = "SELECT products.name, products.description, products.price, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <style>
        .product {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Ваш профиль</h1>
    <h2>Заказы</h2>
    <div id="cart">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '<p>Цена: $' . htmlspecialchars($row['price']) . '</p>';
                echo '<p>Количество: ' . htmlspecialchars($row['quantity']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>У вас нет заказов</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
