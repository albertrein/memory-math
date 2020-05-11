<?php
    include_once('dbconnection.php');

    /*
     * Recebe o numero de par de cartas via get
     */

    $err = FALSE;
    (isset($_GET['cartas']) and !empty($_GET['cartas'])) ? $cartas = $_GET['cartas'] : $err = TRUE;

    if (($cartas < 1) || ($err)) {
        mysqli_close($db_conn);	
	    exit;
    }

    $query = 'SELECT CR.resultado FROM MEMORY_MATH.CARTA_RESPOSTA CR
                                  ORDER BY RAND()
                                  LIMIT '.$cartas;

    $result = mysqli_query($db_conn, $query);
    $qtd = mysqli_num_rows($result);

    if ($qtd >= $cartas) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        $cont=0;
        foreach ($rows as $r) {
            $query = 'SELECT CC.id, CC.expressao, CC.resposta FROM MEMORY_MATH.CARTA_CALCULO CC 
                                                              WHERE CC.RESPOSTA='.$r['resultado'].'
                                                              ORDER BY RAND()
                                                              LIMIT 1';
            $result = mysqli_query($db_conn, $query);
            $row = mysqli_fetch_assoc($result);
            $selecionadas[$cont] = $row;
            $cont++;
        }
    } else {
        echo 'ERRO: Nao existem cartas cadastradas suficientes!';
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