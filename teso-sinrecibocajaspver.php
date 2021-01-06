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
document.form2.action="teso-pdfsinrecajasp.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="teso-sinrecibocajaspver.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{
//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="teso-sinrecibocajaspver.php";
//alert("id:"+document.form2.idcomp.value+'  ncomp:'+document.form2.ncomp.value);
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
//document.form2.idcomp.value=document.form2.idcomp.value;
//document.form2.ncomp.value=document.form2.idcomp.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="teso-sinrecibocajaspver.php";
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
  <td colspan="3" class="cinta"><a href="teso-sinrecibocajasp.php" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#" ><img src="imagenes/guardad.png"  alt="Guardar" /></a><a href="teso-buscasinrecibocajasp.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
	$sqlr="select *from cuentacaja where estado='S' and vigencia=".$_SESSION["vigencia"];
//	echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[1];
	}
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
$linkbd=conectar_bd();
$sqlr="select max(id_recibos) from  tesosinreciboscajasp ORDER BY id_recibos DESC";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$_GET[idrecibo];
	 $_POST[idcomp]=$_GET[idrecibo];
}
if(!$_POST[oculto])
{
	$_POST[tabgroup1]=1;
$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cobrorecibo]=$row[0];
	 $_POST[vcobrorecibo]=$row[1];
	 $_POST[tcobrorecibo]=$row[2];	 
	}
}
 $sqlr="select * from tesosinreciboscajasp where id_recibos=$_POST[idcomp]";
 $res=mysql_query($sqlr,$linkbd); //echo $sqlr;
			while($r=mysql_fetch_row($res))
		 {		  
		  $_POST[tiporec]=$r[10];
		 }

