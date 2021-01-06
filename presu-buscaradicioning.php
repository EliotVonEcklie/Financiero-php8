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
		<title>:: SPID - Presupuesto</title>
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
				location.href="presu-adicioningver.php?idac="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg;
			}

			function eliminar(idr, consec)
			{
			if (confirm("Esta Seguro de Anular el Traslado "+consec))
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
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a href="presu-adicioning.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
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
		<form name="form2" method="post" action="presu-buscaradicioning.php">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
		<table  class="inicio" align="center" >
			<tr >
				<td class="titulos" colspan="6">:: Buscar  Adicion/Reduccion Presupuestal</td>
				<td class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
			</tr>
			<tr >
				<td class="saludo1">Consecutivo:</td>
				<td><input name="consecutivo" type="text" value="" size="10"></td>
				<td class="saludo1">Acto Administrativo:</td>
				<td>
					<input name="acto" type="text" id="acto" value="" size="40" maxlength="40">
					<input id="oculto" name="oculto" type="hidden" value="1">
				</td>
				<td class="saludo1">Vigencia:</td>
				<td><input name="vigencia" type="text" value="" size="10"></td>
          
			</tr>                       
		</table>   
		<div class="subpantalla" style="height:69.5%; width:99.6%; overflow-x:hidden;" id="divdet">
		<?php
		$linkbd=conectar_bd();
		if($_POST[oculto]==2)
		{
			$sqlr="UPDATE pptotraslados SET estado='N' WHERE id_acuerdo='$_POST[var1]'";
			mysql_query($sqlr,$linkbd);
		}

		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		$crit3=" ";

		if ($_POST[consecutivo]!="")
		$crit1=" and pptoacuerdos.consecutivo like '%".$_POST[consecutivo]."%' ";
		if ($_POST[acto]!="")
		$crit2=" and pptoacuerdos.numero_acuerdo like '%$_POST[acto]%' ";
		if ($_POST[vigencia]!="")
		$crit3=" and pptoacuerdos.vigencia like '%".$_POST[vigencia]."%' ";

		$sqlr="select *from pptoacuerdos where (pptoacuerdos.valoradicion>0) or (pptoacuerdos.valorreduccion>0) and pptoacuerdos.tipo='M' ".$crit1.$crit2.$crit3." ORDER BY vigencia DESC, consecutivo ";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$_POST[numtop]=$ntr;
		$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
		$cond2="";
		if ($_POST[numres]!="-1"){ 
			$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
		}

		$sqlr="select *from pptoacuerdos where (pptoacuerdos.valoradicion>0) or (pptoacuerdos.valorreduccion>0) and pptoacuerdos.tipo='M' ".$crit1.$crit2.$crit3." ORDER BY id_acuerdo DESC, consecutivo $cond2";
		//$sqlr="select *from pptoacuerdos where (pptoacuerdos.valoradicion>0) or (pptoacuerdos.valorreduccion>0) and pptoacuerdos.tipo='M' ".$crit1.$crit2.$crit3." ORDER BY vigencia DESC, consecutivo $cond2";
		$resp = mysql_query($sqlr,$linkbd);

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

		//echo "$sqlr";
//else
///	$sqlr="select *from pptoacuerdos where pptoacuerdos.tipo='I'";
		 
//$sqlr="select pptocuentaspptoinicial.cuenta, pptocuentas.nombre, pptocuentaspptoinicial.fecha, pptocuentaspptoinicial.vigencia, pptocuentaspptoinicial.valor, pptocuentaspptoinicial.pptodef, pptocuentaspptoinicial.saldos, pptoacuerdos.consecutivo, pptoacuerdos.numero_acuerdo  from pptocuentaspptoinicial, pptocuentas, pptoacuerdos where pptocuentaspptoinicial.cuenta=pptocuentas.cuentas and pptocuentaspptoinicial.id_acuerdo=pptoacuerdos.id_acuerdo ".$crit1.$crit2." order by pptocuentaspptoinicial.cuenta";

// echo "<div><div>sqlr:".$sqlr."</div></div>";

	$con=1;
	echo "<table class='inicio' align='center' width='80%'>
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
			<td colspan='9'>Presupuesto Inicial Encontrados: $ntr</td>
		</tr>
		<tr>
			<td width='5%' class='titulos2'>Id Acto</td>
			<td class='titulos2'>Acto Administrativo</td>
			<td class='titulos2'>Fecha</td> 
			<td class='titulos2'>Vigencia</td> 
			<td class='titulos2'>Valor Inicial</td> 
			<td class='titulos2'>Estado</td>
			<td class='titulos2'>Tipo</td>
			<td class='titulos2'>Anular</td>
			<td class='titulos2'>Ver</td>
		</tr>";	
//echo "nr:".$nr;
$iter='zebra1';
$iter2='zebra2';
 while ($row =mysql_fetch_row($resp)) 
 {
	if($gidcta!=""){
		if($gidcta==$row[0]){
			$estilo='background-color:#FF9';
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
		<td >".strtoupper($row[0])."</td>
		<td >".strtoupper($row[2])."</td>
		<td>".strtoupper($row[3])."</td>
		<td >".strtoupper($row[4])."</td>
		<td >".strtoupper($row[8])."</td>
		<td >".strtoupper($row[9])."</td>
		<td >Presupuesto Inicial</td>
		<td ><a href='#'><center><img src='imagenes/anular.png'></center></a></td>";
		echo"<td>
			<a onClick=\"verUltimaPos($idcta, $numfil)\" style='cursor:pointer;'>
				<center><img src='imagenes/lupa02.png' style='width:18px' title='Ver'></center>
			</a>
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