<?php 
  include_once("../header.php");
  include_once("../validar.php");
?>

<?php 
	//valida-se esta logado como Administrador ou sindico
	validaAdminSind();
 ?>

<?php 
	//variavel SESSAO
	$tipo = $_SESSION['tipo'];
	$id_grupo = $_SESSION['id_grupo'];

	//varivel GET
	$id_planta = $_GET['id_planta'];

	$result = mysqli_query($con, "SELECT * FROM planta WHERE idecoflow = '$id_planta' AND id_grupo_fk = '$id_grupo'");
	$planta = mysqli_fetch_object($result);

	//Verificação para perfil sindico
	if($tipo == 'sind'){
		//Verifica-se planta pertence a grupo senão usuario tentando acesso indevido
		if(!isset($planta)){
			echo '<meta http-equiv="refresh" content="0;URL=listaPlanta.php?error=Acesso indevido." />';
		}
	}

 ?>

 <?php include_once("../footer.php") ?>