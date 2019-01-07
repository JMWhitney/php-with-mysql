<?php

    require_once('db_credentials.php');

    function db_connect() {
        $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        return $connection;
    }

    function db_disconnect() {
        if(isset($connection)) {
            mysqli_close($connection);
        }
    }

?>
