<?php //V 1000 12/12/16 ?> 
<!--V 1.0 29/02/2015 Creada por HAFR-->
<?php
	require "comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script> 
			function ponprefijo(idcomp,acuerdo,valor)
			{ 
				parent.document.form2.idabono.value =idcomp;
				parent.document.form2.nabono.value =idcomp;	
				parent.document.form2.codigoacuerdo.value=acuerdo;
				parent.document.form2.valortot.value=valor;
				parent.document.form2.idabono.focus();	
				parent.document.form2.idabono.select();
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
  		<form name="form2" action="" method="post">
        	<?php 
				if ($_POST[oculto]=='')
				{
					$_POST[numpos]=0;$_POST[numres]=100;$_POST[nummul]=0;
				}
			?>
			<table  class="inicio" style="width:99.4%;">
            
      			<tr>
        			<td class="titulos" colspan="4">.: Buscar Abono</td>
                 	<td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:3.5cm;">.: Numero Abono:</td>
        			<td>
                    	<input type="search" name="numero"  value="<?php echo $_POST[numero];?>" />
						<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;"/>
                    </td>
       			</tr>                       
    		</table> 
          	<input type="hidden" name="oculto" id="oculto"  value="1">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantalla" style="height:84.5%; width:99%; overflow-x:hidden;">
				<?php
                    $crit1="";
                    if ($_POST[numero]!=""){
						$crit1=" and (tesoabono.id_abono like '%$_POST[numero]%') ";
					}
					$sqlr="SELECT tesoabono.fecha, tesoabono.id_abono, tesoabono.concepto, tesoabono.valortotal FROM tesoabono WHERE tesoabono.estado='S' $crit1 ";
					// echo $_SESSION[vigencia];
                    $resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}	
					$sqlr="SELECT tesoabono.fecha, tesoabono.id_abono, tesoabono.concepto, tesoabono.idacuerdo,tesoabono.valortotal FROM tesoabono WHERE tesoabono.estado='S' $crit1 order by tesoabono.id_abono desc $cond2 ";
					// echo $sqlr;
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
                    echo "
					<table class='inicio' align='center' width='99%'>
						<tr>
							<td colspan='4' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu' style='width:2cm;'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='5'>Abonos Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' style='width:3%'>Item</td>
							<td class='titulos2' style='width:4%'>Vigencia</td>
							<td class='titulos2' style='width:8%'>N Abono</td>
							<td class='titulos2' colspan='2'>Detalle</td>
						</tr>";	
                    $iter='saludo1a';
                    $iter2='saludo2';
                    while ($row =mysql_fetch_row($resp)) 
                    {
                        $detalle=$row[2];
						$con2=$con+ $_POST[numpos];
                        echo"
                        <tr class='$iter' onClick=\"javascript:ponprefijo($row[1],$row[3],$row[4])\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
                            <td>$con2</td>
                            <td>$row[0]</td>
                            <td>$row[1]</td>
                            <td colspan='2'>$row[2]</td>
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
					echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
                ?>
			</div>
		</form>
	</body>
</html>
	