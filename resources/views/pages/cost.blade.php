@extends('layout')

@section('content')
    <style>
        .col-timepage {
            margin-left: 11.5%;
            margin-top: 1%;
            margin-bottom: 1%;

        }
        .panel-footer {
            background-color: #fafafa;
        }
        .box-algo {
            margin-bottom: 8px;
        }
        .checkbox-algo {
            padding-left: 20px;
        }
        a#allAlgo {
            margin-left: 10px;
        }
        .panelheading-timepage,
        .panelheading-algo,
        .panelheading-graphics,
        .panelheading-before,
        .panelheading-after {
            padding-top: 3px;
        }
        .col-algo, .col-graphics,
        .col-databefore, .col-dataafter {
            margin-left: 5%;
        }
        .result-algo {
            padding-left: 15px;
        }
        .btn-before {
            float: right;
            position: relative;
            top: -33px;
        }
    </style>
    <div class="row">
        <div class="col-md-9 col-timepage">
            <div class="panel panel-default panel-timepage">
                <div class="panel-heading panelheading-timepage">
                    <h4><i class="fa fa-percent" aria-hidden="true"></i> Moyenne du temps de calcul par tri</h4>
                </div>
                <form method="GET">
                    <div class="panel-body">
                        <div class="container">
                            <div class="box-algo">
                                <label for="algo">Algorithmes à trier : </label><br />
                                <div class="checkbox-algo">
                                    <label class="checkbox-inline"><input name="algo[]" type="checkbox" value="Tri à bulle">Tri à bulle</label>
                                    <label class="checkbox-inline"><input name="algo[]" type="checkbox" value="Tri par insertion">Tri par insertion</label>
                                    <label class="checkbox-inline"><input name="algo[]" type="checkbox" value="Tri par selection">Tri par selection</label>
                                    <label class="checkbox-inline"><input name="algo[]" type="checkbox" value="Tri par fusion">Tri par fusion</label>
                                    <label class="checkbox-inline"><input name="algo[]" type="checkbox" value="Tri rapide">Tri rapide</label>
                                    <label class="checkbox-inline"><input name="algo[]" type="checkbox" value="Tri à peigne">Tri à peigne</label>
                                    <label class="checkbox-inline"><input name="algo[]" type="checkbox" value="Tri de shell">Tri de shell</label>
                                    <a class="btn btn-default btn-sm" id="allAlgo">Tout trier</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="nb">Nombre d'élements dans le tableau : </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="nb">
                                        <option value="10">10</option>
                                        <option value="100">100</option>
                                        <option value="1000">1000</option>
                                        <option value="10000">10000</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="sortway">Agencement initial des données de la série : </label>
                                </div>
                                <div class="col-md-8">
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
                                <div class="col-md-4">
                                    <label for="nbexec">Nombre d'executions : </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="nbexec" value="1" min="1">
                                </div>
                            </div>
                           <!--  <div class="row">
                                <div class="col-md-12">
                                    <input class="btn btn-default btnValidate" type="submit" name="Go">
                                </div>
                            </div> -->
                        </div>   
                    </div>
                    <div class="panel-footer">
                        <input class="btn btn-default btn-block btnValidate" type="submit" name="Go">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-algo">
            <div class="panel panel-default">
                <div class="panel-heading panelheading-algo">
                    <h4><i class="fa fa-balance-scale" aria-hidden="true"></i> Algorithmes</h4>
                    <a class="btn btn-default btn-before" data-toggle="collapse" href="#collapse-algo" 
                    aria-expanded="false" aria-controls="collapse-algo"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>
                <div class="panel-body collapse in" id="collapse-algo">
                    @if (isset($datasBeforeTri))
                        @foreach ($results as $result)
                            <h5><span class="label-algo">{{ $result["name"] }}</span></h5>
                            <p class="result-algo">
                                Cout d'exécution : <span class="value-algo">{{ $result["cost"] }}</span>
                            </p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-5 col-graphics">
            <div class="panel panel-default">
                <div class="panel-heading panelheading-graphics">
                    <h4><i class="fa fa-bar-chart" aria-hidden="true"></i> Graphiques</h4>
                    <a class="btn btn-default btn-before" data-toggle="collapse" href="#collapse-graphics" 
                    aria-expanded="false" aria-controls="collapse-graphics"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>
                <div class="panel-body collapse in" id="collapse-graphics">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-databefore">
            <div class="panel panel-default">
                <div class="panel-heading panelheading-before">
                    <h4><i class="fa fa-database" aria-hidden="true"></i> Data avant le tri</h4>
                    <a class="btn btn-default btn-before" data-toggle="collapse" href="#collapse-before" 
                    aria-expanded="false" aria-controls="collapse-before"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>
                <div class="panel-body collapse" id="collapse-before">
                    @if (isset($datasBeforeTri))
                        <h5>Datas avant le tri :</h5>
                        <p>
                            @foreach ($datasBeforeTri as $data)
                                {{ $data }} 
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-5 col-dataafter">
            <div class="panel panel-default">
                <div class="panel-heading panelheading-after">
                    <h4><i class="fa fa-database" aria-hidden="true"></i> Data après le tri</h4>
                    <a class="btn btn-default btn-before" data-toggle="collapse" href="#collapse-after" 
                    aria-expanded="false" aria-controls="collapse-after"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>
                <div class="panel-body collapse" id="collapse-after">
                    @if (isset($datasBeforeTri))
                        <h5>Datas après le tri :</h5>
                        {{-- <p>{{ print_r($results, true) }}</p> --}}
                        <p>
                            @foreach ($result["data"] as $data)
                                {{ $data }} 
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop