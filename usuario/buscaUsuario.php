<?php 
include_once("../header.php");
include_once("../validar.php");
?>

<?php 
	//função para verificar se esta logado
	valida();
	//função para verificar se esta logado como administrador
	validaAdmin();
 ?>

<?php 
	//variavel de sessão
	$id = $_SESSION['id'];
 ?>

<?php 

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT us.id id, us.id_unidade id_unidade, us.nome nome, us.login, gr.nome grupo, pl.nome planta, us.tipo, us.status FROM usuario us LEFT JOIN planta pl ON pl.idecoflow = us.id_planta LEFT JOIN grupo gr ON gr.id = us.id_grupo WHERE us.id = '$busca' OR  us.id_unidade = '$busca' OR us.nome LIKE '%$busca%' OR us.login LIKE '%$busca%' OR pl.nome LIKE '%$busca%' OR gr.nome LIKE '%$busca%'");
  }

 ?>

<div class="row">
	<div class="col-sm-8 col-sm-offset-4 col-xs-12 col-xs-offset-0">
		<form class="form-inline" method="GET" action="buscaUsuario.php">

			<div class="form-group">
				<label for="busca">Pesquisar</label>
				<input type="search" class="form-control" id="busca" name="busca" placeholder="ID, Idecolfow, Nome, Login, Planta, Grupo" autofocus>
			</div>

			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar</button>

		</form>
	</div>
</div>

  <!--Tabela de consumo do ano-->
  <div class="row marge-tabela">
    <div class="col-sm-12 col-xs-12">
      <div class="panel panel-primary">
        <div class="panel-heading tabela-titulo"><strong>Resultado da busca</strong></div>
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
              <th class="tabela-nome-coluna"></th>
            </tr>

            <?php
              if(isset($_GET['busca'])){
                while($usuarios = mysqli_fetch_object($result)){
            ?>
            <tr>              
              <td><a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="link-td"><?php echo $usuarios->id ?></a></td>
              <td><a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="link-td"><?php echo $usuarios->id_unidade ?></a></td>
              <td><a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="link-td"><?php echo $usuarios->nome ?></a></td>
              <td><a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="link-td"><?php echo $usuarios->login ?></a></td>
              <td><a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="link-td"><?php echo $usuarios->planta ?></a></td>
              <td><a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="link-td"><?php echo $usuarios->grupo ?></a></td>
              <td><a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="link-td"><?php echo $usuarios->tipo ?></a></td>
              <td><a href="alteraUsuario.php?id_usuario=<?php echo $usuarios->id ?>" class="link-td"><?php echo $usuarios->status ?></a></td>
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
      </div>
    </div>
  </div>


 <?php include_once("../footer.php") ?>