<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
<script>
			function guardar()
			{
				var validacion01=document.getElementById('apellido1').value;
				var validacion02=document.getElementById('nombre1').value;
				var validacion03=document.getElementById('razonsocial').value;
				var validacion04=document.getElementById('direccion').value;
				var validacion05=document.getElementById('telefono').value;
				var validacion06=document.getElementById('celular').value;
				var validacion07=document.getElementById('email').value;
				if (document.getElementById('persona').value!='' && document.getElementById('regimen').value!='' && document.getElementById('tipodoc').value!='' && document.getElementById('documento').value!='' && ((validacion01.trim()!='' && validacion02.trim()!='') || validacion03.trim()!='') &&  ((validacion04.trim()!='' && (validacion05.trim()!='' || validacion06.trim()!='') && validacion06.trim()!='' && document.getElementById('dpto').value!='-1' && document.getElementById('mnpio').value != '-1' && (document.getElementById('contribuyente').checked || document.getElementById('proveedor').checked || document.getElementById('empleado').checked))||document.getElementById('particular').checked))
				{despliegamodalm('visible','4','Esta Seguro de Modificar los datos del Tercero','1');}
			  	else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			 }
 
			function validar(formulario){document.form2.submit();}
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}

function validar(formulario){
	document.getElementById('oculto').value='7';
	document.form2.submit();
}

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

		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				document.getElementById('oculto').value='1';
				document.getElementById('idtercero').value=next;
				var idcta=document.getElementById('idtercero').value;
				document.form2.action="acti-editaterceros.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&vbusq="+filtro;
				document.form2.submit();
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				document.getElementById('oculto').value='1';
				document.getElementById('idtercero').value=prev;
				var idcta=document.getElementById('idtercero').value;
				document.form2.action="acti-editaterceros.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&vbusq="+filtro;
				document.form2.submit();
			}

			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('idtercero').value;
				location.href="acti-buscaterceros.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
 <table>
   	<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
    <tr><?php menu_desplegable("acti");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="acti-terceros.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
			<a href="acti-buscaterceros.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
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
 <?php
			if ($_GET[idter]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idter];</script>";}
			$sqlr="select * from  terceros ORDER BY id_tercero DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idter]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from terceros where id_tercero='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from terceros where id_tercero ='$_GET[idter]'";
					}
				}
				else{
					$sqlr="select * from terceros ORDER BY id_tercero DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[idtercero]=$row[0];
			}

