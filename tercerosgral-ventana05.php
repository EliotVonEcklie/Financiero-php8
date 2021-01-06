<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
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
        <title>:: SieS</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
        function ponprefijo(pref,opc,objeto,nobjeto,nfoco)
		{   
            parent.document.getElementById(''+objeto).value =pref ;
            parent.document.getElementById(''+nobjeto).value =opc ;
			parent.document.form2.bt.value='1';
			parent.document.form2.submit();
			parent.despliegamodal2("hidden");
        } 
        </script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
			<?php
				if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}
          		$_POST[tobjeto]=$_GET[objeto];$_POST[tnobjeto]=$_GET[nobjeto];
         	 ?>
			<table  class="inicio" style="width:99.4%;" >
      			<tr>
                	<td class="titulos" colspan="4">:: Buscar Tercero</td>
                	<td class="cerrar" style="width:7%"><a onClick="parent.despliegamodal2('hidden');" >&nbsp;Cerrar</a></td>
                </tr>
      			<tr>
                	<td class="saludo1" style="width:4cm;">Documento o Nombre:</td>
       				<td >
                    	<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:60%;"/>
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                	</td>
       			</tr>                       
    		</table> 
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="tobjeto" id="tobjeto" value="<?php echo $_POST[tobjeto]?>"/>
            <input type="hidden" name="tnobjeto" id="tnobjeto" value="<?php echo $_POST[tnobjeto]?>"/>
            <input type="hidden" name="tnfoco" id="tnfoco" value="<?php echo $_POST[tnfoco]?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
            <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
            <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            <div class="subpantalla" style="height:83.5%; width:99%; overflow-x:hidden;">
				<?php
					$crit1=" ";
					$crit2=" ";
					if ($_POST[nombre]!="")
					{$crit1="AND concat_ws(' ', nombre1,nombre2,apellido1,apellido2,razonsocial,cedulanit) LIKE '%$_POST[nombre]%'";}
					$sqlr="SELECT * FROM terceros where estado='S' $crit1 $crit2 ";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
					$sqlr="SELECT * FROM terceros where estado='S' $crit1 ORDER BY apellido1,apellido2,nombre1,nombre2 $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
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
					echo "
					<table class='inicio' align='center' width='99%'>
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
						<tr><td colspan='7'>Terceros Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2' width='2%'>Item</td>
							<td class='titulos2' width='30%'>RAZON SOCIAL</td>
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
						$con2=$con+ $_POST[numpos];
						if ($row[11]=='31'){$ntercero=$row[5];}
						else {$ntercero=$row[3].' '.$row[4].' '.$row[1].' '.$row[2];}
						echo "
						<tr class='$iter' onClick=\"javascript:ponprefijo('$row[12]','$ntercero','$_POST[tobjeto]','$_POST[tnobjeto]', '$_POST[tnfoco]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td>$con2</td>
							<td>".strtoupper($row[5])."</td>
							<td>".strtoupper($row[3])."</td>
							<td>".strtoupper($row[4])."</td>
							<td>".strtoupper($row[1])."</td>
							<td>".strtoupper($row[2])."</td>
							<td>$row[12]</td>
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
