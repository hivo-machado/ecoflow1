<?php 
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT us.id id, us.id_unidade id_unidade, us.nome nome, us.login, gr.nome grupo, pl.nome planta, us.tipo, us.status FROM usuario us LEFT JOIN planta pl ON pl.idecoflow = us.id_planta LEFT JOIN grupo gr ON gr.id = us.id_grupo WHERE us.id = '$busca' OR  us.id_unidade = '$busca' OR us.nome LIKE '%$busca%' OR us.login LIKE '%$busca%' OR pl.nome LIKE '%$busca%' OR gr.nome LIKE '%$busca%'");
  }

?>

<script type="text/javascript">
  $(function() {    
    $("#tabela-usuario").tablesorter();
    
  }); 
</script>

<!-- Tabela -->
<div class="table-responsive">
  <table id="tabela-usuario" class="table table-bordered table-striped tabela table-hover table-condensed">
    <thead>
      <tr>
        <th class="tabela-nome-coluna">ID <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th class="tabela-nome-coluna">Idecoflow <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th class="tabela-nome-coluna">Nome <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th class="tabela-nome-coluna">Login <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th class="tabela-nome-coluna">Planta <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th class="tabela-nome-coluna">Grupo <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th class="tabela-nome-coluna">Perfil <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th class="tabela-nome-coluna">Status <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th class="tabela-nome-coluna">Ação</th>
      </tr>
    </thead>
    <tbody>
      <?php
        if(isset($_GET['busca'])){
          while($usuarios = mysqli_fetch_object($result)){
      ?>
      <tr>              
        <td><?php echo $usuarios->id ?></td>
        <td><?php echo $usuarios->id_unidade ?></td>
        <td><?php echo $usuarios->nome ?></td>
        <td><?php echo $usuarios->login ?></td>
        <td><?php echo $usuarios->planta ?></td>
        <td><?php echo $usuarios->grupo ?></td>
        <td><?php echo $usuarios->tipo ?></td>
        <td><?php echo $usuarios->status ?></td>
        <td>
          <a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="btn btn-primary btn-xs">
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