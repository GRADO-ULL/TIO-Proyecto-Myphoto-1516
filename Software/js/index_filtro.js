$(document).ready(function()
{
var latitud;
var longitud;
var myCenter;
var output;
var id_imagen = 69;
var usuario_sesion;
var filtro_categoria;

$("#home_").click(function()
{
$("#seccion_filtro").fadeOut();
setTimeout(function(){location.href="inicio_filtro.php";},350);
});

/*$("#acerca").click(function()
{
location.href="#comunidad_myphoto";
});*/

$("#filtrar").click(function()
{
	location.href="#imagenes";
	$("#mensaje_aviso").css("display","none");
	$("#seccion_filtro").toggle("slow");
	$("#seccion_filtro").attr("class","active");
});

$("#boton_filtro").click(function(event)
{
event.preventDefault();
$("#seccion_filtro").fadeOut();
setTimeout(function(){mostrar_imagenes($("#filtro_buscar").val(),null);},350);
});

$("#mis_fotos").click(function()
{
//	console.log("mis fotos");
//	console.log(usuario_sesion);
	mostrar_imagenes(usuario_sesion,null,null);
});

$("#paisajes").click(function()
{
//console.log("Paisajes");
filtro_categoria = "paisajes";
mostrar_imagenes(null,	filtro_categoria);
});
$("#amigos").click(function()
{
//console.log("amigos");
filtro_categoria = "amigos";
mostrar_imagenes(null,  filtro_categoria);
});
$("#musica").click(function()
{
//console.log("musica");
filtro_categoria = "musica";
mostrar_imagenes(null,  filtro_categoria);
});
$("#familia").click(function()
{
//console.log("familia");
filtro_categoria = "familia";
mostrar_imagenes(null,  filtro_categoria);
});
$("#viajes").click(function()
{
//console.log("viajes");
filtro_categoria = "viajes";
mostrar_imagenes(null,  filtro_categoria);
});
$("#encuentros").click(function()
{
//console.log("encuentros");
filtro_categoria = "encuentros";
mostrar_imagenes(null,  filtro_categoria);
});
$("#otras_categorias").click(function()
{
//console.log("Otras categorias");
//filtro_categoria = "paisajes";
mostrar_imagenes(null,  null);
});

$("#lupa").click(function()
{
	$("#lupa_busqueda").toggle("slow");
	$("#lupa_busqueda").change(function()
	{
		mostrar_imagenes(null,null,$("#lupa_busqueda").val());
	});
});
$.ajax({
url:"php/descarga_inicial.php"
})
.done(function(data,textStatus,errorThrown)
{
//console.log("Numero de categorias disponibles->"+data.num_categorias);
//console.log("Usuario actual->"+data.usuario_actual);


$("#bienvenida_usuario").html("Hola " + data.user);
$("#numero_cliente").html(data.numero_cliente);
$("#numero_fotos").html(data.numero_fotos);
$("#numero_loc").html(data.numero_loc);
usuario_sesion = data.user;
console.log("Usuario_sesion->"+usuario_sesion);
//Perfil
$("#user_perfil").val(data.user_perfil);
$("#nombre_perfil").val(data.nombre_perfil);
$("#apellidos_perfil").val(data.apellidos_perfil);
$("#email_perfil").val(data.email_perfil);
$("#password_perfil").val(data.password_perfil);
$("#descripcion_perfil").val(data.descripcion_perfil);

//Subir_imagen
$("#author").val(data.user_perfil);

//Mostramos las categorias disponibles
})
.fail(function(jqXHR,textStatus,errorThrown)
{
console.log("Fallo");
});


setTimeout(function()
{
$("#flecha_control").fadeIn("slow");
},1200);

$("#salir").click(function()
{
	$.ajax({
	   url: "php/logout.php"
	})
	.done(function(data,textStatus,jqXHR)
	{
	    //console.log("Salir");
            setTimeout(function(){location.href="inicio_sesion/index.php";},500);
	})
	.fail(function(jqXHR,textStatus,errorThrown)
	{
	
	});
});

$(":radio").click(function()
{
	$(this).css("border-color","red");
});


$("#subir_imagen").click(function()
{
	var palabra_clave = $(":checked").val();
  if(palabra_clave == null)
	{
		console.log("palabra_clave");
		var palabra_clave = $("#otra_categoria").val();
	}
        var inputFileImage = document.getElementById("archivoImage");
        var file = inputFileImage.files[0];
        var data = new FormData();
        data.append('archivo',file);
        var url = "php/subir_imagen.php";
        $.ajax({
                url:url,
                type:"POST",
                contentType: false,
                data: data,
                processData: false,
                cache: false
            })
            .done(function(data,textStatus,jqXHR)
            {
                console.log("Conexion->"+data.conexion);
                console.log("Nombre archivo->"+data.nombre_archivo);
                console.log("Tipo de archivo->"+data.tipo_archivo);
                console.log("Tamano archivo->"+data.tamano_archivo);
                console.log("Temporal archivo->"+data.tmp_archivo);
                console.log("Success-> "+data.subida_directorio);
                console.log("Latitud-> "+data.latitud);
                console.log("Longitud-> "+data.longitud);
                console.log("Tamanio->"+data.tam_imagen);
                console.log("Imagen-> "+data.v_imagen);
                console.log("Metadatos-> "+data.metadatos);
                console.log("Insercion en BD-> "+data.insercion_bd);
                console.log("Id imagen-> "+data.id_imagen);
                console.log("Archivo existe-> "+data.archivo_existe);
                console.log("Mensaje_respuesta-> "+data.mensaje_respuesta);
                console.log("Error-> "+data.error);
                console.log("Data-success->"+data.success);
                console.log("Data-resultado->"+data.resultado);
                console.log("Data-error->"+data.error);
                console.log("Latitud->"+data.latitud);
                console.log("Longitud->"+data.longitud);
                console.log("Tam->"+data.tam_imagen);
                id_imagen = data.id_imagen;
                console.log("Subida->"+data.archivo_existe);
                var mensaje = data.mensaje_respuesta_subir;
                $("#mensaje_respuesta_subir").html("<h4>"+data.mensaje_respuesta_subir+"</h4>");
		            if(data.mensaje_respuesta_subir != "La imagen ya se ha subido al servidor antes" && data.mensaje_respuesta_subir != "La imagen seleccionada no contiene metadatos de geolocalizacion" && data.mensaje_respuesta_subir != "La imagen no se ha subido correctamente")
                {
                    //Actualizamos los campos autor,titulo y detalles de la imagen introducida
                    
                          var titulo_imagen = $("#title").val();
                          var autor_imagen = $("#author").val();
                          var detalles_imagen = $("#description").val();
                          var parametros_imagen_subida = "id_imagen="+id_imagen+"&titulo_imagen="+titulo_imagen+"&autor_imagen="+autor_imagen+"&detalles_imagen="+detalles_imagen+"&palabra_clave="+palabra_clave;  
                    //console.log(parametros_imagen_subida);
                          $.ajax({
                                  data: parametros_imagen_subida,
                                  type: "POST",
                                  url: "php/subir_imagen1.php"
                          })
                          .done(function(data,textStatus,jqXHR)
                          {
                                  console.log("Datos->"+data.success);
                                  var imagen = data.imagen;
                                  $("#mensaje_respuesta_subida").html(data.respuesta);
                                  $.ajax({
                                            data: "id_imagen="+imagen,
                                            type: "POST",
                                            url: "php/descarga_imagenes.php"
                                  })//cierre ajax
                                  .done(function(data,textStatus,jqXHR)
                                  {
                                          console.log("Cargando datos->"+data.ok);
                                          console.log("Error->"+data.error);
                                         $("#titulo_imagen").html(data.titulo_imagen);
                                          $("#autor_imagen").html(data.autor_imagen);
                                          $("#latitud_imagen").html(data.latitud_imagen);
                                          $("#longitud_imagen").html(data.longitud_imagen);
                                          $("#descripcion_imagen").html(data.descripcion_imagen);
                                          $("#lugar_imagen").html(data.lugar_imagen);
                                          $("#tipo_imagen").html(data.tipo_imagen);
                                          $("#nombre_imagen").html(data.nombre_archivo);
                                          $("#tam_imagen").html(data.tam_imagen);
                                          $("#fecha_imagen").html(data.fecha_imagen);
                                          $("#dispositivo_imagen").html(data.dispositivo_imagen);

                                          //Perfil
                                          $("#user_perfil").val(data.user_perfil);
                                          $("#nombre_perfil").val(data.nombre_perfil);
                                          $("#apellidos_perfil").val(data.apellidos_perfil);
                                          $("#email_perfil").val(data.email_perfil);
                                          $("#password_perfil").val(data.password_perfil);
                                          $("#descripcion_perfil").val(data.descripcion_perfil);

                                          //Subir_imagen
                                          $("#author").val(data.user_perfil);   

                                          var latitud = data.latitud_imagen;
                                          var longitud = data.longitud_imagen;
                                          console.log("Latitud->"+latitud);
                                          console.log("Longitud->"+longitud);
                                          myCenter=new google.maps.LatLng(latitud,longitud);

                                          google.maps.event.addDomListener(window, 'load', initialize());
                                          setTimeout(function()
                                          {
                                              var categoria = data.categoria;
                                              mostrar_imagenes(null,categoria);
                                            //$("#about").show();
                                              location.href="#works";
                                          },1750);
                
                                  })//cierre del done
                                  .fail(function(jqXHR,textStatus,errorThrown)
                                  {
                                          console.log("no entre");
                                      if (jqXHR.status === 0) {
                                            console.log('Not connected.\nPlease verify your network connection.');
                                      }else if (jqXHR.status == 404) {
                                            console.log('The requested page not found. [404]');
                                      }else if (jqXHR.status == 500) {
                                            console.log('Internal Server Error [500].');
                                      }else if (jqXHR === 'parsererror') {
                                            console.log('Requested JSON parse failed.');
                                      }else if (jqXHR === 'timeout') {
                                            console.log('Time out error.');
                                      }else if (jqXHR === 'abort') {
                                            console.log('Ajax request aborted.');
                                      }else{
                                            console.log('Uncaught Error.\n' + jqXHR.responseText);
                                      }
                                  });//cierre del fail
                          })
                          .fail(function(jqXHR,textStatus,errorThrown)
                          {
                                   console.log("Entre en el fail . . . . . . . . .");
                                   if (jqXHR.status === 0) {
                                   console.log('Not connected.\nPlease verify your network connection.');
                                   }else if (jqXHR.status == 404) {
                                   console.log('The requested page not found. [404]');
                                   }else if (jqXHR.status == 500) {
                                   console.log('Internal Server Error [500].');
                                   }else if (jqXHR === 'parsererror') {
                                   console.log('Requested JSON parse failed.');
                                   }else if (jqXHR === 'timeout') {
                                   console.log('Time out error.');
                                   }else if (jqXHR === 'abort') {
                                   console.log('Ajax request aborted.');
                                   }else{
                                   console.log('Uncaught Error.\n' + jqXHR.responseText);
                                   }

                          });//Cierre del fail
                }
		        })
            .fail(function(jqXHR,textStatus,errorThrown)
            {
                   console.log("Entre en el fail");
                   if (jqXHR.status === 0) {
                   console.log('Not connected.\nPlease verify your network connection.');
                   }else if (jqXHR.status == 404) {
                   console.log('The requested page not found. [404]');
                   }else if (jqXHR.status == 500) {
                   console.log('Internal Server Error [500].');
                   }else if (jqXHR === 'parsererror') {
                   console.log('Requested JSON parse failed.');
                   }else if (jqXHR === 'timeout') {
                   console.log('Time out error.');
                   }else if (jqXHR === 'abort') {
                   console.log('Ajax request aborted.');
                   }else{
                   console.log('Uncaught Error.\n' + jqXHR.responseText);
                   }
            }); 
});

$("#actualizar_perfil").click(function()
{
       var parametros_perfil = "user="+$("#usuario_perfil").val()+"&apellidos_perfil="+$("#apellidos_perfil").val()+"&nombre_perfil="+$("#nombre_perfil").val()+"&password_perfil="+$("#password_perfil").val()+"&email_perfil="+$("#email_perfil").val()+"&detalles_perfil="+$("#descripcion_perfil").val();
//       console.log(parametros_perfil);
       $.ajax({
           data: parametros_perfil,
           type: "POST",
           url: "php/actualizar_perfil.php"
       })
       .done(function(data,textStatus,jqXHR)
       {
        console.log("Usuario->"+data.usuario);
		$("#mensaje_actualizar_perfil").html("<h4>"+data.success+"</h4>");
       })
       .fail(function(jqXHR,textStatus,errorThrown)
	{
		console.log("No funciona ni pa atras");
	});
});

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:17,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);
}

