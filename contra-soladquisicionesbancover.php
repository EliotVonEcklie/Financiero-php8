<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "validaciones.inc";
require"conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html" />
        <title>SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/programas.js"></script>
		<script src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
        <style>
			.onoffswitch
			{
    			position: relative !important; 
				width: 69px !important;
    			-webkit-user-select:none !important; 
				-moz-user-select:none !important; 
				-ms-user-select: none !important;
			}
			.onoffswitch-checkbox { display: none !important;}
			.onoffswitch-label 
			{
    			display: block !important; 
				overflow: hidden !important; 
				cursor: pointer !important;
    			border: 2px solid #999999 !important; 
				border-radius: 20px !important;
				padding: 0 !important;
			}
			.onoffswitch-inner 
			{
   				display: block !important; 
				width: 200% !important; 
				margin-left: -100% !important;
    			transition: margin 0.3s ease-in 0s !important;
			}
			.onoffswitch-inner:before, .onoffswitch-inner:after 
			{
    			display: block !important; 
				float: left !important; 
				width: 50% !important; 
				height: 20px !important; 
				padding: 0 !important; 
				line-height: 20px !important;
    			font-size: 14px !important; 
				color: white !important; 
				font-family: Trebuchet, Arial, sans-serif !important; 
				font-weight: bold !important;
    			box-sizing: border-box !important;
				

			}
			.onoffswitch-inner:before 
			{
    			content: "SI" !important;
    			padding-left: 10px !important;
    			background-color: #34A7C1 !important; 
				color: #FFFFFF !important;
			}
			.onoffswitch-inner:after 
			{
    			content: "NO" !important;
				padding-right: 10px !important;
				background-color: #EEEEEE !important; 
				color: #999999 !important;
				text-align: right !important;
				
			}
			.onoffswitch-switch 
			{
				display: block !important; 
				width: 15px !important; 
				height: 15px !important; 
				margin: 1.5px !important;
				background: #FFFFFF !important;
				position: absolute !important; 
				top: 0 !important; 
				bottom: 0 !important;
				right: 45px !important;
				border: 2px solid #999999 !important; 
				border-radius: 20px !important;
				transition: all 0.3s ease-in 0s !important; 
			}
			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {margin-left: 0 !important;}
			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {right: 0px !important;}
		</style>
		<script>
		function buscarubro(e)
 			{if (document.form2.codrubro.value!=""){document.form2.bcrubro.value='1';document.form2.submit();}}
		function despliegamodal2(_valor,_tip)
			{

				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventana2').src="contra-soladquisicionesventana.php";break;
						case "2":
							document.getElementById('ventana2').src="contra-soladquisicionesterceros.php";break;
						case "3":
							document.getElementById('ventana2').src="contra-productos-ventana.php";break;
						case "4":
							var tipo="inversion";
							document.getElementById('ventana2').src="contra-soladquisicionescuentasppto2.php?ti=2&ti2="+tipo;break;
						case "5":
							document.getElementById('ventana2').src="contra-soladquisicionesproyectos.php";break;
					}
				}
			}
			function validar()
			{
				document.form2.oculto.value=3;
				document.form2.submit();
			}
			function guardar()
			{
				if (document.form2.solproyec.value!='' && document.form2.fecha.value!='' )
			  	{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.submit();
					}
			  	}
			  	else
				{
			  		despliegamodalm4('visible','2','Falta informacion para poder guardar')

			  	}
			}
			
			function despliegamodalm(_valor,_tip,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					var coding=document.getElementById('codigo').value;
					var vigen=document.getElementById('vigencia').value;
					switch(_tip)
					{
					
						case "1":
						
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guard\xf3; El Proyecto \""+coding+"\" con Exito";break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;	
					}
				}
			}
			
			function despliegamodalm3(_valor,_tipo,_nomb)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					var coding=document.getElementById('codigo').value;
					var vigen=document.getElementById('vigencia').value;
					switch(_tipo)
					{
						case 1:
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guard\xf3; El Proyecto \""+coding+"\" con Exito";break;
						case 2:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Ya se ingres\xf3 el c\xf3digo \""+coding+"\" de la vigencia "+vigen;break;
						case 3:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Ya se ingres\xf3 un Archivo con el nombre \""+_nomb+"\"";break;
					}
						
				}
			}
			
			function funcionmensaje()
			{
				document.getElementById('codigo').value="";
				document.getElementById('nomarch').value="";
				document.getElementById('nombre').value="";
			}
			function agregarubro()
			{
				if(document.getElementById('myonoffswitch').value==1)
				{
					if(document.form2.codrubro.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >0 && document.form2.valor.value !="")
					{ 
						if(parseFloat(document.getElementById('saldo').value)>=parseFloat(document.getElementById('valor').value))
						{
							document.form2.agregadet2.value=1;
							document.form2.submit();
						}
						else {despliegamodalm4('visible','2','La Cuenta "'+document.getElementById('codrubro').value+'" no tiene saldo suficiente');}
					}
					else {despliegamodalm4('visible','2','Falta informacion para poder Agregar');}
				}
			}

			function agregafuente(){
				if(document.getElementById('myonoffswitch').value!=1)
				{
					if( document.form2.ffinciacion.value!="" && parseFloat(document.form2.valor.value) >0 && document.form2.valor.value !="")
					{ 
					
						document.form2.agregadet8.value=1;
						document.form2.submit();
						
					
				}else {despliegamodalm4('visible','2','Falta informacion para poder Agregar');}
			}
		}
			function agregarchivo(){
				if(document.form2.rutarchivo.value!=""){
							document.form2.agregadet3.value=1;
							document.form2.submit();
				}
				else {despliegamodalm4('visible','2','Debe especificar la ruta del archivo');}
			}
			function agregameta(){
				document.getElementById('contador').value=parseInt(document.getElementById('contador').value)+1;
				document.form2.agregadet7.value=1;
				document.form2.submit();
			}
			function despliegamodalm4(_valor,_tip,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guardo la solicitud de Adqusici\xf3n con Exito";break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;	
					}
				}
			}
			function eliminar2(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			  	{
			  		var eliminar=document.getElementById('elimina');
			  		eliminar.value=variable;
					document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)-1;
					document.form2.submit();
				}
			}
			function eliminar3(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			  	{
			  		var eliminar=document.getElementById('eliminarc');
			  		eliminar.value=variable;
					document.form2.submit();
				}
			}
			
			function cambiocheck()
			{
				if(document.getElementById('myonoffswitch').value==1){document.getElementById('myonoffswitch').value=0;}
				else{document.getElementById('myonoffswitch').value=1;}

				document.form2.submit();
			}
			function descarga($arreglo){
				var nombre="<?php echo sizeof($arreglo); ?>";
				alert(nombre);
			}
			function cargarproyecto(variable){
				document.form2.oculto.value="";
				document.form2.codigo.value=variable.value;
				document.form2.submit();
			}
			function generabppim(){
				document.form2.action="pdfcertificabanco.php";
				document.form2.target="_blank";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
		</script>
        <?php 
        function calcularTamano($ruta){
        	return filesize($ruta);
        }
			titlepag();
			if($_POST[bcrubro]=='1')
			{
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$tipo=substr($_POST[codrubro],0,1);		
				$nresul=buscacuentapres($_POST[codrubro],$tipo); 	
				if($nresul!='')
				{
					$_POST[nrubro]=$nresul;
					$linkbd=conectar_bd();
					$sqlr="SELECT * FROM pptocuentas WHERE cuenta='$_POST[codrubro]' AND (vigencia='$vigusu' OR vigenciaf='$vigusu')";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[valor]=0;		  
					$_POST[saldo]=generaSaldo($row[0],$vigusu,$vigusu);		
					$ind=substr($_POST[codrubro],0,1);	
				    $clasifica=$row[29];		
				  
					if($clasifica=='regalias')
					{						
						$ind=substr($_POST[codrubro],1,1);	
						$criterio="AND (pptocuentas.vigencia='$vigusu' OR pptocuentas.vigenciaf='$vigusu') AND (pptocuentas.vigencia='$vigusu' OR  pptocuentas.vigenciaf='$vigusu')";					  
					}
					else
					{
						$criterio=" AND pptocuentas.vigencia='$vigusu' AND  pptocuentas.vigencia='$vigusu'";
					}
					if ($clasifica=='funcionamiento')
					{
						$sqlr="SELECT pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre, pptocuentas.clasificacion FROM pptocuentas,pptofutfuentefunc WHERE pptocuentas.cuenta='$_POST[codrubro]' AND pptocuentas.futfuentefunc=pptofutfuentefunc.codigo $criterio";
						
					}
					if ($clasifica=='inversion' || $clasifica=='reservas-ingresos')
					{
						$sqlr="SELECT pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre,pptocuentas.clasificacion,pptocuentas.cuenta FROM pptocuentas,pptofutfuenteinv WHERE pptocuentas.cuenta='$_POST[codrubro]' AND pptofutfuenteinv.codigo=pptocuentas.futfuenteinv $criterio";
						
					}
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					if($row[1]!='' || $row[1]!=0)
					{
						$_POST[tipocuenta]=$row[3];
						$_POST[cfuente]=$row[0];
						$_POST[fuente]=$row[2];
						$_POST[valor]=0;			  
						$_POST[saldo]=generaSaldo($row[4],$vigusu,$vigusu);			  
					}
					else
					{
						$_POST[cfuente]="";
						$_POST[fuente]=""; 
					}  
				}
				else
				{
				   $_POST[nrubro]="";	
				   $_POST[fuente]="";				   
				   $_POST[cfuente]="";				   			   
				   $_POST[valor]="";
				   $_POST[saldo]="";
				}
			}
			function eliminarDir()
			{
				$carpeta="informacion/proyectos/temp";
				foreach(glob($carpeta . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta);
			}
		?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
					<a href="plan-proyectos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
					<a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="plan-proyectosbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('plan-principal.php','',''); mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
			</tr>
     	</table>
 		<form name="form2" method="post" enctype="multipart/form-data" >
		<?php
		
    		$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
  			$linkbd=conectar_bd(); 
 			if($_POST[oculto]=="")
			{
				$codigo=$_POST[codigo];
				$sql="SELECT * FROM planproyectos WHERE codigo=$codigo";
				$result=mysql_query($sql,$linkbd);
				$row = mysql_fetch_row($result);
				$_POST[nombre]=$row[3];
				$_POST[nomarchadj]=basename($row[4]);
				$_POST[nomarch]=basename($row[4]);
				$_POST[valorproyecto]=$row[6];
				$_POST[descripcion]=$row[7];
				$_POST[contador]=0;
				$_POST[codigo]=$_GET[idproceso];
				$_POST[vigencia]=$vigusu;
				$_POST[onoffswitch]=1;	
				$_POST[tabgroup1]=1;
				
				$sql="SELECT MAX(cod_meta) FROM planproyectos_det WHERE codigo=$codigo AND vigencia=$vigusu";
				$result=mysql_query($sql,$linkbd);
				$rowc = mysql_fetch_row($result);
				if(!empty($codigo)){
					$_POST[contador]=$rowc[0]+1;
				}
				
				//----
				$sql="SELECT valor,nombre_valor FROM planproyectos_det WHERE codigo=$codigo AND vigencia=$vigusu";
				$result=mysql_query($sql,$linkbd);
				for($j=0;$j<$_POST[contador]; $j++){
					while($row = mysql_fetch_row($result)){
						$_POST["matmetas$j"][]=$row[0];
						$_POST["matmetasnom$j"][]=$row[1];
					}
   		
                 }
                 //-----
                $sql="SELECT * FROM planproyectos_adj WHERE codigo=$codigo AND vigencia=$vigusu";
               	$result=mysql_query($sql,$linkbd);
               	while($row = mysql_fetch_row($result)){
               		$_POST[nomarchivos][]=$row[2];
                    $_POST[rutarchivos][]=basename($row[4]);
                    $_POST[tamarchivos][]=filesize($row[4]);
                    $_POST[patharchivos][]=basename($row[4]);
               	}

               	$sql="SELECT estado FROM planproyectos_pres WHERE codigo=$codigo AND vigencia=$vigusu";
               	$result=mysql_query($sql,$linkbd);
               	$row = mysql_fetch_row($result);
               	if($row[0]=="C"){
					$_POST[onoffswitch]==1;
               		$sql="SELECT ppp.cuenta,ppp.valor,pc.nombre,ppp.vigencia FROM planproyectos_pres AS ppp ,pptocuentas AS pc WHERE ppp.codigo=$codigo AND ppp.vigencia=$vigusu AND ppp.cuenta=pc.cuenta AND ppp.vigencia=pc.vigencia";
					$result=mysql_query($sql,$linkbd);
					while($rowp = mysql_fetch_row($result)){
						$_POST[dcuentas][]=$rowp[0];
                        $_POST[dncuentas][]=$rowp[2];
                        $_POST[dfuentes][]=buscafuenteppto($rowp[0],$rowp[3]); 
                        $_POST[dgastos][]=$rowp[1];
					}
               	}else{
					$_POST[onoffswitch]==0;
               		$sql="SELECT ppp.valor,(SELECT nombre FROM (SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuentefunc) AS tabla WHERE codigo=ppp.fuente) AS celda,ppp.fuente FROM planproyectos_pres AS ppp WHERE ppp.codigo=$codigo AND ppp.vigencia=$vigusu ";
					$result=mysql_query($sql,$linkbd);
					while($rowp = mysql_fetch_row($result)){
                        $_POST[fuentesfinan][]=$rowp[2];
                        $_POST[nfinanciaciones][]=$rowp[1];
                        $_POST[dgastos][]=$rowp[0];
					}
               	}
            
               	
			}

 		?>
 
			            <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="8">Solicitud BPPIM</td>
                                
                            </tr>
							<tr>
                                <td class="saludo1" style="width:5%">Fecha:</td>
                                <td width="6%"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" style="width: 80%">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/></td>
								<td class="saludo1" style="width:5%">Solicitud:</td>
                                <td colspan="4" width="50%">
									<select name="solproyec" id="solproyec" onChange="cargarproyecto(this)" style="width: 100%">
										<option value='' >Seleccione...</option>
										<?php
										$sql="SELECT csp.codigo,csp.codsolicitud,csp.codproyecto,cs.objeto from contrasolicitudproyecto csp,contrasoladquisiciones cs WHERE csp.estado='S' AND csp.vigencia='$vigusu' AND csp.codsolicitud=cs.codsolicitud";
										$res=mysql_query($sql,$linkbd);
										while($row = mysql_fetch_row($res)){
											if($_POST[solproyec]==$row[0]){
												echo "<option value='$row[0]' SELECTED>$row[1] - $row[3]</option>";
												$_POST[codigo]=$row[0];
											}else{
												echo "<option value='$row[0]' >$row[1] - $row[3]</option>";
											}
											
										}
										?>
									</select>
								</td>
								<td rowspan="2" width="10%"></td>
                                
                            </tr>
							<tr>
                                <td class="saludo1" style="width:5%">Valor Actividad:</td>
                                <td style="width:6%">
								<input name="valacti" type="text" id="valacti"  value="<?php echo $_POST[valacti]; ?>" style="width: 100%;text-align:right">
								</td>
								<td class="saludo1" style="width:5%">Aporte Convenio:</td>
                                <td style="width:10%">
								<input name="aporconv" type="text" id="aporconv"  value="<?php echo $_POST[aporconv]; ?>" style="width: 100%;text-align:right">
								</td>
								<td class="saludo1" style="width:5%">Aporte Municipio:</td>
                                <td style="width:10%">
								<input name="apormuni" type="text" id="apormuni"  value="<?php echo $_POST[apormuni]; ?>" style="width: 100%;text-align:right">
								</td>
                                
                            </tr>
					</table>
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="9" >Datos Proyecto</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:7%">Codigo:</td>
                                <td style="width:20%"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:98%" readonly></td>
                                <td class="saludo1" style="width:7%">Vigencia:</td>
                                <td style="width:7%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:98%" readonly></td>
                                <td class="saludo1" style="width:8%">Archivo Adjunto:</td>
                                <td style="width:42.5%" colspan="4"><input type="text" name="nomarchadj" id="nomarchadj"  style="width:100%" value="<?php echo $_POST[nomarchadj]?>" readonly></td>
                   
                            </tr>
                            <tr>
                                <td class="saludo1">Nombre:</td>
                                <td colspan="3">
                                    <input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:100%;text-transform: uppercase;" readonly> 
                                </td>
                                <td class="saludo1">Valor del proyecto:</td>
                                <td>
       
                                    <script>jQuery(function($){ $('#valorproyecto').autoNumeric('init');});</script>
                                    <input type="hidden" name="valorp" id="valorp" value="<?php echo $_POST[valorp]?>"   />
                                    <input type="text" id="valorproyecto" name="valorproyecto"  value="<?php echo $_POST[valorproyecto]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valorp','valorproyecto');return tabular(event,this);" onBlur="validarcdp();" style="width:100%; text-align:right;" autocomplete="off" readonly>
                                    <input type="hidden" name="saldo" id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" > 

                                </td>
                                <input type="hidden" name="banderin1" id="banderin1" value="<?php echo $_POST[banderin1];?>" >
                                <input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador];?>" >
                            </tr>
							<tr>
                                <td class="saludo1">Descripci&oacute;n:</td>
                                <td colspan="3">
                                    <input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;text-transform: uppercase;" readonly> 
                                </td>
                                
                              
                            </tr>
                           
                            <tr><td colspan="4"></td><td colspan="4" rowspan="2" valign="middle"><input type="button" name="agregar6" id="agregar6" value="   Generar certificado   " onClick="generabppim()" style="position: relative;top: -25px" /></td></tr>
                        </table>
                        <?php
                        	$conta=0;
                        	 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='6'>Detalle Metas</td>
                                            </tr>
                                            <tr>";
                                $sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' ORDER BY orden";
                                $resn=mysql_query($sqln,$linkbd);
                                $n=0; $j=0;
                                while($wres=mysql_fetch_array($resn))
                                {
                                    if (strcmp($wres[0],'INDICADORES')!=0)
                                    {
                         				$conta++;
                                        echo "<td class='titulos2' style='width: 18% !important'>".strtoupper($wres[0])."</td>";
                                        	
                                    }
                                }
								echo "<td class='titulos2'><img src='imagenes/del.png'></td>";
                              		  echo "</tr>";
                                if ($_POST[eliminarm]!='')
                                { 
                                    $posi=$_POST[eliminarm];
                                    unset($_POST[matmetas][$posi]);	 		 
                                    $_POST[matmetas]= array_values($_POST[matmetas]); 	
                                    $_POST[eliminarm]='';	 		 		 		 
                                }	 
                                if ($_POST[agregadet7]=='1')
                                {
                                 	for($j=0;$j<$_POST[contador]; $j++){
                                 		for($i=0;$i<count($_POST[niveles]);$i++ ){
											$_POST["matmetas$j"][]=$_POST[niveles][$i];
											$_POST["matmetasnom$j"][]=$_POST[nmetas][$i];
										}
                                 	}
                                   		
                           
                                        $_POST[agregadet7]=0;

                                    
                                    
                                }
                                $itern='saludo1a';
                                $iter2n='saludo2';
								for($x=0;$x<$_POST[contador]; $x++){
									echo "<tr class='$itern'>";
									for ($y=0;$y<$conta;$y++)
                                {
									echo "<td>";
									if(!empty($_POST["matmetas$x"][$y])){
										echo $_POST["matmetas$x"][$y]." - ".$_POST["matmetasnom$x"][$y];
									}
									echo "<input type='hidden' name='matmetas".$x."[]' value='".$_POST["matmetas$x"][$y]."' />";
									echo "<input type='hidden' name='matmetasnom".$x."[]' value='".$_POST["matmetasnom$x"][$y]."' />";
									echo "</td>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                                echo "<td><a href='#' onclick='eliminar2($x)'><img src='imagenes/del.png'></a></td>";
								echo "</tr>";
								}
                                
                                echo "
                                    </table></div>";
                         ?>
              		
        
    	    <input type="hidden" name="oculto" id="oculto" value="1">
    		<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia];?>">
        	<input type="hidden" name="oculgen" id="oculgen" value="<?php echo $_POST[oculgen];?>">
        	<input type="hidden" name="indindex" id="indindex" value="<?php echo $_POST[indindex];?>">
           	<input type="hidden" name="codid" id="codid" value="<?php echo $_POST[codid];?>">
            <input type="hidden" name="pesactiva" id="pesactiva" value="<?php echo $_POST[pesactiva];?>">
            <input type="hidden" name="busadq" id="busadq" value="0">
         	<input type="hidden" name="bctercero" id="bctercero" value="0">
           	<input type="hidden" name="agregadets" id="agregadets" value="0">
            <input type='hidden' name="eliminars" id="eliminars" >
            <input type="hidden" name="bc" value="0">
            <input type="hidden" name="bcproyectos" value="0" >
			<input type="hidden" name="agregadet7" value="0">
            <input type="hidden" name="agregadet2" value="0">
            <input type="hidden" name="agregadet8" value="0">
            <input type="hidden" name="agregadet3" value="0">
            <input type="hidden" name="agregadet" value="0"> 
            <input type="hidden" name="agregadetadq" value="0">
            <input type='hidden' name='eliminar' id='eliminar'>
 		<?php  
			//********Validar codigo y vigencia
			if($_POST[oculto]=="3")
			{
				$linkbd=conectar_bd();
				$sqlr="SELECT * FROM planproyectos WHERE codigo='".$_POST[codigo]."' AND vigencia='".$_POST[vigencia]."'";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				if($ntr==0)
				{ echo"<script>guardar();</script>";}
				else
				{ ?><script>document.getElementById('oculto').value="0";despliegamodalm('visible',2,'Ya se ingreso el codigo');</script><?php }
			}
			//********guardar
		 	if($_POST[oculto]=="2")
			{

				$sql="UPDATE contrasolicitudproyecto SET estado='C', fecha='$_POST[fecha]', val_actividad=$_POST[valacti],apor_convenio=$_POST[aporconv],apor_municipio=$_POST[apormuni] WHERE codigo=$_POST[solproyec]";
				mysql_query($sql,$linkbd);
				echo "<script>alert('Certificado Generado con Exito'); window.location.href='plan-expedirbppim.php'; </script>";
					

			}
	
			
			
		 ?>
		 </div>
		 <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
	 	</form>       
	</body>
</html>