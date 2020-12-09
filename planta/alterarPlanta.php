<?php 
	//conexão com BD
	include_once("../conexao.php");

	//Variavel formulario
	$id_planta = $_POST['id_planta'];
    $nome = $_POST['nome'];
    $grupo = $_POST['grupo'];

    
	if( isset($nome,$grupo) ){
		
        mysqli_query($con, "UPDATE planta SET id_grupo_fk = '$grupo', nome = '$nome' where  idecoflow = '$id_planta'");
        header("Location: alteraPlanta.php?success=Alterado com sucesso.&id_planta=$id_plnata");

	}

 ?>