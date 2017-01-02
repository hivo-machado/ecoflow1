<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("consumo.php"); 
?>

<?php 
  // Variaveis da sessão
  $id = $_SESSION['idecoflow'];
  $nome = $_SESSION['nome'];

  //vetor nome dos meses
  $meses = array(
    1 =>'Janeiro',
    'Fevereiro',
    'Março',
    'Abril',
    'Maio',
    'Junho',
    'Julho',
    'Agosto',
    'Setembro',
    'Outubro',
    'Novembro',
    'Dezembro'
  );

  //Mes e ano atual
  date_default_timezone_set('UTC');
  if(isset($_POST['mes'])){
    $mes = $_POST['mes'];
    $dia = $_POST['dia'];
    $ano = $_POST['ano'];
  }else{
    $dia = 1;
    $mes = date("n"); // mes sem 0 a esquerda
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
    data.addColumn('number', 'Água');

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
      title:'Consumo Diário de Água do mês.',
    };  

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>

<!--Cabeçalho da pagina-->
<div class="row">
  <div class="page-header">
    <h2>Consumo de <?php echo $meses[$mes] ?><small> unidade: <?php echo $nome ?></small></h2>
  </div>
</div>

<!--Campo selecionaveis-->
<div class="row">
  <form class="form-inline" method="POST" action="graficoMes.php">
      <div class="form-group">
        <strong>Dia</strong>
        <select class="form-control input-sm" name="dia">
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
        <strong>Mês</strong>
        <select class="form-control input-sm" name="mes">
          <?php 
            for($i = 1; $i <= 12; $i++){
              if($i == $mes) $seleciona = 'selected'; else $seleciona = '';
              echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
            }
           ?>
        </select>      
      </div>
      <div class="form-group">
        <strong>Ano</strong>
        <select class="form-control input-sm" name="ano">
          <?php
            $numAno = date("Y");
            for($i = 2016; $i <= $numAno; $i++){
              if($i == $ano) $seleciona = 'selected'; else $seleciona = '';
              echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
            }
           ?>
        </select>      
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Aplicar</button>
  </form>
</div>

<!-- Div do plota grafico -->
<div class="row">
  <div class="col-sm-12">
    <div id="chart_div"></div>
  </div>
</div>

<!--Consumo Total do mês-->
<div class="row">
  <div class="col-sm-12">
    <?php 
      echo '<h5> <strong>Consumo total do mês: </strong>'.number_format(consumoTotalMes($con, $id, $ano, $mes, $dia), 3, ',', '.').' m³</h5>';  
    ?>
  </div>
</div>

<?php include_once("../footer.php") ?>