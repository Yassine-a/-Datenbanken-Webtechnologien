<!doctype html>
<html lang="de-de">

<head>
    @include('Partials.Head',['titel'=>$titel])
</head>

<body>
@include('Partials.Header')
<div class="container">
    <div class="row">
        <div class="col" id="avaiableS">
            <h1 class="text-center">Verfügbare Speisen ({{$titel2}})</h1>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form id="product-list" class="w-100" action="Produkte.php" method="get" target="_self">
                <fieldset>
                    <legend>Speisenliste filtern</legend>
                    @php $Row_Nu = 1;
                    $Col_Nu = 0;
                    $Akt_Row = 0;
                    $currentParent = "";
                    @endphp
                    <select name="kat">'
                        <optgroup label="Generell">
                            <option value="alle">Alle zeigen</option>
                        </optgroup>
                        @foreach($catagory_list as $row)
                        @if ($currentParent != $row["PB"])
                            @if ($currentParent != "") </optgroup> @endif
                            <optgroup label='{{ $row["PB"] }}'>
                                @php $currentParent = $row["PB"]@endphp
                        @endif
                            @php $var_select = ""@endphp
                            @if ($current_category == $row["CID"]) @php $var_select = 'selected="selected"'@endphp @endif
                            <option {{$var_select}} value='{{$row["CID"]}}'> {{$row["CB"]}}  </option>

                            @endforeach
                        </optgroup>
                    </select>
                    <br/>
                    <br/>
                    <label for="avaiable"><input type="checkbox" name="avail" value="1" id="avaiable"
                                                 @if ($Avail)  checked='checked' @endif> &nbsp;nur verfügbare</label>
                    <label for="vegetarian"><input type="checkbox" name="vegetarisch" value="true" id="vegetarian"
                                                   @if ($vegetarisch)  checked='checked'@endif> nur vegetarisch</label>
                    <label for="vegan"> <input type="checkbox" name="vegan" value="true" id="vegan"
                                               @if ($vegan)  checked='checked'@endif>&nbsp;nur vegane</label><br><br/>
                    <button class="btn btn-info" type="submit">Speisen filtern</button>
                </fieldset>
            </form>
        </div>
        <div class="col-9" style="text-align:center">

            @if (count($sorted_list) == 0) <h3> Leider wurde nichts gefunden </h3>
            @else
                @foreach($sorted_list as $row)
                    @if($vegan && !$row['Vegan']) @continue @endif
                    @if ($vegetarisch && !$row['Vegetarisch']) @continue @endif
                    @php
                        $name = $row['Name'];
                        $available = $row['Verfuegbar'];
                        $ID = $row['ID'];
                        $Bild = $row['Binaerdaten'];
                        $AltText = $row['Alt-Text'];
                    @endphp

                    {{-- Prüfe ob eine neue Zeile bzw Row ausgegeben sollte --}}
                    @if ($Row_Nu != $Akt_Row)
                        <div class="row lower_10px_padding">  @php$Akt_Row = $Row_Nu;@endphp
                            @endif
                            {{-- Fallunterscheidung, falls $available = 0 dann zeige es als vergriffen --}}
                            @if($available)
                            <div class="col-sm-2">
                                <img class="smallImg  img-thumbnail" src="data:image/jpg;base64, {{$Bild}}"
                                     alt="{{$AltText}}">
                                <h5>{{$name}} </h5>
                                <a target="_self" href="Detail.php?id= {{$ID}}">Details</a>
                            </div>
                            @else
                                <div class="col-sm-2">
                                    <img class="smallImg img-thumbnail" src="data:image/jpg;base64,{{$Bild}}"
                                         alt="{{$AltText}}">
                                    <h5>{{$name}} </h5>
                                    <a target="_self" class="btn disabled"
                                       href="Detail.php?id={{$ID}}">vergriffen</a>'
                                </div>
                            @endif
                            @php $Col_Nu++;@endphp
                            @if ($Col_Nu % 4 == 0)
                                @php ++$Row_Nu;
                                $Col_Nu = 0;
                                @endphp
                        </div>
                    @endif
                @endforeach
            @endif

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
