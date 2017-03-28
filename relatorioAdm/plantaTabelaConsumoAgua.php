<?php 
	include('../conexao.php');
  include_once("funcaoPlanta.php");

	//varivel POST
	$id_planta = $_POST['id_planta'];
	$diaInicio = $_POST['diaInicio'];
	$mesInicio = $_POST['mesInicio'];
	$anoInicio = $_POST['anoInicio'];
  $diaFim = $_POST['diaFim'];
  $mesFim = $_POST['mesFim'];
  $anoFim = $_POST['anoFim'];

	//Chamada das funções
	$consumosAguaFria = consumo($con, $id_planta, 0, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
  $totalAguaFria = consumoTotal($consumosAguaFria);
  $consumosAguaQuente = consumo($con, $id_planta, 1, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
  $totalAguaQuente = consumoTotal($consumosAguaQuente);
  //Valor nulo
  $consumosAguaQuente[] = array(0, 0);
 ?>


<div class="panel panel-primary">
    <div class="panel-heading tabela-titulo"><strong><?= 'Consumos '.$diaInicio.'/'.$mesInicio.'/'.$anoInicio.' - '.$diaFim.'/'.$mesFim.'/'.$anoFim ?></strong></div>
    <!-- Tabela -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped tabela table-hover table-condensed">
        <tr>
          <th class="tabela-nome-coluna">Unidade</th>
          <th class="tabela-nome-coluna">Agua Fria (m³)</th>
          <th class="tabela-nome-coluna">Agua Quente (m³)</th>
          <th class="tabela-nome-coluna">SubTotal</th>
        </tr>

        <?php for($i = 0; $i < count($consumosAguaFria); $i++){ 
          $j = count($consumosAguaQuente) - 1;
          //Verifica unidade são as mesma de agua fria e quente
          for($k = 0; $k < count($consumosAguaQuente) - 1; $k++){
            if( strcmp($consumosAguaFria[$i][0],$consumosAguaQuente[$k][0]) == 0){
              $j = $k;
            }
          }
        ?>
        <tr>
          <td><?= $consumosAguaFria[$i][0] ?></td>
          <td><?= $consumosAguaFria[$i][1] ?></td>
          <td><?= $consumosAguaQuente[$j][1] ?></td>
          <td><?= $consumosAguaFria[$i][1] + $consumosAguaQuente[$j][1] ?></td>
        </tr>
        <?php } ?>
        
        <tr class="info">
          <td><strong>TOTAL</strong></td>
          <td><?= $totalAguaFria ?></td>
          <td><?= $totalAguaQuente ?></td>
          <td><?= $totalAguaFria + $totalAguaQuente ?></td>
        </tr>
      </table>
    </div>
  </div>