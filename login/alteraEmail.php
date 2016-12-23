<?php include_once("../header.php") ?>
<?php include_once("../validar.php") ?>

<div class="row">
	<div class="mensagme text-center col-sm-8 col-sm-offset-2">
		<?php 
		if(isset($_GET['error']))
		{
			?> 
			<div class="alert alert-danger" role="alert"><?php echo $_GET['error'] ?></div>
			<?php
			} 
			else if(isset($_GET['success']))
			{
			?> 
				<div class="alert alert-success" role="alert"><?php echo $_GET['success'] ?></div>
			<?php
			}
			?>
	</div>
</div>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<form class="form-horizontal" method="POST" action="alterarEmail.php" >				
			<div class="panel panel-primary">
				<div class="panel-heading"> <strong> Alterar E-mail </strong></div>
				<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-4 control-label">E-mail</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="email" placeholder="email@email.com">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Confirmar E-mail</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="confEmail" placeholder="Repetir e-mail">
							</div>
						</div>
						<br>
						<div class="form-group">
							<label class="col-sm-4 control-label">Senha</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" name="senha" placeholder="Senha">
							</div>
						</div>
						<div class="form-group">
				    		<div class="col-sm-4 col-sm-offset-8">
								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar e-mail</button>
							</div>
						</div>
				</div>
			</div>
		</form>
	</div>
</div>


<?php include_once("../footer.php") ?>
