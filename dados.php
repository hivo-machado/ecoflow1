<!DOCTYPE html>
<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> 
<html class="no-js lt-ie9 lt-ie8">
<html class="no-js lt-ie9"> 
<html class="no-js">
    <head>
        <meta charset="utf-8">
          <link rel="icon" href="img/6001icone.ico" type="image/x-icon" />
            <link rel="shortcut icon" type="img/x-icon" href="./icone.ico">
        <title>ECOflow</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/templatemo_misc.css">
        <link rel="stylesheet" href="css/templatemo_style.css">
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {packages: ['corechart', 'line']});
          google.charts.setOnLoadCallback(drawBasic);

          function drawBasic() {

          var data = new google.visualization.DataTable();
          data.addColumn('number', 'Dia');
          data.addColumn('number', 'Gasto');

          data.addRows([
            [0, 50],   [1, 50],  [2, 23],  [3, 17],  [4, 18],  [5, 9],
            [6, 11],  [7, 81],  [8, 33],  [9, 40],  [10, 32], [11, 35],
            [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
            [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
            [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
            [30, 55], [31, 60]
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
            title:'Gasto Diário de Água',
          };
          

          var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

          chart.draw(data, options);
        }
        </script>
    </head>
<body>
    <div class="bg-overlay"></div>
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-4 col-sm-12">
                <div class="sidebar-menu">
                    
                    <div class="logo-wrapper">
                        <h1 class="logo">
                            <a href="login.php"><img src="img/logologin.png" alt="ECOflow">
                            </a>
                        </h1>
                         <!-- /.row -->
                    </div> <!-- /.logo-wrapper -->
                    
                    <div class="menu-wrapper">
                        <ul class="menu">
                            <li><a class="show-1" href="#">Dados</a></li>
                            <li><a class="show-2" href="#">Gráfico</a></li>
                            <li><a class="show-3" href="#">Relatórios</a></li>
                            <li><a href="login.php" target="_parent">Sair</a></li>
                        </ul> 
                        <a href="" class="toggle-menu"><i class="fa fa-bars"></i></a>
                    </div>
                </div> 
            </div> 

            <div class="">
                
                <div id="menu-container">
                    <div id="menu-1" class="gallery content">
                        <div class="row">
                            <h3>Empreendimento:</h3><p><div> Porto Cidade </div>
                            <br>
                            <h3>Prédio:</h3><p><div> Porto de Santos </div>   
                            <br>
                            <h3>Apartamento:</h3><p><div> TA001 </div>   
                        </div> 
                    </div>
                    
                    <div id="menu-2" class="services content" >
                        <div class="row">
                            <header class="style1">
                            <p class="style1" id="chart_div"></p>
                            </header>
                        </div>
                    </div> 
                    <div id="menu-3" class="about content">
                        <div class="row">
                            <input type="text" style="background-color: #fff width:50px; "" value="Em Desenvolvimento" width="1000" class="tecnico" readonly="readonly" >
                        </div>
                    </div> 
                    

                    <div id="menu-4" class="contact content">
                        <div class="row">
                        	
                        </div> 
                    </div> 

                </div> 

            </div>

        </div> 
    </div> 
    
    <div class="container-fluid">   
        <div class="row">
            <div class="col-md-12 footer">
                <p id="footer-text">
                
                	Copyright &copy; 2016 <a href="index.html">Giovanni Caprio</a>
                 
                 </p>
            </div>
        </div>
    </div> 

    <script src="js/js/vendor/jquery-1.10.1.min.js"></script>
    <script src="js/js/main.js"></script>
</html>