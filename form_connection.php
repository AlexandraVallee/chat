<?php 
session_start();
require_once("bd_connect.php");// va chercher la page de connection à la bdd
require_once("function.php"); 



if (isset($_POST["sub"])){ //test si le formulaire est envoyé

	$log = htmlspecialchars($_POST["login"]);
	$log = $GLOBALS['db']->real_escape_string($log) ; // déclaration des variables contenues dans le formulaire
	//echo $log;
	$pwd = $_POST["mdp"];
	
	$req = "SELECT `ID` ,`LOGIN`, `PWD`, `PWD-1`, `DATE`, `PassLost`  FROM user WHERE login ="."'". $log."'"; // requête qui cherche dans la bdd si un utilisateur appartient à la Bdd

	$res = $GLOBALS['db']->query($req); // exécute la requête

	if(!$GLOBALS['db']->errno){     // si pas d'érreur alors 
		if($res->num_rows){// si le résultat de la requête renvoit quelque chose alors afficher que l'on est connecté
			$ligne_resultat = $res->fetch_assoc();
			//print_r ($ligne_resultat);
			//echo($ligne_resultat["PWD"]);
			//$verif = password_verify($pwd, $ligne_resultat["PWD"]);
			//echo "c'est ".$verif;
			if(password_verify($pwd, $ligne_resultat['PWD'])){
				
				
				$_SESSION["login"] = $ligne_resultat['LOGIN'];
				$_SESSION["id"] = $ligne_resultat['ID'];

				//echo $_SESSION["login"]; 3 test débug
				//echo $_SESSION["pwd"];
				//echo '<p class="echo">Bienvenu '.$log.' vous êtes connecté</p>';
				
				$date = $ligne_resultat['DATE'];
				$dateActu = $_SERVER['REQUEST_TIME'];
				$troisM = $date + 7889400;
				$passL = $ligne_resultat['PassLost'];
				//echo $passL;
				
				if($date>=$troisM || $passL == 1 ){
					header('Location:http://127.0.0.1/chat/form_change_mdp.php');
					exit();
				}else {
					header('Location:http://127.0.0.1/chat/index.php');
				}
			}
		}
	} else {
		echo '<p class="text-danger">Erreur votre Login ou votre mot de passe est incorect</p>';
	}
}
?>
<?php
	require_once("header_html.php");
?>


	<GLOBALS['db'] href="css/style_form.css" rel="stylesheet">
	<h2> Connexion </h2>
		<form action ="" method="post">
		    <label for="login">Entrez votre login : </label>
		    <input autofocus="" type="text" name="login" required placeholder="Login"><br/>
		    <label for="mdp">Entrez votre mot de passe:</label>
		    <input type="password" name="mdp" required placeholder="********">
		    <input type="submit" value="valider" name="bouton">
		    <input type="hidden" name="sub" value="1">
		</form>

<div class="lien">
		<p><a href="http://127.0.0.1/chat/form_mdp_oubli.php">Vous avez oublié votre mot de passe ?</a></p>
		<p><a href="http://127.0.0.1/chat/form_inscri.php">Pas encore incrit ? cliquez ici </a></p>
</div>

<?php
	require_once("footer_html.php");
?>
