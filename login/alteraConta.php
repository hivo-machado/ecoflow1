<?php 
include_once("../header.php");
include_once("../validar.php");
include_once("funcoes.php");
?>

<?php 
	//variavel de sessão
	$login = $_SESSION['login'];
 ?>

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


<!--Cabeçalho da form-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Login</h2>
	  </div>
	 </div>
</div>


<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarLogin.php" >
			<div class="form-group">
			    <label class="col-sm-4 control-label">Login Cadastrado</label>
			    <div class="col-sm-8">
			    	<input class="form-control" type="text" placeholder=<?php echo $login ?> readonly>
			    </div>
			</div>
			<div class="form-group">
				<label for="login" class="col-sm-4 control-label">Login</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="login" name="login" placeholder="Novo Login" required>
				</div>
			</div>
			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-8">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar Login</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!--Cabeçalho da form-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Senha</h2>
	  </div>
  	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarSenha.php" >
			<div class="form-group">
				<label for="senhaNova" class="col-sm-4 control-label">Nova Senha</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="senhaNova" name="senhaNova" placeholder="Nova Senha" required>
				</div>
			</div>
			<div class="form-group">
				<label for="repetirSenha" class="col-sm-4 control-label">Confirmar Nova Senha</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="repetirSenha" name="repetirSenha" placeholder="Repetir Nova Senha" required>
				</div>
			</div>
			<br>
			<div class="form-group">
				<label for="senha" class="col-sm-4 control-label">Senha</label>
				<div class="col-sm-8"> 
					<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha Atual" required>
					<span id="helpBlock" class="help-block">Confirmação de senha atual necessária para alteração.</span>
				</div>
			</div>
			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-8">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>Atualizar Senha</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once("../footer.php") ?>
