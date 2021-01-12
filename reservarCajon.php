<?php
    $id = $_POST["clienteID"];
    $auto = $_POST["autoID"];
    $cajon = $_POST["cajonID"];

    
$server = "localhost";
$user = "root";
$password = "";
$db = "estacionamientomejorado";
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){
    die("Falló la conexión: ".$conn->connect_error);
}else{
    $sql_sentence = "SELECT * FROM reservaciones WHERE placas = '".$auto."'"; 
    $query = $conn->query($sql_sentence);
    if($query){
        if($query->num_rows > 0){
            echo "<script>
            location.href = 'reservaciones.php?errorcode=autoConReserva';</script>";
        }else{
            $sql_sentence = "INSERT INTO reservaciones (id_cajon, placas, cliente) VALUES ('".$cajon."', '".$auto."', '".$id."')";
            if($conn->query($sql_sentence) === TRUE){
                $sql_sentence = "UPDATE cajones SET situacion = 'Reservado' WHERE id = '".$cajon."'";
                if($conn->query($sql_sentence) === TRUE){
                    echo "<script>alert('Reservación creada correctamente');
                                location.href = 'reservaciones.php';</script>";
                }else{
                    echo $conn->error;
                }
            }else{
                echo $conn->error;
            }
        }
    }else{
        echo $conn->error;
    }
}
                 
    
?>