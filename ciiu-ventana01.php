<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>:: Spid - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script> 
			function ponprefijo(pref,opc,tarifa)
			{ 
				parent.document.form2.ciiu.value =pref  ;	
				parent.document.form2.nciiu.value =opc ;
				parent.document.form2.tciiu.value =tarifa ;	
				parent.document.form2.bci.value='1';
				parent.document.form2.submit();
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form method="post" name="form1">
			<table class="inicio" style="width:99.4%;">
      			<tr>
                	<td class="titulos" colspan="4">:: Buscar Actividad Economica</td>
                    <td class="cerrar" style="width:7%"><a onClick="parent.despliegamodal2('hidden');" >&nbsp;Cerrar</a></td>
                </tr>
      			<tr>
                	<td class="saludo1">:: Nombre:</td>
        			<td><input type="text" name="nombre" value="" style="width:100%;"></td>
        			<td class="saludo1">:: Codigo:</td>
        			<td>
                    	<input type="search" name="documento" id="documento" value="<?php echo $_POST[documento];?>" style="width:60%;"/>
                        <input type="button" name="bboton" onClick="document.form1.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                    </td>
       			</tr>                       
    		</table> 
    		<input name="oculto" type="hidden" value="1">
			<div class="subpantalla" style="height:83.5%; width:99%; overflow-x:hidden;">
				<?php
                    $oculto=$_POST['oculto'];
                    $crit1=" ";
                    $crit2=" ";
                    if ($_POST[nombre]!=""){$crit1="and (codigosciiu.nombre like '%$_POST[nombre]%')";}
                    if ($_POST[documento]!=""){$crit2="and codigosciiu.codigo like '%$_POST[documento]%'";}
                    $sqlr="select *from codigosciiu where codigosciiu.porcentaje<>'' $crit1 $crit2 order by codigosciiu.codigo";
                    $resp = mysql_query($sqlr,$linkbd);
                    $ntr = mysql_num_rows($resp);
                    $con=1;
                    echo "
                    <table class='inicio' align='center' width='99%'>
                        <tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr>
                        <tr><td colspan='8'>Centro Costo Encontrados: $ntr</td></tr>
                        <tr>
                            <td class='titulos2' width='2%'>Item</td>
                            <td class='titulos2' width='10%'>Codigo</td>
                            <td class='titulos2' width='80%'>Nombre</td>
                            <td class='titulos2' width='10%'>Estado</td>
                        </tr>";	
                    $iter='saludo1';
                    $iter2='saludo2';
                    while ($row =mysql_fetch_row($resp)) 
                    {
                        $ncc=$row[1];
                        echo"
                        <tr onClick=\"javascript:ponprefijo('$row[0]','$ncc','$row[2]')\">
                            <td class='$iter'>$con</td>
                            <td class='$iter'>".strtoupper($row[0])."</td>
                            <td class='$iter'>".strtoupper($row[1])."</td>
                            <td class='$iter'>$row[2]</td>
                        </tr>";
                        $con+=1;
                        $aux=$iter;
                        $iter=$iter2;
                        $iter2=$aux;
                    }
                    echo"</table>";
                ?>
            </div>
		</form>
	</body>
</html>  
