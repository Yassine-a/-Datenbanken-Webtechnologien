<!doctype html>
<html lang="de-de">

<head>
    @include('Partials.Head',['titel'=>"Register"])
</head>

<body>
@include('Partials.Header')
<div class="container">
    <?php

    $fb_list = \Emensa\Model\RegistrierenModel::get_fb();
    ?>
    @if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
        // TO DO if User has "na" Role redirect to registering page
        <h4 class="mt-5 lower_10px_padding" style="text-align: center">Hallo {{$_SESSION['username']}}, Sie sind schon
            angemeldet als '.$_SESSION['role'].'</h4>
    @else
        @if($errore)
            <div class="alert alert-danger m-3 " role="alert">
                Es gab Fehler beim Bearbeitung Ihrer Anfrage:
                <ul>
                    @foreach($msg as $warning)
                        <li> {{$warning}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="py-2 d-flex justify-content-center flex-column" method="post" action="Registrieren.php?id=2">
            <h4 class="mt-5 ">Ihre Benutzerdaten</h4>
            <aside class="text-danger"> @if(false) "Es hat nicht geklapt, bitte versuchen Sie es erneut" @endif </aside>
            <input type="hidden" value="{{$username}}" name="username" />
            <input type="hidden" value="{{$hash}}" name="hash" />
            <div class="form-group row m-3">
                <label for="vorname" class="col-sm-2 col-form-label">Vorname</label>
                <div class="col-sm-10">
                    <input name="vorname" type="text" class="form-control" id="vorname" placeholder="Enter Vorname" maxlength="50" value="{{$vorname or ''}}" required/>
                </div>
            </div>
            <div class="form-group row m-3">
                <label for="nachname" class="col-sm-2 col-form-label">Nachname</label>
                <div class="col-sm-10">
                    <input name="nachname" type="text" class="form-control" id="nachname" placeholder="Enter Vorname" maxlength="50" value="{{$nachname or ''}}" required/>
                </div>
            </div>
            <div class="form-group row m-3">
                <label for="date" class="col-sm-2 col-form-label">Geburtsdatum</label>
                <div class="col-sm-10">
                    <input name="date" type="date" class="form-control" id="date" placeholder="Enter Vorname" maxlength="50" value="{{$gdatum or ''}}" required/>
                </div>
            </div>
            <div class="form-group row m-3">
                <label for="email" class="col-sm-2 col-form-label">E-Mail</label>
                <div class="col-sm-10">
                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter E-Mail" maxlength="50" value="{{$email or ''}}" required/>
                </div>
            </div>
            <h4 class="m-3">Ihr Fachbereich</h4>
            <div class="form-group row m-3">
                <label class="col-sm-2 col-form-label" for="exampleFormControlSelect2">Welchen Fachbereichen gehören Sie an?</label>
                <div class="col-sm-10">
                    <select name="fb_id" multiple class="form-control" id="exampleFormControlSelect2">
                        @foreach($fb_list as $row)
                            @php $var_select=""; @endphp
                            @if ($fb == $row['ID']) @php $var_select = 'selected="selected"'@endphp @endif
                            <option {{$var_select}} value="{{$row['ID']}}">{{$row['NAME']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <h4 class="m-3">Ihre Daten als Mitarbeiter</h4>
            <div class="form-group row m-3">
                <label for="buero" class="col-sm-2 col-form-label">Enter Buero</label>
                <div class="col-sm-10">
                    <input name="buero" type="text" class="form-control" id="buero" placeholder="Enter Buero" maxlength="50" value="{{$buero or ''}}"/>
                </div>
            </div>
            <div class="form-group row m-3">
                <label for="telefone" class="col-sm-2 col-form-label">Enter Telefone</label>
                <div class="col-sm-10">
                    <input name="telefone" type="number" class="form-control" id="telefone" placeholder="Enter Buero" maxlength="50" value="{{$telefone or ''}}"/>
                </div>
            </div>

            <input type="submit" class="btn btn-info m-3 align-self-start" value="Senden"/>
        </form>
    @endif


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
