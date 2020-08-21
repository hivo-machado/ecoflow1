<?php 
	include_once('../conexao.php');
	session_start();

    $nome = $_POST['nome'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['uf'];
    $cep = $_POST['cep'];
    $telefone = $_POST['telefone'];
    
    //Gerar o idecoflow
    $result = mysqli_query($con, "SELECT * FROM grupo");    
    $numeroLinhas = mysqli_num_rows($result);

    $idecoflow = "9".$numeroLinhas;

    if($nome != null){
        //Criar novo grupo no banco
        mysqli_query($con, "INSERT INTO grupo(id, nome) VALUES ('$idecoflow', '$nome')");
        header("Location: criaGrupo.php?success=Grupo criado com sucesso.");
    }
 ?>