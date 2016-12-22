<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("consumo.php"); 
?>

<?php 
  // Variaveis da sessão
  $id = $_SESSION['idecoflow'];
  $nome = $_SESSION['nome'];

  //Mes e ano atual
  date_default_timezone_set('UTC');
  if(isset($_POST['mes'])){
    $mes = $_POST['mes'];
    $dia = $_POST['dia'];
    $ano = $_POST['ano'];
  }else{
    $dia = 1;
    $mes = date("m");
    $ano = date("Y");  
  }
?>


<!--API  do google para criação de graficos-->
<script>
  google.charts.load('current', {packages: ['corechart', 'line']});
  google.charts.setOnLoadCallback(drawBasic);

  function drawBasic() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Dia');
    data.addColumn('number', 'Água fria');

    data.addRows([
      <?php echo consumoDia($con, $id, $ano, $mes); ?>
    ]);

    var options = {
      hAxis: {
        title: 'Dia',
        //baseline:31,
        
        gridlines: {
          count:30,
        }
      },
      vAxis: {
        title: 'm³'
      },
      //width: 900,
      //height: 300,
      title:'Consumo Diário de Água do mês: <?php echo $mes ?>',
    };  

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>

<!--Nome da Unidade-->
<div class="row">
  <div class="col-md-4">
      <?php 
        echo '<h3> Unidade: '.$nome.'</h3>';
       ?>  
  </div>
</div>

<div class="row">
  <form class="form-inline" method="POST" action="graficoMes.php">
      <div class="form-group">
        <label>Dia</label>
        <select class="form-control" name="dia">
          <?php
            $numDiaMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
            for($i = 1; $i <= $numDiaMes; $i++){
              if($i == $dia) $seleciona = 'selected'; else $seleciona = '';
              echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
            }
           ?>
        </select>      
      </div>

      <div class="form-group">
        <label>Mês</label>
        <select class="form-control" name="mes">
          <?php 
            for($i = 1; $i <= 12; $i++){
              if($i == $mes) $seleciona = 'selected'; else $seleciona = '';
              echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
            }
           ?>
        </select>      
      </div>

      <div class="form-group">
        <label>Ano</label>
        <select class="form-control" name="ano">
          <?php
            $numAno = date("Y");
            for($i = 2016; $i <= $numAno; $i++){
              if($i == $ano) $seleciona = 'selected'; else $seleciona = '';
              echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
            }
           ?>
        </select>      
      </div>

      <button type="submit" class="btn btn-default">Aplicar</button>
  </form>
</div>

<!-- Div do plota grafico -->
<div class="row">
  <div class="col-md-12">
    <div id="chart_div"></div>
  </div>
</div>

<!--Consumo Total do mês-->
<div class="row">
  <div class="col-md-4">
    <?php 
      echo '<h4>Consumo total do mês: '.consumoTotalMes($con, $id, $ano, $mes, $dia).'</h4>';  
    ?>
  </div>
</div>

<?php include_once("../footer.php") ?>