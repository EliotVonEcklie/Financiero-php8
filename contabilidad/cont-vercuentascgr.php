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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
 				 <td colspan="3" class="cinta">
					<a href="cont-importacuentas.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a>
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				 </td>
         	</tr>
		</table>
   		<form action="" method="post"  name="form2"> 
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
  			<table class="inicio">
    			<tr>
      				<td class="titulos" colspan="4">:.Buscar Cuentas CGR</td>
	 				<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
    			</tr>
				<tr><td colspan="5" class="titulos2" >:&middot; Por Descripcion </td></tr>
				<tr>
					<td class="saludo1" style="width:3cm">:&middot; Numero Cuenta:</td>
				  	<td colspan="3">
                   		<input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style="width:50%;"/>
                    	<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
			      	</td>
			    </tr>
  			</table>
            <input type="hidden" name="oculto" id="oculto" value="1" >
			<input type="hidden" name="ac" id="ac" value="1" >
			<input type="hidden" name="cod" id="cod" value="1" >
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<div class="subpantallap">
    			<table class="inicio">
    				<tr><td height="25" colspan="3" class="titulos" >:.Resultados Busqueda </td></tr>
    				<tr>
      					<td width="32" class="titulos2" >Item</td>
      					<td width="76" class="titulos2" >Cuenta </td>
      					<td width="140" class="titulos2" >Descripcion</td>
    				</tr>
				<?php 
					$ca=$_POST[ac];
					if ($ca==2)
					{
						$sqlr="select count(*) from comprobante_det where  cuenta='$_POST[cod]'";
						$res=mysql_query($sqlr,$link);
						$cf =mysql_fetch_row($res);
						if($cf[0]==0)
		 				{
							$sqlr="delete from cuentas  where cuenta='$_POST[cod]' ";
							$cont=0;
							$resp=mysql_query($sqlr,$link);
							if (!$resp) 
							{	
	 							echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
								echo "Ocurrió el siguiente problema:<br>";
								echo "<pre>";
								echo "</pre></center></td></tr></table>";
							}
							else
							{
								$ntr = mysql_affected_rows();
								if ($ntr==0){echo"<script>alert('No se puede anular la cuenta por ser de tipo Mayor');</script>";}
							}
						}
						else {echo"<script>alert('No se puede anular, porque la cuenta tiene movimientos contables anteriores');</script>";}
					}   
					$oculto=$_POST['oculto'];
					if($oculto!="")
					{
 						$cond=" cuenta like'%$_POST[numero]%' or nombre like '%strtoupper($_POST[numero])%'";
						$sqlr="Select distinct * from chipcuentas where $cond order by cuenta";
						$resp = mysql_query($sqlr,$linkbd);			
						$co='saludo1a';
	 					$co2='saludo2';	
	 					$i=1;
						while ($r =mysql_fetch_row($resp)) 
	    				{
    						echo"<tr class='$co'";
							if ($r[5]=='Auxiliar'){echo"onClick=\"javascript:ponprefijo('$r[0]','$r[1]')\"";} 
							echo"><td>$i</td>";
    	 					echo "<td >$r[0]</td>";
     	 					echo "<td>".ucwords(strtolower($r[1]))."</td></tr>";      
         					$aux=$co;
         					$co=$co2;
         					$co2=$aux;
		 					$i=1+$i;
   						}
						$_POST[oculto]="";
					}
				?>
				</table>
			</div>
		</form>
	</body>
</html>