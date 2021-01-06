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
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gesti&oacute;n Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
        <style>
			.onoffswitch 
			{
    			position: relative; width: 71px;
   				-webkit-user-select:none; 
				-moz-user-select:none; 
				-ms-user-select: none;
			}
			.onoffswitch-checkbox {display: none;}
			.onoffswitch-label 
			{
    			display: block; 
				overflow: hidden; 
				cursor: pointer;
    			border: 2px solid #DDE6E2; 
				border-radius: 20px;
			}
			.onoffswitch-inner 
			{
   				display: block; 
				width: 200%; 
				margin-left: -100%;
    			transition: margin 0.3s ease-in 0s;
			}
			.onoffswitch-inner:before, .onoffswitch-inner:after 
			{
    			display: block; 
				float: left; 
				width: 50%; 
				height: 23px; 
				padding: 0; 
				line-height: 23px;
    			font-size: 14px; 
				color: white; 
				font-family: Trebuchet, Arial, sans-serif; 
				font-weight: bold;
    			box-sizing: border-box;
			}
			.onoffswitch-inner:before 
			{
    			content: "SI";
    			padding-left: 10px;
    			background-color: #51C3E0; 
				color: #FFFFFF;
			}
			.onoffswitch-inner:after 
			{
    			content: "NO";
    			padding-right: 10px;
    			background-color: #EEEEEE; color: #999999;
    			text-align: right;
			}
			.onoffswitch-switch 
			{
    			display: block; 
				width: 17px; 
				margin: 3px;
    			background: #FFFFFF;
    			position: absolute; 
				top: 0; 
				bottom: 0;
    			right: 44px;
    			border: 2px solid #DDE6E2; 
				border-radius: 20px;
    			transition: all 0.3s ease-in 0s; 
			}
			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {margin-left: 0;}
			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {right: 0px;}
		</style>
        <script>
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
				var _idban=document.getElementById('numid').value;
			//	document.location.href = "hum-bancoseditar.php?idban="+_idban;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';
								document.form2.submit();
								break;
				}
			}
			function guardar()
			{
				var validacion01=document.getElementById('codnarl').value;
				var validacion02=document.getElementById('nomacti').value;
				var validacion03=document.getElementById('tararl').value;
				if (validacion01.trim()!='' && validacion02.trim() && validacion03.trim()) 
				{despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
				else {despliegamodalm('visible','2','Falta información realizar la modificacion');}
			}
			function cambiocheck()
			{
				if(document.getElementById('myonoffswitch').value=='S'){document.getElementById('myonoffswitch').value='N';}
				else{document.getElementById('myonoffswitch').value='S';}
				document.form2.submit();
			}
			function validacodigo()
			{
				document.getElementById('validaco').value=1;
				document.form2.submit();
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-nivelesarl.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-nivelesarlbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src="imagenes/iratras.png" title="Men&uacute; Nomina" onClick="location.href='hum-menunomina.php'" class="mgbt"></td>
        	</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
        	<?php 
				if($_POST[oculto]=="")
				{
					$_POST[numid]=$_GET[idnarl];
					$sqlr="SELECT * FROM hum_nivelesarl WHERE id='$_GET[idnarl]'";
					$resp=mysql_query($sqlr,$linkbd);
				    $row=mysql_fetch_row($resp);
					$_POST[codnarl]=$row[1];
					$_POST[nomacti]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[3]);
					$_POST[tararl]=$row[2];
					$_POST[onoffswitch]=$row[4];
					$accion="INGRESO A MIRAR Y EDITAR TARIFAS ARL N° $_POST[numid]";
       			 	$origen=getUserIpAddr();
        			generaLogs($_SESSION["nickusu"],'HUM','V',$accion,$origen);
				}
				if($_POST[validaco]=="1")
				{
					$sqlr="SELECT codigo FROM hum_nivelesarl WHERE codigo='$_POST[codnarl]'";
					$resultado=mysql_query($sqlr,$linkbd) or die (mysql_error());
					if (mysql_num_rows($resultado)>0)
					{
						echo"<script>despliegamodalm('visible','2','Ya existe este código ARL N° $_POST[codnarl]');</script>";
						$_POST[validaco]="0";
						$_POST[codnarl]="";
					} 
				}
			?>
        	<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="4">.: Nivel Tarifa ARL</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
                <tr>
     				<td class="saludo1" style="width:3cm;">C&oacute;digo:</td>
          			<td style="width:10%;"><input type="text" name="codnarl" id="codnarl" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codnarl];?>" style="width:100%" onChange="validacodigo();"/></td>
                    <td class="saludo1" style="width:3cm;">Actividad:</td>
           			<td ><input type="text" name="nomacti" id="nomacti" value="<?php echo $_POST[nomacti];?>" style="width:100%;"/></td>
              	</tr>
                <tr>
                	<td class="saludo1">Tarifa:</td>
                    <td><input type="text" name="tararl" id="tararl" value="<?php echo $_POST[tararl];?>" style="width:100%;"/></td>
                	<td class="saludo1">Estado:</td>
                    <td>
                    	<div class="onoffswitch">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" value="<?php echo $_POST[onoffswitch];?>" <?php if($_POST[onoffswitch]=='S'){echo "checked";}?> onChange="cambiocheck();"/>
                            <label class="onoffswitch-label" for="myonoffswitch">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </td>
                </tr>
          	</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numid" id="numid" value="<?php echo $_POST[numid];?>"/>
            <input type="hidden" name="validaco" id="validaco" value="0"/>
            <?php
				if($_POST[oculto]=="2")
				{ 
					if($_POST[onoffswitch]!='S'){$nestado='N';}
					else {$nestado='S';}
					$sqlr ="UPDATE hum_nivelesarl SET codigo='$_POST[codnarl]',tarifa='$_POST[tararl]',detalle='$_POST[nomacti]',estado='$nestado' WHERE id='$_POST[numid]'"; 
					
					if (!mysql_query($sqlr,$linkbd))
					{
						$e =mysql_error(mysql_query($sqlr,$linkbd));
						echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
					}
  					else 
					{
						echo "<script>despliegamodalm('visible','3','Se modifico con Exito el nivel de ARL');</script>";
						$accion="SE MODIFICO LA TARIFAS ARL N° $_POST[numid]: $sqlr";
       			 		$origen=getUserIpAddr();
        				generaLogs($_SESSION["nickusu"],'HUM','M',$accion,$origen);
					}
				}
			?>
		</form>
        <div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
    </body>
</html>