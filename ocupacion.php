<?php        
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/EstacionamientoMejorado/valet/barranav.php");    
    if($_SESSION["Usuario"] != "Valet"){ 
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
        <h3 id="ocupacion" class="text-center font-weight-bold" style="padding-bottom: 20px;">Ocupación actual</h3>
        <div id="resguardos">
            <div class="fila">
                <div class="cajon">
                    <img id="cajon1_img" src="icon-parking.png"/>
                    <p>Cajón 1</p>
                    <p id="cajon1_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon2_img" src="icon-parking.png"/>
                    <p>Cajón 2</p>
                    <p id="cajon2_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon3_img" src="icon-parking.png"/>
                    <p>Cajón 3</p>
                    <p id="cajon3_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon4_img" src="icon-parking.png"/>
                    <p>Cajón 4</p>
                    <p id="cajon4_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon5_img" src="icon-parking.png"/>
                    <p>Cajón 5</p>
                    <p id="cajon5_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon6_img" src="icon-parking.png"/>
                    <p>Cajón 6</p>
                    <p id="cajon6_situacion">Disponible</p>
                </div>
            </div>
            <div class="fila">
                <div class="cajon">
                    <img id="cajon7_img" src="icon-parking.png"/>
                    <p>Cajón 7</p>
                    <p id="cajon7_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon8_img" src="icon-parking.png"/>
                    <p>Cajón 8</p>
                    <p id="cajon8_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon9_img" src="icon-parking.png"/>
                    <p>Cajón 9</p>
                    <p id="cajon9_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon10_img" src="icon-parking.png"/>
                    <p>Cajón 10</p>
                    <p id="cajon10_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon11_img" src="icon-parking.png"/>
                    <p>Cajón 11</p>
                    <p id="cajon11_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon12_img" src="icon-parking.png"/>
                    <p>Cajón 12</p>
                    <p id="cajon12_situacion">Disponible</p>
                </div>
            </div>
            <div class="fila">
                <div class="cajon">
                    <img id="cajon13_img" src="icon-parking.png"/>
                    <p>Cajón 13</p>
                    <p id="cajon13_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon14_img" src="icon-parking.png"/>
                    <p>Cajón 14</p>
                    <p id="cajon14_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon15_img" src="icon-parking.png"/>
                    <p>Cajón 15</p>
                    <p id="cajon15_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon16_img" src="icon-parking.png"/>
                    <p>Cajón 16</p>
                    <p id="cajon16_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon17_img" src="icon-parking.png"/>
                    <p>Cajón 17</p>
                    <p id="cajon17_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon18_img" src="icon-parking.png"/>
                    <p>Cajón 18</p>
                    <p id="cajon18_situacion">Disponible</p>
                </div>                
            </div>
            <div class="fila">
                <div class="cajon">
                    <img id="cajon19_img" src="icon-parking.png"/>
                    <p>Cajón 19</p>
                    <p id="cajon19_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon20_img" src="icon-parking.png"/>
                    <p>Cajón 20</p>
                    <p id="cajon20_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon21_img" src="icon-parking.png"/>
                    <p>Cajón 21</p>
                    <p id="cajon21_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon22_img" src="icon-parking.png"/>
                    <p>Cajón 22</p>
                    <p id="cajon22_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon23_img" src="icon-parking.png"/>
                    <p>Cajón 23</p>
                    <p id="cajon23_situacion">Disponible</p>
                </div>
                <div class="cajon">
                    <img id="cajon24_img" src="icon-parking.png"/>
                    <p>Cajón 24</p>
                    <p id="cajon24_situacion">Disponible</p>
                </div>                
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
    $resguardos = array();
    //echo "<script>alert('');</script>";
    $sql_sentence = "SELECT id, situacion FROM cajones WHERE situacion = 'Ocupado' OR situacion = 'Reservado'";
    $query = $conn->query($sql_sentence);
    if($query){
        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                array_push($resguardos, $row["id"]);
                array_push($resguardos, "'".$row["situacion"]."'");
            }
        }
    }else{
        echo $conn->error;
    }
}
?>

<script>    
    var arregloResguardos = [<?php echo implode(",",$resguardos);?>];
    document.getElementById("ocupacion").innerHTML = "Total de resguardos: "+arregloResguardos.length;
    for(i=0; i<arregloResguardos.length; i+=2){
        if(arregloResguardos[i+1] == "Ocupado"){
            document.getElementById("cajon"+arregloResguardos[i]+"_situacion").innerHTML = "Ocupado";
            document.getElementById("cajon"+arregloResguardos[i]+"_img").style.backgroundColor = "red";
        }else{
            document.getElementById("cajon"+arregloResguardos[i]+"_situacion").innerHTML = "Reservado";
            document.getElementById("cajon"+arregloResguardos[i]+"_img").style.backgroundColor = "orange";
        }
        document.getElementById("cajon"+arregloResguardos[i]+"_img").src = "icon-car.png";
    }
</script>