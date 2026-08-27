<footer>
    <div class="foot">
      <div class="foot-logo">
        <div class="foot-l">
          <a href="../html/index.html" class="logo">PCY</a>
        </div>
      </div>
      <div class="foot-ul">
        <ul>
          <li><a href="index.php">Főoldal</a></li>
          <li><a href="connection.php">Kapcsolat</a></li>
          <?php
            if($ses == 1){
              echo '<li><a href="profil.php?id='.$_SESSION["user"].'">Profil</a></li>';
            }
          ?>
        </ul>
      </div>
    </div>
  </footer>