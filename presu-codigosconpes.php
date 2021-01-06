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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.submit();
}
function agregardetalle()
{
if(document.form2.valor.value!="" &&  document.form2.concecont.value!="")
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.vavlue=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
 else{
  alert('Faltan datos para completar el registro');
  	document.form2.codigo.focus();
  	document.form2.codigo.select();
  }
 }
</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a href="presu-codigosconpes.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="presu-buscacodigosconpes.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>		  
        </table>
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[tipo]='S';
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;	
		  $sqlr="select  MAX(RIGHT(codigo,2)) from presuingresoconpes  order by codigo Desc";
		 //echo $sqlr;
		  $res=mysql_query($sqlr,$linkbd);
		  $row=mysql_fetch_row($res);
		  $_POST[codigo]=$row[0]+1;
		  if(strlen($_POST[codigo])==1)
		   {
			   $_POST[codigo]='0'.$_POST[codigo];
			}	 
}
?>

 <form name="form2" method="post" action="">
 <?php //**** busca cuenta
  			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],1);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 
			 ?>
 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">.: Agregar Ingresos</td><td width="112" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td width="90" class="saludo1">Codigo:        </td>
        <td width="180"><input name="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        </td>
        <td width="147" class="saludo1">Nombre Ingreso:        </td>
        <td width="644"><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80" onKeyUp="return tabular(event,this)">   <input name="oculto" type="hidden" value="1">     </td>       
       </tr> 
      </table>
	   <table class="inicio">
	   <tr><td colspan="4" class="titulos">Agregar Detalle Ingreso</td></tr>                  
	  <tr>
	  <td class="saludo1">Conceptos contables Compes:</td><td><select name="concecont" id="concecont" >
				  <option value="-1">Seleccione ....</option>
					<?php
					 $sqlr="select *from conceptoscontables where conceptoscontables.tipo='CP' and conceptoscontables.modulo='3' ".$crit1." order by conceptoscontables.codigo";
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[concecont])
			 	{
				 echo "SELECTED";
				 $_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
				 }
				echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     }			
				?>
				  </select><input id="concecontnom" name="concecontnom" type="hidden" value="<?php echo $_POST[concecontnom]?>" ></td></tr>        	
    </table>		
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
 $nr="1";
 $sqlr="INSERT INTO presuingresoconpes (codigo,nombre,tipo,estado)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."','$_POST[tipo]' ,'S')";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png' > Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  else
  {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el  Codigo Conpes con Exito <img src='imagenes/confirm.png' ></center></td></tr></table>";
		//******
		$_POST[valor]=100;
		$sqlr="INSERT INTO presuingresoconpes_det (codigo,concepto,modulo,tipoconce,cuentapres,estado,vigencia)VALUES ('$_POST[codigo]','$_POST[concecont]','4', 'S', '$_POST[cuenta]','S',$vigusu)";
 		//echo "sqlr:".$sqlr;
  		if (!mysql_query($sqlr,$linkbd))
  		{
		echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png' > Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
		}
 		 else
  			{
 			 echo "<table class='inicio'><tr><td class='saludo1'><center> Se ha almacenado el Detalle del  Codigo Conpes con Exito <img src='imagenes/confirm.png' ></center></td></tr></table>";
		//****
	  	 	}
  	  }		
 }
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Falta informacion para Crear el Codigo Conpes <img src='imagenes/confirm.png' ></center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
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
</body>
</html>