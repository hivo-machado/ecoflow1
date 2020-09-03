<?php
  include_once("../conexao.php");
  include_once("funcaoDevice.php"); // php com funções

  // Variaveis da sessão
  if (!isset($_SESSION)) {
    session_start();
  }

  //Variavel POST
  $mes = $_POST['mes'];
  $dia = $_POST['dia'];
  $ano = $_POST['ano'];
  $device = $_POST['device'];
  
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
  //Status da bateria
  $bateria = statusBateria($con, $device, $ano, $mes, $dia);
  //Status da potencia
  $rssi = statusRssi($con, $device, $ano, $mes, $dia);
  //Status da interferencia
  $snr = statusSnr($con, $device, $ano, $mes, $dia);

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
      labels: <?php echo qtdDias($bateria, $ano, $mes ); ?>,
      datasets: [
        {
          label: "Bateria",
          fill: true,
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "rgba(255,215,71,1)",
          borderWidth: 4,
          borderCapStyle: 'butt',
          borderJoinStyle: 'miter',
          pointBorderColor: "rgba(255,215,71,1)",
          pointBorderWidth: 1,
          pointRadius: 1,
          pointHitRadius: 10,
          pointStyle: "circle",
          pointHoverRadius: 4,
          pointHoverBackgroundColor: "rgba(255,215,71,1)",
          pointHoverBorderColor: "rgba(255,215,71,1)",
          pointHoverBorderWidth: 2,
          data: <?php echo statusGrafico($bateria, $ano, $mes ); ?>,
          spanGaps: false,
        },
        {
          label: "RSSI",
          fill: true,
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "rgba(111,255,71,1)",
          borderWidth: 4,
          borderCapStyle: 'butt',
          borderJoinStyle: 'miter',
          pointBorderColor: "rgba(111,255,71,1)",
          pointBorderWidth: 1,
          pointRadius: 1,
          pointHitRadius: 10,
          pointStyle: "circle",
          pointHoverRadius: 4,
          pointHoverBackgroundColor: "rgba(111,255,71,1)",
          pointHoverBorderColor: "rgba(111,255,71,1)",
          pointHoverBorderWidth: 2,
          data: <?php echo statusGrafico($rssi, $ano, $mes ); ?>,
          spanGaps: false,
        },
        {
          label: "SNR",
          fill: true,
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "rgba(215,71,255,1)",
          borderWidth: 4,
          borderCapStyle: 'butt',
          borderJoinStyle: 'miter',
          pointBorderColor: "rgba(215,71,255,1)",
          pointBorderWidth: 1,
          pointRadius: 1,
          pointHitRadius: 10,
          pointStyle: "circle",
          pointHoverRadius: 4,
          pointHoverBackgroundColor: "rgba(215,71,255,1)",
          pointHoverBorderColor: "rgba(215,71,255,1)",
          pointHoverBorderWidth: 2,
          data: <?php echo statusGrafico($snr, $ano, $mes ); ?>,
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

  <!--Observação-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <h6> RSSI: -30dBm (sinal forte) / -120dBm (sinal fraco);</h6>
      <h6> SNR: > 0dB (baixa interferencia) / < 0dB (forte interferencia);</h6>
    </div>
  </div>
  
</section>



<section class="area-tabela">

  <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1>Status Device<small> LoRaWAN: <?php echo $device ?></small></h1>
      </div>
    </div>
  </div>

 
  <!--Tabela de consumo do ano-->
  <div class="row marge-tabela">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading tabela-titulo"><strong>Status Diário no Mês de <?php echo $meses[$mes] ?></strong></div>
        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped tabela table-hover table-condensed">
            <tr>
              <th class="tabela-nome-coluna">Dia</th>
              <th class="tabela-nome-coluna">Bateria (mV)</th>
              <th class="tabela-nome-coluna">RSSI (dBm)</th>
              <th class="tabela-nome-coluna">SNR (dB)</th>
            </tr>

            <?php
              for($i = 1; $i <= $numDiasMes; $i++){
            ?>
            <tr>
              <td><?= date('d/m/Y',strtotime($bateria[1][$i]) ) ?></td>
              <td><?= $bateria[0][$i] ?></td>
              <td><?= $rssi[0][$i] ?></td>
              <td><?= $snr[0][$i] ?></td>
            </tr>
            <?php
             } 
            ?>
            <tr class="info">
              <td><strong>TOTAL</strong></td>
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