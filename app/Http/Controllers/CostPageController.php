<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CostPageController extends Controller
{
    public function cost(Request $request){
	   	$inputs = $request->all();
	   	if ($inputs) {
		   	for ($i=0; $i < $inputs['nb']; $i++){ 
				$datas[] = random_int(0, 1000);
		   	}
		   	$datasBeforeTri = $datas;
		   	$tri = static::triBulle($datas);
		   	return view('pages.cost', compact('datasBeforeTri', 'tri'));
	   	}
	    return view('pages.cost', compact('datas'));
	}
}
