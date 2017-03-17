<?php 
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT * FROM xml WHERE id = '$busca' OR nome LIKE '%$busca%' OR link LIKE '%$busca%' ");
  }

?>

<!-- Tabela -->
<div class="table-responsive">
  <table class="table table-bordered table-striped tabela table-hover table-condensed">
    <tr>
      <th class="tabela-nome-coluna">ID</th>
      <th class="tabela-nome-coluna">Nome</th>   
      <th class="tabela-nome-coluna">Link</th>
      <th class="tabela-nome-coluna">Ação</th>
    </tr>

    <?php
      if(isset($_GET['busca'])){
        while($grupos = mysqli_fetch_object($result)){
    ?>
    <tr>              
      <td><?php echo $grupos->id ?></td>
      <td><?php echo $grupos->nome ?></td>
      <td><?php echo $grupos->link ?></td>
      <td>
        <a href="alteraGrupo.php?id_grupo=<?php echo $grupos->id ?>" class="btn btn-primary btn-xs">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"> </span> Alterar
        </a>
      </td>            
    </tr>
    <?php
      }
    }
    ?>
  </table>
</div>