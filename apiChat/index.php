<?php
include "conexão.php";
$con =   Conexao::getConexao();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // echo"{status:'ok'}";
    // echo time()*1000;
    if (isset($_REQUEST['timestamp']) and !empty($_REQUEST['timestamp'])) {
        $sql = "SELECT*FROM message WHERE timestamp>" . $_GET['timestamp'];
        if ($resultado = $con->query($sql)) {
            // print_r($resultado);
            $return['status'] = 'ok';
            $return['rows'] = $resultado->rowCount();
            while ($message = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $messages[] = $message;
            }
            $return['msg'] = $messages;
            echo json_encode($return);
            // print_r($return);
        } else {
            echo "{status:error}";
        }
    } else {
        echo "{status:error}";
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Verifica se a request está vazia
    if (file_get_contents("php://input") != null and !empty(file_get_contents("php://input"))) {
        //Decodifica o arquivo json
        if ($request = json_decode(file_get_contents("php://input"), true)) {
            //Verifica qual o nick e message que estão na request
            if (isset($request["nick"]) && isset($request["message"])) {
                //Pega o timestamp exato da requisição
                $timestamp = time() * 1000;
                $nick = $request["nick"];
                $message = $request["message"];
                //Insere os comandos do banco de dados na string variável sql
                $sql = "INSERT INTO message(message, nick, timestamp) VALUES (\"" . $message . "\",\"" . $nick . "\"," . $timestamp . ")";
                if ($con->query($sql)) {
                    $request["timestamp"] = $timestamp;
                    $return["request"] = $request;
                    $return["status"] = "ok";
                } else {
                    //Retorna erro caso aconteça algum erro na hora da inserção dos itens na base de dados
                    $return["status"] = "err";
                    $return["err"] = "Erro ao inserir dados no banco de dados";
                }
            } else {
                //Retorna o erro caso falta um dos parâmetros da request
                $return["status"] = "err";
                $return["err"] = "Nem todos os parametros foram enviados";
            }
        } else {
            //Retorna o erro caso a request não esteja em formato json
            $return["status"] = "err";
            $return["err"] = "Request não está em JSON";
        }
    } else {
        //Retorna o erro caso a request esteja vazia
        $return["status"] = "err";
        $return["err"] = "A Request retornou vazia";
    }
    echo json_encode($return);
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
}
