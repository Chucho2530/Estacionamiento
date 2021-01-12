<?php        
    session_start();  
    if($_SESSION["Usuario"] == "Administrador"){ 
        echo "<script>location.href='/EstacionamientoMejorado/administrador/usuarios.php';</script>";
    }else if($_SESSION["Usuario"] == "Valet"){ 
        echo "<script>location.href='/EstacionamientoMejorado/valet/ocupacion.php';</script>";
    }else if($_SESSION["Usuario"] == "Cajero"){ 
        echo "<script>location.href='/EstacionamientoMejorado/cajero/conductores.php';</script>";
    }else if($_SESSION["Usuario"] == "Conductor"){ 
        echo "<script>location.href='/EstacionamientoMejorado/conductor/misdatos.php';</script>";
    }else{
        $_SESSION["Usuario"] = "";
        $_SESSION["UsuarioID"] = ""; 
    }
?>
<!DOCTYPE html>
<html>
    <head>        
        <meta charset="utf-8">
        <title>Estacionamiento</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="estilos.css">
    </head>
    <body style="height: 100vh; width: 100vw">
        <div class="container h-100 w-100">
            <div class="row h-100 w-100">
                <div id="index__mainContainer" class="col-6 d-flex flex-column justify-content-center align-items-center m-auto p-4">
                    <h4 class="mb-3">INICIA SESIÓN</h4>
                    <?php if (isset($_GET['errorcode'])) : ?>
                        <span class="errorMsg p-2 m-auto bg-danger">El usuario o contraseña son incorrectos</span>
                    <?php endif; ?>
                    <form class="col-12" method="POST" action="validarInicioSesion.php">
                        <div class="mb-3">
                            <label for="index__usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="index__usuario" name="index__usuario">
                        </div>
                        <div class="mb-3">
                            <label for="index__contraseña" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="index__contraseña" name="index__contraseña">
                        </div>
                        <button type="submit" class="btn btn-danger">Entrar</button>
                    </form>
                </div>
            </div>
        
    </body>
</html>

<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>