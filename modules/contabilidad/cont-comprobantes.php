<!--V 1.0 24/02/2015-->
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
		<title>:: SPID- Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function agregardetalle()
			{
				valordeb=quitarpuntos(document.form2.vlrdeb.value)	
				valorcred=quitarpuntos(document.form2.vlrcre.value)
				if((document.form2.cuenta.value!="") && (document.form2.tercero.value!="") && (document.form2.cc.value!="") && (document.form2.detalle.value!="") && (valordeb>0 || valorcred>0))
					{document.form2.agregadet.value=1;document.form2.submit();}
				else {despliegamodalm('visible','2','Falta información para poder Agregar');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','3');
			}
			function validar(){document.form2.submit();}
			function guardar()
			{
				valor=Math.round(Math.abs(parseFloat(document.form2.diferencia.value)));
				if (valor=='0')
				{
					var validacion01=document.getElementById('concepto').value;
					if((document.form2.fecha.value!='')&&(document.form2.tipocomprobante.value!="")&&(validacion01.trim()!=''))
						{despliegamodalm('visible','4','Esta Seguro de Guardar','2');}
					else{despliegamodalm('visible','2',"Falta información para poder guardar")}
				}
				else 
				{
					var nomtitul = 'Comprobante descuadrado Diferencia: \"'+ valor+'\"';
					despliegamodalm('visible','2',nomtitul)
				}
			}
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function buscacc(e){if (document.form2.cc.value!=""){document.form2.bcc.value='1';document.form2.submit();}}
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function llamarventanacta(e)
			{
				tecla=(document.all) ? e.keyCode : e.which; 
				if (tecla == 27)
				{					
					mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');
					mypop.focus();
				}
			}
			function llamarventanater(e)
			{
				tecla=(document.all) ? e.keyCode : e.which; 
				if (tecla == 27)
				{
					mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');
					mypop.focus();
				}
			}
			function despliegamodal2(_valor,_nomve)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_nomve)
					{
						case "1":	document.getElementById('ventana2').src="terceros-ventana1.php";break;
						case "2":	document.getElementById('ventana2').src="cuentas-ventana01.php";break;
						case "3":	document.getElementById('ventana2').src="cc-ventana01.php";break;
					}
					
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "2":	document.getElementById('valfocus').value='1';
									document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
									break;
						case "3":	document.getElementById('valfocus').value='1';
									document.getElementById('cc').focus();
									document.getElementById('cc').select();
									break;
					}
				}
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "cont-comprobantes.php";}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.getElementById('bt').value="0";
									mypop=window.open('cont-terceros.php','','');break;
						case "2":	document.form2.oculto.value=2;
									document.form2.action="cont-comprobantes.php";
									document.form2.submit();
									break;
						case "3":	document.form2.elidet.value="1";
									document.form2.submit();break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.getElementById('bt').value="0";
									document.getElementById('tercero').focus();
									document.getElementById('tercero').select();
									break;
						case "2":	break;
						case "3":	document.form2.elimina.value="";break;
					}
				}
			}
			function llamadoesc(e,_opc)
			{
				tecla=(document.all) ? e.keyCode : e.which; 
				if (tecla == 27)
				{
					switch(_opc)
					{
						case "1":	document.getElementById("bgventanamodal2").style.visibility="visible";
									document.getElementById('ventana2').src="cuentas-ventana01.php";break;
						case "2":	document.getElementById("bgventanamodal2").style.visibility="visible";
									document.getElementById('ventana2').src="terceros-ventana1.php";break;
						case "3":	document.getElementById("bgventanamodal2").style.visibility="visible";
									document.getElementById('ventana2').src="cc-ventana01.php";break;
					}
				}
			}
			function valtipcom(){document.getElementById('oculto').value="6";document.form2.submit();}
		</Script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
	  			<td class="cinta" colspan="3">
					<a href="cont-comprobantes.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="cont-buscacomprobantes.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
					<a href="#" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a>
				</td>
           	</tr>
    	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php 
 			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			if($_POST[oculto]==""){$_POST[fecha]=date("Y-m-d");}
			if($_POST[oculto]=='6')
			{
				$sqlr="select fijo,nombre from tipo_comprobante where codigo='$_POST[tipocomprobante]'";
				$res2=mysql_query($sqlr,$linkbd);
				$rt=mysql_fetch_row($res2);
				if($rt[0]=='N')
 				{
					$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp=$_POST[tipocomprobante] ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){$maximo=$r[0];}
					if(!$maximo){$_POST[ncomp]=1;}
  					else {$_POST[ncomp]=$maximo+1;$bloqtipo=" ";}
 				}
 				else
  				{	  
    				echo "<script>despliegamodalm('visible','2','Para este Tipo de Comprobantes \"$rt[1]\" no se pueden crear manualmente los comprobantes');</script>";
					$_POST[tipocomprobante]='-1';
					$_POST[ncomp]="";
	 				$bloqtipo=" readonly";
  				}
			}
		?>
  		<form name="form2" method="post" action="">
        	<input type="hidden" name="valfocus" id="valfocus" value="1"/>
  			<table class="inicio">
                <tr>
                    <td class="titulos" colspan="9">Comprobantes</td>
                    <td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
                </tr>
        		<tr>
		   			<td class="saludo1" style="width:12.5%;">Tipo Comprobante:</td>
          			<td style="width:20%;">
                    	<select name="tipocomprobante" id="tipocomprobante" onKeyUp='return tabular(event,this)' onChange="valtipcom()" style="width:100%;">
		  					<option value="-1">Seleccion Tipo Comprobante</option>	  
		   					<?php
  		   						$sqlr="Select * from tipo_comprobante  where estado='S' AND fijo='N' order by nombre";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[3]==$_POST[tipocomprobante])
			 						{
				 						$_POST[ntipocomp]=$row[1];
				 						echo "<option value=$row[3] SELECTED>$row[1]</option>";
				 					}
									else {echo "<option value=$row[3]>$row[1]</option>";}
			     				}			
		  					?>
		  				</select>
          				<input type="hidden" name="ntipocomp" id="ntipocomp" value="<?php echo $_POST[ntipocomp]?>">
               		</td>
                 	<td class="saludo1" >N°:</td>
          			<td >
                    	<input name="ncomp" type="text" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ncomp]?>" size="7" readonly >
                        <input type="hidden" value="a" name="atras">
                        <input type="hidden" value="s" name="siguiente">
                        <input type="hidden" value="<?php echo $_POST[nuevo]?>" name="nuevo"><a href="#"></a><a href="#"></a>
                 	</td>
          			<td class="saludo1" >Fecha: </td>
          			<td ><input type="date" name="fecha" id="fecha" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)"></td>
          			<td class="saludo1">Estado:</td>
          			<td colspan="2"><input type="text" name="estado"  value="<?php echo $_POST[estado]; ?>" readonly></td>
          			<td>&nbsp;</td>
        		</tr>
    			<tr>
          			<td class="saludo1">Concepto:</td>
          			<td colspan="5" ><input type="text" name="concepto" id="concepto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[concepto]; ?>" placeholder='Descripcion del Comprobante Contable' style="width:100%;"></td>
          			<td class="saludo1">Total:</td>
          			<td><input type="text" name="total"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[total]; ?>" readonly></td>
        		</tr>
        	</table>
			<table class="inicio" >		
        		<tr><td class="titulos2" colspan="30">Agregar Detalle</td></tr>
        		<tr>
          			<td class="saludo1" style="width:10%;">Cuenta:</td>
          			<td valign="middle" style="width:12%;"><input type="text" id="cuenta" name="cuenta" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onKeyDown="llamadoesc(event,'1')" style="width:80%;"/><input type="hidden" value="0" name="bc">&nbsp;<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
                    <td style="width:30%;"><input type="text" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" style="width:100%;" readonly></td>
          			<td class="saludo1" style="width:8%;">Tercero:</td>
          			<td style="width:12%;"><input type="text" id="tercero" name="tercero"  onKeyUp="return tabular(event,this)" onKeyDown="llamadoesc(event,'2')" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;"/><input type="hidden" name="bt" id="bt" value="0">&nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          			<td ><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly/></td>
               	</tr>
                <tr>
                	<td class="saludo1">Centro Costo:</td>
          			<td><input type="text" id="cc" name="cc" onKeyUp="return tabular(event,this)" onBlur="buscacc(event)" value="<?php echo $_POST[cc]?>"  onKeyDown="llamadoesc(event,'3')" style="width:80%;"><input type="hidden" value="0" name="bcc">&nbsp;<a href="#" onClick="despliegamodal2('visible','3');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          			<td><input name="ncc" type="text" id="ncc" value="<?php echo $_POST[ncc]?>" style="width:100%;" readonly></td>
          			<td class="saludo1">Detalle:</td>
          			<td colspan="2"><input type="text" name="detalle" id="detalle" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[detalle]?>" placeholder='Descripcion del registro' style="width:100%;"></td>
              	</tr>
               	<tr>
          			<td class="saludo1">Vlr Debito:</td>
          			<td colspan="2"><input type="text" name="vlrdeb" onKeyPress="javascript:return solonumeros(event)" onKeyDown="return tabular(event,this)"  value="0"/></td>
          			<td class="saludo1">Vlr Credito:</td>
          			<td ><input type="text" name="vlrcre"  onKeyPress="javascript:return solonumeros(event)" onKeyDown="return tabular(event,this)"  value="0"/></td>
          			<td colspan="2" >
                    	<input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" >
                        <input type="hidden" value="0" name="agregadet">
	  					<?php if ($_POST[oculto]==""){echo"<script>document.form2.tipocomprobante.focus();</script>";} ?>
		  				<input type="hidden" name="oculto" id="oculto" value="0">	 
                    </td>
					<?php 
						if($_POST[bc]=='1')
			 			{
			  				$nresul=buscacuenta($_POST[cuenta]);
			  				if($nresul!='')
			   				{
  			  					echo "<script>document.getElementById('ncuenta').value='$nresul';document.getElementById('tercero').focus(); document.getElementById('tercero').select();</script>";
			  				}
			 				else
			 				{
			  				$_POST[ncuenta]="";
			  				echo "<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
			  				}
			 			}			 
			  			//***** busca tercero
			 			if($_POST[bt]=='1')
			 			{
			  				$nresul=buscatercero($_POST[tercero]);
			  				if($nresul!='')
			  				{
  								echo"<script>document.getElementById('ntercero').value='$nresul';document.getElementById('cc').focus(); document.getElementById('cc').select();</script>";
			  				}
			 				else
							{
			  					echo "<script>despliegamodalm('visible','4','Tercero Incorrecto o no Existe, ¿Desea Agregar un Tercero?','1');</script>";
			 				}
			 			}
			 			//*** centro  costo
			 			if($_POST[bcc]=='1')
			 			{
			  				$nresul=buscacentro($_POST[cc]);
			  				if($nresul!='')
			   				{
  			  					echo "<script>document.getElementById('ncc').value='$nresul';document.getElementById('detalle').focus(); document.getElementById('detalle').select();</script>";
			  				}
			 				else
			 				{
								echo "<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Centro de Costos Incorrecto');</script>";
			  				}
			 			}
			 		?>
        		</tr>
      		</table>
            <div class="subpantallac2" style="height:47.2%; width:99.6%; overflow-x:hidden;">
	    		<table class="inicio" width="99%">
        			<tr><td class="titulos" colspan="20">Detalle Comprobantes</td></tr>
					<tr>
						<td class="titulos2" style='width:7%'>Cuenta</td>
                        <td class="titulos2" style='width:30%'>Nombre Cuenta</td>
                        <td class="titulos2" style='width:8%'>Tercero</td>
                        <td class="titulos2" style='width:3%'>C C</td>
                        <td class="titulos2" style='width:30%'>Detalle</td>
                        <td class="titulos2" style='width:10%'>Vlr Debito</td>
                        <td class="titulos2" style='width:10%'>Vlr Credito</td>
                        <td class="titulos2" style='width:2%'><img src="imagenes/del.png"></td>
					</tr>
                    <input type='hidden' name='elimina' id='elimina'>
                    <input type='hidden' name='elidet' id='elidet' value="0">
					<?php 
						if ($_POST[elidet]=='1')
		 				{ 
		 					$posi=$_POST[elimina];
		  					$cuentacred=0;
		  					$cuentadeb=0;
		   					$diferencia=0;
						   	unset($_POST[dcuentas][$posi]);
						   	unset($_POST[dncuentas][$posi]);
						   	unset($_POST[dterceros][$posi]);
						   	unset($_POST[dccs][$posi]);
						   	unset($_POST[ddetalles][$posi]);
						   	unset($_POST[dcheques][$posi]);
						   	unset($_POST[dcreditos][$posi]);		 		 		 		 		 
						   	unset($_POST[ddebitos][$posi]);		 
						   	$_POST[dcuentas]= array_values($_POST[dcuentas]); 
						   	$_POST[dncuentas]= array_values($_POST[dncuentas]); 
						   	$_POST[dterceros]= array_values($_POST[dterceros]); 		 		 
						   	$_POST[dccs]= array_values($_POST[dccs]); 
						   	$_POST[ddetalles]= array_values($_POST[ddetalles]); 
						   	$_POST[dcheques]= array_values($_POST[dcheques]); 
						   	$_POST[dcreditos]= array_values($_POST[dcreditos]); 
						   	$_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
		 				}
						if ($_POST[agregadet]=='1')
		 				{
		  					$cuentacred=0;
		  					$cuentadeb=0;
		  					$diferencia=0;
		 					$_POST[dcuentas][]=$_POST[cuenta];
		 					$_POST[dncuentas][]=$_POST[ncuenta];
		 					$_POST[dterceros][]=$_POST[tercero];
		 					$_POST[dccs][]=$_POST[cc];		 
		 					$_POST[ddetalles][]=$_POST[detalle];
		 					$_POST[dcheques][]=$_POST[cheque];
		  					$_POST[vlrcre]=str_replace(",",".",$_POST[vlrcre]);
		  					$_POST[vlrdeb]=str_replace(",",".",$_POST[vlrdeb]);
	     					$_POST[dcreditos][]=$_POST[vlrcre];
		 					$_POST[ddebitos][]=$_POST[vlrdeb];
		 					$_POST[agregadet]=0;
		  					echo"
								<script>
									document.form2.cuenta.value='';
									document.form2.ncuenta.value='';
									document.form2.tercero.value='';
									document.form2.ntercero.value='';
									document.form2.cc.value='';
									document.form2.ncc.value='';
									document.form2.detalle.value='';
									document.form2.vlrcre.value=0;
									document.form2.vlrdeb.value=0;
									document.form2.cuenta.focus();	
									document.form2.cuenta.select();
							 	</script>";
		  				}
		  				$iter='saludo1a';
		  				$iter2='saludo2';
		 				for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 				{
							echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
		 						<td><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' class='inpnovisibles' $bloqtipo style='width:100%'></td>
		 						<td><input name='dncuentas[]' value='".ucfirst(strtolower($_POST[dncuentas][$x]))."' type='text' class='inpnovisibles' $bloqtipo style='width:100%'></td>
								<td><input name='dterceros[]' value='".$_POST[dterceros][$x]."' type='text' class='inpnovisibles' $bloqtipo style='width:100%'></td>
		 						<td><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text'  class='inpnovisibles' $bloqtipo style='width:100%'></td>
		 						<td><input name='ddetalles[]' value='".ucfirst(strtolower($_POST[ddetalles][$x]))."' type='text' onDblClick='llamarventana(this,$x)' onKeyUp='return tabular(event,this)' onBlur='' class='inpnovisibles' style='width:100%'></td>
		 						<td><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' onDblClick='llamarventanadeb(this,$x)' onBlur='validar()' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)' class='inpnovisibles' style='text-align:right;width:100%'></td>
		 						<td><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text'  onDblClick='llamarventanacred(this,$x)' onBlur='validar()' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)' class='inpnovisibles' style='text-align:right;width:100%'></td>
		 <td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
							</tr>";
			 				$cred=$_POST[dcreditos][$x];
		 					$deb=$_POST[ddebitos][$x];
		 					$cred=$cred;
		 					$deb=$deb;		 
		 					$cuentacred=$cuentacred+$cred;
		 					$cuentadeb=$cuentadeb+$deb;		 
		 					$diferencia=$cuentadeb-$cuentacred;
		 					$total=number_format($total,2,",","");
		 					$_POST[cuentadeb]=$cuentadeb;
		 					$_POST[cuentacred]=$cuentacred;
		 					$_POST[diferencia]=$diferencia;
		 					$_POST[diferencia2]=number_format($diferencia,2,".",",");
 		 					$_POST[cuentadeb2]=number_format($cuentadeb,2,".",",");
							$_POST[cuentacred2]=number_format($cuentacred,2,".",",");	
		 					$aux=$iter;
		 					$iter=$iter2;
		 					$iter2=$aux;	 	 
		 				}
		 				$resultado = convertir($_POST[cuentadeb]);
		 				$_POST[letras]=$resultado." PESOS";
		 				echo "
						<tr>
		 					<td colspan='2' style='text-align:right;'>Diferencia:</td>
		 					<td colspan='2'><input type='hidden' id='diferencia' name='diferencia' value='$_POST[diferencia]'><input id='diferencia2' name='diferencia2' value='$_POST[diferencia2]' type='text' style='text-align:right;' readonly></td>
		 					<td style='text-align:right;'>Totales:</td>
		 					<td><input name='cuentadeb2' id='cuentadeb2' value='$_POST[cuentadeb2]' type='text' style='text-align:right;' readonly><input name='cuentadeb' id='cuentadeb' value='$_POST[cuentadeb]' type='hidden'></td>
		 					<td><input id='cuentacred2' name='cuentacred2' value='$_POST[cuentacred2]' style='text-align:right;' readonly><input name='cuentadeb' id='cuentadeb' value='$_POST[cuentadeb]' type='hidden'></td>
						</tr>";
		 				echo "<tr><td>Son: </td><td colspan='7'><input name='letras' id='letras' value='$_POST[letras]' style='width:100%' readonly></td></tr>";
					?>
				</table>  
			</div> 
	  		<?php 
				//********** GUARDAR EL COMPROBANTE ***********
				if($_POST[oculto]=='2')	
				{
					//rutina de guardado cabecera
					$fechaf=$_POST[fecha];
					$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
					if($bloq>=1)
					{	
						$sqlr="select count(*) from comprobante_cab where tipo_comp=$_POST[tipocomprobante] and numerotipo=$_POST[ncomp]";
						$res=mysql_query($sqlr,$linkbd);
						$nc=mysql_fetch_row($resp); 
						if ($nc[0]>0)
						{
		 					$sqlr="update comprobante_cab set numerotipo=$_POST[ncomp],tipo_comp=$_POST[tipocomprobante],fecha='$fechaf',concepto='$_POST[concepto]',total=0,total_debito=$_POST[cuentadeb2],total_credito=$_POST[cuentadeb2],diferencia=$_POST[diferencia] where tipo_comp='$_POST[tipocomprobante]' and numerotipo='$_POST[ncomp]'";
						}
						else
						{
							$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) values ($_POST[ncomp],$_POST[tipocomprobante],'$fechaf','$_POST[concepto]',0,$_POST[cuentadeb],$_POST[cuentacred],$_POST[diferencia],'1')";
						}
						if (!mysql_query($sqlr,$linkbd))
						{
	 						echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>Ocurrió el siguiente problema:<br><pre></pre></center></td></tr></table>";
						}
  						else
  		 				{
 							$sqlr="delete from comprobante_det where id_comp='$_POST[tipocomprobante] $_POST[ncomp]'";
							mysql_query($sqlr,$linkbd);
							echo "<script>despliegamodalm('visible','3','Se ha almacenado el Encabezado del Comprobante con Exito');</script>";
		  					echo "<script>despliegamodalm('visible','3','Para MODIFICAR el Comprobante Creado Vaya a Buscar Comprobante dando Click en la Lupa de la Barra de Herramientas');</script>";
		 					$idcomp=mysql_insert_id(); 
		 					for ($x=0;$x<count($_POST[dcuentas]);$x++)
		  					{
		 						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('$_POST[tipocomprobante] $_POST[ncomp]','".$_POST[dcuentas][$x]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','".$_POST[ddetalles][$x]."','',".$_POST[ddebitos][$x].",".$_POST[dcreditos][$x].",'1','".$vigusu."')";
		 						if (!mysql_query($sqlr,$linkbd))
								{
		 							echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
		 							$e =mysql_error($respquery);
	 								echo "Ocurrió el siguiente problema:<br><pre></pre></center></td></tr></table>";
								}
  								else{echo "<script>despliegamodalm('visible','1','Se ha almacenado el detalle con Exito ');</script>";}
		  					}
						} 
					}
   	 				else {echo "<script>despliegamodalm('visible','2','o Tiene los Permisos para Modificar este Documento');</script>";}
 					//****fin if bloqueo  
				}
			?>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>  
		</form>
	</body>
</html>