<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"  />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Planeacion Estrategica</title>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }

function validar()
{
	 document.getElementById('oculto').value=5;
	document.form2.submit();
}

function validar2()
{
	
valor=document.getElementById('tipo').value;
for	(x=valor;x<=4;x++)
{
v="id"+x;	
document.getElementById(v).disabled=true;

}


for	(x=valor;x<=4;x++)
{
v="id"+x;	
document.getElementById(v).disabled=true;

}
	
document.form2.submit();
}

function guardar()
{
if (document.form2.consecutivo.value!='' )
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.consecutivo.focus();
  	document.form2.consecutivo.select();
  }
}
 </script> 
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>

	<link rel="stylesheet" href="treeview/jquery.treeview.css" />
    <link rel="stylesheet" href="treeview/red-treeview.css" />
	<link rel="stylesheet" href="css/screen.css" />
	<script src="treeview/lib/jquery.js" type="text/javascript"></script>
	<script src="treeview/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="treeview/jquery.treeview.js" type="text/javascript"></script>
    <script type="text/javascript" src="css/programas.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
		$("#browser").treeview({
			toggle: function() {
				console.log("%s was toggled.", $(this).find(">span").text());
			}
		});
		
		$("#add").click(function() {
			var branches = $("<li><span class='folder'>New Sublist</span><ul>" + 
				"<li><span class='file'>Item1</span></li>" + 
				"<li><span class='file'>Item2</span></li></ul></li>").appendTo("#browser");
			$("#browser").treeview({
				add: branches
			});
		});
	});
	</script>
		<script>
			function verUltimaPos(idcta, filas, vigini, vigfin, padre, buscta, ruta){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="plan-editaplandesarrollo.php?idproceso="+idcta+"&vigini="+vigini+"&vigfin="+vigfin+"&buscta="+buscta+"&padre="+padre+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&ruta="+ruta;
			}

		</script>
    
    <script type="text/javascript">
		$(function() {
			$("#add").treeview({
				collapsed: true,
				animated: "fast",
				control:"#sidetreecontrol",
				prerendered: true,
				persist: "location"
			});
		})
		
	</script>
    <script>
	function buscasgte(padre,hijo, ruta)
	{
		document.getElementById('padre').value=hijo;
		document.getElementById('hijo').value=padre;
		if(document.getElementById('ruta').value==' / ')
			document.getElementById('ruta').value=document.getElementById('ruta').value + ruta;
		else
			document.getElementById('ruta').value=document.getElementById('ruta').value + ' / ' + ruta;
	document.getElementById('oculto').value=5;
//	alert(hijo);
	 document.form2.submit();	
	}
	function buscaante()
	{
	
	 document.getElementById('hijo').value=document.getElementById('padre').value;
	 document.getElementById('atras').value=1;
	 document.getElementById('oculto').value=5;
	 var temp = document.getElementById('ruta').value.split(' / ');
	 var ruta='';
	 if(temp.length>2){
		 for(var i=0;i<(temp.length-1);i++){
			 if(i==0)
				ruta=temp[i];
			 else
				ruta+= ' / ' + temp[i];
		 }
	 }
	 else
		 ruta=' / ';
	document.getElementById('ruta').value=ruta;
	 //alert('aqui'+document.getElementById('atras').value);
	document.form2.submit();
	}

	function eliminar(idr, busca)
	{
		if (confirm("Esta Seguro de Eliminar el Registro "+idr))
		{
			document.getElementById('oculto2').value='2';
			document.getElementById('var1').value=idr;
			document.getElementById('var2').value=busca;
			document.form2.submit();
		}
	}
			</script>
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
		if((isset($_GET['ruta']))&&($_POST[ruta]==""))
			$_POST[ruta]=$_GET['ruta'];
		?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("plan");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a href="plan-crearplandesarrollo.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" border="0" /></a> 
  <a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a> 
  <a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> 
  <a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#" onClick="buscaante()" class="mgbt"><img src="imagenes/iratras.png" title="Buscar" border="0" /></a></td>
