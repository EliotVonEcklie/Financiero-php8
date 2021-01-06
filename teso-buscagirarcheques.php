<?php //V 1000 12/12/16 ?> 
	<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6 1111111
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css"/>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar El Egreso No "+idr))
  				{
  					document.form2.oculto.value=2;
  					document.form2.var1.value=idr;
					document.form2.submit();
  				}
			}
			function verUltimaPos(idcta, filas, filtro1, filtro2)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=10;}
				numpag++;
				location.href="teso-girarchequesver.php?idegre="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro1="+filtro1+"&filtro2="+filtro2;
			}
			function crearexcel(){
				document.form2.action="teso-buscagirarchequesexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php 
			titlepag();
			$scrtop=$_GET['scrtop'];
			if($scrtop=="") $scrtop=0;
			echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$scrtop.")}</script>";
			$gidcta=$_GET['idcta'];
			if(isset($_GET['filtro1']))
				$_POST[numero]=$_GET['filtro1'];
			if(isset($_GET['filtro2']))
				$_POST[nombre_1]=$_GET['filtro2'];
			
			if(isset($_GET[fini]) && isset($_GET[ffin])){
					if(!empty($_GET[fini]) && !empty($_GET[ffin])){
						$_POST[fecha_1]=$_GET[fini];
						$_POST[fecha2]=$_GET[ffin];
					}
				}
				$fech1=split("/",$_POST[fecha_1]);
				$fech2=split("/",$_POST[fecha2]);
				$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
				$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
            	<?php 
					if($_SESSION["prcrear"]==1)
					{$botonnuevo="<a href='teso-girarcheques.php' class='mgbt'><img src='imagenes/add.png' title='Nuevo' /></a>";}
					else
					{$botonnuevo="<a class='mgbt'><img src='imagenes/add2.png' /></a>";}
				?>
  				<td colspan="3" class="cinta"><?php echo $botonnuevo;?>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="#" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a>
				</td>
          	</tr>	
		</table>
 		<form name="form2" method="post" action="teso-buscagirarcheques.php">
 		<?php 
				if ($_POST[oculto]==""){$_POST[iddeshff]=0;$_POST[tabgroup1]=1;}
				 switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';break;
                }
			?>
        	<?php
				if($_GET[numpag]!="")
				{
					$oculto=$_POST[oculto];
					if($oculto!=2)
					{
						$_POST[numres]=$_GET[limreg];
						$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
						$_POST[nummul]=$_GET[numpag]-1;
					}
				}
				else{if($_POST[nummul]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}}
			?>
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="8">:. Buscar Pagos</td>
        			<td class="cerrar" style="width:7%;" ><a href="teso-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
					<td class="saludo1" style="width:2.2cm;">Fecha Inicial:</td>
       				<td style="width:9%;"><input name="fecha_1"  type="text" value="<?php echo $_POST[fecha_1]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
       				<td class="saludo1" style="width:2.2cm;">Fecha Final:</td>
       				<td style="width:9%;"><input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
        			<td class="saludo1" style="width:5cm;" >N&deg; Egreso, N&deg; Orden o Concepto:</td>
        			<td style="width:20%;" ><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:98%;" ></td>
         			<td class="saludo1" style="width:2cm;">Beneficiario: </td>
    				<td >
                    	<input type="search" name="nombre_1" id="nombre_1" value="<?php echo $_POST[nombre_1];?>"  style="width:60%;">&nbsp;&nbsp; 
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
        		</tr>                       
    		</table> 
            <input type="hidden" name="oculto" id="oculto" value="1">
         	<input type="hidden" name="var1" value=<?php echo $_POST[var1];?>>  
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/> 
       		<div class="tabsmeci" style="height:64.5%; width:99.6%;">
       		<div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Pagos General</label>
           	<div class="content" style="overflow-x:hidden;" id="divdet">
      			<?php
					$oculto=$_POST['oculto'];
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$_POST[vigencia]=$vigusu;
					if($_POST[oculto]==2)
					{
	 					$sqlr="select * from tesoegresos where id_egreso=$_POST[var1] and tipo_mov='201' ";
	 					$resp = mysql_query($sqlr,$linkbd);
	 					$row=mysql_fetch_row($resp);
		 				$op=$row[2];
	 					$vpa=$row[7];
	 					//********Comprobante contable en 000000000000
	  					$sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='6' and numerotipo=$row[0]";
	  					mysql_query($sqlr,$linkbd);
	  					$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='6 $row[0]'";
	  					mysql_query($sqlr,$linkbd);
	  					$sqlr="update pptocomprobante_cab set estado='0' where tipo_comp='11' and numerotipo=$row[0]";
	 					mysql_query($sqlr,$linkbd);
	 					//********RETENCIONES
 	 					$sqlr="delete from pptoretencionpago where idrecibo=$row[0] and vigencia='".$_SESSION[vigencia]."'";
	 					mysql_query($sqlr,$linkbd);
   	 					$sqlr="delete from pptorecibopagoppto where idrecibo=$row[0] and vigencia='".$_SESSION[vigencia]."'";
	 					mysql_query($sqlr,$linkbd);
	   					$sqlr="update tesoordenpago  set estado='S' where id_orden=$op and tipo_mov='201' ";
	  					mysql_query($sqlr,$linkbd);	 
	   					$sqlr="update tesoegresos set estado='N' where id_egreso=$_POST[var1] and tipo_mov='201' ";
	  					mysql_query($sqlr,$linkbd);	 
					}   					
					$crit1="";
					$crit2="";
					if ($_POST[numero]!=""){$crit1=" AND concat_ws(' ', id_egreso, id_orden, concepto) LIKE '%$_POST[numero]%'";}
					if ($_POST[nombre_1]!="")
					{
						$crit2="AND EXISTS (SELECT cedulanit FROM terceros WHERE concat_ws(' ', nombre1,nombre2,apellido1,apellido2,razonsocial,cedulanit) LIKE '%$_POST[nombre_1]%' AND terceros.cedulanit = tesoegresos.tercero)";
					}
					if($_POST[numero]!="" || $_POST[nombre_1]!="" || $_POST[fecha_1]!="" || $_POST[fecha2]!="")
					{
						$sqlr="SELECT * FROM tesoegresos WHERE id_egreso>-1 $crit1 $crit2  and tipo_mov='201'";
						if(isset($_POST[fecha_1]) && isset($_POST[fecha2]))
						{
							if(!empty($_POST[fecha_1]) && !empty($_POST[fecha2]))
							{
								$sqlr="SELECT * FROM tesoegresos WHERE id_egreso>-1 $crit1 $crit2 and fecha between '$f1' AND '$f2' and tipo_mov='201'"; 
							}
						}
						$resp = mysql_query($sqlr,$linkbd);
						$_POST[numtop]=mysql_num_rows($resp);
						$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
						$cond2="";
						if ($_POST[numres]!="-1"){ 
							$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
						}
						$sqlr="SELECT * FROM tesoegresos WHERE id_egreso>-1 $crit1 $crit2 and tipo_mov='201' ORDER BY id_egreso DESC $cond2";
						if(isset($_POST[fecha_1]) && isset($_POST[fecha2]))
						{
							if(!empty($_POST[fecha_1]) && !empty($_POST[fecha2]))
							{
								$sqlr="SELECT * FROM tesoegresos WHERE id_egreso>-1 $crit1 $crit2 and fecha between '$f1' AND '$f2' and tipo_mov='201' ORDER BY id_egreso DESC $cond2"; 
							}
						}
						$resp = mysql_query($sqlr,$linkbd);
					}
					
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
					$ntips1=7;
					$ntips2=9;
					echo "
					<table class='inicio' align='center' >
						<tr>
							<td colspan='$ntips1' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr><td colspan='$ntips2'>Pagos Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2'>Egreso</td>
							<td class='titulos2'>Orden Pago</td>
							<td class='titulos2'>Nombre</td>
							<td class='titulos2' width='6%'>Fecha</td>
							<td class='titulos2' style='text-align:center' width='7%'>Valor</td>
							<td class='titulos2' style='text-align:center'>Concepto</td>
							<td class='titulos2' width='4%'><center>Estado</td>
							<td class='titulos2' width='8%'><center>Medio de Pago</td>";
					echo"</tr>";	
					$iter='zebra1';
					$iter2='zebra2';
					$filas=1;

					if($_POST['fecha'] == '' && $_POST['fecha2'] == '' && $_POST['nombre_1'] == '' && $_POST['numero'] == '')
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%;font-size:25px'>Utilice el filtro de busqueda</td>
							</tr>
						</table>";
					}
					elseif(@mysql_num_rows($resp) == 0 || @mysql_num_rows($resp) == '0')
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%;font-size:25px'>No hay resultados de su busqueda.</td>
							</tr>
						</table>";
					}
					else
					{
						while ($row =mysql_fetch_row($resp)) 
						{
							$ntr=buscatercero($row[11]);
							if($gidcta!="")
							{
								if($gidcta==$row[0]){$estilo='background-color:#FF9';}
								else{$estilo="";}
							}
							else{$estilo="";}	
							$idcta="'".$row[0]."'";
							$numfil="'".$filas."'";
							$filtro1="'".$_POST[numero]."'";
							$filtro2="'".$_POST[nombre_1]."'";
							if($_SESSION["preditar"]==1)
							{
								echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
								onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro1, $filtro2)\" style='text-transform:uppercase; $estilo'>";
							}
							else
							{
								echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
								onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo'>";
							}
							echo"
								<td >$row[0]</td>
								<td >$row[2]</td>
								<td >$ntr</td>
								<td >$row[3]</td>
								<td >".number_format($row[7],2)."</td>
								<td >".strtoupper($row[8])."</td>";
							switch ($row[13]) 
							{
								case "S":	echo "<td ><center><img src='imagenes/confirm.png'></center></td>";break;
								case "P":	echo "<td ><center><img src='imagenes/dinero3.png'></center></td>";break;
								case "N":	echo "<td ><center><img src='imagenes/del3.png'></center></td>";break;
								case "R":	echo "<td ><center><img src='imagenes/reversado.png' style='width:18px'></center></td>";break;
							}
							$sqlrMedioPago = "SELECT medio_pago FROM tesoordenpago WHERE id_orden=$row[2]";
							$respMedioPago = mysql_query($sqlrMedioPago,$linkbd);
							$rowMedioPago = mysql_fetch_row($respMedioPago);
							if($rowMedioPago[0]==2)
								$medioPago = "SSF";
							else
								$medioPago = "CSF";
							
							echo"<td style='text-align:center;'>".$medioPago."</td>";
							
							echo "<input type='hidden' name='egreso[]' 		id='egreso[]' 		value='".$row[0]."'>";
							echo "<input type='hidden' name='ordenpago[]'	id='ordenpago[]' 	value='".$row[2]."'>";
							echo "<input type='hidden' name='tercero[]' 	id='tercero[]' 		value='".$row[11]."'>";
							echo "<input type='hidden' name='nombre[]' 		id='nombre[]' 		value='".$ntr."'>";
							echo "<input type='hidden' name='fecha[]' 		id='fecha[]' 		value='".$row[3]."'>";
							echo "<input type='hidden' name='valor[]' 		id='valor[]' 		value='".$row[7]."'>";
							echo "<input type='hidden' name='concepto[]' 	id='concepto[]' 	value='".$row[8]."'>";
							echo "<input type='hidden' name='estado[]' 		id='estado[]' 		value='".$row[13]."'>";
							echo "<input type='hidden' name='mediopago[]' 	id='mediopago[]' 	value='".$medioPago."'>";

							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$filas++;
						}
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
			</div></div>
			<div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="1" <?php echo $check2;?> >
                    <label for="tab-2">Pagos Reversados</label>
           	<div class="content" style="overflow-x:hidden;" id="divdet">
      			<?php
					$oculto=$_POST['oculto'];
					
					$crit1="";
					$crit2="";
					if ($_POST[numero]!=""){$crit1=" AND concat_ws(' ', id_egreso, id_orden, concepto) LIKE '%$_POST[numero]%'";}
					if ($_POST[nombre_1]!="")
					{
						$crit2="AND EXISTS (SELECT cedulanit FROM terceros WHERE concat_ws(' ', nombre1,nombre2,apellido1,apellido2,razonsocial,cedulanit) LIKE '%$_POST[nombre_1]%' AND terceros.cedulanit = tesoegresos.tercero)";
					}
					$sqlr="SELECT * FROM tesoegresos WHERE id_egreso>-1 and vigencia=$vigusu and tipo_mov='401' $crit1 $crit2";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
                    $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					$sqlr="SELECT * FROM tesoegresos WHERE id_egreso>-1 $crit1 $crit2 and vigencia=$vigusu and tipo_mov='401'ORDER BY id_egreso DESC $cond2";
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
					$ntips1=7;
					$ntips2=9;
					if($_SESSION["preditar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
					if($_SESSION["preliminar"]!=1){$ntips1=$ntips1-1;$ntips2=$ntips2-1;}
					echo "
					<table class='inicio' align='center' >
						<tr>
							<td colspan='$ntips1' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr><td colspan='$ntips2'>Pagos Encontrados: $_POST[numtop]</td></tr>
						<tr>
							<td class='titulos2'>Egreso</td>
							<td class='titulos2'>Orden Pago</td>
							<td class='titulos2'>Usuario</td>
							<td class='titulos2' width='6%'>Fecha</td>
							<td class='titulos2' style='text-align:center' width='7%'>Valor</td>
							<td class='titulos2' style='text-align:center'>Concepto</td>
							<td class='titulos2' width='4%'><center>Estado</td>";
					if($_SESSION["preditar"]==1){
						echo"<td class='titulos2' width='4%'><center>Ver</td>";
					}
					echo"</tr>";	
					$iter='zebra1';
					$iter2='zebra2';
					$filas=1;
					while ($row =mysql_fetch_row($resp)) 
					{
						$ntr=buscatercero($row[11]);
						if($gidcta!="")
						{
							if($gidcta==$row[0]){$estilo='background-color:#FF9';}
							else{$estilo="";}
						}
						else{$estilo="";}	
						$idcta="'".$row[0]."'";
						$numfil="'".$filas."'";
						$filtro1="'".$_POST[numero]."'";
						$filtro2="'".$_POST[nombre_1]."'";
						if($_SESSION["preditar"]==1)
						{
							echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
							onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro1, $filtro2)\" style='text-transform:uppercase; $estilo'>";
						}
						else
						{
							echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
							onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo'>";
						}
						$sqlv="SELECT valorpago FROM tesoegresos WHERE id_egreso=$row[0] AND tipo_mov='201' ";
						$resul=mysql_query($sqlv,$linkbd);
						$fila=mysql_fetch_row($resul);
						$valor=$fila[0];
						echo"
							<td >$row[0]</td>
							<td >$row[2]</td>
							<td >$row[17]</td>
							<td >$row[3]</td>
							<td >$ ".number_format($valor,2)."</td>
							<td >".strtoupper($row[8])."</td>";

							echo "<td ><center><img src='imagenes/reversado.png' style='width:18px'></center></td>";
						
						if($_SESSION["preditar"]==1)
						{
							echo"<td style='text-align:center;'>
									<a onClick=\"verUltimaPos($idcta, $numfil, $filtro1, $filtro2)\" style='cursor:pointer;'>
										<img src='imagenes/lupa02.png' style='width:18px' title='Ver'>
									</a>
								</td>";
						}
						
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
								<td class='saludo1' style='text-align:center;width:100%'>Utilice el filtro de busqueda. $tibusqueda</td>
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
			</div></div>

			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>