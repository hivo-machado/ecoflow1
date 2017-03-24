<?php 
include_once("../header.php"); 
include_once('../validar.php');
include_once('../conexao.php');
?>

<?php 
	//função para verificar se esta logado
	valida();
 ?>

 <?php
 	//Varival de sessão
	$id_unidade = $_SESSION['id_unidade'];
	$id_grupo = $_SESSION['id_grupo'];
	$tipo = $_SESSION['tipo'];

	//Inicializando Variavel
	$nome = 'Nome';
	$rua = 'Rua';
	$numero = '000';
	$bairro = 'Bairro';
	$cidade = 'Cidade';
	$estado = 'UF';
	$cep = '00000-000';
	$telefone = '(00) 00000-0000';
	$imagem = 'sem-imagem.jpg';

	if($tipo == 'usuario'){
		//Select para informações do grupo
		$result = mysqli_query($con, "SELECT * FROM grupo LEFT JOIN planta on planta.id_grupo_fk = grupo.id LEFT JOIN unidade on unidade.id_planta_fk = planta.idecoflow WHERE unidade.idecoflow = '$id_unidade' LIMIT 1");
	}else{
		$result = mysqli_query($con, "SELECT * FROM grupo where id = '$id_grupo'");
	}

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

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-xs-12">
		<div class="page-header">
		  <h2><?php echo $nome ?></h2>
		</div>
	</div>
</div>

<!--Informações do grupo-->
<div class="row" id="grupo-info">

	<!--Coluna da imagem do grupo-->
	<div class="col-sm-7 col-xs-12">
		<?php  if($tipo == 'usuario'){ ?>
			<a href="../relatorio/relatorioMes.php">
		<?php }else{ ?>
			<a href="../relatorio/listaPlanta.php">
		<?php } ?>
			<img src=<?php echo '../img/grupo/'.$imagem ?> alt="Nome do Empredimento" class="img-responsive img-thumbnail" id="img-grupo">
		</a>
	</div>

	<!--Coluna de endereço do grupo-->
	<div class="col-sm-5 col-xs-6">
		<div class="col-sm-8">
			<h2>Menu</h2>
			<ul class="nav nav-pills nav-stacked">
			  <li role="presentation" class="active"><a href="#">Home</a></li>
			  <?php if($tipo == 'usuario'){ ?>
			  	<li role="presentation"><a href="../relatorioCliente/relatorioMes.php">Consumo Mês</a></li>
			  	<li role="presentation"><a href="../relatorioCliente/relatorioAno.php">Consumo Ano</a></li>
			  <?php } ?>
			  <?php if($tipo == 'sind'){ ?>
			  	<li role="presentation"><a href="../relatorioAdm/listaPlanta.php">Consumo Água e Gás por Torre</a></li>
			  	<li role="presentation"><a href="../relatorioAdm/grupoConsumoAgua.php">Consumo Água por Grupo</a></li>
			  	<li role="presentation"><a href="../relatorioAdm/grupoConsumoGas.php">Consumo Gás por Grupo</a></li>
			  <?php } ?>
			</ul>
		</div>
	</div>

	<div class="col-sm-12 col-xs-6">
		<address>
			<strong>Endereço</strong><br>
			<?php echo $rua.' '.$numero.' - '.$bairro?><br>
			<?php echo $cidade.', '.$estado.' '.$cep ?><br>
			<abbr title="Telefone">Tel.:</abbr> <?php echo $telefone ?>
		</address>
		<?php if($tipo == 'sind'){ ?>
			<a class="btn btn-primary" href="../grupo/alteraGrupo.php" role="button">Alterar dados</a>
			<span id="helpBlock" class="help-block">Alterar nome, foto e endereço.</span>
		<?php } ?>
	</div>

</div>

<?php include_once("../footer.php") ?>