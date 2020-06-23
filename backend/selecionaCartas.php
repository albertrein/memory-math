<?php
    include_once('dbconnection.php');

    function getCarta($db){
        $query = "SELECT * FROM cartas_new ORDER BY RAND() LIMIT 1";
        $result = mysqli_query($db, $query) or die("null");
        return mysqli_fetch_assoc($result);
    }

    $quantidadeDeCartas = $_POST['qtdCartas'];

    $query = "SELECT DISTINCT resposta FROM cartas_new";
    $result = mysqli_query($db_conn, $query) or die("null");
    $quantidadeCartasValidas = mysqli_num_rows($result);
    if($quantidadeCartasValidas < $quantidadeDeCartas){
        mysqli_close($db_conn);
        $erro = array("qtdCartasRestantes" => $quantidadeDeCartas-$quantidadeCartasValidas);
        die(json_encode($erro));
    }

    $counter = 1;
    $arrayCartas[] = getCarta($db_conn);
    while($counter < $quantidadeDeCartas){
        $carta = getCarta($db_conn);
        $buscarOutraCarta = false;
        for($i = 0; $i < count($arrayCartas); $i++){
            if($carta['id'] == $arrayCartas[$i]['id'] || $carta['resposta'] == $arrayCartas[$i]['resposta']){
                $buscarOutraCarta = true;
            }
        }
        if(!$buscarOutraCarta){
            $arrayCartas[] = $carta;
            $counter++;
        }
    }
    foreach ($arrayCartas as $carta) {
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