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

	if( isset($_GET['id_modelo']) ){
		$id_modelo = $_GET['id_modelo'];
	}else{
		$id_modelo = $_SESSION['id_modelo'];
	}

	$result = mysqli_query($con,"SELECT * FROM lorawan_modelos WHERE modelo = '$id_modelo'");
	$modelo = mysqli_fetch_object($result);
 ?>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Modelo <small><?php echo $modelo->modelo ?></small></h2>
	  </div>
  	</div>
</div>

<!--Formulario Nome e Foto-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarModelo.php" enctype="multipart/form-data">

			<!--Input text oculta com id da planta-->
			<div class="form-group sr-only">
				<label for="id_modelo" class="col-sm-4 control-label">Modelo*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="id_modelo" name="id_modelo"
					value=<?php echo $id_modelo ?>>
				</div>
			</div>

			<div class="form-group">
				<label for="fabricante" class="col-sm-4 control-label">Fabricante*</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="fabricante" name="fabricante" required autofocus
					maxlength="20"
					pattern="[A-Za-z]{1,20}$" 
					title="Verifique os caracteres válidos a-z, A-Z e sem espaço."
					placeholder="Fabricante">
				</div>
            </div>

            <div class="form-group">
				<label for="numero" class="col-sm-4 control-label">Qtd. de Medidores*</label>
				<div class="col-sm-3">
                    <input type="number" class="form-control" id="numero" name="numero" min="1" >
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
