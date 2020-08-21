<?php
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT * FROM planta WHERE idecoflow = '$busca' OR id_grupo_fk LIKE '%$busca%' OR nome LIKE '%$busca%'");
  	}

 ?>

<script type="text/javascript">
  $(function() {    
    $("#tabela-grupo").tablesorter();
    
  }); 
</script>

 <!-- Tabela -->
<div class="table-responsive">
<table id="tabela-planta" class="table table-bordered table-striped tabela table-hover table-condensed">
  <thead>
    <tr>
      <th>ID <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th>Grupo <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>   
      <th>Nome <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th>Ação</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if(isset($_GET['busca'])){
        while($plantas = mysqli_fetch_object($result)){
    ?>
    <tr>              
      <td><?php echo $plantas->idecoflow ?></td>
      <td><?php echo $plantas->id_grupo_fk ?></td>
      <td><?php echo $plantas->nome ?></td>
      <td>
        <a href="alteraPlanta.php?id_planta=<?php echo $plantas->idecoflow ?>" class="btn btn-primary btn-xs">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          Alterar
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