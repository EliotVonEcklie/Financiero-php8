<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6 //para poder actualizar
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SieS - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function verUltimaPos(idcta, idc, filas, filtro)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=10;}
				numpag++;
				location.href="teso-editanotasbancarias.php?idr="+idcta+"&dc="+idc+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<script>
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}
			}
			function validar(){document.form2.submit();}
			function buscater(e)
 			{
				if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}
 			}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			//************* genera reporte ************
			//***************************************
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar la Nota Bancaria "+idr))
  				{
  					document.form2.oculto.value=2;
  					document.form2.var1.value=idr;
					document.form2.submit();
  				}
			}
			//************* genera reporte ************
			//***************************************
			function guardar()
			{
				if (document.form2.fecha.value!='')
  				{
					if (confirm("Esta Seguro de Guardar"))
  					{
  						document.form2.oculto.value=2;
  						document.form2.submit();
  					}
  				}
  				else
				{
  					alert('Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
  				}
			}
			function pdf()
			{
				document.form2.action="teso-pdfconsignaciones.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php 
			titlepag();
			$scrtop=$_GET['scrtop'];
			if($scrtop=="") $scrtop=0;
			echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$scrtop.")}</script>";
			$gidcta=$_GET['idcta'];
			if(isset($_GET['filtro']))
				$_POST[numero]=$_GET['filtro'];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a href="teso-notasbancarias.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a>
				<a onClick="document.form2.submit();" class="mgbt" href="#"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>	
		</table>
 		<form name="form2" method="post" action="teso-buscanotasbancarias.php">
        	<?php
				if($_GET[numpag]!="")
				{
					$oculto=$_POST[oculto];
					if($oculto!=2)
					{
						$_POST[numres]=$_GET[limreg];
						$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
						$_POST[nummul]=$_GET[numpag]-1;
					}
				}
				else{if($_POST[nummul]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}}
			?>
			<table  class="inicio" align="center" >
      	<tr >
        <td class="titulos" colspan="6">:. Buscar Notas Bancarias </td>
        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="162" class="saludo1">Numero Comprobante:</td>
        <td width="179"><input name="numero" type="text" value="" size="15">
        </td>
         <td width="131" class="saludo1">Fecha Inicial: </td>
    <td width="131" ><input name="fechaini" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
  <td width="147" class="saludo1">Fecha Final: </td>
    <td width="149" ><input name="fechafin" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td>
        
        </tr>                       
    </table>
            <input type="hidden" name="oculto" id="oculto" value="1">
         	<input type="hidden" name="var1" value=<?php echo $_POST[var1];?>>  
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/> 
	<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]==2)
	{
		
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesonotasbancarias_cab where id_notaban=$_POST[var1]";
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);
	 //********Comprobante contable en 000000000000
	  $sqlr="update comprobante_cab set estado='0' where numerotipo=$row[0] AND tipo_comp=9";
	  mysql_query($sqlr,$linkbd);
	  $sqlr="update comprobante_det set estado='0' where id_comp='9 $row[0]'";
	  mysql_query($sqlr,$linkbd);
	 
	 $sqlr="update pptocomprobante_cab set estado='0' where numerotipo=$row[0] AND tipo_comp=20";
	  mysql_query($sqlr,$linkbd);
	  
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  $sqlr="update tesonotasbancarias_cab set estado='N' where id_notaban=$row[0]";
	  mysql_query($sqlr,$linkbd);	  
	  $sqlr="update tesonotasbancarias_det set estado='N' where id_notabancab=$row[0]";
	  mysql_query($sqlr,$linkbd);
	}

//if($_POST[oculto])
//{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and tesonotasbancarias_cab.id_notaban like '%".$_POST[numero]."%' ";
if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

$crit2=" and tesonotasbancarias_cab.fecha between '$fechai' and '$fechaf'  ";
}

//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesonotasbancarias_cab where tesonotasbancarias_cab.estado<>'' ".$crit1.$crit2." order by tesonotasbancarias_cab.id_notaban DESC";
	$resp = mysql_query($sqlr,$linkbd);
	$_POST[numtop]=mysql_num_rows($resp);
    $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
	$cond2="";
	if ($_POST[numres]!="-1"){ 
		$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
	}

	$sqlr="select *from tesonotasbancarias_cab where tesonotasbancarias_cab.estado<>'' ".$crit1.$crit2." order by tesonotasbancarias_cab.id_notaban DESC $cond2";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$con=1;
	$numcontrol=$_POST[nummul]+1;
    if($nuncilumnas==$numcontrol)
    {
		$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
        $imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
    }
    else 
    {
		$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
        $imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
    }
    if($_POST[numpos]==0)
    {
        $imagenback="<img src='imagenes/back02.png' style='width:17px'>";
		$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
    }
    else
    {
        $imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
        $imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
    }

$con=1;

echo "<table class='inicio' align='center' >
	<tr>
		<td colspan='6' class='titulos'>.: Resultados Busqueda:</td>
		<td class='submenu'>
			<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
				<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
				<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
				<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
				<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
				<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
				<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan='7'>Notas Bancarias Encontrados: $ntr</td>
	</tr>
	<tr>
		<td width='150' class='titulos2'>No Nota Bancaria</td>
		<td class='titulos2'>Fecha</td>
		<td class='titulos2'>Concepto Nota Bancaria</td>
		<td class='titulos2'>Valor</td>
		<td width='5%' class='titulos2'>Estado</td>
		<td class='titulos2' width='5%'><center>Anular</td>
		<td class='titulos2' width='5%'><center>Editar</td>
	</tr>";		
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
$filas=1;
 while ($row =mysql_fetch_row($resp)) 
 {
	 
	 if($row[4]=='S')
		$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	 				  
	if($row[4]=='N')
		$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
	if($gidcta!="")
	{
		if($gidcta==$row[0]){$estilo='background-color:#FF9';}
		else{$estilo="";}
	}
	else{$estilo="";}	
	
	$idcta="'".$row[0]."'";
	$idc="'".$row[1]."'";
	$numfil="'".$filas."'";
	$filtro="'".$_POST[numero]."'";
	 $sqlr="Select sum(valor) from tesonotasbancarias_det where id_notabancab=$row[0]";
	 $resn=mysql_query($sqlr,$linkbd);
	 $rn=mysql_fetch_row($resn);
	echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $idc, $numfil, $filtro)\" style='text-transform:uppercase; $estilo'>
		 <td>$row[0]</td>
		 <td>$row[2]</td>
		 <td>$row[5]</td>
		 <td align='right'>".number_format($rn[0],0)."</td>
		 <td style='text-align:center;'><img $imgsem style='width:18px' ></td>";
	 if($row[4]=='S')
		 echo "<td><a href='#'  onClick=eliminar($row[0])><center><img src='imagenes/anular.png'></center></a></td>";		 
	 	 if($row[4]=='N')
		  echo "<td></td>";	
		  echo"<td style='text-align:center;'>
			<a onClick=\"verUltimaPos($idcta, $idc, $numfil, $filtro)\" style='cursor:pointer;'>
				<img src='imagenes/lupa02.png' style='width:18px' title='Editar'>
			</a>
		</td>
	</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 $filas++;
 }
echo"
</table>
<table class='inicio'>
	<tr>
		<td style='text-align:center;'>
			<a href='#'>$imagensback</a>&nbsp;
			<a href='#'>$imagenback</a>&nbsp;&nbsp;";
				if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
						else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
					}
					echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
		</td>
	</tr>
</table>";
//}
?></div>
</td></tr>     
</table>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
</body>
</html>