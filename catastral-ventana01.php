<?php
	require "comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			var anterior;
			function ponprefijo(pref,pref2,pref3)
			{ 
    			parent.document.form2.codcat.value =pref;
				parent.document.form2.ord.value =pref2;
				parent.document.form2.tot.value =pref3;
				parent.document.form2.codcat.focus();	
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
  		<form action="" method="post" enctype="multipart/form-data" name="form1">
			<table  class="inicio" align="center" >
      			<tr>
                	<td class="titulos" colspan="4">:: Buscar Codigo Catastral</td>
                    <td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
                </tr>
				<tr>
            		<td class="saludo1">Nombres:</td>
            		<td><input name="nombre" type="text" value="" size="20"></td>
            		<td class="saludo1">Documento Propietario:</td>
            		<td><input name="cedula" type="text" value="" size="20"></td>
    			</tr>
        		<tr>
            		<td class="saludo1">Cod Catastral:</td>
            		<td><input name="documento" type="text" id="documento" value="" size="30"></td>
            		<td class="saludo1">Direccion:</td>
            		<td><input name="direccion" type="text" value="" size="30">&nbsp;<input type="submit" name="Submit" value="Buscar" ></td>
       			</tr>  
       			<input type="hidden" name="oculto" id="oculto" value="1"/>                     
    		</table> 
    		<div class="subpantalla" style="height:78.5%; width:99.6%; overflow-x:hidden;">
				<?php
				
				function obtenerNombre($codigo){
					global $linkbd;
					$sql="SELECT nombre FROM teso_clasificapredios WHERE codigo=$codigo LIMIT 0,1";
					$res=mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					return $row[0];
				}
                    $oculto=$_POST['oculto'];
                    if(true)
                    {
                        $crit1=" ";
                        $crit2=" ";
                        if ($_POST[nombre]!=""){$crit1=" and (tesopredios.nombrepropietario  like '%".$_POST[nombre]."%') ";}
                        if ($_POST[documento]!=""){$crit2=" and tesopredios.cedulacatastral like '%$_POST[documento]%' ";}
                        if ($_POST[direccion]!=""){$crit3=" and (tesopredios.direccion  like '%".$_POST[direccion]."%') ";}
                        if ($_POST[cedula]!=""){$crit4=" and (tesopredios.documento  like '%".$_POST[cedula]."%') ";}
                        $sqlr="select *from tesopredios where tesopredios.estado='S' $crit1 $crit2 $crit3 $crit4 order by tesopredios.cedulacatastral, tesopredios.nombrepropietario, tesopredios.cedulacatastral ";
                        $resp = mysql_query($sqlr,$linkbd);
                        $ntr = mysql_num_rows($resp);
                        $con=1;
                        echo "
                        <table class='inicio' align='center' width='99%'>
                            <tr><td colspan='10' class='titulos'>.: Resultados Busqueda:</td></tr>
                            <tr><td colspan='8'>Terceros Encontrados: $ntr</td></tr>
                            <tr>
                                <td class='titulos2' width='2%'>Item</td>
                                <td class='titulos2' width='30%'>CODIGO CATASTRAL</td>
                                <td class='titulos2' >ORD</td>
                                <td class='titulos2' >TOT</td>
                                <td class='titulos2' >PROPIETARIO</td>
                                <td class='titulos2' width='20%'>DOCUMENTO</td>
                                <td class='titulos2' width='20%'>DIRECCION</td>
                                <td class='titulos2' width='20%'>TIPO PREDIO</td>
                            </tr>";	
                        $iter='zebra1';
                        $iter2='zebra2';
                        while ($row =mysql_fetch_row($resp)) 
                        {
                            echo"
							<tr onClick=\"javascript:ponprefijo('$row[0]','$row[1]','$row[2]')\" class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
								<td>$con</td>
								<td>$row[0]</td>
								<td>$row[1]</td>
								<td>$row[2]</td>
								<td>$row[6]</td>
								<td>$row[5]</td>
								<td>$row[7]</td>
								<td>".obtenerNombre($row[15])."</td>
							</tr>";
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
