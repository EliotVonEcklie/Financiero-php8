<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<title>:: SPID- Tesoreria</title>
	<script>
		function validar(){
			document.form2.submit();
		}

		function pdf(){
			document.form2.action="teso-pdfsinrecaja.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
		}

		function adelante(scrtop, numpag, limreg, filtro){
			if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value)){
				document.form2.oculto.value=1;
				document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
				document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
				var idcta=document.getElementById('ncomp').value;
				document.form2.action="teso-sinrecibocajaver.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		}

		function atrasc(scrtop, numpag, limreg, filtro){
			if(document.form2.ncomp.value>1){
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.ncomp.value-1;
				document.form2.idcomp.value=document.form2.idcomp.value-1;
				var idcta=document.getElementById('ncomp').value;
				document.form2.action="teso-sinrecibocajaver.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
		 	}
		}

		function iratras(scrtop, numpag, limreg, filtro){
			var idcta=document.getElementById('ncomp').value;
			location.href="teso-buscasinrecibocaja.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
		}

		function validar2(){
			//   alert("Balance Descuadrado");
			document.form2.oculto.value=1;
			document.form2.action="teso-sinrecibocajaver.php";
			document.form2.submit();
		}
	</script>
	<script src="css/programas.js"></script>
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
	<link href="css/css3.css" rel="stylesheet" type="text/css" />
	<link href="css/tabs.css" rel="stylesheet" type="text/css" />
	<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=22*$totreg;
		?>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-sinrecibocaja.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> 
			<a href="#" class="mgbt1"><img src="imagenes/guardad.png"  alt="Guardar" /></a>
			<a href="teso-buscasinrecibocaja.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a> 
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
			<a href="#" onClick="pdf()" class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a> 
			<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php

$vigencia=date(Y);
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
	$sqlr="select *from cuentacaja where estado='S' and vigencia=".$_SESSION["vigencia"];
//	echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacaja]=$row[1];
	}
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
$linkbd=conectar_bd();
$sqlr="select max(id_recibos) from  tesosinreciboscaja ORDER BY id_recibos DESC";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$_GET[idrecibo];
	 $_POST[idcomp]=$_GET[idrecibo];
}
if(!$_POST[oculto])
{
	$_POST[tabgroup1]=1;
$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cobrorecibo]=$row[0];
	 $_POST[vcobrorecibo]=$row[1];
	 $_POST[tcobrorecibo]=$row[2];	 
	}
}
 $sqlr="select * from tesosinreciboscaja where id_recibos=$_POST[idcomp]";
 $res=mysql_query($sqlr,$linkbd); //echo $sqlr;
			while($r=mysql_fetch_row($res))
		 {		  
		  $_POST[tiporec]=$r[10];
		 }

switch($_POST[tiporec]) 
  	 {
	 
	  case 3:
	 $sqlr="select *from tesosinreciboscaja,tesosinrecaudos where tesosinrecaudos.id_recaudo=tesosinreciboscaja.id_recaudo and tesosinreciboscaja.id_recibos=".$_POST[idcomp];
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	//$_POST[idcomp]=$row[0];	
	$_POST[idrecaudo]=$row[11];	
	$_POST[fecha]=$row[2];
	$_POST[vigencia]=$row[3];		
	$_POST[concepto]=$row[17];	
	$_POST[tiporec]=$row[10];	
	$_POST[modorec]=$row[5];		
	$_POST[banco]=$row[7];
	$_POST[cb]=$row[6];
	 $_POST[estadoc]=$row[9];
		   if ($_POST[estadoc]=='N')
		   $_POST[estado]="ANULADO";
		   else
		   $_POST[estado]="ACTIVO";	 		
	$_POST[valorecaudo]=$row[8];				
	$_POST[tercero]=$row[15];				
	$_POST[ntercero]=buscatercero($_POST[tercero]);						
	}
		break;	
	}

