<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.codigo.value!='' && document.form2.nombre.value!='' && document.form2.tipog.value!='')
  {
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
 else{
	despliegamodalm('visible','2','Faltan datos para completar el registro');
  	document.form2.codigo.focus();
  	document.form2.codigo.select();
  }
 }
 


		function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
		{
			document.getElementById("bgventanamodalm").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventanam').src="";}
			else
			{
				switch(_tip)
				{
					case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
					case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
					case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
					case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
				}
			}
		}

		function respuestaconsulta(pregunta, variable)
		{
			switch(pregunta)
			{
				case "1":	document.getElementById('oculto').value="2";
							document.form2.submit();break;
				case "2":
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
					break;
			}
		}

		function funcionmensaje(){document.location.href = "teso-editagastosbancarios.php?id="+document.getElementById('codigo').value;}
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
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
			<a href="teso-gastosbancarios.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscagastosbancarios.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a>
		</td>
	</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$linkbd=conectar_bd();
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
if(!$_POST[oculto])
{
		  $sqlr="select  MAX(RIGHT(codigo,2)) from tesogastosbancarios  order by codigo Desc";
		 //echo $sqlr;
		  $res=mysql_query($sqlr,$linkbd);
		  $row=mysql_fetch_row($res);
		  $_POST[codigo]=$row[0]+1;
		   if(strlen($_POST[codigo])==1)
		   {
			   $_POST[codigo]='0'.$_POST[codigo];
			}
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
}
?>
 <div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
 <form name="form2" method="post" action="">
 <?php //**** busca cuenta
  			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
$linkbd=conectar_bd();			 
			 ?>
    <table class="inicio" align="center" >
      	<tr >
        	<td class="titulos" colspan="6">.: Agregar Notas Bancarias</td><td width="112" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr  >
	  	<td style="width:5%;" class="saludo1">Codigo:        </td>
        <td style="width:2%;">
        	<input name="codigo" id="codigo"type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        
        </td>
        <td style="width:5%;" class="saludo1">Nombre:        </td>
        <td style="width:30%;">
        	<input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" style="width:100%;" onKeyUp="return tabular(event,this)">  
        	<input name="oculto" id="oculto" type="hidden" value="1"></td>
		
		<td style="width:5%;" class="saludo1">Tipo Nota:</td>
		
		<td>
		  <select name="tipog" onChange="validar()" id="tipog">
			  <option value="">Seleccione ...</option>
			  <option value="I" <?php if($_POST[tipog]=='I') echo "SELECTED"; ?>>Ingreso</option>
			  <option value="G" <?php if($_POST[tipog]=='G') echo "SELECTED"; ?>>Gasto</option>
		  </select></td>
       	</tr> 
	   	</table>
	  
	   	<table class="inicio">
	   		<tr>
	   			<td colspan="4" class="titulos">Agregar Detalle Notas Bancarias</td></tr>                  
	  		<tr>
	 			<td style="width:10%;" class="saludo1">Concepto Contable:</td>
	 			<td  >
	 				<select name="concecont" id="concecont" style="width:51.5%;">
				  		<option value="-1">Seleccione ....</option>
							<?php
					 			$sqlr="Select * from conceptoscontables  where modulo='4' and tipo='GB' order by codigo";
						 		$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									$i=$row[0];
									echo "<option value=$row[0] ";
									if($i==$_POST[concecont])
							 		{	
								 		echo "SELECTED";
								 		$_POST[concecontnom]=$row[1];
								 	}
									echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
							    }			
							?>
		  			</select>
		  		</td>
		  	</tr>
		  	<?php if($_POST[tipog]=='I'){ ?>
		  	<tr>
	  			<td style="width:10%;" class="saludo1">Cuenta presupuestal: </td>
          		<td colspan="3" valign="middle" >
					<input type="text" id="cuenta" name="cuenta"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus(); document.getElementById('cuenta').select();">
		  			<input type="hidden" value="" name="bc" id="bc">
		  			<a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
		  				<img src="imagenes/buscarep.png" align="absmiddle" border="0">
		  			</a>
		  			<input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" style="width:36.7%;" readonly >
		  		</td>
	    	</tr> 
    	</table>
    	<?php } ?>
	<?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('agregar').focus();
			  document.getElementById('agregar').select();
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
		?>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
 $nr="1";
 $sqlr="INSERT INTO tesogastosbancarios (codigo,nombre,tipo,estado)VALUES ('$_POST[codigo]','".utf8_decode($_POST[nombre])."','$_POST[tipog]' ,'S')";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "
									<script>
										despliegamodalm('visible','2','Manejador de Errores de la Clase BD No se pudo ejecutar la petición');
										document.getElementById('valfocus').value='2';
									</script>";
	}
  else
  {
//  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Gasto Bancario con Exito</center></td></tr></table>";
		//******
		$sqlr="INSERT INTO tesogastosbancarios_det (codigo,concepto,modulo,tipoconce,cuentapres,estado,vigencia)VALUES ('$_POST[codigo]','$_POST[concecont]','4', 'GB', '$_POST[cuenta]','S',$vigusu)";
 		//echo "sqlr:".$sqlr;
  		if (!mysql_query($sqlr,$linkbd))
  		{
		echo "
									<script>
										despliegamodalm('visible','2','Manejador de Errores de la Clase BD No se pudo ejecutar la petición');
										document.getElementById('valfocus').value='2';
									</script>";
		}
 		 else
  			{
 			 echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle del Ingreso con Exito');</script>";
		//****
	  	 	}

	//****COMPUESTO	
	}	
 }
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Centro Costo</H2></center></td></tr></table>";
 }
}
?> </td></tr>
     
</table>
</body>
</html>