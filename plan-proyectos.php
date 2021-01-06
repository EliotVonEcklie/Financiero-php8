<?php //V 1000 12/12/16 ?> 
<?php
error_reporting(0);
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
 			{if (document.form2.codrubro.value!=""){document.form2.bcrubro.value='1';document.form2.oculto.value=1;document.form2.submit();}}
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
				if (document.form2.codigo.value!='' && document.form2.nombre.value!='' && document.form2.valorproyecto.value!='' && document.form2.nomarchadj.value!='' && document.form2.vigencia.value!='')
			  	{
					var contador=document.form2.contador.value;
					if(contador=='0'){
						despliegamodalm4('visible','2','Debe especificar alguna meta');
					}else{
						if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.submit();
					}
					}
					
			  	}
			  	else
				{
			  		despliegamodalm4('visible','2','Falta informacion para poder guardar');
					document.form2.nombre.focus();
					document.form2.nombre.select();
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
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guardo El Proyecto \""+coding+"\" con Exito";break;
						case 2:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Ya se ingres\xf3 el c\xf3digo \""+coding+"\" de la vigencia "+vigen;break;
						case 3:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Ya se ingres\xf3 un Archivo con el nombre \""+_nomb+"\"";break;
					}
						
				}
			}
			
			function funcionmensaje()
			{
				var coding=document.getElementById('auto').value;
				window.location='plan-proyectoseditar.php?idproceso='+coding;
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
							document.form2.oculto.value=1;
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
						document.form2.oculto.value=1;
						document.form2.submit();
						
					
				}else {despliegamodalm4('visible','2','Falta informacion para poder Agregar');}
			}
		}
			function agregarchivo(){
				if(document.form2.rutarchivo.value!=""){
							document.form2.agregadet3.value=1;
							document.form2.oculto.value=1;
							document.form2.submit();
				}
				else {despliegamodalm4('visible','2','Debe especificar la ruta del archivo');}
			}
		
			function existeMeta(meta){
				var contador=document.getElementById("contador").value;
				var retorno=false;
				for(var x=0;x<contador; x++){
						var arreglo=document.getElementsByName("matmetas"+x+"[]");
						for(var i=0;i<arreglo.length;i++){
							if(arreglo.item(i).value==meta){
								retorno=true;
								break;
							}
						}
					if(retorno==true){
						break;
					}
					
				}
			
				return retorno;
				
			}
			
			function agregameta(){
				var contador=document.getElementById("contador").value;
				var tam=document.getElementById("sumnivel").value;
				var entra=false;
				for(var i=0;i<tam;i++){
					var valor=document.getElementById("niveles["+i+"]").value;
					if(valor==''){
						entra=true;
						break;
					}
				}
				
				if(entra){
					for(var i=0;i<tam;i++){
					document.getElementById("niveles["+i+"]").value='';
					}
				
					despliegamodalm4('visible','2','No pueden existir metas vacias');
				}else{
					var exMeta=existeMeta(document.getElementById("niveles["+(tam-1)+"]").value);
					if(exMeta){
						despliegamodalm4('visible','2','Metas Repetidas');
					}else{
						document.getElementById('contador').value=parseInt(document.getElementById('contador').value)+1;
						document.form2.agregadet7.value=1;
						document.form2.oculto.value=1;
						document.form2.submit();
					}
					
				}
				
				
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
					document.form2.oculto.value=1;
					document.form2.submit();
				}
			}
			function eliminar3(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			  	{
			  		var eliminar=document.getElementById('eliminarc');
			  		eliminar.value=variable;
			  		document.form2.oculto.value=1;
					document.form2.submit();
				}
			}
			
			function eliminarmeta(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			  	{
			  		var eliminar=document.getElementById('eliminarm');
			  		eliminar.value=variable;
			  		document.form2.oculto.value=1;
					document.form2.contador.value=parseInt(document.form2.contador.value)-1;
					document.form2.submit();
				}
			}
			function cambiocheck()
			{
				if(document.getElementById('myonoffswitch').value==1){document.getElementById('myonoffswitch').value=0;}
				else{document.getElementById('myonoffswitch').value=1;}
				document.form2.oculto.value=1;
				document.form2.submit();
			}
			function descarga($arreglo){
				var nombre="<?php echo sizeof($arreglo); ?>";
				alert(nombre);
			}
			function redireccion(){
				var nombre=document.form2.nomarchadj.value;
				window.location.href='informacion/proyectos/temp/'+nombre ;
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
  				<td colspan="3" class="cinta"><a href="plan-proyectos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#" onClick="validar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="plan-proyectosbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0"/></a><a href="#" onClick="mypop=window.open('plan-principal.php','',''); mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
     	</table>
 		<form name="form2" method="post" enctype="multipart/form-data" >
		<?php
    		$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
  			$linkbd=conectar_bd(); 
 			if($_POST[oculto]=="")
			{
				$_POST[contador]=0;
				$_POST[vigencia]=$vigusu;
				$_POST[onoffswitch]=1;	
				$_POST[tabgroup1]=1;
			}
			switch($_POST[tabgroup1])
			{
				case 1:
					$check1='checked';break;
				case 2:
					$check2='checked';break;
				case 3:
					$check3='checked';break;
				case 4:
					$check4='checked';break;
			}
 		?>
        <div class="tabsmeci"  style="height:76.5%; width:99.6%">

                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Proyecto</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="9" >Ingresar Proyecto</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:7%">Codigo:</td>
                                <td style="width:20%"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:98%"></td>
                                <td class="saludo1" style="width:7%">Vigencia:</td>
                                <td style="width:7%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:98%" ></td>
                                <td class="saludo1" style="width:8%">Archivo Adjunto:</td>
                                <td style="width:42.5%" colspan="4"><input type="text" name="nomarchadj" id="nomarchadj"  style="width:95%" value="<?php echo $_POST[nomarchadj]?>" readonly><img <?php if(!empty($_POST[nomarchadj])){echo "src='imagenes/descargar.png' onClick='redireccion()' ";  }else{echo "src='imagenes/descargard.png' ";}; ?>  title="descargar" style="cursor:pointer !important"  /></td>
                   
                            </tr>
                            <tr>
                                <td class="saludo1">Nombre:</td>
                                <td colspan="3">
                                    <input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:100%;text-transform: uppercase;"> 
                                </td>
                                <td class="saludo1">Valor del proyecto:</td>
                                <td>
                
                                    <script>jQuery(function($){ $('#valorproyecto').autoNumeric('init');});</script>
                                    <input type="hidden" name="valorp" id="valorp" value="<?php echo $_POST[valorp]?>"   />
                                    <input type="text" id="valorproyecto" name="valorproyecto"  value="<?php echo $_POST[valorproyecto]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valorp','valorproyecto');return tabular(event,this);" onBlur="validarcdp();" style="width:100%; text-align:right;" autocomplete="off">
                                </td>
                                <input type="hidden" name="banderin1" id="banderin1" value="<?php echo $_POST[banderin1];?>" >
                                <input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador];?>" >
                            </tr>
							<tr>
                                <td class="saludo1">Descripci&oacute;n:</td>
                                <td colspan="7">
                                    <input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;text-transform: uppercase;"> 
                                </td>
                                
                              
                            </tr>
                            <?php
                                $sqln="SELECT nombre, orden, codigo FROM plannivelespd WHERE estado='S' ORDER BY orden";
                                $resn=mysql_query($sqln,$linkbd);
                                $n=0; $j=0;
                                while($wres=mysql_fetch_array($resn))
                                {
                                    if (strcmp($wres[0],'INDICADORES')!=0)
                                    {
                                        if($wres[1]==1){$buspad='';}
                                        elseif($_POST[arrpad][($j-1)]!=""){$buspad=$_POST[arrpad][($j-1)];}
                                        else {$buspad='';}
                                        if($n==0){echo"<tr>";}
                                        echo"
                                            <td class='saludo1'>".strtoupper($wres[0])."</td>
                                            <td colspan='3' style='width:35%;'>
                                                <select name='niveles[$j]' id='niveles[$j]'  onChange='document.form2.oculto.value=1;document.form2.submit();' onKeyUp='return tabular(event,this)' style='width:100%;'>
                                                    <option value=''>Seleccione....</option>";
                                        $sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad'  ORDER BY codigo";
                                        $res=mysql_query($sqlr,$linkbd);
                                        while ($row =mysql_fetch_row($res)) 
                                        {
                                            if($row[0]==$_POST[niveles][$j])
                                            {
                                                $_POST[arrpad][$j]=$row[0];
                                                $_POST[nmeta]=$row[0];
                                                $_POST[meta]=$row[1];
                                                $_POST[codmeta]=$wres[2];
                                                echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
                                                
                                            }
                                            else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
                                        }	
                                        echo"	</select>
                                                <input type='hidden' name='arrpad[$j]' value='".$_POST[arrpad][$j]."' >
                                                <input type='hidden' name='meta' value='".$_POST[meta]."' >
                                                <input type='hidden' name='codmeta' value='".$_POST[codmeta]."' >
                                                <input type='hidden' name='codmetas[]' value='".$_POST[codmeta]."' />
                                                 <input type='hidden' name='nmetas[]' value='".$_POST[meta]."' />
                                                <input type='hidden' name='nmeta' value='".$_POST[nmeta]."' >

                                            </td>";
                                        $n++;
                                        if($n>1){$n=0;echo"</tr>";}
                                        $j++;
                                    }
                                }
                            ?>
                            <tr><td colspan="4"></td><td colspan="4" rowspan="2" valign="middle"><input type="button" name="agregar6" id="agregar6" value="   Agregar   " onClick="agregameta()" style="position: relative;top: -25px" /></td></tr>
                        </table>
                        <?php
						$suma=0;
						$sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' AND nombre!='INDICADORES' ORDER BY orden";
						$resn=mysql_query($sqln,$linkbd);
						$suma=mysql_num_rows($resn)+1;
						$_POST[sumnivel]=$suma-1;				
                        	 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='$suma'>Detalle Metas</td>
                                            </tr>
                                            <tr>";
										
										
										$n=0; $j=0;
										while($wres=mysql_fetch_array($resn))
										{
											if (strcmp($wres[0],'INDICADORES')!=0)
											{
								 
												echo "<td class='titulos2' style='width: 18% !important'>".strtoupper($wres[0])."</td>";
													
											}
										}
								echo "<td class='titulos2'><img src='imagenes/del.png'></td>";
                              		  echo "</tr>";
                                if ($_POST[eliminarm]!='')
                                { 
                                    $posi=$_POST[eliminarm];
                                    unset($_POST["matmetas$posi"]);	
									unset($_POST["matmetasnom$posi"]);									
                                    $_POST["matmetas$posi"]= array_values($_POST["matmetas$posi"]); 
									$_POST["matmetasnom$posi"]= array_values($_POST["matmetasnom$posi"]); 									
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
									for ($y=0;$y<count($_POST[niveles]);$y++)
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
                                echo "<td><a href='#' onclick='eliminarmeta($x)'><img src='imagenes/del.png'></a></td>";
								echo "</tr>";
								}
                                
                                echo "
                                    </table></div>";
                         ?>
              		</div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Presupuesto</label>
                    <div class="content" style="overflow:hidden;" >
                   	 	<table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="9">Ingresar Proyecto</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:4cm;">Agregar Rubro:</td>
                            	<td>
                                	<div class="onoffswitch">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" value="<?php echo $_POST[onoffswitch];?>" <?php if($_POST[onoffswitch]==1){echo "checked";}?> onChange="cambiocheck();"/>
                                        <label class="onoffswitch-label " for="myonoffswitch">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <?php
								if($_POST[onoffswitch]==1)
                                {
                                    echo"
                                        <tr>
                                            <td  class='saludo1'>Rubro:</td>
                                            <td>
                                                <input type='text' id='codrubro' name='codrubro' onKeyUp='return tabular(event,this)' onBlur='buscarubro(event)' value='$_POST[codrubro]' onClick=\"document.getElementById('codrubro').focus(); document.getElementById('codrubro').select();\" style='width:85%'>&nbsp;<img src='imagenes/find02.png' onClick=\"despliegamodal2('visible','4');\" class='icoop'/>
                                                <input type='hidden' value='0' name='bcrubro' id='bcrubro'>
                                            </td>
                                            <td colspan='6' style='width:26%'><input name='nrubro' id='nrubro' type='text' value='$_POST[nrubro]' style='width:100%' readonly></td>
                                        </tr>
                                        <tr>
                                            <td class='saludo1'>Fuente:</td>
                                            <td colspan='7'><input name='fuente' type='text' onKeyUp='return tabular(event,this)' value='$_POST[fuente]' style='width:100%' readonly></td>
                                            <input type='hidden' name='cfuente' value='$_POST[cfuente]'/>
                                        </tr>";
                                                
                                }
                                else
                                {
                                    echo"
                                        <tr>
                                            <td  class='saludo1'>F. Finaciaci&oacute;n:</td>
                                            <td colspan='7'>
                                                <select name='ffinciacion' id='ffinciacion' style='width:100%;'>
                                                    <option value=''>Seleccione....</option>
                                                    <option value=''>---------------Funcionamiento---------------.</option>";
                                    $sqlr="SELECT * FROM pptofutfuentefunc ORDER BY  codigo + 0  ASC";
                                    $res=mysql_query($sqlr,$linkbd);
                                    while ($row =mysql_fetch_row($res)) 
                                    {
                                        if($row[0]==$_POST[ffinciacion])
                                        {
                                            echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
                                            $_POST[nfinanciacion]=$row[1];
                                            $_POST[tipofina]="func";
                                        }
                                        else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
                                    }
                                    echo"		<option value=''>---------------Inversion---------------.</option>";	
                                    $sqlr="SELECT * FROM pptofutfuenteinv ORDER BY  codigo + 0  ASC";
                                    $res=mysql_query($sqlr,$linkbd);
                                    while ($row =mysql_fetch_row($res)) 
                                    {
                                        if($row[0]==$_POST[ffinciacion])
                                        {
                                            echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
                                            $_POST[nfinanciacion]=$row[1];
                                            $_POST[tipofina]="inve";
                                        }
                                        else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
                                    }
                                    echo"	</select>
                                            <input type='hidden' name='nfinanciacion' id='nfinanciacion' value='$_POST[nfinanciacion]'/>
                                            <input type='hidden' name='tipofina' id='tipofina' value='$_POST[tipofina]'/>
                                        </td>
                                    </tr>";
                                }
							?>
                            <tr> 
                               
                                <td class="saludo1">Valor:</td>
                                <td>
                                    <script>jQuery(function($){ $('#valorv').autoNumeric('init');});</script>
                                    <input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>"   />
                                    <input type="text" id="valorv" name="valorv"  value="<?php echo $_POST[valorv]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valor','valorv');return tabular(event,this);" onBlur="validarcdp();" style="width:85%; text-align:right;" autocomplete="off">
                                    <input type="hidden" name="saldo" id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" readonly> 
                                </td>
                                <td>
                                    <?php
                                        if($_POST[onoffswitch]==1)
                                        {echo"<input type='button' name='agregar2' id='agregar2' value='   Agregar   ' onClick='agregarubro()'/>";}
										else
										{echo"<input type='button' name='agregar3' id='agregar3' value='   Agregar   ' onClick='agregafuente()'/>";}
                                    ?>
                                </td>
                            </tr> 
                      	</table>
                        <input type="hidden" name="elimina" id="elimina" value="<?php echo $_POST[elimina]; ?>">
                        <input type="hidden" name="eliminarc" id="eliminarc" value="<?php echo $_POST[eliminarc]; ?>">
						<input type="hidden" name="eliminarm" id="eliminarm" value="<?php echo $_POST[eliminarm]; ?>">
						<?php
                            if($_POST[onoffswitch]==1)
                            {
                                echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='5'>Detalle Rubros</td>
                                            </tr>
                                            <tr>
                                                <td class='titulos2'>Cuenta</td>
                                                <td class='titulos2'>Nombre Cuenta</td>
                                                <td class='titulos2'>Fuente</td>
                                          
                                                <td class='titulos2'>Valor</td>
                                                <td class='titulos2'><img src='imagenes/del.png'></td>
                                            </tr>";
                                if ($_POST[elimina]!='')
                                { 
                                    $posi=$_POST[elimina];
                                    $cuentagas=0;
                                    $cuentaing=0;
                                    $diferencia=0;
                                    unset($_POST[dcuentas][$posi]);
                                    unset($_POST[dtipogastos][$posi]);
                                    unset($_POST[dncuentas][$posi]);
                                    unset($_POST[dgastos][$posi]);		 		 		 		 		 
                                    unset($_POST[dcfuentes][$posi]);		 		 
                                    unset($_POST[dfuentes][$posi]);		 		 
                                    $_POST[dcuentas]= array_values($_POST[dcuentas]); 
                                    $_POST[dtipogastos]= array_values($_POST[dtipogastos]); 
                                    $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                                    $_POST[dgastos]= array_values($_POST[dgastos]); 
                                    $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                                    $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
                                    $_POST[elimina]='';	 		 		 		 
                                }	 
                                if ($_POST[agregadet2]=='1')
                                {
                                    $ch=esta_en_array($_POST[dcuentas],$_POST[codrubro]);
                                    if($ch!='1')
                                    {			 
                                        $cuentagas=0;
                                        $cuentaing=0;
                                        $diferencia=0;
                                        $_POST[dcuentas][]=$_POST[codrubro];
                                        $_POST[dtipogastos][]=$_POST[tipocuenta];
                                        $_POST[dncuentas][]=$_POST[nrubro];
                                        $_POST[dfuentes][]=$_POST[fuente];
                                        $_POST[dcfuentes][]=$_POST[cfuente];		 
                                        $_POST[valor]=str_replace(".","",$_POST[valor]);
                                        $_POST[dgastos][]=$_POST[valor];
                                        $_POST[agregadet2]=0;
                                        echo"
                                        <script>	
                                            document.form2.codrubro.value='';
                                            document.form2.nrubro.value='';
                                            document.form2.fuente.value='';
                                            document.form2.cfuente.value='';
                                            document.form2.valor.value='';
                                            document.form2.valorv.value='';
                                            document.form2.saldo.value='';
                                            document.form2.codrubro.focus();	
                                        </script>";
                                    }
                                    else {echo"<script>parent.despliegamodalm('visible','2','Ya se Ingreso el Rubro  $_POST[codrubro] en el CDP');</script>";}
                                }

                                for ($x=0;$x<count($_POST[dcuentas]);$x++)
                                {
                                    echo "
                                    <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
                                    <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                                    <input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
                                    <input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
                                        <tr class='$itern'>
                                            <td>".$_POST[dcuentas][$x]."</td>
                                            <td>".$_POST[dncuentas][$x]."</td>
                                            <td>".$_POST[dfuentes][$x]."</td>
                                            <td  style='width:5%;'><input class='inpnovisibles' name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text'  onDblClick='llamarventana(this,$x)'  style='text-align:right;' readonly></td>
                                            <td><a href='#' onclick='eliminar2($x)'><img src='imagenes/del.png'></a></td>
                                            <input name='dtipogastos[]' value='".$_POST[dtipogastos][$x]."' type='hidden'>
                                        </tr>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                    $gas=$_POST[dgastos][$x];
                                    $gas=$gas;
                                    $cuentagas=$cuentagas+$gas;
                                    $_POST[cuentagas2]=$cuentagas;
                                    $total=number_format($total,2,",","");
                                    $_POST[cuentagas]=$cuentagas;
                                    $_POST[letras]=convertir($cuentagas)." PESOS";
                                }
                                echo "
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style='text-align:right;'>TOTAL:</td>
                                            <td style='text-align:right;'><input type='hidden' class='inpnovisibles' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'  readonly>$".number_format($_POST[cuentagas],2,".",",")."<input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'><input id='letras' name='letras' value='$_POST[letras]' type='hidden'></td>
                                        </tr>
                                        <tr>
                                            <td class='saludo1'>Son:</td>
                                            <td class='saludo1' colspan= '4'>$_POST[letras]</td>
                                        </tr>
                                    </table>";
                            }
							else
							{
								 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='3'>Detalle Rubros</td>
                                            </tr>
                                            <tr>
                                                <td class='titulos2' style='width: 80%' >F. Financiaci&oacute;n</td>
                                                <td class='titulos2'>Valor</td>
                                                <td class='titulos2'><img src='imagenes/del.png'></td>
                                            </tr>";
                                if ($_POST[elimina]!='')
                                { 
                                    $posi=$_POST[elimina];
                                    $cuentagas=0;
                                    $cuentaing=0;
                                    $diferencia=0;
                                    unset($_POST[dcuentas][$posi]);
                                    unset($_POST[dtipogastos][$posi]);
                                    unset($_POST[dncuentas][$posi]);
                                    unset($_POST[dgastos][$posi]);		 		 		 		 		 
                                    unset($_POST[dcfuentes][$posi]);		 		 
                                    unset($_POST[dfuentes][$posi]);		 		 
                                    $_POST[dcuentas]= array_values($_POST[dcuentas]); 
                                    $_POST[dtipogastos]= array_values($_POST[dtipogastos]); 
                                    $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                                    $_POST[dgastos]= array_values($_POST[dgastos]); 
                                    $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                                    $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
                                    $_POST[elimina]='';	 		 		 		 
                                }	

                                if ($_POST[agregadet8]=='1')
                                {
                                    $ch=esta_en_array($_POST[fuentesfinan],$_POST[ffinciacion]);
                                    if($ch!='1')
                                    {			 
                                        $cuentagas=0;
                                        $cuentaing=0;
                                        $diferencia=0;
                                        $_POST[fuentesfinan][]=$_POST[ffinciacion];
                                        $_POST[nfinanciaciones][]=$_POST[nfinanciacion];
                                        $_POST[valor]=str_replace(".","",$_POST[valor]);
                                        $_POST[dgastos][]=$_POST[valor];
                                        $_POST[agregadet8]=0;
                                        echo"
                                        <script>	
                                            document.form2.valor.value='';	
                                        </script>";
                                    }
                                    else {echo"<script>parent.despliegamodalm('visible','2','Ya se Ingreso La fuente  $_POST[ffinciacion] ');</script>";}
                                }
                                $itern='saludo1a';
                                $iter2n='saludo2';
                                for ($x=0;$x<count($_POST[fuentesfinan]);$x++)
                                {
                                    echo "
                                    <input type='hidden' name='fuentesfinan[]' value='".$_POST[fuentesfinan][$x]."'/>
                                        <tr class='$itern'>
                                            <td>".$_POST[fuentesfinan][$x]."-".$_POST[nfinanciaciones][$x]."</td>
                                            <td  style='width:5%;'><input class='inpnovisibles' name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text'  onDblClick='llamarventana(this,$x)'  style='text-align:right;' readonly></td>
                                            <td><a href='#' onclick='eliminar2($x)'><img src='imagenes/del.png'></a></td>
                                        </tr>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                    $gas=$_POST[dgastos][$x];
                                    $gas=$gas;
                                    $cuentagas=$cuentagas+$gas;
                                    $_POST[cuentagas2]=$cuentagas;
                                    $total=number_format($total,2,",","");
                                    $_POST[cuentagas]=$cuentagas;
                                    $_POST[letras]=convertir($cuentagas)." PESOS";
                                } 
                                
                             
                                echo "
                                        <tr>
                                            <td></td>
                                            <td style='text-align:right;'>TOTAL:</td>
                                            <td style='text-align:right;'><input type='hidden' class='inpnovisibles' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'  readonly>$".number_format($_POST[cuentagas],2,".",",")."<input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'><input id='letras' name='letras' value='$_POST[letras]' type='hidden'></td>
                                        </tr>
                                        <tr>
                                            <td class='saludo1'>Son:</td>
                                            <td class='saludo1' colspan= '2'>$_POST[letras]</td>
                                        </tr>
                                    </table>";
							}
						?>
                    </div>
              	</div>
              	<div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3; ?> >
                    <label for="tab-3">Anexos</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="6" >Subir Anexos</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:8%">Archivo Principal:</td>
                                <td style="width:25%" ><input type="text" name="nomarch" id="nomarch"  style="width:100%;" value="<?php echo $_POST[nomarch]?>" readonly> </td>
                                    <td style="width:3%">
                                    	<div class='upload'> 
                                        <input type="file" name="plantillaad" onChange="document.form2.oculto.value=1;document.form2.submit();" />
                                        <img src="imagenes/upload01.png" style="width:18px" title="Cargar" /> 
                                    </div> 
                                    </td>
            					<td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="titulos" colspan="7" >Otros Anexos</td>
     
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:8%">Anexo:</td>
                                <td style="width:25%" ><input type="text" name="rutarchivo" id="rutarchivo"  style="width:100%;" value="<?php echo $_POST[rutarchivo]?>" readonly> <input type="hidden" name="tamarchivo" id="tamarchivo" value="<?php echo $_POST[tamarchivo] ?>" /><input type="hidden" name="patharchivo" id="patharchivo" value="<?php echo $_POST[patharchivo] ?>" />

                                 </td>
                                    <td style="width:3%">
                                    	<div class='upload'> 
                                        <input type="file" name="plantillaad1" onChange="document.form2.oculto.value=1;document.form2.submit();" />
                                        <img src="imagenes/upload01.png" style="width:18px" title="Cargar" /> 
                                    </div> 
                                    </td>
                                <td class="saludo1" style="width:8%">Nombre:</td>
            					<td width="25%"><input type="text" style="width: 100% !important; " name="nomarchivo" id="nomarchivo" /></td>
            					<td><input type='button' name='agregar2' id='agregar2' value='   Agregar   ' onClick='agregarchivo()'/></td>
            					<td></td>
                            </tr>
                        </table>
                        <?php
						
                        	 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='5'>Detalle Adjuntos</td>
                                            </tr>
                                            <tr>
                                                <td class='titulos2'>Nombre</td>
                                                <td class='titulos2'>Ruta</td>
                                                <td class='titulos2'>".utf8_decode("Tamaño")."</td>
                                                <td class='titulos2'></td>
                                                <td class='titulos2'><img src='imagenes/del.png'></td>
                                            </tr>";
                                if ($_POST[eliminarc]!='')
                                { 
                                    $posi=$_POST[eliminarc];
                                    unset($_POST[nomarchivos][$posi]);
                                    unset($_POST[rutarchivos][$posi]);
                                    unset($_POST[tamarchivos][$posi]);
                                    unset($_POST[patharchivos][$posi]);	 		 
                                    $_POST[nomarchivos]= array_values($_POST[nomarchivos]); 
                                    $_POST[rutarchivos]= array_values($_POST[rutarchivos]); 
                                    $_POST[tamarchivos]= array_values($_POST[tamarchivos]); 
                                    $_POST[patharchivos]= array_values($_POST[patharchivos]); 	
                                    $_POST[eliminarc]='';	 		 		 		 
                                }	 
                                if ($_POST[agregadet3]=='1')
                                {
                                    $ch=esta_en_array($_POST[nomarchivos],$_POST[nomarchivo]);
                                    if($ch!='1')
                                    {			 
                                        $_POST[nomarchivos][]=$_POST[nomarchivo];
                                        $_POST[rutarchivos][]=$_POST[rutarchivo];
                                        $_POST[tamarchivos][]=$_POST[tamarchivo];
                                        $_POST[patharchivos][]=$_POST[patharchivo];
                                        $_POST[agregadet3]=0;
                                        echo"
                                        <script>	
                                            document.form2.nomarchivo.value='';
                                            document.form2.rutarchivo.value='';
                                            document.form2.tamarchivo.value='';
                                        </script>";
                                    }
                                    else {echo"<script>parent.despliegamodalm('visible','2','Ya se Ingreso el Archivo  $_POST[nomarchivo]');</script>";}
                                }
                                $itern='saludo1a';
                                $iter2n='saludo2';
                                for ($x=0;$x<count($_POST[nomarchivos]);$x++)
                                {
                                	$rutaarchivo="informacion/proyectos/temp/".$_POST[patharchivos][$x];
                                    echo "
                                    <input type='hidden' name='nomarchivos[]' value='".$_POST[nomarchivos][$x]."'/>
                                    <input type='hidden' name='rutarchivos[]' value='".$_POST[rutarchivos][$x]."'/>
                                    <input type='hidden' name='tamarchivos[]' value='".$_POST[tamarchivos][$x]."'/>
                                    <input type='hidden' name='patharchivos[]' value='".$_POST[patharchivos][$x]."'/>
                                        <tr class='$itern'>
                                            <td>".$_POST[nomarchivos][$x]."</td>
                                            <td>".$_POST[rutarchivos][$x]."</td>
                                            <td>".$_POST[tamarchivos][$x]." Bytes</td>
                                            <td style='text-align:center;width: 30px'><a href='$rutaarchivo' target='_blank' ><img src='imagenes/descargar.png'  title='(Descargar)' ></a></td>
                                        
                                            <td><a href='#' onclick='eliminar3($x)'><img src='imagenes/del.png'></a></td>
                                        </tr>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                                echo "
                                    </table></div>";
                         ?>
              		</div>
                </div>
     	</div>
        
    	    <input type="hidden" name="oculto" id="oculto" value="1">
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
			<input type="hidden" name="sumnivel" id="sumnivel" value="<?php echo $_POST[sumnivel];?>">
            <input type='hidden' name='eliminar' id='eliminar'>
			<input type="hidden" name="auto" id="auto" value="<?php echo $_POST[auto]; ?>">
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

				$linkbd=conectar_bd();
				$sqlr="SELECT max(CAST(consecutivo AS UNSIGNED)) FROM planproyectos";
				$row=mysql_fetch_row(mysql_query($sqlr,$linkbd));
				$consec=$row[0]+1;	
				$rutaprincipal="informacion/proyectos/temp/".$_POST[nomarchadj];
					if($_POST[contador]==0){
						echo "<script>despliegamodalm4('visible','2','Debe especificar alguna meta'); </script>";
					}else{
						$sqlr="INSERT INTO planproyectos (consecutivo,codigo,vigencia,nombre,archivo,estado,valor,descripcion) VALUES ('$consec','$_POST[codigo]','$_POST[vigencia]','$_POST[nombre]','$rutaprincipal','S',$_POST[valorp],'$_POST[descripcion]') ";	
				if (!mysql_query($sqlr,$linkbd))
				{
					
					echo "<script>alert('ERROR EN LA CREACION DEL PROYECTO');document.form2.nombre.focus();</script>";
				 	echo $sqlr;
				}
				else
					{ 
					
							$idauto=$consec;
							echo "<script>document.getElementById('auto').value=$idauto; </script>";
							$_POST[auto]=$idauto;
							if($_POST[onoffswitch]==1){
							for($i=0;$i<count($_POST[dcuentas]); $i++){
							$cuenta=$_POST[dcuentas][$i];
							$valor=$_POST[dgastos][$i];
							$sqlr="INSERT INTO planproyectos_pres(codigo,vigencia,cuenta,valor,estado,fuente) VALUES ('$_POST[codigo]','$_POST[vigencia]','$cuenta',$valor,'C','') ";
							mysql_query($sqlr,$linkbd);
						}
						}else{
						for($i=0;$i<count($_POST[fuentesfinan]); $i++){
							$fuente=$_POST[fuentesfinan][$i];
							$valor=$_POST[dgastos][$i];
							$sqlr="INSERT INTO planproyectos_pres(codigo,vigencia,cuenta,valor,estado,fuente) VALUES ('$_POST[codigo]','$_POST[vigencia]','',$valor,'F','$fuente') ";
							mysql_query($sqlr,$linkbd);
						}
						}
						
						for($i=0;$i<count($_POST[nomarchivos]); $i++){
							$nombre=$_POST[nomarchivos][$i];
							$ruta="informacion/proyectos/temp/".$_POST[rutarchivos][$i];
							$sqlr="INSERT INTO planproyectos_adj(codigo,nombre,vigencia,ruta) VALUES ('$_POST[codigo]','$nombre','$_POST[vigencia]','$ruta') ";
							mysql_query($sqlr,$linkbd);
						}

						for($x=0;$x<$_POST[contador]; $x++){
								
									for ($y=0;$y<count($_POST[niveles]);$y++)
                                {
                                	$meta=$_POST["matmetas$x"][$y];
                                	$codmeta=$_POST[codmetas][$y];
                                	$nommeta=$_POST["matmetasnom$x"][$y];
                                	$sql="INSERT INTO planproyectos_det(codigo,vigencia,cod_meta,cod_param,valor,nombre_valor) VALUES ('$_POST[codigo]','$_POST[vigencia]',$x,'$codmeta','$meta','$nommeta')";
									mysql_query($sql,$linkbd);
									
                                }
							}


						if($_POST[nomarch]!="")
						{
							$dircarga="informacion/proyectos/temp/";
							copy($dircarga.$_POST[nomarch],("informacion/proyectos/".$_POST[nomarch]));
						}
						
						echo "<script>document.getElementById('oculto').value='0';despliegamodalm3('visible',1);</script>";
			        
					
						
					
					}
					}
				
			
					

			}
			//cargararchivos 
			if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
			{
				$rutaad="informacion/proyectos/temp/";
				if(!file_exists($rutaad)){mkdir ($rutaad);}
				else {eliminarDir();mkdir ($rutaad);}
				$nomarchivo=$_FILES['plantillaad']['name'];
				$linkbd=conectar_bd();
				$sqlr="SELECT * FROM planproyectos WHERE archivo='".$nomarchivo."'";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				if($ntr==0)
				{
				?><script>document.getElementById('nomarch').value='<?php echo $_FILES['plantillaad']['name'];?>';document.getElementById('nomarchadj').value='<?php echo $_FILES['plantillaad']['name'];?>';</script><?php 
				copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
				}
				else
				{?><script>despliegamodalm('visible',3,'Ya se ingreso un Archivo con el nombre '+'<?php echo $nomarchivo; ?>');</script><?php }
			}
			if (is_uploaded_file($_FILES['plantillaad1']['tmp_name'])) 
			{
				$rutaad="informacion/proyectos/temp/";
				$nomarchivo=$_FILES['plantillaad1']['name'];
				?><script>document.getElementById('rutarchivo').value='<?php echo $_FILES['plantillaad1']['name'];?>';document.getElementById('tamarchivo').value='<?php echo $_FILES['plantillaad1']['size'];?>';document.getElementById('patharchivo').value='<?php echo $_FILES['plantillaad1']['name'];?>';</script><?php 
				copy($_FILES['plantillaad1']['tmp_name'], $rutaad.$_FILES['plantillaad1']['name']);
				
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