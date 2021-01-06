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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
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
function buscactac(e)
 {
if (document.form2.cuentac.value!="")
{
 document.form2.bcc.value='1';
 document.form2.submit();
 }
 }
function buscactag(e)
 {
if (document.form2.cuentag.value!="")
{
 document.form2.bcg.value='1';
 document.form2.submit();
 }
 }
function buscactap(e)
 {
if (document.form2.cuentap.value!="")
{
 document.form2.bcp.value='1';
 document.form2.submit();
 }
 }
function buscactap2(e)
 {
if (document.form2.cuentap2.value!="")
{
 document.form2.bcp2.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.submit();
}
function agregardetalle()
{
if(document.form2.valor.value!="" &&  document.form2.cuenta.value!="")
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
function guardar()
{

if (document.form2.nombre.value!=''  && document.form2.codigo.value!='' && document.form2.concecont.value!=-1 && document.form2.concecontgas.value!=-1 && document.form2.cuentap.value!='' && document.form2.cuenta2.value!='')
  {
	despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  }
  else{
	despliegamodalm('visible','2','Faltan datos para completar el registro');
  	document.form2.codigo.focus();
  	document.form2.codigo.select();
  }
}
function despliegamodal2(_valor)
		{
			document.getElementById("bgventanamodal2").style.visibility=_valor;
			if(_valor=="hidden"){document.getElementById('ventana2').src="";}
			else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
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
		function funcionmensaje(){
			document.location.href = "teso-editaingresossf.php?id="+document.getElementById('codigo').value ;
			}
		
</script>
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
  <a href="teso-ingresossf.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
  <a href="#" class="mgbt"  onClick="guardar()"><img src="imagenes/guarda.png" title="Guardar" /></a>
  <a href="teso-buscaingresossf.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a>
  <a href="#" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
if(!$_POST[oculto])
{
		$linkbd=conectar_bd();
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[tipo]='S';
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		
		  $sqlr="select  MAX(RIGHT(codigo,2)) from tesoingresossf_cab  order by codigo Desc";
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
		<div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
        </div>
    </div>
 <form name="form2" method="post" action="">
<?php //**** busca cuentas
  			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],1);			
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentap]="";	
			   }
			 }
			 if($_POST[bcp2]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap2],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuentap2]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentap2]="";	
			   }
			 }
			 if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 if($_POST[bcg]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentag]);			
			  if($nresul!='')
			   {
			  $_POST[ncuentag]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentag]="";	
			   }
			 }

			  if($_POST[bcc]!='')
			 {
				
			  $nresul=buscacuenta($_POST[cuentac]);		
			   //echo "bbbb".$_POST[cuentac];	
			  if($nresul!='')
			   {
			  $_POST[ncuentac]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuentac]="";	
			   }
			 }
			 ?>
 
    <table class="inicio" align="center" >
      	<tr >
        	<td class="titulos" colspan="12">Recursos Sin situacion de Fondos SSF</td><td width="110" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr  >
		  	<td width="50" class="saludo1">Codigo:        </td>
	        <td width="63">
				<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        
			</td>
	        <td width="45" class="saludo1">Nombre :        </td>
	        <td width="482">
	        	<input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80" onKeyUp="return tabular(event,this)">        
	        </td>                
       	</tr> 
	</table>
	<table class="inicio">
	   	<tr>
	   		<td colspan="4" class="titulos">Detalle Recursos SSF</td>
	   	</tr>   
        <tr>
	  		<td style="width:15%;" class="saludo1">Parametro Contable Ingreso:</td>
          	<td colspan="2"  valign="middle" >
				<select name="concecont" id="concecont" style="width:41.5%;">
					<option value="-1" >Seleccione ....</option>
						<?php
						 	$sqlr="Select * from conceptoscontables  where modulo='4' and tipo='IS' order by codigo";
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
				</select>
				<input id="concecontnom" name="concecontnom" type="hidden" value="<?php echo $_POST[concecontnom]?>" >
			</td>
	    </tr>               
	  	<tr>
	  		<td style="width:15%;" class="saludo1">Parametro Contable Gastos: </td>
          	<td colspan="2"  valign="middle" >
				<select style="width:41.6%;" name="concecontgas" id="concecontgas" >
				  	<option value="-1">Seleccione ....</option>
					<?php
					 	$sqlr="Select * from conceptoscontables  where modulo='4' and tipo='GS' order by codigo";
		 				$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$i=$row[0];
							echo "<option value=$row[0] ";
							if($i==$_POST[concecontgas])
			 				{
				 			echo "SELECTED";
				 			$_POST[concecontgasnom]=$row[0]." - ".$row[3]." - ".$row[1];
				 			}
							echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
			     		}			
					?>
				</select>
				<input id="concecontgasnom" name="concecontgasnom" type="hidden" value="<?php echo $_POST[concecontgasnom]?>" >
			</td>
	    </tr>
         
        <tr>
        	<td style="width:15%;" class="saludo1">Cuenta presupuestal Ingreso: </td>
			<td valign="middle" >
				<input type="text" id="cuentap" name="cuentap"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactap(event)" value="<?php echo $_POST[cuentap]?>" onClick="document.getElementById('cuentap').focus();document.getElementById('cuentap').select();">
				<input type="hidden" value="" name="bcp" id="bcp">
				<a href="#" onClick="mypop=window.open('scuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
					<img src="imagenes/buscarep.png" align="absmiddle" border="0">
				</a>
				<input style="width:40%;" name="ncuentap" type="text" value="<?php echo $_POST[ncuentap]?>"  readonly>
			</td>
		</tr> 
		<tr>
			<td style="width:15%;" class="saludo1">Cuenta presupuestal Gasto: </td>
			<td valign="middle" >
				<input type="text" id="cuenta2" name="cuenta2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactap2(event)" value="<?php echo $_POST[cuenta2]?>" onClick="document.getElementById('cuenta2').focus();document.getElementById('cuenta2').select();">
				<input type="hidden" value="" name="bcp2" id="bcp2">
				<a href="#" onClick="mypop=window.open('cuentasppto2-ventana.php?ti=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
					<img src="imagenes/buscarep.png" align="absmiddle" border="0">
				</a>
				<input style="width:40%;" name="ncuenta2" type="text" value="<?php echo $_POST[ncuenta2]?>"  readonly>
				<input name="oculto" id="oculto" type="hidden" value="1">
			</td>
	    </tr> 

    </table>
	 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentag').focus();
			  document.getElementById('cuentag').select();
			  document.getElementById('bc').value='';
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
			 if($_POST[bcg]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentag]);
			  if($nresul!='')
			   {
			  $_POST[ncuentag]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuentap').focus();
			  document.getElementById('cuentap').select();
			  document.getElementById('bcg').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentag]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentag.focus();</script>
			  <?php
			  }
			 }
			 
			 
			 if($_POST[bcc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentac]);
			  if($nresul!='')
			   {
			  $_POST[ncuentac]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuenta').focus();
			  document.getElementById('cuenta').select();
			  document.getElementById('bcc').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentac]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentac.focus();</script>
			  <?php
			  }
			 } 
		?>

	 <?php
			//**** busca cuenta
			if($_POST[bcp]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuentap],1);
			  if($nresul!='')
			   {
			  $_POST[ncuentap]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('cuenta2').focus();
			  document.getElementById('cuenta2').select();
			  document.getElementById('bcp').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentap]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");
			  document.form2.cuentap.focus();
			  document.form2.cuentap.select();
			  </script>
			  <?php
			  }
			 }
			 //**** busca cuenta
			if($_POST[bcp2]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta2],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta2]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('codigo').focus();
			  document.getElementById('codigo').select();
			  document.getElementById('bcp2').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta2]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");
			  document.form2.cuenta2.focus();
			  document.form2.cuenta2.select();
			  </script>
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
 $sqlr="INSERT INTO tesoingresossf_cab(codigo,nombre,estado)VALUES ('$_POST[codigo]','".($_POST[nombre])."' ,'S')";
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
  echo "<table><tr><td class='saludo1'><center>Se ha almacenado el Ingreso SSF con Exito  <img src='imagenes/confirm.png'></center></td></tr></table>";   
		//******
		$sqlr="INSERT INTO tesoingresossf_det (codigo,conceing,concegas,cuentacongas,cuentapresing,cuentapresgas,estado, vigencia)VALUES ('$_POST[codigo]', '$_POST[concecont]','$_POST[concecontgas]','$_POST[cuentag]','$_POST[cuentap]','$_POST[cuenta2]','S','$vigusu')";
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
 			
	  	 	}
	   }
  }
}
?> </td></tr>
     
</table>
</body>
</html>