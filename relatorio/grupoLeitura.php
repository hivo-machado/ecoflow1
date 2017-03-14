<?php 
  include_once("../header.php");
  include_once("../validar.php");

	//valida-se esta logado como Administrador ou sindico
	validaAdminSind();
 ?>

<?php 
	//variavel SESSAO
  $id = $_SESSION['id'];
	$tipo = $_SESSION['tipo'];

  if( isset( $_GET['id_grupo']) ){
    //varivel GET
    $id_grupo = $_GET['id_grupo'];
  }else{
    //variavel sessão
    $id_grupo = $_SESSION['id_grupo'];
  }

  //Seleciona usuario
  $result = mysqli_query($con, "SELECT * FROM usuario WHERE id = '$id' AND id_grupo = '$id_grupo'");
  $usuario = mysqli_fetch_object($result);

	//Verificação para perfil sindico
	if($tipo == 'sind'){
		//Verifica-se usuario pertence ao grupo senão usuario tentando acesso indevido
		if(!isset($usuario)){
			echo '<meta http-equiv="refresh" content="0;URL=../home/home.php?error=Acesso indevido." />';
		}
	}
	
  //Seleciona grupo
	$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$id_grupo'");
	$grupo = mysqli_fetch_object($result);
 ?>

 <script>
   $(document).ready(function(){

    //chamada da função submitForm
    $('#mes').change(function(){ mudarDia(); });
    $('#ano').change(function(){ mudarDia(); });

    //função submit para tabela 
    $('#form').submit( function(){
      $.ajax({
        url:'grupoTabela.php',
        type: 'POST',
        data: $('#form').serialize(),
        success: function(data){
          $('#tabela').html(data);
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
   

    //Inicia com formulario do dia atual
    function iniciarPagina(){
      $.ajax({
        url:'grupoTabela.php',
        type: 'POST',
        data: $('#form').serialize(),
        success: function(data){
          $('#tabela').html(data);
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

    iniciarPagina();

  });//fim document

 </script>

 <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1>Consumo<small> Grupo: <?php echo $grupo->nome ?></small></h1>
      </div>
    </div>
  </div>

  <!--Campo selecionaveis-->
  <div class="row hidden-print">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <form id="form" class="form-inline" method="POST" action="">

      <div class="col-sm-5 col-sm-offset-1 col-xs-4 col-xs-offset-1">

        <div class="row">

          <!--Input text oculto com id_grupo-->
          <div class="form-group sr-only">
            <label for="id_grupo" class="col-sm-4 control-label">ID Grupo*</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="id_grupo" name="id_grupo"
              value=<?php echo $id_grupo ?>>
            </div>
          </div>

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

          <div class="form-group form-group-sm">
            <button type="submit" class="btn btn-primary btn-sm">Aplicar</button>
          </div>

        </div>
      </div>


      </form>
    </div>
  </div><!--Fim do campo selecionavel-->

  <!--Tabela de consumo do mes-->
  <div class="row marge-tabela">
    <div class="col-sm-6 col-sm-offset-3">
      <div id="tabela">
        <center><img src="../img/loader.gif" style="display: none" id="carregando"></center>
      </div>
    </div>
  </div>

  <div class="row hidden-print">

    <!--Botão imprimir-->
    <div class="col-sm-2 col-sm-offset-6 hidden-xs">
      <button type="button" class="btn btn-primary" name="imprimir" value="Imprimir" onclick="window.print();"><span class="glyphicon glyphicon-print" arian-hidden="true"></span> Imprimir</button>
    </div>

  </div>

 <?php include_once("../footer.php") ?>