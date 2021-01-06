<?php //V 1001 20/12/16 Modificado implementacion de Reversion, e ingresar al ver con doble clic?> 
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
		<title>:: Spid - Presupuesto</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css"/>
 		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script>
			function validar(formulario)
			{
				document.form2.action="presu-buscacdp.php";document.form2.submit();
			}
			function verUltimaPos(is, filas, filtro){
				
					var scrtop=$('#divdet').scrollTop();
					var altura=$('#divdet').height();
					var numpag=$('#nummul').val();
					var limreg=$('#numres').val();
					if((numpag<=0)||(numpag==""))
						numpag=0;
					if((limreg==0)||(limreg==""))
						limreg=10;
					numpag++;
					location.href="presu-cdpver.php?is="+is+"&vig="+vigusu;
			}
			function fundeshacer(iddesha)
			{
				if (confirm("Esta Seguro de Deshacer el CDP No "+iddesha))
				{
					document.getElementById('oculto').value='4';
					document.getElementById('iddesh').value=iddesha;
					document.form2.submit();
				}
			}
			var ctrlPressed = false;
			var tecla01 = 16, tecla02 = 80, tecla03 = 81;
			$(document).keydown(
				function(e){
					
					if (e.keyCode == tecla01){ctrlPressed = true;}
					if (e.keyCode == tecla03){tecla3Pressed = true;}
					if (ctrlPressed && (e.keyCode == tecla02) && tecla3Pressed)
					{
						
						if(document.form2.iddeshff.value=="0"){document.form2.iddeshff.value="1";}
						else {document.form2.iddeshff.value="0";}
						document.form2.submit();
					}
					})
					$(document).keyup(function(e){if (e.keyCode ==tecla01){ctrlPressed = false;}})
					$(document).keyup(function(e){if (e.keyCode ==tecla03){tecla3Pressed = false;}
				})
			function selexcel()
			{
				tipocdp=document.form2.tabgroup1.value;
				switch(tipocdp)
				{
					case "1":	document.form2.action="presu-buscacdpexcel.php";break;
					case "2":	document.form2.action="presu-buscacdpexcelr.php";break;
					case "3":	document.form2.action="presu-buscacdpexcelpr.php";break;
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
					case "1":	document.form2.action="presu-buscacdppdf.php";break;
					case "2":	document.form2.action="presu-buscacdppdfr.php";break;
					case "3":	document.form2.action="presu-buscacdppdfpr.php";break;
				}
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();?>
		<?php
			$scrtop=$_GET['scrtop'];
			if($scrtop=="") $scrtop=0;
			echo"<script>
				window.onload=function(){
					$('#divdet').scrollTop(".$scrtop.")
				}
			</script>";
			$gidcta=$_GET['idcta'];
			if(isset($_GET['filtro']))
				$_POST[nombre]=$_GET['filtro'];
			?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
       		<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='presu-cdp.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar"  onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/print.png" title="Imprimir" style="width:29px;"  onClick="selpdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excell"  onclick="selexcel()" class="mgbt"><img  src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='presu-gestioncdp.php'" class="mgbt"/></td>
			</tr>
		</table>	
 		<form name="form2" method="post" action="presu-reporteparametros.php">
			<table width="100%" align="center"  class="inicio" >
                <tr>
                    <td class="titulos" colspan="9">:: Buscar .: Cuentas</td>
                    <td class="cerrar" style='width:7%' onClick="location.href='presu-principal.php'">Cerrar</td>
                    <input type="hidden" name="oculto" id="oculto" value="1">
                    <input type="hidden" name="iddeshff" id="iddeshff" value="<?php echo $_POST[iddeshff];?>">	 
                </tr>                       
                <tr>
                    <td class="saludo1">Vigencia:</td>
                    <td><input type="search" name="vigencia" value="<?php echo $_POST[vigencia] ?>" onKeyUp="return tabular(event,this)" /></td>
                    <td class="saludo1">Cuenta:</td>
                    <td><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero] ?>" onKeyUp="return tabular(event,this)" /></td>
                    <td><input type="button" name="bboton" onClick="document.form2.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
                </tr>
			</table>
            <input type="hidden" name="iddesh" id="iddesh" value="<?php echo $_POST[iddesh];?>"/>
                <?php
                    $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$linkbd=conectar_bd();
					$crit1=" ";
					$crit2=" ";
					if ($_POST[vigencia]!=""){$crit1=" AND TB1.vigencia ='$_POST[vigencia]' ";}
					else {$crit1=" AND TB1.vigencia ='$vigusu' ";}
					if ($_POST[cuenta]!=""){$crit2=" AND TB1.cuenta like '%$_POST[cuenta]%' ";}
				?>
          	<div class="tabsmeci" style="height:64.5%; width:99.6%;">
                    <div class="content" style="overflow-x:hidden;">        
						<?php
                            $sqlr="SELECT TB1.* FROM pptocuentas TB1 WHERE TB1.estado='S' $crit1 $crit2  ORDER BY TB1.cuenta DESC";
                            $resp = mysql_query($sqlr,$linkbd);
                            $ntr = mysql_num_rows($resp);
                            $con=1;
                            if($_POST[iddeshff]==1){$tff01=9;$tff02=10;}
                            else {$tff01=8;$tff02=9;}
                            echo "
                            <table class='inicio' align='center'>
                                <tr><td colspan='$tff01' class='titulos'>.: Resultados Busqueda:</td></tr>
                                <tr><td colspan='$tff02'>Certificado Disponibilidad Presupuestal Encontrados: $ntr</td></tr>
                                <tr>
                                    <td class='titulos2' style='width:5%'>Vigencia</td>
                                    <td class='titulos2' style='width:4%'>Numero</td>
                                    <td class='titulos2' >Valor</td>
                                    <td class='titulos2' style='width:10%'>Solicita</td>
                                    <td class='titulos2'>Objeto</td>
                                    <td class='titulos2' style='width:7%'>Fecha</td>
                                    <td class='titulos2' style='width:4%'>Estado</td>";
                            if(strtoupper($_SESSION["perfil"])=="SUPERMAN" && $_POST[iddeshff]==1)
                            {echo"<td class='titulos2' style='width:4%'>Deshacer</td>";}
                            echo"<td class='titulos2' style='width:4%'>Ver</td></tr>";	
                            $iter='zebra1';
                            $iter2='zebra2';
							$filas=1;
                            while ($row =mysql_fetch_row($resp)) 
                            {
                                switch ($row[5]) 
                                {
                                    case "S":	$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";break;
                                    case "N":	$imgsem="src='imagenes/sema_verdeR.jpg' title='Anulado'";break;
                                    case "C":	$imgsem="src='imagenes/sema_amarilloON.jpg' title='Completo'";break;
                                    case "R":	$imgsem="src='imagenes/sema_rojoON.jpg' title='Reversado'";break;
                                }
								if($gidcta!="")
								{
									if($gidcta==$row[0]){$estilo='background-color:#FF9';}
									else {$estilo="";}
								}
								else{$estilo="";}
								$idcta="'$row[0]'";				
								$is="'$row[2]'";
								$numfil="'$filas'";
                                echo "
                                <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"location.href='presu-cdpver.php?is=$row[2]&vig=$row[1]'\" style='text-transform:uppercase; $estilo' >
                                    <td>$row[1]</td>
                                    <td>$row[2]</td>
                                    <td style='text-align:right;'>$".number_format($row[4],2)."</td>
                                    <td>$row[6]</td>

                                    <td>$row[7]</td>
                                    
                                    <td style='text-align:center;'>".date('d-m-Y',strtotime($row[3]))."</td>
                                    <td style='text-align:center;'><img $imgsem style='width:18px'/></td>";
									if(strtoupper($_SESSION["perfil"])=="SUPERMAN" && $_POST[iddeshff]==1)
									{	echo"<td style='text-align:center;'><img src='imagenes/flechades.png' title='Deshacer No: $row[2]' style='width:18px;cursor:pointer;' onClick=\"fundeshacer('$row[2]')\" /></td>";}
									echo"
                                    <td style='text-align:center;'><img src='imagenes/lupa02.png' style='width:20px' class='icoop' title='Ver' onClick=\"location.href='presu-cdpver.php?is=$row[2]&vig=$row[1]'\"/></td>
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