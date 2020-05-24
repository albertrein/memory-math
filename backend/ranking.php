<?php
    include_once('dbconnection.php');

    /*
     * Recebe o numero de jogadores via get
     */

    $query = 'SELECT nome, pontos FROM jogador ORDER BY pontos DESC LIMIT 10';

    $result = mysqli_query($db_conn, $query) or die("null");
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }else{
        echo "null";
        mysqli_close($db_conn);	
        exit;
    }
    echo json_encode($rows);

    mysqli_query($db_conn, $query) or die(mysqli_error());
    
	mysqli_close($db_conn);	
	exit;
?>