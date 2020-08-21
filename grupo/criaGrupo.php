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
	    <h2>Criar Novo Grupo</h2>
	  </div>
  	</div>
</div>

<!--Formulario -->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="criarGrupo.php">

			<div class="form-group">
				<label for="nome" class="col-sm-4 control-label">Nome*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="nome" name="nome" required autofocus
					maxlength="20"
					pattern="[A-Za-z]{1,20}$" 
					title="Verifique os caracteres válidos a-z, A-Z e sem espaço."
					placeholder="Nome">
				</div>
            </div>

            <div class="form-group">
				<label for="rua" class="col-sm-4 control-label">Rua</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="rua" name="rua" maxlength="64" 
					placeholder="Rua do grupo">
				</div>
			</div>

			<div class="form-group">
				<label for="numero" class="col-sm-4 control-label">Numero</label>
				<div class="col-sm-3">
					<input type="number" class="form-control" id="numero" name="numero" min="1" >
				</div>
			</div>
			
			<div class="form-group">
				<label for="bairro" class="col-sm-4 control-label">Bairro</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="bairro" name="bairro" maxlength="64" 
					placeholder="Bairro do grupo">
				</div>
			</div>

			<div class="form-group">
				<label for="cidade" class="col-sm-4 control-label">Cidade</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="cidade" name="cidade" maxlength="64" 
					placeholder="Cidada do grupo">
				</div>
			</div>

			<div class="form-group">
				<label for="uf" class="col-sm-4 control-label">UF</label>
				<div class="col-sm-3">
					<select name="uf" id="uf" class="form-control" >
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
				<label for="cep" class="col-sm-4 control-label">CEP</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="cep" name="cep" 
					maxlength="9" OnKeyPress="formatar('#####-###', this)" 
					pattern="[0-9]{5}-[0-9]{3}$"
					title="Verifique o CEP com seguinte formato XXXXX-XXX"
					placeholder="XXXXX-XXX">
				</div>
			</div>

			<div class="form-group">
				<label for="telefone" class="col-sm-4 control-label">Telefone</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="telefone" name="telefone" maxlength="15" 
					title="Verifique o telefone com seguinte formato (XX) XXXX-XXXX ou (XX) 9XXXX-XXXX"
					placeholder="(XX) XXXX-XXXX ou (XX) 9XXXX-XXXX" 
					OnKeyPress="mascara( this, mtel );">
				<span id="helpBlock" class="help-block">* Campos obrigatórios.</span>
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