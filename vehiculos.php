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
        <title>Estacionamiento - Vehiculos</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../estilos.css">
    </head>
    <body>    
        <div class="container h-90">
            <h3 class="mt-4 text-center">Registros de vehiculos</h3>
            <div class="row col-4 d-flex flex-row mt-4">
                <button id="btnNuevo" type="button" class="btn btn-primary mr-4" onclick="habilitarRegistro()">Registrar nuevo</button>
                <button id="btnBuscar" type="button" class="btn btn-primary" onclick="habilitarBusqueda()" hidden>Buscar vehiculo</button>
            </div>
            
            <div class="row col-12 d-flex flex-row justify-content-between mt-5">
                <span class="text-secondary">Escribe el nombre del conductor...</span>
                <div class="input-group">
                    <input id="input__idBuscarConductor" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>

            <div class="row col-12 d-flex flex-row justify-content-between mt-3">
                <span class="text-secondary">Escribe la marca del vehiculo a buscar...</span>
                <div class="input-group">
                    <input id="input__idBuscarVehiculo" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                </div>
            </div>

            <div class="row col-12 d-flex flex-row justify-content-between mt-5">
                <form class="col-12" method="post" action="registroVehiculos.php">
                    <h4>Datos del vehiculo</h4>
                    <?php if (isset($_GET['errorcode'])) : ?>
                        <p class="p-2 bg-danger text-white mt-3 mb-3"><?php 
                        if($_GET['errorcode'] == 'matricula'): 
                            echo "El vehiculo ya esta registrado en el sistema"; 
                        elseif($_GET['errorcode'] == 'idconductor'): 
                            echo "El ID de conductor no existe en el sistema"; 
                        endif ?></p>
                    <?php endif; ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">ID de conductor</span>
                        </div>
                        <input id="input__idconductor" type="text" name="idConductorVehiculo" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Matricula</span>
                        </div>
                        <input id="input__matricula" type="text" name="matriculaVehiculo" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Marca</span>
                        </div>
                        <input id="input__marca" type="text" name="marcaVehiculo" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Modelo</span>
                        </div>
                        <input id="input__modelo" type="text" name="modeloVehiculo" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Color</span>
                        </div>
                        <input id="input__color" type="text" name="colorVehiculo" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tamaño</span>
                        </div>
                        <select class="custom-select" id="input__tamaño" name="tamanioVehiculo" disabled>
                            <option value="Chico" selected>Chico</option>
                            <option value="Grande">Grande</option>
                        </select>
                    </div>
                    <div class="input-group mb-5">
                        <button id="vehiculos__btnGuardar" type="submit" class="btn btn-primary mr-4" hidden>Guardar</button>
                        <button id="vehiculos__btnModificar" type="button" class="btn btn-primary mr-4" onclick="validarModificar()" disabled>Modificar</button>
                        <button id="vehiculos__btnEliminar" type="button" class="btn btn-primary" onclick="confirmarEliminar()" disabled>Eliminar</button>
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
    $cars = array();
    $sql_sentence = "SELECT * FROM usuarios where tipo = 'Conductor' ";
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

            $sql_sentence = "SELECT * FROM vehiculos";
            $query = $conn->query($sql_sentence);
            if($query){
                if($query->num_rows > 0){
                    while($row = $query->fetch_assoc()){
                        array_push($cars, "'".$row["placas"]."'");
                        array_push($cars, "'".$row["marca"]."'");
                        array_push($cars, "'".$row["modelo"]."'");
                        array_push($cars, "'".$row["color"]."'");
                        array_push($cars, "'".$row["tamanio"]."'");
                        array_push($cars, "'".$row["cliente"]."'");
                    }
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

<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>


<script>    
        var arregloUsuariosPHP = [<?php echo implode(",",$users);?>];
        var arregloUsuarios = new Array();
        for(i=0; i<arregloUsuariosPHP.length; i+=7){
            arregloUsuarios.push(arregloUsuariosPHP[i]);
        }

        var arregloVehiculosPHP = [<?php echo implode(",",$cars);?>];
        var arregloVehiculos = new Array();
        var usuarioSeleccionado = ""; var vehiculoSeleccionado = "";

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
            selector: "#input__idBuscarConductor",           // Input field selector              | (Optional)
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
                usuarioSeleccionado = feedback.selection.value;
                document.getElementById("input__idBuscarConductor").value = usuarioSeleccionado;
                for(i=0; i<arregloVehiculosPHP.length; i+=6){
                    if(arregloVehiculosPHP[i+5] == usuarioSeleccionado){
                        arregloVehiculos.push(arregloVehiculosPHP[i+1]+" "+arregloVehiculosPHP[i+2]+" "+arregloVehiculosPHP[i]);
                    }
                }
                document.getElementById("input__idBuscarVehiculo").disabled = false;
                generarAutoCompleteVehiculos();
            }             
        });
    function generarAutoCompleteVehiculos(){
        new autoComplete({
            data: {                              // Data src [Array, Function, Async] | (REQUIRED)
                src: arregloVehiculos,
                key: [""],
                cache: false
            },
            sort: (a, b) => {                    // Sort rendered results ascendingly | (Optional)
                if (a.match < b.match) return -1;
                if (a.match > b.match) return 1;
                return 0;
            },
            placeHolder: "",     // Place Holder text                 | (Optional)
            selector: "#input__idBuscarVehiculo",           // Input field selector              | (Optional)
            threshold: 0,                        // Min. Chars length to start Engine | (Optional)
            debounce: 0,                       // Post duration for engine to start | (Optional)
            searchEngine: "strict",              // Search Engine type/mode           | (Optional)
            resultsList: {                       // Rendered results list object      | (Optional)
                render: true,
                /* if set to false, add an eventListener to the selector for event type
                "autoComplete" to handle the result */
                container: source => {
                    source.setAttribute("id", "autoComplete_list1");
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
                document.querySelector("#autoComplete_list1").appendChild(result);
                console.log("No results");
            },
            onSelection: feedback => {             // Action script onSelection event | (Optional)
                document.getElementById("input__idconductor").disabled = false;
                document.getElementById("input__matricula").disabled = false;
                document.getElementById("input__marca").disabled = false;
                document.getElementById("input__modelo").disabled = false;
                document.getElementById("input__color").disabled = false;
                document.getElementById("input__tamaño").disabled = false;

                for(i=0; i<arregloVehiculosPHP.length; i+=6){
                    if(feedback.selection.value == arregloVehiculosPHP[i+1]+" "+arregloVehiculosPHP[i+2]+" "+arregloVehiculosPHP[i]){
                        vehiculoSeleccionado = arregloVehiculosPHP[i];
                        document.getElementById("input__idBuscarVehiculo").value = feedback.selection.value;
                        document.getElementById("input__idconductor").value = arregloVehiculosPHP[i+5];
                        document.getElementById("input__matricula").value = arregloVehiculosPHP[i];
                        document.getElementById("input__marca").value = arregloVehiculosPHP[i+1];
                        document.getElementById("input__modelo").value = arregloVehiculosPHP[i+2];
                        document.getElementById("input__color").value = arregloVehiculosPHP[i+3];
                        document.getElementById("input__tamaño").value = arregloVehiculosPHP[i+4];
                        break;
                    }
                }                
                document.getElementById("vehiculos__btnModificar").disabled = false;
                document.getElementById("vehiculos__btnEliminar").disabled = false;
            }             
        });
    }
    function validarModificar(){
        cliente = document.getElementById("input__idconductor").value;
        matricula = document.getElementById("input__matricula").value;
        marca = document.getElementById("input__marca").value;
        modelo = document.getElementById("input__modelo").value;
        color = document.getElementById("input__color").value;
        tamanio = document.getElementById("input__tamaño").value;
        clienteValido = false; matriculaValida = true;
        for(i=0; i<arregloUsuariosPHP.length; i+=7){
            if(cliente == arregloUsuariosPHP[i]){
                clienteValido = true;
                break;
            }
        }
        for(i=0; i<arregloVehiculosPHP.length; i+=6){
            if(matricula == arregloVehiculosPHP[i] && (vehiculoSeleccionado != matricula)){
                matriculaValida = false;
                break;
            }
        }
        if(!clienteValido){
            alert("ID de cliente no registrado en el sistema");
        }else if(!matriculaValida){
            alert("Este vehiculo ya se encuentra registrado (Matricula duplicada)");
        }else{
            $.ajax({
                    data: {viejaMatricula: vehiculoSeleccionado, matriculaVehiculo: matricula, marcaVehiculo: marca,
                        modeloVehiculo: modelo, colorVehiculo: color, tamanioVehiculo: tamanio, clienteVehiculo: cliente},
                    url: "modificarVehiculo.php",
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
        }

    }
    function confirmarEliminar(){
        var decision = confirm("Seguro que quiere borrar este vehiculo?");
        if(decision){
            $.ajax({
                data: {id: vehiculoSeleccionado},
                url: "eliminarVehiculo.php",
                type: "POST",            
                success: function(response){                        
                    if(response.toString() == "éxito"){
                        alert("El vehiculo fue eliminado correctamente");
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
        document.getElementById("vehiculos__btnGuardar").hidden = false;
        document.getElementById("vehiculos__btnModificar").hidden = true;
        document.getElementById("vehiculos__btnEliminar").hidden = true;
        document.getElementById("input__idBuscarConductor").disabled = true;
        document.getElementById("input__idBuscarVehiculo").disabled = true;
        document.getElementById("input__idconductor").disabled = false;
        document.getElementById("input__matricula").disabled = false;
        document.getElementById("input__marca").disabled = false;
        document.getElementById("input__modelo").disabled = false;
        document.getElementById("input__color").disabled = false;
        document.getElementById("input__tamaño").disabled = false;
        limpiarCampos();
    }

    function habilitarBusqueda(){
        document.getElementById("btnNuevo").hidden = false;
        document.getElementById("btnBuscar").hidden = true;
        document.getElementById("vehiculos__btnGuardar").hidden = true;
        document.getElementById("vehiculos__btnModificar").hidden = false;
        document.getElementById("vehiculos__btnEliminar").hidden = false;
        document.getElementById("vehiculos__btnModificar").disabled = true;
        document.getElementById("vehiculos__btnEliminar").disabled = true;
        document.getElementById("input__idBuscarConductor").disabled = false;
        document.getElementById("input__idBuscarVehiculo").disabled = true;
        document.getElementById("input__idconductor").disabled = true;
        document.getElementById("input__matricula").disabled = true;
        document.getElementById("input__marca").disabled = true;
        document.getElementById("input__modelo").disabled = true;
        document.getElementById("input__color").disabled = true;
        document.getElementById("input__tamaño").disabled = true;
        limpiarCampos();
    }
    function limpiarCampos(){
        document.getElementById("input__idBuscarConductor").value = "";
        document.getElementById("input__idBuscarVehiculo").value = "";
        document.getElementById("input__idconductor").value = "";
        document.getElementById("input__matricula").value = "";
        document.getElementById("input__marca").value = "";
        document.getElementById("input__modelo").value = "";
        document.getElementById("input__color").value = "";
    }
</script>