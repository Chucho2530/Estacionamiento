<?php
    $userSystem = $_POST["index__usuario"];
    $pass = $_POST["index__contraseña"];

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "estacionamientomejorado";
    $conn = new mysqli($server, $user, $password, $db);
    if($conn->connect_error){
        die("Falló la conexión: ".$conn->connect_error);
    }else{
        $sql_sentence = "SELECT tipo FROM usuarios WHERE usuario = '".$userSystem."' AND clavedeacceso = '".$pass."'";
        $query = $conn->query($sql_sentence);
        if($query){
            if($query->num_rows == 1){
                
                while($row = $query->fetch_assoc()){
                    session_start(); 
                    $_SESSION["Usuario"] = $row["tipo"]; 
                    $_SESSION["UsuarioID"] = $userSystem; 
                    session_regenerate_id();
                    if($row["tipo"] == "Administrador"){
                        echo "<script>
                        location.href = 'administrador/usuarios.php';</script>";
                    }else if($row["tipo"] == "Cajero"){
                        echo "<script>
                        location.href = 'cajero/conductores.php';</script>";
                    }else if($row["tipo"] == "Valet"){
                        echo "<script>
                        location.href = 'valet/ocupacion.php';</script>";
                    }else if($row["tipo"] == "Conductor"){
                        echo "<script>
                        location.href = 'conductor/misdatos.php';</script>";
                    }
                }

            }else{
                echo "<script>
                location.href = 'index.php?errorcode=loginFailed';</script>";
            }
        }else{
            echo $conn->error;
        }
        
    }
?>