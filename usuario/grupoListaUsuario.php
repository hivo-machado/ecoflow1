<?php 
  include("../header.php");
  include("../validar.php");
  include('../conexao.php');

	//valida-se esta logado como Administrador ou sindico
	validaAdminSind();
 ?>

<?php 
	//variavel SESSAO
  $id = $_SESSION['id'];
  $tipo = $_SESSION['tipo'];

  if($tipo != "sind"){
    if( isset( $_GET['id_grupo']) ){
      //varivel GET
      $id_grupo = $_GET['id_grupo'];
    }
  }else{
    $id_grupo = $_SESSION['id_grupo'];
  }

  

/*
  //Seleciona usuario
  $result = mysqli_query($con, "SELECT * FROM usuario WHERE id = '$id' AND id_grupo = '$id_grupo'");
  $usuario = mysqli_fetch_object($result);

	//Verificação para perfil sindico
	if($tipo == 'sind'){
		//Verifica-se usuario pertence ao grupo senão usuario tentando acesso indevido
		if(!isset($usuario)){
			echo '<meta http-equiv="refresh" content="0;URL=../home/home.php?error=Acesso indevido." />';
		}
	}
*/
	
  //Seleciona grupo
	$result = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$id_grupo'");
	$grupo = mysqli_fetch_object($result);
 ?>

 <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1>Lista de Usuário<small> Grupo: <?php echo $grupo->nome ?></small></h1>
      </div>
    </div>
  </div>

  
  <!--Tabela de consumo do mes-->
  <div class="row marge-tabela">
    <div class="col-sm-12 col-xs-12">
      <div id="tabela">
        <?php

          //Variavel
          $cont = 0;

          //Plantas do grupo
          $plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$id_grupo' ORDER BY nome");

          while($planta = mysqli_fetch_object($plantas) ){
            $cont++;

            //Seleciona todos os usuarios da planta ativos com perfil usuario
            $usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE id_planta = '$planta->idecoflow' AND tipo LIKE 'usuario' AND status = 'ativo' ORDER BY nome");
            if( $cont == 1) echo "<div class='row'>";
         ?>

        <div class="col-sm-4">
          <div class="panel panel-primary">
            <div class="panel-heading tabela-titulo"><strong><?= $planta->nome ?></strong></div>
            <!-- Tabela -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped tabela table-hover table-condensed">
                <tr>
                  <th class="tabela-nome-coluna">Nome</th>
                  <th class="tabela-nome-coluna">Login</th>
                  <th class="tabela-nome-coluna">Senha</th>
                </tr>

                <?php while( $usuario = mysqli_fetch_object($usuarios) ){ ?>
                <tr>
                  <td><?= $usuario->nome ?></td>
                  <td><?= $usuario->login ?></td>
                  <td><?= $usuario->senha ?></td>
                </tr>
                <?php } ?>
                
              </table>
            </div>
          </div>
        </div>

        <?php 
          if( $cont == 3){
           echo "</div>";
           $cont = 0;
          }
        } 
        ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-2 col-sm-offset-10 col-xs-5 col-xs-offset-7">
      <a href="grupoDownloadUsuario.php?id_grupo=<?php echo $id_grupo ?>" class="btn btn-primary">
        <span class="glyphicon glyphicon-download-alt" aria-hidden="true"> </span> Download
      </a>
    </div>
  </div>
  

 <?php include_once("../footer.php") ?>