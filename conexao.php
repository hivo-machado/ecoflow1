<?php 

$con = mysqli_connect("mysql.hostinger.com.br", "u643955609_ecof", "urVi4Ue9bo");

if(!$con)
{
	die("Falha na conexão com o banco");
}

mysqli_select_db($con, "u643955609_ecof");

?>