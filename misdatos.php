<?php        
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/EstacionamientoMejorado/conductor/barranav.php");    
    if($_SESSION["Usuario"] != "Conductor"){ 
        echo "<script>location.href='../index.php';</script>";
    }
?>
<!DOCTYPE html>
<html>
    <head>        
        <meta charset="utf-8">
        <title>Estacionamiento - Mis datos</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../estilos.css">
    </head>
    <body>    
        <div class="container h-90">
            <h3 class="mt-4 text-center">Información de tu cuenta</h3>

            <div class="row col-12 d-flex flex-row justify-content-between mt-4">
                <form class="col-12" method="post" action="registroConductores.php">
                    <h4>Datos del conductor</h4>
                    <?php if (isset($_GET['errorcode'])) : ?>
                        <p class="p-2 bg-danger text-white mt-3 mb-3"><?php 
                        if($_GET['errorcode'] == 'id'): 
                            echo "ID de usuario ya registrado"; 
                        endif ?></p>
                    <?php endif; ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">ID de conductor</span>
                        </div>
                        <input id="input__idconductor" name="idUsuario" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nombre</span>
                        </div>
                        <input id="input__nombre" type="text" name="nombreUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Apellidos</span>
                        </div>
                        <input id="input__apellidos" type="text" name="apellidosUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Clave de acceso</span>
                        </div>
                        <input id="input__clave" type="text" name="claveUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Telefono</span>
                        </div>
                        <input id="input__telefono" type="text" name="telefonoUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Correo</span>
                        </div>
                        <input id="input__correo" type="text" name="correoUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group mb-5">
                        <button id="conductores__btnModificar" type="button" class="btn btn-primary mr-4" onclick="validarModificar()">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>

    </body>
</html>

<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "estacionamientomejorado";
$conn = new mysqli($server, $user, $password, $db);
if($conn->connect_error){
    die("Falló la conexión: ".$conn->connect_error);
}else{
    $users = array();
    $sql_sentence = "SELECT * FROM usuarios where tipo = 'Conductor'";
    $query = $conn->query($sql_sentence);
    if($query){
        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                array_push($users, "'".$row["usuario"]."'");
                array_push($users, "'".$row["tipo"]."'");
                array_push($users, "'".$row["clavedeacceso"]."'");
                array_push($users, "'".$row["nombre"]."'");
                array_push($users, "'".$row["apellidos"]."'");
                array_push($users, "'".$row["telefono"]."'");
                array_push($users, "'".$row["correo"]."'");
            }
            $currentUser = "'".$_SESSION["UsuarioID"]."'";
        }
    }else{
        echo $conn->error;
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>
<script> 
        var arregloUsuariosPHP = [<?php echo implode(",",$users);?>];
        var usuarioID = [<?php echo $currentUser; ?>];
        for(i=0; i<arregloUsuariosPHP.length; i+=7){
            if(arregloUsuariosPHP[i] == usuarioID){
                document.getElementById("input__idconductor").value = arregloUsuariosPHP[i];
                document.getElementById("input__nombre").value = arregloUsuariosPHP[i+3];
                document.getElementById("input__apellidos").value = arregloUsuariosPHP[i+4];
                document.getElementById("input__clave").value = arregloUsuariosPHP[i+2];
                document.getElementById("input__telefono").value = arregloUsuariosPHP[i+5];
                document.getElementById("input__correo").value = arregloUsuariosPHP[i+6];
            }
        }

        function validarModificar(){
        var decision = confirm("Seguro que desea guardar cambios?");
        if(decision){
            //Validando el id
            idusuario = document.getElementById("input__idconductor").value;
            nombre = document.getElementById("input__nombre").value;
            apellidos = document.getElementById("input__apellidos").value;
            clave = document.getElementById("input__clave").value;
            telefono = document.getElementById("input__telefono").value;
            correo = document.getElementById("input__correo").value;
            idValido = true;
            for(i=0; i<arregloUsuariosPHP.length; i+=7){
                if(idusuario == arregloUsuariosPHP[i] && (usuarioID != idusuario)){
                    idValido = false;
                    break;
                }
            }
            if(idValido){
                $.ajax({
                    data: {idModificar: idusuario, nombreModificar: nombre, apellidosModificar: apellidos,
                        tipoModificar: "Conductor", claveModificar: clave, telefonoModificar: telefono, correoModificar: correo, viejoIDModificar: usuarioID.toString()},
                    url: "modificarUsuario.php",
                    type: "POST",            
                    success: function(response){                        
                        if(response.toString() == "éxito"){
                            alert("Cambios guardados correctamente");
                            location.reload();
                        }
                        else {                
                            alert(response.toString());
                        }
                    }
                }).fail(function(e, test, error){
                    alert(error.toString());
                });
            }else{
                alert("El id '"+idusuario+"' ya está en uso");
            }
        }
    }
    
</script>