<?php
    include_once('dbconnection.php');
    $query = "SELECT PERGUNTA, RESPOSTA FROM pergunta ORDER BY RAND() LIMIT 1";

    $result = mysqli_query($db_conn, $query);
    
    if (!$result || mysqli_num_rows($result) <= 0) {
        mysqli_close($db_conn);
        echo json_encode([]);
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
	mysqli_close($db_conn);	
	exit;
?>