<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
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
		<title>:: Spid - Contratacion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			jQuery(function($){ $('#vlrestimadovl').autoNumeric('init');});
			jQuery(function($){ $('#vlrestimadoactvl').autoNumeric('init');});
			
			function comprueba(codigo,verifica){
			var codigosol=document.getElementsByName("dcodigosol[]");
			if(verifica.checked){
				document.getElementById("contadorcert").value=parseInt(document.getElementById("contadorcert").value)+1;
			 for(var i=0;i<codigosol.length; i++){
				if(codigosol.item(i).value==codigo){
						document.getElementById(i).style.backgroundColor = "yellow";
					}
				}	
			}else{
				document.getElementById("contadorcert").value=parseInt(document.getElementById("contadorcert").value)-1;
				for(var i=0;i<codigosol.length; i++){
				if(codigosol.item(i).value==codigo){
						document.getElementById(i).style.backgroundColor = "white";
					}
				}
			}
			}

			
			function versolicitud(){
				var solicitud=document.getElementById("solproyecod").value;
				if(solicitud!=''){
					window.open('informacion/proyectos/temp/solicitudpaa'+solicitud+'.pdf','_blank');
				}else{
					despliegamodalm('visible','2','No se ha seleccionado solicitud');
				}
				 
			}
			function cargarproyecto(){
				document.form2.submit();
			}
			 function validafinalizar(e){
				 var id=e.id;
				 var check=e.checked;
				 var opciones=document.getElementById("contador").value;
				 var contcer=document.getElementById("contadorcert").value
				if(id=='finaliza'){
					if(contcer==0){
						despliegamodalm('visible','2','Debe certificar algun producto');
						document.form2.finaliza.checked=false;
					}else{
						document.form2.finaliza2.checked=false;
					} 
				 }else{
					 document.form2.finaliza.checked=false;
					 document.form2.todos.checked=false;
					for(var i=0;i<opciones;i++){
					document.getElementById("acepta["+i+"]").checked=false;
					}
	
				 } 
				
				 
				 //document.form2.submit();
			 }
			function validarimport(formulario)
				{
					document.form2.import.value=1;
					document.form2.action="contra-plancompras.php";
					document.form2.submit();
				}
			function protocoloimport()
				{
					document.form2.action="plan-compras-import.php";
					document.form2.target="_BLANK";
					document.form2.submit(); 
					document.form2.action="";
					document.form2.target="";
				}
			function agregardetalle()
			{
				if(document.form2.cuenta.value!="" && document.form2.ncuenta.value!="" )
				{
					document.form2.agregadet.value="1";
					document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)+1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion del Producto para poder Agregar');}
			}
			function agregaradqui()
			{ 
				var validacion01=document.getElementById('descripcion').value;
				var validacion02=document.getElementById('duracion1').value;
				var validacion03=document.getElementById('vlrestimado').value;
				var validacion04=document.getElementById('vlrestimadoact').value;
				var validacion05=document.getElementById('duracion2').value;
				if((document.form2.fecha.value!="")&&(document.form2.fecha2.value!="")&&((validacion02.trim()!='' || validacion02!=0) || (validacion05.trim()!='' || validacion05!=0))&&(document.form2.modalidad.value!="")&&(validacion01.trim()!='')&&(document.form2.fuente.value!="")&&(validacion03.trim()!='')&&(validacion04.trim()!='')&&(document.form2.requierev.value!="")&&(document.form2.estadorequierev.value!="")&&(document.getElementById('banderin2').value!=0))
				{
					document.form2.agregadetadq.value=1;
					document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)+1;
					document.getElementById('banderin2').value=0;
					document.getElementById('limpiar').value="1";
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion de la Adquisición para poder Agregar');}
			}
			function eliminarlist(variable)
			{
				document.form2.eliminarlista.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar esta Adquisición','2');
			}
			function eliminard(variable)
			{
				document.form2.eliminar.value=variable;
				despliegamodalm('visible','4','Esta seguro de eliminar el Producto de la lista','3');
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}
			}
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
							var tipo=document.getElementById('tipocuenta').value;
							document.getElementById('ventana2').src="contra-soladquisicionescuentasppto.php?ti=2&ti2="+tipo;break;
						case "5":
							document.getElementById('ventana2').src="contra-soladquisicionesproyectos.php";break;
					}
				}
			}
			function buscadquisicion(data){
				var div = data.split("|");
				var cod = "";
				if(document.form2.codigos.value!=""){
					cod = document.form2.codigos.value+'-';
				}
				var cont = div[0].split("-").length;
				if(document.form2.cnat.value!=""){
					document.form2.cnat.value = document.form2.cnat.value+'-'+cont;
				}else{
					document.form2.cnat.value = cont;
				}
				document.form2.codigos.value = cod+div[0];
				cod = "";
				if(div[1]!=""){
					cod = div[1]+'-';
				}
				document.form2.codadquisicion.value = cod+document.form2.codadquisicion.value;
				document.form2.submit();
			}
			function guardar()
			{
						var fecha=document.form2.fecha.value;
						var tipo = document.form2.tipo.value;
						if (tipo == 1) {
							var sol=document.form2.solproyec.value;
						}else{
							var sol=document.form2.codigos.value;
						}
						var descrip=document.form2.observacion.value;
						var corregir=document.form2.finaliza2;
						var aceptar=document.form2.finaliza;
						var opciones=document.getElementById("contador").value;
						var pasa=false;
						if(corregir.checked){
							if(fecha!='' && sol!='' && descrip!=''){
							despliegamodalm('visible','4','Esta Seguro de Guardar','1');
						}else{
							despliegamodalm('visible','2','Faltan datos para completar el registro');
						}
						}else if(aceptar.checked){
							for(var i=0;i<opciones;i++){
								if(document.getElementById("acepta["+i+"]").checked){
									pasa=true;
									break;
								}
							}
							if(pasa){
								if(fecha!='' && sol!='' ){
								despliegamodalm('visible','4','Esta Seguro de Guardar','1');
								}else{
									despliegamodalm('visible','2','Faltan datos para completar el registro');
								}
							}else{
								despliegamodalm('visible','2','Debe por lo menos certificar un producto');
							}
							
							}else{
								despliegamodalm('visible','2','Debe aceptar o corregir esta solicitud');
							}	
			
			}
			function pdf()
			{
				document.form2.action="pdfcertificadopaa.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf2()
			{
				document.form2.action="contra-plancompraspdf2.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
			function funcionmensaje(){document.location.href = "contra-editarexpedirpaaa.php?id="+document.getElementById('solproyec').value;}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculgen.value="2";document.form2.submit();break;
					case "2":	document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)-1;
								document.form2.oculto.value='2';document.form2.submit();break;
					case "3":	document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)-1;
								document.form2.oculto.value='3';document.form2.submit();break;
				}
			}
			function aprobartodo(vari){
				var opciones=document.getElementById("contador").value;
				if(vari.checked){
					document.getElementById("contadorcert").value=opciones;
					for(var i=0;i<opciones;i++){
					document.getElementById("acepta["+i+"]").checked=true;
				}
				}else{
					document.getElementById("contadorcert").value=0;
					for(var i=0;i<opciones;i++){
					document.getElementById("acepta["+i+"]").checked=false;
				}
				}
				document.form2.submit();
			}
			
		</script>
		<style>
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
		  left: 0 !important; top: -3 !important;
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
		  left: 0 !important; top: -3 !important;
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
		.c2 #t1:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t2{
			background-color: white !important;
		}
		</style>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("inve");?></tr>
    		<tr>
  				<td colspan="3" class="cinta">
					<a href="contra-expedirpaa.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
					<a href="contra-expedirpaabuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="" class="mgbt"><img src="imagenes/print.png" title="Imprimir" /></a>
					<a href="#" onClick="" class="mgbt"> <img src="imagenes/print111.png"  alt="Buscar2" title="Imprimir_v2"/></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
    	<form name="form2" method="post" enctype="multipart/form-data">
            <input type="hidden" name="oculgen" id="oculgen" value="<?php echo $_POST[oculgen] ?> ">
            <input type="hidden" name="banderin1" id="banderin1" value="<?php echo $_POST[banderin1];?>">
            <input type="hidden" name="banderin2" id="banderin2" value="<?php echo $_POST[banderin2];?>">
            <input type="hidden" name="limpiar" id="limpiar" value="<?php echo $_POST[limpiar];?>"> 
			<input type="hidden" name="clear" id="clear" value="<?php echo $_POST[clear];?>"> 
			<input type="hidden" name="posiciones" id="posiciones" value="<?php echo $_POST[posiciones];?>"> 
			<?php
			function obtenerValorProducto($columna,$solicitud,$producto){
				global $linkbd;
				$sql="SELECT codigossol,$columna FROM contrasolicitudpaa WHERE codsolicitud='$solicitud' ";
				$res=mysql_query($sql,$linkbd);
				$row = mysql_fetch_row($res);
				$arreglo=explode("-",$row[0]);
				$arreglores=explode("-",$row[1]);
				$posicion=array_search($producto, $arreglo);
				return $arreglores[$posicion];
			}
			function existeProducto($codpro){
				global $linkbd;
				$registros=explode(" ",$codpro);
				$retorno=false;
				for($i=0;$i<count($registros);$i++){
					$sql="SELECT * FROM productospaa WHERE codigo='$registros[$i]' AND estado='S' ";
					$result=mysql_query($sql,$linkbd);
					$num=mysql_num_rows($result);
					if($num==0){
						$retorno=false;
						break;
					}else{
						$retorno=true;
					}
				}
				return $retorno;
			}
				$_POST[clear]=0;
				echo "<script>
				document.form2.clear.value=0;
					</script>";			
		
					if($_POST[oculgen]=="")
					{
						$_POST[fecha]=date("d/m/Y");
						$_POST[contadorcert]=0;
						$_POST[vigenciactual]=vigencia_usuarios($_SESSION[cedulausu]);
						$_POST[tipo]=1;
						
						echo"
						<script>
							document.getElementById('banderin1').value=0;
							document.getElementById('banderin2').value=0;
							document.getElementById('oculgen').value='1';
						</script>";
					}
				
					if ($_POST[tipo]==1) {
						$sql="SELECT codplan,codigossol,valoresunit FROM contrasolicitudpaa WHERE codsolicitud='$_POST[solproyec]' ";
						$res=mysql_query($sql,$linkbd);
						$row = mysql_fetch_row($res);
						//$_POST[codadquisicion]=$row[0];
						//$nresul=buscadquisicion($_POST[codadquisicion]);
						
						//if($nresul[1]!='')
						//{
							//$_POST[nadquisicion]=$nresul[1];
						//}
						$_POST[codadquisicion]=$row[0];
						$arregloplanes=explode("-",$row[0]);
						//var_dump($arregloplanes);
						if(!empty($row[1])){
							$arreglosoli=explode("-",$row[1]);
						}

					
						$_POST[nadquisicion] = 'SOLICITUD DE PRODUCTOS A ALMACEN';
					}else{
						$arreglop = explode("-",$_POST[codadquisicion]);
						$arreglocont = explode("-",$_POST[cnat]);
						for ($i=0; $i <count($arreglocont) ; $i++) { 
							for ($j=0; $j < intval($arreglocont[$i]) ; $j++) { 
								$aux[] = $arreglop[$i];
								$arregloplanes = array_merge($arregloplanes, $aux);
							}
							unset($aux);
						}
						$arreglosoli = explode("-",$_POST[codigos]);
						$_POST[solproyec] = selconsecutivo('contrasolicitudpaa','codigo');
					}
					
            ?>
            <table class="inicio">
				<tr>
					<td class="titulos" style="width:100%;">.: Tipo
						<select name="tipo" id="tipo" onKeyUp="return tabular(event,this)" onChange="cargarproyecto()" style="width:20%;" >
							<option value='1' <?php if($_POST[tipo]==1){ echo SELECTED; }?>>Orden de Compra</option>
							<option value='2' <?php if($_POST[tipo]==2){ echo SELECTED; }?>>Manual</option>
						</select>
					</td>
					<td style="width:80%;">
					</td>
				</tr>
			</table>
 			<table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="8">Certificar PAA</td>
                                
                            </tr>
							<tr>
                                <td class="saludo1" style="width:13%">Fecha:</td>
                                <td width="13%"><input name="fecha" type="text" id="fecha" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" style="width: 80%">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fecha');" class="icobut"/></td>
								<td class="saludo1" style="width:13%"><?php if($_POST[tipo]==1){ echo "Solicitud:"; }else{ echo "Codigo UNSPSC"; }?></td>
								<td style="width:30%">
								<?php if($_POST[tipo]==1){ ?>
									<select name="solproyec" id="solproyec" onChange="cargarproyecto()" style="width: 90%">
										<option value='' >Seleccione...</option>
										<?php
										$sql="SELECT csp.codigo,csp.codsolicitud,csp.descripcion FROM contrasolicitudpaa AS csp,contrasoladquisiciones AS csa WHERE csp.estado='A' AND csp.codsolicitud=csa.codsolicitud";
										$res=mysql_query($sql,$linkbd);
										while($row = mysql_fetch_row($res)){
											if($_POST[solproyec]==$row[1]){
												echo "<option value='$row[1]' SELECTED>$row[1] - ".substr($row[2],0,88)."...</option>";
												$_POST[codigo]=$row[0];
												$_POST[vigencia]=$row[3];
												$_POST[solproyecod]=$row[1];
												$_POST[nomobjeto]=$row[2];
											}else{
												echo "<option value='$row[1]'>$row[1] - ".substr($row[2],0,88)."...</option>";
											}
											
										}
										echo "<input type='hidden' name='codigo' id='codigo' value='$_POST[codigo]' />";
										echo "<input type='hidden' name='vigencia' id='vigencia' value='$_POST[vigencia]' />";
										echo "<input type='hidden' name='solproyecod' id='solproyecod' value='$_POST[solproyecod]' />";
										echo "<input type='hidden' name='nomobjeto' id='nomobjeto' value='$_POST[nomobjeto]' />";
										?>
									</select>
									<span style="text-decoration: underline; cursor:pointer"><b><a href="#" onClick="versolicitud()">VER</a></b></span>
								<?php }else{ ?>
                                	<input type="text" name="codigos" id="codigos" value="<?php echo $_POST[codigos];?>" style="width:90%;" readonly/>
									<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" class="icobut"></a>
									<input type='hidden' name='solproyec' id='solproyec' value='<?php echo $_POST[solproyec];?>' />
									<input type='hidden' name='cnat' id='cnat' value='<?php echo $_POST[cnat];?>' />
								<?php } ?>
								</td>
								<td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;"></td>
								<td style="width:5%" ></td>
								</tr>
								<tr>
                            <td class="saludo1" style="width:5%;">C&oacute;digo Plan(es) de Compras:</td>
                            <td valign="middle" width="10%">
                            	<input type="hidden" name="codadqant" id="codadqant" value="<?php echo $_POST[codadqant];?>"/>
                                <input type="text" id="codadquisicion" name="codadquisicion" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscadquisicion(event)" value="<?php echo $_POST[codadquisicion]?>" readonly onClick="document.getElementById('codadquisicion').focus();document.getElementById('codadquisicion').select();" style="width:90%" <?php if($_POST[actiblo]=="readonly"){echo "disabled";}?>> 
                            </td>
                            <td class="saludo1" style="width:6%;">Objeto:</td>
                            <td colspan="1">
								<input type="text" name="nadquisicion" id="nadquisicion" value="<?php echo $_POST[nadquisicion]?>" style="width:100%"   <?php echo $_POST[actiblo];?> readonly>
                            </td>
                        </tr>   
							<tr>
                                <td class="saludo1" style="width:5%">Observaciones:</td>
                                <td colspan="3">
									<input name="observacion" type="text" id="observacion"  value="<?php echo $_POST[observacion]; ?>" style="width: 74%;text-align:left;height: 60px">
									<div style="border: 1px dashed gray;padding-left: 2%;float: right;margin-top: -1px;margin-left: -1px;padding-bottom: 11px;padding-top: 5px;padding-right: 20px;">
										<div style="display:inline-block;"><label style="background-color: white !important; color:#555;font-size:10px">Aprobar certificado:</label></div>
										<div class="c1" style="display:inline-block"><input type="checkbox" id="finaliza" name="finaliza"  onChange="validafinalizar(this)" <?php if(isset($_POST['finaliza'])){echo "checked";} ?> value="<?php echo $_POST[finaliza]?>"/><label for="finaliza" id="t1" ></label></div>
										<br><br>
										<div style="display:inline-block;"><label style="background-color: white !important; color:#555;font-size:10px">Corregir solicitud: <?php echo str_repeat('&nbsp;', 2); ?></label></div>
										<div class="c2" style="display:inline-block"><input type="checkbox" id="finaliza2" name="finaliza2"  onChange="validafinalizar(this)" <?php if(isset($_POST['finaliza2'])){echo "checked";} ?> value="<?php echo $_POST[finaliza2]?>"/><label for="finaliza2" id="t2" ></label></div>
									</div>
								</td>
                            </tr>
					</table>
            <input type="hidden" name="vigenciactual" id="vigenciactual" value="<?php echo $_POST[vigenciactual];?>">
            <div class="subpantallac" style="height:43.5%; width:99.5%; overflow:hidden">
			<table>
			<tr>
			<td valign="top" style="width: 70%"> 
			<div class="container1" style="overflow-y:scroll; overflow-x:hidden; max-height: 350px; height: 350px">
			<table class="inicio">
                <tr><td class="titulos" colspan="10">PRODUCTOS A CERTIFICAR</td></tr>
                <tr>
					<td class="titulos2" style="width:7%"><input type="checkbox" name="todos" id="todos" <?php if(isset($_POST[todos])){echo "CHECKED"; } ?> style=
					"height:10px !important" onChange="aprobartodo(this)"/> Aprobar</td>
                    <td class="titulos2" style="width:10%">Codigo UNSPSC</td>
					<td class="titulos2" style="width:15%">Detalle</td>
					<td class="titulos2" style="width:10%" align="middle">Codigo Plan</td>
                    <td class="titulos2" style="width:20%">Modalidad Adq.</td>
					<td class="titulos2" style="width:10%">Duracion</td>
					<td class="titulos2" style="width:25%">Responsable</td>
		
                </tr>
                <?php
					//$resultante=Array();
					
					/*
					$sql="SELECT codigosaprob FROM contrasolicitudpaa WHERE codplan='$_POST[codadquisicion]' ";
					$res=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_row($res)){
						$concatena.=$row[0]."-";
					}
					$concatena=substr($concatena,0,-1);
					$totalcods=explode("-",$concatena);
					for($i=0;$i<$tam;$i++){
						if(!(in_array($arreglouns[$i],$totalcods))){
							$resultante[]=$arreglouns[$i];
						}
					}
					*/
					$co='saludo1a';
					$co2='saludo2';
					$change = 0;
					for($i=0;$i<count($arreglosoli);$i++ ){
						$sql="SELECT cp.* FROM contraplancompras cp WHERE cp.codplan='".$arregloplanes[$i]."' AND cp.estado='S' ";
						$res=mysql_query($sql,$linkbd);
						$row = mysql_fetch_row($res);
						$modalidad=$row[8];
						$contacto=$row[15];
						$duracion=explode("/",$row[7]);
						$vtotal=$row[10];
					
						$sqlr="Select nombre_dominio from dominios  where nombre_dominio='MODALIDAD_SELECCION' and (valor_final IS NULL or valor_final ='') AND (tipo='S' OR tipo='1') AND valor_inicial='$modalidad' LIMIT 0,1"; 
						$re=mysql_query($sqlr,$linkbd);
						$rmod=mysql_fetch_row($re);
						$sql="SELECT nombre FROM productospaa WHERE codigo='$arreglosoli[$i]' AND estado='S' ";
						$r=mysql_query($sql,$linkbd);
						$ro=mysql_fetch_row($r);
						//if(in_array($arreglouns[$i],$arreglosoli)){
							if(isset($_POST[acepta][$i])){
								$check="CHECKED";
								$estilo=" style='background-color: yellow !important' ";
								
							}else{
								$check="";
								$estilo="";
							}
						//}else{
							//   echo "<td><input type='checkbox' name='acepta[$i]' id='acepta[$i]' onChange='comprueba($arreglouns[$i],this)' DISABLED/></td>";
						//}
						echo "<tr class='$co' $estilo>";
						echo "<td><input type='checkbox' name='acepta[$i]' id='acepta[$i]' onChange='comprueba($arreglosoli[$i],this)' $check /></td>";
						echo "<td><input type='hidden' name='dcodigos[]' value='$arreglosoli[$i]'/> $arreglosoli[$i] </td>";
						echo "<td>$ro[0]</td>";
						if($_POST[tipo]==1){
							echo "<td align='middle'><input type='hidden' name='dpaa[]' value='$arregloplanes[$i]'/> $arregloplanes[$i]</td>";
						}else{
							echo "<td align='middle'><input type='hidden' name='dpaa[]' value='$arregloplanes'/> $arregloplanes</td>";
						}
						echo "<td>$rmod[0]</td>";
						echo "<td>$duracion[0] DIAS / $duracion[1] MESES</td>";
						echo "<td>$contacto</td>";
						echo "</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
					}
					
                   
                    
                   
                ?>
            </table>
			</div>
			</td>
			<td valign="top" style="width: 30%">
			<div class="container2" style="overflow-y:scroll; overflow-x:hidden; max-height: 350px; height: 350px">
			<table class="inicio">
			 <tr><td class="titulos" colspan="3">PRODUCTOS SOLICITADOS</td></tr>
                <tr>
                    <td class="titulos2" style="width:30%">Codigo UNSPSC</td>
					<td class="titulos2" style="width:40%">Detalle</td>
                    <td class="titulos2" style="width:30%">Tipo.</td>
		
                </tr>
			<?php
				if($_POST[tipo]==1){
					$sql="SELECT codigossol FROM contrasolicitudpaa WHERE codsolicitud='$_POST[solproyec]' ";
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
				}else{
					$fila[0]=$_POST[codigos];
				}
				if(!empty($fila[0])){
					$resultado=explode("-",$fila[0]);
					for($i=0;$i<count($resultado);$i++ ){
						$sql="SELECT nombre FROM productospaa WHERE codigo='$resultado[$i]' AND estado='S' ";
						$r=mysql_query($sql,$linkbd);
						$ro=mysql_fetch_row($r);
						echo "<tr class='$co' id='$i' >";
						echo "<td> <input type='hidden' name='dcodigosol[]' value='$resultado[$i]'/> $resultado[$i] </td>";
						echo "<td>$ro[0]</td>";
						echo "<td>PRODUCTO</td>";
						echo "</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
					}
					$_POST[contador]=count($resultado);
				}
				
			?>
			</table>
			</div>
			
			</td>
			</tr>
			</table>
           
			
 			</div>
            <input type="hidden" name="oculto" id="oculto" value="1">
			<input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador]; ?>">
			<input type="hidden" name="contadorcert" id="contadorcert" value="<?php echo $_POST[contadorcert]; ?>">
			<?php
   				if($_POST[oculgen]=="2")
				{
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$aceptar=$_POST[finaliza];
					$rechazar=$_POST[finaliza2];
					$solicitud=$_POST[solproyec];
					$codigos="";
					$fechaf=cambiar_fecha($_POST[fecha]);
					$totalcerti=0;
					for($i=0;$i<$_POST[contador];$i++){
						if(isset($_POST[acepta][$i])){
							$codigos.=($_POST[dcodigos][$i]."-");
							if ($_POST[tipo]==1) {
								$cantidad.=(obtenerValorProducto("cantidadunit",$solicitud,$_POST[dcodigos][$i])."-");
								$valores.=(obtenerValorProducto("valoresunit",$solicitud,$_POST[dcodigos][$i])."-");
								$totalcerti+=$valores;
							}else{
								$cantidad.='1-';
								$valores.=round($vtotal/count($arreglosoli),2).'-';
								$totalcerti+=$valores;
							}
							$planes.=($_POST[dpaa][$i]."-");
						}

					}
					$codigos=substr($codigos,0,-1);
					$cantidad=substr($cantidad,0,-1);
					$valores=substr($valores,0,-1);
					$planes=substr($planes,0,-1);
					if(isset($aceptar)){
						if($_POST[tipo]==1){
							$sql="UPDATE contrasolicitudpaa SET estado='CE',observaciones='$_POST[observacion]',codigosaprob='$codigos',codplan='$planes',fecha_certi='$fechaf',valtotalcerti='$totalcerti'  WHERE codsolicitud=$solicitud";
							mysql_query($sql,$linkbd);
							$sql="UPDATE contrasoladquisiciones SET codplan='$planes',objeto='$_POST[nomobjeto]',codproductos='$totprod',numproductos='$totnum',valunitariop='$totval' WHERE codsolicitud=$solicitud";
							mysql_query($sql,$linkbd);
						}else{						
							$sql="INSERT INTO contrasolicitudpaa(codigo,codsolicitud,fecha,estado,vigencia,descripcion,observaciones,codigosaprob,codplan,fecha_certi,valtotalsol,valtotalcerti,valoresunit,cantidadunit,codigossol) VALUES ('$solicitud','0','$fechaf','CE','$vigusu','$_POST[nadquisicion]','$_POST[observacion]','$codigos','$planes','$fechaf','$vtotal','$totalcerti','$valores','$cantidad','$_POST[codigos]')";
							view($sql);
						}
					}else if(isset($rechazar)){
						if($_POST[tipo]==1){
							$sql="UPDATE contrasolicitudpaa SET estado='CO',observaciones='$_POST[observacion]',codigosaprob='$codigos',codplan='$planes',fecha_certi='$fechaf',valtotalcerti='0'  WHERE codsolicitud=$solicitud";
							mysql_query($sql,$linkbd);
						}else{
							$sql="INSERT INTO contrasolicitudpaa(codigo,codsolicitud,fecha,estado,vigencia,descripcion,observaciones,codigosaprob,codplan,fecha_certi,valtotalsol,valtotalcerti,valoresunit,cantidadunit,codigossol) VALUES ('$solicitud','0','$fechaf','CO','$vigusu','$_POST[nadquisicion]','$_POST[observacion]','$codigos','$planes','$fechaf','$vtotal','0','$valores','$cantidad','$_POST[codigos]')";
							view($sql);
						}
					}
					echo"<script>despliegamodalm('visible','1','Certificado Generado con Exito');</script>";
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