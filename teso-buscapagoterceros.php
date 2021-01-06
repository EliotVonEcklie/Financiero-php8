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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script src="css/programas.js"></script>
        <script src="css/calendario.js"></script>
		<script>
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar el Pago a Terceros "+idr))
  				{
  					document.form2.oculto.value=2;
					document.form2.var1.value=idr;
					document.form2.submit();
  				}
			}
            function verUltimaPos(id){
                location.href="teso-editapagoterceros.php?idpago="+id;
            }
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a onClick="location.href='teso-pagoterceros.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
				<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
				<a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
       		</tr>	
		</table>
 		<form name="form2" method="post" action="teso-buscapagoterceros.php">
			<table  class="inicio" align="center" >
      			<tr >
        			<td class="titulos" colspan="6">:. Buscar Pago Terceros</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr >
        			<td width="168" class="saludo1">No Pago:</td>
        			<td width="154" ><input name="numero" type="text" value="" ></td>
         			<td width="144" class="saludo1">Concepto Pago: </td>
    				<td width="498" ><input type="text" name="nombre" value="" size="80"/></td>
         			<input type="hidden" name="oculto" id="oculto" value="1"/>
                    <input type="hidden" name="var1" value=<?php echo $_POST[var1];?>/>
       			</tr>                       
   			</table>    
    		<div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
				<?php
                    $oculto=$_POST['oculto'];
                    if($_POST[oculto]==2)
                    {
                        $sqlr="select * from tesopagoterceros where id_pago=$_POST[var1]";
                        $resp = mysql_query($sqlr,$linkbd);
                        $row=mysql_fetch_row($resp);
                        //********Comprobante contable en 000000000000
                        $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where numerotipo=$row[0] and tipo_comp=12";
                        mysql_query($sqlr,$linkbd);
                        //$sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='12 $row[0]'";
                        // mysql_query($sqlr,$linkbd);	
                        //******** RECIBO DE CAJA ANULAR 'N'	 
                        $sqlr="update tesopagoterceros set estado='N' where id_pago=$row[0]";
                        mysql_query($sqlr,$linkbd);
                        //echo $sqlr;
                        /*$sqlr="select * from pptoingtranppto where idrecibo=$row[0]";
                        $resp=mysql_query($sqlr,$linkbd);
                        while($r=mysql_fetch_row($resp))
                        {
                            $sqlr="update pptocuentaspptoinicial set ingresos=ingresos-$r[3] where cuenta='$r[1]'";
                            mysql_query($sqlr,$linkbd);
                        }	
                        $sqlr="delete from pptoingtranppto where idrecibo=$row[0]";
                        $resp=mysql_query($sqlr,$linkbd); */
                    }
                    //if($_POST[oculto])
                    {
                        $crit1=" ";
                        $crit2=" ";
                        if ($_POST[numero]!=""){$crit1=" and tesopagoterceros.id_pago like '%".$_POST[numero]."%' ";}
                        if ($_POST[nombre]!=""){$crit2=" and tesopagoterceros.concepto like '%".$_POST[nombre]."%'  ";}
                        //sacar el consecutivo 
                        //$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
                        $sqlr="select *from tesopagoterceros where tesopagoterceros.id_pago>-1 $crit1 $crit2 order by tesopagoterceros.id_pago DESC";
                        //echo "<div><div>sqlr:".$sqlr."</div></div>";
                        $resp = mysql_query($sqlr,$linkbd);
                        $ntr = mysql_num_rows($resp);
                        $con=1;
                        echo "
                        <table class='inicio' align='center' >
                        <tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr>
                        <tr><td colspan='2'>Recaudos Encontrados: $ntr</td></tr>
                        <tr>
                            <td  class='titulos2'>Codigo</td>
                            <td class='titulos2'>Concepto</td>
                            <td class='titulos2'>Fecha</td>
                            <td class='titulos2'>Contribuyente</td>
                            <td class='titulos2'>Valor</td>
                            <td class='titulos2'>Estado</td>
                            <td class='titulos2' width='5%'><center>Anular</td>
                            <td class='titulos2' width='5%'><center>Ver</td>
                        </tr>";	
                        $iter='zebra1';
                        $iter2='zebra2';
                        while ($row =mysql_fetch_row($resp)) 
                        {
							$sqlr1="select sum(valor) from tesopagoterceros_det where id_pago='$row[0]'";
							$res1 = mysql_query($sqlr1,$linkbd);
							$r1 = mysql_fetch_row($res1);
                            if($_GET[idt]==$row[0]){
                                $estilo='background-color:#FF9';
                            }
                            else{
                                $estilo="";
                            }
                            $nter=buscatercero($row[1]);
                            if($row[9]=='S')
								$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	 				  
							if($row[9]=='N')
								$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'"; 	
							echo "
							<tr class='$iter' onDblClick=\"verUltimaPos($row[0])\" style='text-transform:uppercase; $estilo'>
								<td>$row[0]</td>
								<td>$row[7]</td>
								<td>$row[10]</td>
								<td>$nter</td>
								<td>".number_format($r1[0],2)."</td>
								<td style='text-align:center;'><img $imgsem style='width:18px' ></td>";
							if($row[9]=='S')
								{echo "<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png'></a></td>";}	 
							if($row[9]=='N'){echo "<td></td>";}
							echo "<td style='text-align:center;'><a href='teso-editapagoterceros.php?idpago=$row[0]'><img src='imagenes/buscarep.png'></a></td>
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