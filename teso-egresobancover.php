<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro1="'".$_GET['filtro1']."'";
	$filtro2="'".$_GET['filtro2']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
		 <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script language="JavaScript1.2">
			function guardar(){
				var concepto=document.form2.concepto.value;
				if(concepto==''){
					despliegamodalm('visible','1','Falta la Causa');
				}else{
					despliegamodalm('visible','4','Esta Seguro de Actualizar la Informacion','1');
				}
				
			} 
			function validar(){
				document.form2.formapa.value="1";
				document.form2.submit();
			}
			function buscaop(e)
 			{
				if (document.form2.orden.value!="")
				{
 					document.form2.bop.value='1';
 					document.form2.submit();
 				}
			 }
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{ 
					document.form2.agregadetdes.value=1;
					document.form2.submit();
 				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.elimina.value=variable;
					document.form2.submit();
				}
			}
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.eliminad.value=variable;
					document.form2.submit();
				}
			}
			function calcularpago()
 			{
				valorp=document.form2.valor.value;
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;
 			}
			function funcionmensaje()
			{
				var _cons=document.getElementById('egreso').value;
				document.location.href = "teso-egresobancover.php?idegre="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro1=&filtro2=";
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						// alert("case 1");
						document.form2.oculto.value='2';
						document.form2.submit();
					break;
				}
			}
			function pdf()
			{
				document.form2.action="pdfegresocambio.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.egreso.value=parseFloat(document.form2.egreso.value)+1;
					var idcta=document.getElementById('egreso').value;
					document.form2.action="teso-egresobancover.php?idcta="+idcta;
					document.form2.submit();
				}
				else
				{
	  				// alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
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
</script>
<script language="JavaScript1.2">
function atrasc()
{

//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {

document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.egreso.value=document.form2.egreso.value-1;
var idcta=document.getElementById('egreso').value;
document.form2.action="teso-egresobancover.php?idcta="+idcta;
document.form2.submit();
 }
}

			function iratras(){
				var idcta=document.getElementById('egreso').value;
				location.href="teso-buscaegresobanco.php?idcta="+idcta;
			}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.egreso.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="teso-egresobancover.php";
