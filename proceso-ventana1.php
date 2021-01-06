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
			function ponprefijo(pref,opc,fec)
			{ 
				parent.document.form2.numresolucion.value =pref;
				parent.document.form2.codcatastral.value =opc ;
				parent.document.form2.fecha.value =fec ;
				parent.document.form2.numresolucion.focus();
				parent.document.form2.codcatastral.focus();
				parent.document.form2.fecha.focus();
				parent.despliegamodal2("hidden");
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
      				<td height="25" colspan="3" class="titulos" >Buscar Proceso Persuasivo</td>
                    <td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
    			</tr>
				<tr><td colspan="4" class="titulos2" >:&middot; Por Descripcion </td></tr>
				<tr>
					<td class="saludo1" style='width:3cm;'>:&middot; Numero Cuenta:</td>
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
					$sqlr="select *from tesocobroreporte where tesocobroreporte.idtesoreporte>-1 $crit1 $crit2 group by tesocobroreporte.numresolucion asc";
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
				<td colspan='6' class='saludo3'>Recaudos Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' width='10%'>No Resolucion</td>
				<td class='titulos2'>Codigo Catastral</td>
				<td class='titulos2'>Fecha</td>
				<td class='titulos2'>Total debe</td>
			</tr>";	
          	$iter='saludo1a';
            $iter2='saludo2';
			$filas=1;
			
 			while ($row =mysql_fetch_row($resp)){
				if($gidcta!=""){
					if($gidcta==$row[0]){
						$estilo='background-color:#FF9';
					}
					else{
						$estilo="";
					}
				}
				else{
					$estilo="";
				}	
				$sql1="SELECT pago FROM tesoprediosavaluos WHERE codigocatastral='$row[3]' and vigencia='$row[2]'";
				$r1=mysql_query($sql1,$linkbd);
				$row3=mysql_fetch_row($r1);
				if($row3[0]=="S")
				{
					$p2luzcem1=$cmverde;$p2luzcem2=$cmverde;$p2luzcem3=$cmverde;
				}
				else
				{
					$sql="SELECT proceso FROM tesocobroreporte_adj WHERE numresolucion='$row[16]'";
					$r=mysql_query($sql,$linkbd);
					$row2 =mysql_fetch_row($r);
					if($row2[0]=="resolucion")
					{
						$p2luzcem1=$cmverde;$p2luzcem2=$cmamarillo;$p2luzcem3=$cmrojo;
					}
					elseif ($row2[0]=="citacion")
					{
						$p2luzcem1=$cmverde;$p2luzcem2=$cmverde;$p2luzcem3=$cmamarillo;
					}
					elseif ($row2[0]=="mandamiento")
					{
						$p2luzcem1=$cmverde;$p2luzcem2=$cmverde;$p2luzcem3=$cmverde;
					}
					else
					{
						$p2luzcem1=$cmamarillo;$p2luzcem2=$cmrojo;$p2luzcem3=$cmrojo;
					}
				}
				$sql5="SELECT numresolucion FROM tesoreportecitacion WHERE numresolucion='$row[16]'";
				$r5=mysql_query($sql5,$linkbd);
				$row5=mysql_fetch_row($r5);
				if($row3[0]!="" && $row5[0]=="")
				{
					$idcta="'".$row[0]."'";
					$sqlr1="select sum(valortotal) from tesocobroreporte where numresolucion='$row[16]'";
					$resp1 = mysql_query($sqlr1,$linkbd);
					$row1=mysql_fetch_row($resp1);
					$numfil="'".$filas."'";
					$filtro="'".$_POST[nombre]."'";
					echo"<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\" onClick=\"javascript:ponprefijo('$row[16]','$row[3]','$row[17]')\" style='text-transform:uppercase; $estilo' >
						<td>$row[16]</td>
						<td>$row[3]</td>
						<td>$row[17]</td>
						<td>$ ".number_format($row1[0],2)."</td>
					</tr>";
					$con+=1;
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
					$filas++;
				}
			}
     	echo"</table>";
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
		</form>
	</body>
</html> 
