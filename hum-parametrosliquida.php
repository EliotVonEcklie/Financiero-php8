<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require "funciones.inc";
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
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar(){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
			function despliegamodal2(_valor,_nven)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=aprueba&nobjeto=naprueba&nfoco=sueldo";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value!="0")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('naprueba').value='';
						document.getElementById('aprueba').focus();
						document.getElementById('aprueba').select();
					}
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
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
			function busquedas()
			{
				if (document.getElementById('aprueba').value!=""){document.getElementById('banbus').value="1";document.form2.submit();}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="hum-parametrosliquida.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a class="mgbt"><img src="imagenes/buscad.png" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
           	</tr>		
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" action="hum-parametrosliquida.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
				if($_POST[oculto]=="")
				{
					$sqlr="select *from humparametrosliquida";	
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						$_POST[aprueba]=$row[1];
						$_POST[naprueba]=buscatercero($row[1]);
						$_POST[sueldo]=$row[2];
						$_POST[primnav]=$row[3];
						$_POST[primvac]=$row[4];
						$_POST[indevac]=$row[5];
						$_POST[bondir]=$row[6];				
						$_POST[intcesa]=$row[7];
						$_POST[subalim]=$row[8];
						$_POST[auxtrans]=$row[9];
						$_POST[auxcesa]=$row[10];
						$_POST[recnoct]=$row[11];
						$_POST[horextdiu]=$row[12];
						$_POST[horextnoct]=$row[13];
						$_POST[hororddom]=$row[14];
						$_POST[horextdiudom]=$row[15];
						$_POST[horextnoctdom]=$row[16];
						$_POST[cajacomp]=$row[17];
						$_POST[icbf]=$row[18];
						$_POST[sena]=$row[19];
						$_POST[iti]=$row[20];
						$_POST[esap]=$row[21];
						$_POST[arp]=$row[22];
						$_POST[saludemr]=$row[23];
						$_POST[saludemp]=$row[24];
						$_POST[pensionemr]=$row[25];
						$_POST[pensionemp]=$row[26];
						$_POST[provcesa]=$row[27];
						$_POST[intcesapara]=$row[28];
						$_POST[incapacidades]=$row[29];
					}
				}
			?>
    		<table  class="inicio" >
                <tr>
                    <td class="titulos" colspan="4">:: Parametros de Nomina</td>
                    <td class="cerrar" style="width:7%;"><a href="hum-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:25%;">.: Aprueba Nomina:</td>
                    <td colspan="3"><input id="aprueba" name="aprueba" type="text" value="<?php echo $_POST[aprueba]?>" onKeyUp="return tabular(event,this)" onBlur="busquedas()" style="width:15%;">&nbsp;<a href="#" onClick="despliegamodal2('visible')"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="naprueba" name="naprueba" type="text" value="<?php echo $_POST[naprueba]?>"  onKeyUp="return tabular(event,this)" readonly style="width:40%;"> </td>
                </tr>
                <tr><td colspan="5" class="titulos2">Parametros Pago</td></tr>      
                <tr>
                    <td class="saludo1">Sueldo Personal de Nomina: </td>
                    <td style="width:25%;">
                        <select name="sueldo" id="sueldo" style="width:100%" >
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[sueldo]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td class="saludo1" style="width:25%">Prima Navidad:</td>
                    <td colspan="2">
                        <select name="primnav" id="primnav" style="width:100%;">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[primnav]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                 }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td class="saludo1">Prima Vacaciones: </td>
                    <td style="width:25%;">
                        <select name="primvac" id="primvac" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[primvac]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td class="saludo1">Indemnizacion Vacaciones:</td>
                    <td colspan="2">
                        <select name="indevac" id="indevac" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[indevac]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Bonificacion Direccion: </td>
                    <td style="width:25%;">
                        <select name="bondir" id="bondir" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[bondir]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">Intereses Cesantias:</td>
                    <td colspan="2">
                        <select name="intcesa" id="intcesa" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[intcesa]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Subsidio Alimentacion: </td>
                    <td style="width:25%;">
                        <select name="subalim" id="subalim" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[subalim]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">Auxilio Transporte:</td>
                    <td colspan="2">
                        <select name="auxtrans" id="auxtrans" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[auxtrans]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Auxilio Cesantias: </td>
                    <td style="width:25%;">
                        <select name="auxcesa" id="auxcesa" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[auxcesa]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">Recargo Nocturno:</td>
                    <td colspan="2">
                        <select name="recnoct" id="recnoct" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[recnoct]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Hora Extra Diurna: </td>
                    <td style="width:25%;">
                        <select name="horextdiu" id="horextdiu" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[horextdiu]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">Hora Extra Nocturna:</td>
                    <td colspan="2">
                        <select name="horextnoct" id="horextnoct" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[horextnoct]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Hora Ordinaria Dominical/Festivo</td>
                    <td style="width:25%;">
                        <select name="hororddom" id="hororddom" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {			
                                    if($row[0]==$_POST[hororddom]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">Hora Extra Diurna Dominical/Festivo:</td>
                    <td colspan="2">
                        <select name="horextdiudom" id="horextdiudom" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[horextdiudom]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else{echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Hora Extra Nocturna Dominical/Festivo: </td>
                    <td colspan="1" style="width:25%;">
                        <select name="horextnoctdom" id="horextnoctdom" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[horextnoctdom]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                   <td  class="saludo1">Incapacidades: </td>
                    <td colspan="2" style="width:25%;">
                        <select name="incapacidades" id="incapacidades" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humvariables  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[incapacidades]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr><td colspan="5" class="titulos2">Parametros Parafiscales y otros</td></tr>
                <tr>
                    <td  class="saludo1">Caja de Compensacion Familiar: </td>
                    <td style="width:25%;">
                        <select name="cajacomp" id="cajacomp" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[cajacomp]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">ICBF:</td>
                    <td colspan="2">
                        <select name="icbf" id="icbf" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[icbf]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">SENA: </td>
                    <td style="width:25%;" >
                        <select name="sena" id="sena" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[sena]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}  
                                 }   
                            ?>
                         </select>
                    </td>
                    <td  class="saludo1">Institutos Tecnicos:</td>
                    <td colspan="2">
                        <select name="iti" id="iti" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[iti]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	  
                                }   
                            ?>
                        </select>

                    </td>
                </tr>     
                <tr>
                    <td class="saludo1">ESAP: </td>
                    <td style="width:25%;">
                        <select name="esap" id="esap" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[esap]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                     <td  class="saludo1">ARL:</td>
                     <td colspan="2">
                        <select name="arp" id="arp" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[arp]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Salud Empleador: </td>
                    <td style="width:25%;">
                        <select name="saludemr" id="saludemr" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[saludemr]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">Salud Empleado:</td>
                    <td colspan="2">
                        <select name="saludemp" id="saludemp" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[saludemp]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Pension Empleador: </td>
                    <td style="width:25%;">
                        <select name="pensionemr" id="pensionemr" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[pensionemr]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">Pension Empleado:</td>
                    <td colspan="2">
                        <select name="pensionemp" id="pensionemp" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[pensionemp]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <td  class="saludo1">Provision Cesantias: </td>
                    <td style="width:25%;">
                        <select name="provcesa" id="provcesa" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[provcesa]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                    <td  class="saludo1">Intereses Cesantias:</td>
                    <td colspan="2">
                        <select name="intcesapara" id="intcesapara" style="width:100%">
                            <option value="-1">Seleccione ....</option>
                            <?php
                                $sqlr="Select * from humparafiscales  where estado='S' order by codigo";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[intcesapara]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                }   
                            ?>
                        </select>
                    </td>
                </tr>    
			</table>
            <input type="hidden" name="oculto" id="oculto" value="1">
            <input type="hidden" name="banbus" id="banbus" value=""/>
			<?php
				if($_POST[banbus]!='')
				{
					$nresul=buscatercero($_POST[aprueba]);
					if($nresul!='')
					{echo"<script>document.getElementById('naprueba').value='$nresul';document.getElementById('sueldo').focus();</script>";}
					else
					{echo"<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Documento Incorrecto');</script>";}
				}
                if($_POST[oculto]=="2")
                {
                    $sqlr="delete from humparametrosliquida";
                    mysql_query($sqlr,$linkbd);
                    $sqlr="insert into humparametrosliquida (`aprueba`, `sueldo`, `prima_navidad`, `prima_vacaciones`, `indemni_vacaciones`, `bonifica_direccion`, `int_cesantias`, `sub_alimentacion`, `aux_transporte`, `aux_cesantias`, `recar_nocturno`, `horaext_diurno`, `horaext_nocturno`, `horaord_dominical`, `horaext_diurnadom`, `horaext_noctdom`, `cajacompensacion`, `icbf`, `sena`, `iti`, `esap`, `arp`, `salud_empleador`, `salud_empleado`, `pension_empleador`, `pension_empleado`, `provi_cesantias`, `int_cesantiaspara`,`incapacidades`) values ('$_POST[aprueba]','$_POST[sueldo]','$_POST[primnav]','$_POST[primvac]','$_POST[indevac]','$_POST[bondir]','$_POST[intcesa]','$_POST[subalim]','$_POST[auxtrans]','$_POST[auxcesa]','$_POST[recnoct]','$_POST[horextdiu]','$_POST[horextnoct]','$_POST[hororddom]','$_POST[horextdiudom]','$_POST[horextnoctdom]','$_POST[cajacomp]','$_POST[icbf]','$_POST[sena]','$_POST[iti]','$_POST[esap]','$_POST[arp]','$_POST[saludemr]','$_POST[saludemp]','$_POST[pensionemr]','$_POST[pensionemp]','$_POST[provcesa]','$_POST[intcesapara]','$_POST[incapacidades]') ";
                    if (!mysql_query($sqlr,$linkbd))
					{echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD humparametrosliquida');</script>";}
                    else
                    {echo "<script>despliegamodalm('visible','3','Se ha agregado la información a la Parametrización de la nomina');</script>";}
            	}
         	?>
 		</form>
        <div id="bgventanamodal2">
     		<div id="ventanamodal2">
        		<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
            	</IFRAME>
          	</div>
     	</div>
	</body>
</html>