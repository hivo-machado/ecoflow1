<?php

function converterBup($payload){
    
    //0->leitura 1->medidor 2->servico 3->nome 4->planta
    $leitura = array(
        array(hexdec(substr($payload, 4, 8))/1000,"1",0,"lora01",62),
        array(hexdec(substr($payload, 14, 8))/1000,"2",0,"lora02",62), 
        array(hexdec(substr($payload, 24, 8))/1000,"3",0,"lora03",62), 
        array(hexdec(substr($payload, 32, 8))/1000,"4",0,"lora04",62) 
    );

    return($leitura);
}

// function statusItc($dados){
    // $leitura->[0]->[1] = hexdec(substr($payload, 4, 2))*0.1;
// }

?>