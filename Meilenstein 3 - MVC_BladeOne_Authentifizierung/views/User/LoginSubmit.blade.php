<!doctype html>
<html lang="de-de">

<head>
    @include('Partials.Head',['titel'=>"Log-In"])
</head>

<body>
@include('Partials.Header')
<div class="container">

    <div class="container" align="center">
        @if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
            <h4 class="mt-5 lower_10px_padding" style="text-align: center">{{$message}}</h4>
        @endif
        @if(isset($_SESSION['logged_in']) & $_SESSION['logged_in'])
                <a href="logout.php" class="btn btn-info m-3 align" style="text-align:center">Logout</a>
        @endif
    </div>
</div>
@include("Partials.Footer")
</body>

</html>