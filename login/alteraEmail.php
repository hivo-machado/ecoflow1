<?php 
include_once("../header.php");
include_once("../validar.php");
include_once("funcoes.php");
?>

<?php 
	//função para verificar se esta logado
	valida();
 ?>

<?php 
	//variavel de sessão
	$id = $_SESSION['id'];
 ?>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar E-mail</h2>
	  </div>
  	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarEmail.php" >
			<?php if($email = buscaEmail($con, $id)){ ?>
			<div class="form-group">
			    <label class="col-sm-4 control-label">E-mail</label>
			    <div class="col-sm-8">
			    	<input class="form-control" type="text" placeholder=<?php echo $email ?> readonly>
			    </div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label for="email" class="col-sm-4 control-label">Novo E-mail</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" 
					minlength="5" maxlength="40" required autofocus
					pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
					title="E-mail inválido.">
				</div>
			</div>
			<div class="form-group">
				<label for="confEmail" class="col-sm-4 control-label">Confirmar Novo E-mail</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="confEmail" name="confEmail" placeholder="Repetir e-mail" 
					minlength="5" maxlength="40" required
					pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
					title="E-mail inválido.">
				</div>
			</div>
			<br>
			<div class="form-group">
				<label for="senha" class="col-sm-4 control-label">Senha</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
					<span id="helpBlock" class="help-block">Confirmação de senha necessária para alteração.</span>
				</div>
			</div>
			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-8">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar e-mail</button>
				</div>
			</div>
		</form>
	</div>
</div>


<?php include_once("../footer.php") ?>
