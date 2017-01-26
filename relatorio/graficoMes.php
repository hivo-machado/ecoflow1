<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("funcao.php"); // php com funções
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

  //Consumo Total do mes
  $total = consumoTotalMes($con, $id, $ano, $mes);
  //Numero de dias do mes
  $numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
  //Consumo de dias
  $consumos = consumoMes($con, $id, $ano, $mes);
?>

<!--Função Grafico Chart-->
<script type="text/javascript">
  var options = {
    responsive:true,
    legend: {
        display: true,
        position: "bottom",
    }
  };

  var data = {
      labels: <?php echo qtdDias($ano, $mes); ?>,
      datasets: [
          {
            label: "Água",
            fill: true,
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
            pointStyle: "circle",
            data: <?php echo consumoMesGrafico($con, $id, $ano, $mes); ?>,
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
<div class="row hidden-print">
  <div class="page-header">
    <h2>Gráfico de <?php echo $meses[$mes] ?><small> unidade: <?php echo $nome ?></small></h2>
  </div>
</div>

<!--Campo selecionaveis-->
<div class="row hidden-print">
  <form class="form-inline" method="POST" action="graficoMes.php">
      <div class="form-group form-group-sm hidden">
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
<div class="row hidden-print">
  <h4><strong> Consumo Diário de Água no Mês de <?php echo $meses[$mes] ?></strong></h4>
</div>
<!-- Div do plota grafico -->
<div class="row hidden-print">
  <div class="col-sm-12">
    <canvas id="GraficoLine"></canvas>
  </div>
</div>

<!--Consumo Total do mês-->
<div class="row hidden-print">
  <div class="col-sm-12">
    <?php 
      echo '<h5> <strong>Consumo total do mês: </strong>'.$total.'</h5>';  
    ?>
  </div>
</div>

<!--Cabeçalho da tabela-->
<div class="row">
  <div class="page-header">
    <h2>Tabela de <?php echo $meses[$mes] ?><small> unidade: <?php echo $nome ?></small></h2>
  </div>
</div>

<!--Campo selecionaveis-->
<div class="row hidden-print">
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

<!--Tabela de consumo do ano-->
<div class="row marge-tabela">
  <div class="col-sm-6 col-sm-offset-3">
    <div class="panel panel-primary">
      <div class="panel-heading tabela-titulo"><strong>Consumo Diário de Água no Mês de <?php echo $meses[$mes] ?></strong></div>
      <!-- Tabela -->
      <div class="table-responsive">
        <table class="table table-bordered table-striped tabela table-hover table-condensed">
          <tr>
            <th class="tabela-nome-coluna">Dia</th>
            <th class="tabela-nome-coluna">Consumo (m³)</th>
          </tr>

          <?php
            for($i = 1; $i <= $numDiasMes; $i++){
          ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $consumos[$i] ?></td>
          </tr>
          <?php
           } 
          ?>
          <tr>
            <td><strong>TOTAL</strong></td>
            <td><?php echo $total ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once("../footer.php") ?>