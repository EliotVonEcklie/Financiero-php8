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
		<title>:: SieS - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script src="css/programas.js"></script>
        <script src="css/calendario.js"></script>
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
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.acuerdo.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
function validar(formulario)
{
document.form2.action="presu-presuinicialing.php";
document.form2.submit();
}
function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-presuinicialing.php";
document.form2.submit();
}
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=document.form2.tipocta.value;
 document.form2.submit();
 }
 }
function agregardetalle()
{
 vc=document.form2.valorac2.value;
if(document.form2.cuenta.value!="" && document.form2.tipomov.value!="" && document.form2.tipocta.value!="" && document.form2.valor.value>=0 )
{ 
 tipoc=document.form2.tipocta.value;
 switch (tipoc)
 {
   case '1':
     suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentaing2.value);
 		if(suma<=vc)
  			{
				document.form2.agregadet.value=1;
//				document.form2.chacuerdo.value=2;
				document.form2.submit();
				
  			}
			else
	 			{
	 			alert("El Valor supera el Acto Administrativo: "+suma);
				 }
	break;
	case '2':
	suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentagas2.value);
 		if(suma<=vc)
  			{
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
  			}
			else
	 			{
	 			alert("El Valor supera el Acto Administrativo: "+suma);
				 }
	break;
	}
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
  document.form2.chacuerdo.value=2;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
function finaliza()
 {
  if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
  {
	  document.form2.fin.value=1;
	  document.form2.fin.checked=true; 
  } 
  else
  	  document.form2.fin.value=0;
  document.form2.fin.checked=false; 
 }
