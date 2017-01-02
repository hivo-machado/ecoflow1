<?php include_once("../header.php") ?>
		
		<!-- menssagem de sucesso ou erro-->
<div class="row">
	<div class="mensagme text-center col-sm-5 col-sm-offset-3">
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

<!-- Div para logo Ecoflow -->
<div class="row">		
	<div class="col-xs-3 col-xs-offset-5 col-sm-offset-4">
		<img src="../img/ECOFlow symbol.jpg" alt="Logo Ecoflow" class="img-responsive">
		<br>
	</div>			
</div>

<!-- Div de formulario para login -->
<div class="row">	
	<div class="col-sm-5 col-sm-offset-3">
        <div align="center" class="panel panel-default">        
	        <div class="panel-body">
	        	<div class="row">
			        <form class="form-horizontal" method="POST" action="validarLogin.php">
					  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 col-sm-offset-1 col-xs-2 col-xs-offset-1 control-label">Login</label>
					    	<div class="col-sm-8 col-xs-8">
					      	<input type="text" class="form-control" name="login" placeholder="Nome">
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="inputPassword3" class="col-sm-2 col-sm-offset-1 col-xs-2 col-xs-offset-1 control-label">Senha</label>
					    	<div class="col-sm-8 col-xs-8">
					      		<input type="password" class="form-control" name="senha" placeholder="Senha">
					    	</div>
					  	</div>
					  	<div class="col-sm-3 col-sm-offset-3">
					    	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Entrar</button>
					    </div>
					</form>			        		
				    <div class="col-sm-6">
						<a href="recuperaSenha.php"><small>esqueceu sua senha?</small></a>
					</div>
	        	</div>
	        	<div class="row">
	        	</div>
	        </div>
        </div>
	</div>
</div>

<?php include_once("../footer.php") ?>