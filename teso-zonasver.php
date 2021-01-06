 <?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
$linkbd=conectar_bd();
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID- Tesoreria</title>

<script>
function guardar()
{
	var codigo = document.getElementById("codigo").value;
	var nombre = document.getElementById("nombre").value;
	if(codigo != "" && nombre != ""){
		despliegamodalm('visible','4','Esta Seguro de Guardar','1');
	}else{
		despliegamodalm('visible','2','Falta informacion para poder guardar');
	}
}

function funcionmensaje()
{
	var codigo = document.getElementById("codigo").value;
	document.location.href = "teso-zonasver.php?cod="+codigo;
}
	
function respuestaconsulta(pregunta)
{
	switch(pregunta)
	{
		case "1":	document.form2.oculto.value=2;
					document.form2.submit();
					break;
	}
}
	
function despliegamodalm(_valor,_tip,mensa,pregunta)
{
	document.getElementById("bgventanamodalm").style.visibility=_valor;
	if(_valor=="hidden"){document.getElementById('ventanam').src="";}
	else
	{
		switch(_tip)
		{
			case "1":
				document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
			case "2":
				document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
			case "3":
				document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
			case "4":
				document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
		}
	}
}
	
	
function despliegamodal2(_valor,v)
{
	document.getElementById("bgventanamodal2").style.visibility=_valor;
	if(_valor=="hidden"){
		document.getElementById('ventana2').src="";
		document.form2.submit();
	}
	else {
		if(v==1){
			document.getElementById('ventana2').src="registro-ventana02.php?vigencia="+document.form2.vigencia.value;
		}else if(v==2){
			document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=solicita";
		}else if(v==3){
			document.getElementById('ventana2').src="registro-ventana03.php?vigencia="+document.form2.vigencia.value;
		}
		
	}
}
</script>

<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<style>
  #map {
	height: 100%;
  }
 .controls {
	margin-top: 10px;
	border: 1px solid transparent;
	border-radius: 2px 0 0 2px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	height: 32px;
	outline: none;
	box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  }
  #pac-input {
	background-color: #fff;
	font-family: Roboto;
	font-size: 15px;
	font-weight: 300;
	margin-left: 12px;
	padding: 0 11px 0 13px;
	text-overflow: ellipsis;
	width: 300px;
  }
  #pac-input:focus {
	border-color: #4d90fe;
  }
  .pac-container {
	font-family: Roboto;
  }
  #type-selector {
	color: #fff;
	background-color: #4d90fe;
	padding: 5px 11px 0px 11px;
  }
  #type-selector label {
	font-family: Roboto;
	font-size: 13px;
	font-weight: 300;
  }
  #target {
	width: 345px;
  }

</style>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-zonas.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscazonas.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
if(isset($_GET[codigo])){
	$_POST[codigo] = $_GET[codigo];
}
if(!empty($_POST[codigo])){
	$sql="SELECT nombre,descripcion FROM zonas WHERE codigo=$_POST[codigo] ";
	$res = mysql_query($sql,$linkbd);
	while($row = mysql_fetch_row($res)){
		$_POST[nombre] = $row[0];
		$_POST[descripcion] = $row[1];
	}
}

 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$fec=date("d/m/Y");
$_POST[vigencia]=$vigusu;		 		  			 
}
?>
 <form name="form2" method="post" action="teso-zonasver.php">
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Parametrizacion Zonas</td>
        <td width="80" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="10%"  class="saludo1">Codigo: </td>
        <td width="10%" > <input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" style="width:90%" onKeyPress="javascript:return solonumeros(event)" readonly> </td><td width="10%" class="saludo1">Nombre:</td>
        <td width="15%" > <input name="nombre" id="nombre" type="text" value="<?php echo $_POST[nombre]?>" style="width: 90%" /></td> 
		<td width="10%" class="saludo1">Descripcion:</td>
        <td width="35%" ><input name="descripcion" id="descripcion" type="text" value="<?php echo $_POST[descripcion]?>" style="width: 90%" placeholder="*** Opcional" /></td>
       </tr> 
      </table>
	<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]; ?>" />
	 <input id="pac-input" class="controls" type="text" placeholder="Busqueda...">
	 <div id="map"></div>
    </form> 
</table>
<div id="bgventanamodalm" class="bgventanamodalm">
	<div id="ventanamodalm" class="ventanamodalm">
		<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
		</IFRAME>
	</div>
</div>

<?php
if($_POST[oculto] =="2"){
	$sql="UPDATE zonas SET nombre='$_POST[nombre]',descripcion='$_POST[descripcion]' WHERE codigo=$_POST[codigo] ";
	$res = mysql_query($sql,$linkbd);
	if(!$res){
		echo "<script>despliegamodalm('visible','2','Error al actualizar el registro'); </script>";
	}else{
		echo "<script>despliegamodalm('visible','2','Se ha actualizado exitosamente la zona'); </script>";
	}
}

?>
<script>
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 4.624335, lng: -74.063644},
          zoom: 7,
          mapTypeId: 'roadmap'
        });
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });
        var markers = [];
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();
          if (places.length == 0) {
            return;
          }
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));
            if (place.geometry.viewport) {
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbki_Q1GMukzWPCMYh_k_aoar5u56_PNQ&libraries=places&callback=initAutocomplete" async defer></script>
</body>
</html>