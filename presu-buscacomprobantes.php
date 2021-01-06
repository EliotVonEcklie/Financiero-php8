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
        <script type="text/javascript" ='botones.js'></script>
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

 if(document.form2.posicion.value==''){
	 document.form2.posicion.value=0;
 }
if(parseInt(document.form2.posicion.value)>0)
 {
	 
document.form2.fecha.value='';
document.form2.oculto.value=2;
document.form2.posicion.value=parseInt(document.form2.posicion.value)-1;
document.form2.action="presu-buscacomprobantes.php";
document.form2.submit();
}

}

function atrasc()
{
if(document.form2.posicion.value==''){
	 document.form2.posicion.value=0;
 }
if(parseInt(document.form2.posicion.value)<parseInt(document.form2.maximo.value)-1)
 {
	 
	document.form2.fecha.value='';
	document.form2.oculto.value=2;
	document.form2.posicion.value=parseInt(document.form2.posicion.value)+1;
	document.form2.action="presu-buscacomprobantes.php";
	document.form2.submit();
 }

}

function validar()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
document.form2.oculto.value=1;
document.form2.action="presu-buscacomprobantes.php";
//alert($oculto);
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
document.form2.oculto.value=3;
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
function refresh(){
	document.form2.oculto.value=2;
	document.form2.action="presu-buscacomprobantesexcel.php";
	document.form2.submit();
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
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="duplicarcomp()" class="mgbt"><img src="imagenes/duplicar.png" title="Duplicar"></a>  
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir" title="Imprimir"></a> 
					<a href="#" onClick="excell()"><img src="imagenes/excel.png"  alt="excel" title="Excel"></a>
				</td>
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
	$globa='1';
    //echo "Oculto inicial:"; 
    //echo "-".$_POST[tipocomprobantep]."<br>";

	if($_POST[clasecomp]=='P')
	{
		$criterio=" AND TB1.vigencia=$vigusu";
	}
	else
	{
		$criterio=" ";
	}

	
	if(!empty($_POST[posicion])){
		$posicion=$_POST[posicion];
	}else{
		$posicion=0;
	}
	$valor=$_POST[arregloact][$posicion];
	$_POST[ncomp]=$valor;
			
	// NO USA LAS FLECHAS
	if($_POST[oculto]=='1')
	{	
	 	$_POST[concepto]="";
	 	$_POST[total]="";
	 	$_POST[cuentadeb]="";
	 	$_POST[cuentacred]="";
	 	$_POST[diferencia]="";	 	 	 	 
	 	$_POST[estado]="";
		$link=conectar_bd();

		// APROPIACIÓN ADICIONES - FLECHAS: NO
		if($_POST[tipocomprobantep]=='2')
		{
			$_POST[arregloact]=array();
			$sqlr="select * from pptoacuerdos where vigencia='$vigusu' ORDER BY id_acuerdo DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[0]; // id acuerdo 			
			}
			$sqlr="select * from pptoacuerdos where vigencia='$vigusu' ORDER BY id_acuerdo DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[0];  // id acuerdo 
			$_POST[fecha]=$r[3];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[2]; // numero acuerdo 
			$_POST[total]=$r[4]; // vigencia 
		 	$_POST[estado]=$r[9];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoadiciones where vigencia='$vigusu' and id_acuerdo='".$r[0]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];	// cuenta 
				$nresul=buscacuentapres($r2[4]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';
				$_POST[dpdetalles][]='';
				if($r2[7]=='G')				// tipo
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[5];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}

		// APROPIACIÓN INICIAL - FLECHAS: NO
		if($_POST[tipocomprobantep]=='1') // problema con id acuerdo
			
		{
			$_POST[arregloact]=array();
			$sqlr="select * from pptocuentaspptoinicial TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo GROUP BY TB2.id_acuerdo ORDER BY TB2.id_acuerdo DESC";
			//echo $sqlr; echo "<br>";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[8]; // id acuerdo 			
			}

			$sqlr="select * from pptocuentaspptoinicial TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo ORDER BY TB2.id_acuerdo DESC";
			//echo $sqlr; 
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
		 	$_POST[ncomp]=$r[8];  // id acuerdo 
			$_POST[fecha]=$r[1];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
			$_POST[concepto]=$r[15]; // numero acuerdo 
			$_POST[total]=$r[2]; // vigencia 
		 	
		 	
			$_POST[estado]=$r[4];	// estado 

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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptocuentaspptoinicial where id_acuerdo='".$r[8]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[0];	// cuenta 
				$nresul=buscacuentapres($r2[0]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';
				$_POST[dpdetalles][]='';
				if($r2[23]=='G')				// tipo
				{
					$_POST[ddebitos][]='';
					$_POST[dcreditos][]=$r2[3]; // valor 
				}
				else
				{
					$_POST[ddebitos][]=$r2[3];  // valor 
					$_POST[dcreditos][]='';
				}
			}
		}

		// APROPIACIÓN REDUCCIONES  - FLECHAS: NO
		if($_POST[tipocomprobantep]=='3') // flecha adelante no sirve, segunda iteracion no sirve 
		{
			$_POST[arregloact]=array();
			$sqlr="select * from pptoreducciones TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo GROUP BY TB2.id_acuerdo ORDER BY TB1.id_acuerdo DESC";
			//echo $sqlr; echo "<br>";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[1]; // id acuerdo 			
			}
			$sqlr="select * from pptoreducciones TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo ".$criterio." ORDER BY TB1.id_acuerdo DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[1];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;	
			$_POST[concepto]=$r[11]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
		 	
			$_POST[estado]=$r[6];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoreducciones where id_acuerdo='".$r[1]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];	// cuenta 
				$nresul=buscacuentapres($r2[4]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';
				$_POST[dpdetalles][]='';
				if($r2[7]=='G')				// tipo
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[5];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}

		// APROPIACION TRASLADO  - FLECHAS: NO
		if($_POST[tipocomprobantep]=='5') // flecha adelante no sirve 
		{
			$_POST[arregloact]=array();
			$sqlr="select * from pptotraslados TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo GROUP BY TB2.id_acuerdo ORDER BY TB2.id_acuerdo DESC";
			//echo $sqlr; echo "<br>";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[1]; // id acuerdo 			
			}
			$sqlr="select * from pptotraslados TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo ".$criterio." ORDER BY id_traslados DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[1];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[10]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
		 	
			$_POST[estado]=$r[6];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptotraslados where id_acuerdo='".$r[1]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];	// cuenta 
				$nresul=buscacuentapres($r2[4]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';
				$_POST[dpdetalles][]='';
				if($r2[7]=='C')				// tipo
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[5];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}

		// CUENTA POR PAGAR  - FLECHAS: NO
		if($_POST[tipocomprobantep]=='8')
		{ 	
			$_POST[arregloact]=array();
			$sqlr="select * from tesoordenpago TB1,tesoordenpago_det TB2, pptocuentas TB3 where TB1.id_orden=TB2.id_orden AND TB2.cuentap=TB3.cuenta  GROUP BY TB2.id_orden ORDER BY TB1.id_orden DESC";
			//echo $sqlr; echo "<br>";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[0]; // id acuerdo 			
			}

			$sqlr="select * from tesoordenpago TB1,tesoordenpago_det TB2, pptocuentas TB3 where  TB1.id_orden=TB2.id_orden AND TB2.cuentap=TB3.cuenta ORDER BY TB1.id_orden DESC";
			//echo $sqlr; 
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
		 	$_POST[ncomp]=$r[0];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
			$_POST[concepto]=$r[7]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
			$_POST[estado]=$r[13];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from tesoordenpago_det where id_orden='".$r[0]."' order by cuentap";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[2];	// cuenta  21 
				$nresul=buscacuentapres($r2[2]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]=$r[6];
				$_POST[dpdetalles][]='';  
				
				if($r2[6]=='201')		
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[4]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[4];  // valor 
					$_POST[ddebitos][]='';
				}	
				
			}
		}

		// CUENTA POR PAGAR NOMINA  - FLECHAS: NO
		if($_POST[tipocomprobantep]=='9')
		{
			$_POST[arregloact]=array();
			$sqlr="select * from pptotraslados TB1, pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo".$criterio."";
			//echo $sqlr; echo "<br>";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[1]; // id acuerdo 			
			}
			$sqlr="select * from pptoadiciones where id_acuerdo='".$r[1]."' order by cuenta";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[1];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[10]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
		 	$_POST[cuentadeb]=$r[5];	// valor
		 	$_POST[cuentacred]=$r[6];	// estado 
		 	$_POST[diferencia]=$r[7];	// tipo 
		 	$estad='';
			if($r[6]=='S'){$_POST[estadoc]='ACTIVO'; $estad='and estado!=0';}
			else{$_POST[estadoc]='ANULADO';}
			$_POST[estado]=$r[6];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptotraslados where id_acuerdo='".$r[1]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];	// cuenta 
				$nresul=buscacuentapres($r2[4]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';
				$_POST[dpdetalles][]='';
				if($r2[7]=='C')				// tipo
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[5];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// DISPONIBILIDAD - FLECHAS: NO
		if($_POST[tipocomprobantep]=='6') // consvigencia conflicto 
		{
			$_POST[arregloact]=array();
			$sqlr="select * from pptocdp where vigencia='$vigusu' ORDER BY consvigencia DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[2]; // id acuerdo 			
			}
			$sqlr="select * from pptocdp where vigencia='$vigusu' ORDER BY consvigencia DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[2];  // id acuerdo 
			$_POST[fecha]=$r[3];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[7]; // numero acuerdo 
			$_POST[total]=$r[1]; // vigencia 
		 	
			$_POST[estado]=$r[5];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptocdp_detalle where vigencia='$vigusu' and consvigencia='".$r[2]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[3];	// cuenta 
				$nresul=buscacuentapres($r2[3]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';
				$_POST[dpdetalles][]='';
				if($r2[9]=='201')				// tipo
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[5];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}

		// EGRESO - FLECHAS: NO
		if($_POST[tipocomprobantep]=='11')
		{ 
			$_POST[arregloact]=array();
			$sqlr="select * from tesoegresos TB1,tesoordenpago_det TB2, configbasica TB3 where  TB1.id_orden=TB2.id_orden GROUP BY TB2.id_orden ORDER BY TB1.id_egreso DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[0]; // id acuerdo 			
			}
			$sqlr="select * from tesoegresos TB1,tesoordenpago_det TB2 where  TB1.id_orden=TB2.id_orden ".$criterio." ORDER BY TB1.id_egreso DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[0];  // id acuerdo 
			$_POST[fecha]=$r[3];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[8]; // numero acuerdo 
			$_POST[total]=$r[4]; // vigencia 
		 	$_POST[estado]=$r[13];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from tesoordenpago_det where id_orden='".$r[2]."' order by cuentap";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[2];	// cuenta 
				$nresul=buscacuentapres($r2[2]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]=$r[11];
				$_POST[dpdetalles][]='';
				if($r2[6]=='201')				// tipo
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[4]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[4];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}

		// EGRESO NOMINA - FLECHAS: NO
		if($_POST[tipocomprobantep]=='10')
		{
			$sqlr="select * from pptorecibopagoegresoppto TB1, pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo ".$criterio."";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[1];
		 	$_POST[ncomp]=$r[1];
		 	$_POST[fecha]=$r[2];
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[10];
		 	$_POST[total]=$r[3];
		 	
		 
		 	$_POST[cuentadeb]=$r[5];
		 	$_POST[cuentacred]=$r[6];
		 	$_POST[diferencia]=$r[7];
		 	$estad='';
			if($r[6]=='S'){$_POST[estadoc]='ACTIVO'; $estad='and estado!=0';}
			else{$_POST[estadoc]='ANULADO';}
			$_POST[estado]=$r[6];


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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoadiciones where id_acuerdo='".$r[1]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];
				$nresul=buscacuentapres($r2[4]);
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';	 
				$_POST[dpdetalles][]='';
				if($r2[7]=='G')
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5];
				}
				else
				{
					$_POST[dcreditos][]=$r2[5];
					$_POST[ddebitos][]='';
				}
				
			}
		}
		
		// EGRESO SSF - FLECHAS: NO

		if($_POST[tipocomprobantep]=='13')
		{
			$_POST[arregloact]=array();
			$sqlr="select * from tesossfegreso_cab TB1,tesossfegreso_det TB2 where TB1.id_orden=TB2.id_egreso GROUP BY TB2.id_egreso ORDER BY TB1.id_orden DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[0]; // id acuerdo 			
			}
			$sqlr="select * from tesossfegreso_cab TB1,tesossfegreso_det TB2 where TB1.id_orden=TB2.id_egreso ".$criterio." ORDER BY TB1.id_orden DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[0];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[7]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
		 	$_POST[estado]=$r[13];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from tesossfegreso_det where id_egreso='".$r[0]."' order by cuentap";
			$res2=mysql_query($sqlr,$link);	

			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[2];	// cuenta 
				$nresul=buscacuentapres($r2[2]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]=$r[6];	// tercero
				$_POST[dpdetalles][]='';
				if($r2[6]=='S')				// tipo
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[4]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[4];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// INCORPORACIONES MANUAL - FLECHAS: NO

		if($_POST[tipocomprobantep]=='22')
		{	
			$sqlr="select * from pptoegressf TB1, pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo ".$criterio."";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[1];
		 	$_POST[ncomp]=$r[1];
		 	$_POST[fecha]=$r[2];
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[10];
		 	$_POST[total]=$r[3];
		 	
		 	$_POST[cuentadeb]=$r[5];
		 	$_POST[cuentacred]=$r[6];
		 	$_POST[diferencia]=$r[7];
		 	$estad='';
			if($r[6]=='S'){$_POST[estadoc]='ACTIVO'; $estad='and estado!=0';}
			else{$_POST[estadoc]='ANULADO';}
			$_POST[estado]=$r[6];


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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoadiciones where id_acuerdo='".$r[1]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];
				$nresul=buscacuentapres($r2[4]);
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';	 
				$_POST[dpdetalles][]='';
				if($r2[7]=='G')
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5];
				}
				else
				{
					$_POST[dcreditos][]=$r2[5];
					$_POST[ddebitos][]='';
				}
				
			}
		}
		
		// INGRESO SSF - FLECHAS: NO

		if($_POST[tipocomprobantep]=='21')
		{
			$_POST[arregloact]=array();
			$sqlr="select * from tesossfingreso_cab ORDER BY id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[0]; // id acuerdo 			
			}
			$sqlr="select * from tesossfingreso_cab ".$criterio." ORDER BY id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[0];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[4]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
		 	$_POST[estado]=$r[8];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoingssf where idrecibo='".$r[0]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	

			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[1];	// cuenta 
				$nresul=buscacuentapres($r2[1]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				//$_POST[dpterceros][]=$r[5];	// tercero
				$_POST[dpdetalles][]='';
				if($r[8]=='S')				// tipo
				{
					$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[3]; // valor 
				}
				else if($r[8]=='N')
				{
					$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]=$r2[3];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// INGRESOS INTERNOS - FLECHAS: NO

		if($_POST[tipocomprobantep]=='18')
		{ 
			$_POST[arregloact]=array();
			$sqlr="select *from tesosinreciboscaja,tesosinrecaudos where tesosinrecaudos.id_recaudo=tesosinreciboscaja.id_recaudo ORDER BY tesosinrecaudos.id_recibos DESC";
			echo $sqlr;
			//$sqlr="select * from tesossfingreso_cab ORDER BY id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[0]; // id acuerdo 			
			}
			$sqlr="select *from tesosinreciboscaja,tesosinrecaudos where tesosinrecaudos.id_recaudo=tesosinreciboscaja.id_recaudo ".$criterio." ORDER BY tesosinrecaudos.id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[0];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[17]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
		 	$_POST[estado]=$r[9];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptosinrecibocajappto where idrecibo='".$r[4]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	 

			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[1];	// cuenta 
				$nresul=buscacuentapres($r2[1]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				//$_POST[dpterceros][]=$r[5];	// tercero
				$_POST[dpdetalles][]='';
				if($r[9]=='S')				// tipo
				{
					$_POST[dpterceros][]=$r[15];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[3]; // valor 
				}
				else if($r[9]=='N')
				{
					$_POST[dpterceros][]=$r[15];
					$_POST[dcreditos][]=$r2[3];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// INGRESOS RECIBOS CAJA - FLECHAS: NO

		if($_POST[tipocomprobantep]=='16')
		{
			$_POST[arregloact]=array();
			$sqlr="select *from tesoreciboscaja ORDER BY id_recibos DESC";
			echo $sqlr;
			//$sqlr="select * from tesossfingreso_cab ORDER BY id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[0]; // id acuerdo 			
			}
			$sqlr="select *from tesoreciboscaja ".$criterio." ORDER BY id_recibos DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[0];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[11]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
		 	$_POST[estado]=$r[9];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptorecibocajappto where idrecibo='".$r[0]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	 

			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[1];	// cuenta 
				$nresul=buscacuentapres($r2[1]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpdetalles][]='';
				if($r[9]=='S')				// tipo
				{
					//$_POST[dpterceros][]=$r[15];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[3]; // valor 
				}
				else if($r[9]=='N')
				{
					//$_POST[dpterceros][]=$r[15];
					$_POST[dcreditos][]=$r2[3];  // valor 
					$_POST[ddebitos][]='';
				}
			}	
		}
		
		// NOTAS BANCARIAS - FLECHAS: NO

		if($_POST[tipocomprobantep]=='20')
		{
			$sqlr="select * from tesonotasbancarias_det TB1, pptoacuerdos TB2 where  TB1.id_notabandet=TB2.id_acuerdo";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[1];
		 	$_POST[ncomp]=$r[1];
		 	$_POST[fecha]=$r[2];
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[10];
		 	$_POST[total]=$r[3];
		 	
		 	$_POST[cuentadeb]=$r[5];
		 	$_POST[cuentacred]=$r[6];
		 	$_POST[diferencia]=$r[7];
		 	$estad='';
			if($r[6]=='S'){$_POST[estadoc]='ACTIVO'; $estad='and estado!=0';}
			else{$_POST[estadoc]='ANULADO';}
			$_POST[estado]=$r[6];


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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoadiciones where id_acuerdo='".$r[1]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];
				$nresul=buscacuentapres($r2[4]);
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';	 
				$_POST[dpdetalles][]='';
				if($r2[7]=='G')
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5];
				}
				else
				{
					$_POST[dcreditos][]=$r2[5];
					$_POST[ddebitos][]='';
				}
				
			}
		}
		
		// PRESUPUESTO CIERRE - FLECHAS: NO

		if($_POST[tipocomprobantep]=='12')
		{

		}
		
		// RECAUDOS TRANSFERENCIAS - FLECHAS: NO

		if($_POST[tipocomprobantep]=='19')
		{
			$_POST[arregloact]=array();
			$sqlr="select *from tesorecaudotransferencia ORDER BY id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[0]; // id acuerdo 			
			}
			$sqlr="select *from tesorecaudotransferencia ".$criterio." ORDER BY id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[0];  // id acuerdo 
			$_POST[fecha]=$r[2];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[6]; // numero acuerdo 
			$_POST[total]=$r[3]; // vigencia 
		 	$_POST[estado]=$r[10];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoingtranppto where idrecibo='".$r[0]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	 

			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[1];	// cuenta 
				$nresul=buscacuentapres($r2[1]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpdetalles][]='';
				if($r[10]=='S')				// tipo
				{
					$_POST[dpterceros][]=$r[7];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[3]; // valor 
				}
				else if($r[10]=='N')
				{
					$_POST[dpterceros][]=$r[7];
					$_POST[dcreditos][]=$r2[3];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// REGISTROS - FLECHAS: NO

		if($_POST[tipocomprobantep]=='7')
		{
			$_POST[arregloact]=array();
			//$sqlr="select *from tesosinreciboscaja,tesosinrecaudos where tesosinrecaudos.id_recaudo=tesosinreciboscaja.id_recaudo ORDER BY tesosinrecaudos.id_recaudo DESC";

			$sqlr="select * from pptorp where vigencia='$vigusu' ORDER BY consvigencia DESC";
			$res=mysql_query($sqlr,$link);
			$max=mysql_num_rows($res);
			$_POST[maximo]=$max; 
			while($row=mysql_fetch_row($res)){
				$_POST[arregloact][]=$row[1]; // id acuerdo 			
			}
			$sqlr="select * from pptorp where vigencia='$vigusu' ORDER BY consvigencia DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$_POST[ncomp]=$r[1];  // id acuerdo 
			$_POST[fecha]=$r[4];  // fecha 
	 		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;		// fecha
			$_POST[concepto]=$r[11]; // numero acuerdo 
			$_POST[total]=$r[0]; // vigencia 
		 	$_POST[estado]=$r[3];	// estado 
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			
			$sqlr="Select * from pptorp_detalle  where vigencia='$vigusu' and consvigencia='".$r[1]."' order by CUENTA";
			$res2=mysql_query($sqlr,$link);	 

			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[3];	// cuenta 
				$nresul=buscacuentapres($r2[3]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				//$_POST[dpterceros][]=$r[5];	// tercero
				$_POST[dpdetalles][]='';
				if($r[3]=='S')				// tipo
				{
					$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor 
				}
				else if($r[3]=='N')
				{
					$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]=$r2[5];  // valor 
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// RESERVAS PRESUPUESTALES - FLECHAS: NO

		if($_POST[tipocomprobantep]=='15')
		{	

		}
		
		// RETENCIONES PAGOS - FLECHAS: NO

		if($_POST[tipocomprobantep]=='17')
		{
						
		}
		
		// VIGENCIAS FUTURAS - FLECHAS: NO

		if($_POST[tipocomprobantep]=='14')
		{
			
		}
		
	}
	
	// FLECHA HACIA LOS LADOS 
	if($_POST[oculto]=='2')		// variable oculto igual a 2
	{
		//echo "aa";
		$_POST[concepto]="";
	 	$_POST[total]="";
	 	$_POST[cuentadeb]="";
	 	$_POST[cuentacred]="";
	 	$_POST[diferencia]="";	 	 	 	 
	 	$_POST[estado]="";
		$link=conectar_bd();
		
		// Apropiación Adiciones
		if($_POST[tipocomprobantep]=='2')
		{
			$sqlr="select * from pptoacuerdos where vigencia='$vigusu' and id_acuerdo='$_POST[ncomp]' ORDER BY id_acuerdo DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	$a=$_POST[fecha]=$r[3];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[2];	// numero acuerdo
			$_POST[total]=$r[4];		// vigencia 
			$_POST[estado]=$r[9];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoadiciones where vigencia='$vigusu' and id_acuerdo='".$r[0]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];		// cuenta  
				$nresul=buscacuentapres($r2[4]); // cuenta 
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';	 
				$_POST[dpdetalles][]='';
				if($r2[7]=='G')		// tipo  
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor 
				}
				else
				{
					$_POST[dcreditos][]=$r2[5]; // valor 
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// Apropiación Inicial
		if($_POST[tipocomprobantep]=='1')
		{	
			$sqlr="select * from pptocuentaspptoinicial TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo AND TB1.id_acuerdo='$_POST[ncomp]'";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	$a=$_POST[fecha]=$r[1];
			
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[15];
			$_POST[total]=$r[2];		// vigencia 
					 	
			$_POST[estado]=$r[4];		// estado
			
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
			
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			
			$sqlr="select * from pptocuentaspptoinicial where id_acuerdo='".$r[8]."' order by cuenta"; // id_acuerdo primer tabla 
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[0];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[0]); // cuenta
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';	 
				$_POST[dpdetalles][]='';
				
				if($r2[23]=='G')		// tipo primera tabla 
				{
					$_POST[ddebitos][]='';
					$_POST[dcreditos][]=$r2[3]; // valor segunda tabla
				}
				else
				{
					$_POST[ddebitos][]=$r2[3]; // pptodef segunda tabla
					$_POST[dcreditos][]='';
				}
				
			}
		}
		
		// Apropiación Reduccion
		if($_POST[tipocomprobantep]=='3') 
		{
			$sqlr="select * from pptoreducciones TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo AND TB1.id_acuerdo='$_POST[ncomp]'";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0];
		 	$a=$_POST[fecha]=$r[2];	// fecha
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[10];	// numero acuerdo
			$_POST[total]=$r[3];		// vigencia 
			
		 	$_POST[estado]=$r[6];		// estado
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
			
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			
			$sqlr="select * from pptoreducciones where id_acuerdo='".$r[1]."' order by cuenta";  // id_acuerdo primer tabla 
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[4]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';	 
				$_POST[dpdetalles][]='';
				
				if($r2[7]=='G')		// tipo primera tabla 
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor  segunda tabla
				}
				else
				{
					$_POST[dcreditos][]=$r2[5]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
				
			}
		}
		
		// Apropiación Traslados
		if($_POST[tipocomprobantep]=='5') // flecha adelante no sirve
		{
			$sqlr="select * from pptotraslados TB1,pptoacuerdos TB2 where  TB1.id_acuerdo=TB2.id_acuerdo AND TB1.id_acuerdo='$_POST[ncomp]'";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	$a=$_POST[fecha]=$r[2];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[10];	// numero acuerdo
			$_POST[total]=$r[3];		// vigencia 
			
		 	$_POST[estado]=$r[6];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptotraslados where id_acuerdo='".$r[1]."' order by cuenta"; // id_acuerdo primer tabla 
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[4];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[4]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';	 
				$_POST[dpdetalles][]='';
				if($r2[7]=='C')		// tipo primera tabla 
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor  segunda tabla R:disminuye
				}
				else
				{
					$_POST[dcreditos][]=$r2[5]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// Cuenta por pagar
		if($_POST[tipocomprobantep]=='8') // se salta a uno mayor 
		{
			$sqlr="select * from tesoordenpago TB1,tesoordenpago_det TB2, pptocuentas TB3 where TB1.id_orden=TB2.id_orden AND TB2.cuentap=TB3.cuenta AND TB3.vigencia='2017' AND TB1.id_orden='$_POST[ncomp]'";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	$a=$_POST[fecha]=$r[2];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[7];	// numero acuerdo
			$_POST[total]=$r[3];		// vigencia 
			$_POST[cuentadeb]=$r[23];	// valor
		 	$_POST[cuentacred]=$r[24];	// estado 
		 	$_POST[diferencia]=$r[25];	// tipo 
		 	$_POST[estado]=$r[24];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from tesoordenpago_det where id_orden='".$r[0]."' "; 
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[2];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[2]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]=$r[6];	 
				$_POST[dpdetalles][]='';
				
				if($r2[6]=='201')		// tipo primera tabla 
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[4]; // valor  segunda tabla
				}
				else
				{
					$_POST[dcreditos][]=$r2[4]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
			}
		}
		
		// Disponibilidad
		if($_POST[tipocomprobantep]=='6')
		{
			$sqlr="select * from pptocdp where vigencia='$vigusu' and consvigencia='$_POST[ncomp]' ORDER BY consvigencia DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	$a=$_POST[fecha]=$r[3];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[7];	// numero acuerdo
			$_POST[total]=$r[1];		// vigencia 
			$_POST[cuentadeb]=$r[4];	// valor
		 	$_POST[cuentacred]=$r[5];	// estado 
		 	$_POST[diferencia]=$r[9];	// tipo 
		 	$_POST[estado]=$r[5];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptocdp_detalle where vigencia='$vigusu' and consvigencia='".$r[2]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	

			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[3];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[3]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]='';	 
				$_POST[dpdetalles][]='';
				if($r2[9]=='201')		// tipo primera tabla 
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor  segunda tabla
				}
				else
				{
					$_POST[dcreditos][]=$r2[5]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
			}
		}

		// Egresos
		if($_POST[tipocomprobantep]=='11')
		{
			$sqlr="select * from tesoegresos TB1,tesoordenpago_det TB2 where  TB1.id_orden=TB2.id_orden AND TB1.id_egreso='$_POST[ncomp]'";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	$a=$_POST[fecha]=$r[3];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[8];	// numero acuerdo
			$_POST[total]=$r[4];		// vigencia 

		 	$_POST[estado]=$r[13];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from tesoordenpago_det  where id_orden='".$r[2]."' order by cuentap"; // id_acuerdo primer tabla 
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[2];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[2]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]=$r[11];	 
				$_POST[dpdetalles][]='';
				if($r2[6]=='201')		// tipo primera tabla 
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[4]; // valor  segunda tabla
				}
				else
				{
					$_POST[dcreditos][]=$r2[4]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
			}
		}

		// Egresos SSF
		if($_POST[tipocomprobantep]=='13')
		{
			$sqlr="select * from tesossfegreso_cab TB1,tesossfegreso_det TB2 where TB1.id_orden=TB2.id_egreso AND TB1.id_orden='$_POST[ncomp]'";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	$a=$_POST[fecha]=$r[2];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[7];	// numero acuerdo
			$_POST[total]=$r[3];		// vigencia 
			$_POST[estado]=$r[13];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from tesossfegreso_det  where id_egreso='".$r[0]."' order by cuentap"; // id_acuerdo primer tabla 
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[2];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[2]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				$_POST[dpterceros][]=$r[6]; 
				$_POST[dpdetalles][]='';
				if($r2[6]=='S')		// tipo primera tabla 
				{
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[4]; // valor  segunda tabla
				}
				else
				{
					$_POST[dcreditos][]=$r2[4]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
			}
		}

		// Ingresos SSF
		if($_POST[tipocomprobantep]=='21')
		{
			$sqlr="select * from tesossfingreso_cab where id_recaudo='$_POST[ncomp]' ORDER BY id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	
		 	$a=$_POST[fecha]=$r[2];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[4];	// numero acuerdo
			$_POST[total]=$r[3];		// vigencia 
			$_POST[estado]=$r[8];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptoingssf where idrecibo='".$r[0]."' order by cuenta"; // id_acuerdo primer tabla 
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{
				$_POST[dpcuentas][]=$r2[1];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[1]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				 
				$_POST[dpdetalles][]='';
				if($r[8]=='S')		// tipo primera tabla 
				{	$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[3]; // valor  segunda tabla
				}
				else if($r[8]=='N')
				{	$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]=$r2[3]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
			}
		}

		// ingresos internos
		if($_POST[tipocomprobantep]=='18')
		{

			$sqlr="select *from tesosinreciboscaja, tesosinrecaudos where tesosinrecaudos.id_recaudo=tesosinreciboscaja.id_recaudo AND tesosinrecaudos.id_recaudo='$_POST[ncomp]' ORDER BY tesosinrecaudos.id_recaudo DESC";
			echo $sqlr;
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	
		 	$a=$_POST[fecha]=$r[2];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[17];	// numero acuerdo
			$_POST[total]=$r[3];		// vigencia 
			$_POST[estado]=$r[9];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptosinrecibocajappto where idrecibo='".$r[4]."' AND cuenta!='' order by cuenta";
			
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{	
				$_POST[dpcuentas][]=$r2[1];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[1]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				 
				$_POST[dpdetalles][]='';
				if($r[9]=='S')		// tipo primera tabla 
				{	$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[3]; // valor  segunda tabla
				}
				else if($r[9]=='N')
				{	$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]=$r2[3]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
			}
		}

		// registros
		if($_POST[tipocomprobantep]=='7')
		{ 	
			$sqlr="select * from pptorp where vigencia='$vigusu' and consvigencia='$_POST[ncomp]' ORDER BY consvigencia DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	
		 	$a=$_POST[fecha]=$r[4];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[11];	// numero acuerdo
			$_POST[total]=$r[0];		// vigencia 
			$_POST[estado]=$r[3];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento]; 
			$sqlr="select * from pptorp_detalle  where vigencia='$vigusu' and consvigencia='".$r[1]."' order by CUENTA";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{	
				$_POST[dpcuentas][]=$r2[3];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[3]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				 
				$_POST[dpdetalles][]='';

				if($r[10]=='201')		// tipo primera tabla 
				{	$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[5]; // valor  segunda tabla
				}
				else if($r[10]=='401')
				{	$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]=$r2[5]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}
				else if($r[10]=='402')
				{	$_POST[dpterceros][]=$r[5];
					$_POST[dcreditos][]=$r2[5]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}

			}
		}

		// ingresos recibos caja
		if($_POST[tipocomprobantep]=='16')
		{
			$sqlr="select *from tesoreciboscaja where id_recibos='$_POST[ncomp]' ORDER BY id_recibos DESC";
			echo $sqlr;
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	$a=$_POST[fecha]=$r[2];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[11];	// numero acuerdo
			$_POST[total]=$r[3];		// vigencia 
			$_POST[estado]=$r[9];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento];
			
			$sqlr="select * from pptorecibocajappto where idrecibo='".$r[0]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{	
				$_POST[dpcuentas][]=$r2[1];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[1]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				 
				$_POST[dpdetalles][]='';

				if($r[9]=='S')		// tipo primera tabla 
				{	
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[3]; // valor  segunda tabla
				}
				else if($r[9]=='N')
				{	$_POST[dcreditos][]=$r2[3]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}

			}	
		}

		// recaudo transferencia
		if($_POST[tipocomprobantep]=='19')
		{
			$sqlr="select *from tesorecaudotransferencia where id_recaudo='$_POST[ncomp]' ORDER BY id_recaudo DESC";
			$res=mysql_query($sqlr,$link);
			$r=mysql_fetch_row($res);
			$globa=$r[0]; // por qué 0?
		 	
		 	$a=$_POST[fecha]=$r[2];
			ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		 	$_POST[fecha]=$fechaf;
		 	$_POST[concepto]=$r[6];	// numero acuerdo
			$_POST[total]=$r[3];		// vigencia 
			$_POST[estado]=$r[10];		// estado
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
			$tipom="and tipomovimiento=".$_POST[tipomovimiento];
			$sqlr="select * from pptoingtranppto where idrecibo='".$r[0]."' order by cuenta";
			$res2=mysql_query($sqlr,$link);	
			while($r2=mysql_fetch_row($res2))
			{	
				$_POST[dpcuentas][]=$r2[1];		// cuenta primera tabla 
				$nresul=buscacuentapres($r2[1]); // cuenta primera tabla
				$_POST[dpncuentas][]=$nresul;
				 
				$_POST[dpdetalles][]='';

				if($r[10]=='S')		// tipo primera tabla 
				{	$_POST[dpterceros][]=$r[7];
					$_POST[dcreditos][]='';
					$_POST[ddebitos][]=$r2[3]; // valor  segunda tabla
				}
				else if($r[10]=='N')
				{	
					$_POST[dpterceros][]=$r[7];
					$_POST[dcreditos][]=$r2[3]; // valor segunda tabla
					$_POST[ddebitos][]='';
				}

			}	
		}
	
	}

	if($_POST[oculto]=='3')
	{
		//echo "HH";
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
				<input type="hidden" name="posicion" value="<?php echo $_POST[posicion]?>">
            	<a href="#" onClick="atrasc()">

            		<img src="imagenes/back.png" alt="anterior" align="absmiddle">
            	</a>

         		<input type="text" name="ncomp" style="width:50%;" onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) onBlur="validar2()" >
         		<!--
				<input type="text" name="ncomp" style="width:50%;" onKeyPress="javascript:return solonumeros(event)" value="<?php //echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) " onBlur="validar2()" >
         		-->
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
	                if($_POST[estado]=="S"){
				       	$valuees="ACTIVO";
				       	$stylest="width:50%; background-color:#0CD02A; color:white; text-align:center;";
				    }else if($_POST[estado]=="N"){
				       	$valuees="ANULADO";
				      	$stylest="width:50%; background-color:#FF0000; color:white; text-align:center;";
				    }else if($_POST[estado]=="P"){
				       	$valuees="PAGO";
				      	$stylest="width:50%; background-color:#0404B4; color:white; text-align:center;";
				    }else if($_POST[estado]=="R"){
				       	$valuees="REVERSADO TOTAL";
				      	$stylest="width:50%; background-color:#FF0000; color:white; text-align:center;";
				    }else if($_POST[estado]=="C"){
				       	$valuees="COMPLETADO";
				      	$stylest="width:50%; background-color:#0040FF; color:white; text-align:center;";
				    }else if($_POST[estado]=="F"){
				       	$valuees="FINALIZADO";
				      	$stylest="width:50%; background-color:#08F0E5; color:white; text-align:center;";
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
			<td class="saludo1">Tipo Documento</td>
			<td>
				<input type="hidden" name="sele" id="sele" value="<?php echo $_POST[sele]?>">
				<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="validar3();">
					<?php
						if($_POST[estado]=='2'){
						
					?>
						<option value='201' <?php if($_POST[tipomovimiento]=='201'){echo "SELECTED";} ?> >101 - Documento original</option>
						<option value='401' <?php if($_POST[tipomovimiento]=='401'){echo "SELECTED";} ?>>201 - Documento REVERSION TOTAL</option>
					<?php
						}else if($_POST[estado]=='3'){
					?>
						<option value='201' <?php if($_POST[tipomovimiento]=='201'){echo "SELECTED";} ?>>101 - Documento original</option>
						<option value='402' <?php if($_POST[tipomovimiento]=='402'){echo "SELECTED";} ?>>202 - Documento REVERSION PARCIAL</option>
					<?php
						}else if($_POST[tipocomprobantep]=='1'){
					?>
						<option value='201' <?php if($_POST[tipomovimiento]=='201'){echo "SELECTED";} ?> >101 - Documento original</option>
						<option value='401' <?php if($_POST[tipomovimiento]=='401'){echo "SELECTED";} ?>>201 - Documento REVERSION TOTAL</option>
						<option value='402' <?php if($_POST[tipomovimiento]=='402'){echo "SELECTED";} ?>>202 - Documento REVERSION PARCIAL</option>
					<?php
						}else{
					?>
						<option value='201' <?php if($_POST[tipomovimiento]=='201'){echo "SELECTED";} ?>>101 - Documento original</option>
					<?php
						}
					?>
				</select>
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
						
						for($x=0;$x<count($_POST[arregloact]); $x++){
							echo "<input type='hidden' name='arregloact[]' value='".$_POST[arregloact][$x]."' />";
						}
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
										<input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='hidden'>
										<input name='ndebitos[]' value='".number_format($_POST[ddebitos][$x],2)."' type='text' size='10' onDblClick='llamarventanadeb(this,$x)' onBlur='validar3()' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)'>
									</td>
									<td>
										<input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='hidden'>
										<input name='ncreditos[]' value='".number_format($_POST[dcreditos][$x],2)."' type='hidden' size='10' onDblClick='llamarventanacred(this,$x)' onBlur='validar3()' onKeyUp='return tabular(event,this)' onKeyPress='javascript:return solonumeros(event)'>
									</td>
								</tr>";
