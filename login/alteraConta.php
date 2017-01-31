<?php 
include_once("../header.php");
include_once("../validar.php");
include_once("funcoes.php");
?>

<?php 
	//variavel de sessão
	$id = $_SESSION['idecoflow'];
	$login = $_SESSION['login'];

	//Verificar se existe e-mail cadastrado
	if(!buscaEmail($con, $id)){
		header("Location: alteraEmail.php?error=Cadastre primeiro o e-mail.");
	}
 ?>


<!--Cabeçalho da form-->
<div class="row">
  <div class="page-header">
    <h2>Alterar Login</h2>
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
  <div class="page-header">
    <h2>Alterar Senha</h2>
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
