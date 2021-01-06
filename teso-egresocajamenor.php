<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function buscarp(e)
			{
				if (document.form2.rp.value!="")
				{
					document.form2.brp.value='1';
					document.form2.submit();
				}
			}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				 }
				else {alert("Falta informacion para poder Agregar");}
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{ 
					document.form2.agregadetdes.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
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
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.eliminad.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('eliminad');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				valoracuerdo=document.form2.valorac2.value;
				valortotal=document.form2.totalc.value;
				tipegreso = document.form2.tipoegreso.value;
				if(tipegreso == "apertura")
				{
					if(parseFloat(valoracuerdo) >= parseFloat(valortotal))
					{
						if (document.form2.fecha.value!='' && document.form2.detallegreso.value!='')
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
					else
					{
						alert('El valor del comprobante no debe ser mayor al acto administrativo');
					}
				}
				else
				{
					if(parseFloat(valoracuerdo) == parseFloat(valortotal))
					{
						if (document.form2.fecha.value!='' && document.form2.detallegreso.value!='')
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
					else
					{
						alert('El valor del comprobante no debe ser diferente al valor del reintegro');
					}
				}
	
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="ordenpago-ventana1.php?vigencia="+document.form2.vigencia.value;break;
						case '2':	document.getElementById('ventana2').src="cuentasbancarias-ventana01.php?tipoc=C";break;
						case '3':	document.getElementById('ventana2').src="cuentasbancarias-ventana01.php?tipoc=D";break;
						case '4':	document.getElementById('ventana2').src="reversar-egreso.php?vigencia="+document.form2.vigencia.value;break;
					}
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
					}
				}
			}
			function funcionmensaje()
			{
				var _cons=document.getElementById('idcomp').value;
				document.location.href = "teso-editaegresocajamenor.php?idegreso="+_cons;
			}
			function calcularpago()
			{
				//alert("dddadadad");
				valorp=document.form2.valor.value;
				document.form2.base.value=valorp-document.form2.iva.value;
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;	
	  			document.form2.submit();
			}
			function pdf()
			{
				document.form2.action="pdfegresocajamenor.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
function sumapagosant() 
{ 

 cali=document.getElementsByName('pagos[]');
 valrubro=document.getElementsByName('pvalores[]');
 sumar=0;
// document.form2.todos.checked=chkbox.checked;
for (var i=0;i < cali.length;i++) 
{ 
	if (cali.item(i).checked == true) 
	{
//		 alert('si'+i+' '+cali.item(i).value);
//	cali.item(i).checked = true;
	sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);	
	
//		alert("cabio"+habdesv.item(i).value);
	}
//		alert("cabio"+habdesv.item(i).value);
} 
//  		alert("cam");
	document.form2.sumarbase.value=sumar;	
	//alert('fjfjfjfjfjf'+sumar );
	 resumar();
} 
</script>
<script >
function resumar() 
{ 
 cali=document.getElementsByName('rubros[]');
 valrubro=document.getElementsByName('dvalores[]');
 sumar=0;
// document.form2.todos.checked=chkbox.checked;

for (var i=0;i < cali.length;i++) 
{ 
	if (cali.item(i).checked == true) 
	{
//		 alert('si'+i+' '+cali.item(i).value);
//	cali.item(i).checked = true;
	sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);	
//		alert("cabio"+habdesv.item(i).value);
	}
//		alert("cabio"+habdesv.item(i).value);
} 
//  		alert("cam");
document.form2.totalc.value=sumar;
document.form2.valor.value=sumar;
document.form2.valoregreso.value=sumar;
document.form2.submit();	
} 
</script>
<script>
function checktodos()
{
 cali=document.getElementsByName('rubros[]');
 valrubro=document.getElementsByName('dvalores[]');
 for (var i=0;i < cali.length;i++) 
 { 
	if (document.getElementById("todos").checked == true) 
	{
	 cali.item(i).checked = true;
 	 document.getElementById("todos").value=1;	 
	}
	else
	{
	cali.item(i).checked = false;
    document.getElementById("todos").value=0;
	}
 }	
 resumar() ;
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
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
	<tr class="cinta">
		<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-egresocajamenor.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='teso-buscaegresocajamenor.php'" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png"title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-gestioncajamenor.php'" class="mgbt"/></td>
	</tr>
</table>
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
	  //*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto])
{
	
	$linkbd=conectar_bd();
	$sqlr="select cuentacajamenor from tesoparametros";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[ceuntacajamenor]=$row[0];
	}
		$check1="checked";
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
		// $_POST[vigencia]=$vigusu; 		
		 $_POST[vigencia]=$vigusu; 		
		 $sqlr="select max(id) from tesoegresocajamenor";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[idcomp]=$consec;						 
}
?>
 <form name="form2" method="post" action=""> 
 <?php
 if($_POST[brp]=='1')
			 {
			  $nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  if($nresul!='')
			   {
			  $_POST[cdp]=$nresul;
			  //*** busca detalle cdp
			  $linkbd=conectar_bd();
  				$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo,pptorp.tercero, pptocdp.objeto from pptorp,pptocdp where pptorp.estado='S' and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] AND pptocdp.tipo_mov='201' AND pptorp.tipo_mov='201' AND pptocdp.vigencia=pptorp.vigencia order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[detallecdp]=$row[2];
				$_POST[tercero]=$row[7];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[regimen]=buscaregimen($_POST[tercero]);			
				$_POST[valorrp]=$row[5];
				$_POST[saldorp]=generaSaldoRP($_POST[rp],$_POST[vigencia]);
				$_POST[valor]=$row[6];
				/*if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.19),1);	
				 else
				 $_POST[iva]=0;	*/		
				$_POST[base]=$_POST[valor];				 
				$_POST[detallegreso]=$row[8];
				$_POST[valoregreso]=$_POST[valor];
				$_POST[valorretencion]=$_POST[totaldes];
				$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
				$_POST[valorcheque]=number_format($_POST[valorcheque],2);				
			  }
			 else
			 {
			  $_POST[cdp]="";
			  $_POST[detallecdp]="";
			  $_POST[tercero]="";
			  $_POST[ntercero]="";
			  }
			 }
 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				/*if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;	*/
				 $_POST[base]=$_POST[valor];				 
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
 
 ?>
    <table class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="12">Egreso caja menor</td>
        	<td class="cerrar" >
        		<a href="teso-principal.php">Cerrar</a>
        	</td>
      	</tr>
      	<tr >
		    <td style="width:11%;" class="saludo1" >Numero Egreso:</td>
        	<td style="width:15%;">
        		<input name="idcomp" type="text" style="width:90%;" value="<?php echo $_POST[idcomp]?>" readonly> 
        	</td>
			<td style="width:8%;" class="saludo1">Fecha: </td>
        	<td style="width:15%;">
        		<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   
        		<a href="#" onClick="displayCalendarFor('fc_1198971545');">
        			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
        		</a>
        	</td>
	  		<td style="width:8%;" class="saludo1">Vigencia: </td>
        	<td style="width:10%;">
        		<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> 
        	</td>
            <td class="saludo1" style="width:2.8cm;">Tipo Egreso:</td>
            <td style="width:14%">
                <select name="tipoegreso" id="tipoegreso" onChange="validar();" onKeyUp="return tabular(event,this)" style="width:100%">
                    <option value="">Seleccione ...</option>
                    <option value="apertura" <?php if($_POST[tipoegreso]=='apertura') echo "SELECTED"?>>Apertura</option>
                    <option value="reintegro" <?php if($_POST[tipoegreso]=='reintegro') echo "SELECTED"?>>Reintegro</option>
                </select>
            </td>
        </tr>
        <?php
        $linkbd=conectar_bd();
        if($_POST[tipoegreso]=='apertura')
        {
            echo "
                    <tr>
                        <td class='saludo1'>Acto Administrativo:</td>
                        <td  valign='middle' style='width:20%;'>
                        <input type='hidden' name='consulta' id='consulta' value='$_POST[consulta]'>
                        <select name='acuerdo' style='width:100%;' onChange='validar()' onKeyUp='return tabular(event,this)'>
                        <option value='-1'>Seleccione</option>
            ";
            $sqlr="Select * from tesoacuerdo where estado='S'";
            $resp = mysql_query($sqlr,$linkbd);
            
            while ($row =mysql_fetch_row($resp)) 
						{
                echo "<option value=$row[0] ";
                $i=$row[0];
                if($i==$_POST[acuerdo])
                {
                    echo "SELECTED";
                    $_POST[valorac]=$row[5];
                    $_POST[valorac2]=$row[5];
                    $_POST[valorac]=number_format($_POST[valorac],2,'.',',');
                }
                echo ">".$row[1]."-".$row[2]."</option>";	
            }
            echo "
                    </select>
                    <td style='width:10%;' class='saludo1'>
				   					<input type='hidden' value='1'>Valor Acuerdo:</td>
                    <td style='width:10%;'>
                    <input name='valorac' type='text' value='$_POST[valorac]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' readonly>
                    <input type='hidden'  id='valorac2' name='valorac2' value='$_POST[valorac2]'>
                    </td>  
                    ";	
            
        }
        else
        {
						echo "
						<tr>
								<td class='saludo1'>Reintegro:</td>
								<td  valign='middle' style='width:20%;'>
								<input type='hidden' name='consultareintegro' id='consultareintegro' value='$_POST[consultareintegro]'>
								<select name='reintegro' style='width:100%;' onChange='validar()' onKeyUp='return tabular(event,this)'>
												<option value='-1'>Seleccione</option>
						";
						$sqlr="Select * from tesocontabilizacajamenor where finaliza='1'";
						$resp = mysql_query($sqlr,$linkbd);
						
						while ($row =mysql_fetch_row($resp)) 
						{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[reintegro])
								{
										echo "SELECTED";
										$_POST[valorreintegro]=$row[3];
										$_POST[valorreintegro2]=$row[3];
										$_POST[valorreintegro]=number_format($_POST[valorreintegro],2,'.',',');
								}
								echo ">".$row[0]."-".$row[1]."</option>";	
						}
						echo "
						</select>
						<td style='width:10%;' class='saludo1'>
						<input type='hidden' value='1'>Valor Reintegro:</td>
						<td style='width:10%;'>
						<input name='valorreintegro' type='text' value='$_POST[valorreintegro]' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' readonly>
						<input type='hidden'  id='valorreintegro2' name='valorac2' value='$_POST[valorreintegro2]'>
						</td>  
						";	
				}
				if($_POST[tipoegreso]!='')
				{
					?>
					<td class="saludo1" style="width:2.8cm;">Forma de Pago:</td>
					<td style="width:14%">
						<select name="tipop" id="tipop" onChange="validar();" onKeyUp="return tabular(event,this)" style="width:100%">
							<option value="">Seleccione ...</option>
							<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
								<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
						</select> 
					</td>
					</tr>
					<?php
				}
				if($_POST[tipop]=='cheque') //**** if del cheques
				{
					if($_POST[escuentas]=='' || $_POST[escuentas]=='tran')
					{
						$_POST[escuentas]='che';
						$_POST[cb]='';
						$_POST[nbanco]='';
						$_POST[banco]='';
						$_POST[tcta]='';
						$_POST[ter]='';
						$_POST[ncheque]='';
					}
						echo" 
								<tr>
							<td class='saludo1'>Cuenta Bancaria:</td>
							<td>
							<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%'/>
							&nbsp;<a onClick=\"despliegamodal2('visible','2');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'><img src='imagenes/find02.png' style='width:20px;'/></a>
															</td>
															<td colspan='2'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%' readonly></td>
						<td class='saludo1'>Cheque:</td>
																<td>
							<input type='text' id='ncheque' name='ncheque' value='$_POST[ncheque]' style='width:100%'/>
							<input type='hidden' id='nchequeh' name='nchequeh' value='$_POST[nchequeh]'/>
						</td>
						</tr>
														<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
														<input type='hidden' name='tcta' id='tcta' value='$_POST[tcta]'/>
														<input type='hidden' name='ter' id='ter' value='$_POST[ter]'/>";
					//-----------Asignacion del consecutivo de cheque----------------------------
					if($_POST[cb]!=''){
						$sqlc="select cheque from tesocheques where cuentabancaria='$_POST[cb]' and estado='S' order by cheque asc";
						//echo $sqlc;
						$resc = mysql_query($sqlc,$linkbd);
						$rowc =mysql_fetch_row($resc);
						if($rowc[0]==''){
							
						}else{
							echo "<script>document.form2.ncheque.value='".$rowc[0]."';</script>";
						}
					}	
					
					
				}//cierre del if de cheques
				if($_POST[tipop]=='transferencia')//**** if del transferencias
				{
					if($_POST[escuentas]=='' || $_POST[escuentas]=='che')
					{
						$_POST[escuentas]='tran';
						$_POST[cb]='';
						$_POST[nbanco]='';
						$_POST[banco]='';
						$_POST[tcta]='';
						$_POST[ter]='';
						$_POST[ntransfe]='';
					}
						echo"
							<tr>
							<td class='saludo1'>Cuenta Bancaria:</td>
							<td>
																		<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%'/>
							&nbsp;<a onClick=\"despliegamodal2('visible','3');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'><img src='imagenes/find02.png' style='width:20px;'/></a>
																</td>
																<td colspan='2'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%' readonly></td>
						<td class='saludo1'>No Transferencia:</td>
																<td><input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:100%'></td>
						</tr>
					<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
													<input type='hidden' name='tcta' id='tcta' value='$_POST[tcta]'/>
													<input type='hidden' name='ter' id='ter' value='$_POST[ter]'/>";
				}//cierre del if de cheques
        ?>
        <tr>
        	<td style="width:11%;" class="saludo1">Registro:</td>
        	<td style="width:15%;">
        		<input name="rp" type="text" style="width:80%;" value="<?php echo $_POST[rp]?>"  onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" >
        		<input type="hidden" value="0" name="brp">
            	<a href="#" onClick="mypop=window.open('registro-ventana.php?vigencia=<?php echo $_POST[vigencia]?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">
            		<img src="imagenes/buscarep.png" align="absmiddle" border="0">
            	</a>        
            </td>
	  		<td style="width:8%;" class="saludo1">CDP:</td>
	  		<td style="width:15%;">
				<input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>"  readonly>
			</td>
	  		<td style="width:8%;" class="saludo1">Detalle RP:</td>
	  		<td colspan="7">
				<input type="hidden" name="saldorp" id="saldorp" value="<?php echo $_POST[saldorp];?>">
				<input type="text" id="detallecdp" name="detallecdp" style="width:100%;" value="<?php echo $_POST[detallecdp]?>"  readonly>
			</td>
		</tr> 
	  	<tr>
	  		<td style="width:11%;" class="saludo1">Centro Costo:</td>
	  		<td style="width:15%;">
					<select name="cc"  onChange="validar()" style="width:90%;" onKeyUp="return tabular(event,this)" >
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
	     	<td style="width:8%;" class="saludo1">Tercero:</td>
          	<td style="width:15%;" >
          		<input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" >
          		<input type="hidden" value="0" name="bt">
          			<a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">
          				<img src="imagenes/buscarep.png" align="absmiddle" border="0">
          			</a>
           	</td>
          	<td colspan="6">
          		<input  id="ntercero" style="width:100.5%;"  name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  readonly>
          	</td>
        </tr>
        <tr>
        	<td style="width:11%;" class="saludo1">Detalle Orden de Pago:</td>
        	<td colspan="8">
				<input type="text" id="detallegreso" name="detallegreso" style="width:100.45%;" value="<?php echo $_POST[detallegreso]?>" >
			</td>
		</tr>
	  	<tr>
	  		<td style="width:11%;" class="saludo1">Valor RP:</td>
	  		<td style="width:15%;">
	  			<input type="text" id="valorrp" name="valorrp" style="width:90%;" value="<?php echo $_POST[valorrp]?>" onKeyUp="return tabular(event,this)" readonly>
	  		</td>
	  		<td style="width:8%;" class="saludo1" >Valor a Pagar:</td>
	  		<td style="width:15%;">
	  			<input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>"  readonly> 
	  			<input type="hidden" value="1" name="oculto">
					<input type="hidden" name="escuentas" id="escuentas" value="<?php echo $_POST[escuentas];?>"/>
	  		</td>
	  	
	  	</tr>
    </table>
      <?php
	  if(!$_POST[oculto])
	   {
		?>
         <script>
			  document.form2.fecha.focus();
			 document.form2.fecha.select();</script>
        <?php   
		}
	  ?>
      		
      <?php
		 //***** busca tercero
			 if($_POST[brp]=='1')
			 {
			  $nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  if($nresul!='')
			   {
			  $_POST[cdp]=$nresul;
  				?>
			  <script>
			  document.getElementById('cc').focus();
			   document.getElementById('cc').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[cdp]="";
			  ?>
			  <script>
				 alert("Registro Presupuestal Incorrecto");
				 document.form2.rp.select();
		  		//document.form2.rp.focus();	
			  </script>
			  <?php
			  }
			 }
			 
			  if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
			  if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;	
				 $_POST[base]=$_POST[valor]-$_POST[iva];
  				?>
			  <script>
			  document.getElementById('detallegreso').focus();document.getElementById('detallegreso').select();</script>
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
			?>  	      
	  <div class="subpantallac2">
      <?php
	  if($_POST[brp]=='1')
	  {
		  $_POST[brp]=0;
	  //*** busca contenido del rp
	  $_POST[dcuentas]=array();
  	  $_POST[dncuentas]=array();
	  $_POST[dvalores]=array();
	  $_POST[drecursos]=array();
	  $_POST[dnrecursos]=array();	  	  
	  $_POST[rubros]=array();	
	  $_POST[dcodssf]=array();  	
	  $_POST[dcodssfnom]=array();  	  
	  $sqlr="select *from pptorp_detalle where pptorp_detalle.consvigencia=(select pptorp.consvigencia from pptorp where consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] ) and pptorp_detalle.vigencia=$_POST[vigencia]";
	  //echo $sqlr;
	  $res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
		$_POST[dcuentas][]=$r[3];
	  $_POST[dvalores][]=generaSaldoRPxcuenta($r[2],$r[3],$_POST[vigencia]);
	   $_POST[dncuentas][]=buscacuentapres($r[3],2);	   
	   $_POST[rubros][]=$r[3];	   
	   $ind=substr($r[3],0,1);
//	   echo "i".$ind;
			if($ind=='R' || $ind=='r')
					 {						
					$ind=substr($r[3],1,1);						  
					 }	
			  if ($ind=='2')
			  $sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldoscdprp,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$r[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo and pptocuentaspptoinicial.vigencia=".$_POST[vigencia]."";
			  if ($ind=='3' || $ind=='4')
			  $sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldoscdprp,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$r[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv and pptocuentaspptoinicial.vigencia=".$_POST[vigencia]."";
			  //echo $sqlr;
			  $res2=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res2);
    if($row[1]!='' || $row[1]!=0)
			     {
				  $_POST[drecursos][]=$row[0];
				  $_POST[dnrecursos][]=$row[2];
				//  $_POST[valor]=$row[1];			  
				 }
				 else
				  {
				  $_POST[drecurso][]="";
				  $_POST[dnrecurso][]="";
				  }	 
				
		 }
	  }
	  ?>
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
       <?php
	   if($_POST[todos]==1)
	    $checkt='checked';
		else
	    $checkt='';
	   ?>
		<tr>
			<td class="titulos2">Cuenta</td>
			<td class="titulos2">Nombre Cuenta</td>
			<td class="titulos2">Recurso</td>
			<td class="titulos2">Valor</td>
			<td class="titulos2">
				<input type="checkbox" id="todos" name="todos" onClick="checktodos()" value="<?php echo $_POST[todos]?>" <?php echo $checkt ?>>
				<input type='hidden' name='elimina' id='elimina'  >
			</td>
		</tr>
