<?php //V 1000 12/12/16 ?> 
<!--V 1.0 29/02/2015 Creada por HAFR-->
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script> 
			function ponprefijo(idrp,idcdp,det,valor,saldo,tercero,vigencia)
			{ 
				parent.document.form2.rp.value =idrp  ;
				parent.document.form2.cdp.value =idcdp ;
				parent.document.form2.detallecdp.value =det ;	
				parent.document.form2.valorrp.value =valor ;	
				parent.document.form2.saldorp.value =saldo ;
				parent.document.form2.valor.value =saldo ;	
				parent.document.form2.tercero.value =tercero ;	
				parent.document.form2.vigencia.value =vigencia ;
				parent.document.form2.rp.focus();	
				parent.document.form2.cc.focus();	
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
        			<td class="titulos" colspan="4">:: Buscar Registro</td>
                 	<td class="cerrar"><a onClick="parent.despliegamodal2('hidden');">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:3.5cm;">:: Numero Registro:</td>
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
                    $crit1="";
                    $crit2="";
                    if ($_POST[numero]!=""){$crit1=" and (pptorp.consvigencia like '%$_POST[numero]%') ";}
                    $crit2=" and  pptorp.vigencia=$_POST[vigencia] and  pptocdp.vigencia=$_POST[vigencia]";
					$fecha = $_POST[vigencia].'-12-31';
					$sqlr = "select distinct(p1.vigencia) vigencia ,p1.consvigencia,p1.detalle ,p1.estado,cd1.consvigencia,p1.valor,p1.saldo, p1.tercero 
					from pptorp p1, pptocdp cd1, pptorp_detalle pd1 
					where p1.idcdp=cd1.consvigencia
					and pd1.vigencia = p1.vigencia 
					and pd1.consvigencia = p1.consvigencia 
					and cd1.tipo_mov='201' 
					and p1.tipo_mov='201'
					and p1.vigencia=$_POST[vigencia] 
					and cd1.vigencia=$_POST[vigencia]
					and fx_ppt_saldoregistro (p1.consvigencia ,p1.vigencia,pd1.cuenta ,'$fecha')>0
					union all
					select distinct(p.vigencia) vigencia,p.consvigencia,p.detalle ,p.estado,cd.consvigencia,p.valor,p.saldo, p.tercero 
					from pptorp p , pptocdp cd, pptocuentas p2, pptorp_detalle pd 
					where p.idcdp=cd.consvigencia
					and cd.tipo_mov='201' 
					and p.tipo_mov='201' 
					and pd.vigencia = p.vigencia 
					and pd.consvigencia = p.consvigencia 
					and pd.vigencia  = p2.vigencia 
					and pd.cuenta    = p2.cuenta 
					and p2.regalias ='S'
					and fx_ppt_saldoregistro (p.consvigencia ,p.vigencia,pd.cuenta ,'$fecha')>0
					and p2.vigenciarg like '%$_POST[vigencia]'";



					//$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo, pptorp.tercero from pptorp,pptocdp where pptorp.idcdp=pptocdp.consvigencia and pptocdp.tipo_mov='201' and pptorp.tipo_mov='201' $crit1 $crit2 order by pptorp.consvigencia asc $cond2 ";
					//echo $sqlr;
                    $resp = mysql_query($sqlr,$linkbd);
                    $con=1;
                    echo "
					<table class='inicio' align='center' width='99%'>
						
						<tr>
							<td class='titulos2' style='width:3%'>Item</td>
							<td class='titulos2' style='width:4%'>Vigencia</td>
							<td class='titulos2' style='width:8%'>N� RP</td>
							<td class='titulos2' colspan='2'>Detalle</td>
						</tr>";	
                    $iter='saludo1a';
                    $iter2='saludo2'; 
                    while ($row =mysql_fetch_row($resp)) 
                    {
                    	$saldoRP=generaSaldoRP($row[1],$row[0]);
                    	if($saldoRP!=0){
                    		 $detalle=$row[2];
						$con2=$con+ $_POST[numpos];
                        echo"
                        <tr class='$iter' onClick=\"javascript:ponprefijo('$row[1]','$row[4]','$detalle','$row[5]','$row[6]','$row[7]','$row[0]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
                            <td>$con2</td>
                            <td>$row[0]</td>
                            <td>$row[1]</td>
                            <td colspan='2'>$row[2]</td>
                        </tr>";
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
