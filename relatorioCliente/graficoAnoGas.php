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
  $consumosGas = consumo($con, $nome, 2, $ano);
  //Total consumo do ano
  $totalGas = consumoTotal($consumosGas);

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
          data: <?= consumoGrafico($con, $consumosGas, $ano); ?>,
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
      <h3>Total de <?php echo $ano.': '.$totalGas.' m³' ?></h3>
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
        <div class="panel-heading tabela-titulo"><strong>Consumo Mensal de Gás no Ano de <?php echo $ano ?></strong></div>
        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover table-condensed tabela">
            <tr>
              <th class="tabela-nome-coluna">#</th>
              <th class="tabela-nome-coluna">Mês</th> 
              <th class="tabela-nome-coluna">Gás (m³)</th>
            </tr>

            <?php
              for($i = 1; $i < 13; $i++){
            ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $meses[$i] ?></td> 
              <td><?= $consumosGas[$i] ?></td>
            </tr>
            <?php
             } 
            ?>
            <tr class="info">
              <td colspan="2"><strong>TOTAL</strong></td>
              <td><?= $totalGas ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>