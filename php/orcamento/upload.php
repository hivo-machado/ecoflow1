<?php
$target_dir = "/srv/http/ecoflow.net.br/php/orcamento/uploads/";
//$target_dir = "/home2/ecofl253/public_html/php/orcamento/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file = str_replace(" ", "_", $target_file);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Checar se o já existe algum arquivo com o mesmo nome
if (file_exists($target_file)) {
  echo "Arquivo duplicado";
  $uploadOk = 0;
}

// Aceitar somente alguns tipos de arquivos
if($imageFileType != "xls" && $imageFileType != "xlsx" ) {
  echo "Somente planilhas .xls e .xlsx são aceitas";
  $uploadOk = 0;
}

// Checar se $uploadOk foi setado em 0 em algum lugar
if ($uploadOk == 0) {
  echo "Algum erro no arquivo enviado.";
// Se tudo estiver correto importa o arquivo
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " importado com sucesso.";
  } else {
    echo "Houve um problema com a importação da planilha";
  }
}


?>

<html>
<body>

<div class="row hidden-print">
<!--Formulario de download em excel-->
<div class="col-sm-2 col-sm-offset-10">
	   <form  method="POST" action="editarPlanilha.php">

        <div class="sr-only">

          <!--Input text oculto com id_grupo-->
          <input type="text" class="form-control" id="id_grupo" name="nome" value=<?php echo $target_file ?>>

        </div>

        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-download-alt" arian-hidden="true"></span> Download</button>
      </form>
    </div>

    <html>
<body>