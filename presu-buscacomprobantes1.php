<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<meta http-equiv="expira" content="no-cache">
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/cssrefresh.js">
        <script type="text/javascript" src='botones.js'></script>
<script>
function pdf()
{
document.form2.action="pdfcmovppto.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}

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

function agregardetalle()
{
valordeb=quitarpuntos(document.form2.vlrdeb.value)	
valorcred=quitarpuntos(document.form2.vlrcre.value)
//alert('valor'+valordeb);
if(document.form2.cuenta.value!="" && document.form2.tercero.value!="" && document.form2.cc.value!="" && (valordeb>0 || valorcred>0))
 {
document.form2.agregadet.value=1;
document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

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

function adelante()
{
// alert("Balance Descuadrado");
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.fecha.value='';
document.form2.oculto.value=2;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.action="presu-buscacomprobantes.php";
document.form2.submit();
}
}

function atrasc()
{
   
//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {
document.form2.fecha.value='';
document.form2.oculto.value=2;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.action="presu-buscacomprobantes.php";
//alert("Balance Descuadrado");
document.form2.submit();
 }
}

function validar()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
document.form2.oculto.value=1;
document.form2.action="presu-buscacomprobantes.php";
document.form2.submit();
}

function validar3()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
//document.form2.oculto.value=2;
//document.form2.action="cont-buscacomprobantes.php";
document.form2.submit();
}

function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=2;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="presu-buscacomprobantes.php";
document.form2.submit();
}

function guardar()
{
//   alert("Balance Descuadrado");
valor=parseFloat(document.form2.diferencia.value);
if (valor==0 && document.form2.fecha.value!='')
 {
	if (confirm("Esta Seguro de Guardar"))
  {
document.form2.oculto.value=3;
document.form2.action="presu-buscacomprobantes.php";
document.form2.submit();
  }
 }
 else 
  {
   alert("Comprobante descuadrado o faltan informacion: "+valor);
  }
}

function duplicarcomp()
{
//   alert("Balance Descuadrado");
valor=parseFloat(document.form2.diferencia.value);
if (valor==0 && document.form2.fecha.value!='')
 {
	if (confirm("Esta Seguro de Duplicar el Comprobante"))
  {
document.form2.oculto.value=4;
document.form2.duplicar.value=2;
document.form2.action="presu-buscacomprobantes.php";
document.form2.submit();
  }
 }
 else 
  {
   alert("Comprobante descuadrado o faltan informacion: "+valor);
  }
}

function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }

function buscacc(e)
 {
if (document.form2.cc.value!="")
{
 document.form2.bcc.value='1';
 document.form2.submit();
 }
 }

function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }

function excell()
{
    //code
	document.form2.action="presu-buscacomprobantesexcel.php";
	document.form2.target="_BLANK";
	document.form2.submit(); 
	document.form2.action="";
	document.form2.target="";

}
</script>
		<?php titlepag();clearstatcache();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
  			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
      		<tr><?php menu_desplegable("presu");?></tr>
            <tr>
     			<td colspan="3" class="cinta">
					<a href="presu-comprobantes.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="presu-buscacomprobantes.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="duplicarcomp()" class="mgbt"><img src="imagenes/duplicar.png" title="Duplicar"></a>  
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir" title="Imprimir"></a> 
					<a href="#" onClick="excell()"><img src="imagenes/excel.png"  alt="excel" title="Excel"></a></td> 
     		</tr>
		</table>
