<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SPID - Presupuesto</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
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

if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.acuerdo.value!='')
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

function validar(formulario)
{
//document.form2.action="presu-adicioningver.php";
document.form2.submit();
}

function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="ccp-adicioningver.php";
document.form2.submit();
}

function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=document.form2.tipocta.value;
 document.form2.submit();
 }
 }

function agregardetalle()
{
 vc=document.form2.valorac2.value;
if(document.form2.cuenta.value!="" && document.form2.tipomov.value!="" && document.form2.tipocta.value!="" && document.form2.valor.value>=0 )
{ 
 tipoc=document.form2.tipocta.value;
 switch (tipoc)
 {
   case '1':
     suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentaing2.value);
 		if(suma<=vc)
  			{
				document.form2.agregadet.value=1;
//				document.form2.chacuerdo.value=2;
				document.form2.submit();
				
  			}
			else
	 			{
	 			alert("El Valor supera el Acto Administrativo: "+suma);
				 }
	break;
	case '2':
	suma=parseFloat(document.form2.valor.value)+parseFloat(document.form2.cuentagas2.value);
 		if(suma<=vc)
  			{
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
  			}
			else
	 			{
	 			alert("El Valor supera el Acto Administrativo: "+suma);
				 }
	break;
	}
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
  document.form2.chacuerdo.value=2;
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}

function finaliza()
 {
 if (document.form2.valorac2.value==document.form2.cuentagas2.value && document.form2.valorac2.value==document.form2.cuentaing2.value)
  {
  if (confirm("Confirme Guardando el Documento, al completar el Proceso"))
  {
	  document.form2.fin.checked=true; 
  } 
  else
  document.form2.fin.checked=false; 
  }
  else 
  {
   alert("El Total del Acto Administrativo no es igual al de Ingresos y/o Gastos");
    document.form2.fin.checked=false; 
  }
 }

