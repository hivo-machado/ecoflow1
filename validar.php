<?php 
	
	//Verifica-se esta logando
	function valida(){
		if(!isset ($_SESSION['id']) && !isset($_SESSION['login']) && !isset($_SESSION['nome']) && !isset( $_SESSION['tipo']) ){
			echo '<meta http-equiv="refresh" content="0;URL=../login?error=Usuário não logado." />';
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

	//verifica-se esta logado como administrador e síndico
	function validaAdminSind(){
		if (!( ($_SESSION["tipo"] == 'sind')||($_SESSION["tipo"] == 'admin') ) ){
			echo '<meta http-equiv="refresh" content="0;URL=../home/home.php?error=Usuario inválido." />';
		}
	}

	//verifica-se logado
	function logado(){
		if(isset ($_SESSION['id']) && isset($_SESSION['login']) && isset( $_SESSION['tipo']) ){
			if( ($_SESSION["tipo"] == 'sind')||($_SESSION["tipo"] == 'usuario') ){
				echo '<meta http-equiv="refresh" content="0;URL=../home/home.php" />';
			}
			if($_SESSION["tipo"] == 'admin'){
				echo '<meta http-equiv="refresh" content="0;URL=../home/homeAdmin.php" />';
			}
		}
	}

 ?>