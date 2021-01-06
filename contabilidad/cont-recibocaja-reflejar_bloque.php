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
		<script>
			function guardar()
			{
				if (document.form2.fecha.value!='' && ((document.form2.modorec.value=='banco' && document.form2.banco.value!='') || (document.form2.modorec.value=='caja')))
  				{
					if (confirm("Esta Seguro de Guardar"))
  					{
  						document.form2.oculto.value=2;
  						document.form2.submit();
  					}
  				}
  				else
				{
 					alert('Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
  				}
			}
			function pdf()
			{
				document.form2.action="teso-pdfrecaja.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target=""; 
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 				{
					document.form2.oculto.value=1;
					if(document.getElementById('codrec').value!="")
					{document.getElementById('codrec').value=""}
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					document.form2.action="cont-recibocaja-reflejar.php";
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
 				{
					document.form2.oculto.value=1;
					if(document.getElementById('codrec').value!="")
					{document.getElementById('codrec').value=""}
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					document.form2.action="cont-recibocaja-reflejar.php";
					document.form2.submit();
 				}
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="cont-recibocaja-reflejar.php";
				document.form2.submit();
			}
			function callprogress(vValor)
			{
 				document.getElementById("getprogress").innerHTML = vValor;
 				document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';
				document.getElementById("titulog1").style.display='block';
   				document.getElementById("progreso").style.display='block';
     			document.getElementById("getProgressBarFill").style.display='block';
				if (vValor==100){document.getElementById("titulog2").style.display='block';}
			}  
		</script>
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
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="cont-buscarecibocaja-reflejar_bloque.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/reflejar1.png" title="Reflejar" style="width:24px;"/></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" style="width:29px;height:25px;" title="Imprimir" /></a>
					<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
			</tr>		  
		</table>
		<div id="titulog1" class='inicio' style="display:none">1. REFLEJANDO INFORMACION</div>
            	<div class='inicio'>
    				<div id="progreso" class="ProgressBar" style="display:none">
      					<div class="ProgressBarText"><span id="getprogress"></span>&nbsp;% completado</div>
      					<div id="getProgressBarFill"></div>
                    </div>
    			</div>  
 		<form name="form2" method="post" action=""> 
        	<input type="hidden" name="codrec" id="codrec" value="<?php echo $_POST[codrec];?>" />
			<div class="subpantallac5">
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				$sqlr="select id_recibos,id_recaudo from tesoreciboscaja ORDER BY id_recibos DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
				$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[0];}
				if(!$_POST[oculto])
				{
					$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
	 					$_POST[cobrorecibo]=$row[0];
	 					$_POST[vcobrorecibo]=$row[1];
	 					$_POST[tcobrorecibo]=$row[2];	 
					}
				}
				
	  			//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				if ($_GET[idrecibo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idrecibo];</script>";}
				//if ($_POST[codrec]!="")
				//{$sqlr="select id_recibos,id_recaudo from tesoreciboscaja where id_recibos='$_POST[codrec]'";}
				//else
				{$sqlr="select id_recibos,id_recaudo from tesoreciboscaja ORDER BY id_recibos DESC";}
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
				if(!$_POST[oculto])
				{
					$fec=date("d/m/Y");
					$_POST[vigencia]=$vigencia;
					if ($_POST[codrec]!="" || $_GET[idrecibo]!="")
						if($_POST[codrec]!="")
						{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_POST[codrec]'";}
						else 
						{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_GET[idrecibo]'";}
					else
					{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja ORDER BY id_recibos DESC";}
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
	 				//$_POST[maximo]=$r[0];
				 	$_POST[ncomp]=$r[0];
	 				$_POST[idcomp]=$r[0];
	 				$_POST[idrecaudo]=$r[1];
	 				$_POST[oculto]=0;
				}
				//**** for para el bloque *******************
				//echo $_POST[maximo];
//				for($x=$_POST[maximo];$x<=1;$x--)
//				$_POST[maximo]=30;
				$fr=0;
				$xval=$_POST[maximo];
				//echo $_POST[maximo];
				//echo $xval;
				while($xval>=1)
				{
				$fr+=1;
				//echo $_POST[maximo];
				//echo $xval;
//				echo "d:".$xval;
				$porcentaje = $fr * 100 / $_POST[maximo]; 
				echo"<script>progres='".round($porcentaje)."';callprogress(progres);</script>"; 
							flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
							ob_flush();
        					//sleep(1);segundos
							usleep(2);//microsegundos
						//	echo " $_POST[maximo] $fr";
				$_POST[codrec]=$xval;
				$_POST[idcomp]=$xval;
				$xval=$xval-1;
				if ($_POST[codrec]!="")
				{$sqlr="select * from tesoreciboscaja where id_recibos='$_POST[codrec]'";}
				else
 				{$sqlr="select * from tesoreciboscaja where id_recibos='$_POST[idcomp]'";}
 				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
		 		{		  
		  			$_POST[tiporec]=$r[10];
		  			$_POST[idrecaudo]=$r[4];
		  			$_POST[ncomp]=$r[0];
		  			$_POST[modorec]=$r[5];	
		  			$_POST[vigencia]=$r[3]; 
		 		}
				if($_POST[tiporec]==1)
				{
			?>
			<input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
			<input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
 			<input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
 			<input type="hidden" name="encontro"  value="<?php echo $_POST[encontro]?>" >
  			<input type="hidden" name="codcatastral"  value="<?php echo $_POST[codcatastral]?>" >
 			<?php 
				switch($_POST[tiporec]) 
  	 			{
	  				case 1:	$sqlr="SELECT * FROM tesoliquidapredial WHERE idpredial=$_POST[idrecaudo] AND  1=$_POST[tiporec]";
  	  						$_POST[encontro]="";
	  						$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
	 						{
								$_POST[codcatastral]=$row[1];		
	  							$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];	
	  							$_POST[valorecaudo]=$row[8];		
	  							$_POST[totalc]=$row[8];	
	  							$_POST[tercero]=$row[4];	
	  							$_POST[ntercero]=buscatercero($row[4]);		
								if ($_POST[ntercero]=='')
		 						{
		  							$sqlr2="SELECT * FROM tesopredios WHERE cedulacatastral='".$row[1]."' ";
		  							$resc=mysql_query($sqlr2,$linkbd);
		  							$rowc =mysql_fetch_row($resc);
		   							$_POST[ntercero]=$rowc[6];
		 						}	
	  							$_POST[encontro]=1;
							}
							$sqlr="SELECT * FROM tesoreciboscaja WHERE id_recibos=$_POST[idcomp] ";
							$res=mysql_query($sqlr,$linkbd);
							$row =mysql_fetch_row($res); 
							$_POST[fecha]=$row[2];
							$_POST[estadoc]=$row[9];
		   					if ($row[9]=='N')
		   					{
								$_POST[estado]="ANULADO";
		   						$_POST[estadoc]='0';
		   					}
		   					else
						  	{
							   $_POST[estadoc]='1';
							   $_POST[estado]="ACTIVO";
						   	}
							$_POST[modorec]=$row[5];
							$_POST[banco]=$row[7];	
       	 					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   						$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	  						break;
	  
	  				case 2:	$sqlr="SELECT * FROM tesoindustria WHERE id_industria=$_POST[idrecaudo] AND 2=$_POST[tiporec]";
  	  						$_POST[encontro]="";
	  						$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
	 						{
	  							$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];	
	  							$_POST[valorecaudo]=$row[6];		
	  							$_POST[totalc]=$row[6];	
	  							$_POST[tercero]=$row[5];	
	  							$_POST[ntercero]=buscatercero($row[5]);	
	  							$_POST[encontro]=1;
	 						}
							$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
							$res=mysql_query($sqlr,$linkbd);
							$row =mysql_fetch_row($res); 
							$_POST[fecha]=$row[2];
							$_POST[estadoc]=$row[9];
		   					if ($row[9]=='N')
		   					{
								$_POST[estado]="ANULADO";
		   						$_POST[estadoc]='0';
		   					}
		   					else
							{
							   $_POST[estadoc]='1';
							   $_POST[estado]="ACTIVO";
							}
        					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   						$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	   						$_POST[modorec]=$row[5];
							$_POST[banco]=$row[7];
	  						break;
	  				case 3:	$sqlr="SELECT * FROM tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
  	  						$_POST[encontro]="";
	  						$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
	 						{
	  							$_POST[concepto]=$row[6];	
	  							$_POST[valorecaudo]=$row[5];		
	  							$_POST[totalc]=$row[5];	
	  							$_POST[tercero]=$row[4];	
	  							$_POST[ntercero]=buscatercero($row[4]);			
	  							$_POST[encontro]=1;
	 						}
							$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
							$res=mysql_query($sqlr,$linkbd);
							$row =mysql_fetch_row($res); 
							$_POST[fecha]=$row[2];
							$_POST[estadoc]=$row[9];
		   					if ($row[9]=='N')
		   					{
								$_POST[estado]="ANULADO";
		  						$_POST[estadoc]='0';
		   					}
		  					else
		   					{
			   					$_POST[estadoc]='1';
			   					$_POST[estado]="ACTIVO";
		   					}
							$_POST[modorec]=$row[5];
							$_POST[banco]=$row[7];
        					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   						$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
							break;	
				}
 			?>
    		<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="9">Reflejar Recibo de Caja</td>
                    <td class="cerrar" style="width:7%" ><a href="cont-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
        			<td class="saludo1" style="width:2.5cm;">No Recibo:</td>
        			<td style="width:10%;"> 
                    	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="anterior" align="absmiddle"/></a> 
                        <input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>" />
                        <input type="text" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  style="width:50%;" />
                        <input type="hidden" name="ncomp"  value="<?php echo $_POST[ncomp]?>"/>
                        <a href="#" onClick="adelante()"><img src="imagenes/next.png" title="siguiente" align="absmiddle"/></a> 
                        <input type="hidden" value="a" name="atras"/>
                        <input type="hidden" value="s" name="siguiente"/>
                        <input type="hidden" name="maximo" value="<?php echo $_POST[maximo]?>" />
               		</td>
	 				<td class="saludo1" style="width:2.5cm;">Fecha:</td>
        			<td style="width:10%;"><input type="text" name="fecha"  value="<?php echo $_POST[fecha]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly/></td>
         			<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
		  			<td style="width:38%;">
                    	<input type="text" id="vigencia" name="vigencia" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" readonly>  
          		 		<input type="text" name="estado" value="<?php echo $_POST[estado] ?>" readonly>  
                        <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">   
                   	</td>
                    <td></td>   
        		</tr>
     			<tr>
                	<td class="saludo1"> Recaudo:</td>
                    <td> 
                    	<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)"  style="width:100%;">
                        	<?php
								switch($_POST[tiporec])
								{
									case "1":	echo"<option value='1' SELECTED>Predial</option>";break;
									case "2":	echo"<option value='2' SELECTED>Industria y Comercio</option>";break;
									case "3":	echo"<option value='3' SELECTED>Otros Recaudos</option>";break;
								}
							?>
        				</select>
          			</td>
        			<td class="saludo1">No Liquid:</td>
                    <td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" onKeyUp="return tabular(event,this)" onChange="validar()" readonly></td>
					<td class="saludo1">Recaudado en:</td>
     				<td> 
                    	<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" style="width:16%;" >
                        	<?php
								if($_POST[modorec]=='banco'){echo"<option value='banco' SELECTED>Banco</option>";}
								else{echo"<option value='caja' SELECTED>Caja</option>";}
							?>
        				</select>
        				<?php
		  					if ($_POST[modorec]=='banco')
		  				 	{
								echo"<select id='banco' name='banco' onKeyUp='return tabular(event,this)' style='width:83%;'>";
								$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
									if($row[1]==$_POST[banco])
			 						{
						 				echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3] - $row[4]</option>";
						 				$_POST[nbanco]=$row[4];
						 	 			$_POST[ter]=$row[5];
										$_POST[cb]=$row[2];
						 			}
								}
								echo" </select>
								<input type='hidden' name='cb'  value='$_POST[cb]'>
								<input type='hidden' name='ter' id='ter' value='$_POST[ter]'>            
								<input type='hidden' id='nbanco' name='nbanco' value='$_POST[nbanco]' readonly>";	 
							}
						?>
          			</td>
       			</tr>
	  			<tr>
                	<td class="saludo1">Concepto:</td>
                    <td colspan="5"><input name="concepto" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
              	</tr>
      			<tr>
                	<td class="saludo1" >Valor:</td>
                    <td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" onKeyUp="return tabular(event,this)" readonly ></td>
                    <td  class="saludo1">Documento: </td>
        			<td ><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" readonly></td>
			  		<td class="saludo1">Contribuyente:</td>
	  				<td>
                    	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this) " style="width:100%;"  readonly>
                        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  				</td>
                    <td></td>
            	</tr>
      		</table>
      		<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    	<input type="hidden" value="0" name="agregadet">
     		<div class="subpantallac3" style="width:99.6%; overflow-x:hidden;">
      			<?php	 
      			//echo $_POST[oculto]."dddhdhdhd".$_POST[encontro];
      			
 					if($_POST[oculto]>=0 && $_POST[encontro]=='1')
 					{
 					
  						switch($_POST[tiporec]) 
  	 					{
	  						case 1: //********PREDIAL
	   								$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
	   								//echo "s:".$sqlr;
									unset($_POST[dcoding]); 		 
									unset($_POST[dncoding]); 		 
									unset($_POST[dvalores]); 	
									$_POST[dcoding]= array(); 		 
									$_POST[dncoding]= array(); 		 
									$_POST[dvalores]= array(); 	
		 							if($_POST[tcobrorecibo]=='S')
		 							{	 
		 								$_POST[dcoding][]=$_POST[cobrorecibo];
		 								$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 								$_POST[dvalores][]=$_POST[vcobrorecibo];
		 							}
		 							$_POST[trec]='PREDIAL';	 
 	 								$res=mysql_query($sqlr,$linkbd);
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									while ($row =mysql_fetch_row($res)) 
									{
										$vig=$row[1];
										if($vig==$vigusu)
		 								{
											$sqlr2="select * from tesoingresos where codigo='01'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    										$_POST[dvalores][]=$row[11];		 
	 									}
		 								else
	   	 								{	
											$sqlr2="select * from tesoingresos where codigo='03'";
											$res2=mysql_query($sqlr2,$linkbd);
											$row2 =mysql_fetch_row($res2); 
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;			 		
	    									$_POST[dvalores][]=$row[11];		
		 								}
									}  
	  								break;
	  						case 2:	//***********INDUSTRIA Y COMERCIO
									unset($_POST[dcoding]); 		 
									unset($_POST[dncoding]); 		 
									unset($_POST[dvalores]); 	
 									$_POST[dcoding]= array(); 		 
		 							$_POST[dncoding]= array(); 		 
		 							$_POST[dvalores]= array(); 	
	  			 					$_POST[trec]='INDUSTRIA Y COMERCIO';	 
									if($_POST[tcobrorecibo]=='S')
		 							{	 
		 								$_POST[dcoding][]=$_POST[cobrorecibo];
		 								$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 								$_POST[dvalores][]=$_POST[vcobrorecibo];
		 							}
									$sqlr="select *from tesoindustria where id_industria=$_POST[idrecaudo] and  2=$_POST[tiporec]";
	  								$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
	 								{
										$sqlr2="select * from tesoingresos where codigo='02'";
	  									$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2);
 										$_POST[dcoding][]=$row2[0];
										$_POST[dncoding][]=$row2[1];			 		
	    								$_POST[dvalores][]=$row[6];		
									}
	  								break;
	  						case 3:	//*****************otros recaudos *******************
	  			 					$_POST[trec]='OTROS RECAUDOS';	 
	  			 					unset($_POST[dcoding]); 		 
									unset($_POST[dncoding]); 		 
									unset($_POST[dvalores]); 	
  									$sqlr="select *from tesorecaudos_det where id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
		 							$_POST[dcoding]= array(); 		 
		 							$_POST[dncoding]= array(); 		 
		 							$_POST[dvalores]= array(); 	
									if($_POST[tcobrorecibo]=='S')
		 							{	 
		 								$_POST[dcoding][]=$_POST[cobrorecibo];
		 								$_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
    	 								$_POST[dvalores][]=$_POST[vcobrorecibo];
		 							}	 
  									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{	
										$_POST[dcoding][]=$row[2];
										$sqlr2="select nombre from tesoingresos where codigo='".$row[2]."'";
										$res2=mysql_query($sqlr2,$linkbd);
										$row2 =mysql_fetch_row($res2); 
										$_POST[dncoding][]=$row2[0];			 		
    									$_POST[dvalores][]=$row[3];		 	
									}
									break;
   						}
 					}
 				?>
	   			<table class="inicio">
	   	   			<tr><td colspan="4" class="titulos">Detalle Recibo de Caja</td></tr>                  
					<tr>
                    	<td class="titulos2">Codigo</td>
                        <td class="titulos2">Ingreso</td>
                        <td class="titulos2">Valor</td>
                 	</tr>
					<?php 		
		  				$_POST[totalc]=0;
						$iter='saludo1a';
						$iter2='saludo2';
		 				for ($x=0;$x<count($_POST[dcoding]);$x++)
		 				{		 
		 					echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td style='width:10%;'><input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'>".$_POST[dcoding][$x]."</td>
								<td><input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'>".$_POST[dncoding][$x]."</td>
								<td style='width:20%;text-align:right;'><input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."' style='width:100%;'>$ ".number_format($_POST[dvalores][$x],2,',','.')."</td>				
							</tr>";
							$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
							$_POST[totalcf]=number_format($_POST[totalc],2);
							$aux=$iter;
	 						$iter=$iter2;
	 						$iter2=$aux;
		 				}
 						$resultado = convertir($_POST[totalc]);
						$_POST[letras]=$resultado." PESOS M/CTE";
		 				echo "
						<tr class='$iter' >
							<td style='text-align:right;' colspan='2'>Total:</td>
							<td style='text-align:right;'>
								<input type='hidden' name='totalcf' value='$_POST[totalcf]'>
								<input name='totalc' type='hidden' value='$_POST[totalc]'>$ ".number_format($_POST[totalc],2,',','.')."
							</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='5'><input type='hidden' name='letras' value='$_POST[letras]'>$_POST[letras]</td>
						</tr>";
					?> 
	   			</table>
       		</div>
	  <?php
	  $_POST[oculto]=2;
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{						
	//************VALIDAR SI YA FUE GUARDADO ************************
	switch($_POST[tiporec]) 
  	 {
	  case 1://***** PREDIAL *****************************************
//	  echo 'PREDIAL';
	  $sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {
			$numerorecaudos=$r[0];
		 }
	  if($numerorecaudos>=0)
	   { 	
	   $sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
	   mysql_query($sqlr,$linkbd);
	    $sqlr="delete from comprobante_det where numerotipo=$_POST[idcomp] and tipo_comp='5'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
		mysql_query($sqlr,$linkbd);
		   if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }	   
		      ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	   
	   
	   	//************ insercion de cabecera recaudos ************
		 $concecc=$_POST[idcomp];
		 //echo "ccc".$concecc;
		 echo "<input type='hidden' name='concec' value='$concecc'>";	
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
		  $sqlr="update tesoliquidapredial set estado='P' WHERE idpredial=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);
		  $sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  $resq=mysql_query($sqlr,$linkbd);
		  //echo "<br>$sqlr";
		  while($rq=mysql_fetch_row($resq))
 		  {
		   $sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE   idpredial=$_POST[idrecaudo]) AND vigencia=$rq[1]";
		   mysql_query($sqlr2,$linkbd);
		   		//  echo "<br>$sqlr2";				
		  }
		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php		  			 
	//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";	 
		 mysql_query($sqlr,$linkbd);
		 
		 		 //******parte para el recaudo del cobro por recibo de caja
		 
		 for($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		 if($_POST[dcoding][$x]==$_POST[cobrorecibo])
		 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
		
	    //**** busqueda cuenta presupuestal*****
		

			//busqueda concepto contable
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		 		//echo "concc: $sqlrc <br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
			  $porce=$rowi[5];
			  
			if($rowc[7]=='S')
			  {				 
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;
					
				if($rowc[3]=='N')
			    {
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr."<br>";						
					//***cuenta caja o banco
				if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
			   //$valordeb=$_POST[dvalores][$x]*($porce/100);
				//$valorcred=0;
				//echo "bc:$_POST[modorec] - $cuentacb";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "Conc: $sqlr <br>";					
				}
			
			  }
		 }
		 }
	  }
	}			 	 
	 //*************** fin de cobro de recibo
		 
		 
		 //		 echo "<BR>".$sqlr;		 
		 $sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 $res=mysql_query($sqlrs,$linkbd);	
		 $rowd==mysql_fetch_row($res);
		 $tasadesc=($rowd[6]/100);
		 $sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
		 $res=mysql_query($sqlrs,$linkbd);		 
		// echo "<BR>".$sqlrs;		 
