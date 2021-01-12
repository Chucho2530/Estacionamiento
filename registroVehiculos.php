<?php
    $matricula = $_POST["matriculaVehiculo"];
    $marca = $_POST["marcaVehiculo"];
    $modelo = $_POST["modeloVehiculo"];
    $color = $_POST["colorVehiculo"];
    $tamanio = $_POST["tamanioVehiculo"];
    $cliente = $_POST["idConductorVehiculo"];

    
$server = "localhost";
$user = "root";
$password = "";
$db = "estacionamientomejorado";
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){
    die("Falló la conexión: ".$conn->connect_error);
}else{
    $sql_sentence = "SELECT tamanio FROM vehiculos WHERE placas = '".$matricula."'"; 
    $query = $conn->query($sql_sentence);
    if($query){
        if($query->num_rows > 0){
            echo "<script>
            location.href = 'vehiculos.php?errorcode=matricula';</script>";
        }else{
            $sql_sentence = "SELECT tipo FROM usuarios WHERE usuario = '".$cliente."' AND tipo = 'Conductor'"; 
            $query = $conn->query($sql_sentence);
            if($query){
                if($query->num_rows > 0){
                    $sql_sentence = "INSERT INTO vehiculos (placas, marca, modelo, color, tamanio, cliente) VALUES ('".$matricula."', '".$marca."', '".$modelo."', '".$color."', '".$tamanio."', '".$cliente."')";
                    if($conn->query($sql_sentence) === TRUE){
                        echo "<script>alert('Registro éxitoso');
                                    location.href = 'vehiculos.php';</script>";
                    }else{
                        echo $conn->error;
                    }
                }else{
                    echo "<script> location.href = 'vehiculos.php?errorcode=idconductor'; </script>";
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