<?php
			$_POST[totalc]=0;
			$iter='saludo1a';
			$iter2='saludo2';
		 for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 {		
		 $chk=''; 
		$ch=esta_en_array($_POST[rubros],$_POST[dcuentas][$x]);
			if($ch=='1')
			 {
			 $chk="checked";
			 //echo "ch:$x".$chk;
			 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
			// $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
			 }
             echo "
                <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
                <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
								<input type='hidden' name='drecursos[]' value='".$_POST[drecursos][$x]."'/>
								<input type='hidden' name='dnrecursos[]' value='".$_POST[dnrecursos][$x]."'/>
								<tr class='$iter'>
									 <td>".$_POST[dcuentas][$x]."</td>
									 <td>".$_POST[dncuentas][$x]."</td>
									 <td>".$_POST[dnrecursos][$x]."</td>									 
									 <td>
											<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='20' onBlur='resumar()' onDblClick='llamarventanaegre(this,$x);' >
									 </td>
									 <td>
											<input type='checkbox' name='rubros[]' value='".$_POST[dcuentas][$x]."' onClick='resumar()' $chk>
									 </td>
								</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." PESOS M/CTE";
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
	    echo "<tr><td colspan='2'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'><input name='valoregreso' type='hidden' value='$_POST[valoregreso]'></td></tr><tr><td  class='saludo1'>Son:</td> <td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
        document.form2.valoregreso.value=<?php echo $_POST[totalc];?>;		
        document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;		
		//calcularpago();
        </script>
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	$sqlrCajaMenor = "select cuentacajamenor from tesoparametros";
	$resCajaMenor=mysql_query($sqlrCajaMenor,$linkbd);
	$rowCajaMenor=mysql_fetch_row($resCajaMenor);
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
	if($bloq>=1)
	{
		$sqlr="select count(*) from tesoegresocajamenor where id=$_POST[idcomp] ";	
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		{
			$numerorecaudos=$r[0];
		}
		if($numerorecaudos==0)
		{
			//************CREACION DEL COMPROBANTE CONTABLE ************************
			//***busca el consecutivo del comprobante contable
			$consec=0;
			$sqlr="select max(id) from tesoegresocajamenor";
			//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			while($r=mysql_fetch_row($res))
			{
	  		$consec=$r[0];	  
	 		}
	 		$consec+=1;
			//***cabecera comprobante SSF GASTO
	 		$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,37,'$fechaf','$_POST[detallegreso]',0,$_POST[totalc],$_POST[totalc],0,'1')";
			mysql_query($sqlr,$linkbd);
			//echo "<br>$sqlr ";
			$_POST[idcomp]=$idcomp;
			echo "<input type='hidden' name='ncomp' value='$idcomp'>";
			//******************* DETALLE DEL COMPROBANTE CONTABLE  *********************
			for ($y=0;$y<count($_POST[rubros]);$y++)
			{
				for($x=0;$x<count($_POST[dcuentas]);$x++)
				{
					if($_POST[dcuentas][$x]==$_POST[rubros][$y])  
					{
						//CONTABILIZACION
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('37 $consec','$_POST[banco]','".$_POST[tercero]."','".$_POST[cc]."','Egreso caja menor ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
						echo $sqlr;
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('37 $consec','$rowCajaMenor[0]','".$_POST[tercero]."','".$_POST[cc]."','Egreso caja menor ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
					}
				}
			}
			//**************FIN DE CONTABILIDAD	
			//**************PPTO AFECTAR LAS CUENTAS PPTALES
		 	for ($y=0;$y<count($_POST[rubros]);$y++)
		  	{
				for($x=0;$x<count($_POST[dcuentas]);$x++)
		 		{
					if($_POST[dcuentas][$x]==$_POST[rubros][$y])
					{
							if($_POST[tipoegreso]=='reintegro')
							{
								$sqlr2="update pptorp_detalle set saldo=saldo-".$_POST[dvalores][$x]." where cuenta='".$_POST[dcuentas][$x]."' and consvigencia=".$_POST[rp]." and vigencia=".$vigusu;
								$res2=mysql_query($sqlr2,$linkbd); 
								//****creacion documento presupuesto ingresos
								$sqlr="insert into pptoegresocajamenor (cuenta,idegreso,valor,vigencia) values('".$_POST[dcuentas][$x]."',$consec,".$_POST[dvalores][$x].",'".$vigusu."')";
								mysql_query($sqlr,$linkbd);	
								//	echo "<br>$sqlr2";
							}
							
					}
				}
		 	}
			 //***ACTUALIZACION  DEL REGISTRO
			if($_POST[tipoegreso]=='reintegro')
			{
				$sqlr="update pptorp set saldo=saldo-".$_POST[valoregreso]." where consvigencia=".$_POST[rp]." and vigencia=".$vigusu;
				$res=mysql_query($sqlr,$linkbd);
			}
			if($_POST[tipop]=='cheque'){$valtipo=$_POST[ncheque];}
			else{$valtipo=$_POST[ntransfe];}
			///*******INCIO DE TABLAS DE TESORERIA **************
			//**** ENCABEZADO ORDEN DE PAGO
			$sqlr="insert into tesoegresocajamenor (id,fecha,vigencia,id_rp,tipo_egreso,actoadministrativo,valoracto,reintegro,valor_reintegro,cuentabanco,cc,tercero,detalle,valorrp,valorpagar,cuentapagar,estado,formapago,numformapago) values($consec,'$fechaf',".$vigusu.",$_POST[rp],'$_POST[tipoegreso]','$_POST[acuerdo]','$_POST[valorac2]','$_POST[reintegro]','$_POST[valorreintegro2]',$_POST[banco],'$_POST[cc]','$_POST[tercero]','$_POST[detallegreso]',$_POST[valorrp],$_POST[totalc],'$_POST[cuentapagar]','S','$_POST[tipop]','$valtipo')";
			mysql_query($sqlr,$linkbd);
			$idorden=mysql_insert_id();
			//****** DETALLE ORDEN DE PAGO
	 		for ($y=0;$y<count($_POST[rubros]);$y++)
	  	{
				for($x=0;$x<count($_POST[dcuentas]);$x++)
	 			{
		  		if($_POST[dcuentas][$x]==$_POST[rubros][$y])
			  	{
 	  				$sqlr="insert into tesoegresocajamenor_det (id_egreso,cuentap,cc,valor,estado) values ($consec,'".$_POST[dcuentas][$x]."','".$_POST[cc]."',".$_POST[dvalores][$x].",'S')";
						//	  echo "<br>".$sqlr;
						if (!mysql_query($sqlr,$linkbd))
						{
		 					echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
							//	 $e =mysql_error($respquery);
		 					echo "Ocurrio el siguiente problema:<br>";
  	 					//echo htmlentities($e['message']);
  	 	 				echo "<pre>";
     					///echo htmlentities($e['sqltext']);
    					// printf("\n%".($e['offset']+1)."s", "^");
     	 				echo "</pre></center></td></tr></table>";
		 				}
  					else
  		 			{
		  				//echo "<script>despliegamodalm('visible','1','Se ha almacenado el Egreso con Exito');</script>";
		  				?>
		  				<script>
								document.form2.numero.value="";
								document.form2.valor.value=0;
								document.form2.oculto.value=1;
		  				</script>
		  				<?php
		  			}
					}
				}
			}
		}
  }
 	else
  {
  	echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
  }
  //****fin if bloqueo  
}//************ FIN DE IF OCULTO************
?>
<div id="bgventanamodal2">
			<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
			</div>
</div>		
</form>
 </td></tr>  
</table>
</body>
</html>	 