<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("funcaoAno.php");
   
  //função para verificar se esta logado
  valida();
 
  // Variaveis da sessão
  $nome = $_SESSION['nome'];
?>

<script>

  $(document).ready(function(){
    
    $('#ano').change(function(){submit();});

    function submit(){
      $.ajax({
        url:'graficoAnoGas.php',
        type: 'POST',
        data: $('#data').serialize(),
        success: function(data){
          $('#relatorio').css({display:"block"});
          $('#relatorio').html(data);
        },
        beforeSend: function(){
          $('#relatorio').css({display:"none"});
          $('#carregando').css({display:"block"});
        },
        complete: function(){
          $('#carregando').css({display:"none"});
        }
      });
      return false;
    };

    //Data inicial
    var dataAtual = new Date();
    var mes = dataAtual.getMonth() + 1;//Ajusta mês de 0-11 para 1-12
    var ano = dataAtual.getFullYear();

    var i;
    var opcao;
    var seleciona;

     //Preencher option do ano
    for(i = 2016; i <= ano; i++ ){
      if(i == ano) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#ano').append(opcao);
    }

    submit();

  });
  
</script>

<!--Cabeçalho do gráfico-->
<div class="row">
  <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
    <div class="page-header">
      <h1>Consumo Gás<small> unidade: <?php echo $nome ?></small></h1>
    </div>
  </div>
</div>

<!--Campo Selecionavel-->
<div class="row hidden-print">
  <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
    <form id="data" class="form-inline" method="POST" action="">

        <div class="form-group form-group-sm">
          <label for="ano">Ano</label>
          <select class="form-control" id="ano" name="ano"></select>      
        </div>

    </form>
  </div>
</div>

<!--Local dos relatorios grafico e tabela-->
<div>
  <center><img src="../img/loader.gif" style="display: none" id="carregando"></center>
</div>
<div id="relatorio">
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