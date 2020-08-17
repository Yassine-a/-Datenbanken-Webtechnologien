<!doctype html>
<html lang="de-de">

<head>
    @include('Partials.Head',['titel'=>$titel])
</head>

<body>
@include('Partials.Header')
<div class="container">
    <div class="row">
        <div class="col-3">
            <!--empty space-->
        </div>
        <div class="col-9" id="avaiableS">
            <h1>Details für "{{$details['Name']}}"</h1>
            <br/>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        @if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in'])
            <div class="col-3" style="text-align: center;">
            <h4 class="mt-5 lower_10px_padding" >"Hallo "{{$_SESSION['username']}}, Sie sind angemeldet als {{$_SESSION['role']}}</h4>
            <a href="logout.php" class="btn btn-info m-3 align" >Logout</a>
            </div>
        @else
            <div class="col-3">
                <form method="post" action="LoginSubmit.php">
                    <fieldset>
                        <legend>Login</legend>
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username"
                               placeholder="Enter Username" maxlength="50" required/>
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Enter Password" maxlength="50" required/>
                        <input name="submit" type="submit" class="btn btn-info m-2 align-self-end" value="Sign In"/>
                    </fieldset>
                </form>
            </div>
        @endif

        <div class="col-7">
            <img id="Mahlzeiten_Bild" class="img-fluid img-thumbnail"
                 src="data:image/jpg;base64,{{$details['Binaerdaten']}}" alt="{{$details['Alt-Text']}}">

        </div>

        <div class="col-2">
            <div class="float-right">
                <aside>
                    <h5><strong>{{$GSM}}</strong>-Preis</h5>
                    <p style="font-size:45px">{{$details['Preis']}}&euro;</p>
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
            @if(!isset($_SESSION['logged_in']) || (!isset($_SESSION['logged_in'])&&!$_SESSION['logged_in']))
                <p> Melden Sie sich jetzt an, um die wirklich viel günstigeren Preise für Mitarbeiter oder Studenten zu
                    sehen.</p>
            @endif
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
                <div class="tab-pane fade show active" id="beschreibung">{{$details['Beschreibung']}}</div>
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
                        @foreach($zutaten as $row)
                            <tr>
                                <td>
                                    <a data-toggle="tooltip" data-placement="bottom"
                                       title="Suchen Sie nach {{ $row['Name'] }} im Web"
                                       target=”_blank”
                                       href="http://www.google.com/search?q= {{ $row['Name']}}"> {{$row['Name']}}
                                    </a>
                                        @if($row['Bio']) <img src="../img/bio.png" title="Bio" alt="Bioabzeichen"/> @endif

                                </td>
                                <td>@if($row['Vegan']) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif</td>
                                <td>@if($row['Vegetarisch']) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif</td>
                                <td>@if($row['Glutenfrei']) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif</td>
                            </tr>
                        @endforeach
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
@include("Partials.Footer")
</body>

</html>
