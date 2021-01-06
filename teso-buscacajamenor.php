<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
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
				var fi=document.getElementById("fc_1198971545").value;
				var ff=document.getElementById("fc_1198971546").value;
				location.href="teso-cajamenoreditar.php?idop="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro+"&fini="+fi+"&ffin="+ff;
			}
		

			function crearexcel(){
				document.form2.action="teso-buscaegresoexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				//refrescar();
			}

			function eliminar(idr){
				if (confirm("Esta Seguro de Eliminar la liquidacion No "+idr)){
				document.form2.oculto.value=2;
				document.form2.var1.value=idr;
				document.form2.submit();
				}
			}
            
		</script>
		<?php titlepag();?>
        <?php
				if(isset($_GET[fini]) && isset($_GET[ffin])){
					if(!empty($_GET[fini]) && !empty($_GET[ffin])){
						$_POST[fecha]=$_GET[fini];
						$_POST[fecha2]=$_GET[ffin];
					}
				}
				$fech1=split("/",$_POST[fecha]);
				$fech2=split("/",$_POST[fecha2]);
				$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
				$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];

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
				<a href="teso-contabilizacajamenor.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a href="#" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="#" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a></td>
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
 		<form name="form2" method="post" action="teso-buscacajamenor.php">
 		<?php 
				if ($_POST[oculto]==""){$_POST[iddeshff]=0;$_POST[tabgroup1]=1;}
				 switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';break;
                }
			?>
         	<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
         	<input name="excel"  id="excel"  type="hidden" value="<?php echo $_POST[excel] ?>" >
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="6">:. Buscar comprobantes caja menor</td>
        			<td class="cerrar" style='width:7%'><a href="teso-principal.php">&nbsp;Cerrar</a></td>
              	</tr>
              	<tr>
              		<td class="saludo1" style="width:3.1cm;">Fecha Inicial:</td>
       				<td style="width:12%;"><input name="fecha"  type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
       				<td class="saludo1" style="width:3.1cm;">Fecha Final:</td>
       				<td style="width:12%;"><input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
                 	<td style="width:15%" class="saludo1">N&uacute;mero o Detalle Comprobante: </td>
    				<td >
                		<input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:50%" >
	          			<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
               		</td>
       			</tr>                       
    		</table> 
            <input name="oculto" id="oculto" type="hidden" value="1">
            <input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>  
    		<script>
    			document.form2.nombre.focus();
	    		document.form2.nombre.select();
    		</script>
    		<input type="hidden" name="fecham1"  id="fecham1" value="<?php echo $_POST[fecham1]; ?>"/>
    		<input type="hidden" name="fecham2" id="fecham2" value="<?php echo $_POST[fecham2]; ?>"/>
     		<div class="tabsmeci" style="height:64.5%; width:99.6%;">
             	<div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Caja menor</label>
           	<div class="content" style="overflow-x:hidden;" id="divdet">
      			<?php
	  			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				
				$_POST[fecham1]=$f1;
				$_POST[fecham2]=$f2;
				//$_POST[fecha]=$f1;
				//$_POST[fecha2]=$f2;
				if($_POST[oculto]==2){
				 	$linkbd=conectar_bd();	
				 	$sqlr="select * from tesocontabilizacajamenor where id_cajamenor=$_POST[var1] and estado='1' ";
				 	$resp = mysql_query($sqlr,$linkbd);
				 	$row=mysql_fetch_row($resp);
				 	$rpe=$row[4];
				 	$vpa=$row[10];
				 	$nop=$row[0];
				 	$vigop=$row[3];
				 	//********Comprobante contable en 000000000000
				  	$sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='36' and numerotipo=$row[0]";
				  	mysql_query($sqlr,$linkbd);
				  	$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='36 $row[0]'";
				  	mysql_query($sqlr,$linkbd);
				 	//***anular ppto 
				  	
				   	$sqlr="update tesocontabilizacajamenor  set estado='0' where id_cajamenor=$_POST[var1] and estado='1' ";
				  	mysql_query($sqlr,$linkbd);	 
				  	
				} 
				
				//****** 	
				$linkbd=conectar_bd();
				$crit1="";
				
				if ($_POST[nombre]!="")
					$crit1="and concat_ws(' ', id_cajamenor, objeto) LIKE '%$_POST[nombre]%'";
				//sacar el consecutivo 
				if($_POST[nombre]!="" || $_POST[fecha]!="" || $_POST[fecha2]!="")
				{
					$sqlr="select * from tesocontabilizacajamenor where tesocontabilizacajamenor.id_cajamenor>-1 $crit1 order by tesocontabilizacajamenor.id_cajamenor DESC"; 
					if(isset($_POST[fecha]) && isset($_POST[fecha2])){
						if(!empty($_POST[fecha]) && !empty($_POST[fecha2])){
							$sqlr="select * from tesocontabilizacajamenor where tesocontabilizacajamenor.id_cajamenor>-1 $crit1 and fecha between '$f1' AND '$f2' order by tesocontabilizacajamenor.id_cajamenor DESC"; 
						}
					}
					
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$_POST[numtop]=$ntr;
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$cond2="";
					if ($_POST[numres]!="-1"){
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
					$sqlr="select * from tesocontabilizacajamenor where tesocontabilizacajamenor.id_cajamenor>-1 $crit1 order by tesocontabilizacajamenor.id_cajamenor desc $cond2";
					if(isset($_POST[fecha]) && isset($_POST[fecha2])){
						if(!empty($_POST[fecha]) && !empty($_POST[fecha2])){
							$sqlr="select * from tesocontabilizacajamenor where tesocontabilizacajamenor.id_cajamenor>-1 $crit1 and fecha between '$f1' AND '$f2' order by tesocontabilizacajamenor.id_cajamenor DESC"; 
						}
					}

				}	
				
				$resp = mysql_query($sqlr,$linkbd);
				$con=1;
				$numcontrol=$_POST[nummul]+1;
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
					<tr>
						<td colspan='9'>Liquidaciones Encontrados: $ntr</td>
					</tr>
					<tr>
						<td class='titulos2' style='width:3%'>Item</td>
						<td class='titulos2' style='width:6.5%'>Fecha</td>
						<td class='titulos2' >Objeto</td>
						<td class='titulos2' style='width:10%'>Valor</td>
						<td class='titulos2' style='width:5%'>Estado</td>
						<td class='titulos2' style='width:5%'>Ver</td>
					</tr>";	
                    $iter='saludo1a';
                    $iter2='saludo2';
					$filas=1;
 					while ($row =mysql_fetch_row($resp)){
 						$detalle=$row[1];
 						switch ($row[4]){
							case "1":
								$imagen="src='imagenes/confirm.png' title='Activo'";
								$camcelda="<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png' title='Anular'></a></td>";
								break;
							case "0":
								$imagen="src='imagenes/cross.png' title='Anulado'";
								$camcelda="<td style='text-align:center;'><img src='imagenes/candado.png' title='bloqueado' style='width:18px'/></td>";
						}
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
						$idcta="'$row[0]'";
						$numfil="'$filas'";
						$filtro="'$_POST[nombre]'";
						echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
						 	<td>$row[0]</td>
						 	<td>".date('d-m-Y',strtotime($row[2]))."</td>
						 	<td>$row[1]</td>
						 	<td style='text-align:right;'>$ ".number_format($row[3],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."&nbsp;&nbsp;</td>
						 	<td style='text-align:center;'><img $imagen style='width:18px'></td>";
							echo"<td style='text-align:center;'>
								<a onClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='cursor:pointer;'>
									<img src='imagenes/lupa02.png' style='width:18px' title='Ver'>
								</a>
							</td>
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
					echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
?></div>
            	</div>
            </div>
</form>
</body>
</html>