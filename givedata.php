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
        <div class="categories-title">Vásárlási adatok megadása</div>
        <div class="prof-data">
          <form class="form" id="form1"  action="givedata.php" method="POST" name="form1" enctype="multipart/form-data">
            <h1>Átviteli lehetőség</h1>
            <div class="order_row">
              <input type="radio" id="atvet" name="atvet" value="Csomagautomata" checked="checked">
              <label>Csomagautomata</label>
              <label class="orderprice">990 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="atvet" name="atvet" value="Futárszolgálat">
              <label>Futárszolgálat</label>
              <label class="orderprice">1 490 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="atvet" name="atvet" value="EXPRESSZ szállítás">
              <label>EXPRESSZ szállítás</label>
              <label class="orderprice">1 990 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="atvet" name="atvet" value="GLS futár">
              <label>GLS futár</label>
              <label class="orderprice">1 990 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="atvet" name="atvet" value="	GLS Pont">
              <label>	GLS Pont</label>
              <label class="orderprice">1 790 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="atvet" name="atvet" value="Duna Plaza">
              <label>Duna Plaza</label>
              <label class="orderprice">0 Ft</label>
            </div>
            <h1>Fizetési mód</h1>
            <div class="order_row">
              <input type="radio" id="fizet" name="fizet" value="Online bankkártya" checked="checked">
              <label>Online bankkártya</label>
              <label class="orderprice">0 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="fizet" name="fizet" value="Előre utalás">
              <label>Előre utalás</label>
              <label class="orderprice">0 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="fizet" name="fizet" value="Utánvét">
              <label>	Utánvét</label>
              <label class="orderprice">690 Ft</label>
            </div>
            <h1>Extra szolgáltatás</h1>
            <div class="order_row">
              <input type="radio" id="extra" name="extra" value="Nem kérek" checked="checked">
              <label>Nem kérek</label>
              <label class="orderprice">0 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="extra" name="extra" value="Háztól-Házig Garancia">
              <label>Háztól-Házig Garancia</label>
              <label class="orderprice">790 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="extra" name="extra" value="Szállítás biztosítás">
              <label>Szállítás biztosítás</label>
              <label class="orderprice">590 Ft</label>
            </div>
            <div class="order_row">
              <input type="radio" id="extra" name="extra" value="Extra dobozban">
              <label>Extra dobozban</label>
              <label class="orderprice">590 Ft</label>
            </div>
            <h1>Számlázási adatok</h1>
            <input type="text" name="nev" placeholder="Név" required>
            <input type="text" name="irszam" placeholder="Ir.szám" required>
            <input type="text" name="varos" placeholder="Város/Utca/Házszám" required>
            <input type="text" name="megj" placeholder="Megjegyzés">
            <input type="submit" name="submit1" value="Mentés" class="button">
          </form>
          <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              if (isset($_POST['submit1'])) {
                $user->order();
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>
  <?php
    include_once "nav/footer.php";
  ?>
</body>
</html>