<?php
  include_once "conf.php";
  session_start();
  $wr = new Write($conn);
  $user = new User($conn);
  $ses = 1;
  $user_data;
  if(!isset($_SESSION['user'])){
    $ses = 0;
  }else{
    $user_data = $user->getUser();
  }
?>
<header>
    <input type="checkbox" id="toggler">
    <label for="toggler" class="ham">
      <img src="img/icons/hamburger.png" alt="hamburger" class="hamburger">
    </label>
    <a href="index.php" class="logo">PCY</a>
    <nav>
      <a href="index.php">
        Főoldal
      </a>
      <a href="connection.php">
        Kapcsolat
      </a>
      <?php
        if($ses == 1){
          echo '<a href="profil.php?id='.$_SESSION["user"].'">';
          if($user_data['User_per'] == "ADMIN"){
            echo '
              Admin
            ';
          }else{
            echo '
              Profil
            ';
          }
          echo '</a>';
        }
      ?>
    </nav>
    <div class="icons">
      <?php
        if($ses == 1){
          echo '
          <img src="img/user/'.$user_data["User_img"].'" class="user_img">
          <a href="cart.php" class="cart">
            <img src="img/icons/cart.png" alt="cart">
          </a>
          <div class="num">'.$user->getCart().'</div>'
          ;
        }else{
          echo '
          <a href="log-reg.php" class="prof">
            <img src="img/icons/profil.png" alt="prof">
          </a>
          <a href="cart.php" class="cart" id="toCart">
            <img src="img/icons/cart.png" alt="cart">
          </a>';
        }
      ?>
    </div>
</header>