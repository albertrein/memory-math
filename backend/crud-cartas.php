<?php
    include_once('dbconnection.php');
    include_once('cadastrarcartafunctions.php');

    /*
     * {cod: '', acao: '', campo1: '', campo2: ''}
     */

     function select($db){
        $query = 'SELECT  CC.id, CC.expressao, CR.resultado FROM carta_calculo CC INNER JOIN carta_resposta CR WHERE CC.resposta = CR.id ORDER BY CC.id';
        $result = mysqli_query($db, $query);

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

        $query = 'DELETE CC, CR FROM carta_calculo CC JOIN carta_resposta CR WHERE CC.resposta = CR.id AND CC.id='.$cod;
        $result = mysqli_query($db, $query);

        if($result && mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            echo json_encode("Ok!");
            return true;
        }
        echo "null";
    }

    function insert($db,$campo1, $campo2){
        $query = 'SELECT COUNT(*) AS total FROM carta_calculo CC WHERE CC.expressao = "'.$campo1.'"';
        $result = mysqli_query($db, $query)or die(mysqli_error($db));
        $row = mysqli_fetch_assoc($result);

        if($row['total'] == 0) {
            cadastrarCartaCalculo($db, $campo1, $campo2);
            echo json_encode("Ok");
        } else {
            echo "null";
        }
    }

    $json = json_decode(file_get_contents('php://input'));
    
    insert($db_conn,"9 * 10","90");
    
	mysqli_close($db_conn);	
	exit;
?>