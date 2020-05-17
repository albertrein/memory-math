<?php
    include_once('dbconnection.php');
    include_once('crud-cartas-funcs.php');

    /*
     * {cod: '', acao: '', campo1: '', campo2: ''}
     */

     function select($db){
        $query = 'SELECT  CC.id, CC.expressao, CR.resultado FROM carta_calculo CC INNER JOIN carta_resposta CR WHERE CC.resposta = CR.id ORDER BY CC.id';
        $result = mysqli_query($db, $query) or die('null');

        if($result && mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            echo json_encode($rows);
            return true;
        }
        echo "null";
     }

    function delete($db,$cod){
        $query = "SET FOREIGN_KEY_CHECKS=OFF"; //Gambi pra fazer o delete
        mysqli_query($db, $query) or die(json_encode('null'));
        $query = 'DELETE carta_calculo, carta_resposta FROM carta_calculo INNER JOIN carta_resposta WHERE carta_calculo.RESPOSTA=carta_resposta.ID AND carta_calculo.ID='.$cod;
        $result = mysqli_query($db, $query) or die('null');
        //echo $query."-";
        if($result){
            echo json_encode("Ok!");
            return true;
        }
        echo "null";
    }

    function insert($db,$campo1, $campo2){
        $query = 'SELECT COUNT(*) AS total FROM carta_calculo CC WHERE CC.expressao = "'.$campo1.'"';
        $result = mysqli_query($db, $query)or die('null');
        $row = mysqli_fetch_assoc($result);

        if($row['total'] == 0) {
            cadastrarCartaCalculo($db, $campo1, $campo2);
            echo json_encode("Ok");
        } else {
            echo "null";
        }
    }

    function update($db, $cod, $campo1, $campo2){
        $query = "UPDATE carta_calculo CC, carta_resposta CR SET CC.expressao='".$campo1."', CR.resultado='".$campo2."' WHERE CC.resposta=CR.id AND CC.id=".$cod;
        $result = mysqli_query($db, $query)or die('null');
    
        echo json_encode("Ok");
        
    }

    $json = json_decode(file_get_contents('php://input'));
    $cod = $json->cod;
    $acao = $json->acao;
    $campo1 = $json->campo1;
    $campo2 = $json->campo2;

    //die( json_encode($acao.'-'.$cod.'-'.$campo1.'-'.$campo2));
    
    switch($acao){
        case "inserir":
            insert($db_conn, $campo1, $campo2);
        break;
        case "deletar":
            delete($db_conn, $cod);
        break;
        case "atualizar":
            update($db_conn, $cod, $campo1, $campo2);
            break;
        default:
            select($db_conn);
    }
    
	mysqli_close($db_conn);	
	exit;
?>