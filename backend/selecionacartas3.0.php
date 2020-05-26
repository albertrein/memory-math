<?php
    include_once('dbconnection.php');
    /*
    * Recebe o numero de par de cartas via get
    */
    
    $cartas = $_POST['qtdCartas'];
    $query = 'SELECT * FROM cartas_new ORDER BY RAND() LIMIT '.$cartas;

    $result = mysqli_query($db_conn, $query) or die("null");
	
    $qtd = mysqli_num_rows($result);

    if ($qtd >= $cartas) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    } else {
        echo 'null';
        mysqli_close($db_conn);	
	    exit;
    }

    foreach ($rows as $carta) {
        $json[] = array(
            'key' => $carta['id'],
            'value' => $carta['expressao']
        );
        $json[] = array(
            'key' => $carta['id'],
            'value' => $carta['resposta']
        );
    }

    shuffle($json);

    echo json_encode($json);

	mysqli_close($db_conn);	
	exit;

?>