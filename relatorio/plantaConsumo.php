<?php 
  include_once("../header.php");
  include_once("../validar.php");
  include_once("funcaoMesPlanta.php");
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

	if(isset($_GET['mesInicio'])){
      $diaInicio = $_GET['diaInicio'];
	    $mesInicio = $_GET['mesInicio'];
	    $anoInicio = $_GET['anoInicio'];
      $diaFim = $_GET['diaFim'];
      $mesFim = $_GET['mesFim'];
      $anoFim = $_GET['anoFim'];
	}else{
	    $diaInicio = 1;
	    $mesInicio = date("n");
		  $anoInicio = date("Y"); 
      $diaFim = $diaInicio;
      $mesFim = $mesInicio + 1;
      $anoFim = $anoInicio;
	}

	//Chamda das funções
	$consumos = consumo($con, $id_planta, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
	$total = consumoTotal($consumos);

 ?>

 <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1>Consumo<small> Planta: <?php echo $planta->nome ?></small></h1>
      </div>
    </div>
  </div>

  <!--Campo selecionaveis-->
  <div class="row hidden-print">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <form class="form-inline" method="GET" action="plantaConsumo.php">

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
            <select class="form-control" id="diaInicio" name="diaInicio" onchange="this.form.submit()">
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
            <select class="form-control" id="mesInicio" name="mesInicio" onchange="this.form.submit()">
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
            <select class="form-control" id="anoInicio" name="anoInicio" onchange="this.form.submit()">
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
            <select class="form-control" id="diaFim" name="diaFim" onchange="this.form.submit()">
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
            <select class="form-control" id="mesFim" name="mesFim" onchange="this.form.submit()">
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
            <select class="form-control" id="anoFim" name="anoFim" onchange="this.form.submit()">
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
      <div class="panel panel-primary">
        <div class="panel-heading tabela-titulo"><strong>Consumo <?php echo $diaInicio.'/'.$mesInicio.'/'.$anoInicio.' - '.$diaFim.'/'.$mesFim.'/'.$anoFim ?></strong></div>
        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped tabela table-hover table-condensed">
            <tr>
              <th class="tabela-nome-coluna">Unidade</th>
              <th class="tabela-nome-coluna">Consumo (m³)</th>
            </tr>

            <?php for($i = 0; $i < count($consumos[0]); $i++){ ?>
            <tr>
              <td><?php echo $consumos[0][$i] ?></td>
              <td><?php echo $consumos[1][$i] ?></td>
            </tr>
            <?php } ?>
            
            <tr class="info">
              <td><strong>TOTAL</strong></td>
              <td><?php echo $total ?></td>
            </tr>
          </table>
        </div>
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

    <!--Botão download-->
    <div class="col-sm-2">
    	<form  method="POST" action="downloadTabela.php">

    		<!--Input text oculto com id_planta-->
  			<div class="form-group sr-only">
  				<label for="id_planta" class="col-sm-4 control-label">ID Planta</label>
  				<div class="col-sm-8">
  					<input type="text" class="form-control" id="id_planta" name="id_planta"
  					value=<?php echo $id_planta ?>>
  				</div>
  			</div>

  			<!--Input text oculto com data inicio-->
  			<div class="form-group sr-only">
  				<label for="diaInicio_D" class="col-sm-4 control-label">Dia Inicio</label>
  				<div class="col-sm-8">
  					<input type="text" class="form-control" id="diaInicio_D" name="diaInicio"
  					value=<?php echo $diaInicio ?>>
  				</div>
  			</div>

  			<!--Input text oculto com mes inicio-->
  			<div class="form-group sr-only">
  				<label for="mesInicio_D" class="col-sm-4 control-label">Mês Inicio</label>
  				<div class="col-sm-8">
  					<input type="text" class="form-control" id="mesInicio_D" name="mesInicio"
  					value=<?php echo $mesInicio ?>>
  				</div>
  			</div>

  			<!--Input text oculto com ano inicio-->
  			<div class="form-group sr-only">
  				<label for="anoInicio_D" class="col-sm-4 control-label">Ano Inicio</label>
  				<div class="col-sm-8">
  					<input type="text" class="form-control" id="anoInicio_D" name="anoInicio"
  					value=<?php echo $anoInicio ?>>
  				</div>
  			</div>

        <!--Input text oculto com dia fim-->
        <div class="form-group sr-only">
          <label for="diaFim_D" class="col-sm-4 control-label">Dia Fim</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="diaFim_D" name="diaFim"
            value=<?php echo $diaFim ?>>
          </div>
        </div>

        <!--Input text oculto com mes fim-->
        <div class="form-group sr-only">
          <label for="mesFim_D" class="col-sm-4 control-label">Mês Fim</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="mesFim_D" name="mesFim"
            value=<?php echo $mesFim ?>>
          </div>
        </div>

        <!--Input text oculto com ano fim-->
        <div class="form-group sr-only">
          <label for="anoFim_D" class="col-sm-4 control-label">Ano Fim</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="anoFim_D" name="anoFim"
            value=<?php echo $anoFim ?>>
          </div>
        </div>

	  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-download-alt" arian-hidden="true"></span> Download</button>
      </form>

    </div>

  </div>

 <?php include_once("../footer.php") ?>