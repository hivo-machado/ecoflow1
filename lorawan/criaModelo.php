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


<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Criar Novo Modelo de Rádio</h2>
	  </div>
  	</div>
</div>

<!--Formulario -->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="criarModelo.php">

			<div class="form-group">
				<label for="modelo" class="col-sm-4 control-label">Modelo*</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="modelo" name="modelo" required autofocus
					maxlength="20"
                    pattern="[a-z0-9._%+-]{1, 20}$"
					title="Verifique os caracteres válidos."
					placeholder="Modelo">
				</div>
            </div>

            <div class="form-group">
				<label for="fabricante" class="col-sm-4 control-label">Fabricante*</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="fabricante" name="fabricante" required autofocus
					maxlength="20"
                    pattern="[a-z0-9._%+-]{1, 20}$"
					title="Verifique os caracteres válidos."
					placeholder="Fabricante">
				</div>
            </div>

			<div class="form-group">
				<label for="numero" class="col-sm-4 control-label">Numero*</label>
				<div class="col-sm-3">
                    <input type="number" class="form-control" id="numero" name="numero" min="1" >
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