function capturaTecla(e){ 
var tcl = (document.all)?e.keyCode:e.which;
if (tcl==115){
alert(tcl);
return tabular(e,elemento);
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
          		<td colspan="3" class="cinta"><a href="presu-presuinicialing.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="presu-buscaracuerdos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$vigencia=$vigusu;
$linkbd=conectar_bd();
 ?>	
<?php
if(!$_POST[oculto])
{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
		 $_POST[valor]=0; 			 
		 $_POST[cuentaing]=0;
		 $_POST[cuentagas]=0;
 		 $_POST[cuentaing2]=0;
		 $_POST[cuentagas2]=0;
}

?>
 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],$_POST[tipocta]);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 
		if ($_POST[chacuerdo]=='2')
					 {
				    $_POST[dcuentas]=array();
				    $_POST[dncuetas]=array();
				    $_POST[dingresos]=array();
				    $_POST[dgastos]=array();
					$_POST[diferencia]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing]=0;																			
					 }	 
		?>

 <form name="form2" method="post" action="">
    <table class="inicio" align="center" width="80%" >
      <tr >
        <td class="titulos" colspan="8">.: Adicion/Reduccion Presupuestal</td>
        <td width="61" class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
	  <td class="saludo1">Adicion/Reduccion</td>
		  <td><select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar2()">
          <option value="1" <?php if($_POST[tipomov]=='1') echo "SELECTED"; ?>>Adicion</option>
          <option value="2" <?php if($_POST[tipomov]=='2') echo "SELECTED"; ?>>Reduccion</option>
        </select>
		</td>
	  <td width="96" class="saludo1">Fecha:        </td>
        <td width="194"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
		 <td width="119" class="saludo1">Acto Administrativo:</td>
          <td width="197" valign="middle" >
		  <select name="acuerdo"  onChange="validar2()" onKeyUp="return tabular(event,this)">
		<option value="-1">...</option>
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from pptoacuerdos where estado='S' and vigencia='".$_SESSION["vigencia"]."' and tipo='I'";
			        $tv=4+$_POST[tipomov];
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
					 if($i==$_POST[acuerdo])
			 			{
						 echo "SELECTED";
						 $_POST[vigencia]=$row[4];
						 $_POST[valorac]=$row[$tv];
						 $_POST[valorac2]=$row[$tv];
						 $_POST[valorac]=number_format($_POST[valorac],2,'.',',');		 
						 //******subrutina para cargar el detalle del acuerdo de adiciones
						 if($_POST[chacuerdo]=='2' )
						  {
						 $sqlr2="select *from pptoadiciones where id_acuerdo='$i'";
						 $resp2=mysql_query($sqlr2,$link);
					     while ($row2 =mysql_fetch_row($resp2)) 
						   {
						    $_POST[dcuentas][]=$row2[4];					
							 if(substr($row2[4],0,1)=='1')							
						    {$_POST[dingresos][]=$row2[5];
							$_POST[dgastos][]=0;
							 $nresul=buscacuentapres($row2[4],1);
							 $_POST[dncuentas][]=$nresul;		}
							else{
							 $nresul=buscacuentapres($row2[4],2);
							 $_POST[dncuentas][]=$nresul;									
						    $_POST[dgastos][]=$row2[5];
							$_POST[dingresos][]=0;
								}
						   }
						 //******subrutina para cargar el detalle del acuerdo de adiciones
						 $sqlr2="select *from pptoreducciones where id_acuerdo='$i'";
						 $resp2=mysql_query($sqlr2,$link);;
					     while ($row2 =mysql_fetch_row($resp2)) 
						   {
						    $_POST[dcuentas][]=$row2[4];
							 if(substr($row2[4],0,1)=='1')							
						    {$_POST[dingresos][]=$row2[5];
							$_POST[dgastos][]=0;
							$nresul=buscacuentapres($row2[4],1);
						    $_POST[dncuentas][]=$nresul;							 
								}
							else							
						    {$_POST[dgastos][]=$row2[5];
							$_POST[dingresos][]=0;														
							 $nresul=buscacuentapres($row2[4],2);
						    $_POST[dncuentas][]=$nresul;							 
								}
						   }
						  }///**** fin si cambio 
						 }
					  echo ">".$row[1]."-".$row[2]."</option>";	  
					}

		  ?>
		</select><input type="hidden" name="chacuerdo" value="1">		  </td>
		  <td class="saludo1">Vigencia:</td>
		  <td><input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly></td>
       </tr><tr>
	   <td class="saludo1"><input type="hidden" value="1" name="oculto">Valor Acuerdo:</td><td><input name="valorac" type="text" value="<?php echo $_POST[valorac]?>" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"><input type="hidden"  id="valorac2" name="valorac2" value="<?php echo $_POST[valorac2]?>"></td><td class="saludo1">Finalizar</td><td><input type="checkbox" name="fin" value="<?php echo $_POST[fin]?>" id="fin" onClick="finaliza()"></td>
	    </tr></table>
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Cuentas</td></tr>
	   <tr><td class="saludo1">Tipo</td><td>
	   <select name="tipocta" id="tipocta" onKeyUp="return tabular(event,this)" onChange="validar()">
          <option value="1" <?php if($_POST[tipocta]=='1') echo "SELECTED"; ?>>Ingreso</option>
          <option value="2" <?php if($_POST[tipocta]=='2') echo "SELECTED"; ?>>Gastos</option>
        </select>
	     </td><td width="119" class="saludo1">Cuenta:</td>
          <td width="197" valign="middle" ><input type="text" id="cuenta" name="cuenta" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="" name="bc" id="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=<?php echo $_POST[tipocta] ?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td><td colspan="2"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="80" readonly></td></tr>
		  <tr> 
		  <td class="saludo1">Valor:</td><td>
<input name="valor" type="text" value="<?php echo $_POST[valor]?>" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"> </td><td>
<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"></td></tr>  
    </table>
	<?php
	if(!$_POST[oculto])
	{ 
		 ?>
		 <script>
    	document.form2.fecha.focus();
		</script>
	<?php
	}
	?>
		 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {

			  $nresul=buscacuentapres($_POST[cuenta],$_POST[tipocta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();
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
		?><div class="subpantallac" style="height:51%; width:99.6%; overflow-x:hidden;">
		<table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="5">Detalle Presupuesto          </td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Ingresos</td><td class="titulos2">Gastos</td><td class="titulos2"><img src="imagenes/del.png" style="height:20px"><input type='hidden' name='elimina' id='elimina'></td>
		</tr>
		<?php 
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		  $cuentagas=0;
		  $cuentaing=0;
		   $diferencia=0;
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dgastos][$posi]);		 		 		 		 		 
		 unset($_POST[dingresos][$posi]);		 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 
		 $_POST[dgastos]= array_values($_POST[dgastos]); 
		 $_POST[dingresos]= array_values($_POST[dingresos]); 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		  $cuentagas=0;
		  $cuentaing=0;
		  $diferencia=0;
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 if($_POST[tipocta]=='1')
	 	 {
		 $_POST[dgastos][]=0;
		 $_POST[dingresos][]=$_POST[valor];
		 }
		 if($_POST[tipocta]=='2')
		 {
		 $_POST[dingresos][]=0;
		 $_POST[dgastos][]=$_POST[valor];
		 }
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.cuenta.value="";
				document.form2.ncuenta.value="";
				document.form2.tipocta.select();
		  		document.form2.tipocta.focus();	
		 </script>
		  <?php
		  }
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
		 
		 echo "<tr><td class='saludo2'><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='20' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly></td><td class='saludo2'><input name='dingresos[]' value='".$_POST[dingresos][$x]."' type='text' size='15'></td><td class='saludo2'><input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text' size='15' onDblClick='llamarventana(this,$x)' readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
