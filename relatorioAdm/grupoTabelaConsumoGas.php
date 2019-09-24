<?php 
  include('../conexao.php');
  include_once("funcaoPlanta.php");

  //varivel POST
  $id_grupo = $_POST['id_grupo'];
  $diaInicio = $_POST['diaInicio'];
  $mesInicio = $_POST['mesInicio'];
  $anoInicio = $_POST['anoInicio'];
  $diaFim = $_POST['diaFim'];
  $mesFim = $_POST['mesFim'];
  $anoFim = $_POST['anoFim'];

  //Variavel
  $cont = 0;

  //Plantas do grupo
  $plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$id_grupo' ORDER BY nome");

  while($planta = mysqli_fetch_object($plantas) ){
    $cont++;

    //Chamada das funções
    $consumos = consumo($con, $planta->idecoflow, 2, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
    $total = consumoTotal($consumos);
    if( $cont == 1) echo "<div class='row'>";
 ?>

<div class="col-sm-4">

  <div class="panel panel-primary">
    <div class="panel-heading tabela-titulo"><strong><?= $planta->nome.' '.$diaInicio.'/'.$mesInicio.'/'.$anoInicio.' - '.$diaFim.'/'.$mesFim.'/'.$anoFim ?></strong></div>
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

</div>

<?php 
  if( $cont == 3){
   echo "</div>";
   $cont = 0;
  }
} 
?>