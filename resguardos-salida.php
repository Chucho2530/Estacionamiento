<?php        
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/EstacionamientoMejorado/cajero/barranav.php");    
    if($_SESSION["Usuario"] != "Cajero"){ 
        echo "<script>location.href='../index.php';</script>";
    }
?>
<!DOCTYPE html>
<html>
    <head>        
        <meta charset="utf-8">
        <title>Estacionamiento - Resguardos</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../estilos.css">
    </head>
    <body>    
        <div class="container h-90">
            <h3 class="mt-4 text-center">Salida de vehiculo</h3>

            <div class="row col-12 d-flex flex-row justify-content-between mt-4">
                <form class="col-12" method="post" action="pagarResguardo.php">

                    <h4>Datos del resguardo por pagar</h4>
                    <?php if (isset($_GET['errorcode'])) : ?>
                        <p class="p-2 bg-danger text-white mt-3 mb-3"><?php 
                        if($_GET['errorcode'] == 'emptyField'): 
                            echo "Uno o más campos estan vacios, selecciona un vehiculo y calcula el monto a pagar"; 
                        endif ?></p>
                    <?php endif; ?>
                    <div class="row col-12 d-flex flex-row justify-content-between mt-3">
                        <span class="text-secondary">Escribe la marca del vehiculo resguardado...</span>
                        <div class="input-group">    
                            <input id="autoID" name="autoID" type=hidden>  
                            <input id="input__idBuscarVehiculo" type="text" name="vehiculo" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="row col-12 d-flex flex-row justify-content-between mt-4 mb-4">
                        <span class="text-secondary">Registrado a nombre de...</span>
                        <div class="input-group">    
                            <input id="clienteID" name="clienteID" type=hidden>  
                            <input id="input__idBuscarConductor" type="text" name="cliente" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                        </div>
                    </div>
                    
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Fecha</span>
                        </div>
                        <input id="fecha" type="text" name="fecha" class="form-control col-11" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Hora entrada</span>
                        </div>
                        <input id="hora_entrada" type="text" name="hora_entrada" class="form-control col-11" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Cajón</span>
                        </div>
                        <input id="cajon" type="text" name="cajon" class="form-control col-11" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>                    
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Servicio de lavado</span>
                        </div>
                        <input id="lavado" type="text" name="lavado" class="form-control col-11" placeholder="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Total a cobrar</span>
                        </div>
                        <input id="total_cobrar" type="text" name="total_cobrar" class="form-control col-11" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-5">
                        <button id="btnPagar" type="button" class="btn btn-primary mr-4" onclick="pagar()" disabled>Pagar resguardo</button>
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
                    $resguardos = array();
                    $sql_sentence = "SELECT * FROM resguardos WHERE estatus = 'Activo'";
                    $query = $conn->query($sql_sentence);
                    if($query){
                        if($query->num_rows > 0){
                            while($row = $query->fetch_assoc()){
                                array_push($resguardos, "'".$row["id_cajon"]."'");
                                array_push($resguardos, "'".$row["placas"]."'");
                                array_push($resguardos, "'".$row["hora_llegada"]."'");
                                array_push($resguardos, "'".$row["lavado"]."'");
                                array_push($resguardos, "'".$row["fecha"]."'");
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="../pdfLibrary/dist/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>
<script> 
$("form").keypress(function(e) {
  //Enter key
  if (e.which == 13) {
    return false;
  }
});
        var arregloUsuariosPHP = [<?php echo implode(",",$users);?>];
        var arregloResguardosPHP = [<?php echo implode(",",$resguardos);?>];
        var arregloAutosPHP = [<?php echo implode(",",$cars);?>];
        var arregloAutos = new Array();
        for(i=0; i<arregloAutosPHP.length; i+=4){
            arregloAutos.push(arregloAutosPHP[i+1]+" "+arregloAutosPHP[i+2]+" "+arregloAutosPHP[i]);
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
                document.getElementById("input__idBuscarConductor").value = "";
                document.getElementById("clienteID").value = "";
                en_resguardo = false;
                for(i=0; i<arregloAutosPHP.length; i+=4){
                    if(feedback.selection.value == arregloAutosPHP[i+1]+" "+arregloAutosPHP[i+2]+" "+arregloAutosPHP[i]){
                        
                        for(m=0; m<arregloResguardosPHP.length; m+=5){
                            if(arregloResguardosPHP[m+1] == arregloAutosPHP[i]){
                                en_resguardo = true;
                                document.getElementById("input__idBuscarVehiculo").value = feedback.selection.value;
                                document.getElementById("autoID").value = arregloAutosPHP[i];
                                document.getElementById("fecha").value = arregloResguardosPHP[m+4]
                                document.getElementById("hora_entrada").value = arregloResguardosPHP[m+2]
                                document.getElementById("cajon").value = arregloResguardosPHP[m];
                                document.getElementById("lavado").value = "$0.00";
                                if(arregloResguardosPHP[m+3] = "true"){
                                    document.getElementById("lavado").value = "$25.00";
                                }
                                for(h=0; h<arregloUsuariosPHP.length; h+=3){
                                    if(arregloUsuariosPHP[h] == arregloAutosPHP[i+3]){
                                        document.getElementById("input__idBuscarConductor").value = arregloUsuariosPHP[h+1]+" "+arregloUsuariosPHP[h+2];
                                        document.getElementById("clienteID").value = arregloUsuariosPHP[h];
                                        break;
                                    }
                                }
                                break;
                            }
                        }
                    }
                }
                if(en_resguardo){                
                    document.getElementById("btnPagar").disabled = false;
                }else{
                    alert("Este vehiculo no está en resguardo actualmente");
                }
            }             
        });
    }
    function cajonSeleccionado(){
        document.getElementById("cajonID").value = document.getElementById("input__cajon").value;
    }
    function pagar(){
        auto = document.getElementById("autoID").value;
        cajon = document.getElementById("cajon").value;
        hora = document.getElementById("hora_entrada").value;
        pago = document.getElementById("total_cobrar").value;
        d = new Date();
        hraSalida = ('0'+d.getHours()).slice(-2)+":"+('0'+d.getMinutes()).slice(-2)+":"+('0'+d.getSeconds()).slice(-2);
        hoy = ('0'+d.getDate()).slice(-2)+"/"+('0'+(d.getMonth()+1)).slice(-2)+"/"+d.getFullYear();
        $.ajax({
            data: {vehiculo: auto, cajon: cajon, hora_entrada: hora, total_cobrar: pago},
            url: "pagarResguardo.php",
            type: "POST",            
            success: function(response){                        
                if(response.toString() == "éxito"){
                    var doc = new jsPDF();        
                    doc.setFontSize(18);
                    textWidth = doc.getStringUnitWidth("Estacionamiento") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                    textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                    doc.text(textOffset, 18, "Estacionamiento");

                    doc.setFontSize(14);
                    textWidth = doc.getStringUnitWidth("Ticket de salida") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                    textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                    doc.text(textOffset, 25, "Ticket de salida");


                    doc.setFontSize(12);
                    doc.text(30, 37, "Fecha: "+hoy);
                    doc.text(140, 37, "Hora: "+hraSalida);

                    doc.setFontSize(10);
                    doc.text(30, 45, "Cajón: "+cajon);
                    doc.text(30, 50, "Nombre del usuario: "+document.getElementById("input__idBuscarConductor").value);
                    doc.text(30, 55, "Vehiculo: "+document.getElementById("input__idBuscarVehiculo").value);
                    doc.text(30, 65, "Total: "+pago);
                    

                    doc.save("ticket.pdf");
                    alert('Pago registrado correctamente'); 
                    location.href='resguardos-salida.php';
                    location.href.reload();
                }
                else {                
                    alert('Uno o más campos estan vacios, selecciona un vehiculo y calcula el monto a pagar');
                }
            }
        }).fail(function(e, test, error){
            alert(error.toString());
        });
    }

</script>