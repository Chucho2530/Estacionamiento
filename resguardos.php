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
        <form autocomplete="off" action="registrarResguardo.php" method=post style="margin-top:40px; padding-bottom:30px; width: 60%; margin-left: 20%; margin-right: 20%; margin-bottom: 5%; ">                        
             
            <input id="fecha" name="fecha" type=hidden> 
            <input id="horaEntrada" name="horaEntrada" type=hidden> 
            <center>
                <h4><b>Comprobante de estacionamiento</b></h4>
                <p id="dd">Fecha: 
                   Hora: </p>
            </center>
            

            <div class="form-group form-inline autocomplete">
              <label for="tipo" style="margin-left: 10%; width: 20%; float: left">Tipo:</label>
              <select style="width: 60%" class="form-control" id="tipo" onchange="cambiarTipoRecibo()">
                  <option value="Vehiculo registrado">Vehiculo registrado</option>
                  <option value="Vehiculo nuevo">Vehiculo nuevo</option>
              </select>
            </div>
            <br>

            <div class="form-group form-inline autocomplete">
                <label for="cliente" style="margin-left: 10%; width: 20%;">Cliente:</label>         
                <input id="clienteID" name="clienteID" type=hidden>  
                <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Nombre del cliente..." style="width:60%">
            </div>
            <div id="camposAutoReg" class="form-group form-inline autocomplete">              
                <input id="autoID" name="autoID" type=hidden>   
                <label for="auto" style="margin-top: 10px; margin-left: 10%; width: 20%;">Vehiculo:</label>
                <input type="text" class="form-control" id="auto" name="auto" placeholder="Vehiculo del cliente..." style="width:60%" disabled>
            </div>
            
            <div id="camposAutoNuevo" style="display: none">
              <div class="form-inline form-group">
                  <label for="matricula" style="margin-left: 10%; width: 20%;">Placas:</label>
                  <input type="text" class="form-control" id="matricula" placeholder="Matricula..." name="matricula" style="width: 60%">                
              </div>
              
              <div class="form-inline form-group">              
                  <label for="marca" style="margin-left: 10%; width: 20%;">Marca:</label>
                  <input type="text" class="form-control" id="marca" placeholder="Marca..." name="marca" style="width: 60%">
              </div>
              <div class="form-inline form-group">
                  <label for="modelo" style="margin-left: 10%; width: 20%;">Modelo:</label>
                  <input type="text" class="form-control" id="modelo" placeholder="Modelo..." name="modelo" style="width: 60%">     
              </div>
              
              <div class="form-inline form-group">              
                  <label for="color" style="margin-left: 10%; width: 20%;">Color:</label>
                  <input type="text" class="form-control" id="color" placeholder="Color..." name="color" style="width: 60%">
              </div>
              <div class="form-inline form-group">              
                  <label for="tamanio" style="margin-left: 10%; width: 20%;">Tamaño:</label>
                  <select id="tamanio" name="tamanio" class="form-control" style="width: 60%">
                      <option value="Chico">Chico</option>
                      <option value="Grande">Grande</option>
                  </select>
              </div>
            </div>
            <div class="input-group mb-3 col-10" style="margin-left: 16%">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <input type="checkbox" name="lavado" aria-label="Checkbox for following text input">
                </div>
              </div>
              <input type="text" class="form-control col-9" style="margin-left: 9.5%" placeholder="Servicio de lavado" aria-label="Text input with checkbox" disabled>
            </div>

            <center>
              <br>
            <input type="submit" class="btn btn-primary" value="Registrar" id="btnGuardar" disabled>
            </center>
        </form>
    </body>


<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "estacionamientomejorado";
    $conn = new mysqli($server, $user, $password, $db);
    if($conn->connect_error){
        die("Falló la conexión: ".$conn->connect_error);
    }else{
        $clientes = array();
        $vehiculos = array();
        //echo "<script>alert('');</script>";
        $sql_sentence = "SELECT * FROM usuarios where tipo = 'Conductor'";
        $query = $conn->query($sql_sentence);
        if($query){
            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    array_push($clientes, "'".$row["usuario"]."'");
                    array_push($clientes, "'".$row["nombre"]."'");
                    array_push($clientes, "'".$row["apellidos"]."'");
                }            
            }
            
            $sql_sentence = "SELECT * FROM vehiculos";
            $query = $conn->query($sql_sentence);
            if($query){
                if($query->num_rows > 0){
                    while($row = $query->fetch_assoc()){
                        array_push($vehiculos, "'".$row["placas"]."'");
                        array_push($vehiculos, "'".$row["marca"]."'");
                        array_push($vehiculos, "'".$row["modelo"]."'");
                        array_push($vehiculos, "'".$row["color"]."'");
                        array_push($vehiculos, "'".$row["tamanio"]."'");
                        array_push($vehiculos, "'".$row["cliente"]."'");
                    }
                }
            }
        }else{
            echo $conn->error;
        }
    }
