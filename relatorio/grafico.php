<?php include_once("../header.php"); ?> 
<?php include_once("../validar.php"); ?>
<?php include_once("consumo.php"); ?>

<?php 
  // Variaveis da sessão
  $login = $_SESSION['login'];
  $nome = $_SESSION['nome'];

  //Mes e ano atual
  date_default_timezone_set('UTC');
  if(isset($_POST['mes'])){
    $mes = $_POST['mes'];
    $dia = $_POST['dia'];
    $ano = date("Y");
  }else{
    $dia = 1;
    $mes = date("m");
    $ano = date("Y");  
  }
?>
<div class="row">
  <?php 
    //Nome da Unidade
    echo '<h3> Unidade: '.$nome.'</h3>';
   ?>
</div>

<div class="row">
  <form class="form-inline" method="POST" action="grafico.php">
      <div class="form-group">
        <label>Dia</label>
        <select class="form-control" name="dia">
          <?php echo '<option value="'.$dia.'">'.$dia.'</option>' ?>;
          <?php
            $numDiaMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
            for($i = 1; $i <= $numDiaMes; $i++){
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
           ?>
        </select>      
      </div>

      <div class="form-group">
        <label>Mês</label>
        <select class="form-control" name="mes">
          <?php echo '<option value="'.$mes.'">'.$mes.'</option>' ?>;
          <?php 
            for($i = 1; $i <= 12; $i++){
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
           ?>
        </select>      
      </div>

      <button type="submit" class="btn btn-default">Aplicar</button>
  </form>
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
<div class="row">
  <div id="chart_div"></div>
</div>

<div class="row">
  <?php
    // Consumo Total do mês 
    echo '<p>'.consumoMes($con, $login, $ano, $mes, $dia).'</p>';  
  ?>
</div>

<?php include_once("../footer.php") ?>