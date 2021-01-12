<?php
    $id = $_POST["idModificar"];
    $tipo = $_POST["tipoModificar"];
    $clavedeacceso = $_POST["claveModificar"];
    $nombre = $_POST["nombreModificar"];
    $apellidos = $_POST["apellidosModificar"];
    $telefono = $_POST["telefonoModificar"];
    $correo = $_POST["correoModificar"];
    $oldid = $_POST["viejoIDModificar"];

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "estacionamientomejorado";
    $conn = new mysqli($server, $user, $password, $db);
    if($conn->connect_error){
        die("Falló la conexión: ".$conn->connect_error);
    }else{
        $sql_sentence = "UPDATE usuarios SET usuario = '".$id."', tipo = '".$tipo."', clavedeacceso = '".$clavedeacceso."', nombre = '".$nombre."', apellidos = '".$apellidos."', telefono = '".$telefono."', correo = '".$correo."' WHERE usuario = '".$oldid."'";
        $query = $conn->query($sql_sentence);
        if($query){
            $sql_sentence = "UPDATE vehiculos SET cliente = '".$id."' WHERE cliente = '".$oldid."'";
            $query = $conn->query($sql_sentence);
            if($query){
                session_start(); 
                $_SESSION["UsuarioID"] = $id;
                echo "éxito";
            }else{
                echo $conn->error;
            }
        }else{
            echo $conn->error;
        }
        
    }
           
?>