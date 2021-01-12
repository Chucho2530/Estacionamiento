<?php
    $id = $_POST["id"];

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "estacionamientomejorado";
    $conn = new mysqli($server, $user, $password, $db);
    if($conn->connect_error){
        die("Falló la conexión: ".$conn->connect_error);
    }else{
        $sql_sentence = "DELETE FROM vehiculos WHERE placas = '".$id."'";
        $query = $conn->query($sql_sentence);
        if($query){
            echo "éxito";
        }else{
            echo $conn->error;
        }
                   
    }    
?>