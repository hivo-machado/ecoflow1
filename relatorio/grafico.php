<?php include_once("../header.php"); ?> 
<?php include_once("../validar.php"); ?>
<?php include_once("consumo.php"); ?>

<script src="consumo.js"></script>

<?php 
  // Variaveis da sessão
  $login = $_SESSION['login'];
  $nome = $_SESSION['nome'];

  //Mes e ano atual
  date_default_timezone_set('UTC');
  $mes = date("m");
  $ano = date("Y");  
?>

<?php 
  //Nome da Unidade
  echo '<h3> Unidade: '.$nome.'</h3>';
 ?>
<div class="col-md-2">
  <select class="form-control" name="mes" id="mes" onchange="selecionaMes();">
    <option></option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>  
  </select>
</div>

<script>
    //API  do google para criação de graficos
  google.charts.load('current', {packages: ['corechart', 'line']});
  google.charts.setOnLoadCallback(drawBasic);

  function drawBasic() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Dia');
    data.addColumn('number', 'Consumo');

    data.addRows([
      <?php echo consumoDia($con, $login, $ano, $mes); ?>
    ]);

    var options = {
      hAxis: {
        title: 'Dia',
        //baseline:31,
        
        gridlines: {
          count:15,
        }
      },
      vAxis: {
        title: 'm³/s'
      },
      width: 900,
      height: 300,
      title:'Consumo Diário de Água do mês: <?php echo $mes ?>',
    };  

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>

<!-- Div do plota grafico -->
<div id="chart_div"></div>

<div>
  <?php
    // Consumo Total do mês 
    echo '<p>'.consumoMes($con, $login, $ano, $mes, 1).'</p>';  
  ?>
</div>

<p id="demo"></p>

<script>
  document.getElementById("demo").innerHTML = toCelsius(77);
</script>

<?php include_once("../footer.php") ?>