<?php //V 1000 12/12/16 ?> 
<?php
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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.submit();
}
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar el Recaudo Transferencia "+idr))
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
  else{
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

function verUltimaPos(idcta){
	/*var scrtop=$('#divdet').scrollTop();
	var altura=$('#divdet').height();
	var numpag=$('#nummul').val();
	var limreg=$('#numres').val();
	if((numpag<=0)||(numpag==""))
		numpag=0;
	if((limreg==0)||(limreg==""))
		limreg=10;
	numpag++;*/
	location.href="teso-editarecaudotransferencia.php?idrecaudo="+idcta;
}
</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
  		<td colspan="3" class="cinta">
  			<a href="teso-recaudotransferencia.php" class="mgbt">
  				<img src="imagenes/add.png" title="Nuevo"/>
  			</a>
  			<a class="mgbt">
  				<img src="imagenes/guardad.png"/>
  			</a>
  			<a onClick="document.form2.submit();" href="#" class="mgbt">
  				<img src="imagenes/busca.png" title="Buscar"/>
  			</a>
  			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt">
  				<img src="imagenes/nv.png" title="Nueva Ventana">
  			</a>
  		</td>
  	</tr>	
</table>
	<?php 
	
	if($_POST[nummul]=="")
	{
		$_POST[numres]=10;
		$_POST[numpos]=0;
		$_POST[nummul]=0;
	}
	?>
	<form name="form2" method="post" action="teso-buscarecaudotransferencia.php">
		<table  class="inicio" align="center" >
			<tr>
				<td class="titulos" colspan="8">:. Buscar Recaudos Transferencia</td>
        		<td width="70" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      		</tr>
			<tr>
				<td class="saludo1" style="width:2.2cm;">Fecha Inicial:</td>
				<td style="width:9%;"><input name="fecha"  type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
				<td class="saludo1" style="width:2.2cm;">Fecha Final:</td>
				<td style="width:9%;"><input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
				<td class="saludo1" style="width:10%;" >Concepto Recaudo:</td>
				<td style="width:20%;" ><input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:98%;" ></td>
				<td class="saludo1"style="width:10%;">Numero Recaudo: </td>
				<td >
					<input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>"  style="width:60%;">&nbsp;&nbsp; 
					<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
				</td>
			</tr>                     
    	</table>    
		<input type="hidden" name="oculto" id="oculto" value="1">
		<input type="hidden" name="var1" value=<?php echo $_POST[var1];?>>  
		<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    <div class="subpantallap" style="height:66%; width:99.6%; overflow-x:hidden;">
     <?php
	$oculto=$_POST['oculto'];
	if($_POST[oculto]==2)
	{
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesorecaudotransferencia where id_recaudo=$_POST[var1]  ";
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);
	 //********Comprobante contable en 000000000000
	  $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where numerotipo=$row[0] AND tipo_comp=14";
	 // echo $sqlr;
	  mysql_query($sqlr,$linkbd);
	  $sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='14 $row[0]'";
	  mysql_query($sqlr,$linkbd);
	  
	  $sqlr="update pptocomprobante_cab set estado='0' where numerotipo=$row[0] AND tipo_comp=19";
	  mysql_query($sqlr,$linkbd);
	
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  $sqlr="update tesorecaudotransferencia set estado='N' where id_recaudo=$row[0]";
	  mysql_query($sqlr,$linkbd);
	  $sqlr="select * from pptoingtranppto where idrecibo=$row[0]";
  	  $resp=mysql_query($sqlr,$linkbd);
	  while($r=mysql_fetch_row($resp))
	   {
		$sqlr="update pptocuentaspptoinicial set ingresos=ingresos-$r[3] where cuenta='$r[1]'";
		mysql_query($sqlr,$linkbd);
	   }	
	   $sqlr="delete from pptoingtranppto where idrecibo=$row[0]";
  	  $resp=mysql_query($sqlr,$linkbd); 
	}
   ?>
    
    
    <?php
		$oculto=$_POST['oculto'];
		//if($_POST[oculto]=="1")
		$fech1=split("/",$_POST[fecha]);
		$fech2=split("/",$_POST[fecha2]);
		$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
		$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		$crit3=" ";
		if ($_POST[numero]!="")
			$crit1=" and tesorecaudotransferencia.id_recaudo  like '%".$_POST[numero]."%' ";
		if ($_POST[nombre]!="")
			$crit2=" and tesorecaudotransferencia.concepto like '%".$_POST[nombre]."%'  ";

		if($_POST[fecha]!="" && $_POST[fecha2]!="")
		{
			$crit3 = " AND tesorecaudotransferencia.fecha BETWEEN '$f1' AND '$f2'";
		}
		//sacar el consecutivo 
		//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
		$sqlr="select *from tesorecaudotransferencia where tesorecaudotransferencia.id_recaudo>-1 ".$crit1.$crit2.$crit3." order by tesorecaudotransferencia.id_recaudo desc";

		// echo "<div><div>sqlr:".$sqlr."</div></div>";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
		$cond2="";
		if ($_POST[numres]!="-1"){
			$cond2="LIMIT $_POST[numpos], $_POST[numres]";
		}
		$sqlr="select *from tesorecaudotransferencia where tesorecaudotransferencia.id_recaudo>-1 ".$crit1.$crit2.$crit3." order by tesorecaudotransferencia.id_recaudo desc $cond2";
		$resp = mysql_query($sqlr,$linkbd);
		$con=1;
		$numcontrol=$_POST[nummul]+1;
		if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
		{
			$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
			$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
		}
		else
		{
			$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
			$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
		}
		if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
		{
			$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
			$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
		}
		else
		{
			$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
			$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
		}
		echo "<table class='inicio' align='center' >
			<tr>
				<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
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
				<td colspan='2'>Recaudos Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' style='width:8%'>Codigo</td>
				<td class='titulos2' style='width:8%'>Liquidacion</td>
				<td class='titulos2'>Nombre</td>
				<td class='titulos2' style='width:8%'>Fecha</td>
				<td class='titulos2'>Contribuyente</td>
				<td class='titulos2' style='width:10%'>Valor</td>
				<td class='titulos2' style='width:8%'>Estado</td>
				<td class='titulos2' style='width:8%'><center>Anular</td>
				<td class='titulos2' ><center>Ver</td>
			</tr>";	
		//echo "nr:".$nr;
		$iter='zebra1';
		$iter2='zebra2';
		$id=$_GET[id];
 		//echo $id;
		while ($row =mysql_fetch_row($resp)) 
		{
			$estilo='';
			if($id==$row[0]){
				$estilo='background-color:#FF9';
			}
			$nter=buscatercero($row[7]);
			if($row[10]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	}			  
			if($row[10]=='N'){$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulado'";}	
	 
			echo "<tr class='$iter' onDblClick=\"verUltimaPos($row[0])\" style='$estilo'>
				<td>$row[0]</td>
				<td>$row[1]</td>
				<td>$row[6]</td>
				<td>$row[2]</td>
				<td>$nter</td>
				<td style='text-align:right;'>".number_format($row[9],2)."</td>
				<td style='text-align:center;'>
					<img $imgsem style='width:18px'/>
				</td>";
				if($row[10]=='S')
				echo "<td><a href='#'  onClick=eliminar($row[0])><center><img src='imagenes/anular.png'></center></a></td>";		 
				if($row[10]=='N')
				echo "<td></td>";	 
				$sqlrMedioPago = "SELECT medio_pago FROM tesorecaudotransferencialiquidar WHERE id_recaudo=$row[1]";
				$respMedioPago = mysql_query($sqlrMedioPago,$linkbd);
				$rowMedioPago = mysql_fetch_row($respMedioPago);
				if($rowMedioPago[0]==2)
					$medioPago = "SSF";
				else
					$medioPago = "CSF";
				
				echo"<td style='text-align:center;'>".$medioPago."</td>";
	 		//echo "<td><a href='teso-editarecaudotransferencia.php?idrecaudo=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
			$con+=1;
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
 		}
 		echo"</table>
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
					echo"&nbsp;&nbsp;<a href='#'>$imagenforward</a>
						&nbsp;<a href='#'>$imagensforward</a>
				</td>
			</tr>
		</table>";
?></div>	
</form> 
</body>
</html>