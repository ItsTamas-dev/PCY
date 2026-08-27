<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="nav/nav.css">
  <link rel="stylesheet" href="css/cat.css">
  <link rel="stylesheet" href="css/scroll.css">
  <link rel="stylesheet" href="css/slide.css">
  <title>PCY</title>
</head>
<body>
  <?php
    include_once "nav/nav.php";
  ?>
  <section class="news" id="news">
    <div class="new">
      <?php
        $wr->WriteSlide();
      ?>
    </div>
  </section>
  <div class="categories">
    <?php
        $wr->WriteAllProduct();
      ?>
  </div>
  <script src="js/scroll.js"></script>
  <?php
    include_once "nav/footer.php";
  ?>
</body>
</html>