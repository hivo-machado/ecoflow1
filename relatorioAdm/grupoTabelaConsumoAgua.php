<?php 
  include('../conexao.php');
  include_once("funcaoPlanta.php");

  //varivel POST
  $id_planta = $_POST['id_grupo'];
  $diaInicio = $_POST['diaInicio'];
  $mesInicio = $_POST['mesInicio'];
  $anoInicio = $_POST['anoInicio'];
  $diaFim = $_POST['diaFim'];
  $mesFim = $_POST['mesFim'];
  $anoFim = $_POST['anoFim'];

  //Variavel
  $cont = 0;

  //Plantas do grupo
  $plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$id_planta' ORDER BY nome");

  while($planta = mysqli_fetch_object($plantas) ){
    $cont++;

    //Chamada das funções
    $consumosAguaFria = consumo($con, $planta->idecoflow, 0, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
    $totalAguaFria = consumoTotal($consumosAguaFria);
    $consumosAguaQuente = consumo($con, $planta->idecoflow, 1, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
    $totalAguaQuente = consumoTotal($consumosAguaQuente);
    //valor nulo
    $consumosAguaQuente[] = array(0, 0);

    //Criar um linhas para cada 3 tabelas
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
          <th class="tabela-nome-coluna">Água Fria (m³)</th>
          <th class="tabela-nome-coluna">Água Quente (m³)</th>
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

</div>

<?php
  //Fechar linha para cada 3 tabelas
  if( $cont == 3){
   echo "</div>";
   $cont = 0;
  }
} 
?>