<?php
	require "comun.inc";
	require"funciones.inc";
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
		<title>:: Siip - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function ponprefijo(pref,codc)
			{
    			parent.document.form2.codacuerdo.value =pref;
				parent.document.form2.codcatastral.value =codc;
   		 		parent.document.form2.codacuerdo.focus();
				parent.despliegamodal2("hidden");
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body >
    	 <form action="" method="post" name="form2">
			<?php
                if(!$_POST[tipo])
                {
                    $_POST[tipo]=$_GET[ti];
                    $_POST[modulo]=$_GET[modulo];
                }
				if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}
            ?>
			<table  class="inicio" style="width:99.4%;">
      			<tr >
       		 		<td class="titulos" colspan="4">:: Buscar Acuerdos Predial</td>
                    <td class="cerrar" style="width:7%"><a onClick="parent.despliegamodal2('hidden');" >&nbsp;Cerrar</a></td>
      			</tr>
      			<tr >
        			<td class="saludo1" style="width:4cm;">Cod. Catastral:</td>
        			<td>
                    	<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:60%;"/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                 	</td>
     			</tr>                       
    		</table>
            <input type="hidden" name="oculto" id="oculto"  value="1">
           	<input type="hidden" name="tipo" id="tipo" value="<?php echo $_POST[tipo]?>">
         	<input type="hidden" name="modulo" id="modulo" value="<?php echo $_POST[modulo]?>">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantalla" style="height:83.5%; width:99%; overflow-x:hidden;">
				<?php
					if ($_POST[nombre]!=""){$crit1.="AND concat_ws(' ', codcatastral) LIKE '%$_POST[nombre]%'";}
					$sqlr="SELECT * FROM tesoacuerdopredial WHERE estado='S' $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
					$sqlr="SELECT * FROM tesoacuerdopredial WHERE estado='S' $crit1 ORDER BY idacuerdo $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$numcontrol=$_POST[nummul]+1;
					if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;'>";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					$con=1;
					echo "
					<table class='inicio' align='center' width='99%'>
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
						<tr><td colspan='6'>Acuerdos Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2'>Item</td>
							<td class='titulos2'>Num. Acuerdo</td>
							<td class='titulos2'>Cod. Catastral</td>
							<td class='titulos2'>Vigencia</td>
							<td class='titulos2'>Cuotas</td>
							<td class='titulos2'>Fecha Acuerdo</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
                    while ($row =mysql_fetch_row($resp)) 
					{
						echo"
						<tr class='$iter' onClick=\"javascript:ponprefijo('$row[0]','$row[1]')\" style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td>$con</td>
							<td>$row[0]</td>
							<td>$row[1]</td>
							<td>$row[2] </td>
							<td>$row[4] </td>
							<td>$row[5] </td>
						</tr>";
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
									<a>$imagensback</a>&nbsp;
									<a>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
						else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
					}
					echo "		&nbsp;&nbsp;<a>$imagenforward</a>
									&nbsp;<a>$imagensforward</a>
								</td>
							</tr>
						</table>";
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>
