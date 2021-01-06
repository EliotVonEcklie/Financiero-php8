<?php
	error_reporting(0);
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
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
        <title>:: SPID - Presupuesto</title>
        <script src="css/programas.js"></script>
        <script src="css/calendario.js"></script>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<script>
			//************* ver reporte ************
			//***************************************
			function verep(idfac){document.form1.oculto.value=idfac;document.form1.submit();}
			//************* genera reporte ************
			//***************************************
			function genrep(idfac){document.form2.oculto.value=idfac;document.form2.submit();}
			//************* genera reporte ************
			//***************************************
			function redireccionardestino()
			{
				valordir=document.form2.destinocdp.value;
				switch(valordir)
				{
					case '1':
					document.location='ccp-cdpcontra.php?vdir=1';
					break;

					case '2':
					document.location='ccp-cdp.php?vdir=2';
					break;

					case '3':
					document.location='ccp-cdpnomina.php?vdir=3';
					break;
				}
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
							document.getElementById('ventana2').src="ccp-solicitudproceso.php";break;
					}
				}
			}
			function guardar()
			{

				var fechabloqueo=document.form2.fechabloq.value;
			 	var fechadocumento=document.form2.fecha.value;
			 	var nuevaFecha=fechadocumento.split("/");
			 	var fechaCompara=nuevaFecha[2]+"-"+nuevaFecha[1]+"-"+nuevaFecha[0];
				
			 	if((Date.parse(fechabloqueo)) > (Date.parse(fechaCompara))){
					despliegamodalm('visible','2','Fecha de documento menor que fecha de bloqueo');
				}else{
		
					var vigencia="<?php echo vigencia_usuarios($_SESSION[cedulausu]) ?>";
					if(vigencia==nuevaFecha[2]){
						if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.solicita.value!='')
  				{
					
					var sal=document.getElementById("pasa").value;
					if(sal=="0"){
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');
			
					}else{
						despliegamodalm('visible','2','El rubro '+sal+" excede el saldo permitido");
					}
					
					
  				}
  				else
				{
  					despliegamodalm('visible','2','Falta infomacion para poder agregar','1');
  					document.form2.fecha.focus();document.form2.fecha.select();
  				}
					}else{
					despliegamodalm('visible','2','La fecha del documento debe coincidir con su vigencia');
					}
				}

				
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
				
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
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			} 
			function validar(formulario)
			{document.form2.chacuerdo.value=2;document.form2.action="ccp-cdpcontra.php";document.form2.submit();}
			function validar2(formulario)
			{document.form2.chacuerdo.value=2;document.form2.action="ccp-cdp.php";document.form2.submit();}
			function validarcdp()
			{
				valorp=document.getElementById("valor").value;
				nums=quitarpuntos(valorp);			
				if(nums<0 || nums> parseFloat(document.form2.saldo.value))
				{
					despliegamodalm('visible','2','Valor Superior al Disponible '+document.form2.saldo.value,'1');
					document.form2.cuenta.select();document.form2.cuenta.focus();
				}
			}
			function buscacta(e)
 			{if (document.form2.cuenta.value!=""){document.form2.bc.value=2;document.form2.submit();}}
			function agregardetalle()
			{
				if(document.form2.cuenta.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >=0 )
				{document.form2.agregadet.value=1;document.form2.submit();}
				else {despliegamodalm('visible','2','Falta infomacion para poder agregar','1');}
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
			function pdf()
			{
				document.form2.action="pdfcdispre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}

			function finaliza()
 			{
  				if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
  				{document.form2.fin.value=1;document.form2.fin.checked=true; } 
  				else
				{
  	  				document.form2.fin.value=0;
  				document.form2.fin.checked=false; 
				}
 			}
			function capturaTecla(e)
			{ 
				var tcl = (document.all)?e.keyCode:e.which;
				if (tcl==115){alert(tcl);return tabular(e,elemento);}
			}
			function funcionmensaje()
			{
				var numdocar=document.getElementById('numero').value;
				var vigencar=document.getElementById('vigencia').value;
				window.location.href = "ccp-cdpver.php?is="+numdocar+"&vig="+vigencar;
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
		</script>
        <?php titlepag();?>
	</head>
	<body >
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
					<a href="ccp-cdpcontra.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a><img src="imagenes/busca.png" title="Buscar"  onClick="location.href='ccp-buscacdp.php'" class="mgbt"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a><a href="ccp-gestioncdp.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
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
			$linkbd=conectar_bd();
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]); 
			$vigencia=$vigusu;
			//*******************************
			if(!$_POST[oculto])
			{
				$_POST[destinocdp]=$_GET[vdir];
 		 		$fec=date("d/m/Y");
		 		$_POST[fecha]=$fec; 	
		 		$_POST[valor]=0; 			 
		 		$_POST[cuentaing]=0;
		 		$_POST[cuentagas]=0;
 		 		$_POST[cuentaing2]=0;
				$_POST[cuentagas2]=0;
		 		$link=conectar_bd();
				$sqlr="SELECT MAX(consvigencia) FROM pptocdp WHERE vigencia=$_POST[vigencia] ";
				$res=mysql_query($sqlr,$link);	
				while($r=mysql_fetch_row($res))
				{$maximo=$r[0];}
				if(!$maximo){$_POST[numero]=1;}
				else{$_POST[numero]=$maximo+1;}
			}
			//*******************************
			if($_POST[chacuerdo]=='2')
			{
				$_POST[dcuentas]=array();	 
			 	$_POST[dncuentas]=array();	 
			 	$_POST[dgastos]=array();	 
			 	$_POST[dcfuentes]=array();	 
			 	$_POST[dfuentes]=array();	 
			 	$_POST[cuentagas2]=0;
			 	$_POST[cuentagas]=0;
			}
 			$sqlr="SELECT contrasolicitudcdp_det.rubro,contrasolicitudcdp_det.valor, contrasoladquisiciones.objeto, contrasoladquisiciones.codsolicitante FROM  contrasoladquisiciones , contrasolicitudcdp_det WHERE contrasoladquisiciones.codsolicitud=$_POST[idliq] AND  contrasolicitudcdp_det.proceso=$_POST[idliq] AND contrasoladquisiciones.codsolicitud= contrasolicitudcdp_det.proceso AND contrasolicitudcdp_det.vigencia=$vigusu";
		$res=mysql_query($sqlr,$linkbd); 
		$_POST[agregadet]='';		
		$cont=0;
		while ($row=mysql_fetch_row($res)) 
		 {		
		 $_POST[objeto]=$row[2];
		 $solicitante="";
		 $codsolicita=explode("-",$row[3]);
		 foreach ($codsolicita as &$valor)
		 {	
		 	$coincidencia=strpos($solicitante, buscar_empleado($valor,1));
			if($coincidencia===false)
			{
		 		if ($solicitante==""){$solicitante=buscar_empleado($valor,1);}
				else{$solicitante=$solicitante.", ".buscar_empleado($valor,1);}
			}
		 }
		 unset($valor);
		 
		 //echo "ddd ".$solicitante;
		 $_POST[solicita]=$solicitante;		 
		 $_POST[dcuentas][$cont]=$row[0];	 
		 $_POST[dncuentas][$cont]=buscacuentapres($row[0]);
		 $_POST[dgastos][$cont]=$row[1];
		 $fuente=buscafuenteppto($row[0],$vigusu);
		  $infofte = explode("_", $fuente);	 
		 $_POST[dcfuentes][$cont]=$infofte[0];
		 $_POST[dfuentes][$cont]=$infofte[1];
		 $cont=$cont+1;
		 }			
		?>

 <form name="form2" method="post" action="">
 				<?php
				$sesion=$_SESSION[cedulausu];
				$sqlr="Select dominios.valor_final from usuarios,dominios where usuarios.cc_usu=$sesion and dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial=usuarios.cc_usu ";
				$resp = mysql_query($sqlr,$linkbd);
				$fechaBloqueo=mysql_fetch_row($resp);
				echo "<input type='hidden' name='fechabloq' id='fechabloq' value='$fechaBloqueo[0]' />";

				?>
	<table class="inicio">
		<tr>
			<td class="titulos" colspan="8">.: Disponibilidad Presupuestal </td>
		</tr>
		<tr>
		 	<td class="saludo1" style="width:6.5%;">
					CDP
			</td>
			<td>
				<select name="destinocdp" id="destinocdp" onChange="redireccionardestino()">
					<option value="1" <?php if($_POST[destinocdp]=='1') echo "SELECTED"; ?>>CDP Contratacion</option>
					<option value="2" <?php if($_POST[destinocdp]=='2') echo "SELECTED"; ?>>CDP Basico</option>
					<option value="3" <?php if($_POST[destinocdp]=='3') echo "SELECTED"; ?>>CDP Nomina</option>
				</select>
			</td>
		</tr>
	</table>
    <table class="inicio" align="center" width="80%" >
    	<tr>
        	<td class="titulos" colspan="8">.: Certificado Disponibilidad Presupuestal </td>
        	<td width="65" class="cerrar" ><a href="ccp-principal.php">Cerrar</a></td>
     	</tr>
     	<tr>
		 	<td class="saludo1">Vigencia:</td><td style="width: 5%"><input style="width: 100%" type="text" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly></td>
	  		<td width="width:6%" class="saludo1">Numero:</td>
			<td style="width: 5%"><input name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>" style="width: 100%" readonly></td>
			<td class="saludo1" style="width: 10%">Solicitud Proceso:</td>
			<td style="width: 10%">
				<input type="text" id="idliq" name="idliq" onKeyUp="return tabular(event,this)" onBlur="validar()" value="<?php echo $_POST[idliq]?>" onClick="document.getElementById('idliq').focus(); document.getElementById('idliq').select();" style="width:70%" >
    			<input type="hidden" value="0" name="bcrubro" id="bcrubro"><a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;" border="0"></a>
		  	</td>
	 		<td width="79" class="saludo1">Fecha:        </td>
        	<td colspan="4"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" align="absmiddle" border="0" style="width:20px; cursor:pointer;"></a>        <input type="hidden" name="chacuerdo" value="1">		  </td></tr><tr>
	   		<td class="saludo1"><input type="hidden" value="1" name="oculto">
	 	 	Solicita:</td>
	   		<td colspan="5"><input name="solicita" type="text" id="solicita" 
		  	onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" style="width: 100%"></td>
	   		<td class="saludo1">Objeto:</td><td width="632"><input name="objeto" type="text" id="objeto"  
		  	onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" size="90"></td>
	    </tr></table>	   
	<?php
	if(!$_POST[oculto])
	{ 
		 ?>
		 <script>
    	document.form2.cuenta.focus();
		</script>
	<?php
	}
	?>
		 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $tipo=substr($_POST[cuenta],0,1);			 
			  $nresul=buscacuentapres($_POST[cuenta],$tipo);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();
			  </script>
			  <?php
			  $linkbd=conectar_bd();
		  $ind=substr($_POST[cuenta],0,1);
		   $ind=substr($_POST[cuenta],0,1);
			  	if($ind=='R' || $ind=='r')
					 {						
					$ind=substr($_POST[cuenta],1,1);						  					  
					$criterio="and (pptocuentaspptoinicial.vigencia=".$vigusu." or  pptocuentaspptoinicial.vigenciaf=$vigusu)";					  
					 }
			  if ($ind=='2')
			  $sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldos,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
			  if ($ind=='3' || $ind=='4')
			 $sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldos,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
    			if($row[1]!='' || $row[1]!=0)
			     {
				  $_POST[cfuente]=$row[0];
				  $_POST[fuente]=$row[2];
				  $_POST[valor]=0;			  
				  $_POST[saldo]=generaSaldo($_POST[cuenta],$_POST[vigencia],$_POST[vigencia]);			  
				 }
				 else
				  {
					  
				   /*$_POST[cfuente]="";
	  			   $_POST[fuente]="";
				   $_POST[valor]="";			  
				   $_POST[saldo]="";
				   $_POST[cuenta]="";			  
				   $_POST[ncuenta]="";			  */
				  }  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  $_POST[fuente]="";
			   $_POST[valor]="";
	//		 echo "dd:".$sqlr;
			  ?>
             
			  <script>alert("Cuenta Incorrecta");
			   document.form2.fuente.value='';
			  document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
		?>
		<div class="subpantalla" style="height:72%; width:99.6%; overflow-x:hidden;">
		<table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="5">Detalle CDP</td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Fuente</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png"></td>
		</tr>
		<?php 
		if ($_POST[elimina]!='')
		 { 
		 $posi=$_POST[elimina];
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
		  $cuentagas=0;
		  $cuentaing=0;
		   $diferencia=0;
		  // array_splice($_POST[dcuentas],$posi, 1);
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dgastos][$posi]);		 		 		 		 		 
		 unset($_POST[dcfuentes][$posi]);		 		 
		 unset($_POST[dfuentes][$posi]);		 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 
		 $_POST[dgastos]= array_values($_POST[dgastos]); 
		 $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
		 $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 		 	
		 $_POST[elimina]='';	 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
			$ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
			if($ch!='1')
			 {			 
		  $cuentagas=0;
		  $cuentaing=0;
		  $diferencia=0;
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 $_POST[dfuentes][]=$_POST[fuente];
		 $_POST[dcfuentes][]=$_POST[cfuente];		 
	  	 $_POST[valor]=str_replace(".","",$_POST[valor]);
		 $_POST[dgastos][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.cuenta.value="";
				document.form2.ncuenta.value="";
				document.form2.fuente.value="";
				document.form2.cfuente.value="";				
				//document.form2.cuenta.select();
		  		document.form2.cuenta.focus();	
		 </script>
		  <?php
			}
			else
			 {
			?>
		 <script>
		  	 alert('Ya existe este Rubro en el CDP');
		</script>
			<?php
			 }
		  }
		  ?>
                   <input type='hidden' name='elimina' id='elimina'>
          <?php
		  // echo "<TR><TD>t :".count($_POST[dcuentas])."</TD></TR>";
		 for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 {
		 
		 echo "<tr><td class='saludo2'><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='20' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly></td><td class='saludo2'><input name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."' type='hidden'><input name='dfuentes[]' value='".$_POST[dfuentes][$x]."' type='text' size='45' readonly></td><td class='saludo2'><input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text' size='15' onDblClick='llamarventana(this,$x)' readonly></td><td class='saludo2'><a href='#' onclick=''><img src='imagenes/del.png'></a></td></tr>";
		 $gas=$_POST[dgastos][$x];

		 $gas=$gas;
		 $cuentagas=$cuentagas+$gas;
		 $_POST[cuentagas2]=$cuentagas;
		 $total=number_format($total,2,",","");
 		 $_POST[cuentagas]=number_format($cuentagas,2,".",",");
			$resultado = convertir($_POST[cuentagas2]);
			$_POST[letras]=$resultado." Pesos";
		 }
		 echo "<tr><td ></td><td colspan='1'></td><td class='saludo1'></td><td class='saludo1'><input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' readonly><input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'><input id='letras' name='letras' value='$_POST[letras]' type='hidden'></td></tr>";
		 echo "<tr><td class='saludo1'>Son:</td><td class='saludo1' colspan= '4'>$resultado</td></tr>";
		?>
		</table>
		</div>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
				</IFRAME>
			</div>
		</div>
    </form>
  <?php
  
  //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
  function generaSaldoCuenta(){
	   $retorno="0";
	   
	for ($i=0;$i<count($_POST[dcuentas]);$i++)
		{
		
		$saldo=generaSaldo($_POST[dcuentas][$i],$_POST[vigencia],$_POST[vigencia]);
		if($saldo<$_POST[dgastos][$i]){
		$retorno=$_POST[dcuentas][$i];
		
		break;
		}
		
					
		}	
		
		return $retorno;
	}
				$saldo=generaSaldoCuenta();
				echo "<input type='hidden' name='pasa' id='pasa' value='$saldo' />";	
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
	if($bloq>=1)
	{
		$linkbd=conectar_bd();
		$sqlr="select count(*) from pptocdp where vigencia='$_POST[vigencia]' and consvigencia=$_POST[numero]";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		{
			$numerorecaudos=$r[0];
		}
		if($numerorecaudos==0)
		{
			$nr="1";	 	
			//************** modificacion del presupuesto **************
			$sqlr="insert into pptocdp (vigencia,consvigencia,fecha,valor,estado,solicita,objeto,tipo_mov) values($_POST[vigencia],$_POST[numero],'$fechaf	',$_POST[cuentagas2],'S','$_POST[solicita]','$_POST[objeto]','201')";
			if (!mysql_query($sqlr,$linkbd))
			{
				echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b> <img src='imagenes\alert.png'> </b></font></p>";
				echo "Ocurri� el siguiente problema:<br>";
				echo "<pre>";
				echo "</pre></center></td></tr></table>";
				echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n: ');</script>";
			}
			else
			{
				echo "<table class='inicio'><tr><td class='saludo1'>Se ha almacenado el CDP con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
				$sqlr="UPDATE contrasoladquisiciones SET codcdp='$_POST[numero]' WHERE codsolicitud=".$_POST[idliq];
				mysql_query($sqlr,$linkbd);
				$sqlr="UPDATE contrasolicitudcdpppto SET ndoc='$_POST[numero]' WHERE proceso=".$_POST[idliq];
				mysql_query($sqlr,$linkbd);
			
			}	
			for ($x=0;$x<count($_POST[dcuentas]);$x++)
			{
				$sqlr="update pptocuentaspptoinicial set saldos=saldos-".$_POST[dgastos][$x]." where cuenta='".$_POST[dcuentas][$x]."' and (vigencia=$vigusu or vigenciaf=$vigusu)";
				$res=mysql_query($sqlr,$linkbd); 
				$sqlr="insert into pptocdp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[numero]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'201')";
				$res=mysql_query($sqlr,$linkbd);
			
			}
			echo "<script>despliegamodalm('visible','1','Se ha almacenado el CDP con Exito');</script>";
		}
		else
		{
			echo "<script>despliegamodalm('visible','2','Ya existe un CDP con este consecutivo');</script>";
		}
	}
	else
	{
		echo "<script>despliegamodalm('visible','2','No tiene los permiso suficientes');</script>";	
	}
}//*** if de control de guardado
?> 
</td></tr>     
</table>
</body>
<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('�Realmente desea cambiar la vigencia?');
   if(confirma){
    var anobloqueo=bloqueo.split("-");
    var ano=anobloqueo[0];
    if(valor < ano){
      if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
      }else{
        location.reload();
      }

    }else{
      $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
    }
    
   }else{
   	location.reload();
   }
   
 });

 function updateresponse(data){
  json=eval(data);
  if(json[0].respuesta=='2'){
    alert("Vigencia modificada con exito");
  }else if(json[0].respuesta=='3'){
    alert("Error al modificar la vigencia");
  }
  location.reload();
 }
 function selectresponse(data){ 
  json=eval(data);
  $('#cambioVigencia').val(json[0].vigencia);
  bloqueo=json[0].bloqueo;
 }

 }); 
</script>
</html>