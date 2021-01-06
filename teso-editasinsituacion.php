<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
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
</script>
<script language="JavaScript1.2">
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
		if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
		{ 
			document.form2.agregadet.value=1;
			//document.form2.chacuerdo.value=2;
			document.form2.submit();
 		}
 		else
 		{
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
		ingresos2=document.getElementsByName('dcoding[]');
		if (document.form2.fecha.value!='' && ingresos2.length>0)
  		{
			if (confirm("Esta Seguro de Guardar"))
  			{
  				document.form2.oculto.value=2;
  				document.form2.submit();
  			}
  		}
  		else
  		{
  			alert('Faltan datos para completar el registro');
  			document.form2.fecha.focus();
  			document.form2.fecha.select();
  		}	
	}
	
	function pdf()
	{
		document.form2.action="teso-pdfssf.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}

	function iratras(scrtop, numpag, limreg, filtro){
		var idcta=document.getElementById('idcomp').value;
		location.href="teso-buscasinsituacion.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
	}

	function adelante(scrtop, numpag, limreg, filtro){
		var maximo=document.getElementById('maximo').value;
		var actual=document.getElementById('idcomp').value;
		if(parseFloat(maximo)>parseFloat(actual))
		{
			var idcta=parseFloat(document.getElementById('idcomp').value)+1;
			location.href="teso-editasinsituacion.php?idrecaudo="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
		}
	}
		
	function atrasc(scrtop, numpag, limreg, filtro)
	{

		var actual=document.getElementById('idcomp').value;
		if(0<parseFloat(actual))
		{
			var idcta=parseFloat(document.getElementById('idcomp').value)-1;
			location.href="teso-editasinsituacion.php?idrecaudo="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
		}
	}
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function buscaing(e)
 {
if (document.form2.codingreso.value!="")
{
 document.form2.bin.value='1';
 document.form2.submit();
 }
 }
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=22*$totreg;
		?>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-sinsituacion.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
			<a class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscasinsituacion.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
			<a href="#"  onClick="pdf()"  class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a> 
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
//$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	$_POST[tabgroup1]=1;
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigusu;
$linkbd=conectar_bd();
	$sqlr="select VALOR_INICIAL from dominios where dominio='CUENTA_CAJA' where VALOR_FINAL='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[0];
	}
	switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';
                }
	/*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;*/
	 $sqlr="select * from tesossfingreso_cab WHERE ID_RECAUDO='$_GET[idrecaudo]'";
	$res=mysql_query($sqlr,$linkbd);

	while($row=mysql_fetch_row($res))
	 {
	 $_POST[idcomp]=$row[0];
	 $_POST[fecha]=$row[2];
	 $_POST[vigencia]=$row[3];
	 $_POST[concepto]=$row[4];			 
	 $_POST[tercero]=$row[5];	
	 $_POST[ntercero]=buscatercero($row[5]);		 
	 $_POST[cc]=$row[6];			 	 	 
	 $_POST[valortotal]=$row[7];			
	 $_POST[estado]=$row[8];			 	 	 	  	 	 	 
	 if($_POST[estado]=='S')
	 $_POST[estadoc]="ACTIVO";
 	 if($_POST[estado]=='N')
	 $_POST[estadoc]="ANULADO";
	 }
	 $sqlr="select * from tesossfingreso_det WHERE ID_RECAUDO='$_GET[idrecaudo]'";
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	{
	 $_POST[dcoding][]=$r[2];
	 $codssf=buscacodssf($r[2],$vigusu);
	//	 $nomcodssf= buscacodssfnom($codssf);
	 $_POST[dncoding][]=buscaingresossf($r[2]);		;			 		
	 $_POST[dvalores][]=$r[3];
	}
}
?>
 <form name="form2" method="post" action=""> 
 <?php
 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
//******** busca ingreso *****
//***** busca tercero
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingresossf($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ningreso]="";
			  }
			 }

