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
		<title>:: Spid - Tesoreria</title>
      	<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="inve-greservas-articulos.php";}
				else {document.getElementById('ventana2').src="inve-greservas-cuentas.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('articulo').focus();
									document.getElementById('articulo').select();
									break;
						case "2":	document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
									break;
					}
					document.getElementById('valfocus').value='0';
				}
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.location.href = "teso-contabilizacajamenor.php";}
			function guardar()
			{
				valg01=document.form2.codigo.value;
				valg02=document.form2.fecha.value;
				valg03=document.form2.objeto.value;
				if (valg01!='' && valg02!='' && valg03!=0)
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function guiabuscar(_opc)
			{
				if(_opc==1){if(document.getElementById('articulo').value!=""){document.getElementById('busqueda').value='1';}}
				else{if(document.getElementById('cuenta').value!=""){document.getElementById('busqueda').value='2';}}
				document.form2.submit();
			}
			function agregardetalle()
			{
				val01=document.getElementById('tercero').value;
				val02=document.getElementById('detalle').value;
				val03=document.getElementById('cc').value;
                val04=document.getElementById('valor').value;
                val05=document.getElementById('cuenta').value;
				if(val01!="" && val02!="" && val03!="" && val04!="" && val05!=""){document.form2.agregadet.value=1;document.form2.submit();}
			 	else {despliegamodalm('visible','2','Falta informacion para poder Agregar Detalle de Modalidad');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function validar(_opc){document.form2.submit();}
			function limpiar()
			{
				document.getElementById('articulo').value='';
				document.getElementById('narticulo').value='';
				document.getElementById('nbodega').value='';
				document.getElementById('nreserva').value='';
				document.getElementById('nreservav').value='';
				document.getElementById('cuenta').value='';
				document.getElementById('ncuenta').value='';
				document.getElementById('cc').value='';
				document.getElementById('umedida').value='';
			}
			jQuery(function($){ $('#nreservav').autoNumeric('init',{mDec:'0'});});
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-contabilizacajamenor.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscacajamenor.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"></td>
			</tr>
         </table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
 		<form name="form2" method="post" action="teso-contabilizacajamenor.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
        	<?php
				if ($_POST[oculto]=="")
				{ 
					$_POST[fecha]=date("d/m/Y");
					$_POST[conarticulos]=0;
					$_POST[codigo]=selconsecutivo('tesocontabilizacajamenor','id_cajamenor');
				}
			?>
    		<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="8">.: Contabilizaci&oacute;n de reintegro caja menor</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='inve-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:10%;">.: C&oacute;digo Caja Menor:</td>
                    <td style="width:9%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:100%;" readonly/></td>
                    <td class="saludo1" style="width:12%;">.: Fecha:</td>
                    <td style="width:8%;"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 70%">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/><input type="hidden" name="chacuerdo" value="1"></td>
                    <td style="width:12%;" class="saludo1">.: Tercero:</td>
                    <td style="width:14%;">
                        <input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" >
                        <input type="hidden" value="0" name="bt">
                            <a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">
                                <img src="imagenes/buscarep.png" align="absmiddle" border="0">
                            </a>
                    </td>
                    <td colspan="2">
                        <input  id="ntercero" style="width:100.5%;"  name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  readonly>
                    </td>
      			</tr>
                <tr>
                    <td style="width:11%;" class="saludo1">.: Objeto:</td>
                    <td colspan="3">
                        <input type="text" id="objeto" name="objeto" placeholder="Detalle cabecera" style="width:100.45%;" value="<?php echo $_POST[objeto]?>">
                    </td>
                    <td class="saludo1">.: Detalle Orden de Pago:</td>
                    <td colspan="2">
                        <input type="text" id="detalle" name="detalle" placeholder="Descripcion del gasto" style="width:100.45%;" value="<?php echo $_POST[detalle]?>">
                    </td>
                </tr>
  				<tr>
                    <td class="saludo1" >.: Valor:</td>
                    <td >
                    	<input type="hidden" name="nreserva" id="nreserva" value="<?php echo $_POST[nreserva]?>"/>
                        <input type="number" name="valor" id="valor" value="<?php echo $_POST[valor]?>" style="width:100%;text-align:right;" data-a-dec=',' data-a-sep='.' data-v-min='0' />
                    </td>
   					<td class="saludo1">.: Conceptos Contables:</td>
                    <td>
                    	<select id="cuenta" name="cuenta" onChange="validar()" style="width:100%">
                    		<option value="">Seleccione...</option>
							<?php
								$sqlm="SELECT * FROM conceptoscontables WHERE almacen='S' and tipo='C' and modulo='3' ORDER BY codigo";
								$resm=mysql_query($sqlm,$linkbd);
								while($rowm=mysql_fetch_array($resm))
								{
									if("$rowm[0]"==$_POST[cuenta])
									{
										$_POST[ncuenta]=$rowm[1];
										echo "<option value='$rowm[0]' style='text-transform:uppercase' SELECTED>$rowm[0] - $rowm[1]</option>";										
									}
									else {
										echo "<option value='$rowm[0]' style='text-transform:uppercase'>$rowm[0] - $rowm[1]</option>";
									}
								}
							?>
                    	</select>
               			<input type="hidden" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" >
                    </td>
                    <td style="width:11%;" class="saludo1">Centro Costo:</td>
                    <td style="width:15%;">
                            <select name="cc" id="cc" onChange="validar()" style="width:90%;" onKeyUp="return tabular(event,this)" >
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
                    <td ><em class="botonflecha" onClick="agregardetalle()">agregar detalle</em></td>
                </tr>
            </table>
    		<input type="hidden" name="oculto" id="oculto" value="1"> 
            <input type="hidden" name="agregadet" id="agregadet" value="0" >
            <input type="hidden" name="busqueda" id="busqueda" value=""> 
            <input type='hidden' name='elimina' id='elimina'>
            <div class="subpantalla" style="height:50%; width:99.6%; overflow-x:hidden;">
				<table class='inicio'>
                    <tr><td class='titulos' colspan='9'>Detalles del Comprobante</td></tr>
                    <tr class='titulos2'>
                        <td style="width:8%;">Tercero</td>
                        <td >Detalle</td>
                        <td style="width:5%;">Centro costo</td>
						<td style="width:5%;">Valor</td>
						<td style="width:8%;">Cod. Cuenta</td>
                        <td style="width:4%;">Eliminar</td>
                    </tr>
             		<?php
						if ($_POST[oculto]=='3')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[atercero][$posi]);
							unset($_POST[adetalle][$posi]);
							unset($_POST[acc][$posi]);
							unset($_POST[avalor][$posi]);
							unset($_POST[acuenta][$posi]);
							$_POST[atercero]= array_values($_POST[atercero]); 
							$_POST[adetalle]= array_values($_POST[adetalle]); 
							$_POST[acc]= array_values($_POST[acc]); 		 		 
							$_POST[avalor]= array_values($_POST[avalor]); 
							$_POST[acuenta]= array_values($_POST[acuenta]); 
						}
						if ($_POST[agregadet]=='1')
						{
							$_POST[atercero][]=$_POST[tercero];
							$_POST[adetalle][]=$_POST[detalle];
							$_POST[acc][]=$_POST[cc]; 
							$_POST[avalor][]=$_POST[valor];
							$_POST[acuenta][]=$_POST[cuenta];
							$_POST[agregadet]=0;
                            echo "<script>
                                        document.getElementById('tercero').value='';
                                        document.getElementById('ntercero').value='';
                                        document.getElementById('detalle').value='';
                                        document.getElementById('cuenta').value='';
                                        document.getElementById('valor').value='';
                                    </script>";
							
						}
						$iter='saludo1a';
						$iter2='saludo2';
						$_POST[total]=0;
						for ($x=0;$x<count($_POST[atercero]);$x++)
						{
							echo "
							<input type='hidden' name='atercero[]' value='".$_POST[atercero][$x]."'/>
							<input type='hidden' name='adetalle[]' value='".$_POST[adetalle][$x]."'/>
							<input type='hidden' name='acc[]' value='".$_POST[acc][$x]."'/>
							<input type='hidden' name='avalor[]' value='".$_POST[avalor][$x]."'/>
							<input type='hidden' name='acuenta[]' value='".$_POST[acuenta][$x]."'/>
							<tr class='$iter'>
								<td>".$_POST[atercero][$x]."</td>
								<td>".$_POST[adetalle][$x]."</td>
								<td>".$_POST[acc][$x]."</td>
								<td style='text-align:right;'>".$_POST[avalor][$x]."</td>
								<td style='text-align:right;'>".$_POST[acuenta][$x]."</td>
								<td class='icobut' style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)'></td>
                            </tr>";
                            $_POST[total]+=$_POST[avalor][$x];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							
                        }
                        
					?>
                </table>
                
            </div>
                <table class='inicio'>
                    <tr class='titulos2'>
                        <td style="width:82%;"></td>
                        <?php echo "<td style='width:8%;'>$ $_POST[total]</td>" ;?>
                        <td style="width:10%;"></td>
                    </tr>
                </table>
  			<?php		
				if($_POST[oculto]=="2")
				{
                    $sqlrCajaMenor = "select cuentacajamenor from tesoparametros";
                    $resCajaMenor=mysql_query($sqlrCajaMenor,$linkbd);
                    $rowCajaMenor=mysql_fetch_row($resCajaMenor);
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                    $vigencia = $fecha[3];
                    $bloq=bloqueos($_SESSION[cedulausu],$fechaf);
                    if($bloq>=1)
                    {
                        $sqlr = "INSERT INTO tesocontabilizacajamenor (id_cajamenor,objeto,fecha,valor,estado) VALUES ($_POST[codigo],'$_POST[objeto]','$fechaf',$_POST[total],'1')";
                        if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno en tesocontabilizacajamenor');</script>";}
                        else
                        {
                            $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[codigo],38,'$fechaf','$_POST[objeto]',0,$_POST[total],$_POST[total],0,'1')";
                            mysql_query($sqlr,$linkbd);
                            for($x=0;$x<count($_POST[atercero]);$x++)
                            {
                                $sqlr = "INSERT INTO tesocontabilizacajamenor_det (id_cajamenor,tercero,detalle,cc,valor,conceptocontable,estado) VALUES ($_POST[codigo],'".$_POST[atercero][$x]."','".$_POST[adetalle][$x]."','".$_POST[acc][$x]."','".$_POST[avalor][$x]."','".$_POST[acuenta][$x]."','1')";
                                if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno en tesocontabilizacajamenor_det');</script>";$cont=$cont+1;}
                                else
                                {
                                    $cuentas=concepto_cuentas($_POST[acuenta][$x],'C',3,$_POST[acc][$x],$fechaf);
                                    $tam=count($cuentas);
                                    for($cta=0;$cta<$tam;$cta++)
                                    {
                                        $ctacon=$cuentas[$cta][0];
                                        if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
                                        {
                                            $ncuent=buscacuenta($ctacon);								  
                                            if ($_POST[avalor][$x]>0 && $ncuent!='')
                                            {
                                                $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('38 $_POST[codigo]','".$ctacon."','".$_POST[atercero][$x]."','".$_POST[acc][$x]."','".$_POST[adetalle][$x]."','','".$_POST[avalor][$x]."',0,'1','".$vigencia."')";
                                                mysql_query($sqlr,$linkbd);
                                            }
                                        }
                                    }
                                    $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('38 $_POST[codigo]','$rowCajaMenor[0]','".$_POST[atercero][$x]."','".$_POST[acc][$x]."','".$_POST[adetalle][$x]."','',0,'".$_POST[avalor][$x]."','1','".$vigencia."')";
                                    mysql_query($sqlr,$linkbd);
                                }
                            }
                            if ($cont!=0){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}
                            else {echo"<script>despliegamodalm('visible','1','Se almaceno el comprobante con exito');</script>";} 
                        }
                    }
                    else
                    {
                        echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
                    }
				}
			?>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
            <input type="hidden" name="conarticulos" id="conarticulos" value="<?php echo $_POST[conarticulos];?>"> 
 		</form>
	</body>
</html>