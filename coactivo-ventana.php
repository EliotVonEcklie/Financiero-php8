<?php 
	require "comun.inc";
	require "funciones.inc";
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
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			var anterior;
			function ponprefijo(pref,opc,val)
			{ 
				parent.document.form2.codproceso.value =pref;
				parent.document.form2.codcatastral.value =opc ;
				parent.document.form2.total.value =val ;
				parent.document.form2.totalco.value =val ;
				parent.document.form2.bc.value ='1' ;
				parent.document.form2.codigoco.value =pref ;
				parent.document.form2.codproceso.focus();
				parent.document.form2.codcatastral.focus();
				parent.document.form2.total.focus();
				parent.despliegamodal2("hidden");
				parent.document.form2.submit();
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
    	<form action="" method="post" enctype="multipart/form-data" name="form2">
			<?php 
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;
					$_POST[numres]=10;
					$_POST[nummul]=0;
					$_POST[tipo]=$_GET[ti];
				}
				?>
  			<table class="inicio" style="width:99.4%;">
    			<tr>
      				<td height="25" colspan="3" class="titulos" >Buscar Procesos Coactivos</td>
                    <td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
    			</tr>
				<tr>
					<td class="saludo1" style='width:3cm;'>:&middot; Numero Proceso:</td>
				  	<td  colspan="3">
                    	<input type="search" name="numero" id="numero" value="<?php echo $_POST[numero];?>" style='width:50%;'/>
				  		<input type="hidden" name="tipo" id="tipo" value="<?php echo $_POST[tipo]?>"/>
			      		
                        <input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
			      	</td>
			    </tr>
  			</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<div  class="subpantalla" style="height:80.5%; width:99.2%; overflow-x:hidden;">
		     <?php
			 $crit1="";
		     if(!empty($_POST[numero])){
		     	$crit1="tesoreportecitacion.codproceso LIKE '%$_POST[numero]%' ";
		     }	

			 $sqlr="select *from tesoreportecitacion where tesoreportecitacion.codproceso>-1 $crit1  order by tesoreportecitacion.numresolucion asc";
			 $resp = mysql_query($sqlr,$linkbd);
		
		

		$numcontrol=$_POST[nummul]+1;
		if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1")){
			$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
			$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
		}
		else{
			$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
			$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
		}
		if(($_POST[numpos]==0)||($_POST[numres]=="-1")){
			$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
			$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
		}
		else{
			$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
			$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
		}

		$con=1;
		echo "<table class='inicio' align='center'>
			<tr>
				
			</tr>
			<tr>
				<td colspan='6' class='saludo3'>Procesos Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' width='10%'>No Proceso</td>
				<td class='titulos2' width='10%'>No Resolucion</td>
				<td class='titulos2'>Codigo Catastral</td>
				<td class='titulos2'>Descripcion</td>
				<td class='titulos2'>Vigencia</td>
			</tr>";	
          	$iter='saludo1a';
            $iter2='saludo2';
			$filas=1;
			
 			while ($row =mysql_fetch_row($resp)){
 				$sqlr="SELECT SUM(valortotal) FROM tesocobroreporte WHERE codcatastral='$row[2]' GROUP BY codcatastral";
 				$res=mysql_query($sqlr,$linkbd);
 				$valor=mysql_fetch_row($res);
				
				$sqlr1="SELECT *FROM tesoreportemandamiento WHERE codproceso='$row[1]'";
 				$res1=mysql_query($sqlr1,$linkbd);
 				if (!mysql_fetch_row($res1))
				{
					echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
					onMouseOut=\"this.style.backgroundColor=anterior\" onClick=\"javascript:ponprefijo('$row[0]','$row[2]','$valor[0]')\" style='text-transform:uppercase; $estilo' >";
					echo "<td>$row[0]</td>";
					echo "<td>$row[1]</td>";
					echo "<td>$row[2]</td>";
					echo "<td>$row[5]</td>";
					echo "<td>$row[4]</td>";
					echo "</tr>";
				}
				
			}
     	echo"</table>";
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
		</form>
	</body>
</html> 
