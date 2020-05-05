<?php
    include_once('dbconnection.php');

    /*
     * Recebe a palavra all via get
     */

    $err = FALSE;
    (isset($_GET['cartas']) and !empty($_GET['cartas'])) ? $cartas = $_GET['cartas'] : $err = TRUE;

    if (($cartas != "all") || ($err)) {
        mysqli_close($db_conn);	
	    exit;
    }

    $query = 'SELECT  CC.id, CC.expressao, CR.resultado FROM MEMORY_MATH.CARTA_CALCULO CC 
                                                        INNER JOIN MEMORY_MATH.CARTA_RESPOSTA CR
                                                        WHERE CC.RESPOSTA = CR.ID
                                                        ORDER BY CC.ID';

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