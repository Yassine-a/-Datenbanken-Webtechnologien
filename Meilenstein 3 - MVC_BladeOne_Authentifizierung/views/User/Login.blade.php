<!doctype html>
<html lang="de-de">

<head>
    @include('Partials.Head',['titel'=>"Log-In"])
</head>

<body>
@include('Partials.Header')
<div class="container">
    @if(!isset($_SESSION['logged_in']) || (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==false))
        <h2 class="text-uppercase mt-5 sign-in" style="text-align: center">Sign In</h2>
        <form class="py-2 d-flex justify-content-center flex-column" method="post" action="Login.php">
            <aside class="alert alert-success" role="alert">@if(isset($msg)) {{$msg}} @endif</aside>
            <aside @if($flag) class="alert alert-danger" role="alert"@endif>@if($flag) Es hat nicht geklapt, bitte versuchen Sie es erneut @endif</aside>
            <div class="form-group m-3">
                <label for="username" @if($flag) class="p-3 mb-2 bg-danger text-dark"@endif>Username</label>
                <input name="username" type="text" class="form-control" @if($flag) style="border:1px solid red"
                       @endif
                       id="username" placeholder="Enter Username" maxlength="50" required/></div>
            <div class="form-group m-3">
                <label for="password" @if($flag) class="p-3 mb-2 bg-danger text-dark" @endif>Password</label>
                <input name="password" type="password" class="form-control" @if($flag)style="border:1px solid red"
                       @endif
                       id="password" placeholder="Enter Password" maxlength="50" required/></div>
            <input type="hidden" id="submit" name="submit" value="true">
            <input type="submit" class="btn btn-primary m-3 align-self-end" value="Sign In"/>
        </form>
    @else
        <div class="container" align="center">
        <h4 class="mt-5 lower_10px_padding">Hallo {{$_SESSION['username']}}, Sie sind
            angemeldet als {{$_SESSION['role']}}</h4>
        <a href="logout.php" class="btn btn-info m-3 align">Logout</a>
        </div>
    @endif

</div>
@include("Partials.Footer")
</body>

</html>