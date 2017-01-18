<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimePageController extends Controller
{
	public function time(Request $request){

		// SI ON RECUPERE DES DONNEES DEPUIS LE FORMULAIRE ON PREPARE LES DONNEES INITIALES
		$inputs = $request->all();
		if ($inputs) {
			$datasBeforeTri = array();
			$datasBeforeTri = static::dataPrepare($inputs);
	   	//FIN DE LA PREPARATION DES DONNEES INITIALES

	   	// -> EXEC DES TRIS <-//
	   	$results = array();
	   	$results[] = static::execTri('Tri à bulle', $datasBeforeTri, $inputs['nbexec']);
	   	$results[] = static::execTri('Tri par insertion', $datasBeforeTri, $inputs['nbexec']);
	   	$results[] = static::execTri('Tri par selection', $datasBeforeTri, $inputs['nbexec']);

	   	//RETURN
	   	return view('pages.time', compact('datasBeforeTri', 'results'));
		}
	return view('pages.time', compact('datas'));
	}

	public function dataPrepare($inputs){
		$datas = array();
   		if ($inputs["sortway"] == "sorted") {
		   	for ($i=0; $i < $inputs['nb']; $i++){ 
				$datas[] = $i;
	   		}
   		} 
   		else if ($inputs["sortway"] == "inverse") {
		   	for ($i=$inputs['nb']; $i != 0; $i--){ 
				$datas[] = $i;
	   		}
   		}
   		else if ($inputs["sortway"] == "random") {
		   	for ($i=0; $i < $inputs['nb']; $i++){ 
				$datas[] = $i;
	   		}
	   		shuffle($datas);
   		}
   		else if ($inputs["sortway"] == "almost") {
   			$seuil = round(80*$inputs["nb"]/100);
		   	for ($i=0; $i < $seuil; $i++){ 
				$datas[] = $i;
	   		}
		   	for ($i=$seuil; $i < $inputs['nb']; $i++){ 
				$datas[] = random_int($seuil, $inputs["nb"]-1);
	   		}
   		}
   		else if ($inputs["sortway"] == "duplicates") {
		   	for ($i=0; $i < $inputs['nb']; $i++){ 
	   			$seuil = round(80*$inputs["nb"]/100);
			   	for ($i=0; $seuil > count($datas); $i++){ 
					$datas[] = $i;
					$datas[] = $i;
		   		}
			   	for ($i=$seuil; $i < $inputs['nb']; $i++){ 
					$datas[] = $i;
		   		}
		   		shuffle($datas);
	   		}
   		}
   		return $datas;
	}

	public function triBulle($tableau){
	    $tab_en_ordre = false;
	    $taille = count($tableau);
	    while(!$tab_en_ordre)
	    {
	        $tab_en_ordre = true;
	        for($i=0 ; $i < $taille-1 ; $i++)
	        {
	            if($tableau[$i] > $tableau[$i+1])
	            {
            	    $tmp = $tableau[$i];
					$tableau[$i] = $tableau[$i+1];
    				$tableau[$i+1] = $tmp;
	                $tab_en_ordre = false;
	            }
	        }
	        $taille--;
	    }
	    return $tableau;
	}

	public function triInsertion($tableau)
	{
	    for($i = 0; $i < count($tableau); $i++)
	    {
	        $element_a_inserer = $tableau[$i];
	        for($j = 0; $j < $i; $j++)
	        {
	            $element_courant = $tableau[$j];
	            if ($element_a_inserer < $element_courant)
	            {
	                $tableau[$j] = $element_a_inserer;
	                $element_a_inserer = $element_courant;
	            }  
	        }
	        $tableau[$i] = $element_a_inserer;
	    }
	    return $tableau;
	}

	public function triSelection($tableau)
	{
	    $count = count($tableau);
	    for($i=0;$i<$count-1;$i++)
	    {
	        $min = $i;
	        $minV = $tableau[$min];
	        for($j=$i+1;$j<$count;$j++)
	        {
	            if($tableau[$j] < $minV)
	            {
	                $min = $j;
	                $minV = $tableau[$min];
	            }
	        }
	    
	        if($min != $i)
	        {
	            $tableau[$min] = $tableau[$i];
	            $tableau[$i] = $minV;
	        }
	    }
	    return $tableau;
	}

	public function execTri($nomDuTri, $datasInitial, $nbexec){
	   	$time = array();
	   	$datas = array();
   		for ($i=0; $i < $nbexec; $i++) {
   			if($nomDuTri == "Tri par insertion"){
	   			$start = microtime(true);
	   			$datas[] = static::triInsertion($datasInitial);
	    		$time[] = microtime(true) - $start;	
	   		}
	   		if($nomDuTri == "Tri par selection"){
	   			$start = microtime(true);
	   			$datas[] = static::triSelection($datasInitial);
	    		$time[] = microtime(true) - $start;
	   		}
	   		if($nomDuTri == "Tri à bulle"){
		   		$start = microtime(true);
	   			$datas[] = static::triBulle($datasInitial);
	    		$time[] = microtime(true) - $start;
	   		}
	   	}
	   	$average = array_sum($time) / count($time); 
	   	return array('name' => $nomDuTri, 'data' => $datas[0], 'debugtime' => $time, 'Average time' => $average);
	}
}