<?php 
  $link=conectar_bd();
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
//echo "entro  dupli".$_POST[oculto];
    $sqlr="Select * from pptotipo_comprobante  where estado='S' and codigo=$_POST[tipocomprobantep] ";
	$res=mysql_query($sqlr,$link);
	//echo $sqlr;
	$r=mysql_fetch_row($res);
    $_POST[clasecomp]=$r[5];
	if($_POST[clasecomp]=='P')
	{
		$criterio=" and vigencia=$vigusu";
	}
	else
	{
		$criterio=" ";
	}
	if($_POST[oculto]=='1')
	{
	
		//echo "entro  dupli";
		// $_POST[fecha]="";
	 	$_POST[concepto]="";
	 	$_POST[total]="";
	 	$_POST[cuentadeb]="";
	 	$_POST[cuentacred]="";
	 	$_POST[diferencia]="";	 	 	 	 
	 	$_POST[estado]="";
		$link=conectar_bd();
		$sqlr="select * from pptocomprobante_cab where tipo_comp=$_POST[tipocomprobantep] ".$criterio." ORDER BY numerotipo DESC";
		$res=mysql_query($sqlr,$link);
		//echo $sqlr;
		$r=mysql_fetch_row($res);
	 	$_POST[maximo]=$r[0];
	 	$_POST[ncomp]=$r[0];
	 	$_POST[fecha]=$r[2];
 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 	$_POST[fecha]=$fechaf;
	 	$_POST[concepto]=$r[3];
	 	$_POST[total]=$r[4];
	 	$_POST[cuentadeb]=$r[5];
	 	$_POST[cuentacred]=$r[6];
	 	$_POST[diferencia]=$r[7];	 	 	 	 
		if($r[8]=='1')
		 $_POST[estadoc]='ACTIVO'; 	 				  
		 if($r[8]=='0')
		 $_POST[estadoc]='ANULADO'; 	
		 $_POST[estado]=$r[9];
	 	 
	 $_POST[dpcuentas]=array();
	 $_POST[dpncuentas]=array();
	 $_POST[dpterceros]=array();
	 $_POST[dpnterceros]=array();	 
	 $_POST[dccs]=array();		 
	 $_POST[dpdetalles]=array();

	 $_POST[dcreditos]=array();
	 $_POST[ddebitos]=array();
	 $idet=$_POST[tipocomprobantep];
	 $ndet=$_POST[ncomp];
	//$sqlr="select * from pptocomprobante_det where tipo_comp=$idet and numerotipo=$ndet  ".$criterio." order by cuenta";
	 $sqlr="select * from pptocomprobante_det where tipo_comp=$_POST[tipocomprobantep] and numerotipo=$ndet  ".$criterio." order by cuenta";
	$res2=mysql_query($sqlr,$link);	
	while($r2=mysql_fetch_row($res2))
	{
 $_POST[dpcuentas][]=$r2[1];
	 $nresul=buscacuentapres($r2[1]);
	 $_POST[dpncuentas][]=$nresul;
	 $_POST[dpterceros][]=$r2[2];	 
	 $_POST[dpdetalles][]=$r2[3];
//	 $_POST[dcheques][]=$_POST[cheque];
//		 $_POST[dcreditos][]=number_format($_POST[vlrcre],2,".","");
	//	 $_POST[ddebitos][]=number_format($_POST[vlrdeb],2,".","");
	 $_POST[dcreditos][]=$r2[5];
	 $_POST[ddebitos][]=$r2[4];
	}
	 //echo "NUEVO";	 	 
}
else
 {
  	 //$_POST[fecha]="";
	

  if($_POST[elimina]=='' && $_POST[agregadet]=='')
	  {
		   $_POST[concepto]="";
	 $_POST[total]="";
	 $_POST[cuentadeb]="";
	 $_POST[cuentacred]="";
	 $_POST[diferencia]="";	 	 	 	 
	 $_POST[estado]="";
	$sqlr="select * from pptocomprobante_cab where tipo_comp=$_POST[tipocomprobantep] and numerotipo=$_POST[ncomp] ".$criterio." ";
	$res=mysql_query($sqlr,$link);

	while($r=mysql_fetch_row($res))
	{
	if($_POST[oculto]==2)
	 {	
	 $_POST[fecha]=$r[2];
	 ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 $_POST[fecha]=$fechaf;	
	 }
	 $_POST[concepto]=$r[3];
	 $_POST[total]=$r[4];
	 $_POST[cuentadeb]=$r[5];
	 $_POST[cuentacred]=$r[6];
	 $_POST[diferencia]=$r[7];	 	 	 	 
	 $_POST[estado]=$r[8];	 
	 if($r[8]=='1')
		 {
		 $_POST[estadoc]='ACTIVO'; 	 
		 $color=" style='background-color:#009900 ;color:#fff'";				  
		 }
		 if($r[8]=='0')
		 {
		 $_POST[estadoc]='ANULADO'; 
		 	$color=" style='background-color:#aa0000 ; color:#fff'";	
		 }
	}
	  }
 	 $idet=$_POST[tipocomprobantep]." ".$_POST[ncomp];
	 if($_POST[elimina]=='' && $_POST[agregadet]=='')
	  {
	$_POST[dpcuentas]=array();
	 $_POST[dpncuentas]=array();
	 $_POST[dpterceros]=array();
	 $_POST[dpnterceros]=array();	 	 
	 $_POST[dpdetalles]=array();
//	 $_POST[dcheques][]=$_POST[cheque];
//		 $_POST[dcreditos][]=number_format($_POST[vlrcre],2,".","");
	//	 $_POST[ddebitos][]=number_format($_POST[vlrdeb],2,".","");
	 $_POST[dcreditos]=array();
	 $_POST[ddebitos]=array();
	$sqlr="select * from pptocomprobante_det where tipo_comp=$_POST[tipocomprobantep] and numerotipo=$_POST[ncomp] ".$criterio." order by cuenta";
	
	
	$res2=mysql_query($sqlr,$link);	
	while($r2=mysql_fetch_row($res2))
	{
	 $_POST[dpcuentas][]=$r2[1];
	 $nresul=buscacuentapres($r2[1]);
	 $_POST[dpncuentas][]=$nresul;
	 $_POST[dpterceros][]=$r2[2];	 
	 $_POST[dpdetalles][]=$r2[3];
//	 $_POST[dcheques][]=$_POST[cheque];
//		 $_POST[dcreditos][]=number_format($_POST[vlrcre],2,".","");
	//	 $_POST[ddebitos][]=number_format($_POST[vlrdeb],2,".","");
	 $_POST[dcreditos][]=$r2[5];
	 $_POST[ddebitos][]=$r2[4];
	}
	  }
	// echo "RECARGADO";
 }