//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
		while ($row =mysql_fetch_row($res)) 
		{
		$vig=$row[1];
		$vlrdesc=$row[10];
		if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
		 {
				 		// $tasadesc=round($row[10]/($row[4]+$row[6]),1);		
		 $idcomp=mysql_insert_id();
		// echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
		  $sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
		  mysql_query($sqlr,$linkbd);
		$sqlr2="select * from tesoingresos_DET where codigo='01' AND MODULO='4' and vigencia=$vigusu";
		$res2=mysql_query($sqlr2,$linkbd);
				// echo "<BR>".$sqlr2;				 
				 //****** $cuentacb   ES LA CUENTA CAJA O BANCO
		while($rowi =mysql_fetch_row($res2))
		 {
			// echo "<br>conc: ".$rowi[2];
		  switch($rowi[2])
		   {
			case '01': //***  VALOR PREDIAL
			//**** busca descuento PREDIAL
					$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P01' AND MODULO='4' and vigencia=$vigusu";
					$resds=mysql_query($sqlrds,$linkbd);
					while($rowds =mysql_fetch_row($resds))
		   			{
					 $descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
				//	 echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
					}
				if ($row[6]<=0)
					$descpredial=$vlrdesc;
			//****			
				 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		 //echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[4];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Vigente $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=round($valorcred-$descpredial,2);
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Vigente $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
//							 echo "<BR>round($valorcred-($descpredial*$valorcred))";
					     //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
					  }
					}
				  }
				 }
			break;  
			case '02': //***
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
					  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL			
					  }
					}
				  }
				 }
			
			break;  
			case '03': 			
					$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P10' AND MODULO='4' and vigencia=$vigusu";
					$resds=mysql_query($sqlrds,$linkbd);
					while($rowds =mysql_fetch_row($resds))
		   			{
					 $descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
		//	 echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
					}

			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred-$descpredial;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
					  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL			
					  }
					}
				  }
				 }
			break;  
			case 'P10': 
			if($row[6]>0)
			{	
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=round($row[10]*($porce/100),2);
					$valorcred=0;		
					//echo "<BR>$row[10] $porce ".$valordeb;			
					if($rowc[3]=='N')
				    {
				 	 if($valordeb>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					//		 echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			}	 
			break;  
			case 'P01': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
				 if ($row[6]>0)
					$porce=$rowi[5];
				 else
					 $porce=100;
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=round($row[10]*$porce/100,2);
					// echo "<BR>".$valordeb." round($row[10]*$porce/100,0)";
					$valorcred=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valordeb>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P02': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[5];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P04': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[7];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P05': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P07': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[9];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P08': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=0;
					$valordeb=$row[8];					
				  }
				 if($rowc[6]=='N')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
				  }
					if($rowc[3]=='N')
				    {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);					
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valorcred;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
				   }
				 }
			break; 
			} 
			//echo "<br>".$sqlr;
		 }
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    	$_POST[dvalores][]=$row[11];		 
			//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
	 	}
		 else  ///***********OTRAS VIGENCIAS ***********
	   	 {	
			 		 $tasadesc=$row[10]/($row[4]+$row[6]);
		// $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
		 //mysql_query($sqlr,$linkbd);
		// echo "<BR>".$sqlr;
		 $idcomp=mysql_insert_id();
//		 echo "<input type='hidden' name='ncomp' value='$idcomp'>";	
		  $sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
		  mysql_query($sqlr,$linkbd);
		$sqlr2="select * from tesoingresos_DET where codigo='03' AND MODULO='4' and vigencia=$vigusu";
		$res2=mysql_query($sqlr2,$linkbd);
				// echo "<BR>".$sqlr2;
				 
				 //****** $cuentacb   ES LA CUENTA CAJA O BANCO
		while($rowi =mysql_fetch_row($res2))
		 {
			// echo "<br>conc: ".$rowi[2];
		  switch($rowi[2])
		   {
			case 'P03': //***
				 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		 //echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[4];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred-$tasadesc*$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Impuesto Predial Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
						  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
					  }
					}
				  }
				 }
			break;  
			case 'P06': //***
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			
			break;  
			case '03': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred-$tasadesc*$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P01': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valordeb=$row[10];
					$valorcred=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Descuento Pronto Pago $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
					  }
					}
				  }
				 }
			break;  
			case 'P02': 
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[5];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Predial $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					}
				   }
				  }
				 }
			break;  
			case 'P04': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[7];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobretasa Bomberil $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P05': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[6];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Ingreso Sobtretasa Bomberil Otras Vigencias $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P07': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=$row[9];
					$valordeb=0;					
					if($rowc[3]=='N')
				    {
				 	 if($valorcred>0)
					  {						
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
					$valordeb=$valorcred;
					$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$cuentacb."','".$_POST[tercero]."', '".$rowc[5]."','Intereses Sobtretasa Ambiental $vig','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);
							// echo "<BR>".$sqlr;
							
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL	
					  }
					}
				  }
				 }
			break;  
			case 'P08': 
			
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
	 			 $resc=mysql_query($sqlrc,$linkbd);	  
				 		// echo "<BR>".$sqlrc;
				 while($rowc=mysql_fetch_row($resc))
				 {
			  	$porce=$rowi[5];
				if($rowc[6]=='S')
			 	  {				 
					$valorcred=0;
					$valordeb=$row[8];					
				  }
				 if($rowc[6]=='N')
			 	  {				 
					$valorcred=$row[8];
					$valordeb=0;					
				  }
					if($rowc[3]=='N')
				    {
				 	 					
				 	$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$rowc[4]."','".$_POST[tercero]."', '".$rowc[5]."','Sobtretasa Ambiental $vig','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
					mysql_query($sqlr,$linkbd);					
							// echo "<BR>".$sqlr;
							  //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$valordeb;
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL		
				   }
				 }
			break;  


			} 
			//echo "<br>".$sqlr;
		 }
		$_POST[dcoding][]=$row2[0];
		$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    	$_POST[dvalores][]=$row[11];		 	
				//		echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
		 }
		}
	//*******************  
	 $sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  $resp=mysql_query($sqlr,$linkbd);
		  while($row=mysql_fetch_row($resp,$linkbd))
		   {
		    $sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[1]";
			mysql_query($sqlr2,$linkbd);
		   }	 	  
		  
   	 } //fin de la verificacion
	 else
	 {
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion Predial<img src='imagenes/alert.png'></center></td></tr></table>";
	 }//***FIN DE LA VERIFICACION
	   break;
	   case 2:  //********** INDUSTRIA Y COMERCIO
	   echo "INDUSTRIA";
		      ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			  $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2'";
	$res=mysql_query($sqlr,$linkbd);
	//echo $sqlr;
	while($r=mysql_fetch_row($res))
	 {
		$numerorecaudos=$r[0];
	 }
  if($numerorecaudos>=0)
   {   	 
    $sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
	   mysql_query($sqlr,$linkbd);
	    $sqlr="delete from comprobante_det where id_comp='5 $_POST[idcomp]'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
		mysql_query($sqlr,$linkbd);
         
	if (!mysql_query($sqlr,$linkbd))
		{
	 	echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 	echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 	echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     	echo "</pre></center></td></tr></table>";
		}
  		else
  		 {
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
		 $concecc=$_POST[idcomp]; 
		 //*************COMPROBANTE CONTABLE INDUSTRIA
		  $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($concecc,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";		  
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
	 	  $sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='2'";
		  mysql_query($sqlr,$linkbd);
  		  $sqlr="update tesoindustria set estado='P' WHERE id_industria=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);
		  if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
//			echo "c:".count($_POST[dcoding]);

		 //******parte para el recaudo del cobro por recibo de caja
		 
		 for($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		 if($_POST[dcoding][$x]==$_POST[cobrorecibo])
		 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
		
	    //**** busqueda cuenta presupuestal*****
		

			//busqueda concepto contable
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		 		//echo "concc: $sqlrc <br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
			  $porce=$rowi[5];
			  
			if($rowc[7]=='S')
			  {				 
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;
					
				if($rowc[3]=='N')
			    {
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia='$vigusu'";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia='$vigusu'";
			mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
//			echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr."<br>";						
					//***cuenta caja o banco
				if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
			   //$valordeb=$_POST[dvalores][$x]*($porce/100);
				//$valorcred=0;
				//echo "bc:$_POST[modorec] - $cuentacb";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "Conc: $sqlr <br>";					
				}
			
			  }
		 }
		 }
	  }
	}			 	 
	 //*************** fin de cobro de recibo

	
		for($x=0;$x<count($_POST[dcoding]);$x++)
	 	{
		 //***** BUSQUEDA INGRESO ********
		$sqlr="Select * from tesoindustria_det where id_industria=".$_POST[idrecaudo];
	 	$res=mysql_query($sqlr,$linkbd);
		$row=mysql_fetch_row($res);
		$industria=$row[1];
		$avisos=$row[2];
		$bomberil=$row[3];
		$retenciones=$row[4];
		$sanciones=$row[5];	
		$intereses=$row[6];		
		$antivigact=$row[11];		
		$antivigant=$row[10];		
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
	 	$res=mysql_query($sqlri,$linkbd);
	//     echo "$sqlri <br>";	    
		  while($row=mysql_fetch_row($res))
		  {
			if($row[2]=='04') //*****industria
			  {
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='04' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$industria+$sanciones+$intereses;
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Industria y Comercio $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
	//					echo "<br>$sqlr";
						//********** CAJA O BANCO
						 //*** retencion ica
						
						$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
					$rescr=mysql_query($sqlr2,$linkbd);
					 while($rowcr=mysql_fetch_row($rescr))
					  {
					   if($rowcr[3]=='N')
						{
						 if($rowcr[6]=='S')
						 {
							$cuentaretencion= $rowcr[4];
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero, centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentaretencion."','".$_POST[tercero]."','".$row2[5]."','Retenciones Industria y Comercio','',".$retenciones.",0,'1','".$_POST[vigencia]."')";
							mysql_query($sqlr,$linkbd);
						 }
						}
					  }
					  //**fin rete ica
						 $valordeb=$industria+$sanciones+$intereses-$retenciones-$antivigant;
						 $valorcred=0;
						 if($valordeb<0)
						 {
						 $sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
							$res2=mysql_query($sqlr2,$linkbd);
							 while($row2=mysql_fetch_row($res2))
							  {
							   if($row2[3]=='N')
								{				 					  		
							   if($row2[7]=='S')
								 {	
						 		  $cuentacbr=$row2[4];
								  $valordeb=0;
								  $valorcred=$retenciones;
								 }
								}
							  }			 
						 }
						 else
						 {
						  $cuentacbr=$cuentacb;
						 }
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacbr."','".$_POST[tercero]."','".$row2[5]."','Industria y Comercio $_POST[modorec]','',".($valordeb).",$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$industria  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$industria,'".$vigusu."')";
					//	 echo "ic rec:".$sqlr;
  						  mysql_query($sqlr,$linkbd);	
						 }
						}
					  }
			  }
			if($row[2]=='05')//************avisos
			  {
				$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='05' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$avisos;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Avisos y Tableros $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
//						echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$avisos;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Avisos y Tableros $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$avisos  WHERE cuenta='$row[6]'   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$avisos,'".$vigusu."')";
						  //echo "av rec:".$sqlr;
		  			  mysql_query($sqlr,$linkbd);	
						

						 }
						}						
					  }
			  }
			  
			  
			  if($row[2]=='P11')//************ANTICIPOS VIG ACTUAL ****************** 
			  {
				$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[7]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$antivigact;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','ANTICIPO VIGENCIA ACTUAL $_POST[ageliquida]','',0,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
					//echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$antivigact;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','ANTICIPO VIGENCIA ACTUAL $_POST[modorec]','',$valordeb,0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);											
						 }
						}						
					  }
			  }
			  //*******************
			  if($row[2]=='P11')//************ANTICIPOS VIG ANTERIOR ****************** 
			  {
				$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[7]=='S')
						 {				 
						 $valorcred=0;
						 $valordeb=$antivigant;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','ANTICIPO VIGENCIA ANTERIOR $_POST[ageliquida]','',$valordeb,$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
//						echo "<br>$sqlr";						
						//********** CAJA O BANCO
						// $valordeb=$industria-$retenciones+$antivigant;
						 $valordeb=$industria-$retenciones-$antivigant;
						 $valorcred=0;
						//$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','ANTICIPO VIGENCIA ANTERIOR $_POST[modorec]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
						//mysql_query($sqlr,$linkbd);											
						 }
						}						
					  }
			  }
			  //*******************
			  
			  
			if($row[2]=='06') //*********bomberil ********
			  {
					$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='06' and tipo='C'";
					$res2=mysql_query($sqlr2,$linkbd);
					 while($row2=mysql_fetch_row($res2))
					  {
					   if($row2[3]=='N')
						{				 					  		
					   if($row2[6]=='S')
						 {				 
						 $valordeb=0;
						 $valorcred=$bomberil;					
						  $sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('5 $concecc', '".$row2[4]."','".$_POST[tercero]."', '".$row2[5]."','Bomberil $_POST[ageliquida]','',".$valordeb.",$valorcred,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);	 
		//				echo "<br>$sqlr";						
						//********** CAJA O BANCO
						 $valordeb=$bomberil;
						 $valorcred=0;
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $concecc','".$cuentacb."','".$_POST[tercero]."','".$row2[5]."','Bomberil $_POST[modorec]','',".$valordeb.",0,'1','".$_POST[vigencia]."')";
						mysql_query($sqlr,$linkbd);
			//***MODIFICAR PRESUPUESTO
						$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bomberil  WHERE cuenta=$row[6]   and vigencia=".$vigusu;
						mysql_query($sqlr,$linkbd);
						 $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]',$concecc,$bomberil,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
				 //echo "bom rec:".$sqlr;
						 }
						}
					  }
			   }
		    }
		  }
		}
   }
	 else
	 {
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 }
		 
		break; 
	  case 3: //**************OTROS RECAUDOS
	
    $sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='5'";
	  mysql_query($sqlr,$linkbd);
	    $sqlr="delete from comprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='5'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);
		$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
		mysql_query($sqlr,$linkbd);
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];
//***cabecera comprobante
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";
	mysql_query($sqlr,$linkbd);
	$idcomp=mysql_insert_id();
