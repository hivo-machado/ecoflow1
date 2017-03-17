<?php 
  include_once("../header.php");
  include_once("../validar.php");
?>

<?php 
	//valida-se esta logado como Administrador ou sindico
	validaAdminSind();
 ?>

<?php 
	//variavel SESSAO
	$tipo = $_SESSION['tipo'];
	$id_grupo = $_SESSION['id_grupo'];

  //varivel GET
  $id_planta = $_GET['id_planta'];

	//Seleciona planta
	$result = mysqli_query($con, "SELECT * FROM planta WHERE idecoflow = '$id_planta' AND id_grupo_fk = '$id_grupo'");
	$planta = mysqli_fetch_object($result);

	//Verificação para perfil sindico
	if($tipo == 'sind'){
		//Verifica-se planta pertence a grupo senão usuario tentando acesso indevido
		if(!isset($planta)){
			echo '<meta http-equiv="refresh" content="0;URL=listaPlanta.php?error=Acesso indevido." />';
		}
	}else{
		//Seleciona planta
		$result = mysqli_query($con, "SELECT * FROM planta WHERE idecoflow = '$id_planta'");
		$planta = mysqli_fetch_object($result);
	}
	
 ?>

 <script>
   $(document).ready(function(){

    //função submit para tabela 
    $('#form').submit( function(){
      submit();
      return false;
    });

    function submit(){
      $.ajax({
        url:'plantaTabelaLeitura.php',
        type: 'POST',
        data: $('#form').serialize(),
        success: function(data){
          $('#tabela').html(data);
        },
        beforeSend: function(){
          $('#carregando').css({display:"block"});
        },
        complete: function(){
          $('#carregando').css({display:"none"});
        }
      });
      return false;
    };

    //data inicial
    var dataAtual = new Date();
    var dia = dataAtual.getDate();
    var mes = dataAtual.getMonth() + 1;//Ajusta mês de 0-11 para 1-12
    var ano = dataAtual.getFullYear();
    var hora = dataAtual.getHours();
    
    //formata o dia
    if (dia.toString().length == 1)
      dia = "0"+dia;
    //formata o mes
    if (mes.toString().length == 1)
      mes = "0"+mes;
    //formatar hora
    if (hora.toString().length == 1)
      hora = "0"+hora;

    //insere valores no input data e hora
    $('#data').val(ano + '-' + mes + '-' + dia);
    $('#hora').val(hora + ':00');

    submit();

  });//Fim document

 </script>

 <!--Cabeçalho da tabela-->
  <div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <div class="page-header">
        <h1>Consumo<small> Torre: <?php echo $planta->nome ?></small></h1>
      </div>
    </div>
  </div>

  <!--Campo selecionaveis-->
  <div class="row hidden-print">
    <div class="col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
      <form id="form" class="form-inline" method="POST" action="">
        <div class="col-sm-5 col-sm-offset-1 col-xs-4 col-xs-offset-1">

          <!--Input text oculto com id_planta-->
          <div class="form-group sr-only">
            <label for="id_planta" class="col-sm-4 control-label">ID Planta</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="id_planta" name="id_planta"
              value=<?php echo $id_planta ?>>
            </div>
          </div>

          <div class="form-group form-group-sm">
            <label for="data">Data</label>
            <input type="date" class="form-control" id="data" name="data" required>        
          </div>

          <div class="form-group form-group-sm">
            <label for="hora">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" required>        
          </div>

          <div class="form-group form-group-sm">
            <button type="submit" class="btn btn-primary btn-sm">Aplicar</button>
          </div>

        </div>
      </form>
    </div>
  </div>

  <!--Tabela de consumo do mes-->
  <div class="row marge-tabela">
    <div class="col-sm-6 col-sm-offset-3">
      <div id="tabela">
        <center><img src="../img/loader.gif" style="display: none" id="carregando"></center>
      </div>
    </div>
  </div>

  <div class="row hidden-print">

    <!--Botão imprimir-->
    <div class="col-sm-2 col-sm-offset-8 hidden-xs">
      <form>
        <button type="button" class="btn btn-primary" name="imprimir" value="Imprimir" onclick="window.print();"><span class="glyphicon glyphicon-print" arian-hidden="true"></span> Imprimir</button>
      </form>
    </div>

  </div>

 <?php include_once("../footer.php") ?>