<?php 
include_once("../header.php");
include_once("../validar.php");
include_once("../validaAdmin.php");
?>

<?php 
	//variavel de sessão
	$id = $_SESSION['id'];
 ?>

<!--Menssagem de Alerta-->
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

<?php 

	if (isset($_POST['busca'];)) {
		$busca = $_POST['busca'];
		$resultado = mysqli_query($con, "SELECT * FROM projeto where status = 'candidato' and (codigo = '$cod' or nome_p like'%$cod%')");
	}

 ?>

<div class="row">
	<div class="col-sm-7 col-sm-offset-4 col-xs-12 col-xs-offset-0">
		<form class="form-inline" method="POST" action="buscaUsuario.php">

			<div class="form-group">
				<label for="busca">Pesquisar</label>
				<input type="search" class="form-control" id="busca" name="busca" autofocus>
			</div>

			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar</button>

		</form>
	</div>
</div>


 <?php include_once("../footer.php") ?>