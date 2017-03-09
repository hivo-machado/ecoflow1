<?php 
  include_once("../header.php");
  include_once("../validar.php");
?>

<?php 
	//valida-se esta logado como Administrador ou sindico
	validaAdminSind();
 ?>

<?php 
	//variavel SESSAO
	$tipo = $_SESSION['tipo'];
	$id_grupo = $_SESSION['id_grupo'];

  //varivel GET
  $id_planta = $_GET['id_planta'];

	//Seleciona planta
	$result = mysqli_query($con, "SELECT * FROM planta WHERE idecoflow = '$id_planta' AND id_grupo_fk = '$id_grupo'");
	$planta = mysqli_fetch_object($result);

	//Verificação para perfil sindico
	if($tipo == 'sind'){
		//Verifica-se planta pertence a grupo senão usuario tentando acesso indevido
		if(!isset($planta)){
			echo '<meta http-equiv="refresh" content="0;URL=listaPlanta.php?error=Acesso indevido." />';
		}
	}else{
		//Seleciona planta
		$result = mysqli_query($con, "SELECT * FROM planta WHERE idecoflow = '$id_planta'");
		$planta = mysqli_fetch_object($result);
	}
	
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
        url:'plantaTabela.php',
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

  //metodo para enviar a form quando terminar de carregar a pagina
  window.onload = function(){
    $.ajax({
      url:'plantaTabela.php',
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


  //Copia os dados para outra form de download
  function copia(){
    document.getElementById('id_planta_D').value = document.getElementById('id_planta').value;
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
        <h1>Consumo<small> Torre: <?php echo $planta->nome ?></small></h1>
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

          <!--Input text oculto com id_planta-->
          <div class="form-group sr-only">
            <label for="id_planta" class="col-sm-4 control-label">ID Planta*</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="id_planta" name="id_planta"
              value=<?php echo $id_planta ?>>
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
	   <form  method="POST" action="plantaDownload.php">

        <div class="sr-only">

          <!--Input text oculto com id_planta-->
          <input type="text" class="form-control" id="id_planta_D" name="id_planta">

          <!--Input text oculto com data inicio-->
          <input type="text" class="form-control" id="diaInicio_D" name="diaInicio">

          <!--Input text oculto com mes inicio-->
          <input type="text" class="form-control" id="mesInicio_D" name="mesInicio">

          <!--Input text oculto com ano inicio-->
          <input type="text" class="form-control" id="anoInicio_D" name="anoInicio">

          <!--Input text oculto com dia fim-->
          <input type="text" class="form-control" id="diaFim_D" name="diaFim">

          <!--Input text oculto com mes fim-->
          <input type="text" class="form-control" id="mesFim_D" name="mesFim">

          <!--Input text oculto com ano fim-->
          <input type="text" class="form-control" id="anoFim_D" name="anoFim">

        </div>

        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-download-alt" arian-hidden="true"></span> Download</button>
      </form>
    </div>

  </div>

 <?php include_once("../footer.php") ?>