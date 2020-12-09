<?php

function converterBup($payload){
    
    //0->leitura 1->medidor
    $leituras = array(
        hexdec(substr($payload, 2, 2))/10,
        array(hexdec(substr($payload, 4, 8))/1000,"1"),
        array(hexdec(substr($payload, 14, 8))/1000,"2"), 
        array(hexdec(substr($payload, 24, 8))/1000,"3"), 
        array(hexdec(substr($payload, 32, 8))/1000,"4") 
    );

    return($leituras);
}

?>