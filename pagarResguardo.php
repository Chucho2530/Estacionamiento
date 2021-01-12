<?php
    $vehiculo = $_POST["vehiculo"];
    $cajon = $_POST["cajon"];
    $hora_llegada = $_POST["hora_entrada"];
    $pago = $_POST["total_cobrar"];

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "estacionamientomejorado";
    $conn = new mysqli($server, $user, $password, $db);
    if($conn->connect_error){
        die("Falló la conexión: ".$conn->connect_error);
    }else{
        if(isset($_POST["vehiculo"]) && $pago != ""){
            $sql_sentence = "UPDATE resguardos SET pago = '".$pago."', estatus = 'Pagado' WHERE id_cajon = '".$cajon."' AND placas = '".$vehiculo."' AND hora_llegada = '".$hora_llegada."'";
            $query = $conn->query($sql_sentence);
            if($query){
                $sql_sentence = "UPDATE cajones SET situacion = 'Disponible' WHERE id = '".$cajon."'";
                $query = $conn->query($sql_sentence);
                if($query){
                    echo "éxito";
                }else{
                    echo $conn->error;
                }
            }else{
                echo $conn->error;
            }
        }else{
            echo "<script>location.href='resguardos-salida.php?errorcode=emptyField';</script>";
        }
    }
           
?>