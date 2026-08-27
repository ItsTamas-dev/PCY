<?php 

$conn = mysqli_connect("localhost", "root", "", "pcy");
mysqli_set_charset($conn, "UTF8");
class User{
  public $conn;
  function __construct($conn) {
    $this->conn = $conn;
  }
  function reg(){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $re_pass = $_POST['re_pass'];
    if(empty($email) || empty($pass) || empty($re_pass)){
      header("Location: log-reg.php?error=Az összes mező kitöltése kötelező!!<br>(Regisztáció)");
      exit();
    }else{
      if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $s_email = mysqli_query($this->conn, "SELECT User_email FROM Users WHERE User_email = '{$email}'");
        if(mysqli_num_rows($s_email) > 0){
          header("Location: log-reg.php?error=A megadott email már foglalt!!<br>(Regisztáció)");
          exit();
        }else{
          if($pass != $re_pass){
            header("Location: log-reg.php?error=A két jelszó nem egyezik!!<br>(Regisztáció)");
            exit();
          }else{
            $secret_pass = md5($pass);
            $insert = mysqli_query($this->conn, "INSERT INTO Users (User_email, User_pass, User_img, User_per)
            VALUES ('{$email}', '{$secret_pass}', 'user.png', 'USER')");
            if($insert){
              header("Location: log-reg.php?error=Sikeres regisztráció!!<br>(Regisztáció)");
              exit();
            }
          }
        }
      }else{
        header("Location: log-reg.php?error=A megadott email nem megfelelő!!<br>(Regisztáció)");
        exit();
      }
    }
  }
  function log(){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    if(empty($email) || empty($pass)){
      header("Location: log-reg.php?error=Az összes mező kitöltése kötelező!!<br>(Bejelentkezés)");
      exit();
    }else{
      $s_email = mysqli_query($this->conn, "SELECT * FROM Users WHERE User_email = '{$email}'");
      if(mysqli_num_rows($s_email) > 0){
        $us = mysqli_fetch_assoc($s_email);
        $ch_pass = md5($pass);
        if($ch_pass == $us["User_pass"]){
          $_SESSION['user'] = $us["User_id"];
          header("Location: index.php");
        }else{
          header("Location: log-reg.php?error=Hibás jelszó!!<br>(Bejelentkezés)");
        exit();
        }
      }else{
        header("Location: log-reg.php?error=Nincs ilyen email!!<br>(Bejelentkezés)");
        exit();
      }
    }
  }
  function logout(){
    if(isset($_SESSION['user'])){
      session_unset();
      session_destroy();
      header("Location: index.php");
    }
  }
  function getUser(){
    if(isset($_SESSION['user'])){
      $getdata = mysqli_query($this->conn, "SELECT * FROM Users WHERE User_id = {$_SESSION['user']}");
      if(mysqli_num_rows($getdata) > 0){
        $user_row = mysqli_fetch_assoc($getdata);
        return $user_row;
      }
    }
    return 0;
  }
  function getCart(){
    $getCart = mysqli_query($this->conn, "SELECT COUNT(User_id) AS cartdb FROM Cart WHERE User_id = {$_SESSION['user']} ");;
    if(mysqli_num_rows($getCart) > 0){
      $user_cart = mysqli_fetch_assoc($getCart);
      return $user_cart["cartdb"];
    }
  }
  function changePass(){
    $user = $this->getUser();
    $pass = $_POST['pass'];
    $new_pass = $_POST['new_pass'];
    $re_pass = $_POST['re_pass'];
    if(empty($pass) || empty($new_pass) || empty($re_pass)){
      header("Location: profil.php?error=Az összes mező kitöltése kötelező!!");
      exit();
    }else{
      $check = md5($pass);
      if($check == $user['User_pass']){
        if($new_pass == $re_pass){
          if($new_pass == $pass){
            header("Location: profil.php?error=AZ új jelszót jelenleg használod!!");
            exit();
          }else{
            $new = md5($new_pass);
            $change = mysqli_query($this->conn, "UPDATE `users` SET `User_pass` = '{$new}' WHERE `users`.`User_id` = {$user['User_id']};");
            if($change){
              header("Location: profil.php?error=Sikeres jelszó változtatás!!");
            exit();
            }
          }
        }else{
          header("Location: profil.php?error=Az új jelszó nem egyezik az ellenörzővel!!");
          exit();
        }
      }else{
        header("Location: profil.php?error=Hibás jelszó!!");
        exit();
      }
    }
  }
  function changeImg(){
    $user = $this->getUser();
    $img = $_FILES['image'];
    if(isset($_FILES['image'])){
      $img_name = $_FILES['image']['name'];
      $tmp_name = $_FILES['image']['tmp_name'];
      $img_explode = explode('.', $img_name);
      $img_ext = end($img_explode);
      $extensions = ['jpg', 'jpeg', 'png'];
      if(in_array($img_ext, $extensions) === true){
        $time = time();
        $img_name_fol = $time.$img_name;
        if(move_uploaded_file($tmp_name, "img/user/".$img_name_fol)){
          if($user["User_img"] != "user.png"){
            $path = 'img/user/'.$user["User_img"].'';
            unlink($path); 
          }
          $change = mysqli_query($this->conn, "UPDATE `users` SET `User_img` = '{$img_name_fol}' WHERE `users`.`User_id` = {$user['User_id']};");
          if($change){
            header("Location: profil.php?errorimg=Sikeres képváltoztatás!!");
            exit();
          }
        }else{
          header("Location: profil.php?errorimg=Hiba történt!!");
          exit();
        }
      }else{
        header("Location: profil.php?errorimg=Nem megfelelő formátum (jpeg, jpg, png)!!");
        exit();
      }
    }else{
      header("Location: profil.php?errorimg=Nincs fájl feltöltve!!");
      exit();
    }
  }
  function addAdmin(){
    $email = filter_input(INPUT_POST, 'addadmin', FILTER_SANITIZE_STRING);
    $change = mysqli_query($this->conn, "UPDATE `Users` SET `User_per` = 'ADMIN' WHERE `User_email` = '{$email}'");
    if($change){
      header("Location: profil.php?erroradmin=Sikeres hozzáadás!!");
      exit();
    }
  }
  function deleteUser(){
    $del_id = 0;
    $email = filter_input(INPUT_POST, 'addadmin', FILTER_SANITIZE_STRING);
    $delete = mysqli_query($this->conn, "DELETE FROM `Users` WHERE User_email = '{$email}'");

    $deluser = mysqli_query($this->conn, "SELECT * FROM Users WHERE User_email = '{$email}'");
    if(mysqli_num_rows($deluser) != 0){
      $del_row = mysqli_fetch_assoc($deluser);
      $del_id = $del_row['User_id'];
    }

    $deleteCart = mysqli_query($this->conn, "DELETE FROM `Cart` WHERE User_id = '{$del_id}'");
    $deleteComm = mysqli_query($this->conn, "DELETE FROM `Comments` WHERE User_Id = '{$del_id}'");
    $deleteOrder = mysqli_query($this->conn, "DELETE FROM `Order` WHERE User_Id = '{$del_id}'");

    if($delete && $deleteCart && $deleteComm && $deleteOrder){
      header("Location: profil.php?erroruser=Sikeres törlés!!");
      exit();
    }
  }
  function delMy(){
    $id = $_GET["delmy_id"];
    $this->logout();
    $delete = mysqli_query($this->conn, "DELETE FROM `Users` WHERE User_id = '{$id}'");
    $deleteCart = mysqli_query($this->conn, "DELETE FROM `Cart` WHERE User_id = '{$id}'");
    $deleteComm = mysqli_query($this->conn, "DELETE FROM `Comments` WHERE User_Id = '{$id}'");
    $deleteOrder = mysqli_query($this->conn, "DELETE FROM `Order` WHERE User_Id = '{$id}'");

  }
  function order(){
    $atvet = $_POST['atvet'];
    $fizet = $_POST['fizet'];
    $extra = $_POST['extra'];
    $nev = $_POST['nev'];
    $irszam = $_POST['irszam'];
    $varos = $_POST['varos'];
    $megj = $_POST['megj'];
    $new = 0;
    $update = mysqli_query($this->conn, "SELECT * FROM Cart");
    if(empty($megj)){
      $megj = "Nincs megjegyzés";
    }
    $order_data = ''.$atvet.';'.$fizet.';'.$extra.';'.$nev.';'.$irszam.';'.$varos.';'.$megj.'';
    $cart = mysqli_query($this->conn, "SELECT * FROM Cart WHERE User_Id = {$_SESSION['user']}");
    $order ="";
    while($cart_row = mysqli_fetch_assoc($cart)){
        $order .= ''.$cart_row["Pro_id"].';';
    }
    $insert = mysqli_query($this->conn, "INSERT INTO `order` (`Order_id`, `User_id`, `Order`, `order_data`) VALUES (NULL, {$_SESSION["user"]}, '{$order}', '{$order_data}');");
    $cart = mysqli_query($this->conn, "SELECT * FROM Cart WHERE User_Id = {$_SESSION['user']}");
    while($cart_row = mysqli_fetch_assoc($cart)){
      $cart_id = $cart_row["Pro_id"];
      $pro = mysqli_query($this->conn, "SELECT * FROM Products WHERE Pro_id = {$cart_id}");
      while($pro_row = mysqli_fetch_assoc($pro)){
        $new = $pro_row["Pro_stock"];
        $new = $new-1;
        $update = mysqli_query($this->conn, "UPDATE `Products` SET `Pro_stock` = {$new} WHERE `products`.`Pro_id` = {$cart_id};");
      }
    }
    $delete = mysqli_query($this->conn, "DELETE FROM `Cart` WHERE User_Id = '{$_SESSION['user']}'");
    if($insert && $delete && $update){
      echo "<h1>Sikeresen leadta rendelését!</h1>";
    }
  }
}
class Write{
  public $conn;
  public $id;
  public $sql;
  public $row;
  public $user_row;
  function __construct($conn) {
    $this->conn = $conn;
    $user = new User($this->conn); 
    $this->user_row = $user->getUser();
  }
  function WriteAllCat(){
    $sql = mysqli_query($this->conn, "SELECT * FROM Categories");
    while($row = mysqli_fetch_assoc($sql)){
      $array = explode(';',$row["Cat_brand"]);
      echo '<div class="card reveal">
              <div class="inf">
                <div class="cat-img">
                  <a class="aimg" href="allproduct.php?id='.$row["Cat_id"].'" class="cat-btn">
                    <img src="img/categories/'.$row["Cat_img"].'" alt="'.$row["Cat_name"].'">
                  </a>
                </div>
                <h1>'.$row["Cat_name"].'</h1>
                <ul>
                  <li>'.$array[0].'</li>
                  <li>'.$array[1].'</li>
                  <li>'.$array[2].'</li>
                  <li>'.$array[3].'</li>
                  <li>'.$array[4].'</li>
                  <li>...</li>
                </ul>
                <a href="allproduct.php?id='.$row["Cat_id"].'" class="cat-btn">Tovább</a>
              </div>
            </div>';
    }  
  }
  function WriteSlide(){
    $sql = mysqli_query($this->conn, "SELECT * FROM Products LIMIT 3");
    while($row = mysqli_fetch_assoc($sql)){
      echo '<div class="content">
              <div class="img"><img src="img/product/'.$row["Pro_img1"].'" alt="teszt"></div>
              <h3>'.$row["Pro_name"].'</h3>
              <span>'.$row["Pro_name2"].'</span>
              <p>'.$row["Pro_text"].'</p>
              <a href="product.php?id='.$row["Pro_id"].'" class="tonewpage">Megtekintés</a>
            </div>';
    }
  }
  function WriteAllProduct(){
    $id= $_GET['id'];
    $name = mysqli_query($this->conn, "SELECT * FROM Categories WHERE Cat_id = '$id'");
    while($row = mysqli_fetch_assoc($name)){
      echo '<div class="categories-title">'.$row["Cat_name"].'</div>';
    }
    echo '<div class="cards">';
    $sql= mysqli_query($this->conn, "SELECT * FROM Products WHERE Pro_cat = '$id' ORDER BY Pro_price");
    while($row = mysqli_fetch_assoc($sql)){
      $array = explode(';',$row["Pro_card"]);
        echo '<div class="card item reveal">
                <div class="inf">
                  <div class="cat-img">
                    <a href="product.php?id='.$row["Pro_id"].'">
                      <img src="img/product/'.$row["Pro_img1"].'" alt="laptop">
                    </a>
                  </div>
                  <h1>'.$row["Pro_name"].'</h1>
                  <h2>'.$row["Pro_name2"].'</h2>
                  <ul>
                    <li>'.$array[0].'</li>
                    <li>'.$array[1].'</li>
                    <li>'.$array[2].'</li>
                    <li>'.$array[3].'</li>
                    <li>'.$array[4].'</li>
                    <li class="price">'.$row["Pro_price"].' Ft</li>
                  </ul>
                  <a href="cart.php?addid='.$row['Pro_id'].'"class="toCart-btn" name="addCart"';
          if(!isset($_SESSION['user']) || $row["Pro_stock"] == 0){
                    echo 'id="toCart"';
          }
          echo '>Kosárba</a>
                </div>
              </div>';
    }
    $sql= mysqli_query($this->conn, "SELECT * FROM Products WHERE Pro_cat = '$id' ORDER BY Pro_price");
    if(mysqli_fetch_assoc($sql) == 0){
      echo '<div class ="nopro">Ehhez a kategóriához jelenleg nincs termék!</div>';
    }
    echo '</div>';
  }
  function setId(){
    $this->id= $_GET['id'];
  }
  function getId(){
    return $this->id;
  }
  function setSql(){
    $this->sql = mysqli_query($this->conn, "SELECT * FROM Products WHERE Pro_id = '$this->id'");
    if(mysqli_num_rows($this->sql) > 0){
      $this->row = mysqli_fetch_assoc($this->sql);
    }
  }
  function getBigImg(){
      echo '<img src="img/product/'.$this->row["Pro_img1"].'" alt="'.$this->row["Pro_name"].'">';
  }
  function getSmall(){
    echo '<div class="small">
            <img class="img" src="img/product/'.$this->row["Pro_img1"].'" alt="'.$this->row["Pro_name"].'">
          </div>';
    echo '<div class="small">
            <img class="img" src="img/product/'.$this->row["Pro_img2"].'" alt="'.$this->row["Pro_name"].'">
          </div>';
    echo '<div class="small">
            <img class="img" src="img/product/'.$this->row["Pro_img3"].'" alt="'.$this->row["Pro_name"].'">
          </div>';
    echo '<div class="small">
            <img id="vid" src="img/icons/play.png" alt="play">
          </div>';
  }
  function getJs(){
   $src = '"';
   echo "<script>document.querySelectorAll('.small-img .img').forEach(image =>{image.onclick = () =>{
      document.querySelector('.big-img').innerHTML = ".$src."<img src='img/product/".$this->row["Pro_img1"]."'>".$src.";
      document.querySelector('.big-img img').src = image.getAttribute('src');
    }});document.getElementById('vid').onclick = () =>{
    document.querySelector('.big-img').innerHTML =`<iframe src='".$this->row["Pro_video"]."'></iframe>`;
    document.querySelector('.pop').style.display = 'block';}</script>
   ";
  }
  function getName(){
    echo '
    <h1>'.$this->row["Pro_name"].'</h1>
    <h2>'.$this->row["Pro_name2"].'</h2>
    
    ';
    /*<h2>'.$this->row["Pro_price"].' Ft</h2>*/
  }
  function getDate(){
    $date = date("m/d");
    $new_date =  date('m/d', strtotime($date . ' +4 day'));
    echo $new_date;
  }
  function getAvailable(){
    echo '<div class="rend">
            <label>
              Jelenleg raktáron: '.$this->row["Pro_stock"].' db
            </label>
            </div>
            <div class="send">
              <a href="cart.php?addid='.$this->row['Pro_id'].'"';
    if($this->row["Pro_stock"] == 0 || !isset($_SESSION['user'])){
              echo 'id="toCart"';
    }
    echo'     >Kosárba</a>
            </div>';
  }
  function WriteTable(){
    $array = explode(';',$this->row["Pro_all"]);
    for($i = 0; $i<(sizeof($array))-1; $i++){
      if(!($array[$i]=="head")){
        if(($array[$i+1]=="head")){
          if($i == 0){
            echo '
            <tr>
              <th colspan="2" class="first">'.$array[$i].'</th>
            </tr>';
          }else{
            echo '
              <tr>
                <th colspan="2">'.$array[$i].'</th>
              </tr>';
          }
        }else{
          if (str_contains($array[$i+1], "*")) {
            $lista = explode('*',$array[$i+1]);
            echo '
              <tr>
              <td>'.$array[$i].'</td>
              <td><ul>';
              for($j = 0; $j < sizeof($lista); $j++){
                echo '<li>'.$lista[$j].'</li>';
              }
              echo '</ul></td>
              </tr>';
              $i++;
        }else{
          echo '
              <tr>
              <td>'.$array[$i].'</td>
              <td>'.$array[$i+1].'</td>
              </tr>';
              $i++;
        }
          
        }
      }
    }
  }
  function WriteComment(){
    $comments = mysqli_query($this->conn, "SELECT * FROM Comments WHERE Pro_Id = '$this->id' ORDER BY `comments`.`Com_Id` DESC");
    $i = 1;
    if(mysqli_num_rows($comments) == 0){
      echo '<div class="comment"> 
              Ehhez a termékhez nincs megjegyzés írva!
            </div>';
    }
    while($com = mysqli_fetch_assoc($comments)){
      $user = mysqli_query($this->conn, "SELECT * FROM Users WHERE User_id = {$com['User_Id']}");
      if(mysqli_num_rows($user) != 0){
        $user_row = mysqli_fetch_assoc($user);
        $array = explode('@', $user_row['User_email']);
        if($i>2){
          echo '<div class="comment reveal">';
        }else{
          echo '<div class="comment">';
        }
        echo '  <div class="comm_img">
                  <img src="img/user/'.$user_row['User_img'].'">
                </div>
                <div class="comm_text">
                <h4>'.$array[0].'</h4>
                  <p class="text">
                    '.$com["Com_text"].'
                  </p>
                </div>
              </div>';
        $i++;
      }
    }
  }
  function WriteCart(){
    $price = 0;
    $cart = mysqli_query($this->conn, "SELECT * FROM Cart WHERE User_Id = {$_SESSION['user']}");
    if(mysqli_num_rows($cart) == 0){
      echo '<div class="noitem">Jelenleg üres a kosár</div>';
    }else{
      while($cart_row = mysqli_fetch_assoc($cart)){
        $cart_pro = mysqli_query($this->conn, "SELECT * FROM Products WHERE Pro_Id = {$cart_row['Pro_id']}");
        if(mysqli_num_rows($cart_pro) > 0){
          $pro_row = mysqli_fetch_assoc($cart_pro);
          echo '<div class="item">
                  <img src="img/product/'.$pro_row['Pro_img1'].'" alt="termek">
                  <div class="name">
                    <h3>'.$pro_row['Pro_name'].'</h3>
                    <span>'.$pro_row['Pro_name2'].'</span>
                  </div>
                  <div class="price">
                    <div class="money">
                      <span id="pr1">'.$pro_row['Pro_price'].'</span> Ft
                    </div>
                  </div>
                  <div>
                    <a class="delete" href="cart.php?delete='.$cart_row['Cart_id'].'">Törlés</a>
                  </div>
                </div>';
          $price += $pro_row['Pro_price'];
        }
      }
      echo '<div class="next">
              <a href="givedata.php">Tovább az adatok megadásához</a>
              <span id="all">'.$price.' Ft</span>
            </div>';
    }
  }
  function delCart(){
    if(isset($_GET['delete'])){
      $delete_id = $_GET['delete'];
      $delete= mysqli_query($this->conn, "DELETE FROM Cart WHERE Cart_id = {$delete_id}");
    }
  }
  function addCart(){
    if(isset($_GET["addid"])){
      $id = $_GET["addid"];
      $user_id = $this->user_row["User_id"];
      $add= mysqli_query($this->conn, "INSERT INTO `cart` (`Cart_id`, `Pro_id`, `User_id`) VALUES (NULL, $id, $user_id)");
    }
  }
  function addComm(){
    $text = $_POST["comment"];
    if(!(empty($text))){
      $add= mysqli_query($this->conn, "INSERT INTO `comments` (`Com_Id`, `Pro_Id`, `User_Id`, `Com_text`) VALUES (NULL, {$this->id}, {$_SESSION["user"]}, '{$text}')");
    }
  }
}
?>