<?php
    include_once('dbconnection.php');

    /*
     * Recebe o numero de par de cartas via get
     */

    $cartas = $_POST['qtdCartas'];

    $query = 'SELECT DISTINCT resposta FROM cartas_new ORDER BY RAND() LIMIT '.$cartas;

    $result = mysqli_query($db_conn, $query);
	if($result == FALSE) {
		echo 'null';
        mysqli_close($db_conn);	
	    exit;
	}
    $qtd = mysqli_num_rows($result);

    if ($qtd >= $cartas) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        foreach ($rows as $r) {
            $query = 'SELECT id, expressao, resposta FROM cartas_new
                                                     WHERE resposta='.$r['resposta'].'
                                                     ORDER BY RAND()
                                                     LIMIT 1';
            $result = mysqli_query($db_conn, $query);
            if($result == FALSE) {
                echo 'null';
                mysqli_close($db_conn);	
                exit;
            }
            $row = mysqli_fetch_assoc($result);
            $selecionadas[] = $row;
        }
    } else {
        echo 'null';
        mysqli_close($db_conn);	
	    exit;
    }

    foreach ($selecionadas as $s) {
        $json[] = array(
            'key' => $s['id'],
            'value' => $s['expressao']
        );
        $json[] = array(
            'key' => $s['id'],
            'value' => $s['resposta']
        );
    }

    shuffle($json);

    $json_str = json_encode($json);
    echo "$json_str";

    mysqli_query($db_conn, $query) or die(mysqli_error());

	mysqli_close($db_conn);	
	exit;
?> 
