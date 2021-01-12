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
        <title>Estacionamiento - Corte de caja</title>    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../estilos.css">
    </head>
    <body>    
        <div class="container h-90">
            <h3 class="mt-4 text-center">Periodo de corte</h3>
            <div class="row col-12 d-flex flex-row mt-4">
                <span>Desde</span>
                <input id="fechaDesde" type="date" class="ml-3 mr-4"/>
                <span>Hasta</span>
                <input id="fechaHasta" type="date" class="ml-3 mr-4"/>
                <button id="btnCorte" type="button" class="btn btn-primary" onclick="generarCorte()">Generar corte</button>
            </div>

            <div class="table-responsive">
                <table id="tablaCorteCaja" class="table table-striped table-hover mt-5">
                    <thead class="bg-primary text-white">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Vehiculo</th>
                        <th scope="col">Cajón</th>
                        <th scope="col">Concepto</th>
                        <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">Total</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                        </tr>
                    </tbody>
                </table>
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
    $usuarios = array();
    $sql_sentence = "SELECT * FROM usuarios WHERE tipo = 'Conductor'";
    $query = $conn->query($sql_sentence);
    if($query){
        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                array_push($usuarios, "'".$row["usuario"]."'");
                array_push($usuarios, "'".$row["nombre"]."'");
                array_push($usuarios, "'".$row["apellidos"]."'");
            }
            $vehiculos = array();
            $sql_sentence = "SELECT * FROM vehiculos";
            $query = $conn->query($sql_sentence);
            if($query){
                if($query->num_rows > 0){
                    while($row = $query->fetch_assoc()){
                        array_push($vehiculos, "'".$row["placas"]."'");
                        array_push($vehiculos, "'".$row["marca"]."'");
                        array_push($vehiculos, "'".$row["modelo"]."'");
                        array_push($vehiculos, "'".$row["cliente"]."'");
                    }
                    $resguardos = array();
                    $sql_sentence = "SELECT * FROM resguardos WHERE estatus = 'Pagado'";
                    $query = $conn->query($sql_sentence);
                    if($query){
                        if($query->num_rows > 0){
                            while($row = $query->fetch_assoc()){
                                array_push($resguardos, "'".$row["id_cajon"]."'");
                                array_push($resguardos, "'".$row["placas"]."'");
                                array_push($resguardos, "'".$row["hora_llegada"]."'");
                                array_push($resguardos, "'".$row["hora_salida"]."'");
                                array_push($resguardos, "'".$row["lavado"]."'");
                                array_push($resguardos, "'".$row["pago"]."'");
                                array_push($resguardos, "'".$row["fecha"]."'");
                                array_push($resguardos, "'".$row["estatus"]."'");
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

<script>    
  var arregloClientesPHP = [<?php echo implode(",",$usuarios);?>];
  var arregloVehiculosPHP = [<?php echo implode(",",$vehiculos);?>];
  var arregloResguardosPHP = [<?php echo implode(",",$resguardos);?>];

    function generarCorte(){
        tabla = document.getElementById("tablaCorteCaja");
        while(tabla.rows.length > 1){
            tabla.deleteRow(tabla.rows.length-1);
        }
        sumaTotal = 0;
        fechaDesde = document.getElementById("fechaDesde").value;
        fechaHasta = document.getElementById("fechaHasta").value;
        if(fechaDesde != "" && fechaHasta != ""){
            if(fechaDesde <= fechaHasta){
                for(i=0; i<arregloResguardosPHP.length; i+=8){
                    elementos = arregloResguardosPHP[i+6].split("/");
                    fechaResguardo = (elementos[2]+"-"+elementos[1]+"-"+elementos[0]);
                    if(fechaResguardo >= fechaDesde && fechaResguardo <= fechaHasta){
                        fila = tabla.insertRow(tabla.rows.length);
                        numero = fila.insertCell(0);
                        cliente = fila.insertCell(1);
                        vehiculo = fila.insertCell(2);
                        cajon = fila.insertCell(3);
                        concepto = fila.insertCell(4);
                        subtotal = fila.insertCell(5);
                        
                        numero.innerHTML = tabla.rows.length; 
                        cajon.innerHTML =   arregloResguardosPHP[i];   
                                        
                        for(m=0; m<arregloVehiculosPHP.length; m+=4){
                            if(arregloVehiculosPHP[m] == arregloResguardosPHP[m+1]){
                                vehiculo.innerHTML = arregloVehiculosPHP[m+1]+" "+arregloVehiculosPHP[m+2];

                                for(k=0; k<arregloClientesPHP.length; k+=3){
                                    if(arregloClientesPHP[k] == arregloVehiculosPHP[m+3]){
                                        cliente.innerHTML = arregloClientesPHP[k+1]+" "+arregloClientesPHP[k+2];
                                        break;
                                    }
                                } 

                                break;
                            }
                        }
                        concepto.innerHTML = "Solo resguardo";
                        if(arregloResguardosPHP[i+4] == "true"){
                            concepto.innerHTML = "Resguardo y lavado";
                        }
                        subtotal.innerHTML = "$"+arregloResguardosPHP[i+5];
                        sumaTotal += parseFloat(arregloResguardosPHP[i+5]);
                    }
                }
                    
                fila = tabla.insertRow(tabla.rows.length);
                numero = fila.insertCell(0);
                cliente = fila.insertCell(1);
                vehiculo = fila.insertCell(2);
                cajon = fila.insertCell(3);
                concepto = fila.insertCell(4);
                subtotal = fila.insertCell(5);
                
                numero.innerHTML = "Total";
                subtotal.innerHTML = "$"+sumaTotal;
                if(tabla.rows.length>2){
                    subtotal.innerHTML = "$"+sumaTotal;
                }else{                    
                    alert("No existen registros de resguardos pagados en este periodo");
                }
            }else{
                alert("La fecha de inicio debe ser menor o igual a la fecha final");
            }
        }else{
            alert("Seleccione un periodo por fecha")
        }
    }

</script>