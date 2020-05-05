<?php
    include_once('dbconnection.php');

    /*
     * Recebe id via get
     */

    (isset($_GET['id']) and !empty($_GET['id'])) ? $id = $_GET['id'] : exit;

    $query = 'DELETE FROM MEMORY_MATH.PERGUNTA WHERE ID = '.$id;
    mysqli_query($db_conn, $query) or die(mysqli_error());
    
	mysqli_close($db_conn);	
	exit;
?>