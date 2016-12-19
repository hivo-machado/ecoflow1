<?php 
	if(! isset ($_SESSION["login"])){	
		header("Location: ../login/validaLogin.php?error=Usuário não logado.");		
	}
 ?>