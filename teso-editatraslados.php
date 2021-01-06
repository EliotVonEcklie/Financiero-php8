<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

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
function atrasc(prev){
				
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('idcomp').value;
				
				if(parseFloat(minimo)<parseFloat(actual)){
				
					document.getElementById('oculto').value='1';
					document.getElementById('idcomp').value=prev;
					var idr=document.getElementById('idcomp').value;
					location.href="teso-editatraslados.php?idr="+idr+"&dc="+idr;
					//document.form2.submit();
				}
			}
function adelante(next){
	
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('idcomp').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('idcomp').value=next;
					var idr=document.getElementById('idcomp').value;
					location.href="teso-editatraslados.php?idr="+idr+"&dc="+idr;
					//document.form2.submit();
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
function iratras(){
				var idr=document.getElementById('idcomp').value;
				location.href="teso-buscatraslados.php?idr="+idr;
			}
			
</script>

<script src="css/programas.js"></script>
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<script src="css/calendario.js"></script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta">
  <a href="teso-traslados.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo" /></a> 
  <a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
  <a href="teso-buscatraslados.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0"  title="Buscar"/></a> 
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a> 
  <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
  <a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
  </td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$sqlr="select MIN(id_consignacion), MAX(id_consignacion) from tesotraslados_cab";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];			
			$_POST[maximo]=$r[1];
			
 ?>	