//----------maximo------------
			$sqlr="select * from tesossfingreso_cab order by id_recaudo desc";
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
			$_POST[maximo]=$row[0];
			 
 ?>
 
 <div class="tabsic" style="height:36%; width:99.6%;">
 	<div class="tab">
 		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	    <label for="tab-1">Ingresos SSF</label>
	    <div class="content" style="overflow-x:hidden;">
	    	<table class="inicio" align="center" >
      	<tr >
        	<td class="titulos" colspan="2"> Ingresos Sin Situacion de Fondos - SSF</td>
        	<td style="width:7%" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
      		<td>
      			<table>
      				<tr  >
			        	<td class="saludo1" style="width:10%;">Numero Ingreso:</td>
			        	<td style="width:25%;">
			        		<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)">
			        			<img src="imagenes/back.png" alt="anterior" align="absmiddle">
		        	    	</a>
			        		<input name="idcomp" id="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) " style="width:50%"  readonly>
			        		<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)">
                            	<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
                            </a> 
			        		<input type="hidden" name="maximo" id="maximo" value="<?php echo $_POST[maximo]; ?>">
			        	</td>
					  	<td  class="saludo1" style="width:8%;">Fecha:</td>
				        <td style="width:15%;">
				        	<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:80%" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> 
				        </td>
			         	<td class="saludo1" style="width:8%;">Vigencia:</td>
					  	<td style="width:60%;">
					  		<input type="text" style="width:30%;"  id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly> 
					  		<?php 
								if($_POST[estadoc]=='ACTIVO'){
									echo "<input name='estado' type='text' value='ACTIVO'   style='width:30%; background-color:#0CD02A; color:white; text-align:center;' readonly >";
								}
								else
								{
									echo "<input name='estado' type='text' value='ANULADO'  style='width:30%; background-color:#FF0000; color:white; text-align:center;' readonly >";
								}
							?>
					  	</td>
			        </tr>       
			      	<tr>
				        <td style="width:10%;" class="saludo1">Concepto Ingreso:</td>
				        <td colspan="5" >
				        	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:87.8%;" onKeyUp="return tabular(event,this)">
				        </td>
				    </tr>  
			      	<tr>
			      		<td style="width:10%;" class="saludo1">NIT: </td>
			        	<td style="width:25%;">
			            	<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:60%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)">
			           	</td>
			      		<td class="saludo1">Contribuyente:</td>
			      		<td colspan="3"  >
				  			<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:79%;" onKeyUp="return tabular(event,this) "  readonly>
				  			<input type="hidden" value="0" name="bt">
				  			<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
				  			<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
						  	<input type="hidden" value="1" name="oculto">
						</td>
			      	</tr>
			      	<tr>
				    	<td style="width:10%;" class="saludo1">Centro Costo:</td>
				  		<td style="width:30%;">
							<select name="cc"  onChange="validar()" style="width:80%;" onKeyUp="return tabular(event,this)">
							<?php
							$linkbd=conectar_bd();
							$sqlr="select *from centrocosto where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
										    {
											echo "<option value=$row[0] ";
											$i=$row[0];
								
											 if($i==$_POST[cc])
									 			{
												 echo "SELECTED";
												 }
											  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
											}	 	
							?>
						   </select>
				 		</td>
				 		
				 		<td >
				 			<input  type="button" name="agregact" value="Agregar" onClick="agregardetalle()">	      
			        		<input type="hidden" value="0" name="agregadet">
			        	</td>
			        </tr>
      			</table>
      		</td>
      		<td  colspan="2" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
      	</tr>
	</table>
	    </div>
 	</div>
 	<div class="tab">
 		<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	    <label for="tab-2">Afectacion Presupuestal</label>
	    <div class="content" style="overflow-x:hidden;"> 
         				<table class="inicio" style="overflow:scroll">
         					<tr><td class="titulos" colspan="3">Detalle Comprobantes</td></tr>
        					<tr>
                            	<td class="titulos2">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2">Valor</td>
                         	</tr>
                            <input type="hidden" id="totaldes" name="totaldes" value="<?php echo $_POST[totaldes]?>" readonly>
							
      						<?php
									$totaldes=0;
									$_POST[dcuenta]=array();
									$_POST[ncuenta]=array();
									$_POST[rvalor]=array();
									$sqlr="select *from pptoingssf where idrecibo=$_POST[idcomp] and vigencia=$_POST[vigencia] and cuenta!=''";
									
									$resd=mysql_query($sqlr,$linkbd);
									$iter='saludo1a';
									$iter2='saludo2';
									$cr=0;
									while($rowd=mysql_fetch_row($resd))
									{
								    $nresult=buscacuentapres($rowd[1],$rowd[4]);
											echo "<tr class=$iter>
												<td >
													<input name='dcuenta[]' value='$rowd[1]' type='text' size='20' readonly>
												</td>
												<td >
													<input name='ncuenta[]' value='$nresult' type='text' size='55' readonly>
												</td>
												<td >
													<input name='rvalor[]' value='".number_format($rowd[3],2)."' type='text' size='10' readonly>
												</td>
											</tr>";
									$var1=$rowd[3];
									$var1=$var1;
									$cuentavar1=$cuentavar1+$var1;
									$_POST[varto]=number_format($cuentavar1,2,".",",");
									 }
									 echo "<tr class=$iter><td> </td></tr>";
									echo "<tr >
											<td ></td>
											<td>Total:</td>
											<td >
												<input name='varto' id='varto' value='$_POST[varto]' size='10' readonly>
											</td>
										 </tr>";
								
							?>
							<input type='hidden' name='contrete' value="<?php echo $_POST[contrete] ?>" />
        				</table>
						
	   				</div>
 	</div>
 </div>
    
       <?php
           //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
