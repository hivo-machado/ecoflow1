<?php 
	if(! isset ($_SESSION["login"])){		
		header("Location: ../login/login.php?error=Usuário não logado.");		
	}
 ?>