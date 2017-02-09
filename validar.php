<?php 
	
	//Verifica-se esta logando
	function valida(){
		if(!isset ($_SESSION['id']) && !isset($_SESSION['login']) && !isset($_SESSION['nome']) && !isset( $_SESSION['tipo']) ){
			header("Location: ../login/validaLogin.php?error=Usuário não logado.");		
		}
	}

	//verifica-se esta logado como administrador
	function validaAdmin(){
		if($_SESSION["tipo"] != 'admin' ){	
			echo '<meta http-equiv="refresh" content="0;URL=../home/home.php?error=Usuario inválido." />';
		}
	}

	//verifica-se esta logado como síndico
	function validaSind(){
		if($_SESSION["tipo"] != 'sind' ){	
			echo '<meta http-equiv="refresh" content="0;URL=../home/home.php?error=Usuario inválido." />';
		}
	}

 ?>