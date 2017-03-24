<?php
  include_once("../conexao.php");
  include_once("funcaoMes.php"); // php com funções
?>

<?php 
  // Variaveis da sessão
  session_start();
  $nome = $_SESSION['nome'];

  //Variavel POST
  $mes = $_POST['mes'];
  $dia = $_POST['dia'];
  $ano = $_POST['ano'];

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

  //Numero de dias do mes
  $numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
  //Consumo de dias
  $consumosGas = consumo($con, $nome, 2, $ano, $mes, $dia);
  //Consumo Total do mes
  $totalGas = consumoTotal($consumosGas, $ano, $mes);

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
      labels: <?php echo qtdDias($consumosGas, $ano, $mes ); ?>,
      datasets: [
        {
          label: "Gás",
          fill: true,
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "rgb(92,184,92)",
          borderWidth: 4,
          borderCapStyle: 'butt',
          borderJoinStyle: 'miter',
          pointBorderColor: "rgb(92,184,92)",
          pointBorderWidth: 1,
          pointRadius: 1,
          pointHitRadius: 10,
          pointStyle: "circle",
          pointHoverRadius: 4,
          pointHoverBackgroundColor: "rgb(92,184,92)",
          pointHoverBorderColor: "rgb(92,184,92)",
          pointHoverBorderWidth: 2,
          data: <?php echo consumoGrafico($consumosGas, $ano, $mes ); ?>,
          spanGaps: false,
        }
      ]
  };

  
  var ctx = document.getElementById("GraficoLine").getContext("2d");
  var LineChart = new Chart.Line(ctx, {data: data, options: options});
  
  </script>


<section class="area-grafico">

  <!-- Div do plota grafico -->
  <div class="row marge-grafico">
    <div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">
      <canvas id="GraficoLine"></canvas>
    </div>
  </div>

  <!--Consumo Total do mês-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <h3>Total de <?php echo $meses[$mes].': '.$totalGas.' m³' ?> </h3>
    </div>
  </div>
  
</section>



<section class="area-tabela">

  <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1>Consumo Gás<small> unidade: <?php echo $nome ?></small></h1>
      </div>
    </div>
  </div>

 
  <!--Tabela de consumo do ano-->
  <div class="row marge-tabela">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading tabela-titulo"><strong>Consumo Diário de Gás no Mês de <?php echo $meses[$mes] ?></strong></div>
        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped tabela table-hover table-condensed">
            <tr>
              <th class="tabela-nome-coluna">Dia</th>
              <th class="tabela-nome-coluna">Gás (m³)</th>
            </tr>

            <?php
              for($i = 1; $i <= $numDiasMes; $i++){
            ?>
            <tr>
              <td><?= date('d/m/Y',strtotime($consumosGas[1][$i]) ) ?></td>
              <td><?= $consumosGas[0][$i] ?></td>
            </tr>
            <?php
             } 
            ?>
            <tr class="info">
              <td><strong>TOTAL</strong></td>
              <td><?= $totalGas ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>