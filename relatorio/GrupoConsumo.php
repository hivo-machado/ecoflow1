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
    $('#mesInicio').change(function(){ mudarDiaInicio(); });
    $('#anoInicio').change(function(){ mudarDiaInicio(); });
    $('#mesFim').change(function(){ mudarDiaFim(); });
    $('#anoFim').change(function(){ mudarDiaFim(); });

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
      copia();
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
      copia();
      return false;
    };

    //Copia os dados para formulario de download
    function copia(){ 
      $('#diaInicio_D').val( $('#diaInicio').val() );
      $('#mesInicio_D').val( $('#mesInicio').val() );
      $('#anoInicio_D').val( $('#anoInicio').val() );
      $('#diaFim_D').val( $('#diaFim').val() );
      $('#mesFim_D').val( $('#mesFim').val() );
      $('#anoFim_D').val( $('#anoFim').val() );
    };

    //Mudar preenchimento do select dia quando mudar mes e ano
    function mudarDiaInicio(){
      var i;
      var opcao;
      var diaInicio = $('#diaInicio').val();
      var mesInicio = $('#mesInicio').val();
      var anoInicio = $('#anoInicio').val();
      var ultimoDiaInicio = (new Date(anoInicio, mesInicio, 0)).getDate();
      //limpar as opções
      $('#diaInicio').empty();

      //Preencher option do diaInicio
      for(i = 1; i <= ultimoDiaInicio; i++ ){
        if(i == diaInicio) var seleciona = ' selected '; else seleciona = '';
        opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
        $('#diaInicio').append(opcao);
      }
    };

    //Mudar preenchimento do select dia quando mudar mes e ano
    function mudarDiaFim(){
      var i;
      var opcao;
      var diaFim = $('#diaFim').val();
      var mesFim = $('#mesFim').val();
      var anoFim = $('#anoFim').val();
      var ultimoDiaFim = (new Date(anoFim, mesFim, 0)).getDate();
      //limpar as opções
      $('#diaFim').empty();

      //Preencher option do diaFim
      for(i = 1; i <= ultimoDiaFim; i++ ){
        if(i == diaFim) var seleciona = ' selected '; else seleciona = '';
        opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
        $('#diaFim').append(opcao);
      }
    };

    //Data inicial
    var dataAtual = new Date();
    var mesInicio = dataAtual.getMonth() + 1;//Ajusta mês de 0-11 para 1-12
    var anoInicio = dataAtual.getFullYear();

    var dataFim = dataAtual;
    dataFim.setMonth(dataFim.getMonth() + 1); // Soma 1 mes
    var mesFim = dataFim.getMonth() + 1;//Ajusta mês de 0-11 para 1-12
    var anoFim = dataFim.getFullYear();

    var i;
    var opcao;
    var seleciona;
    var ultimoDiaInicio = (new Date(anoInicio, mesInicio, 0)).getDate();
    var ultimoDiaFim = (new Date(anoFim, mesFim, 0)).getDate();

    //Preencher option do diaInicio
    for(i = 1; i <= ultimoDiaInicio; i++ ){
      if(i == 1) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#diaInicio').append(opcao);
    }

    //Preencher option do mesInicio
    for(i = 1; i <= 12; i++ ){
      if(i == mesInicio) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#mesInicio').append(opcao);
    }

    //Preencher option do anoInicio
    for(i = 2016; i <= anoInicio; i++ ){
      if(i == anoInicio) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#anoInicio').append(opcao);
    }

    //Preencher option do diaFim
    for(i = 1; i <= ultimoDiaFim; i++ ){
      if(i == 1) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#diaFim').append(opcao);
    }

    //Preencher option do mesInicio
    for(i = 1; i <= 12; i++ ){
      if(i == mesFim) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#mesFim').append(opcao);
    }

    //Preencher option do anoInicio
    for(i = 2016; i <= anoFim; i++ ){
      if(i == anoFim) seleciona = ' selected '; else seleciona = '';
      opcao = $('<option value="'+i+'"'+seleciona+'>'+i+'</option>');
      $('#anoFim').append(opcao);
    }

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
          <label>Inicio:</label>
        </div>

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
            <label for="diaInicio">Dia</label>
            <select class="form-control" id="diaInicio" name="diaInicio"></select>          
          </div>

          <div class="form-group form-group-sm">
            <label for="mesInicio">Mês</label>
            <select class="form-control" id="mesInicio" name="mesInicio"></select>      
          </div>

          <div class="form-group form-group-sm">
            <label for="anoInicio">Ano</label>
            <select class="form-control" id="anoInicio" name="anoInicio"></select>      
          </div>

        </div>
      </div>

      <div class="col-sm-5 col-sm-offset-0 col-xs-4 col-xs-offset-2">

        <div class="row">
          <label>Fim:</label>
        </div>

        <div class="row">
        
          <div class="form-group form-group-sm">
            <label for="diaFim">Dia</label>
            <select class="form-control" id="diaFim" name="diaFim"></select>          
          </div>

          <div class="form-group form-group-sm">
            <label for="mesFim">Mês</label>
            <select class="form-control" id="mesFim" name="mesFim"></select>      
          </div>

          <div class="form-group form-group-sm">
            <label for="anoFim">Ano</label>
            <select class="form-control" id="anoFim" name="anoFim"></select>      
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
      <form>
        <button type="button" class="btn btn-primary" name="imprimir" value="Imprimir" onclick="window.print();"><span class="glyphicon glyphicon-print" arian-hidden="true"></span> Imprimir</button>
      </form>
    </div>

    <!--Formulario de download em excel-->
    <div class="col-sm-2">
	   <form  method="POST" action="grupoDownload.php">

        <div class="sr-only">

          <!--Input text oculto com id_grupo-->
          <input type="text" class="form-control" id="id_grupo" name="id_grupo" value=<?php echo $id_grupo ?>>
         
          <!--Input text oculto com data inicio-->
          <input type="text" id="diaInicio_D" name="diaInicio" value="">

          <!--Input text oculto com mes inicio-->
          <input type="text" id="mesInicio_D" name="mesInicio" value="">

          <!--Input text oculto com ano inicio-->
          <input type="text" id="anoInicio_D" name="anoInicio" value="">

          <!--Input text oculto com dia fim-->
          <input type="text" id="diaFim_D" name="diaFim" value="">

          <!--Input text oculto com mes fim-->
          <input type="text" id="mesFim_D" name="mesFim" value="">

          <!--Input text oculto com ano fim-->
          <input type="text" id="anoFim_D" name="anoFim" value="">

        </div>

        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-download-alt" arian-hidden="true"></span> Download</button>
      </form>
    </div>

  </div>

 <?php include_once("../footer.php") ?>