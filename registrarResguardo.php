<?php
    $cliente = $_POST["clienteID"];
    $auto = $_POST["autoID"];
    $fecha = $_POST["fecha"];
    $hraEntrada = $_POST["horaEntrada"];
    
    $matricula = $_POST["matricula"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $color = $_POST["color"];
    $tamanio = $_POST["tamanio"];
    
    $lavado = "false";
    if(isset($_POST["lavado"])){
        $lavado = "true";      
    }

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "estacionamientomejorado";
    $conn = new mysqli($server, $user, $password, $db);

    if($auto == ""){
        if(($matricula == "") || ($marca == "") || ($modelo == "") || ($color == "")){
            echo "<script>alert('Error, uno o mas campos estan vacios');
            location.href = 'resguardos.php';</script>";
        }else{
            if($conn->connect_error){
                die("Falló la conexión: ".$conn->connect_error);
            }else{
                $sql_sentence = "INSERT INTO vehiculos (placas, marca, modelo, color, tamanio, cliente) VALUES ('".$matricula."', '".$marca."', '".$modelo."', '".$color."', '".$tamanio."', '".$cliente."')";
                if($conn->query($sql_sentence) === TRUE){
                    $sql_sentence_aux = "SELECT id FROM cajones WHERE situacion = 'Disponible'";
                    $query = $conn->query($sql_sentence_aux);
                    if($query->num_rows > 0){
                        $row = $query->fetch_assoc();
                        $cajon = $row["id"];
                        $sql_sentence = "INSERT INTO resguardos (id_cajon, placas, hora_llegada, hora_salida, lavado, pago, fecha, estatus) VALUES ('".$cajon."', '".$matricula."', '".$hraEntrada."', '', '".$lavado."', '', '".$fecha."', 'Activo')";
                        if($conn->query($sql_sentence) === TRUE){
                            $sql_sentence = "UPDATE cajones SET situacion = 'Ocupado' WHERE id = '".$cajon."'";
                            if($conn->query($sql_sentence) === TRUE){
                                echo "<script>alert('Registro éxitoso');
                                                location.href = 'resguardos.php';</script>";
                            }else{
                                echo $conn->error;
                            }
                        }else{
                            echo $conn->error;
                        }
                        
                    }else{
                        echo "<script>alert('Lo sentimos, no hay espacios disponibles');
                                            location.href = 'resguardos.php';</script>";
                    }
                }else{
                    echo $conn->error;
                }
            }            
        }
    }else{
        if($cliente == ""){
            echo "<script>alert('Error, uno o mas campos estan vacios');
            location.href = 'resguardos.php';</script>";
        }else{
            if($conn->connect_error){
                die("Falló la conexión: ".$conn->connect_error);
            }else{
                $sql_sentence_aux = "SELECT placas FROM resguardos WHERE placas = '".$auto."' AND estatus = 'Activo'";
                $query = $conn->query($sql_sentence_aux);
                if($query->num_rows > 0){
                    echo "<script>alert('El auto ya se encuentra en resguardo');
                    location.href = 'resguardos.php';</script>";
                }else{                    
                    
                    $sql_sentence_aux = "SELECT id FROM cajones WHERE situacion = 'Disponible'";
                    $query = $conn->query($sql_sentence_aux);
                    if($query->num_rows > 0){
                        $row = $query->fetch_assoc();
                        $cajon = $row["id"];
                        $sql_sentence_aux = "SELECT id_cajon FROM reservaciones WHERE placas = '".$auto."'";
                        $query = $conn->query($sql_sentence_aux);
                        if($query->num_rows > 0){
                            $row = $query->fetch_assoc();
                            $cajon = $row["id_cajon"];
                        }
                        $sql_sentence_aux = "DELETE FROM reservaciones WHERE placas = '".$auto."'";
                        $query = $conn->query($sql_sentence_aux);
                        $sql_sentence = "INSERT INTO resguardos (id_cajon, placas, hora_llegada, hora_salida, lavado, pago, fecha, estatus) VALUES ('".$cajon."', '".$auto."', '".$hraEntrada."', '', '".$lavado."', '', '".$fecha."', 'Activo')";
                        if($conn->query($sql_sentence) === TRUE){
                            $sql_sentence = "UPDATE cajones SET situacion = 'Ocupado' WHERE id = '".$cajon."'";
                                if($conn->query($sql_sentence) === TRUE){
                                    echo "<script>alert('Registro éxitoso');
                                                    location.href = 'resguardos.php';</script>";
                                }else{
                                    echo $conn->error;
                                }
                        }else{
                            echo $conn->error;
                        }
                    }else{
                        echo "<script>alert('Lo sentimos, no hay espacios disponibles');
                                            location.href = 'resguardos.php';</script>";
                    }
                }
            }
        }
    }
?>