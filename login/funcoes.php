<?php 

	function buscaEmail($con, $id){

		$result = mysqli_query($con, "SELECT * FROM usuario where id = '$id'");
		$usuario = mysqli_fetch_object($result);

		if(isset($usuario->email)){
			return $usuario->email;
		}else{
			return false;
		}
	}
 ?>