function pdf()
{
document.form2.action="pdfpptoadga.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}

function capturaTecla(e){ 
var tcl = (document.all)?e.keyCode:e.which;
if (tcl==115){
alert(tcl);
return tabular(e,elemento);
}
}

			function adelante(){
				if(document.form2.siguiente.value!=''){
					location.href="ccp-adicioningver.php?idac="+document.form2.siguiente.value;
				}
			}
		
			function atrasc(){
				if(document.form2.anterior.value!=''){
					location.href="ccp-adicioningver.php?idac="+document.form2.anterior.value;
				}
			}
</script>
		<?php titlepag();?>
	</head>
	<body >
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
            <tr>
				<td colspan="3" class="cinta">
					<a href="ccp-adicioning.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="" class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a>
					<a href="ccp-buscaradicioning.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir" ></a>
				</td>
			</tr>
		</table> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$vigencia=$vigusu;
if(!$_POST[oculto])
{
	$linkbd=conectar_bd();

	$sqlr="select *from pptoacuerdos where (pptoacuerdos.valoradicion>0) or (pptoacuerdos.valorreduccion>0) and pptoacuerdos.tipo='M' ORDER BY vigencia DESC, consecutivo ";
	$res=mysql_query($sqlr,$linkbd);
	$contacu=0;
	$_POST[actual]=$_GET[idac];
	while ($row=mysql_fetch_row($res)){
		if($contacu==0){
			$_POST[anterior]='';
		}
		if($row[0]==$_POST[actual]){
			$row=mysql_fetch_row($res);
			$_POST[siguiente]=$row[0];
			break;
		}
		$_POST[anterior]=$row[0];
		$contacu+=1;
	}


 		 

		$sqlr="select *from pptoacuerdos where pptoacuerdos.id_acuerdo=$_GET[idac]";
		 $res=mysql_query($sqlr,$linkbd);
				 $cont=0; 
		 $ban=0;
		 
		// echo $sqlr;
		 while ($row=mysql_fetch_row($res))
		 	{
			$_POST[acuerdo]=$row[0];	
			if ($row[9]=='A')
					$_POST[fin]='Anulado';
				if ($row[9]=='S')
					$_POST[fin]='Sin Finalizar';
				if ($row[9]=='F')
					$_POST[fin]='Finalizado';
			
			$p1=substr($row[3],0,4);
			$p2=substr($row[3],5,2);
			$p3=substr($row[3],8,2);
			
			
			
			$_POST[fecha]=$p3."-".$p2."-".$p1;		
			
		
			if ($row[5]>0)
		 		{		$ban=1;
						$_POST[tipomov]=1;	
					$resultado = convertir($row[5]);
		 			$_POST[letras]=$resultado." PESOS";
				}
			else
				if ($row[6]>0)
				{	$ban=2;
						$_POST[tipomov]=2;	
					$resultado = convertir($row[6]);
		 			$_POST[letras]=$resultado." PESOS";
				}	
			$cont=$cont+1;
			}
	
		
		
		
		//$_POST[tipomov]=1;	
			$sqlr1="select *from pptoadiciones, pptocuentas where pptoadiciones.cuenta=pptocuentas.cuenta and pptoadiciones.id_acuerdo=$_GET[idac] and pptoadiciones.estado='S' and (pptocuentas.vigencia=".$vigusu." or pptocuentas.vigenciaf=".$vigusu.")";
			// echo "<br>".$sqlr1;
			$res1=mysql_query($sqlr1,$linkbd);
			$cont=0;
			while ($row1=mysql_fetch_row($res1))
		 	{		
				$_POST[dcuentas][$cont]=$row1[4];	
				$_POST[dncuentas][$cont]=$row1[10];
				if ($row1[7]=='I')
				{	
					$_POST[dingresos][$cont]=$row1[5];	
					$_POST[dgastos][$cont]='0';
				
				}
				if ($row1[7]=='G')
				{			
					$_POST[dingresos][$cont]='0';
					$_POST[dgastos][$cont]=$row1[5];	
				}		
				$cont=$cont+1;
				$_POST[adre]="ADICION PRESUPUESTAL";
			}
		 	
			//$_POST[tipomov]=2;	
			$sqlr1="select *from pptoreducciones, pptocuentas where pptoreducciones.cuenta=pptocuentas.cuenta and pptoreducciones.id_acuerdo=$_GET[idac] and pptoreducciones.estado='S' and (pptocuentas.vigencia=".$vigusu." or pptocuentas.vigenciaf=".$vigusu.")";
			$res1=mysql_query($sqlr1,$linkbd);
			while ($row1=mysql_fetch_row($res1))
		 	{		
				$_POST[dcuentas][$cont]=$row1[4];	
				$_POST[dncuentas][$cont]=$row1[9];	
				if ($row1[7]=='I')
				{		
					$_POST[dingresos][$cont]=$row1[5];	
					$_POST[dgastos][$cont]='0';
				}
				if ($row1[7]=='G')
				{			
					$_POST[dingresos][$cont]='0';
					$_POST[dgastos][$cont]=$row1[5];	
				
				}		
				$cont=$cont+1;
				$_POST[adre1]="REDUCCION PRESUPUESTAL";
			}
	}
?>
 <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],$_POST[tipocta]);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
			 
		if ($_POST[chacuerdo]=='2')
					 {
				    $_POST[dcuentas]=array();
				    $_POST[dncuentas]=array();
				    $_POST[dingresos]=array();
				    $_POST[dgastos]=array();
					$_POST[diferencia]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing]=0;																			
					 }	 
		?>
 <form name="form2" method="post" action="">
 	<input type="hidden" name="hab" id="hab" value="<?php echo $_POST[hab] ?>">
    <table class="inicio" align="center" width="80%" >
      	<tr >
        	<td class="titulos" style="width:95%;" colspan="2">.: Adicion/Reduccion Presupuestal</td>
        	<td  class="cerrar" style="width:5%;"><a href="ccp-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
      		<td style="width:75%;">
      			<table>
      				<tr  >
			  			<td style="width:10%;" class="saludo1">Adicion/Reduccion</td>
				  		<td style="width:10%;">
				  			<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar2()" disabled>
		          				<option value="" <?php if($_POST[tipomov]=='') echo "SELECTED"; ?>>...</option>
		          				<option value="1" <?php if($_POST[tipomov]=='1') echo "SELECTED"; ?>>Adicion</option>
		          				<option value="2" <?php if($_POST[tipomov]=='2') echo "SELECTED"; ?>>Reduccion</option>
		        			</select>
						</td>
			  			<td style="width:5%;" class="saludo1">Fecha:        </td>
		        		<td style="width:7%;">
		        			<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>
		        			       
		        		</td>
				 		<td style="width:12%;" class="saludo1">Acto Administrativo:</td>
				 		<td style="width:25%;" valign="middle" >
				 			<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
		        			<input type="hidden" name="anterior" id="anterior" value="<?php echo $_POST[anterior] ?>">
		        			<input type="hidden" name="actual" id="actual" value="<?php echo $_POST[actual] ?>">
				  			<select name="acuerdo"  onChange="validar2()" style="width:80%;" onKeyUp="return tabular(event,this)" readonly>
				
							 <?php

							   $link=conectar_bd();
					  		   $sqlr="Select * from pptoacuerdos where  id_acuerdo=$_GET[idac]";
					  		   
								        $tv=4+$_POST[tipomov];
							 			$resp = mysql_query($sqlr,$link);
									    while ($row =mysql_fetch_row($resp)) 
									    {
										echo "<option value=$row[0]";
										$i=$row[0];
										if($i==$_POST[acuerdo])
								 			{
											 echo "SELECTED";
											  $_POST[nomacuerdo]=$row[1]."-".$row[2];
											 $_POST[vigencia]=$row[4];
											 $_POST[valorac]=$row[$tv];
											 $_POST[valorac2]=$row[$tv];
											 $_POST[valorac]=number_format($_POST[valorac],2,'.',',');		 
											 //******subrutina para cargar el detalle del acuerdo de adiciones
											 if($_POST[chacuerdo]=='2' )
											  {
											 $sqlr2="select *from pptoadiciones where id_acuerdo='$i'";
											 $resp2=mysql_query($sqlr2,$link);
										     while ($row2 =mysql_fetch_row($resp2)) 
											   {
											    $_POST[dcuentas][]=$row2[4];					
												 if(substr($row2[4],0,1)=='1')							
											    {$_POST[dingresos][]=$row2[5];
												$_POST[dgastos][]=0;
												 $nresul=buscacuentapres($row2[4],1);
												 $_POST[dncuentas][]=$nresul;		}
												else{
												 $nresul=buscacuentapres($row2[4],2);
												 $_POST[dncuentas][]=$nresul;									
											    $_POST[dgastos][]=$row2[5];
												$_POST[dingresos][]=0;
													}
											   }
											 //******subrutina para cargar el detalle del acuerdo de adiciones
											 $sqlr2="select *from pptoreducciones where id_acuerdo='$i'";
											 $resp2=mysql_query($sqlr2,$link);
										     while ($row2 =mysql_fetch_row($resp2)) 
											   {
											    $_POST[dcuentas][]=$row2[4];
												 if(substr($row2[4],0,1)=='1')							
											    {$_POST[dingresos][]=$row2[5];
												$_POST[dgastos][]=0;
												$nresul=buscacuentapres($row2[4],1);
											    $_POST[dncuentas][]=$nresul;							 
													}
												else							
											    {$_POST[dgastos][]=$row2[5];
												$_POST[dingresos][]=0;														
												 $nresul=buscacuentapres($row2[4],2);
											    $_POST[dncuentas][]=$nresul;							 
													}
											   }
											  }///**** fin si cambio 
											 }
										  echo ">".$row[1]."-".$row[2]."</option>";	  
										}

							  ?>
							</select>
							<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
							<input type="hidden" name="siguiente" id="siguiente" value="<?php echo $_POST[siguiente] ?>">
							<input type="hidden" name="chacuerdo" value="1">
							<input type="hidden" name="nomacuerdo" value="<?php echo $_POST[nomacuerdo]?>">
							<input type="hidden" name="adre1" value="<?php echo $_POST[adre1]?>">
							<input type="hidden" name="adre" value="<?php echo $_POST[adre]?>">		  </td>
				  		<td style="width:5%;" class="saludo1">Vigencia:</td>
				  		<td style="width:5%;">
				  			<input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
				  		</td>
		       		</tr>
		       		<tr>
			   			<td style="width:10%;" class="saludo1">
			   				<input type="hidden" value="1" name="oculto">Valor Acuerdo:</td>
			   			<td style="width:10%;">
			   				<input name="valorac" type="text" value="<?php echo $_POST[valorac]?>" style="width:100%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>
			   				<input type="hidden"  id="valorac2" name="valorac2" value="<?php echo $_POST[valorac2]?>">
			   			</td>
			   			<td style="width:5%;" class="saludo1">Finalizar</td>
			   			<td style="width:7%;">
			   				<input type="text" name="fin" value="<?php echo $_POST[fin]?>" id="fin"  disabled="disabled">
			   			</td>
			    	</tr>
      			</table>
      		</td>
      		<td colspan="3" style="width:25%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" >
      			
      		</td>
      	</tr>
    </table>
	   
	<?php
	if(!$_POST[oculto])
	{ 
		 ?>
		 <script>
    	document.form2.fecha.focus();
		</script>
	<?php
	}	
			//**** busca cuenta
			if($_POST[bc]!='')
			 {

			  $nresul=buscacuentapres($_POST[cuenta],$_POST[tipocta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  			  ?>
			  <script>
			  document
			  document.getElementById('valor').focus();
			  document.getElementById('valor').select();
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
		?>
		<div class="subpantalla" style="height:50.9%; width:99.6%; overflow-x:hidden;">
		<table class="inicio" width="99%">
        <tr>
          <td class="titulos" colspan="5">Detalle Comprobantes          </td>
        </tr>
		<tr>
		<td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Ingresos</td><td class="titulos2">Gastos</td><td><input type='hidden' name='elimina' id='elimina'></td> 
		</tr> 
		<?php 
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		  $cuentagas=0;
		  $cuentaing=0;
		   $diferencia=0;
		 unset($_POST[dcuentas][$posi]);
 		 unset($_POST[dncuentas][$posi]);
		 unset($_POST[dgastos][$posi]);		 		 		 		 		 
		 unset($_POST[dingresos][$posi]);		 
		 $_POST[dcuentas]= array_values($_POST[dcuentas]); 
		 $_POST[dncuentas]= array_values($_POST[dncuentas]); 
		 $_POST[dgastos]= array_values($_POST[dgastos]); 
		 $_POST[dingresos]= array_values($_POST[dingresos]); 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		  $cuentagas=0;
		  $cuentaing=0;
		  $diferencia=0;
		 $_POST[dcuentas][]=$_POST[cuenta];
		 $_POST[dncuentas][]=$_POST[ncuenta];
		 if($_POST[tipocta]=='1')
	 	 {
		 $_POST[dgastos][]=0;
		 $_POST[dingresos][]=$_POST[valor];
		 }
		 if($_POST[tipocta]=='2')
		 {
		 $_POST[dingresos][]=0;
		 $_POST[dgastos][]=$_POST[valor];
		 }
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.cuenta.value="";
				document.form2.ncuenta.value="";
				document.form2.tipocta.select();
		  		document.form2.tipocta.focus();	
		 </script>
		  <?php
		  }
		  $iter='zebra1';
		  $iter2='zebra2';
		 for ($x=0;$x< count($_POST[dcuentas]);$x++)
		 {
		 
		 echo "<tr class='$iter'>
		 <td style='width:15%;'>
			<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%;' readonly></td>
		<td style='width:55%;'>
			<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%;' readonly></td>
		<td style='width:15%;'>
			<input name='dingresos[]' value='".$_POST[dingresos][$x]."' type='text' style='width:100%;' readonly></td>
		<td style='width:15%;'>
			<input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text' style='width:100%;' onDblClick='llamarventana(this,$x)' readonly></td></tr>";
//		 $cred= $vc[$x]*1;
		 $gas=$_POST[dgastos][$x];
		 $ing=$_POST[dingresos][$x];
//		 $cred=number_format($cred,2,".","");
	//	 $deb=number_format($deb,2,".","");
		 $gas=$gas;
		 $ing=$ing;		 
		 $cuentagas=$cuentagas+$gas;
		 $cuentaing=$cuentaing+$ing;
		 $_POST[cuentagas2]=$cuentagas;
		 $_POST[cuentaing2]=$cuentaing;		 	
		 $diferencia=$cuentaing-$cuentagas;
		 $total=number_format($total,2,",","");
		 $_POST[diferencia]=number_format($diferencia,2,".",",");
 		 $_POST[cuentagas]=number_format($cuentagas,2,".",",");
		 $_POST[cuentaing]=number_format($cuentaing,2,".",",");	 
		  	$aux=$iter;
	 		$iter=$iter2;
	 		$iter2=$aux;
		 }
		 
		 
		 echo "<tr class='$iter'><td >Diferencia:</td><td colspan='1'><input id='diferencia' name='diferencia' value='$_POST[diferencia]' readonly></td><td style='width:15%;'><input name='cuentaing' id='cuentaing' value='$_POST[cuentaing]' style='width:100%;' readonly><input name='cuentaing2' id='cuentaing2' value='$_POST[cuentaing2]' type='hidden'></td><td style='width:15%;'><input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' style='width:100%;' readonly><input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'><input id='letras' name='letras' value='$_POST[letras]' type='hidden'></td></tr>";
		?>
		</table></div>
    </form>
  <?php
  //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	if ($_POST[acuerdo]!="")
	 {
 	$nr="1";	
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		///***********insercion de las cuentas al ppto inicial
	switch($_POST[tipomov])
	{
	case 1: //Adiciones 
	 $sqlr="delete from pptoadiciones where cuenta='".$_POST[dcuentas][$x]."' and vigencia='$_POST[vigencia]'";	 
		mysql_query($sqlr,$linkbd); 
	 for($x=0;$x<count($_POST[dcuentas]);$x++)	
	  {
	  if ($_POST[dingresos][$x]=='0')
	    {
		 $valores=$_POST[dgastos][$x];
		}
		else
		 {
		  $valores=$_POST[dingresos][$x];
		 }
		 //*** eliminar anteriores registros para crear el nuevo ppto inicial de la vigencia
		
	 $sqlr="INSERT INTO pptoadiciones (cuenta,fecha,vigencia,valor,estado,pptodef,saldos,saldoscdprp,id_acuerdo)VALUES ('".$_POST[dcuentas][$x]."','".$fechaf."','$_POST[vigencia]', $valores,'S',$valores,$valores,$valores,$_POST[acuerdo])";
	 //echo "sqlr:".$sqlr;
  	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<script>alert('ERROR EN LA CREACION DEL PRESUPUESTO INICIAL');document.form2.fecha.focus();</script>";
		}
		  else
		  {
		   
			  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado el presupuesto inicial de la cuenta ".$_POST[dcuentas][$x]." con Exito</h2></center></td></tr></table>";
	    	  echo "<script>document.form2.acuerdo.value='';</script>";
		  	  echo "<script>document.form2.fecha.focus();</script>"; 
  		   }
		}   //****for
		break;		   
	 } //****switch
	 }//***if de acuerdo
 else
  {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Proceso</H2></center></td></tr></table>";
  echo "<script>document.form2.fecha.focus();</script>";  
  } 
 }//*** if de control de guardado
?> 
</td></tr>     
</table>
</body>
</html>