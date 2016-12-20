<?php include_once("../header.php") ?>
<?php include_once("../validar.php") ?>

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
		<form class="form-horizontal" method="POST" action="updateUsuario.php" >				
			<div class="panel panel-default">
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
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
						<div class="form-group">
							<label class="col-md-4 control-label">Senha</label>
							<div class="col-md-8">
								<input type="password" class="form-control" name="senha_atual" placeholder="Senha Atual">
							</div>
						</div>
						<div class="form-group">
				    		<div class="col-md-3 col-md-offset-9">
								<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
							</div>
						</div>
				</div>
			</div>
		</form>
	</div>
</div>


<?php include_once("../footer.php") ?>
