<!doctype html>
<html lang="de-de">

<head>
    <?php
    $seite = 'Details';
    include 'inc/head.php';
    ?>
</head>

<body>
<!-- Navigation Area -->
    <?php
    if (!isset($_GET['id'])) header('Location: Produkte.php');
    $ID = $_GET['id'];
    $PAGE = 'produkte';
    include 'inc/navbar.php'
    ?>
    <!-- PHP Code to redirect the user to Produkt.php, incase the wrong ID was given -->
    <?php
    require __DIR__ . '/vendor/autoload.php';
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

    //$result=mysqli_query($remoteConnection,"SELECT * FROM Bilder WHERE ID=1");
    //$row = mysqli_fetch_array($result);
    //echo '<img src="' . $row['Binaerdaten'] . '" />';

    $result = mysqli_query($remoteConnection, "SELECT  m.ID, m.Name,m.ID,Beschreibung,`Alt-Text`,Binaerdaten,Gastpreis FROM Mahlzeiten AS m
                                                        JOIN Bilder AS b
                                                        JOIN HatBilder AS hb
                                                        JOIN Preise AS p ON m.ID=p.MahlzeitenID
                                                        WHERE m.ID=hb.MahlzeitenID AND b.ID = hb.BilderID AND m.ID=$ID");

    $row = mysqli_fetch_array($result);
    $DB_ID = $row['ID'];
    if ($DB_ID != $ID) header('Location: Produkte.php');
    ?>
    <!-- PHP Code to query the database and fetch the data-->
    <?php

    $preis = $row['Gastpreis'];
    $desc = $row['Beschreibung'];
    $name = $row['Name'];
    $AltText = $row['Alt-Text'];
    $Bild=$row['Binaerdaten'];


?>
<div class="container">
    <div class="row">
        <div class="col-3">
            <!--empty space-->
        </div>
        <div class="col-9" id="avaiableS">
            <h1>Details für "<?php echo $name ?>"</h1>
            <br/>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-3">
            <form method="get">
                <fieldset>
                    <legend>&nbsp;Login</legend>
                    <label for="username"><input type="text" name="username" placeholder="Benutzer"
                                                 id="username"></label>
                    <label for="password"><input type="password" name="password" placeholder="********"
                                                 id="password"></label>
                    <a href="#">Anmelden</a>
                </fieldset>
            </form>
        </div>

        <div class="col-7">
            <?php echo '<img id="Mahlzeiten_Bild" class="img-fluid img-thumbnail"
                 src="data:image/jpg;base64,'.$Bild.'" alt="'.$AltText.'">'.PHP_EOL; ?>


        </div>

        <div class="col-2">
            <div class="float-right">
                <aside>
                    <h5><strong>Gast</strong>-Preis</h5>
                    <p style="font-size:45px"><?php echo $preis  ?>&euro;</p>
                    <button type="button" class="btn btn-info" style="position:absolute; bottom:0"><i
                                class="fas fa-utensils"></i> Vorbestellen
                    </button>
                </aside>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row" style="padding:20px">
        <div class="col-3">
            <p>Melden Sie sich jetzt an, um die wirklich viel günstigeren Preise für Mitarbeiter oder Studenten zu
                sehen.</p>
        </div>
        <div class="col-6">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#beschreibung" role="tab" aria-selected="true">Beschreibung</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#zutaten" role="tab" aria-selected="false">Zutaten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#bewertungen" role="tab" aria-selected="false">Bewertungen</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="beschreibung"><?php echo $desc ?></div>
                <div class="tab-pane fade" id="zutaten">

                    <table class="table">

                        <thead>
                        <tr>
                            <th scope="col" class="col-4">Zutaten</th>
                            <th scope="col" class="col-2">Vegan?</th>
                            <th scope="col" class="col-2">Vegetarisch?</th>
                            <th scope="col" class="col-2">Glutenfrei?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = mysqli_query($remoteConnection, " SELECT ZutatenID, z.Name, z.Bio, z.Vegan, z.Vegetarisch, z.Glutenfrei FROM Mahlzeiten m 
                                                        JOIN MalhzeitenEnthaeltZutaten mez ON m.ID = mez.MahlzeitenID 
                                                        JOIN Zutaten z ON mez.ZutatenID = z.ID WHERE m.ID=$ID
                                                        ORDER BY Bio Desc, Name ASC");

                        mysqli_close($remoteConnection);

                        while ($row = mysqli_fetch_assoc($result)) { // Important line !!! Check summary get row on array ..
                            $count=1;
                            if($row['Bio']) $bio = '<img src="img/bio.png"  title="Bio" alt="Bioabzeichen"/>'; else $bio="";
                            if($row['Vegan']) $vegan = "<i class=\"far fa-check-circle\"></i>"; else $vegan="<i class=\"far fa-circle\"></i>";
                            if($row['Vegetarisch']) $vegetarisch = "<i class=\"far fa-check-circle\"></i>"; else $vegetarisch="<i class=\"far fa-circle\"></i>";
                            if($row['Glutenfrei']) $glutenfrei = "<i class=\"far fa-check-circle\"></i>"; else $glutenfrei="<i class=\"far fa-circle\"></i>";

                            echo "<tr>";
                            echo '<td>'.'<a data-toggle="tooltip" data-placement="bottom" title="Suchen Sie nach '.$row['Name'].' im Web"'.
                                ' target=”_blank” href="http://www.google.com/search?q='.$row['Name'].'">'.$row['Name'].'</a>'.$bio.'</td>'
                                .'<td>'.$vegan.'</td>'.'<td>'.$vegetarisch.'</td>'.'<td>'.$glutenfrei.'</td>';
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane fade" id="bewertungen">
                    <br>
                    <form action="http://bc5.m2c-lab.fh-aachen.de/form.php" method="post" target="_self">
                        <label for="benutzer">Benutzername:
                            <input id="benutzer" type="text" name="benutzer" placeholder="Benutzer">
                        </label><br>
                        <label for="mahlzeit">Mahlzeit:
                            <select name="mahlzeit" id="mahlzeit">
                                <option value="falafel">Falafel</option>
                                <option value="sonstiges">To-Be-Added</option>
                            </select>
                        </label> <br>
                        <label for="bewertung">Bewertung:</label>
                        <input type="number" name="bewertung" step="1" id="bewertung" min="1" max="5" value="1">
                        <br>
                        <label for="bemerkung"> Bemerkung: </label><br>
                        <textarea name="bemerkung" rows="5" cols="50" id="bemerkung"></textarea><br>
                        <input class="btn btn-info" type="submit" value="Bewertung absenden">
                        <input type="hidden" name="matrikel" value="3170834"/>
                        <input type="hidden" name="kontrolle" value="abd"/>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer Container -->
<?php
include 'inc/Footer.php'
?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>
