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

	//vetor nome dos meses
	$meses = array(
	    1 =>'Janeiro',
	    'Fevereiro',
	    'Março',
	    'Abril',
	    'Maio',
	    'Junho',
	    'Julho',
	    'Agosto',
	    'Setembro',
	    'Outubro',
	    'Novembro',
	    'Dezembro'
	);

	//Seleciona planta
	$result = mysqli_query($con, "SELECT * FROM planta WHERE idecoflow = '$id_planta' AND id_grupo_fk = '$id_grupo'");
	$planta = mysqli_fetch_object($result);

	//Verificação para perfil sindico
	if($tipo == 'sind'){
		//Verifica-se planta pertence a grupo senão usuario tentando acesso indevido
		if(!isset($planta)){
			echo '<meta http-equiv="refresh" content="0;URL=listaPlanta.php?error=Acesso indevido." />';
		}
	}
	
	//Iniciar time zone
	date_default_timezone_set('America/Sao_Paulo');

	if(isset($_GET['mes'])){
	    $mes = $_GET['mes'];
	    $dia = $_GET['dia'];
	    $ano = $_GET['ano'];
	}else{
	    $dia = 1;
	    $mes = date("n"); // mes sem 0 a esquerda
		$ano = date("Y");  
	}

	//Chamda das funções
	$consumos = consumo($con, $id_planta, $ano, $mes, $dia);
	$total = consumoTotal($consumos);

 ?>

 <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1><?php echo $meses[$mes] ?><small> Planta: <?php echo $planta->nome ?></small></h1>
      </div>
    </div>
  </div>

  <!--Campo selecionaveis-->
  <div class="row hidden-print">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <form class="form-inline" method="GET" action="plantaMes.php">
      		<!--Input text oculta com id do usuario-->
			<div class="form-group sr-only">
				<label for="id_planta" class="col-sm-4 control-label">ID Planta*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="id_planta" name="id_planta"
					value=<?php echo $id_planta ?>>
				</div>
			</div>

          <div class="form-group form-group-sm">
            <label for="dia">Dia</label>
            <select class="form-control" id="dia" name="dia" onchange="this.form.submit()">
              <?php
                $numDiaMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
                for($i = 1; $i <= $numDiaMes; $i++){
                  if($i == $dia) $seleciona = 'selected'; else $seleciona = '';
                  echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
                }
               ?>
            </select>          
          </div>

          <div class="form-group form-group-sm">
            <label for="mes">Mês</label>
            <select class="form-control" id="mes" name="mes" onchange="this.form.submit()">
              <?php 
                for($i = 1; $i <= 12; $i++){
                  if($i == $mes) $seleciona = 'selected'; else $seleciona = '';
                  echo '<option value="'.$i.'"'.$seleciona.'>'.$i.'</option>';
                }
               ?>
            </select>      
          </div>

          <div class="form-group form-group-sm">
            <label for="ano">Ano</label>
            <select class="form-control" id="ano" name="ano" onchange="this.form.submit()">
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

   <!--Tabela de consumo do mes-->
  <div class="row marge-tabela">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading tabela-titulo"><strong>Consumo de <?php echo $meses[$mes] ?></strong></div>
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

  <!--Botão imprimir-->
  <div class="row hidden-print hidden-xs">
    <div class="col-sm-2 col-sm-offset-8">
      <form>
        <button type="button" class="btn btn-primary" name="imprimir" value="Imprimir" onclick="window.print();"><span class="glyphicon glyphicon-print" arian-hidden="true"></span> Imprimir</button>
      </form>
    </div>
  </div>

 <?php include_once("../footer.php") ?>