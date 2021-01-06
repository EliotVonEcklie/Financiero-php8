<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SPID - Presupuesto</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function guardar()
			{
				if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.solicita.value!='')
				{
					if (confirm("Esta Seguro de Cambiar el destino de compra?"))
					{
						document.form2.oculto.value=2;
						document.form2.submit();
						document.form2.action="pdfcdp.php";
					}
				}
				else
				{
					alert('Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
				}
			}
			function validar(formulario)
			{
				var x = document.getElementById("tipomov").value;
				document.form2.movimiento.value=x;
				document.form2.action="presu-rpver.php";
				document.form2.submit();
			}
			function validar2(formulario)
			{
				document.form2.chacuerdo.value=2;
				document.form2.action="presu-cdp.php";
				document.form2.submit();
			}
			function pdf()
			{
				document.form2.action="pdfrprecom.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function finaliza()
			{
				if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
				{
					document.form2.fin.value=1;
					document.form2.fin.checked=true; 
				} 
				else {document.form2.fin.value=0;}
				document.form2.fin.checked=false; 
			}
			function capturaTecla(e)
			{ 
				var tcl = (document.all)?e.keyCode:e.which;
				if (tcl==115){
				alert(tcl);
				return tabular(e,elemento);
				}
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					document.form2.action="presu-rpver.php";
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					document.form2.action="presu-rpver.php";
					document.form2.submit();
				}
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="presu-rpver.php";
				document.form2.submit();
			}
		</script>
		<?php titlepag();?>
	</head>
	<body >
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("presu");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='presu-rp.php'" class="mgbt"/><img src="imagenes/guardad.png" title="Guardar" onClick="#" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='presu-buscarp.php'" class="mgbt"/><img src="imagenes/agenda1.png" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt" title="Agenda"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt" ><img  src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='presu-buscarp.php'"class="mgbt"/></td>
			</tr>
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			$oculto=$_POST['oculto'];
			if(!$_POST[oculto])
			{
				$_POST[vigencia]=$vigusu;
				$_POST[ncomp]=$_GET[is];
				$_POST[idcomp]=$_GET[is];
				$_POST[tipomov]='201';
				$sqlr="select consvigencia from  pptorp where vigencia='$vigusu' and tipo_mov='201' ORDER BY consvigencia DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
			}
			$_POST[dcuentas]=array();
			$_POST[dncuentas]=array();
			$_POST[dingresos]=array();
			$_POST[dgastos]=array();
			$_POST[drecursos]=array();
			$_POST[dnrecursos]=array();		
			$_POST[fechacdp]="";	
			$_POST[fecha]="";	
			$_POST[solicita]=""; 	
			$_POST[objeto]=""; 	
			$_POST[valorrp]="";
			$_POST[saldo]="";
			$_POST[vigencia]=""; 	
			$_POST[tercero]="";
			$_POST[ntercero]="";
			$_POST[estado]="";
			$_POST[numerocdp]="";
			$_POST[estadoc]="";
			$_POST[ncontrato]="";
			$sqlr="select * from pptorp, pptocdp where pptorp.idcdp=pptocdp.consvigencia  and pptorp.consvigencia=$_POST[ncomp] and  pptorp.vigencia=$vigusu and pptocdp.tipo_mov='201' and pptorp.tipo_mov=$_POST[tipomov] ";
			$res=mysql_query($sqlr,$linkbd); 
			$cont=0;
			while ($row=mysql_fetch_row($res)) 
 			{
				switch($row[3])
				{
					case 'S':	$_POST[estadoc]='ACTIVO';
								$color=" style='background-color:#0CD02A ;color:#fff'";
								break;
					case 'C':	$_POST[estadoc]='COMPLETO'; 	 				
								$color=" style='background-color:#00CCFF ; color:#fff'";
								break;
					case 'N':	$_POST[estadoc]='ANULADO'; 
								$color=" style='background-color:#aa0000 ; color:#fff'";
								break;
					case 'R':	$_POST[estadoc]='REVERSADO'; 
								$color=" style='background-color:#aa0000 ; color:#fff'";
								break;
				}
				$sqlr1="select concepto from pptocomprobante_cab where tipo_comp='7' and vigencia='$vigusu' and numerotipo='$_POST[ncomp]'";
				$res1=mysql_query($sqlr1,$linkbd); 
				$row1=mysql_fetch_row($res1);
				$separar=explode(' - ',$row[16]);
				$_POST[numerocdp]=$row[2];
				$_POST[numero]=$_POST[ncomp];
				$p1=substr($row[16],0,4);
				$p2=substr($row[16],5,2);
				$p3=substr($row[16],8,2);
				$_POST[fechacdp]="$p3-$p2-$p1";	
				$p1=substr($row[4],0,4);
				$p2=substr($row[4],5,2);
				$p3=substr($row[4],8,2);
				$_POST[fecha]=$p3."/".$p2."/".$p1;	
				$_POST[solicita]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[19]);
				$_POST[objeto]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[11]); 	
				$_POST[valorrp]=$row[6];
				$_POST[saldo]=generaSaldoRP($_POST[idcomp],$vigusu);
				$_POST[vigencia]=$row[0]; 	
				$_POST[tercero]=$row[5];
				$_POST[ntercero]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",buscatercero($_POST[tercero]));
				$_POST[estado]=$row[3];
				$_POST[ncontrato]=$row[8];
				$cont=$cont+1;
			}
			//**** busca cuenta
			if ($_POST[chacuerdo]=='2')
			{
				$_POST[dcuentas]=array();
				$_POST[dncuetas]=array();
				$_POST[dingresos]=array();
				$_POST[dgastos]=array();
				$_POST[drecursos]=array();
	 			$_POST[dnrecursos]=array();	
				$_POST[diferencia]=0;
				$_POST[cuentagas]=0;
				$_POST[cuentaing]=0;																			
			}	 
		?>
		<form name="form2" method="post" action="">
			<table class="inicio" width="99.6%" >
				<tr>
					<td class="titulos" colspan="10">.: Registro Presupuestal </td>
					<td class="cerrar" style='width:7%' onClick="location.href='presu-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1">N&uacute;mero:</td>
					<input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>"/>
					<input type="hidden" name="ncomp" value="<?php echo $_POST[ncomp]?>"/>
					<input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente"/>
					<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"/>
					<input type="hidden" name="numero" id="numero" value="<?php echo $_POST[numero] ?>"/>
					<td style="width:9%"><img src="imagenes/back.png" title="Anterior" onClick="atrasc()" class="icobut"/>&nbsp;<input type="text" name="idcomp" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)"  onBlur="validar2()"/>&nbsp;<img src="imagenes/next.png" title="Siguiente" onClick="adelante()" class="icobut"/></td>
					<td  class="saludo1">Fecha:</td>
					<td><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="30" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly/>&nbsp;</td>
					<td width="130" class="saludo1">Vigencia:</td>
					<td width="50"><input size="4" type="text" name="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly></td>
					<td width="30" class="saludo1">Contrato:</td>
					<td width="60" ><input id="ncontrato" type="text" name="ncontrato" size="6" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)"  value="<?php echo $_POST[ncontrato]?>" ></td><td width="25" class="saludo1">Estado</td>
					<td width="165" ><input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" size="6" readonly  <?php echo $color; ?>/>&nbsp;<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar()" style="float:right">
					<?php
						$codMovimiento='201';
						if(isset($_POST['movimiento']))
						{
							if(!empty($_POST['movimiento'])){$codMovimiento=$_POST['movimiento'];}
						}
						$sql="SELECT tipo_mov FROM pptorp where consvigencia=$_POST[ncomp] AND vigencia='$vigusu' ORDER BY tipo_mov";
						$resultMov=mysql_query($sql,$linkbd);
						$movimientos=Array();
						$movimientos["201"]["nombre"]="201-Documento de Creacion";
						$movimientos["201"]["estado"]="";
						$movimientos["401"]["nombre"]="401-Reversion Total";
						$movimientos["401"]["estado"]="";
						$movimientos["402"]["nombre"]="402-Reversion Parcial";
						$movimientos["402"]["estado"]="";
						while($row = mysql_fetch_row($resultMov))
						{
							$mov=$movimientos[$row[0]]["nombre"];
							$movimientos[$codMovimiento]["estado"]="selected";
							$state=$movimientos[$row[0]]["estado"];
							echo "<option value='$row[0]' $state>$mov</option>";
						}
						$movimientos[$codMovimiento]["estado"]="";
						echo "<input type='hidden' id='movimiento' name='movimiento' value='$_POST[movimiento]' />";
					?>        
					</select></td>
				</tr>
				<tr>
					<td width="125" class="saludo1">Numero CDP:</td>
					<td width="298"><input name="numerocdp" type="text" id="numerocdp" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numerocdp]?>" size="20" readonly></td>
					<td width="79" class="saludo1">Fecha CDP:</td>
					<td ><input name="fechacdp" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="30" value="<?php echo $_POST[fechacdp]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly></td>
					<td class="saludo1">Tercero:</td>
					<td  colspan="5"><input id="tercero" type="text" name="tercero" size="12" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" readonly>&nbsp;&nbsp;<input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="68" readonly></td>
					<input type="hidden" value="0" name="bt">
				</tr>
				<tr>
					<input type="hidden" value="1" name="oculto">
					<td class="saludo1">Solicita:</td>
					<td colspan="3"><input name="solicita" type="text" id="solicita" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" size="75" readonly></td>
					<td class="saludo1">Objeto:</td>
					<td colspan='5'><input name="objeto" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo htmlspecialchars(strtoupper($_POST[objeto]))?>" size="90" readonly> </td>
				</tr>
				<tr>
					<td class="saludo1">Valor RP:</td>
					<td><input name="valorrp" type="text" value="<?php echo $_POST[valorrp]?>" readonly></td>
					<td class="saludo1">Saldo:</td>
					<td><input name="saldo" type="text" value="<?php echo $_POST[saldo]?>" size="30" readonly></td>
					<td class="saludo1" style="width:10%">Destino de compra:</td>
            <td width="21%"> 
							<select name="destcompra" id="destcompra" style="width: 95%">
								<?php
									if($_POST[oculto]!='2')
									{
										$sq = "SELECT * FROM pptorp_almacen WHERE id_rp='$_POST[idcomp]' AND vigencia='$_POST[vigencia]'";
										$resalma = mysql_query($sq,$linkbd);
										$rowalma = mysql_fetch_row($resalma);
										$_POST[destcompra] = '';
										if($rowalma[0]!='')
										{
											$_POST[destcompra] =$rowalma[1];
										}
									}
									
									$sql="SELECT * FROM almdestinocompra WHERE estado='S' ORDER BY codigo";
									$result=mysql_query($sql,$linkbd);
									while($row = mysql_fetch_row($result)){
										if($_POST[destcompra]==$row[0]){
											echo "<option value='$row[0]' SELECTED>$row[1]</option>";
										}else{
											echo "<option value='$row[0]'>$row[1]</option>";
										}
										
									}
								?>
							</select>
						</td>
						<td colspan="3"><em class="botonflecha" onClick="guardar()">Cambiar Destino</em></td>
					<?php
						if($_POST[movimiento]=='401' || $_POST[movimiento]=='402')
						{
							$sqlr="select detalle from pptorp where consvigencia=$_POST[idcomp] and vigencia=$_POST[vigencia] and tipo_mov like '4%' ";
							$resp = mysql_query($sqlr,$linkbd);
							$row =mysql_fetch_row($resp);
							$_POST[detaller]=$row[0];
							echo"
							<td class='saludo1'>Detalle Reversion:</td>
							<td colspan='5'><input type='text' name='detaller' id='detaller' style='width:100%;' value='$_POST[detaller]' readonly/></td>";
			
						}
					?>
				</tr>
			</table>
        	<div class="subpantalla" style="height:55.5%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" width="99%">
					<tr><td class="titulos" colspan="5">Detalle RP</td></tr>
					<tr>
						<td class="titulos2" style='width:10%'>Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2">Fuente</td>
                        <td class="titulos2" style='width:10%'>Valor</td>
					</tr>
					<?php
						$_POST[dcuentas]=array();
						$_POST[dncuentas]=array();
						$_POST[dgastos]=array();
						$_POST[dfuentes]=array();	
						$_POST[dcfuentes]=array();
						if($_POST[movimiento]!='') 			 			 			 			 		   
							$sqlr="Select * from pptorp_detalle  where vigencia='$vigusu' and consvigencia=$_POST[ncomp] and tipo_mov='$_POST[movimiento]'  order by CUENTA";
						else
							$sqlr="Select * from pptorp_detalle  where vigencia='$vigusu' and consvigencia=$_POST[ncomp] and tipo_mov='201' order by CUENTA";
		 				$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$_POST[dcuentas][]=$row[3];
 	 						$nresul=buscacuentapres($row[3],2);			
							$_POST[dncuentas][]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$nresul);				 
							$_POST[dgastos][]=$row[5];
							$nfuente=buscafuenteppto($row[3],$vigusu);
							$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
							$_POST[dcfuentes][]=$cdfuente;
							$_POST[dfuentes][]=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$nfuente);
						}
						$co="zebra1";
						$co2="zebra2";		
						$_POST[cuentagas]=0;				
						for ($x=0;$x< count($_POST[dcuentas]);$x++)
						{
		 					echo "
							<tr class='$co'>
								<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."' />
								<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
								<input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
								<input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
								<input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'>
								<td>".$_POST[dcuentas][$x]."</td>
								<td>".$_POST[dncuentas][$x]."</td>
								<td>".$_POST[dfuentes][$x]."</td>
								<td style='text-align:right;'>$ ".number_format($_POST[dgastos][$x],2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
							</tr>";
							$gas=$_POST[dgastos][$x];
							$_POST[cuentagas]=$_POST[cuentagas]+$gas;
							$resultado = convertir($_POST[cuentagas]);
							$_POST[letras]=$resultado." PESOS";
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}
		 				echo "
						<input type='hidden' name='cuentagas' id='cuentagas'  value='$_POST[cuentagas]'/>
						<input type='hidden' name='cuentagas2' id='cuentagas2' value='$_POST[cuentagas2]'/>
						<input type='hidden'  name='letras' id='letras' value='$_POST[letras]'/>
						<tr class='$co' style='text-align:right;'>
							<td colspan='3'>Total:</td>
							<td>$ ".number_format($_POST[cuentagas],2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
						</tr>
						<tr>
							<td class='saludo1'>Son:</td>
							<td class='saludo1' colspan= '4'>$_POST[letras]</td>
						</tr>";
		?>
		</table>
 </div>
 <?php
 if($_POST[oculto]=='2')
 {
	 ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	 $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	 //************** modificacion del presupuesto **************
	 $sqlr="UPDATE pptorp set fecha='$fechaf', contrato='$_POST[ncontrato]' where  vigencia='$vigusu' and consvigencia='$_POST[idcomp]' and tipo_mov='201' ";
	 if (!mysql_query($sqlr,$linkbd))
	 {
		 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
		 echo "Ocurri� el siguiente problema:<br>";
		 echo "<pre>";
		 echo "</pre></center></td></tr></table>";
	 }
		 else
		 {
		 echo "<table class='inicio'><tr><td class='saludo1'>Se ha Modificado con Exito <img src='imagenes\confirm.png'></center></tr></table>";
	 }
	 $sqexis = "SELECT * FROM pptorp_almacen WHERE id_rp='$_POST[idcomp]' AND vigencia='$_POST[vigencia]'";
	 $resexis = mysql_query($sqexis,$linkbd);
	 $rowexis = mysql_fetch_row($resexis);
	 if($rowexis[0]!='')
	 {
	//	echo "hola".$_POST[destcompra];
		 $sqlupdate = "UPDATE pptorp_almacen SET destino='$_POST[destcompra]' WHERE id_rp='$_POST[idcomp]' AND vigencia='$_POST[vigencia]'";
		 if (!mysql_query($sqlupdate,$linkbd))
		 {
			 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlupdate</b></font></p>";
			 echo "Ocurri� el siguiente problema:<br>";
			 echo "<pre>";
			 echo "</pre></center></td></tr></table>";
		 }
	 }
	 else
	 {
		 $sqlrinsert = "insert into pptorp_almacen (id_rp,destino,vigencia) values ('$_POST[idcomp]','".$_POST[destcompra]."','$_POST[vigencia]')";
		 if (!mysql_query($sqlrinsert,$linkbd))
		 {
			 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlrinsert</b></font></p>";
			 echo "Ocurri� el siguiente problema:<br>";
			 echo "<pre>";
			 echo "</pre></center></td></tr></table>";
		 }
	 }
	 //********* creacion del cdp ****************
	}//*** if de control de guardado
 ?>
 </form>
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
</body>

</html>