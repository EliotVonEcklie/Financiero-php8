<?php //V 1000 12/12/16 ?> 
<?php
  require"comun.inc";
  require"funciones.inc";
  session_start();
  $linkbd=conectar_bd(); 
  cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  header("Cache-control: private"); // Arregla IE 6
  date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
	<title>:: Spid - Calidad</title>
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
  else
  {
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
</script>
  
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("contra");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="contra-anexos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
			<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
			<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
		</td>
	</tr>
</table>
<form name="form2" method="post" action="contra-buscaanexos.php">
	<table  class="inicio" align="center" >
	  <tr>
		<td class="titulos" colspan="4">:: Buscar Anexos </td>
		<td width="11%" class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
	  </tr>
	  <tr >
		<td width="6%" class="saludo1">Nombre:</td>
		<td width="49%"><input name="nombre" type="text" value="" size="40"></td>
		<td width="13%" class="saludo1">Codigo:        </td>
		<td width="21%"><input name="documento" type="text" id="documento" value="" size="2" maxlength="2">
		  <input name="oculto" type="hidden" value="1"></td>
	  </tr>                       
	</table>
    <div class="subpantallac5">
      <?php
        $oculto=$_POST['oculto'];
        if($_POST[oculto])
        {
          $linkbd=conectar_bd();
          $crit1=" ";
          $crit2=" ";
          if ($_POST[nombre]!="")
              $crit1=" and (contraanexos.nombre like '%".$_POST[nombre]."%') ";
          if ($_POST[documento]!="")
              $crit2=" and contraanexos.id like '%$_POST[documento]%' ";
          //sacar el consecutivo 
          $sqlr="select *from contraanexos where contraanexos.estado<>'' ".$crit1.$crit2." order by contraanexos.id";
          // echo "<div><div>sqlr:".$sqlr."</div></div>";
          $resp = mysql_query($sqlr,$linkbd);
          $ntr = mysql_num_rows($resp);
          $con=1;
          echo "<table class='inicio' align='center' width='80%'><tr><td colspan='7' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='7'>Encontrados: $ntr</td></tr><tr><td width='5%' class='titulos2'>Codigo</td><td class='titulos2'>Nombre</td><td class='titulos2'>Tipo</td><td class='titulos2' width='5%'>ESTADO</td><td class='titulos2' width='5%'>EDITAR</td></tr>";	
          //echo "nr:".$nr;
          $iter='saludo1';
          $iter2='saludo2';
          while ($row =mysql_fetch_row($resp)) 
          {
	           $sqlr="SELECT * FROM dominios where nombre_dominio='CONTRATACION_ANEXOS' and valor_inicial='$row[4]'";
	           $res=mysql_query($sqlr,$linkbd);
	           $rowEmp = mysql_fetch_row($res);
	           $tipo=$rowEmp[1];
	           echo "<tr ><td class='$iter'>".strtoupper($row[0])."</td><td class='$iter'>".utf8_decode(strtoupper($row[1]))."</td><td class='$iter'>$tipo </td><td class='$iter'>$row[2] </td><td class='$iter'><a href='contra-editaanexos.php?idproceso=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
	           $con+=1;
	           $aux=$iter;
	           $iter=$iter2;
	           $iter2=$aux;
          }
          echo"</table>";
        }
      ?>
    </div>  
    </form>
  </td></tr>     
</table>
</body>
</html>