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

	if( isset($_GET['id_grupo']) ){
		$id_grupo = $_GET['id_grupo'];
	}else{
		$id_grupo = $_SESSION['id_grupo'];
	}

	$result = mysqli_query($con,"SELECT * FROM grupo WHERE id = '$id_grupo'");
	$grupo = mysqli_fetch_object($result);
 ?>

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Nome e Foto do Grupo <small><?php echo $grupo->nome ?></small></h2>
	  </div>
  	</div>
</div>

<!--Formulario Nome e Foto-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarNome.php" enctype="multipart/form-data">

			<!--Input text oculta com id do grupo-->
			<div class="form-group sr-only">
				<label for="id_grupo" class="col-sm-4 control-label">ID Grupo*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="id_grupo" name="id_grupo"
					placeholder=<?php echo $id_grupo ?> value=<?php echo $id_grupo ?>>
				</div>
			</div>

			<div class="form-group">
				<label for="nome" class="col-sm-4 control-label">Nome*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="nome" name="nome" required autofocus
					maxlength="32" 
					pattern="[A-Za-z0-9\s]{1,32}$" 
					title="Verifique os caracteres válidos a-z, A-Z e 0-9."
					placeholder="Nome do Grupo">
					<span id="helpBlock" class="help-block">* Campo obrigatório.</span>
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

<!--Cabeçalho da pagina-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	  <div class="page-header">
	    <h2>Alterar Endereço do Grupo <small><?php echo $grupo->nome ?></small></h2>
	  </div>
  	</div>
</div>

<!--Formulario Endereço-->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form class="form-horizontal" method="POST" action="alterarEndereco.php" >

			<!--Input text oculta com id do grupo-->
			<div class="form-group sr-only">
				<label for="id_grupo" class="col-sm-4 control-label">ID Grupo*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="id_grupo" name="id_grupo"
					placeholder=<?php echo $id_grupo ?> value=<?php echo $id_grupo ?>>
				</div>
			</div>
				
			<div class="form-group">
				<label for="rua" class="col-sm-4 control-label">Rua*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="rua" name="rua" maxlength="64" required
					placeholder="Rua do grupo">
				</div>
			</div>

			<div class="form-group">
				<label for="numero" class="col-sm-4 control-label">Numero*</label>
				<div class="col-sm-3">
					<input type="number" class="form-control" id="numero" name="numero" min="1" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="bairro" class="col-sm-4 control-label">Bairro*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="bairro" name="bairro" maxlength="64" required
					placeholder="Bairro do grupo">
				</div>
			</div>

			<div class="form-group">
				<label for="cidade" class="col-sm-4 control-label">Cidade*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="cidade" name="cidade" maxlength="64" required
					placeholder="Cidada do grupo">
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
	    		<div class="col-sm-4 col-sm-offset-8">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar Endereço</button>
				</div>
			</div>

		</form>
	</div>
</div>

<!--Verifica se usuário e do perfil administrador-->
<?php if($_SESSION['tipo']=='admin'){ ?>
	<!--Cabeçalho da pagina-->
	<div class="row">
		<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		  <div class="page-header">
		    <h2>Ativar ou Desativar usuários do Grupo <small><?php echo $grupo->nome ?></small></h2>
		  </div>
	  	</div>
	</div>

	<!--Formulario ativar ou desativar usuarios do grupo-->
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1"><!--Div para ajuste de tela pequena-->

			<div class="row">
				<div class="col-sm-8 col-sm-offset-4">
					<p>Ativa ou desativa usuários do grupo no sistema. (Caso usuário seja desativado ele será impedido de se logar.)</p>
				</div>
			</div>

			<div class=" col-sm-8 col-sm-offset-4">
				<form class="form-horizontal" method="post" action="statusUsuarios.php">
					
					<div class="form-group">

						<!--Input text oculta com id do grupo-->
						<div class="form-group sr-only">
							<label for="id_grupo" class="col-sm-4 control-label">ID Grupo*</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="id_grupo" name="id_grupo"
								placeholder=<?php echo $id_grupo ?> value=<?php echo $id_grupo ?>>
							</div>
						</div>

						<div class="radio">
						  <label>
						    <input type="radio" name="status" id="optionsRadios1" value="ativo" checked>
						    Ativar usuários.
						  </label>
						</div>

						<div class="radio">
						  <label>
						    <input type="radio" name="status" id="optionsRadios2" value="desativo">
						    Desativar usuários.
						  </label>
						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar Usúarios</button>
					</div>

				</form>
			</div>

		</div>
	</div>
<?php } ?>

<?php include_once("../footer.php") ?>