?>
  <form name="form2" method="post" action="">
<?php
			//**** busca cuenta
  			if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
			 
			 //**** busca centro costo
  			if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncc]="";
			  }
			 }
			 ?>

  	<table class="inicio" width="99%">
        <tr>
          	<td class="titulos" colspan="9">Comprobantes          </td>
          	<td width="287" class="cerrar" >
          		<a href="cont-principal.php">Cerrar</a>
          	</td>
        </tr>
        <tr>
		   	<td style="width:10%;" class="saludo1" >Tipo Comprobante:          </td>
          	<td style="width:25%;" >
          		<select name="tipocomprobantep" style="width:100%;" onKeyUp='return tabular(event,this)' onChange="validar()">
		  			<option value="-1">Seleccion Tipo Comprobante</option>	  
				   	<?php
				   		$link=conectar_bd();
		  		   		$sqlr="Select * from pptotipo_comprobante  where estado='S' order by nombre";
						// echo $sqlr;
				 		$resp = mysql_query($sqlr,$link);
						while ($row =mysql_fetch_row($resp)) 
						{
							$i=$row[3];
							echo "<option value=$row[3] ";
							if($i==$_POST[tipocomprobantep])
					 		{
							 	$_POST[ntipocomp]=$row[1];
						  		$_POST[clasecomp]=$row[5];
						 		echo "SELECTED";
						 	}
							echo " >".$row[1]."</option>";	  
					    }			
				  	?>
		  		</select>
		  		<input name="clasecomp" type="hidden" value="<?php echo $_POST[clasecomp]?>">
		  	</td>
		  	<td style="width:2%;" class="saludo1" >No:          </td>
		  	<td style="width:10%;" >
		  		<input type="hidden" name="ntipocomp" value="<?php echo $_POST[ntipocomp]?>">
            	<a href="#" onClick="atrasc()">
            		<img src="imagenes/back.png" alt="anterior" align="absmiddle">
            	</a>
         		<input type="text" name="ncomp" style="width:50%;" onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) " onBlur="validar2()" >
         		<input type="hidden" value="a" name="atras" >
         		<input type="hidden" value="s" name="siguiente" >
         		<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">            
         		<a href="#" onClick="adelante()">
         			<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
         		</a>          
         	</td>
          	<td style="width:5%;" class="saludo1" >Fecha: </td>
          	<td style="width:15%;">
          		<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:80%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
          		<a href="#" onClick="displayCalendarFor('fc_1198971545');">
          			<img src="imagenes/buscarep.png" align="absmiddle" border="0">
          		</a>          
          	</td>
          	<td style="width:5%;" class="saludo1">Estado:          </td>
          	<td colspan="2">
          		<input type="hidden" id="duplicar" name="duplicar"  value="<?php echo $_POST[duplicar]; ?>" readonly>
          		<input type="hidden" id="oculto" name="oculto"  value="<?php echo $_POST[oculto]; ?>" readonly>
          		<input type="hidden" name="estado"  value="<?php echo $_POST[estado]; ?>" readonly>
          		<?php 
	                if($_POST[estadoc]=="ACTIVO"){
				       	$valuees="ACTIVO";
				       	$stylest="width:50%; background-color:#0CD02A; color:white; text-align:center;";
				    }else if($_POST[estadoc]=="ANULADO"){
				       	$valuees="ANULADO";
				      	$stylest="width:50%; background-color:#FF0000; color:white; text-align:center;";
				    }else if($_POST[estadoc]=="PAGO"){
				       	$valuees="PAGO";
				      	$stylest="width:50%; background-color:#0404B4; color:white; text-align:center;";
				                    }

				                    echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
                  				?>
          		
          	</td>
          	<td></td>
        </tr>
    	<tr>
          	<td class="saludo1">Concepto:          </td>
          	<td colspan="3" >
				<input type="text" name="concepto" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[concepto]; ?>">          
			</td>
          	<td style="width:5%;" class="saludo1">Vigencia:          </td>
          	<td style="width:15%;" >
          		<input type="text" name="total" onKeyUp="return tabular(event,this)" style="width:35%;" value="<?php echo $_POST[total]; ?>" readonly >          
          	</td>
        </tr>
    </table>

	<div class="subpantallac5" style="height:63.5%; width:99.6%; overflow-x:hidden;">
	    <table class="inicio" width="99%">
        	<tr>
         	 	<td class="titulos" colspan="7">Detalle Comprobantes          </td>
        	</tr>
			<tr>
				<td class="titulos2" >Cuenta</td>
				<td class="titulos2" >Nombre Cuenta</td>
				<td class="titulos2" >Tercero</td>
				<td class="titulos2" >Nom Tercero</td>
				<td class="titulos2" >Detalle</td>
				<td class="titulos2" >Aumenta</td>
				<td class="titulos2" >Disminuye</td></tr>
					<?php 
						if ($_POST[elimina]!='')
					 	{ 
					 		//echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
					 		$posi=$_POST[elimina];
					  		$cuentacred=0;
					  		$cuentadeb=0;
					   		$diferencia=0;

					 		unset($_POST[dpcuentas][$posi]);
			 		 		unset($_POST[dpncuentas][$posi]);
					 		unset($_POST[dpterceros][$posi]);
					 		unset($_POST[dpnterceros][$posi]);		 
					 		unset($_POST[dpdetalles][$posi]);
					 		unset($_POST[dcheques][$posi]);
					 		unset($_POST[dcreditos][$posi]);		 		 		 		 		 
					 		unset($_POST[ddebitos][$posi]);		 
					 		$_POST[dpcuentas]= array_values($_POST[dpcuentas]); 
					 		$_POST[dpncuentas]= array_values($_POST[dpncuentas]); 
					 		$_POST[dpterceros]= array_values($_POST[dpterceros]); 		 		 
					 		$_POST[dpnterceros]= array_values($_POST[dpnterceros]); 		 		 		 
					 		$_POST[dpdetalles]= array_values($_POST[dpdetalles]); 
					 		$_POST[dcheques]= array_values($_POST[dcheques]); 
					 		$_POST[dcreditos]= array_values($_POST[dcreditos]); 
					 		$_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
					 	}
						if ($_POST[agregadet]=='1')
					 	{
					  		$cuentacred=0;
					  		$cuentadeb=0;
					  		$diferencia=0;
					 		$_POST[dpcuentas][]=$_POST[cuenta];
					 		$_POST[dpncuentas][]=$_POST[ncuenta];
					 		$_POST[dpterceros][]=$_POST[tercero];
					 		$_POST[dpnterceros][]=$_POST[ntercero];	 
					 		$_POST[dpdetalles][]=$_POST[detalle];
					 		$_POST[dcheques][]=$_POST[cheque];
							//		 $_POST[dcreditos][]=number_format($_POST[vlrcre],2,".","");
							//	 $_POST[ddebitos][]=number_format($_POST[vlrdeb],2,".","");
							// $_POST[vlrcre]=str_replace(".","",$_POST[vlrcre]);
				 			//$_POST[vlrdeb]=str_replace(".","",$_POST[vlrdeb]);
				 			$_POST[vlrcre]=str_replace(",",".",$_POST[vlrcre]);
				 			$_POST[vlrdeb]=str_replace(",",".",$_POST[vlrdeb]);
				 			$_POST[dcreditos][]=$_POST[vlrcre];
					 		$_POST[ddebitos][]=$_POST[vlrdeb];
					 		$_POST[agregadet]=0;
					?>
				 	<script>
				  		//document.form2.cuenta.focus();	
						document.form2.cuenta.select();
						document.form2.cuenta.value="";
				 	</script>
		  			<?php
						/*	$_POST[cuenta]='';
							$_POST[ncuenta]='';
							$_POST[tercero]='';
							$_POST[cc]='';		 
						    $_POST[detalle]='';
							$_POST[cheque]='';
							$_POST[vlrcre]='';
							$_POST[vlrdeb]='';*/
		  				}
		 					//  echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		  
