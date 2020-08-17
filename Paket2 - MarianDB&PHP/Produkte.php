<?php require __DIR__ . '/vendor/autoload.php';?>
<!doctype html>
<html lang="de-de">

<head>
    <?php
    $seite = 'Mahlzeiten';
    include 'inc/head.php';
    ?>

</head>

<body>
<!-- Navigation Area -->
<?php
$PAGE = 'produkte';
include 'inc/navbar.php';
?>
<!-- Container for the imgs -->
<div class="container">
    <div class="row">
        <div class="col" id="avaiableS">
            <h1 class="text-center">Verfügbare Speisen (Bestseller)</h1>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form id="product-list">
                <fieldset>
                    <legend>Speisenliste filtern</legend>
                    <select>
                        <option value="Kategorien">Kategorien</option>
                    </select>
                    <br/>
                    <br/>
                    <label for="avaiable"><input type="checkbox" name="products" value="avaiable" id="avaiable"> &nbsp;nur
                        verfügbare</label>
                    <label for="vegetarian"> <input type="checkbox" name="products" value="vegetarian" id="vegetarian">
                        &nbsp;nur vegetarische</label>
                    <label for="vegan"> <input type="checkbox" name="products" value="vegan" id="vegan">&nbsp;nur vegane</label><br><br/>
                    <button type="button" class="btn btn-info">Speisen filtern</button>
                </fieldset>
            </form>
        </div>
        <div class="col-9" style="text-align:center">
            <?php
            $Row_Nu = 1; // Hilfsvariable, falls Row_Nu != Akt_Row dann wird eine neue Row ausgegeben
            $Col_Nu = 0; // Zaehlt die Anzahl der Produkte pro Zeile
            $Akt_Row = 0;
            $LIMIT=""; // Hiltsvariable, wird an Query angehängt
            $Avail=0;
            if(isset($_GET['limit'])) $LIMIT="LIMIT ".$_GET['limit'];
            if(isset($_GET['avail'])) $Avail=$_GET['avail'];
            if($Avail) $availQuery = "m.Verfuegbar = 1";
            else $availQuery = "true";

            $dotenv = Dotenv\Dotenv::create(__DIR__, '.env');
            $dotenv->load();
            $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);
            $remoteConnection = mysqli_connect(getenv('DB_HOST'),
                getenv('DB_USER'),
                getenv('DB_PASS'),
                getenv('DB_NAME'),
                (int)getenv('DB_PORT'));

            if (!$remoteConnection) {
                echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
                exit();
            }
            $query="SELECT m.Name,m.ID,Verfuegbar,`Alt-Text`,Binaerdaten FROM Mahlzeiten AS m JOIN Bilder AS b JOIN HatBilder AS hb 
                    WHERE m.ID=hb.MahlzeitenID AND b.ID = hb.BilderID AND $availQuery ".$LIMIT;
            $result = mysqli_query($remoteConnection, $query);
            mysqli_close($remoteConnection);

            if($result){
                while ($row = mysqli_fetch_assoc($result)) { // Important line !!! Check summary get row on array ..
                    $name = $row['Name'];
                    $available = $row['Verfuegbar'];
                    $ID = $row['ID'];
                    $Bild = $row['Binaerdaten'];
                    $AltText = $row['Alt-Text'];

                    // Prüfe ob eine neue Zeile bzw Row ausgegeben sollte
                    if ($Row_Nu != $Akt_Row) {
                        echo '<div class="row lower_10px_padding">'.PHP_EOL;
                        $Akt_Row = $Row_Nu;
                    }

                    // Fallunterscheidung, falls $available = 0 dann zeige es als vergriffen
                   if($available){
                       echo '<div class="col-sm-2">'.PHP_EOL;
                       echo  '<img class="smallImg  img-thumbnail"
                         src="data:image/jpg;base64,'.$Bild.'" alt="'.$AltText.'">'.PHP_EOL;

                       echo '<h5>' . $name . '</h5>'.PHP_EOL;
                       echo '<a target="_self" href="Detail.php?id=' . $ID . '">Details</a>'.PHP_EOL;
                       echo '</div>'.PHP_EOL;
                   }
                   else{
                       echo '<div class="col-sm-2">'.PHP_EOL;
                       echo '<img class="smallImg img-thumbnail"
                         src="data:image/jpg;base64,'.$Bild.'" alt="'.$AltText.'">'.PHP_EOL;

                       echo '<h5>' . $name . '</h5>'.PHP_EOL;
                       echo '<a target="_self" class="btn disabled" href="Detail.php?id=' . $ID . '">vergriffen</a>'.PHP_EOL;
                       echo '</div>'.PHP_EOL;
                   }

                    $Col_Nu++;
                    if ($Col_Nu%4 == 0) {
                        ++$Row_Nu;
                        $Col_Nu = 0;
                        echo '</div>'.PHP_EOL;
                    } // d.h hier sind per Zeile schon 4 Elemente vorhanded => Neue Row Zeile (/Div bezieht sich auf RowDiv)
                }
            }

            ?>

        </div>
        </div>
    </div>
</div>
<!-- footer Container -->
<?php
include 'inc/Footer.php'
?>
</body>

</html>
