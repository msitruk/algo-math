<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CostPageController extends Controller
{
	public function cost(Request $request){

		// SI ON RECUPERE DES DONNEES DEPUIS LE FORMULAIRE ON PREPARE LES DONNEES INITIALES
		$inputs = $request->all();
		if ($inputs) {
			$datasBeforeTri = array();
			$datasBeforeTri = static::dataPrepare($inputs);
	   	//FIN DE LA PREPARATION DES DONNEES INITIALES

	   	// -> EXEC DES TRIS <-//
            $results = array();
            foreach ($request['algo'] as $key => $value) {
                $results[] = static::execTri($value, $datasBeforeTri);
            }




            //$results[] = static::execTri('Tri de shell', $datasBeforeTri, $inputs['nbexec']);

	   	//RETURN
	   	return view('pages.cost', compact('datasBeforeTri', 'results'));
		}
	return view('pages.cost', compact('datas'));
	}

	public function execTri($nomDuTri, $datasInitial){
		$datas[] = static::triRapideReturn($datasInitial);
	   	$time = array();
	   	$cost = 0;
	   	$datas = array();
		if($nomDuTri == "Tri par insertion"){
   			$cost = static::triInsertion($datasInitial);
   		}
   		if($nomDuTri == "Tri par selection"){
   			$cost = static::triSelection($datasInitial);
   		}
   		if($nomDuTri == "Tri à bulle"){
   			$cost = static::triBulle($datasInitial);
   		}
        if($nomDuTri == "Tri par fusion"){
            $cost = static::triFusion($datasInitial);
        }
        if($nomDuTri == "Tri rapide"){
            $cost = static::triRapide($datasInitial);
        }
        if($nomDuTri == "Tri à peigne"){
            $cost = static::triPeigne($datasInitial);
        }
        if($nomDuTri == "Tri de shell"){
            $cost = static::triShell($datasInitial);
        }
	   	return array('name' => $nomDuTri, 'data' => $datas, 'cost' => $cost);
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
	    return $i;
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
	    return $j;
	}

	public function triSelection($tableau)
	{
		$cost = 0;
	    $count = count($tableau);
	    for($i=0;$i<$count-1;$i++)
	    {
	        $min = $i;
	        $minV = $tableau[$min];
	        for($j=$i+1;$j<$count;$j++)
	        {
	        	$cost++;
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
	    return $cost;
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
        return $i;
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

    public function triRapideReturn($tableau)
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
        return array_merge(static::triRapideReturn($left), array($pivot_key => $pivot), static::triRapideReturn($right));
    }

    public function triRapide($tableau)
    {
    	$cost = 0;
        if( count( $tableau ) < 2 ) {
            return $tableau;
        }
        $left = $right = array( );
        reset( $tableau );
        $pivot_key  = key( $tableau );
        $pivot  = array_shift( $tableau );
        foreach( $tableau as $k => $v ) {
        	$cost++;
            if( $v < $pivot )
                $left[$k] = $v;
            else
                $right[$k] = $v;
        }
        $tableau = array_merge(static::triRapideReturn($left), array($pivot_key => $pivot), static::triRapideReturn($right));
        return $cost;
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
        return $i;
    }

    public function triShell($my_array)
    {
    	$cost = 0;
        $x = round(count($my_array)/2);
        while($x > 0)
        {
            for($i = $x; $i < count($my_array);$i++){
                $temp = $my_array[$i];
                $j = $i;
                while($j >= $x && $my_array[$j-$x] > $temp)
                {
                	$cost++;
                    $my_array[$j] = $my_array[$j - $x];
                    $j -= $x;
                }
                $my_array[$j] = $temp;
            }
            $x = round($x/2.2);
        }
        return $cost;
    }

}

