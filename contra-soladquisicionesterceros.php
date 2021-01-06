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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script> 
			function ponprefijo(pref,opc,valor,valor2,cargo)
			{   
				parent.document.form2.tercero.value =pref;
				parent.document.form2.ntercero.value =opc;
				parent.document.form2.dependencia.value =valor;
				parent.document.form2.iddependencia.value =valor2;
				parent.despliegamodal2('hidden');
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form action="" method="post" enctype="multipart/form-data" name="form2">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
			<table  class="inicio" style="width:99.4%;">
                <tr>
                    <td class="titulos" colspan="4">:: Buscar Empleado</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:2cm;">Nombre o Documento:</td>
                    <td>
                    	<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:70%;"/>
                        <input type="submit" name="Submit" value="Buscar" >
                    </td>
                </tr>                       
    		</table> 
    		<input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>"/>
            <input type="hidden" name="tnobjeto" id="tnobjeto" value="<?php echo $_POST[tnobjeto]?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallac" style="height:86%; width:99.1%; overflow-x:hidden;">
				<?php
                    $crit1=" ";
                    $crit2=" ";
                    if ($_POST[nombre]!="")
					{$crit1=" AND concat_ws(' ', t.nombre1,t.nombre2,t.apellido1,t.apellido2,t.cedulanit) like '%$_POST[nombre]%'";}
                    $sqlr="SELECT t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo $crit1 $crit2";
                    $resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo $crit1 $crit2 order by t.apellido1, t.apellido2, t.nombre1, t.nombre2 LIMIT $_POST[numpos],$_POST[numres]";
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
							<td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu' style='width:4%;'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
						</tr>
                        <tr><td colspan='8'>Terceros Encontrados: $_POST[numtop]</td></tr>
                        <tr>
                            <td class='titulos2' width='2%'>Item</td>
                            <td class='titulos2' width='30%'>Dependencia</td>
                            <td class='titulos2' width='30%'>CARGO</td>
                            <td class='titulos2' width='10%'>PRIMER APELLIDO</td>
                            <td class='titulos2' width='10%'>SEGUNDO APELLIDO</td>
                            <td class='titulos2' width='10%'>PRIMER NOMBRE</td>
                            <td class='titulos2' width='10%'>SEGUNDO NOMBRE</td>
                            <td class='titulos2' width='4%'>DOCUMENTO</td>
                        </tr>";	
                    $iter='saludo1a';
                    $iter2='saludo2';
                    while ($row =mysql_fetch_row($resp)) 
                    {
                        if ($row[11]=='31'){$ntercero=$row[5];}
                        else { $ntercero="$row[3] $row[4] $row[1] $row[2]";}
                        $dependencia=buscarareatrabajo($row[25]);
                        echo"
                        <tr class='$iter' onClick=\"javascript:ponprefijo('$row[12]','$ntercero','$dependencia','$row[25]','$_POST[tobjeto]', '$_POST[tnobjeto]','$_POST[tobjeto2]','$_POST[tobjeto3]','$row[24]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
                            <td>$con</td>
                            <td>$dependencia</td>
                            <td>$row[24]</td>
                            <td>$row[3]</td>
                            <td>$row[4]</td>
                            <td >$row[1]</td>
                            <td >$row[2]<td>$row[12]</td>
                        </tr>";
                         $con+=1;
                         $aux=$iter;
                         $iter=$iter2;
                         $iter2=$aux;
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
