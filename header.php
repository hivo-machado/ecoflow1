<?php include_once("conexao.php"); ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>ECOflow</title>
	<!-- Icone de pagina-->
	<link rel="icon" href="../img/ECOFlow.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="../img/ECOFlow.ico" type="image/x-icon" />

	<!-- Links para Bootsrap -->
	<link rel="stylesheet"  href="../css/bootstrap.css">
	<link rel="stylesheet"  href="../css/bootstrap-theme.css">
	<link rel="stylesheet"  href="../css/meutema.css">

	<!--Links para grafico Chart-->
	<script src="../js/Chart.js"></script>	
</head>
<body>

<div id="tudo">
<!-- Div para navbar -->
<div id="topo">
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>

		      <a href="../index.php" class="navbar-brand">
		      	<div id="barnav">
		      		<img alt="Brand" src="../img/ECOFlow.ico" height="30">
		      		<strong>ECO</strong>flow
		      	</div>
		      </a>
		    </div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="dropdown">
			          <a href="#" class="dropdown-toggle" id="barnav" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			          	Relatório
			          	<span class="caret"></span>
			          </a>
			          <ul class="dropdown-menu">
			            <li>
			            	<a href="../relatorio/graficoMes.php">Mês</a>
			            </li>
			            <li>
			            	<a href="../relatorio/graficoAno.php">Ano</a>
			            </li>
			          </ul>
			        </li>
				</ul>				
				<ul class="nav navbar-nav navbar-right">
					<?php 
					if( !isset($_SESSION["idecoflow"])){
						?>
						<li>
							<a id="barnav" href="../login/validaLogin.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Entrar</a>
						</li>
					<?php }else{ ?>
						<li>
							<li class="dropdown">
					          <a id="barnav" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
					          	<span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
					          	<?php echo $_SESSION["login"] ?> 
					          	<span class="caret"></span>
					          </a>
					          <ul class="dropdown-menu">
					            <li>
					            	<a href="../login/alteraEmail.php">
						            	<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
						            	E-mail
					            	</a>
					            </li>
						        <li>
						        	<a href="../login/alteraConta.php"> 
						        	<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						        	Conta
						        	</a>
						        </li>
						        <li role="separator" class="divider"></li>
						        <li>
						        	<a href="../sair.php">
						        		<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 
						        		Sair
						        	</a>
						        </li>
					          </ul>
					        </li>
						</li>
					<?php } ?>
				</ul>				
			</div>
		</div>
	</nav>
</div>


<div id="conteudo">
	<div class="container-fluid">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="row">
				<div class="mensagme text-center col-sm-8 col-sm-offset-2">
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


	

