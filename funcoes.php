<?php

function controler_bot($url = NULL, $metodo = NULL, $parametros){

if(($metodo != NULL) && is_array($parametros) && ($url != NULL)){

    $response = @file_get_contents($url . $metodo . implode($parametros));
    json_decode($response, true);

    file_put_contents(__DIR__ . '/imbot.log', "\n" . $response, FILE_APPEND);
    file_put_contents(__DIR__ . '/imbot.log', "\n" . $url . $metodo . implode($parametros), FILE_APPEND);
}
}

function getUserByName($url = NULL, $metodo = NULL, $name){
    if(($metodo != NULL) && ($url != NULL)){

        try{
        $response = @file_get_contents($url . $metodo . '?NAME=' . $name);
        $response = json_decode($response);
        $resultado = $response->result;

        }catch(Exception $err){
            
            file_put_contents(__DIR__ . '/imbot.log', "\n" . $err->getMessage(), FILE_APPEND);

        }finally{

            file_put_contents(__DIR__ . '/imbot.log', "\n" . $url . $metodo . '?NAME=' . $name, FILE_APPEND);
            file_put_contents(__DIR__ . '/imbot.log', "\n" . $resultado[0]->ID . ' NAME=' .$name, FILE_APPEND);
        
        }
    }

    return $resultado[0]->ID;
}

