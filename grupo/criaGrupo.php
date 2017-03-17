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
	    <h2>Adicionar Novo Grupo</h2>
	  </div>
  	</div>
</div>

<!--Formulario Nome e Foto-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="criarGrupo.php">

			<div class="form-group">
				<label for="nome" class="col-sm-4 control-label">Nome do Grupo*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="nome" name="nome" required autofocus
					maxlength="35"
					pattern="[A-Za-z0-9\s]{1,35}$" 
					title="Verifique os caracteres válidos a-z, A-Z, 0-9."
					placeholder="Nome grupo">
				</div>
			</div>

			<div class="form-group">
				<label for="link" class="col-sm-4 control-label">Link*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="link" name="link" required
					minlength="1"
					maxlength="255"
					pattern="https?://.+" 
					title="Inclua http://"
					placeholder="http://ecoflow.ind.br/...">
				</div>
			</div>

			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-4">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Salvar Novo Grupo</button>
				</div>
			</div>

		</form>
	</div>
</div>

 <?php include_once("../footer.php") ?>