<?php
$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='CUENTA_TRASLADO'";
	 $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
			{
			 $_POST[cuentatraslado]=$row[0];
			 }
	  //*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto])
{
		 $_POST[dccs]= array(); 
		 $_POST[dccs2]= array(); 
		 $_POST[dconsig]= array(); 
		 $_POST[dbancos]= array(); 
  		  $_POST[dnbancos]= array(); 
		 $_POST[dbancos2]= array(); 
  		  $_POST[dnbancos2]= array(); 
		 $_POST[dcbs]= array(); 
		 $_POST[dcbs2]= array(); 
		 $_POST[dcts]= array(); 
		 $_POST[dcts2]= array(); 
		 $_POST[dvalores]= array(); 
	

//$sqlr="select *from tesotraslados_cab, tesotraslados,terceros,tesobancosctas   where tesotraslados_cab.estado='S' and	tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban= tesotraslados.ncuentaban1 and tesotraslados_cab.id_consignacion= tesotraslados.id_trasladocab and tesobancosctas.estado='S' and tesotraslados_cab.id_comp=$_GET[idr]";
$sqlr="select *from tesotraslados_cab where tesotraslados_cab.estado<>'' and tesotraslados_cab.id_consignacion=$_GET[dc]";
$res=mysql_query($sqlr,$linkbd);
	$cont=0;
	$_POST[idcomp]=$_GET[dc];
	$_POST[ncomp]=$_GET[dc];
	$_POST[comp]=$_GET[idr];
	
	while ($row =mysql_fetch_row($res)) 
	{	$p1=substr($row[2],0,4);
		$p2=substr($row[2],5,2);
		$p3=substr($row[2],8,2);
		$_POST[fecha]=$p3."/".$p2."/".$p1;
		$_POST[concepto]=$row[5];
		$_POST[estado]=$row[4];
		if($_POST[estado]=='S')
		$_POST[estadoc]='ACTIVO';
		else
		$_POST[estadoc]='ANULADO';
				
	}
	
	
	
	

$sqlr="select *from tesotraslados_cab, tesotraslados,terceros,tesobancosctas   where tesotraslados_cab.estado<>'' and	tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban= tesotraslados.ncuentaban1 and tesotraslados_cab.id_consignacion= tesotraslados.id_trasladocab and tesobancosctas.estado='S'
 and tesotraslados_cab.id_consignacion=$_GET[dc] AND tesotraslados.tercero1=tesobancosctas.tercero";
//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	$cont=0;
	$_POST[idcomp]=$_GET[dc];
	$_POST[ncomp]=$_GET[dc];
	$_POST[comp]=$_GET[idr];
	$total=0;
	while ($row =mysql_fetch_row($res)) 
	{	$p1=substr($row[2],0,4);
		$p2=substr($row[2],5,2);
		$p3=substr($row[2],8,2);
		$_POST[fecha]=$p3."/".$p2."/".$p1;	
		$_POST[dccs][]=$row[10];
		$_POST[dccs2][]=$row[13];
		$_POST[dconsig][]=$row[9];			 
		//*** cuenta contable
		$sqlr="select distinct * from tesobancosctas where ncuentaban='$row[11]' ";
		//echo $sqlr;
		$res2=mysql_query($sqlr,$linkbd);
		$row2 =mysql_fetch_row($res2);		
		$_POST[dbancos][]=$row2[0];		 
		//		echo $sqlr; 
		$_POST[dcbs2][]=$row[14];
		$_POST[dnbancos][$cont]=$row[23];		 
		$_POST[dcbs][]=$row[11];
		$_POST[concepto]=$row[5];
		$total=$total+$row[16]; 
		$_POST[totalc]=$total;
	 	$_POST[dvalores][]=$row[16];
		$_POST[dcts][$cont]=$row[30];
		//** cuenta contable
		$sqlr="select distinct * from tesobancosctas where ncuentaban='$row[14]' ";
		//echo $sqlr;
		$res2=mysql_query($sqlr,$linkbd);
		$row2 =mysql_fetch_row($res2);		
		$_POST[dbancos2][]=$row2[0];
						
		$_POST[dcts2][]=$row[30];
			
		$cont=$cont+1;
	}	 
	//	echo $sqlr;
/*
$sqlr1="select *from tesotraslados_cab, tesotraslados,terceros,tesobancosctas   where tesotraslados_cab.estado='S' and	tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban= tesotraslados.ncuentaban2 and tesotraslados_cab.id_consignacion= tesotraslados.id_trasladocab and tesobancosctas.estado='S'
 and tesotraslados_cab.id_comp=$_GET[idr]";
$res1=mysql_query($sqlr1,$linkbd);
	$cont=0;
	while ($row1 =mysql_fetch_row($res1)) 
	{
$_POST[dbancos2][]=$row1[40];	
$_POST[dnbancos2][]=$row1[23];	
$_POST[dcts2][]=$row1[30];
$cont=$cont+1;
	}
*/
}
			$sqln="select *from tesotraslados_cab WHERE id_consignacion > '$_POST[idcomp]' ORDER BY id_consignacion ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from tesotraslados_cab WHERE id_consignacion < '$_POST[idcomp]' ORDER BY id_consignacion DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";

?>
 <form name="form2" method="post" action=""> 
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="7">.: Editar Traslados</td>
        <td style="width:7%;" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	        <td class="saludo1" style="width:9%;">N&uacute;mero Traslado:</td>
        <td style="width:10%;">
		
			<a href="#" onClick="atrasc(<?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
			
			<input name="idcomp" id="idcomp" type="text"  value="<?php echo $_POST[idcomp]?>" style="width:55%;" readonly>
			
		<a href="#" onClick="adelante(<?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
			<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
            <input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
			
			
		</td>
<td  class="saludo1" style="width:10%;">Fecha: </td>
        <td style="width:40%;">
		<input name="fecha" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
		        	<a href="#" onClick="displayCalendarFor('fc_1198971546');">
		        		<img src="imagenes/calendario04.png"  style="width:20px" align="absmiddle" border="0">
		        	</a>   
		<input name="cuentatraslado" type="hidden" value="<?php echo $_POST[cuentatraslado]?>">
			
		<?php
		if($_POST[estadoc]=='ACTIVO'){ 
			$valuees="ACTIVO";
            $stylest="width:20%; background-color:#0CD02A; color:white; text-align:center;";
		}
		if($_POST[estadoc]=='PAGO'){
			$valuees="PAGO";
            $stylest="width:25%; background-color:#0404B4; color:white; text-align:center;"; 	 				  
		}
		if($_POST[estadoc]=='ANULADO'){
			$valuees="ANULADO";
            $stylest="width:25%; background-color:#FF0000; color:white; text-align:center;"; 
		}?>
		<?php	echo  "<input type='text' name='estadoc' id='estado' value='$valuees' style='$stylest' readonly />"?>
		<input name="estado" type="hidden" value="<?php echo $_POST[estado]?>"></td>
