<!--V 1.0 24/02/2015-->
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
		<title>:: SPID - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function buscater(e){if (document.form2.documento.value!=""){document.form2.bt.value='1';document.form2.submit();}}
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
function guardar()
{
	if (document.form2.documento.value!=''){if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
  	else{alert('Faltan datos para completar el registro');}
 }

function validar(formulario){document.form2.action="acti-terceros.php";document.form2.submit();}

function cleanForm()
{
	document.form2.nombre1.value="";
	document.form2.nombre2.value="";
	document.form2.apellido1.value="";
	document.form2.apellido2.value="";
	document.form2.documento.value="";
	document.form2.codver.value="";
	document.form2.telefono.value="";
	document.form2.direccion.value="";
	document.form2.email.value="";
	document.form2.web.value="";
	document.form2.celular.value="";
	document.form2.razonsocial.value="";
}
</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
   	<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
    <tr><?php menu_desplegable("acti");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="acti-terceros.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
			<a href="acti-buscaterceros.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
		</td>
	</tr>
</table>
<div id="bgventanamodalm" class="bgventanamodalm">
	<div id="ventanamodalm" class="ventanamodalm">
		<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
		</IFRAME>
	</div>
</div>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center" width="80%" >
      <tr >
        <td class="titulos" colspan="4">.: Agregar Terceros</td><td class="cerrar" ><a href="acti-principal.php">&nbsp;Cerrar</a></td>
      </tr>
	   <tr  >
        <td class="saludo1">.: Tipo Persona:
        </td>
        <td><select name="persona"  onChange="validar()">
		<option value="-1">...</option>
		 <?php
  		   $sqlr="Select * from personas where estado='1'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$linkbd);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
					 if($i==$_POST[persona])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[1]."</option>";	  
					}
  
		  ?>
		</select>
        </td><td class="saludo1">.: Regimen:
        </td>
        <td><select name="regimen" >
		 <?php
  		   $sqlr="Select * from regimen where estado='1' order by id_regimen";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$linkbd);
				    while ($row =mysql_fetch_row($resp)) 
				    {
echo "<option value=$row[0] ";
					$i=$row[0];
					 if($i==$_POST[regimen])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[1]."</option>";	  
					} 
		  ?>
		</select>
        </td></tr>
		   <tr >
        <td class="saludo1">.: Tipo Doc:
        </td>
        <td><select name="tipodoc">
		 <?php
  		   $sqlr="Select docindentidad.id_tipodocid,docindentidad.nombre from  docindentidad, documentopersona where docindentidad.estado='1' and documentopersona.persona=$_POST[persona] and documentopersona.tipodoc=docindentidad.id_tipodocid";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$linkbd);
				    while ($row =mysql_fetch_row($resp)) 
				    {
echo "<option value=$row[0] ";
					$i=$row[0];
					 if($i==$_POST[tipodoc])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[1]."</option>";	  
					}
  
		  ?>
		</select>
        </td><td class="saludo1">.: Documento:
        </td><td><input name="documento" type="text" value="<?php echo $_POST[documento]?>" size="20"  onBlur="buscater(event)" onKeyPress="codigover()"  onKeyUp="return tabular(event,this)">-
          <input name="codver" type="text" id="codver" size="1" maxlength="1" value="<?php echo $_POST[codver]?>" readonly>
        </td>
		   </tr>
		 <tr>
        <td class="saludo1">.: Primer Apellido:
        </td>
        <td><input id="apellido1" name="apellido1" type="text" value="<?php echo $_POST[apellido1]?>" size="40"  onKeyUp="return tabular(event,this)" >
        </td>
         <td class="saludo1">.: Segundo Apellido:
        </td>
        <td><input id="apellido2" name="apellido2" type="text" value="<?php echo $_POST[apellido2]?>" size="40"  onKeyUp="return tabular(event,this)">
        </td>
        </tr>
		<tr>
        <td class="saludo1">.: Primer Nombre:
        </td>
        <td><input id="nombre1" name="nombre1" type="text" value="<?php echo $_POST[nombre1]?>" size="40"  onKeyUp="return tabular(event,this)">
        </td>
		<td class="saludo1">.: Segundo Nombre:
        </td>
        <td><input id="nombre2" name="nombre2" type="text" value="<?php echo $_POST[nombre2]?>" size="40"  onKeyUp="return tabular(event,this)">
        </td>
	  </tr>
	   <tr >
        <td class="saludo1">.: Razon Social:
        </td>
        <td colspan="3"><input name="razonsocial" type="text" value="<?php echo $_POST[razonsocial]?>" size="80" onKeyUp="return tabular(event,this)">
        </td>	</tr>  
	   <tr  >
        <td class="saludo1">.: Direccion:
        </td>
        <td colspan="3"><input name="direccion" type="text" value="<?php echo $_POST[direccion]?>" size="70" onKeyUp="return tabular(event,this)">
        </td>
		</tr>
		<tr>
         <td class="saludo1">.: Telefono:
        </td>
        <td><input name="telefono" type="text" value="<?php echo $_POST[telefono]?>" size="40" onKeyUp="return tabular(event,this)">
        </td>
		 <td class="saludo1">.: Celular:
        </td>
        <td><input name="celular" type="text" value="<?php echo $_POST[celular]?>" size="40" onKeyUp="return tabular(event,this)">
        </td>
       </tr>  
	    <tr  >
        <td class="saludo1">.: E-mail:
        </td>
        <td><input name="email" type="text" value="<?php echo $_POST[email]?>" size="40" onKeyUp="return tabular(event,this)">
        </td>
         <td class="saludo1">.: Pagina Web:
        </td>
        <td><input name="web" type="text" value="<?php echo $_POST[web]?>" size="40" onKeyUp="return tabular(event,this)">
        </td>
       </tr> 
	   <tr>
        <td class="saludo1">:: Dpto :
          </td>
        <td><select name="dpto" id="dpto" onChange="validar()">
                    <option value="-1">:::: Seleccione Departamento :::</option>
            <?php
  		   $sqlr="Select * from danedpto order by nombredpto";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$linkbd);
				    while ($row =mysql_fetch_row($resp)) 
				    {
echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[dpto])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[2]."</option>";	  
					}
  
		  ?>
          </select>
        </td>
        <td class="saludo1">:: Municipio :
          </td>
        <td><select name="mnpio" id="mnpio">
			<option value="-1">:::: Seleccione Municipio ::::</option>
              <?php
  		   $sqlr="Select * from danemnpio where  danemnpio.danedpto=".$_POST[dpto]." order by nom_mnpio";
		  					$resp = mysql_query($sqlr,$linkbd);
				    while ($row =mysql_fetch_row($resp)) 
				    {
echo "<option value=$row[2] ";
					$i=$row[2];
					 if($i==$_POST[mnpio])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[3]."</option>";	  
					}
		?>        
        </select><input name="oculto" type="hidden" value="1">  </td>
      </tr> 
	       <tr  >
        <td class="saludo1">.: Tipo Tercero: 
        </td>
        <td colspan="3" > :: Contribuyente:<input name="contribuyente" type="checkbox" value="1">         
		 :: Proveedor:<input name="proveedor" type="checkbox" value="1">
  		 :: Empleado:<input name="empleado" type="checkbox" value="1">
        </td>    </tr>               
    </table>
    <input type="hidden" value="0" name="bt"/>
