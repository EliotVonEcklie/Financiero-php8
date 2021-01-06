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
<title>:: SPID- Tesoreria</title>

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

if (document.form2.fecha.value!='' && ((document.form2.modorec.value=='banco' && document.form2.banco.value!='') || (document.form2.modorec.value=='caja' && document.form2.cuentacaja.value!='')) )
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
document.form2.action="teso-pdfsinrecajasp.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
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
		<td colspan="3" class="cinta">
			<a href="teso-sinrecibocajasp.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>
			<a href="#" onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
			<a href="teso-buscasinrecibocajasp.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="Nueva Ventana"></a>
			<a href="#" <?php if($_POST[oculto]==2) { ?>onClick="pdf()" <?php } ?>> <img src="imagenes/print.png"  alt="Buscar" /></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
//$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[0];
	}
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	$check1="checked";
	$fec=date("d/m/Y");
	$_POST[vigencia]=$vigencia;
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[0];
	}
	
	$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cobrorecibo]=$row[0];
	 $_POST[vcobrorecibo]=$row[1];
	 $_POST[tcobrorecibo]=$row[2];	 
	}
	$sqlr="select max(id_recibos) from tesosinreciboscajasp ";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
	 $_POST[idcomp]=$consec;	
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		 $_POST[valor]=0;		 
		 		// echo "ddd";
}
//echo "dddd".$_POST[oculto];
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
 <form name="form2" method="post" action=""> 
 <input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>" >
 <input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>" >
 <input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>" >
 <input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>" > 
 <input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
 <?php 
 if($_POST[oculto])
 {
	switch($_POST[tiporec]) 
  	 {
	  case 1:
	  $sqlr="select *from tesoliquidapredial where tesoliquidapredial.idpredial=$_POST[idrecaudo] and estado ='S' and 1=$_POST[tiporec]";
  		//echo "$sqlr";
  	  $_POST[encontro]="";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
		$_POST[codcatastral]=$row[1];		
	  	$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];	
	  	$_POST[valorecaudo]=$row[8];		
	  	$_POST[totalc]=$row[8];	
	  	$_POST[tercero]=$row[4];	
	  	$_POST[ntercero]=buscatercero($row[4]);
		if ($_POST[ntercero]=='')
		 {
		  $sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
		  $resc=mysql_query($sqlr2,$linkbd);
		  $rowc =mysql_fetch_row($resc);
		   $_POST[ntercero]=$rowc[6];
		 }	
	  	$_POST[encontro]=1;
		}
	  
	  break;
	  
	  case 2:
	  $sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo] and estado ='S' and 2=$_POST[tiporec]";
  		//echo "$sqlr";
  	  $_POST[encontro]="";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
	  	$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];	
	  	$_POST[valorecaudo]=$row[6];		
	  	$_POST[totalc]=$row[6];	
	  	$_POST[tercero]=$row[5];	
	  	$_POST[ntercero]=buscatercero($row[5]);	
	  	$_POST[encontro]=1;
		$_POST[cuotas]=$row[9]+1;
		$_POST[tcuotas]=$row[8];
	 	}
	  
	  break;
	  
	  case 3:
	  $sqlr="select *from tesosinrecaudossp where tesosinrecaudossp.id_recaudo=$_POST[idrecaudo] and estado='S' and 3=$_POST[tiporec]";
  		//echo "$sqlr";
  	  $_POST[encontro]="";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
	  	$_POST[concepto]=$row[6];	
	  	$_POST[valorecaudo]=$row[7];		
	  	$_POST[totalc]=$row[5];	
	  	$_POST[tercero]=$row[4];	
	  	$_POST[ntercero]=buscatercero($row[4]);	
	  	$_POST[encontro]=1;
	 	}
		break;	
	}
 }
 ?>
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Ingresos Servicios Publicos</td>
        <td width="68" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
        <td  class="saludo1" >No Recibo:</td>
        <td width="203"  > <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" ><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  readonly></td>
	  <td width="103"   class="saludo1">Fecha:        </td>
        <td width="229" ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
         <td width="101" class="saludo1">Vigencia:</td>
		  <td width="350"><input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>      
        </tr>
      <tr><td class="saludo1"> Recaudo:</td><td> <select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" >
          <option value="3" <?php if($_POST[tiporec]=='3') echo "SELECTED"; ?>>Otros Recaudos</option>
        </select>
          </td>
          <?php
		  $sqlr="";
		  ?>
        <td class="saludo1">No Liquid:</td><td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" size="30" onKeyUp="return tabular(event,this)" onChange="validar()"> </td>
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
	  <tr><td class="saludo1" width="71">Concepto:</td><td colspan="3"><input name="concepto" size="90" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)"></td>
      <?php
	  if($_POST[tiporec]==2)
	   {
		?>   
      <td class="saludo1">No Cuota:</td><td><input name="cuotas" size="1" type="text" value="<?php echo $_POST[cuotas] ?>" readonly>/<input type="text" id="tcuotas" name="tcuotas" value="<?php echo $_POST[tcuotas]?>" size="1"  readonly ></td>
      <?php
	   }
	  ?>
	  </tr>
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
      <?php 
 if($_POST[oculto] && $_POST[encontro]=='1')
 {
  switch($_POST[tiporec]) 
  	 {
	  case 1: //********PREDIAL
	   $sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 // echo "$sqlr";
		 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 	
		 $_POST[trec]='PREDIAL';
		 
 	 	$res=mysql_query($sqlr,$linkbd);
//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
		while ($row =mysql_fetch_row($res)) 
		{
		$vig=$row[1];
		if($vig==$vigusu)
		 {
		$sqlr2="select * from tesoingresos where codigo='01'";
		$res2=mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($res2); 
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    	$_POST[dvalores][]=$row[11];		 
			//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
	 	}
		 else
	   	 {	
		$sqlr2="select * from tesoingresos where codigo='03'";
		$res2=mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($res2); 
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
	    $_POST[dvalores][]=$row[11];		
				//		echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
		 }
		 
	}  
	  break;
	  
	  case 2: //***********INDUSTRIA Y COMERCIO
 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 	
	  		 $_POST[trec]='INDUSTRIA Y COMERCIO';	 
		
			 $sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo] and estado ='S' and 2=$_POST[tiporec]";
  		//echo "$sqlr";
	  $res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
	 	{
		$sqlr2="select * from tesoingresos where codigo='02'";
	  $res2=mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($res2);
 		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1];			 		
	    $_POST[dvalores][]=$row[6]/$_POST[tcuotas];		
		}
	  break;
	  
	  case 3: ///*****************otros recaudos *******************
	  		 $_POST[trec]='OTROS RECAUDOS';	 
			// echo $_POST[tcobrorecibo];
			  $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 
		
  $sqlr="select *from tesosinrecaudossp_det where tesosinrecaudossp_det.id_recaudo=$_POST[idrecaudo] and estado ='S'  and 3=$_POST[tiporec]";
