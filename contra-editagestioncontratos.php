<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
	require"comun.inc";
	require"funciones.inc";
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
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
         <script>
			function verpaa(){
				despliegamodalm2('visible','1');
			}
			function vercdp(){
				despliegamodalm2('visible','2');
			}
			function verbanco(){
				despliegamodalm2('visible','3');
			}
			function verestudios(){
				despliegamodalm2('visible','4');
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
					case "1":
						if (document.form2.fecha.value!='' && document.form2.modalidad.value!=''  && document.form2.smodalidad.value!=''  && document.form2.clasecontrato.value!='')
						{
							if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="2";document.form2.submit();}
						}
						else
						{
							alert('Faltan datos para completar el registro');
							document.form2.estado.focus();
							document.form2.estado.select();
						}
						break;
					case "2":
						if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="3";document.form2.submit();}
						break;
					case "3":
						if (document.form2.vigcontra.value!='')
						{
							if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="4";document.form2.submit();}
						}
						else
						{
							alert('Faltan datos para completar el registro');
							document.form2.estado.focus();
							document.form2.estado.select();
						}
						break;
					case "4":
						if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="5";document.form2.submit();}
						break;
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
					case "1":
						document.getElementById('botguardar').value="1";break;
					case "2":
						document.getElementById('botguardar').value="2";break;
					case "3":
						document.getElementById('botguardar').value="3";break;
					case "4":
						document.getElementById('botguardar').value="4";break;
				}
				
			}
			function validar2(_tip)
			{
				switch(_tip)
				{
					case "anti":
						var anticipo=document.getElementById('anticipo').value;
						if(anticipo=="n")
						{
							document.getElementById('valacti').value="disabled";
							document.getElementById('valantio').value=0;
							
						}
						else{document.getElementById('valacti').value="";}
						break;
					case "datanti":
						document.getElementById('valantio').value=document.getElementById('valanti').value;
						break;
					case "vplazo":
						if(document.getElementById('plazo').value!="")
						{document.getElementById('plazoo').value=document.getElementById('plazo').value;}
						break;
					case "vunidades":
						if(document.getElementById('nunidadesv').value!="")
						{document.getElementById('nunidades').value=document.getElementById('nunidadesv').value;}
						break;
					case "vvalcontra":
						if(document.getElementById('valcontra').value!="")
						{document.getElementById('valcontrao').value=document.getElementById('valcontra').value;}
						break;
					case "vpagos":
						if(document.getElementById('npagosv').value!="")
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
						case "1":
							document.getElementById('ventana1').src="contra-gestioncontratosterceros.php";break;
						case "2":
							var direcc="contra-gestioncontratosempleados.php?ind="+_pro;
							document.getElementById('ventana1').src=direcc;break;
					}
				}
			}
			function despliegamodalm(_valor,_tip,mensa)
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
			function despliegamodalm2(_valor,_tip)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				var solicitud=document.getElementById("solcompra").value;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventana2').src="contra-verpaa.php?solicitud="+solicitud;break;
						case "2":	document.getElementById('ventana2').src="contra-vercdp.php?solicitud="+solicitud;break;
						case "3":	document.getElementById('ventana2').src="contra-verbanco.php?solicitud="+solicitud;break;
						case "4":	document.getElementById('ventana2').src="contra-verestudios.php?solicitud="+solicitud;break;
					}
				}
			}
			function funcionmensaje(){document.form2.submit();}
			jQuery(function($){ $('#valcontra').autoNumeric('init');});
			jQuery(function($){ $('#valanti').autoNumeric('init');});
		</script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
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
		
		
		.c3 input[type="checkbox"]:not(:checked),
		.c3 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c3 input[type="checkbox"]:not(:checked) +  #t3,
		.c3 input[type="checkbox"]:checked +  #t3 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c3 input[type="checkbox"]:not(:checked) +  #t3:before,
		.c3 input[type="checkbox"]:checked +  #t3:before {
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
		.c3 input[type="checkbox"]:not(:checked) +  #t3:after,
		.c3 input[type="checkbox"]:checked + #t3:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c3 input[type="checkbox"]:not(:checked) +  #t3:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c3 input[type="checkbox"]:checked +  #t3:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c3 input[type="checkbox"]:disabled:not(:checked) +  #t3:before,
		.c3 input[type="checkbox"]:disabled:checked +  #t3:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c3 input[type="checkbox"]:disabled:checked +  #t3:after {
		  color: #999 !important;
		}
		.c3 input[type="checkbox"]:disabled +  #t3 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c3 input[type="checkbox"]:checked:focus + #t3:before,
		.c3 input[type="checkbox"]:not(:checked):focus + #t3:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c3 #t3:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t3{
			background-color: white !important;
		}
		
		
		
		
		.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 80%;
	margin:3% auto 3% auto;
	}

	.card:hover {
		box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
	}
	
	.card .head{
		 transition: 1s;
	}
	
	.card:hover .head{
		background-color:gray;
	}
	
	.container {
		padding: 2px 16px;
		background-color: #009688 !important;
		color:white;
	}
		.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 6px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 6px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
}

.button1 {
    background-color: white; 
    color: black; 
    border: 2px solid #4CAF50;
	font-weight:bold;
	
}

