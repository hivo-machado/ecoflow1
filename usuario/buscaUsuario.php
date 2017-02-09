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

<!--Menssagem de Alerta-->
 <div class="row">
	<div class="mensagme text-center col-sm-8 col-sm-offset-2">
		<?php 
		if(isset($_GET['error']))
		{
			?> 
			<div class="alert alert-danger alert-dismissible" role="alert"><?php echo $_GET['error'] ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
			} 
			else if(isset($_GET['success']))
			{
			?> 
				<div class="alert alert-success alert-dismissible" role="alert"><?php echo $_GET['success'] ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php
			}
			?>
	</div>
</div>

<?php 

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT us.id id, us.id_unidade id_unidade, us.nome nome, gr.nome grupo, pl.nome planta FROM usuario us, planta pl, grupo gr WHERE us.id_grupo = gr.id AND gr.id = pl.id_grupo_fk AND (us.id = '$busca' OR  us.id_unidade = '$busca' OR us.nome LIKE '%$busca%' OR pl.nome LIKE '%$busca%' OR gr.nome LIKE '%$busca%')");
	}else{
		$result = mysqli_query($con, "SELECT us.id id, us.id_unidade id_unidade, us.nome nome, gr.nome grupo, pl.nome planta FROM usuario us, planta pl, grupo gr WHERE us.id_grupo = gr.id AND gr.id = pl.id_grupo_fk");
	}

 ?>

<div class="row">
	<div class="col-sm-7 col-sm-offset-4 col-xs-12 col-xs-offset-0">
		<form class="form-inline" method="GET" action="buscaUsuario.php">

			<div class="form-group">
				<label for="busca">Pesquisar</label>
				<input type="search" class="form-control" id="busca" name="busca" autofocus>
			</div>

			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar</button>

		</form>
	</div>
</div>

  <!--Tabela de consumo do ano-->
  <div class="row marge-tabela">
    <div class="col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">
      <div class="panel panel-primary">
        <div class="panel-heading tabela-titulo"><strong>Resultado da busca</strong></div>
        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped tabela table-hover table-condensed">
            <tr>
              <th class="tabela-nome-coluna">ID</th>
              <th class="tabela-nome-coluna">ID unidade</th>
              <th class="tabela-nome-coluna">Nome</th>
              <th class="tabela-nome-coluna">Planta</th>
              <th class="tabela-nome-coluna">Grupo</th>
            </tr>

            <?php
              while($usuarios = mysqli_fetch_object($result)){
            ?>
            <tr>
              <td><?php echo $usuarios->id ?></td>
              <td><?php echo $usuarios->id_unidade ?></td>
              <td><?php echo $usuarios->nome ?></td>
              <td><?php echo $usuarios->planta ?></td>
              <td><?php echo $usuarios->grupo ?></td>
            </tr>
            <?php
             } 
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>


 <?php include_once("../footer.php") ?>