//  echo "$sqlr";				 
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
	   	   <tr><td colspan="4" class="titulos">Detalle Recibo de Caja</td></tr>                  
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
 			$resultado = convertir($_POST[totalc],"PESOS");
			$_POST[letras]=$resultado." PESOS M/CTE";
		 echo "<tr><td></td><td class='saludo2'>Total</td><td class='saludo1'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td class='saludo1'>Son:</td><td colspan='5' ><input name='letras' type='text' value='$_POST[letras]' size='200'></td></tr>";
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
	  case 1://***** PREDIAL *****************************************
//	  echo 'PREDIAL';
	  $sqlr="select count(*) from tesosinreciboscajasp where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {
			$numerorecaudos=$r[0];
		 }
	  if($numerorecaudos>=0)
	   { 	
	//   $sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
	//   mysql_query($sqlr,$linkbd);
	//    $sqlr="delete from comprobante_det where id_comp='5 $_POST[idcomp]'";
		//echo $sqlr;
//		mysql_query($sqlr,$linkbd);
	//	$sqlr="delete from pptosinrecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
	//	mysql_query($sqlr,$linkbd);
		   if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }	   
		      ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	   $sqlr="insert into tesosinreciboscajasp (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo) values(0,'$fechaf',".$vigusu.",$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]')";	  
		if (!mysql_query($sqlr,$linkbd))
		{
	 	echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 	echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 	echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     	echo "</pre></center></td></tr></table>";
		}
  		else
  		 {
		 $concecc=mysql_insert_id();
		 }
	   	//************ insercion de cabecera recaudos ************
