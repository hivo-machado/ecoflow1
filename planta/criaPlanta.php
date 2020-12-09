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
	$result = mysqli_query($con, "SELECT * FROM grupo");
 ?>


<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Criar Nova Planta</h2>
	  </div>
  	</div>
</div>

<!--Formulario -->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="criarPlanta.php">

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
					<select name="grupo" id="grupo" class="form-control">
						<option value="">Selecione</option>
						<?php 
							while ( $grupos = mysqli_fetch_object($result) ) {
								echo '<option value="'.$grupos->id.'">'.$grupos->nome.'</option>';
							}
						 ?>
                     </select>
                     <span id="helpBlock" class="help-block">* Campos obrigatórios.</span>
				</div>
			</div>
			
			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-4">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Salvar Nova Planta</button>
				</div>
			</div>

		</form>
	</div>
</div>


 <?php include_once("../footer.php") ?>