switch($_POST[tabgroup1])
{
case 1:
$check1='checked';
break;
case 2:
$check2='checked';
break;
case 3:
$check3='checked';
}
?>
 <form name="form2" method="post" action=""> 
 <input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>" >
 <input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
 
 <?php 
 if($_POST[oculto])
 {
  /*$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] ";
 // echo "$sqlr";
  	  $_POST[encontro]="";
  $res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	  $_POST[concepto]=$row[6];	
	  $_POST[valorecaudo]=$row[5];	
	  $_POST[totalc]=$row[5];	
	  $_POST[tercero]=$row[4];	
	  $_POST[ntercero]=buscatercero($row[4]);	
	  $_POST[modorec]=$row[5];			 		  
	$_POST[banco]=$row[7];
	  $_POST[encontro]=1;
	}*/
 }
 ?>
 <div class="tabsic" style="height:36%; width:99.6%;">
 <div class="tab">
 	<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	<label for="tab-1">Ingresos Propios</label>
	<div class="content" style="overflow-x:hidden;">
		<table class="inicio" align="center" >
    	<tr >
        	<td class="titulos" colspan="8">Ingresos Propios</td>
        	<td style="width:7%" class="cerrar"><a href="teso-principal.php"> Cerrar</a></td>
      	</tr>
      	<tr>
        	<td style="width:2.5cm" class="saludo1" >No Recibo:</td>
        	<td style="width:15%" >
            	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" >
                <input id="idcomp" name="idcomp" type="text" style="width:50%" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  >
                <input id="ncomp" name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" >
                <input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
           	</td>
	  		<td style="width:2.5cm" class="saludo1">Fecha:</td>
        	<td style="width:10%" >
            	<input name="fecha" type="text"  onKeyDown="mascara(this,'/',patron,true)"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fecha]?>" style="width:100%" maxlength="10" readonly>        
           	</td>
         	<td style="width:2.5cm" class="saludo1">Vigencia:</td>
		  	<td style="width:10%">
            	<input type="text" id="vigencia" name="vigencia" style="width:100%" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>
          	</td>
		  	<td style="width:2.5cm" class="saludo1">Estado:</td>
		  	<td style="width:10%" >
            	<?php 
					if($_POST[estado]=='ACTIVO'){
						echo "<input name='estado' type='text' value='ACTIVO' size='5' style='width:100%; background-color:#0CD02A; color:white; text-align:center;' readonly >";
					}
					else
					{
						echo "<input name='estado' type='text' value='ANULADO' size='5' style='width:100%; background-color:#FF0000; color:white; text-align:center;' readonly >";
					}
				?>
                <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">      
           	</td>       
        </tr>
      	<tr>
        	<td class="saludo1"> Recaudo:</td>
            <td> 
            	<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" disabled >
         			<option value="1" <?php if($_POST[tiporec]=='1') echo "SELECTED"; ?>>Predial</option>
          			<option value="2" <?php if($_POST[tiporec]=='2') echo "SELECTED"; ?>>Industria y Comercio</option>
          			<option value="3" <?php if($_POST[tiporec]=='3') echo "SELECTED"; ?>>Otros Recaudos</option>
        		</select>
          	</td>
        	<td class="saludo1">No Liquid:</td>
            <td>
            	<input name="idrecaudo" type="text" id="idrecaudo" onChange="validar()" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[idrecaudo]?>" style="width:100%" readonly> 
           	</td>
	 		<td class="saludo1">Recaudado en:</td>
            <td colspan="3">
            	<input id="modorec" name="modorec" type="text" style="width:15%; text-transform:uppercase" value="<?php echo $_POST[modorec] ?>" readonly> 
        		<?php
		  		if ($_POST[modorec]=='banco'){
				?>
         			<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:84%;" disabled>
	      				<option value="">Seleccione....</option>
						<?php
                        $linkbd=conectar_bd();
                        $sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
                        $res=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($res)){
                            echo "<option value=$row[1] ";
                            $i=$row[1];
                            if($i==$_POST[banco]){
                                echo "SELECTED";
                                $_POST[nbanco]=$row[4];
                                $_POST[ter]=$row[5];
                                $_POST[cb]=$row[2];
                            }
                            echo ">".$row[2]." - Cuenta ".$row[3]." - ".$row[4]."</option>";	 	 
                        }	 	
                        ?>
            		</select>
       				<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           
                	<input type="hidden" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%" readonly>
            	</td>
        	<?php
		   	}
			?> 
  		</tr>
	  	<tr>
        	<td class="saludo1">Concepto:</td>
            <td colspan="7">
            	<input name="concepto" type="text" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[concepto] ?>" style="width:100%" readonly>
           	</td>
       	</tr>
      	<tr>
        	<td class="saludo1">Valor:</td>
            <td>
            	<input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly >
           	</td>
            <td class="saludo1">Documento: </td>
        	<td >
            	<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly>
         	</td>
		  	<td class="saludo1">Contribuyente:</td>
	  		<td colspan="3">
            	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" onKeyUp="return tabular(event,this) "  readonly>
                <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	    		<input type="hidden" value="1" name="oculto" id="oculto">
                <input type="hidden" value="<?php echo $_POST[tiporeca]?>"  name="trec">
	    		<input type="hidden" value="0" name="agregadet">
           	</td>
      	</tr>     
	</table>
	</div>
 </div> <!-- Termina tab -->

 <div class="tab">
 	<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	<label for="tab-2">Afectacion Presupuestal</label>
	<div class="content" style="overflow-x:hidden;">
		<table class="inicio" style="overflow:scroll">
         					<tr><td class="titulos" colspan="3">Detalle Comprobantes</td></tr>
        					<tr>
                            	<td class="titulos2">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2">Valor</td>
                         	</tr>
                            <input type="hidden" id="totaldes" name="totaldes" value="<?php echo $_POST[totaldes]?>" readonly>
							
      						<?php
									$totaldes=0;
									$_POST[dcuenta]=array();
									$_POST[ncuenta]=array();
									$_POST[rvalor]=array();

									$sqlr="select *from pptosinrecibocajappto where idrecibo=$_POST[idcomp] and vigencia=$_POST[vigencia] and cuenta!=''";
									$resd=mysql_query($sqlr,$linkbd);
									
									$iter='saludo1a';
									$iter2='saludo2';
									$cr=0;
									while($rowd=mysql_fetch_row($resd))
									{
								    $nresult=buscacuentapres($rowd[1],$rowd[4]);
											echo "<tr class=$iter>
												<td >
													<input name='dcuenta[]' value='$rowd[1]' type='text' size='20' readonly>
												</td>
												<td >
													<input name='ncuenta[]' value='$nresult' type='text' size='55' readonly>
												</td>
												<td >
													<input name='rvalor[]' value='".number_format($rowd[3],2)."' type='text' size='10' readonly>
												</td>
											</tr>";
									$var1=$rowd[3];
									$var1=$var1;
									$cuentavar1=$cuentavar1+$var1;
									$_POST[varto]=number_format($cuentavar1,2,".",",");
									 }
									 echo "<tr class=$iter><td> </td></tr>";
									echo "<tr >
											<td ></td>
											<td>Total:</td>
											<td >
												<input name='varto' id='varto' value='$_POST[varto]' size='10' readonly>
											</td>
										 </tr>";
								
							?>
							<input type='hidden' name='contrete' value="<?php echo $_POST[contrete] ?>" />
        				</table>
	</div>

 </div><!-- Termina tab -->
 </div>
	
    <div class="subpantalla" style="height:52%; width:99.6%; overflow-x:hidden;">
    <?php
    switch($_POST[tiporec]){
		case 3: ///*****************otros recaudos *******************
 			$_POST[trec]='OTROS RECAUDOS';	 
 		 	$_POST[dcoding]= array(); 		 
		 	$_POST[dncoding]= array(); 		 
		 	$_POST[dvalores]= array(); 
  			$sqlr="select *from tesosinrecaudos_det where tesosinrecaudos_det.id_recaudo=$_POST[idrecaudo] and estado ='S'  and 3=$_POST[tiporec]";
  			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) {
				$_POST[dcoding][]=$row[2];
				$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 =mysql_fetch_row($res2); 
				$_POST[dncoding][]=$row2[0];			 		
				$_POST[dvalores][]=$row[3];		 	
			}
		break;
   	}
   	?>
	<table class="inicio">
		<tr>
        	<td colspan="4" class="titulos">Detalle Recibo de Caja</td>
       	</tr>                  
		<tr>
        	<td width="20%" class="titulos2">Codigo</td>
            <td class="titulos2">Ingreso</td>
            <td width="15%" class="titulos2">Valor</td>
       	</tr>
	  	<?php
		$iter='saludo1a';
		$iter2='saludo2';
		$_POST[totalc]=0;
		for ($x=0;$x<count($_POST[dcoding]);$x++){		 
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
				<td>
					<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='hidden'>".$_POST[dcoding][$x]."
				</td>
				<td>
					<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='hidden'>".$_POST[dncoding][$x]."
				</td>
				<td align='right'>
					<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'>".number_format($_POST[dvalores][$x],2,',','.')."
				</td>
			</tr>";
		 	$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 	$_POST[totalcf]=number_format($_POST[totalc],2);
		 	$aux=$iter;
		 	$iter=$iter2;
		 	$iter2=$aux;
		}
 		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." Pesos";
		echo "<tr class='$iter'>
		 	<td></td>
			<td>Total</td>
			<td align='right'>
				<input name='totalcf' type='hidden' value='$_POST[totalcf]' readonly>
				<input name='totalc' type='hidden' value='$_POST[totalc]'>".number_format($_POST[totalc],2,',','.')."
			</td>
		</tr>
		<tr class='titulos2'>
			<td>Son:</td>
			<td colspan='5' >
				<input name='letras' type='hidden' value='$_POST[letras]'>".$_POST[letras]."
			</td>
		</tr>";
		?> 
	   	</table>
  	</div>
</form>
 </td></tr>
</table>
</body>
</html>