//		 $concecc=$_POST[idcomp];
		 //echo "ccc".$concecc;
		 echo "<input type='hidden' name='concec' value='$concecc'>";	
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
		  $sqlr="update tesoliquidapredial set estado='P' WHERE idpredial=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);
		  $sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  $resq=mysql_query($sqlr,$linkbd);
		  //echo "<br>$sqlr";
		  while($rq=mysql_fetch_row($resq))
 		  {
		   $sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE   idpredial=$_POST[idrecaudo]) AND vigencia=$rq[1]";
		   mysql_query($sqlr2,$linkbd);
		   		//  echo "<br>$sqlr2";
		  }
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php		  			 
	//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,30,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
		 mysql_query($sqlr,$linkbd);
		 
		 //******parte para el recaudo del cobro por recibo de caja
		 
		 for($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		 if($_POST[dcoding][$x]==$_POST[cobrorecibo])
		 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
		
	    //**** busqueda cuenta presupuestal*****
		

			//busqueda concepto contable
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		 		//echo "concc: $sqlrc <br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
			  $porce=$rowi[5];
			  
			if($rowc[7]=='S')
			  {				 
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;
					
				if($rowc[3]=='N')
			    {
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('30 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr."<br>";						
					//***cuenta caja o banco
				if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
			   //$valordeb=$_POST[dvalores][$x]*($porce/100);
				//$valorcred=0;
				//echo "bc:$_POST[modorec] - $cuentacb";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('30 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "Conc: $sqlr <br>";					
				}
			
			  }
		 }
		 }
	  }
	}			 	 
	 //*************** fin de cobro de recibo
		  $sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 $res=mysql_query($sqlrs,$linkbd);	
		 $rowd==mysql_fetch_row($res);
		 $tasadesc=($rowd[6]/100);
 $sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 $res=mysql_query($sqlr,$linkbd);
		 
		 //echo "<BR>".$sqlr;
