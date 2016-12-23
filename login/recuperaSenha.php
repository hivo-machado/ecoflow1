<?php include_once("../header.php") ?>

<div class="row">
	<div class="mensagme text-center col-md-8 col-md-offset-2">
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
	<div class="col-md-8 col-md-offset-2">
		<form class="form-horizontal" method="POST" action="recuperarSenha.php" >				
			<div class="panel panel-default">
				<div class="panel-heading"> <strong> Esqueceu Senha </strong></div>
				<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-md-offset-1">
								<p>Esqueceu a senha eviaremos um e-mail com sua senha.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">E-mail</label>
							<div class="col-md-8">
								<input type="email" class="form-control" name="email" placeholder="email@email.com">
							</div>
						</div>
						<br>
						<div class="form-group">
				    		<div class="col-md-3 col-md-offset-9">
								<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar</button>
							</div>
						</div>
				</div>
			</div>
		</form>
	</div>
</div>


<?php include_once("../footer.php") ?>