</tr>
<tr>
        <td  class="saludo1">N&uacute;mero Transacci&oacute;n:
        </td>
        <td><input name="numero" type="text" value="<?php echo $_POST[numero]?>" onKeyUp="return tabular(event,this)">        </td>
		<td  class="saludo1">Concepto Traslado:</td>
		          <td><input name="concepto" type="text" style="width:99.5%;" value="<?php echo $_POST[concepto]?>"  onKeyUp="return tabular(event,this)">        </td>

       </tr> 
	   <tr>
	<td class="saludo1">Tipo Traslado</td>
	<td>
	<select name="tipotras" id="tipotras" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="1" <?php if($_POST[tipotras]=='1') echo "SELECTED"; ?>>Interno</option>
         <option value="2" <?php if($_POST[tipotras]=='2') echo "SELECTED"; ?>>Externo</option>
  	</select>
	</td>
	<?php
	 if($_POST[tipotras]==2)
	   {
	?>
	<td class="saludo1">Tipo Traslado</td>
	<td>
	<select name="tipotrasext" id="tipotrasext" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="1" <?php if($_POST[tipotrasext]=='1') echo "SELECTED"; ?>>Entrada</option>
         <option value="2" <?php if($_POST[tipotrasext]=='2') echo "SELECTED"; ?>>Salida</option>
  	</select>
	</td>
	<?php
		}
	?>
	</tr>
	  <tr>
	  <td class="saludo1">Centro Costo :</td>
	  <td>
	<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[cc])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
	?>
   </select>
	 </td>
	  <td class="saludo1">Cuenta Bancaria :</td>
	  <td >
	    <select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[banco])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco]=$row[4];
						  $_POST[ter]=$row[5];
						 $_POST[cb]=$row[2];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select> <input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:67.5%;" readonly><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ><input type="hidden" id="comp" name="comp" value="<?php echo $_POST[comp]?>" ></td>
	  </tr> 
	   <?php
	   if($_POST[tipotras]==1)
	   {
	   ?>
	  <tr>
	  <td class="saludo1">Centro Costo Destino:</td>
	  <td>
	<select name="cc2"  onChange="validar()" onKeyUp="return tabular(event,this)">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[cc2])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
	?>
   </select>
	 </td>
	  <td class="saludo1">Cuenta Bancaria Destino:</td>
	  <td >
	    <select id="banco2" name="banco2"  onChange="validar()" onKeyUp="return tabular(event,this)">
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	//$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.tercero=$_POST[ter]  and tesobancosctas.estado='S' ";
	$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit   and tesobancosctas.estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[1] ";
					$i=$row[1];
					 if($i==$_POST[banco2])
			 			{
						 echo "SELECTED";
						 $_POST[nbanco2]=$row[4];
						 $_POST[cb2]=$row[2];
						  $_POST[ter2]=$row[5];
						 }
					  echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
					}	 	
	?>
            </select> <input type="text" id="nbanco2" name="nbanco2" value="<?php echo $_POST[nbanco2]?>" style="width:67.5%;" readonly><input type="hidden" id="cb2" name="cb2" value="<?php echo $_POST[cb2]?>" ><input type="hidden" id="ter2" name="ter2" value="<?php echo $_POST[ter2]?>" ></td>
	  </tr> 
	   <?php
	  }
	  ?>
	  <tr>
	  <td class="saludo1">Valor:</td><td><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" onKeyUp="return tabular(event,this)"> <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"><input type="hidden" value="1" name="oculto" id="oculto">	</td>
	  </tr>
      </table>
	  <div class="subpantallac">
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Traslados</td></tr>                  
		<tr><td class="titulos2">Banco</td><td class="titulos2">N� Transacci&oacute;n</td>
		<td class="titulos2">CC-1</td>
		<td class="titulos2">Cuenta Bancaria 1 </td>
		<td class="titulos2">CC-2</td>
		<td class="titulos2">Cuenta Bancaria 2 </td>
		<td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
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
		  unset($_POST[dcts][$posi]);	
 		 unset($_POST[dcts2][$posi]);		 
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
		 $_POST[dcts]= array_values($_POST[dcts]); 		 
		 $_POST[dcts2]= array_values($_POST[dcts2]); 		 		 
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
		 $_POST[dcts][]=$_POST[ter];
		 $_POST[dcts2][]=$_POST[ter2];		 
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
				document.form2.ter.value="";
				document.form2.ter2.value="";
				document.form2.valor.value="";	
				document.form2.numero.value="";	
				document.form2.agregadet.value="0";				
				document.form2.numero.select();
		  		document.form2.numero.focus();	
		 </script>
		  <?php
		  }
		  		  $_POST[totalc]=0;
		// echo "C".count($_POST[dbancos]); 
		 for ($x=0;$x<count($_POST[dbancos]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dnbancos[]' value='".$_POST[dnbancos][$x]."' type='text' size='40'></td><td class='saludo2'><input name='dconsig[]' value='".$_POST[dconsig][$x]."' type='text' ></td><td class='saludo2'><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2' readonly></td><td class='saludo2'><input name='dbancos[]' value='".$_POST[dbancos][$x]."' type='hidden' ><input name='dcts[]' value='".$_POST[dcts][$x]."' type='hidden' ><input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dccs2[]' value='".$_POST[dccs2][$x]."' type='text' size='2' readonly></td><td class='saludo2'><input name='dcts2[]' value='".$_POST[dcts2][$x]."' type='hidden' ><input name='dnbancos2[]' value='".$_POST[dnbancos2][$x]."' type='hidden' ><input name='dbancos2[]' value='".$_POST[dbancos2][$x]."' type='hidden' ><input name='dcbs2[]' value='".$_POST[dcbs2][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." Pesos";
	    echo "<tr><td colspan='5'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td colspan='5'>Son: <input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?>
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	
	$linkbd=conectar_bd();
	$p1=substr($_POST[fecha],0,2);
	$p2=substr($_POST[fecha],3,2);
	$p3=substr($_POST[fecha],6,4);
	$fechaf=$p3."-".$p2."-".$p1;	
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{
	if($_POST[estado]=='S')
	$estadoc='1';
	else
	$estadoc='0';
// 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
//	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
//************CREACION DEL COMPROBANTE CONTABLE ************************
//***busca el consecutivo del comprobante contable
//	$consec=0;
//	$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='10' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
	//echo $sqlr;
//	$res=mysql_query($sqlr,$linkbd);
//	while($r=mysql_fetch_row($res))
//	 {
//	  $consec=$r[0];	  
//	 }
//	 $consec+=1;
//***cabecera comprobante
$totalpagar= $_POST[totalc];
	$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp=10";
	mysql_query($sqlr,$linkbd);
	$sqlr="delete from comprobante_det where numerotipo=$_POST[idcomp] and tipo_comp=10";
	mysql_query($sqlr,$linkbd);
//	 $sqlr="update comprobante_cab set fecha='$fechaf',concepto='$_POST[concepto]',total=0,total_debito=$_POST[totalc],total_credito=$_POST[totalc],diferencia=0,estado='1' where tipo_comp=10 and numerotipo=$_POST[idcomp]";
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[idcomp] ,10,'$fechaf','$_POST[concepto]',0,$totalpagar,$totalpagar,0,'$estadoc')";
	mysql_query($sqlr,$linkbd);
	//echo $sqlr;
//	$idcomp=mysql_insert_id();
//	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************	
//	 $sqlr="delete from comprobante_det where id_comp='10 $_POST[idcomp]' and vigencia='".$_SESSION[vigencia]."'";
//	 mysql_query($sqlr,$linkbd);
//	echo "$_POST[tipotras] <br>";	 
	if($_POST[tipotras]=='1')
	{
	for($x=0;$x<count($_POST[dbancos]);$x++)
	 {
	    //**** consignacion  BANCARIA*****
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('10 $_POST[idcomp]','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Traslado ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',0,".$_POST[dvalores][$x].",'1',".$_SESSION[vigencia].")";
	//echo "$sqlr <br>";
	mysql_query($sqlr,$linkbd);
		//*** Cuenta CAJA **
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('10 $_POST[idcomp]','".$_POST[dbancos2][$x]."','".$_POST[dcts2][$x]."','".$_POST[dccs2][$x]."','Traslado ".$_POST[dconsig][$x]." ".$_POST[dnbancos2][$x]."','',".$_POST[dvalores][$x].",0,'1',".$_SESSION[vigencia].")";
	mysql_query($sqlr,$linkbd);
	//echo "$sqlr <br>";
	}	
	}
	
	if($_POST[tipotras]=='2')
	{
	for($x=0;$x<count($_POST[dbancos]);$x++)
	 {
	 if($_POST[tipotrasext]=='1')
	 {
	 $debito=$_POST[dvalores][$x];
	 $credito=0;	 
	 }
	 if($_POST[tipotrasext]=='2')
	 {
	 $debito=0;
	 $credito=$_POST[dvalores][$x];	 	 
	 }	
	    //**** consignacion  BANCARIA*****
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('10 $_POST[idcomp]','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Traslado ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',$debito,$credito,'$estadoc','".$vigusu."')";
	mysql_query($sqlr,$linkbd);
	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('10 $_POST[idcomp]','".$_POST[cuentatraslado]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Traslado ".$_POST[dconsig][$x]." ".$_POST[dnbancos][$x]."','',$credito,$debito,'$estadoc','".$vigusu."')";
	mysql_query($sqlr,$linkbd);
	 }	
	}
	//************ insercion de cabecera TRASLADOS ************
	
	$sqlr="update tesotraslados_cab set fecha='$fechaf',estado='S',concepto='$_POST[concepto]' where id_consignacion=$_POST[comp] and vigencia='".$vigusu."'";	  
	mysql_query($sqlr,$linkbd);
//***************CREACION DE LA TABLA EN CTRASLADOS *********************
	
	$sqlr="select *from tesotraslados_cab where id_consignacion=$_POST[idcomp]";

	$resp=mysql_query($sqlr,$linkbd);
	$row=mysql_fetch_row($resp);
	$idconsig=$row[0];
	//************** insercion de consignaciones **************
	 $sqlr="delete from tesotraslados where id_trasladocab='$idconsig'";
	 mysql_query($sqlr,$linkbd);
	 	
	for($x=0;$x<count($_POST[dbancos]);$x++)
	 {
	$sqlr="insert into tesotraslados (id_trasladocab,fecha,ntransaccion,cco,ncuentaban1,tercero1,ccd,ncuentaban2,tercero2,valor,estado) values($idconsig,'$fechaf','".$_POST[dconsig][$x]."','".$_POST[dccs][$x]."','".$_POST[dcbs][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs2][$x]."','".$_POST[dcbs2][$x]."','".$_POST[dcts2][$x]."',".$_POST[dvalores][$x].",'$_POST[estado]')";	 

	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurri� el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  		else
  		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado los Traslados con Exito</center></td></tr></table>";
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  document.form2.oculto.value=1;
		  </script>
		  <?php
		  }
	}
	}//***bloqueo
	else
	{
    echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
    }	
}
?>	
</form>
 </td></tr>  
</table>
</body>
</html>