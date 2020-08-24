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
    $result = mysqli_query($con, "SELECT * FROM lorawan_devices");
 ?>


<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Criar Nova Unidade</h2>
	  </div>
  	</div>
</div>

<!--Formulario -->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="criarUnidade.php">

			<div class="form-group">
				<label for="nome" class="col-sm-4 control-label">ID*</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="nome" name="nome" required autofocus
					maxlength="20"
                    pattern="[A-Z0-9.-_]{1, 20}$"
					title="Verifique os caracteres válidos."
					placeholder="Nome">
				</div>
            </div>

            <div class="form-group">
				<label for="medidor" class="col-sm-4 control-label">Medidor*</label>
				<div class="col-sm-3">
					<select name="medidor" id="medidor" class="form-control" required>
						<option value="">Selecione</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					 </select>
				</div>
            </div>

            <div class="form-group">
				<label for="servico" class="col-sm-4 control-label">Serviço</label>
				<div class="col-sm-3">
					<select name="servico" id="servico" class="form-control" required>
						<option value="">Selecione</option>
						<option value="0">Água</option>
						<option value="1">Gás</option>
						<option value="2">Água quente</option>
					 </select>
				</div>
            </div>
            
            <div class="form-group">
				<label for="device" class="col-sm-4 control-label">Device*</label>
				<div class="col-sm-4" >
					<select name="device" id="device" class="form-control">
						<option value="">Selecione</option>
						<?php 
							while ( $devices = mysqli_fetch_object($result) ) {
								echo '<option value="'.$devices->device_addr.'">'.$devices->device_addr.'</option>';
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