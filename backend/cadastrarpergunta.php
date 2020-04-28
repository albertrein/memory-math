<?php
    include_once('dbconnection.php');

    /*
     * Formato de json esperado e.g.:
     * {"pergunta":"Pergunta?", "resposta":"0"}
     */

    $json = json_decode(file_get_contents('php://input'));
    $pergunta = $json->pergunta;
    $resposta = $json->resposta;
    
    echo 'pergunta '.$pergunta;
    echo 'resposta '.$resposta;
    
    $query = 'SELECT COUNT(*) AS total FROM MEMORY_MATH.PERGUNTA P WHERE P.PERGUNTA = "'.$pergunta.'"';
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);

    if($row['total'] == 0) {
        $query = 'INSERT INTO PERGUNTA(PERGUNTA,RESPOSTA) VALUES ("'.$pergunta.'",'.$resposta.')';
        mysqli_query($db_conn, $query) or die(mysqli_error());
    } else {
        echo 'pergunta ja existe';
    }
    
	mysqli_close($db_conn);	
	exit;
?>