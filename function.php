<?php

function scriptLess($entre){
	$entre = preg_replace ( '/<script(.*)>(.*)<\/script>/isU', null, $entre );
	return $entre;
}
//echo scriptLess('Je suis un vilain <strong>H4ck3r</strong>, et je vais <script>alert("pirater");</script> ton site et tu vas <script>alert("pleurer ta mère");</script>');




function chaineLongAleatoire($nbrCar){
	$chaine = "azertyuiopqsdfghjklmwxcvbn123456789AZERTYUIOPQSDFGHJKLMWXCVBN!,?#-_";
	$nbLettre = strlen($chaine)-1;
	$generation ="";

	for($i=0; $i<$nbrCar; $i++){
		$pos = mt_rand(0,$nbLettre);
		$car = $chaine[$pos];
		$generation .= $car;	
	}
	return $generation;
}
//$generation = chaineLongAleatoire(8);


