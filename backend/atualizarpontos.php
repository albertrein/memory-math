<?php
    include_once('dbconnection.php');

    /*
     * Formato de json esperado e.g.:
     * {"nome":"Jogador1", "pontos":30}
     */

    $json = json_decode(file_get_contents('php://input'));
    $nome = $json->nome;
    $pontos = $json->pontos;
    
    $query = 'SELECT pontos FROM jogador WHERE NOME="'.$nome.'"';
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row['pontos'] < $pontos) {
        $query = 'UPDATE jogador SET PONTOS='.$pontos.' WHERE NOME="'.$nome.'"';
        mysqli_query($db_conn, $query) or die(mysqli_error());
    }
    
	mysqli_close($db_conn);	
	exit;
?>