<!--V 1.0 24/02/2015-->
<?php
	//header("Content-Type: text/html; charset=utf-8");
	ini_set('max_execution_time',3600);
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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="pdfcmov.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function agregardetalle()
			{
				document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				document.form2.catcompro.value=document.form2.categoria.value;
				valordeb=quitarpuntos(document.form2.vlrdeb.value)	
				valorcred=quitarpuntos(document.form2.vlrcre.value)
				if(document.form2.cuenta.value!="" && document.form2.tercero.value!="" && document.form2.cc.value!="" && (valordeb>0 || valorcred>0))
				{document.form2.agregadet.value=1;document.form2.submit();}
				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				document.form2.catcompro.value=document.form2.categoria.value;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','4');
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
				{
					document.form2.fecha.value='';
					document.form2.oculto.value=2;
					document.form2.agregadet.value='';
					document.form2.elimina.value='';
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.action="cont-buscacomprobantes.php";
					document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				    document.form2.catcompro.value=document.form2.categoria.value;
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
				{
					document.form2.fecha.value='';
					document.form2.oculto.value=2;
					document.form2.agregadet.value='';
					document.form2.elimina.value='';
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				    document.form2.catcompro.value=document.form2.categoria.value;
					document.form2.action="cont-buscacomprobantes.php";
					document.form2.submit();
				}
			}
			function validar1()
			{
				document.form2.oculto.value=1;
				alert();
				document.form2.action="cont-buscacomprobantes.php";
				document.form2.submit();
				alert();
			}
			function validarMovimiento()
			{
				var x = document.getElementById("tipomov").value;
				document.form2.movimiento.value=x;
				document.form2.oculto.value=2;
			    document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				document.form2.catcompro.value=document.form2.categoria.value;
				document.form2.agregadet.value='';
				document.form2.elimina.value='';
				document.form2.action="cont-buscacomprobantes.php";
				document.form2.submit();
			}
			function validar()
			{
				document.form2.oculto.value=1;
				document.form2.action="cont-buscacomprobantes.php";
				document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				document.form2.catcompro.value=document.form2.categoria.value;
				document.form2.submit();
			}
			function validarcat(){
				document.form2.action="cont-buscacomprobantes.php";
				document.form2.catcompro.value=document.form2.categoria.value;
				document.form2.submit();
			}
			 
			function validar3(){document.form2.submit();}
			function validar2()
			{
				document.form2.oculto.value=2;
			    document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				document.form2.catcompro.value=document.form2.categoria.value;
				document.form2.agregadet.value='';
				document.form2.elimina.value='';
				document.form2.action="cont-buscacomprobantes.php";
				document.form2.submit();
			}
			function guardar()
			{
				document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				document.form2.catcompro.value=document.form2.categoria.value;
				valor=Math.round(Math.abs(parseFloat(document.form2.diferencia.value)));
				if (valor==0)
				{
					var validacion01=document.getElementById('concepto').value;
					if((document.form2.fecha.value!='')&&(document.form2.tipocomprobante.value!="")&&(validacion01.trim()!=''))
						{despliegamodalm('visible','4','Esta Seguro de Modificar','2');}
					else{despliegamodalm('visible','2',"Falta informaci�n para poder guardar")}
				}
				else 
				{
					var nomtitul = 'Comprobante descuadrado Diferencia: \"'+ valor+'\"';
					despliegamodalm('visible','2',nomtitul)
				}
			}
			function duplicarcomp()
			{
				valor=Math.round(parseFloat(document.form2.diferencia.value));
				if (valor==0 && document.form2.fecha.value!='')
					{despliegamodalm('visible','4','Esta Seguro de Duplicar el Comprobante','3');}
				else 
				{
					var titumod ="Comprobante descuadrado o faltan informacion: "+valor;
					despliegamodalm('visible','2',titumod);
				}
			}
			function buscacta(e){
				if (document.form2.cuenta.value!=""){
				document.form2.bc.value='1';
				document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				document.form2.catcompro.value=document.form2.categoria.value;
				document.form2.submit();
				}
			}
			function buscacc(e){
				if (document.form2.cc.value!=""){
					document.form2.bcc.value='1';
					document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				    document.form2.catcompro.value=document.form2.categoria.value;
					document.form2.submit();
					}
				}
			function buscater(e){
				if (document.form2.tercero.value!=""){
					document.form2.bt.value='1';
					document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				    document.form2.catcompro.value=document.form2.categoria.value;
					document.form2.submit();
					}
				}
			function excell()
			{
				document.form2.action="cont-buscacomprobantesexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodal2(_valor,_nomve)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_nomve)
					{
						case "1":	document.getElementById('ventana2').src="terceros-ventana1.php";break;
						case "2":	document.getElementById('ventana2').src="cuentas-ventana01.php";break;
						case "3":	document.getElementById('ventana2').src="cc-ventana01.php";break;
					}
					
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "2":	document.getElementById('valfocus').value='1';
									document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
									break;
						case "3":	document.getElementById('valfocus').value='1';
									document.getElementById('cc').focus();
									document.getElementById('cc').select();
									break;
					}
				}
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
						case "4":
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "cont-buscacomprobantes.php";}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.getElementById('bt').value="0";	
									mypop=window.open('cont-terceros.php','','');break;
						case "2":	document.form2.oculto.value='3';
									document.form2.action="cont-buscacomprobantes.php";
									document.form2.submit();break;
						case "3":	document.form2.oculto.value='4';
									document.form2.duplicar.value='2';
									document.form2.action="cont-buscacomprobantes.php";
									document.form2.submit();break;
						case "4":	document.form2.elidet.value="1";
									document.form2.submit();break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.getElementById('bt').value="0";
									document.getElementById('tercero').focus();
									document.getElementById('tercero').select();
									break;
						case "2":	
						case "3":	break;
						case "4":	document.form2.elimina.value="";break;
					}
				}
			}
			function llamadoesc(e,_opc)
			{
				tecla=(document.all) ? e.keyCode : e.which; 
				if (tecla == 27)
				{
					switch(_opc)
					{
						case "1":	document.getElementById("bgventanamodal2").style.visibility="visible";
									document.getElementById('ventana2').src="cuentas-ventana01.php";break;
						case "2":	document.getElementById("bgventanamodal2").style.visibility="visible";
									document.getElementById('ventana2').src="terceros-ventana1.php";break;
						case "3":	document.getElementById("bgventanamodal2").style.visibility="visible";
									document.getElementById('ventana2').src="cc-ventana01.php";break;
					}
				}
			}
			function calcular()
			{
				document.form2.tipcomp.value=document.form2.tipocomprobante.value;
				document.form2.catcompro.value=document.form2.categoria.value;
				document.form2.submit();
			}
		</Script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
	  			<td colspan="3" class="cinta">
					<a onClick="location.href='cont-comprobantes.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a onClick="location.href='cont-buscacomprobantes.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
					<a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" style="width:29px;height:25px;" title="imprimir"></a>
					<a onClick="duplicarcomp()"class="mgbt"><img src="imagenes/duplicar.png" style="width:28px;height:25px;" title="Duplicar"></a>
					<a onClick="excell()" class="mgbt"><img src="imagenes/excel.png" style="width:24px;height:24px;" title="excel"></a>
				</td>
        	</tr>
      	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php 
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			//if(!$_POST[oculto])
			$_POST[estadoc]='';
			$consulta="";
			if(isset($_GET['idCat']))
			{
				$_POST[catcompro]=$_GET['idCat'];
				$_POST[categoria]=$_GET['idCat'];
				$_POST[tipocomprobante]=$_GET['tipo_compro'];
				$_POST[tipcomp]=$_GET['tipo_compro'];
				$consulta = " and numerotipo='".$_GET['num_compro']."'";
				$_POST[oculto]='1';
				//echo $_POST[ncomp];
			}
			if($_POST[oculto]=='1')
			{
	 			$_POST[concepto]="";
	 			$_POST[total]="";
 	 			$_POST[cuenta]="";
 	 			$_POST[ncuenta]="";	 
 	 			$_POST[tercero]="";	 
	 			$_POST[ntercero]="";
 	 			$_POST[cc]="";	 
	 			$_POST[ncc]="";
  	 			$_POST[detalle]="";	 
	 			$_POST[cuentadeb]="";
	 			$_POST[cuentacred]="";
	 			$_POST[diferencia]="";	 	 	 	 
	 			$_POST[estado]="";
				$sqlr="select * from comprobante_cab where tipo_comp=$_POST[tipocomprobante] $consulta ORDER BY numerotipo DESC"; 
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[1];
				if(isset($_GET['num_compro']))
				{
					$_POST['ncomp']=$_GET['num_compro'];
				}
				else
				{
					$_POST[ncomp]=$r[1];
				}
	 			$_POST[fecha]=$r[3];
	 			$_POST[concepto]=$r[4];
	 			$_POST[total]=$r[5];
	 			$_POST[cuentadeb]=$r[6];
	 			$_POST[cuentacred]=$r[7];
				$_POST[diferencia]=$r[8];	 
				if($r[9]=='1'){$_POST[estadoc]='ACTIVO'; }	 				  
		 		if($r[9]=='0'){$_POST[estadoc]='ANULADO';}	
				$_POST[estado]=$r[9];
	 			$_POST[dcuentas]=array();
	 			$_POST[dncuentas]=array();
	 			$_POST[dterceros]=array();
	 			$_POST[dnterceros]=array();	 
	 			$_POST[dccs]=array();		 
	 			$_POST[ddetalles]=array();
	 			$_POST[dcreditos]=array();
	 			$_POST[ddebitos]=array();
	 			$idet=$_POST[tipocomprobante];
	 			$ndet=$_POST[ncomp];
				$sqlr="select * from comprobante_det where tipo_comp=$idet and numerotipo=$ndet  order by id_det";

				$res2=mysql_query($sqlr,$linkbd);	
				while($r2=mysql_fetch_row($res2))
				{
			 		$_POST[dcuentas][]=$r2[2];
			 		$nresul=buscacuenta($r2[2]);
			 		$_POST[dncuentas][]=$nresul;
			 		$_POST[dterceros][]=$r2[3];
			 		$_POST[dccs][]=$r2[4];		 
			 		$_POST[ddetalles][]=$r2[5];
			 		$_POST[dcreditos][]=$r2[8];
			 		$_POST[ddebitos][]=$r2[7];	
				}
			}
			else
 			{
  				if($_POST[elimina]=='' && $_POST[agregadet]=='')
	  			{
		   			$_POST[concepto]="";
	 				$_POST[total]="";
	 				$_POST[cuentadeb]="";
 	 				$_POST[cuenta]="";
 	 				$_POST[ncuenta]="";	 
 	 				$_POST[tercero]="";	 
	 				$_POST[ntercero]="";
	  	 			$_POST[cc]="";	 
	 				$_POST[ncc]="";
  	 				$_POST[detalle]="";	
	 				$_POST[cuentacred]="";
	 				$_POST[diferencia]="";	 	 	 	 
	 				$_POST[estado]="";
					$sqlr="select * from comprobante_cab where tipo_comp=$_POST[tipocomprobante] and numerotipo=$_POST[ncomp] ";
					$res=mysql_query($sqlr,$linkbd);
					//echo $sqlr;
					$color='';
					while($r=mysql_fetch_row($res))
					{
						if($_POST[oculto]==2){$_POST[fecha]=$r[3];}
	 					$_POST[concepto]=$r[4];
	 					$_POST[total]=$r[5];
	 					$_POST[cuentadeb]=$r[6];
	 					$_POST[cuentacred]=$r[7];
	 					$_POST[diferencia]=$r[8];	 	 	 	 
						 $_POST[estado]=$r[9];	 
						
	 					if($r[9]=='1')
						{ 
							$_POST[estadoc]='ACTIVO';
							$color=" style='background-color:#009900 ;color:#fff'";
						}	 				  
		 				if($r[9]=='0')
						{ 
							$_POST[estadoc]='ANULADO'; 
							$color=" style='background-color:#aa0000 ; color:#fff'";
						}	
						if($r[9]=='2')
						{ 
							$_POST[estadoc]='REVERSADO'; 
							$color=" style='background-color:#aa0000 ; color:#fff'";
						}
					}
	  			}
 	 			$idet=$_POST[tipocomprobante]." ".$_POST[ncomp];
	 			if($_POST[elimina]=='' && $_POST[agregadet]=='')
	  			{
					$_POST[dcuentas]=array();
	 				$_POST[dncuentas]=array();
	 				$_POST[dterceros]=array();
	 				$_POST[dnterceros]=array();	 
	 				$_POST[dccs]=array();		 
					$_POST[ddetalles]=array();
	 				$_POST[dcreditos]=array();
	 				$_POST[ddebitos]=array();
					$sqlr="select * from comprobante_det where tipo_comp=$_POST[tipocomprobante] and numerotipo=$_POST[ncomp]  order by id_det";
					//echo $sqlr;
					$res2=mysql_query($sqlr,$linkbd);	
					while($r2=mysql_fetch_row($res2))
					{
	 					$_POST[dcuentas][]=$r2[2];
	 					$nresul=buscacuenta($r2[2]);
	 					$_POST[dncuentas][]=$nresul;
	 					$_POST[dterceros][]=$r2[3];
	 					$_POST[dccs][]=$r2[4];		 
	 					$_POST[ddetalles][]=$r2[5];
	 					$_POST[dcreditos][]=round($r2[8],2);
	 					$_POST[ddebitos][]=round($r2[7],2);
					}
	  			}
			}
		?>
      	<form name="form2" method="post" action="">
        	<input type="hidden" name="valfocus" id="valfocus" value="1"/>
  			<table class="inicio">
        		<tr>
          			<td class="titulos" colspan="9">Comprobantes</td>
          			<td class="cerrar" style="width:7%;"><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
        		</tr>
        		<tr>
		   			<td class="saludo1" style="width:12.5%;">Categoria comprobante:</td>
          			<td style="width:20%;">
                    	 <select name="categoria" id="categoria" style="width:100%;" onChange="validarcat()">
						<option value="">.: Seleccione la categoria</option> 
                            <?php
							$sql="select * from categoria_compro WHERE estado='S' ORDER BY id";
							$result=mysql_query($sql,$linkbd);
							while($row = mysql_fetch_array($result)){
							if($_POST[catcompro]==$row[0]){
								echo "<option value='$row[0]' SELECTED>$row[1]</option>";
							}else{
								echo "<option value='$row[0]'>$row[1]</option>";
							}
								
							}
							?>
							
                        </select> 
						<input type="hidden" name="catcompro" id="catcompro" />
						
          			</td>
          			<td class="saludo1" style="width:4%;" >No:</td>
          			<td style="width:12%;">
                    	<input type="hidden" name="ntipocomp" value="<?php echo $_POST[ntipocomp]?>"><a onClick="atrasc()" style='cursor:pointer;'><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>&nbsp;<input type="text" name="ncomp" onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) " onBlur="validar2()"  style="width:60%;"><input type="hidden" value="a" name="atras"><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">&nbsp;<a onClick="adelante()" style='cursor:pointer;'><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
                  	</td>
          			<td class="saludo1" >Fecha: </td>
          			<td  style="width:20%;"><input type="text" name="fecha" id="fecha"   title="YYYY-MM-DD" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)"  style="width:50%;" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2" >&nbsp;<a href="#" onClick="displayCalendarFor('fecha');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a></td>
					<td>
					<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validarMovimiento()" style="float:right">
					<?php
					
					$codMovimiento='1';
					if(isset($_POST['movimiento'])){
								if(!empty($_POST['movimiento']))
									$codMovimiento=$_POST['movimiento'];
							 }
					$sql="SELECT estado FROM comprobante_cab where numerotipo=$_POST[ncomp] and tipo_comp=$_POST[tipocomprobante] ORDER BY estado";
					$resultMov=mysql_query($sql,$linkbd);
					$movimientos=Array();
					$movimientos["1"]["nombre"]="1-Documento de Creacion";
					$movimientos["1"]["estado"]="";
					$movimientos["2"]["nombre"]="2-Reversion";
					$movimientos["2"]["estado"]="";
					while($row = mysql_fetch_row($resultMov)){
						$mov=$movimientos[$row[0]]["nombre"];
						$movimientos[$codMovimiento]["estado"]="selected";
						$state=$movimientos[$row[0]]["estado"];
						echo "<option value='$row[0]' $state>$mov</option>";
					}
					$movimientos[$codMovimiento]["estado"]="";
					echo "<input type='hidden' id='movimiento' name='movimiento' value='$_POST[movimiento]' />";
					 ?>
					 </select>
					 </td>
          			<td class="saludo1">Estado:</td>
          			<td colspan="2"><input type="hidden" id="duplicar" name="duplicar"  value="<?php echo $_POST[duplicar]; ?>" readonly><input type="hidden" name="estado"  value="<?php echo $_POST[estado]; ?>" readonly><input type="text" name="estadoc" id="estadoc"  value="<?php echo $_POST[estadoc]; ?>"  readonly></td>
        		</tr>
    			<tr>
					<td class="saludo1" style="width:12.5%;">Tipo Comprobante:</td>
          			<td style="width:20%;">
                    	<select name="tipocomprobante" id="tipocomprobante" onKeyUp='return tabular(event,this)' onChange="validar()" style="width:100%;">
		  					<option value="-1">.: Seleccione Tipo Comprobante</option>	  
		   					<?php
  		   						$sqlr="Select * from tipo_comprobante  where estado='S' AND id_cat=$_POST[categoria] order by nombre";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($_POST[tipcomp]==$row[3])
			 						{
				 						$_POST[ntipocomp]=$row[1];
				 						echo "<option value=$row[3] SELECTED>$row[1]</option>";
				 					}
									else {echo "<option value=$row[3]>$row[1]</option>";}
			     				}			
		  					?>
		  				</select>
						<input type="hidden" name="tipcomp" id="tipcomp" />
          			</td>
					
          			<td class="saludo1" colspan="3">Concepto:</td>
          			<td colspan="2"><input type="text" name="concepto" id="concepto"  style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[concepto]; ?>"></td>
          			<td class="saludo1">Total:</td>
          			<td><input type="text" name="total" size="20" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[total]; ?>" readonly ></td>
        		</tr>
        	</table>
			<table class="inicio">		
        		<tr><td class="titulos2" colspan="30">Agregar Detalle</td></tr>
        		<tr>
          			<td class="saludo1" style="width:10%;">Cuenta:</td>
         	 		<td valign="middle" style="width:12%;"><input type="text" id="cuenta" name="cuenta" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>"  onKeyDown="llamadoesc(event,'1')"/><input type="hidden" value="0" name="bc"/>&nbsp;<a onClick="despliegamodal2('visible','2');" style='cursor:pointer;'><img src="imagenes/find02.png" style="width:20px;"/></a></td>
                    <td style="width:30%;"><input type="text" name="ncuenta" id="ncuenta" value="<?php echo $_POST[ncuenta]?>" style="width:100%;" readonly></td>
          			<td class="saludo1" style="width:8%;">Tercero:</td>
          			<td style="width:12%;"><input type="text" id="tercero" name="tercero" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>"onKeyDown="llamadoesc(event,'2')"><input type="hidden" value="0" name="bt" id="bt">
            <a onClick="despliegamodal2('visible','1');" style='cursor:pointer;'><img src="imagenes/find02.png" style="width:20px;"></a></td>
          			<td ><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly/></td>
          		</tr>
          		<tr>
          			<td width="101" class="saludo1">Centro Costo:</td>
          			<td><input type="text" id="cc" name="cc" onKeyUp="return tabular(event,this)" onBlur="buscacc(event)" value="<?php echo $_POST[cc]?>" onKeyDown="llamadoesc(event,'3')" style="width:80%"/><input type="hidden" value="0" name="bcc">&nbsp;<a onClick="despliegamodal2('visible','3');" style='cursor:pointer;'><img src="imagenes/find02.png" style="width:20px;"></a></td>
          			<td><input name="ncc" type="text" id="ncc" value="<?php echo $_POST[ncc]?>" style="width:100%" readonly></td>
          			<td width="115" class="saludo1">Detalle:</td>
         			 <td colspan="2"><input type="text" name="detalle" id="detalle" style="width:100%" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[detalle]?>" o|nClick="document.getElementById('detalle').focus();document.getElementById('detalle').select();"></td>
          		</tr>
                <tr>
          			<td class="saludo1">Vlr Debito:</td>
         			<td colspan="2"><input type="text" name="vlrdeb" onKeyPress="javascript:return solonumeros(event)" onKeyDown="return tabular(event,this)"  value="0" onClick="document.getElementById('vlrdeb').focus();document.getElementById('vlrdeb').select();"></td>
          			<td width="115" class="saludo1">Vlr Credito:</td>
          			<td width="140"><input type="text" name="vlrcre"  onKeyPress="javascript:return solonumeros(event)" onKeyDown="return tabular(event,this)" value="0" onClick="document.getElementById('vlrcre').focus();document.getElementById('vlrcre').select();"></td>
          			<td colspan="2"><input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"></td>
             	</tr>
      		</table>
	  		<?php if (!$_POST[oculto]){echo "<script>document.form2.tipocomprobante.focus();</script>";}?>
		  	<input type="hidden" value="0" name="oculto" >	 
			<?php 
				if($_POST[estadoc]=='ACTIVO')
				{
					echo"
					<script>
						document.getElementById('estadoc').style.backgroundColor='green';
						document.getElementById('estadoc').style.color='#fff';
					</script>";
				}
				if($_POST[estadoc]=='ANULADO')
				{
					echo"
						<script>
							document.getElementById('estadoc').style.backgroundColor='red';
							document.getElementById('estadoc').style.color='#fff';
						</script>";
				}
				if($_POST[estadoc]=='REVERSADO')
				{
					echo"
						<script>
							document.getElementById('estadoc').style.backgroundColor='red';
							document.getElementById('estadoc').style.color='#fff';
						</script>";
				}
				if($_POST[estadoc]=='')
				{
					echo"
						<script>
							document.getElementById('estadoc').style.backgroundColor='';
							document.getElementById('estadoc').style.color='#fff';
						</script>";
				}
				if($_POST[bc]=='1')
			 	{
			  		$nresul=buscacuenta($_POST[cuenta]);
			  		if($nresul!='')
			   		{
  			 			echo "<script>document.getElementById('ncuenta').value='$nresul';document.getElementById('tercero').focus(); document.getElementById('tercero').select();</script>";
			  		}
			 		else
			 		{
			  			$_POST[ncuenta]="";
			  			echo "<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
			  		}
			 	}
			  	//***** busca tercero
			 	if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
					{
						echo"<script>document.getElementById('ntercero').value='$nresul';document.getElementById('cc').focus(); document.getElementById('cc').select();</script>";
					}
			 		else
			 		{
			  			echo "<script>despliegamodalm('visible','4','Tercero Incorrecto o no Existe, �Desea Agregar un Tercero?','1');</script>";
			  		}
			 	}
			 	//*** centro  costo
			 	if($_POST[bcc]=='1')
			 	{
			  		$nresul=buscacentro($_POST[cc]);
			  		if($nresul!='')
			   		{
			  			echo "<script>document.getElementById('ncc').value='$nresul';document.getElementById('detalle').focus(); document.getElementById('detalle').select();</script>";
			  		}
			 		else
			 		{
			  			echo "<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Centro de Costos Incorrecto');</script>";
			 		}
			 	}
			 ?>
      		<div class="subpantallac2" style="height:47.2%; width:99.6%; overflow-x:hidden;">
	    		<table class="inicio" width="99%">
        			<tr><td class="titulos" colspan="20">Detalle Comprobantes </td></tr>
					<tr>
						<td class="titulos2" style='width:8%;'>Cuenta</td>
                        <td class="titulos2" style='width:17%;'>Nombre Cuenta</td>
                        <td class="titulos2" style='width:8%;'>Tercero</td>
                        <td class="titulos2" style='width:20%;'>Nom Tercero</td>
                        <td class="titulos2" style='width:3%;'>CC</td>
                        <td class="titulos2">Detalle</td>
                        <td class="titulos2" style='width:10%;'>Vlr Debito</td>
                        <td class="titulos2" style='width:10%;'>Vlr Credito</td>
                        <td class="titulos2" style='width:3%;'><img src="imagenes/del.png"></td>
					</tr>
                    	<input type='hidden' name='elimina' id='elimina'>
                        <input type='hidden' name='elidet' id='elidet' value="0">
					<?php 
						if ($_POST[elidet]=='1')
		 				{ 
		 					$posi=$_POST[elimina];
		 					$cuentacred=0;
		  					$cuentadeb=0;
		   					$diferencia=0;
		 					unset($_POST[dcuentas][$posi]);
 							unset($_POST[dncuentas][$posi]);
		 					unset($_POST[dterceros][$posi]);
		 					unset($_POST[dnterceros][$posi]);		 
		 					unset($_POST[dccs][$posi]);
		 					unset($_POST[ddetalles][$posi]);
		 					unset($_POST[dcheques][$posi]);
		 					unset($_POST[dcreditos][$posi]);		 		 		 		 		 
		 					unset($_POST[ddebitos][$posi]);		 
		 					$_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 					$_POST[dncuentas]= array_values($_POST[dncuentas]); 
		 					$_POST[dterceros]= array_values($_POST[dterceros]); 		 		 
							$_POST[dnterceros]= array_values($_POST[dnterceros]); 		 		 		 
							$_POST[dccs]= array_values($_POST[dccs]); 
		 					$_POST[ddetalles]= array_values($_POST[ddetalles]); 
		 					$_POST[dcheques]= array_values($_POST[dcheques]); 
		 					$_POST[dcreditos]= array_values($_POST[dcreditos]); 
		 					$_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
						}
						if ($_POST[agregadet]=='1')
		 				{
		  					$cuentacred=0;
		  					$cuentadeb=0;
		  					$diferencia=0;
		 					$_POST[dcuentas][]=$_POST[cuenta];
		 					$_POST[dncuentas][]=$_POST[ncuenta];
		 					$_POST[dterceros][]=$_POST[tercero];
		 					$_POST[dnterceros][]=$_POST[ntercero];
		 					$_POST[dccs][]=$_POST[cc];		 
		 					$_POST[ddetalles][]=$_POST[detalle];
		 					$_POST[dcheques][]=$_POST[cheque];
	 						$_POST[vlrcre]=str_replace(",",".",$_POST[vlrcre]);
	 						$_POST[vlrdeb]=str_replace(",",".",$_POST[vlrdeb]);
	 						$_POST[dcreditos][]=round($_POST[vlrcre],2);
		 					$_POST[ddebitos][]=round($_POST[vlrdeb],2);
		 					$_POST[agregadet]=0;
		 					echo"
								<script>
									document.form2.cuenta.value='';
									document.form2.ncuenta.value='';
									document.form2.tercero.value='';
									document.form2.ntercero.value='';
									document.form2.cc.value='';
									document.form2.ncc.value='';
									document.form2.detalle.value='';
									document.form2.vlrcre.value=0;
									document.form2.vlrdeb.value=0;
									document.form2.cuenta.focus();	
									document.form2.cuenta.select();
							 	</script>";
		  				}
		  				$co="saludo1a";
		  				$co2="saludo2";
		  				$_POST[cuentadeb]=0;
		  				$_POST[cuentacred]=0;
		  				$_POST[diferencia]=0;
		  				$_POST[diferencia2]=0;
		 				$cuentacred=0;
		 				$cuentadeb=0;	 
 						$diferencia=0;	 
		 				for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 				{
							$lectura="readonly ";
							if($_POST[tipocomprobante]=="16"){$lectura="'";}
							echo "
							<tr class='$co'>
								<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
								<input type='hidden' name='dncuentas[]' value='".ucfirst(strtolower($_POST[dncuentas][$x]))."'/>
								<input type='hidden' name='dterceros[]' value='".$_POST[dterceros][$x]."'/>
								<input type='hidden' name='dnterceros[]' value='".buscatercero($_POST[dterceros][$x])."'/>
								<input type='hidden' name='dccs[]' value='".$_POST[dccs][$x]."'/>
								<input type='hidden' name='ddetalles[]' value='".ucfirst(strtolower($_POST[ddetalles][$x]))."'/>
								
								<td>".$_POST[dcuentas][$x]."</td>
								<td>".ucfirst(strtolower($_POST[dncuentas][$x]))."</td>
								<td>".$_POST[dterceros][$x]."</td>
								<td>".buscatercero($_POST[dterceros][$x])."</td>
								<td>".$_POST[dccs][$x]."</td>
								<td>".ucfirst(strtolower($_POST[ddetalles][$x]))."</td>
								<td><input type='text' name='ddebitos[]' value='".$_POST[ddebitos][$x]."' class='inpnovisibles' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)' onChange='calcular();' $lectura style='width:100%;text-align:right;'/></td>
								<td><input type='text' name='dcreditos[]' value='".$_POST[dcreditos][$x]."' class='inpnovisibles'  onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)' onChange='calcular();' $lectura style='width:100%; text-align:right;'/></td>
								<td ><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
							</tr>";
							$cred=$_POST[dcreditos][$x];
		 					$deb=$_POST[ddebitos][$x];
		 					$cred=$cred;
		 					$deb=$deb;	
		 					$cuentacred=$cuentacred+$cred;
		 					$cuentadeb=$cuentadeb+$deb;	
		 					$diferencia=$cuentadeb-$cuentacred;
		 					$total=number_format($total,2,",","");
							$_POST[diferencia]=$diferencia;
							$_POST[diferencia2]=number_format($diferencia,2,".",",");
							$_POST[cuentadeb]=number_format($cuentadeb,2,".",",");
							$_POST[cuentadeb2]=$cuentadeb;
							$_POST[cuentacred]=number_format($cuentacred,2,".",",");	 
							$_POST[cuentacred2]=$cuentacred;
							$aux=$co;
							$co=$co2;
		 					$co2=$aux;
		 				}
		 				echo "
						<tr>
							<td></td>
							<td></td>
							<td >Diferencia:</td>
							<td colspan='2'><input type='hidden' id='diferencia' name='diferencia' value='$_POST[diferencia]' ><input id='diferencia2' name='diferencia2' value='$_POST[diferencia2]' type='text' readonly></td>
							<td>Totales:</td>
							<td class='saludo2'><input name='cuentadeb2' type='hidden' id='cuentadeb2' value='$_POST[cuentadeb2]'><input name='cuentadeb' id='cuentadeb' value='$_POST[cuentadeb]' readonly style='width:100%;text-align:right;'/></td>
							<td class='saludo2'><input id='cuentacred' name='cuentacred' value='$_POST[cuentacred]' readonly style='width:100%;text-align:right;'/><input id='cuentacred2' type='hidden' name='cuentacred2' value='$_POST[cuentacred2]' ></td>
						</tr>";
					?>
				</table>  
			</div> 
	  		<?php 
				//********** GUARDAR EL COMPROBANTE ***********
				
				if($_POST[oculto]=='3')	
				{
					$fechaf=$_POST[fecha];
					$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
					if($bloq>=1)
					{						
						$sqlr="select fijo from tipo_comprobante where codigo='$_POST[tipocomprobante]'";
						$res2=mysql_query($sqlr,$linkbd);
						$rt=mysql_fetch_row($res2);
						if($rt[0]=='N') //**** validacion tipo comprobante
 						{	
							$fechaf=$_POST[fecha];
		 					$sqlr="update comprobante_cab set numerotipo=$_POST[ncomp],tipo_comp=$_POST[tipocomprobante],fecha='$fechaf', concepto='$_POST[concepto]',total=0,total_debito=$_POST[cuentadeb2],total_credito=$_POST[cuentadeb2],diferencia=$_POST[diferencia], estado='$_POST[estado]' where tipo_comp='$_POST[tipocomprobante]' and numerotipo='$_POST[ncomp]'";
							if (!mysql_query($sqlr,$linkbd))
							{
	 							echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>Ocurri? el siguiente problema:<br><pre></pre></center></td></tr></table>";
							}
  							else
  		 					{
								echo "<script>despliegamodalm('visible','3','Se ha modificado el encabezado con Exito');</script>";
 								$sqlr="delete from comprobante_det where id_comp='$_POST[tipocomprobante] $_POST[ncomp]'";
								mysql_query($sqlr,$linkbd);
		 						for ($x=0;$x<count($_POST[dcuentas]);$x++)
		  						{
		 							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('$_POST[tipocomprobante] $_POST[ncomp]','".$_POST[dcuentas][$x]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','".$_POST[ddetalles][$x]."','',".$_POST[ddebitos][$x].",".$_POST[dcreditos][$x].",'1','".$vigusu."')";
		 							if (!mysql_query($sqlr,$linkbd))
									{
			 							echo "<table ><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
		 								$e =mysql_error($respquery);
	 									echo "Ocurrio el siguiente problema:<br><pre></pre></center></td></tr></table>";
									}
  									else {echo "<script>despliegamodalm('visible','3','Se ha modificado el comprobante con Exito ');</script>";}
		  						}
							} 
 						}//**** fin validacion tipo comprobante
					}
					else{echo "<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";}
				}
				//DUPLICAR LOS COMPROBANTES MANUALES
				if($_POST[oculto]=='4' && $_POST[duplicar]=='2')	
				{
					$fechaf=$_POST[fecha];
					$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
					if($bloq>=1)
					{						
						$sqlr="select fijo from tipo_comprobante where codigo='$_POST[tipocomprobante]'";
						$res2=mysql_query($sqlr,$linkbd);
						$rt=mysql_fetch_row($res2);
						//echo $rt[0];
						if($rt[0]=='N') //**** validacion tipo comprobante
 						{	
							$sqlr="select * from comprobante_cab where tipo_comp=$_POST[tipocomprobante]  ORDER BY numerotipo DESC";
							$res=mysql_query($sqlr,$linkbd);
							$r=mysql_fetch_row($res);
	 						$nuevocomp=$r[1]+1;
							$fechaf=$_POST[fecha];
		 					$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) values ($nuevocomp,$_POST[tipocomprobante],'$fechaf', '$_POST[concepto]',0,$_POST[cuentadeb2],$_POST[cuentacred2],$_POST[diferencia], '$_POST[estado]')";	
							if (!mysql_query($sqlr,$linkbd))
							{
	 							echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici?n: <br><font color=red><b>$sqlr</b></font></p>Ocurri? el siguiente problema:<br><pre></pre></center></td></tr></table>";
							}
  							else
  		 					{
								echo "<script>despliegamodalm('visible','3','Se ha Duplicado el Comprobante con Exito');</script>";
 								//$sqlr="delete from comprobante_det where id_comp='$_POST[tipocomprobante] $nuevocomp'";
								//mysql_query($sqlr,$linkbd);
		 						for ($x=0;$x<count($_POST[dcuentas]);$x++)
		  						{
		 							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('$_POST[tipocomprobante] $nuevocomp','".$_POST[dcuentas][$x]."','".$_POST[dterceros][$x]."','".$_POST[dccs][$x]."','".$_POST[ddetalles][$x]."','',".$_POST[ddebitos][$x].",".$_POST[dcreditos][$x].",'1','".$vigusu."')";
		 							if (!mysql_query($sqlr,$linkbd))
									{
		 								echo "<table ><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici?n: <br><font color=red><b>$sqlr</b></font></p>";
		 								$e =mysql_error($respquery);
	 									echo "Ocurrio el siguiente problema:<br>pre></pre></center></td></tr></table>";
									}
  									else
  		 	  						{
										$_POST[oculto]='1';
										$_POST[duplicar]='';
										echo "
											<script>
												document.form2.oculto.value=1;
												setTimeout (\"alert ('Duplicando');\", 8000); 
												document.form2.submit();
											</script>";
		  	   						}
		  						}
							} 
 						}//**** fin validacion tipo comprobante
					}
					else {echo "<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";}
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