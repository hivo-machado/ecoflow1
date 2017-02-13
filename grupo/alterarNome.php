<?php 
	//conexão com BD
	include_once("../conexao.php");

	//Variavel formulario
	$id_grupo = $_POST['id_grupo'];
	$nome = $_POST['nome'];

	
	if( isset($nome) ){

		if($_FILES['arquivo']['size'] > 0){
			
			// Pasta onde o arquivo vai ser salvo
			$_UP['pasta'] = '../img/grupo/';
			// Tamanho máximo do arquivo (em Bytes)
			$_UP['tamanho'] = 1024 * 1024 * 5; // 2Mb
			// Array com as extensões permitidas
			$_UP['extensoes'] = array('jpg', 'png', 'jpeg');
			// Array com os tipos de erros de upload do PHP
			$_UP['erros'][0] = 'Não houve erro';
			$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
			$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
			$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
			$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
			// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
			
			// Faz a verificação da extensão do arquivo
			$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
			if (array_search($extensao, $_UP['extensoes']) === false) {
			  echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou jpeg";
			}
			// Faz a verificação do tamanho do arquivo
			if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
			  echo "O arquivo enviado é muito grande, envie arquivos de até 5Mb.";
			  exit;
			}
			// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
			// Trocar o nome do arquivo
			$nome_final = $id_grupo.'.'.$extensao;
			
			  
			// Depois verifica se é possível mover o arquivo para a pasta escolhida
			if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
			  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo				
				mysqli_query($con, "UPDATE grupo SET nome_grupo = '$nome', imagem = '$nome_final' where  id = '$id_grupo'");

				header("Location: alteraGrupo.php?success=Alterado com sucesso.&id_grupo=$id_grupo");
				#  echo "Upload efetuado com sucesso!";
				#  echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
			} else {
			  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
			  header("Location: alteraGrupo.php?error=Imagem invalida!&id_grupo=$id_grupo");
			}
		}else{// if arquivo

			mysqli_query($con, "UPDATE grupo SET nome_grupo = '$nome' where  id = '$id_grupo'");
			header("Location: alteraGrupo.php?success=Alterado com sucesso.&id_grupo=$id_grupo");
		}

	}// if nome

 ?>