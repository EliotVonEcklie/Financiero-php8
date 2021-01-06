<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Ideal - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<?php titlepag();?> 
    </head>
	<style>
	
	</style>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png" /></a> <a class="mgbt"><img src="imagenes/guardad.png" style="width:24px;"/></a> <a class="mgbt"><img src="imagenes/buscad.png"/></a> <a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Clasificadores </td>
        			<td class="cerrar" style="width:7%;" ><a href="ccp-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
					<td style="background-repeat:no-repeat; background-position:center;">
						<ol id="lista2">
							<li onClick="location.href='ccp-ingreso.php'" style="cursor:pointer;">Clasificadores de ingresos CCPET</li>
                            <li onClick="location.href='ccp-gasto.php'" style="cursor:pointer;">Clasificadores de gastos CCPET</li>
							<li onClick="location.href='ccp-producto.php'" style="cursor:pointer;">Clasificador program&aacute;tico de inversi&oacute;n</li>
							<li onClick="location.href='ccp-cuin.php'" style="cursor:pointer;">Clasificador CUIN</li>
							<li onClick="location.href='ccp-fuentes.php'" style="cursor:pointer;">Fuentes</li>
							<li onClick="location.href='ccp-bienestransportables.php'" style="cursor:pointer;">Clasificador Bienes transportables sec. 0-4</li>
              <li onClick="location.href='ccp-servicios.php'" style="cursor:pointer;">Clasificador Servicios sec. 5-9</li> 
              <li onClick="location.href='ccp-generarclasificadores.php'" style="cursor:pointer;">Crear Clasificadores</li> 
              <li onClick="location.href='ccp-programarclasificadores.php'" style="cursor:pointer;">Programar Clasificadores para cuentas de ingresos</li> 
              <li onClick="location.href='ccp-programarclasificadoresgastos.php'" style="cursor:pointer;">Programar Clasificadores para cuentas de gastos</li> 
            </ol>
				</td>                 
				</tr>							
    		</table>
		</form>
	</body>
	<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('�Realmente desea cambiar la vigencia?');
   if(confirma){
    var anobloqueo=bloqueo.split("-");
    var ano=anobloqueo[0];
    if(valor < ano){
      if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
      }else{
        location.reload();
      }

    }else{
      $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
    }
    
   }else{
   	location.reload();
   }
   
 });

 function updateresponse(data){
  json=eval(data);
  if(json[0].respuesta=='2'){
    alert("Vigencia modificada con exito");
  }else if(json[0].respuesta=='3'){
    alert("Error al modificar la vigencia");
  }
  location.reload();
 }
 function selectresponse(data){ 
  json=eval(data);
  $('#cambioVigencia').val(json[0].vigencia);
  bloqueo=json[0].bloqueo;
 }

 }); 
 
</script>
</html>