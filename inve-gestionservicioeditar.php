<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	require"conversor.php";
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
        <title>:: Spid - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
		#pagos{
			transition: all 1s;
		}
		#pagos:hover{
			transform:rotate(360deg);
		}
		</style>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
		
			function validafinalizar(){
			var acta=document.getElementById('acta').value;
			var contador=parseInt(document.getElementById('contador').value);
			var estado=document.getElementById("estsemaforo4").value;
			var tot=document.getElementById("conta").value;
			if(estado!=0){
				if(acta!=''){

						if(document.form2.nproceso.value=='' && document.form2.obcontra.value==''){
							despliegamodalm('visible','2','No se ha cargado ningun proceso');
							document.getElementById('finalizac').checked=false;
						}else{
							if(contador==0){
							despliegamodalm('visible','2','Debe aprobar un pago');
							document.getElementById('finalizac').checked=false;
						}else{
							if(document.form2.nregpresu.value=='0'){
							despliegamodalm('visible','2','No existe un registro para este servicio');
							document.getElementById('finalizac').checked=false;
							}else{
								document.getElementById('estsemaforo3').value="3";
							}
					}
							
									
					}
				
				
			}else{
				despliegamodalm('visible','2','Debe primero cargar el acta de finalizacion');
				document.getElementById('finalizac').checked=false;
				
			}
		}else{
			if(document.form2.nproceso.value=='' && document.form2.obcontra.value==''){
							despliegamodalm('visible','2','No se ha cargado ningun proceso');
							document.getElementById('finalizac').checked=false;
						}else{
							if(contador==0){
							despliegamodalm('visible','2','Debe aprobar un pago');
							document.getElementById('finalizac').checked=false;
						}else{
							if(document.form2.nregpresu.value=='0'){
							despliegamodalm('visible','2','No existe un registro para este servicio');
							document.getElementById('finalizac').checked=false;
							}else{
								document.getElementById('estsemaforo3').value="3";
							}
					}
							
									
			}
				
		}
			
	}
		
		function carnomarchivo()
			{	
			var comarchivo=document.getElementById('archivotexto').value;
				var elem = comarchivo.split('\\');
				var totalelem=elem.length-1;
				document.getElementById('acta').value=elem[totalelem];
				document.form2.submit();
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="ventana-gestionservicio.php?vigencia=2017";break;

					}
				}
			}
			
			function putfile(valor,posi){document.getElementsByName('namearc[]').item(posi).value=valor;}
			function putfile2(valor,posi){document.getElementsByName('namearc2[]').item(posi).value=valor;}
			function validar(){document.form2.submit();}
			function cambiopestanas(ven){document.getElementById('pesactiva').value=ven;}
			function valnumarchivo(indicador){document.getElementById('actachivo').value=indicador;document.getElementById('ocultoa1').value='1';}
			function bcontratis(e)
			{if (document.form2.idcontratista.value!=""){document.form2.bcontratista.value='1';document.form2.submit();}}
			function buscater(e)
			{if (document.form2.tercero.value!=""){document.form2.bctercero.value='1';document.form2.submit();}}
			function buscarea(e)
			{if (document.form2.realizado.value!=""){document.form2.bcrealizado.value='1';document.form2.submit();}}
			function buscarev(e)
			{if (document.form2.revisado.value!=""){document.form2.bcrevisado.value='1';document.form2.submit();}}
			function buscafir(e)
			{if (document.form2.firmado.value!=""){document.form2.bcfirmado.value='1';document.form2.submit();}}
			function buscacta(e)
 			{if (document.form2.cuenta.value!=""){document.form2.bc.value=2;document.form2.submit();}}
			function guardar()
			{
				   var contador=parseInt(document.getElementById('contador').value);
				   var pestana=document.getElementById("pesactiva").value;
				   var saldo=document.getElementById("saldo").value;
				   var total=document.getElementById("totapro").value;
				   var liberado=document.getElementById("liberadoc").value;
				   if(liberado=="1"){
					   despliegamodalm('visible','2','La entrada de servicio esta liberada');
				   }else{
					     if((saldo-total)<0){
					   despliegamodalm('visible','2','El saldo no puede ser negativo');
				   }else{
					  if(pestana=='1'){
						if (document.form2.nproceso.value!='' && document.form2.obcontra.value!='' && contador>0)
						{
							
							if (confirm("Esta Seguro de Guardar")){document.form2.control.value='1';document.form2.oculto.value="2";document.form2.submit();}
						}
						else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
					}else if(pestana=='2'){
						 if (confirm("Esta Seguro de Guardar")){document.form2.control.value='1';document.form2.oculto.value="4";document.form2.submit();}
					}else{
						var pasa=true;
						var archivosobli=document.getElementsByName("obliga2[]");
						var nombreobli=document.getElementsByName("namearc2[]");
						for(var i=0;i<archivosobli.length;i++){
							if(archivosobli.item(i).value=='S' && nombreobli.item(i).value==''){
								pasa=false;
								break;
							}
						}
						if(pasa==false){
							despliegamodalm('visible','2','Falta Anexar Archivos Obligatorios');
						}else{
							if (confirm("Esta Seguro de Guardar")){document.form2.control.value='1';document.form2.oculto.value="3";document.form2.submit();}
						}
					} 
				   }
				   }
	
								
			}   
			
		
			function cambiobotones(_tip)
			{
				switch(_tip)
				{
					case "1":	document.getElementById('botguardar').value="1";break;
					case "2":	document.getElementById('botguardar').value="2";break;
					case "3":	document.getElementById('botguardar').value="3";break;
					case "4":	document.getElementById('botguardar').value="4";break;
				}
				
			}
			function validar2(_tip)
			{
				switch(_tip)
				{
					case "anti":		var anticipo=document.getElementById('anticipo').value;
										if(anticipo=="n")
										{
											document.getElementById('valacti').value="disabled";
											document.getElementById('valantio').value=0;
										}
										else{document.getElementById('valacti').value="";}
										break;
					case "datanti":		document.getElementById('valantio').value=document.getElementById('valanti').value;break;
					case "vplazo":		if(document.getElementById('plazo').value!="")
										{document.getElementById('plazoo').value=document.getElementById('plazo').value;}
										break;
					case "vunidades":	if(document.getElementById('nunidadesv').value!="")
										{document.getElementById('nunidades').value=document.getElementById('nunidadesv').value;}
										break;
					case "vvalcontra":	if(document.getElementById('valcontra').value!="")
										{document.getElementById('valcontrao').value=document.getElementById('valcontra').value;}
										break;
					case "vpagos":		if(document.getElementById('npagosv').value!="")
										{document.getElementById('npagos').value=document.getElementById('npagosv').value;}
										break;
				}
				document.form2.submit();
			} 
			function validar1()
			{
				var ban1=document.getElementById('modalidad').value;
				var ban2=document.getElementById('smodalidad').value
				if((ban1!="")&&((ban2!="")))
				{
					document.getElementById('ocultoa1').value="2";
					document.getElementById('estsemaforo2').value="1"
					document.getElementById('estsemaforo4').value="1"
				}
				document.form2.submit();
			}
			function despliegamodal(_valor,_tip,_pro)
			{
				document.getElementById("bgventanamodal1").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana1').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventana1').src="contra-gestioncontratosterceros.php";break;
						case "2":	var direcc="contra-gestioncontratosempleados.php?ind="+_pro;
									document.getElementById('ventana1').src=direcc;break;
					}
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
			function funcionmensaje(){var codigo=document.getElementById('codigo').value; window.location.href='inve-gestionservicioeditar.php?id='+codigo;}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form1.oculgen.value=2;document.form1.submit();break;
				}
			}
			function actualizardatos(){
				document.form2.oculto.value=6;
				document.form2.submit();
			}
			function validarcheck(e){
				var valor=document.getElementsByClassName(e.id).item(0).value;
				var nuevonum=limpiarNumero(valor);
				if(e.checked==true){
					document.form2.contador.value=parseInt(document.form2.contador.value)+1;
					document.form2.totapro.value=parseFloat(document.form2.totapro.value)+parseFloat(nuevonum);
					
				}else{
					document.form2.contador.value=parseInt(document.form2.contador.value)-1;
					document.form2.totapro.value=document.form2.totapro.value-parseFloat(nuevonum);
				}
				document.form2.control.value='1';
				document.form2.oculto.value='10';
				document.form2.submit();
			}
			function limpiarNumero(numero){
				var acum="";
				for(var i=0;i<numero.length;i++){
					if(!(numero.charAt(i)=='$' || numero.charAt(i)=='.')){
						acum+=numero.charAt(i);
					}
				}
				return acum;
			}
			function atrasc(){
				var min=1;
				var codigo=document.getElementById("codigo").value;
				document.form2.oculto.value='';
				if(codigo>min){
					document.getElementById("codigo").value=parseInt(document.getElementById("codigo").value)-1;
					document.form2.submit();
				}
			}
			function adelante(){
				var max=document.getElementById("maximo").value;
				var codigo=document.getElementById("codigo").value;
				document.form2.oculto.value='';
				if(codigo<max){
					document.getElementById("codigo").value=parseInt(document.getElementById("codigo").value)+1;
					document.form2.submit();
				}
			}
			function agregarchivo(){

				if(document.getElementById("rutarchivo1").value!=""){
							document.form2.agregadet3.value=1;
							document.form2.oculto.value=1;
							document.form2.submit();
				}
				else {despliegamodalm('visible','2','Debe especificar la ruta del archivos');}
			}
			jQuery(function($){ $('#valanti').autoNumeric('init');});
			jQuery(function($){ $('#valcontra').autoNumeric('init');});
			
			jQuery(function($){ 
			
			$('input[data-rel=valorvl]').autoNumeric('init');
			
			}
			);
		</script>
        <?php 
			titlepag();
			
			function validacion01()
			{
				if(($_POST[estsemaforo4]=="2") ){$val01="";}
				else{$val01="disabled";}
				return $val01;
			}
			function eliminarDir($carpeta)
			{
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
				$carpeta2="informacion/gestion_contratos/".$vigusu."/".$carpeta;
				foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
				{
					//echo $archivos_carpeta;
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta2);
			}
			function limpiarnum($numero){
				$acum="";
				for($i=0;$i<strlen($numero);$i++ ){
					if(!($numero[$i]=='$' || $numero[$i]=='.')){
						$acum.=$numero[$i];
					}
				}
				$pos=strpos($acum,",");
				return substr($acum,0,$pos);
			}
			
		?>
	</head>
    <body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
       <table>
		    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
		    <tr><?php menu_desplegable("inve");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="inve-gestionservicio.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="inve-gestionserviciobuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" class="mgbt" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="inve-gestionserviciobuscar.php"  class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
        	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" enctype="multipart/form-data" action="inve-gestionservicioeditar.php">  
        	<?php 
				$cmoff='imagenes/sema_rojoOFF.jpg';
				$cmrojo='imagenes/sema_rojoON.jpg';
				$cmamarillo='imagenes/sema_amarilloON.jpg';
				$cmverde='imagenes/sema_verdeON.jpg';

				//**************************************************************************************
				$linkbd=conectar_bd(); 
				if(isset($_GET[id]) && !empty($_GET[id])){
						$_POST[codigo]=$_GET[id];
					}
					
				$sql="SELECT liberado FROM inv_servicio WHERE codcompro='$_POST[codigo]' ";
				$res=mysql_query($sql,$linkbd);
				$estado=mysql_fetch_row($res);
				if($estado[0]=='1'){
					$_POST[finalizac]=1;
					$_POST[liberadoc]="1";
					$_POST[esliberado]=1;
					$_POST[estsemaforo4]="2";
					$_POST[estsemaforo3]="3";
					echo "<script>document.getElementById('estsemaforo3').value='3' ;document.getElementById('estsemaforo4').value='2';  </script>";
				}else{
					$_POST[estsemaforo4]="0";
					$_POST[estsemaforo3]="1";
				}
				$sql="SELECT * FROM inv_servicio";
				$res=mysql_query($sql,$linkbd);
				$numax=mysql_num_rows($res);
				$_POST[maximo]=$numax;
				if($_POST[oculto]=="")
				{	
					$_POST[contador]=0;
					$_POST[totapro]=0;
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
					$_POST[vigencia]=$vigusu;
					$_POST[vigcontra]=$vigusu;
					
					$sqlr="select *  from inv_servicio where codcompro='$_POST[codigo]' ";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);	
					$_POST[nproceso]=$row[1];
					$_POST[totapro]=$row[4];
					$_POST[acta]=basename($row[5]);
					$_POST[fechaent]=$row[6];
					$_POST[pesactiva]="1";
					$_POST[anticipo]="n";
					$_POST[valacti]="disabled";
					$_POST[valantio]=0;
					$_POST[valcontrao]=0;
					$_POST[plazoo1]=0;
					$_POST[plazoo2]=0;
					$_POST[finfasblo]="disabled";
					$_POST[finfasbloc]="disabled";
					$_POST[blgeneral1]="";
					$_POST[blgeneral2]="";
					$_POST[botguardar]="1";
					$sql="SELECT cc.fecha_inicio,cc.fecha_terminacion,t.nombre1,t.nombre2,t.apellido1,t.apellido2,cp.objeto,cc.rp,rp.valor,cc.valor_anticipo,cc.valor_contrato,cc.fechaliquidacion,cc.num_pagos,cc.modalidad,cc.submodalidad,cc.valor_cuota FROM contracontrato as cc,contraprocesos as cp,terceros as t,pptorp as rp WHERE cc.id_contrato=cp.idproceso AND cp.estado='S' AND cp.idproceso=$_POST[nproceso] AND t.cedulanit=cc.supervisor AND rp.consvigencia=cc.rp AND cp.vigencia=rp.vigencia";
					$result=mysql_query($sql,$linkbd);
					$cons=mysql_fetch_row($result);
					$_POST[fechai]=$cons[0];
					$_POST[fechat]=$cons[1];
					$_POST[tercero]=$cons[2]." ".$cons[3]." ".$cons[4]." ".$cons[5];
					$_POST[obcontra]=$cons[6];
					$_POST[nregpresu]=$cons[7];
					$_POST[vregpresu]=$cons[8];
					$_POST[valanti]=$cons[9];
					$_POST[valcontra]=$cons[10];
					$_POST[fechal]=$cons[11];
					$_POST[npagos]=$cons[12];
					$_POST[modalidad]=$cons[13];
					$_POST[smodalidad]=$cons[14];
					$_POST[val_cuota]=$cons[15];
					//*************************************
						$sql="SELECT aprobados FROM inv_servicio WHERE codcompro='$_POST[codigo]' ";
						$res=mysql_query($sql,$linkbd);
						$row=mysql_fetch_row($res);
						$condicion="";
						if(!empty($row[0])){
							$condicion="AND numpago IN (".$row[0].")";
						}

						$sql="SELECT valor,liberado,numpago FROM inv_servicio_det WHERE codcompro='$_POST[codigo]' $condicion ORDER BY numpago ASC ";
						$res=mysql_query($sql,$linkbd);
						$cantnum=mysql_num_rows($res);
						$_POST[conta]=$cantnum;
						$_POST[contador]=$cantnum;
						$i=0;
						while($row = mysql_fetch_row($res)){
							$valor="";
							if($row[1]=='1'){
								$valor=$row[1];
							}
							$_POST[posiciones][$i]=$row[2];
							$_POST["pagov$i"]=$row[0];
							$_POST["pago$i"]=$valor;
							$i++;
						}
				
					
					
					///////////***
					$sql="SELECT codcompro,idanexo,anexo,ruta,obligatorio FROM inv_servicio_adj WHERE codcompro='$_POST[codigo]' AND tipo='P' ";
					$res=mysql_query($sql,$linkbd);
					$cant=mysql_num_rows($res);
					$bandera="0";
					$_POST[idanex2]=Array();
					$_POST[nanex2]=Array();
					$_POST[obliga2]=Array();
					$_POST[namearc2]=Array();
					while($row = mysql_fetch_row($res)){
						$_POST[namearc2][]=$row[3];
						$_POST[idanex2][]=$row[1];
						$_POST[nanex2][]=$row[2];
						$_POST[obliga2][]=$row[4];
						if(empty($row[3]) && $row[4]=='S'){
							$bandera="1";
						}
					}
					if($cant==0){
						$_POST[estsemaforo4]="0";
							echo "<script>document.getElementById('estsemaforo4').value='0';  </script>";
					}else{
						if($bandera=="0"){
						if($_POST[estsemaforo4]!='2'){
							$_POST[estsemaforo4]="1";
							echo "<script>document.getElementById('estsemaforo4').value='1';  </script>";
						}
						
					}
				}
					
					$sql="SELECT anexo,ruta FROM inv_servicio_adj WHERE codcompro='$_POST[codigo]' AND tipo='A'";
					$result=mysql_query($sql,$linkbd);
					$_POST[nomarchivos]=Array();
					$_POST[rutarchivos]=Array();
					$_POST[tamarchivos]=Array();
					$_POST[patharchivos]=Array();
					while($row = mysql_fetch_row($result)){
						$_POST[nomarchivos][]=$row[0];
						$_POST[rutarchivos][]=$row[1];
						$_POST[tamarchivos][]=999;
						$_POST[patharchivos][]=$row[1];
					}
					
					$rutax="informacion/gestion_contratos/".$vigusu;
					$ruta="informacion/gestion_contratos/".$vigusu."/".$_POST[nproceso];
					$_POST[rutaad]=$ruta."/";
					$_POST[oculto]="0";		
				}
				else
				{if($_POST[estsemaforo1]=="0"){$_POST[estsemaforo1]="1";}}
				
				if($_POST[oculto]!=""){
					$sql="SELECT valtotalautorizado FROM inv_servicio WHERE idproceso='$_POST[nproceso]' ";
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
					$num=mysql_num_rows($res);
					if(is_null($fila[0])){
						$_POST[saldo]=$_POST[valcontra];
					}else{
						$_POST[saldo]=$fila[0];
					}
				}
				
				$sql="SELECT SUM(numpagosauto),MAX(codcompro) FROM inv_servicio WHERE idproceso='$_POST[nproceso]' ";
				$res=mysql_query($sql,$linkbd);
				$rowp=mysql_fetch_row($res);
				$total=intval($rowp[0]);
				$numpagos=intval($_POST[npagos]);
				if(($total) == $numpagos && ($numpagos>0) && $rowp[1]==$_POST[codigo]){
					
					$_POST[estsemaforo4]="1";
					echo "<script>document.getElementById('estsemaforo4').value='1'; </script>";
				}
				
				
				switch($_POST[estsemaforo3])
				{
					case "0":	$p3luzcem1=$cmrojo;$p3luzcem2=$cmoff;$p3luzcem3=$cmoff;break;
					case "1":
					case "2":	$p3luzcem1=$cmoff;$p3luzcem2=$cmamarillo;$p3luzcem3=$cmoff;break;
					case "3":	if($_POST[nregpresu]!='')
								{
									$p3luzcem1=$cmoff;$p3luzcem2=$cmoff;$p3luzcem3=$cmverde;break;
								}else
								$p3luzcem1=$cmoff;$p3luzcem2=$cmamarillo;$p3luzcem3=$cmoff;break;
				}
				switch($_POST[estsemaforo4])
				{
					case "0":	$p4luzcem1=$cmrojo;$p4luzcem2=$cmoff;$p4luzcem3=$cmoff;break;
					case "1":	$p4luzcem1=$cmoff;$p4luzcem2=$cmamarillo;$p4luzcem3=$cmoff;break;
					case "2":	$p4luzcem1=$cmoff;$p4luzcem2=$cmoff;$p4luzcem3=$cmverde;break;
				}				
				//*****************************************************************
				switch($_POST[pesactiva])
					{
						case "1":	$check1="checked";$check2="";$check3="";$check4="";break;
						case "2":	$check1="";$check2="checked";$check3="";$check4="";break;
						case "3":	$check1="";$check2="";$check3="checked";$check4="";break;
					}

				//**************************************************************************************
				if(($_POST[estsemaforo3]=="3")&& ($_POST[estsemaforo4]=="2") )
				{$_POST[finfasblo]="";}
				else{$_POST[finfasblo]="disabled";}
				//**************************************************************************************
				
				
			?> 
            <input type="hidden" name="botguardar" id="botguardar" value="<?php echo $_POST[botguardar];?>">
 			<input type="hidden" name="finfasblo" id="finfasblo" value="<?php echo $_POST[finfasblo];?>">
            <input type="hidden" name="finfasbloc" id="finfasbloc" value="<?php echo $_POST[finfasbloc];?>">
            <input type="hidden" name="blgeneral1" id="blgeneral1" value="<?php echo $_POST[blgeneral1];?>">
            <input type="hidden" name="blgeneral2" id="blgeneral2" value="<?php echo $_POST[blgeneral2];?>">
            <input type="hidden" name="blgeneralc1" id="blgeneralc1" value="<?php echo $_POST[blgeneralc1];?>">
            <input type="hidden" name="blgeneralc2" id="blgeneralc2" value="<?php echo $_POST[blgeneralc2];?>">
            <input type="hidden" name="actachivo" id="actachivo" value="<?php echo $_POST[actachivo];?>">
            <input type="hidden" name="ocultoa1" id="ocultoa1"  value="<?php echo $_POST[ocultoa1];?>" >
			<input type="hidden" name="val_cuota" id="val_cuota" value="<?php echo $_POST[val_cuota];?>" >
			<input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador];?>" >
			<input type="hidden" name="maximo" id="maximo" value="<?php echo $_POST[maximo];?>" >
			<input type="hidden" name="conta" id="conta" value="<?php echo $_POST[conta];?>" >
            <div class="tabscontra" style="height:75.conta6%; width:99.6%">
            	
            	 
               <div class="tab">
                   <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> onClick="cambiobotones('1'); cambiopestanas('1');  ">
                   <label for="tab-1"><img src="<?php echo $p3luzcem1;?>" width="16" height="16"><img src="<?php echo $p3luzcem2;?>" width="16" height="16"><img src="<?php echo $p3luzcem3;?>" width="16" height="16"> Datos Comprobante</label>
                   <div class="content" style="overflow-x:hidden;overflow-y:hidden; height: 550px">
						<table class="inicio">
							<tr>
                                <td class="titulos" style="width:93%" colspan="8">Datos Comprobante </td>
                                <td class="cerrar" style="width:7%"><a href="contra-principal.php">Cerrar</a></td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:3%">Codigo:</td>
                                <td style="width:9%">
								<a href="#" onClick="atrasc()">

									<img src="imagenes/back.png" alt="anterior" align="absmiddle">
								</a>
								
								<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo];?>" style="width:40%" onBlur="refresca()">
								<a href="#" onClick="adelante()">

									<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
								</a>
								</td>
                                <td class="saludo1" style="width:7%">N&deg; Proceso:</td>
                                <td style="width:12%"><input type="text" name="nproceso" id="nproceso" value="<?php echo $_POST[nproceso];?>" style="width:40%" <?php echo $_POST[blgeneralc1];?> onBlur="actualizardatos()" readonly> <input type="hidden" value="0" name="bop">&nbsp;<a  style="cursor:pointer;" title="Listado Procesos"><img src="imagenes/find02.png" style="width:20px;"/></a></td>
                               
                           
								
                                <td class="saludo1" style="width:6%">Liberar:</td>
                                <td style="width:10%">
                                   <div class="c1"><input type="checkbox" id="finalizac" name="finalizac"  onChange="validafinalizar()" <?php if($_POST[finalizac]!=""){echo "checked disabled"; } ?> /><label for="finalizac" id="t1" ></label></div>
								   <input type="hidden" name="liberadoc" id="liberadoc" value="<?php echo $_POST[liberadoc]; ?>" />
                                </td>  
                            </tr>
                            <tr>
                            	<td class="saludo1" >Fecha:</td>
                                <td>
								<input name="fechaent" id="fechaent" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechaent]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechaent');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								
								</td>
                                <td class="saludo1" >Fecha Inicio:</td>
                                <td >
								<input name="fechai" id="fechai" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechai]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2" readonly/>&nbsp;<a href="#" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								
								</td>
								  <td  class="saludo1">Supervisor:</td>
                                <td>
                                    <input id="tercero" name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%" onKeyUp="return tabular(event,this)" onBlur="<?php if($_POST[blgeneralc1]==""){ echo "buscater(event);";}?>" onFocus="" <?php echo $_POST[blgeneralc1];?>>
                                   
                                </td>
                               
                            </tr>
                            <tr>
                                <td class="saludo1">Objeto:</td>
                                <td colspan="3"><input type="text" name="obcontra" id="obcontra" value="<?php echo $_POST[obcontra];?>" style="width:93.5%" readonly></td>
								<td class="saludo1">Acta de Finalizacion:</td>
                                <td ><input type="text" name="acta" id="acta" value="<?php echo $_POST[acta];?>" style="width:90%" readonly>
								<div class='upload' style="float:right;"> 
         					      <a href="#" title="Cargar Documento"><input type="file" name="archivotexto" id="archivotexto" value="<?php echo $_POST[archivotexto] ?>"  <?php if($_POST[estsemaforo4]=='0'){echo "disabled"; }else{echo "onChange='carnomarchivo();' "; }?> ><img  <?php if($_POST[estsemaforo4]=='0'){echo "src='imagenes/upload02.png' "; }else{echo "src='imagenes/upload01.png' "; }?>  style="width:18px" title='Cargar Documento'/></a>
                               </div>
								</td>
                            </tr>
                       
                            <tr>
                            	<td class="saludo1">Reg. Presupuestal:</td>
                                <td><input type="text" name="nregpresu" id="nregpresu" value="<?php echo $_POST[nregpresu];?>" style="width:85%; text-align:right" readonly></td>
                                <td class="saludo1">valor:</td>
                                <td>
                                	<input type="text" name="vmregpresu" id="vmregpresu" value="<?php echo "$".number_format($_POST[vregpresu],2);?>" style="width:85%" readonly>
                                	<input type="hidden" name="vregpresu" id="vregpresu" value="<?php echo $_POST[vregpresu];?>" style="width:100%">                              
                                </td>
								  <td class="saludo1" >Valor Anticipo:</td>
                                <td>
                                	<input type="hidden" name="valantio" id="valantio" value="<?php echo $_POST[valantio];?>">
                                	<input type="text" name="valanti" id="valanti" value="<?php echo $_POST[valanti];?>" style="width:100%;text-align:right; "  data-a-sign="$" data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp="sinpuntitos('valantio','valanti');return tabular(event,this);" readonly/>
                                    
                               	</td>
                               
                                    
                            </tr>
                        
                            <tr>
                                <td class="saludo1">Valor Total:</td>
                                <td>
                                	<input type="hidden" name="valcontrao" id="valcontrao" value="<?php echo $_POST[valcontrao];?>"/>
                                	<input type="text" name="valcontra" id="valcontra" value="<?php echo $_POST[valcontra]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valcontrao','valcontra');return tabular(event,this);" style='text-align:right;width:85%' readonly/>
                                </td>
                                 <td class="saludo1" >Fecha Terminaci&oacute;n:</td>
                                <td>
								<input name="fechat" id="fechat" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechat]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2" readonly/>&nbsp;<a href="#"  tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								</td>
                                <td class="saludo1" >N&deg; Pagos:</td>
                                <td colspan="1">
                                	<input type="text" name="npagosv" id="npagosv" value="<?php $unidtx=convertir($_POST[npagos]);if($unidtx=="UN"){echo "UN PAGO";}else{echo $unidtx." PAGOS";}?>" style="width:100%"  onBlur="<?php if($_POST[blgeneralc1]==""){ echo "validar2('vpagos');";}?>" onKeyPress="javascript:return solonumeros(event)" onFocus="<?php if($_POST[blgeneralc1]==""){ echo "document.getElementById('npagosv').value='';";}?>" <?php echo $_POST[blgeneralc1];?>>
                                <input type="hidden" name="npagos" id="npagos" value="<?php echo $_POST[npagos];?>" style="width:100%">
                                </td>
                            </tr>  
                        
						</table>
						<table class="inicio">
							<tr>
                                <td class="titulos" style="width:100%" colspan="10">.: Autorizaci&oacute;n de Pagos </td>
                            </tr>
							    <tr>
								<td class="titulos2" style="width:15%;text-align:center">Pago</td>
								<td class="titulos2" style="width:45%;text-align:center">Valor a Autorizar</td>
								<td class="titulos2" style="width:20%;text-align:center" >Fecha</td>
								<td class="titulos2" style="text-align:center" >Aprobar</td>
								</tr>
							<?php
								
								for($i=0;$i<$_POST[conta]; $i++)
								{
									$check="";
									
									if($_POST["pago$i"]!=""){
										$_POST[fecha][$i]=$_POST[fechaent];
										$check="checked";
									}
									$val=0;
									if($_POST["pagov$i"]!=""){
										$val=$_POST["pagov$i"];
									}
									$val1=0;
									if($_POST["valantio$i"]!=""){
										$val1=$_POST["valantio$i"];
									}
									echo "<tr class='saludo1'>
										<input type='hidden' name='posiciones[]' value='".$_POST[posiciones][$i]."' />
										<td><center><img src='imagenes/pesos.png' title='pago $i' width='25px' height='25px' id='pagos' /><center/></td>
										<td><center><input type=\"hidden\" name=\"valantio$i\" id=\"valantio$i\" value='$val1' ><input type='text'   name='pagov$i' id='pagov$i' class='pago$i' data-rel='valorvl' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('valantio$i','pagov$i');return tabular(event,this);\" value='$val' style='width:80%;text-align:right;' onBlur='document.form2.control.value=1;document.form2.submit();' /></center> </td>
										<td ><center><input type='text' name='fecha[]' style='width: 70% !important;text-align:center' value='".$_POST[fecha][$i]."' readonly/> </center></td>
										<td ><center><div class=\"c1\"><input type=\"checkbox\" id=\"pago$i\" name=\"pago$i\"   onchange=\"validarcheck(this);\" $check/><label for=\"pago$i\" id=\"t1\" ></label></div></center></td>
									</tr>";
								}
							?>
							
							<tr class='saludo2a' style='text-align:right;font-weight:bold;background-color: rgba(0,0,0,0.2)'>
								<td style="text-align: right">Total:</td>
								<td style="text-align: center">$ <?php echo number_format($_POST['totapro']); ?> ( <?php echo convertir($_POST['totapro']); ?> PESOS MCTE)</td>
								<td style="text-align: center" colspan="2">Saldo: $ <?php echo number_format($_POST[saldo]-$_POST[totapro],2,',','.'); ?></td>
							
							</tr>
						</table>
					</div>
				</div>
				<!-- campo del total -->
				<input type="hidden" name="totapro" id="totapro" value="<?php echo $_POST[totapro]; ?>" /> 
				<input type="hidden" name="saldo" id="saldo" value="<?php echo $_POST[saldo]; ?>" /> 
				
				<div class="tab" >
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> onClick="cambiobotones('2'); cambiopestanas('2');  ">
                    <label for="tab-2"><img src="<?php echo $p3luzcem1;?>" width="16" height="16"><img src="<?php echo $p3luzcem2;?>" width="16" height="16"><img src="<?php echo $p3luzcem3;?>" width="16" height="16"> Anexos</label>
                    <div class="content" style="overflow:hidden !important;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="7" >Anexos</td>
     
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:8%">Ruta:</td>
                                <td style="width:25%" ><input type="text" name="rutarchivo1" id="rutarchivo1"  style="width:100%;" value="<?php echo $_POST[rutarchivo1]?>" readonly> <input type="hidden" name="tamarchivo1" id="tamarchivo1" value="<?php echo $_POST[tamarchivo1] ?>" /><input type="hidden" name="patharchivo1" id="patharchivo1" value="<?php echo $_POST[patharchivo1] ?>" />

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
                                        $_POST[rutarchivos][]=$_POST[rutarchivo1];
                                        $_POST[tamarchivos][]=$_POST[tamarchivo1];
                                        $_POST[patharchivos][]=$_POST[patharchivo1];
                                        $_POST[agregadet3]=0;
                                        echo"
                                        <script>	
                                            document.form2.nomarchivo.value='';
                                            document.form2.rutarchivo1.value='';
                                            document.form2.tamarchivo1.value='';
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
                                    </table>";
                         ?>
              		</div>
                </div>
				
				
				<div class="tab">

				    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> onClick="cambiobotones('3'); cambiopestanas('3');  " <?php if($_POST[estsemaforo4]=='0'){echo "disabled"; }?> >
                   <label for="tab-3"><img src="<?php echo $p4luzcem1;?>" width="16" height="16"><img src="<?php echo $p4luzcem2;?>" width="16" height="16"><img src="<?php echo $p4luzcem3;?>" width="16" height="16"> Anexos Postcontractuales</label>
					<div class="content" style="overflow-x:hidden">
						<?php
							//************************************************************************************************
							if (is_uploaded_file($_FILES['uploads2']['tmp_name'][$_POST[actachivo]]))  
							{
								
								if ($_POST[namearc2][$_POST[actachivo]]!="")
								{
									$nomar=$_POST[rutaad].$_POST[namearc2][$_POST[actachivo]];
									unlink($nomar);	
								}
								$_POST[namearc2][$_POST[actachivo]]=$_FILES['uploads2']['name'][$_POST[actachivo]];
								$nomar=$_FILES['uploads2']['name'][$_POST[actachivo]];
								copy($_FILES['uploads2']['tmp_name'][$_POST[actachivo]], $_POST[rutaad].$nomar);	
							}
							//**************************************************************************************
							if (is_uploaded_file($_FILES['archivotexto']['tmp_name'])) 
							{
								$nomarchivo=$_FILES['archivotexto']['name'];
								?><script>document.getElementById('rutarchivo').value='<?php echo $_FILES['archivotexto']['name'];?>';document.getElementById('tamarchivo').value='<?php echo $_FILES['archivotexto']['size'];?>';document.getElementById('patharchivo').value='<?php echo $_FILES['archivotexto']['name'];?>';</script><?php 
								copy($_FILES['archivotexto']['tmp_name'], $_POST[rutaad].$_FILES['archivotexto']['name']);
								
							}
			
						?>	
                        <table class="inicio">
                            <tr><td class="titulos" colspan="4">Anexos Postcontractuales</td></tr>
                            <tr>
                                <td class="saludo1">Modalidad</td>
                                <td> 
                                    <select name="modalidadv" id="modalidadv" disabled >
                                    	<option  value="" >Seleccione....</option>
                                   	 	<?php
											$sqlr="SELECT * FROM dominios where nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL OR valor_final='0')";
											$res=mysql_query($sqlr,$linkbd);
											while ($rowEmp = mysql_fetch_row($res)) 
											{
												echo "<option value= ".$rowEmp[0];
												$i=$rowEmp[0];
												if($i==$_POST[modalidad]){echo "  SELECTED";}
												echo ">".$rowEmp[0]." - ".$rowEmp[2]."</option>";	 	 
											}	
                                        ?> 
                                   	</select>
                                </td>
                          		<td class="saludo1">Procedimiento</td>
                                <td> 
                                    <select name="smodalidadv" id="smodalidadv"  disabled>
                                        <option  value="" >Seleccione....</option>
                                        <?php
                                            $sqlr="SELECT * FROM dominios where nombre_dominio='MODALIDAD_SELECCION' and valor_final = '$_POST[modalidad]' and valor_inicial = '$_POST[smodalidad]'";
											
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($rowEmp = mysql_fetch_row($res)) 
                                            {
                                                echo "<option value= ".$rowEmp[0];
                                                $i=$rowEmp[0];
                                                if($i==$_POST[smodalidad])
                                                {echo "  SELECTED";}
                                                echo ">".$rowEmp[0]." - ".$rowEmp[2]."</option>";	 	 
                                            }	
                                        ?> 
                                    </select>
                                </td>
                           	</tr>
						</table>
                        <table class="inicio">
                        	<tr>
                        		<td class="titulos2">No</td><td class="titulos2">Id Anexo</td>
                                <td class="titulos2">Anexo</td><td class="titulos2">Adjunto <img src='imagenes/attach.png'></td>
                                <td class="titulos2">Obligatorio</td>
                         	</tr>
                        		<?php
									$iter='saludo1';
                                	$iter2='saludo2';
									for($xy=0;$xy<count($_POST[namearc2]);$xy++)
									{
										$cont1=$xy+1;
										 echo "
										 <tr class='$fila'>
										 	<td>$cont1</td>
											<td style='width:10%'><input type='text' class='inpnovisibles' name='idanex2[]' style='width:95%' value='".$_POST[idanex2][$xy]."' readonly></td>
											<td style='width:30%'><input type='text' class='inpnovisibles' name='nanex2[]' style='width:95%' value='".$_POST[nanex2][$xy]."' readonly></td>
											<td style='width:40%'>
												<input type='text' name='namearc2[]' style='width:95%' value='".$_POST[namearc2][$xy]."' readonly>
												<div class='custom-input-file'>
													<input class='input-file' style='width:5%' type='file' name='uploads2[]'  onClick='valnumarchivo($xy);' onchange='validar();'><img src='imagenes/attach.png'> 
												</div>
											</td>
											<td><input type='text' class='inpnovisibles' name='obliga2[]' style='width:95%' value='".$_POST[obliga2][$xy]."' readonly></td>
										</tr>";
										$aux=$fila; 
										$fila=$fila2;
										$fila2=$aux;
									}
								?>
                   		</table>
                	</div>
				</div>            
			</div>
            <div id="bgventanamodal1" class="bgventanamodal" >
            	<div id="ventanamodal1" class="ventanamodal">
            		<a href="javascript:despliegamodal('hidden','0');" style="position: absolute; left: 810px; top: 5px; z-index: 100;">		<img src="imagenes/exit.png" alt="cerrar" width=22 height=22>Cerrar</a>
                	<IFRAME src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                	</IFRAME>
           		</div>
        	</div>
            <input type="hidden" name="oculto" id="oculto" value="1" >
            <input type="hidden" name="valacti" id="valacti" value="<?php echo $_POST[valacti];?>">
            <input type="hidden" name="rutaad" id="rutaad" value="<?php echo $_POST[rutaad];?>">
            <input type="hidden" name="pesactiva" id="pesactiva" value="<?php echo $_POST[pesactiva];?>">
            <input type="hidden" name="bctercero" id="bctercero" value="0">
            <input type="hidden" name="bcrealizado" id="bcrealizado" value="0">
            <input type="hidden" name="bcrevisado" id="bcrevisado" value="0">
            <input type="hidden" name="bcfirmado" id="bcfirmado" value="0">
            <input type="hidden" name="bcontratista" id="bcontratista" value="0">
            <input type="hidden" name="estsemaforo1" id="estsemaforo1" value="<?php echo $_POST[estsemaforo1];?>">
            <input type="hidden" name="estsemaforo2" id="estsemaforo2" value="<?php echo $_POST[estsemaforo2];?>">
            <input type="hidden" name="estsemaforo3" id="estsemaforo3" value="<?php echo $_POST[estsemaforo3];?>">
            <input type="hidden" name="estsemaforo4" id="estsemaforo4" value="<?php echo $_POST[estsemaforo4];?>">
			<input type="hidden" name="rutarchivo" id="rutarchivo" value="<?php echo $_POST[rutarchivo];?>">
			<input type="hidden" name="tamarchivo" id="tamarchivo" value="<?php echo $_POST[tamarchivo];?>">
			<input type="hidden" name="patharchivo" id="patharchivo" value="<?php echo $_POST[patharchivo];?>">
			<input type="hidden" name="esliberado" id="esliberado" value="<?php echo $_POST[esliberado];?>">
			<input type="hidden" name="agregadet3" value="0">
			<input type="hidden" name="eliminarc" id="eliminarc" value="<?php echo $_POST[eliminarc]; ?>">
			<input type="hidden" name="control" id="control" value="<?php echo $_POST[control];?>">
			
            <?php
				//******GUARDADO FASES 
				if($_POST[oculto]==2)
				{	
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
					if(isset($_POST['finalizac'])){$cfinaliza=1;}else{$cfinaliza=0;}
					$linkbd=conectar_bd();
					if(strpos($_POST[fechaent],"-")===false){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaent],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fechaf=$_POST[fechaent];
					}
					
					//*******************
					if(!empty($_POST[acta])){
						$ruta=$_POST[rutaad].$_POST[acta];
					}else{
						$ruta="";
					}

					$bandera="0";
					$numpagos=0;
					$pagosconcat="";
					for($i=0;$i<$_POST[conta];$i++){
						$val1=limpiarnum($_POST["pagov$i"]);
						if($_POST["pago$i"]!=""){
							$sql="UPDATE inv_servicio_det SET liberado='1' WHERE codcompro='$_POST[codigo]' AND numpago='".$_POST[posiciones][$i]."' ";
							$numpagos++;
							$pagosconcat.=($_POST[posiciones][$i].",");
						}else{
							$sql="UPDATE inv_servicio_det SET liberado='0' WHERE codcompro='$_POST[codigo]' AND numpago='".$_POST[posiciones][$i]."' ";
						}
						//echo $sql;
						mysql_query($sql,$linkbd);
					}
					$pagosconcat=substr($pagosconcat,0,-1);
					if($cfinaliza==1){
						$sql="UPDATE inv_servicio SET valtotalautorizado='$_POST[totapro]',liberado='$cfinaliza',numpagosauto='$numpagos',aprobados='$pagosconcat' WHERE codcompro='$_POST[codigo]' ";
						mysql_query($sql,$linkbd);
					}else{
						$sql="UPDATE inv_servicio SET valtotalautorizado='$_POST[totapro]',liberado='$cfinaliza' WHERE codcompro='$_POST[codigo]' ";
						mysql_query($sql,$linkbd);
					}
					
					
					
					if($cfinaliza==1){
						$sql="UPDATE inv_servicio SET estado='A' where codcompro='$_POST[codigo]' ";
					}else{
						$sql="UPDATE inv_servicio SET estado='S' where codcompro='$_POST[codigo]' ";
					}
					mysql_query($sql,$linkbd);
					if($cfinaliza==1)
					{
						echo"<script>
							document.getElementById('estsemaforo3').value='2';
							document.getElementById('finalizac').checked=true;
							document.getElementById('finalizac').value=1;
                        </script>";
					}
					else
						
					{?><script>document.getElementById('estsemaforo3').value="2";</script><?php }
					?>
					<?php	

					echo"<script>despliegamodalm('visible','1','Se Almaceno la Entrada de Servicio');</script>";
				}
				
				//************************************************************************************************
				if($_POST[oculto]==3)
				{	
					$conta1=0;
					$conta2=0;
					$linkbd=conectar_bd();
					$sqlr="DELETE FROM inv_servicio_adj WHERE codcompro='$_POST[codigo]' AND tipo='P' ";
					mysql_query($sqlr,$linkbd);
					for($xy=0;$xy<count($_POST[namearc2]);$xy++)
					{
						if($_POST[obliga2][$xy]=="S"){$conta1=$conta1+1;}		
					
							$idanexo=$_POST[idanex2][$xy];
							$anexo=$_POST[nanex2][$xy];
							$sqlr="insert into inv_servicio_adj (codcompro,idanexo,anexo,ruta,obligatorio,tipo) values ('$_POST[codigo]','$idanexo','$anexo','".$_POST[namearc2][$xy]."','S','P')";
	   						mysql_query($sqlr,$linkbd);
							if($_POST[obliga2][$xy]=="S"){$conta2=$conta2+1;}	
						
					}
					echo"<script>despliegamodalm('visible','1','Se Almacenaron los Anexos');</script>";
				}
				if($_POST[oculto]==4)
				{	
					$conta1=0;
					$conta2=0;
					$linkbd=conectar_bd();
					$sqlr="DELETE FROM inv_servicio_adj WHERE codcompro='$_POST[codigo]' AND tipo='A' ";
					mysql_query($sqlr,$linkbd);
					//**Almacenando archivos adjuntos
				
					for($x=0;$x<count($_POST[nomarchivos]);$x++)
					{	
						$ruta=$_POST[rutarchivos][$x];
						$nombre=$_POST[nomarchivos][$x];
						$sqlr="insert into inv_servicio_adj (codcompro,idanexo,anexo,ruta,obligatorio,tipo) values ('$_POST[codigo]','$x','$nombre','$ruta','S','A')";
						mysql_query($sqlr,$linkbd);
						
					}
					echo"<script>despliegamodalm('visible','1','Se Almacenaron los Anexos');</script>";
				}
					if (is_uploaded_file($_FILES['plantillaad1']['tmp_name'])) 
					{
						$rutaad="informacion/proyectos/temp/";
						$nomarchivo=$_FILES['plantillaad1']['name'];
						?><script>document.getElementById('rutarchivo1').value='<?php echo $_FILES['plantillaad1']['name'];?>';document.getElementById('tamarchivo1').value='<?php echo $_FILES['plantillaad1']['size'];?>';document.getElementById('patharchivo1').value='<?php echo $_FILES['plantillaad1']['name'];?>';</script><?php 
						copy($_FILES['plantillaad1']['tmp_name'], $rutaad.$_FILES['plantillaad1']['name']);
						
					}
			?>
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
			
        </form>
  	
    </body>
    
    
</html>