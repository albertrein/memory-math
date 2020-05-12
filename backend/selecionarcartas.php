<?php
    include_once('dbconnection.php');
    
    $quantidadeCartasSolicitadas = $_POST['qtdCartas'];
    
    $query = 'SELECT CC.id, CC.expressao, CR.resultado FROM carta_calculo CC INNER JOIN carta_resposta CR WHERE CC.RESPOSTA = CR.ID ORDER BY RAND() LIMIT '.$quantidadeCartasSolicitadas;

    $result = mysqli_query($db_conn, $query);
    
    if(!$result || mysqli_num_rows($result) <= 0 || mysqli_num_rows($result) < $quantidadeCartasSolicitadas){
        echo "null";
        mysqli_close($db_conn);	
        exit;
    }
    
    while ($row = mysqli_fetch_assoc($result)) {
        $json[] = array(
            'key' => $row['id'],
            'value' => $row['expressao']
        );
        $json[] = array(
            'key' => $row['id'],
            'value' => $row['resultado']
        );
    }
    shuffle($json);

    $json_str = json_encode($json);
    echo $json_str;
?>