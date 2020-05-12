<?php
    include_once('dbconnection.php');

    /*
     * Recebe o numero de jogadores via get
     */

    $query = 'SELECT nome, pontos FROM jogador ORDER BY pontos DESC LIMIT 10';

    $result = mysqli_query($db_conn, $query);
    $qtd = mysqli_num_rows($result);

    if ($qtd > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    } else {
        echo "null";
        mysqli_close($db_conn);	
	    exit;
    }

    foreach ($rows as $r) {
        $json[] = array(
            'nome' => $r['nome'],
            'pontos' => $r['pontos'].' pts'
        );
    }

    echo json_encode($json);

    mysqli_query($db_conn, $query) or die(mysqli_error());
    
	mysqli_close($db_conn);	
	exit;
?>