<?php 
include_once("../header.php");
include_once("../validar.php");
?>

<!--Link para funções-->
<script type="text/javascript" src="../js/funcoes.js"></script>

<?php 
	//função para verificar se esta logado
	valida();
	//função para verificar se esta logado como administrador e sindico
	validaAdminSind();
 ?>

<?php 

	if (isset($_GET['busca'])) {
		$busca = $_GET['busca'];
		$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$busca' OR nome LIKE '%$busca%' OR nome_grupo LIKE '%$busca%' OR cidade LIKE '%$busca%' OR estado LIKE '%$busca%'");
  }

 ?>
 
 <!--Cabeçalho da pagina-->
<div class="row">
  <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
    <div class="page-header">
      <h2>Pesquisar Grupo</h2>
    </div>
    </div>
</div>

<!--Input da pesquisa-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		<form method="GET" action="buscaGrupo.php">
        
      <label for="busca" class="col-sm-2 col-xs-12">Pesquisar</label>

      <div class="col-sm-10 col-xs-12">
        <div class="input-group">
          <input type="search" class="form-control" id="busca" name="busca" placeholder="Buscar por ID, Nome, Nome Grupo, Cidade, UF" autofocus value = <?php if(isset($_GET['busca']) ) echo $_GET['busca'] ?> >
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
          </span>
        </div>        
      </div>

		</form>
	</div>
</div>

  <!--Tabela de Resultado da pesquisa-->
  <div class="row marge-tabela">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">

        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped tabela table-hover table-condensed">
            <tr>
              <th class="tabela-nome-coluna">ID</th>
              <th class="tabela-nome-coluna">Nome</th>   
              <th class="tabela-nome-coluna">Nome Grupo</th>
              <th class="tabela-nome-coluna">Cidade</th>
              <th class="tabela-nome-coluna">UF</th>
              <th class="tabela-nome-coluna">Ação</th>
            </tr>

            <?php
              if(isset($_GET['busca'])){
                while($grupos = mysqli_fetch_object($result)){
            ?>
            <tr>              
              <td onclick="botao('<?php echo  "listaPlanta.php?id_grupo=".$grupos->id ?>');"><?php echo $grupos->id ?></td>
              <td onclick="botao('<?php echo  "listaPlanta.php?id_grupo=".$grupos->id ?>');"><?php echo $grupos->nome ?></td>
              <td onclick="botao('<?php echo  "listaPlanta.php?id_grupo=".$grupos->id ?>');"><?php echo $grupos->nome_grupo ?></td>
              <td onclick="botao('<?php echo  "listaPlanta.php?id_grupo=".$grupos->id ?>');"><?php echo $grupos->cidade ?></td>
              <td onclick="botao('<?php echo  "listaPlanta.php?id_grupo=".$grupos->id ?>');"><?php echo $grupos->estado ?></td>
              <td>
                <a href="listaPlanta.php?id_grupo=<?php echo $grupos->id ?>" class="btn btn-primary btn-xs">
                  <span class="glyphicon glyphicon-folder-open" aria-hidden="true"> </span> Abrir
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


 <?php include_once("../footer.php") ?>