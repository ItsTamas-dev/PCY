<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="nav/nav.css">
  <link rel="stylesheet" href="css/cat.css">
  <link rel="stylesheet" href="css/log-reg.css">
  <title>PCY</title>
</head>
<body>
  <?php
    include_once "nav/nav.php";
  ?>
   <div class="full">
    <div class="wrap">
      <div class="card">
        <div class="head">
          <div class="slide">
            <div class="slide-item" id="slide-item">
              as
            </div>
            <div class="slide-texts">
              <div class="log">
                <a href="javascript:void(0);" onclick="toLeft()">Bejelentkezés</a>
              </div>
              <div class="reg">
                <a href="javascript:void(0);" onclick="toRight()">Regisztáció</a>
              </div>
            </div>
          </div>
        </div>
        <div class="error_msg">
          <?php if (isset($_GET['error'])) { ?>
                    <div class="error-txt"><?php echo $_GET['error']; ?></div>
     	    <?php } ?>
        </div>
        <div class="forms" id="REGISTRATION-LOGIN">
          <form class="form" id="form1" action="log-reg.php" method="POST" name="form1">
            <div class="text">
                <label>Email-cím</label>
                <input type="text" name="email">
            </div>
            <div class="text">
                <label>Jelszó</label>
                <input type="password" name="pass" minlength="8" placeholder="Minimum 8 karakter">
            </div>
            <div class="text">
              <label>Jelszó megerősítő</label>
              <input type="password" name="re_pass">
            </div>
            <div class="text button">
              <input type="submit" name="submit1" value="Regisztráció">
            </div>
          </form>
          <form class="form" id="form2"  action="log-reg.php" method="POST" name="form1">
            <div class="text">
                <label>Email-cím</label>
                <input type="text" name="email">
            </div>
            <div class="text">
                <label>Jelszó</label>
                <input type="password" name="pass">
            </div>
            <div class="text button">
              <input type="submit" name="submit2" value="Belépés">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['submit1'])) {
        $user->reg();
      } elseif (isset($_POST['submit2'])) {
        $user->log();
      }
    }

  ?>
  <script src="js/slide.js"></script>
  <?php
    include_once "nav/footer.php";
  ?>
</body>
</html>