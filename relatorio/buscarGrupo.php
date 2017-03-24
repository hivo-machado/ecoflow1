<?php 
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$busca' OR nome LIKE '%$busca%' OR nome_grupo LIKE '%$busca%' OR cidade LIKE '%$busca%' OR estado LIKE '%$busca%'");
  }

?>

<!-- Tabela -->
<div class="table-responsive">
  <table class="table table-bordered table-striped tabela table-hover table-condensed">
    <tr>
      <th class="tabela-nome-coluna">ID</th>
      <th class="tabela-nome-coluna">Nome</th>   
      <th class="tabela-nome-coluna">Nome Grupo</th>
      <th class="tabela-nome-coluna">Cidade</th>
      <th class="tabela-nome-coluna">UF</th>
      <th class="tabela-nome-coluna">Ação</th>
    </tr>

    <?php
      if(isset($_GET['busca'])){
        while($grupos = mysqli_fetch_object($result)){
    ?>
    <tr>              
      <td><?php echo $grupos->id ?></td>
      <td><?php echo $grupos->nome ?></td>
      <td><?php echo $grupos->nome_grupo ?></td>
      <td><?php echo $grupos->cidade ?></td>
      <td><?php echo $grupos->estado ?></td>
      <td>
        <a href="listaPlanta.php?id_grupo=<?php echo $grupos->id ?>" class="btn btn-primary btn-xs">
          <span class="glyphicon glyphicon-folder-open" aria-hidden="true"> </span> Torres
        </a>
        <a href="grupoConsumo.php?id_grupo=<?php echo $grupos->id ?>" class="btn btn-primary btn-xs">
          <span class="glyphicon glyphicon-th-list" aria-hidden="true"> </span> Consumo
        </a>
        <a href="grupoLeitura.php?id_grupo=<?php echo $grupos->id ?>" class="btn btn-primary btn-xs">
          <span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span> Leitura
        </a>
      </td>            
    </tr>
    <?php
      }
    }
    ?>
  </table>
</div>