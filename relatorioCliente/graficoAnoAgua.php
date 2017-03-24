<?php 
  include_once("../conexao.php");
  include_once("funcaoAno.php"); //php com funções
?>

<?php 
  // Variaveis da sessão
  session_start();
  $nome = $_SESSION['nome'];

  //Varivel POST
  $ano = $_POST['ano'];

  //Vetor consumo do ano
  $consumosAguaFria = consumo($con, $nome, 0, $ano);
  $consumosAguaQuente = consumo($con, $nome, 1, $ano);
  //Total consumo do ano
  $totalAguaFria = consumoTotal($consumosAguaFria);
  $totalAguaQuente = consumoTotal($consumosAguaQuente);

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
?>

<!--Configuração do Grafico Chart-->
<script type="text/javascript">
  var options = {
      responsive:true,
      legend: {
        display: true,
        position: "bottom",
    }
  };

  var data = {
      labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
      datasets: [
        {
          label: "Água Fria",
          fill: true,
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "rgba(77,144,254,1)",
          borderWidth: 4,
          borderCapStyle: 'butt',
          borderJoinStyle: 'miter',
          pointBorderColor: "rgba(77,144,254,1)",
          pointBorderWidth: 1,
          pointRadius: 1,
          pointHitRadius: 10,
          pointStyle: "circle",
          pointHoverRadius: 4,
          pointHoverBackgroundColor: "rgba(77,144,254,1)",
          pointHoverBorderColor: "rgba(77,144,254,1)",
          pointHoverBorderWidth: 2,
          data: <?= consumoGrafico($con, $consumosAguaFria, $ano); ?>,
          spanGaps: false,
        },
        {
          label: "Água Quente",
          fill: true,
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "rgba( 217, 83, 79,1)",
          borderWidth: 4,
          borderCapStyle: 'butt',
          borderJoinStyle: 'miter',
          pointBorderColor: "rgba(  217, 83, 79,1)",
          pointBorderWidth: 1,
          pointRadius: 1,
          pointHitRadius: 10,
          pointStyle: "circle",
          pointHoverRadius: 4,
          pointHoverBackgroundColor: "rgba(217, 83, 79,1)",
          pointHoverBorderColor: "rgba( 217, 83, 79,1)",
          pointHoverBorderWidth: 2,
          data: <?= consumoGrafico($con, $consumosAguaQuente, $ano); ?>,
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

  <!--Consumo Total do Ano-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <h3>Total de <?php echo $ano.': '.($totalAguaFria + $totalAguaQuente).' m³' ?></h3>
    </div>
  </div>

</section>

<section class="area-tabela">
  
  <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1>Consumo Água<small> unidade: <?php echo $nome ?></small></h1>
      </div>
    </div>
  </div>

  <!--Tabela de consumo do ano-->
  <div class="row marge-tabela">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading tabela-titulo"><strong>Consumo Mensal de Água no Ano de <?php echo $ano ?></strong></div>
        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover table-condensed tabela">
            <tr>
              <th class="tabela-nome-coluna">#</th>
              <th class="tabela-nome-coluna">Mês</th> 
              <th class="tabela-nome-coluna">Água Fria (m³)</th>
              <th class="tabela-nome-coluna">Água Quente (m³)</th>
              <th class="tabela-nome-coluna">SUBTOTAL</th>
            </tr>

            <?php
              for($i = 1; $i < 13; $i++){
            ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $meses[$i] ?></td> 
              <td><?= $consumosAguaFria[$i] ?></td>
              <td><?= $consumosAguaQuente[$i] ?></td>
              <td><?= $consumosAguaFria[$i] + $consumosAguaQuente[$i] ?></td>
            </tr>
            <?php
             } 
            ?>
            <tr class="info">
              <td colspan="2"><strong>TOTAL</strong></td>
              <td><?= $totalAguaFria ?></td>
              <td><?= $totalAguaQuente ?></td>
              <td><?= $totalAguaFria + $totalAguaQuente ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>