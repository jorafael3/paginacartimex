<?php

if (isset($_POST['series'])) {
    require('conexionseries.php');
    try {
        $tipo = $_POST['numero'];
        $pdo = new PDO("sqlsrv:server=$sql_serverName ; Database = $sql_database", $sql_user, $sql_pwd);
        $query = $pdo->prepare('{CALL Inv_buscar_series_productos_xtratech2 (?)}');
        $query->bindParam(1, $tipo, PDO::PARAM_STR);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
            exit();
        } else {
            $err = $query->errorInfo();
            echo json_encode($err);
            exit();
        }
    } catch (PDOException $e) {

        $e = $e->getMessage();
        echo json_encode($e);
        exit();
    }
}
