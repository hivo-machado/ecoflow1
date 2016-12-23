<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("consumo.php"); 
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

?>

<script>
  //API  do google para criação de graficos
  google.charts.load('current', {packages: ['corechart', 'line']});
  google.charts.setOnLoadCallback(drawBasic);

  function drawBasic() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Mês');
    data.addColumn('number', 'Água');

    data.addRows([
      <?php echo consumoAno($con, $id, $ano); ?>
    ]);

    var options = {
      hAxis: {
        title: 'Mês',
        //baseline:31,
        
        gridlines: {
          count:12,
        }
      },
      vAxis: {
        title: 'm³'
      },
      //width: 900,
      //height: 300,
      title:'Consumo Mensal de Água no Ano: <?php echo $ano ?>',
    };  

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>

<!--Cabeçalho da pagina-->
<div class="page-header">
  <h2>Consumo de <?php echo $ano ?><small> unidade: <?php echo $nome ?></small></h2>
</div>

<!--Campo Selecionavel-->
<div class="row">
  <form class="form-inline" method="POST" action="graficoAno.php">
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
  <div class="col-xs-12">
    <div id="chart_div"></div>
  </div>
</div>

<div class="row">
  <div class="col-xs-5">
    <?php
      // Consumo Total do Ano
      echo '<h5><strong>Consumo Total do Ano: </strong>'.consumoTotalAno($con, $id, $ano).' m³</h5>';  
    ?>
  </div>
</div>

<?php include_once("../footer.php") ?>