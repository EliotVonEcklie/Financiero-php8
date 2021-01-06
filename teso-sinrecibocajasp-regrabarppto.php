<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
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
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='' && ((document.form2.modorec.value=='banco' && document.form2.banco.value!='') || (document.form2.modorec.value=='caja')))
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
document.form2.action="teso-pdfrecaja.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{
   //alert("adelante"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="teso-sinrecibocaja-regrabarppto.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{
	   //alert("atras"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="teso-sinrecibocaja-regrabarppto.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="teso-sinrecibocaja-regrabarppto.php";
document.form2.submit();
}
</script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="#" ><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a> <a href="#" onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscasinrecibocaja-rg.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#"onClick="pdf()"> <img src="imagenes/print.png"  alt="Imprimir" /></a><a href="teso-actualizardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
 <form name="form2" method="post" action=""> 
 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[0];
//	 echo "cc";
	}
 ?>	
<?php

	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
$sqlr="select id_recibos,id_recaudo from  tesosinreciboscaja ORDER BY id_recibos DESC";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
if(!$_POST[oculto])
{
	$check1="checked";
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigencia;
$sqlr="select id_recibos,id_recaudo from  tesosinreciboscaja ORDER BY id_recibos DESC";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$r[0];
	 $_POST[idcomp]=$r[0];
	 $_POST[idrecaudo]=$r[1];	 
	 if($_GET[idrecibo]!="")
		{
	 	 $_POST[idcomp]=$_GET[idrecibo];
		  $_POST[ncomp]=$_GET[idrecibo];
		}
}
//echo "Ncomp: ".$_POST[ncomp];
 $sqlr="select * from tesosinreciboscaja where id_recibos=$_POST[idcomp]";
 $res=mysql_query($sqlr,$linkbd);
// echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {		  
		  $_POST[tiporec]=$r[10];
		  $_POST[idrecaudo]=$r[4];
		  $_POST[ncomp]=$r[0];
		  $_POST[modorec]=$r[5];	
		 }
