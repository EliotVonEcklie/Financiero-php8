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
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function ponprefijo(opc1,opc2)
			{
				parent.document.getElementById('tipocomp').value=opc1;	
				parent.document.getElementById('ntipocomp').value=opc2;
                parent.document.getElementById('oculto').value=1;
				parent.document.form2.submit();
				parent.despliegamodal2('hidden');
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
        	<?php
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;
					$_POST[numres]=10;
					$_POST[nummul]=0;
				}
			?>
 			<table  class="inicio" style="width:99.4%;" >
      			<tr>
              		<td class="titulos" colspan="4">:: Buscar tipo de comprobantes contables</td>
                    <td class="cerrar" style="width:10%;"><a onClick="parent.despliegamodal2('hidden');" href="#" >&nbsp;Cerrar</a></td>
                </tr>
     			<tr>
                	<td class="saludo1" style="width:2cm;">:: C&oacute;digo:</td>
                    <td style="width:20%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo];?>" style="width:100%;"/></td>
        			<td class="saludo1" style="width:2cm;">:: Nombre:</td>
        			<td>
                    	<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:70%"/>&nbsp;
                        <input type="button" name="Submit" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" onClick="document.form2.submit();"/>
                    </td>
 				</tr>
 			</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantallac" style="height:87%; width:99.1%; overflow-x:hidden;">
			<?php
 					$co='saludo1a';
 					$co2='saludo2';
					$crit1="";
                    $crit2="";
					if ($_POST[codigo]!=""){$crit1=" AND  codigo LIKE '%$_POST[codigo]%'";}
                    if ($_POST[nombre]!=""){$crit2=" AND  nombre LIKE '%$_POST[nombre]%'";}
 					$sqlr="SELECT * FROM tipo_comprobante WHERE id_cat='3' $crit1 $crit2 ";
 					$resp=mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
                    $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
                    $cond2="";

					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					$crit2="";
					if(empty($crit1)){
						$crit2=" AND cc.id=tc.id_cat";
					}else{
						$crit2="AND cc.id=tc.id_cat";
                    }
                    
                    $sqlr = "SELECT tc.nombre,tc.estado,tc.codigo,cc.nombre FROM tipo_comprobante as tc,categoria_compro as cc WHERE tc.id_cat='3' $crit1 $crit2 ORDER BY tc.id_tipo ";
                    //echo $sqlr;
 					$resp=mysql_query($sqlr,$linkbd);
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
					echo"
 					<table class='inicio'>
						<tr>
							<td colspan='2' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu' style='width:5%;'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='6'>Articulos Encontrados: $_POST[numtop]</td></tr>
 						<tr>
							<td class='titulos2' style='width:10%'>Codigo</td>
							<td class='titulos2'>Nombre Comprobante</td>
							<td class='titulos2' style='width:25%'>Categoria Comprobante</td>
						</tr>";
					while($row=mysql_fetch_row($resp))
  					{
                        $sqlrTipoComp = "select * from almtipomov where tipo_comp='$row[2]'";
                        $respTipoComp=mysql_query($sqlrTipoComp,$linkbd);
                        $rowTipoComp=mysql_fetch_row($respTipoComp);
                        if($rowTipoComp[0]=='')
                        {
                            echo"
                            <tr class='$co' onClick=\"ponprefijo('$row[2]','$row[0]')\" style='text-transform:uppercase'>
                                <td>$row[2]</td>
                                <td>$row[0]</td>
                                <td>$row[3]</td>
                            </tr>";
                            $aux=$co;
                            $co=$co2;
                            $co2=$aux;
                        }
                        
  					}
 			?>
 			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
 		</form>
	</body>
</html>