</tr></table>
<tr><td colspan="3" class="tablaprin"> 
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
if($_POST[oculto]=="")
{
	$sqlv="select *from dominios where nombre_dominio='VIGENCIA_PD' and tipo='S'";
	$resv=mysql_query($sqlv,$linkbd);
	$wv=mysql_fetch_row($resv);
	$vig1=$wv[0];
	$vig2=$wv[1];
	$_POST[padre]='';	
	$_POST[hijo]='';	
	if(isset($_GET['vigini'])){
		$vig1=$_GET['vigini'];
	}
	if(isset($_GET['vigfin'])){
		$vig2=$_GET['vigfin'];
		$_POST[vigplan]=$vig1.' - '.$vig2;
	}
	if(isset($_GET['padret'])){
		$_POST[padre]=$_GET['padret'];
	}
}

?>
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
 <form name="form2" method="post">
	<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    <input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
    <input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
 <table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="1">:: Plan de Desarrollo:  
			<select name="vigplan" onChange="validar()">
				<?php
				$sqlv="select *from dominios where nombre_dominio='VIGENCIA_PD' order by tipo desc, valor_inicial";
				$resv=mysql_query($sqlv,$linkbd);
				while($wv=mysql_fetch_row($resv)){
					if($_POST[vigplan]==$wv[0].' - '.$wv[1]){
						$selected='selected="selected"';
						$vig1=$wv[0];
						$vig2=$wv[1];
					}
					else	
						$selected='';
					echo'<option value="'.$wv[0].' - '.$wv[1].'" '.$selected.'>'.$wv[0].' - '.$wv[1].'</option>';
				}
				?>
			</select>
			<?php
			if($_POST[oculto]!="")
			{
				if($_POST[atras]==1)
				{	
					$crit3=" and presuplandesarrollo.codigo='$_POST[hijo]'";
					$sqlr="select distinct *from presuplandesarrollo where  presuplandesarrollo.vigencia=$vig1 and  presuplandesarrollo.vigenciaf=$vig2 ".$crit3." order by presuplandesarrollo.codigo";
					//echo "".$sqlr;
					$resp=mysql_query($sqlr,$linkbd);	
					$rowp=mysql_fetch_row($resp);
					$_POST[padre]=$rowp[2];	
					// $_POST[hijo]='';
				}
			}
			?>
        <input name="hijo" id="hijo" type="hidden" value="<?php echo $_POST[hijo] ?>">  
        <input id="padre" name="padre" type="hidden" value="<?php echo $_POST[padre] ?>"> <input id="atras" name="atras" type="hidden" value="0"> 
        <input name="oculto" id="oculto" type="hidden" value="<?php echo $_POST[oculto] ?>">
        <input name="oculto2" id="oculto2" type="hidden" value="<?php echo $_POST[oculto2] ?>">
        <input name="var1" id="var1" type="hidden" value="<?php echo $_POST[var1] ?>">
        <input name="var2" id="var2" type="hidden" value="<?php echo $_POST[var2] ?>">
        <input name="ruta" id="ruta" type="hidden" value="<?php echo $_POST[ruta] ?>">
		</td>
        <td class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
      </tr>
      </table>
	<div class="subpantallap" style="height:65%; width:99.6%; overflow-x:hidden;" id="divdet">
	<?php	
