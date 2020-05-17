<?php

    function calcular($expressao) {
        $array_expressao = explode(' ', $expressao);
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
                //não conseguiu calcular
                $resultado = null;
                break;
        }
        return $resultado;
    }

    function buscarIdCartaRespostaPorResultado($db_conn, $resultado) {
        $query = 'SELECT id FROM carta_resposta WHERE resultado = '.$resultado;
        $result = mysqli_query($db_conn, $query);
        
        if (($result != FALSE) && (mysqli_num_rows($result) > 0)) {
            $row = mysqli_fetch_assoc($result);
            return $row['id'];
        }else{
            return null;
        }
    }

    function removerCartaResposta($db_conn, $resultado) {
        $query = 'SELECT COUNT(*) AS total FROM carta_calculo WHERE resposta = '.$resultado;
        $result = mysqli_query($db_conn, $query);
        
        if ($result != FALSE) {
            $row = mysqli_fetch_assoc($result);
        }else{
            return FALSE;
        }
        
        if($row['total'] == 0) {
            $query = 'DELETE FROM carta_resposta WHERE id = '.$resultado;
            mysqli_query($db_conn, $query) or die(mysqli_error());
        }

        return TRUE;
    }

    function cadastrarCartaResposta($db_conn, $resultado) {
        if (($resultado == null) || ($resultado != floor($resultado))) {
            return FALSE;
        }
        $query = 'INSERT INTO carta_resposta(resultado) VALUES ('.$resultado.')';
        mysqli_query($db_conn, $query) or die(mysqli_error());

        return TRUE;
    }

    function cadastrarCartaCalculo($db_conn, $expressao) {
        $resultado = calcular($expressao);
        if ($resultado == null) {
            //não será cadastrado, pois não foi possível calcular a expressao
            return FALSE;
        }

        $resposta = buscarIdCartaRespostaPorResultado($db_conn, $resultado);
        if ($resposta == null) {
            cadastrarCartaResposta($db_conn, $resultado);
            $resposta = buscarIdCartaRespostaPorResultado($db_conn, $resultado);
            if ($resposta == null) {
                //não será cadastrado, pois não foi possível cadastrar a resposta
                return FALSE;
            }
        }

        $query = 'INSERT INTO carta_calculo(expressao,resposta) VALUES ("'.$expressao.'",'.$resposta.')';
        mysqli_query($db_conn, $query) or die(mysqli_error());

        return TRUE;
    }

    function editarCarta($db_conn, $id, $expressao) {
        $query = 'SELECT resposta FROM carta_calculo WHERE id = '.$id;
        $result = mysqli_query($db_conn, $query);

        if (($result != FALSE) && (mysqli_num_rows($result) > 0)) {
            $row = mysqli_fetch_assoc($result);
            $oldResposta = $row['resposta'];
        }else{
            return null;
        }

        $resultado = calcular($expressao);

        if ($resultado == null) {
            return FALSE; //não será atualizado, pois não foi possível calcular a expressao
        }

        $resposta = buscarIdCartaRespostaPorResultado($db_conn, $resultado);
        if ($resposta == null) {
            cadastrarCartaResposta($db_conn, $resultado);
            $resposta = buscarIdCartaRespostaPorResultado($db_conn, $resultado);
            if ($resposta == null) {
                //não será atualizado, pois não foi possível cadastrar a resposta
                return FALSE;
            }
        }

        $query = 'UPDATE carta_calculo SET expressao = "'.$expressao.'", resposta = '.$resposta.' WHERE id = '.$id;
        mysqli_query($db_conn, $query) or die(mysqli_error());

        removerCartaResposta($db_conn, $oldResposta);

        return TRUE;
    }

    function removerCarta($db_conn, $id) {
        $query = 'SELECT resposta FROM carta_calculo WHERE id = '.$id;
        $result = mysqli_query($db_conn, $query);

        if (($result != FALSE) && (mysqli_num_rows($result) > 0)) {
            $row = mysqli_fetch_assoc($result);
            $resposta = $row['resposta'];
        }else{
            return FALSE;
        }
    
        if (isset($row)) {
            $resposta = $row['resposta'];
        } else {
            mysqli_close($db_conn);
            exit;
        }
        $query = 'DELETE FROM carta_calculo WHERE id = '.$id;
        mysqli_query($db_conn, $query) or die(mysqli_error());

        removerCartaResposta($db_conn, $resposta);
        
        return TRUE;
    }

    function listarCartas($db_conn) {
        $query = 'SELECT  CC.id, CC.expressao, CR.resultado FROM carta_calculo CC INNER JOIN carta_resposta CR WHERE CC.resposta = CR.id ORDER BY CC.id';
        $result = mysqli_query($db_conn, $query);

        if($result && mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            echo json_encode($rows);
            return TRUE;
        }
        echo "null";
        return FALSE;
    }

?>