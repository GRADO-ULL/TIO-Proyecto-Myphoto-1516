 <?php
 require('../../conexion.php');
     $jsondata = array();
     
     $id_imagen = $_POST['id_imagen'];

     $sql = "SELECT * FROM TIO_IMAGENES WHERE id_imagen = $id_imagen";
     $result = mysqli_query($con,$sql) or die('Consulta fallida: ' . mysql_error());
     if($result->num_rows > 0)
     {
            $row = mysqli_fetch_assoc($result);
            $jsondata['ok'] = "ok";
            $jsondata['direccion_imagen'] = $row['direccion_imagen'];
            $jsondata['titulo_imagen'] = $row['titulo_imagen'];
    	    //$jsondata['lugar_imagen'] = $row['lugar_imagen'];
	        $jsondata['autor_imagen'] = $row['usuario'];
            $jsondata['latitud_imagen'] = $row['latitud_imagen'];   
            $jsondata['longitud_imagen'] = $row['longitud_imagen'];   
             
	        $jsondata['descripcion_imagen'] = $row['descripcion_imagen'];
	        $jsondata['tipo_imagen'] = $row['tipo_imagen'];
	        $jsondata['nombre_archivo'] = $row['nombre_archivo'];
	        $jsondata['tam_imagen'] = $row['tam_imagen'];
	        $jsondata['fecha_imagen'] = $row['fecha_imagen'];
	        $jsondata['dispositivo_imagen'] = $row['dispositivo_imagen'];	
            $jsondata['categoria'] = $row['categoria'];                
     }
     else
     {
             $jsondata['direccion_imagen'] = "0 results";
     }
    
    $jsondata['error'] = error_get_last();
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
?>
