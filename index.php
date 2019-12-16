<?php
require_once("bd_connect.php");

$message_par_page = 3;

$reqTt = 'SELECT COUNT(*) AS total FROM mess';
$resTt = $GLOBALS['db']->query($reqTt); 
$rowTt = $resTt->fetch_assoc();
$total=$rowTt['total'];

$nbrPage=ceil($total/$message_par_page);

if(isset($_GET['page'])){
    $pageAct=intval($_GET['page']);

    if($pageAct>$nbrPage){
        $pageAct=$nbrPage;
    }
}else{
    $pageAct=1;
}
$FirstEnt=intval(($pageAct-1)*$message_par_page);


$req = "SELECT `ID`,`DATE`,`ID_USER`,`MESSAGE` FROM `mess` ORDER BY `DATE` ASC LIMIT {$FirstEnt},{$message_par_page}";
$res = $GLOBALS['db']->query($req);
?>

<?php
	require_once("header_html.php");
?>

<?php
	while ($row = $res->fetch_assoc()) {
?>

			<article data-id="<?php echo $row['ID']; ?>">
				<header><h2><?php echo $row['ID_USER']; ?></h2>
				</header>
				<main><?php echo nl2br($row['MESSAGE']); ?></main>
				<footer>
					<time><?php
							$datetime = DateTime::createFromFormat("Y-m-d", $row['DATE']);
							echo "le ".$datetime->format("d/m/Y");?></time>
				</footer>
			</article>


<?php
	}
if(isset($_SESSION["login"])){
require_once("creaArticle.php");
}
echo '<main><p align="center">Page : ';
for($i=1; $i<=$nbrPage; $i++){

    if($i==$pageAct){
    	 echo " [ $i ] ";
    }else{
    	 echo ' <a href="?page='.$i.'">'.$i.'</a> ';
    }
}
?>

<?php
	require_once("footer_html.php");
?>