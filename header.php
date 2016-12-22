<?php include_once("conexao.php"); ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>ECOflow</title>

	<!-- Links para Bootsrap -->
	<link rel="stylesheet"  href="../css/bootstrap.css">
	<link rel="stylesheet"  href="../css/bootstrap-theme.css">

	<!-- Script para API do google gera grafico -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
</head>
<body>

<!-- Div para navbar -->
<div>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="../index.php" class="navbar-brand"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> HOME</a></li>
					<li>
						<li class="dropdown">
				        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gráfico <span class="caret"></span></a>
				         	<ul class="dropdown-menu">
				            <li><a href="../relatorio/graficoMes.php">Mês</a></li>
				            <li><a href="../relatorio/graficoAno.php">Ano</a></li>
				          </ul>
				        </li>
					</li>
				</ul>				
				<ul class="nav navbar-nav navbar-right">
					<?php 
					if( !isset($_SESSION["idecoflow"])){
						?>
						<li>
							<a href="../login/validaLogin.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Entrar</a>
						</li>
					<?php }else{ ?>
						<li>
							<li class="dropdown">
					        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $_SESSION["login"] ?> <span class="caret"></span></a>
					         	<ul class="dropdown-menu">
					         	<li><a href="../login/alteraEmail.php"> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> E-mail</a></li>
					            <li><a href="../login/alteraConta.php"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Conta</a></li>
					            <li role="separator" class="divider"></li>
					            <li><a href="../sair.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sair</a></li>
					          </ul>
					        </li>
						</li>
					<?php } ?>
				</ul>				
			</div>
		</div>
	</nav>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	
	


	

