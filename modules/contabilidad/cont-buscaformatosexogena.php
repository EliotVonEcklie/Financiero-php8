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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.documento.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  }
 }

function validar(formulario)
{
document.form2.action="cont-terceros.php";
document.form2.submit();
}

function cleanForm()
{
document.form2.nombre1.value="";
document.form2.nombre2.value="";
document.form2.apellido1.value="";
document.form2.apellido2.value="";
document.form2.documento.value="";
document.form2.codver.value="";
document.form2.telefono.value="";
document.form2.direccion.value="";
document.form2.email.value="";
document.form2.web.value="";
document.form2.celular.value="";
document.form2.razonsocial.value="";
}
function cambioswitch(id,valor)
{
	if(valor==1)
	{
		if (confirm("Desea activar Estado")){document.form2.cambioestado.value="1";}
		else{document.form2.nocambioestado.value="1"}
	}
	else
	{
		if (confirm("Desea Desactivar Estado")){document.form2.cambioestado.value="0";}
		else{document.form2.nocambioestado.value="0"}
	}
	document.getElementById('idestado').value=id;
	document.form2.submit();
}

</script>

        <?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("cont");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="cont-formatosexogena.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
			<a class="mgbt"><img src="imagenes/guardad.png"/></a>
			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="cont-parametrosexogena.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
 <form name="form2" method="post" action="#">
 <?php
				if($_POST[oculto2]=="")
				{
					$_POST[oculto2]="0";
					$_POST[cambioestado]="";
					$_POST[nocambioestado]="";
				}
				//*****************************************************************
				if($_POST[cambioestado]!="")
				{
					$linkbd=conectar_bd();
					if($_POST[cambioestado]=="1")
					{
                        $sqlr="UPDATE contexogenaconce_cab SET estado='S' WHERE 	codigo='".$_POST[idestado]."'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
                        $sqlr="UPDATE contexogenaconce_cab SET estado='N' WHERE 	codigo='".$_POST[idestado]."'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
					else {$_POST[lswitch1][$_POST[idestado]]=0;}
					$_POST[nocambioestado]="";
				}
			?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Formatos Exogena </td>
        <td width="11%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="6%" class="saludo1">Nombre:</td>
        <td width="49%"><input name="nombre" type="text" value="" size="40">
        </td>
        <td width="13%" class="saludo1">Codigo Formato:        </td>
        <td width="21%"><input name="documento" type="text" id="documento" value="" size="2" maxlength="2">
          <input name="oculto" type="hidden" value="1"></td>
       </tr>                       
    </table>  
     <input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2];?>">
    <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
    <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
    <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"> 
    <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[nombre]!=""){$crit1=" WHERE (contexogenaforma_cab.nombre like '%".$_POST[nombre]."%') ";}
if ($_POST[documento]!="")
{
	if ($_POST[nombre]!=""){$crit2=" and contexogenaforma_cab.codigo like '%$_POST[documento]%' ";}
	else {$crit2=" WHERE contexogenaforma_cab.codigo like '%$_POST[documento]%' ";}
}

$sqlr="select * from contexogenaforma_cab ".$crit1.$crit2." order by contexogenaforma_cab.codigo";

$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='80%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='7'>Conceptos Encontrados: $ntr</td></tr><tr><td width='5%' class='titulos2'>Codigo</td><td class='titulos2'>Nombre</td><td class='titulos2'>Valor Limite</td><td class='titulos2' colspan='2' style='width:6%;'>ESTADO</td><td class='titulos2' width='5%'>EDITAR</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1a';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
 $tipo="";
 if($row[3]=='S')
	  	{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#090";$_POST[lswitch1][$row[0]]=0;}
		else
		{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST[lswitch1][$row[0]]=1;}

	 echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
	 <td>$row[0]</td>
	 <td style='text-transform:uppercase'>$row[1]</td>
	 <td style='text-transform:uppercase'>$row[2]</td>
	 <td style='text-align:center;'><img $imgsem style='width:20px'/></td>
	 <td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$row[0]."\",\"".$_POST[lswitch1][$row[0]]."\")' /></td>
	 <td style='text-align:center;'><a href='cont-editaformatosexogena.php?cod=$row[0]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a></td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
}
?></div>
</form>
</body>
</html>