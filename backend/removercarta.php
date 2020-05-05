<?php
    include_once('dbconnection.php');

    /*
     * Recebe id via get
     */

    $err = FALSE;
    (isset($_GET['id']) and !empty($_GET['id'])) ? $id = $_GET['id'] : $err = TRUE;

    if ($err) {
        mysqli_close($db_conn);	
        exit;
    }

    $query = 'SELECT CC.RESPOSTA FROM MEMORY_MATH.CARTA_CALCULO CC WHERE CC.ID = '.$id;
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (isset($row)) {
        $resposta = $row['RESPOSTA'];
    } else {
        mysqli_close($db_conn);
        exit;
    }

    $query = 'SELECT COUNT(*) AS total FROM MEMORY_MATH.CARTA_CALCULO CC WHERE CC.RESPOSTA = '.$resposta;
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);

    if($row['total'] == 1) {
        $query = 'DELETE FROM MEMORY_MATH.CARTA_CALCULO WHERE ID = '.$id;
        mysqli_query($db_conn, $query) or die(mysqli_error());

        $query = 'DELETE FROM MEMORY_MATH.CARTA_RESPOSTA WHERE ID = '.$resposta;
        mysqli_query($db_conn, $query) or die(mysqli_error());
    } else {
        $query = 'DELETE FROM MEMORY_MATH.CARTA_CALCULO WHERE ID = '.$id;
        mysqli_query($db_conn, $query) or die(mysqli_error());
    }
   
	mysqli_close($db_conn);	
	exit;
?>