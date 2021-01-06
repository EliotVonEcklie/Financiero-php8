<?php //V 1002 28/12/16 No mostraba los egresos reversados?> 
<?php
	error_reporting(0);
	require "comun.inc";
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
		<title>:: SieS</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function ponprefijo(norden,valor)
			{
   				parent.document.form2.docgen.value=norden;
				parent.document.form2.valdoc.value=valor;
				parent.document.form2.saldo.value=valor;
				parent.document.form2.docgen.focus();	
				parent.document.form2.docgen.select();
				parent.document.form2.submit();
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
  	<form action="" method="post" name="form2">
    	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
		<table  class="inicio" style="width:99.4%;">
      		<tr >
        		<td class="titulos" colspan="4">:: Buscar Proceso</td>
                <td class="cerrar"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
      		</tr>
      		<tr >
        		<td class="saludo1" style="width:5cm">:: No. de Proceso u Objeto:</td>
        		<td style="width:35%"><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:98%;"></td>
                <td class="saludo1" style="width:2cm">:: Vigencia:</td>
                <td><input type="search" name="vigenciab" id="vigenciab" value="<?php echo $_POST[vigenciab];?>" style="width:50%;">&nbsp;&nbsp;<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
       		</tr>                       
    	</table> 
    	<input type="hidden" name="oculto" id="oculto" value="1">
    	<input type="hidden" name="vigencia" value="<?php echo $_GET[vigencia]?>">
        <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
        <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
        <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
		<div class="subpantalla" style="height:86%; width:99%; overflow-x:hidden;">
			<?php
				$_POST[vigenciab]=$_GET[vigencia];
				$crit1="";
				$crit2=" ";
				if ($_POST[numero]!="")
				{
					$crit1="AND contraprocesos.idproceso LIKE '$_POST[numero]'";
				}
				
				if ($_POST[vigenciab]!=""){$crit2=" and (contraprocesos.vigencia like '%$_POST[vigenciab]%')";}
				
				$sqlr="SELECT contraprocesos.idproceso,contraprocesos.vigencia,contraprocesos.objeto,contracontrato.valor_contrato FROM  contraprocesos,contracontrato, contrasoladquisiciones WHERE contraprocesos.estado='S' AND contracontrato.id_contrato=contraprocesos.idproceso AND contrasoladquisiciones.codsolicitud=contraprocesos.codsolicitud AND contrasoladquisiciones.coddestcompra='02'  $crit1 $crit2"; 
				$resp = mysql_query($sqlr,$linkbd);
				$i=0;
				while($row = mysql_fetch_row($resp))
				{
					$sql="SELECT *FROM acticrearact WHERE documento='$row[0]'";
					$res=mysql_query($sql,$linkbd);
					$rowp=mysql_fetch_row($res);
					$numca=mysql_num_rows($res);
					if($numca>0)
					{
						$i++;
				    }
				
				}
				$_POST[numtop]=$i;
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$sqlr="SELECT contraprocesos.idproceso,contraprocesos.vigencia,contraprocesos.objeto,contracontrato.valor_contrato FROM  contraprocesos,contracontrato, contrasoladquisiciones WHERE contraprocesos.estado='S' AND NOT EXISTS (SELECT 1 FROM acticrearact WHERE acticrearact.codigo = contraprocesos.idproceso and acticrearact.estado='S') AND contracontrato.id_contrato=contraprocesos.idproceso AND contrasoladquisiciones.codsolicitud=contraprocesos.codsolicitud AND contrasoladquisiciones.coddestcompra='02' $crit1 $crit2 order by contraprocesos.idproceso LIMIT $_POST[numpos],$_POST[numres]";
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
				echo "
				<table class='inicio' align='center' width='99%'>
				<tr>
					<td colspan='4' class='titulos'>.: Resultados Busqueda:</td>
					<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
				</tr>
				<tr><td colspan='6'>Procesos Encontrados: $_POST[numtop]</td></tr>
				<tr>
					<td class='titulos2' style='width:5%'>Item</td>
					<td class='titulos2' style='width:5%'>N&deg; Proceso</td>
					<td class='titulos2' style='width:5%'>Vigencia</td>
					<td class='titulos2' >Objeto</td>
					<td class='titulos2' style='width:8%'>Valor Pagar</td>
				</tr>";	
				$iter='saludo1a';
				$iter2='saludo2';
				while ($row =mysql_fetch_row($resp)) 
				{	
					$numca=mysql_num_rows($res);
					$nomter=buscatercero($row[6]);
					$con2=$con+ $_POST[numpos];
					echo"<tr class='$iter' style='text-transform:uppercase' onClick=\"javascript:ponprefijo('$row[0]','$row[3]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
					<td>$con2</td>
					<td><b>$row[0]</b></td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td style='text-align:left;'>$".number_format($row[3])."</td></tr>";
					$con+=1;
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
				}
				if ($_POST[numtop]==0)
				{
					echo "
					<table class='inicio'>
						<tr>
							<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='imagenes\alert.png' style='width:25px'></td>
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
				echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
							</td>
						</tr>
					</table>";
?>
</div>
<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
</form>
</body>
</html>