function mostrar_imagenes(filtro_usuario,filtro_categoria,filtro_general)
{
//console.log("Entr en funcion");
var id_minimo;
var id_maximo;
var datos;
var url_;
if(filtro_usuario != null)
{
	datos = "buscando="+filtro_usuario;
	url_ = "php/filtro.php";
}else
{
	if(filtro_categoria != null)
	{
		datos = "buscando="+filtro_categoria;
		url_ = "php/filtro_categoria.php";
	}
	else
	{
		if(filtro_general != null)
		{
			//console.log("fILTRO GENERAL");
		        datos = "buscando="+filtro_general;
		        url_  = "php/filtro_general.php";
		}
		else
		{
      console.log("cweniocnio");
			datos = "";
			url_ = "php/descarga_inicial.php";
		}
	}
}

console.log("Datos->"+datos);
console.log("Url->"+url_);
$.ajax({
data: datos,
type: "POST",
url: url_
})
.done(function(data,textStatus,jqXHR)
{

id_minimo = data.id_minimo;
id_maximo = data.id_maximo;
console.log("Id minimo->"+id_minimo);
console.log("Id maximo->"+id_maximo);
$("#imagenes").fadeOut();

setTimeout(
function()
{
//$("#works").html(" ");
$("#imagenes").html(" ");
console.log("Resultados->"+data.resultados);
console.log("Probando->"+data.probando);
console.log("Mensaje_respuesta->"+data.mensaje_respuesta);

if(data.resultados != 0)
{
	$("#mensaje_aviso").css("display","none");
	location.href="#imagenes";
        var salida = "<div id="+"works"+">";
        //output = "<div id="+"works>";
        $.each(data.imagenes,function(key,value)
        {
  //              console.log("Entro");
                salida += "<figure style="+"background:"+"black;border-style:solid;border-color:white;border-width:2px;"+" class="+"effect-oscar  wowload fadeInUp"+"><center><img height=450px src="+value.direccion_imagen+" alt=No puede encontrarse la imagen/></center><figcaption><h2 id="+"etiqueta"+">"+value.categoria+"</h2><p>"+value.titulo_imagen+"<br><a  href="+value.direccion_imagen+" title="+value.titulo_imagen+" data-gallery>Ver</a><a id="+value.id_imagen+" href=#about>Info foto</a></p></figcaption></figure>";
        })
        salida += "</div>";
  //      console.log(salida); 
//        $("#works").html(salida);
        $("#imagenes").html(salida);
        $("#imagenes").fadeIn();
        $("#works").attr("class", "clearfix grid");
}
else
{
//	console.log(data.mensaje_respuesta);
	$("#mensaje_aviso").fadeIn();
	$("#mensaje_aviso").html("<h3 style="+"text-align:center;margin-top:150px;>"+data.mensaje_respuesta+"</h3>");
}
for(i=id_minimo;i<=id_maximo;i++)
{
        $("#"+i).click(function()
        {
                console.log("he pulsado el "+i);
                //console.log("Caracteristicas de la imagen:"+this.id);
                var id_imagen = this.id;
                $("#about").fadeIn();
        //Mapa
        //      crear_mapa(latitud,longitud);
        $.ajax({
                data: "id_imagen="+id_imagen,
                type: "POST",
                url: "php/descarga_imagenes.php"
        })
        .done(function(data,textStatus,jqXHR){
                console.log("Cargando datos->"+data.ok);
                console.log("Error->"+data.error);
               $("#titulo_imagen").html("Titulo: "+data.titulo_imagen);
                $("#autor_imagen").html(data.autor_imagen);
                $("#latitud_imagen").html(data.latitud_imagen);
                $("#longitud_imagen").html(data.longitud_imagen);
                $("#descripcion_imagen").html("Descripción : "+data.descripcion_imagen);
                $("#lugar_imagen").html(data.lugar_imagen);
                $("#tipo_imagen").html(data.tipo_imagen);
                $("#nombre_imagen").html(data.nombre_archivo);
                $("#tam_imagen").html(data.tam_imagen);
                $("#fecha_imagen").html(data.fecha_imagen);
                $("#dispositivo_imagen").html(data.dispositivo_imagen);

		//Perfil
		$("#user_perfil").val(data.user_perfil);
		$("#nombre_perfil").val(data.nombre_perfil);
		$("#apellidos_perfil").val(data.apellidos_perfil);
		$("#email_perfil").val(data.email_perfil);
		$("#password_perfil").val(data.password_perfil);
		$("#descripcion_perfil").val(data.descripcion_perfil);

		//Subir_imagen
		$("#author").val(data.user_perfil);

                latitud = data.latitud_imagen;
                longitud = data.longitud_imagen;
                myCenter=new google.maps.LatLng(latitud,longitud);

                google.maps.event.addDomListener(window, 'load', initialize());

        })
        .fail(function(jqXHR,textStatus,errorThrown)
        {
                console.log("no entre");
            if (jqXHR.status === 0) {
                  console.log('Not connected.\nPlease verify your network connection.');
            }else if (jqXHR.status == 404) {
                  console.log('The requested page not found. [404]');
            }else if (jqXHR.status == 500) {
                  console.log('Internal Server Error [500].');
            }else if (jqXHR === 'parsererror') {
                  console.log('Requested JSON parse failed.');
            }else if (jqXHR === 'timeout') {
                  console.log('Time out error.');
            }else if (jqXHR === 'abort') {
                  console.log('Ajax request aborted.');
            }else{
                  console.log('Uncaught Error.\n' + jqXHR.responseText);
            }
        });
	});
}
},300);
})
.fail(function(jqXHR,textStatus,errorThrown)
{
   console.log("no entre1");
            if (jqXHR.status === 0) {
                  console.log('Not connected.\nPlease verify your network connection.');
            }else if (jqXHR.status == 404) {
                  console.log('The requested page not found. [404]');
            }else if (jqXHR.status == 500) {
                  console.log('Internal Server Error [500].');
            }else if (jqXHR === 'parsererror') {
                  console.log('Requested JSON parse failed.');
            }else if (jqXHR === 'timeout') {
                  console.log('Time out error.');
            }else if (jqXHR === 'abort') {
                  console.log('Ajax request aborted.');
            }else{
                  console.log('Uncaught Error.\n' + jqXHR.responseText);
            }
});

//}//FIN DEL IF

}//Fin función 
//Control de la aparición de los elementos
$("#perfil").click(function(e)
{
	e.preventDefault();
	$("#editlog").fadeIn();
        location.href = "#editlog";
});


});
