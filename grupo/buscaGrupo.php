<?php 
include_once("../header.php");
include_once("../validar.php");
?>

<!--Link para funções-->
<script type="text/javascript" src="../js/funcoes.js"></script>

<?php 
	//função para verificar se esta logado
	valida();
	//função para verificar se esta logado como administrador
	validaAdmin();
 ?>

<script>
  //Ajax para submit do formulario
  $(function(){
    $('#form').submit(function(){
      $.ajax({
        url:'buscarGrupo.php',
        type: 'GET',
        data: $('#form').serialize(),
        success: function(data){
          $('#tabela').html(data);
        }
      });
      return false;
    });
  });
</script>

 <!--Cabeçalho da pagina-->
<div class="row">
  <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
    <div class="page-header">
      <h2>Pesquisar Grupo</h2>
    </div>
    </div>
</div>

<!--Input da pesquisa-->
<div class="row">
	<div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		<form id="form" method="GET" action="">
        
      <label for="busca" class="col-sm-2 col-xs-12">Pesquisar</label>

      <div class="col-sm-10 col-xs-12">
        <div class="input-group">
          <input type="search" class="form-control" id="busca" name="busca" placeholder="Buscar por ID, Nome, Nome Grupo, Bairro, Cidade, UF" autofocus value = "<?php if(isset($_GET['busca']) ) echo $_GET['busca'] ?>" >
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
          </span>
        </div>        
      </div>

		</form>
	</div>
</div>

  <!--Tabela de resultado da busca-->
  <div class="row marge-tabela">
    <div class="col-sm-12 col-xs-12">
      <!--Div para receber o resultado do formulario em Ajax-->
      <div id="tabela"></div>
    </div>
  </div>


 <?php include_once("../footer.php") ?>