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
		<!-- ETIQUETA QUE SIRVE PARA PONER ACENTOS A LAS PALABRAS, PARA NO USAR CARACTERES ESPECIALES ::RECICLAR CÓDIGO:: <meta charset="UTF-8"> -->
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
			
		.c1 input[type="checkbox"]:not(:checked),
		.c1 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c1 input[type="checkbox"]:not(:checked) +  #t1,
		.c1 input[type="checkbox"]:checked +  #t1 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:before,
		.c1 input[type="checkbox"]:checked +  #t1:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:after,
		.c1 input[type="checkbox"]:checked + #t1:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c1 input[type="checkbox"]:checked +  #t1:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c1 input[type="checkbox"]:disabled:not(:checked) +  #t1:before,
		.c1 input[type="checkbox"]:disabled:checked +  #t1:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c1 input[type="checkbox"]:disabled:checked +  #t1:after {
		  color: #999 !important;
		}
		.c1 input[type="checkbox"]:disabled +  #t1 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c1 input[type="checkbox"]:checked:focus + #t1:before,
		.c1 input[type="checkbox"]:not(:checked):focus + #t1:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c1 #t1:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t1{
			background-color: white !important;
		}
		
		
		
		
		
		.c2 input[type="checkbox"]:not(:checked),
		.c2 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c2 input[type="checkbox"]:not(:checked) +  #t2,
		.c2 input[type="checkbox"]:checked +  #t2 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c2 input[type="checkbox"]:not(:checked) +  #t2:before,
		.c2 input[type="checkbox"]:checked +  #t2:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c2 input[type="checkbox"]:not(:checked) +  #t2:after,
		.c2 input[type="checkbox"]:checked + #t2:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c2 input[type="checkbox"]:not(:checked) +  #t2:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c2 input[type="checkbox"]:checked +  #t2:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c2 input[type="checkbox"]:disabled:not(:checked) +  #t2:before,
		.c2 input[type="checkbox"]:disabled:checked +  #t2:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c2 input[type="checkbox"]:disabled:checked +  #t2:after {
		  color: #999 !important;
		}
		.c2 input[type="checkbox"]:disabled +  #t2 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c2 input[type="checkbox"]:checked:focus + #t2:before,
		.c2 input[type="checkbox"]:not(:checked):focus + #t2:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c2 #t2:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t2{
			background-color: white !important;
		}
		</style>
		<script>
		jQuery(function($){ $('#valacti').autoNumeric('init');});
		jQuery(function($){ $('#aporconv').autoNumeric('init');});
		jQuery(function($){ $('#apormuni').autoNumeric('init');});
		function compruebabanco(verifica){
			var bloqueo = document.form2.bloqueartodo.value;
			
			if(bloqueo!="1"){
				if(verifica.checked){
				document.getElementById("contadorcert").value=parseInt(document.getElementById("contadorcert").value)+1;
				}else{
					document.getElementById("contadorcert").value=parseInt(document.getElementById("contadorcert").value)-1;
				}
				
			}
			document.form2.submit();
		}
		
		function aprobartodobanco(vari){
			var opciones=document.getElementById("contadorsol").value;
			if(vari.checked){
				document.getElementById("contadorcert").value=opciones;
				for(var i=0;i<opciones;i++){
					document.getElementById("aceptab["+i+"]").checked=true;
				}
			}else{
				document.getElementById("contadorcert").value=0;
				for(var i=0;i<opciones;i++){
					document.getElementById("aceptab["+i+"]").checked=false;
				}
			
			}
			document.form2.submit();
		}
		
		 function validafinalizar(e){
		 var id=e.id;
		 var check=e.checked;
		 var cantidad=document.getElementById("contadorcert").value;
		 var aporteMunicipio = document.form2.aporconvu.value;
		 var aporteConvenio = document.form2.apormuniu.value;
		 var valorTotalProyecto = document.form2.valorproyectosinformato.value;
		 var totalAporte = aporteMunicipio + aporteConvenio;
				
		if(id=='finaliza'){
			 if(cantidad==0){
				 despliegamodalm4('visible','6','Debe certificar por lo menos una meta');
				 document.form2.finaliza.checked=false;
			 }else if(totalAporte > valorTotalProyecto){
				 despliegamodalm4('visible','6','El total de aportes debe ser menor que el valor del proyecto');
				 document.form2.finaliza.checked=false;
			 }
			 else{
				 
				if(check){
					 document.getElementById("bloqueartodo").value = "1";
				 }else{
					 document.getElementById("bloqueartodo").value = "0";
				 }
				 document.form2.submit();
			 }
			 
		 }else{
			 document.form2.finaliza.checked=false;
			 document.form2.submit();
		 } 
		
		 //
	
	 }
	 
		function pdfsolicitudbanco(){
			 	document.form2.action="pdfbancoproyecto.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
			 }
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
						case "6":
							document.getElementById('ventana2').src="contra-productos-ventana.php";break;
						case "7":
							document.getElementById('ventana2').src="contra-planproyectos.php";break;
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

				var aporteMunicipio = document.form2.aporconvu.value;
				var aporteConvenio = document.form2.apormuniu.value;
				var valorTotalProyecto = document.form2.valorproyectosinformato.value;
				var totalAporte = parseFloat(aporteMunicipio) + parseFloat(aporteConvenio);
				console.log("totalAporte: ",totalAporte, "Total proyecto: ",valorTotalProyecto);
				if(totalAporte <= valorTotalProyecto){
					if (document.form2.fecha.value!='' && document.form2.codproyecto.value!='' && document.form2.contador.value>0)
					{
						despliegamodalm4('visible','4','Esta Seguro de Guardar');
					}
					else
					{
						despliegamodalm4('visible','2','Falta informacion para poder guardar');

					}
				}else{
					despliegamodalm4('visible','2','El total de aportes debe ser menor que el valor del proyecto');
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
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guardo El Proyecto \""+coding+"\" con Exito";break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp=1";break;
						case "5":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();
								break;
								
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
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Ya se ingreso el codigo \""+coding+"\" de la vigencia "+vigen;break;
						case 3:
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos=Ya se ingreso un Archivo con el nombre \""+_nomb+"\"";break;
					}
						
				}
			}
			
			function funcionmensaje()
			{
				document.location.href = "plan-editarexpedirbppim.php?id="+document.getElementById('solproyecod').value;
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
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guardo con Exito";break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp=1";break;
						case "5":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "6":
							document.getElementById('ventanam').src="ventana-mensaje7.php?titulos="+mensa;break;							
					}
				}
			}
			
			function recargarPagina(){
				
				document.form2.submit();
				
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
				document.form2.submit();
			}
			function generabppim(){
				document.form2.action="pdfcertificabanco.php";
				document.form2.target="_blank";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function buscaproyectos(){
				document.form2.bcproyectos.value="1";
				document.form2.submit();
			}
			function direcciona(){
				var nombre=document.form2.nomarchadj.value;
				window.location.href='informacion/proyectos/temp/'+nombre ;
			}
		</script>
        <?php 
        function calcularTamano($ruta){
        	return filesize($ruta);
        }
		function limpiarnum($numero){
				$acum="";
				if(strpos($numero,"$")===false){
					return $numero;
				}else{
					for($i=0;$i<strlen($numero);$i++ ){
					if(!($numero[$i]=='$' || $numero[$i]=='.')){
						$acum.=$numero[$i];
					}
				}
					$pos=strpos($acum,",");
					return substr($acum,0,$pos);
				}
				
		}
			titlepag();
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
  				<td colspan="3" class="cinta"><a href="plan-expedirbppim.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="plan-buscarexpedirbppim.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0"/></a><a href="#" onClick="mypop=window.open('plan-principal.php','',''); mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
     	</table>
 		<form name="form2" method="post" enctype="multipart/form-data" >
		<?php
		
    		$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
  			$linkbd=conectar_bd();
			
			if($_POST[oculto]=="" || $_POST[bcproyectos]=="1")
			{
				$_POST[fecha]=date("d/m/Y");
				unset($_POST[nomarchivos]);
				unset($_POST[rutarchivos]);
				unset($_POST[tamarchivos]);
				unset($_POST[patharchivos]);
				if($_POST[tipo]==1){
					$sql="SELECT codproyecto FROM contrasolicitudproyecto WHERE codigo='$_POST[solproyecod]' ";
					$res=mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					$_POST[codproyecto]=$row[0];
					$codigo=$_POST[codproyecto];
				}else{
					$codigo=$_POST[codproyecto];
				}
				$sql="SELECT * FROM planproyectos WHERE codigo='$codigo' ";
				$result=mysql_query($sql,$linkbd);
				$row = mysql_fetch_row($result);
				$_POST[nproyecto]=$row[3];
				$_POST[nomarchadj]=basename($row[4]);
				$_POST[nomarch]=basename($row[4]);
				$_POST[valorproyecto]=$row[6];
				$_POST[valorproyectosinformato] = $row[6];
				$_POST[descripcion]=$row[7];
				$_POST[contador]=0;
				$_POST[vigencia]=$vigusu;
	
				$_POST[onoffswitch]=1;	
				$_POST[tabgroup1]=1;
				
				$sql="SELECT MAX(contrasolicitudproyecto_det.cod_meta) FROM contrasolicitudproyecto_det,contrasolicitudproyecto WHERE contrasolicitudproyecto_det.codigosol=contrasolicitudproyecto.codsolicitud AND contrasolicitudproyecto.codigo=$_POST[solproyecod] ";
				$result=mysql_query($sql,$linkbd);
				$rowc = mysql_fetch_row($result);
				if(is_null($rowc[0])){
					$_POST[contadorsol]=0;
				}else{
					$_POST[contadorsol]=$rowc[0]+1;
				}
			
				$sql="SELECT contrasolicitudpaa.valtotalsol FROM contrasolicitudpaa,contrasolicitudproyecto WHERE contrasolicitudpaa.codsolicitud=contrasolicitudproyecto.codsolicitud AND contrasolicitudproyecto.codigo=$_POST[solproyecod] ";
				$res=mysql_query($sql,$linkbd);
				$row = mysql_fetch_row($res);
				$_POST[valactiu]=$row[0];
				$_POST[valacti]=$row[0];
				$sql="SELECT MAX(cod_meta) FROM planproyectos_det WHERE codigo='$codigo' ";
				$result=mysql_query($sql,$linkbd);
				$rowc = mysql_fetch_row($result);
				if(!empty($codigo)){
					$_POST[contador]=$rowc[0]+1;
				}
				
	
				for($j=0;$j<$_POST[contador]; $j++){
					unset($_POST["matmetas$j"]);
					unset($_POST["matmetasnom$j"]);
                 }

				//----
				$sql="SELECT valor,nombre_valor,cod_meta FROM planproyectos_det WHERE codigo='$codigo' ORDER BY LENGTH(valor),cod_meta ASC";
					$result=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_row($result)){
						$j=$row[2];
						$_POST["matmetas$j"][]=$row[0];
						$_POST["matmetasnom$j"][]=$row[1];
					}
					
				$sql="SELECT contrasolicitudproyecto_det.valor,contrasolicitudproyecto_det.nombre_valor,contrasolicitudproyecto_det.cod_meta FROM contrasolicitudproyecto_det,contrasolicitudproyecto WHERE contrasolicitudproyecto_det.codigosol=contrasolicitudproyecto.codsolicitud AND contrasolicitudproyecto.codigo=$_POST[solproyecod] ORDER BY LENGTH(contrasolicitudproyecto_det.valor),contrasolicitudproyecto_det.cod_meta ASC";
					$result=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_row($result)){
						//AQUI VAN LAS METAS SOLICITADAS
					}
                 //-----
                $sql="SELECT * FROM planproyectos_adj WHERE codigo='$codigo' ";
               	$result=mysql_query($sql,$linkbd);
               	while($row = mysql_fetch_row($result)){
               		$_POST[nomarchivos][]=$row[2];
                    $_POST[rutarchivos][]=basename($row[4]);
                    $_POST[tamarchivos][]=filesize($row[4]);
                    $_POST[patharchivos][]=basename($row[4]);
               	}
            $_POST[bcproyectos]="";
               	
			}
			if($_POST[oculto]==""){
				$_POST[contadorcert]=0;
				$_POST[aporconv]=0;
				$_POST[aporconvu]=0;
				$_POST[apormuni]=0;
				$_POST[apormuniu]=0;
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
		<?php
		function existeSolicitudMeta($proyecto,$meta){
			global $linkbd;
			$sql="SELECT 1 FROM contrasolicitudproyecto,contrasolicitudproyecto_det where contrasolicitudproyecto.codigo='$proyecto' AND  contrasolicitudproyecto_det.valor='$meta' AND contrasolicitudproyecto.codsolicitud=contrasolicitudproyecto_det.codigosol";
			$res=mysql_query($sql,$linkbd);
			$num=mysql_num_rows($res);
			return $num;
		}
		?>
        <div class="tabsmeci"  style="height:78.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Proyecto</label>
                    <div class="content" style="overflow:hidden;">
					<table class="inicio">
						<tr>
							<td class="titulos" style="width:100%;">.: Tipo
								<select name="tipo" id="tipo" onKeyUp="return tabular(event,this)" onChange="cargarproyecto()" style="width:20%;" >
									<option value='1' <?php if($_POST[tipo]==1){ echo SELECTED; }?>>Solicitud de Compra</option>
									<option value='2' <?php if($_POST[tipo]==2){ echo SELECTED; }?>>Manual</option>
								</select>
							</td>
							<td style="width:80%;">
							</td>
						</tr>
					</table>
					<table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="8">Certificar BPPIM</td>
                                
                            </tr>
							<tr>
							
                                <td class="saludo1" style="width:5%">Fecha:</td>
                                <td width="6%"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" style="width: 80%">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/></td>
								<td class="saludo1" style="width:5%">Solicitud:</td>
                                <td colspan="4" width="50%">
									<select name="solproyecod" id="solproyecod" onChange="cargarproyecto(this)" style="width: 90%" <?php if($_POST[tipo]==2){?> disabled <?php }else{}?>>
										<option value='' >Seleccione...</option>
										<?php
										$sql="SELECT csp.codigo,csp.codsolicitud,csp.codproyecto,csp.descripcion from contrasolicitudproyecto csp,contrasoladquisiciones cs WHERE csp.estado='A' AND csp.vigencia='$vigusu' AND csp.codsolicitud=cs.codsolicitud";
										$res=mysql_query($sql,$linkbd);
										while($row = mysql_fetch_row($res)){
											
											if($_POST[solproyecod]==$row[0]){
												echo "<option value='$row[0]' SELECTED>$row[1] - ".substr($row[3],0,90)."...</option>";
												$_POST[codigo]=$row[2];
												$_POST[codsol]=$row[1];
											}else{
												echo "<option value='$row[0]' >$row[1] - ".substr($row[3],0,90)."...</option>";
											}
											
										}
										echo "<input type='hidden' name='codsol' id='codsol' value='$_POST[codsol]' />";
										?>
									</select>

									<span style="text-decoration: underline; cursor:pointer"><b><a <?php if(!empty($_POST[codsol])){echo "href='informacion/proyectos/temp/solicitudbanco$_POST[codsol].pdf' target='_blank' ";}  ?> >VER</a></b></span>
								</td>
								<td rowspan="2" width="10%" style="border: 1px dashed gray">
									<div style="display:inline-block;"><label style="background-color: white !important">Liberar:</label></div>
									<div class="c1" style="display:inline-block"><input type="checkbox" id="finaliza" name="finaliza"  onChange="validafinalizar(this)" <?php if(isset($_POST['finaliza'])){echo "checked";} ?> value="<?php echo $_POST[finaliza]?>"/><label for="finaliza" id="t1" ></label></div>
								</td>
                                
                            </tr>
							<tr>
                                <td class="saludo1" style="width:5%">Valor Solicitado:</td>
                                <td style="width:6%">
								<input type="hidden" name="valactiu" id="valactiu" value="<?php echo $_POST[valactiu]; ?>"/>
								<input type="text" name="valacti" id="valacti" value="<?php echo $_POST[valacti]; ?>" style="width:100%;text-align:right;" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min="0" onKeyUp="sinpuntitos('valactiu','valacti');" readonly/>
								
								</td>
								<td class="saludo1" style="width:5%">Aporte Convenio:</td>
                                <td style="width:10%">
								<input type="hidden" name="aporconvu" id="aporconvu" value="<?php if(!isset($_POST[aporconvu])) {$_POST[aporconvu] = 0;} echo $_POST[aporconvu]; ?>"/>
								<input type="text" name="aporconv" id="aporconv" value="<?php echo $_POST[aporconv]; ?>" style="width:100%;text-align:right;" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min="0" onKeyUp="sinpuntitos('aporconvu','aporconv');" <?php if($_POST[bloqueartodo]=="1" && isset($_POST[bloqueartodo])) echo "readonly"; else echo ""; ?>/>
								</td>
								<td class="saludo1" style="width:5%">Aporte Municipio:</td>
                                <td style="width:10%">
								<input type="hidden" name="apormuniu" id="apormuniu" value="<?php if(!isset($_POST[apormuniu])) {$_POST[apormuniu] = 0;} echo $_POST[apormuniu]; ?>"/>
								<input type="text" name="apormuni" id="apormuni" value="<?php echo $_POST[apormuni]; ?>" style="width:100%;text-align:right;" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min="0" onKeyUp="sinpuntitos('apormuniu','apormuni');" <?php if($_POST[bloqueartodo]=="1" && isset($_POST[bloqueartodo])) echo "readonly"; else echo ""; ?>/>
								</td>
                                
                            </tr>
							<tr>
								<td class="saludo1" style="width:5%">Observaciones:</td>
								<td colspan="6"><input name="observa" type="text" id="observa"  value="<?php echo $_POST[observa]; ?>" style="width: 100%;text-align:left;height: 40px" <?php if($_POST[bloqueartodo]=="1" && isset($_POST[bloqueartodo])) echo "readonly"; else echo ""; ?>></td>
							</tr>
					</table>
					<table class="inicio" >
						<tr>
							<td class="titulos" colspan="10" >Asignacion de Proyecto</td>
						</tr>
						<?php if($_POST[tipo]==2){?>
						<tr>
							<td class="saludo1" style="width:7%">Codigo: </td>
							<input type="hidden" name="conproyec" id="conproyec" value="<?php echo $_POST[conproyec]; ?>"/>
							<td style="width:20%">
								<input type="text" name="codproyecto" id="codproyecto" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="document.form2.submit()" value="<?php echo $_POST[codproyecto]?>" onClick="document.getElementById('codproyecto').focus();document.getElementById('codproyecto').select();" style="width:85%" >
								<a href="#" onClick="despliegamodal2('visible','7');"><img src='imagenes/find02.png' style='width:20px;cursor:pointer;'/></a>
							</td>
							<td class="saludo1" style="width:7%">Vigencia:</td>
							<td style="width:7%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:98%" ></td>
							<td class="saludo1" style="width:8%">Archivo Adjunto:</td>
							<td style="width:42.5%" colspan="4"><input type="text" name="nomarchadj" id="nomarchadj"  style="width:95%;text-align: right;" value="<?php echo $_POST[nomarchadj]?>" readonly><img <?php if(!empty($_POST[nomarchadj])){echo "src='imagenes/descargar.png' onClick='redireccion()' ";  }else{echo "src='imagenes/descargard.png' ";}; ?> title="Descargar" style="cursor:pointer !important"/></td>
							<td rowspan="3" width="10%" style="background-image: url('imagenes/proyecto.png'); background-repeat: no-repeat; background-position:center center;background-size: 75px 75px">
							</td>
						</tr>
						<?php }else{?>
						<tr>
							<td class="saludo1" style="width:7%">Codigo: </td>
							<input type="hidden" name="conproyec" id="conproyec" value="<?php echo $_POST[conproyec]; ?>"/>
							<td style="width:20%"><input type="text" name="codproyecto" id="codproyecto" readonly value="<?php echo $_POST[codproyecto]?>" style="width:92%" onKeyUp="return tabular(event,this)" onBlur="buscaproyectos()" onClick="document.getElementById('codproyecto').focus(); document.getElementById('codproyecto').select();" ><a href='#'></a></td>
							<td class="saludo1" style="width:7%">Vigencia:</td>
							<td style="width:7%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:98%" readonly></td>
							<td class="saludo1" style="width:8%">Archivo Adjunto:</td>
							<td style="width:42.5%" colspan="4"><input type="text" name="nomarchadj" id="nomarchadj"  style="width:95%;text-align: right;" value="<?php echo $_POST[nomarchadj]?>" readonly><img <?php if(!empty($_POST[nomarchadj])){echo "src='imagenes/descargar.png' onClick='redireccion()' ";  }else{echo "src='imagenes/descargard.png' ";}; ?> title="Descargar" style="cursor:pointer !important"/></td>
							<td rowspan="3" width="10%" style="background-image: url('imagenes/proyecto.png'); background-repeat: no-repeat; background-position:center center;background-size: 75px 75px">
							</td>
						</tr>
						<?php }?>
						<tr>
							<td class="saludo1">Nombre:</td>
							<td colspan="3">
								<input type="text" name="nproyecto" id="nproyecto" value="<?php echo $_POST[nproyecto]?>" style="width:100%;text-transform: uppercase;" readonly> 
							</td>
							<td class="saludo1">Valor del proyecto:</td>
							<td>
								<script>jQuery(function($){ $('#valorproyecto').autoNumeric('init');});</script>
								<input type="hidden" name="valorp" id="valorp" value="<?php echo $_POST[valorp]?>"   />
								<input type="hidden" name="valorproyectosinformato" id="valorproyectosinformato" value="<?php echo $_POST[valorproyectosinformato]?>"   />
								<input type="text" id="valorproyecto" name="valorproyecto"  value="<?php echo $_POST[valorproyecto]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valorp','valorproyecto');return tabular(event,this);" onBlur="validarcdp();" style="width:100%; text-align:right;" autocomplete="off" readonly>
								<input type="hidden" name="saldo" id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" >
							</td>
						</tr>
						<tr>
							<td class="saludo1">Descripci&oacute;n:</td>
							<td colspan="5">
								<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;text-transform: uppercase;" readonly> 
							</td>
						</tr>
						<tr><td colspan="4"></td><td colspan="4" rowspan="2" valign="middle"></td></tr>
					</table>
                        <?php
					
							// margen azul 
                        	 $conta=0;
							 $suma=0;
                        	 $sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' AND nombre!='INDICADORES' ORDER BY orden";
                          	 $resn=mysql_query($sqln,$linkbd); // conexion
							 $suma=mysql_num_rows($resn)+2; // variable creada guarda 
							 $_POST[niveles]=$suma-2;
							 echo"
							 
                                <div class='subpantalla' style='height:50%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='".($_POST[niveles]+1)."'>Detalle Metas</td>
                                            </tr>
                                            <tr>";
                                
                                $n=0; $j=0;
								echo "<td class='titulos2'><input type='checkbox' name='todosb' id='todosb' style= 'height:10px !important' onChange='aprobartodobanco(this)' $todos/>APROBAR</td>";
                                while($wres=mysql_fetch_array($resn))
                                {
                                    if (strcmp($wres[0],'INDICADORES')!=0)
                                    {
                         				$conta++;
                                        echo "<td class='titulos2' style='width: 18% !important'>".strtoupper($wres[0])."</td>";
                                        	
                                    }
                                }
								
								
                              		  echo "</tr>";
                                $itern='saludo1a';
                                $iter2n='saludo2';
								for($x=0;$x<$_POST[contador]; $x++){
								
									if(existeSolicitudMeta($_POST[solproyecod],$_POST["matmetas$x"][$conta-1])>0 ){
									
										$estilo="style='background-color: yellow !important' ";
										$disabled="";
									}else{
										$disabled="DISABLED";
										$estilo="";
									}
									
									echo "<tr class='$itern' $estilo>";
									
									if(isset($_POST[aceptab][$x]) ||  $_POST[bloqueartodo]=="1"){
										$check="CHECKED";
									}else{
										$check="";
									}
									
									for ($y=0;$y<$conta;$y++)
									{
		
										if($y==0){
												echo "<td><input type='checkbox' name='aceptab[$x]' id='aceptab[$x]'  onChange='compruebabanco(this)' $check $disabled /></td>";
											}
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
                              
								echo "</tr>";
								}
                                
                                echo "
                                    </table></div>";
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
                                    	
                                    </td>
            					<td></td>
                                <td></td>
                                <td></td>
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
			<input type="hidden" name="banderin1" id="banderin1" value="<?php echo $_POST[banderin1];?>" >
			<input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador];?>" >
			<input type="hidden" name="contadorsol" id="contadorsol" value="<?php echo $_POST[contadorsol];?>" >
			<input type="hidden" name="contadorcert" id="contadorcert" value="<?php echo $_POST[contadorcert];?>" >
			<input type="hidden" name="niveles" id="niveles" value="<?php echo $_POST[niveles];?>" >
			<input type="hidden" name="buscameta" id="buscameta" value="<?php echo $_POST[buscameta];?>">
			<input type="hidden" name="bloqueartodo" id="bloqueartodo" value = "<?php echo $_POST[bloqueartodo];?>"  >
			
 		<?php  
			//********guardar
		 	if($_POST[oculto]=="2")
			{
				$aceptar=$_POST[finaliza];
				//$rechazar=$_POST[finaliza2];
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fecha=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				
				$sql="SELECT codsolicitud FROM contrasolicitudproyecto WHERE codigo='$_POST[solproyecod]' ";
				$res=mysql_query($sql,$linkbd);
				$row = mysql_fetch_row($res);
				$soli=$row[0];
				$aporconvenio=limpiarnum($_POST[aporconvu]);
				$apormunicipio=limpiarnum($_POST[apormuniu]);
				$valoracti=limpiarnum($_POST[valactiu]);
				$metascert="";
				for($x=0;$x<$_POST[contadorsol]; $x++){
						
						if($_POST[aceptab][$x]){
							$meta=$_POST["matmetas$x"][$_POST[niveles]-1];
							$metascert.=($meta."-");
							
						  }
					}
				$metascert=substr($metascert,0,-1);
				$sql="UPDATE contrasolicitudproyecto SET fecha_certi='$fecha', val_actividad=$valoracti,apor_convenio=$aporconvenio,apor_municipio=$apormunicipio,observaciones='$_POST[observa]',codproyecto='$_POST[codproyecto]',metascert='$metascert' WHERE codigo=$_POST[solproyecod]";
				mysql_query($sql,$linkbd);				
				$sql="UPDATE contrasoladquisicionesgastos SET codproyecto='$_POST[codproyecto]' WHERE codsolicitud='$soli'  ";
				mysql_query($sql,$linkbd);
				$sql="UPDATE contrasolicitudcdp_det SET conproyecto='$_POST[codproyecto]' WHERE proceso='$soli'  ";
				mysql_query($sql,$linkbd);
				if(isset($aceptar)){
					
					$sql="UPDATE contrasolicitudproyecto SET estado='CE' WHERE codigo=$_POST[solproyecod]";
					mysql_query($sql,$linkbd);
					
					$sql="UPDATE planproyectos SET estado='A' WHERE codigo='$_POST[codproyecto]'  ";
					mysql_query($sql,$linkbd);
				}else{
					$sql="UPDATE contrasolicitudproyecto SET estado='A' WHERE codigo=$_POST[solproyecod]";
					mysql_query($sql,$linkbd);
					
					$sql="UPDATE planproyectos SET estado='S' WHERE codigo='$_POST[codproyecto]'  ";
					mysql_query($sql,$linkbd);
				}
				
				
				echo "<script>despliegamodalm4('visible','5','Certificado Generado con Exito');</script>";
					

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