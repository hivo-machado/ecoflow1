<?php 
	include_once('../conexao.php');
	session_start();

    $nome = $_POST['nome'];
    $medidor = $_POST['medidor'];
    $servico = $_POST['servico'];
    $device = $_POST['device'];
    
    
    if($nome != null){

         //Criar nova unidade no banco
         mysqli_query($con, "INSERT INTO lorawan_unidades(nome, medidor, servico, device_addr) VALUES ('$nome', '$medidor', '$servico', '$device')");
        
        $result = mysqli_query($con, "SELECT * FROM lorawan_idecoflow WHERE nome = $nome");  

        if(!$result){
            //Criar novo idecoflow para a unidade caso não existir
            $result = mysqli_query($con, "SELECT * FROM lorawan_unidades");    
            $numeroLinhas = mysqli_num_rows($result);
            
            $idecoflow = "L".$numeroLinhas;

            mysqli_query($con, "INSERT INTO lorawan_idecoflow(idecoflow, nome) VALUES ('$idecoflow', '$nome')");
            
            //Criar novo usuario para a unidade caso não existir
            $resultPlanta = mysqli_query($con, "SELECT planta FROM lorawan_devices WHERE device_addr = '$device'");
            $plantas = mysqli_fetch_object($resultPlanta);
            $resultGrupo = mysqli_query($con, "SELECT id_grupo_fk FROM planta WHERE idecoflow = '$plantas->planta'"); 
            $grupos = mysqli_fetch_object($resultGrupo);
            
            $id_unidade = $idecoflow;
            $id_planta = $plantas->planta;            
            $id_grupo = $grupos->id_grupo_fk;
            $login = $idecoflow.$nome;
            $senha = $idecoflow.$nome;
            $tipo = "usuario";
            $status = "ativo";

            mysqli_query($con, "INSERT INTO usuario(id_unidade, id_planta, id_grupo, login, senha, nome, tipo, status) VALUES ('$id_unidade', '$id_planta', '$id_grupo', '$login', '$senha', '$nome', '$tipo', '$status')");
            
        }
        
        header("Location: criaUnidade.php?success=Unidade criada com sucesso.");
    }
 ?>