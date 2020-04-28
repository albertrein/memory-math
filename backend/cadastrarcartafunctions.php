<?php

    function cadastrarCartaResposta($db_conn, $resultado) {
        
        $query = 'INSERT INTO CARTA_RESPOSTA(RESULTADO) VALUES ('.$resultado.')';
        mysqli_query($db_conn, $query) or die(mysqli_error());

        return true;
    }

    function cadastrarCartaCalculo($db_conn, $expressao, $resultado) {
        
        $query = 'SELECT CR.ID FROM MEMORY_MATH.CARTA_RESPOSTA CR WHERE CR.RESULTADO = '.$resultado.'';
        $result = mysqli_query($db_conn, $query);
        $qtd = mysqli_num_rows($result);

        if ($qtd > 0) {
            $row = mysqli_fetch_assoc($result);
            $query = 'INSERT INTO CARTA_CALCULO(EXPRESSAO,RESPOSTA) VALUES ("'.$expressao.'",'.$row['ID'].')';
            mysqli_query($db_conn, $query) or die(mysqli_error());
        } else {
            cadastrarCartaResposta($db_conn, $resultado);

            $query = 'SELECT CR.ID FROM MEMORY_MATH.CARTA_RESPOSTA CR WHERE CR.RESULTADO = '.$resultado.'';
            $result = mysqli_query($db_conn, $query);
            $row = mysqli_fetch_assoc($result);
            
            $query = 'INSERT INTO CARTA_CALCULO(EXPRESSAO,RESPOSTA) VALUES ("'.$expressao.'",'.$row['ID'].')';
            mysqli_query($db_conn, $query) or die(mysqli_error());
        }

        return true;
    }

?>