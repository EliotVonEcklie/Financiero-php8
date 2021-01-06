<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
document.form2.action="presu-presuinicial.php";
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
  if (document.form2.valorac2.value==document.form2.cuentagas2.value && document.form2.valorac2.value==document.form2.cuentaing2.value)
  {
   if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
   {
	  document.form2.fin.checked=true; 
   } 
   else
   document.form2.fin.checked=false; 
  }
  else 
  {
   alert("El Total del Acto Administrativo no es igual al de Ingresos y/o Gastos");
    document.form2.fin.checked=false; 
  }
 }
function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-presuinicial.php";
document.form2.submit();
}

function pdf()
{
document.form2.action="pdfpptoini.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
         		<td colspan="3" class="cinta"><a href="presu-presuinicial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a href="presu-buscarpresuinicial.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir" ></a></td>
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
 		 $sqlr="select *from pptoacuerdos where pptoacuerdos.id_acuerdo=$_GET[idac]";
		 $res=mysql_query($sqlr,$linkbd);
		 while ($row=mysql_fetch_row($res))
		 	{
				$_POST[fecha]=$row[3];
				$_POST[acuerdo]=$row[0];
				if ($row[9]=='A')
					$_POST[fin]='Anulado';
				if ($row[9]=='S')
					$_POST[fin]='Sin Finalizar';
				if ($row[9]=='F')
					$_POST[fin]='Finalizado';
						
			}
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
				    $_POST[dncuentas]=array();
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
        <td class="titulos" colspan="8">.: Presupuesto Inicial</td>
        <td class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td class="saludo1">Presupuesto</td>
		  <td><select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar()" disabled>
          <option value="1" <?php if($_POST[tipomov]=='1') echo "SELECTED"; ?>>Presupuesto Inicial</option>
        </select>
		</td>
	  <td width="96" class="saludo1">Fecha:        </td>
        <td width="194"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>               </td>
		 <td width="119" class="saludo1">Acto Administrativo:</td>
          <td width="197" valign="middle" >
		  <select name="acuerdo"  onChange="validar2()" onKeyUp="return tabular(event,this)"  disabled="disabled">
		
		 <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from pptoacuerdos where vigencia='".$viguu."' and tipo='I'";
			        $tv=4+$_POST[tipomov];
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
					
					 if($i==$_POST[acuerdo])
			 			{
						 echo "SELECTED";
						 $_POST[nomacuerdo]=$row[1]." ".$row[2];
						 $_POST[vigencia]=$row[4];
						 $_POST[valorac]=$row[8];
						 $_POST[valorac2]=$row[8];
						 $_POST[valorac]=number_format($_POST[valorac],2,'.',',');
						 
						
						 $sqlr2="select *from pptocuentaspptoinicial where id_acuerdo='$i' order by cuenta";
						 $resp2=mysql_query($sqlr2,$link);
					     while ($row2 =mysql_fetch_row($resp2)) 
						   {
						    $_POST[dcuentas][]=$row2[0];					
							 if(substr($row2[0],0,1)=='1')							
						    {$_POST[dingresos][]=$row2[5];
							$_POST[dgastos][]=0;
							 $nresul=buscacuentapres($row2[0],1);
							 $_POST[dncuentas][]=$nresul;		}
							else{
							 $nresul=buscacuentapres($row2[0],2);
							 $_POST[dncuentas][]=$nresul;									
						    $_POST[dgastos][]=$row2[5];
							$_POST[dingresos][]=0;
								}
						   }
						 	}	 
						
					  echo ">".$row[1]."-".$row[2]."</option>";	  
					}

		  ?>
		</select><input type="hidden" name="nomacuerdo" value="<?php echo $_POST[nomacuerdo]?>">	<input type="hidden" name="chacuerdo" value="1" readonly>	  </td>
		  <td class="saludo1">Vigencia:</td>
		  <td><input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly></td>
       </tr><tr>
	   <td class="saludo1"><input type="hidden" value="1" name="oculto">Valor Acuerdo:</td><td><input name="valorac" type="text" value="<?php echo $_POST[valorac]?>" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" readonly><input type="hidden"  id="valorac2" name="valorac2" value="<?php echo $_POST[valorac2]?>"></td><td class="saludo1">Finalizar</td><td><input type="text" name="fin" value="<?php echo $_POST[fin]?>" id="fin"  disabled="disabled"></td>
	    </tr></table>
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
		?>
        <div class="subpantalla" style="height:63.5%; width:99.6%; overflow-x:hidden;">
		<table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="5">Detalle Comprobantes          </td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Ingresos</td><td class="titulos2">Gastos</td>
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
				document.form2.tipo.select();
		 </script>
		  <?php
		  }
		  $iter="$zebra1";
		  $iter2="$zebra2";
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {echo "<tr class='$iter'><td ><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='20' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='100' readonly></td><td class='saludo2'><input name='dingresos[]' value='".$_POST[dingresos][$x]."' type='text' size='15' readonly> </td><td class='saludo2'><input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text' size='15' onDblClick='llamarventana(this,$x)' readonly></td></tr>";
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
		 $resultado = convertir($_POST[cuentagas2]);
		 $_POST[letras]=$resultado." Pesos";
		 }
		 echo "<tr><td >Diferencia:</td><td colspan='1'><input id='diferencia' name='diferencia' value='$_POST[diferencia]' readonly></td><td class='saludo1'><input name='cuentaing' id='cuentaing' value='$_POST[cuentaing]' readonly><input name='cuentaing2' id='cuentaing2' value='$_POST[cuentaing2]' type='hidden'></td><td class='saludo1'><input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' readonly><input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'><input id='letras' name='letras' value='$_POST[letras]' type='hidden'></td></tr>";
		?>
		</table>
        </div>
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
	
	//echo "Click:$_POST[fin]";
	//***modificacion del acuerdo 
	if($_POST[fin]=='1' && ($_POST[valorac2]==$_POST[cuentaing2] && $_POST[valorac2]==$_POST[cuentagas2])) //**** si esta completa y finalizado
		    {
			$sqlr="delete from pptocomprobante_cab where tipo_comp='1' and numerotipo='$vigusu'";
	 	  	  mysql_query($sqlr,$linkbd);	
			$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($vigusu,1,'$fechaf	','PPTO INICIAL VIGENCIA $vigusu',$vigusu,0,0,0,1)";
	 	  	  mysql_query($sqlr,$linkbd);	
			 $sqlr="update pptoacuerdos set estado='F' where id_acuerdo='".$_POST[acuerdo]."'";
	 //echo "sqlr:".$sqlr;
		  	  mysql_query($sqlr,$linkbd);	  
			  echo "<table><tr><td class='saludo1'><center><h2>Se ha Actualizado el Presupuesto a la cuenta ".$_POST[dcuentas][$x]." con Exito</h2></center></td></tr></table>";
	    	  echo "<script>document.form2.acuerdo.value='';</script>";
		  	  echo "<script>document.form2.fecha.focus();</script>";
			} 
	if($_POST[fin]!='1' )  //***** si no esta finalizado guardado provisionalmente 	
		    {
			 $sqlr="update pptoacuerdos set estado='S' where id_acuerdo='".$_POST[acuerdo]."'";
	//echo "sqlr:".$sqlr;
		  	  mysql_query($sqlr,$linkbd);	  
			  echo "<table><tr><td class='saludo1'><center><h2>Se ha Actualizado el Presupuesto a la cuenta ".$_POST[dcuentas][$x]." con Exito</h2></center></td></tr></table>";
	    	  echo "<script>document.form2.acuerdo.value='';</script>";
		  	  echo "<script>document.form2.fecha.focus();</script>";
			} 
			
	///***********insercion de las cuentas al ppto inicial
	switch($_POST[tipomov])
	{
	case 1:
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
		 //*** eliminar anteriores registros para crear el nuevo ppto inicial de la vigencia
		 $sqlr="delete from pptocomprobante_det where tipo_comp='1' and numerotipo='$vigusu'";
	 	 mysql_query($sqlr,$linkbd);	 
			  
		  $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$_POST[dcuentas][$x]."','','".$_POST[dfuentes][$x]."',".$valores.",0,1,'$vigusu',1,'$vigusu')";
	 	  mysql_query($sqlr,$linkbd); 
		 
		 $sqlr="delete from pptocuentaspptoinicial where cuenta='".$_POST[dcuentas][$x]."' and vigencia='$_POST[vigencia]'";	 
		mysql_query($sqlr,$linkbd); 
	 $sqlr="INSERT INTO pptocuentaspptoinicial (cuenta,fecha,vigencia,valor,estado,pptodef,saldos,saldoscdprp,id_acuerdo,vigenciaf)VALUES ('".$_POST[dcuentas][$x]."','".$fechaf."','$_POST[vigencia]', $valores,'S',$valores,$valores,$valores,$_POST[acuerdo],$vigusu)";
	 //echo "sqlr:".$sqlr;
  	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<script>alert('ERROR EN LA CREACION DEL PRESUPUESTO INICIAL');document.form2.fecha.focus();</script>";
		}
		  else
		  {
		   
			  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado el presupuesto inicial de la cuenta ".$_POST[dcuentas][$x]." con Exito</h2></center></td></tr></table>";
	    	  echo "<script>document.form2.acuerdo.value='';</script>";
		  	  echo "<script>document.form2.fecha.focus();</script>"; 
  		   }
		}   //****for
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