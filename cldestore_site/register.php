// register.php
<?php
// Получение данных формы
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$email = $_POST['email'];

// Подключение к базе данных
$conn = new mysqli('localhost', 'root', '', 'cldestore');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Вставка нового пользователя в базу данных
$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password, $email);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: login.html");
?>
