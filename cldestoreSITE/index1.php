<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>Document</title>
</head>

<body>
  <div class="navbar">
    <a href="profile.php">
      <button>Профиль</button>
    </a>
  </div>
  <div class="mainimage">
    <img src="Iván_el_Terrible_y_su_hijo,_por_Iliá_Repin.jpg" alt="@" />
  </div>
  <div id="products">

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cldestore";
    

    $conn = mysqli_connect($servername, $username, $password, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }


    $result = $conn->query("SELECT * FROM products");
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<div class="offer">';
        echo '<h2>' . $row['name'] . '</h2>';
        echo '<p>' . $row['description'] . '</p>';
        echo '<p>Price: $' . $row['price'] . '</p>';
        echo '<button class="basket" onclick="addToCart(' . $row['id'] . ')"><img src="pngwing.com.png" alt="@" /></button>';
        echo '</div>';
      }
    } else {
      echo "ничего нет";
    }

    $conn->close();
    ?>
    <script>
      function addToCart(productId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "add_to_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Товар добавлн в корзину УРА");
          }
        };
        xhr.send("product_id=" + productId);
      }
    </script>
</body>

</html>