/*		  		  			$i=0;
							$vc=array();
							Foreach ($_SESSION[creditos] as $valor)
							{
							$vd=$valor;
							$vc[$i]=$vd;
							//$_SESSION["cods"][$i] =$vd;
							$i+=1;
							}		 		 */
		 					//echo "<input name='cuentas[]' type='hidden' value='$_POST[cuenta]'>";
		 					//echo "C".count($_POST[dpcuentas]);
		 				$iter="saludo1";
		 				$iter2="saludo2";		 
		 				for ($x=0;$x< count($_POST[dpcuentas]);$x++)
		 				{
							echo "<tr class=$iter>
									<td >
										<input name='dpcuentas[]' value='".$_POST[dpcuentas][$x]."' type='text' size='20' readonly>
									</td>
									<td >
										<input name='dpncuentas[]' value='".ucfirst(strtolower($_POST[dpncuentas][$x]))."' type='text' size='55' readonly>
									</td>
									<td >
										<input name='dpterceros[]' value='".$_POST[dpterceros][$x]."' type='text' size='10' readonly>
									</td>
									<td >
										<input name='dpnterceros[]' value='".buscatercero($_POST[dpterceros][$x])."' type='text' size='20' readonly>
									</td>
									<td >
										<input name='dpdetalles[]' value='".ucfirst(strtolower($_POST[dpdetalles][$x]))."' type='text' size='35' onDblClick='llamarventana(this,$x)' onBlur='validar3()' onKeyUp='return tabular(event,this)'>
									</td>
									<td >
										<input name='ddebitos[]' value='".number_format($_POST[ddebitos][$x],2)."' type='text' size='10' onDblClick='llamarventanadeb(this,$x)' onBlur='validar3()' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)'>
									</td>
									<td>
										<input name='dcreditos[]' value='".number_format($_POST[dcreditos][$x],2)."' type='text' size='10' onDblClick='llamarventanacred(this,$x)' onBlur='validar3()' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)'>
									</td>
								</tr>";
