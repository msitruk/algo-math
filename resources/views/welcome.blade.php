@extends('layout')

@section('content')
	<style>
		.col-homepage {
			margin-left: 25%;
    		margin-top: 7%;
		}
        /*.panel-homepage {
            border: 1px solid #dddddd;
            border-radius: 4px;
            padding: 18px;
        }*/
        .panelbody-homepage {
        	padding-top: 5px;
    		padding-left: 20px;
        }
    </style>
    <div class="row">
    	<div class="col-md-6 col-homepage">
			<div class="panel panel-default panel-homepage">
			  <div class="panel-body panelbody-homepage">
			    <h3>Bienvenue sur AlgoStats</h3>
			     <p>Cette application permet de comparer entre eux les principaux algorithmes de tri 
			     	en quantifiant le temps et le coût de chacun.<p>
			  </div>
			</div>
		</div>
	</div>
@stop