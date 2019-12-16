<?php

require_once("bd_connect.php");
require_once("function.php");

if (isset($_POST["sub"])){
	$eGlobal = false;

	if(isset($_POST['email'])){
   		$mail = htmlspecialchars($_POST['email']);
   		$req2 = "SELECT Email FROM user WHERE Email ="."'".$mail."'";
   		$res2 = $GLOBALS['db']->query($req2);
   		$mailFind=($res2->num_rows);
   		
   		if ( $mailFind == 0) {
   			echo '<p class="echo_err">Une erreur est survenue merci de recommencer</p>';
   			$eGlobal = true;
   		}

   	if($eGlobal == false) {

    $generation = chaineLongAleatoire(8);
		}
		//echo $generation;

		$pwd = password_hash($generation, PASSWORD_DEFAULT);
   		$mail = htmlspecialchars($_POST['email']);

   		$req = "UPDATE USER SET `PWD-4`=`PWD-3`,`PWD-3`=`PWD-2`,`PWD-2`=`PWD-1`,`PWD-1`=`PWD`,`PWD`="."'".$pwd."'".", PassLost = '1' WHERE`EMAIL`="."'".$mail."'";
   		$res = $GLOBALS['db']->query($req);
		
		if(!$GLOBALS['db']->errno){ // si pas d'érreur alors

		$to = $mail;
  		$subject = "Mot de passe transitoire";
  		$message = '

  		Bonjour,

  		Voici votre mot de passe transitoire, il vous sera demandé de le changer lors de votre prochaine connexion.
  		Mot de passe ->'.$generation.'
        	
  		-------------
  		Ceci est un mail automatique, merci ne de pas y repondre.';

  		$header = "From: nomTest <test@test.com>";

  		mail($to, $subject, $message, $header);

  		header('Location:http://127.0.0.1/chat/form_connection.php');
  		exit();
		}
	}
}


?>

<GLOBALS['db'] href="style.css" rel="stylesheet">
<h1> Récupération mot de passe </h1>
<form action ="" method="post">

<label for="email"> Entrez le mail que vous avez utilisé lors de votre inscription : </label><br/>
<input type="mail" name="email" placeholder="exemple@ex.com" required="required" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$"><br/>

<input type="submit" value="valider" name="bouton">
<input type="hidden" name="sub" value="1">

</form>