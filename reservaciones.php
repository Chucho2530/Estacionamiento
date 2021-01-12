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
        <title>Estacionamiento - Reservaciones</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../estilos.css">
    </head>
    <body>    
        <div class="container h-90">
            <h3 class="mt-4 text-center">Reservar un cajón</h3>

            <div class="row col-12 d-flex flex-row justify-content-between mt-4">
                <form class="col-12" method="post" action="reservarCajon.php">

                    <h4>Datos de la reservación</h4>
                    <?php if (isset($_GET['errorcode'])) : ?>
                        <p class="p-2 bg-danger text-white mt-3 mb-3"><?php 
                        if($_GET['errorcode'] == 'autoConReserva'): 
                            echo "Este vehiculo ya tiene una reservacion activa en el estacionamiento"; 
                        endif ?></p>
                    <?php endif; ?>
                    <div class="row col-12 d-flex flex-row justify-content-between mt-5">
                        <span class="text-secondary">Nombre del conductor...</span>
                        <div class="input-group">    
                            <input id="clienteID" name="clienteID" type=hidden>  
                            <input id="input__idBuscarConductor" type="text" name="cliente" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                        </div>
                    </div>

                    <div class="row col-12 d-flex flex-row justify-content-between mt-3">
                        <span class="text-secondary">Escribe la marca del vehiculo a buscar...</span>
                        <div class="input-group">    
                            <input id="autoID" name="autoID" type=hidden>  
                            <input id="input__idBuscarVehiculo" type="text" name="vehiculo" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>

                    
                    <div class="row col-12 mt-4 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Cajón</span>
                        </div>    
                        <input id="cajonID" name="cajonID" type=hidden>  
                        <select class="custom-select col-11 ml-3" id="input__cajon" name="cajon" onchange="cajonSeleccionado()">
                        </select>
                    </div>

                    <div class="input-group mb-5">
                        <button id="btnGuardar" type="submit" class="btn btn-primary mr-4" disabled>Guardar reservación</button>
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
    $sql_sentence = "SELECT * FROM usuarios where usuario = '".$_SESSION["UsuarioID"]."'";
    $query = $conn->query($sql_sentence);
    if($query){
        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                array_push($users, "'".$row["usuario"]."'");
                array_push($users, "'".$row["nombre"]."'");
                array_push($users, "'".$row["apellidos"]."'");
            }
            $cars = array();
            $sql_sentence = "SELECT * FROM vehiculos";
            $query = $conn->query($sql_sentence);
            if($query){
                if($query->num_rows > 0){
                    while($row = $query->fetch_assoc()){
                        array_push($cars, "'".$row["placas"]."'");
                        array_push($cars, "'".$row["marca"]."'");
                        array_push($cars, "'".$row["modelo"]."'");
                        array_push($cars, "'".$row["cliente"]."'");
                    }
                    $cajones = array();
                    $sql_sentence = "SELECT * FROM cajones WHERE situacion = 'Disponible'";
                    $query = $conn->query($sql_sentence);
                    if($query){
                        if($query->num_rows > 0){
                            while($row = $query->fetch_assoc()){
                                array_push($cajones, "'".$row["id"]."'");
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
    }else{
        echo $conn->error;
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>
<script> 
$("form").keypress(function(e) {
  //Enter key
  if (e.which == 13) {
    return false;
  }
});
var arregloCajonesPHP = [<?php echo implode(",",$cajones);?>];
for(i=0; i<arregloCajonesPHP.length; i+=1){
    document.getElementById("input__cajon").innerHTML += "<option>"+arregloCajonesPHP[i]+"</option>";
}
    var arregloUsuariosPHP = [<?php echo implode(",",$users);?>];
        document.getElementById("clienteID").value = arregloUsuariosPHP[0];
        document.getElementById("input__idBuscarConductor").value = arregloUsuariosPHP[1]+" "+arregloUsuariosPHP[2];
        var arregloAutosPHP = [<?php echo implode(",",$cars);?>];
        var arregloAutos = new Array();
        for(i=0; i<arregloAutosPHP.length; i+=4){
            if(document.getElementById("clienteID").value == arregloAutosPHP[i+3]){
                arregloAutos.push(arregloAutosPHP[i+1]+" "+arregloAutosPHP[i+2]+" "+arregloAutosPHP[i]);
            }
        }
        generarAutoCompletarVehiculos();
        
    function generarAutoCompletarVehiculos(){
        new autoComplete({
            data: {                              // Data src [Array, Function, Async] | (REQUIRED)
                src: arregloAutos,
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

                for(i=0; i<arregloAutosPHP.length; i+=4){
                    if(feedback.selection.value == arregloAutosPHP[i+1]+" "+arregloAutosPHP[i+2]+" "+arregloAutosPHP[i]){
                        document.getElementById("input__idBuscarVehiculo").value = feedback.selection.value;
                        document.getElementById("autoID").value = arregloAutosPHP[i];
                        break;
                    }
                }                
                document.getElementById("btnGuardar").disabled = false;
            }             
        });
    }
    function cajonSeleccionado(){
        document.getElementById("cajonID").value = document.getElementById("input__cajon").value;
    }

</script>