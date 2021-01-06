<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SieS - Presupuesto</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
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
</script>
<script>
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
</script>
<script>
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
</script>
<script>
function pdf()
{
document.form2.action="teso-pdfconsignaciones.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="#" ><img src="imagenes/add2.png" alt="Nuevo" /></a> <img src="imagenes/guardad.png" alt="Guardar" /> <a onClick="document.form2.submit();" href="#"><img src="imagenes/busca.png" alt="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="presu-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td></tr>	
</table><tr><td colspan="3" class="tablaprin"> 
	<form name="form2" method="post" action="presu-buscanotasbancarias-reflejar.php">
		<?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
        <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
        <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
        <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
		<table  class="inicio" align="center" >
      		<tr >
        		<td class="titulos" colspan="6">:. Buscar Notas Bancarias </td>
        		<td style="width:7%" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
      		</tr>
      		<tr >
        		<td width="162" class="saludo1">Numero Comprobante:</td>
        		<td width="179">
                	<input name="numero" type="text" value="" size="15">
        		</td>
         		<td width="131" class="saludo1">Fecha Inicial: </td>
    			<td width="131" >
                	<input name="fechaini" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        			<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          
            	</td>
  				<td width="147" class="saludo1">Fecha Final: </td>
    			<td width="149" >
                	<input name="fechafin" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        			<a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  
          			<input name="oculto" id="oculto" type="hidden" value="1">
                    <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
                </td>
        	</tr>                       
    	</table>    
  	</form> 
    <div class="subpantallap">
    	<?php
		$oculto=$_POST['oculto'];
		if($_POST[oculto]==2){
	 		$linkbd=conectar_bd();	
	 		$sqlr="select * from tesonotasbancarias_cab where id_notaban=$_POST[var1]";
	 		$resp = mysql_query($sqlr,$linkbd);
	 		$row=mysql_fetch_row($resp);
	 		//********Comprobante contable en 000000000000
	  		$sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where numerotipo=$row[0] AND tipo_comp=9";
	  		mysql_query($sqlr,$linkbd);
	  		$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='9 $row[0]'";
	  		mysql_query($sqlr,$linkbd);
	 
	 		$sqlr="update pptocomprobante_cab set total_debito=0,total_credito=0,estado='0' where numerotipo=$row[0] AND tipo_comp=20";
	  		mysql_query($sqlr,$linkbd);
	  
	 		//******** RECIBO DE CAJA ANULAR 'N'	 
	  		$sqlr="update tesonotasbancarias_cab set estado='N' where id_notaban=$row[0]";
	  		mysql_query($sqlr,$linkbd);	  
		}
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[numero]!="")
			$crit1=" and tesonotasbancarias_cab.id_notaban like '%".$_POST[numero]."%' ";
		if ($_POST[fechaini]!="" and $_POST[fechafin]!="" ){	
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
			$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$crit2=" and tesonotasbancarias_cab.fecha between '$fechai' and '$fechaf'  ";
		}
		//sacar el consecutivo 
		$sqlr="select *from tesonotasbancarias_cab where tesonotasbancarias_cab.estado<>'' ".$crit1.$crit2." order by tesonotasbancarias_cab.id_notaban DESC";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
		$cond2="";
		if($_POST[numres]!="-1"){
			$cond2="LIMIT $_POST[numpos],$_POST[numres]";
		}
		$sqlr="select *from tesonotasbancarias_cab where tesonotasbancarias_cab.estado<>'' ".$crit1.$crit2." order by tesonotasbancarias_cab.id_notaban DESC ".$cond2;
		$resp = mysql_query($sqlr,$linkbd);
		$numcontrol=$_POST[nummul]+1;
		if($nuncilumnas==$numcontrol){
			$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
			$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
		}
		else{
			$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
			$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
		}
		if($_POST[numpos]==0){
			$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
			$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
		}
		else{
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
				<td class='saludo3' colspan='7'>Notas Bancarias Encontrados: $ntr</td>
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
			$iter='saludo1a';
			$iter2='saludo2';
 			while ($row =mysql_fetch_row($resp)){
	 			$sqlr="Select sum(valor) from tesonotasbancarias_det where id_notabancab=$row[0]";
	 			$resn=mysql_query($sqlr,$linkbd);
	 			$rn=mysql_fetch_row($resn);
				if($row[4]=='S'){
				$estadosemaforo="<img src='imagenes/sema_verdeON.jpg' style='width:19px; '  title='Activo'>";
				}else {
				$estadosemaforo="<img src='imagenes/sema_rojoON.jpg' style='width:19px; ' title='Inactivo'>";
				}
		 		echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;cursor:pointer' onDblClick=\"window.open('presu-notasbancarias-reflejar.php?idr=$row[0]&dc=$row[1]','_self');\">
					<td>$row[0]</td>
					<td>$row[2]</td>
					<td>$row[5]</td>
					<td>".number_format($rn[0],0)."</td>
					<td style='text-align:center;'>$estadosemaforo</td>";
	 				if($row[4]=='S')
		 				echo "<td>
							<a href='#'  onClick=eliminar($row[0])><center><img src='imagenes/anular.png'></center></a>
						</td>";		 
	 	 			if($row[4]=='N')
		  				echo "<td></td>";	
	 				echo "<td>
						<a href='presu-notasbancarias-reflejar.php?idr=$row[0]&dc=$row[1]'><center><img src='imagenes/buscarep.png'></center></a>
					</td>
				</tr>";
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
						for($xx = 1; $xx <= $numfin; $xx++){
							if($numcontrol<=9){$numx=$xx;}
							else{$numx=$xx+($numcontrol-9);}
							if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
							else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
						}
						echo "&nbsp;&nbsp;<a href='#'>$imagenforward</a>
							&nbsp;<a href='#'>$imagensforward</a>
					</td>
				</tr>
			</table>";
			?>
		</div>
</td></tr>     
</table>
</body>
</html>