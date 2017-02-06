<?php 
include_once("../header.php"); 
include_once('../conexao.php');
?>

<?php
	//Valida se usuario esta logado 
	if(! isset ($_SESSION["idecoflow"])){	
		header("Location: ../login/validaLogin.php");		
	}
 ?>

 <?php
 	//Varival de sessão
	$idecoflow = $_SESSION['idecoflow'];
	//Inicializando Variavel
	$nome = 'Sem nome';
	$rua = 'Sem rua';
	$numero = '000';
	$bairro = 'Sem bairro';
	$cidade = 'Sem cidade';
	$estado = 'Sem estado';
	$cep = '00000-000';
	$telefone = '(00) 00000-0000';
	$imagem = '../img/sem-imagem.jpg';

	//Select para informações do grupo
	$result = mysqli_query($con, "SELECT * FROM grupo LEFT JOIN planta on planta.id_grupo_fk = grupo.id LEFT JOIN unidade on unidade.id_planta_fk = planta.idecoflow WHERE unidade.idecoflow = '$idecoflow' LIMIT 1");
	
	//variaveis
	if( $grupo = mysqli_fetch_object($result) ){
		if($grupo->nome_grupo != null) $nome = $grupo->nome_grupo;
		if($grupo->rua != null) $rua = $grupo->rua;
		if($grupo->numero != null) $numero = $grupo->numero;
		if($grupo->bairro != null) $bairro = $grupo->bairro;
		if($grupo->cidade != null) $cidade = $grupo->cidade;
		if($grupo->estado != null) $estado = $grupo->estado;
		if($grupo->cep != null) $cep = $grupo->cep;
		if($grupo->telefone != null) $telefone = $grupo->telefone;
		if($grupo->imagem != null) $imagem = $grupo->imagem;
	}

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


<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-xs-12">
		<div class="page-header">
		  <h2><?php echo $nome ?></h2>
		</div>
	</div>
</div>

<!--Informações do grupo-->
<div class="row" id="grupo">

	<!--Coluna da imagem do grupo-->
	<div class="col-sm-7 col-xs-7">
		<a href="../relatorio/graficoMes.php">
			<img src=<?php echo $imagem ?> alt="Nome do Empredimento" class="img-responsive img-thumbnail" id="img-grupo">
		</a>		
	</div>

	<!--Coluna de endereço do grupo-->
	<div class="col-sm-5 col-xs-5">
		<address>
			<strong>Endereço</strong><br>
			<?php echo $rua.' '.$numero ?><br>
			<?php echo $cidade.', '.$estado.' '.$cep ?><br>
			<abbr title="Telefone">Tel.:</abbr> <?php echo $telefone ?>
		</address>
	</div>

</div>

<?php include_once("../footer.php") ?>