<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("funcao.php"); //php com funções
?>

<?php 
  // Variaveis da sessão
  $id = $_SESSION['idecoflow'];
  $nome = $_SESSION['nome'];

  //Ano atual
  date_default_timezone_set('UTC');
  if(isset($_POST['ano'])){
    $ano = $_POST['ano'];
  }else{
    $ano = date("Y");  
  }

  //Total consumo do ano
  $total = consumoTotalAno($con, $id, $ano);

  //Vetor consumo do ano
  $consumos = consumoAno($con, $id, $ano);

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
            data: <?php echo consumoAnoGrafico($con, $id, $ano); ?>,
            spanGaps: false,
          }
      ]
  };

  window.onload = function(){
    var ctx = document.getElementById("GraficoLine").getContext("2d");
    var LineChart = new Chart.Line(ctx, {data: data, options: options});
  };
  </script>

<!--Cabeçalho do gráfico-->
<div class="row hidden-print">
  <div class="page-header">
    <h2>Gráfico de <?php echo $ano ?><small> unidade: <?php echo $nome ?></small></h2>
  </div>
</div>

<!--Campo Selecionavel-->
<div class="row hidden-print">
  <form class="form-inline" method="POST" action="graficoAno.php">
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

<!--Titulo do grafico-->
<div class="row hidden-print">
  <h4><strong> Consumo Mensal de Água no Ano de <?php echo $ano ?></strong></h4>
</div>

<!-- Div do plota grafico -->
<div class="row hidden-print">
  <div class="col-sm-12">
    <canvas id="GraficoLine"></canvas>
  </div>
</div>

<!--Consumo Total do Ano-->
<div class="row hidden-print">
  <div class="col-sm-12">
    <?php
      echo '<h5><strong>Consumo Total do Ano: </strong>'.$total.'</h5>';  
    ?>
  </div>
</div>

<!--Cabeçalho da tabela-->
<div class="row">
  <div class="page-header">
    <h2>Tabela de <?php echo $ano ?><small> unidade: <?php echo $nome ?></small></h2>
  </div>
</div>

<!--Campo Selecionavel-->
<div class="row hidden-print">
  <form class="form-inline" method="POST" action="graficoAno.php">
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

<!--Tabela de consumo do ano-->
<div class="row marge-tabela">
  <div class="col-sm-6 col-sm-offset-3">
    <div class="panel panel-primary">
      <div class="panel-heading tabela-titulo"><strong>Consumo Mensal de Água no Ano de <?php echo $ano ?></strong></div>
      <!-- Tabela -->
      <div class="table-responsive">
        <table class="table table-bordered table-striped tabela table-hover table-condensed">
          <tr>
            <th class="tabela-nome-coluna"></th>
            <th class="tabela-nome-coluna">Mês</th> 
            <th class="tabela-nome-coluna">Consumo (m³)</th>
          </tr>

          <?php
            for($i = 1; $i < 13; $i++){
          ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $meses[$i] ?></td> 
            <td><?php echo $consumos[$i] ?></td>
          </tr>
          <?php
           } 
          ?>
          <tr>
            <td colspan="2"><strong>TOTAL</strong></td>
            <td><?php echo $total ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once("../footer.php") ?>