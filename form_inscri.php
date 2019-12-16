<?php
require_once("bd_connect.php"); // connection à la base de donnée 

if (isset($_POST["sub"])){
	$eGlobal = false;

   	if ($_POST['mdp'] != $_POST['mdp1']) {
   		echo '<p class="echo_err">Les mots de passe ne sont pas identiques</p>';
   		echo "<br>"; 
   		$eGlobal = true;
   		}

   	if(isset($_POST['login'])){
   		$log1 = $_POST['login'];
   		$req1 = "SELECT LOGIN FROM user WHERE LOGIN ="."'".$log1."'";
   		$res1 = $GLOBALS['db']->query($req1);
   		$pseudoFree=($res1->num_rows);
   		
   		if ($pseudoFree != 0) {
   			echo '<p class="echo_err">Votre login est déjà utilisé par un membre</p>';
   			echo "<br>";
   			$eGlobal = true;
   		}
   	}

   	  if (strlen($_POST['login']) < 3 || strlen($_POST['login']) > 15){
        echo '<p class="echo_err">Votre login est soit trop grand, soit trop petit</p>';
        echo "<br>";
       	$eGlobal = true;
       }


    if(isset($_POST['email'])){
   		$mail = $_POST['email'];
   		$req2 = "SELECT Email FROM user WHERE Email ="."'".$mail."'";
   		$res2 = $GLOBALS['db']->query($req2);
   		$mailFree = ($res2->num_rows);
   		
   		if ( $mailFree != 0) {
   			echo '<p class="echo_err">Votre mail est déjà dans notre base de donnée</p>';
   			echo "<br>";
   			$eGlobal = true;
   		}
   	}
   	

   	if($eGlobal == false) {//s'il n'y a pas d'erreur niveaux du formulaire
   								
  		$login =htmlspecialchars($_POST['login']);
  		//echo $login;
  		//echo " ";
  		$email =htmlspecialchars($_POST['email']);
  		$pwd = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
  		$valid = password_hash($_POST['login'], PASSWORD_DEFAULT);
  		$date = $_SERVER['REQUEST_TIME'];

  		$reqI = "INSERT INTO user ( `Email`, `LOGIN`, `PWD`, `DATE`, `VALIDATION`) VALUES ("."'".$email."', '".$login."', '".$pwd."', '".$date."', '".$valid."')";
  		$GLOBALS['db']->query($reqI);

		if(!$GLOBALS['db']->errno){
			echo '<p class="echo">Votre inscription à bien été prise en compte !!</p>';
			echo "<br>";

			  $to = $email;
  			$subject = "Validation du compte";
  			$message = '

  			Bienvenue sur Super Chat,

  			Pour activer votre compte, veuillez cliquer sur le lien ci dessous
   			ou copier/coller dans votre navigateur internet.

        http://localhost/chat/form_inscri.php?login='.urlencode($login).'&valid='.urlencode($valid).' '.';
  			-------------
  			Ceci est un mail automatique, merci ne de pas y repondre.';

  			$header = "From: nomTest <test@test.com>";

  			mail($to, $subject, $message, $header);
  			echo '<p class="echo">Un mail de confirmation vous à été envoyé</p>';
  			echo "<br>";
		}
	}
}

$adresse =  $_SERVER['REQUEST_URI'];
$base = $_SERVER['PHP_SELF'];

if( $adresse != $base){
parse_str($adresse, $output);
$cle = $output['valid'];
$id = $output['/chat/form_inscri_php?login'];

if($cle){

	$req = "SELECT LOGIN FROM USER WHERE login ="."'".$id."'"; 
	$res = $GLOBALS['db']->query($req);
	$present = ($res->num_rows);
	

	if($present){
		$req2 = "SELECT ACTIF FROM USER WHERE validation ="."'".$cle."'";
		$res2 = $GLOBALS['db']->query($req2);
		$present2 = ($res2->num_rows);
		

		if($present2){
			$req3 = "UPDATE USER SET ACTIF = '1' WHERE validation ="."'".$cle."'";
			$res3 = $GLOBALS['db']->query($req3);
      header("Location:http://localhost/chat/form_connection.php");
		}

		if(!$present2){
			echo '<p class="echo_err">votre compte est déjà validé</p>';
		}
	}


	if(!$present){
		echo '<p class="echo_err">Une erreur est survenue merci de contacter votre administrateur</p>';
	}

}
}


$GLOBALS['db']->close()
?>
<?php
  require_once("header_html.php");
?>

<GLOBALS['db'] href="css/style_form.css" rel="stylesheet">
<h2> Inscription </h2>
<form action ="" method="post">

	  <label for="login">Entrez votre login : </label><br/>
    <input autofocus type="text" placeholder="Votre login doit contenir 3 à 15 caractères" name="login" required="required"><br/>

    <label for="email"> Entrez votre mail : </label><br/>
    <input type="mail" name="email" placeholder="exemple@ex.com" required="required" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$"><br/>

    <label for="mdp">Entrez votre mot de passe :</label><br/>
    <input type="password" name="mdp" placeholder=" 8 symboles  A, a, 1 et caractères spéciaux" required="required" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br/>

    <label for="mdp1">Répétez votre mot de passe :</label><br/>
    <input type="password" name="mdp1" placeholder=" 8 symboles  A, a, 1 et caractères spéciaux" required="required" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br/>

    <input type="submit" value="valider" name="bouton"><br/>
    <input type="hidden" name="sub" value="1">
</form>

<?php
  require_once("footer_html.php");
?>