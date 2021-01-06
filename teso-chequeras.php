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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
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
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
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

if (document.form2.fecha.value!='' && document.form2.banco.value!='')
  {
   if((document.form2.valor.value!='' || document.form2.valor.value>0) && (document.form2.valor2.value!='' || document.form2.valor2.value>0) && (document.form2.valor2.value > document.form2.valor.value))
    {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
	}
	else {
		alert('Verifique los parametros del cheque ');
		document.form2.valor.focus();
  		document.form2.valor.select();
	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}

function despliegamodal2(_valor,scr)
			{
				//alert("Hola"+scr);
				if(scr=="1"){
					var url="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
				}
				if(scr=="2"){
					var url="cuentasbancarias-ventana02.php?tipoc=C&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
				}
				if(scr=="3"){
					var url="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=cc";
				}
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventana2').src="";
				}
				else 
				{
					document.getElementById('ventana2').src=url;
				}
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
  <a href="teso-chequeras.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
  <a href="#" class="mgbt" onClick="guardar();"><img src="imagenes/guarda.png"  title="Guardar" /></a>
  <a href="teso-buscachequeras.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
</tr>		  
</table>
<?php
$vigencia=date(Y);
 ?>	
<?php
if(!$_POST[oculto])
{
			 $linkbd=conectar_bd();
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		 $_POST[valor]="0";		 
		 $_POST[valor2]="0";	
		 $sqlr="select max(idchequera) from tesochequeras ";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
	 $_POST[numero]=$consec;		 		 
}
?>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center" >
		<tr >
			<td class="titulos" colspan="7">Chequeras</td><td width="138" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
		</tr>
		<tr  >
			<td style="width:10%;"  class="saludo1">Fecha:        </td>
			<td style="width:15%;">
				<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"> 
				<a href="#" onClick="displayCalendarFor('fc_1198971545');">
					<img src="imagenes/buscarep.png" align="absmiddle" border="0">
				</a>        
			</td>
			<td  class="saludo1" style="width:5%;">N&deg;</td>
			<td >
				<input type="text" id="numero" name="numero" style="width:8%;" value="<?php echo $_POST[numero]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" readonly >
			</td>
		</tr> 
		<tr>
			<?php
				echo "<tr>
						<td style='width:10%;' class='saludo1'>Cuenta Bancaria:</td>
						<td>
							<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%;'/>&nbsp;
							<a onClick=\"despliegamodal2('visible','2');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
								<img src='imagenes/find02.png' style='width:20px;'/>
							</a>
						</td>
						<td colspan='2'>
								<input type='text' id='nbanco' name='nbanco' style='width:50%;' value='$_POST[nbanco]'  readonly>
						</td>
					
							<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
							<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
						</tr>";
			?>
			<!--<td style="width:10%;" class="saludo1">Cuenta Bancaria:</td>
			<td style="width:15%;" >
				<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
					<option value="">Seleccione....</option>
					// <?php
						// $linkbd=conectar_bd();
						// $sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' and tesobancosctas.tipo='Corriente'";
						// $res=mysql_query($sqlr,$linkbd);
						// while ($row =mysql_fetch_row($res)) 
						// {
							// echo "<option value=$row[1] ";
							// $i=$row[1];
							// if($i==$_POST[banco])
							// {
								// echo "SELECTED";
								// $_POST[nbanco]=$row[4];
								// $_POST[ter]=$row[5];
								// $_POST[cb]=$row[2];
							// }
							// echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
						// }	 	
					// ?>
				</select>
				<?php 
					$sqlr="select count(*) from tesochequeras where banco=$_POST[ter] and cuentabancaria=$_POST[cb] and estado='S' ";
					$res2=mysql_query($sqlr,$linkbd);
					$row2 =mysql_fetch_row($res2);
					if($row2[0]>0)
					{
						echo "<script>alert('Ya existe una chequera activa para esta Cuenta');document.form2.banco.value=''; document.form2.banco.focus();</script>";
						$_POST[nbanco]="";
					}
				?>
			</td>
			<td colspan="2"> 
				<input type="text" id="nbanco" name="nbanco" style="width:50%;" value="<?php echo $_POST[nbanco]?>"  readonly>
				<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
			</td>-->
		</tr> 
		<tr>
			<td style="width:10%;" class="saludo1">Rango inicial:</td>
			<td style="width:15%;">
				<input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" >	
			</td>
			<td  class="saludo1" style="width:7%;">Rango Final:</td>
			<td  >	
				<input type="text" id="valor2" name="valor2" style="width:8%;" value="<?php echo $_POST[valor2]?>"  onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" >
				<input type="hidden" value="1" name="oculto">
			</td>
		</tr>
    </table>
	  <?php
		if($_POST[oculto]=='2')
		{
			$linkbd=conectar_bd();
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$sqlr="insert into tesochequeras (banco,cuentabancaria,fecha,inicial,final,consecutivo,estado) values ('$_POST[ter]','$_POST[cb]','$fechaf','$_POST[valor]','$_POST[valor2]','$_POST[valor]','S')";
			
			
			if (!mysql_query($sqlr,$linkbd))
			{
				 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
				echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Chequera con Exito</center></td></tr></table>";
				?>
				<script>
					document.form2.numero.value="";
					document.form2.valor.value=0;
					document.form2.oculto.value=1;
				</script>
				<?php
			}
			$sqlr="select * from tesochequeras where estado='S' and cuentabancaria='$_POST[cb]'";
			$resp = mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($resp)) 
			{
				//echo $row[0]."-".$row[1]."-".$row[2]."-".$row[3]."-".$row[4]."-".$row[5]."-".$row[6]."-".$row[7]."<br>";
				$inicial=intval($row[4]);
				$final=intval($row[5]);
				//echo $inicial."-".$final."<br>";
				while($inicial<$final){
					$sqlr1="insert into tesocheques (cheque, banco, cuentabancaria, chequera, estado, id_cheque, destino) values ($inicial,'$row[1]','$row[2]','$row[0]','S','$row[0]-$inicial','-')";
					mysql_query($sqlr1,$linkbd);
					$inicial+=1;
				}
			}
		}
	  ?>
	  <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>	
    </form> 
</table>
</body>
</html>