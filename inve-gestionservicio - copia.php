<?php //V 1000 12/12/16 ?> 
<?php
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
        <title>:: Spid - Contratacion</title>
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
		</style>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
		
		function validafinalizar(){
			var acta=document.getElementById('acta').value;
			if(acta!=''){
				document.getElementById('estsemaforo3').value="2";
				document.getElementById('estsemaforo4').value="2";
			}else{
				despliegamodalm('visible','2','Debe primero cargar el acta de finalizacion');
				document.getElementById('finalizac').checked=false;
				
			}
			//document.form2.submit();
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
			function valnumarchivo(indicador){document.getElementById('actachivo').value=indicador;}
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
				var pestn=document.getElementById('botguardar').value
				switch(pestn)
				{
					case "":
					case "1":	if (document.form2.fecha.value!='' && document.form2.modalidad.value!=''  && document.form2.smodalidad.value!=''  && document.form2.clasecontrato.value!='')
								{
									if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="2";document.form2.submit();}
								}
								else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
								break;
					case "2":	if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="3";document.form2.submit();}break;
					case "3":	if (document.form2.vigcontra.value!='')
								{
									if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="4";document.form2.submit();}break;
								}
								else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
								break;
					case "4":	if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="5";document.form2.submit();}break;
					case "4":	if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="5";document.form2.submit();}break;
				}
			}  
			function validarcdp()
			{
				valorp=document.getElementById("valor").value;
				nums=quitarpuntos(valorp);			
				if(nums<0 || nums> parseFloat(document.form2.saldo.value))
				{
					alert('Valor Superior al Disponible '+document.form2.saldo.value);
					document.form2.cuenta.select();
					document.form2.cuenta.focus();
				}
			}
			function agregardetalle()
			{
				if(document.form2.cuenta.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >=0 )
				{ document.form2.agregadet.value=1;document.form2.submit();}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
  					document.form2.chacuerdo.value=2;
					document.form2.elimina.value=variable;
					document.getElementById('elimina').value=variable;
					document.form2.submit();
				}
			}
			function pdfsolicitud()
			{
				document.form2.action="pdfsolcdispre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
			function funcionmensaje(){document.form2.submit();}
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
					document.form2.totapro.value=parseFloat(document.form2.totapro.value)+parseFloat(nuevonum);
					
				}else{
					document.form2.totapro.value=document.form2.totapro.value-parseFloat(nuevonum);
				}
				
				
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
          		<td colspan="3" class="cinta"><a href="inve-fisico.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="inve-fisicobuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" class="mgbt" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a class="mgbt"><img src="imagenes/printd.png"></a></td>
        	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" enctype="multipart/form-data">  
        	<?php 
				$cmoff='imagenes/sema_rojoOFF.jpg';
				$cmrojo='imagenes/sema_rojoON.jpg';
				$cmamarillo='imagenes/sema_amarilloON.jpg';
				$cmverde='imagenes/sema_verdeON.jpg';
				//**************************************************************************************
				if(($_POST[estsemaforo1]=="3")||($_POST[estsemaforo1]=="2"))
				{
					if(isset($_REQUEST['finaliza'])){$_POST[estsemaforo1]="3";$_POST[blgeneral1]="readonly";$_POST[blgeneral2]="disabled";}
					else{$_POST[estsemaforo1]="2";$_POST[blgeneral1]="";$_POST[blgeneral2]="";}
				}
				//**************************************************************************************
				echo $_POST[estsemaforo3]=="3";
				if(($_POST[estsemaforo3]=="3")||($_POST[estsemaforo3]=="2"))
				{
					if(isset($_REQUEST['finalizac'])){$_POST[estsemaforo3]="3";$_POST[blgeneralc1]="readonly";$_POST[blgeneralc2]="disabled";}
					else{$_POST[estsemaforo3]="2";$_POST[blgeneralc1]="";$_POST[blgeneralc2]="";}
				}
				//**************************************************************************************
				$linkbd=conectar_bd(); 
				$sql="SELECT COUNT(*) FROM inv_servicio";
				$result=mysql_query($sql,$linkbd);
				$row=mysql_fetch_row($result);
				$max=$row[0];
				$_POST[codigo]=$max+1;
			
				if($_POST[oculto]=="")
				{
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
					$_POST[vigencia]=$vigusu;
					$_POST[vigcontra]=$vigusu;
					$sqlr="select max(idproceso) from contraprocesos ";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);	 
					//$_POST[nproceso]=$row[0];	 
					$_POST[estsemaforo1]="0";	
					$_POST[estsemaforo2]="0";
					$_POST[estsemaforo3]="1";
					$_POST[estsemaforo4]="0"; 
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
					$rutax="informacion/gestion_contratos/".$vigusu;
					$ruta="informacion/gestion_contratos/".$vigusu."/".$_POST[nproceso];

					if(($vigusu!="")&&($_POST[nproceso]!=""))
					{					
						if(!file_exists($ruta))
						{
							if(!file_exists($ruta)){mkdir($rutax);}
							mkdir($ruta);
							}//Se ha creado el directorio en la ruta
							else {eliminarDir($_POST[nproceso]);mkdir ($ruta);}// " ya existe el directorio en la ruta ";
					}
					$_POST[rutaad]=$ruta."/";
					$_POST[oculto]="0";		
				}
				else
				{if($_POST[estsemaforo1]=="0"){$_POST[estsemaforo1]="1";}}
				if(($_POST[pesactiva]=="3")||($_POST[solcompra]!="")){if($_POST[estsemaforo3]=="0"){$_POST[estsemaforo3]="1";}}
				switch($_POST[estsemaforo1])
				{
					case "0":	$p1luzcem1=$cmrojo;$p1luzcem2=$cmoff;$p1luzcem3=$cmoff;break;
					case "1":
					case "2":	$p1luzcem1=$cmoff;$p1luzcem2=$cmamarillo;$p1luzcem3=$cmoff;break;
					case "3":	$p1luzcem1=$cmoff;$p1luzcem2=$cmoff;$p1luzcem3=$cmverde;break;
				}
				switch($_POST[estsemaforo2])
				{
					case "0":	$p2luzcem1=$cmrojo;$p2luzcem2=$cmoff;$p2luzcem3=$cmoff;break;
					case "1":	$p2luzcem1=$cmoff;$p2luzcem2=$cmamarillo;$p2luzcem3=$cmoff;break;
					case "2":	if($_POST[nregpresu]!='')
								{
									$p2luzcem1=$cmoff;$p2luzcem2=$cmoff;$p2luzcem3=$cmverde;break;
								}else
								$p2luzcem1=$cmoff;$p2luzcem2=$cmamarillo;$p2luzcem3=$cmoff;break;
									
				}
				switch($_POST[estsemaforo3])
				{
					case "0":	$p3luzcem1=$cmrojo;$p3luzcem2=$cmoff;$p3luzcem3=$cmoff;break;
					case "1":
					case "2":	$p3luzcem1=$cmoff;$p3luzcem2=$cmamarillo;$p3luzcem3=$cmoff;break;
					case "3":	$p3luzcem1=$cmoff;$p3luzcem2=$cmoff;$p3luzcem3=$cmverde;break;
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
						case "4":	$check1="";$check2="";$check3="";$check4="checked";break;
					}
				//*****************************************************************
				if ($_POST[solcompra]!="")
				{
					$sqlr="SELECT * FROM contrasoladquisiciones WHERE codsolicitud='$_POST[solcompra]'";
					$row=mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[concepto]=strtoupper($row[2]);
					$_POST[obcontra]=strtoupper($row[2]);
					$codsolicita=explode("-",$row[3]);
					$xx=count($_POST[sdocumento]);
					for($posi=0;$posi<$xx;$posi++)
					{
						unset($_POST[sdocumento][0]);
						unset($_POST[snombre][0]);
						unset($_POST[sidependencian][0]);
						unset($_POST[sndependencia][0]);
						$_POST[sdocumento]= array_values($_POST[sdocumento]); 
						$_POST[snombre]= array_values($_POST[snombre]); 
						$_POST[sidependencian]= array_values($_POST[sidependencian]); 	
						$_POST[sndependencia]= array_values($_POST[sndependencia]); 
					}
					foreach ($codsolicita as &$valor)
					{	
						$nresul=buscatercerod($valor);		 
						$_POST[sdocumento][]=$valor;
						$_POST[snombre][]=$nresul[0]; 
						$_POST[sidependencia][]=$nresul[2];
						$_POST[sndependencia][]=$nresul[1];
					}
					unset($valor);
					$sqlrcdp="select distinct * from pptocdp where pptocdp.vigencia='$row[9]' and pptocdp.consvigencia='$row[6]' ";
					$cont=0;
					$rowcdp=mysql_fetch_row(mysql_query($sqlrcdp,$linkbd)); 
					$_POST[numerocdp]=$rowcdp[2];
					$modfecha1=date("d-m-Y",strtotime($rowcdp[3]));
					$_POST[fechacdp]= $modfecha1;
					$_POST[estadocdp]= $rowcdp[5];
					switch($rowcdp[5])
					{
						case "S":	$_POST[estadoccdp]='DISPONIBLE';  ;break;
						case "C":	$_POST[estadoccdp]='CON REGISTRO';break;
						case "N":	$_POST[estadoccdp]='ANULADO';break;
					}
					$sqlrrp="SELECT consvigencia,valor FROM pptorp WHERE idcdp='$rowcdp[2]' AND vigencia='$row[9]'";
					$rowrp=mysql_fetch_row(mysql_query($sqlrrp,$linkbd));
					$_POST[nregpresu]=$rowrp[0];
					$_POST[vregpresu]=$rowrp[1];
					$cuentagas=0;
					$cuentaing=0;
					$diferencia=0;
					$t=count($_POST[dcuentas]);
					for ($x=0;$x<$t;$x++)
					{
						unset($_POST[dcuentas][$x]);
						unset($_POST[dtgastos][$x]);
						unset($_POST[dtipogastos][$x]);
						unset($_POST[dncuentas][$x]);
						unset($_POST[dgastos][$x]);		 		 		 		 		 
						unset($_POST[dcfuentes][$x]);		 		 
						unset($_POST[dfuentes][$x]);		 
						unset($_POST[dmetas][$x]);	
						unset($_POST[dnmetas][$x]);	
						unset($_POST[dconproyec][$x]);	
						unset($_POST[dcodproyec][$x]);
						unset($_POST[dnomproyec][$x]);	
					}
					$_POST[dtgastos]= array_values($_POST[dtgastos]); 
					$_POST[dcuentas]= array_values($_POST[dcuentas]); 
					$_POST[dtipogastos]= array_values($_POST[dtipogastos]);
					$_POST[dncuentas]= array_values($_POST[dncuentas]); 
					$_POST[dgastos]= array_values($_POST[dgastos]); 
					$_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
					$_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
					$_POST[dmetas]= array_values($_POST[dmetas]); 	
					$_POST[dnmetas]= array_values($_POST[dnmetas]); 
					$_POST[dconproyec]= array_values($_POST[dconproyec]); 	
					$_POST[dcodproyec]= array_values($_POST[dcodproyec]); 
					$_POST[dnomproyec]= array_values($_POST[dnomproyec]);	
					$sqlr3="SELECT * FROM contrasoladquisicionesgastos WHERE codsolicitud='$_POST[solcompra]'";
					$res3=mysql_query($sqlr3,$linkbd);
					$contador1=0;
					while ($row3 =mysql_fetch_row($res3))
					{
						$contador1=$contador1+1;
						$_POST[dcuentas][]=$row3[3];
						$tipo=substr($row3[3],0,1);		
						$nresul=buscacuentapres($row3[3],$tipo); 
						$_POST[dncuentas][]=$nresul;
						$ind=substr($row3[3],0,1);
						if ($ind==2)
						{
							$sqlr4="select nombre from pptofutfuentefunc where codigo='$row3[4]'";
							$res4=mysql_query($sqlr4,$linkbd);
							$row4 =mysql_fetch_row($res4);
						}
						else
						{
							$sqlr4="select nombre from pptofutfuenteinv where codigo='$row3[4]'";
							$res4=mysql_query($sqlr4,$linkbd);
							$row4 =mysql_fetch_row($res4);
						}
						$_POST[dtipogastos][]=$row3[1];
						if ($row3[1]=="2"){$_POST[dtgastos][]="Funcionamiento";}
						elseif($row3[1]=="3"){$_POST[dtgastos][]="Deuda";}
						else{$_POST[dtgastos][]="Inversion";}
						$_POST[dfuentes][]=$row4[0];
						$_POST[dcfuentes][]=$row3[4];
						$_POST[dgastos][]=$row3[5];
						$sqlr5="select nombre from presuplandesarrollo where codigo='$row3[2]'";
						$res5=mysql_query($sqlr5,$linkbd);
						$row5 =mysql_fetch_row($res5);
						$_POST[dmetas][]=$row3[2];
						$_POST[dnmetas][]=$row5[0];
						$_POST[dconproyec][]=$row3[7];
						$sqlr6="select codigo, nombre from planproyectos where consecutivo='$row3[7]'";
						$res6=mysql_query($sqlr6,$linkbd);
						$row6 =mysql_fetch_row($res6);
						$_POST[dcodproyec][]=$row6[0];		 
						$_POST[dnomproyec][]=$row6[1];	 
					} 
				}
				//*****************************************************************
				if($_POST[bctercero]=='1')
				{
					$nresul=buscatercerod($_POST[tercero]);
					if($nresul[0]!=''){$_POST[ntercero]=$nresul[0];$_POST[dependencia]=$nresul[1];$_POST[iddependencia]=$nresul[2];}
					else
					{
						$_POST[ntercero]="";
						echo"<script>despliegamodalm('visible','2','Documento Supervisor Incorrecto o no Existe');document.form2.tercero.focus();</script>";
					}
				}
				//*****************************************************************
				if($_POST[bcrealizado]=='1')
				{
					$nresul=buscatercerod($_POST[realizado]);
					if($nresul[0]!=''){$_POST[nrealizado]=$nresul[0];$_POST[drealizado]=$nresul[1];$_POST[idrealizado]=$nresul[2];}
					else
					{
						$_POST[nrealizado]="";
						echo"<script>despliegamodalm('visible','2','Documento Incorrecto o no Existe');document.form2.realizado.focus();</script>";
					}
				}
				//*****************************************************************
				if($_POST[bcrevisado]=='1')
				{
					$nresul=buscatercerod($_POST[revisado]);
					if($nresul[0]!=''){$_POST[nrevisado]=$nresul[0];$_POST[drevisado]=$nresul[1];$_POST[idrevisado]=$nresul[2];}
					else
					{
						$_POST[nrevisado]="";
						echo"<script>despliegamodalm('visible','2','Documento Incorrecto o no Existe');document.form2.realizado.focus();</script>";
					}
				}
				//*****************************************************************
				if($_POST[bcfirmado]=='1')
				{
					$nresul=buscatercerod($_POST[firmado]);
					if($nresul[0]!=''){$_POST[nfirmado]=$nresul[0];$_POST[dfirmado]=$nresul[1];$_POST[idfirmado]=$nresul[2];}
					else
					{
						$_POST[nfirmado]="";
						echo"<script>despliegamodalm('visible','2','Documento Incorrecto o no Existe');document.form2.realizado.focus();</script>";
					}
				}
				//**************************************************************************************
				if($_POST[bcontratista]=='1')
				{
					$nresul=buscatercero($_POST[idcontratista]);
					if($nresul!=''){$_POST[ncontratista]=$nresul;}
					else
					{
						$_POST[ncontratista]="";
						echo"<script>despliegamodalm('visible','2','Documento Contratista Incorrecto o no Existe');document.form2.idcontratista.focus();</script>";
					}
				}
				//**************************************************************************************
				if(($_POST[estsemaforo2]=="2")&&(($_POST[estsemaforo1]=="2" )||($_POST[estsemaforo1]=="3" )))
				{$_POST[finfasblo]="";}
				else{$_POST[finfasblo]="disabled";}
				//**************************************************************************************
				if(($_POST[estsemaforo1]=="3")&&($_POST[estsemaforo2]=="2")&&($_POST[estsemaforo4]=="2")&&(($_POST[estsemaforo3]=="2" )||($_POST[estsemaforo3]=="3" )))
				{$_POST[finfasbloc]="";}
				else{$_POST[finfasbloc]="disabled";}
				$sql="SELECT cc.fecha_inicio,cc.fecha_terminacion,t.nombre1,t.nombre2,t.apellido1,t.apellido2,cp.objeto,cc.rp,rp.valor,cc.valor_anticipo,cc.valor_contrato,cc.fechaliquidacion,cc.num_pagos,cc.modalidad,cc.submodalidad FROM contracontrato as cc,contraprocesos as cp,terceros as t,pptorp as rp WHERE cc.id_contrato=cp.idproceso AND cp.estado='S' AND cp.idproceso=$_POST[nproceso] AND t.cedulanit=cc.supervisor AND rp.consvigencia=cc.rp AND cp.vigencia=rp.vigencia";
					//echo $sql;
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
				
			?> 
            <input type="hidden" name="botguardar" id="botguardar" value="<?php echo $_POST[botguardar];?>">
 			<input type="hidden" name="finfasblo" id="finfasblo" value="<?php echo $_POST[finfasblo];?>">
            <input type="hidden" name="finfasbloc" id="finfasbloc" value="<?php echo $_POST[finfasbloc];?>">
            <input type="hidden" name="blgeneral1" id="blgeneral1" value="<?php echo $_POST[blgeneral1];?>">
            <input type="hidden" name="blgeneral2" id="blgeneral2" value="<?php echo $_POST[blgeneral2];?>">
            <input type="hidden" name="blgeneralc1" id="blgeneralc1" value="<?php echo $_POST[blgeneralc1];?>">
            <input type="hidden" name="blgeneralc2" id="blgeneralc2" value="<?php echo $_POST[blgeneralc2];?>">
            <input type="hidden" name="actachivo" id="actachivo" value="<?php echo $_POST[actachivo];?>">
            <input type="hidden" name="ocultoa1" id="ocultoa1" value="1" >
            <div class="tabscontra" style="height:75.6%; width:99.6%">
            	
            	 
               <div class="tab">
                   <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check1;?> onClick="cambiobotones('3'); cambiopestanas('3');  ">
                   <label for="tab-3"><img src="<?php echo $p3luzcem1;?>" width="16" height="16"><img src="<?php echo $p3luzcem2;?>" width="16" height="16"><img src="<?php echo $p3luzcem3;?>" width="16" height="16"> Datos Comprobante</label>
                   <div class="content" style="overflow-x:hidden">
						<table class="inicio">
							<tr>
                                <td class="titulos" style="width:93%" colspan="8">Datos Comprobante </td>
                                <td class="cerrar" style="width:7%"><a href="contra-principal.php">Cerrar</a></td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:3%">Codigo:</td>
                                <td style="width:9%"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo];?>" style="width:80%" readonly></td>
                                <td class="saludo1" style="width:7%">N&deg; Proceso:</td>
                                <td style="width:12%"><input type="text" name="nproceso" id="nproceso" value="<?php echo $_POST[nproceso];?>" style="width:40%" <?php echo $_POST[blgeneralc1];?> onBlur="actualizardatos()" > <input type="hidden" value="0" name="bop">&nbsp;<a onClick="despliegamodal2('visible','1');" style="cursor:pointer;" title="Listado Procesos"><img src="imagenes/find02.png" style="width:20px;"/></a></td>
                               
                           
								
                                <td class="saludo1" style="width:6%">Finalizar Fase:</td>
                                <td style="width:10%">
                                   <div class="c1"><input type="checkbox" id="finalizac" name="finalizac"  onChange="validafinalizar()" <?php if($_POST[finalizac]!=""){echo "checked"; } ?> /><label for="finalizac" id="t1" ></label></div>
                                </td>  
                            </tr>
                            <tr>
                            	<td class="saludo1" >Fecha Inicio:</td>
                                <td>
								<input name="fechai" id="fechai" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechai]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechai');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								
								</td>
                                <td class="saludo1" >Fecha Terminaci&oacute;n:</td>
                                <td >
								<input name="fechat" id="fechat" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechat]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechat');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								
								</td>
								  <td  class="saludo1">Supervisor:</td>
                                <td>
                                    <input id="tercero" name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%" onKeyUp="return tabular(event,this)" onBlur="<?php if($_POST[blgeneralc1]==""){ echo "buscater(event);";}?>" onFocus="" <?php echo $_POST[blgeneralc1];?>>
                                   
                                </td>
                               
                            </tr>
                            <tr>
                                <td class="saludo1">Objeto:</td>
                                <td colspan="3"><input type="text" name="obcontra" id="obcontra" value="<?php echo $_POST[obcontra];?>" style="width:89%" <?php echo $_POST[blgeneralc1];?>></td>
								<td class="saludo1">Acta de Finalizacion:</td>
                                <td ><input type="text" name="acta" id="acta" value="<?php echo $_POST[acta];?>" style="width:90%" readonly>
								<div class='upload' style="float:right;"> 
         					<a href="#" title="Cargar Documento"><input type="file" name="archivotexto" id="archivotexto" value="<?php echo $_POST[archivotexto] ?>" onChange="carnomarchivo();"><img src='imagenes/upload01.png' style="width:18px" title='Cargar Documento'/></a>
                        </div>
								</td>
                            </tr>
                       
                            <tr>
                            	<td class="saludo1">Reg. Presupuestal:</td>
                                <td><input type="text" name="nregpresu" id="nregpresu" value="<?php echo $_POST[nregpresu];?>" style="width:85%" readonly></td>
                                <td class="saludo1">valor:</td>
                                <td>
                                	<input type="text" name="vmregpresu" id="vmregpresu" value="<?php echo "$".number_format($_POST[vregpresu],2);?>" style="width:85%" readonly>
                                	<input type="hidden" name="vregpresu" id="vregpresu" value="<?php echo $_POST[vregpresu];?>" style="width:100%">                              
                                </td>
								  <td class="saludo1" >Valor Anticipo:</td>
                                <td>
                                	<input type="hidden" name="valantio" id="valantio" value="<?php echo $_POST[valantio];?>">
                                	<input type="text" name="valanti" id="valanti" value="<?php echo $_POST[valanti];?>" style="width:100%;text-align:right; "  data-a-sign="$" data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp="sinpuntitos('valantio','valanti');return tabular(event,this);" />
                                    
                               	</td>
                               
                                    
                            </tr>
                        
                            <tr>
                                <td class="saludo1">Valor Total:</td>
                                <td>
                                	<input type="hidden" name="valcontrao" id="valcontrao" value="<?php echo $_POST[valcontrao];?>"/>
                                	<input type="text" name="valcontra" id="valcontra" value="<?php echo $_POST[valcontra]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valcontrao','valcontra');return tabular(event,this);" style='text-align:right;width:85%'/>
                                </td>
                                 <td class="saludo1" >Fecha Liquidaci&oacute;n:</td>
                                <td>
								<input name="fechal" id="fechal" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechal]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechal');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
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
								<td class="titulos2" style="width:15%;">N&deg; de Pago</td>
								<td class="titulos2" style="width:50%;text-align:center">Valor a Autorizar</td>
								<td class="titulos2" style="text-align:center" >Liberar</td>
								</tr>
							<?php
								for($i=0;$i<$_POST[npagos]; $i++)
								{
									$check="";
									if($_POST["pago$i"]!=""){
										$check="checked";
									}
									$val=0;
									if($_POST["pagov$i"]!=""){
										$val=limpiarnum($_POST["pagov$i"]);
									}
									$val1=0;
									if($_POST["valantio$i"]!=""){
										$val1=limpiarnum($_POST["valantio$i"]);
									}
									echo "<tr ><td>Pago No. $i</td><td><center><input type=\"hidden\" name=\"valantio$i\" id=\"valantio$i\" value='$val1'><input type='text' name='pagov$i' id='pagov$i' class='pago$i' data-rel='valorvl' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('valantio$i','pagov$i');return tabular(event,this);\" value='$val' style='width:80%;text-align:right;' /></center> </td><td ><center><div class=\"c1\"><input type=\"checkbox\" id=\"pago$i\" name=\"pago$i\"   onchange=\"validarcheck(this);\" $check/><label for=\"pago$i\" id=\"t1\" ></label></div></center></td></tr>";
								}
							?>
							
							<tr class='saludo2a' style='text-align:right;font-weight:bold;'>
								<td style="text-align: right">Total:</td>
								<td style="text-align: center">$ <?php echo number_format($_POST['totapro']); ?></td>
								<td></td>
							
							</tr>
						</table>
					</div>
				</div>
				<input type="hidden" name="totapro" id="totapro" value="<?php if($_POST['totapro']==""){echo 0; } else{ echo $_POST['totapro']; }  ?>" /> 
				<div class="tab">
                   <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?>   <?php $val01=validacion01();echo $val01; ?> >
                   <label for="tab-4"><img src="<?php echo $p4luzcem1;?>" width="16" height="16"><img src="<?php echo $p4luzcem2;?>" width="16" height="16"><img src="<?php echo $p4luzcem3;?>" width="16" height="16"> Anexos Postcontractuales</label>
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
							if($_POST[ocultoa1]=="2")
							{
								$_POST[namearc2]=array(); 
								$_POST[idanex2]=array();
                                $_POST[nanex2]=array();
								$_POST[obliga2]=array();
                                $sqlr="SELECT contramodalidadanexos.idanexo,contraanexos.nombre, contramodalidadanexos.obligatorio  FROM contramodalidadanexos, contraanexos where contramodalidadanexos.idmodalidad = '$_POST[modalidad]' and contramodalidadanexos.idpadremod = '$_POST[smodalidad]' and contramodalidadanexos.fase='3' and contramodalidadanexos.idanexo=contraanexos.id";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_row($res)) 
								{	
								$_POST[namearc2][]="";
								$_POST[idanex2][]=$rowEmp[0];
								$_POST[nanex2][]=$rowEmp[1];
								$_POST[obliga2][]=$rowEmp[2];
								}
								$_POST[ocultoa1]="1";
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
            <?php
				//*** ingreso
				
			 	if($_POST[bin]=='1')
			 	{
			  		$nresul=buscaingreso($_POST[codingreso]);
			  		if($nresul!='')
			   		{
			 			$_POST[ningreso]=$nresul;
  			  			echo"<script>document.getElementById('valor').focus();document.getElementById('valor').select();</script>";
			  		}
			 		else
			 		{
			  			$_POST[codingreso]="";
			  			echo"<script>despliegamodalm('visible','3','Codigo Ingresos Incorrecto');document.form2.codingreso.focus();</script>";
			  		}
			 	}
				//******GUARDADO FASES 
				if($_POST[oculto]==2)
				{	
					if(isset($_REQUEST['finaliza'])){$cfinaliza=1;}else{$cfinaliza=0;}
					$linkbd=conectar_bd();
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					if($_POST[estsemaforo1]=="1")
					{
						$sqlr="insert into contraprocesos (idproceso,fecha,vigencia,objeto,modalidad,submodalidad,clasecontrato,nomproyecto,contrato,solicita,dependencia,estado,codsolicitud, activo)values('$_POST[nproceso]','$fechaf','$_POST[vigencia]','$_POST[concepto]','$_POST[modalidad]','$_POST[smodalidad]','$_POST[clasecontrato]','','','','','S','$_POST[solcompra]','$cfinaliza')";$mensaje="Se Almacenaron los Datos Precontractuales con Exito";
						$sqlrsef="INSERT INTO contraestadosemf (idcontrato,sem1,sem2,sem3,sem4) VALUES ('$_POST[nproceso]', '2', '$_POST[estsemaforo2]','$_POST[estsemaforo3]','$_POST[estsemaforo4]')";
						//echo $sqlr;
					}
					else
					{
						if($_POST[solcompra]!=""){$solicompra=$_POST[solcompra];}
						else {$solicompra=$_POST[solcomprao];}
						$sqlr="UPDATE contraprocesos SET  fecha='$fechaf',vigencia='$_POST[vigencia]',objeto='$_POST[concepto]', modalidad='$_POST[modalidad]',submodalidad='$_POST[smodalidad]',clasecontrato='$_POST[clasecontrato]',codsolicitud='$solicompra', activo='$cfinaliza' WHERE idproceso='$_POST[nproceso]'";$mensaje="Se Modificaron los Datos Precontractuales con Exito";
						if($cfinaliza==1){$camsem=3;}
						else{$camsem=2;}
						$sqlrsef="UPDATE contraestadosemf SET sem1='$camsem',sem2='$_POST[estsemaforo2]',sem3='$_POST[estsemaforo3]', sem4='$_POST[estsemaforo4]' WHERE idcontrato='$_POST[nproceso]'";
					}
					mysql_query($sqlrsef,$linkbd);
					if (!mysql_query($sqlr,$linkbd))
					{				 
						?><script>
							alert('ERROR EN LA CREACION DEL ANEXO '+<?php echo $sqlr ?>);
						</script><?php
						echo "<div class='inicio'><div class='saludo3'>Error ".mysql_error($linkbd)." <img src='imagenes/alert.png'></div></div>";
					}
					if($cfinaliza==1)
					{
						echo"<script>
							document.getElementById('estsemaforo1').value='3';
							document.getElementById('finaliza').checked=true;
							document.getElementById('finaliza').value=1;
                        </script>";
					}
					else
						
					{?><script>document.getElementById('estsemaforo1').value="2";</script><?php }
					?><script>parent.despliegamodalm('visible','1','<?php echo $mensaje;?>');</script><?php	
					
				}
				//************************************************************************************************
				if($_POST[oculto]==3)
				{
					$conta1=0;
					$conta2=0;
					$linkbd=conectar_bd();
					$sqlr="DELETE FROM contraprocesos_anexos WHERE proceso='$_POST[nproceso]' AND id_fase='1'";
					mysql_query($sqlr,$linkbd);
					for($xy=0;$xy<count($_POST[namearc]);$xy++)
					{
						if($_POST[obliga][$xy]=="S"){$conta1=$conta1+1;}		
						if($_POST[namearc][$xy]!="")
						{
							$sqlr="insert into  contraprocesos_anexos (proceso,id_fase,id_anexo,adjunto,estado) values ('$_POST[nproceso]','1','".$_POST[idanex][$xy]."','".$_POST[namearc][$xy]."','S')";
	   						mysql_query($sqlr,$linkbd);
							if($_POST[obliga][$xy]=="S"){$conta2=$conta2+1;}	
						}
					}
					if($conta1==$conta2)
					{ 
						echo"<script>document.getElementById('estsemaforo2').value='2';</script>";
						$sqlrsef="UPDATE contraestadosemf SET sem1='$_POST[estsemaforo1]',sem2='2',sem3='$_POST[estsemaforo3]', sem4='$_POST[estsemaforo4]' WHERE idcontrato='$_POST[nproceso]'";
					}
					mysql_query($sqlrsef,$linkbd);
					echo"<script>parent.despliegamodalm('visible','1','Se Almacenaron los Anexos Precontractuales con Exito');</script>";
				}
				//************************************************************************************************
				if($_POST[oculto]==4)
				{	
					if($_POST[solcompra]!=""){$solicompra=$_POST[solcompra];}
					else {$solicompra=$_POST[solcomprao];}
					if(isset($_REQUEST['finalizac'])){$cfinalizac=1;}else{$cfinalizac=0;}
					$totalplazo=$_POST[plazoo1]."/".$_POST[plazoo2];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechareg],$fecha);
					$fecharegf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechai],$fecha);
					$fechaif=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechat],$fecha);
					$fechatf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechasus],$fecha);
					$fechasusf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechal],$fecha);
					$fechalf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechacto],$fecha);
					$fechactof=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					if($_POST[estsemaforo3]=="1")
					{
						$sqlr="INSERT INTO contracontrato (id_contrato,numcontrato,vigencia,fecha_registro,rp,contratista,supervisor, valor_contrato,modalidad,submodalidad,tipo_contrato,num_pagos,objeto,realizo,reviso,firmo,regimen_contra,origenppto,fecha_suscripcion, tipo_vincu_super,plazo_ejecu,numero_unidades,anticipo,valor_anticipo,fiducia_anticipo,fecha_inicio,fecha_terminacion,publi_secop, num_acto,fecha_acto,codsolicitud,fechaliquidacion,activo) VALUES ('$_POST[nproceso]','$_POST[ncontra]','$_POST[vigcontra]', '$fecharegf','$_POST[nregpresu]','$_POST[idcontratista]','$_POST[tercero]','$_POST[valcontrao]','$_POST[modalidad]', '$_POST[smodalidad]','$_POST[clasecontrato]','$_POST[npagos]','$_POST[obcontra]','$_POST[realizado]','$_POST[revisado]', '$_POST[firmado]','$_POST[regcontra]','$_POST[origenppto]','$fechasusf','$_POST[tipvinsup]','$totalplazo','$_POST[nunidades]', '$_POST[anticipo]','$_POST[valantio]','$_POST[antificucia]','$fechaif','$fechatf','$_POST[codsecod]','$_POST[numacto]', '$fechactof','$solicompra','$fechalf','$cfinalizac')";$mensaje="Se Almacenaron los Datos del Contrato con Exito";
					}
					else
					{
						$sqlr="UPDATE contracontrato SET numcontrato='$_POST[ncontra]',vigencia='$_POST[vigcontra]',fecha_registro='$fecharegf',rp='$_POST[nregpresu]', contratista='$_POST[idcontratista]',supervisor='$_POST[tercero]', valor_contrato='$_POST[valcontrao]',modalidad='$_POST[modalidad]', submodalidad='$_POST[smodalidad]',tipo_contrato='$_POST[clasecontrato]',num_pagos='$_POST[npagos]',objeto='$_POST[obcontra]', realizo='$_POST[realizado]',reviso='$_POST[revisado]',firmo='$_POST[firmado]',regimen_contra='$_POST[regcontra]', origenppto='$_POST[origenppto]',fecha_suscripcion='$fechasusf', tipo_vincu_super='$_POST[tipvinsup]', plazo_ejecu='$totalplazo',numero_unidades='$_POST[nunidades]',anticipo='$_POST[anticipo]',valor_anticipo='$_POST[valantio]',fiducia_anticipo='$_POST[antificucia]',fecha_inicio='$fechaif',fecha_terminacion='$fechatf',publi_secop='$_POST[codsecod]', num_acto='$_POST[numacto]',fecha_acto='$fechactof',codsolicitud='$solicompra',fechaliquidacion='$fechalf',activo='$cfinalizac' WHERE  id_contrato='$_POST[nproceso]'";$mensaje="Se Modifico los Datos del Contrato con Exito";
					}
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE contraprocesos SET contrato='$_POST[ncontra]' WHERE idproceso='$_POST[nproceso]'";
					mysql_query($sqlr,$linkbd);
					$sqlrsef="UPDATE contraestadosemf SET sem1='$_POST[estsemaforo1]',sem2='$_POST[estsemaforo2]', sem3='2',sem4='$_POST[estsemaforo4]' WHERE idcontrato='$_POST[nproceso]'";
					mysql_query($sqlrsef,$linkbd);
					
					{?><script>document.getElementById('estsemaforo3').value="2";</script><?php }
					?><script>parent.despliegamodalm('visible','1','<?php echo $mensaje;?>');</script><?php				
				}
				//************************************************************************************************
				if($_POST[oculto]==5)
				{
					$conta1=0;
					$conta2=0;
					$linkbd=conectar_bd();
					$sqlr="DELETE FROM contraprocesos_anexos WHERE proceso='$_POST[nproceso]' AND id_fase='2'";
					mysql_query($sqlr,$linkbd);
					for($xy=0;$xy<count($_POST[namearc2]);$xy++)
					{
						if($_POST[obliga2][$xy]=="S"){$conta1=$conta1+1;}		
						if($_POST[namearc2][$xy]!="")
						{
							$sqlr="insert into  contraprocesos_anexos (proceso,id_fase,id_anexo,adjunto,estado) values ('$_POST[nproceso]','2','".$_POST[idanex2][$xy]."','".$_POST[namearc2][$xy]."','S')";
	   						mysql_query($sqlr,$linkbd);
							if($_POST[obliga2][$xy]=="S"){$conta2=$conta2+1;}	
						}
					}
					if($conta1==$conta2)
					{ 
						echo"<script>document.getElementById('estsemaforo4').value='2';</script>";
						$sqlrsef="UPDATE contraestadosemf SET sem1='$_POST[estsemaforo1]',sem2='$_POST[estsemaforo2]', sem3='$_POST[estsemaforo3]',sem4='2' WHERE idcontrato='$_POST[nproceso]'";
					}
					mysql_query($sqlrsef,$linkbd);
					echo"<script>parent.despliegamodalm('visible','1','Se Almacenaron los Anexos de Contratación con Exito');</script>";
				}
				//************************************************************************************************
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