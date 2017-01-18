@extends('layout')

@section('content')
    <div class="container">
        <h1>Moyenne du temps de calcul par tri</h1>

        <form method="GET">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nb">Nombre d'élements dans le tableau : </label>
                    </div>
                    <div class="col-md-6">
                        <select name="nb">
                            <option value="10">10</option>
                            <option value="100">100</option>
                            <option value="1000">1000</option>
                            <option value="10000">10000</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="sortway">Agencement initial des données de la série : </label>
                    </div>
                    <div class="col-md-6">
                        <select name="sortway">
                            <option value="sorted">Déjà triée</option>
                            <option value="inverse">Triée en sens inverse</option>
                            <option value="random">Total random</option>
                            <option value="almost">Quasiment-triée</option>
                            <option value="duplicates">Bcp de doublons et qq uniques</option>
                            {{-- une moyenne des séries citées ci-dessus --}}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="nbexec">Nombre d'executions : </label>
                    </div>
                    <div class="col-md-6">
                        <input type="number" name="nbexec" value="1" min="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" name="Go">
                    </div>
                </div>
            </div>
        </form>

        @if (isset($datasBeforeTri))
            @foreach ($results as $result)
                <h2>{{ $result["name"] }}</h2>
                {{-- <p>{{ $result["data"] }}</p> --}}
{{--                 <p>
                    @foreach ($result["data"] as $data)
                        {{ $data }} 
                    @endforeach
                </p> --}}
                <p>
                Temps moyen d'exécution : 
                    @if (strstr($result["Average time"], 'E'))
                        {{ sprintf('%.15F',$result["Average time"]) }} / 
                    @endif
                    {{ $result["Average time"] }}
                </p>
            @endforeach
            <h2>Datas avant le tri :</h2>
            <p>
                @foreach ($datasBeforeTri as $data)
                    {{ $data }} 
                @endforeach
            </p>
            <h2>Datas après le tri :</h2>
            {{-- <p>{{ print_r($results, true) }}</p> --}}
            <p>
                @foreach ($result["data"] as $data)
                    {{ $data }} 
                @endforeach
            </p>
        @endif
    </div>
@stop