<?php
    include_once('dbconnection.php');
    include_once('cadastrarcartafunctions.php');

    /*
     * {cod: '', acao: '', campo1: '', campo2: ''}
     */

     function select($db){
        $query = 'SELECT  id, nome, senha FROM jogador ORDER BY id ASC';
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
        $query = 'DELETE FROM jogador WHERE jogador.id='.$cod;
        $result = mysqli_query($db, $query) or die("null");
        if($result){
            echo json_encode("Ok!");
            return true;
        }
        echo "null";
    }

    function insert($db,$campo1, $campo2){
        $query = 'SELECT COUNT(*) AS total FROM jogador WHERE jogador.nome="'.$campo1.'"';
        $result = mysqli_query($db, $query)or die("null1");
        $row = mysqli_fetch_assoc($result);

        if($row['total'] == 0) {
            $query = 'INSERT INTO jogador(NOME, SENHA, PONTOS) VALUES ("'.$campo1.'", "'.$campo2.'", 0)';
            $result = mysqli_query($db, $query)or die('null');
            echo json_encode("Ok");
        } else {
            echo "null";
        }
    }

    function update($db, $cod, $campo1, $campo2){
        $query = "UPDATE jogador J SET J.nome='".$campo1."', J.senha='".$campo2."' WHERE J.id=".$cod;
        $result = mysqli_query($db, $query)or die("null");
    
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