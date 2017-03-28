<?php 
	include('../conexao.php');
  include_once("funcaoPlanta.php");

	//varivel POST
  $id_planta = $_POST['id_planta'];
  $servico = $_POST['servico'];
  $data = $_POST['data'];
  $hora = $_POST['hora'];

  //Chamada das funções
  $leituras = leitura($con, $id_planta, $servico, $data, $hora);
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

      <?php for($i = 0; $i < count($leituras); $i++){ ?>
      <tr>
        <td><?php echo $leituras[$i][0] ?></td>
        <td><?php echo $leituras[$i][1] ?></td>
        <td><?php echo $leituras[$i][2] ?></td>
        <td><?php echo $leituras[$i][3] ?></td>
      </tr>
      <?php } ?>
      
    </table>
  </div>

</div>