<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private;"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<?php function modificar_acentos($cadena) {$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","–");
$permitidas= array ("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&ntilde;","&Ntilde;","-");$texto = str_replace($no_permitidas, $permitidas ,$cadena);return $texto;}
function modificar_acentosjs($cadena) {$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","–");
$permitidas= array ("\\xe1","\\xe9","\\xed","\\xf3","\\xfa;","\\xc1","\\xc9","\\xcd","\\xd3","\\xda","\\xf1","\\xd1","-");$texto = str_replace($no_permitidas, $permitidas ,$cadena);return $texto;}?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <style>
        	.tablabuscardoc{ position: relative; display:none;}
        #bgventanamodal {
			background-image: url(imagenes/bgModal.png);
			position: fixed;
			z-index: 1;
			height: 100%;
			width: 100%;
			left: 0px;
			top: 0px;
			visibility: hidden;
		}
        #ventanamodal {
			background-color: #CCC;
			border: 10px solid #FFF;
			position: absolute;
			height: 500px;
			width: 900px;
			left: 50%;
			top: 50%;
			margin-top: -250px;
			margin-left: -450px;
		}
        </style>
        <script type='text/javascript' src='funcioneshf.js'></script>  
        <script type='text/javascript'>
			function despliegamodal(_valor)
			{
				document.getElementById("bgventanamodal").style.visibility=_valor;
			}
		</script>     
    </head>
	<body>
		<div id="bgventanamodal">
        	<div id="ventanamodal">
                <IFRAME src="terceros-ventana.php" name="otras" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
 </IFRAME> <p><a href="javascript:despliegamodal('hidden');">Cerrar ventana</a></p>
            </div>
        </div>
        
		<table >
        	<tr>
            	<td ><img src="imagenes/logoplan.png" class="imgtitulos"></td>
                <td><img src="imagenes/entidad.png" class="imgtitulos"></td>
                <td>
					<table class="inicio">
           				 <tr>
                         	<td  class="saludo1" >Usuario: </td>
                            <td><?php echo $_SESSION[usuario]?></td>
            				<td class="saludo1">Perfil: </td><td><?php echo $_SESSION["perfil"];?></td>
                       	</tr>
             			<tr>
                        	<td  class="saludo1" >Fecha ingreso:</td>
                            <td> <?php echo " ".$fec=date("Y-m-d");?> </td> 
                            <td class="saludo1">Hora Ingreso: </td>
                            <td><?php $hora=time();echo " ".date ( "h:i:s" , $hora ); $hora=date ( "h:i:s" , $hora )?></td>
                    	</tr>
					</table>
				</td>
			</tr>
        	<tr>
            	<td colspan="3">
            	<!-- Navigation -->  
            		<ul class="mi-menu">  
            		<li><a href="principal.php">Inicio</a></li>  
            		<li><a href="#">Archivos Maestros</a><ul><script>document.write('<?php echo modificar_acentos($_SESSION[linksetpl][1]);?>')</script></ul></li>
            		<li><a href="#">Procesos</a><ul><script>document.write('<?php echo modificar_acentos($_SESSION[linksetpl][2]);?>')</script></ul></li>		
           			<li><a href="#" >Herramientas</a><ul><script>document.write('<?php echo modificar_acentos($_SESSION[linksetpl][3]);?>')</script></ul></li>
           			<li><a href="#" >Informes</a><ul><script>document.write('<?php echo modificar_acentos($_SESSION[linksetpl][4]);?>')</script></ul></li>         
            		<li><a href="ayuda.html" target="_blank">Ayuda</a></li>   
           			<li style="text-align:right; float:right"><a href="#"><?php  $vigusu=vigencia_usuarios($_SESSION[cedulausu]); echo " ".$vigusu ?></a></li>        
                	</ul>  
            	</td>
			</tr>
    		<tr>
      			<td colspan="3" class="cinta"><a href="#" ><script>boton_agenda();</script></a> <a href="#" id="imguardar"><img src="imagenes/guardad.png"  alt="Guardar" onClick="" /></a> <a href="#" onClick="#" > <img src="imagenes/buscad.png" alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>
				</td>
			</tr>
		</table>
        <!-- Inicio del modulo de atención al ciudadano -->
		<form name="forminicio" method="post" action="" >
        <table class="inicio" >
            <tr>
              <td class="titulos"colspan="2">:: Tramites</td>
              <td width="5%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
            </tr>
            <tr >
                <td class="saludo1" style="width:10%" >:&middot; Tipo de tramite:</td>
                <td>
                	<select id="ttramites" name="ttramites" class="elementosmensaje" style="width:25%">
                    	<option value="">Seleccione....</option>
						<?php	
								$sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPO_TRAMITE_AC' ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
				    			{
									echo "<option value= ".$rowEmp['valor_inicial'];
									$i=$rowEmp['valor_inicial'];
					 				if($i==$_POST[evento])
			 						{
						 				echo "  SELECTED";
						 				$_POST[nombreevento]=$rowEmp['descripcion_valor'];
						 			}
					  				echo ">".$rowEmp['valor_inicial']." - ".modificar_acentos($rowEmp['descripcion_valor'])."</option>"; 	 
								}		
              			?> 
	      			</select>
                </td>
            </tr>
        </table>
        </form>
        <span id="tablabuscardoc" class="tablabuscardoc">
            <form action="" method="post" enctype="multipart/form-data" name="formbusdocrad" id="formbusdocrad"> 
                <table class="inicio">
                    <tr >
                      <td height="25" colspan="4" class="titulos" >:.Buscar Documentos Radicados </td>
                      <td width="5%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
                    </tr>
                    <tr>
                      <td colspan="5" class="titulos2" >:&middot; Por Descripci&oacute;n </td>
                    </tr>
                    <tr >
                      <td width="13%" class="saludo1"  >:&middot; Documento:</td>
                      <td  colspan="3">
                          <input name="numero" type="text" size="30" >
                          <input name="oculto" type="hidden" id="oculto" value="1" >
                      </td>
                    </tr>
                </table>
            </form>
        </span>
        <span id="tablaradicardoc" class="tablaradicardoc">
            <form action="" method="post" enctype="multipart/form-data" name="formraddoc"> 
            	 
                <table class="inicio">
                    <tr >
                      <td height="25" colspan="10" class="titulos" >:.Radicar Documento </td>
                      <td width="5%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
                    </tr>
                    <tr>
						<td width="13%" class="saludo1" style="width:9%" >:&middot; N&deg; Radicaci&oacute;n:</td>
                      	<td ><input id="nradicado" name="nradicado" type="text" style="width:95%"></td>
                        <td class="saludo1" style="width:5%">:&middot; Fecha:</td>
						<td>
                        	<input id="fecharad" name="fecharad" type="text"  style="width:95%" readonly>
                        	<input id="fecharado" name="fecharado" type="hidden">
                        </td>
                        	<script>
								var fechrad=document.getElementById("fecharad");fechrad.value=fecha_corta(new Date());
								var fechrado=document.getElementById("fecharado");fechrado.value=fecha_sinformato(new Date());
						 	</script>
                		<td class="saludo1" style="width:5%" >:&middot; Hora:</td>
                		<td>
                        	<input id="horarad" name="horarad" type="text"  style="width:95%"required="required">
                            <input id="horarado" name="horarado" type="hidden">
                        </td>
                        <script>window.onload = function(){setInterval(hora_corta, 1000);}</script>
                        <td class="saludo1" style="width:9%" >:&middot;Tipo Radicaci&oacute;n:</td>
                        <td>
                        	<select id="tradicacion" name="tradicacion" class="elementosmensaje" style="width:95%"  onKeyUp="return tabular(event,this)" onChange="sumadiashabiles(this.value);">
                            	<option onChange="" value="" >Seleccione....</option>
                                <?php	
								$sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPO_RADICACION_AC' ORDER BY  valor_inicial ASC  ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
				    			{
									echo "<option value= ".$rowEmp['valor_final'];
									$i=$rowEmp['valor_inicial'];
					 				if($i==$_POST[evento])
			 						{
						 				echo "  SELECTED";
						 				$_POST[nombreevento]=$rowEmp['descripcion_valor'];
						 			}
					  				echo ">".$rowEmp['valor_inicial']." - ".modificar_acentos($rowEmp['descripcion_valor'])."</option>"; 	 
								}		
              			?> 
                            </select>
                     	</td>
						<td class="saludo1" style="width:8%" >:&middot; Fecha Limite:</td>

                		<td>
                        	<input id="fechares" name="fechares" type="text"  style="width:95%"required="required">
                            <input id="fechareso" name="fechareso" type="hidden">
                        </td>
                    </tr>
                    <tr>
                    	<td class="saludo1" >:&middot; Tercero:</td>
                        <td colspan="3">
                        	<input id="tercero" type="text" name="tercero" style="width:98%"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="">
                      	</td>
                       	<td >
                        	<a href="#" onClick="despliegamodal('visible');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                            <input type="hidden" value="0" name="bt">
                       	</td>
                    </tr>
                </table>   
            </form>
        </span>
        
      
<IFRAME src="calendario1/mensajes.php" name="otra" marginWidth=0 marginHeight=0 frameBorder=0  id=elIframe style="Z-INDEX: 1; LEFT: 500px; WIDTH: 500px; POSITION: absolute; TOP: 200px; HEIGHT: 300px; visibility:hidden;" frameSpacing=0> 
 </IFRAME> 

        
</body>
</html>