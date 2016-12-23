<?php include_once("../header.php") ?>

<div class="row">
	<div class="mensagme text-center col-xs-8 col-xs-offset-2">
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
	<div class="col-xs-8 col-xs-offset-2">
		<form class="form-horizontal" method="POST" action="recuperarSenha.php" >				
			<div class="panel panel-primary">
				<div class="panel-heading"> <strong> Esqueceu Senha </strong></div>
				<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-xs-offset-1">
								<p>Esqueceu a senha eviaremos um e-mail com seu login e senha.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-4 control-label">E-mail</label>
							<div class="col-xs-8">
								<input type="email" class="form-control" name="email" placeholder="email@email.com">
							</div>
						</div>
						<br>
						<div class="form-group">
				    		<div class="col-xs-3 col-xs-offset-9">
								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar</button>
							</div>
						</div>
				</div>
			</div>
		</form>
	</div>
</div>


<?php include_once("../footer.php") ?>