<script>
			  document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe")				   		  	
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			 //*** ingreso
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingresossf($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();document.getElementById('valor').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[codingreso]="";
			  ?>
			  <script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
			  <?php
			  }
			 }
			 ?>
      
    <div class="subpantalla">
	   	<table class="inicio">
	   		<tr>
   	      		<td colspan="4" class="titulos">Detalle  Ingresos Sin Situacion de Fondos</td>
   	      	</tr>                  
			<tr>
				<td class="titulos2">Codigo</td>
				<td class="titulos2">Ingreso</td>
				<td class="titulos2">Valor</td>
				
			</tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		  
 		 unset($_POST[dcoding][$posi]);	
 		 unset($_POST[dncoding][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];			 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.valor.value="";	
				document.form2.ningreso.value="";				
				document.form2.codingreso.select();
		  		document.form2.codingreso.focus();	
		 </script>
         
         
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {		 
		 echo "<tr>
		 		<td class='saludo1' style='width:5%;'>
		 			<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' style='width:100%;' readonly>
		 		</td>
		 		<td class='saludo1' style='width:70%;'>
		 			<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' style='width:100%;'  readonly>
		 		</td>
		 		<td class='saludo1' style='width:20%;'>
		 			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text'  style='width:100%;'  readonly>
		 		</td>
		 	</tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr>
		 		<td style='width:5%;'>
		 		</td>
		 		<td class='saludo2' style='width:80%;'>Total</td>
		 		<td class='saludo1' style='width:20%;'>
		 			<input name='totalcf' type='text' style='width:100%;' value='$_POST[totalcf]'>
		 			<input name='totalc' type='hidden' value='$_POST[totalc]'>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td class='saludo1' style='width:5%;'>Son:</td>
		 		<td style='width:80%;'>
		 			<input name='letras' type='text' value='$_POST[letras]' style='width:100%;'>
		 		</td>
		 	</tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$fechaf=$_POST[fecha];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];
	$sqlr="delete from comprobante_cab where numerotipo=$consec and tipo_comp=20";
	mysql_query($sqlr,$linkbd);	
	$sqlr="delete from comprobante_det where numerotipo=$consec and tipo_comp=20";
	mysql_query($sqlr,$linkbd);	
	$sqlr="delete from tesossfingreso_cab where id_recaudo=$consec ";
	mysql_query($sqlr,$linkbd);	
	$sqlr="delete from tesossfingreso_det where id_recaudo=$consec ";
	mysql_query($sqlr,$linkbd);	
	$sqlr="delete from pptoingssf where idrecibo=$consec ";	
  	mysql_query($sqlr,$linkbd);
	 $sqlr="delete from pptocomprobante_cab where numerotipo=$consec and tipo_comp='21'";
	  mysql_query($sqlr,$linkbd);
    $sqlr="delete from pptocomprobante_det where  numerotipo=$consec and tipo_comp='21'";
		mysql_query($sqlr,$linkbd);		
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,20,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);	
	$idcomp=mysql_insert_id();
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($consec,21,'$fechaf','INGRESOS SSF $_POST[concepto]',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
	  mysql_query($sqlr,$linkbd);
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$_POST[vigencia]";
	 	$res2=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($row2=mysql_fetch_row($res2))
		 {
	    //**** busqueda concepto contable*****		
		$sqlri="Select * from conceptoscontables_det where codigo='".$row2[2]."' and modulo=4 and tipo='IS' ";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
				if($rowi[7]=='S')
				 {
				$valorcred=$_POST[dvalores][$x];
				$valordeb=0;
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('20 $consec','".$rowi[4]."','".$_POST[tercero]."','".$_POST[cc]."','Ingreso sin Situacion de Fondos ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
	mysql_query($sqlr,$linkbd);
//					echo "<br>".$sqlr;
				 }
				if($rowi[6]=='S')
				 {
			  $valordeb=$_POST[dvalores][$x];
				$valorcred=0;				   
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('20 $consec','".$rowi[4]."','".$_POST[tercero]."','".$_POST[cc]."','Ingreso sin Situacion de Fondos ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
	//			echo "<br>".$sqlr;
				$vi=$_POST[dvalores][$x];
				 }
		 }
//			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta =".$rowi[5]."";
			//mysql_query($sqlr,$linkbd);	
				 //****creacion documento presupuesto ingresos
	//		  $sqlr="insert into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[5]',$consec,$vi,'".$_SESSION[vigencia]."')";
  			 // mysql_query($sqlr,$linkbd);				  
		 }
	}	
	//************ insercion de cabecera recaudos ************
	$sqlr="insert into tesossfingreso_cab (id_recaudo,idcomp,fecha,vigencia,concepto,tercero,cc,valortotal,estado) values($consec,$idcomp,'$fechaf','".$_POST[vigencia]."','".strtoupper($_POST[concepto])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S')";	  
	mysql_query($sqlr,$linkbd);
	$idrec=$consec;
	//echo "Conc: $sqlr <br>";
	//************** insercion de consignaciones **************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
	$sqlr="insert into tesossfingreso_det (id_recaudo,ingreso,valor,estado) values($consec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table ><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
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
			$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$_POST[vigencia]'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
		  $vi=$_POST[dvalores][$x];
		  $sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[5]."' AND VIGENCIA='".$_POST[vigencia]."'";
		  mysql_query($sqlr,$linkbd);	
				 //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptoingssf (cuenta,idrecibo,valor,vigencia) values('$rowi[5]',$consec,$vi,'".$_POST[vigencia]."')";
  			  mysql_query($sqlr,$linkbd);	
			  
			if($rowi[5]!="" && $vi>0)
			{			
		 	$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[5]."','".$_POST[tercero]."','INGRESOS SSF',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',21,$consec)";
		 	mysql_query($sqlr,$linkbd); 			  
			}
		 }			 			 
		  echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso SSF con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php
		  }
	}	 
}
?>	
</form>
 </td></tr>
</table>
</body>
</html>