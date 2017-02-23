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
	
	if( $_SESSION['tipo'] == 'admin' ){
		$id_grupo = $_GET['id_grupo'];
	}else if( $_SESSION['tipo'] == 'sind' ){
		$id_grupo = $_SESSION['id_grupo'];
	}
	
	$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$id_grupo'");
	$grupo = mysqli_fetch_object($result);

	$result = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$id_grupo'");
?>

 <!--Cabeçalho da pagina-->
<div class="row">
  <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
    <div class="page-header">
      <h2>Torres <small><?php echo $grupo->nome_grupo ?></small></h2>
    </div>
    </div>
</div>

  <!--Tabela plantas-->
  <div class="row marge-tabela">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
    
        <!-- Tabela -->
        <div class="table-responsive">
          <table class="table table-bordered table-striped tabela table-hover table-condensed">
            <tr>
              <th class="tabela-nome-coluna">ID</th>
              <th class="tabela-nome-coluna">Nome</th>
              <th class="tabela-nome-coluna"></th>
            </tr>

            <?php while($planta = mysqli_fetch_object($result)){ ?>
            <tr>              
              <td onclick="botao('<?php echo "plantaConsumo.php?id_planta=".$planta->idecoflow ?>')"><?php echo $planta->idecoflow ?></td>
              <td onclick="botao('<?php echo "plantaConsumo.php?id_planta=".$planta->idecoflow ?>')"><?php echo $planta->nome ?></td>
              <td>
                <a href="plantaConsumo.php?id_planta=<?php echo $planta->idecoflow ?>" class="btn btn-primary btn-xs">
                  <span class="glyphicon glyphicon-folder-open" aria-hidden="true"> </span> Abrir
                </a>
              </td>            
            </tr>
            <?php } ?>
          </table>
        </div>

    </div>
  </div>


 <?php include_once("../footer.php") ?>