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
	//busca no BD todos os grupos para criação de select option
    $resultModelo = mysqli_query($con, "SELECT * FROM lorawan_modelos");
    $resultPlanta = mysqli_query($con, "SELECT * FROM planta");
 ?>


<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Criar Novo Device</h2>
	  </div>
  	</div>
</div>

<!--Formulario -->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="criarDevice.php">

			<div class="form-group">
				<label for="id" class="col-sm-4 control-label">ID*</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="id" name="id" required autofocus
					maxlength="20"
                    pattern="[A-Z0-9]{1, 20}$"
					title="Verifique os caracteres válidos."
					placeholder="Modelo">
				</div>
            </div>

            <div class="form-group">
				<label for="modelo" class="col-sm-4 control-label">Modelo*</label>
				<div class="col-sm-4" >
					<select name="modelo" id="modelo" class="form-control">
						<option value="">Selecione</option>
						<?php 
							while ( $modelos = mysqli_fetch_object($resultModelo) ) {
								echo '<option value="'.$modelos->modelo.'">'.$modelos->modelo.'</option>';
							}
						 ?>
                     </select>
				</div>
			</div>

			<div class="form-group">
				<label for="planta" class="col-sm-4 control-label">Planta*</label>
				<div class="col-sm-4" >
					<select name="planta" id="planta" class="form-control">
						<option value="">Selecione</option>
						<?php 
							while ( $plantas = mysqli_fetch_object($resultPlanta) ) {
								echo '<option value="'.$plantas->idecoflow.'">'.$plantas->nome.'</option>';
							}
						 ?>
                     </select>
                     <span id="helpBlock" class="help-block">* Campos obrigatórios.</span>
				</div>
			</div>
			
			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-4">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Salvar Novo Modelo</button>
				</div>
			</div>

		</form>
	</div>
</div>


 <?php include_once("../footer.php") ?>