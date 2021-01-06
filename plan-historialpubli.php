<?php //V 1000 12/12/16 ?> 
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

function despliegamodal(_valor)
			{document.getElementById("bgventanamodal").style.visibility=_valor;}
 </script> 
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="css/programas.js"></script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("plan");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="plan-historialpubli.php" ><img src="imagenes/add.png"  alt="Nuevo" border="0" /></a> <a href="#"  onClick=""><img src="imagenes/guardad.png"  alt="Guardar" /></a> <a href="#" onClick="document.form1.submit()"><img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>  </td>
</tr></table>
<tr><td colspan="3" class="tablaprin"> 
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
?>
<form name="form1" method="post" action="">
		<table class="inicio">
                    <tr >
                      <td height="25" colspan="6" class="titulos" >:.Reporte Publicaciones</td>
                      <td width="5%" class="cerrar" ><a href="plan-principal.php" onClick="">Cerrar</a></td>
                    </tr>
                    <tr >
                      <td width="13%" class="saludo1" >:&middot; Titulo Publicacion:</td>
                      <td  colspan="1"><input name="numero" type="text" size="30%" value="<?php echo $_POST[numero]?>" >
                      </td>
                      <td class="saludo1">Periodo Inicial Publicacion:</td><td>
                      	<input type='date' name="fecha" value="<?php echo $_POST[fecha] ?>">
                        </td>
                        <td class="saludo1">Periodo Final Publicacion:</td><td>
                      	<input type='date' name="fecha2" value="<?php echo $_POST[fecha2] ?>">
                        <input type="button" value="Buscar" onClick="document.form1.submit()">
                      	<input name="oculto" type="hidden" id="oculto" value="1" >
                      	<input name="ocudel" type="hidden" id="ocudel" value="<?php echo $_POST[oculdel]?>">
                 		<input name="iddel" type="hidden" id="iddel" value="1">
                      </td>
                    </tr>
                </table>
            <table class="inicio">
            <tr>
            <td class="titulos">Item</td>
            <td class="titulos">Titulo</td>
            <td class="titulos">Fecha Inicial</td>
            <td class="titulos">Fecha Final</td>
            <td class="titulos">Estado</td>                                    
            <td class="titulos">Ver</td>            
            </tr>
            
<?php
 $oculto=$_POST['oculto'];
 if($oculto=="1")
 {
	if($_POST[numero]!="") 
   $cond=" and titulos like'%$_POST[numero]%'";
   if($_POST[fecha]!="") 
   $cond2=" and fecha_inicio  between '$_POST[fecha]' and '$_POST[fecha2]' ";
   
	$sqlr="SELECT * FROM infor_interes where estado='S' ".$cond.$cond2." order by fecha_inicio";					
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
    $iter='saludo1';
    $iter2='saludo2';
    while ($rowEmp = mysql_fetch_row($res)) 
     {
	   echo '<tr class="'.$iter.'"><td>'.$rowEmp[0].'</td><td>'.$rowEmp[2].'</td><td>'.$rowEmp[7].'</td><td>'.$rowEmp[8].'</td><td>'.$rowEmp[10].'</td><td><center><a href="#" onClick="document.nuevomen.idoculto.value='.$rowEmp[0].'; cargarpagina(); despliegamodal(\'visible\');"><img src="imagenes/buscarep.png"></a></center></td></tr>';	
	   $aux=$iter2;
	   $iter2=$iter;
	   $iter=$aux;
	 }
 }
?>          
</table>          
 </form> 
 <div id="bgventanamodal">
        	<div id="ventanamodal">  
            	<a href="javascript:despliegamodal('hidden');" style="position: absolute; left: 810px; top: 8px; z-index: 100;"><img src="imagenes/exit.png" alt="cerrar" width=27 height=27>Cerrar</a>
 <form id="nuevomen" name="nuevomen" method="post">
 		<input id="idoculto" name="idoculto" type="hidden" value="<?php echo $_POST[idoculto]?>">
        <div id="formdesplegable"> 
              <script> 
			  function cargarpagina(){
			  document.getElementById('formdesplegable').innerHTML=('<IFRAME src="plan-mostrainformacion.php?idinfo='+document.nuevomen.idoculto.value+'" name="otras" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>');
			  }</script> 
    </div>
    </form>
    		
            </div>
        </div>              
</td></tr>      
</table>
</body>
</html>