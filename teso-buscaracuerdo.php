<?php //V 1000 12/12/16 ?> 
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
        <title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
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
				location.href="teso-editaacuerdo.php?idacuerdo="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
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

//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.documento.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  }
 }

function validar(formulario)
{
document.form2.action="teso-buscaracuerdo.php";
document.form2.submit();
}

function cleanForm()
{
document.form2.nombre1.value="";
document.form2.nombre2.value="";
document.form2.apellido1.value="";
document.form2.apellido2.value="";
document.form2.documento.value="";
document.form2.codver.value="";
document.form2.telefono.value="";
document.form2.direccion.value="";
document.form2.email.value="";
document.form2.web.value="";
document.form2.celular.value="";
document.form2.razonsocial.value="";
}
function eliminar(idr, consec)
{
	if (confirm("Esta Seguro de Eliminar el Acto Administrativo "+consec))
  	{
	document.getElementById('oculto').value='2';
  	document.form2.var1.value=idr;
	document.form2.submit();
  	}
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
          			<a href="teso-acuerdo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
          			<a class="mgbt"><img src="imagenes/guardad.png"/></a>
          			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
          			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
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
<form name="form2" method="post" action="presu-buscaracuerdos.php">
    <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
    <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
	<table width="100%" align="center"  class="inicio" >
      	<tr >
        	<td class="titulos" colspan="9">:: Buscar .: Actos Administrativos</td>
        	<td width="70" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
            	<input name="oculto" type="hidden" value="1">
    	</tr>                       
    	<tr  >
    		<td style="width: 5%" class="saludo1">Numero:</td>
    		<td style="width: 10%">
    			<input name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>" style="width: 90%">
    		</td>
    		<td style="width: 10%" class="saludo1">Fecha Inicial: </td>
    		<td style="width: 15%" >
    			<input name="fechaini" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        		<a href="#" onClick="displayCalendarFor('fc_1198971545');">
        			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
        		</a>          
        	</td>
  			<td style="width: 10%" class="saludo1">Fecha Final: </td>
    		<td style="width: 15%" >
    			<input name="fechafin" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        		<a href="#" onClick="displayCalendarFor('fc_1198971546');">
        			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
        		</a>          
        	</td>
            <td class="saludo1"><input type="hidden" value="1" name="oculto2">Acto Admin:</td>
    		<td style="width: 30%">
    			<input name="objeto" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" style="width: 90%">
                <input name="oculto" id="oculto" type="hidden" value="<?php echo $_POST[oculto] ?>">
			    <input name="var1" type="hidden" value="<?php echo $_POST[var1];?>">
    		</td>
  	 	</tr>
  		<tr>
    		
  </tr>
</table>
<div class="subpantalla" style="height:64.5%; width:99.6%; overflow-x:hidden;" id="divdet">
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]==2)
	{
	 $linkbd=conectar_bd();	
	 $sqlr="UPDATE tesoacuerdo SET estado='N' WHERE id_acuerdo='$_POST[var1]'";
	 mysql_query($sqlr,$linkbd);
	}
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
$crit3=" ";
$crit4=" ";
$crit5=" ";


if ($_POST[vigencia]!="")
$crit1=" and tesoacuerdo.vigencia ='$_POST[vigencia]' ";
if ($_POST[numero]!="")
$crit2=" and tesoacuerdo.consecutivo like '%$_POST[numero]%' ";
if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

$crit3=" and tesoacuerdo.fecha between '$fechai' and '$fechaf'  ";
}
if ($_POST[objeto]!="")
$crit5=" and tesoacuerdo.detalle_acuerdo like '%".$_POST[objeto]."%' ";

 
$sqlr="select *from tesoacuerdo where tesoacuerdo.estado!='A' ".$crit1.$crit2.$crit3.$crit4.$crit5." order by tesoacuerdo.fecha DESC, tesoacuerdo.consecutivo ";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$_POST[numtop]=$ntr;
$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
$cond2="";
if ($_POST[numres]!="-1"){ 
	$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
}

$sqlr="select *from tesoacuerdo where tesoacuerdo.estado!='A' ".$crit1.$crit2.$crit3.$crit4.$crit5." order by tesoacuerdo.fecha DESC, tesoacuerdo.consecutivo $cond2";
$resp = mysql_query($sqlr,$linkbd);
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
echo "<table class='inicio' align='center' width='80%'>
	<tr>
		<td colspan='5' class='titulos'>.: Resultados Busqueda:</td>
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
		<td colspan='6'>Acuerdos Administrativos Encontrados: $ntr</td>
	</tr>
	<tr>
		<td class='titulos2'>Numero</td>
		<td class='titulos2'>Acto Administrativo</td>
		<td class='titulos2'>Valor</td>
		<td class='titulos2' width='10%'>Fecha</td>
		<td class='titulos2' width='5%'>Anular</td>
		<td class='titulos2' width='5%'>Editar</td>
	</tr>";	
$iter='saludo1';
$iter2='saludo2';
$filas=1;
 while ($row =mysql_fetch_row($resp)) 
 {
						if($gidcta!=""){
							if($gidcta==$row[0]){
								$estilo='background-color:yellow';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$idcta="'".$row[0]."'";
						$numfil="'".$filas."'";
						$dblclic="onDblClick=\"verUltimaPos($idcta, $numfil)\" ";
		echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" $dblclic style='text-transform:uppercase; $estilo' >
		<td >$row[1]</td>
		<td >$row[2]</td>
		<td >".number_format(strtoupper($row[5]),2)."</td>
		<td>$row[3]</td>";
		if($row[6]=='S')
		{
			echo"<td>
				<a href='#' onClick='eliminar(".$row[0].", ".$row[1].")'><center><img src='imagenes/anular.png'></center></a>
			</td>
			<td>
				<a onClick=\"verUltimaPos($idcta, $numfil)\" style='cursor:pointer;'>
					<center><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></center>
				</a>
			</td>";
		}
		else if($row[9]=='N')
		{
		echo"<td>
			<a href='#'><center><img src='imagenes/anulard.png' style='width:18px' title='Anulado'></center></a>
		</td>
		<td>
			<a onClick=\"verUltimaPos($idcta, $numfil)\" style='cursor:pointer;'>
				<center><img src='imagenes/lupa02.png' style='width:18px' title='Ver'></center>
			</a>
		</td>";
		}
		else{
		echo"<td>
			<a href='#'><center><img src='imagenes/candado.png' style='width:18px'></center></a>
		</td>
		<td>
			<a onClick=\"verUltimaPos($idcta, $numfil)\" style='cursor:pointer;'>
				<center><img src='imagenes/lupa02.png' style='width:18px' title='Ver'></center>
			</a>
		</td>";
		}
	echo"</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	 $filas++;
 }
					if ($_POST[numtop]==0)
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda<img src='imagenes\alert.png' style='width:25px'></td>
							</tr>
						</table>";
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
					echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
?></div>
             <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
</form>
</body>
</html>