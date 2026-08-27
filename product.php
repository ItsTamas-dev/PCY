<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="nav/nav.css">
  <link rel="stylesheet" href="css/product.css">
  <link rel="stylesheet" href="css/scroll.css">
  <title>PCY</title>
</head>
<body>
  
  <?php
    include_once "nav/nav.php";
  ?>
  <div class="center">
    <div class="product">
      <div class="product-top">
        <div class="images">
          <div class="big-img">
            <?php
              $wr->setId();
              $wr->setSql();
              $wr->getBigImg();
            ?>
          </div>
          <div class="small-img">
            <?php
              $wr->getSmall();
              $wr->getJs();
            ?>
          </div>
        </div>
      </div>
      <div class="product-property">
        <div class="property">
          <?php
            $wr->getName();
          ?>
          <div class="inf">
            <div class="gar">
              <h2>Garancia lehetőség</h2>
              <ul>
                <li>Háztól-Házig Garancia</li>
                <li>Szállítás biztosítás</li>
              </ul>
            </div>
            <div class="szal">
              <h2>Átvételi lehetőségek</h2>
              <table>
                <tr>
                  <td>Duna Plaza</td>
                  <td><?php $wr->getDate(); ?></td>
                </tr>
                <tr>
                  <td>Futárszolgálat</td>
                  <td><?php $wr->getDate(); ?></td>
                </tr>
                <tr>
                  <td>EXPRESSZ szállítás</td>
                  <td><?php $wr->getDate(); ?></td>
                </tr>
                <tr>
                  <td>Posta Pont</td>
                  <td><?php $wr->getDate(); ?></td>
                </tr>
                <tr>
                  <td>MOL Pont</td>
                  <td><?php $wr->getDate(); ?></td>
                </tr>
                <tr>
                  <td>PACKETA</td>
                  <td><?php $wr->getDate(); ?></td>
                </tr>
                <tr>
                  <td>GLS futár</td>
                  <td><?php $wr->getDate(); ?></td>
                </tr>
                <tr>
                  <td>Nagy csomag</td>
                  <td><?php $wr->getDate(); ?></td>
                </tr>
              </table>
            </div>
          </div>
          <?php 
              $wr->getAvailable();
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="center">
    <div class="buttons">
      <div class="btn">
        <button id="table" onclick="table()">Tulajdonságok</button>
        <button id="comm" onclick="comm()">Megjegyzések</button>
        <button id="wcomm" onclick="wcomm()">Hozzászólás</button>
      </div>
    </div>
  </div>
  
  <div class="center">
    <div class="table" id="TABLE">
      <table class="reveal">
        <?php $wr->WriteTable(); ?>
      </table>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['comment'])) {
        $wr->addComm();
      }
    }
    ?>
    <div class="comm none" id="COMM">
      <div class="comments">
        <?php $wr->WriteComment(); ?>
      </div>
    </div>
    <div class="comm none" id="WCOMM">
      <div class="comments">
        <form class="form" id="form1" action="product.php?id=<?php echo $wr->getId(); ?>" method="POST" name="form1">
          <label>Ide Írja hozzászólását!</label><br>
          <textarea name="comment" maxlength="500" placeholder="Max 500 karakter"></textarea>
          <input type="submit" name="addcomm" class="addcomm"
          <?php if(!isset($_SESSION['user'])){
              echo 'id="toCart"';
          }?>
          >
        </form>
      </div>
    </div>
  </div>
  <script src="js/scroll.js"></script>
  <script>
    function table(){
      document.getElementById("TABLE").classList.remove("none");
      document.getElementById("COMM").classList.add("none");
      document.getElementById("WCOMM").classList.add("none");
    }
    function comm(){
      document.getElementById("TABLE").classList.add("none");
      document.getElementById("COMM").classList.remove("none");
      document.getElementById("WCOMM").classList.add("none");
    }
    function wcomm(){
      document.getElementById("TABLE").classList.add("none");
      document.getElementById("COMM").classList.add("none");
      document.getElementById("WCOMM").classList.remove("none");
    }
  </script>
  <?php
    include_once "nav/footer.php";
  ?>
</body>
</html>