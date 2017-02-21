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
	//busca no BD todos os grupos para criação de select option
	$result = mysqli_query($con, "SELECT * FROM grupo");
 ?>

 <script>
 	//JQuery para mostrar campo somente valido para perfil sindico
 	$(document).ready( function(){
 		$('#tipo').change( function(){
 			var perfil = $('#tipo').val();
 			if(perfil == "sind"){
 				$("#grupos").fadeIn();
 			}else{
 				$("#grupos").fadeOut();
 			}
 		});
 	});
 </script>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Criar Novo Usuário <small>Síndico ou Administrador</small></h2>
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
					title="Verifique os caracteres válidos a-z, A-Z e sem espaço."
					placeholder="Nome">
				</div>
			</div>

			<div class="form-group">
				<label for="login" class="col-sm-4 control-label">Login*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="login" name="login" required
					maxlength="20"
					pattern="[A-Za-z0-9._]{1,20}$" 
					title="Verifique os caracteres válidos a-z, A-Z, 0-9 e '_'."
					placeholder="Login">
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
					placeholder="Repetir Senha">
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

			<div class="form-group" id="grupos" style="display: none">
				<label for="grupo" class="col-sm-4 control-label">Grupo*</label>
				<div class="col-sm-4" >
					<select name="grupo" id="grupo" class="form-control">
						<option value="">Selecione</option>
						<?php 
							while ( $grupos = mysqli_fetch_object($result) ) {
								echo '<option value="'.$grupos->id.'">'.$grupos->nome.'</option>';
							}
						 ?>
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
	    		<div class="col-sm-4 col-sm-offset-4">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Salvar Novo Usuário</button>
				</div>
			</div>

		</form>
	</div>
</div>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Criar Novos Usuários <small>Unidades</small></h2>
	  </div>
  	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-sm-offset-1">

		<div class="row">
			<div class="col-sm-8 col-sm-offset-4">
				<p>Criar usuarios automaticamente para novas unidades. (Todos os usuarios são criados com login e senha igual a idecoflow respectivos)</p>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<a class="btn btn-primary" href="criarUsuarios.php" role="button"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Criar Novos Usúarios</a>
			</div>
		</div>
		
	</div>
</div>


 <?php include_once("../footer.php") ?>