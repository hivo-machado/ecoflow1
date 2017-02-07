<?php 
include_once("../header.php");
include_once("../validar.php");
?>

<?php 
	//variavel de sessão
	$id = $_SESSION['id'];
 ?>

 <!--Link para mascara dos input-->
<script src="../js/mascara.js"></script>

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

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Nome e Foto</h2>
	  </div>
  	</div>
</div>

<!--Formulario Nome e Foto-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarNome.php" enctype="multipart/form-data">

			<div class="form-group">
				<label for="nome" class="col-sm-4 control-label">Nome*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="nome" name="nome" required autofocus>
				</div>
			</div>

			<div class="form-group">
				<label for="foto" class="col-sm-4 control-label">Foto</label>
				<div class="col-sm-8">
					<input type="file" id="foto" name="arquivo">
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

<div class="row">
	<div class="col-sm-12 col-xs-12">
		<span id="helpBlock" class="help-block text-right">* Campos obrigatórios.</span>
	</div>	
</div>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Endereço</h2>
	  </div>
  	</div>
</div>

<!--Formulario Endereço-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarEndereco.php" >
				
			<div class="form-group">
				<label for="rua" class="col-sm-4 control-label">Rua*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="rua" name="rua" maxlength="255" required>
				</div>
			</div>

			<div class="form-group">
				<label for="numero" class="col-sm-4 control-label">Numero*</label>
				<div class="col-sm-3">
					<input type="number" class="form-control" id="numero" name="numero" min="1" required>
				</div>
			</div>

			<div class="form-group">
				<label for="cidade" class="col-sm-4 control-label">Cidade*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="cidade" name="cidade" maxlength="255" required>
				</div>
			</div>

			<div class="form-group">
				<label for="bairro" class="col-sm-4 control-label">Bairro*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="bairro" name="bairro" maxlength="255" required>
				</div>
			</div>

			<div class="form-group">
				<label for="uf" class="col-sm-4 control-label">UF*</label>
				<div class="col-sm-3">
					<select name="uf" id="uf" class="form-control" required>
						<option value="">Selecione</option>
						<option value="AC">AC</option>
						<option value="AL">AL</option>
						<option value="AM">AM</option>
						<option value="AP">AP</option>
						<option value="BA">BA</option>
						<option value="CE">CE</option>
						<option value="DF">DF</option>
						<option value="ES">ES</option>
						<option value="GO">GO</option>
						<option value="MA">MA</option>
						<option value="MG">MG</option>
						<option value="MS">MS</option>
						<option value="MT">MT</option>
						<option value="PA">PA</option>
						<option value="PB">PB</option>
						<option value="PE">PE</option>
						<option value="PI">PI</option>
						<option value="PR">PR</option>
						<option value="RJ">RJ</option>
						<option value="RN">RN</option>
						<option value="RS">RS</option>
						<option value="RO">RO</option>
						<option value="RR">RR</option>
						<option value="SC">SC</option>
						<option value="SE">SE</option>
						<option value="SP">SP</option>
						<option value="TO">TO</option>
					 </select>
				</div>
			</div>

			<div class="form-group">
				<label for="cep" class="col-sm-4 control-label">CEP*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="cep" name="cep" 
					maxlength="9" OnKeyPress="formatar('#####-###', this)" required
					pattern="[0-9]{5}-\[0-9]{3}"
					title="Verifique o CEP com seguinte formato XXXXX-XXX">
				</div>
			</div>

			<div class="form-group">
				<label for="telefone" class="col-sm-4 control-label">Telefone</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="telefone" name="telefone" maxlength="15" OnKeyPress="mascara( this, mtel );">
				</div>
			</div>

			<div class="form-group">
	    		<div class="col-sm-4 col-sm-offset-8">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar Endereço</button>
				</div>
			</div>

		</form>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-xs-12">
		<span id="helpBlock" class="help-block text-right">* Campos obrigatórios.</span>
	</div>	
</div>


<?php include_once("../footer.php") ?>
