<?php 
include_once("../header.php");
include_once("../validar.php");
?>

 <!--Link para mascara dos input-->
<script src="../js/mascara.js"></script>

<?php 
	//função para verificar se esta logado
	valida();
	//função para verificar se esta logado como síndico
	validaAdminSind();
 ?>

<?php 
	//variavel de sessão
	$id = $_SESSION['id'];

	if( isset($_GET['id_planta']) ){
		$id_planta = $_GET['id_planta'];
	}else{
		$id_planta = $_SESSION['id_planta'];
	}

	$result = mysqli_query($con,"SELECT * FROM planta WHERE idecoflow = '$id_planta'");
	$planta = mysqli_fetch_object($result);
 ?>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Planta <small><?php echo $planta->nome ?></small></h2>
	  </div>
  	</div>
</div>

<!--Formulario Nome e Foto-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarPlanta.php" enctype="multipart/form-data">

			<!--Input text oculta com id da planta-->
			<div class="form-group sr-only">
				<label for="id_planta" class="col-sm-4 control-label">ID Planta*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="id_planta" name="id_planta"
					value=<?php echo $id_planta ?>>
				</div>
			</div>

			<div class="form-group">
				<label for="nome" class="col-sm-4 control-label">Nome*</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="nome" name="nome" required autofocus
					maxlength="20"
					pattern="[A-Za-z]{1,20}$" 
					title="Verifique os caracteres válidos a-z, A-Z e sem espaço."
					placeholder="Nome">
				</div>
            </div>

			<div class="form-group">
				<label for="grupo" class="col-sm-4 control-label">Grupo*</label>
				<div class="col-sm-4" >
					<select name="grupo" id="grupo" class="form-control" required>
						<option value="">Selecione</option>
						<?php 
							$result = mysqli_query($con, "SELECT * FROM grupo");
							while ( $grupos = mysqli_fetch_object($result) ) {
								echo '<option value="'.$grupos->id.'">'.$grupos->nome.'</option>';
							}
						 ?>
                     </select>
                     <span id="helpBlock" class="help-block">* Campos obrigatórios.</span>
				</div>
			</div>

			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-8">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
				</div>
			</div>

		</form>
	</div>
</div>

<?php include_once("../footer.php") ?>
