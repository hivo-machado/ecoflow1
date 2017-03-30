<?php
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$busca' OR nome LIKE '%$busca%' OR nome_grupo LIKE '%$busca%' OR bairro LIKE '%$busca%' OR cidade LIKE '%$busca%' OR estado LIKE '%$busca%'");
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
      <th class="tabela-nome-coluna">ID <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th class="tabela-nome-coluna">Nome <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>   
      <th class="tabela-nome-coluna">Nome Grupo <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th class="tabela-nome-coluna">Rua <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>   
      <th class="tabela-nome-coluna">Nº <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>   
      <th class="tabela-nome-coluna">Bairro <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th class="tabela-nome-coluna">Cidade <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th class="tabela-nome-coluna">UF <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th class="tabela-nome-coluna">CEP <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th class="tabela-nome-coluna">Telefone <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
      <th class="tabela-nome-coluna">Ação</th>
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
      <td><?php echo $grupos->rua ?></td>
      <td><?php echo $grupos->numero ?></td>
      <td><?php echo $grupos->bairro ?></td>
      <td><?php echo $grupos->cidade ?></td>
      <td><?php echo $grupos->estado ?></td>
      <td><?php echo $grupos->cep ?></td>
      <td><?php echo $grupos->telefone ?></td>
      <td>
        <a href="alteraGrupo.php?id_grupo=<?php echo $grupos->id ?>" class="btn btn-primary btn-xs">
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