//		 $cred= $vc[$x]*1;
		 $cred=$_POST[dcreditos][$x];
		 $deb=$_POST[ddebitos][$x];
//		 $cred=number_format($cred,2,".","");
	//	 $deb=number_format($deb,2,".","");
		 $cred=$cred;
		 $deb=$deb;		 
		 $cuentacred=$cuentacred+$cred;
		 $cuentadeb=$cuentadeb+$deb;		 
		 $diferencia=$cuentadeb-$cuentacred;
		 $total=number_format($total,2,",","");
		 $_POST[diferencia]=$diferencia;
		 $_POST[diferencia2]=number_format($diferencia,2,".",",");
 		 $_POST[cuentadeb]=number_format($cuentadeb,2,".",",");
		 $_POST[cuentadeb2]=$cuentadeb;
		 $_POST[cuentacred]=number_format($cuentacred,2,".",",");	 
		 $_POST[cuentacred2]=$cuentacred;
		 $aux=$iter2;
		 $iter2=$iter;
		 $iter=$aux;
		 }
		 echo "<tr><td></td><td></td><td >Diferencia:</td><td colspan='1'><input type='hidden' id='diferencia' name='diferencia' value='$_POST[diferencia]' ><input id='diferencia2' name='diferencia2' value='$_POST[diferencia2]' type='text' readonly></td><td>Totales:</td><td class='saludo2'><input name='cuentadeb2' type='hidden' id='cuentadeb2' value='$_POST[cuentadeb2]'><input name='cuentadeb' id='cuentadeb' value='$_POST[cuentadeb]' readonly></td><td class='saludo2'><input id='cuentacred' name='cuentacred' value='$_POST[cuentacred]' readonly><input id='cuentacred2' type='hidden' name='cuentacred2' value='$_POST[cuentacred2]' ></td></tr>";
		?>
		</table>  
		</div> 
	  </form>
 
</body>
</html>