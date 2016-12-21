<?php 
include_once("../header.php");
include_once("../validar.php");
include_once("verificarEmail.php");
 ?>

<div class="row">
	<div class="mensagme text-center col-md-12">
		<?php 
		if(isset($_GET['error']))
		{
			?> 
			<p class="bg-danger" style="color:red"><?php echo $_GET['error'] ?></p>
			<?php
			} 
			else if(isset($_GET['success']))
			{
			?> 
				<p class="bg-success" style="color:green"><?php echo $_GET['success'] ?></p>
			<?php
			}
			?>
	</div>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form class="form-horizontal" method="POST" action="alterarLogin.php" >				
			<div class="panel panel-default">
				<div class="panel-heading"> <strong> Alterar Login </strong></div>
				<div class="panel-body">
						<div class="form-group">
							<label class="col-md-4 control-label"> Login</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="login" placeholder="Novo Login">
							</div>
						</div>
						<div class="form-group">
				    		<div class="col-md-4 col-md-offset-8">
								<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar Login</button>
							</div>
						</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form class="form-horizontal" method="POST" action="alterarSenha.php" >				
			<div class="panel panel-default">
				<div class="panel-heading"> <strong> Alterar Senha </strong></div>
				<div class="panel-body">
						<div class="form-group">
							<label class="col-md-4 control-label"> Nova Senha</label>
							<div class="col-md-8">
								<input type="password" class="form-control" name="senha" placeholder="Nova Senha">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Confirmar Nova Senha</label>
							<div class="col-md-8">
								<input type="password" class="form-control" name="repetirSenha" placeholder="Repetir Nova Senha">
							</div>
						</div>
						<br>
						<div class="form-group">
							<label class="col-md-4 control-label">Senha</label>
							<div class="col-md-8">
								<input type="password" class="form-control" name="senhaAtual" placeholder="Senha Atual">
							</div>
						</div>
						<div class="form-group">
				    		<div class="col-md-4 col-md-offset-8">
								<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar Senha</button>
							</div>
						</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once("../footer.php") ?>