if(($_POST[oculto]!="2")&&($_POST[oculto]!="7")){	
   $linkbd=conectar_bd();
   $sqlr="select *from terceros where id_tercero=$_POST[idtercero]";
   $resp = mysql_query($sqlr,$linkbd);
   while($row =mysql_fetch_row($resp))
    {
	 $_POST[idtercero]=$row[0];
	 $_POST[nombre1]=$row[1];
	 $_POST[nombre2]=$row[2];
	 $_POST[apellido1]=$row[3];
	 $_POST[apellido2]=$row[4];	 	 
	 $_POST[razonsocial]=$row[5];	 	 	 
	 $_POST[direccion]=$row[6];	 	 
 	 $_POST[telefono]=$row[7];	 	 	 
	 $_POST[celular]=$row[8];	 	 	 
	 $_POST[email]=$row[9];	 	 	 
	 $_POST[web]=$row[10];	 	 	 
	 $_POST[tipodoc]=$row[11];	 	 
	 $_POST[documento]=$row[12];	 	 
	 $_POST[codver]=$row[13];	 	 
	 $_POST[dpto]=$row[14];	 	 	 	 	 	 
	 $_POST[mnpio]=$row[15];	 	 	 	 	 	 	 
	 $_POST[persona]=$row[16];	 	 	 	 	 	 	 
	 $_POST[regimen]=$row[17];	 	 	 	 	 	 	 
	 $_POST[contribuyente]=$row[18];	 	 	 	 	 	 	 
	 $_POST[proveedor]=$row[19];	 	 	 	 	 	 	 	 	 	 	 
	 $_POST[empleado]=$row[20];
	 $_POST[estado]=$row[21];	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 
	}
  }
 
			//NEXT
			if($_POST[apellido1]!=""){
				$sqln="select *from terceros where apellido1 > '$_POST[apellido1]' ORDER BY apellido1 ASC LIMIT 1";
				$resn=mysql_query($sqln,$linkbd);
				$row=mysql_fetch_row($resn);
				$next=$row[0];
			}
			else{
				$sqln="select *from terceros where razonsocial > '$_POST[razonsocial]' ORDER BY razonsocial ASC LIMIT 1";
				$resn=mysql_query($sqln,$linkbd);
				$row=mysql_fetch_row($resn);
				$next=$row[0];
			}
			//PREV
			if($_POST[apellido1]!=""){
				$sqlp="select *from terceros where apellido1 < '$_POST[apellido1]' ORDER BY  apellido1 DESC LIMIT 1";
				$resp=mysql_query($sqlp,$linkbd);
				$row=mysql_fetch_row($resp);
				$prev=$row[0];
			}
			else{
				$sqlp="select *from terceros where razonsocial < '$_POST[razonsocial]' ORDER BY  razonsocial DESC LIMIT 1";
				$resp=mysql_query($sqlp,$linkbd);
				$row=mysql_fetch_row($resp);
				$prev=$row[0];
			}
 ?>
    <table class="inicio" align="center" width="80%" >
      <tr >
        <td class="titulos" colspan="4" style='width:93%'>.: Editar Terceros</td><td class="cerrar" style='width:7%'><a href="acti-principal.php">Cerrar</a></td>
      </tr>
	   <tr  >
        <td class="saludo1">.: Tipo Persona:        </td>
        <td><select name="persona"  onChange="validar()">
		<option value="-1">...</option>
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from personas where estado='1'";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
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
		</select>        </td><td class="saludo1">.: Regimen:
        </td>
        <td><select name="regimen" >
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from regimen where estado='1' order by id_regimen";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
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
		</select>        </td></tr>
		   <tr >
        <td class="saludo1">.: Tipo Doc:        </td>
        <td><select name="tipodoc">
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select docindentidad.id_tipodocid,docindentidad.nombre from  docindentidad, documentopersona where docindentidad.estado='1' and documentopersona.persona=$_POST[persona] and documentopersona.tipodoc=docindentidad.id_tipodocid";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
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
		</select>        </td><td class="saludo1">.: Documento:
        </td>
        <td>
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                    	<input type="text" name="documento" id="documento"  onBlur="codigover()"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[documento]?>" style="width:50%" readonly/>&nbsp;-&nbsp;<input type="text" name="codver"  id="codver" size="1" maxlength="1" value="<?php echo $_POST[codver]?>" readonly/>
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
        </td>
		   </tr>
		 <tr>
        <td class="saludo1">.: Primer Apellido:        </td>
        <td><input id="apellido1" name="apellido1" type="text" value="<?php echo $_POST[apellido1]?>" size="40"  onKeyUp="return tabular(event,this)" >        </td>
         <td class="saludo1">.: Segundo Apellido:        </td>
        <td><input id="apellido2" name="apellido2" type="text" value="<?php echo $_POST[apellido2]?>" size="40"  onKeyUp="return tabular(event,this)">        </td>
        </tr>
		<tr>
        <td class="saludo1">.: Primer Nombre:        </td>
        <td><input id="nombre1" name="nombre1" type="text" value="<?php echo $_POST[nombre1]?>" size="40"  onKeyUp="return tabular(event,this)">        </td>
		<td class="saludo1">.: Segundo Nombre:        </td>
        <td><input id="nombre2" name="nombre2" type="text" value="<?php echo $_POST[nombre2]?>" size="40"  onKeyUp="return tabular(event,this)">        </td>
	  </tr>
	   <tr >
        <td class="saludo1">.: Razon Social:        </td>
        <td colspan="3"><input name="razonsocial" type="text" value="<?php echo $_POST[razonsocial]?>" style="width:85%;" onKeyUp="return tabular(event,this)">        </td>	</tr>  
	   <tr  >
        <td class="saludo1">.: Direccion:        </td>
        <td colspan="3"><input name="direccion" type="text"  style="width:85%;" value="<?php echo $_POST[direccion]?>" size="70" onKeyUp="return tabular(event,this)">        </td>
		</tr>
		<tr>
         <td class="saludo1">.: Telefono:        </td>
        <td><input name="telefono" type="text" value="<?php echo $_POST[telefono]?>" size="40" onKeyUp="return tabular(event,this)">        </td>
		 <td class="saludo1">.: Celular:        </td>
        <td><input name="celular" type="text" value="<?php echo $_POST[celular]?>" size="40" onKeyUp="return tabular(event,this)">        </td>
       </tr>  
	    <tr  >
        <td class="saludo1">.: E-mail:        </td>
        <td><input name="email" type="text" value="<?php echo $_POST[email]?>" size="40" onKeyUp="return tabular(event,this)">        </td>
         <td class="saludo1">.: Pagina Web:        </td>
        <td><input name="web" type="text" value="<?php echo $_POST[web]?>" size="40" onKeyUp="return tabular(event,this)">        </td>
       </tr> 
	   <tr>
        <td class="saludo1">:: Dpto :          </td>
        <td><select name="dpto" id="dpto" onChange="validar()">
                    <option value="-1">:::: Seleccione Departamento :::</option>
            <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from danedpto order by nombredpto";
			// echo $sqlr;
		 			$resp = mysql_query($sqlr,$link);
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
          </select>        </td>
        <td class="saludo1">:: Municipio :          </td>
        <td><select name="mnpio" id="mnpio">
			<option value="-1">:::: Seleccione Municipio ::::</option>
              <?php
  		   $sqlr="Select * from danemnpio where  danemnpio.danedpto=".$_POST[dpto]." order by nom_mnpio";
		  					$resp = mysql_query($sqlr,$link);
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
        </select><input name="oculto" id="oculto" type="hidden" value="1"> <input name="idtercero" id="idtercero" type="hidden" value="<?php echo $_POST[idtercero];?>"> </td>
      </tr> 
	       <tr  >
        <td class="saludo1">.: Tipo Tercero:        </td>
        <td colspan="2" > :: Contribuyente:<input name="contribuyente"  type="checkbox"  value="1"  <?php if ($_POST[contribuyente]=='1'){  ?> checked <?php }?>>         
		 :: Proveedor:<input name="proveedor" type="checkbox" value="1" <?php if ($_POST[proveedor]=='1'){  ?> checked <?php }?>>
  		 :: Empleado:<input name="empleado" type="checkbox" value="1" <?php if ($_POST[empleado]=='1'){  ?> checked <?php }?>>        </td>    
        <td >:: Estado: 
          <select name="estado">
            <option value="S" <?php if ($_POST[estado]=='S'){  ?> SELECTED <?php }?>>SI</option>
            <option value="N" <?php if ($_POST[estado]=='N'){  ?> SELECTED <?php }?>>NO</option>
          </select>
          </td>
          </tr>               
    </table>
