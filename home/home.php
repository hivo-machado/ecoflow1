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

<div class="row">

	<div class="col-sm-8 col-xs-12">
		<img src="../img/predio1.jpg" alt="Nome do Empredimento" class="img-responsive img-thumbnail">
	</div>

	<div class="col-sm-4 col-xs-12">

		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="page-header">
				  <h1>Nome do Grupo</h1>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<address>
				  <strong>Endereço</strong><br>
				  1355 Market Street<br>
				  San Francisco, CA 94103<br>
				  <abbr title="Phone">P:</abbr> (123) 456-7890
				</address>
			</div>			
		</div>

	</div>
</div>	

<div class="row">
	<div class="col-sm-12 col-xs-12">
		
	</div>
</div>

<?php include_once("../footer.php") ?>