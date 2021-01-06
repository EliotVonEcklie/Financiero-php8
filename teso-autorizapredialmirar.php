<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
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
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
   		<script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("teso");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a href="teso-autorizapredial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a href="teso-buscaautorizapredial.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>		  
        </table>
		<form name="form2" method="post" action="">
        <?php
			$_POST[numpredial]=$_GET[idauto];
			$sqlrg="SELECT * FROM tesoautorizapredial WHERE id_auto='$_POST[numpredial]'";
			$rowg=mysql_fetch_row(mysql_query($sqlrg,$linkbd));
			$_POST[fecha]=date('d/m/Y',strtotime($rowg[2]));
			$_POST[vigencia]="";
			$_POST[fechav]=date('d/m/Y',strtotime($rowg[3]));
			$_POST[detallerc]="";
			$_POST[codcat]=$rowg[1];
			$_POST[ordt]=$rowg[11];
			$_POST[tot]=$rowg[12];
			$_POST[descripcion]=$rowg[5];
			$_POST[autoriza]=$rowg[6];
			$_POST[valor]="$".number_format($rowg[4],2);
			$anos="";
			$sqlra="SELECT vigencia FROM tesoautorizapredial_det WHERE id_auto='$_POST[numpredial]' ORDER BY vigencia";
			$respa = mysql_query($sqlra,$linkbd);
			while ($rowa =mysql_fetch_row($respa)){$anos=$anos.$rowa[0].", ";}
			$_POST[periodos]=$anos;
			$_POST[dcuentas]=array();
			$_POST[dncuentas]=array();
	 		$_POST[dtcuentas]=array();		 
		 	$_POST[dvalores]=array();
	 		$sqlrq="SELECT * FROM tesopredios WHERE cedulacatastral='$_POST[codcat]' AND ord='$_POST[ordt]' AND tot='$_POST[tot]'";
	 		$resq=mysql_query($sqlrq,$linkbd);
	 		while($rowq=mysql_fetch_row($resq))
	 		{
				$_POST[catastral]=$rowq[0];
				$_POST[ntercero]=$rowq[6];
				$_POST[tercero]=$rowq[5];
				$_POST[direccion]=$rowq[7];
				$_POST[ha]=$rowq[8];
				$_POST[mt2]=$rowq[9];
				$_POST[areac]=$rowq[10];
				$_POST[avaluo]=number_format($rowq[11],2);
				$_POST[avaluo2]=number_format($rowq[11],2);
				$_POST[vavaluo]=$rowq[11];
				$_POST[tipop]=$rowq[14];
				if($_POST[tipop]=='urbano'){$_POST[estrato]=$rowq[15];$tipopp=$rowq[15];}
				else{$_POST[rangos]=$rowq[15];$tipopp=$rowq[15];}
			}
			
		?>
			<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="6" style='width:93%'>Autorizacion Liquidacion Predial</td>
                    <td class="cerrar" style='width:7%'><a href="teso-principal.php">Cerrar</a></td>
      			</tr>
     			<tr>
       				<td class="saludo1">No Autorizacion:</td>
       				<td width="52"><input name="numpredial" type="text" value="<?php echo $_POST[numpredial]?>"  size="8"  readonly></td>
                    <td class="saludo1">Fecha:</td>
                    <td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>"  size="10" readonly></td>
                    <td class="saludo1">Vigencia:</td>
                    <td><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" size="10" readonly></td>
             	</tr>
	  			<tr>
                	<td class="saludo1">Proyeccion Liquidacion:</td>
                    <td><input name="fechav" type="text" value="<?php echo $_POST[fechav]?>" size="10" readonly></td>
                    <td class="saludo1">Periodos:</td>
                    <td ><input type="text" name="periodos"  value='<?php echo $_POST[periodos] ?>' style="width:90%" readonly></td> 
                    <td  class="saludo1">Codigo Catastral:</td>
          			<td>
                        <input id="codcat" type="text" name="codcat" size="20" value="<?php echo $_POST[codcat]?>" readonly>
                        <input id="ordt" type="text" name="ordt" size="3"  value="<?php echo $_POST[ordt]?>" readonly>
                        <input id="tot" type="text" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly>
                   </td>
        		</tr>     
				<tr>
					<td class="saludo1">Descripcion Pago:</td>
                    <td><input type="text" name="descripcion" value="<?php echo $_POST[descripcion] ?>" size="40" readonly></td>
					<td class="saludo1">Autoriza Pago:</td>
                    <td><input type="text" name="autoriza" value="<?php echo $_POST[autoriza] ?>" size="40" readonly></td>
					<td class="saludo1">Valor Pago:</td>
                    <td><input type="text" name="valor" value="<?php echo $_POST[valor] ?>" size="10" readonly></td>
				</tr>	  
	  		</table>
  			<table class="inicio">
	  			<tr>
	    			<td class="titulos" colspan="8">Informacion Predio</td></tr>
	  			<tr>
	 				<td width="119" class="saludo1">Codigo Catastral:</td>
	  				<td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="catastral" type="text" id="catastral" onBlur="buscater(event)"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" size="20" readonly></td>
		 			<td width="82" class="saludo1">Avaluo:</td>
	  				<td colspan="5"><input name="avaluo" type="text" id="avaluo"  value="<?php echo $_POST[avaluo]?>" size="20" readonly></td>
       			</tr>
      			<tr> 
                	<td width="82" class="saludo1">Documento:</td>
	  				<td><input name="tercero" type="text" id="tercero" value="<?php echo $_POST[tercero]?>" size="20" readonly></td>
	  				<td width="119" class="saludo1">Propietario:</td>
	  				<td width="202" colspan="5">
                    	<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
                        <input name="ntercero" type="text" id="propietario" value="<?php echo $_POST[ntercero]?>" size="76" readonly>
                    </td>
				</tr>
      			<tr>
	  				<td width="119" class="saludo1">Direccion:</td>
	  				<td width="202" >
                    	<input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> 
                        <input name="direccion" type="text" id="direccion" value="<?php echo $_POST[direccion]?>" size="40" readonly>
                 	</td>
		 			<td width="82" class="saludo1">Ha:</td>
	  				<td width="124"><input name="ha" type="text" id="ha" value="<?php echo $_POST[ha]?>" size="6" readonly></td>
	  				<td width="72" class="saludo1">Mt2:</td>
	  				<td width="144"><input name="mt2" type="text" id="mt2" value="<?php echo $_POST[mt2]?>" size="6" readonly></td>
	  				<td width="76" class="saludo1">Area Cons:</td>
	  				<td width="206"><input name="areac" type="text" id="areac" value="<?php echo $_POST[areac]?>" size="6" readonly></td>
      			</tr>
	  			<tr>
	     			<td width="119" class="saludo1">Tipo:</td><td width="202">
                    	<select name="tipop" onChange="validar();" disabled>
       						<option value="">Seleccione ...</option>
				  			<option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
  				  			<option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				  		</select>
                 </td>
         		<?php
		 		if($_POST[tipop]=='urbano')
		 		{
		  		?> 
       			 	<td class="saludo1">Estratos:</td>
                 	<td>
                    	<select name="estrato"  disabled>
       						<option value="">Seleccione ...</option>
            				<?php
								$sqlr="select * from estratos where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									echo "<option value=$row[0] ";
									$i=$row[0];
									if($i==$_POST[estrato]){echo "SELECTED";$_POST[nestrato]=$row[1];}
									echo ">".$row[1]."</option>";	 	 
								}	 	
							?>            
						</select> 
                    	<input type="hidden" value="<?php echo $_POST[nestrato]?>" name="nestrato">
            		</td>  
          		<?php
		 		}
		 		else
		  		{
				?>  
					<td class="saludo1">Rango Avaluo:</td>
            		<td>
            			<select name="rangos"  disabled>
       						<option value="">Seleccione ...</option>
            				<?php
								$sqlr="select * from rangoavaluos where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				   				{
									echo "<option value=$row[0] ";
									$i=$row[0];
					 				if($i==$_POST[rangos]){echo "SELECTED";$_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";}
					  				echo ">Entre ".$row[1]." - ".$row[2]." SMMLV</option>";	 	 
								}	 	
							?>            
						</select>
            			<input type="hidden" value="<?php echo $_POST[nrango]?>" name="nrango">            
                        <input type="hidden" value="0" name="agregadet"></td>
           		<?php
		  		}
		  		?> 
        		</tr> 
      		</table>
	  		
	</form>
</body>
</html>