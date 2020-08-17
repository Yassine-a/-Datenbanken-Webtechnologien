<!doctype html>
<html lang="de-de">

<head>
    <?php
    $seite = 'Startseite';
    include 'inc/head.php';
    ?>
</head>

<body>
  <!-- Navigation Area -->
  <?php
  $PAGE='start';
  include 'inc/navbar.php'
  ?>
  <!-- Container for the imgs -->
  <div class="container">
    <img id="upper-img" src="./img/img1.jpg" alt="Mensa-Bild1">
  </div>
  <!-- the Body Container -->
  <div class="container">
    <div class="row top-buffer">
      <div class="col-3">
        <p>Der Dienst e-Mensa ist noch beta. Sie können bereits <a href="#">Mahlzeiten</a> durchstöbern, aber noch nicht bestellen. </p>
      </div>
      <div class="col-sm-7">
        <h1>Leckere Gerichte vorbestellen</h1>
        <p>.. und gemeinsam mit Kommilitonen und Freunden essen</p>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-info"><i class="far fa-hand-point-right"></i> Registrieren</button>
        <button type="button" class="btn btn-info"><i class="fas fa-sign-in-alt"></i> Anmelden</button>
      </div>
    </div>
    <div class="row top-buffer">
      <div class="col-3">
        <p> <a href="#">Registrieren</a> Sie sich hier, um über die Veröffentlichung des Dienstes per Mail informiert zu werden. </p>
      </div>
      <div class="col-9">
        <img id="lower-img" src="./img/img2.jpg" alt="Responsive image">
      </div>
    </div>
  </div>
  <!-- footer Container -->
  <?php
  include 'inc/Footer.php'
  ?>
 </body>

</html>
