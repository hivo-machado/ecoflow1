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

  //Numero de dias do mes
  $numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
  //Consumo de dias
  $consumos = consumoMes($con, $id, $ano, $mes, $dia);
  //Consumo Total do mes
  $total = consumoTotalMes($consumos, $ano, $mes);

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
      labels: <?php echo qtdDias($consumos, $ano, $mes ); ?>,
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
            data: <?php echo consumoMesGrafico($consumos, $ano, $mes ); ?>,
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
  <div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">
    <div class="page-header">
      <h2>Gráfico de <?php echo $meses[$mes] ?><small> unidade: <?php echo $nome ?></small></h2>
    </div>
  </div>
</div>

<!--Campo selecionaveis-->
<div class="row hidden-print">
  <div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">
    <form class="form-inline" method="POST" action="graficoMes.php">
        <div class="form-group form-group-sm">
          <label for="dia">Dia</label>
          <select class="form-control" id="dia" name="dia">
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
          <label for="mes">Mês</label>
          <select class="form-control" id="mes" name="mes">
            <?php 
              for($i = 1; $i <= 12; $i++){
                if($i == $mes) $seleciona = 'selected'; else $seleciona = '';
                echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
              }
             ?>
          </select>      
        </div>
        <div class="form-group form-group-sm">
          <label for="ano">Ano</label>
          <select class="form-control" id="ano" name="ano">
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
</div>

<!-- Div do plota grafico -->
<div class="row marge-grafico">
  <div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">
    <canvas id="GraficoLine"></canvas>
  </div>
</div>

<!--Consumo Total do mês-->
<div class="row">
  <div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">
    <?php 
      echo '<h5> <strong>Consumo total do mês: </strong>'.$total.'</h5>';  
    ?>
  </div>
</div>

<!--Cabeçalho da tabela-->
<div class="row">
  <div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">
    <div class="page-header">
      <h2>Tabela de <?php echo $meses[$mes] ?><small> unidade: <?php echo $nome ?></small></h2>
    </div>
  </div>
</div>

<!--Campo selecionaveis-->
<div class="row hidden-print">
  <div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">
    <form class="form-inline" method="POST" action="graficoMes.php">
        <div class="form-group form-group-sm">
          <label for="dia1">Dia</label>
          <select class="form-control" id="dia1" name="dia">
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
          <label for="mes1">Mês</label>
          <select class="form-control" id="mes1" name="mes">
            <?php 
              for($i = 1; $i <= 12; $i++){
                if($i == $mes) $seleciona = 'selected'; else $seleciona = '';
                echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
              }
             ?>
          </select>      
        </div>
        <div class="form-group form-group-sm">
          <label for="ano1">Ano</label>
          <select class="form-control" id="ano1" name="ano">
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
            <td><?php echo date('d-m-Y',strtotime($consumos[1][$i]) ) ?></td>
            <td><?php echo $consumos[0][$i] ?></td>
          </tr>
          <?php
           } 
          ?>
          <tr class="info">
            <td><strong>TOTAL</strong></td>
            <td><?php echo $total ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<!--Botão imprimir-->
<div class="row hidden-print hidden-xs">
  <div class="col-sm-2 col-sm-offset-8">
    <form>
      <button type="button" class="btn btn-primary" name="imprimir" value="Imprimir" onclick="window.print();"><span class="glyphicon glyphicon-print" arian-hidden="true"></span> Imprimir</button>
    </form>
  </div>
</div>

<?php include_once("../footer.php") ?>