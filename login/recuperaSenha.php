<?php include_once("../header.php") ?>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<form class="form-horizontal" method="POST" action="recuperarSenha.php" >				
			<div class="panel panel-primary">
				<div class="panel-heading"> <strong> Esqueceu Senha </strong></div>
				<div class="panel-body">
						<div class="row">
							<div class="col-sm-12 col-sm-offset-1">
								<p>Esqueceu a senha eviaremos um e-mail com seu login e senha.</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">E-mail</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="email" placeholder="email@email.com">
							</div>
						</div>
						<br>
						<div class="form-group">
				    		<div class="col-sm-3 col-sm-offset-9">
								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar</button>
							</div>
						</div>
				</div>
			</div>
		</form>
	</div>
</div>


<?php include_once("../footer.php") ?>
