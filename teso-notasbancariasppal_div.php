<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
require "validaciones.inc";
session_start();
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$idc=$_GET['dc'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="css/funciones.js"></script>
<script type="text/javascript" src="css/sweetalert.js"></script>
<script type="text/javascript" src="css/sweetalert.min.js"></script>


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
function validarsel()
{
var tiposel =$("#tipomovimiento").val();
var ruta="";


if(tiposel=="201")
{
	ruta="teso-notabancaria_div.php";
	$("#oculto").val("");
}
if(tiposel=="401")
{
	ruta="teso-editanotasbancarias_div.php";
	$("#oculto").val("");
}
//alert("t:"+ruta);
// var parametros = "";
//     $.ajax({
//         data: parametros,
//         url: ruta,
//         type: 'post',
//         beforeSend: function () {
//             $("#notabandiv").html("Procesando, espere por favor...");
//         },
//         success: function (response) {
// 			alert("re"+response)
//             $("#notabandiv").html(response);
//         }
// 	});
document.form2.submit();
}
function validar(){document.form2.submit();}
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
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  && document.form2.valor.value!=""  && document.form2.gastobancario.value!="")
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
// function guardar()
// {

// if (document.form2.fecha.value!='' && document.form2.concepto.value!='')
//   {
// 	if (confirm("Esta Seguro de Guardar"))
//   	{
//   	document.form2.oculto.value=2;
//   	document.form2.submit();
//   	}
//   }
//   else{
//   alert('Faltan datos para completar el registro');
//   	document.form2.fecha.focus();
//   	document.form2.fecha.select();
//   }
// }
// </script>
<script>
function pdf()
{
document.form2.action="teso-pdfnotasbancarias.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{
  // alert("adelante"+document.form2.ncomp.value+" max:"+document.form2.maximo.value);
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="teso-notasbancariasppal_div.php";
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
document.form2.action="teso-notasbancariasppal_div.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">


	function iratras(scrtop, numpag, limreg, filtro){
		var idcta=document.getElementById('idcomp').value;
		location.href="teso-buscanotasbancarias.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
	}
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;

//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="teso-notasbancariasppal_div.php";
document.form2.submit();
}
function copiarconcepto()
{
	var concepto=$("#concepto").val();		
	$("#conceptoh").val(concepto);
	//alert("ff");
}
</script>
<script>
		function agregardetalle()
			{
				
				if(document.form2.numero.value!="" && document.form2.banco.value!="" && document.form2.valor.value!="" && document.form2.valor.value>=0 && document.form2.gastobancario.value!="")
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {//alert("Falta informacion para poder Agregar");
					swal("SPID","Falta informacion para poder Agregar","warning","Aceptar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.elimina.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{		
				var concepto=$("#concepto").val();		
				var conceptoh=$("#conceptoh").val();
				if(concepto===conceptoh)
				{
				 swal("SPID","Por favor modifique el concepto de reversión","error");
				}
				else{
				// alert("b: ");
				var validacion01=document.getElementById('concepto').value;
				// alert("Concepto"+validacion01);
				if ($("#fecha").val()!='' && validacion01.trim()!='' && document.getElementById('concepto').value !="")
  				{
					//    alert("dddddd ");
					  despliegamodalm('visible','4','Esta Seguro de Guardar','1'); }
  				else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
				}

			}
			function pdf()
			{
				document.form2.action="teso-pdfnotasbancarias.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;
							break;

						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje()
			{
				// $("#tipomovimiento").val("401");
				//document.location.href = "teso-notasbancariasppal_div.php";		
				$("#tipomovimiento").val("401");	
				validarsel();
			}
			
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.submit();
						break;
				}
			}
			function despliegamodal2(_valor,_nomve,_vaux)
			{
				
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
				}
				else {
					
					if(_nomve=='1')
					{
					document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ct";
					}
					if(_nomve=='2')
					{
					 document.getElementById('ventana2').src="registro-ventana04.php?vigencia="+_vaux;
					
					}
				}
				
			}
		</script>
<script src="css/programas.js"></script><script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/sweetalert.css" rel="stylesheet" type="text/css" />

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=22*$totreg;
		?>
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-notasbancariasppal_div.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a>
			<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscanotasbancarias.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" border="0" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a>
			<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$linkbd=conectar_bd();
$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
 ?>
<form name="form2" method="post" action=""> 
<?php
$_POST[totregs]=$totreg;
?>
 <div >
 
            <div  class="inicio" style="padding: .35em .625em .75em; margin: 0 2px; border: 1px solid #c0c0c0;">
				<label for="tipomovimiento"  style="padding: .4em .8em .9em; margin: 0 .5px; color:#0C4B7D;" >Tipo Documento:</label> 
                <select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="validarsel()" style="width:20%;" >
                <option >Seleccione Tipo Movimiento</option>
							<?php 
								$user=$_SESSION[cedulausu];
								$sql="SELECT * from permisos_movimientos WHERE usuario='$user' AND estado='T' ";
								$res=mysql_query($sql,$linkbd);
								$num=mysql_num_rows($res);
								if($num==1){
									$sqlr="select * from tipo_movdocumentos where estado='S' and modulo=4 AND (id='2' OR id='4')";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										if($_POST[tipomovimiento]==$row[0].$row[1]){
											echo "<option value='$row[0]$row[1]' SELECTED >$row[0]$row[1]-$row[2]</option>";
										}else{
											echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";
										}
									}
								}else{
									$sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='4' AND transaccion='TPB' ";
									$res=mysql_query($sql,$linkbd);
									while($row = mysql_fetch_row($res)){
										if($_POST[tipomovimiento]==$row[0]){
											echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										}else{
											echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
										}
										
									}
								}
								
							?>
						</select>
            
        </div>
<div id="notabandiv">
    <?php
    if($_POST["tipomovimiento"]=="201")
      include ("teso-notabancaria_div.php");
	  if($_POST["tipomovimiento"]=="401")
      include ("teso-editanotasbancarias_div.php");
    ?>
</div>
<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>	
</form>
</div>

</body>
</html>