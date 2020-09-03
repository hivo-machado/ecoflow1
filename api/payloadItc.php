<?php

function converterItc($payload){
    
    //0->leitura 1->medidor 2->servico 3->nome 4->planta
    $leitura = array(
        array(hexdec(substr($payload, 10, 8))/1000,"1",0,"teste",62) 
    );

    return($leitura);
}

// function statusItc($dados){
    // $leitura->[0]->[1] = hexdec(substr($payload, 4, 2))*0.1;
// }

?>