<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
require "comun.inc";
require"funciones.inc";
//require "encrip.inc";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script src="css/calendario.js"></script>
		<script> 
			function ponprefijo(pref,opc,tipoDoc){ 
			//alert(pref);
				var tipodocumento='';
				if (tipoDoc==31) {
					tipodocumento='N';
				}else if (tipoDoc==11) {
					tipodocumento='R';
				}else if (tipoDoc==13) {
					tipodocumento='C';
				}else if (tipoDoc==22) {
					tipodocumento='E';
				}else if (tipoDoc==41) {
					tipodocumento='P';
				}

				 opener.document.form2.tercero.value =pref ;
				 opener.document.form2.ntercero.value =opc ;
				 opener.document.form2.tipoDoc.value =tipodocumento ;
				 opener.document.form2.tercero.focus();
				// //parent.document.form2.tercero.value =pref ;
				//opener.document.form2.cc.select();
				window.close() ;
				/*parent.document.form2.tercero.value =pref ;
				parent.document.form2.ntercero.value =opc ;
				parent.despliegamodal2("hidden");*/
			} 
        </script> 
<?php titlepag();?>
</head>
<body >
  <form action="" method="post" enctype="multipart/form-data" name="form1">
<table  class="inicio" align="center" >
	<tr><td class="titulos" colspan="4">:: Buscar Tercero</td></tr>
	<tr>
      	<td class="saludo1">Nombre o apellidos:</td>
        <td><input name="nombre" type="text" value="" size="40"></td>
    </tr>
   	<tr>
        <td class="saludo1">Documento: </td>
        <td><input name="documento" type="text" id="documento" value="">&nbsp;&nbsp;
		<input type="submit" name="Submit" value="Buscar" >
	</tr>                       
</table> 
    	<input name="oculto" type="hidden" value="1"></td>
    <div class="subpantalla" style="height:80.5%; width:99.6%; overflow-x:hidden;">
    	<script>
		  		document.form1.nombre.focus();	
			</script>
      <?php
$oculto=$_POST['oculto'];
//if($_POST[oculto])
{
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			if ($_POST[nombre]!="")
			$crit1=" and (terceros.nombre1 like '%".$_POST[nombre]."%' or terceros.nombre2 like '%".$_POST[nombre]."%' or terceros.apellido1 like '%".$_POST[nombre]."%' or terceros.apellido2 like '%".$_POST[nombre]."%' or terceros.razonsocial like '%".$_POST[nombre]."%') ";
			if ($_POST[documento]!="")
			$crit2=" and terceros.cedulanit like '%$_POST[documento]%' ";
			//sacar el consecutivo 
			$sqlr="select *from terceros where terceros.estado='S' ".$crit1.$crit2." order by terceros.apellido1,terceros.apellido2,terceros.nombre1,terceros.nombre2";
			 // echo "<div><div>sqlr:".$sqlr."</div></div>";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			$con=1;
			echo "<table class='inicio' align='center' width='99%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Terceros Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='30%'>RAZON SOCIAL</td><td class='titulos2' width='10%'>PRIMER APELLIDO</td><td class='titulos2' width='10%'>SEGUNDO APELLIDO</td><td class='titulos2' width='10%'>PRIMER NOMBRE</td><td class='titulos2' width='10%'>SEGUNDO NOMBRE</td><td class='titulos2' width='4%'>DOCUMENTO</td></tr>";	
			//echo "nr:".$nr;
			$iter='saludo1a';
			$iter2='saludo2';
			 while ($row =mysql_fetch_row($resp)) 
			 {
			   if ($row[11]=='31')
			   {
					if($row[5]!=''){
						$ntercero=$row[5];
					}else{
						$ntercero=$row[3].' '.$row[4].' '.$row[1].' '.$row[2];
					}
			   }
			   else {
				  $ntercero=$row[3].' '.$row[4].' '.$row[1].' '.$row[2];
			   }
				 echo"<tr class='$iter' onClick=\"javascript:ponprefijo('$row[12]','$ntercero','$row[11]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" ><td>$con</td><td>".strtoupper($row[5])."</td><td>".strtoupper($row[3])."</td><td>".strtoupper($row[4])."</td><td >".strtoupper($row[1])."</td><td>".strtoupper($row[2])."<td>$row[12]</td></tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
			 }
			 echo"</table>";
}
?>
</div>
</form>
</body>
</html>
