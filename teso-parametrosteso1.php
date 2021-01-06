<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			jQuery(function($){ $('#vltmindustria').autoNumeric('init');});
			function guardar()
			{
	
				if (confirm("Esta Seguro de Guardar"))
				{
					document.form2.oculto.value=2;
					document.form2.submit();
				}
			}
			function despliegamodal2(_valor,v)
			{
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if(_valor=="hidden"){
						document.getElementById('ventana2').src="";
						document.form2.submit();
					}
					else {
						if(v==1){
							document.getElementById('ventana2').src="cuenta-abono.php";
						}
						else if(v==2)
						{
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=solicita";
						}
						else if(v==3)
						{
							document.getElementById('ventana2').src="cuentas-ventana3.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==4)
						{
							document.getElementById('ventana2').src="cuentas-ventana4.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==5)
						{
							document.getElementById('ventana2').src="cuenta-cajamenor.php";
						}
					}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
				</IFRAME>
			</div>
		</div>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
   			<tr>
  				<td colspan="3" class="cinta">
				<a><img src="imagenes/add.png" title="Nuevo" onclick="location.href='teso-parametrosteso.php'" class="mgbt"/></a>
				<a><img src="imagenes/guarda.png" title="Guardar" class="mgbt" onClick="guardar()" /></a>
				<a><img src="imagenes/buscad.png" class="mgbt1"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"/></a>
				</td>
    		</tr>
    	</table>		  
		<form name="form2" method="post" >
			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if($_POST[oculto]=="")
				{
  					$_POST[diacorte]=1;
					$_POST[tabgroup1]=1;
					$angu=array();
					$selregis="SELECT id_comprobante,id_cargo FROM firmas WHERE vigencia='$vigusu'";
					$resul=mysql_query($selregis,$linkbd);
					while($filas=mysql_fetch_row($resul))
					{
						$angu[]="$filas[0]-$filas[1]";
					}
  					$sqlr="SELECT * FROM tesoparametros";
		 			$resp = mysql_query($sqlr,$linkbd);
				    while ($row =mysql_fetch_row($resp)) 
				    {						 
					 	$_POST[tercero]=$row[1];
					 	$_POST[ntercero]=$row[4];
					 	$_POST[agepres]=$row[2];
					 	$_POST[cuenta]=$row[5];
					 	$_POST[ncuenta]=buscacuenta($row[5]);
					 	$_POST[tmindustria]=$row[6];
						$_POST[vltmindustria]=$row[6];
						$_POST[cbb]=$row[7];
						$_POST[impben]=$row[8];
						$_POST[intpredial]=$row[9];
						$_POST[cuentacaja]=$row[10];
						$_POST[contabiliza]=$row[11];
						$_POST[imptesorero]=$row[12];
						$_POST[impalcalde]=$row[13];
						$_POST[ncuentacaja]=buscacuenta($row[10]);
						$_POST[desindcom]=$row[15];
						$_POST[desavitab]=$row[16];
						$_POST[desbomber]=$row[17];
						$_POST[intindcom]=$row[18];
						$_POST[intavitab]=$row[19];
						$_POST[intbomber]=$row[20];
						$_POST[cuenta_abono]=$row[21];
						$_POST[ncuenta_abono]=buscacuenta($row[21]);
						$_POST[ncuenta_caja_menor]=$row[22];
						$_POST[ncuenta_caja_menor]=buscacuenta($row[22]);
					}
    				$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[cobrorecibo]=$row[2];
						$_POST[recibovalor]=$row[1];
					 	$_POST[ingresos]=$row[0];	 
					}
					$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='COBRO_ALUMBRADO' AND descripcion_valor='$vigusu'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[cobroAlumbrado]=$row[2];
						$_POST[alumbradovalor]=$row[1];
					 	$_POST[ingresosAlumbrado]=$row[0];	 
					}
 					$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='BASE_PREDIAL' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[basepredial]=$row[0];}
					$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='BASE_PREDIALAMB' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[basepredialamb]=$row[0];}	
					$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='DESCUENTO_CON_DEUDA' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[descuentoConDeuda]=$row[0];}	
 					$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='NORMA_PREDIAL' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[aplicapredial]=$row[0];}
					$sqlr="SELECT valor_inicial,valor_final,descripcion_valor FROM dominios WHERE nombre_dominio='CUENTA_MILES' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[cuentamil]=$row[0];
 	 					$_POST[ncuentamil]=buscacuenta($row[0]);
					}	
					$sqlr="SELECT valor_inicial,valor_final,tipo FROM dominios WHERE nombre_dominio='DESC_INTERESES' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
	 					$_POST[vigmaxdescint]=$row[0];
 	 					$_POST[porcdescint]=$row[1];
	 					$_POST[aplicadescint]=$row[2];
					}
 				}
				switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';
                }
 				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		$_POST[regimen]=buscaregimen($_POST[tercero]);	
			  		if($nresul!='')
			   		{
			  			$_POST[ntercero]=$nresul;
  						if($_POST[regimen]==1){$_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);}
				 		else {$_POST[iva]=0;}
				 		$_POST[base]=$_POST[valor]-$_POST[iva];				 
			  		}
			 		else {$_POST[ntercero]="";}
			 	}
			?>
  			<table width="160%" class="inicio" align="center" >
    			<tr>
      				<td class="titulos" colspan="8">Parametrizacion</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
    			</tr>
    			<tr >
      				<td style="width:12%;" class="saludo1" >Tesorero:</td>
      				<td style="width:13%;">
      					<input id="tercero" name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:80%;" onKeyUp="return tabular(event,this)"/>&nbsp;
      					<a onClick="mypop=window.open('tercerosgral-ventana.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=tercero&nobjeto=ntercero','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">
      						<img src="imagenes/buscarep.png" align="absmiddle" border="0">
      					</a>&nbsp;
                    </td>
                    <td colspan="4">
                        <input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%;" onKeyUp="return tabular(event,this)">     
                   	</td>
                </tr>
                <tr>
          			<td style="width:12%;" class="saludo1">A&ntilde;os Prescripcion Predial:</td>
                    <td style="width:13%;">
                    	<input type="number" name="agepres" style="width:80%;" value="<?php echo $_POST[agepres]?>">
                    </td>
             	
		  			<td style="width:10%;" class="saludo1">Ingreso Recibo de Caja:</td>
					<td colspan="3">
						<select name="ingresos" id="ingresos" style="width:100%;">
				  			<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="SELECT * FROM tesoingresos WHERE estado='S' ORDER BY codigo";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if("$row[0]"==$_POST[ingresos])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[0] $row[1]</option>";
				 						$_POST[ingresos]=$row[0];
				 					}
									else{echo "<option value='$row[0]'>$row[0] $row[1]</option>";}
			     				}   
							?>
		  				</select>
					</td>
              	</tr>
                <tr>
          			<td style="width:10%;" class="saludo1">Aplicar Cobro Recibo CajaFijo:</td>
    				<td style="width:13%;">
                    	<select name="cobrorecibo" style="width:80%;">
       		  				<option value="">Seleccione ...</option>
			  				<option value="S" <?php if($_POST[cobrorecibo]=='S') echo "SELECTED"?>>Aplicar (S)</option>
			  				<option value="N" <?php if($_POST[cobrorecibo]=='N') echo "SELECTED"?>>No Aplicar (N)</option>
       					</select>
       				</td>
	  				<td style="width:10%;" class="saludo1">Valor Recibo de Caja:</td>
                    <td style="width:9%;">
                    	<input name="recibovalor" type="text" value="<?php echo $_POST[recibovalor];?>">
                    </td>
					<td style="width:10%;" class="saludo1">Ingreso Alumbrado:</td>
					<td colspan="1">
						<select name="ingresosAlumbrado" id="ingresosAlumbrado" style="width:100%;">
				  			<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="SELECT * FROM tesoingresos WHERE estado='S' ORDER BY codigo";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if("$row[0]"==$_POST[ingresosAlumbrado])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[0] $row[1]</option>";
				 						$_POST[ingresosAlumbrado]=$row[0];
				 					}
									else{echo "<option value='$row[0]'>$row[0] $row[1]</option>";}
			     				}   
							?>
		  				</select>
					</td>
    			</tr>
				<tr>
					<td style="width:10%;" class="saludo1">Aplicar Cobro Alumbrado Publico:</td>
    				<td style="width:13%;">
                    	<select name="cobroAlumbrado" style="width:80%;">
       		  				<option value="">Seleccione ...</option>
			  				<option value="S" <?php if($_POST[cobroAlumbrado]=='S') echo "SELECTED"?>>Aplicar (S)</option>
			  				<option value="N" <?php if($_POST[cobroAlumbrado]=='N') echo "SELECTED"?>>No Aplicar (N)</option>
       					</select>
       				</td>
	  				<td style="width:10%;" class="saludo1">Valor Cobro Alumbrado Publico:</td>
                    <td style="width:9%;">
                    	<input name="alumbradovalor" type="text" value="<?php echo $_POST[alumbradovalor];?>">
                    </td>
					<td>
						<p>Valor por mil sobre el avaluo</p>
					</td>
				</tr>
				<tr>                	
					<td style="width:10%;" class="saludo1">Cuenta Traslado Bancarios:</td>
          			<td style="width:13%;">
                    	<input type="text" id="cuenta" name="cuenta" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" placeholder='cuenta contable' onKeyDown="llamarventanacta(event)"/>&nbsp;<a href="#" onClick="mypop=window.open('cuentas-ventanageneral.php?objeto=cuenta&nobjeto=ncuenta','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
         			</td>
                    <td colspan="4">
                        <input name="ncuenta" id="ncuenta" type="text" style="width:100%;" value="<?php echo $_POST[ncuenta]?>" readonly/>
                  	</td>
               	</tr>
                <tr>
                  	<td style="width:10%;" class="saludo1">Base Sobretasa Bomberil :</td>
					<td style="width:13%;">
    					<select name="basepredial" style="width:80%;">
       		  				<option value="">Seleccione ...</option>
			  				<option value="1" <?php if($_POST[basepredial]=='1') echo "SELECTED"?>>Base Avaluo Predio</option>
			  				<option value="2" <?php if($_POST[basepredial]=='2') echo "SELECTED"?>>Base Predial</option>
        				</select>
						
    				</td> 
    				<td style="width:10%;" class="saludo1">Base Sobretasa Ambiental :</td>
                    <td style="width:9%;">
                        <select name="basepredialamb" >
                            <option value="">Seleccione ...</option>
                            <option value="1" <?php if($_POST[basepredialamb]=='1') echo "SELECTED"?>>Base Avaluo Predio</option>
                             <option value="2" <?php if($_POST[basepredialamb]=='2') echo "SELECTED"?>>Base Predial</option>
                        </select>
                    </td>
					<td style="width:10%;" class="saludo1">Descuento con deuda de vigencias anteriores? :</td>
                    <td style="width:9%;">
                        <select name="descuentoConDeuda" >
                            <option value="">Seleccione ...</option>
                            <option value="S" <?php if($_POST[descuentoConDeuda]=='S') echo "SELECTED"?>>Si tiene descuento</option>
                             <option value="N" <?php if($_POST[descuentoConDeuda]=='N') echo "SELECTED"?>>No tiene descuento</option>
                        </select>
                    </td>
				</tr>
				
    			<tr>
                	<td style="width:10%;" class="saludo1">Cuenta a Miles:</td>
          			<td style="width:13%;">
                    	<input type="text" id="cuentamil" name="cuentamil" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactam(event)" value="<?php echo $_POST[cuentamil]?>" onClick="document.getElementById('cuentamil').focus();document.getElementById('cuentamil').select();" placeholder='cuenta contable' onKeyDown="llamarventanacta(event)">&nbsp;<a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentamil&nobjeto=ncuentamil','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                   	</td>
                    <td colspan="4">
                    	<input id="ncuentamil" name="ncuentamil" style="width:100%;" type="text" value="<?php echo $_POST[ncuentamil]?>" readonly/>
                    </td>
        			
             	</tr>
	   			<tr>
	   				<td style="width:10%;" class="saludo1">Aplicar Desc Intereses:</td>
    				<td style="width:13%;">
                    	<select name="aplicadescint" style="width:80%;">
       		  				<option value="">Seleccione ...</option>
			  				<option value="S" <?php if($_POST[aplicadescint]=='S') echo "SELECTED"?>>Aplicar (S)</option>
			  				<option value="N" <?php if($_POST[aplicadescint]=='N') echo "SELECTED"?>>No Aplicar (N)</option>
        				</select>
       				</td>
	  				<td style="width:8%;" class="saludo1">Vigencia Max Desc Intereses:</td>
                    <td style="width:9%;">
                    	<input name="vigmaxdescint" type="text" value="<?php echo $_POST[vigmaxdescint];?>"  maxlength="4">
                    </td>
      				<td style="width:10%;" class="saludo1">% Desc Intereses:</td>
                    <td style="width:5%;">
                    	<input name="porcdescint" type="text" style="width:94%;" value="<?php echo $_POST[porcdescint];?>" >
                    </td>
              	</tr>
	 			<tr>
          			<td style="width:10%;" class="saludo1">Aplicar Norma Predial:</td>
    				<td style="width:13%;">
                    	<select name="aplicapredial" style="width:80%;">
       		  				<option value="">Seleccione ...</option>
			 				<option value="S" <?php if($_POST[aplicapredial]=='S') echo "SELECTED"?>>Aplicar (S)</option>
			  				<option value="N" <?php if($_POST[aplicapredial]=='N') echo "SELECTED"?>>No Aplicar (N)</option>
        				</select>
       				</td>
                    <td style="width:10%;" class="saludo1">Tarifa Minima Industria:</td>
               		<td style="width:9%;">
                    	<input type="hidden" name="tmindustria" id="tmindustria" value="<?php echo "$_POST[tmindustria]";?>"/>
                    	<input type="text" name="vltmindustria" id="vltmindustria" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('tmindustria','vltmindustria');return tabular(event,this);" value="<?php echo $_POST[vltmindustria]; ?>" style='text-align:right;' />
                    </td>
					<td class="saludo1">Imprimir Beneficiario:</td>
					<td>
						<select name="impben" style="width:100%;">
       		  				<option value="">Seleccione ...</option>
			 				<option value="S" <?php if($_POST[impben]=='S') echo "SELECTED"?>>Imprimir(S)</option>
			  				<option value="N" <?php if($_POST[impben]=='N') echo "SELECTED"?>>No Imprimir(N)</option>
        				</select>
					</td>
	   			</tr>
				<tr>
					<td class="saludo1">Cobrar impuesto bomberil?</td>
					<td>
						<select name="cbb" style="width:80%;">
       		  				<option value="">Seleccione ...</option>
			 				<option value="S" <?php if($_POST[cbb]=='S') echo "SELECTED"?>>Aplicar (S)</option>
			  				<option value="N" <?php if($_POST[cbb]=='N') echo "SELECTED"?>>No Aplicar (N)</option>
        				</select>
					</td>
					<td class="saludo1">Interes predial:</td>
					<td>
						<select name="intpredial" style="width:100%;">
       		  				<option value="">Seleccione ...</option>
			 				<option value="inicioanio" <?php if($_POST[intpredial]=='inicioanio') echo "SELECTED"?>>Inicio a&ntildeo</option>
			  				<option value="finalincentivo" <?php if($_POST[intpredial]=='finalincentivo') echo "SELECTED"?>>Final de descuento incentivo</option>
        				</select>
					</td>
					<td class="saludo1">Imprimir tesorero:</td>
					<td>
						<select name="imptesorero" style="width:100%;">
       		  				<option value="">Seleccione ...</option>
			 				<option value="S" <?php if($_POST[imptesorero]=='S') echo "SELECTED"?>>Imprimir(S)</option>
			  				<option value="N" <?php if($_POST[imptesorero]=='N') echo "SELECTED"?>>No Imprimir(N)</option>
        				</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Cuenta Caja </td>
					<td style="width:13%;">
                    	<input type="text" id="cuentacaja" name="cuentacaja" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuentacaja]?>" onClick="document.getElementById('cuentacaja').focus();document.getElementById('cuentacaja').select();" placeholder='cuenta caja' onKeyDown="llamarventanacta(event)"/>&nbsp;<a href="#" onClick="mypop=window.open('cuentas-ventanageneral.php?objeto=cuentacaja&nobjeto=ncuentacaja','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
         			</td>
                    <td colspan="2">
                        <input name="ncuentacaja" id="ncuentacaja" type="text" style="width:100%;" value="<?php echo $_POST[ncuentacaja]?>" readonly/>
                  	</td>
					<td class="saludo1">Imprimir Alcalde:</td>
					<td>
						<select name="impalcalde" style="width:100%;">
       		  				<option value="">Seleccione ...</option>
			 				<option value="S" <?php if($_POST[impalcalde]=='S') echo "SELECTED"?>>Imprimir(S)</option>
			  				<option value="N" <?php if($_POST[impalcalde]=='N') echo "SELECTED"?>>No Imprimir(N)</option>
        				</select>
					</td>
				</tr>
                <tr>
                	<td class="saludo1">Contabiliza retenciones</td>
                	<td style="width:13%;">
                	<select name="contabiliza" id="contabiliza" style="width: 80%">
                		<option value="">Seleccione la opcion...</option>
                		<option value="1" <?php if($_POST[contabiliza]=="1"){echo "SELECTED"; } ?> >Cuentas por pagar</option>
                		<option value="2" <?php if($_POST[contabiliza]=="2"){echo "SELECTED"; } ?>>Egresos</option>
                	</select>
                	</td>
					<td style="width:12%;" class="saludo1" >Cuenta puente:</td>
      				<td style="width:13%;">
					  	<input name="cuenta_abono" id="cuenta_abono" type="text"  value="<?php echo $_POST[cuenta_abono]?>" onKeyUp="return tabular(event,this) " style="width:60%;" onBlur="validar2()">
						<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
						<input type="hidden" name="ncuentact">
                    </td>
                    <td colspan="4">
                        <input id="ncuenta_abono" name="ncuenta_abono" type="text" value="<?php echo $_POST[ncuenta_abono]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly>     
                   	</td>
                </tr>
				<tr>
					<td class="saludo1" >Cuenta Caja menor:</td>
      				<td style="width:13%;">
					  	<input name="cuenta_caja_menor" id="cuenta_caja_menor" type="text"  value="<?php echo $_POST[cuenta_caja_menor]?>" onKeyUp="return tabular(event,this) " style="width:80%;" onBlur="validar2()">
						<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',5);" title="Buscar cuenta" class="icobut" />
                    </td>
					<td colspan="4">
                        <input name="ncuenta_caja_menor" id="ncuenta_caja_menor" type="text" style="width:100%;" value="<?php echo $_POST[ncuenta_caja_menor]?>" readonly/>
                  	</td>
				</tr>
      		</table>
            <table width="160%" class="inicio" align="center" >
    			<tr>
      				<td class="titulos" colspan="8">Parametros Industria y Comercio</td>
               </tr>
               <tr>
               		<td class="titulos2" style="width:15%;">DESCUENTOS:</td>
               		<td class="saludo1" style="width:4cm;">Industria y comercio:</td>
                    <td style="width:13%;">
                        <select name="desindcom" id="desindcom" style="width: 90%">
                            <option value="S" <?php if($_POST[desindcom]=="S"){echo "SELECTED"; } ?>>Aplica Descuento</option>
                            <option value="N" <?php if($_POST[desindcom]=="N"){echo "SELECTED"; } ?>>Sin Descuento</option>
                        </select>
                	</td>
                    <td class="saludo1" style="width:4cm;">Avisos y tablero:</td>
                    <td style="width:13%;">
                        <select name="desavitab" id="desavitab" style="width: 90%">
                            <option value="S" <?php if($_POST[desavitab]=="S"){echo "SELECTED"; } ?>>Aplica Descuento</option>
                            <option value="N" <?php if($_POST[desavitab]=="N"){echo "SELECTED"; } ?>>Sin Descuento</option>
                        </select>
                	</td>
                    <td class="saludo1" style="width:4cm;">Bomberil:</td>
                    <td style="width:13%;">
                        <select name="desbomber" id="desbomber" style="width: 90%">
                            <option value="S" <?php if($_POST[desbomber]=="S"){echo "SELECTED"; } ?>>Aplica Descuento</option>
                            <option value="N" <?php if($_POST[desbomber]=="N"){echo "SELECTED"; } ?>>Sin Descuento</option>
                        </select>
                	</td>
                   	<td></td>
               </tr>
                <tr>
               		<td class="titulos2" style="width:15%;">INTERESES MORA:</td>
               		<td class="saludo1" style="width:4cm;">Industria y comercio:</td>
                    <td style="width:13%;">
                        <select name="intindcom" id="intindcom" style="width: 90%">
                            <option value="S" <?php if($_POST[intindcom]=="S"){echo "SELECTED"; } ?>>Aplica Interes</option>
                            <option value="N" <?php if($_POST[intindcom]=="N"){echo "SELECTED"; } ?>>Sin Interes</option>
                        </select>
                	</td>
                    <td class="saludo1" style="width:4cm;">Avisos y tablero:</td>
                    <td style="width:13%;">
                        <select name="intavitab" id="intavitab" style="width: 90%">
                            <option value="S" <?php if($_POST[intavitab]=="S"){echo "SELECTED"; } ?>>Aplica Interes</option>
                            <option value="N" <?php if($_POST[intavitab]=="N"){echo "SELECTED"; } ?>>Sin Interes</option>
                        </select>
                	</td>
                    <td class="saludo1" style="width:4cm;">Bomberil:</td>
                    <td style="width:13%;">
                        <select name="intbomber" id="intbomber" style="width: 90%">
                            <option value="S" <?php if($_POST[intbomber]=="S"){echo "SELECTED"; } ?>>Aplica Interes</option>
                            <option value="N" <?php if($_POST[intbomber]=="N"){echo "SELECTED"; } ?>>Sin Interes</option>
                        </select>
                	</td>
                   	<td></td>
               </tr>
          	</table>
     		<input type="hidden" value="0" name="oculto">
            <input type="hidden" value="0" name="bt">
            <input type="hidden" value="0" name="bc">
      		<?php
	  			if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		$_POST[regimen]=buscaregimen($_POST[tercero]);	
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else
			 		{
			  			$_POST[ntercero]="";
						echo"
	  					<script>
	  						alert('Tercero Incorrecto o no Existe')				   		  	
		  					document.form2.tercero.focus();	
			  			</script>";
			  		}
				 }
				$oculto=$_POST[oculto];
				if($oculto=="2")
				{
					//recorrer el array donde se guardan los check seleccionados
					//elimina registro si existen en tabla firmas
					$delregis="DELETE FROM firmas";
					mysql_query($delregis,$linkbd);
					foreach($_POST[selec] as $key=>$value)
					{
						//varios strings de un solo string, separados por un guion
						$ang = explode("-", $value);
						//actualizar o guardar en 
						$inregis="INSERT INTO firmas (id_comprobante,id_cargo,vigencia) VALUES ('$ang[0]','$ang[1]','$vigusu')";
						mysql_query($inregis,$linkbd);
					}
					
					$sqlr="DELETE FROM tesoparametros";
					mysql_query($sqlr,$linkbd);
					if($_POST[checkb]=="1"){$bomberile="S";}
					else{$bomberile="N";}
					if($_POST[checka]=="1"){$ambientale="S";}
					else{$ambientale="N";}
					$sqlr="INSERT INTO tesoparametros (id,cc_terorero,age_prespred,estado,nombreteso,cuentatraslado,tmindustria,bomberil, impbeneficiario,interespredial,cuentacaja,conta_pago,imptesorero,impalcalde,desindustria,desavisos,desbomberil,intindustria,intavisos,intbomberil,cuentapuente,cuentacajamenor) VALUES ('1','$_POST[tercero]', '$_POST[agepres]','S','$_POST[ntercero]','$_POST[cuenta]','$_POST[tmindustria]','$bomberile','$_POST[impben]', '$_POST[intpredial]', '$_POST[cuentacaja]','$_POST[contabiliza]','$_POST[imptesorero]','$_POST[impalcalde]','$_POST[desindcom]','$_POST[desavitab]', '$_POST[desbomber]','$_POST[intindcom]','$_POST[intavitab]','$_POST[intbomber]','$_POST[cuenta_abono]','$_POST[cuenta_caja_menor]')";
					if(!mysql_query($sqlr,$linkbd))
 					{
						echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Actualizado la informacion ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
 					}
 					else
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";	 
						$sqlr="delete from dominios where nombre_dominio='CUENTA_TRASLADO' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[cuenta]."','','cuenta traslado bancarios externa','CUENTA_TRASLADO','','TRASLADOS BANCARIOS')";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from dominios where nombre_dominio='BASE_PREDIAL' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[basepredial]."','','Base para impuestos predial','BASE_PREDIAL','','BASE COBRO IMPUESTOS PREDIAL BOMBERIL')";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from dominios where nombre_dominio='BASE_PREDIALAMB' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[basepredialamb]."','','Base para impuestos predial','BASE_PREDIALAMB','','BASE COBRO IMPUESTOS PREDIAL AMBIENTAL')";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from dominios where nombre_dominio='DESCUENTO_CON_DEUDA' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[descuentoConDeuda]."','','DESCUENTO CON DEUDA DE VIGENCIAS ANTERIORES','DESCUENTO_CON_DEUDA','','DESCUENTO_CON_DEUDA')";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from dominios where nombre_dominio='NORMA_PREDIAL' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[aplicapredial]."','','norma impuestos predial','NORMA_PREDIAL','','NORMATIVIDAD IMPUESTOS PREDIAL')";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from dominios where nombre_dominio='COBRO_RECIBOS' and descripcion_valor='$vigusu' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[ingresos]."','".$_POST[recibovalor]."','$vigusu','COBRO_RECIBOS','$_POST[cobrorecibo]','COBRO_RECIBOS')";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from dominios where nombre_dominio='COBRO_ALUMBRADO' and descripcion_valor='$vigusu' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[ingresosAlumbrado]."','".$_POST[alumbradovalor]."','$vigusu','COBRO_ALUMBRADO','$_POST[cobroAlumbrado]','COBRO_ALUMBRADO')";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from dominios where nombre_dominio='CUENTA_MILES' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[cuentamil]."','','".$_POST[ncuentamil]."','CUENTA_MILES','','CUENTAMILES')";
						mysql_query($sqlr,$linkbd);
						$sqlr="delete from dominios where nombre_dominio='DESC_INTERESES' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into dominios  (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('".$_POST[vigmaxdescint]."','".$_POST[porcdescint]."','','DESC_INTERESES','".$_POST[aplicadescint]."','DESCUENTO INTERESES')";
						mysql_query($sqlr,$linkbd);
						
					}
					echo"<script>document.form2.oculto.value='';document.form2.submit();</script>";
				}
			?>
		</form>
	</body>
</html>