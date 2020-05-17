<?php
    include_once('../dbconnection.php');
    include_once('crud-cartas-funcs.php');

    /*
     * {cod: '', acao: '', expressao: ''}
     */

    $json = json_decode(file_get_contents('php://input'));
    
    if ($json == null) {
        echo "null";
        exit;
    }

    if ($json->acao) {
        $acao = $json->acao;
    }else{
        $acao = "listar";
    }

    //die( json_encode($acao.'-'.$cod.'-'.$expressao.'-'.$campo2));
    
    switch($acao){
        case "inserir":
            if ($json->expressao == null) {
                echo "null";
                exit;
            }
            $expressao = $json->expressao;
            if (cadastrarCartaCalculo($db_conn, $expressao)) {
                echo json_encode("Ok");
            }else{
                echo "null";
            }
        break;
        case "deletar":
            if ($json->cod == null) {
                echo "null";
                exit;
            }
            $cod = $json->cod;
            if (removerCarta($db_conn, $cod)) {
                echo json_encode("Ok");
            }else{
                echo "null";
            }
        break;
        case "atualizar":
            if (($json->cod == null) || ($json->expressao == null)) {
                echo "null";
                exit;
            }
            $expressao = $json->expressao;
            $cod = $json->cod;
            if (editarCarta($db_conn, $cod, $expressao)) {
                echo json_encode("Ok");
            }else{
                echo "null";
            }
            break;
        default:
            listarCartas($db_conn);
    }
    
	mysqli_close($db_conn);	
	exit;
?>