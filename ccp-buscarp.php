<?php //V 1001 20/12/16 Modificado implementacion de Reversion e ingresar al ver con doble clic?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script>
			function selexcel()
			{
				tipocdp=document.form2.tabgroup1.value;
				switch(tipocdp)
				{
					case "1":	document.form2.action="ccp-buscarpexcel.php";break;
					case "2":	document.form2.action="ccp-buscarpexcelr.php";break;
					case "3":	document.form2.action="ccp-buscarpexcelpr.php";break;
				}
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target=""; 
			}
			function selpdf()
			{
				tipocdp=document.form2.tabgroup1.value;
				switch(tipocdp)
				{
					case "1":	document.form2.action="ccp-buscarppdf.php";break;
					case "2":	document.form2.action="ccp-buscarppdfr.php";break;
					case "3":	document.form2.action="ccp-buscarppdfpr.php";break;
				}
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();?>
	</head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='ccp-rp.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("ccpet");?>" class="mgbt"/><img src="imagenes/print.png" title="Imprimir" style="width:29px;"  onClick="selpdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick="selexcel();" class="mgbt"/><img  src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='ccp-gestionrp.php'" class="mgbt"/></td>
			</tr>
		</table>
 		<form name="form2" method="post" action="ccp-buscarp.php">
        	<?php 
				if ($_POST[oculto]==""){$_POST[tabgroup1]=1;}
				switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';break;
                }
			?>
			<table width="100%" align="center"  class="inicio" >
      			<tr>
        			<td class="titulos" colspan="9" style='width:93%'>:: Buscar .: Registro Presupuestal </td>
        			<td class="cerrar" style='width:7%' onClick="location.href='ccp-principal.php'">Cerrar</td>
             		<input type="hidden" name="oculto" id="oculto" value="1">
    			</tr>                       
    			<tr>
    				<td class="saludo1" >Vigencia:</td>
    				<td><input type="search" name="vigencia" value="<?php echo $_POST[vigencia] ?>" style='width:95%' onKeyUp="return tabular(event,this)"/></td>
    				<td class="saludo1" >N&uacute;mero:</td>
    				<td><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero] ?>" style='width:95%' onKeyUp="return tabular(event,this)"/></td>
    				<td class="saludo1" >Fecha Inicial: </td>
    				<td><input type="search" name="fechaini" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style='width:80%'/>&nbsp;<img src="imagenes/calendario04.png"  style="width:21px" onClick="displayCalendarFor('fc_1198971545');" class="icobut" title="Calendario"/></td>
  					<td class="saludo1">Fecha Final: </td>
    				<td><input type="search" name="fechafin" id="fc_1198971546" title="DD/MM/YYYY" style='width:80%' value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"/>&nbsp;<img src="imagenes/calendario04.png" style="width:21px" onClick="displayCalendarFor('fc_1198971546');" class="icobut" title="Calendario"/></td>  
        			 <td><input type="button" name="bboton" onClick="document.form2.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
  				</tr>
			</table>
            <div class="tabsmeci" style="height:64.5%; width:99.6%;">
             	<div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">RP General</label>
                    <div class="content" style="overflow-x:hidden;">    
						<?php
                            $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                            $vigencia=$vigusu;
                            $linkbd=conectar_bd();
                            $crit1=" ";
                            $crit2=" ";
                            $crit3=" ";
                            if ($_POST[vigencia]!=""){$crit1=" and TB1.vigencia ='$_POST[vigencia]' ";}
                            else {$crit1=" and TB1.vigencia ='$vigusu' ";}
                            if ($_POST[numero]!=""){$crit2=" and TB1.consvigencia like '%$_POST[numero]%' ";}
                            if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
                            {	
                                ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
                                $fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                                ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
                                $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                                $crit3=" and TB1.fecha between '$fechai' and '$fechaf'  ";
                            }
                            $sqlr="SELECT TB1.* FROM ccpet_rp TB1 WHERE TB1.estado<>'' $crit1 $crit2 $crit3 AND tipo_mov='201' ORDER BY TB1.consvigencia DESC";
                            $resp = mysql_query($sqlr,$linkbd);
                            $ntr = mysql_num_rows($resp);
                            $con=1;
                            echo "
                            <table class='inicio' align='center' width='80%'>
                                <tr><td colspan='11' class='titulos'>.: Resultados Busqueda:</td></tr>
                                <tr><td colspan='5'>Registros Presupuestales Encontrados: $ntr</td></tr>
                                <tr>
                                    <td width='5%' class='titulos2'>Vigencia</td>
                                    <td class='titulos2' style='width:4%;'>No RP</td>
                                    <td class='titulos2' style='width:4%;'>No CDP</td>
                                    <td class='titulos2' >Objeto</td>
									<td class='titulos2' >Nit o Cedula</td>
									<td class='titulos2' >Nombre</td>
                                    <td class='titulos2' >Valor</td>
                                    <td class='titulos2' width='10%'>Fecha</td>
                                    <td class='titulos2'>Estado</td>
                                    <td class='titulos2' width='5%'>Ver</td>
                                </tr>";	
                            $iter='saludo1a';
                            $iter2='saludo2';
                            while ($row =mysql_fetch_row($resp)) 
                            {
                                switch ($row[3]) 
                                {
                                    case "S":	$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";break;
                                    case "N":	$imgsem="src='imagenes/sema_verdeR.jpg' title='Anulado'";break;
                                    case "C":	$imgsem="src='imagenes/sema_verdeON.jpg' title='Completo'";break;
                                    case "R":	$imgsem="src='imagenes/sema_rojoON.jpg' title='Reversado'";break;
                                    case "PR":	$imgsem="src='imagenes/sema_rojoON.jpg' title='Reversado Parcial'";break;
                                }
								$ntercero=buscatercero($row[5]);
                                $sqlr2="select ccpet_cdp.objeto from ccpet_cdp where ccpet_cdp.consvigencia=$row[2] and ccpet_cdp.vigencia=$row[0] and tipo_mov='201' ";
                                $resp2 = mysql_query($sqlr2,$linkbd);
                                $r2 =mysql_fetch_row($resp2);
                                $sqlr3="select concepto from ccpet_comprobante_cab where tipo_comp='7' and vigencia='$row[0]' and numerotipo='$row[1]'";
                                $resp3 = mysql_query($sqlr3,$linkbd);
                                $r3 =mysql_fetch_row($resp3);
                                echo "
                               <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"location.href='ccp-rpver.php?is=$row[1]&vig=$row[0]'\" style='text-transform:uppercase; $estilo' >
                                    <td>$row[0]</td>
                                    <td>$row[1]</td>
                                    <td>$row[2]</td>
                                    <td>$r2[0]</td>
									<td>$row[5]</td>
									<td>$ntercero</td>
                                    <td style='text-align:right;'>".number_format($row[6],2)."</td>
                                    <td style='text-align:center;'>".date('d-m-Y',strtotime($row[4]))."</td>
                                    <td style='text-align:center;'><img $imgsem style='width:18px'/></td>
                                    <td style='text-align:center;'><a href='ccp-rpver.php?is=$row[1]&vig=$row[0]'><img src='imagenes/lupa02.png' style='width:18px' class='icoop' title='Ver'></a></td>
                                </tr>";
                                 $con+=1;
                                 $aux=$iter;
                                 $iter=$iter2;
                                 $iter2=$aux;
                            }
                            echo"</table>";
                        ?>
              		</div>
            	</div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">RP Reversados</label>
                    <div class="content" style="overflow-x:hidden;"> 
                    	<?php
							$sqlr="SELECT TB1.*,(select valor FROM ccpet_rp TB2 where TB2.consvigencia=TB1.consvigencia AND TB2.tipo_mov='201' AND TB2.vigencia = TB1.vigencia ) FROM ccpet_rp TB1 WHERE TB1.estado='R' AND TB1.tipo_mov='401' $crit1 $crit2 $crit3 ORDER BY TB1.consvigencia DESC";
                           // echo $sqlr;
                            $resp = mysql_query($sqlr,$linkbd);
                            $ntr = mysql_num_rows($resp);
                            $con=1;
                            echo "
                            <table class='inicio' align='center'>
                                <tr><td colspan='11' class='titulos'>.: Resultados Busqueda:</td></tr>
                                <tr><td colspan='11'>Registros Presupuestales Encontrados: $ntr</td></tr>
                                <tr>
                                    <td class='titulos2' style='width:5%'>Vigencia</td>
                                    <td class='titulos2' style='width:4%'>Numero</td>
                                    <td class='titulos2' style='width:10%'>Valor RP</td>
									<td class='titulos2' style='width:10%'>Valor Reintegrado</td>
                                    <td class='titulos2'>Reintegrado Por:</td>
                                    <td class='titulos2'>Detalle</td>
                                    <td class='titulos2' style='width:14%'>Fecha Reintegro</td>
                                    <td class='titulos2' style='width:4%'>Estado</td>
									<td class='titulos2' style='width:4%'>Ver</td>
								</tr>";	
                            $iter='zebra1';
                            $iter2='zebra2';
                            while ($row =mysql_fetch_row($resp)) 
                            {
								$sqlr1="SELECT sum(saldo) from ccpetrp_detalle where consvigencia='$row[1]' and vigencia='$row[0]' and tipo_mov like '4%' ";
								$resp1 = mysql_query($sqlr1,$linkbd);
								$row1 =mysql_fetch_row($resp1);
                                echo "
                                <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"location.href='ccp-rpver.php?is=$row[1]&vig=$row[0]'\" style='text-transform:uppercase; $estilo' >
                                    <td>$row[0]</td>
                                    <td>$row[1]</td>
                                    <td style='text-align:right;'>$".number_format($row[13],2)."</td>
									<td style='text-align:right;'>$".number_format($row1[0],2)."</td>
                                    <td>&nbsp;$row[12]</td>
                                    <td>$row[11]</td>
                                    <td style='text-align:center;'>".date('d-m-Y',strtotime($row[3]))."</td>
                                    <td style='text-align:center;'><img src='imagenes/sema_rojoON.jpg' title='Reversado' style='width:18px'/></td>
                                    <td style='text-align:center;'><img src='imagenes/lupa02.png' class='icoop'  style='width:18px' title='Ver' onClick=\"location.href='ccp-cdpver.php?is=$row[2]&vig=$row[1]'\"/></td>
                                </tr>";
                                $con+=1;
                                $aux=$iter;
                                $iter=$iter2;
                                $iter2=$aux;
                            }
                            echo"</table>";
						?> 
                    </div>
            	</div>   
            	<div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
                    <label for="tab-3">RP Reversados Parcialmente</label>
                    <div class="content" style="overflow-x:hidden;"> 
                    	<?php
						  $sqlr="SELECT TB1.* FROM ccpet_rp TB1 WHERE TB1.estado='R' AND TB1.tipo_mov='402' $crit1 $crit2 $crit3 ORDER BY TB1.consvigencia DESC";

                            $resp = mysql_query($sqlr,$linkbd);
                            $ntr = mysql_num_rows($resp);
                            $con=1;
                            echo "
                            <table class='inicio' align='center'>
                                <tr><td colspan='9' class='titulos'>.: Resultados Busqueda:</td></tr>
                                <tr><td colspan='10'>Registros Presupuestales Encontrados: $ntr</td></tr>
                                <tr>
                                    <td class='titulos2' style='width:5%'>Vigencia</td>
                                    <td class='titulos2' style='width:4%'>Numero</td>
                                    <td class='titulos2' style='width:10%'>Valor RP</td>
									<td class='titulos2' style='width:10%'>Valor Reintegrado</td>
                                    <td class='titulos2'>Reintegrado Por:</td>
                                    <td class='titulos2'>Detalle</td>
                                    <td class='titulos2' style='width:14%'>Fecha Reintegro</td>
                                    <td class='titulos2' style='width:4%'>Estado</td>
									<td class='titulos2' style='width:4%'>Ver</td>
								</tr>";	
                            $iter='zebra1';
                            $iter2='zebra2';
                            while ($row =mysql_fetch_row($resp)) 
                            {
								$sqlr1="SELECT sum(saldo) from pptorp_det_r where consvigencia='$row[1]' and vigencia='$row[0]'";
								$resp1 = mysql_query($sqlr1,$linkbd);
								$row1 =mysql_fetch_row($resp1);
                                echo "
                                <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"location.href='ccp-rpver.php?is=$row[1]&vig=$row[0]'\" style='text-transform:uppercase; $estilo' >
                                    <td>$row[0]</td>
                                    <td>$row[1]</td>
                                    <td style='text-align:right;'>$".number_format($row[6],2)."</td>
									<td style='text-align:right;'>$".number_format($row1[0],2)."</td>
                                    <td>&nbsp;$row[12]</td>
                                    <td>$row[11]</td>
                                    <td style='text-align:center;'>".date('d-m-Y',strtotime($row[3]))."</td>
                                    <td style='text-align:center;'><img src='imagenes/sema_rojoON.jpg' title='Reversado' style='width:18px'/></td>
                                    <td style='text-align:center;'><img src='imagenes/lupa02.png' class='icoop' title='Ver' onClick=\"location.href='ccp-cdpver.php?is=$row[2]&vig=$row[1]'\"/></td>
                                </tr>";
                                $con+=1;
                                $aux=$iter;
                                $iter=$iter2;
                                $iter2=$aux;
                            }
                            echo"</table>";
						?> 
                    </div>
            	</div>
     		</div>
		</form>
						<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
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