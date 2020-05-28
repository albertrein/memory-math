<?php
    define('DB_SERVIDOR', 'db');
    define('DB_USUARIO', 'root');
    define('DB_SENHA', 'phprs');
    define('DB_BANCO', 'memory_math');

    $db_conn = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_SENHA, DB_BANCO) or die('Não foi possivel conectar ao banco de dados.'); 
?>