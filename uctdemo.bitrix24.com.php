<?php

$config = array(

    'BOT_ID' => '412',
    'CLIENT_ID' => 'bcr7mc35ek4qe9af5b2owxw05s8zi2hq',
    'URL' => 'https://uctdemo.bitrix24.com/rest/80/b3tccjddff2i2q0a/',

    //Uras do sistema
    'SAUDACAO' => "Olá! Que bom que você entrou em contato...",
    'SUB_URA_3' => "Com qual area deseja falar?%0A%0A1 - Bitrix24%0A2 - Telefonia%0A9 - Voltar ao menu anterior",
    'CAPTURA_NOME' => "Poderia me informar o seu nome?",
    'CAPTURA_TELEFONE' => ', se necessário, vamos entrar em contato por telefone para prosseguir com o seu atendimento de forma mais personalizada. Para isso, deixe aqui abaixo o seu melhor número. Com DDD, tá bom?',
    'CAPTURA_EMAIL' => ', agora me fala seu e-mail, por favor...',
    'URA' => ', para saber como te ajudar da melhor forma, preciso que você digite o número que corresponde ao motivo desse contato: %0A' . 
    '1 - Quero saber mais sobre a Conta PJ do C6 Bank; %0A' . 
    '2 - Quero saber sobre crédito para empresas; %0A' . 
    '3 - Quero dar um falar com um atendente;',
    //Grupos
    'COMERCIAL' => '148',
    'BITRIX' => '150',
    'TELEFONIA' => '152',
    'FINANCEIRO' => '154',

    // Pesquisar funcionários
    'SRC_USER' => 'https://uctdemo.bitrix24.com/rest/12/z2fsucx4hgkw2im3/',


    'URA_ERRO' => "Eroo",
);



function menu_ura($mensagem = NULL, $atual = NULL, $metodos, $conn, $config, $row = null)
{

   
    if(mb_strpos($mensagem, '=== Outgoing message, author: Bitrix24 (')){
        
        //Captura do nome do usuário que enviou a mensagem pelo Wazzup
        $pos = strpos($mensagem, '(');
        $nome = substr($mensagem, ($pos + 1), -1);
        $pos = strpos($nome, ')');
        $nome = substr($nome, 0, $pos);
        //--------------------------------

        file_put_contents(__DIR__ . '/imbot.log', "\n" . 'Mensagem do Wazzup detectada com o nome: ' . $nome , FILE_APPEND);
        
        $IDUSER = getUserByName($config['SRC_USER'], 'user.search.json?', $nome);

        file_put_contents(__DIR__ . '/imbot.log', "\n" . "ID: $IDUSER encontrado!", FILE_APPEND);

        controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                
            'BOT_ID=' . $config['BOT_ID'] . '&',
            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
            'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            'LEAVE=Y'  . '&',
            'TRANSFER_ID=' . $IDUSER
            
            )); 
    }else{



        if (!is_null($atual)) {

            $navegador = $atual;
            $controler = 1;
        } else {
    
            $navegador = $mensagem;
            $controler = 0;
        }
    
    
    
    
        switch ($navegador) {
    
            case '1':
    
                controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=Excelente escolha! O C6 Bank hoje é o único banco que oferece uma conta PJ TOTALMENTE gratuita e benefícios incríveis...'
                    
                    
                ));

                sleep(0.5);

                controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=Cesta de serviços, pix e tag de pedágio GRÁTIS, desconto na conta de luz de até 12%, cartão de crédito sem anuidade e sua empresa ainda pode ter CRÉDITO APROVADO mediante solicitação.'
                    
                    
                ));

                sleep(0.5);
                
                controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=' . $row['NOME'] . ', você tem interesse? %0A' .
                    '1 - Claro! Quero abrir a minha conta agora! %0A' . 
                    '2 - Não, não tenho interesse em economizar.%0A' . 
                    '0 - Voltar ao menu anterior.'
                    
                    
                ));

                if ($controler == 1) {
    
                    switch ($mensagem) {
    
                        case '1':
                            controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'MESSAGE=Perfeito! Em breve, um de nossos atendentes entrará em contato para dar início já à abertura da sua conta e garantir tudo isso e muito mais para a sua empresa. 😊'
                                
                                
                            ));

                            sleep(0.5);
                            
                            controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'MESSAGE=Ou então, entre em contato agora pelo nosso WhatsApp através do link: wa.me/552139008295'
                                
                                
                            ));
    
                            break;
    
                        case '2':

    
                            break;
    
                       
    
                        case '0':
    
                            menu_ura(0, "" , $metodos, $conn, $config);
    
                            $query = "DELETE FROM conversas  WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "' AND URL = '" . $_REQUEST['auth']['domain'] . "'";
    
                            $result = mysqli_query($conn, $query);
    
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
                }

                break;
    
            case '2':
    
                controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=Excelente escolha! O C6 Bank hoje é o único banco que oferece uma conta PJ TOTALMENTE gratuita e benefícios incríveis...'
                    
                    
                ));
                
                controler_bot($config['URL'], $metodos['ENVIAR'], array(

                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=Excelente escolha! O C6 Bank hoje é o único banco que oferece uma conta PJ TOTALMENTE gratuita e benefícios incríveis...'
                    
                        
                ));
                    
                    controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'LEAVE=Y'  . '&',
                    'QUEUE_ID=' . $config['FINANCEIRO']
                    
                    )); 
    
                    $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
        
                    $result = mysqli_query($conn, $query);
    
    
                break;
    
            case '3':
    
                if ($controler == 1) {
    
                    switch ($mensagem) {
    
                        case '1':
    
                            controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'MESSAGE=Alguêm da equipe de Bitrix24 já ira atender você'
                                
    
                            ));
    
                            controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
    
                                
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',                            
                                'QUEUE_ID=' . $config['BITRIX'] . '&',
                                'LEAVE=' . "Y",
    
                            ));  
    
                            $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
    
                            $result = mysqli_query($conn, $query);
    
                            break;
    
                        case '2':
    
                            controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'MESSAGE=Alguêm da equipe de telefonia já ira atender você'
                                
    
                            ));
    
                            controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'LEAVE=Y'  . '&',
                                'QUEUE_ID=' . $config['TELEFONIA']
    
                            ));  
    
                            $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
    
                            $result = mysqli_query($conn, $query);
    
                            break;
    
                       
    
                        case '9':
    
                            menu_ura(0, "" , $metodos, $conn, $config);
    
                            $query = "DELETE FROM conversas  WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "' AND URL = '" . $_REQUEST['auth']['domain'] . "'";
    
                            $result = mysqli_query($conn, $query);
    
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
    
                case '9':
    
    
                    break;
    
                case '999':
    
    
                    break;
    
            default:
    
                controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=' . $config['URA_ERRO']
    
                ));
    
                break;
        }
    }

}

?>