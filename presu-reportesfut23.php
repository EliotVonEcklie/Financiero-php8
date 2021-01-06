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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="pdfejecuciongastos.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="presu-ejecuciongastosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
            <tr>
				<?php
					$informes=array();
					$informes[1]="538";
					$informes[2]="539";
					$informes[3]="540";
					$informes[4]="541";
					$informes[5]="543";
					$informes[6]="544";
                ?>
  				<td colspan="3" class="cinta"><a class="mgbt" onClick="location.href='presu-reportesfut.php'"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a><a onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir" style="width:29px; height:25px;"></a><a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a><a href="<?php echo "archivos/".$_SESSION[usuario]."informecgr".$fec.".csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv" style="width:29px; height:25px;"></a><a onClick="location.href='presu-reportesfut.php'" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
  			</tr>
		</table>
		<form name="form2" method="post" action="presu-reportesfut23.php">
 			<?php
  				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				if($_POST[bc]!='')
			 	{
			  		$nresul=buscacuentapres($_POST[cuenta],2);			
			  		if($nresul!='')
			   		{
			  			$_POST[ncuenta]=$nresul;
					  	$sqlr="select *from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and vigencia='$vigusu'";
					  	$res=mysql_query($sqlr,$linkbd);
					  	$row=mysql_fetch_row($res);
					  	$_POST[valor]=$row[5];		  
					  	$_POST[valor2]=$row[5];		  			  
			  		}
			  		else {$_POST[ncuenta]="";}
				}
			 	$sqlr="select *from configbasica where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	 			{
  					$_POST[nitentidad]=$row[0];
  					$_POST[entidad]=$row[1];
					$_POST[codent]=$row[8];
 				 }
			?>
    		<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="6">.: SGR CIERRE FISCAL</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='presu-principal.php'">&nbsp;Cerrar</a></td>
     	 		</tr>
      			<tr>
					<td class='saludo1'>Periodos</td>
					<td>
						<select name="periodos" id="periodos" onChange="validar()" style="width:45%;" >
      						<option value="">Sel..</option>
	  						<?php	  
  	  							$sqlr="Select * from chip_periodos  where estado='S' order by id";		
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[periodos])
									{
										echo "<option value='$row[0]' SELECTED>$row[2]</option>";
										$_POST[periodo]=$row[1]; 
										$_POST[cperiodo]=$row[2]; 	
									}
									else {echo "<option value='$row[0]'>$row[2]</option>";}
								}
							?>
      					</select>
                        <input type="hidden" name="periodo" value="<?php echo $_POST[periodo]?>">
                    	<input type="text" name="cperiodo" value="<?php echo $_POST[cperiodo]?>"  style="width:45%;" readonly>
					</td>
					<td class="saludo3" style="width:11%;">Codigo Entidad</td>
                	<td>
                    	<input name="codent" type="text" value="<?php echo $_POST[codent]?>">		
        				<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> 
                        <input type="hidden" value="1" name="oculto">
                  	</td>
           		</tr>      
    		</table>
     		<?php
				if($_POST[bc]!='')//**** busca cuenta
				{
			  		$nresul=buscacuentapres($_POST[cuenta],2);
			  		if($nresul!='')
			   		{
			  			$_POST[ncuenta]=$nresul;
			  			$sqlr="select * from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and vigencia='$vigusu' and vigenciaf='$vigusu'";
			  			$res=mysql_query($sqlr,$linkbd);
			 			$row=mysql_fetch_row($res);
			  			$_POST[valor]=$row[5];		  
			  			$_POST[valor2]=$row[5];		  			  
  			  			echo "<script>document.form2.fecha.focus(); document.form2.fecha.select();</script>";
			  		}
			 		else
			 		{
			 			$_POST[ncuenta]="";
			 			echo "<script>alert('Cuenta Incorrecta');document.form2.cuenta.focus();</script>";
			  		}
			 	}
			?>
			<div class="subpantallap" style="height:66.5%; width:99.6%;">
  				<?php
					$oculto=$_POST['oculto'];
					$iter="zebra1";
					$iter2="zebra2";
					if($_POST[oculto])
					{
						switch($_POST[reporte])
   						{	
							case 1:	break;
							case 2: break;
							case 3:	break;
	 						case 5: break;
   						}
					}
				?> 
			</div>
        </form>
	</body>
</html>