<!doctype html>
<?php require __DIR__ . '/vendor/autoload.php'; ?>
<html lang="de-de">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="./StyleSheet.css" rel="stylesheet" />
    <?php
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

    $result=mysqli_query($remoteConnection,"SELECT COUNT(*) FROM Zutaten");
    $row = mysqli_fetch_assoc($result);
    $total = $row['COUNT(*)'];
    ?>

    <title>Zutatenliste (<?php echo $total?>)</title>
</head>

<body>
<?php
$PAGE='start';
include 'inc/navbar.php'
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <table class="table">

                <thead>
                <tr>
                    <?php


                    if (!$remoteConnection) {
                        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
                        exit();
                    }

                    $result=mysqli_query($remoteConnection,"SELECT COUNT(*) FROM Zutaten");
                    $row = mysqli_fetch_assoc($result);
                    $total = $row['COUNT(*)'];

                    echo '<th scope="col" class="col-4">Zutaten</th>';
                    ?>

                    <th scope="col" class="col-2">Vegan?</th>
                    <th scope="col" class="col-2">Vegetarisch?</th>
                    <th scope="col" class="col-2">Glutenfrei?</th>
                </tr>
                </thead>
                <tbody>
                <?php
                //  <th scope="col" class="col-2">Bio?</th> '<td>'.$bio.'</td>'
                $query="SELECT ID, Name, Bio, Vegan, Vegetarisch, Glutenfrei FROM Zutaten ORDER BY Bio Desc, Name ASC";
                $result = mysqli_query($remoteConnection, $query);
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
    </div>
</div>


<?php
include 'inc/Footer.php'
?>
</body>

</html>