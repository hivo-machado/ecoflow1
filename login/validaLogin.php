<?php include_once("../header.php") ?>

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

<!-- Div para logo Ecoflow -->
<div class="row">		
	<div class="col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3">
		<img src="../img/ECOFlow symbol.jpg" alt="Logo Ecoflow" class="img-responsive">
		<br>
	</div>			
</div>

<!-- Div de formulario para login -->
<div class="row">	
	<div class="col-sm-6 col-sm-offset-3">
        <div align="center" class="panel panel-default">        
	        <div class="panel-body">
	        	<div class="row">
			        <form class="form-horizontal" method="POST" action="validarLogin.php">
					  <div class="form-group">
					    <label for="login" class="col-sm-2 col-sm-offset-1 col-xs-2 col-xs-offset-1 control-label">Login</label>
					    	<div class="col-sm-8 col-xs-8">
					      	<input type="text" class="form-control" id="login" name="login" placeholder="Nome" required autofocus>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="senha" class="col-sm-2 col-sm-offset-1 col-xs-2 col-xs-offset-1 control-label">Senha</label>
					    	<div class="col-sm-8 col-xs-8">
					      		<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
					    	</div>
					  	</div>
					  	<div class="col-sm-3 col-sm-offset-3">
					    	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Entrar</button>
					    </div>
					</form>			        		
				    <div class="col-sm-12 col-sm-offset-0">
						<a href="recuperaSenha.php"><small>esqueceu sua senha ou login?</small></a>
					</div>
	        	</div>
	        	<div class="row">
	        	</div>
	        </div>
        </div>
	</div>
</div>

<?php include_once("../footer.php") ?>