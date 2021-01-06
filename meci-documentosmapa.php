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
if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.nombre.focus();
  	document.form2.nombre.select();
  }
 }

function clasifica(formulario)
{
//document.form2.action="presu-recursos.php";
document.form2.submit();
}

function desaparecer(capa)
{
 if (document.getElementById(capa).style.visibility=='hidden')
 {
document.getElementById(capa).style.visibility='visible';
 }
 else
 {
document.getElementById(capa).style.visibility='hidden';
}
 
}
</script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("meci");?></tr>
        <tr>
  <td colspan="3" class="cinta"><a href="meci-documentos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><img src="imagenes/busca.png"  title="Buscar" border="0" /><a href="#" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
</tr></table>
 <tr> 
 <td colspan="3"> 
 <?php
 $procesos[]=array();
  $tprocesos[]=array();
    $linkbd=conectar_bd();  
	$sqlr="Select * from dominios where dominios.nombre_dominio='PROCESOS_CALIDAD' order by valor_final ";
		$resp = mysql_query($sqlr,$linkbd);
	    while ($row =mysql_fetch_row($resp))
		{
		 $tprocesos[$row[1]][0]=$row[0];
 		 $tprocesos[$row[1]][1]=$row[1];
  		 $tprocesos[$row[1]][2]=$row[2];
   		 $tprocesos[$row[1]][4]=$row[4];
		}
		
		$sqlr="Select calprocesos.id, calprocesos.nombre, DOMINIOS.TIPO,calprocesos.clasificacion, calprocesos.prefijo from calprocesos, dominios where dominios.nombre_dominio='PROCESOS_CALIDAD' AND calprocesos.clasificacion=DOMINIOS.VALOR_FINAL AND calprocesos.estado='S' ";
		$resp = mysql_query($sqlr,$linkbd);
	    while ($row =mysql_fetch_row($resp))
		{
		 $procesos[$row[0]][0]=$row[0];
		 $procesos[$row[0]][2]=$row[2];
 		 $procesos[$row[0]][1]=$row[1];
  		 $procesos[$row[0]][3]=$row[3];
		 $procesos[$row[0]][4]=$row[4];
		}
		$_POST[codigo]=$mx+1;	
 ?>
   <table class="inicio" >
   <tr><td class="titulos" >Mapa Procesos</td><td class="cerrar" ><a href="meci-principal.php">Cerrar</a></td></tr>
   <tr><td colspan="2">
   
   
 <div class="macroproceso" style="float:left; background-color:#ffe; width:12%">
	<div  style="background-color:#3CF; height:99%"><?php echo "ENTRADAS"?>
    </div>
   <?php
   $cv=count($procesos);
   $ct=count($tprocesos);
//   echo "sss".$ct;
   for($t=1;$t<$ct;$t++)
   {
	//   echo "t:".$tprocesos[$t][4];
   if($tprocesos[$t][4]=='E' )
	   {
	?>
    <div class="procesos"><?php echo "".$tprocesos[$t][2] ?>
    </div>
    <div class=" procesoscontent" id="E<?php echo $tprocesos[$t][0]?>">
    <?php	   
//   echo "sss".$cv;
    for($x=1;$x<=$cv;$x++ )
    {
	   	   //echo "t:".$tprocesos[$t][1];
	   if($procesos[$x][2]=='E' && $procesos[$x][3]==$tprocesos[$t][1])
	   {
	 ?>
     <div class="subprocesos" >
     <?php
	 echo "<img class='valign' />".$procesos[$x][1]." (".$procesos[$x][4].")";
	 ?>
     </div> 
     <?php 
	   }
   	}
	?>
	</div>
    <?php
   	}
   }
   ?>   
 </div>  
</div> 
<div class="macroproceso" style="float:left; background-color:#ffe; width:75%">
	<div style="border-color:#666;
	background-color:#9C0;
	 height:99%;"><?php echo "PROCESOS"?>
    </div>
   <?php
   $cv=count($procesos);
   $ct=count($tprocesos);
//   echo "sss".$ct;
   for($t=1;$t<$ct;$t++)
   {
	//   echo "t:".$tprocesos[$t][4];
   if($tprocesos[$t][4]=='P' )
	   {
	?>
    <div class="procesos"><?php echo "".$tprocesos[$t][2] ?>
    <img src="imagenes/flecha_derecha.gif" onClick="desaparecer('P<?php echo $tprocesos[$t][0]?>')">
    </div>
    <div class="procesoscontent" id="P<?php echo $tprocesos[$t][0]?>">
    <?php	   
//   echo "sss".$cv;
    for($x=1;$x<=$cv;$x++ )
    {
	   	   //echo "t:".$tprocesos[$t][1];
	   if($procesos[$x][2]=='P' && $procesos[$x][3]==$tprocesos[$t][1])
	   {
	 ?>
     <center><div class="subprocesos" >
     <?php
	 echo "<img class='valign' />".$procesos[$x][1]." (".$procesos[$x][4].")";
	 ?>
     </div> </center>
     <?php 
	   }
   	}
	?>
	</div>
    <?php
   	}
   }
   ?>   
 </div>  
</div> 
<div class="macroproceso" style="float:left; background-color:#FFE; width:12%; height:100%" >
	<div  style="background-color:#F90; height:99%"><?php echo "SALIDAS"?>
    </div>
   <?php
   $cv=count($procesos);
   $ct=count($tprocesos);
//   echo "sss".$ct;
   for($t=1;$t<$ct;$t++)
   {
	//   echo "t:".$tprocesos[$t][4];
   if($tprocesos[$t][4]=='S' )
	   {
	?>
    <div class="procesos"><?php echo "".$tprocesos[$t][2] ?>
    <img src="imagenes/flecha_derecha.gif" onClick="desaparecer('S<?php echo $tprocesos[$t][0]?>')"></div>
    <div class=" procesoscontent" id='S<?php echo $tprocesos[$t][0]?>'>
    <?php	   
//   echo "sss".$cv;
    for($x=1;$x<=$cv;$x++ )
    {
	   	   //echo "t:".$tprocesos[$t][1];
	   if($procesos[$x][2]=='S' && $procesos[$x][3]==$tprocesos[$t][1])
	   {
	 ?>
     <center><div class="subprocesos"  >
     <?php
	 echo "<img class='valign' />".$procesos[$x][1]." (".$procesos[$x][4].")";
	 ?>
     </div> </center>
     <?php 
	   }
   	}
	?>
	</div>
    <?php
   	}
   }
   ?>   
 </div>  
</div> 
   </td>
   </tr>
   </table>  
 </td>       
 </tr>       
	</table>
</body>
</html>