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


<div class="jumbotron">
  <h1>Bem-vindo, <?php echo $nome ?></h1>
  <p>Sistema Administrativo ECOflow.</p>
</div>


<div class="row">

</div>

<?php include_once("../footer.php") ?>