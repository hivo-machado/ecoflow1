<?php 
	include('../conexao.php');
  include_once("funcaoPlanta.php");

	//varivel POST
  $id_grupo = $_POST['id_grupo'];
	$servico = $_POST['servico'];
	$data = $_POST['data'];
  $hora = $_POST['hora'];

  //Variavel
  $cont = 0;

  //Plantas do grupo
  $plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$id_grupo' ORDER BY nome");

  while($planta = mysqli_fetch_object($plantas) ){
    $cont++;

    //Chamada das funções
    $leituras = leitura($con, $planta->idecoflow, $servico, $data, $hora);
    if( $cont == 1) echo "<div class='row'>";
 ?>

<div class="col-sm-4">
  <div class="panel panel-primary">
    <div class="panel-heading tabela-titulo"><strong><?= $planta->nome.' '.$data.' '.$hora ?></strong></div>
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
</div>

<?php 
  if( $cont == 3){
   echo "</div>";
   $cont = 0;
  }
} 
?>