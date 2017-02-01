<?php include_once("../header.php") ?>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">
	  <div class="page-header">
	    <h2>Recuperar Senha</h2>
	  </div>
  	</div>
</div>

<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="recuperarSenha.php" >
			<div class="row">
				<div class="col-sm-12 col-sm-offset-0">
					<p>Esqueceu a senha ou login eviaremos um e-mail com seu login e senha.</p>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-4 control-label">E-mail</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" required autofocus>
				</div>
			</div>
			<br>
			<div class="form-group">
	    		<div class="col-sm-3 col-sm-offset-9">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar</button>
				</div>
			</div>
		</form>
	</div>
</div>


<?php include_once("../footer.php") ?>
