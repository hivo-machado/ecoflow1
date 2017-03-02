<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("funcaoAno.php"); //php com funções
?>

<?php 
  //função para verificar se esta logado
  valida();
 ?>

<?php 
  // Variaveis da sessão
  $id_unidade = $_SESSION['id_unidade'];
  $nome = $_SESSION['nome'];

  //Iniciar time zone
  date_default_timezone_set('America/Sao_Paulo');

  $ano = date("Y");

?>

<script>

  $(document).ready(function(){
    $('#ano').change(function() {
      $.ajax({
        url:'graficoAno.php',
        type: 'POST',
        data: $('#data').serialize(),
        success: function(data){
          $('#relatorio').html(data);
        },
        beforeSend: function(){
          $('#carregando').css({display:"block"});
        },
        complete: function(){
          $('#carregando').css({display:"none"});
        }
      });
      return false;
    });
  });

  window.onload = function(){
    $.ajax({
      url:'graficoAno.php',
      type: 'POST',
      data: $('#data').serialize(),
      success: function(data){
        $('#relatorio').html(data);
      },
      beforeSend: function(){
        $('#carregando').css({display:"block"});
      },
      complete: function(){
        $('#carregando').css({display:"none"});
      }
    });
    return false;
  };
  
</script>

<!--Cabeçalho do gráfico-->
<div class="row">
  <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
    <div class="page-header">
      <h1>Consumo do Ano<small> unidade: <?php echo $nome ?></small></h1>
    </div>
  </div>
</div>

<!--Campo Selecionavel-->
<div class="row hidden-print">
  <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
    <form id="data" class="form-inline" method="POST" action="">

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

    </form>
  </div>
</div>

<div id="relatorio">
  <center><img src="../img/loader.gif" style="display: none" id="carregando"></center>
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