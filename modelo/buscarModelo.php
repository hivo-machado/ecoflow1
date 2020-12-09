<?php
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT * FROM lorawan_modelos WHERE modelo LIKE '$busca' OR fabricante LIKE '%$busca%' OR quantidade_medidores = '%$busca%'");
  	}

 ?>

<script type="text/javascript">
  $(function() {    
    $("#tabela-grupo").tablesorter();
    
  }); 
</script>

 <!-- Tabela -->
<div class="table-responsive">
<table id="tabela-modelo" class="table table-bordered table-striped tabela table-hover table-condensed">
  <thead>
    <tr>
      <th>Modelo <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th>Fabricante <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>   
      <th>Qtd. de Medidores <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th>Ação</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if(isset($_GET['busca'])){
        while($modelos = mysqli_fetch_object($result)){
    ?>
    <tr>              
      <td><?php echo $modelos->modelo ?></td>
      <td><?php echo $modelos->fabricante ?></td>
      <td><?php echo $modelos->quantidade_medidores ?></td>
      <td>
        <a href="alteraModelo.php?id_modelo=<?php echo $modelos->modelo ?>" class="btn btn-primary btn-xs">
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