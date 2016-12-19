<?php 
	if(! isset ($_SESSION["idecoflow"])){	
		header("Location: ../login/validaLogin.php?error=Usuário não logado.");		
	}
 ?>