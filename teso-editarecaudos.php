<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
 	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
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
        <title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function pdf()
			{
				document.form2.action="teso-pdfrecaudos.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			
			function factura()
			{
				document.form2.action="facverpdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			
			function adelante()
			{
				//alert("Balance Descuadrado");
				//document.form2.oculto.value=2;
				if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value))
				{
					//document.form2.oculto.value=1;
					//document.form2.agregadet.value='';
					//document.form2.elimina.value='';
					//document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					var idcta=document.form2.idcomp.value;
					document.form2.action="";
					location.href="teso-editarecaudos.php?idrecaudo="+idcta+"#";
				}
			}
			function atrasc()
			{
				//document.form2.oculto.value=2;
				if(document.form2.idcomp.value>1)
				{
					//document.form2.oculto.value=1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					var idcta=document.form2.idcomp.value;
					location.href="teso-editarecaudos.php?idrecaudo="+idcta+"#";
				}
			}

			
			function iratras()
			{
				var idcta=document.getElementById('idcomp').value;
				location.href="teso-buscarecaudos.php?idcta="+idcta;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <?php
			$numpag=$_GET[numpag];
			$limreg=$_GET[limreg];
			$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='teso-recaudos.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
					<a onClick="location.href='teso-buscarecaudos.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  style="width:29px;height:25px;" title="Imprimir"/></a>
					<a onClick="factura()" class="mgbt"><img src="imagenes/factura2.png"  style="width:29px;height:25px;" title="Imprimir"/></a>
					<a href="#" class="mgbt"  onClick= "iratras()"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>		  
		</table>
        <form name="form2" method="post" action=""> 
			<?php
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
	  			//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if(!$_POST[oculto])
				{
					$check1="checked";
					$fec=date("d/m/Y");	
					$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[1];}
					$sqlr="select * from tesorecaudos ORDER BY id_recaudo DESC";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
	 				$_POST[maximo]=$r[0];
	 				$_POST[ncomp]=$_GET[idrecaudo];
					$check1="checked"; 
 		 			$fec=date("d/m/Y");
					//$_POST[fecha]=$fec; 		 		  			 
					//$_POST[valor]=0;
					//$_POST[valorcheque]=0;
					//$_POST[valorretencion]=0;
					//$_POST[valoregreso]=0;
					//$_POST[totaldes]=0;
					$sqlr="select * from tesorecaudos where id_recaudo=".$_POST[ncomp];
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res))
		 			{
		 				$_POST[fecha]=$r[2];
		 				$_POST[compcont]=$r[1];
		  				$consec=$r[0];	  
		  				$_POST[rp]=$r[4];
						$_POST[vigencia]=$r[3];
	 				}
	 				$_POST[idcomp]=$consec;	
					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
					$_POST[fecha]=$fechaf;	
				}
				$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo=$_POST[idcomp] ";
  	  			$_POST[encontro]="";
  				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				while ($row =mysql_fetch_row($res)) 
				{
	  				$_POST[concepto]=$row[6];	
	  				$_POST[valorecaudo]=$row[5];	
	 				$_POST[totalc]=$row[5];	
	  				$_POST[tercero]=$row[4];	
	  				$_POST[ntercero]=buscatercero($row[4]);	
	  				//$_POST[idcomp]=$row[0];
		 	 		$_POST[fecha]=$row[2];
		 			$_POST[valor]=0;		 	
	  				$_POST[encontro]=1;
	 				$_POST[numerocomp]=$row[1];
	  				if($row[7]=='S'){
						$valuees="ACTIVO";
						$stylest="width:65%; background-color:#0CD02A; color:white; text-align:center;";
					}	 				  
		 			if($row[7]=='P'){
						$valuees="PAGO";
						$stylest="width:65%; background-color:#0404B4; color:white; text-align:center;";} 	 				  
		 			if($row[7]=='N'){
						$valuees="ANULADO";
						$stylest="width:65%; background-color:#FF0000; color:white; text-align:center;";
						} 
				}
				/*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$vigusu;
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 			$consec+=1;*/
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
			?>
    		<table class="inicio" style="width:99.7%">
      			<tr>
        			<td class="titulos" colspan="7">Liquidar Recaudos</td>
        			<td class="cerrar" style="width:7%"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:3.5cm;">N&uacute;mero Liquidaci&oacute;n:</td>
        			<td style="width:15%;">
                    	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="Anterior" style="cursor:pointer;"></a>
                        <input type="hidden" id="numerocomp" name="numerocomp" value="<?php echo $_POST[numerocomp]?>"/>
                        <input type="text" id="idcomp" name="idcomp" value="<?php echo $_POST[idcomp]?>" onBlur="validar2()" readonly/> 
                        <input type="hidden" id="ncomp" name="ncomp" value="<?php echo $_POST[ncomp]?>"/>
                        <input type="hidden" name="compcont"  value="<?php echo $_POST[compcont]?>"/>
                        <a href="#" onClick="adelante()"><img src="imagenes/next.png" title="Siguiente" style="cursor:pointer;"></a> 
                        <input type="hidden" value="a" name="atras"/>
                        <input type="hidden" value="s" name="siguiente"/>
                        <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"/>
                 	</td>
	 				<td class="saludo1" style="width:2.5cm;">Fecha:</td>
        			<td style="width:20%;"><input type="date"  name="fecha" value="<?php echo $_POST[fecha];?>" readonly/></td>
         			<td class="saludo1" style="width:1.5cm;">Vigencia:</td>
		  			<td style="width:20%;">
					<input type="text" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia];?>" style="width:33%;" readonly/>
					<?php echo "<input name='estadoc' type='text' id='estadoc' value='$valuees' style='$stylest' readonly/>"?>
					</td>
                    <td rowspan="4" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
        		</tr>
      			<tr>
        			<td class="saludo1">Concepto Liquidaci&oacute;n:</td>
        			<td colspan="5" ><input type="text" name="concepto" value="<?php echo $_POST[concepto]?>" style="width:100%;" readonly/></td>
             	</tr>  
      			<tr>
        			<td class="saludo1">CC/NIT: </td>
        			<td><input type="text" name="tercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" readonly/></td>
			  		<td class="saludo1">Contribuyente:</td>
	  				<td colspan="3"><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly/></td>
       			</tr>

      		</table>
      		<input type="hidden" value="1" name="oculto">
     		<div class="subpantallac7" style="height:57.3%; width:99.5%; overflow-x:hidden;">
       			<?php 
 					$sqlr="select *from tesorecaudos_det where tesorecaudos_det.id_recaudo=$_POST[idcomp]";
		 			$_POST[dcoding]= array(); 		 
		 			$_POST[dncoding]= array(); 		 
		 			$_POST[dvalores]= array(); 		 
  					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[dcoding][]=$row[2];	
						$_POST[dncoding][]=buscaingreso($row[2]);			 		
    					$_POST[dvalores][]=$row[3];	
					}
 				?>
	   			<table class="inicio">
                    <tr><td colspan="3" class="titulos">Detalle Liquidacion Recaudos</td></tr>                  
                    <tr>
                        <td class="titulos2">Codigo</td>
                        <td class="titulos2">Ingreso</td>
                        <td class="titulos2">Valor</td>
                    </tr>
                    <?php 		
                        $_POST[totalc]=0;
                        $co="saludo1a";
                        $co2="saludo2";
                        for ($x=0;$x<count($_POST[dcoding]);$x++)
                        {		 
                            echo "
                            <input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'/>
                            <input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'/>
                            <input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
                            <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
                                <td>".$_POST[dcoding][$x]."</td>
                                <td>".$_POST[dncoding][$x]."</td>
                                <td style='text-align:right;'>$ ".number_format($_POST[dvalores][$x],2)."</td>
                            </tr>";
                            $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
                            $_POST[totalcf]=number_format($_POST[totalc],2);
                            $totalg=number_format($_POST[totalc],2,'.','');
                            $aux=$co;
                            $co=$co2;
                            $co2=$aux;
                        }
                        if ($_POST[totalc]!='' && $_POST[totalc]!=0){$_POST[letras] = convertirdecimal($totalg,'.');}
                        else {$_POST[letras]=''; $_POST[totalcf]=0;}
                        echo "
                        <input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
                        <input type='hidden' name='totalc' value='$_POST[totalc]'/>
                        <input type='hidden' name='letras' value='$_POST[letras]'/'>
                        <tr class='$co' style='text-align:right;'>
                            <td colspan='2'>Total:</td>
                            <td>$ $_POST[totalcf]</td>
                        </tr>
                        <tr class='titulos2'>
                            <td >Son:</td>
                            <td colspan='2' >$_POST[letras]</td></tr>";
                    ?> 
	   			</table>
			</div>
		</form>
	</body>
</html> 		