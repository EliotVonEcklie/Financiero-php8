<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Administracion</title>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function checktodos()
{
 cali=document.getElementsByName('bloqueados[]');
 for (var i=0;i < cali.length;i++) 
 { 
	if (document.getElementById("todos").checked == true) 
	{
	 cali.item(i).checked = true;
 	 document.getElementById("todos").value=1;	 
	}
	else
	{
	cali.item(i).checked = false;
    document.getElementById("todos").value=0;
	}
 }	
}
</script>
<script>
//************* ver reporte ************
//***************************************
function guardar()
{
  	if (confirm("Esta Seguro de Guardar"))
  	{
	  document.form2.oculto.value=2;
	  document.form2.submit();
	}
}
</script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<script src="css/calendario.js"></script>
<script src="css/programas.js"></script>
<?php titlepag();?>
</head>
<body>
<table>
<tr><td>
<img src="imagenes/logoadmin.png"></td><td><img src="imagenes/entidad.png"></td><td>
		<table class="inicio">
		<tr><td  class="saludo1" >Usuario: </td><td><?php echo $_SESSION[usuario]?></td>
		<td class="saludo1">Perfil: </td><td><?php echo $_SESSION["perfil"];?></td></tr>
		 <tr><td  class="saludo1" >Fecha ingreso:</td><td> <?php echo " ".$fec=date("Y-m-d");?> </td> <td  class="saludo1">Hora Ingreso: </td><td><?php $hora=time();echo " ".date ( "h:i:s" , $hora ); $hora=date ( "h:i:s" , $hora )?></td></tr>
		 </table></td></tr>
	<tr><td colspan="3">
        <!-- Navigation -->  
		<ul class="mi-menu">  
        <li><a href="principal.php">Inicio</a></li>  
        <li><a href="#">Sistema</a><ul><script>document.write('<?php echo $_SESSION[linksetad][0];?>')</script></ul></li>
		<li><a href="#">Parametros</a><ul><script>document.write('<?php echo $_SESSION[linksetad][1];?>')</script></ul></li>		
		<li><a href="#" >Herramientas</a><ul><script>document.write('<?php echo $_SESSION[linksetad][2];?>')</script></ul></li>
        <li><a href="#" >Informes</a><ul><script>document.write('<?php echo $_SESSION[linksetad][3];?>')</script></ul></li>         
        <li><a href="ayuda.html" target="_blank">Ayuda</a></li>
        <li style="text-align:right; float:right"><a href="#"><?php  $vigusu=vigencia_usuarios($_SESSION[cedulausu]); echo " ".$vigusu ?></a></li>           
  			</ul>  
        </td>
        </tr>
<tr>
  <td colspan="3" class="tablaprin"><a href="adm-bloqueos.php" ><img src="imagenes/add.png"  alt="Nuevo" /></a> <a href="#" onClick="guardar();"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="#" onClick="document.form2.submit();"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a></td></tr></table>
  <tr ><td colspan="3" class="tablaprin">
  <form name="form1" method="post" action="">
  <table width="50%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
    <tr bgcolor="#F7E39C">
      <td height="25" colspan="2"><span class="Estilo8 Estilo38 Estilo60"><span class="Estilo8 Estilo38 Estilo66  Estilo73">:: Buscar Usuarios </span></span></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td bgcolor="#CCCCCC"><span class="Estilo39">:&middot; Nombre:      </span></td>
      <td bgcolor="#CCCCCC"><input name="nombre" type="text" id="nombre" size="45"></td>
    </tr>
    <tr bgcolor="#dddddd">
      <th height="20" colspan="2"><div align="center" class="Estilo5 Estilo6 Estilo67">
         <input name="oculto" type="hidden" id="oculto" value="1"> 
         <span class="Estilo72">(Click en el Icono de Buscar)</span></div></th>
    </tr>
  </table>
  <div align="center"></div>
</form>
<table width="50%" height="46" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">        
  <tr bordercolor="#FFFFFF" bgcolor="#F7E39C">
          <td height="25" colspan="5"><span class="Estilo70 Estilo41 Estilo49 Estilo40 Estilo66 Estilo73"><strong>:: Resultados
            
          </strong></span></td>
        </tr>
        <tr bordercolor="#FFFFFF" bgcolor="#000066">
          <td width="465" height="25"><span class="Estilo70 Estilo43 Estilo17 Estilo73"><strong>Nombre</strong></span></td>
          <td width="93"><div align="center"><span class="Estilo70 Estilo43 Estilo17 Estilo73"><strong>Estado</strong></span></div></td>
          <td width="134"><div align="center" class="Estilo73"><span class="Estilo17 Estilo43 Estilo70"><strong>Ver/Editar</strong></span></div></td>
        </tr>
<?php
$oculto=$_POST['oculto'];
if($oculto!="")
{
 $linkbd=conectar();
//sacar el consecutivo 
$sqlr="Select * from usuarios where nom_usu like'%$_POST[nombre]%' and id_usu>0 order by nom_usu";
$resp = oci_parse ($linkbd, $sqlr);
oci_execute ($resp);
echo "<form name='form2' action='usuarios.php' method='post'>";
$co='#cccccc';
  $co2='#dddddd';
		while ( ($r = oci_fetch_array($resp,OCI_BOTH)))
	    {
    	 echo "<tr bgcolor='$co'><td><font color='#000066' size='2' face='Verdana, Arial, Helvetica, sans-serif'>".$r[1]."</font></td>";
		 if ($r[6]==1)
			{ $es ='Activa'; }
			else
			{ $es ='Inactiva'; }
		 echo "<td><center><font color='#000066' size='2' face='Verdana, Arial, Helvetica, sans-serif'>".$es."</font></center></td>";
    	 echo "<td><center><a href='verusuario.php?r=$r[0]' alt='Editar'><img src='imagenes\edit.png' widht='30' height='20'></a> </center></td></tr>";
         $aux=$co;
         $co=$co2;
         $co2=$aux;
   		}
  echo "</form>";
oci_free_statement($resp);
oci_close($linkbd);	
$_POST[oculto]="";
}
?>
     </table>
  </td>
  </tr>
</table>
</body>
</html>