<?php
//***** busca tercero
			 	if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[documento]);
			  		if($nresul!='')
			 		{			  
			  			echo"
			  				<script>
								despliegamodalm('visible','2','Tercero ya Existe');
								document.getElementById('valfocus').value='2';
			  				</script>";
			  		}
			 	}	
$valor=$_POST[persona];
switch ($valor) { 
   	case '-1': 
//			alert("cambia");
      	 break ;
   	case '1': 
	//			alert("cambia"+valor);
		?><script>
			document.form2.nombre1.disabled = true;
			document.form2.nombre1.value = "";
			document.form2.nombre2.disabled = true;
			document.form2.nombre2.value = "";
			document.form2.apellido1.disabled = true;
			document.form2.apellido1.value = "";		
			document.form2.apellido2.disabled = true;
			document.form2.apellido2.value = "";		
			document.form2.razonsocial.disabled = false;	
			</script>
		<?php
//ap1.disabled=true;
//ap1.value="true";
      	 break ;
   	case '2': 
			//alert("cambia"+valor);
				?><script>
				document.form2.nombre1.disabled = false;
			document.form2.nombre2.disabled = false;
			document.form2.apellido1.disabled = false;
			document.form2.apellido2.disabled = false;
			document.form2.razonsocial.disabled = true;
			document.form2.razonsocial.value = "";	
			</script>
		<?php	
				//					document.form2.nombre1.disabled = true;
//ap2.disabled=true;
//ap2.value="true";
      	 break ;
   	default: 
      	 //Sentencias a ejecutar si el valor no es ninguno de los anteriores 
} 
?>	
    </form>
  <?php
//$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
if ($_POST[documento]!="")
 {
 $nr="1";
 $mxa=selconsecutivo('terceros','id_tercero');
$sqlr="INSERT INTO terceros (id_tercero,nombre1,nombre2,apellido1,apellido2,razonsocial,direccion,telefono,celular,email,web,tipodoc,cedulanit,codver,depto,mnpio,persona,regimen, contribuyente,proveedor,empleado,estado)VALUES ('$mxa','".utf8_decode($_POST[nombre1])."','".utf8_decode($_POST[nombre2])."','".utf8_decode($_POST[apellido1])."','".utf8_decode($_POST[apellido2])."','".utf8_decode($_POST[razonsocial])."','".utf8_decode($_POST[direccion])."','$_POST[telefono]','$_POST[celular]','$_POST[email]','$_POST[web]',$_POST[tipodoc],'$_POST[documento]','$_POST[codver]','$_POST[dpto]','$_POST[mnpio]',$_POST[persona],$_POST[regimen],'$_POST[contribuyente]','$_POST[proveedor]','$_POST[empleado]','S')";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado con Exito</h2></center></td></tr></table>";
  $_POST[nombre1]="";
  $_POST[nombre2]="";
  $_POST[apellido1]="";
  $_POST[apellido2]="";
  $_POST[documento]="";
  $_POST[codver]="";
  $_POST[razonsocial]="";
  $_POST[direccion]="";
  $_POST[telefono]="";
  $_POST[celular]="";
  $_POST[email]="";
  $_POST[web]="";
  $_POST[oculto]="1";
    ?><script>
cleanForm();
</script><?php
  }
 }
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Tercero</H2></center></td></tr></table>";

 }
}
?>
</body>
</html>