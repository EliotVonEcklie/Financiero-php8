<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SieS - Tesoreria</title>

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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
</script>
<script>
function pdf()
{
document.form2.action="teso-pdftraslados.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr  class="cinta">
  <td colspan="3"  class="cinta"><a href="teso-traslados.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a ><img src="imagenes/guardad.png"  alt="Guardar" /></a><a href="teso-buscatraslados.php"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a></td>
</tr>		  
</td></tr>
  </table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
 ?>	
<?php
	  //*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto])
{
 	$linkbd=conectar_bd();
	$sqlr="select *from tesotraslados_cab, tesotraslados,terceros,tesobancosctas   where tesotraslados_cab.estado='S' and	tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban= tesotraslados.ncuentaban1 and tesobancosctas.estado='S'
 and tesotraslados_cab.id_comp=$_GET[idr]";
	$res=mysql_query($sqlr,$linkbd);
	$cont=0;
	$_POST[idcomp]=$_GET[dc];
	$_POST[ncomp]=$_GET[dc];
	$total=0;
	while ($row =mysql_fetch_row($res)) 
	{	$p1=substr($row[2],0,4);
		$p2=substr($row[2],5,2);
		$p3=substr($row[2],8,2);
		$_POST[fecha]=$p3."-".$p2."-".$p1;	
		$_POST[dccs][$cont]=$row[10];
		$_POST[dccs2][$cont]=$row[13];
		$_POST[dconsig][$cont]=$row[9];			 
		$_POST[dbancos][$cont]=$row[11];		 
		$_POST[dbancos2][$cont]=$row[14];		 
		$_POST[dcbs2][$cont]=$row[14];
		$_POST[dnbancos][$cont]=$row[23];		 
		$_POST[dcbs][$cont]=$row[11];
		$_POST[concepto]=$row[5];
		$total=$total+$row[16]; 
		$_POST[totalc]=$total;
	 	$_POST[dvalores][$cont]=$row[16];
		$cont=$cont+1;
	}	 
}
?>

 <form name="form2" method="post" action=""> 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="7">.: Ver Traslados</td><td width="126" class="cerrar" ><a href="teso-principal.php">X Cerrar</a></td>
      </tr>
      <tr  >
	  <td  class="saludo1">Fecha:        </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">        </td>        
        <td class="saludo1" >Numero Comprobante:</td>
        <td ><input name="idcomp" type="text" size="20" value="<?php echo $_POST[idcomp]?>"></td>
 		  <td  class="saludo1">Concepto Traslado:</td>
	        <td><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" size="50" onKeyUp="return tabular(event,this)">        </td>

       </tr> 
	  </table>
	  <div class="subpantallac">
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Traslados</td></tr>                  
		<tr><td class="titulos2">Banco</td><td class="titulos2">N° Transaccion</td><td class="titulos2">CC-O</td><td class="titulos2">Cuenta Bancaria Origen</td><td class="titulos2">CC-D</td><td class="titulos2">Cuenta Bancaria Destino</td><td class="titulos2">Valor<input type='hidden' name='elimina' id='elimina'></td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		 unset($_POST[dccs][$posi]);
		 unset($_POST[dccs2][$posi]);
		 unset($_POST[dconsig][$posi]);
		  unset($_POST[dbancos][$posi]);
		 unset($_POST[dnbancos][$posi]);		 
		  unset($_POST[dbancos2][$posi]);
		 unset($_POST[dnbancos2][$posi]);		 
 		 unset($_POST[dcbs][$posi]);	
 		 unset($_POST[dcbs2][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  
		 $_POST[dccs]= array_values($_POST[dccs]); 
		 $_POST[dccs2]= array_values($_POST[dccs2]); 		 
		 $_POST[dconsig]= array_values($_POST[dconsig]);  
		 $_POST[dbancos]= array_values($_POST[dbancos]); 
  		  $_POST[dnbancos]= array_values($_POST[dnbancos]); 
		 $_POST[dbancos2]= array_values($_POST[dbancos2]); 
  		  $_POST[dnbancos2]= array_values($_POST[dnbancos2]); 
		 $_POST[dcbs]= array_values($_POST[dcbs]); 		 
		 $_POST[dcbs2]= array_values($_POST[dcbs2]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dccs][]=$_POST[cc];
		 $_POST[dccs2][]=$_POST[cc2];		 
		 $_POST[dconsig][]=$_POST[numero];			 
		 $_POST[dbancos][]=$_POST[banco];		 
		 $_POST[dnbancos][]=$_POST[nbanco];		 
		 $_POST[dbancos2][]=$_POST[banco2];		 
		 $_POST[dnbancos2][]=$_POST[nbanco2];		 
		 $_POST[dcbs][]=$_POST[cb];
		 $_POST[dcbs2][]=$_POST[cb2];		 
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]='0';
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.banco.value="";
				document.form2.nbanco.value="";
				document.form2.banco2.value="";
				document.form2.nbanco2.value="";
				document.form2.cb.value="";
				document.form2.cb2.value="";
				document.form2.valor.value="";	
				document.form2.numero.value="";	
				document.form2.agregadet.value="0";				
				document.form2.numero.select();
		  		document.form2.numero.focus();	
		 </script>
		  <?php
		  }
		  		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dbancos]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dnbancos[]' value='".$_POST[dnbancos][$x]."' type='text' size='40'></td><td class='saludo2'><input name='dconsig[]' value='".$_POST[dconsig][$x]."' type='text' ></td><td class='saludo2'><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2' readonly></td><td class='saludo2'><input name='dbancos[]' value='".$_POST[dbancos][$x]."' type='hidden' ><input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dccs2[]' value='".$_POST[dccs2][$x]."' type='text' size='2' readonly></td><td class='saludo2'><input name='dbancos2[]' value='".$_POST[dbancos2][$x]."' type='hidden' ><input name='dcbs2[]' value='".$_POST[dcbs2][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' readonly></td></tr>";
		 		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." PESOS";
	    echo "<tr><td colspan='5'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td colspan='5'>Son: <input name='letras' type='text' value='$_POST[letras]' size='100'></td></tr>";
		?>
	   </table></div>
	  <?php
?>	
</form>
 </td></tr>  
</table>
</body>
</html>