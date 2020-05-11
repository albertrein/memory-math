<?php
    include_once('dbconnection.php');

    /*
     * Recebe a palavra all via get
     */

    $err = FALSE;
    (isset($_GET['perguntas']) and !empty($_GET['perguntas'])) ? $perguntas = $_GET['perguntas'] : $err = TRUE;

    if (($perguntas != "all") || ($err)) {
        mysqli_close($db_conn);	
	    exit;
    }

    $query = 'SELECT  P.id, P.pergunta, P.resposta FROM MEMORY_MATH.PERGUNTA P
                                                   ORDER BY P.ID';

    $result = mysqli_query($db_conn, $query);
    $qtd = mysqli_num_rows($result);

    if ($qtd > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    } else {
        mysqli_close($db_conn);	
	    exit;
    }

    $json_str = json_encode($rows);
    echo "$json_str";

    mysqli_query($db_conn, $query) or die(mysqli_error());
    
	mysqli_close($db_conn);	
	exit;
?>