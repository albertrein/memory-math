<?php
    include_once('dbconnection.php');

    /*
     * Formato de json esperado e.g.:
     * {"nome":"Jogador1", "pontos":30}
     */

    $json = json_decode(file_get_contents('php://input'));
    $nome = $json->nome;
    $pontos = $json->pontos;
    
    $query = 'SELECT J.pontos FROM MEMORY_MATH.JOGADOR J WHERE J.NOME="'.$nome.'"';
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row['pontos'] < $pontos) {
        $query = 'UPDATE MEMORY_MATH.JOGADOR SET PONTOS='.$pontos.' WHERE NOME="'.$nome.'"';
        mysqli_query($db_conn, $query) or die(mysqli_error());
    } else {
        mysqli_close($db_conn);	
        exit;
    }

	mysqli_close($db_conn);	
	exit;
?>