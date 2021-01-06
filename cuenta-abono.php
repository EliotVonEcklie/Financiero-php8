<!--V 1000 17/12/16 -->
<?php
	require"comun.inc";
  	require"funciones.inc";
  	session_start();
  	$linkbd=conectar_bd();  
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SPID</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
		function ponprefijo(pref,opc)
		{   
			parent.document.form2.cuenta_abono.value =pref;
			parent.document.form2.ncuenta_abono.value =opc;
			parent.despliegamodal2("hidden");
			parent.document.form2.submit();
		} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
  		<form name="form1" action="" method="post">
            <table class="inicio" style="width:99.6%;">
   				<tr>
       				<td colspan="4" class="titulos" >Buscar CUENTAS </td>
                  	<td class="cerrar" style="width:7%" onClick="parent.despliegamodal2('hidden');">Cerrar</td>
                </tr>
             	<tr><td colspan="6" class="titulos2" >:&middot; Por Descripcion </td></tr>
              	<tr >
              		<td class="saludo1" >:&middot; Numero Cuenta:</td>
                	<td  colspan="3">
                    	<input name="numero" type="text" size="30" >
                      	<input type="button" name="bboton" onClick="document.form1.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
                 	</td>
          		</tr>      
   			</table>
          	<input name="oculto" type="hidden" id="oculto" value="1" >
        	<input name="tobjeto" type="hidden" value="<?php echo $_POST[tobjeto]?>">
        	<input name="tnobjeto" type="hidden" value="<?php echo $_POST[tnobjeto]?>">
    		<div class="subpantalla" style="height:78.5%; width:99.3%; overflow-x:hidden;">
    			<table class="inicio">
    				<tr ><td height="25" colspan="5" class="titulos" >Resultados Busqueda </td></tr>
                    <tr>
      					<td style='width:4%' class="titulos2" >Item</td>
      					<td style='width:12%' class="titulos2" >Cuenta </td>
      					<td class="titulos2" >Descripcion</td>
      					<td style='width:16%' class="titulos2" >Tipo</td>
      					<td style='width:6%' class="titulos2" >Estado</td>	
                    </tr>  	  
					<?php
                        $crit1="";
                        $crit2="";
                        $cond=" where tabla.cuenta like'%".$_POST[numero]."%' or tabla.nombre like '%".strtoupper($_POST[numero])."%'";
                        $sqlr="SELECT * FROM (SELECT cn1.cuenta,cn1.nombre,cn1.naturaleza,cn1.centrocosto,cn1.tercero,cn1.tipo,cn1.estado FROM cuentasnicsp AS cn1 INNER JOIN cuentasnicsp AS cn2 ON cn2.tipo='Auxiliar'  AND cn2.cuenta LIKE CONCAT( cn1.cuenta,  '%' ) WHERE cn1.tipo='Mayor' GROUP BY cn1.cuenta UNION SELECT cuenta,nombre,naturaleza,centrocosto,tercero,tipo,estado FROM cuentasnicsp WHERE tipo='Auxiliar') AS tabla $cond ORDER BY 1";
                        $resp = mysql_query($sqlr,$linkbd);
                        $ntr = mysql_num_rows($resp);
                        $i=1;
                        $co='saludo1a';
                        $co2='saludo2';	
                        while ($r =mysql_fetch_row($resp)) 
                        {			
                            if ($r[5]=='Auxiliar'){echo "<tr class='$co' onClick=\"javascript:ponprefijo('$r[0]','$r[1]')\">";} 
                            else {echo "<tr class='$co'>";} 
                            echo "
                                <td>$i</td>
                                <td>$r[0]</td>
                                <td>$r[1]</td>
                                <td>$r[5]</td>
                                <td style='text-align:center;'>$r[6]</td></tr>";
                            $aux=$co;
                            $co=$co2;
                            $co2=$aux;
                            $i=1+$i;
                        }
                    ?>
				</table>
			</div>
 		</form>
	</body>
</html>