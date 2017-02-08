<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimePageController extends Controller
{
	public function time(Request $request){

		// SI ON RECUPERE DES DONNEES DEPUIS LE FORMULAIRE ON PREPARE LES DONNEES INITIALES
		$inputs = $request->all();
        var_dump($request['algo']);
		if ($inputs) {
			$datasBeforeTri = array();
			$datasBeforeTri = static::dataPrepare($inputs);
	   	//FIN DE LA PREPARATION DES DONNEES INITIALES

	   	// -> EXEC DES TRIS <-//
            $results = array();
            // if (in_array('0', $request['algo'])) {
            //     $results[] = static::execTri('Tri à bulle', $datasBeforeTri, $inputs['nbexec']);
            // }
            // if (in_array('1', $request['algo'])) {
            //     $results[] = static::execTri('Tri par insertion', $datasBeforeTri, $inputs['nbexec']);
            // }
            // if (in_array('2', $request['algo'])) {
            //     $results[] = static::execTri('Tri par selection', $datasBeforeTri, $inputs['nbexec']);
            // }
            // if (in_array('3', $request['algo'])) {
            //     $results[] = static::execTri('Tri par fusion', $datasBeforeTri, $inputs['nbexec']);
            // }
            // if (in_array('4', $request['algo'])) {
            //     $results[] = static::execTri('Tri rapide', $datasBeforeTri, $inputs['nbexec']);
            // }
            // if (in_array('5', $request['algo'])) {
            //     $results[] = static::execTri('Tri à peigne', $datasBeforeTri, $inputs['nbexec']);
            // }
            foreach ($request['algo'] as $key => $value) {
                $results[] = static::execTri($value, $datasBeforeTri, $inputs['nbexec']);
            }




            //$results[] = static::execTri('Tri de shell', $datasBeforeTri, $inputs['nbexec']);

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

    public function triFusion($tableau)
    {
        if( count( $tableau ) <= 1 ) return;
        else {
            $tab1 = array();
            $tab2 = array();

            // Répartie les information dans 2 tableaux différent
            for( $i = 0; $i < count( $tableau ); $i++) {
                if( $i < ( count( $tableau ) ) / 2 )
                    $tab1[] = $tableau[ $i ];
                else
                    $tab2[] = $tableau[ $i ];
            }

            // Appel la fonction tri récursivement
            static::triFusion( $tab1 );
            static::triFusion( $tab2 );

            // Fusionne les petits tableaux en plus grand
            static::fusionner( $tab1, $tab2, $tableau );
        }
        return $tableau;
    }

    public function fusionner ( $tab1, $tab2, &$tab )
    {
        $i = 0;
        $i1 = $i2 = 0;
        // Fusionne les petits tableaux dans le plus grand
        while( $i1 < count( $tab1 ) && $i2 < count( $tab2 ) ) {
            if( $tab1[ $i1 ] < $tab2[ $i2 ] ) // On compare ici
                $tab[ $i ] = $tab1[ $i1++ ];
            else
                $tab[ $i ] = $tab2[ $i2++ ];
            $i++;
        }

        // S'il reste des éléments dans un des 2 tableaux mais pas dans l'autre
        while( $i1 < count( $tab1 ) ) {
            $tab[ $i ] = $tab1[ $i1++ ];
            $i++;
        }
        while( $i2 < count( $tab2 ) ) {
            $tab[ $i ] = $tab2[ $i2++ ];
            $i++;
        }
    }

    public function triRapide($tableau)
    {
        if( count( $tableau ) < 2 ) {
            return $tableau;
        }
        $left = $right = array( );
        reset( $tableau );
        $pivot_key  = key( $tableau );
        $pivot  = array_shift( $tableau );
        foreach( $tableau as $k => $v ) {
            if( $v < $pivot )
                $left[$k] = $v;
            else
                $right[$k] = $v;
        }
        return array_merge(static::triRapide($left), array($pivot_key => $pivot), static::triRapide($right));
    }


    public function triPeigne($tableau)
    {
        $gap = count($tableau);
        $swap = true;
        while ($gap > 1 || $swap){
            if($gap > 1) $gap /= 1.25;
            $swap = false;
            $i = 0;
            while($i+$gap < count($tableau)){
                if($tableau[$i] > $tableau[$i+$gap]){
                    list($tableau[$i], $tableau[$i+$gap]) = array($tableau[$i+$gap],$tableau[$i]);
                    $swap = true;
                }
                $i++;
            }
        }
        return $tableau;
    }

    public function triShell($tableau)
    {
        $gap = floor(count($tableau)/2);
        while ($gap > 0) {
            for ($i = 0; $i < count($tableau)-$gap; ++$i) {
                $arrWithGapsKeys = array();
                $arrWithGaps = array();
                $loop = true;
                $j = $i;
                while ($loop) {
                    if (isset($tableau[$j])) {
                        $arrWithGapsKeys[] = (int)$j;
                        $arrWithGaps[] = $tableau[$j];
                        $j += $gap;
                    } else {
                        $loop = false;
                    }
                }
                $arrWithGapsOrdered = static::triInsertion($arrWithGaps);
                foreach ($arrWithGapsKeys as $key) {
                    $arr[$key] = current($arrWithGapsOrdered);
                    next($arrWithGapsOrdered);
                }
            }
            $gap = floor($gap/2);
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
            if($nomDuTri == "Tri par fusion"){
                $start = microtime(true);
                $datas[] = static::triFusion($datasInitial);
                $time[] = microtime(true) - $start;
            }
            if($nomDuTri == "Tri rapide"){
                $start = microtime(true);
                $datas[] = static::triRapide($datasInitial);
                $time[] = microtime(true) - $start;
            }
            if($nomDuTri == "Tri à peigne"){
                $start = microtime(true);
                $datas[] = static::triPeigne($datasInitial);
                $time[] = microtime(true) - $start;
            }
            if($nomDuTri == "Tri de shell"){
                $start = microtime(true);
                $datas[] = static::triShell($datasInitial);
                $time[] = microtime(true) - $start;
            }
	   	}
	   	$average = array_sum($time) / count($time);
        //$average = array_sum($time) / count($time;
	   	return array('name' => $nomDuTri, 'data' => $datas[0], 'debugtime' => $time, 'Average time' => $average);
	}
}

