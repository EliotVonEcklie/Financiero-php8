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
				document.form2.action="teso-pdfabono.php";
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
					location.href="teso-editaabono.php?idabono="+idcta+"#";
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
					location.href="teso-editaabono.php?idabono="+idcta+"#";
				}
			}

			
			function iratras()
			{
				var idcta=document.getElementById('idcomp').value;
				location.href="teso-buscaabonos.php?idcta="+idcta;
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
					<a onClick="location.href='teso-abonoacuerdopredial.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
					<a onClick="location.href='teso-buscaabonos.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  style="width:29px;height:25px;" title="Imprimir"/></a>
					<a href="#" class="mgbt"  onClick= "iratras()"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>		  
		</table>
        <form name="form2" method="post" action=""> 
			<?php
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
				if(!$_POST[oculto])
				{
					$sqlr="select * from tesoabono ORDER BY id_abono DESC";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
	 				$_POST[maximo]=$r[0];
	 				$_POST[ncomp]=$_GET[idabono];
					$check1="checked"; 
 		 			$fec=date("d/m/Y");
					$sqlr="select * from tesoabono where id_abono=".$_POST[ncomp];
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res))
		 			{
		 				$_POST[fecha]=$r[2];
		 				$_POST[compcont]=$r[1];
		  				$consec=$r[0];	  
	 				}
	 				$_POST[idcomp]=$consec;	
					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
					$_POST[fecha]=$fechaf;	
				}
				$sqlr="select *from tesoabono where tesoabono.id_abono=$_POST[idcomp] ";
  	  			$_POST[encontro]="";
  				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				while ($row =mysql_fetch_row($res)) 
				{
	  				$_POST[concepto]=$row[5];	
	  				$_POST[valorecaudo]=$row[4];	
	 				$_POST[totalc]=$row[4];	
	  				$_POST[tercero]=$row[3];	
	  				$_POST[ntercero]=buscatercero($row[3]);	
	  				//$_POST[idcomp]=$row[0];
		 	 		$_POST[fecha]=$row[2];
		 			$_POST[valor]=0;		 	
	  				$_POST[encontro]=1;
	 				$_POST[numerocomp]=$row[1];
	  				if($row[6]=='S'){
						$valuees="ACTIVO";
						$stylest="width:65%; background-color:#0CD02A; color:white; text-align:center;";
					}	 				  
		 			if($row[6]=='P'){
						$valuees="PAGO";
						$stylest="width:65%; background-color:#0404B4; color:white; text-align:center;";} 	 				  
		 			if($row[6]=='N'){
						$valuees="ANULADO";
						$stylest="width:65%; background-color:#FF0000; color:white; text-align:center;";
						} 
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
                }
                $totalg=number_format($_POST[valorecaudo],2,'.','');
                $_POST[letras] = convertirdecimal($totalg,'.');
                echo "
                    <input type='hidden' name='letras' value='$_POST[letras]'/>";
			?>
    		<table class="inicio" style="width:99.7%">
      			<tr>
        			<td class="titulos" colspan="7">Abonos</td>
        			<td class="cerrar" style="width:7%"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:3.5cm;">N&uacute;mero Abono:</td>
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
         			<td class="saludo1" style="width:1.5cm;">Valor:</td>
		  			<td style="width:20%;">
					<input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo];?>" style="width:33%;" readonly/>
					<?php echo "<input name='estadoc' type='text' id='estadoc' value='$valuees' style='$stylest' readonly/>"?>
					</td>
                    <td rowspan="4" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
        		</tr>
      			<tr>
        			<td class="saludo1">Concepto Abono:</td>
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
              <div class="subpantallac7" style="height:56.3%; width:99.5%; overflow-x:hidden;">
                <table class="inicio">
                    <tr><td colspan="12" class="titulos">Detalles Acuerdos Predial</td></tr>                  
                    <tr>
                        <td class="titulos2">Vigencia</td>
                        <td class="titulos2">Predial</td>
                        <td class="titulos2">Tasa</td>
						<td class="titulos2">Interes Predial</td>
						<td class="titulos2">Descuento Interes</td>
						<td class="titulos2">Bomberil</td>
						<td class="titulos2">Interes Bomberil</td>
						<td class="titulos2">Ambiente</td>
						<td class="titulos2">Interes Ambiente</td>
						<td class="titulos2">Descuento</td>
						<td class="titulos2">Valor total</td> 
                        <td class="titulos2" style="width:5%">Sel.</td>
                        <input type='hidden' name='elimina' id='elimina'/>
                 	</tr>
                        <?php 
                            $iter='zebra1';
                            $iter2='zebra2';
                            $chek=" checked";
                            $sqlr1="SELECT *from tesoabono_det WHERE id_abono='$_POST[idcomp]'";
                            $res1=mysql_query($sqlr1);
                            while($row1=mysql_fetch_assoc($res1))
                            {
                                $sqlr="SELECT *FROM tesoacuerdopredial_det WHERE idacuerdo='$_POST[compcont]' AND estado='P' AND vigencia='".$row1['vigencia']."'";
                                $res=mysql_query($sqlr,$linkbd);
                                $row=mysql_fetch_assoc($res);
                                echo "
                                    <input type='hidden' name='dvigencias[]' value='".$row['vigencia']."' />
                                    <input type='hidden' name='davaluos[]' value='".$rw[0]."' />
                                    <input type='hidden' name='codcatastral' value='".$row1['codcatastral']."' />
                                    <input type='hidden' name='dpredial[]' value='".$row['predial']."'/>
                                    <input type='hidden' name='dtasa[]' value='".$row['tasa']."'/>
                                    <input type='hidden' name='dintpredial[]' value='".$row['intpredial']."'/>
                                    <input type='hidden' name='ddescuenint[]' value='".$row['descuenint']."'/>
                                    <input type='hidden' name='dbomberil[]' value='".$row['bomberil']."'/>
                                    <input type='hidden' name='dintbomberil[]' value='".$row['intbomberil']."'/>
                                    <input type='hidden' name='dambiente[]' value='".$row['ambiente']."'/>
                                    <input type='hidden' name='dintambiente[]' value='".$row['intambiente']."'/>
                                    <input type='hidden' name='ddescuento[]' value='".$row['descuento']."'/>
                                    <input type='hidden' name='dvaltotal[]' value='".$row['valtotal']."'/>

									<tr class='$iter' style='background-color:#4BCADC'>
										<td>".$row['vigencia']."</td>
										<td style='text-align:right;'>$ ".$row['predial']."</td>
										<td>".$row['tasa']."</td>
										<td style='text-align:right;'>$ ".$row['intpredial']."</td>
										<td style='text-align:right;'>$ ".$row['descuenint']."</td>
										<td style='text-align:right;'>$ ".$row['bomberil']."</td>
										<td style='text-align:right;'>$ ".$row['intbomberil']."</td>
										<td style='text-align:right;'>$ ".$row['ambiente']."</td>
										<td style='text-align:right;'>$ ".$row['intambiente']."</td>
										<td style='text-align:right;'>$ ".$row['descuento']."</td>
										<td style='text-align:right;'>$ ".$row['valtotal']."</td>
										<td><input type='checkbox' value='".$row['vigencia']."' disabled $chek>Pago</td>
									</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;

                            }	
						?>
                </table>
            </div>
		</form>
	</body>
</html> 		