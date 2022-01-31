<?php

file_put_contents(__DIR__ . '/imbot.log', "\n" . print_r($_REQUEST, 1), FILE_APPEND);

if($_REQUEST['event'] != 'ONIMBOTJOINCHAT'){

    include($_REQUEST['auth']['domain'] . '.php');

    file_put_contents(__DIR__ . '/imbot.log', "\n" . print_r($_REQUEST, 1), FILE_APPEND);
    
    include('conexao.php');
    
    include('metodos.php');
    
    include('funcoes.php');
    
    $query = "SELECT * FROM conversas WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['TO_CHAT_ID'] . "'AND URL = '" . $_REQUEST['auth']['domain'] ."'";
    
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) <= 0){
    
        $query = "INSERT INTO conversas(`CHAT_ID`, `URL`) VALUES('" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "' ," . "'" . $_REQUEST['auth']['domain'] . "')";    
    
        $result = mysqli_query($conn, $query);
    
        controler_bot($config['URL'], $metodos['ENVIAR'], array(
            
            'BOT_ID=' . $config['BOT_ID'] . '&',
            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
            'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            'MESSAGE=' . $config['URA'] 
        
        ));
    
    }else{
    
        $ura = mysqli_fetch_row($result);   
    
        //file_put_contents(__DIR__ . '/imbot.log', "\n" . 'Batata', FILE_APPEND);
    
        if($_REQUEST['data']['USER']['IS_EXTRANET'] == 'Y'){
    
            menu_ura($_REQUEST['data']['PARAMS']['MESSAGE'], $ura[3] , $metodos, $conn, $config);
    
        }
    
    }
    


    
}