<?php
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
$linkbd=conectar_bd();
if ($_POST[documento]!="")
 {
 $nr="1";
$sqlr="update terceros set nombre1='".utf8_decode($_POST[nombre1])."',nombre2='".utf8_decode($_POST[nombre2])."',apellido1='".utf8_decode($_POST[apellido1])."',apellido2='".utf8_decode($_POST[apellido2])."',razonsocial='".utf8_decode($_POST[razonsocial])."',direccion='".utf8_decode($_POST[direccion])."',telefono='$_POST[telefono]',celular='$_POST[celular]',email='$_POST[email]',web='$_POST[web]',tipodoc=$_POST[tipodoc],cedulanit='$_POST[documento]',codver='$_POST[codver]',depto='$_POST[dpto]',mnpio='$_POST[mnpio]',persona=$_POST[persona],regimen=$_POST[regimen], contribuyente='$_POST[contribuyente]',proveedor='$_POST[proveedor]',empleado='$_POST[empleado]',estado='$_POST[estado]' where id_tercero=$_POST[idtercero]";
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
  echo "<table><tr><td class='saludo1'><center><h2>Se ha Actualizado con Exito</h2></center></td></tr></table>";
  /*$_POST[nombre1]="";
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
  $_POST[web]="";*/
  $_POST[oculto]="1";
    ?><script>
//cleanForm();
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