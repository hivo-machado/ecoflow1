<?php 

$con = mysqli_connect("localhost", "root", "");

if(!$con)
{
	die("Falha na conexão com o banco");
}

mysqli_select_db($con, "ecoflow");

?>