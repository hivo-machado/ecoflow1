<?php 
	include('../conexao.php');
  	include_once("funcaoMesPlanta.php");

	//varivel POST
	$id_planta = $_POST['id_planta'];
	$diaInicio = $_POST['diaInicio'];
	$mesInicio = $_POST['mesInicio'];
	$anoInicio = $_POST['anoInicio'];
    $diaFim = $_POST['diaFim'];
    $mesFim = $_POST['mesFim'];
    $anoFim = $_POST['anoFim'];

	//Chamda das funções
	$consumos = consumo($con, $id_planta, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
	$total = consumoTotal($consumos);
 ?>


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