//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
		while ($row =mysql_fetch_row($res)) 
		{
		$vig=$row[1];
		$vlrdesc=$row[10];
		if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
		 {
			 		// $tasadesc=$row[10]/($row[4]+$row[6]);		
		// echo "<BR>".$sqlr;
		 $idcomp=mysql_insert_id();
		 echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
		$sqlr2="select * from tesoingresos_DET where codigo='01' AND MODULO='4' and vigencia=$vigusu";
		$res2=mysql_query($sqlr2,$linkbd);
				// echo "<BR>".$sqlr2;				 
				 //****** $cuentacb   ES LA CUENTA CAJA O BANCO
		while($rowi =mysql_fetch_row($res2))
		 {
			// echo "<br>conc: ".$rowi[2];
		  switch($rowi[2])
		   {
			case '01': //***
					$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P01' AND MODULO='4' and vigencia=$vigusu";
					$resds=mysql_query($sqlrds,$linkbd);
					while($rowds =mysql_fetch_row($resds))
		   			{
					 $descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);
	//				 echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
					}

				 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		 //echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[4];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Vigente $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=round($valorcred-$descpredial,2);
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Vigente $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
					     //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
					  }
					}
				  }
				 }
			break;  
			case '02': //***
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
					  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL			
					  }
					}
				  }
				 }
			
			break;  
			case '03': 
								$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P10' AND MODULO='4' and vigencia=$vigusu";
					$resds=mysql_query($sqlrds,$linkbd);
					while($rowds =mysql_fetch_row($resds))
		   			{
					 $descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);
	//				 echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
					}

			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=round($valorcred-$descpredial,2);
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
					  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL			
					  }
					}
				  }
				 }
			break;  
			case 'P10': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=round($row[10]*round(($porce/100),2),2);
					$valorcred=0;		
					//echo "<BR>$row[10] $porce ".$valordeb;			
					if($rowc[3]=='N')
				    {
				 	 if($valordeb>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					//		 echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P01': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=round($row[10]*round($porce/100,2),2);
					// $descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
					$valorcred=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valordeb>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P02': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[5];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P04': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[7];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P05': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P07': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[9];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P08': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=0;
					$valordeb=$row[8];					
				  }
				 if($rowc[6]=='N')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
				  }
					if($rowc[3]=='N')
				    {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);					
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valorcred;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
				   }
				 }
			break; 
			} 
			//echo "<br>".$sqlr;
		 }
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    	$_POST[dvalores][]=$row[11];		 
			//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
	 	}
		 else  ///***********OTRAS VIGENCIAS ***********
	   	 {	
			 		 $tasadesc=$row[10]/($row[4]+$row[6]);
		// $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
		 //mysql_query($sqlr,$linkbd);
		// echo "<BR>".$sqlr;
		 $idcomp=mysql_insert_id();
		 echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
		  $sqlr="update tesosinreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
		  mysql_query($sqlr,$linkbd);
		$sqlr2="select * from tesoingresos_DET where codigo='03' AND MODULO='4' and vigencia=$vigusu";
		$res2=mysql_query($sqlr2,$linkbd);
				// echo "<BR>".$sqlr2;
				 
				 //****** $cuentacb   ES LA CUENTA CAJA O BANCO
		while($rowi =mysql_fetch_row($res2))
		 {
			// echo "<br>conc: ".$rowi[2];
		  switch($rowi[2])
		   {
			case 'P03': //***
				 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		 //echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[4];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred-$tasadesc*$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
						  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
					  }
					}
				  }
				 }
			break;  
			case 'P06': //***
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			
			break;  
			case '03': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred-$tasadesc*$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P01': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=$row[10];
					$valorcred=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
					  }
					}
				  }
				 }
			break;  
			case 'P02': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[5];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					}
				   }
				  }
				 }
			break;  
			case 'P04': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[7];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P05': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P07': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[9];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P08': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=0;
					$valordeb=$row[8];					
				  }
				 if($rowc[6]=='N')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
				  }
					if($rowc[3]=='N')
				    {
				 	 					
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);					
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
				   }
				 }
			break;  


			} 
			//echo "<br>".$sqlr;
		 }
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    	$_POST[dvalores][]=$row[11];		 	
				//		echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
		 }
		}
	//*******************  
	 $sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  $resp=mysql_query($sqlr,$linkbd);
		  while($row=mysql_fetch_row($resp,$linkbd))
		   {
		    $sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[1]";
			mysql_query($sqlr2,$linkbd);
		   }	 	  
		  
   	 } //fin de la verificacion
	 else
	 {
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion Predial<img src='imagenes/alert.png'></center></td></tr></table>";
	 }//***FIN DE LA VERIFICACION
	   break;
	   case 2:  //********** INDUSTRIA Y COMERCIO
	   //echo "INDUSTRIA";
		      ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="select count(*) from tesosinreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2' AND ESTADO='S'";
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	while($r=mysql_fetch_row($res))
	 {
		$numerorecaudos=$r[0];
	 }
	 $sqlr="SELECT ncuotas,pagos,estado from tesoindustria  WHERE id_industria=$_POST[idrecaudo]";
		  $resic=mysql_query($sqlr,$linkbd);
		  $rowic=mysql_fetch_array($resic);
	 	  $ncuotas=$rowic[0];
		  $pagos=$rowic[1];
  if(($numerorecaudos==0) || ($ncuotas-$pagos)>0)
   {   	 
		 $sqlr="insert into tesosinreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo) values(0,'$fechaf',".$_SESSION["vigencia"].",$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]')";	  
		if (!mysql_query($sqlr,$linkbd))
		{
	 	echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 	echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 	echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     	echo "</pre></center></td></tr></table>";
		}
  		else
  		 {
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script>pdf()</script></center></td></tr></table>"; 
		 $concecc=mysql_insert_id(); 
		 //*************COMPROBANTE CONTABLE INDUSTRIA
		  $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,25,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	 	  $sqlr="update tesosinreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='2'";
		  mysql_query($sqlr,$linkbd);
		  //*** N CUOTAS
		  $sqlr="SELECT ncuotas,pagos,estado from tesoindustria  WHERE id_industria=$_POST[idrecaudo]";
		  $resic=mysql_query($sqlr,$linkbd);
		  $rowic=mysql_fetch_array($resic);
		  $ncuotas=$rowic[0];
		  $pagos=$rowic[1];
		  $estadoic=$rowic[2];	
		  if (($ncuotas-$pagos)==1)
		   {
			$sqlr="update tesoindustria set estado='P',pagos=pagos+1 WHERE id_industria=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);   
			}	
			else
			{  		  
  		  $sqlr="update tesoindustria set pagos=pagos+1 WHERE id_industria=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);
			}
		  if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
//			echo "c:".count($_POST[dcoding]);	

 //******parte para el recaudo del cobro por recibo de caja
		 
		 for($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		 if($_POST[dcoding][$x]==$_POST[cobrorecibo])
		 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
		
	    //**** busqueda cuenta presupuestal*****
		

			//busqueda concepto contable
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		 		//echo "concc: $sqlrc <br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
			  $porce=$rowi[5];
			if($rowc[7]=='S')
			  {				 
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;
					
				if($rowc[3]=='N')
			    {
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr."<br>";						
					//***cuenta caja o banco
				if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
			   //$valordeb=$_POST[dvalores][$x]*($porce/100);
				//$valorcred=0;
				//echo "bc:$_POST[modorec] - $cuentacb";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "Conc: $sqlr <br>";					
				}
			
			  }
		 }
		 }
	  }
	}			 	 
	 //*************** fin de cobro de recibo

		for($x=0;$x<count($_POST[dcoding]);$x++)
	 	{
		 //***** BUSQUEDA INGRESO ********
		$sqlr="Select * from tesoindustria_det where id_industria=".$_POST[idrecaudo];
	 	$res=mysql_query($sqlr,$linkbd);
		$row=mysql_fetch_row($res);
		$industria=$row[1]/$_POST[tcuotas];
		$avisos=$row[2]/$_POST[tcuotas];
		$bomberil=$row[3]/$_POST[tcuotas];	
		$sanciones=$row[5]/$_POST[tcuotas];	
		$retenciones=$row[4]/$_POST[tcuotas];				
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$res=mysql_query($sqlri,$linkbd);
	//     echo "$sqlri <br>";	    
		  while($row=mysql_fetch_row($res))
		  {
			if($row[2]=='04') //*****industria
			  {
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='04' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$industria+$sanciones;
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Industria y Comercio $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
	//					echo "<br>$sqlr";
						//********** CAJA O BANCO
						 //*** retencion ica
						
						$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
					$rescr=mysql_query($sqlr2,$linkbd);
					 while($rowcr=mysql_fetch_row($rescr))
					  {
					   if($rowcr[3]=='N')
						{
						 if($rowcr[6]=='S')
						 {
							$cuentaretencion= $rowcr[4];
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentaretencion."','".$_POST[tercero]."','".$row2[5]."','Retenciones Industria y Comercio','',".$retenciones.",0,'1','".$_POST[vigencia]."')";
							mysql_query($sqlr,$linkbd);
						 }
						}
					  }
					  //**fin rete ica
						 $valordeb=$industria+$sanciones;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Industria y Comercio $_POST[modorec]','',".($valordeb-$retenciones).",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$valordeb  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
					 $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$valordeb,'".$vigusu."')";
						 //echo "ic rec:".$sqlr;
  						  mysql_query($sqlr,$linkbd);	
						 }
						}
					  }
			  }
			if($row[2]=='05')//************avisos
			  {
				$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='05' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$avisos;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Avisos y Tableros $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
//						echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$avisos;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Avisos y Tableros $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$avisos  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$avisos,'".$vigusu."')";
						//  echo "av rec:".$sqlr;
		  			  mysql_query($sqlr,$linkbd);	
						

						 }
						}						
					  }
			  }
			if($row[2]=='06') //*********bomberil ********
			  {
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='06' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$bomberil;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('25 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Bomberil $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
		//				echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$bomberil;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Bomberil $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
			//***MODIFICAR PRESUPUESTO
						$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bomberil  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$bomberil,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
				// echo "bom rec:".$sqlr;
						 }
						}
					  }
			   }
		    }
		  }
		}
   }
	 else
	 {
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 }
		 
		break; 
	  case 3: //**************OTROS RECAUDOS
	$sqlr="select count(*) from tesosinreciboscajasp where id_recaudo=$_POST[idrecaudo] and tipo='3' AND ESTADO='S'";
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	while($r=mysql_fetch_row($res))
	 {
		$numerorecaudos=$r[0];
	 }
  if($numerorecaudos==0)
   { 
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$concecc=0;
	$sqlr="select max(id_recibos ) from tesosinreciboscajasp  ";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $concecc=$r[0];	  
	 }
	 $concecc+=1;
	 // $consec=$concecc;
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,30,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	
	 $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($concecc,23,'$fechaf','INGRESOS SERV PUBLICOS $_POST[concepto]',$vigusu,0,0,0,'1')";
	 	  mysql_query($sqlr,$linkbd);
		//echo "$sqlr <br>";	  
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
			$porce=$rowi[5];
			$vi=$_POST[dvalores][$x]*($porce/100);
	    //**** busqueda cuenta presupuestal*****
			$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[6]."','".$_POST[tercero]."','INGRESO SERV PUBLICOS ',".$vi.",0,'1','$_POST[vigencia]',23,'$concecc')";
	  mysql_query($sqlr,$linkbd); 	
			//echo "$sqlr <br>";	  
			//busqueda concepto contable
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		// 		echo "concc: $sqlrc - $_POST[cobrorecibo]<br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
		 
			 
	  		 if($_POST[dcoding][$x]==$_POST[cobrorecibo])
			 {
			  //$columna= $rowc[7];
			//  echo "cred  $rowc[7]<br>";	      
			  if($rowc[7]=='S')
  			  {
			  $columna= $rowc[7];
			   }
			  else
			  {
				  $columna= 'N';
				}
			  $cuentacont=$rowc[4];
			 }
			 else
			 {
			  $columna= $rowc[6];	
			  $cuentacont=$rowc[4];			 
			 }
			if($columna=='S')
			  {				 
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;
				//	echo "cuenta: $rowc[4] - $columna <br>";	      
				if($rowc[3]=='N')
			    {
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('30 $concecc','".$cuentacont."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr."<br>";						
					//***cuenta caja o banco
				if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
			   //$valordeb=$_POST[dvalores][$x]*($porce/100);
				//$valorcred=0;
				//echo "bc:$_POST[modorec] - $cuentacb";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('30 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				
				
			
				//echo "Conc: $sqlr <br>";					
				}
			
			  }
		 }
		 }
	}	
	//************ insercion de cabecera recaudos ************

	$sqlr="insert into tesosinreciboscajasp (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo) values($idcomp,'$fechaf',".$vigusu.",$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]')";	  
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  		
		else
  		 {
		  echo "<table><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script>pdf()</script></center></td></tr></table>";
		  $sqlr="update tesosinrecaudossp set estado='P' WHERE ID_RECAUDO=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);

		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php
		  }
    } //fin de la verificacion
	 else
	 {
	  echo "<table ><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 }
	   break;
	   //********************* INDUSTRIA Y COMERCIO
	} //*****fin del switch
	$_POST[ncomp]=$concecc;
	//******* GUARDAR DETALLE DEL RECIBO DE CAJA ******	
		for($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		  $sqlr="insert into tesosinreciboscajasp_det (id_recibos,ingreso,valor,estado) values($concecc,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
		  mysql_query($sqlr,$linkbd);  
	//	  echo $sqlr."<br>";
		 }		
	//***** FIN DETALLE RECIBO DE CAJA ***************		
	  }
  else
   {
    echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
   }
  //****fin if bloqueo  
   }//**fin del oculto 
?>	
</form>
 </td></tr>
</table>
</body>
</html>