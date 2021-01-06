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
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
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
function agregarchivo(){
				if(document.form2.rutarchivo.value!=""){
							document.form2.agregadet3.value=1;
							document.form2.submit();
				}
				else {despliegamodalm4('visible','2','Debe especificar la ruta del archivo');}
			}
			function eliminar3(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			  	{
			  		var eliminar=document.getElementById('eliminarc');
			  		eliminar.value=variable;
					document.form2.submit();
				}
			}
function guardar()
{
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
}

function validar()
{
document.form2.oculto.value=1;
document.form2.submit();
}

function validar2(formulario)
{
document.form2.chacuerdo.value=2;
document.form2.action="presu-adicioningver.php";
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
document.form2.action="pdfcobropredial_masivo.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function pdf2()
{
document.form2.action="pdfcobropredial_masivo2.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function pdf3()
{
document.form2.action="pdfcobropredial_masivo3.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}		
function pdf4()
{
	document.form2.action="pdfcobropredial_masivo4.php";
	document.form2.target="_BLANK";
	document.form2.submit(); 
	document.form2.action="";
	document.form2.target="";
}	
function generapdf()
{
document.form2.action="pdfpersuasivo.php";
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
		
		function atrasc()
		{
			if(document.form2.numresolucion.value>1)
			 {
				document.form2.numresolucion.value=document.form2.numresolucion.value-1;
				document.form2.action="teso-reportecobropredialver.php";
				document.form2.submit();
			 }
		}
		function adelante()
		{
			if(parseFloat(document.form2.numresolucion.value)<parseFloat(document.form2.maximo.value))
			 {
				document.form2.numresolucion.value=parseFloat(document.form2.numresolucion.value)+1;
				document.form2.action="teso-reportecobropredialver.php";
				document.form2.submit();
			 }
		}
</script>
		<?php titlepag();?>
	</head>
	<body >
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("teso");?></tr>
            <tr>
				<td colspan="3" class="cinta">
					<a href="teso-reportecobropredial_masivo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="teso-buscareportecobropredial.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
					<a href="#" onClick="pdf2()" class="mgbt"> <img src="imagenes/print111.png"  alt="Buscar2" title="Uribe"/></a>
					<a href="#" onClick="pdf3()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar2" title="Pto Rico"/></a>
					<a href="#" onClick="pdf4()" class="mgbt"> <img src="imagenes/print2.png"  alt="Buscar2" title="Castillo"/></a>
					<a><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-buscareportecobropredial.php'" class="mgbt"/></a>
				</td>
			</tr>
		</table> 
		<form name="form2" method="post" enctype="multipart/form-data">
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
$vigencia=$vigusu;
$proce='resolucion';
	if($_POST[oculto]=="")
			{	
				$_POST[tabgroup1]=1;
			}
			switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';
                }

	$linkbd=conectar_bd();
	$contacu=0;
	if(isset($_GET[resolucion])){
		$_POST[numresolucion]=$_GET[resolucion];
		
	} 
		$sq="SELECT expediente FROM tesocobroreporte WHERE numresolucion='$_POST[numresolucion]' ";
		$re=mysql_query($sq,$linkbd);
		$row=mysql_fetch_row($re);
		$_POST[expediente]=$row[0];
			if($_POST[oculto]!='2')
			{
				unset($_POST[nomarchivos]);
				unset($_POST[rutarchivos]);
				unset($_POST[tamarchivos]);
				unset($_POST[patharchivos]);	 		 
				$_POST[nomarchivos]= array_values($_POST[nomarchivos]); 
				$_POST[rutarchivos]= array_values($_POST[rutarchivos]); 
				$_POST[tamarchivos]= array_values($_POST[tamarchivos]); 
				$_POST[patharchivos]= array_values($_POST[patharchivos]);
			}
			unset($_POST[vigencia]);	 		 
            $_POST[vigencia]= array_values($_POST[vigencia]);
			$sqlr1="select vigencia,predial,intereses1,sobretasabombe,intereses2,sobretasamb,intereses3,descuentos,valortotal,diasmora,codcatastral,fecha,(SELECT sum(valortotal) FROM tesocobroreporte WHERE numresolucion='$_POST[numresolucion]') from tesocobroreporte where numresolucion='$_POST[numresolucion]' ";
			$res1=mysql_query($sqlr1,$linkbd);
			$con=0;
			while ($row1=mysql_fetch_row($res1))
		 	{		
				$_POST[vigencia][$con]=$row1[0];	
				$_POST[predial][$con]=$row1[1];
				$_POST[interesespredial][$con]=$row1[2];
				$_POST[sobretasabombe][$con]=$row1[3];
				$_POST[intsobretasabombe][$con]=$row1[4];
				$_POST[sobretasamb][$con]=$row1[5];
				$_POST[intsobretasamb][$con]=$row1[6];
				$_POST[descuento][$con]=$row1[7];
				$_POST[valortotal][$con]=$row1[8];
				$_POST[diasmora][$con]=$row1[9];
				$_POST[codigocatastral2]=$row1[10];
				$_POST[fecha]=$row1[11];
				$_POST[total]=$row1[12];
				$con++;
			}
			
			$sql="SELECT * FROM tesocobroreporte_adj WHERE numresolucion='$_POST[numresolucion]' AND vigencia=$vigusu";
               	$result=mysql_query($sql,$linkbd);
               	while($row = mysql_fetch_row($result)){
               		$_POST[nomarchivos][]=$row[2];
                    $_POST[rutarchivos][]=basename($row[4]);
                    $_POST[tamarchivos][]=filesize($row[4]);
                    $_POST[patharchivos][]=basename($row[4]);
               	}
			
			$sqlr="select max(numresolucion) from  tesocobroreporte ";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
				$r=mysql_fetch_row($res);
				 $_POST[maximo]=$r[0];
?>
 	<div class="tabsic" style="height:80%; width:99.6%;" > 
			<div class="tab"> 
       		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	  		<label for="tab-1">Resolucion</label>
			<div class="content" width="100%" style="overflow-x:hidden;">
		<table class="inicio" align="center" width="99%" >
      	<tr >
        	<td class="titulos" style="width:95%;" colspan="2">.: Resolucion </td>
        	<td  class="cerrar" style="width:5%;"><a href="presu-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
      		<table class="inicio">
				<div>
      				<tr>
			  			<td style="width:10%;" class="saludo1">No de Resolucion</td>
				  		<td style="width:0.1%;">
							<td style="width:10%;"><img src="imagenes/back.png" title="Anterior" onClick="atrasc()" class="icobut">
				  			<input type="text" id="numresolucion" name="numresolucion" onKeyPress="javascript:return solonumeros(event)" style="width:50%;" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[numresolucion]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
							<img src="imagenes/next.png" title="Siguiente" onClick="adelante()" class="icobut"/>
							<input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
							<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
							<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
				  		</td>
			  			<td style="width:4%;" class="saludo1">Fecha:        </td>
		        		<td style="width:7%;">
		        			<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:100%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>
		        			       
		        		</td>
				  		<td style="width:8%;" class="saludo1">Codigo Catastral:</td>
				  		<td style="width:10%;">
				  			<input type="text" id="codigocatastral2" name="codigocatastral2" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[codigocatastral2]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
				  		</td>
						<td style="width:8%;" class="saludo1">Total a pagar ($)</td>
				  		<td style="width:7%;">
				  			<input type="text" id="total" name="total" onKeyPress="javascript:return solonumeros(event)" style="width:100%;" onKeyUp="return tabular(event,this)"  value="<?php echo number_format($_POST[total],2)?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
				  		</td style="width:5%;">
						<td style="width:6%;" class="saludo1">No de Expediente</td>
						<td style="width:6%;">
							<input type="text" id="expediente" name="expediente"  style="width:80%;"   value="<?php echo $_POST[expediente]?>">
						</td>
						<td>
							<input type="button" id="generar" value="Generar Cobro Persuasivo" onclick="generapdf()" style="width:60%">
						</td>
		       		</tr>
				</div>
      		</table>
      	</tr>
    </table>
		<table class="inicio"  >
        <tr>
          <td class="titulos" colspan="14">Detalle Resolucion          </td>
        </tr>
		<tr>
			<td class="titulos2">Vigencia</td>
			<td class="titulos2">Codigo Catastral</td>
			<td class="titulos2">Predial</td>
			<td class="titulos2">Intereses Predial</td>
			<td class="titulos2">Sobretasa Bomberil</td>
			<td class="titulos2">Intereses Bomberil</td>
			<td class="titulos2">Sobretasa Ambiental</td>
			<td class="titulos2">Intereses Ambiental</td>
			<td class="titulos2">Descuento</td>
			<td class="titulos2">Valor Total</td>
			<td class="titulos2">Dias Mora</td>
		</tr> 
		<?php 
		  $iter='zebra1';
		  $iter2='zebra2';
		 for ($x=0;$x< count($_POST[vigencia]);$x++)
		 {
		 
		 echo "<tr class='$iter'>
			<td><input name='vigencia[]' value='".$_POST[vigencia][$x]."' type='text' style='width:100%;' readonly></td>
			<td><input name='codigocatastral[]' value='".$_POST[codigocatastral2]."'  style='width:100%;' readonly></td>
			<td><input name='predial[]' value='".number_format($_POST[predial][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='interesespredial[]' value='".number_format($_POST[interesespredial][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='sobretasabombe[]' value='".number_format($_POST[sobretasabombe][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='intsobretasabombe[]' value='".number_format($_POST[intsobretasabombe][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='sobretasamb[]' value='".number_format($_POST[sobretasamb][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='intsobretasamb[]' value='".number_format($_POST[intsobretasamb][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='descuento[]' value='".number_format($_POST[descuento][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='valortotal[]' value='".number_format($_POST[valortotal][$x],2)."' type='text' style='width:100%;' readonly></td>
			<td><input name='diasmora[]' value='".$_POST[diasmora][$x]."' type='text' style='width:100%;' readonly></td>
		</tr>";
		  	$aux=$iter;
	 		$iter=$iter2;
	 		$iter2=$aux;
		 }
		 
		?>
		</tr>
		</table>
		</div>
	</div>
				<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       				<label for="tab-2">Anexos</label>
       				<div class="content" > 
         				<table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="6" >Subir Anexos</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:8%">Anexo:</td>
                                <td style="width:25%" ><input type="text" name="rutarchivo" id="rutarchivo"  style="width:100%;" value="<?php echo $_POST[rutarchivo]?>" readonly> <input type="hidden" name="tamarchivo" id="tamarchivo" value="<?php echo $_POST[tamarchivo] ?>" /><input type="hidden" name="patharchivo" id="patharchivo" value="<?php echo $_POST[patharchivo] ?>" />
                                 </td>
                                    <td style="width:3%">
                                    	<div class='upload'> 
                                        <input type="file" name="plantillaad1" onChange="validar();" />
                                        <img src="imagenes/upload01.png" style="width:18px" title="Cargar" /> 
                                    </div> 
                                    </td>
                                <td class="saludo1" style="width:8%">Nombre:</td>
            					<td width="25%"><input type="text" style="width: 100% !important; " name="nomarchivo" id="nomarchivo" /></td>
            					<td><input type='button' name='agregar2' id='agregar2' value='   Agregar   ' onClick='agregarchivo()'/></td>
            					<td></td>
                            </tr>
                        </table>
						<input type="hidden" name="elimina" id="elimina" value="<?php echo $_POST[elimina]; ?>">
                        <input type="hidden" name="eliminarc" id="eliminarc" value="<?php echo $_POST[eliminarc]; ?>">
                        <?php
                        	 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='5'>Detalle Adjuntos</td>
                                            </tr>
                                            <tr>
                                                <td class='titulos2'>Nombre</td>
                                                <td class='titulos2'>Ruta</td>
                                                <td class='titulos2'>".utf8_decode("Tamaño")."</td>
                                                <td class='titulos2'></td>
                                                <td class='titulos2'><img src='imagenes/del.png'></td>
                                            </tr>";
                                if ($_POST[eliminarc]!='')
                                { 
                                    $posi=$_POST[eliminarc];
                                    unset($_POST[nomarchivos][$posi]);
                                    unset($_POST[rutarchivos][$posi]);
                                    unset($_POST[tamarchivos][$posi]);
                                    unset($_POST[patharchivos][$posi]);	 		 
                                    $_POST[nomarchivos]= array_values($_POST[nomarchivos]); 
                                    $_POST[rutarchivos]= array_values($_POST[rutarchivos]); 
                                    $_POST[tamarchivos]= array_values($_POST[tamarchivos]); 
                                    $_POST[patharchivos]= array_values($_POST[patharchivos]); 	
                                    $_POST[eliminarc]='';	 		 		 		 
                                }	 
                                if ($_POST[agregadet3]=='1')
                                {
                                    $ch=esta_en_array($_POST[nomarchivos],$_POST[nomarchivo]);
                                    if($ch!='1')
                                    {
                                        $_POST[nomarchivos][]=$_POST[nomarchivo];
                                        $_POST[rutarchivos][]=$_POST[rutarchivo];
                                        $_POST[tamarchivos][]=$_POST[tamarchivo];
                                        $_POST[patharchivos][]=$_POST[patharchivo];
                                        $_POST[agregadet3]=0;
                                        echo"
                                        <script>	
                                            document.form2.nomarchivo.value='';
                                            document.form2.rutarchivo.value='';
                                            document.form2.tamarchivo.value='';
                                        </script>";
                                    }
                                    else {echo"<script>parent.despliegamodalm('visible','2','Ya se Ingreso el Archivo  $_POST[nomarchivo]');</script>";}
                                }
                                $itern='saludo1a';
                                $iter2n='saludo2';
                                for ($x=0;$x<count($_POST[nomarchivos]);$x++)
                                {
                                	$rutaarchivo="informacion/proyectos/temp/".$_POST[patharchivos][$x];
                                    echo "
                                    <input type='hidden' name='nomarchivos[]' value='".$_POST[nomarchivos][$x]."'/>
                                    <input type='hidden' name='rutarchivos[]' value='".$_POST[rutarchivos][$x]."'/>
                                    <input type='hidden' name='tamarchivos[]' value='".$_POST[tamarchivos][$x]."'/>
                                    <input type='hidden' name='patharchivos[]' value='".$_POST[patharchivos][$x]."'/>
                                        <tr class='$itern'>
                                            <td>".$_POST[nomarchivos][$x]."</td>
                                            <td>".$_POST[rutarchivos][$x]."</td>
                                            <td>".$_POST[tamarchivos][$x]." Bytes</td>
                                            <td style='text-align:center;width: 30px'><a href='$rutaarchivo' target='_blank' ><img src='imagenes/descargar.png'  title='(Descargar)' ></a></td>
                                        
                                            <td><a href='#' onclick='eliminar3($x)'><img src='imagenes/del.png'></a></td>
                                        </tr>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                                echo "
                                    </table></div>";
							
							if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
							{
								$rutaad="informacion/proyectos/temp/";
								if(!file_exists($rutaad)){mkdir ($rutaad);}
								else {eliminarDir();mkdir ($rutaad);}
								$nomarchivo=$_FILES['plantillaad']['name'];
								$linkbd=conectar_bd();
								$sqlr="SELECT * FROM planproyectos WHERE archivo='".$nomarchivo."'";
								$resp = mysql_query($sqlr,$linkbd);
								$ntr = mysql_num_rows($resp);
								if($ntr==0)
								{
								?><script>document.getElementById('nomarch').value='<?php echo $_FILES['plantillaad']['name'];?>';document.getElementById('nomarchadj').value='<?php echo $_FILES['plantillaad']['name'];?>';</script><?php 
								copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
								}
								else
								{?><script>despliegamodalm('visible',3,'Ya se ingres\xf3 un Archivo con el nombre '+'<?php echo $nomarchivo; ?>');</script><?php }
							}
							if (is_uploaded_file($_FILES['plantillaad1']['tmp_name'])) 
							{
								$rutaad="informacion/proyectos/temp/";
								$nomarchivo=$_FILES['plantillaad1']['name'];
								?><script>document.getElementById('rutarchivo').value='<?php echo $_FILES['plantillaad1']['name'];?>';document.getElementById('tamarchivo').value='<?php echo $_FILES['plantillaad1']['size'];?>';document.getElementById('patharchivo').value='<?php echo $_FILES['plantillaad1']['name'];?>';</script><?php 
								copy($_FILES['plantillaad1']['tmp_name'], $rutaad.$_FILES['plantillaad1']['name']);
								
							}
                         ?>
              		</div>
                </div>
			</div>
			 <input type="hidden" name="oculto" id="oculto" value="1">
        	<input type="hidden" name="oculgen" id="oculgen" value="<?php echo $_POST[oculgen];?>">
        	<input type="hidden" name="indindex" id="indindex" value="<?php echo $_POST[indindex];?>">
           	<input type="hidden" name="codid" id="codid" value="<?php echo $_POST[codid];?>">
            <input type="hidden" name="pesactiva" id="pesactiva" value="<?php echo $_POST[pesactiva];?>">
            <input type="hidden" name="busadq" id="busadq" value="0">
         	<input type="hidden" name="bctercero" id="bctercero" value="0">
           	<input type="hidden" name="agregadets" id="agregadets" value="0">
            <input type='hidden' name="eliminars" id="eliminars" >
            <input type="hidden" name="bc" value="0">
            <input type="hidden" name="bcproyectos" value="0" >
			<input type="hidden" name="agregadet7" value="0">
            <input type="hidden" name="agregadet2" value="0">
            <input type="hidden" name="agregadet8" value="0">
            <input type="hidden" name="agregadet3" value="0">
            <input type="hidden" name="agregadet" value="0"> 
            <input type="hidden" name="agregadetadq" value="0">
            <input type='hidden' name='eliminar' id='eliminar'>
			
			<?php
			if($_POST[oculto]=="2")
			{
				$linkbd=conectar_bd();
				$sql="DELETE FROM tesocobroreporte_adj WHERE numresolucion='$_POST[numresolucion]' and vigencia='$vigusu' and ruta='$ruta' and proceso='$proce'";
				mysql_query($sql,$linkbd);
				for($i=0;$i<count($_POST[nomarchivos]); $i++){
							$nombre=$_POST[nomarchivos][$i];
							$ruta="informacion/proyectos/temp/".$_POST[rutarchivos][$i];
							$sqlr="INSERT INTO tesocobroreporte_adj(numresolucion,codcatastral,nombre,vigencia,ruta,proceso) VALUES ('$_POST[numresolucion]','".$_POST[codigcatas]."','$nombre','$vigusu','$ruta','$proce') ";
							mysql_query($sqlr,$linkbd);
						}
			}
			?>
				</form>
</body>
</html>