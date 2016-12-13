<?php include_once("../header.php") ?>

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

		<div class="row">		
			<div class="col-md-3 col-md-offset-4">
				<img src="../img/ECOFlow symbol.jpg" alt="Logo Ecoflow" class="img-responsive">
			</div>			
		</div>

		<div class="row">
		</div>

		<div class="row">	
	    	<div class="col-md-5 col-md-offset-3">
		        <div align="center" class="panel panel-default">        
			        <div class="panel-body">
				        <form class="form-horizontal" method="POST" action="validar.php">
						  <div class="form-group">
						    <label for="inputEmail3" class="col-md-2 col-md-offset-1 control-label">Login</label>
						    <div class="col-md-7">
						      <input type="text" class="form-control" name="login" placeholder="Nome">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-md-2 col-md-offset-1 control-label">Senha</label>
						    <div class="col-md-7">
						      <input type="password" class="form-control" name="senha" placeholder="Senha">
						    </div>
						  </div>
						  <div class="form-group">
						    <div class="col-md-3 col-md-offset-3">
						      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Entrar</button>
						    </div>
						  </div>
						</form>
			        </div>
		        </div>
	    	</div>
		</div>

<?php include_once("../footer.php") ?>