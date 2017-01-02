<?php 

$con = mysqli_connect("mysql427.umbler.com", "ecoflow", "v1n1c1u5");

if(!$con)
{
	die("Falha na conexão com o banco");
}

mysqli_select_db($con, "ecoflow");

?>