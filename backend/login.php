<?php
    include_once('dbconnection.php');

    function login($db, $usuario, $senha){
        $query = ("SELECT nome FROM jogador WHERE nome='".$usuario."' AND senha='".$senha."'");
        $result = mysqli_query($db, $query);
        if($result && mysqli_num_rows($result) > 0){
           resposta(true);
           return;
        }
        resposta(false);
    }

    function cadastraUsuario($db, $usuario, $senha){
        $query = ("INSERT INTO jogador(nome, senha, pontos) VALUES ('".$usuario."', '".$senha."', 0)");
        $result = mysqli_query($db, $query);
        if($result){
           resposta(true);
           return;
        }
        resposta(false);
    }

    function resposta($retorno){
        if($retorno){
            echo json_encode("OK");
            return;
        }
        echo "null";
    }

    /*
     * Formato de json esperado e.g.:
     * {"tipo":"login", "usuario":"Jogador1", "senha":"12345"}
     */

    $json = json_decode(file_get_contents('php://input'));
    $tipo = $json->tipo;
    $usuario = $json->usuario;
    $senha = $json->senha;
    
    if($tipo == "login-form"){
        login($db_conn, $usuario, $senha);
    }else{
        cadastraUsuario($db_conn, $usuario, $senha);
    }
    mysqli_close($db_conn);
?>