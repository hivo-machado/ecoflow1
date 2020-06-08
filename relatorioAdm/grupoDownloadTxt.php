<?php 
	include_once("../conexao.php");
    
    /*Funcao criada especialmente para o cliente do Villa Lobos*/

    //Coleta da data da requisição formato do banco
    
    if(date("d") > 1){
        $dataBancoFim = date("Y-m-01");
        $dataBancoInicio = date("Y-m-01", strtotime("-1 months"));
    }else{
        $dataBancoFim = date("Y-m-01", strtotime("-1 months"));
        $dataBancoInicio = date("Y-m-01", strtotime("-2 months"));
    }
    
    $id = '3';

    //Consultar Grupo
	$result = mysqli_query($con, "SELECT * from grupo WHERE id = '$id'");
	$grupo = mysqli_fetch_object($result);
	
    // Nome do Arquivo do .txt que será gerado
    $arquivo = "$grupo->nome.$dataBancoInicio.$dataBancoFim.txt";
   
    //Consultar plantas 
    $plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$id' ORDER BY nome");
    
    // Loop por planta
    while($planta = mysqli_fetch_object($plantas)){        
        $unidades = mysqli_query($con, "SELECT * FROM unidade WHERE id_planta_fk = '$planta->idecoflow' AND tempo = '$dataBancoFim' AND hora LIKE '06:%' ORDER BY nome");

        // Loop por unidades
        while($unidade = mysqli_fetch_object($unidades)){            
            //Seleciona a leitura inicial da unidade
			$resInicio = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$unidade->idecoflow' AND tempo = '$dataBancoInicio' AND hora LIKE '06:%'");
            $unidadeInicio = mysqli_fetch_object($resInicio);

			//Seleciona a leitura final da unidade
			$resFim = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$unidade->idecoflow' AND tempo = '$dataBancoFim' AND hora LIKE '06:%'");
            $unidadeFim = mysqli_fetch_object($resFim);
            
            //TIPO
            $tipo = "AGUA    ";

            //VERSAO
            $versao = "10";

            //CODIGO CONDOMINIO
            $codigoCondominio = "0567"; //sistema do cliente verifica o grupo pelo codigo "567"

            //BLOCO 
            switch ($unidade->id_planta_fk){
                case 2://Torre C
                    $blocoCliente = '   C';
                    $unidadeCliente = preg_replace("/[^AB0-9]/", "", $unidade->nome);                    
                    break;
                case 6://Torre E
                    $blocoCliente = '   E';
                    $unidadeCliente = preg_replace("/[^0-9]/", "", $unidade->nome);
                    break;
                case 7://Torre A
                    $blocoCliente = '   A';
                    $unidadeCliente = preg_replace("/[^0-9]/", "", $unidade->nome);
                    break;
                case 8://Villa A&B
                    $blocoCliente = 'VILLA';
                    if($unidade->idecoflow != '1008'){
                        $unidadeCliente = preg_replace("/[^ABLVJ0-9]/", "", $unidade->nome);
                    }else{
                        $unidadeCliente = preg_replace("/[^CAFET]/", "", $unidade->nome);
                    }
                    break;
                case 9://Torre D
                    $blocoCliente = '   D';
                    $unidadeCliente = preg_replace("/[^0-9]/", "", $unidade->nome);
                    break;
                case 10://Torre B
                    $blocoCliente = '   B';
                    $unidadeCliente = preg_replace("/[^0-9]/", "", $unidade->nome);
                    break;
            }

            //UNIDADE
            $unidadeCliente = str_pad($unidadeCliente, 6, "0", STR_PAD_LEFT);

            //DATA LEITURA
            $dataCliente = date("01/m/Y");

            //MES
            $mesCliente = date("m");
                
            //ANO
            $anoCliente = date("Y");

            //LEITURA ANTERIOR 
            $leituraAnterior = (string)number_format($unidadeInicio->leitura, 4);
            $leituraAnterior = preg_replace("/[^0-9]/", "", $leituraAnterior);
            $leituraAnterior = str_pad($leituraAnterior, 14, "0", STR_PAD_LEFT);
            
            //LEITURA ATUAL 
            $leituraAtual = (string)number_format($unidadeFim->leitura, 4);
            $leituraAtual = preg_replace("/[^0-9]/", "", $leituraAtual);
            $leituraAtual = str_pad($leituraAtual, 14, "0", STR_PAD_LEFT);
            
            //CONSUMO 
            $consumo = (string)number_format($unidadeFim->leitura-$unidadeInicio->leitura, 4);
            $consumo = preg_replace("/[^0-9]/", "", $consumo);
            $consumo = str_pad($consumo, 14, "0", STR_PAD_LEFT);

            //VALOR
            $valor = "0";
            $valor = (string)number_format($valor, 2);
            $valor = preg_replace("/[^0-9]/", "", $valor);
            $valor = str_pad($valor, 14, "0", STR_PAD_LEFT);
            
            ob_start();

            if(isset($unidadeFim)) {
                //Cria uma string no formato do cliente
                $stringCliente = $tipo.$versao.$codigoCondominio.$blocoCliente.$unidadeCliente.$dataCliente.$mesCliente.$anoCliente.$leituraAnterior.$leituraAtual.$consumo.$valor;
                echo("$stringCliente\n");
            }
        }
    }
    $stringDownload = ob_get_contents();
    ob_end_clean();
    //Forca o navegador a fazer download do arquivo
    header("Content-type: text/txt");
    header("Content-disposition: attachment; filename = $arquivo");    
 ?>