<!--V 1000 14/12/16 -->
<?php
  require "comun.inc";
  require "funciones.inc";
  session_start();
  $linkbd=conectar_bd();  
  cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  header("Cache-control: private"); // Arregla IE 6
  date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: Contabilidad</title>
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
document.form2.action="teso-buscaconcecontablescausa.php";
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
</script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function verUltimaPos(idcta, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="hum-editaconcecontablesnomina.php?is="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
    <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("cont");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="hum-concecontablesnomina.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a> <a href="hum-concecontables.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td></tr>	
</table><tr><td colspan="3" class="tablaprin"> 
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
 <form name="form2" method="post" action="hum-buscaconcecontablesnomina.php">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres]; ?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos]; ?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul]; ?>"/>
         	<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="2">:: Buscar Concepto Contable Nomina</td>
        <td style="width:7%" class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
      <tr >
		<td style="width:3.5cm" class="saludo1">:. Codigo o Nombre:</td>
        <td style="width:80%">
        	<input name="nombre" type="text" style="width:50%" value="<?php echo $_POST[nombre]; ?>">
        	<input name="oculto" id="oculto" type="hidden" value="1"> 
       	</td>
        <td style="width:7%"></td>
       </tr>                       
    </table>
    <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet" >
      <?php
        $oculto=$_POST['oculto'];
        $linkbd=conectar_bd();
		$crit1="";
		$cond2="";
		if ($_POST[nombre]!="")
		$crit1="and concat_ws(' ', codigo, nombre) LIKE '%$_POST[nombre]%'";

		if ($_POST[numres]!="-1"){ 
			$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
		}
          //sacar el consecutivo 
	        $sqlr="select *from conceptoscontables where conceptoscontables.tipo='H' and conceptoscontables.modulo='2' ".$crit1." order by conceptoscontables.codigo";
          $resp = mysql_query($sqlr,$linkbd);
          $ntr = mysql_num_rows($resp); 
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
		$sqlr="select *from conceptoscontables where conceptoscontables.tipo='H' and conceptoscontables.modulo='2' ".$crit1." order by conceptoscontables.codigo ".$cond2;
		$resp = mysql_query($sqlr,$linkbd);			
		$co='saludo1a';
		$co2='saludo2';	
		$numcontrol=$_POST[nummul]+1;
		$i=($_POST[nummul]*$_POST[numres])+1;
		if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1")){
			$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
			$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
		}
		else{
			$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
			$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
		}
		if(($_POST[numpos]==0)||($_POST[numres]=="-1")){
			$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
			$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
		}
		else{
			$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
			$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
		}

          $con=1;
          echo "<table class='inicio' align='center'>
		  	<tr>
				<td colspan='3' class='titulos'>.: Resultados Busqueda:</td>
				<td class='submenu'>
					<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
						<option value='10'"; if ($_POST[renumres]=='10'){echo "selected";} echo ">10</option>
						<option value='20'"; if ($_POST[renumres]=='20'){echo "selected";} echo ">20</option>
						<option value='30'"; if ($_POST[renumres]=='30'){echo "selected";} echo ">30</option>
						<option value='50'"; if ($_POST[renumres]=='50'){echo "selected";} echo ">50</option>
						<option value='100'"; if ($_POST[renumres]=='100'){echo "selected";} echo ">100</option>
						<option value='-1'"; if ($_POST[renumres]=='-1'){echo "selected";} echo ">Todos</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan='3'>Concepto Contable Causacion Ingresos Encontrados: $ntr</td>
			</tr>
			<tr>
				<td width='150' class='titulos2'>Fecha</td>
				<td width='5%' class='titulos2'>Codigo</td>
				<td class='titulos2'>Nombre</td>
				<td class='titulos2' width='5%'>Editar</td>
			</tr>";	
			$con=1;
          	$iter='saludo1a';
          	$iter2='saludo2';
			$filas=1;
          	while ($row =mysql_fetch_row($resp)){
			$sq="select fechainicial from conceptoscontables_det where codigo='$row[0]' and modulo='$row[2]' and tipo='$row[3]'";
			$rs = mysql_query($sq,$linkbd);
			$rw =mysql_fetch_row($rs);
						if($gidcta!=""){
							if($gidcta==$row[0]){
								$estilo='background-color: yellow;';
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
						$filtro="'".$_POST[nombre]."'";
				echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
					<td>$rw[0]</td>
					<td>".strtoupper($row[0])."</td>
					<td>".strtoupper($row[1])."</td>";
					echo"<td style='text-align:center;'>
							<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
								<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
							</a>
						</td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
				 $filas++;
          }
          echo"</table>";
				echo"<table class='inicio'>
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
</form>
</td></tr>     
</table>
</body>
</html>