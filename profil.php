<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="nav/nav.css">
  <link rel="stylesheet" href="css/cat.css">
  <link rel="stylesheet" href="css/profil.css">
  <title>PCY</title>
</head>
<body>
  <?php
    include_once "nav/nav.php";
    if(!isset($_SESSION['user'])){
      header("Location: index.php");
    }
  ?>
  <div class="profil">
    <div class="prof-div">
      <div class="data">
        <div class="categories-title">Profil</div>
        <div class="categories-title"><a href="profil.php?logout_id=<?php echo $_SESSION['user'] ?>" >Kilépés</a></div>
        <div class="prof-data">
          <form class="form" id="form1"  action="profil.php" method="POST" name="form1" enctype="multipart/form-data">
            <h1>Profilkép módosítás</h1>
            <div class="error_msg">
              <?php if (isset($_GET['errorimg'])) { ?>
                        <div class="error-txt"><?php echo $_GET['errorimg']; ?></div>
              <?php } ?>
            </div>
            <label>Kérem adja meg az új profilképét!</label><br>
            <input type="file" name="image" class="file">
            <input type="submit" name="submit1" value="Mentés" class="button">
          </form>
        </div>
        <div class="password">
          <form class="form" id="form2"  action="profil.php" method="POST" name="form1">
            <h1>Jelszómódosítás</h1>
            <div class="error_msg">
              <?php if (isset($_GET['error'])) { ?>
                        <div class="error-txt"><?php echo $_GET['error']; ?></div>
              <?php } ?>
            </div>
            <label>Régi jelszó</label><br>
            <input type="password" name="pass"><br>
            <label >Új jelszó</label><br>
            <input type="password" name="new_pass"><br>
            <label >Új jelszó</label><br>
            <input type="password" name="re_pass"><br>
            <input type="submit" name="submit2" value="Mentés" class="button">
          </form>
        </div>
        <?php 
          if($user_data['User_per'] == "ADMIN"){
        ?>
        <div class="password">
          <form class="form" id="form2"  action="profil.php" method="POST" name="form1">
            <h1>Admin hozzáadás</h1>
            <div class="error_msg">
              <?php if (isset($_GET['erroradmin'])) { ?>
                        <div class="error-txt"><?php echo $_GET['erroradmin']; ?></div>
              <?php } ?>
            </div>
            <label>Email cím</label><br>
            <select name="addadmin" id="addadmin">
              <?php
                  $sql = mysqli_query($conn, "SELECT * FROM Users WHERE User_per = 'USER' ORDER BY User_email ASC");
                  while($email = mysqli_fetch_assoc($sql)){
                    echo '<option value="'.$email['User_email'].'">'.$email['User_email'].'</option>';
                  }
                ?>
            </select>
            <input type="submit" name="submit3" value="Mentés" class="button">
          </form>
        </div>
        <div class="password">
          <form class="form" id="form2"  action="profil.php" method="POST" name="form1">
            <h1>Felhasználó törlése</h1>
            <div class="error_msg">
              <?php if (isset($_GET['erroruser'])) { ?>
                        <div class="error-txt"><?php echo $_GET['erroruser']; ?></div>
              <?php } ?>
            </div>
            <label>Email</label><br>
            <select name="addadmin" id="addadmin">
              <?php
                  $sql = mysqli_query($conn, "SELECT * FROM Users WHERE User_per = 'USER' ORDER BY User_email ASC");
                  while($email = mysqli_fetch_assoc($sql)){
                    echo '<option value="'.$email['User_email'].'">'.$email['User_email'].'</option>';
                  }
                ?>
            </select>
            <input type="submit" name="submit4" value="Mentés" class="button">
          </form>
        </div>
        <?php } ?>
      </div>
      <div class="categories-title"><a href="profil.php?delmy_id=<?php echo $_SESSION['user'] ?>" >Fiókom törlése</a></div>
    </div>
  </div>
  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['submit1'])) {
        $user->changeImg();
      }elseif (isset($_POST['submit2'])) {
        $user->changePass();
      }elseif (isset($_POST['submit3'])) {
        $user->addAdmin();
      }elseif (isset($_POST['submit4'])) {
        $user->deleteUser();
      }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      if (isset($_GET['logout_id'])) {
        $user->logout();
      }elseif (isset($_GET['delmy_id'])) {
        $user->delMy();
      }
    }
  ?>
  <?php
    include_once "nav/footer.php";
  ?>
</body>
</html>