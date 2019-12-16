<?php
require_once("bd_connect.php");
require_once("function.php");
session_start();
if (isset($_POST['sub'])) {
	$_SESSION["nom"] = $_POST['auteur'];
}



if (isset($_POST['sub'])) {
	//Déclare les vars
	$form_valid = TRUE;
	$form_auteur = $_POST['auteur'];
	$form_txt = $_POST['message'];
	
	//Assainir: XSS, injection SQL 
	$form_auteur = addslashes(trim(scriptLess($form_auteur)));
	$form_txt = addslashes(trim(scriptLess($form_txt)));
	
	/* VERIFICATION */
	
	//Est-ce que les champs sont saisis ?
	if (empty($form_auteur)) {
		$form_valid = FALSE;
		$form_error_msg = "Title empty";
	}
	if (empty($form_txt)) {
		$form_valid = FALSE;
		$form_error_msg = "Text empty";
	}
	
	if ($form_valid) {
		/* VERIFICATION AVEC BDD */
		$log1 = $_POST['auteur'];
   		$req = "SELECT NAME FROM user WHERE NAME ="."'".$log1."'";
   		$res = $GLOBALS['db']->query($req);
   		$pseudoFree=($res->num_rows);
   		
   		if ($pseudoFree != 0) {
   			echo '<p class="echo_err">Votre pseudo est déjà utilisé </p>';
   			echo "<br>";
   			$eGlobal = true;
   		} else{
   			$log1 = $_POST['auteur'];
   			$req = "INSERT INTO `user` (`ID`, `NAME`) VALUES (NULL,"."'".$form_auteur."')";
   			$res = $GLOBALS['db']->query($req);
   		}
		
		/* FIN VERIFICATIONS, AJOUT */
		if ($form_valid) {
			$req = "INSERT INTO mess ( `DATE` , `ID_USER` , `MESSAGE`) VALUES ( NOW(),"."'".$form_auteur."', '".$form_txt."')";
			//echo $req ; die();

			$GLOBALS['db']->query($req);
			if (!empty($GLOBALS['db']->error)) {
				//Erreur
				$form_error_msg = $GLOBALS['db']->error;
			} else {
				$form_error_msg = "Post created";
			}
		}
	}
}
?>

<?php
	require_once("header_html.php");
?>
	

	<form action ="" method="post">
		<input name="auteur" placeholder="Entrez votre nom" required><?php $_SESSION["nom"]; ?></input>
		<textarea  name="message" required>Contenu de l'article ici</textarea>

		<input type="submit" value="valider" name="bouton">
		<input type="hidden" name="sub" value="1">
	</form>

	<script>tinymce.init({selector:'textarea', plugins : "emoticons", toolbar : "emoticons"});</script>
	<?php if (isset($form_error_msg)) { echo $form_error_msg; } ?>
	
<?php
	require_once("footer_html.php");
?>