?>




<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@7.2.0/dist/js/autoComplete.min.js"></script>

<script type="text/javascript">
  var d = new Date();
  document.getElementById("dd").innerHTML = "Fecha: "+('0'+d.getDate()).slice(-2)+" - "+('0'+(d.getMonth()+1)).slice(-2)+" - "+d.getFullYear()+
      "<br> Hora: "+('0'+d.getHours()).slice(-2)+":"+('0'+d.getMinutes()).slice(-2);
  document.getElementById("fecha").value = ('0'+d.getDate()).slice(-2)+"/"+('0'+(d.getMonth()+1)).slice(-2)+"/"+d.getFullYear();
  document.getElementById("horaEntrada").value = ('0'+d.getHours()).slice(-2)+":"+('0'+d.getMinutes()).slice(-2)+":"+('0'+d.getSeconds()).slice(-2);
  var inputName = document.getElementById("cliente");        
  var inputCar = document.getElementById("auto");
  var arregloClientes = new Array();
  var arregloClientesPHP = [<?php echo implode(",",$clientes);?>];
  var arregloAutos = new Array();
  var arregloAutosPHP = [<?php echo implode(",",$vehiculos);?>];

  for(i=0; i<arregloClientesPHP.length; i+=3){
      arregloClientes.push(arregloClientesPHP[i+1]+" "+arregloClientesPHP[i+2]+", ID: "+arregloClientesPHP[i]);
  }
  for(i=0; i<arregloAutosPHP.length; i+=6){
      arregloAutos.push(arregloAutosPHP[i+1]+" "+arregloAutosPHP[i+2]+" "+arregloAutosPHP[i]);
  }
  new autoComplete({
            data: {                              // Data src [Array, Function, Async] | (REQUIRED)
                src: arregloClientes,
                key: [""],
                cache: false
            },
            sort: (a, b) => {                    // Sort rendered results ascendingly | (Optional)
                if (a.match < b.match) return -1;
                if (a.match > b.match) return 1;
                return 0;
            },
            placeHolder: "",     // Place Holder text                 | (Optional)
            selector: "#cliente",           // Input field selector              | (Optional)
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
                for(i=0; i<arregloClientesPHP.length; i+=3){
                    if(feedback.selection.value == arregloClientesPHP[i+1]+" "+arregloClientesPHP[i+2]+", ID: "+arregloClientesPHP[i]){
                        document.getElementById("cliente").value = feedback.selection.value;
                        document.getElementById("clienteID").value = arregloClientesPHP[i];
                        break;
                    }
                }                
                document.getElementById("auto").disabled = false;
                generarAutoCompletarVehiculos();
            }             
    });

  
  
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
            selector: "#auto",           // Input field selector              | (Optional)
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

                for(i=0; i<arregloAutosPHP.length; i+=6){
                    if(feedback.selection.value == arregloAutosPHP[i+1]+" "+arregloAutosPHP[i+2]+" "+arregloAutosPHP[i]){
                      document.getElementById("auto").value = feedback.selection.value;
                        document.getElementById("autoID").value = arregloAutosPHP[i];
                        break;
                    }
                }                
                document.getElementById("btnGuardar").disabled = false;
            }             
        });
    }
function cambiarTipoRecibo(){
  if(document.getElementById("tipo").value != "Vehiculo registrado"){
    document.getElementById("camposAutoNuevo").style.display = "block";
    document.getElementById("camposAutoReg").style.display = "none";
    document.getElementById("auto").value = "";
    document.getElementById("autoID").value = "";
    document.getElementById("cliente").value = "";
    document.getElementById("clienteID").value = "";
    $("#auto").attr("disabled", true);
    $("#btnGuardar").removeAttr("disabled", false);
  }else{
    document.getElementById("camposAutoNuevo").style.display = "none";
    document.getElementById("camposAutoReg").style.display = "flex";
    $("#btnGuardar").attr("disabled", true);
  }
}

    </script>
</html>