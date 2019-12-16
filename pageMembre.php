<?php
require_once("bd_connect.php");

$adresse =  $_SERVER['REQUEST_URI'];
parse_str($adresse, $output);
//print_r($output);
$membre = $output['/Chat/pageMembre_php?id'];


$req = "SELECT `DATE`, `MESSAGE` FROM mess WHERE ID_USER ="."'".$membre."'";
$res = $GLOBALS['db']->query($req);     
?>

<?php
	require_once("header_html.php");
	echo "message de ".$membre;
?>

<?php
	
	while ($row = $res->fetch_assoc()) {
?>

			<article data-id="<?php echo $row['ID']; ?>">
				<main><?php echo nl2br($row['MESSAGE']); ?></main>
				<footer>
					<time><?php
							$datetime = DateTime::createFromFormat("Y-m-d", $row['DATE']);
							echo "le ".$datetime->format("d/m/Y");?></time>
				</footer>
			</article>


<?php
}


require_once("footer_html.php");
?>

