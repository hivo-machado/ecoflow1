<?php 
	include_once('../conexao.php');
	session_start();

    $nome = $_POST['nome'];
    $grupo = $_POST['grupo'];
    
    //Gerar o idecoflow
    $result = mysqli_query($con, "SELECT * FROM planta");    
    $numeroLinhas = mysqli_num_rows($result);

    $idecoflow = "9".$numeroLinhas;

    if($nome != null){
        //Criar novo grupo no banco
        mysqli_query($con, "INSERT INTO planta(idecoflow, id_grupo_fk, nome) VALUES ('$idecoflow', '$grupo', '$nome')");
        header("Location: criaPlanta.php?success=Planta criada com sucesso.");
    }

 ?>