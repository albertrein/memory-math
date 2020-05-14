<?php

    function cadastrarCartaResposta($db_conn, $resultado) {
        
        $query = 'INSERT INTO carta_resposta(RESULTADO) VALUES ('.$resultado.')';
        mysqli_query($db_conn, $query) or die(mysqli_error());

        return true;
    }

    function cadastrarCartaCalculo($db_conn, $expressao, $resultado) {
        
        $query = 'SELECT CR.ID FROM carta_resposta CR WHERE CR.RESULTADO = '.$resultado.'';
        $result = mysqli_query($db_conn, $query);
        $qtd = mysqli_num_rows($result);

        if ($qtd > 0) {
            $row = mysqli_fetch_assoc($result);
            $query = 'INSERT INTO carta_calculo(EXPRESSAO,RESPOSTA) VALUES ("'.$expressao.'",'.$row['ID'].')';
            mysqli_query($db_conn, $query) or die(mysqli_error());
        } else {
            cadastrarCartaResposta($db_conn, $resultado);

            $query = 'SELECT CR.ID FROM carta_resposta CR WHERE CR.RESULTADO = '.$resultado.'';
            $result = mysqli_query($db_conn, $query);
            $row = mysqli_fetch_assoc($result);
            
            $query = 'INSERT INTO carta_calculo(EXPRESSAO,RESPOSTA) VALUES ("'.$expressao.'",'.$row['ID'].')';
            mysqli_query($db_conn, $query) or die(mysqli_error());
        }

        return true;
    }

?>