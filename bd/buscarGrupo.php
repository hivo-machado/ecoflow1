<?php 
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT * FROM xml WHERE id = '$busca' OR nome LIKE '%$busca%' OR link LIKE '%$busca%' ");
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
        <th>Link <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
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
    </tbody>
  </table>
</div>