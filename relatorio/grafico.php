<?php include_once("../header.php"); ?> 
<?php include_once("../validar.php"); ?>
<?php include_once("consumo.php"); ?>

<?php 
  date_default_timezone_set('UTC');

  $login = $_SESSION['login'];

  if(isset($_GET['mes']) ){
    $mes = $_GET['mes'];
    $ano = date("Y");
  }else{
    $mes = date("m");
    $ano = date("Y");
  }
?>

<!-- API  do google para criação de graficos-->
<script>
  google.charts.load('current', {packages: ['corechart', 'line']});
  google.charts.setOnLoadCallback(drawBasic);

  function drawBasic() {

  var data = new google.visualization.DataTable();
  data.addColumn('number', 'Dia');
  data.addColumn('number', 'Consumo');

  data.addRows([
    <?php 
      echo consumoDia($con, $login, $ano, $mes);
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
    title:'Consumo Diário de Água do mês: <?php echo $mes ?>',
  };  

  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

  chart.draw(data, options);
}
</script>

<!-- Div do plota grafico -->
<div id="chart_div"></div>

<?php 
  //echo '<p>'.consumoMes($con, $login, $ano, 11).'</p>';
?>


<?php include_once("../footer.php") ?>