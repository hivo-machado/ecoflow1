<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("consumo.php"); // php com funções
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

<!--Função Grafico Chart-->
<script type="text/javascript">
  var options = {
    responsive:true
  };

  var data = {
      labels: <?php echo qtdDias($ano, $mes); ?>,
      datasets: [
          {
            label: "Água",
            fill: true,
            fillColor: "rgba(77,144,254,0.3)",
            lineTension: 0.1,
            backgroundColor: "rgba(77,144,254,0.4)",
            borderColor: "rgba(77,144,254,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(77,144,254,1)",
            pointBackgroundColor: "#ffffff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(255,255,255,1)",
            pointHoverBorderColor: "rgba(77,144,254,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo consumoMes($con, $id, $ano, $mes); ?>,
            spanGaps: false,
        }
      ]
  };

  window.onload = function(){
    var ctx = document.getElementById("GraficoLine").getContext("2d");
    var LineChart = new Chart.Line(ctx, {data: data, options: options});
  };
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
      <div class="form-group form-group-sm">
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
      <div class="form-group form-group-sm">
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
      <div class="form-group form-group-sm">
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
      <button type="submit" class="btn btn-primary btn-sm">Aplicar</button>
  </form>
</div>

<!--Titulo do grafico-->
<div class="row">
  <h4><strong> Consumo Diário de Água no Mês de <?php echo $meses[$mes] ?></strong></h4>
</div>
<!-- Div do plota grafico -->
<div class="row">
  <div class="col-sm-12">
    <canvas id="GraficoLine" width="100%" height="40%"></canvas>
  </div>
</div>

<!--Consumo Total do mês-->
<div class="row">
  <div class="col-sm-12">
    <?php 
      echo '<h5> <strong>Consumo total do mês: </strong>'.consumoTotalMes($con, $id, $ano, $mes, $dia).'</h5>';  
    ?>
  </div>
</div>

<?php include_once("../footer.php") ?>