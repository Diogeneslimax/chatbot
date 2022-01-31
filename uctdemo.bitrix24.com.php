<?php

$config = array(

    //Configurações da plataforma 
    'BOT_ID' => '322',
    'CLIENT_ID' => 'q1m6yx2du0g59jobb1glyl4q5hinv0ei',
    'URL' => 'https://uctdemo.bitrix24.com/rest/154/nlc3a0iv9u2h768g/',

    //Uras do sistema
    'URA' => "Bem vindo a UC Technology.%0A%0ASelecione a opção desejada:%0A1 - Comercial%0A2 - Financeiro%0A3 - Suporte Técnico",
    'SUB_URA_3' => "Com qual area deseja falar?%0A%0A1 - Bitrix24%0A2 -Telefonia%0A",

    //Grupos


);

function menu_ura($mensagem = NULL, $atual = NULL, $metodos, $conn, $config)
{

    if ($mensagem != 9) {

        if (!is_null($atual)) {

            $navegador = $atual;
            $controler = 1;
        } else {

            $navegador = $mensagem;
            $controler = 0;
        }
    } else {

        $navegador = $mensagem;
    }

    switch ($navegador) {

        case '1':


            break;

        case '2':


            break;
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        case '3':


            if ($controler == 1) {

                switch ($mensagem) {

                    case '1':

                        break;

                    case '2':

                        break;

                    case '3':

                        controler_bot($config['URL'], $metodos['ENVIAR'], array(

                            'BOT_ID=' . $config['BOT_ID'] . '&',
                            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                            'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                            'MESSAGE=Alguêm da equipe de desenvolvimento já ira atender você'
                            

                        ));

                        controler_bot($config['URL'], $metodos['TRANSFERIR'], array(

                            'BOT_ID=' . $config['BOT_ID'] . '&',
                            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                            'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                            'LEAVE=Y&',
                            'QUEUE_ID=74'

                        ));                        

                        break;

                    case '9':

                        break;

                    default:

                        controler_bot($config['URL'], $metodos['ENVIAR'], array(

                            'BOT_ID=' . $config['BOT_ID'] . '&',
                            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                            'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                            'MESSAGE=' . $config['SUB_URA_3']

                        ));

                        break;
                }
            } else {

                $query = "UPDATE conversas SET URA = '" . $navegador . "' WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "' AND URL = '" . $_REQUEST['auth']['domain'] . "'";

                $result = mysqli_query($conn, $query);

                controler_bot($config['URL'], $metodos['ENVIAR'], array(

                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=' . $config['SUB_URA_3']

                ));
            }

            break;
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        case '4':


            break;

        case '5':


            break;

        case '6':


            break;

        case '7':


            break;

        case '8':


            break;

        case '9':


            break;

        default:

            controler_bot($config['URL'], $metodos['ENVIAR'], array(

                'BOT_ID=' . $config['BOT_ID'] . '&',
                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                'MESSAGE=' . $config['URA']

            ));

            break;
    }
}
