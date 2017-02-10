<?php 
include_once("../header.php");
include_once("../validar.php");
?>

<?php 
	//função para verificar se esta logado
	valida();
	//função para verificar se esta logado como administrador
	validaAdmin();
 ?>

 <?php 
	 if( isset($_GET['id_usuario']) ){
	 	$id_usuario = $_GET['id_usuario'];
	 	$result = mysqli_query($con, "SELECT * FROM usuario WHERE id = '$id_usuario'");
	 	$usuario = mysqli_fetch_object($result);
	 }
  ?>

<!--Cabeçalho-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Usuário <small><?php echo $usuario->nome ?></small></h2>
	  </div>
  	</div>
</div>

<!--Formulario Nome e Foto-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarUsuario.php">

			<div class="form-group sr-only">
				<label for="id_usuario" class="col-sm-4 control-label">ID Usuario*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="id_usuario" name="id_usuario"
					placeholder=<?php echo $id_usuario ?> value=<?php echo $id_usuario ?>>
				</div>
			</div>

			<div class="form-group">
				<label for="login" class="col-sm-4 control-label">Login*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="login" name="login" required autofocus
					maxlength="20"
					pattern="[A-Za-z0-9._]{1,20}$" 
					title="Verifique os caracteres válidos a-z, A-Z, 0-9 e '_'."
					placeholder=<?php echo $usuario->login ?> value=<?php echo $usuario->login ?>>
				</div>
			</div>

			<div class="form-group">
				<label for="senha" class="col-sm-4 control-label">Senha*</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="senha" name="senha" required
					minlength="6" maxlength="20"
					pattern="[\S]{6,20}$"
					title="verifique se a senha possui no minimo 6 caracteres sem espaço em branco."
					placeholder="Senha">
				</div>
			</div>

			<div class="form-group">
				<label for="repetirSenha" class="col-sm-4 control-label">Confirmar Senha*</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="repetirSenha" name="repetirSenha" required
					minlength="6" maxlength="20"
					pattern="[\S]{6,20}$"
					title="verifique se a senha possui no minimo 6 caracteres sem espaço em branco."
					placeholder="Repetir senha">
				</div>
			</div>

			<div class="form-group">
				<label for="status" class="col-sm-4 control-label">Status*</label>
				<div class="col-sm-4">
					<select name="status" id="status" class="form-control" required>
						<option value="">Selecione</option>
						<option value="ativo">Ativo</option>
						<option value="desativado">Desativado</option>
					 </select>
					<span id="helpBlock" class="help-block">* Campos obrigatórios.</span>
				</div>
			</div>

			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-4">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar Usuário</button>
				</div>
			</div>

		</form>
	</div>
</div>

<!--Cabeçalho-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Resetar Usuário <small><?php echo $usuario->nome ?></small></h2>
	  </div>
  	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-sm-offset-1">

		<div class="row">
			<div class="col-sm-8 col-sm-offset-4">
				<p>Reseta o usuário para login e senha igual a idecoflow. (Para usuário com perfil Síndico e Administrador reseta login e senha igual ao ID.)</p>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<form class="form-horizontal" method="POST" action="resetarUsuario.php">

					<div class="form-group sr-only">
						<label for="id_usuario" class="col-sm-4 control-label">ID Usuario*</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="id_usuario" name="id_usuario"
							placeholder=<?php echo $id_usuario ?> value=<?php echo $id_usuario ?>>
						</div>
					</div>

					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Resetar Usúario</button>

				</form>
			</div>
		</div>
		
	</div>
</div>

<!--Cabeçalho-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Ativar ou desativar usuario <small><?php echo $usuario->nome ?></small></h2>
	  </div>
  	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-xs-12">
		
	</div>
</div>


 <?php include_once("../footer.php") ?>