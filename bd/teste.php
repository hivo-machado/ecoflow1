<?php 
	include_once("../conexao.php");

	$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '2'");
    $resgrupo = mysqli_fetch_object($result);

    echo $resgrupo->id."<br>".$resgrupo->nome."<br>";



 ?>