//		 $cred= $vc[$x]*1;
		$diferencia=0;
		$_POST[diferencia2]=0;
		 $cred=$_POST[dcreditos][$x];
		 $deb=$_POST[ddebitos][$x];

//		 $cred=number_format($cred,2,".","");
	//	 $deb=number_format($deb,2,".","");
		 
		 $cuentacred=$cuentacred+$cred;
		 $cuentadeb=$cuentadeb+$deb;

		 $diferencia=$cuentadeb-$cuentacred;
		 $total=number_format($total,2,",",""); 
		 $_POST[diferencia]=$cuentadeb-$cuentacred;
		 
		 $_POST[diferencia2]=number_format($cuentadeb-$cuentacred,2,".",",");
		 $_POST[cuentadeb]=number_format($cuentadeb,2,".",",");
		 $_POST[cuentadeb2]=$cuentadeb;
		 $_POST[cuentacred]=number_format($cuentacred,2,".",",");	 
		 $_POST[cuentacred2]=$cuentacred;
		 $aux=$iter2;
		 $iter2=$iter;
		 $iter=$aux;
		 }
		 echo "<tr>
		 <td></td><td></td>
		 <td >Diferencia:</td>
		 <td colspan='1'><input type='hidden' id='diferencia' name='diferencia' value='$_POST[diferencia]' ><input id='diferencia2' name='diferencia2' value='$_POST[diferencia]' type='text' readonly></td>
		 <td>Totales:</td><td class='saludo2'><input name='cuentadeb2' type='hidden' id='cuentadeb2' value='$_POST[cuentadeb2]'><input name='cuentadeb' id='cuentadeb' value='$_POST[cuentadeb]' readonly></td>
		 <td class='saludo2'><input id='cuentacred' name='cuentacred' value='$_POST[cuentacred]' readonly><input id='cuentacred2' type='hidden' name='cuentacred2' value='$_POST[cuentacred2]' ></td></tr>";
		?>
		</table>  
		</div> 
	  </form>
 
</body>
</html>