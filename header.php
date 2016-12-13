<?php include_once("conexao.php") ?>
<?php include_once("grafico/consumo.php"); ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ECOflow</title>

	<link rel="stylesheet"  href="../css/bootstrap.css">
	<link rel="stylesheet"  href="../css/bootstrap-theme.css">

	 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {packages: ['corechart', 'line']});
          google.charts.setOnLoadCallback(drawBasic);

          function drawBasic() {

          var data = new google.visualization.DataTable();
          data.addColumn('number', 'Dia');
          data.addColumn('number', 'Consumo');

          data.addRows([
            <?php 
                for($i = 1; $i <= 31; $i++){
                    $str = '['.$i.','.consumoDia($con, $i).']';
                    if($i != 31) $str = $str.',';
                    echo $str;
                }
             ?>
          ]);

          var options = {
            hAxis: {
              title: 'Dia',
              baseline:31,
              
              gridlines: {
                count:16,
              }
            },
            vAxis: {
              title: 'm³/s'
            },
            width: 900,
            height: 300,
            title:'Consumo Diário de Água',
          };
          

          var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

          chart.draw(data, options);
        }
        </script>
</head>
<body>
<div>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li>
						<a href="../index.php" class="navbar-brand"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> HOME</a>
					</li>
					<!--
					<li>
						<li class="dropdown">
				        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuario <span class="caret"></span></a>
				         	<ul class="dropdown-menu">
				            <li><a href="../Usuario/buscaUsuario.php">Consultar</a></li>
				            <li><a href="../Usuario/alterarUsuario.php">Alterar</a></li>
				            <li><a href="../Usuario/desativarUsuario.php">Desativar</a></li>
				          </ul>
				        </li>
					</li>
					-->
				</ul>				
				<ul class="nav navbar-nav navbar-right">
					<?php 
					if( !isset($_SESSION["login"])){
						?>
					<li>
						<a href="../login/login.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Entrar</a>
					</li>
					<?php }else{ ?>
					<li>
						<a href="../sair.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sair</a>
					</li>
					<?php } ?>
				</ul>				
			</div>
		</div>
	</nav>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	
	


	

