<?php //V 1000 12/12/16 ?> 
<!--V 1.0 15/09/2016 Creada por Ricardo-->
<?php
	require "comun.inc";
	require"funciones.inc";
	require "validaciones.inc";
	$linkbd=conectar_bd();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script> 
			function ponprefijo(vig,ncom,soli,obj)
			{ 
				parent.document.form2.vigencia.value =vig;
				parent.document.form2.ncomp.value =ncom;
				parent.document.form2.idcomp.value =ncom;					
				parent.document.form2.solicita.value=soli;
				parent.document.form2.objeto.value=obj;
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body >
  		<form name="form2" action="" method="post">
        	<?php 
				if ($_POST[oculto]=='')
				{
					$_POST[vigencia]=$_GET[vigencia];
					$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
				}
			?>
			<table  class="inicio" style="width:99.4%;">
            
      			<tr>
        			<td class="titulos" colspan="4">:: Buscar CDP</td>
                 	<td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:3.5cm;">:: Numero CDP:</td>
        			<td>
                    	<input type="search" name="numero"  value="<?php echo $_POST[numero];?>" />
						<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;"/>
                    </td>
       			</tr>                       
    		</table> 
     		<input type="hidden" name="vigencia" value="<?php echo $_POST[vigencia]?>"/>
          	<input type="hidden" name="oculto" id="oculto"  value="1">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
    		<div class="subpantalla" style="height:84.5%; width:99%; overflow-x:hidden;">
				<?php
                    $linkbd=conectar_bd();
					$vigusu=$_GET[vigencia];

					$crit1=" ";
					$crit2=" ";
					if ($_POST[vigencia]!="")
					$crit1=" and pptocdp.vigencia ='$_POST[vigencia]' ";
					else
					$crit1=" and pptocdp.vigencia ='$vigusu' ";
					if ($_POST[numero]!="")
					$crit2=" and pptocdp.consvigencia like '%$_POST[numero]%' ";
					
					
					$con=1;
					if($_POST[iddeshff]==1){$tff01=9;$tff02=10;}
					else {$tff01=8;$tff02=9;}
					echo "<table class='inicio' align='center'><tr><td colspan='$tff01' class='titulos'>.: Resultados Busqueda:</td></tr>
					<tr><td colspan='$tff02'>Certificado Disponibilidad Presupuestal Encontrados: $ntr</td></tr>
					<tr>
					<td class='titulos2' style='width:5%'>Vigencia</td>
					<td class='titulos2' style='width:4%'>Numero</td>
					<td class='titulos2' >Valor</td>
					<td class='titulos2' style='width:10%'>Solicita</td>
					<td class='titulos2'>Objeto</td>
					<td class='titulos2' style='width:7%'>Fecha</td>
					<td class='titulos2' style='width:4%'>Estado</td>";
					$iter='zebra1';
					$iter2='zebra2';
					
					$sqlr="select consvigencia,valor,fecha,estado from pptocdp where estado='S' and tipo_mov='201' $crit1 $crit2 order by consvigencia desc";
					 //echo $sqlr;
					$resp=mysql_query($sqlr,$linkbd);
					 while ($row =mysql_fetch_row($resp)) 
					 {
					 	$saldoCDP=generaSaldoCDP($row[0],$vigusu);

					 	if($saldoCDP>0){
					 		$sqlr1="select solicita, objeto from pptocdp where consvigencia=$row[0] and vigencia=$vigusu and tipo_mov='201' ";
						$r=mysql_query($sqlr1,$linkbd);
						$ro=mysql_fetch_row($r);
						switch ($row[3]) 
						{
							case "S":	$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";break;
							case "N":	$imgsem="src='imagenes/sema_verdeR.jpg' title='Anulado'";break;
							case "C":	$imgsem="src='imagenes/sema_verdeON.jpg' title='Completo'";break;
							case "R": 	$imgsem="src='imagenes/sema_rojoON.jpg' title='Reversado'";break;
						}
						 echo "
						 <tr class='$iter' onClick=\"javascript:ponprefijo('$vigusu','$row[0]','$ro[0]','$ro[1]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
						 <td>$vigusu</td>
						 <td>$row[0]</td>
						 <td style='text-align:right;'>".number_format($row[1],2)."</td>
						 <td>$ro[0]</td>
						 <td>$ro[1]</td>
						 <td style='text-align:center;'>".date('d-m-Y',strtotime($row[3]))."</td>
						 <td style='text-align:center;'><img $imgsem style='width:18px'/></td>";
						 $con+=1;
						 $aux=$iter;
						 $iter=$iter2;
						 $iter2=$aux;
					 	}
						
					}
					 echo"</table>";
				?>
			</div>
		</form>
	</body>
</html>