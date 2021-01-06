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
		function ponprefijo(codigo,fecha,nombre,valor,estado,placa,cc)
		{   
			parent.document.form2.codigo.value =codigo;
			parent.document.form2.fecha.value =fecha;
			parent.document.form2.nombre.value =nombre;
			parent.document.form2.valor.value=valor;
      parent.document.form2.estado.value=estado;
      parent.document.form2.placa.value=placa;
      parent.document.form2.cc.value=cc;
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
       				<td colspan="4" class="titulos" >Buscar ACTIVOS </td>
                  	<td class="cerrar" style="width:7%" onClick="parent.despliegamodal2('hidden');">Cerrar</td>
                </tr>
             	<tr><td colspan="6" class="titulos2" >:&middot; Por Codigo </td></tr>
              	<tr >
              		<td class="saludo1" >:&middot; Codigo del Activo:</td>
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
    				<tr ><td height="25" colspan="6" class="titulos" >Resultados Busqueda </td></tr>
                    <tr class="titulos2">
      					<td style='width:4%'>Item</td>
                <td style='width:5%'>Codigo</td>
      					<td style='width:12%'>Fecha</td>
      					<td class="titulos2" >Nombre</td>
      					<td style='width:16%'>Valor</td>
      					<td style='width:6%'>Estado</td>	
                    </tr>  	  
					         <?php
                        $placa = str_replace('.', '', $_GET[placa]);
                        function Buscar_datos($cod){
                            global $linkbd;
                            $sqlr="SELECT fechareg,valor,estado FROM `acticrearact` WHERE `codigo`='$cod' and estado = 'S'";
                            $resp = mysql_query($sqlr,$linkbd);
                            $r =mysql_fetch_assoc($resp);
                            return array($r[fechareg],$r[valor],$r[estado]);
                        }

                        $crit1="";
                        $crit2="";


                        if ($_POST[numero]!='') {
                          $sqlr = "SELECT `codigo`,`nombre`,`placa`,`cc` FROM `acticrearact_det` WHERE `codigo`='$_POST[numero]'";
                        }else{
                          $sqlr = "SELECT `codigo`,`nombre`,`placa`,`cc` FROM `acticrearact_det` WHERE `placa` LIKE '$placa%'";
                        }
                     
                        $resp = mysql_query($sqlr,$linkbd);
                        $ntr = mysql_num_rows($resp);
                        $i=1;
                        $co='saludo1a';
                        $co2='saludo2';	
                        while ($r =mysql_fetch_assoc($resp)) 
                        {			
                            $data = Buscar_datos($r[codigo]);
                            echo "<tr class='$co' onClick=\"javascript:ponprefijo('$r[codigo]','$data[0]','$r[nombre]','$data[1]','$data[2]','$r[placa]','$r[cc]')\">";
                            echo "
                                <td>$i</td>
                                <td>$r[codigo]</td>
                                <td>$data[0]</td>
                                <td>$r[nombre]</td>
                                <td>$data[1]</td>
                                <td style='text-align:center;'>$data[2]</td></tr>";
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