<?php
    $matricula = $_POST["matriculaVehiculo"];
    $marca = $_POST["marcaVehiculo"];
    $modelo = $_POST["modeloVehiculo"];
    $color = $_POST["colorVehiculo"];
    $tamanio = $_POST["tamanioVehiculo"];
    $cliente = $_POST["clienteVehiculo"];
    $oldid = $_POST["viejaMatricula"];

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "estacionamientomejorado";
    $conn = new mysqli($server, $user, $password, $db);
    if($conn->connect_error){
        die("Falló la conexión: ".$conn->connect_error);
    }else{
        $sql_sentence = "UPDATE vehiculos SET placas = '".$matricula."', marca = '".$marca."', modelo = '".$modelo."', color = '".$color."', tamanio = '".$tamanio."', cliente = '".$cliente."' WHERE placas = '".$oldid."'";
        $query = $conn->query($sql_sentence);
        if($query){
            echo "éxito";
        }else{
            echo $conn->error;
        }
        
    }
           
?>