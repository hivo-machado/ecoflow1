<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("consumo.php"); //php com funções
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

<!--Função Grafico Chart-->
<script type="text/javascript">
  var options = {
      responsive:true
  };

  var data = {
      labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
      datasets: [
          {
              label: "Dados agua fria",
              fillColor: "rgba(77,144,254,0.3)",
              strokeColor: "#4d90fe",
              pointColor: "#4d90fe",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "#4d90fe",
              data: <?php echo consumoAno($con, $id, $ano); ?>
          }
      ]
  };

  window.onload = function(){
      var ctx = document.getElementById("GraficoLine").getContext("2d");
      var LineChart = new Chart(ctx).Line(data, options);
  };
  </script>

<!--Cabeçalho da pagina-->
<div class="row">
  <div class="page-header">
    <h2>Consumo de <?php echo $ano ?><small> unidade: <?php echo $nome ?></small></h2>
  </div>
</div>

<!--Campo Selecionavel-->
<div class="row">
  <form class="form-inline" method="POST" action="graficoAno.php">
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
  <h4><strong> Consumo Mensal de Água no Ano de <?php echo $ano ?></strong></h4>
</div>
<!-- Div do plota grafico -->
<div class="row">
  <div class="col-sm-12">
    <canvas id="GraficoLine" width="100%" height="35%"></canvas>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <?php
      // Consumo Total do Ano
      echo '<h5><strong>Consumo Total do Ano: </strong>'.consumoTotalAno($con, $id, $ano).'</h5>';  
    ?>
  </div>
</div>

<?php include_once("../footer.php") ?>