.button1:hover {
    background-color: #4CAF50;
    color: white;
}
.animarimg{
	width:0px;
	height:0px;
	z-index:999999;
	position:absolute;
	top:100px;
	-webkit-transition: all 2s;
	-moz-transition:all 2s;
	transition: all 3s;
}
.card:hover .animarimg{
	width:100px;
	height: 70px;
	transform: rotate(360deg);
}
		</style>
        <?php 
			titlepag();
			
			function validacion01()
			{
				if(($_POST[modalidad]!="") && ($_POST[smodalidad]!="")){$val01="";}
				else{
					$val01="disabled";
					}
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
		?>
	</head>
    <body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table> 
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
            <tr>
  				<td colspan="3" class="cinta">
					<a href="contra-gestioncontratos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"  border="0" /></a>
					<a id="bguardar" href="#" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" /></a>
					<a href="contra-buscagestioncontratos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
					<a href="#" id="impre" class="mgbt"><img src="imagenes/print_off.png" alt="Imprimir" style="width:30px;"/></a>
					<a href="contra-buscagestioncontratos.php"  class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
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
				if(($_POST[estsemaforo3]=="3")||($_POST[estsemaforo3]=="2"))
				{
					if(isset($_REQUEST['finalizac'])){$_POST[estsemaforo3]="3";$_POST[blgeneralc1]="readonly";$_POST[blgeneralc2]="disabled";}
					else{$_POST[estsemaforo3]="2";$_POST[blgeneralc1]="";$_POST[blgeneralc2]="";}
				}
				//**************************************************************************************
				$linkbd=conectar_bd(); 
				
				if($_POST[oculto]=="")
				{
					$_POST[nproceso]=$_GET[idproceso];
					$sqlr="select * from contraprocesos WHERE idproceso='$_POST[nproceso]'";
					$row=mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$sqlrsf="SELECT * FROM contraestadosemf where idcontrato='$_POST[nproceso]'";
					$rowsf =mysql_fetch_row(mysql_query($sqlrsf,$linkbd));	 
					$_POST[estsemaforo1]=$rowsf[1];	
					$_POST[estsemaforo2]=$rowsf[2];	
					$_POST[estsemaforo3]=$rowsf[3];	
					$_POST[estsemaforo4]=$rowsf[4];	
					$_POST[pesactiva]="1";
					$_POST[fecha]=$row[1];
					$_POST[vigencia]=$row[2];
					$_POST[solcompra]=$row[12];
					$_POST[solcomprao]=$row[12];
					$_POST[finaliza]=$row[13];
					if($_POST[finaliza]==1){$_POST[blgeneral1]="readonly";$_POST[blgeneral2]="disabled";}
					else {$_POST[blgeneral1]="";$_POST[blgeneral2]="";}
					$_POST[modalidad]=$row[4];
					$_POST[smodalidad]=$row[5];
					$_POST[clasecontrato]=$row[6];
					$_POST[ocultoa1]="2";
					$sqlrct="select * from contracontrato WHERE id_contrato='$_POST[nproceso]'";
					$rowct=mysql_fetch_row(mysql_query($sqlrct,$linkbd));
					$_POST[ncontra]=$rowct[1];
					if($rowct[2]==""){$_POST[vigcontra]=$row[2];}
					else{$_POST[vigcontra]=$rowct[2];}
					$_POST[fechareg]=$rowct[3];
					$_POST[fechai]=$rowct[26];
					$_POST[fechat]=$rowct[27];
					$duraciones=explode('/', $rowct[21]);
					if ($duraciones[0]==""){$_POST[plazoo1]=0;}
					else{$_POST[plazoo1]=$duraciones[0];}
					if ($duraciones[1]==""){$_POST[plazoo2]=0;}
					else{$_POST[plazoo2]=$duraciones[1];}
					$_POST[idcontratista]=$rowct[5];
					$_POST[ncontratista]=buscatercero($_POST[idcontratista]);
					$_POST[origenppto]=$rowct[17];
					$_POST[fechasus]=$rowct[19];
					$_POST[tipvinsup]=$rowct[20];
					$_POST[nunidades]=$rowct[22];
					$_POST[valcontrao]=$rowct[7];
					$_POST[valcontra]=$rowct[7];
					$_POST[val_cuota]=$rowct[34];
					$_POST[fechal]=$rowct[32];
					$_POST[npagos]=$rowct[11];
					$_POST[anticipo]=$rowct[23];
					$_POST[valanti]=$rowct[24];
					$_POST[valantio]=$rowct[24];
					$_POST[antificucia]=$rowct[25];
					$_POST[codsecod]=$rowct[28];
					$_POST[numacto]=$rowct[29];
					$_POST[fechacto]=$rowct[30];
					$_POST[tercero]=$rowct[6];
					$_POST[realizado]=$rowct[13];
					$_POST[revisado]=$rowct[14];
					$_POST[firmado]=$rowct[15];
					$_POST[regcontra]=$rowct[16];
					$nresul=buscatercerod($_POST[tercero]);
					$_POST[ntercero]=$nresul[0];
					$_POST[dependencia]=$nresul[1];
					$_POST[iddependencia]=$nresul[2];
					$nresul=buscatercerod($_POST[realizado]);
					$_POST[nrealizado]=$nresul[0];
					$_POST[drealizado]=$nresul[1];
					$_POST[idrealizado]=$nresul[2];
					$nresul=buscatercerod($_POST[revisado]);
					$_POST[nrevisado]=$nresul[0];
					$_POST[drevisado]=$nresul[1];
					$_POST[idrevisado]=$nresul[2];
					$nresul=buscatercerod($_POST[firmado]);
					$_POST[nfirmado]=$nresul[0];
					$_POST[dfirmado]=$nresul[1];
					$_POST[idfirmado]=$nresul[2];
					$_POST[finalizac]=$rowct[33];
					if($_POST[finalizac]==1){$_POST[blgeneralc1]="readonly";$_POST[blgeneralc2]="disabled";}
					else {$_POST[blgeneralc1]="";$_POST[blgeneralc2]="";}
					$rutax="informacion/gestion_contratos/".$_POST[vigencia];
					$ruta="informacion/gestion_contratos/".$_POST[vigencia]."/".$_POST[nproceso];
					$_POST[rutaad]=$ruta."/";
					$_POST[botguardar]="1";
					if($_POST[anticipo]=="s"){$_POST[valacti]="";}
					else{$_POST[valacti]="disabled";}
					
					$_POST[oculto]="0";	
					?><script> </script> <?php	
				}
				else
				{if($_POST[estsemaforo1]=="0"){$_POST[estsemaforo1]="1";}}
				
				if(($_POST[pesactiva]=="3")||($_POST[solcompra]!="")){if($_POST[estsemaforo3]=="0"){$_POST[estsemaforo3]="1";}}
				switch($_POST[estsemaforo1])
				{
					case "0":
						$p1luzcem1=$cmrojo;$p1luzcem2=$cmoff;$p1luzcem3=$cmoff;
						break;
					case "1":
					case "2":
						$p1luzcem1=$cmoff;$p1luzcem2=$cmamarillo;$p1luzcem3=$cmoff;
						break;
					case "3":
					$p1luzcem1=$cmoff;$p1luzcem2=$cmoff;$p1luzcem3=$cmverde;
						break;
				}
				switch($_POST[estsemaforo2])
				{
					case "0":
						$p2luzcem1=$cmrojo;$p2luzcem2=$cmoff;$p2luzcem3=$cmoff;
						break;
					case "1":
						$p2luzcem1=$cmoff;$p2luzcem2=$cmamarillo;$p2luzcem3=$cmoff;
						break;
					case "2":
					$p2luzcem1=$cmoff;$p2luzcem2=$cmoff;$p2luzcem3=$cmverde;
						break;
				}
				switch($_POST[estsemaforo3])
				{
					case "0":
						$p3luzcem1=$cmrojo;$p3luzcem2=$cmoff;$p3luzcem3=$cmoff;
						break;
					case "1":
					case "2":
						$p3luzcem1=$cmoff;$p3luzcem2=$cmamarillo;$p3luzcem3=$cmoff;
						break;
					case "3":
					$p3luzcem1=$cmoff;$p3luzcem2=$cmoff;$p3luzcem3=$cmverde;
						break;
				}
				switch($_POST[estsemaforo4])
				{
					case "0":
						$p4luzcem1=$cmrojo;$p4luzcem2=$cmoff;$p4luzcem3=$cmoff;
						break;
					case "1":
						$p4luzcem1=$cmoff;$p4luzcem2=$cmamarillo;$p4luzcem3=$cmoff;
						break;
					case "2":
					$p4luzcem1=$cmoff;$p4luzcem2=$cmoff;$p4luzcem3=$cmverde;
						break;
				}				
				//*****************************************************************
				switch($_POST[pesactiva])
					{
						case "1":
							$check1="checked";$check2="";$check3="";$check4="";break;
						case "2":
							$check1="";$check2="checked";$check3="";$check4="";break;
						case "3":
							$check1="";$check2="";$check3="checked";$check4="";break;
						case "4":
							$check1="";$check2="";$check3="";$check4="checked";break;
					}
				//*****************************************************************
				if ($_POST[solcompra]!="")
				{
					$sqlr="SELECT * FROM contrasoladquisiciones WHERE codsolicitud='".$_POST[solcompra]."'";
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
					$sqlrcdp="select distinct * from pptocdp where pptocdp.vigencia='".$row[9]."' and pptocdp.consvigencia='".$row[6]."' ";
					$cont=0;
					$rowcdp=mysql_fetch_row(mysql_query($sqlrcdp,$linkbd)); 
					$_POST[numerocdp]=$rowcdp[2];
					$modfecha1=date("d-m-Y",strtotime($rowcdp[3]));
					$_POST[fechacdp]= $modfecha1;
					$_POST[estadocdp]= $rowcdp[5];
					switch($rowcdp[5])
					{
						case "S":
							$_POST[estadoccdp]='DISPONIBLE';  ;break;
						case "C":
							$_POST[estadoccdp]='CON REGISTRO';break;
						case "N":
							$_POST[estadoccdp]='ANULADO';break;
					}
					$sqlrrp="SELECT consvigencia,valor FROM pptorp WHERE idcdp='".$rowcdp[2]."' AND vigencia='".$row[9]."'";
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
					$sqlr3="SELECT * FROM contrasoladquisicionesgastos WHERE codsolicitud='".$_POST[solcompra]."'";
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
						?><script>despliegamodalm('visible','2','Documento Supervisor Incorrecto o no Existe');document.form2.tercero.focus();</script><?php
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
						?><script>despliegamodalm('visible','2','Documento Incorrecto o no Existe');document.form2.realizado.focus();</script><?php
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
						?><script>despliegamodalm('visible','2','Documento Incorrecto o no Existe');document.form2.realizado.focus();</script><?php
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
						?><script>despliegamodalm('visible','2','Documento Incorrecto o no Existe');document.form2.realizado.focus();</script><?php
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
						?><script>despliegamodalm('visible','2','Documento Contratista Incorrecto o no Existe');document.form2.idcontratista.focus();</script><?php
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
				
			?> 
            <input type="hidden" name="botguardar" id="botguardar" value="<?php echo $_POST[botguardar];?>">
 			<input type="hidden" name="blgeneral1" id="blgeneral1" value="<?php echo $_POST[blgeneral1];?>">
            <input type="hidden" name="blgeneral2" id="blgeneral2" value="<?php echo $_POST[blgeneral2];?>">
            <input type="hidden" name="blgeneralc1" id="blgeneralc1" value="<?php echo $_POST[blgeneralc1];?>">
            <input type="hidden" name="blgeneralc2" id="blgeneralc2" value="<?php echo $_POST[blgeneralc2];?>">
            <input type="hidden" name="finfasblo" id="finfasblo" value="<?php echo $_POST[finfasblo];?>">
            <input type="hidden" name="finfasbloc" id="finfasbloc" value="<?php echo $_POST[finfasbloc];?>">
            <input type="hidden" name="actachivo" id="actachivo" value="<?php echo $_POST[actachivo];?>">
            <input type="hidden" name="ocultoa1" id="ocultoa1" value="1" >
            <div class="tabscontra" style="height:73%;">
            	<div class="tab"> 
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> onClick="cambiobotones('1'); cambiopestanas('1');">
               		<label for="tab-1"><img src="<?php echo $p1luzcem1;?>" width="16" height="16"><img src="<?php echo $p1luzcem2;?>" width="16" height="16"><img src="<?php echo $p1luzcem3;?>" width="16" height="16"> Datos Prescontractuales</label>
 					<div class="content" style="overflow-x:hidden">
                        <table class="inicio" align="center">
                            <tr>
                                <td class="titulos" style="width:93%" colspan="12">Datos Precontractuales </td>
                                <td class="cerrar" style="width:7%"><a href="contra-principal.php">Cerrar</a></td>
                            </tr>
                            <tr>
                                
                                <td class="saludo1" style="width:10%" >No Proceso:</td>
                                <td style="width:10%"><input style="width:100%" name="nproceso" type="text"  value="<?php echo $_POST[nproceso]?>" onKeyUp="return tabular(event,this)" readonly ></td>
                              <td class="saludo1" style="width:7%;" >Vigencia:</td>
                                <td style="width:8%;"><input type="text" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:100%" readonly> </td>  
                                <td class="saludo1" >Fecha:</td>
                                <td>
								<input name="fecha" id="fecha" type="text" title="DD/MM/YYYY" style="width:30%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								</td> 
                                <td >
									<td class="saludo1" <?php if($_POST[blgeneralc2]!=""){echo "style=\"display:none;\"";}?>>Finalizar Fase:</td>
                                <td <?php if($_POST[blgeneralc2]!=""){echo "style=\"display:none;\"";}?>>
									<div class="c1"><input type="checkbox" id="finaliza" name="finaliza" <?php if(isset($_REQUEST['finaliza'])){echo "checked";}elseif($_POST[finaliza]==1) {echo "checked";} ?> value="<?php echo $_POST[finaliza]?>"  <?php echo $_POST[finfasblo];?> onChange="validar();" /><label for="finaliza" id="t1" ></label></div>																	
                                </td> 
                                <td class="saludo1" <?php if($_POST[blgeneralc2]==""){echo "style=\"display:none;\"";}?>>Finalizar Fase:</td>
                                <td <?php if($_POST[blgeneralc2]==""){echo "style=\"display:none;\"";}?>>
                                   	<div class="c3"><input type="checkbox" id="finalx" name="finalx"  checked disabled /><label for="finalx" id="t3" ></label></div>																	
                                </td> 
                                </td> 
								
                             
                            </tr>
                            <tr>
                                <td class="saludo1">Solicitud:</td>
                                <td>
                                	<input type="hidden" name="solcomprao" id="solcomprao" value="<?php if($_POST[solcompra]!=""){echo $_POST[solcompra];} else {$_POST[solcompra]=$_POST[solcomprao];echo $_POST[solcomprao];}?>">
                                    <select name="solcompra" id="solcompra" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%" <?php echo $_POST[blgeneral2];?>>
                                        <option value="">Seleccione....</option>
                                        <?php
                                            $sqlr="SELECT contrasoladquisiciones.codsolicitud FROM contrasoladquisiciones WHERE activo=1   ORDER BY contrasoladquisiciones.codsolicitud";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                $i=$row[0];
                                                echo "<option value=$row[0] ";                                                
                                                if(0==strcmp($i,$_POST[solcompra])){echo "SELECTED"; $_POST[codigot]=$row[0];}
                                                echo ">".$row[0]."</option>";	 	 
                                            }	 	
                                        ?>
                                    </select>
                                </td>           
                                <td class="saludo1">Objeto:</td>
                                <td colspan="12" ><input style="width:100%" name="concepto" type="text" value="<?php echo $_POST[concepto]?>" onKeyUp="return tabular(event,this)" readonly></td>
                            </tr>  
                        </table>
                        <div class="subpantalla" style="height:22%; width:99.5%; margin-top:0px; overflow-x:hidden">
                            <table class="inicio" style="width:100%">
                                <tr>
                                    <td class="titulos2" style="width:10%">Documento</td>
                                    <td class="titulos2" style="width:45%">Nombre</td>
                                    <td class="titulos2" style="width:45%">Dependencia</td>
                                </tr>
                                <?php
                                    $iter='saludo1';
                                    $iter2='saludo2';
                                    for ($x=0;$x<count($_POST[sdocumento]);$x++)
                                    {		 
                                        echo "
                                            <tr class='$iter'>
                                                <td><input class='inpnovisibles' name='sdocumento[]' value='".$_POST[sdocumento][$x]."' type='text' readonly style='width:100%'></td>
                                                <td><input class='inpnovisibles' name='snombre[]'  value='".$_POST[snombre][$x]."' type='text' style=\"width:100%\" readonly style='width:100%'></td>
                                                <td><input class='inpnovisibles' name='sndependencia[]' value='".$_POST[sndependencia][$x]."' type='text' readonly style='width:100%'><input name='sidependencia[]' value='".$_POST[sidependencia][$x]."' type='hidden'></td>
                                            </tr>";	
                                        $aux=$iter;
                                        $iter=$iter2;
                                        $iter2=$aux;
                                    }	
                                ?>
                            </table>
						</div>
                        <table class="inicio">
                            <tr>
                                <td class="saludo1">Modalidad:</td>
                                <td colspan="2">
                                <input type="hidden" name="modaux" id="modaux" value="<?php if($_POST[modalidad]!=""){echo $_POST[modalidad];} else {$_POST[modalidad]=$_POST[modaux];echo $_POST[modaux];}?>">
                                    <select name="modalidad" id="modalidad" onKeyUp="return tabular(event,this)" onChange="validar1()" style="width:90%" <?php echo $_POST[blgeneral2];?>>
                                        <option  value="" >Seleccione....</option>
                                        <?php
                                            $sqlr="SELECT * FROM dominios where nombre_dominio='MODALIDAD_SELECCION' and (valor_final is NULL or valor_final='')";
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
                                <td class="saludo1">Procedimiento:</td>
                                <td  colspan="2"> 
                                	<input type="hidden" name="proaux" id="proaux" value="<?php if($_POST[smodalidad]!=""){echo $_POST[smodalidad];} else {$_POST[smodalidad]=$_POST[proaux];echo $_POST[proaux];}?>">
                                    <select style="width:100%" name="smodalidad" id="smodalidad" onKeyUp="return tabular(event,this)" onChange="validar1()" <?php echo $_POST[blgeneral2];?>>
                                        <option  value="" >Seleccione....</option>
                                        <?php
                                            $sqlr="SELECT * FROM dominios where nombre_dominio='MODALIDAD_SELECCION' and valor_final = '$_POST[modalidad]'";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($rowEmp = mysql_fetch_row($res)) 
                                            {
                                                echo "<option value= ".$rowEmp[0];
                                                $i=$rowEmp[0];
                                                if($i==$_POST[smodalidad]){echo "  SELECTED";}
                                                echo ">".$rowEmp[0]." - ".$rowEmp[2]."</option>";	 	 
                                            }	
                                        ?> 
                                    </select>
                                </td>
                                <td class="saludo1">Clase de Contrato:</td>
                                <td colspan="2"> 
                                	<input type="hidden" name="claaux" id="claaux" value="<?php if($_POST[clasecontrato]!=""){echo $_POST[clasecontrato];} else {$_POST[clasecontrato]=$_POST[claaux];echo $_POST[claaux];}?>">
                                    <select name="clasecontrato" id="clasecontrato" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:90%" <?php echo $_POST[blgeneral2];?>>
                                        <option  value="" >Seleccione....</option>
                                        <?php
                                            $sqlr="SELECT * FROM contraclasecontratos where estado = 'S'";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($rowEmp = mysql_fetch_row($res)) 
                                            {
                                                echo "<option value= ".$rowEmp[0];
                                                $i=$rowEmp[0];
                                                if($i==$_POST[clasecontrato])
                                                {
                                                    echo "  SELECTED";
                                                    if ($rowEmp[5]!=""){$_POST[fmtmoda]=$rowEmp[4];}
                                                    else{$_POST[fmtmoda]="";}
                                                }
                                                echo ">".$rowEmp[0]." - ".$rowEmp[1]."</option>";	 	 
                                            }	
                                        ?> 
                                     </select> 
                                    <input type="hidden" name="fmtmoda" value="<?php echo $_POST[fmtmoda] ?>">
                                </td>
                                <td class="saludo1">Plantilla Contrato:</td>
                                <td colspan="3">
                                    <?php
                                        if($_POST[fmtmoda]!="")
                                        {$ruta="informacion/plantillas_contratacion/$_POST[fmtmoda]";$nomdesc=$ruta;}				
                                        else{$ruta="#";$nomdesc="No hay Plantilla Disponible";}
                                        if ($_POST[fmtmoda]!=""){echo '<a href="'.$ruta.'" target="_blank" ><img src="imagenes/descargar.png" title="(Descargar)">'.traeico($_POST[fmtmoda]).'</a>';}
                                        else{echo'<img src="imagenes/descargard.png" title="(Plantilla No Disponible)">';}
                                    ?>	
                                </td>
                             </tr>  
                             <tr>
								<td class="saludo1">Regimen:</td>
                                <td><input type="text" name="regcontra" id="regcontra" value="<?php echo $_POST[regcontra];?>" style="width:91%" readonly></td>
                             </tr>               
                        </table>
                        <?php
						//**** busca cuenta
							if($_POST[bc]!='')
							{
								$tipo=substr($_POST[cuenta],0,1);			
								$nresul=buscacuentapres($_POST[cuenta],$tipo);			
								if($nresul!='')
								{
									$_POST[ncuenta]=$nresul;
									$linkbd=conectar_bd();
									$sqlr="select *from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or   vigenciaf=$vigusu)";
									$res=mysql_query($sqlr,$linkbd);
									$row=mysql_fetch_row($res);
									$_POST[valor]=0;		  
									$_POST[saldo]=$row[6];	
									$ind=substr($_POST[cuenta],0,1);			
									if($ind=='R' || $ind=='r')
									{						
										$ind=substr($_POST[cuenta],1,1);	
										$criterio="and (pptocuentaspptoinicial.vigencia=".$vigusu." or  pptocuentaspptoinicial.vigenciaf=$vigusu) AND (pptocuentas.vigencia=".$vigusu." or  pptocuentas.vigenciaf=$vigusu)";					
									}
									else
									{$criterio=" and pptocuentaspptoinicial.vigencia=".$vigusu." AND  pptocuentas.vigencia=".$vigusu."";}
									if ($ind=='2')
									{
										$sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldos,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
										$_POST[tipocuenta]=2;
									}
									if ($ind=='3' || $ind=='4')
									{
										$sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldos,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
										$_POST[tipocuenta]=$ind;
									}
									$res=mysql_query($sqlr,$linkbd);
									$row=mysql_fetch_row($res);
									if($row[1]!='' || $row[1]!=0)
									{
										$_POST[cfuente]=$row[0];
										$_POST[fuente]=$row[2];
										$_POST[valor]=0;			  
										$_POST[saldo]=$row[1];			  
								   }
								   else
								   {
										$_POST[cfuente]="";
										$_POST[fuente]=""; 
								   }  
								}
								else
								{
									$_POST[ncuenta]="";	
									$_POST[fuente]="";				   
									$_POST[cfuente]="";				   			   
									$_POST[valor]="";
									$_POST[saldo]="";
								}
							}
						?>
                        <table class="inicio" align="center" width="90%" >
						<tr>
						<td width="25%">
						<div class="card">
						  <div class="head">
						<img src="imagenes/planear.png" alt="Avatar" style="width:100%; height: 150px">
						<img src="imagenes/siglas.png" class="animarimg">
						</div>
						  <div class="container">
							<h4 style="display: inline-block;"><b>PLAN ANUAL</b></h4> 
							<button type="button" class="button button1" onClick="verpaa()" >VER</button>
						  </div>
						</div>
						</td>
						<td width="25%">
						<div class="card">
						 <div class="head">
						<img src="imagenes/cdp.png" alt="Avatar" style="width:100%; height: 150px">
						<img src="imagenes/siglas.png" class="animarimg">
						</div>
						  <div class="container" >
							<h4 style="display: inline-block;"><b>DISPONIBILIDAD</b></h4> 
							<button type="button" class="button button1" onClick="vercdp()" >VER</button>
						  </div>
						</div>
						</td>
						<td width="25%">
						<div class="card">
						<div class="head">
						<img src="imagenes/project.png" alt="Avatar" style="width:100%; height: 150px">
						<img src="imagenes/siglas.png" class="animarimg">
						</div>
						  
						  <div class="container">
							
							<h4 style="display: inline-block;"><b>PROYECTO</b></h4> 
							<button type="button" class="button button1" onClick="verbanco()" >VER</button>
						
						  </div>
						</div>
						</td>
						<td width="25%">
						<div class="card">
						<div class="head">
						<img src="imagenes/analisis.png" alt="Avatar" style="width:100%; height: 150px">
						<img src="imagenes/siglas.png" class="animarimg">
						</div>
						  
						  <div class="container">
							
							<h4 style="display: inline-block;"><b>EST.PREVIOS/SECTOR</b></h4> 
							<button type="button" class="button button1" onClick="verestudios()" >VER</button>
						
						  </div>
						</div>
						</td>
						</tr>
						</table>
                    </div>
                </div>
            	 <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> onClick="cambiobotones('2'); cambiopestanas('2');" <?php $val01=validacion01();echo $val01; ?> >
                    <label for="tab-2"><img src="<?php echo $p2luzcem1;?>" width="16" height="16"><img src="<?php echo $p2luzcem2;?>" width="16" height="16"><img src="<?php echo $p2luzcem3;?>" width="16" height="16"> Anexos Precontractuales</label>	
                    <div class="content">						
						<?php
							//************************************************************************************************
							if (is_uploaded_file($_FILES['uploads']['tmp_name'][$_POST[actachivo]]))  
							{
								if ($_POST[namearc][$_POST[actachivo]]!="")
								{
									$nomar=$_POST[rutaad].$_POST[namearc][$_POST[actachivo]];
									unlink($nomar);	
								}
								$_POST[namearc][$_POST[actachivo]]=$_FILES['uploads']['name'][$_POST[actachivo]];
								$nomar=$_FILES['uploads']['name'][$_POST[actachivo]];
								copy($_FILES['uploads']['tmp_name'][$_POST[actachivo]], $_POST[rutaad].$nomar);	
							}
							//**************************************************************************************
							if($_POST[ocultoa1]=="2")
							{
								$_POST[namearc]=array(); 
								$_POST[idanex]=array();
                                $_POST[nanex]=array();
								$_POST[obliga]=array();
                                $sqlr="SELECT contramodalidadanexos.idanexo,contraanexos.nombre, contramodalidadanexos.obligatorio  FROM contramodalidadanexos, contraanexos where contramodalidadanexos.idmodalidad = '$_POST[modalidad]' and contramodalidadanexos.idpadremod = '$_POST[smodalidad]' and contramodalidadanexos.fase='1' and contramodalidadanexos.idanexo=contraanexos.id";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_row($res)) 
								{	
									$sqlrda1="SELECT adjunto FROM contraprocesos_anexos WHERE proceso='$_POST[nproceso]' AND id_fase='1' AND id_anexo='$rowEmp[0]'";
									$rowda1=mysql_fetch_row(mysql_query($sqlrda1,$linkbd));
									if ($rowda1!=""){$_POST[namearc][]=$rowda1[0];}
									else{$_POST[namearc][]="";}
								$_POST[idanex][]=$rowEmp[0];
								$_POST[nanex][]=$rowEmp[1];
								$_POST[obliga][]=$rowEmp[2];
								}
							}
						?>							
                        <table class="inicio">
                            <tr><td class="titulos" colspan="4">Anexos Precontractuales</td></tr>
                            <tr>
                                <td class="saludo1">Modalidad</td>
                                <td> 
                                    <select name="modalidadv" id="modalidadv" disabled >
                                    	<option  value="" >Seleccione....</option>
                                   	 	<?php
											$sqlr="SELECT * FROM dominios where nombre_dominio='MODALIDAD_SELECCION' ";
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
									for($xy=0;$xy<count($_POST[namearc]);$xy++)
									{
										$cont1=$xy+1;
										 echo "
										 <tr class='$fila'>
										 	<td>$cont1</td>
											<td style='width:10%'><input type='text' class='inpnovisibles' name='idanex[]' style='width:95%' value='".$_POST[idanex][$xy]."' readonly></td>
											<td style='width:30%'><input type='text' class='inpnovisibles' name='nanex[]' style='width:95%' value='".$_POST[nanex][$xy]."' readonly></td>
											<td style='width:40%'>
												<input type='text' name='namearc[]' style='width:95%' value='".$_POST[namearc][$xy]."' readonly>
												<div class='custom-input-file'>";
												if($_POST[blgeneral1]=="")
												{ 
													echo "
													<input class='input-file' style='width:5%' type='file' name='uploads[]'  onClick='valnumarchivo($xy);' onchange='validar();'><img src='imagenes/attach.png'>";
												}
												else
												{echo "<img src='imagenes/attach.png'> ";}
										echo"		
												</div>
											</td>
											<td><input type='text' class='inpnovisibles' name='obliga[]' style='width:95%' value='".$_POST[obliga][$xy]."' readonly></td>
										</tr>";
										$aux=$fila; 
										$fila=$fila2;
										$fila2=$aux;
									}
								?>
                   		</table>
                	</div>
               </div>  
               <div class="tab">
                   <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> onClick="cambiobotones('3'); cambiopestanas('3');  ">
                   <label for="tab-3"><img src="<?php echo $p3luzcem1;?>" width="16" height="16"><img src="<?php echo $p3luzcem2;?>" width="16" height="16"><img src="<?php echo $p3luzcem3;?>" width="16" height="16"> Datos Contrataci&oacute;n</label>
                   <div class="content">
						<table class="inicio">
							<tr>
                                <td class="titulos" style="width:90%" colspan="10">Datos Contrataci&oacute;n </td>
                                <td class="cerrar" style="width:10%"><a href="contra-principal.php">Cerrar</a></td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:12%">Vigencia:</td>
                                <td style="width:12%"><input type="text" name="vigcontra" id="vigcontra" value="<?php echo $_POST[vigcontra];?>" style="width:85%" readonly></td>
                                <td class="saludo1" style="width:13%">N&deg; Contrato:</td>
                                <td style="width:12%"><input type="text" name="ncontra" id="ncontra" value="<?php echo $_POST[ncontra];?>" style="width:85%" <?php echo $_POST[blgeneralc1];?>></td>
                               
                                <td class="saludo1" style="width:13%">Fecha Registro:</td>
                                <td style="width:12%">
								<input name="fechareg" id="fechareg" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechareg]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechareg');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								</td>
                                <td class="saludo1" style="width:6%">Finalizar Fase:</td>
                                <td style="width:10%">
                               																
								   <div class="c2"><input type="checkbox" id="finalizac" name="finalizac" <?php if(isset($_REQUEST['finalizac'])){echo "checked";}elseif($_POST[finalizac]==1) {echo "checked";} ?> value="<?php echo $_POST[finalizac]?>"  <?php echo $_POST[finfasbloc];?> onChange="validar();" /><label for="finalizac" id="t2" ></label></div>																	
								</td>  
                            </tr>
                            <tr>
                            	<td class="saludo1" >Fecha Inicio:</td>
                                <td>
								<input name="fechai" id="fechai" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechai]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechai');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								
								</td>
                                <td class="saludo1" >Fecha Terminaci&oacute;n:</td>
                                <td>
								<input name="fechat" id="fechat" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechat]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechat');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								
								</td>
                                <td class="saludo1">Plazo:</td>
                                <td title="Meses" colspan="3">
                                	D&iacute;as:<input type="text" name="plazoo1" id="plazoo1" value="<?php echo $_POST[plazoo1]?>" style="width:20%;text-align:right;"   onKeyPress="javascript:return solonumeros(event)" onFocus="<?php if ($_POST[blgeneralc1]==""){echo "document.getElementById('plazoo1').value='';";}?>" <?php echo $_POST[blgeneralc1];?>>&nbsp;
                                    Meses:<input type="text" name="plazoo2" id="plazoo2" value="<?php echo $_POST[plazoo2]?>" style="width:20%;text-align:right;"   onKeyPress="javascript:return solonumeros(event)" onFocus="<?php if ($_POST[blgeneralc1]==""){echo "document.getElementById('plazoo2').value='';";}?>" <?php echo $_POST[blgeneralc1];?>>
                                </td>
                            </tr>
                            <tr>
                                <td class="saludo1">Objeto:</td>
                                <td colspan="7"><input type="text" name="obcontra" id="obcontra" value="<?php echo $_POST[obcontra];?>" style="width:100%" <?php echo $_POST[blgeneralc1];?>></td>
                            </tr>
                            <tr>
                                <td class="saludo1" >Contratista:</td>
                                <td>
                                    <input type="text" name="idcontratista" id="idcontratista" value="<?php echo $_POST[idcontratista]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="<?php if($_POST[blgeneralc1]==""){ echo "bcontratis(event);";}?>" <?php echo $_POST[blgeneralc1];?>>
                                    <a href="#" onClick="despliegamodal('visible','1');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                                </td>
                                <td colspan="6"><input type="text" name="ncontratista" id="ncontratista" value="<?php echo $_POST[ncontratista]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                            </tr>
                            <tr>
                            	<td class="saludo1">Reg. Presupuestal:</td>
                                <td><input type="text" name="nregpresu" id="nregpresu" value="<?php echo $_POST[nregpresu];?>" style="width:85%" readonly></td>
                                <td class="saludo1">valor:</td>
                                <td>
                                	<input type="text" name="vmregpresu" id="vmregpresu" value="<?php echo "$".number_format($_POST[vregpresu],2);?>" style="width:85%" readonly>
                                	<input type="hidden" name="vregpresu" id="vregpresu" value="<?php echo $_POST[vregpresu];?>" style="width:100%">                              
                                </td>
                                <td class="saludo1">Origen Pto:</td>
                                <td colspan="3"><input type="text" name="origenppto" id="origenppto" value="<?php echo $_POST[origenppto];?>" style="width:100%" <?php echo $_POST[blgeneralc1];?>></td>       
                            </tr>
                            <tr>
                            	 <td class="saludo1">Fecha Suscripci&oacute;n:</td>
                                 <td>
								 <input name="fechasus" id="fechasus" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechasus]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechasus');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								 </td>
                                 <td class="saludo1">Vinculo Supervisor:</td>
                                 <td>
                                 	<input type="hidden" name="tipvinsupo" id="tipvinsupo" value="<?php if($_POST[tipvinsup]!=""){echo $_POST[tipvinsup];} else {$_POST[tipvinsup]=$_POST[tipvinsupo];echo $_POST[tipvinsupo];}?>">
                                 	<select name="tipvinsup" id="tipvinsup" onKeyUp="return tabular(event,this)"  style="width:85%" <?php echo $_POST[blgeneralc2];?>>
                                        <option value="i" <?php if($_POST[tipvinsup]=='i') echo "SELECTED"; ?>>Interno</option>
                                        <option value="e" <?php if($_POST[tipvinsup]=='e') echo "SELECTED"; ?>>Externo</option>
                                    </select>
                                 </td>
                                 <td class="saludo1">N&deg; Unidades:</td>
                                 <td colspan="3">
                                 <input type="text" name="nunidadesv" id="nunidadesv" value="<?php $unidtx=convertir($_POST[nunidades]);if($unidtx=="UN"){echo "UNA UNIDAD";}else{echo $unidtx." UNIDADES";}?>" style="width:100%"  onBlur="<?php if($_POST[blgeneralc1]==""){ echo "validar2('vunidades');";}?>" onKeyPress="javascript:return solonumeros(event)" onFocus="<?php if($_POST[blgeneralc1]==""){ echo "document.getElementById('nunidadesv').value='';";}?>" <?php echo $_POST[blgeneralc1];?>>
                                 <input type="hidden" name="nunidades" id="nunidades" value="<?php echo $_POST[nunidades];?>" style="width:85%"></td>
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
                                <td colspan="1" >
                                	<input type="text" name="npagosv" id="npagosv" value="<?php $unidtx=convertir($_POST[npagos]);if($unidtx=="UN"){echo "UN PAGO";}else{echo $unidtx." PAGOS";}?>" style="width:100%"  onBlur="<?php if($_POST[blgeneralc1]==""){ echo "validar2('vpagos');";}?>" onKeyPress="javascript:return solonumeros(event)" onFocus="<?php if($_POST[blgeneralc1]==""){ echo "document.getElementById('npagosv').value='';";}?>" <?php echo $_POST[blgeneralc1];?>>
                                <input type="hidden" name="npagos" id="npagos" value="<?php echo $_POST[npagos];?>" style="width:100%">
                                </td>
								
								<td style="width:10%" class="saludo1">Valor Cuota:</td>
								
								<td colspan="1">
									<input id="val_cuota" name="val_cuota" onkeypress="return justNumbers(event);" value="<?php echo $_POST[val_cuota]; ?>" style="width:100%">
								</td>
								
                            </tr>
                            <tr>
                                <td class="saludo1">Anticipo:</td>
                               	<td > 
									<select name="anticipo" id="anticipo" onKeyUp="return tabular(event,this)" onChange="validar2('anti');" style="width:85%">
                                        <option value="s" <?php if($_POST[anticipo]=='s') echo "SELECTED"; ?>>SI</option>
                                        <option value="n" <?php if($_POST[anticipo]=='n') echo "SELECTED"; ?>>NO</option>
                                    </select>
                                </td>
                                <td class="saludo1" >Valor Anticipo:</td>
                                <td>
                                	<input type="hidden" name="valantio" id="valantio" value="<?php echo $_POST[valantio];?>">
                                	<input type="text" name="valanti" id="valanti" value="<?php echo $_POST[valanti];?>" style="width:85%;text-align:right; "  data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valantio','valanti');return tabular(event,this);" />
                                    
                               	</td>
                                 <td class="saludo1">Fiducia:</td>
                               	<td> 
                                	<input type="hidden" name="antificuciao" id="antificuciao" value="<?php if($_POST[antificucia]!=""){echo $_POST[antificucia];} else {$_POST[antificucia]=$_POST[antificuciao];echo $_POST[antificuciao];}?>">
									<select name="antificucia" id="antifiducia" onKeyUp="return tabular(event,this)" style="width:85%" <?php echo $_POST[valacti];?> <?php echo $_POST[blgeneralc2];?>>
                                        <option value="n" <?php if($_POST[antificucia]=='n') echo "SELECTED"; ?>>NO</option>
                                        <option value="s" <?php if($_POST[antificucia]=='s') echo "SELECTED"; ?>>SI</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td class="saludo1" >Cod. SECOP:</td>
                            	<td><input type="text" name="codsecod" id="codsecod" value="<?php echo $_POST[codsecod];?>"  style="width:85%" <?php echo $_POST[blgeneralc1];?>></td>
                                <td class="saludo1" >N&deg; Acto:</td>
                                <td><input type="text" name="numacto" id="numacto" value="<?php echo $_POST[numacto];?>"  style="width:85%" <?php echo $_POST[blgeneralc1];?>></td>
                                <td class="saludo1" >Fecha Acto:</td>
                                 <td>
								 <input name="fechacto" id="fechacto" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechacto]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechacto');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								 
								 </td>
                            </tr>
                            <tr>
                                <td  class="saludo1">Supervisor:</td>
                                <td>
                                    <input id="tercero" name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="<?php if($_POST[blgeneralc1]==""){ echo "buscater(event);";}?>" onFocus="" <?php echo $_POST[blgeneralc1];?>>
                                    <a href="#" onClick="despliegamodal('visible','2','1');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                                </td>
                                <td colspan="2"><input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                                <td  class="saludo1">Dependencia:</td>
                                <td colspan="3">
                                    <input type="text" name="dependencia" id="dependencia" value="<?php echo $_POST[dependencia]?>" style="width:100%;" readonly>
                                    <input type="hidden" name="iddependencia" id="iddependencia" value="<?php echo $_POST[iddependencia]?>">	
                                </td>
                        	</tr>
                            <tr>
                                <td class="titulos" colspan="12">.: Personal Contrataci&oacute;n </td>
                            </tr>
                            <tr>
                                <td  class="saludo1">Realizado Por:</td>
                                <td>
                                    <input id="realizado" name="realizado" type="text" value="<?php echo $_POST[realizado]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="<?php if($_POST[blgeneralc1]==""){ echo "buscarea(event);";}?>" onFocus="" <?php echo $_POST[blgeneralc1];?>>
                                    <a href="#" onClick="despliegamodal('visible','2','2');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                                </td>
                                <td colspan="2"><input id="nrealizado" name="nrealizado" type="text" value="<?php echo $_POST[nrealizado]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                                <td  class="saludo1">Dependencia:</td>
                                <td colspan="3">
                                    <input type="text" name="drealizado" id="drealizado" value="<?php echo $_POST[drealizado]?>" style="width:100%;" readonly>
                                    <input type="hidden" name="idrealizado" id="idrealizado" value="<?php echo $_POST[idrealizado]?>">	
                                </td>
                        	</tr>
                            <tr>
                                <td  class="saludo1">Revisado Por:</td>
                                <td>
                                  <input id="revisado" name="revisado" type="text" value="<?php echo $_POST[revisado]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="<?php if($_POST[blgeneralc1]==""){ echo "buscarev(event);";}?>" onFocus="" <?php echo $_POST[blgeneralc1];?>>
                                    <a href="#" onClick="despliegamodal('visible','2','3');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                                </td>
                                <td colspan="2"><input id="nrevisado" name="nrevisado" type="text" value="<?php echo $_POST[nrevisado]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                                <td  class="saludo1">Dependencia:</td>
                                <td colspan="3">
                                    <input type="text" name="drevisado" id="drevisado" value="<?php echo $_POST[drevisado]?>" style="width:100%;" readonly>
                                    <input type="hidden" name="idrevisado" id="idrevisado" value="<?php echo $_POST[idrevisado]?>">	
                                </td>
                        	</tr>
                            <tr>
                                <td  class="saludo1">Firmado Por:</td>
                                <td>
                                   <input id="firmado" name="firmado" type="text" value="<?php echo $_POST[firmado]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="<?php if($_POST[blgeneralc1]==""){ echo "buscafir(event);";}?>" onFocus="" <?php echo $_POST[blgeneralc1];?>>
                                    <a href="#" onClick="despliegamodal('visible','2','4');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                                </td>
                                <td colspan="2"><input id="nfirmado" name="nfirmado" type="text" value="<?php echo $_POST[nfirmado]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                                <td  class="saludo1">Dependencia:</td>
                                <td colspan="3">
                                    <input type="text" name="dfirmado" id="dfirmado" value="<?php echo $_POST[dfirmado]?>" style="width:100%;" readonly>
                                    <input type="hidden" name="idfirmado" id="idfirmado" value="<?php echo $_POST[idfirmado]?>">	
                                </td>
                        	</tr>
						</table>
					</div>
				</div>  
				<div class="tab">
                   <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> onClick="cambiobotones('4'); cambiopestanas('4');"  <?php $val01=validacion01();echo $val01; ?>>
                   <label for="tab-4"><img src="<?php echo $p4luzcem1;?>" width="16" height="16"><img src="<?php echo $p4luzcem2;?>" width="16" height="16"><img src="<?php echo $p4luzcem3;?>" width="16" height="16"> Anexos Contratacion</label>
					<div class="content">
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
                                $sqlr="SELECT contramodalidadanexos.idanexo,contraanexos.nombre, contramodalidadanexos.obligatorio  FROM contramodalidadanexos, contraanexos where contramodalidadanexos.idmodalidad = '$_POST[modalidad]' and contramodalidadanexos.idpadremod = '$_POST[smodalidad]' and contramodalidadanexos.fase='2' and contramodalidadanexos.idanexo=contraanexos.id";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_row($res)) 
								{	
									$sqlrda2="SELECT adjunto FROM contraprocesos_anexos WHERE proceso='$_POST[nproceso]' AND id_fase='2' AND id_anexo='$rowEmp[0]'";
									$rowda2=mysql_fetch_row(mysql_query($sqlrda2,$linkbd));
									if ($rowda2!=""){$_POST[namearc2][]=$rowda2[0];}
									else{$_POST[namearc2][]="";}
									$_POST[idanex2][]=$rowEmp[0];
									$_POST[nanex2][]=$rowEmp[1];
									$_POST[obliga2][]=$rowEmp[2];
								}
								$_POST[ocultoa1]="1";
							}
						?>	
                        <table class="inicio">
                            <tr><td class="titulos" colspan="4">Anexos Contractuales</td></tr>
                            <tr>
                                <td class="saludo1">Modalidad</td>
                                <td> 
                                    <select name="modalidadv" id="modalidadv" disabled >
                                    	<option  value="" >Seleccione....</option>
                                   	 	<?php
											$sqlr="SELECT * FROM dominios where nombre_dominio='MODALIDAD_SELECCION' ";
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
												<div class='custom-input-file'>";
												if($_POST[blgeneralc1]=="")
												{ 
													echo "
													<input class='input-file' style='width:5%' type='file' name='uploads2[]'  onClick='valnumarchivo($xy);' onchange='validar();'><img src='imagenes/attach.png'> ";
												}
												else
												{echo "<img src='imagenes/attach.png'> ";}
										echo"		
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
			<input type="hidden" name="codigot" id="codigot" value="<?php echo $_POST[codigot];?>">
            <?php
				//*** ingreso
			 	if($_POST[bin]=='1')
			 	{
			  		$nresul=buscaingreso($_POST[codingreso]);
			  		if($nresul!='')
			   		{
			 			$_POST[ningreso]=$nresul;
  			  			?><script>
			  				document.getElementById('valor').focus();document.getElementById('valor').select();
                        </script><?php
			  		}
			 		else
			 		{
			  			$_POST[codingreso]="";
			  			?><script>
							alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();
                        </script><?php
			  		}
			 	}
				//******GUARDADO FASES 
				if($_POST[oculto]==2)
				{	
					if(isset($_POST['finaliza'])){$cfinaliza=1;}else{$cfinaliza=0;}
					$linkbd=conectar_bd();
					if(strpos($_POST[fecha],"-")===false){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fechaf=$_POST[fecha];
					}
					
					if($_POST[estsemaforo1]=="1")
					{
						$sqlr="insert into contraprocesos (idproceso,fecha,vigencia,objeto,modalidad,submodalidad,clasecontrato,nomproyecto,contrato,solicita,dependencia,estado,codsolicitud, activo)values('$_POST[nproceso]','$fechaf','$_POST[vigencia]','$_POST[concepto]','$_POST[modalidad]','$_POST[smodalidad]','$_POST[clasecontrato]','','','','','S','$_POST[solcompra]','$cfinaliza')";$mensaje="Se Almacenaron los Datos Precontractuales con Exito";
						$sqlrsef="INSERT INTO contraestadosemf (idcontrato,sem1,sem2,sem3,sem4) VALUES ('$_POST[nproceso]', '2', '$_POST[estsemaforo2]','$_POST[estsemaforo3]','$_POST[estsemaforo4]')";
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
						?><script>
							document.getElementById('estsemaforo1').value="3";
							document.getElementById('finaliza').checked=true;
							document.getElementById('finaliza').value=1;
                        </script><?php 
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
					{ ?><script>document.getElementById('estsemaforo2').value="2";</script><?php }
					$sqlrsef="UPDATE contraestadosemf SET sem1='$_POST[estsemaforo1]',sem2='2',sem3='$_POST[estsemaforo3]', sem4='$_POST[estsemaforo4]' WHERE idcontrato='$_POST[nproceso]'";
					mysql_query($sqlrsef,$linkbd);
					?><script>parent.despliegamodalm('visible','1','Se Almacenaron los Anexos Precontractuales con Exito');</script><?php
				}
				//************************************************************************************************
				if($_POST[oculto]==4)
				{
					if($_POST[solcompra]!=""){$solicompra=$_POST[solcompra];}
					else {$solicompra=$_POST[solcomprao];}
					if(isset($_REQUEST['finalizac'])){$cfinalizac=1;}else{$cfinalizac=0;}
					$totalplazo=$_POST[plazoo1]."/".$_POST[plazoo2];
					if(strpos($_POST[fechareg],"-")===false){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechareg],$fecha);
						$fecharegf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fecharegf=$_POST[fechareg];
					}
					//***Fecha inicial
					if(strpos($_POST[fechai],"-")===false){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechai],$fecha);
						$fechaif=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fechaif=$_POST[fechai];
					}
					//***Fecha final
					if(strpos($_POST[fechat],"-")===false){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechat],$fecha);
						$fechatf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fechatf=$_POST[fechat];
					}
					//***Fecha susf
					if(strpos($_POST[fechasus],"-")===false){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechasus],$fecha);
						$fechasusf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fechasusf=$_POST[fechasus];
					}
					//***Fecha f
					if(strpos($_POST[fechal],"-")===false){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechal],$fecha);
						$fechalf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fechalf=$_POST[fechal];
					}
					//***Fecha acto
					if(strpos($_POST[fechacto],"-")===false){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechacto],$fecha);
						$fechactof=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fechactof=$_POST[fechacto];
					}
					
					
					
					if($_POST[estsemaforo3]=="1")
					{
						$sqlr="INSERT INTO contracontrato (id_contrato,numcontrato,vigencia,fecha_registro,rp,contratista,supervisor, valor_contrato,modalidad,submodalidad,tipo_contrato,num_pagos,objeto,realizo,reviso,firmo,regimen_contra,origenppto,fecha_suscripcion, tipo_vincu_super,plazo_ejecu,numero_unidades,anticipo,valor_anticipo,fiducia_anticipo,fecha_inicio,fecha_terminacion,publi_secop, num_acto,fecha_acto,codsolicitud,fechaliquidacion,activo,valor_cuota) VALUES ('$_POST[nproceso]','$_POST[ncontra]','$_POST[vigcontra]', '$fecharegf','$_POST[nregpresu]','$_POST[idcontratista]','$_POST[tercero]','$_POST[valcontrao]','$_POST[modalidad]', '$_POST[smodalidad]','$_POST[clasecontrato]','$_POST[npagos]','$_POST[obcontra]','$_POST[realizado]','$_POST[revisado]', '$_POST[firmado]','$_POST[regcontra]','$_POST[origenppto]','$fechasusf','$_POST[tipvinsup]','$totalplazo','$_POST[nunidades]', '$_POST[anticipo]','$_POST[valantio]','$_POST[antificucia]','$fechaif','$fechatf','$_POST[codsecod]','$_POST[numacto]', '$fechactof','$solicompra','$fechalf','$cfinalizac','$_POST[val_cuota]')";$mensaje="Se Almacenaron los Datos del Contrato con Exito";
					}
					else
					{
						$sqlr="UPDATE contracontrato SET numcontrato='$_POST[ncontra]',vigencia='$_POST[vigcontra]',fecha_registro='$fecharegf',rp='$_POST[nregpresu]', contratista='$_POST[idcontratista]',supervisor='$_POST[tercero]', valor_contrato='$_POST[valcontrao]',modalidad='$_POST[modalidad]', submodalidad='$_POST[smodalidad]',tipo_contrato='$_POST[clasecontrato]',num_pagos='$_POST[npagos]',objeto='$_POST[obcontra]', realizo='$_POST[realizado]',reviso='$_POST[revisado]',firmo='$_POST[firmado]',regimen_contra='$_POST[regcontra]', origenppto='$_POST[origenppto]',fecha_suscripcion='$fechasusf', tipo_vincu_super='$_POST[tipvinsup]', plazo_ejecu='$totalplazo',numero_unidades='$_POST[nunidades]',anticipo='$_POST[anticipo]',valor_anticipo='$_POST[valantio]',fiducia_anticipo='$_POST[antificucia]',fecha_inicio='$fechaif',fecha_terminacion='$fechatf',publi_secop='$_POST[codsecod]', num_acto='$_POST[numacto]',fecha_acto='$fechactof',codsolicitud='$solicompra',fechaliquidacion='$fechalf',activo='$cfinalizac',valor_cuota='$_POST[val_cuota]' WHERE  id_contrato='$_POST[nproceso]'";$mensaje="Se Modifico los Datos del Contrato con Exito";
					}
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE contraprocesos SET contrato='$_POST[ncontra]' WHERE idproceso='$_POST[nproceso]'";
					mysql_query($sqlr,$linkbd);
					$sqlrsef="UPDATE contraestadosemf SET sem1='$_POST[estsemaforo1]',sem2='$_POST[estsemaforo2]', sem3='$_POST[estsemaforo3]',sem4='$_POST[estsemaforo4]' WHERE idcontrato='$_POST[nproceso]'";
					mysql_query($sqlrsef,$linkbd);
					
					{?><script>document.getElementById('estsemaforo3').value="2"; </script><?php }
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
						?><script>document.getElementById('estsemaforo4').value="2";</script><?php 
						$sqlrsef="UPDATE contraestadosemf SET sem1='$_POST[estsemaforo1]',sem2='$_POST[estsemaforo2]', sem3='$_POST[estsemaforo3]',sem4='2' WHERE idcontrato='$_POST[nproceso]'";
					}
					mysql_query($sqlrsef,$linkbd);
					?><script>parent.despliegamodalm('visible','1','Se Almacenaron los Anexos de Contrataci\xf3n con Exito');</script><?php
				}
				//************************************************************************************************
			?>
        </form>  	
    </body>
</html>