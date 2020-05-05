<?php
    include_once('dbconnection.php');

    /*
     * Formato de json esperado e.g.:
     * {"nome":"Jogador1", "senha":"abc12345"}
     */

    $json = json_decode(file_get_contents('php://input'));
    $nome = $json->nome;
    $senha = $json->senha;
    
    $query = 'SELECT COUNT(*) AS total FROM MEMORY_MATH.JOGADOR J WHERE J.NOME = "'.$nome.'"';
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);

    if($row['total'] == 0) {
        $query = 'INSERT INTO JOGADOR(NOME,SENHA,PONTOS) VALUES ("'.$nome.'","'.$senha.'", 0)';
        mysqli_query($db_conn, $query) or die(mysqli_error());
    } else {
        echo 'Nome não disponível';
    }
    
	mysqli_close($db_conn);	
	exit;
?>