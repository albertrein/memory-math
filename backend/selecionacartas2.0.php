<?php
    include_once('dbconnection.php');

    /*
     * Recebe o numero de par de cartas via get
     */

    $cartas = $_POST['qtdCartas'];

    $query = 'SELECT id, resultado FROM carta_resposta ORDER BY RAND() LIMIT '.$cartas;

    $result = mysqli_query($db_conn, $query);
	if($result == FALSE) {
		echo '1null';
        mysqli_close($db_conn);	
	    exit;
	}
    $qtd = mysqli_num_rows($result);

    if ($qtd >= $cartas) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        foreach ($rows as $r) {
            $query = 'SELECT CC.id, CC.expressao, '.$r['resultado'].' as resposta FROM carta_calculo CC 
                                                                                  WHERE CC.resposta='.$r['id'].'
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