document.form2.submit();
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
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
				<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a href="teso-buscaegresobanco.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" onClick="<?php echo paginasnuevas("teso");?>"  class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Buscar" style="width:29px;height:25px;"/></a>
				<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>		  
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu;
			$sqlr="select *from cuentapagar where estado='S' ";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) {$_POST[cuentapagar]=$row[1];}
	  		//*********** cuenta origen va al credito y la destino al debito
			if(!$_POST[oculto])
			{
				$sqlr="select *from cuentapagar where estado='S' ";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) {$_POST[cuentapagar]=$row[1];}
				$sqlr="select * from tesoegresos ORDER BY id_egreso DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
				$_POST[ncomp]=$_GET[idegre];
				$check1="checked";
			}
			$_POST[vigencia]=$vigusu; 		
			if($_POST[oculto]=='1' || !$_POST[oculto])
			{		 
				$sqlr="select * from tesoegresos_banco where id_egreso=$_POST[ncomp]";
				$res=mysql_query($sqlr,$linkbd);
				$numerofilas=mysql_num_rows($res);
				$camposnu=mysql_fetch_row($res);
				$_POST[bancoant]=$camposnu[2];
				$_POST[concepto]=$camposnu[6];
				$_POST[usuario]=$camposnu[5];
		 		$sqlr="select * from tesoegresos where id_egreso=$_POST[ncomp]";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res))
		 		{
		 			$consec=$r[0];	  
		  			$_POST[orden]=$r[2];
		  			$_POST[estado]=$r[13];
					if($_POST[formapa]=="" || !isset($_POST[formapa])){
						$_POST[tipop]=$r[14];
						$_POST[banco]=$r[9];
					}
		  			
					if($_POST[tipop]=='transferencia'){
						$_POST[ntransfe]=$r[10];
						$_POST[ntransfeant]=$camposnu[7];
					}else{
						$_POST[ncheque]=$r[10];	
						$_POST[nchequeant]=$camposnu[7];
					}
		  				  		  
					$_POST[cb]=$r[12];		  
		  			$_POST[transferencia]=$r[12];
					$_POST[fecha]=$r[3];		  		  		  
	 			}
				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
				$_POST[fecha]=$fechaf;
	 			$_POST[egreso]=$consec;		 
			}
			switch($_POST[tabgroup1])
			{
				case 1:	$check1='checked';break;
				case 2:	$check2='checked';break;
				case 3:	$check3='checked';break;
			}
		?>
		 <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action=""> 
			<?php
                if($_POST[orden]!='' )
                {
                    //*** busca detalle cdp
                    $sqlr="select *from tesoordenpago where id_orden=$_POST[orden] ";
                    $resp = mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($resp);
                 
                    if($_POST[movimiento]=='401'){
                    $sql1="select concepto from tesoegresos where id_orden=$_POST[orden] AND tipo_mov='401' ";
                    $resp1 = mysql_query($sql1,$linkbd);
                    $row1 =mysql_fetch_row($resp1);
                  	
                    }
                    $_POST[tercero]=$row[6];
                    $_POST[ntercero]=buscatercero($_POST[tercero]);
                    $_POST[tercerocta]=buscatercero_cta($_POST[tercero]);
                    $_POST[valororden]=$row[10];
                    $_POST[retenciones]=$row[12];
                    $_POST[totaldes]=number_format($_POST[retenciones],2);
                    $_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
                    $_POST[bop]="";
                }
                else
                {
                    $_POST[cdp]="";
                    $_POST[detallecdp]="";
                     $_POST[tercero]="";
                    $_POST[ntercero]="";
                    $_POST[bop]="";
                }
            ?>
 			<div class="tabsic" style="height:34.5%; width:99.6%;"> 
   				<div class="tab"> 
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Egreso</label>
	   				<div class="content" style="overflow-x:hidden;">
	   					<table class="inicio" align="center" >
	   					<tr>
	     					<td class="titulos" colspan="8" >Comprobante de Cambio de Egreso</td>
                            <td class="cerrar" style="width:7%"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
                      	</tr>
       					<tr>
						    <input name="usuario" id="usuario" type="hidden" value="<?php echo $_POST[usuario]; ?>" /> 
                        	<td class="saludo1" style="width:12%">N&deg; Egreso:</td>
                            <td style="width:16%">
                            	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
                                <input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" > 
                                <input id="egreso" name="egreso" type="text" value="<?php echo $_POST[egreso]?>"  onKeyUp="return tabular(event,this)" onBlur="validar2()" style="width:50%" > 
                                <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                                <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                                <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
                                <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                                <input type="text" name="vigencia"  value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this)" style="width:22%;" readonly> 
                           	</td>
       	  					<td class="saludo1" style="width:3.0cm;">Fecha: </td>
        						<td style="width:12%"><input type="text" id="fc_1198971545" name="fecha" value="<?php echo $_POST[fecha]?>" title="DD/MM/YYYY" maxlength="10" onKeyDown="mascara(this,'/',patron,true)" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:80%">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;" ></a></td>      
       						<td class="saludo1" style="width:12%;">Forma de Pago:</td>
       						<td style="width:15%">
       							<select name="tipop"  onChange="validar()"  style="width:100%">
				  					<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  					<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
				  				</select> 
								<input name="formapa" id="formapa" type="hidden" value="<?php echo $_POST[formapa]; ?>" /> 
								
          					</td> 
                            <td rowspan="7" style="width:5%"></td>
                           	<td rowspan="7" colspan="2" style="background:url(imagenes/cheque04.png); background-repeat:no-repeat; background-position:center; background-size: 80% 80%"></td>
       					</tr>
						<tr>
                        	<td class="saludo1">Estado:</td> 
                            <td>
                            	<?php  
                            		
                            			echo "<input name='estado' type='text' value='ACTIVO' size='5' style='width:98%; background-color:#0CD02A; color:white; text-align:center;' readonly >";
                            		
                            		
                            	?>
                            	
                            </td>        
                        	<td class="saludo1">No Orden Pago:</td>
	 						<td><input name="orden" type="text" value="<?php echo $_POST[orden]?>" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)" style="width:80%" readonly><input type="hidden" value="0" name="bop">
	 						
	 					
                        </tr>
                        <tr>
      						<td class="saludo1">Tercero:</td>
          					<td><input type="text" id="tercero" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:98%" readonly></td>
           					<td colspan="2"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
                            <td class="saludo1">Cuenta:</td>
                            <td><input name="tercerocta" type="text" value="<?php echo $_POST[tercerocta]?>" style="width:100%" readonly></td>
                     	</tr>
						<tr>
                        	<td class="saludo1">Causa de cambio:</td>
							<td colspan="5"><textarea id="concepto" name="concepto" style="width:100%; height:40px;resize:none;background-color:#FFF;color:#333;border-color:#ccc;" <?php if(!empty($_POST[concepto]) ){echo "readonly"; } ?> ><?php echo $_POST[concepto]; ?></textarea></td>
                     	</tr>           
      					<?php 
	  						if($_POST[tipop]=='cheque')//**** if del cheques
	   					 	{
	  					?>    
           						<tr>
	  								<td class="saludo1">Cuenta Bancaria:</td>
	  								<td >
	     								<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
		  									<?php
												$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban, tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S'  and tesobancosctas.tipo='Corriente' ";
												$res=mysql_query($sqlr,$linkbd);
												while ($row =mysql_fetch_row($res)) 
				    							{
					 								if($row[1]==$_POST[banco])
			 										{
						 								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
						 								$_POST[nbanco]=$row[4];
						  								$_POST[ter]=$row[5];
						 								$_POST[cb]=$row[2];
						 								$_POST[tcta]=$row[3];
						 							}
													else{echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}
												}	 	
											?>
            							</select>
										<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" >
                                        <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                                        <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                                	</td>
                                    <td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%" readonly></td>
									<td class="saludo1">Cheque:</td>
                                    <td ><input type="text" id="ncheque" name="ncheque" value="<?php echo $_POST[ncheque]?>" style="width:100%"></td>
	  							</tr>
								
							<?php
	     					}//cierre del if de cheques
	  						if($_POST[tipop]=='transferencia')//**** if del transferencias
	    					{
							?> 
      							<tr>
	  								<td class="saludo1">Cuenta Bancaria:</td>
	  								<td >
	     								<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      									<option value="">Seleccione....</option>
		  									<?php
												$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban, tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
												$res=mysql_query($sqlr,$linkbd);
												while ($row =mysql_fetch_row($res)) 
				    							{
													echo "";
													$i=$row[1];
					 								if($i==$_POST[banco])
			 										{
														echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
						 								$_POST[nbanco]=$row[4];
						  								$_POST[ter]=$row[5];
						 								$_POST[cb]=$row[2];
						 								$_POST[tcta]=$row[3];
													}
					  								else {echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";} 
												}	 	
											?>
            							</select>				
										<input name="tcta" type="hidden" value="<?php echo $_POST[tcta]?>" >
                                        <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                                        <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                                  	</td>
                                    <td colspan="2"><input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%" readonly></td>
									<td class="saludo1">No Transferencia:</td>
                                    <td ><input type="text" id="ntransfe" name="ntransfe" value="<?php echo $_POST[ntransfe]?>" style="width:100%"></td>
	  							</tr>
      					<?php
	     					}//cierre del if de cheques
      					?> 
							<?php
							
							if($numerofilas>0){
								echo "<tr>";
								echo "<td class='saludo1'>Cuenta Bancaria Ant.:</td>";
								echo "<td ><select id='bancoant' name='bancoant' disabled>";
								
								$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban, tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
								echo "";
								$i=$row[1];
					 			if($i==$_POST[bancoant])
			 					{
								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
								$_POST[nbancoant]=$row[4];
								$_POST[tctant]=$row[3];
								$_POST[cbant]=$row[2];
								}
					  			else {echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";} 
								}
								echo "</select>
								</td>";
								echo "<td colspan=\"2\"><input type=\"text\" id=\"nbancoant\" name=\"nbancoant\" value='$_POST[nbancoant]' style=\"width:100%\" readonly></td>";
								if($_POST[tipop]=='transferencia')//**** if del transferencias
								{
									echo "<td class=\"saludo1\">No Transferencia Ant.:</td>
                                    <td ><input type=\"text\" id=\"ntransfeant\" name=\"ntransfeant\" value='$_POST[ntransfeant]' style=\"width:100%\"></td>";
								echo "</tr>";
								}else{
									echo "<td class=\"saludo1\">Cheque Ant.:</td>
                                    <td ><input type=\"text\" id=\"nchequeant\" name=\"nchequeant\" value='$_POST[nchequeant]' style=\"width:100%\"></td>";
								echo "</tr>";
								}
								
							}
						?>
						<input name="tctant" type="hidden" value="<?php echo $_POST[tctant]?>" >
						<input name="cbant" type="hidden" value="<?php echo $_POST[cbant]?>" >
	  					<tr>
					
	  					<td class="saludo1">Valor Orden:</td>
                        <td><input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valororden]?>" style="width:98%" readonly></td>	  
                        <td class="saludo1">Retenciones:</td>
                        <td><input name="retenciones" type="text" id="retenciones" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retenciones]?>" style="width:100%" readonly></td>	  
                        <td class="saludo1">Valor a Pagar:</td>
                        <td><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>" style="width:100%" readonly> <input type="hidden" value="1" name="oculto"></td>
                   	</tr>	
      			</table>
	 		</div>
     </div>
   
  

	</div>   
	 
		<div class="subpantallac4" style="height:40%; width:99.6%; overflow-x:hidden;">
	 		<table class="inicio">
	   			<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
				<tr>
                	<td class="titulos2">Cuenta</td>
                    <td class="titulos2">Nombre Cuenta</td>
                    <td class="titulos2">Recurso</td>
                    <td class="titulos2">Valor</td>
             	</tr>
				<?php 		
					if ($_POST[elimina]!='')
		 			{ 
		 				$posi=$_POST[elimina];
						unset($_POST[dccs][$posi]);
						unset($_POST[dvalores][$posi]);		 
		 				$_POST[dccs]= array_values($_POST[dccs]); 
		 			}	 
		 			if ($_POST[agregadet]=='1')
		 			{
		 				$_POST[dccs][]=$_POST[cc];
						$_POST[agregadet]='0';
		  		?>
						<script>
                            //document.form2.cuenta.focus();	
                            document.form2.banco.value="";
                            document.form2.nbanco.value="";
                            document.form2.banco2.value="";
                            document.form2.nbanco2.value="";
                            document.form2.cb.value="";
                            document.form2.cb2.value="";
                            document.form2.valor.value="";	
                            document.form2.numero.value="";	
                            document.form2.agregadet.value="0";				
                            document.form2.numero.select();
                            document.form2.numero.focus();	
                      	</script>
             	<?php
		  			}
		  			$_POST[totalc]=0;
		  			$sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] and tipo_mov='201' ";
				//echo $sqlr;
				$dcuentas[]=array();
				$dncuentas[]=array();
				$resp2 = mysql_query($sqlr,$linkbd);
				$iter='saludo1a';
				$iter2='saludo2';
				while($row2=mysql_fetch_row($resp2))
				 {
					 $sql="select vigencia FROM tesoordenpago where id_orden=$_POST[orden]";
					 $result=mysql_query($sql,$linkbd);
					 $vigDocumento=mysql_fetch_array($result);
				  //$_POST[dcuentas][]=$row2[2];
				  $nombre=buscaNombreCuenta($row2[2],$vigDocumento[0]);
				  $nfuente=buscafuenteppto($row2[2],$vigDocumento[0]);
				  //$_POST[dvalores][]=$row2[4];				
		 echo "
		 <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
		 	<td><input name='dcuentas[]' value='".$row2[2]."' type='hidden'>$row2[2]</td>
			<td><input name='dncuentas[]' value='".$nombre."' type='hidden' >$nombre</td>
			<td><input name='drecursos[]' value='".$nfuente."' type='hidden' >$nfuente</td>
			<td style='text-align:right;'><input name='dvalores[]' value='".$row2[4]."' type='hidden' readonly>$row2[4]</td>
		</tr>";
		 $_POST[totalc]=$_POST[totalc]+$row2[4];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 $aux=$iter;
	 	$iter=$iter2;
	 	$iter2=$aux;
		 }
		$resultado = convertir($_POST[valorpagar]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "
		<tr class='$iter'>
			<td style='text-align:right;' colspan='3'>Total:</td>
			<td style='text-align:right;'><input name='totalcf' type='hidden' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'>$_POST[totalcf]</td>
		</tr>
		<tr class='titulos2'>
			<td>Son:</td> 
			<td colspan='5'><input name='letras' type='hidden' value='$_POST[letras]'>$_POST[letras]</td>
		</tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
		//calcularpago();
        </script>
	   </table></div>	
        <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	if($_POST[tipop]=='cheque'){$vartipos=$_POST[ncheque];}
	if($_POST[tipop]=='transferencia'){$vartipos=$_POST[ntransfe];}
	$sqlr="select * from tesoegresos_banco where id_egreso=$_POST[ncomp]";
	$res=mysql_query($sqlr,$linkbd);
    $numerofilas=mysql_num_rows($res);
	if($numerofilas>0){
		echo "<script>despliegamodalm('visible','1','Ya existe un comprobante de cambio para este egreso');</script>";
	}else{
		$sqlr="select banco,cheque,cuentabanco,pago from tesoegresos where id_egreso=$_POST[ncomp]";
	$res=mysql_query($sqlr,$linkbd);
	while($row = mysql_fetch_row($res)){
		$bancoant=$row[0];
		$chequeant=$row[1];
		$cuentabanant=$row[2];
		$tipoant=$row[3];

	}			

	$sql="UPDATE tesoegresos SET banco='$_POST[banco]',cheque='$vartipos',cuentabanco='$_POST[cb]',pago='$_POST[tipop]' WHERE id_egreso= $_POST[egreso] AND tipo_mov='201' ";
	if(mysql_query($sql,$linkbd)){
		$sqlr="UPDATE comprobante_det SET cheque='$vartipos',cuenta='$_POST[banco]' WHERE tipo_comp=6 AND numerotipo=$_POST[egreso] AND (detalle LIKE '%banco%' OR  detalle LIKE '%Banco%')";
		mysql_query($sqlr,$linkbd);
		if($bancoant!=$_POST[banco] || $chequeant!=$vartipos || $tipoant!=$_POST[tipop]){
		$sqlr="INSERT INTO tesoegresos_banco(id_egreso,banco_ant,banco_nu,fecha_mod,usuario,objeto,cheque_ant,cheque_nu,tipo_ant,tipo_nu,cuentabanco_ant,cuentanbanco_nu) VALUES ('$_POST[egreso]','$bancoant','$_POST[banco]','$fechaf','$_SESSION[nickusu]','$_POST[concepto]','$chequeant','$vartipos','$tipoant','$_POST[tipop]','$cuentabanant','$_POST[cb]')";
		mysql_query($sqlr,$linkbd);
		echo "<script>despliegamodalm('visible','1','Se ha actualizado el Egreso con Exito');</script>";
		}else{
		echo "<script>despliegamodalm('visible','1','No hay algun cambio en el comprobante');</script>";
		}
	
		
	}else{
		echo "<script>despliegamodalm('visible','2','Error al actualizar el comprobante');</script>";
	}
	}
	
}
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 