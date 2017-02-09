<?php 
include_once("../header.php");
include_once("../validar.php");
?>

<?php 
	//função para verificar se esta logado
	valida();
 ?>

<?php
	//busca no BD todos os grupos para criação de select option
	$result = mysqli_query($con, "SELECT * FROM grupo");
 ?>

<!--Menssagem de Alerta-->
 <div class="row">
	<div class="mensagme text-center col-sm-8 col-sm-offset-2">
		<?php 
		if(isset($_GET['error']))
		{
			?> 
			<div class="alert alert-danger alert-dismissible" role="alert"><?php echo $_GET['error'] ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
			} 
			else if(isset($_GET['success']))
			{
			?> 
				<div class="alert alert-success alert-dismissible" role="alert"><?php echo $_GET['success'] ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php
			}
			?>
	</div>
</div>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Criar Usuário</h2>
	  </div>
  	</div>
</div>

<!--Formulario Nome e Foto-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="criarUsuario.php">

			<div class="form-group">
				<label for="nome" class="col-sm-4 control-label">Nome*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="nome" name="nome" required autofocus
					maxlength="20"
					pattern="[A-Za-z]{1,20}$" 
					title="Verifique os caracteres válidos a-z, A-Z e sem espaço.">
				</div>
			</div>

			<div class="form-group">
				<label for="login" class="col-sm-4 control-label">Login*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="login" name="login" required
					maxlength="20"
					pattern="[A-Za-z0-9._]{1,20}$" 
					title="Verifique os caracteres válidos a-z, A-Z, 0-9 e '_'.">
				</div>
			</div>

			<div class="form-group">
				<label for="senha" class="col-sm-4 control-label">Senha*</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="senha" name="senha" required
					minlength="6" maxlength="20"
					pattern="[\S]{6,20}$"
					title="verifique se a senha possui no minimo 6 caracteres sem espaço em branco.">
				</div>
			</div>

			<div class="form-group">
				<label for="repetirSenha" class="col-sm-4 control-label">Repetir Senha*</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="repetirSenha" name="repetirSenha" required
					minlength="6" maxlength="20"
					pattern="[\S]{6,20}$"
					title="verifique se a senha possui no minimo 6 caracteres sem espaço em branco.">
				</div>
			</div>

			<div class="form-group">
				<label for="grupo" class="col-sm-4 control-label">Grupo</label>
				<div class="col-sm-4" >
					<select name="grupo" id="grupo" class="form-control">
						<option value="">Selecione</option>
						<?php 
							while ( $grupos = mysqli_fetch_object($result) ) {
								echo '<option value="'.$grupos->id.'">'.$grupos->nome.'</option>';
							}
						 ?>
					 </select>
					 <span id="helpBlock" class="help-block">Não necessario para perfil Administrador.</span>
				</div>
			</div>

			<div class="form-group">
				<label for="tipo" class="col-sm-4 control-label">Perfil*</label>
				<div class="col-sm-4">
					<select name="tipo" id="tipo" class="form-control" required>
						<option value="">Selecione</option>
						<option value="admin">Administrador</option>
						<option value="sind">Síndico</option>
					 </select>
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
	    		<div class="col-sm-4 col-sm-offset-8">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Salvar Usuário</button>
				</div>
			</div>

		</form>
	</div>
</div>

 <?php include_once("../footer.php") ?>