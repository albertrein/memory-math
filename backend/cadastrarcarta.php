<?php
    include_once('dbconnection.php');
    include_once('cadastrarcartafunctions.php');
    
    /*
     * Formato de json esperado e.g.:
     * {"expressao":"5 * 5"}
     */

    $carta = json_decode(file_get_contents('php://input'));
    $expressao = $carta->expressao;
    
    $array_expressao = explode(' ', $carta->expressao);

    $resultado = null;
    switch ($array_expressao[1]) {
        case '+':
            $resultado = $array_expressao[0] + $array_expressao[2];
            break;
        
        case '-':
            $resultado = $array_expressao[0] - $array_expressao[2];
            break;
        
        case '*':
            $resultado = $array_expressao[0] * $array_expressao[2];
            break;
        
        case '/':
            $resultado = $array_expressao[0] / $array_expressao[2];
            break;
        
        default:
            echo 'ERRO: Operação não reconhecida<br>';
            break;
    }
    
    $query = 'SELECT COUNT(*) AS total FROM MEMORY_MATH.CARTA_CALCULO CC WHERE CC.EXPRESSAO = "'.$expressao.'"';
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);

    if($row['total'] == 0) {
        cadastrarCartaCalculo($db_conn, $expressao, $resultado);
    } else {
        echo 'carta ja existe';
    }
    
	mysqli_close($db_conn);	
	exit;
?>