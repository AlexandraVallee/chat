<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!--<script src="js\tinymce\tinymce.min.js"></script>-->
	<link rel="stylesheet" href="css/ico.css" />
	<link rel="stylesheet" href="css/css.css" />
	<title>Super Chat</title>
</head>

<body>

	<header>
		<div class="baniere">
			<p class="icon icon-bubbles4"></p>
			<p class="txt"><?php
			session_start();
			if(isset($_SESSION["login"])) {
				echo"Bienvenue ".$_SESSION["login"];
			}else{
				echo "Bienvenue";
			} ?> </p>
			<!--<form method="GET" action="verif-recherche.php">
   				<input type="search" id="search" name="q" placeholder="Recherche..." />
   				<button><span class="icon icon-search"></span></button>
			</form>-->
		</div>
		<nav>
			<ul>
				<li><a href="index.php"><span class="icon icon-home"></span><p> Accueil</p></a></li>
				<li><a href="form_connection.php"><span class="icon icon-user"></span><p> Connexion</p></a></li>
				<li><a href="form_inscri.php"><span class="icon icon-user-plus"></span><p> Inscription</p></a></li>
				<li><a href="logout.php"><span class="icon icon-switch"></span><p> Déconnexion</p></a></li>

			</ul>
		</nav>
	</header>
	<main>
	<div>