<?php 
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$busca' OR nome LIKE '%$busca%' OR nome_grupo LIKE '%$busca%' OR cidade LIKE '%$busca%' OR estado LIKE '%$busca%'");
  }

?>

<script type="text/javascript">
  $(function() {    
    $("#tabela-grupo").tablesorter();
    
  }); 
</script>

<!-- Tabela -->
<div class="table-responsive">
  <table id="tabela-grupo" class="table table-bordered table-striped tabela table-hover table-condensed">
    <thead>
      <tr>
        <th>ID <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Nome <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>   
        <th>Nome Grupo <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Cidade <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>UF <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
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
          <a href="grupoListaUsuario.php?id_grupo=<?php echo $grupos->id ?>" class="btn btn-primary btn-xs">
            <span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span> Lista
          </a>
          <a href="grupoDownloadUsuario.php?id_grupo=<?php echo $grupos->id ?>" class="btn btn-primary btn-xs">
            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"> </span> Download
          </a>
        </td>            
      </tr>
      <?php
        }
      }
      ?>
    </tbody>
  </table>
</div>