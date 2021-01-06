<?php
	require"comun.inc";
	require"funciones.inc";
	setlocale(LC_ALL,"es_ES");
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
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script>
			function verUltimaPos(idcta, filas, filtro)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=10;}
				numpag++;
				location.href="teso-predialver.php?idpredial="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.oculto.value=2;
					document.form2.var1.value=idr;
					document.form2.submit();
				}
			}
			function crearexcel()
			{
				document.form2.action="teso-buscapredialexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
				//refrescar();
			}
			function funordenar(var01)
			{
				if(document.getElementById(''+var01).value==0){document.getElementById(''+var01).value=1;}
				else if(document.getElementById(''+var01).value==1) {document.getElementById(''+var01).value=2;}
				else{document.getElementById(''+var01).value=0;}
				document.form2.submit();
			}
		</script>
		<?php 
			titlepag();
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
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
		  		<td colspan="3" class="cinta">
					<a><img src="imagenes/add.png" onClick="location.href='teso-importapredial.php'" class="mgbt" title="Nuevo"/></a>
					<a><img src="imagenes/guardad.png" class="mgbt1"/></a>
					<a><img src="imagenes/busca.png" onClick="document.form2.submit();" class="mgbt" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt" title="Nueva Ventana"></a>
					<a><img src="imagenes/excel.png" title="Exportar Excel" onclick="#" class="mgbt"/></a>
				</td>
       		</tr>	
		</table>
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
			else
			{
				if($_POST[nummul]=="")
				{
					$_POST[numres]=10;
					$_POST[numpos]=0;
					$_POST[nummul]=0;
				}
			}
		?>
		<form name="form2" method="post" action="">
    		<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<table  class="inicio" align="center" >
    			<tr>
        			<td class="titulos" colspan="3">:. Buscar Liquidacion Predial</td>
                    <td class="cerrar" style='width:7%'><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr >
        			<td style="width:6cm" class="saludo1">Numero Liquidacion o Codigo Catastral:</td>
        			<td style="width:30%"><input type="search" name="nombre" id="nombre" style="width:95%" value="<?php echo $_POST[nombre]?>"/></td>
           			<td><input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
        		</tr>                       
    		</table>    
    		<input type="hidden" name="oculto" id="oculto"  value="<?php echo $_POST[oculto] ?>" >
        	<input type="hidden" name="var1" id="var1"  value="<?php echo $_POST[var1] ?>" />
			<div class="subpantallac5" style="height:68.5%; width:99.6%; overflow-x:hidden;" id="divdet">
				<?php
                    if($_POST[oculto]==2)
                    {
                        $sqlr="UPDATE tesoliquidapredial SET estado='N' WHERE idpredial=$_POST[var1]";
                        mysql_query($sqlr,$linkbd);
                        $sqlr="UPDATE tesoliquidapredial_det SET estado='N' WHERE idpredial=$_POST[var1]";
                        mysql_query($sqlr,$linkbd);
                    }
                    $oculto=$_POST['oculto'];
                    $crit1="";
                    if ($_POST[nombre]!=""){$crit1="and concat_ws(' ', idpredial, codigocatastral) LIKE '%$_POST[nombre]%'";}
                    //sacar el consecutivo 
                    $sqlr="select *from tesoliquidapredial where tesoliquidapredial.idpredial>-1 $crit1";
                    $resp = mysql_query($sqlr,$linkbd);
                    $ntr = mysql_num_rows($resp);
                    $_POST[numtop]=$ntr;
                    $nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
                    $cond2="";
                    if ($_POST[numres]!="-1"){ $cond2="LIMIT $_POST[numpos], $_POST[numres]";}
                    $sqlr="select * from tesoliquidapredial where idpredial>-1 $crit1 order by idpredial desc $cond2 ";
                    $resp = mysql_query($sqlr,$linkbd);
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
                    $con=1;
                    echo "
                    <table class='inicio' align='center'>
                        <tr>
                            <td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
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
                            <td colspan='8' class='saludo3'>Recaudos Encontrados: $ntr</td>
                        </tr>
                        <tr>
                            <td width='150' class='titulos2'>No Liquidacion</td>
                            <td class='titulos2'>Codigo Catastral</td>
                            <td class='titulos2'>Fecha</td>
                            <td class='titulos2'>Contribuyente</td>
                            <td class='titulos2'>Valor</td>
                            <td class='titulos2'>Estado</td>
                            <td class='titulos2' width='5%'><center>Anular</td>
                            <td class='titulos2' width='5%'><center>Ver</td>
                        </tr>";	
                    $iter='saludo1a';
                    $iter2='saludo2';
                    $filas=1;
                    while ($row =mysql_fetch_row($resp))
                    {
                        $sqlr="select sum(totaliquidavig) from  tesoliquidapredial_det where idpredial=$row[0]";
                        $resp2=mysql_query($sqlr,$linkbd);
                        $r2=mysql_fetch_row($resp2);
                        $nter=buscatercero($row[4]);
                        if($gidcta!="")
                        {
                            if($gidcta==$row[0]){$estilo='background-color:yellow';}
                            else {$estilo="";}
                        }
                        else{$estilo="";}	
                        $idcta="'$row[0]'";
                        $numfil="'$filas'";
                        $filtro="'$_POST[nombre]'";
                        echo"
                            <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
                onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
                                <td >$row[0]</td>
                                <td >$row[1]</td>
                                <td>$row[2]</td>
                                <td>$row[4] - $nter</td>
                                <td >".number_format($r2[0],2,",",".")."</td>";
                        if ($row[18]=='S')
                        echo "
                                <td><center><img src='imagenes/confirm.png'></center></td>
                                <td><a href='#' onClick=eliminar($row[0])><center><img src='imagenes/borrar01.png' style='Width:19px;' title='Anular'></center></a></td>";
                        if ($row[18]=='N')
                        echo "
                                <td><center><img src='imagenes/cross.png'></center></td>
                                <td></td>";
                        if ($row[18]=='P')
                        echo "
                                <td><center><img src='imagenes/dinero3.png'></center></td>
                                <td></td>";
                        echo"
                                <td style='text-align:center;'><a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'><img src='imagenes/lupa02.png' style='width:18px' title='Ver'></a></td>
                            </tr>";
                        $con+=1;
                        $aux=$iter;
                        $iter=$iter2;
                        $iter2=$aux;
                        $filas++;
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
                                echo"&nbsp;&nbsp;<a href='#'>$imagenforward</a>
                                    &nbsp;<a href='#'>$imagensforward</a>
                            </td>
                        </tr>
                    </table>";
				?>
			</div>
		</form> 
	</body>
</html>