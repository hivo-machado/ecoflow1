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

	//Iniciar time zone
	date_default_timezone_set('America/Sao_Paulo');

	if(isset($_POST['mes'])){
	    $mes = $_POST['mes'];
	    $dia = $_POST['dia'];
	    $ano = $_POST['ano'];
	}else{
	    $dia = 1;
	    $mes = date("n"); // mes sem 0 a esquerda
		$ano = date("Y");  
	}

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
      <form class="form-inline" method="POST" action="graficoMes.php">
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
        <div class="panel-heading tabela-titulo"><strong>Titulo</strong></div>
        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped tabela table-hover table-condensed">
            <tr>
              <th class="tabela-nome-coluna">Dia</th>
              <th class="tabela-nome-coluna">Consumo (m³)</th>
            </tr>

            <tr>
              <td></td>
              <td></td>
            </tr>
            
            <tr class="info">
              <td><strong>TOTAL</strong></td>
              <td>Total</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

 <?php include_once("../footer.php") ?>