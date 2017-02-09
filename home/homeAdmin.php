<?php 
include_once("../header.php"); 
include_once('../validar.php');
include_once('../conexao.php');
?>

<?php 
	//função para verificar se esta logado
	valida();
	//função para verificar se esta logado como administrador
	validaAdmin();
 ?>


 <?php 
 	//Variavel de sessão
 	$nome = $_SESSION['nome'];
  ?>



<!--Div para menssagem de alerta-->
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


<div class="jumbotron">
  <h1>Bem-vindo, <?php echo $nome ?></h1>
  <p>Sistema Administrativo ECOflow.</p>
</div>


<div class="row">

</div>

<?php include_once("../footer.php") ?>