//	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
		
		  $sqlr="delete from pptorecibocajappto where idrecibo=$consec ";
			//  mysql_query($sqlr,$linkbd);	
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
	 	$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		 {
		
	    //**** busqueda cuenta presupuestal*****
		

			//busqueda concepto contable
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
		 		//echo "concc: $sqlrc <br>";	      
		while($rowc=mysql_fetch_row($resc))
		 {
			  $porce=$rowi[5];
			  //echo '<br>CR:'.$rowi[2].'    '.$_POST[cobrorecibo];
			  echo "";			  
			if($rowc[6]=='S' and $_POST[dcoding][$x]!=$_POST[cobrorecibo])
			  {				 			  
			  $cuenta=$rowc[4];
			  	  
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;
					
				if($rowc[3]=='N')
			    {
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			//mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
		
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
			//echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $consec','".$cuenta."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr."<br>";						
					//***cuenta caja o banco
				if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
			   //$valordeb=$_POST[dvalores][$x]*($porce/100);
				//$valorcred=0;
				//echo "bc:$_POST[modorec] - $cuentacb";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $consec','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "Conc: $sqlr <br>";					
				}
			
			  }
			 if($_POST[dcoding][$x]==$_POST[cobrorecibo] and $rowc[7]=='S')
			  {
			  $cuenta=$rowc[4];
			  
			  			  $cuenta=$rowc[4];
			  	  
				$valorcred=$_POST[dvalores][$x]*($porce/100);
				$valordeb=0;
					
				if($rowc[3]=='N')
			    {
			   //*****inserta del concepto contable  
			   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 $sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 $respto=mysql_query($sqlrpto,$linkbd);	  
			 //echo "con: $sqlrpto <br>";	      
				$rowpto=mysql_fetch_row($respto);
			
			$vi=$_POST[dvalores][$x]*($porce/100);
			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
			//mysql_query($sqlr,$linkbd);	
			
			  //****creacion documento presupuesto ingresos
		
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$vigusu."')";
  			  mysql_query($sqlr,$linkbd);	
			//echo "ppt:$sqlr";
			//************ FIN MODIFICACION PPTAL
			
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $consec','".$cuenta."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr."<br>";						
					//***cuenta caja o banco
				if($_POST[modorec]=='caja')
			  	{				 
					$cuentacb=$_POST[cuentacaja];
					$cajas=$_POST[cuentacaja];
					$cbancos="";
			  	}
				if($_POST[modorec]=='banco')
			    {
					$cuentacb=$_POST[banco];				
					$cajas="";
					$cbancos=$_POST[banco];
			    }
			   //$valordeb=$_POST[dvalores][$x]*($porce/100);
				//$valorcred=0;
				//echo "bc:$_POST[modorec] - $cuentacb";
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('5 $consec','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
				mysql_query($sqlr,$linkbd);
				//echo "Conc: $sqlr <br>";					
				}			  
			  }		
			  
		 }
		 }
	}	
	//************ insercion de cabecera recaudos ************

	/*$sqlr="insert into tesoreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja,cuentabanco,valor,estado,tipo) values($idcomp,'$fechaf',".$vigusu.",$_POST[idrecaudo],'$_POST[modorec]','$cajas','$cbancos','$_POST[totalc]','S','$_POST[tiporec]')";	  
	if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  		else
  		 {
		  echo "<table><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
		  $sqlr="update tesorecaudos set estado='P' WHERE ID_RECAUDO=$_POST[idrecaudo]";
		  mysql_query($sqlr,$linkbd);

		  ?>
		  <script>
		  document.form2.numero.value="";
		  document.form2.valor.value=0;
		  </script>
		  <?php
		  
		  }*/
	   break;
	   //********************* INDUSTRIA Y COMERCIO
	} //*****fin del switch
	/*$sqlr="delete from tesoreciboscaja_det where id_recibos=$_POST[idcomp]";
	mysql_query($sqlr,$linkbd); 
	for($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		  $sqlr="insert into tesoreciboscaja_det (id_recibos,ingreso,valor,estado) values($_POST[idcomp],'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
		  mysql_query($sqlr,$linkbd);  
	//	  echo $sqlr."<br>";
		 }		
	*/
	}//***bloqueo
		else
	   {
    	echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
	   }

   }//**fin del oculto .
   }//***condicion de predial
   }//*****fin del for masivo
?>	
</div>	
</form>
 </td></tr>
</table>
</body>
</html>