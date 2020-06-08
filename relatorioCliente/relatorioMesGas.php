<?php 
  include_once("../header.php");
  include_once("../validar.php");
  
  //função para verificar se esta logado
  valida();

  // Variaveis da sessão
  $nome = $_SESSION['nome'];

?>

<script>

  $(document).ready(function(){

    $('#dia').change(function(){submit()(); });
    $('#mes').change(function(){submit()(); mudarDia(); });
    $('#ano').change(function(){submit()(); mudarDia(); });

    function submit(){
      $.ajax({
        url:'graficoMesGas.php',
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

    //Mudar preenchimento do select dia quando mudar mes e ano
    function mudarDia(){
      var i;
      var opcao;
      var dia = $('#dia').val();
      var mes = $('#mes').val();
      var ano = $('#ano').val();
      var ultimoDia = (new Date(ano, mes, 0)).getDate();
      //limpar as opções
      $('#dia').empty();

      //Preencher option do dia
      for(i = 1; i <= ultimoDia; i++ ){
        if(i == dia) var seleciona = ' selected '; else seleciona = '';
        opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
        $('#dia').append(opcao);
      }
    };

    //Data inicial
    var dataAtual = new Date();
    var mes = dataAtual.getMonth() + 1;//Ajusta mês de 0-11 para 1-12
    var ano = dataAtual.getFullYear();

    var i;
    var opcao;
    var seleciona;
    var ultimoDia = (new Date(ano, mes, 0)).getDate();

    //Preencher option do dia
    for(i = 1; i <= ultimoDia; i++ ){
      if(i == 1) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#dia').append(opcao);
    }

    //Preencher option do mes
    for(i = 1; i <= 12; i++ ){
      if(i == mes) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#mes').append(opcao);
    }

    //Preencher option do ano
    for(i = 2016; i <= ano; i++ ){
      if(i == ano) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#ano').append(opcao);
    }

    submit();

  });
  
</script>

  <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1>Consumo Gás<small> unidade: <?php echo $nome ?></small></h1>
      </div>
    </div>
  </div>

  <!--Campo selecionaveis-->
  <div class="row hidden-print">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <form id="data" class="form-inline" method="POST" action="">
          <div class="form-group form-group-sm">
            <label for="dia">Dia</label>
            <select class="form-control" id="dia" name="dia"></select>          
          </div>
          <div class="form-group form-group-sm">
            <label for="mes">Mês</label>
            <select class="form-control" id="mes" name="mes"></select>      
          </div>
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

</section>

<?php include_once("../footer.php") ?>