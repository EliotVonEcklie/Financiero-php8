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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verUltimaPos(idcta, filas){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="teso-editacuentasbancos.php?idr="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
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
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
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
function selexcel()
			{
				document.form2.action="cont-saldobancosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
			}
function cambioswitch(id,valor)
{
	if(valor==1)
	{
		if (confirm("Desea activar Estado")){document.form2.cambioestado.value="1";}
		else{document.form2.nocambioestado.value="1"}
	}
	else
	{
		if (confirm("Desea Desactivar Estado")){document.form2.cambioestado.value="0";}
		else{document.form2.nocambioestado.value="0"}
	}
	document.getElementById('idestado').value=id;
	document.form2.submit();
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
					<a href="teso-cuentasbancos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a class="mgbt1"><img src="imagenes/buscad.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="selexcel();" class="mgbt"><img src="imagenes/excel.png" title="Excel" /></a>
					<a href="teso-informestesoreria.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>	
        </table>
        <?php
		if($_GET[numpag]!=""){
			$oculto=$_POST[oculto];
			if($oculto!=2){
				$_POST[numres]=$_GET[limreg];
				$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
				$_POST[nummul]=$_GET[numpag]-1;
			}
		}
		else{
			if($_POST[nummul]==""){
				$_POST[numres]=10;
				$_POST[numpos]=0;
				$_POST[nummul]=0;
			}
		}
		?>
 <form name="form2" method="post" action="teso-saldobancos.php">
         	<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			 <?php
				if($_POST[oculto2]=="")
				{
					$_POST[oculto2]="0";
					$_POST[cambioestado]="";
					$_POST[nocambioestado]="";
				}
				//*****************************************************************
				if($_POST[cambioestado]!="")
				{
					$linkbd=conectar_bd();
					if($_POST[cambioestado]=="1")
					{
                        $sqlr="UPDATE tesobancosctas SET estado='S' WHERE cuenta='".$_POST[idestado]."'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
                        $sqlr="UPDATE tesobancosctas SET estado='N' WHERE cuenta='".$_POST[idestado]."'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
					else {$_POST[lswitch1][$_POST[idestado]]=0;}
					$_POST[nocambioestado]="";
				}
			?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Saldo Bancos</td>
        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
       <tr> 
	   <td class="saludo1" style="width:10%;">Mes Final:</td>
        		<td style="width:11%;">
					<input type="text" name="fecha" id="fecha" title="DD/MM/YYYY" style="width:80%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="4"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha');" tabindex="5" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
				</td>
	   <td class="saludo1" style="width:11%;">Nit Tercero:</td>
          <td width="139" ><input id="tercero" type="text" name="tercero" size="12" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bt"> <input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto">	
            </td>
          <td class="saludo1" style="width:11%;">Razón Social:</td>
		  <td width="298" colspan="1"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="45" >
		  <input type="button" name="generar" value="Generar" onClick="document.form2.submit()" tabindex="13"></td>
          <input name="oculto" id="oculto" type="hidden" value="1">
		  
			
        </tr>                       
    </table> 
     <input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>">
    <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
    <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
    <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">   
     <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
      <?php
$oculto=$_POST['oculto'];

$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[tercero]!="")
$crit1=" and tesobancosctas.tercero like '%".$_POST[tercero]."%' ";
if ($_POST[ntercero]!="")
$crit2=" and terceros.razonsocial like '%".$_POST[ntercero]."%' ";
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
//sacar el consecutivo 
	$sqlr="select *from terceros, tesobancosctas, cuentas where terceros.cedulanit=tesobancosctas.tercero and cuentas.cuenta=tesobancosctas.cuenta".$crit1.$crit2."order by cuentas.cuenta,terceros.cedulanit";
	//echo $sqlr."<br>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
					$_POST[numtop]=$ntr;
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

					$cond2="";
					
					
					$con=1;
					

$con=1;

echo "<table class='inicio' align='center' >
	<tr>
		<td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
									
	</tr>
	<tr>
		<td colspan='10'>Cuentas Bancarias Encontrados: $ntr</td>
	</tr><tr><td class='titulos2'>Nit Tercero</td><td class='titulos2'>Razón Social</td><td  class='titulos2'>Cuenta</td><td class='titulos2'>Cuenta Contable</td><td class='titulos2'>Cuenta Bancaria</td><td class='titulos2' width='10%'>Tipo Cuenta</td><td class='titulos2' colspan='2' width='10%'><center>Saldo</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1a';
$iter2='saludo2';
$filas=1;
				
 while ($row =mysql_fetch_row($resp)) 
 {
	 $saldebito='0';
	 $salcredito='0';
	 $saldo='0';
	 $sqlr3="SELECT DISTINCT
        		sum(comprobante_det.valdebito),
        		sum(comprobante_det.valcredito)
     			FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)
				AND comprobante_cab.fecha <= '$fechaf1'
				AND comprobante_det.tipo_comp <> 7 ".$critcons." 
				AND comprobante_det.cuenta= '$row[22]'
				AND comprobante_det.centrocosto like '%$_POST[cc]%'
				GROUP BY comprobante_det.cuenta
				ORDER BY comprobante_det.cuenta";
				$res1=mysql_query($sqlr3,$linkbd);
				$row1=mysql_fetch_row($res1);
				$saldebito=$row1[0];
				$salcredito=$row1[1];
				
				$sqlr3="SELECT DISTINCT
				sum(comprobante_det.valdebito)-
				sum(comprobante_det.valcredito)
				FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)         
				AND comprobante_det.tipo_comp = 7 
				AND comprobante_det.cuenta = '$row[22]'  
				AND comprobante_det.centrocosto like '$_POST[cc]%' ".$critcons."
				GROUP BY comprobante_det.cuenta
				ORDER BY comprobante_det.cuenta";
				$res2=mysql_query($sqlr3,$linkbd);
				$row2=mysql_fetch_row($res2);
				$saldo=$row2[0]+$saldebito-$salcredito;
				$saldofina+=$saldo;
		        //echo $saldo."<br>";
	 if($row[26]=='S')
	  	{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[22]]=0;}
	else
		{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST[lswitch1][$row[22]]=1;}
						if($gidcta!=""){
							if($gidcta==$row[24]){
								$estilo='background-color:yellow';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'".$row[24]."'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[tercero]."'";
	 echo "
	 	<tr class='$iter' style='text-transform:uppercase;'  >
		 <td>$row[12]</td>
		 <td>$row[5]</td>
		 <td>$row[28]</td>
		 <td>$row[27]</td>
		 <td>$row[24]</td>
		 <td>$row[25]</td>
		 <td align='right'>".number_format($saldo,2,",",".")."</td>
								
		</tr>";
		
		echo "
		<input type='hidden' name='nitercero[]' value='$row[12]'>
		<input type='hidden' name='razonsocial[]' value='$row[5]'>
		<input type='hidden' name='cuenta[]' value='$row[28]'>
		<input type='hidden' name='cuentacont[]' value='$row[27]'>
		<input type='hidden' name='cuentaban[]' value='$row[24]'>
		<input type='hidden' name='tipocuenta[]' value='$row[25]'>
		<input type='hidden' name='saldo[]' value='$saldo'>
		";

	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	$filas++;
 }



?></div>
</form>
</body>
</html>