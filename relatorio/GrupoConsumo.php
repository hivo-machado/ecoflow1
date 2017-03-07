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

  if( isset($_SESSION['id_grupo']) ){
    $id_grupo = $_SESSION['id_grupo'];
  }else{
    //varivel GET
    $id_grupo = $_GET['id_grupo'];
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
	
	
	//Iniciar time zone
	date_default_timezone_set('America/Sao_Paulo');

	
  $diaInicio = 1;
  $mesInicio = date("n");
  $anoInicio = date("Y"); 
  $diaFim = $diaInicio;
  $mesFim = $mesInicio + 1;
  $anoFim = $anoInicio;
 ?>

 <script>
   $(document).ready(function(){

    //chamada da função submitForm
    $('#diaInicio').change(function(){submitForm()});
    $('#mesInicio').change(function(){submitForm()});
    $('#anoInicio').change(function(){submitForm()});
    $('#diaFim').change(function(){submitForm()});
    $('#mesFim').change(function(){submitForm()});
    $('#anoFim').change(function(){submitForm()});

    //função submit para tabela 
    function submitForm(){
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
  });
   /*
  //metodo para enviar a form quando terminar de carregar a pagina
  window.onload = function(){
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
  */

  //Copia os dados para outra form de download
  function copia(){
    document.getElementById('id_grupo_D').value = document.getElementById('id_grupo').value;
    document.getElementById('diaInicio_D').value = document.getElementById('diaInicio').value;
    document.getElementById('mesInicio_D').value = document.getElementById('mesInicio').value;
    document.getElementById('anoInicio_D').value = document.getElementById('anoInicio').value;
    document.getElementById('diaFim_D').value = document.getElementById('diaFim').value;
    document.getElementById('mesFim_D').value = document.getElementById('mesFim').value;
    document.getElementById('anoFim_D').value = document.getElementById('anoFim').value;
  }
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
            <select class="form-control" id="diaInicio" name="diaInicio">
              <?php
                $numDiaMes = cal_days_in_month(CAL_GREGORIAN, $mesInicio, $anoInicio);
                for($i = 1; $i <= $numDiaMes; $i++){
                  if($i == $diaInicio) $seleciona = 'selected'; else $seleciona = '';
                  echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
                }
               ?>
            </select>          
          </div>

          <div class="form-group form-group-sm">
            <label for="mesInicio">Mês</label>
            <select class="form-control" id="mesInicio" name="mesInicio">
              <?php 
                for($i = 1; $i <= 12; $i++){
                  if($i == $mesInicio) $seleciona = 'selected'; else $seleciona = '';
                  echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
                }
               ?>
            </select>      
          </div>

          <div class="form-group form-group-sm">
            <label for="anoInicio">Ano</label>
            <select class="form-control" id="anoInicio" name="anoInicio">
              <?php
                $numAno = date("Y");
                for($i = 2016; $i <= $numAno; $i++){
                  if($i == $anoInicio) $seleciona = 'selected'; else $seleciona = '';
                  echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
                }
               ?>
            </select>      
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
            <select class="form-control" id="diaFim" name="diaFim">
              <?php
                $numDiaMes = cal_days_in_month(CAL_GREGORIAN, $mesFim, $anoFim);
                for($i = 1; $i <= $numDiaMes; $i++){
                  if($i == $diaFim) $seleciona = 'selected'; else $seleciona = '';
                  echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
                }
               ?>
            </select>          
          </div>

          <div class="form-group form-group-sm">
            <label for="mesFim">Mês</label>
            <select class="form-control" id="mesFim" name="mesFim">
              <?php 
                for($i = 1; $i <= 12; $i++){
                  if($i == $mesFim) $seleciona = 'selected'; else $seleciona = '';
                  echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
                }
               ?>
            </select>      
          </div>

          <div class="form-group form-group-sm">
            <label for="anoFim">Ano</label>
            <select class="form-control" id="anoFim" name="anoFim">
              <?php
                $numAno = date("Y");
                for($i = 2016; $i <= $numAno; $i++){
                  if($i == $anoFim) $seleciona = 'selected'; else $seleciona = '';
                  echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
                }
               ?>
            </select>      
          </div>

        </div>
      </div>
          
      </form>
    </div>
  </div>

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

    <!--Form para download dos dados em excel-->
    <div class="col-sm-2">
	   <form  method="POST" action="grupoDownload.php">

        <!--Input text oculto com id_grupo-->
        <div class="form-group sr-only">
          <label for="id_grupo" class="col-sm-4 control-label">ID Planta</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="id_grupo_D" name="id_grupo">
          </div>
        </div>

        <!--Input text oculto com data inicio-->
        <div class="form-group sr-only">
          <label for="diaInicio_D" class="col-sm-4 control-label">Dia Inicio</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="diaInicio_D" name="diaInicio">
          </div>
        </div>

        <!--Input text oculto com mes inicio-->
        <div class="form-group sr-only">
          <label for="mesInicio_D" class="col-sm-4 control-label">Mês Inicio</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="mesInicio_D" name="mesInicio">
          </div>
        </div>

        <!--Input text oculto com ano inicio-->
        <div class="form-group sr-only">
          <label for="anoInicio_D" class="col-sm-4 control-label">Ano Inicio</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="anoInicio_D" name="anoInicio">
          </div>
        </div>

        <!--Input text oculto com dia fim-->
        <div class="form-group sr-only">
          <label for="diaFim_D" class="col-sm-4 control-label">Dia Fim</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="diaFim_D" name="diaFim">
          </div>
        </div>

        <!--Input text oculto com mes fim-->
        <div class="form-group sr-only">
          <label for="mesFim_D" class="col-sm-4 control-label">Mês Fim</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="mesFim_D" name="mesFim">
          </div>
        </div>

        <!--Input text oculto com ano fim-->
        <div class="form-group sr-only">
          <label for="anoFim_D" class="col-sm-4 control-label">Ano Fim</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="anoFim_D" name="anoFim">
          </div>
        </div>

        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-download-alt" arian-hidden="true"></span> Download</button>
      </form>
    </div>

  </div>

 <?php include_once("../footer.php") ?>