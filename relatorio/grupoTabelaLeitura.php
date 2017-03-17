<?php 
	include('../conexao.php');
  include_once("funcaoGrupo.php");

	//varivel POST
	$id_grupo = $_POST['id_grupo'];
	$data = $_POST['data'];
  $hora = $_POST['hora'];

	//Chamada das funções
	$leituras = leitura($con, $id_grupo, $data, $hora);
 ?>


<div class="panel panel-primary">
<div class="panel-heading tabela-titulo"><strong>Consumo <?php echo $data.' '.$hora ?></strong></div>
<!-- Tabela -->
<div class="table-responsive">
  <table class="table table-bordered table-striped tabela table-hover table-condensed">
    <tr>
      <th class="tabela-nome-coluna">Unidade</th>
      <th class="tabela-nome-coluna">Data</th>
      <th class="tabela-nome-coluna">Hora</th>
      <th class="tabela-nome-coluna">Consumo (m³)</th>
    </tr>

    <?php for($i = 0; $i < count($leituras[0]); $i++){ ?>
    <tr>
      <td><?php echo $leituras[0][$i] ?></td>
      <td><?php echo $leituras[1][$i] ?></td>
      <td><?php echo $leituras[2][$i] ?></td>
      <td><?php echo $leituras[3][$i] ?></td>
    </tr>
    <?php } ?>
    
  </table>
</div>

</div>