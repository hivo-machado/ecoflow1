<?php 
	include('../conexao.php');

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT us.id id, us.id_unidade id_unidade, us.nome nome, us.login, gr.nome grupo, pl.nome planta, us.tipo, us.status FROM usuario us LEFT JOIN planta pl ON pl.idecoflow = us.id_planta LEFT JOIN grupo gr ON gr.id = us.id_grupo WHERE us.id = '$busca' OR  us.id_unidade = '$busca' OR us.nome LIKE '%$busca%' OR us.login LIKE '%$busca%' OR pl.nome LIKE '%$busca%' OR gr.nome LIKE '%$busca%'");
  }

?>

<!-- Tabela -->
<div class="table-responsive">
  <table class="table table-bordered table-striped tabela table-hover table-condensed">
    <tr>
      <th class="tabela-nome-coluna">ID</th>
      <th class="tabela-nome-coluna">Idecoflow</th>
      <th class="tabela-nome-coluna">Nome</th>
      <th class="tabela-nome-coluna">Login</th>
      <th class="tabela-nome-coluna">Planta</th>
      <th class="tabela-nome-coluna">Grupo</th>
      <th class="tabela-nome-coluna">Perfil</th>
      <th class="tabela-nome-coluna">Status</th>
      <th class="tabela-nome-coluna">Ação</th>
    </tr>

    <?php
      if(isset($_GET['busca'])){
        while($usuarios = mysqli_fetch_object($result)){
    ?>
    <tr>              
      <td onclick="botao('<?php echo  "alteraUsuario.php?id_usuario=".$usuarios->id ?>');"><?php echo $usuarios->id ?></td>
      <td onclick="botao('<?php echo  "alteraUsuario.php?id_usuario=".$usuarios->id ?>');"><?php echo $usuarios->id_unidade ?></td>
      <td onclick="botao('<?php echo  "alteraUsuario.php?id_usuario=".$usuarios->id ?>');"><?php echo $usuarios->nome ?></td>
      <td onclick="botao('<?php echo  "alteraUsuario.php?id_usuario=".$usuarios->id ?>');"><?php echo $usuarios->login ?></td>
      <td onclick="botao('<?php echo  "alteraUsuario.php?id_usuario=".$usuarios->id ?>');"><?php echo $usuarios->planta ?></td>
      <td onclick="botao('<?php echo  "alteraUsuario.php?id_usuario=".$usuarios->id ?>');"><?php echo $usuarios->grupo ?></td>
      <td onclick="botao('<?php echo  "alteraUsuario.php?id_usuario=".$usuarios->id ?>');"><?php echo $usuarios->tipo ?></td>
      <td onclick="botao('<?php echo  "alteraUsuario.php?id_usuario=".$usuarios->id ?>');"><?php echo $usuarios->status ?></td>
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
  </table>
</div>