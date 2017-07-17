<?php 
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
    $perfil = $_GET['perfil'];
    $status = $_GET['status'];
    $result = mysqli_query($con, "SELECT us.id id, us.id_unidade id_unidade, us.nome nome, us.login, us.senha, gr.nome grupo, pl.nome planta, us.tipo, us.status FROM usuario us LEFT JOIN planta pl ON pl.idecoflow = us.id_planta LEFT JOIN grupo gr ON gr.id = us.id_grupo WHERE us.tipo LIKE '$perfil%' AND us.status LIKE '$status%' AND ( us.id = '$busca' OR  us.id_unidade = '$busca' OR us.nome LIKE '%$busca%' OR us.login LIKE '%$busca%' OR pl.nome LIKE '%$busca%' OR gr.nome LIKE '%$busca%')");
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
        <th>ID <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Idecoflow <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Nome <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Login <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Senha <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Planta <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Grupo <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Perfil <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
        <th>Status <span id="icone-tabela" class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
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
        <td><?php echo $usuarios->senha ?></td>
        <td><?php echo $usuarios->planta ?></td>
        <td><?php echo $usuarios->grupo ?></td>
        <td><?php echo $usuarios->tipo ?></td>
        <td><?php echo $usuarios->status ?></td>           
      </tr>
      <?php
        }
      }
      ?>
    </tbody>
  </table>
</div>