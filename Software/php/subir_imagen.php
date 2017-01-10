<?php
require('../../conexion.php');
session_start();
    
    $jsondata = array();
    $jsondata['conexion'] = "Conexion exitosa";
    $jsondata['nombre_archivo'] =  $_FILES["archivo"]["name"];
    $jsondata['tipo_archivo'] = $_FILES["archivo"]["type"];
    $jsondata['tamano_archivo'] = $_FILES["archivo"]["size"];
    $jsondata['tmp_archivo'] = $_FILES["archivo"]["tmp_name"];
    //$jsondata['archivador'] = $upload_folder . $nombre_archivo;

    $target_path = "../images/";
    $target_path = $target_path . basename( $_FILES['archivo']['name']); 

            $archivador = "./images/".$jsondata['nombre_archivo'];
            //$v_imagen = $target_path.$_FILES['archivo']['name'];
            $v_imagen = "../images/".$jsondata['nombre_archivo'];
            $jsondata['v_imagen'] = $v_imagen;   
        /*// Generar thumbnail.    -->>> MINIATURA DE IMAGEN
        $v_ancho_imagen = 1234;
        $v_alto_imagen = 800;
        $v_tipo_imagen = 'jpg';
        $v_thumbnail = exif_thumbnail($v_imagen, $v_ancho_imagen, $v_alto_imagen, $v_tipo_imagen);
        */
        if(file_exists($v_imagen))
        {
            $existe = true;
        }
        else
        {
            $existe = false;
        }

    if($existe == false)
    {
        if(move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)) { 
                $jsondata['subida_directorio'] = "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
        }else
        {
            $jsondata['subida_directorio'] = "El archivo no se ha subido";
        }

            //$v_exif = exif_read_data($v_imagen);
                if((($v_exif = exif_read_data($v_imagen))!= null) and (isset($v_exif["GPSLongitude"])) and (isset($v_exif["GPSLongitudeRef"])) and (isset($v_exif["GPSLatitude"])) and (isset($v_exif["GPSLatitudeRef"])))
                {
                        $jsondata['metadatos'] = true;
                        $v_longitud = getGps($v_exif["GPSLongitude"], $v_exif['GPSLongitudeRef']);

                        $v_latitud = getGps($v_exif["GPSLatitude"], $v_exif['GPSLatitudeRef']);
                        $v_tamanio = $v_exif["FileSize"];
                        /*if(isset($v_exif["Camera Model Name"]))
                        {
                            $v_dispositivo = $v_exif["Camera Model Name"];
                        }*/
                        //Capturando el tipo de dispositivo que ha tomando la imagen
                        $v_dispositivo = $v_exif["Make"];
                        //Capturando la fecha en la que se ha tomado la imagen
                        $v_datetime = $v_exif["DateTime"];
                        //Capturando el tipo de la imagen
                        $v_tipoimagen = $v_exif["MimeType"];
                        //Capturando el nombre del archivo
                        $v_nombrearchivo =$v_exif["FileName"];
                        $jsondata['latitud'] = "La latitud de la imagen es: " . $v_latitud;
                        $jsondata['longitud'] = "La longitud de la imagen es: " . $v_longitud;
                        $jsondata['tam_imagen'] = $v_exif["FileSize"];
                                            
                        $query = "INSERT INTO tio_imagenes(direccion_imagen,latitud_imagen,longitud_imagen,tam_imagen,dispositivo_imagen,fecha_imagen,tipo_imagen,nombre_archivo) VALUES('$archivador',$v_latitud,$v_longitud,$v_tamanio,'$v_dispositivo','$v_datetime','$v_tipoimagen','$v_nombrearchivo')";

                        $result = mysqli_query($con,$query) or die('Consulta fallida: ' . mysql_error());
                        
                        if($result != null)
                        {
                            $jsondata['insercion_bd'] = true;
                            $query1 = "SELECT id_imagen from tio_imagenes where direccion_imagen like '$archivador' and latitud_imagen = $v_latitud and longitud_imagen = $v_longitud and tam_imagen = $v_tamanio and dispositivo_imagen = '$v_dispositivo' and fecha_imagen = '$v_datetime' and tipo_imagen like '$v_tipoimagen' and nombre_archivo like '$v_nombrearchivo'";
                            
                            $result1 = mysqli_query($con,$query1) or die('Consulta fallida: ' . mysql_error());
                            
                            $num_rows = $result1->num_rows;
                            
                            if($num_rows > 0)
                            {
                                $jsondata['mensaje_respuesta_subir'] = "La imagen se ha subido correctamente";
                                $row = mysqli_fetch_assoc($result1);
                                $jsondata['id_imagen'] = $row['id_imagen'];
                            }
                            else
                            {
                                $jsondata['mensaje_respuesta_subir'] = "La imagen no se ha subido correctamente";
                                $jsondata['id_imagen'] = -1.0;
                            }
                        }
                        else
                        {
                            $jsondata['mensaje_respuesta_subir'] = "La imagen no se ha subido correctamente";
                            $jsondata['insercion_bd'] = false;
                            $jsondata['id_imagen'] = -1;
                        }
                }
                else
                {
                    $jsondata['metadatos'] = false;
                    $jsondata["mensaje_respuesta_subir"] = "La imagen seleccionada no contiene metadatos de geolocalizacion";
                }        

    }
    else
    {
        $jsondata['mensaje_respuesta_subir'] = "La imagen ya se ha subido al servidor antes";
    }
        
        //$query = "INSERT INTO `tio_imagenes` (`latitud_imagen`, `longitud_imagen`, `direccion_imagen`, `tipo_imagen`, `nombre_archivo`, `tam_imagen`, `fecha_imagen`, `dispositivo_imagen`, `flash`) VALUES ('$v_latitud', '$v_longitud', '$archivador', '$v_tipoimagen', '$v_tamanio', '$v_datetime', '$v_dispositivo', '$v_flash')";

  //  if ($con->query($query) === TRUE) {
  //         $jsondata['success'] = "El archivo se ha subido correctamente al servidor";
  //  } else {
  //      $jsondata['success'] = "Error al subir archivo: " . $con->error;   
  //  }

            function getGps($exifCoord, $hemi){
                $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
                $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
                $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;

                $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
                return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
            }

            function gps2Num($coordPart) {
                $parts = explode('/', $coordPart);
                if(count($parts) <= 0){
                    return 0;
                }
                if (count($parts) == 1){
                    return $parts[0];
                }
                return floatval($parts[0]) / floatval($parts[1]);
            }

    
    //NO RULA CON IMÁGENES PNG
    /*if(!move_uploaded_file($tmp_archivo,$archivador))
    {
        $jsondata['success'] = "No se ha producido la subida al servidor con normalidad";
    }else{
        $jsondata['success'] = "El archivo ".$nombre_archivo." se ha subido al servidor";
    }*/
    
    //$query1 = "SELECT id_imagen FROM TIO_IMAGENES WHERE id_imagen >= ALL(SELECT id_imagen from TIO_IMAGENES)";
    //$query1 = "SELECT * FROM TIO_IMAGENES WHERE  nombre_archivo like '$v_nombrearchivo'");
    /*
    $query1 = "select id_imagen  from tio_imagenes where nombre_archivo like '$v_nombrearchivo' AND dispositivo_imagen like '$v_dispositivo' AND tam_imagen = $v_tamanio";
    $result = $con->query($query1);
    
    if ($result->num_rows > 0) {
    // output data of each row
        $row = $result->fetch_assoc();
        $jsondata['id_imagen'] = $row['id_imagen'];
    } else {
        $jsondata['resultado'] = "0 results";
    }
    */
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
?>