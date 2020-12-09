<?php

function converterKhomp($payload){
    
    //0->leitura 1->medidor
    $leitura = array(
        hexdec(substr($base, 4, 2))/10,
        array(hexdec(substr($payload, 10, 8))/1000,"1") 
    );

    return($leitura);
}

?>