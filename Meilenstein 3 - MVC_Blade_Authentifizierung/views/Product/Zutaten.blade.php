<!doctype html>
<html lang="de-de">

<head>
@include('Partials.Head',['page'=>$titel])

</head>

<body>
@include('Partials.Header')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
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
                @foreach($sorted_list as $row)
                    <tr>
                        <td>
                            <a data-toggle="tooltip" data-placement="bottom" title="Suchen Sie nach {{ $row['Name'] }} im Web"
                            target=”_blank” href="http://www.google.com/search?q= {{ $row['Name']}}"> {{$row['Name']." "}}
                            @if($row['Bio']) <img src="img/bio.png"  title="Bio" alt="Bioabzeichen"/> @endif </a>
                        </td>
                        <td>@if($row['Vegan']) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif</td>
                        <td>@if($row['Vegetarisch']) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif</td>
                        <td>@if($row['Glutenfrei']) <i class="far fa-check-circle"></i> @else <i class="far fa-circle"></i> @endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@include("Partials.Footer")
</body>

</html>