switch($_POST[tiporec]) 
  	 {
	 
	  case 3:
	 $sqlr="select *from tesosinreciboscajasp,tesosinrecaudossp where tesosinrecaudossp.id_recaudo=tesosinreciboscajasp.id_recaudo and tesosinreciboscajasp.id_recibos=".$_POST[idcomp];
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	//$_POST[idcomp]=$row[0];	
	$_POST[idrecaudo]=$row[11];	
	$_POST[fecha]=$row[2];
	$_POST[vigencia]=$row[3];		
	$_POST[concepto]=$row[17];	
	$_POST[tiporec]=$row[10];	
	$_POST[modorec]=$row[5];		
	$_POST[banco]=$row[7];
	$_POST[cb]=$row[6];
	 $_POST[estadoc]=$row[9];
		   if ($_POST[estadoc]=='N')
		   $_POST[estado]="ANULADO";
		   else
		   $_POST[estado]="ACTIVO";	 		
	$_POST[valorecaudo]=$row[8];				
	$_POST[tercero]=$row[15];				
	$_POST[ntercero]=buscatercero($_POST[tercero]);						
	}
		break;	
	}

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
 <input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
 
 <?php 
 if($_POST[oculto])
 {
  /*$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] ";
 // echo "$sqlr";
  	  $_POST[encontro]="";
  $res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	  $_POST[concepto]=$row[6];	
	  $_POST[valorecaudo]=$row[5];	
	  $_POST[totalc]=$row[5];	
	  $_POST[tercero]=$row[4];	
	  $_POST[ntercero]=buscatercero($row[4]);	
	  $_POST[modorec]=$row[5];			 		  
	$_POST[banco]=$row[7];
	  $_POST[encontro]=1;
	}*/
 }
 ?>
 
  <div class="tabsic" style="height:36%; width:99.6%;">
   <div class="tab">
		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
		<label for="tab-1">Ingresos Propios</label>
		<div class="content" style="overflow-x:hidden;">
		 <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9">Ingresos Propios</td>
        <td class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
        <td  class="saludo1" >No Recibo:</td>
        <td width="152"  ><a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" ><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  ><input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td>
	  <td width="86"   class="saludo1">Fecha:        </td>
        <td width="152" ><input name="fecha" type="text"  onKeyDown="mascara(this,'/',patron,true)"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fecha]?>" size="10" maxlength="10" readonly>        </td>
         <td width="101" class="saludo1">Vigencia:</td>
		  <td width="252"><input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly></td>
		  <td width="55" class="saludo1">Estado:</td>
		  <td width="143" ><input type="text" name="estado" value="<?php echo $_POST[estado] ?>" size="5" readonly>  <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">      </td>       
        </tr>
      <tr><td class="saludo1"> Recaudo:</td><td> <select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" disabled >
         <option value="1" <?php if($_POST[tiporec]=='1') echo "SELECTED"; ?>>Predial</option>
          <option value="2" <?php if($_POST[tiporec]=='2') echo "SELECTED"; ?>>Industria y Comercio</option>
          <option value="3" <?php if($_POST[tiporec]=='3') echo "SELECTED"; ?>>Otros Recaudos</option>
        </select>
          </td>
          <?php
		  $sqlr="";
		  ?>
        <td class="saludo1">No Liquid:</td><td><input name="idrecaudo" type="text" id="idrecaudo" onChange="validar()" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[idrecaudo]?>" size="30" readonly> </td>
	 <td class="saludo1">Recaudado en:</td><td><input id="modorec" name="modorec" type="text" size="5" value="<?php echo $_POST[modorec] ?>" readonly> 
        <?php
		  if ($_POST[modorec]=='banco')
		   {
		?>
         <select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)" disabled>
	      <option value="">Seleccione....</option>
		  <?php
	$linkbd=conectar_bd();
	//$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
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
       <input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           </td><td colspan="2"> <input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" size="40" readonly>
          </td>
        <?php
		   }
		?> 
       </tr>
	  <tr><td class="saludo1" width="71">Concepto:</td><td colspan="5"><input name="concepto" type="text" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[concepto] ?>" size="90" readonly></td></tr>
      <tr><td class="saludo1" width="71">Valor:</td><td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" size="30" onKeyUp="return tabular(event,this)" readonly ></td><td  class="saludo1">Documento: </td>
        <td ><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" size="20" onKeyUp="return tabular(event,this)" readonly>
         </td>
			  <td class="saludo1">Contribuyente:</td>
	  <td  ><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" size="50" onKeyUp="return tabular(event,this) "  readonly><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  </td><td>
	    <input type="hidden" value="1" name="oculto"><input type="hidden" value="<?php echo $_POST[tiporeca]?>"  name="trec">
	    <input type="hidden" value="0" name="agregadet"></td></tr>     
      </table>
		</div>
		</div>
		 <div class="tab">
 	<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	<label for="tab-2">Afectacion Presupuestal</label>
	<div class="content" style="overflow-x:hidden;">
		<table class="inicio" style="overflow:scroll">
         					<tr><td class="titulos" colspan="3">Detalle Comprobantes</td></tr>
        					<tr>
                            	<td class="titulos2">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2">Valor</td>
                         	</tr>
                            <input type="hidden" id="totaldes" name="totaldes" value="<?php echo $_POST[totaldes]?>" readonly>
							
      						<?php
							
								
									
									$totaldes=0;
									$_POST[dcuenta]=array();
									$_POST[ncuenta]=array();
									$_POST[rvalor]=array();

									$sqlr="select *from pptosinrecibocajaspppto where idrecibo=$_POST[idcomp] and vigencia=$_POST[vigencia] and cuenta!=''";
									//echo $sqlr;
									$resd=mysql_query($sqlr,$linkbd);
									
									$iter='saludo1a';
									$iter2='saludo2';
									$cr=0;
									while($rowd=mysql_fetch_row($resd))
									{
								    $nresult=buscacuentapres($rowd[1],$rowd[4]);
											echo "<tr class=$iter>
												<td >
													<input name='dcuenta[]' value='$rowd[1]' type='text' size='20' readonly>
												</td>
												<td >
													<input name='ncuenta[]' value='$nresult' type='text' size='55' readonly>
												</td>
												<td >
													<input name='rvalor[]' value='".number_format($rowd[3],2)."' type='text' size='10' readonly>
												</td>
											</tr>";
									$var1=$rowd[3];
									$var1=$var1;
									$cuentavar1=$cuentavar1+$var1;
									$_POST[varto]=number_format($cuentavar1,2,".",",");
									 }
									 echo "<tr class=$iter><td> </td></tr>";
									echo "<tr >
											<td ></td>
											<td>Total:</td>
											<td >
												<input name='varto' id='varto' value='$_POST[varto]' size='10' readonly>
											</td>
										 </tr>";
								
							?>
							<input type='hidden' name='contrete' value="<?php echo $_POST[contrete] ?>" />
        				</table>
	</div>

 </div><!-- Termina tab -->

   
  </div>
  
   
     <div class="subpantallac7">
     <?php
     switch($_POST[tiporec]) 
  	 {
	  
	  case 3: ///*****************otros recaudos *******************
  $sqlr="select *from tesosinrecaudossp_det where tesosinrecaudossp_det.id_recaudo=$_POST[idrecaudo] and estado ='S'  and 3=$_POST[tiporec]";
//  echo "$sqlr";
 $_POST[trec]='OTROS RECAUDOS';	 
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
		 echo "<tr><td class='saludo1'><input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' size='4' readonly></td><td class='saludo1'><input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' size='90' readonly></td><td class='saludo1'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15' readonly></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr><td></td><td class='saludo2'>Total</td><td class='saludo1'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td class='saludo1'>Son:</td><td colspan='5' ><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?> 
	   </table></div>
</form>
 </td></tr>
</table>
</body>
</html>