<?php
    include_once('dbconnection.php');

    /*
     * Recebe o numero de jogadores via get
     */

    $err = FALSE;
    (isset($_GET['jogadores']) and !empty($_GET['jogadores'])) ? $jogadores = $_GET['jogadores'] : $err = TRUE;

    if (($jogadores < 1) || ($err)) {
        mysqli_close($db_conn);	
	    exit;
    }

    $query = 'SELECT J.nome, J.pontos FROM MEMORY_MATH.JOGADOR J
                                                        ORDER BY J.PONTOS DESC
                                                        LIMIT '.$jogadores;

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

    foreach ($rows as $r) {
        $json[] = array(
            'nome' => $r['nome'],
            'pontos' => $r['pontos'].' pts'
        );
    }

    $json_str = json_encode($json);
    echo "$json_str";

    mysqli_query($db_conn, $query) or die(mysqli_error());
    
	mysqli_close($db_conn);	
	exit;
?>