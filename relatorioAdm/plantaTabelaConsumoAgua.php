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
	$consumos = consumo($con, $id_planta, 0, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
  $total = consumoTotal($consumos);
  // print_r($consumos);
 ?>


<div class="panel panel-primary">
  <div class="panel-heading tabela-titulo"><strong>Consumo <?php echo $diaInicio.'/'.$mesInicio.'/'.$anoInicio.' - '.$diaFim.'/'.$mesFim.'/'.$anoFim ?></strong></div>
  <!-- Tabela -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped tabela table-hover table-condensed">
      <tr>
        <th class="tabela-nome-coluna">Unidade</th>
        <th class="tabela-nome-coluna">Leitura inicial</th>
        <th class="tabela-nome-coluna">Data inicial</th>
        <th class="tabela-nome-coluna">Leitura final</th>
        <th class="tabela-nome-coluna">Data final</th>
        <th class="tabela-nome-coluna">Consumo (m³)</th>
      </tr>

      <?php for($i = 0; $i < count($consumos); $i++){ ?>
      <tr>
        <td><?php echo $consumos[$i][0] ?></td>
        <td><?php echo $consumos[$i][1] ?></td>
        <td><?php echo $consumos[$i][2] ?></td>
        <td><?php echo $consumos[$i][3] ?></td>
        <td><?php echo $consumos[$i][4] ?></td>
        <td><?php echo $consumos[$i][5] ?></td>
      </tr>
      <?php } ?>
      
      <tr class="info">
        <td><strong>TOTAL</strong></td>
        <td><?php echo $total ?></td>
      </tr>
    </table>
  </div>
</div>