//echo "ncomp: ".$_POST[ncomp];
//echo " mrec: ".$_POST[modorec];
switch($_POST[tabgroup1])
{
case 1:
$check1='checked';
break;
case 2:
$check2='checked';
break;
case 3:
$check3='checked';
}
?>
<input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>" >
 <input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>" >
 <input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>" > 
 <input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>" >
  <input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
 <?php 

	switch($_POST[tiporec]) 
  	 {	  
	  case 3:
	  $sqlr="select *from tesosinrecaudos where tesosinrecaudos.id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
  		//echo "$sqlr";
  	  $_POST[encontro]="";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
	  	$_POST[concepto]=$row[6];	
	  	$_POST[valorecaudo]=$row[5];		
	  	$_POST[totalc]=$row[5];	
	  	$_POST[tercero]=$row[4];	
	  	$_POST[ntercero]=buscatercero($row[4]);			
	  	$_POST[encontro]=1;
	 	}
		$sqlr="select *from tesosinreciboscaja where  id_recibos=$_POST[idcomp] ";
		$res=mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($res); 
		//echo "$sqlr";
		//$_POST[idcomp]=$row[0];
		$_POST[fecha]=$row[2];
		$_POST[estadoc]=$row[9];
		   if ($row[9]=='N')
		   {$_POST[estado]="ANULADO";
		   $_POST[estadoc]='0';
		   }
		   else
		   {
			   $_POST[estadoc]='1';
			   $_POST[estado]="ACTIVO";
		   }

				$_POST[modorec]=$row[5];
					$_POST[banco]=$row[7];
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   $_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	   //echo "mre:".$_POST[modorec];
		break;	
	}

 ?>
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Interfaz  Ingresos Internos ppto</td>
        <td width="68" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
        <td  class="saludo1" >No Recibo:</td>
        <td width="203"  > <a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" ><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  ><input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td>
	  <td width="103"   class="saludo1">Fecha:        </td>
        <td width="229" ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10"  onKeyDown="mascara(this,'/',patron,true)"  onKeyUp="return tabular(event,this)">        </td>
         <td width="101" class="saludo1">Vigencia:</td>
		  <td width="350"><input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>   <input type="text" name="estado" value="<?php echo $_POST[estado] ?>" size="5" readonly>  <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">      
        </tr>
      <tr><td class="saludo1"> Recaudo:</td><td> <select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="1" <?php if($_POST[tiporec]=='1') echo "SELECTED"; ?>>Predial</option>
          <option value="2" <?php if($_POST[tiporec]=='2') echo "SELECTED"; ?>>Industria y Comercio</option>
          <option value="3" <?php if($_POST[tiporec]=='3') echo "SELECTED"; ?>>Otros Recaudos</option>
        </select>
          </td>
          <?php
		  $sqlr="";
		  ?>
        <td class="saludo1">No Liquid:</td><td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" size="30" onKeyUp="return tabular(event,this)" onChange="validar()" readonly> </td>
	 <td class="saludo1">Recaudado en:</td><td> <select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" onChange="validar()" >
         <option value="caja" <?php if($_POST[modorec]=='caja') echo "SELECTED"; ?>>Caja</option>
          <option value="banco" <?php if($_POST[modorec]=='banco') echo "SELECTED"; ?>>Banco</option>
        </select>
        <?php
		  if ($_POST[modorec]=='banco')
		   {
		?>
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
            </select>
       <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           </td><td> <input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="40" readonly>
          </td>
        <?php
		   }
		?> 
       </tr>
	  <tr><td class="saludo1" width="71">Concepto:</td><td colspan="5"><input name="concepto" size="90" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)"></td></tr>
      <tr><td class="saludo1" width="71">Valor:</td><td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" size="30" onKeyUp="return tabular(event,this)" readonly ></td><td  class="saludo1">Documento: </td>
        <td ><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" size="20" onKeyUp="return tabular(event,this)" readonly>
         </td>
			  <td class="saludo1">Contribuyente:</td>
	  <td  ><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" size="50" onKeyUp="return tabular(event,this) "  readonly><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  </td><td>
	    <input type="hidden" value="1" name="oculto">
		<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    <input type="hidden" value="0" name="agregadet"></td></tr>
     
      </table>
     <div class="subpantallac7">
      <?php  //echo $_POST[oculto]." - ".$_POST[encontro];
 if($_POST[oculto] && $_POST[encontro]=='1')
 {
	
  switch($_POST[tiporec]) 
  	 {	 	 
	  case 3: ///*****************otros recaudos *******************
	  		 $_POST[trec]='OTROS RECAUDOS';	 
  $sqlr="select *from tesosinrecaudos_det where tesosinrecaudos_det.id_recaudo=$_POST[idrecaudo]   and 3=$_POST[tiporec]";
 echo "$sqlr";
		 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 	
		 
  $res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{	
	$_POST[dcoding][]=$row[2];
	$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
	$res2=mysql_query($sqlr2,$linkbd);
	$row2 =mysql_fetch_row($res2); 
	$_POST[dncoding][]=$row2[0];			 		
    $_POST[dvalores][]=$row[3];		 	
	}
	break;
   }
 }
 ?>
	   <table class="inicio">
	   	   <tr>
	   	     <td colspan="4" class="titulos">Detalle Ingresos Internos</td></tr>                  
		<tr><td class="titulos2">Codigo</td><td class="titulos2">Ingreso</td><td class="titulos2">Valor</td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		  
 		 unset($_POST[dcoding][$posi]);	
 		 unset($_POST[dncoding][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];			 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.valor.value="";	
				document.form2.ningreso.value="";				
				document.form2.codingreso.select();
		  		document.form2.codingreso.focus();	
		 </script>
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {		 
		 echo "<tr><td class='saludo1'><input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' size='4'></td><td class='saludo1'><input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' size='90'></td><td class='saludo1'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15'></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr><td></td><td class='saludo2'>Total</td><td class='saludo1'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td class='saludo1'>Son:</td><td colspan='5' ><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{						
	//************VALIDAR SI YA FUE GUARDADO ************************
	switch($_POST[tiporec]) 
  	 {	  
	  case 3: //**************OTROS RECAUDOS
	
    $sqlr="delete from pptocomprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='23'";
	  mysql_query($sqlr,$linkbd);
	    $sqlr="delete from pptocomprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='23'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptosinrecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
		mysql_query($sqlr,$linkbd);
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];
//***cabecera comprobante
	  $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($consec,23,'$fechaf','INGRESOS SERV PUBLICOS',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
	 	  mysql_query($sqlr,$linkbd);
	$idcomp=$consec;
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso Propio con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
//	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
		
		  $sqlr="delete from pptosinrecibocajappto where idrecibo=$consec ";
			 mysql_query($sqlr,$linkbd);	
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
			if($rowi[6]!="")
		    {
	    //**** busqueda cuenta presupuestal*****
		 $porce=$rowi[5];
		 $valorcred=$_POST[dvalores][$x]*($porce/100);
		 $valordeb=0;
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
			$rowpto=mysql_fetch_row($respto);			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			//mysql_query($sqlr,$linkbd);	
			//****creacion documento presupuesto ingresos		
	  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$vigusu."')";
	  mysql_query($sqlr,$linkbd);	
	  $sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','INGRESO SERV PUBLICOS',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',23,'$consec')";
	  mysql_query($sqlr,$linkbd); 		
			//echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
			}
		 }
	}		
	   break;
	   //********************* INDUSTRIA Y COMERCIO
	} //*****fin del switch
	}//***bloqueo
		else
	   {
    	echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
	   }

   }//**fin del oculto 
?>	
</form>
 </td></tr>
</table>
</body>
</html>