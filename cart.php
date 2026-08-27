<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="nav/nav.css">
  <link rel="stylesheet" href="css/cat.css">
  <link rel="stylesheet" href="css/cart.css">
  <title>PCY</title>
</head>
<body>
  <?php
    include_once "nav/nav.php";
    if(!isset($_SESSION['user'])){
      header("Location: index.php");
    }
  ?>
  <div class="center">
    <div class="cart-div">
      <div class="cart-title">Kosár</div>
      <div class="cart-items">
        <?php
          $wr->addCart();
          $wr->WriteCart();
        ?>
      </div>
    </div>
  </div>
  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $wr->delCart();
    }
  ?>
  <?php
    include_once "nav/footer.php";
  ?>
</body>
</html>