//		 $cred= $vc[$x]*1;
		 $gas=$_POST[dgastos][$x];
		 $ing=$_POST[dingresos][$x];
//		 $cred=number_format($cred,2,".","");
	//	 $deb=number_format($deb,2,".","");
		 $gas=$gas;
		 $ing=$ing;		 
		 $cuentagas=$cuentagas+$gas;
		 $cuentaing=$cuentaing+$ing;
		 $_POST[cuentagas2]=$cuentagas;
		 $_POST[cuentaing2]=$cuentaing;		 	
		 $diferencia=$cuentaing-$cuentagas;
		 $total=number_format($total,2,",","");
		 $_POST[diferencia]=number_format($diferencia,2,".",",");
 		 $_POST[cuentagas]=number_format($cuentagas,2,".",",");
		 $_POST[cuentaing]=number_format($cuentaing,2,".",",");	 
		 }
		 echo "<tr><td >Diferencia:</td><td colspan='1'><input id='diferencia' name='diferencia' value='$_POST[diferencia]' readonly></td><td class='saludo1'><input name='cuentaing' id='cuentaing' value='$_POST[cuentaing]' readonly><input name='cuentaing2' id='cuentaing2' value='$_POST[cuentaing2]' type='hidden'></td><td class='saludo1'><input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' readonly><input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'></td></tr>";
		?>
		</table></div>
    </form>
  <?php
  //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	if ($_POST[acuerdo]!="")
	 {
 	$nr="1";	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	switch($_POST[tipomov])
	{
	case 1:
	//*********** ELIMINAR REEGISTROS ANTERIORES
	$sqlr="delete from pptoadiciones where id_acuerdo=$_POST[acuerdo]";
	mysql_query($sqlr,$linkbd);
	$sqlr="delete from pptoreducciones where id_acuerdo=$_POST[acuerdo]";
	mysql_query($sqlr,$linkbd);
		  		  //****SI SOLO SI ESTA FINALIZADO
		  if($_POST[fin]=='1' && $_POST[diferencia]=='0' && $_POST[cuentagas]==$_POST[valorac2] && $_POST[cuentaing]==$_POST[valorac2])
				  {
				 $sqlr="update pptocuentaspptoinicial set pptodef=pptodef+$valores,saldos=saldos+$valores where cuentas='".$_POST[dcuentas][$x]."'";
			 //echo "sqlr:".$sqlr;
			  	mysql_query($sqlr,$linkbd);	  
					$sqlr="update pptoacuerdos set estado='F' WHERE id_acuerdo=".$_POST[acuerdo]."";		
				  	mysql_query($sqlr,$linkbd);	  
					echo "<table><tr><td class='saludo1'><center><h2>SE HA FINALIZADO EL ACUERDO</h2></center></td></tr></table>";		
					}
					else{
					echo "<table><tr><td class='saludo1'><center><h2>NO SE PUEDE FINALIZAR EL DOCUMENTO SI LOS VALORES NO SON IGUALES AL ACUERDO</h2></center></td></tr></table>";		
					}
	 for($x=0;$x<count($_POST[dcuentas]);$x++)	
	  {
	  if ($_POST[dingresos][$x]=='0')
	    {
		 $valores=$_POST[dgastos][$x];
		}
		else
		 {
		  $valores=$_POST[dingresos][$x];
		 }
	 $sqlr="INSERT INTO pptoadiciones (id_acuerdo,fecha,vigencia,cuenta,valor,estado)VALUES ($_POST[acuerdo],'".$fechaf."','$_POST[vigencia]','".$_POST[dcuentas][$x]."', $valores,'S')";
echo "sqlr:".$sqlr;
  	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<script>alert('ERROR EN LA CREACION DE LA ADICION');document.form2.fecha.focus();</script>";
		}
		  else
		  {
		  		  if($_POST[fin]=='1' && $_POST[diferencia]=='0' && $_POST[cuentagas]==$_POST[valorac2] && $_POST[cuentaing]==$_POST[valorac2])
				  {
				 $sqlr="update pptocuentaspptoinicial set pptodef=pptodef+$valores,saldos=saldos+$valores where cuentas='".$_POST[dcuentas][$x]."'";
			 //echo "sqlr:".$sqlr;
			  	mysql_query($sqlr,$linkbd);	  
					$sqlr="update pptoacuerdos set estado='F' WHERE id_acuerdo=".$_POST[acuerdo]."";		
				  	mysql_query($sqlr,$linkbd);	  
					echo "<table><tr><td class='saludo1'><center><h2>SE HA FINALIZADO EL ACUERDO</h2></center></td></tr></table>";		
					}
					else{
					echo "<table><tr><td class='saludo1'><center><h2>NO SE PUEDE FINALIZAR EL DOCUMENTO SI LOS VALORES NO SON IGUALES AL ACUERDO</h2></center></td></tr></table>";		
					}
		  
		  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado la Adicion con Exito</h2></center></td></tr></table>";
		  echo "<script>document.form2.tipocta.focus();</script>";
  		   }
		}   //****for
		break;		   
	case 2:

		$sqlr="delete from pptoadiciones where id_acuerdo=$_POST[acuerdo]";
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptoreducciones where id_acuerdo=$_POST[acuerdo]";
		mysql_query($sqlr,$linkbd);
	 for($x=0;$x<count($_POST[dcuentas]);$x++)	
	 {
	  if ($_POST[dingresos][$x]=='0')
	    {
		 $valores=$_POST[dgastos][$x];
		}
		else
		 {
		  $valores=$_POST[dingresos][$x];
		 }
	 $sqlr="INSERT INTO pptoreducciones (id_acuerdo,fecha,vigencia,cuenta,valor,estado)VALUES ($_POST[acuerdo],'".$fechaf."','$_POST[vigencia]','".$_POST[dcuentas][$x]."', $valores,'S')";
	 //echo "sqlr:".$sqlr;
  	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<script>alert('ERROR EN LA CREACION DE LA REDUCCION');document.form2.fecha.focus();</script>";
		}
		  else
		  {
		  		  if($_POST[fin]=='1' && $_POST[diferencia]=='0' && $_POST[cuentagas]==$_POST[valorac2] && $_POST[cuentaing]==$_POST[valorac2])
				  {
				 $sqlr="update pptocuentaspptoinicial set pptodef=pptodef-$valores,saldos=saldos-$valores where cuentas='".$_POST[dcuentas][$x]."'";
			 //echo "sqlr:".$sqlr;
			  	mysql_query($sqlr,$linkbd);	  
					$sqlr="update pptoacuerdos set estado='F' WHERE id_acuerdo=".$_POST[acuerdo]."";		
				  	mysql_query($sqlr,$linkbd);	  
					echo "<table><tr><td class='saludo1'><center><h2>SE HA FINALIZADO EL ACUERDO</h2></center></td></tr></table>";		
					}
					else{
					echo "<table><tr><td class='saludo1'><center><h2>NO SE PUEDE FINALIZAR EL DOCUMENTO SI LOS VALORES NO SON IGUALES AL ACUERDO</h2></center></td></tr></table>";		
					}
		  
		  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado la reduccion con Exito</h2></center></td></tr></table>";
		  echo "<script>document.form2.tipocta.focus();</script>";
  		   }
		}   	//***for
		break;
	 } //****switch
	 }//***if de acuerdo
 else
  {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Proceso</H2></center></td></tr></table>";
  echo "<script>document.form2.fecha.focus();</script>";  
  } 
 }//*** if de control de guardado
?> 
</td></tr>     
</table>
</body>
</html>