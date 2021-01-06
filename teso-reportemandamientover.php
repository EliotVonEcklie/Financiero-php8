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
        <title>SPID-Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
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
 			{if (document.form2.codrubro.value!=""){document.form2.bcrubro.value='1';document.form2.submit();}}
		function despliegamodal2(_valor,ventana)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
				}
				else {
					if(ventana==1){
						document.getElementById('ventana2').src="coactivo-ventana.php?ti=2";
					}else if(ventana==2){
						document.getElementById('ventana2').src="cdp-reversar-ventana.php";
					}else if(ventana==3){
						document.getElementById('ventana2').src="contra-soladquisicionesproyectos.php";
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
				if (document.form2.numresolucion.value!='' && document.form2.codcatastral.value!='' && document.form2.fechaman.value!='')
			  	{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
			  	}
			  	else
				{
			  		despliegamodalm4('visible','2','Falta informaci\xf3n para poder guardar')
					document.form2.nombre.focus();
					document.form2.nombre.select();
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
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;
					}
				}
			}
			function agregardetallesol()
			{
				if(document.form2.descripcion.value!="" )
				{
					document.form2.agregadets.value=1;
					document.form2.submit()
				}
				else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}
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
			function buscacta(e)
			{
				if (document.form2.numresolucion.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
				}
			}
			function funcionmensaje()
			{
				var numdocar=document.getElementById('codigo').value;
				var vigencar=document.getElementById('codproceso').value;
				var catas=document.getElementById('codcatastral').value;
				document.location.href = "teso-reportemandamientover.php?cod="+numdocar+"&proceso="+vigencar+"&codcatas="+catas;
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
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
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
			function eliminars(variable)
			{
				if (confirm("Esta Seguro de Eliminar "+variable))
				{
					document.form2.eliminars.value=variable;
					vvend=document.getElementById('eliminars');
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function eliminarc(variable)
			{
				if (confirm("Esta Seguro de Eliminar "+variable))
				{
					document.form2.eliminarc.value=variable;
					vvend=document.getElementById('eliminarc');
					vvend.value=variable;
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.form2.oculto.value=2;
						document.form2.submit();
					break;
				}
			}
			function pdf()
			{
				document.form2.action="pdfcitacion3.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
        <?php 
		$linkbd=conectar_bd();
		titlepag();

	        function calcularTamano($ruta){
	        	return filesize($ruta);
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
	
				
				$_POST[codigo]=$_GET[cod];
				$_POST[codproceso]=$_GET[proceso];
				$_POST[codcatastral]=$_GET[codcatas];
				$_POST[codigoco]=$_GET[proceso];

				$sql="SELECT * FROM tesoreportemandamiento WHERE codmandamiento=$_POST[codigo]";
				$res=mysql_query($sql,$linkbd);
				$fila=mysql_fetch_row($res);
				$_POST[fechaman]=$fila[4];

				$sqlr="SELECT SUM(valortotal) FROM tesocobroreporte WHERE codcatastral='$_GET[codcatas]' GROUP BY codcatastral";
 				$res=mysql_query($sqlr,$linkbd);
 				$valor=mysql_fetch_row($res);
 				$_POST[total]=$valor[0];
 				$_POST[totalco]=$valor[0];
 				$_POST[ntotal]=convertir($_POST[total])." PESOS";
				$sql="select numresolucion,codcatastral,fechainicio,fechafin FROM tesoreportecitacion WHERE codproceso=$_POST[codproceso] ";
				$res=mysql_query($sql,$linkbd);
				$fila=mysql_fetch_row($res);
				$_POST[numresolucion]=$fila[0];
				$_POST[fechaini]=$fila[2];
				$_POST[fechafin]=$fila[3];
				$sql="SELECT * FROM tesoreportecitacion_notas WHERE codproceso=$_POST[codproceso] ";
				$res=mysql_query($sql,$linkbd);
				while($row = mysql_fetch_row($res)){

					$_POST[descripcion1][]=$row[2];
					$_POST[cpdigo1][]=$row[1]; 
					$_POST[numresolucion1][]=$row[0];
					$_POST[codcatastral1][]=$_POST[codcatastral];
				}

				$sql="SELECT * FROM tesoreportemandamiento_adj WHERE codproceso=$_POST[codproceso] ";
				//echo $sql;
				$res=mysql_query($sql,$linkbd);
				while($row = mysql_fetch_row($res)){

				$_POST[nomarchivosman][]=$row[4];
                $_POST[rutarchivosman][]=$row[5];
                $_POST[tamarchivosman][]=calcularTamano($row[5]);
                $_POST[patharchivosman][]=$row[5];
				}

				$sql="SELECT * FROM tesoreportecitacion_adj WHERE codproceso=$_POST[codproceso] ";
				//echo $sql;
				$res=mysql_query($sql,$linkbd);
				while($row = mysql_fetch_row($res)){

				$_POST[nomarchivos][]=$row[3];
                $_POST[rutarchivos][]=$row[5];
                $_POST[tamarchivos][]=calcularTamano($row[5]);
                $_POST[patharchivos][]=$row[5];
				}

				
				$sqlr1="select *from tesocobroreporte where tesocobroreporte.numresolucion='$fila[0]' and tesocobroreporte.codcatastral='$fila[1]' ";
				$res1=mysql_query($sqlr1,$linkbd);
				$con=0;
				while ($row1=mysql_fetch_row($res1))
				{
					$_POST[vigencia][$con]=$row1[2];	
					$_POST[predial][$con]=$row1[4];
					$_POST[interesespredial][$con]=$row1[5];
					$_POST[sobretasabombe][$con]=$row1[6];
					$_POST[intsobretasabombe][$con]=$row1[7];
					$_POST[sobretasamb][$con]=$row1[8];
					$_POST[intsobretasamb][$con]=$row1[9];
					$_POST[descuento][$con]=$row1[10];
					$_POST[valortotal][$con]=$row1[12];
					$_POST[diasmora][$con]=$row1[13];
					$con++;
				}
				$_POST[bc]=0;
				$sql="SELECT fecha FROM tesocobroreporte WHERE numresolucion=$_POST[numresolucion] GROUP BY numresolucion";
				$res=mysql_query($sql,$linkbd);
				$fecha=mysql_fetch_row($res);
				$_POST[fecha]=$fecha[0];



	
		
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
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
        	<tr>
  				<td colspan="3" class="cinta"><a href="teso-reportemandamiento.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="teso-buscareportemandamiento.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0"/></a><a href="#" onClick="mypop=window.open('teso-principal.php','',''); mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"> <img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-buscareportemandamiento.php'" class="mgbt"/></td>
			</tr>
     	</table>
 		<form name="form2" method="post" enctype="multipart/form-data" >
		<?php
			//echo "$_POST[eliminarc] jola";
    		$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
  			$linkbd=conectar_bd(); 
 			if($_POST[oculto]=="")
			{
				$fec=date("d/m/Y");
				$_POST[contador]=0;
				$_POST[vigencia1]=$vigusu;
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
			if ($_POST[eliminarc]!='')
			{ 
				$posi=$_POST[eliminarc];
				unset($_POST[cpdigo1][$posi]); 
				unset($_POST[descripcion1][$posi]); 	
				unset($_POST[numresolucion1][$posi]); 	
				unset($_POST[codcatastral1][$posi]);
				$_POST[cpdigo1]= array_values($_POST[cpdigo1]); 
				$_POST[descripcion1]= array_values($_POST[descripcion1]); 
				$_POST[numresolucion1]= array_values($_POST[numresolucion1]); 
				$_POST[codcatastral1]= array_values($_POST[codcatastral1]);
			}
 		?>
        <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Mandamiento de Pago</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="9" >Iniciar Proceso</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
								<td class="saludo1" style="width:7%">Codigo Mandamiento:</td>
                                <td style="width:7%"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:98%" readonly></td>
                                <td class="saludo1" style="width:7%">No. Proceso Coactivo:</td>
                                <td style="width:10%"><input type="text" id="codproceso" name="codproceso" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[codproceso]?>" onClick="document.getElementById('codproceso').focus();document.getElementById('codproceso').select();" style="width:100%;" readonly><input type="hidden" value="" name="bc" id="bc"></td>
                                <td class="saludo1" style="width:7%">Fecha Mandamiento:</td>
                                <td colspan="1" width="7%">
									<input name="fechaman" type="text" id="fechaman" title="DD/MM/YYYY" value="<?php echo $_POST[fechaman]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" >&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fechaman');" class="icobut"/>	  
							   </td>
                                <td class="saludo1" style="width:7%">Codigo Catastral:</td>
                                <td style="width:10%"><input type="text" id="codcatastral" name="codcatastral" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[codcatastral]?>" onClick="document.getElementById('codcatastral').focus();document.getElementById('codcatastral').select();" style="width:100%;" readonly>
                   
                            </tr>
                            <tr>
              
								<td style="width:10%;" class="saludo1">Total a pagar ($)</td>
								<td style="width:10%;">
									<input type="text" id="total" name="total" onKeyPress="javascript:return solonumeros(event)" style="width:98%;" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[total]; ?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
								</td>
								<td colspan="6">
									<input type="text" id="ntotal" name="ntotal" value="<?php echo $_POST[ntotal]; ?>" style="width: 100%" readonly>
								</td>
							
                            </tr>
						
                        </table>
                        <table class="inicio" >
							<tr>
							  <td class="titulos" colspan="14">Detalle Pago          </td>
							</tr>
							<tr>
								<td class="titulos2">Vigencia</td>
								<td class="titulos2">Codigo Catastral</td>
								<td class="titulos2">Predial</td>
								<td class="titulos2">Intereses Predial</td>
								<td class="titulos2">Sobretasa Bomberil</td>
								<td class="titulos2">Intereses Bomberil</td>
								<td class="titulos2">Sobretasa Ambiental</td>
								<td class="titulos2">Intereses Ambiental</td>
								<td class="titulos2">Descuento</td>
								<td class="titulos2">Valor Total</td>
								<td class="titulos2">Dias Mora</td>
							</tr> 
							<?php 
							  $iter='zebra1';
							  $iter2='zebra2';
							 for ($x=0;$x< count($_POST[vigencia]);$x++)
							 {
							 
							 echo "<tr class='$iter'>
								<td><input name='vigencia[]' value='".$_POST[vigencia][$x]."' type='text' style='width:100%;' readonly></td>
								<td><input name='codcatastral[]' value='".$_POST[codcatastral]."'  style='width:100%;' readonly></td>
								<td><input name='predial[]' value='".number_format($_POST[predial][$x],2)."' type='text' style='width:100%;' readonly></td>
								<td><input name='interesespredial[]' value='".number_format($_POST[interesespredial][$x],2)."' type='text' style='width:100%;' readonly></td>
								<td><input name='sobretasabombe[]' value='".number_format($_POST[sobretasabombe][$x],2)."' type='text' style='width:100%;' readonly></td>
								<td><input name='intsobretasabombe[]' value='".number_format($_POST[intsobretasabombe][$x],2)."' type='text' style='width:100%;' readonly></td>
								<td><input name='sobretasamb[]' value='".number_format($_POST[sobretasamb][$x],2)."' type='text' style='width:100%;' readonly></td>
								<td><input name='intsobretasamb[]' value='".number_format($_POST[intsobretasamb][$x],2)."' type='text' style='width:100%;' readonly></td>
								<td><input name='descuento[]' value='".number_format($_POST[descuento][$x],2)."' type='text' style='width:100%;' readonly></td>
								<td><input name='valortotal[]' value='".number_format($_POST[valortotal][$x],2)."' type='text' style='width:100%;' readonly></td>
								<td><input name='diasmora[]' value='".$_POST[diasmora][$x]."' type='text' style='width:100%;' readonly></td>
							</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							 }
							 
							?>
							</tr>
                        </table>
                      
              		</div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Proceso coactivo</label>
                    <div class="content" style="overflow:hidden;" >
                   	 	 <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="9" >Detalle Proceso</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
								<td class="saludo1" style="width:7%">Codigo Proceso:</td>
                                <td style="width:7%"><input type="text" name="codigoco" id="codigoco" value="<?php echo $_POST[codigoco]?>" style="width:98%" readonly></td>
                                <td class="saludo1" style="width:7%">No. Resolucion Persuasivo:</td>
                                <td style="width:10%"><input type="text" id="numresolucion" name="numresolucion" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[numresolucion]?>" onClick="document.getElementById('numresolucion').focus();document.getElementById('numresolucion').select();" style="width:82%;" readonly><input type="hidden" value="" name="bc" id="bc">&nbsp;<img src="imagenes/ojo.png" height="27px" width="50px" /></td>
                                <td class="saludo1" style="width:7%">Vigencia:</td>
                                <td style="width:7%"><input type="text" name="vigencia1" id="vigencia1" value="<?php echo $_POST[vigencia1]?>" style="width:98%" readonly></td>
                                <td class="saludo1" style="width:7%">Codigo Catastral:</td>
                                <td style="width:10%"><input type="text" value="<?php echo $_POST[codcatastral]?>" onClick="document.getElementById('codcatastral').focus();document.getElementById('codcatastral').select();" style="width:100%;" readonly>
                   
                            </tr>
                            <tr>
                                <td style="width:5%;" class="saludo1">Fecha de Resolucion:        </td>
								<td style="width:7%;">
									<input name="fecha" id="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:100%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>     
								</td>
								<td style="width:10%;" class="saludo1">Total a pagar ($)</td>
								<td style="width:10%;">
									<input type="text" id="totalco" name="totalco" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[totalco]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
								</td>
								<td  class="saludo1" style="width:2cm;">Fecha inicio proceso:</td>
								<td colspan="1">
									<input name="fechaini" type="text" id="fechaini" title="DD/MM/YYYY" value="<?php echo $_POST[fechaini]; ?>"   style="width: 98%" readonly>  
							   </td>
								<td style="width:5%;" class="saludo1">Fecha fin proceso:        </td>
								<td colspan="1">
									<input name="fechafin" type="text" id="fechafin" title="DD/MM/YYYY" value="<?php echo $_POST[fechafin]; ?>"   style="width: 100%" readonly>	  
							   </td>
                            </tr>
                        </table>
                        <table class="inicio" width="99%" >
							<tr>
							  <td class="titulos" colspan="14">Detalle Observaciones          </td>
							</tr>
							<tr>
								<td class="titulos2" width="5%">Codigo Proceso</td>
								<td class="titulos2">Descripcion</td>
								<td class="titulos2" width="5%">No Resolucion</td>
								<td class="titulos2" width="15%">Cod Catastral</td>
								
							</tr> 
							<tbody>
							<?php 
							  $iter='zebra1';
							  $iter2='zebra2';
							  //echo "hola".$_POST[codcatastral1][0];
								for ($x=0;$x<count($_POST[cpdigo1]);$x++)
                                {	
                                    echo "
									<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\">
									<td><input class='inpnovisibles' name='cpdigo1[]' value='".$_POST[cpdigo1][$x]."' type='text' readonly style='width:100%'></td>
									<td><input class='inpnovisibles' name='descripcion1[]'  value='".$_POST[descripcion1][$x]."' type='text' style=\"width:100%\" readonly style='width:100%'></td>
									<td><input class='inpnovisibles' name='numresolucion1[]' value='".$_POST[numresolucion1][$x]."' type='text' readonly style='width:100%'></td>
									<td><input class='inpnovisibles' name='codcatastral[]' value='".$_POST[codcatastral1][$x]."' type='text' readonly style='width:100%'></td>
									
								</tr>";	
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
                                }
							 
							?>
							</tbody>
						</table>
						<?php
                        	 echo"
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='5'>Detalle Adjuntos</td>
                                            </tr>
                                            <tr>
                                                <td class='titulos2'>Nombre</td>
                                                <td class='titulos2'>Ruta</td>
                                                <td class='titulos2'>".utf8_decode("Tamaño")."</td>
                                                <td class='titulos2'></td>
                                                
                                            </tr>";
                                	
                                $itern='saludo1a';
                                $iter2n='saludo2';
                                for ($x=0;$x<count($_POST[nomarchivos]);$x++)
                                {
                                	$rutaarchivo=$_POST[patharchivos][$x];
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
                                        
                                        </tr>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                                echo "
                                    </table>";
                         ?>
                    </div>
              	</div>
              	<div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3; ?> >
                    <label for="tab-3">Anexos</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="7" >Otros Anexos</td>
     
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:8%">Anexo:</td>
                                <td style="width:25%" ><input type="text" name="rutarchivo" id="rutarchivo"  style="width:100%;" value="<?php echo $_POST[rutarchivo]?>" readonly> <input type="hidden" name="tamarchivo" id="tamarchivo" value="<?php echo $_POST[tamarchivo] ?>" /><input type="hidden" name="patharchivo" id="patharchivo" value="<?php echo $_POST[patharchivo] ?>" />

                                 </td>
                                    <td style="width:3%">
                                    	<div class='upload'> 
                                        <input type="file" name="plantillaad1" onChange="document.form2.submit();" />
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
                                
                                if ($_POST[agregadet3]=='1')
                                {
                                    $ch=esta_en_array($_POST[nomarchivosman],$_POST[nomarchivo]);
                                    if($ch!='1')
                                    {			 
                                        $_POST[nomarchivosman][]=$_POST[nomarchivo];
                                        $_POST[rutarchivosman][]=$_POST[rutarchivo];
                                        $_POST[tamarchivosman][]=$_POST[tamarchivo];
                                        $_POST[patharchivosman][]="informacion/proyectos/temp/".$_POST[patharchivo];
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
                                for ($x=0;$x<count($_POST[nomarchivosman]);$x++)
                                {
                                	$rutaarchivo=$_POST[patharchivosman][$x];
                                    echo "
                                    <input type='hidden' name='nomarchivosman[]' value='".$_POST[nomarchivosman][$x]."'/>
                                    <input type='hidden' name='rutarchivosman[]' value='".$_POST[rutarchivosman][$x]."'/>
                                    <input type='hidden' name='tamarchivosman[]' value='".$_POST[tamarchivosman][$x]."'/>
                                    <input type='hidden' name='patharchivosman[]' value='".$_POST[patharchivosman][$x]."'/>
                                        <tr class='$itern'>
                                            <td>".$_POST[nomarchivosman][$x]."</td>
                                            <td>".$_POST[rutarchivosman][$x]."</td>
                                            <td>".$_POST[tamarchivosman][$x]." Bytes</td>
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
			<input type='hidden' name="eliminarc" id="eliminarc" >
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
		
			//********guardar
		 	if($_POST[oculto]=="2")
			{
				$sql="DELETE FROM tesoreportemandamiento WHERE codmandamiento=$_POST[codigo]";
				mysql_query($sql,$linkbd);
				$sql="DELETE FROM tesoreportemandamiento_adj WHERE codmandamiento=$_POST[codigo]";
				mysql_query($sql,$linkbd);
				if(strpos($_POST[fechaman],"-")===false){
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaman],$fechafina);
                	$fechaman=$fechafina[3]."-".$fechafina[2]."-".$fechafina[1];	
				}else{
                	$fechaman=$_POST[fechaman];
				}
				
				$linkbd=conectar_bd();
				$sqlr="INSERT INTO tesoreportemandamiento (codmandamiento,codproceso,codcatastral,vigencia,fecha) VALUES ($_POST[codigo],$_POST[codproceso],'$_POST[codcatastral]','$_POST[vigencia1]','$fechaman') ";	
				if (!mysql_query($sqlr,$linkbd))
				{
					echo "<script>alert('ERROR EN LA CREACION DEL MANDAMIENTO DE PAGO');document.form2.nombre.focus();</script>";
				 	echo $sqlr;
				}
				else
					{ 	
						for($i=0;$i<count($_POST[nomarchivosman]); $i++)
						{
							echo "entraaa!!";
							$nombre=$_POST[nomarchivosman][$i];
							$ruta="informacion/proyectos/temp/".$_POST[rutarchivosman][$i];
							$sqlr="INSERT INTO tesoreportemandamiento_adj(codmandamiento,codproceso,codcatastral,nombre,ruta,vigencia) VALUES ('$_POST[codigo]','".$_POST[codproceso]."','$_POST[codcatastral]','$nombre','$ruta','$vigusu') ";
							//echo $sqlr;
							mysql_query($sqlr,$linkbd);
						}
						
						if($_POST[nomarchivo]!="")
						{
							$dircarga="informacion/proyectos/temp/";
							copy($dircarga.$_POST[nomarchivo],("informacion/proyectos/".$_POST[nomarchivo]));
						}
						echo "<script>despliegamodalm4('visible','1','Se actualizo el mandamiento de pago con exito');</script>";
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
				{?><script>despliegamodalm('visible',3,'Ya se ingres\xf3 un Archivo con el nombre '+'<?php echo $nomarchivo; ?>');</script><?php }
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