//	$crit3="";
	//if($_POST[padre]!="")
		if($_POST[oculto2]=="2"){
			$sqlm="select * from planmetasindicadores where codigo='$_POST[var2]";
			$resm=mysql_query($sqlm, $linkbd);
			if(mysql_num_rows($resm)!=0){
				$sqld="delete from planmetasindicadores where codigo='$_POST[var2]";
				mysql_query($sqld,$linkbd);
			}
			$sqlr="DELETE FROM presuplandesarrollo WHERE codigo='$_POST[var1]' and presuplandesarrollo.vigencia=$vig1 and  presuplandesarrollo.vigenciaf=$vig2";
			mysql_query($sqlr,$linkbd);
		}

		$crit3=" and presuplandesarrollo.padre='$_POST[padre]'";
    $sqlr="select distinct *from presuplandesarrollo where presuplandesarrollo.vigencia=$vig1 and  presuplandesarrollo.vigenciaf=$vig2 ".$crit3." order by length(presuplandesarrollo.codigo),presuplandesarrollo.codigo asc";
	$resp=mysql_query($sqlr,$linkbd);
	$_POST[numtop]=mysql_num_rows($resp);
	$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);

					$cond2="";
					if ($_POST[numres]!="-1"){ 
						$cond2="LIMIT $_POST[numpos], $_POST[numres]"; 
					}
	$sqlr="select distinct *from presuplandesarrollo where  presuplandesarrollo.vigencia=$vig1 and  presuplandesarrollo.vigenciaf=$vig2 ".$crit3." order by length(presuplandesarrollo.codigo),presuplandesarrollo.codigo asc ".$cond2;
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
                            	<td class='titulos' colspan='4'>:: Lista de Eventos</td>
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
							<tr><td colspan='5'>$_POST[ruta]</td></tr>
							<tr><td colspan='5'>Encontrados: $_POST[numtop]</td></tr>
							<tr >
								<td class='titulos2' style='width:5%'>Item</td>
								<td class='titulos2' style='width:5%'>Codigo</td>
								<td class='titulos2'>Nombre</td>
								<td class='titulos2' style='width:5%'>Eliminar</td>
								<td class='titulos2' style='width:5%'>Ver/Edita</td>
							 </tr>";
	
	$co="saludo1a";
	$co2="saludo2";
	$con=1;	
	$filas=1;
	//echo $sqlr;
	while($rowp=mysql_fetch_row($resp))
	{	
	$ante=$rowp[2];
						if($gidcta!=""){
							if($gidcta==$rowp[0]){
								$estilo='background-color:yellow';
							}
							else{
								$estilo="";
							}
						}
						else{
							$estilo="";
						}	
						$padret="'".$_POST[padre]."'";
						$hijot="'".$rowp[0]."'";
						$ruta="'".$rowp[1]."'";
						$ruta2="'".$_POST[ruta]."'";
						$idcta="'".$rowp[0]."'";
						$numfil="'".$filas."'";
						$vigini="'".$vig1."'";
						$vigfin="'".$vig2."'";
						$buscta="'".$rowp[7]."'";

						$sqln="SELECT nombre, orden FROM plannivelespd WHERE orden='$rowp[6]' and inicial='$vig1' AND final='$vig2'";
						$resn=mysql_query($sqln,$linkbd);
						$wres=mysql_fetch_array($resn);
						if (strcmp($wres[0],'METAS')!=0)
							$tbusqueda=" onDblClick=\"buscasgte($padret,$hijot,$ruta)\" ";	
						else	
							$tbusqueda=" onDblClick=\"verUltimaPos($idcta, $numfil, $vigini, $vigfin, $padret, $buscta, $ruta2)\" ";
						
						echo"<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
						onMouseOut=\"this.style.backgroundColor=anterior\" $tbusqueda style='text-transform:uppercase; $estilo'>
							<td style='text-align:center;' $tbusqueda ><a href='#'>$con</a></td>
							<td $tbusqueda ><a href='#'>$rowp[0]</a></td>
							<td $tbusqueda ><a href='#'>$rowp[1]</a></td>";	
							$sqlz="select * from presuplandesarrollo where padre='$rowp[0]' and presuplandesarrollo.vigencia=$vig1 and  presuplandesarrollo.vigenciaf=$vig2";
							$resz=mysql_query($sqlz, $linkbd);
							if(mysql_num_rows($resz)<=0){
								echo"<td>
									<center><img src='imagenes/borrar01.png' style='width:18px; cursor:pointer;' title='Eliminar' onClick=\"eliminar($idcta, $buscta)\"></center>
								</td>";
							}
							else{
								echo"<td>
									<center><img src='imagenes/borrar02.png' style='width:18px' title='Eliminar'></center>
								</td>";	
							}
							echo"<td style='text-align:center;'>
								<a onClick=\"verUltimaPos($idcta, $numfil, $vigini, $vigfin, $padret, $buscta)\" style='cursor:pointer;'>
									<img src='imagenes/b_edit.png' style='width:18px' title='Editar'>
								</a>
							</td>
						</tr>";
		$aux=$co2;
		$co2=$co;
		$co=$aux;
		$con+=1;
		$filas++;	 
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
    
</form>     
</td></tr>
</table>
</body>
</html>