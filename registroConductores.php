<?php
    $id = $_POST["idUsuario"];
    $nombre = $_POST["nombreUsuario"];
    $apellidos = $_POST["apellidosUsuario"];
    $clave = $_POST["claveUsuario"];
    $telefono = $_POST["telefonoUsuario"];
    $correo = $_POST["correoUsuario"];

    
$server = "localhost";
$user = "root";
$password = "";
$db = "estacionamientomejorado";
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){
    die("Falló la conexión: ".$conn->connect_error);
}else{
    $sql_sentence = "SELECT tipo FROM usuarios WHERE usuario = '".$id."'"; 
    $query = $conn->query($sql_sentence);
    if($query){
        if($query->num_rows > 0){
            echo "<script>
            location.href = 'conductores.php?errorcode=id';</script>";
        }else{
            $sql_sentence = "INSERT INTO usuarios (usuario, tipo, clavedeacceso, nombre, apellidos, telefono, correo) VALUES ('".$id."', 'Conductor', '".$clave."', '".$nombre."', '".$apellidos."', '".$telefono."', '".$correo."')";
            if($conn->query($sql_sentence) === TRUE){
                echo "<script>alert('Registro éxitoso');
                              location.href = 'conductores.php';</script>";
            }else{
                echo $conn->error;
            }
        }
    }else{
        echo $conn->error;
    }
}
                 
    
?>