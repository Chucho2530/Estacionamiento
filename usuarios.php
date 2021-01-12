<?php        
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/EstacionamientoMejorado/administrador/barranav.php");    
    if($_SESSION["Usuario"] != "Administrador"){ 
        echo "<script>location.href='../index.php';</script>";
    }
?>
<!DOCTYPE html>
<html>
    <head>        
        <meta charset="utf-8">
        <title>Estacionamiento</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../estilos.css">
    </head>
    <body>    
        <div class="container h-90">
            <h3 class="mt-4 text-center">Registros de usuarios</h3>
            <div class="row col-4 d-flex flex-row mt-4">
                <button id="btnNuevo" type="button" class="btn btn-primary mr-4" onclick="habilitarRegistro()">Registrar nuevo</button>
                <button id="btnBuscar" type="button" class="btn btn-primary" onclick="habilitarBusqueda()" hidden>Buscar usuario</button>
            </div>
            
            <div class="row col-12 d-flex flex-row justify-content-between mt-5">
                <span class="text-secondary">Escribe el usuario a buscar...</span>
                <div class="input-group">
                    <input id="input__idBuscar" type="text" class="form-control" placeholder="Usuario" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>

            <div class="row col-12 d-flex flex-row justify-content-between mt-4">
                <form class="col-12" method="post" action="registroUsuarios.php">
                    <h4>Datos del usuario</h4>
                    <?php if (isset($_GET['errorcode'])) : ?>
                        <p class="p-2 bg-danger text-white mt-3 mb-3"><?php 
                        if($_GET['errorcode'] == 'id'): 
                            echo "ID de usuario ya registrado"; 
                        endif ?></p>
                    <?php endif; ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">ID de usuario</span>
                        </div>
                        <input id="input__idusuario" type="text" name="idUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nombre</span>
                        </div>
                        <input id="input__nombre" type="text" name="nombreUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Apellidos</span>
                        </div>
                        <input id="input__apellidos" type="text" name="apellidosUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tipo</span>
                        </div>
                        <select class="custom-select" id="input__tipo" name="tipoUsuario" disabled>
                            <option value="Administrador">Administrador</option>
                            <option value="Cajero">Cajero</option>
                            <option value="Valet">Valet</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Clave de acceso</span>
                        </div>
                        <input id="input__clave" type="text" name="claveUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Telefono</span>
                        </div>
                        <input id="input__telefono" type="text" name="telefonoUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Correo</span>
                        </div>
                        <input id="input__correo" type="text" name="correoUsuario" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-5">
                        <button id="usuarios__btnGuardar" type="submit" class="btn btn-primary mr-4" hidden>Guardar</button>
                        <button id="usuarios__btnModificar" type="button" class="btn btn-primary mr-4" onclick="validarModificar()" disabled>Modificar</button>
                        <button id="usuarios__btnEliminar" type="button" class="btn btn-primary" onclick="confirmarEliminar()" disabled>Eliminar</button>
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
    //echo "<script>alert('');</script>";
    $sql_sentence = "SELECT * FROM usuarios";
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
        }
    }else{
        echo $conn->error;
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>
<script> 
        var arregloUsuariosPHP = [<?php echo implode(",",$users);?>];
        var arregloUsuarios = new Array();
        var usuarioSeleccionado = "";
        for(i=0; i<arregloUsuariosPHP.length; i+=7){
            if(arregloUsuariosPHP[i+1] != "Conductor"){
                arregloUsuarios.push(arregloUsuariosPHP[i]);
            }
        }

        new autoComplete({
            data: {                              // Data src [Array, Function, Async] | (REQUIRED)
                src: arregloUsuarios,
                key: [""],
                cache: false
            },
            sort: (a, b) => {                    // Sort rendered results ascendingly | (Optional)
                if (a.match < b.match) return -1;
                if (a.match > b.match) return 1;
                return 0;
            },
            placeHolder: "",     // Place Holder text                 | (Optional)
            selector: "#input__idBuscar",           // Input field selector              | (Optional)
            threshold: 0,                        // Min. Chars length to start Engine | (Optional)
            debounce: 0,                       // Post duration for engine to start | (Optional)
            searchEngine: "strict",              // Search Engine type/mode           | (Optional)
            resultsList: {                       // Rendered results list object      | (Optional)
                render: true,
                /* if set to false, add an eventListener to the selector for event type
                "autoComplete" to handle the result */
                container: source => {
                    source.setAttribute("id", "autoComplete_list");
                },
                destination: document.querySelector("#autoComplete"),
                position: "afterend",
                element: "ul"
            },
            maxResults: 3,                         // Max. number of rendered results | (Optional)
            highlight: true,                       // Highlight matching results      | (Optional)
            resultItem: {                          // Rendered result item            | (Optional)
                content: (data, source) => {
                    source.innerHTML = data.match;
                },
                element: "li"
            },
            noResults: () => {                     // Action script on noResults      | (Optional)
                const result = document.createElement("li");
                result.setAttribute("class", "no_result");
                result.setAttribute("tabindex", "1");
                result.innerHTML = "Sin coincidencias";
                document.querySelector("#autoComplete_list").appendChild(result);
                console.log("No results");
            },
            onSelection: feedback => {             // Action script onSelection event | (Optional)
                document.getElementById("input__idusuario").disabled = false;
                document.getElementById("input__nombre").disabled = false;
                document.getElementById("input__apellidos").disabled = false;
                document.getElementById("input__tipo").disabled = false;
                document.getElementById("input__clave").disabled = false;
                document.getElementById("input__telefono").disabled = false;
                document.getElementById("input__correo").disabled = false;

                usuarioSeleccionado = feedback.selection.value;
                for(i=0; i<arregloUsuariosPHP.length; i+=7){
                    if(feedback.selection.value == arregloUsuariosPHP[i]){
                        document.getElementById("input__idBuscar").value = arregloUsuariosPHP[i];
                        document.getElementById("input__idusuario").value = arregloUsuariosPHP[i];
                        document.getElementById("input__nombre").value = arregloUsuariosPHP[i+3];
                        document.getElementById("input__apellidos").value = arregloUsuariosPHP[i+4];
                        document.getElementById("input__tipo").value = arregloUsuariosPHP[i+1];
                        document.getElementById("input__clave").value = arregloUsuariosPHP[i+2];
                        document.getElementById("input__telefono").value = arregloUsuariosPHP[i+5];
                        document.getElementById("input__correo").value = arregloUsuariosPHP[i+6];
                        break;
                    }
                }                
                document.getElementById("usuarios__btnModificar").disabled = false;
                document.getElementById("usuarios__btnEliminar").disabled = false;
            }             
        });

    function validarModificar(){
        var decision = confirm("Seguro que desea guardar cambios?");
        if(decision){
            //Validando el id
            idusuario = document.getElementById("input__idusuario").value;
            nombre = document.getElementById("input__nombre").value;
            apellidos = document.getElementById("input__apellidos").value;
            tipo = document.getElementById("input__tipo").value;
            clave = document.getElementById("input__clave").value;
            telefono = document.getElementById("input__telefono").value;
            correo = document.getElementById("input__correo").value;
            idValido = true;
            for(i=0; i<arregloUsuariosPHP.length; i+=7){
                if(idusuario == arregloUsuariosPHP[i] && (usuarioSeleccionado != idusuario)){
                    idValido = false;
                    break;
                }
            }
            if(idValido){
                $.ajax({
                    data: {idModificar: idusuario, nombreModificar: nombre, apellidosModificar: apellidos,
                        tipoModificar: tipo, claveModificar: clave, telefonoModificar: telefono, correoModificar: correo, viejoIDModificar: usuarioSeleccionado},
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
    function confirmarEliminar(){
        var decision = confirm("Seguro que desea eliminar este usuario del sistema?");
        if(decision){
            $.ajax({
                    data: {id: usuarioSeleccionado},
                    url: "eliminarUsuario.php",
                    type: "POST",            
                    success: function(response){                        
                        if(response.toString() == "éxito"){
                            alert("El usuario "+usuarioSeleccionado+" fue eliminado correctamente");
                            location.reload();
                        }
                        else {                
                            alert(response.toString());
                        }
                    }
                }).fail(function(e, test, error){
                    alert(error.toString());
                });
        }
    }
    function habilitarRegistro(){
        document.getElementById("btnNuevo").hidden = true;
        document.getElementById("btnBuscar").hidden = false;
        document.getElementById("usuarios__btnGuardar").hidden = false;
        document.getElementById("usuarios__btnModificar").hidden = true;
        document.getElementById("usuarios__btnEliminar").hidden = true;
        document.getElementById("input__idBuscar").disabled = true;
        document.getElementById("input__idusuario").disabled = false;
        document.getElementById("input__nombre").disabled = false;
        document.getElementById("input__apellidos").disabled = false;
        document.getElementById("input__tipo").disabled = false;
        document.getElementById("input__clave").disabled = false;
        document.getElementById("input__telefono").disabled = false;
        document.getElementById("input__correo").disabled = false;
        limpiarCampos();
    }
    function habilitarBusqueda(){
        document.getElementById("btnNuevo").hidden = false;
        document.getElementById("btnBuscar").hidden = true;
        document.getElementById("usuarios__btnGuardar").hidden = true;
        document.getElementById("usuarios__btnModificar").hidden = false;
        document.getElementById("usuarios__btnEliminar").hidden = false;
        document.getElementById("usuarios__btnModificar").disabled = true;
        document.getElementById("usuarios__btnEliminar").disabled = true;
        document.getElementById("input__idBuscar").disabled = false;
        document.getElementById("input__idusuario").disabled = true;
        document.getElementById("input__nombre").disabled = true;
        document.getElementById("input__apellidos").disabled = true;
        document.getElementById("input__tipo").disabled = true;
        document.getElementById("input__clave").disabled = true;
        document.getElementById("input__telefono").disabled = true;
        document.getElementById("input__correo").disabled = true;
        limpiarCampos();
    }
    function limpiarCampos(){
        document.getElementById("input__idBuscar").value = "";
        document.getElementById("input__idusuario").value = "";
        document.getElementById("input__nombre").value = "";
        document.getElementById("input__apellidos").value = "";
        document.getElementById("input__clave").value = "";
        document.getElementById("input__telefono").value = "";
        document.getElementById("input__correo").value = "";       
    }
</script>