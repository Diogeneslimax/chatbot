<?php

function controler_bot($url = NULL, $metodo = NULL, $parametros){

if(($metodo != NULL) && is_array($parametros) && ($url != NULL)){

    $response = @file_get_contents($url . $metodo . implode($parametros));
    json_decode($response, true);

    
}
}