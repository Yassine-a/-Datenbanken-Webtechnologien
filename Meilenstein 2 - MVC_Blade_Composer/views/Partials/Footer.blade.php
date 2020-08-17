
<footer>
    <div class="container footer">
        <div class="row">
            <div class="col-3">
                <p>(c) <?php
                    $currentDateTime = date('d.m.Y');
                    echo $currentDateTime;
                    ?> DBWT</p>
            </div>
            <div class="col-sm-9">
                <ul class="nav">
                    <li class="nav-item ">
                        <?php if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']) echo '<a class="nav-link active" href="logout.php">Log Out</a>';
                        else echo '<a class="nav-link active" href="login.php">Login</a>';?>
                    </li>
                    <?php if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']) ;
                    else echo '<li class="nav-item">
                        <a class="nav-link" href="Registrieren.php">Registrieren</a>
                    </li>';
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Zutaten.php">Zutatenliste</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="impressum.html">Impressum</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</footer>