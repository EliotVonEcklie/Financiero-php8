<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private");
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SPID - Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function validar(){document.form2.submit();}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
					document.form2.submit();
				}
			}
			function guardar()
			{
				ingresos2=document.getElementsByName('dcoding[]');
				if (document.form2.fecha.value!='' && ingresos2.length>0)
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
				document.form2.action="pdfssfegre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function iratras(){
				location.href="teso-buscasinsituacionegreso.php";
			}
			function adelante()
			{
				if(parseFloat(document.form2.numrecaudo.value)<parseFloat(document.form2.maximo.value))
 				{
					document.form2.oculto.value='';
					document.form2.numrecaudo.value=parseFloat(document.form2.numrecaudo.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="teso-editasinsituacionegreso.php?idrecaudo="+idcta;
					document.form2.submit();
				}
				else
				{
	  				// alert("Balance Descuadrado"+parseFloat(document.form2.maximo.value));
				}
			}
			function atrasc()
			{
				if(document.form2.numrecaudo.value>1)
				{
					document.form2.oculto.value='';
					document.form2.numrecaudo.value=document.form2.numrecaudo.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="teso-editasinsituacionegreso.php?idrecaudo="+idcta;
					document.form2.submit();
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-sinsituacionegreso.php'" class="mgbt"/></a>
					<a><img src="imagenes/guarda.png" title="Guardar" class="mgbt" onClick="guardar()"/></a>
					<a><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='teso-buscasinsituacionegreso.php'" class="mgbt"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"></a>
					<a><img src="imagenes/print.png" title="Imprimir" onClick="pdf()"  class="mgbt"/></a>
					<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>		  
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	  		//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
			if(!$_POST[oculto])
			{
				unset($_POST[dcodssf],$_POST[dcodssfnom],$_POST[dvalores],$_POST[dcuentas],$_POST[rubros],$_POST[dncuentas],$_POST[drecursos],$_POST[dnrecursos]);
				$check1="checked";
				$fec=date("d/m/Y");
				$_POST[vigencia]=$vigusu;
				$sqlr="select VALOR_INICIAL from dominios where dominio='CUENTA_CAJA' where VALOR_FINAL='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){ $_POST[cuentacaja]=$row[0];}
				$sqlr="select * from tesossfegreso_cab ORDER BY id_orden DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
				if($_GET[idrecaudo]!='')
				{
					$_POST[numrecaudo]=$_GET[idrecaudo];
				}
				$sqlr="select * from tesossfegreso_cab WHERE id_orden='$_POST[numrecaudo]'";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	 			{
	 				$_POST[idcomp]=$row[0];
					$_POST[fecha]=date('d/m/Y',strtotime($row[2]));
					$_POST[vigencia]=$row[3];
					$_POST[rp]=$row[4];
					$_POST[detallegreso]=$row[7];	 
					$_POST[tercero]=$row[6];	
					$_POST[ntercero]=buscatercero($row[6]);		 
					$_POST[cc]=$row[5];			 	 	 
					$_POST[valor]=$row[10];
					$_POST[valorcheque]=$row[10];	 
					$_POST[estado]=$row[13];			 	 	 	  	 	 	 
	 				if($_POST[estado]=='S'){$_POST[estadoc]="ACTIVO";}
 					if($_POST[estado]=='N') {$_POST[estadoc]="ANULADO";}
	 			}
	 			$sqlr="select * from tesossfegreso_det WHERE ID_EGRESO='$_GET[idrecaudo]'";
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
				{
						
	 				$codssf=buscacodssf($_POST[rp],$vigusu);
	   				$nomcodssf= buscacodssfnom($r[5]);
	   				$_POST[dcodssf][]=$r[5];
	   				$_POST[dcodssfnom][]="$r[5] - $nomcodssf";		 		
	 				$_POST[dvalores][]=$r[4];
	 				$_POST[dcuentas][]=$r[2];
	 				$_POST[rubros][]=$r[2];
	 				$_POST[dncuentas][]=buscacuentapres($r[2],2);	
	 				$_POST[drecursos][]=buscafuenteppto($r[2],$_POST[vigencia]);
	 				$_POST[dnrecursos][]=buscafuenteppto($r[2],$_POST[vigencia]);
				}
			}
			switch($_POST[tabgroup1])
			{
				case 1:	$check1='checked';break;
				case 2:	$check2='checked';break;
				case 3:	$check3='checked';
			}
		?>
 		<form name="form2" method="post" action=""> 
			<?php
                //***** busca tercero
                if($_POST[bt]=='1')
                {
                    $nresul=buscatercero($_POST[tercero]);
                    if($nresul!='') {$_POST[ntercero]=$nresul;}
                    else {$_POST[ntercero]=""; }
                }
                //******** busca ingreso *****
                //***** busca tercero
                if($_POST[bin]=='1')
                {
                    $nresul=buscaingresossf($_POST[codingreso]);
                    if($nresul!='') {$_POST[ningreso]=$nresul;}
                    else {$_POST[ningreso]="";}
                }
            ?>
            <table class="inicio" align="center" >
                <tr >
                    <td class="titulos" colspan="8">Egreso SSF VER</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td style="width:4cm;" class="saludo1" >Numero Egreso SSF:</td>
                    <td style="width:15%;">
					<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
					<input name="idcomp" id="idcomp" type="text" style="width:70%" value="<?php echo $_POST[idcomp]?>" readonly>
					<input name="numrecaudo" type="hidden" value="<?php echo $_POST[numrecaudo]?>">
					<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
					<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
					</td>
                    <td style="width:1.5cm;" class="saludo1">Fecha: </td>
                    <td style="width:15%;"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">&nbsp;<img src="imagenes/calendario04.png" class="icobut" title="Calendario" onClick="displayCalendarFor('fc_1198971545');"/></td>
                    <td class="saludo1" style="width:2.5cm;">Vigencia: </td>
                    <td style="width:10%;"><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> </td>
                </tr>
                <tr>
					<td  class="saludo1">Registro:</td>
                    <td>
                        <input name="rp" type="text" value="<?php echo $_POST[rp]?>" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" >
                        <input type="hidden" value="0" name="brp">&nbsp;<img src="imagenes/find02.png" title="Lista Registros" class="icobut" onClick="mypop=window.open('registro-ventana.php?vigencia=<?php echo $_POST[vigencia]?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"/>       
                    </td>
                    <td class="saludo1">Centro Costo:</td>
                    <td>
                        <select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
                            <?php
                                $sqlr="select *from centrocosto where estado='S'";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($res)) 
                                {
                                    if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";} 	 
                                }
                            ?>
                       </select>
                    </td>
                    <td class="saludo1">Tercero:</td>
                    <td  >
                        <input id="tercero" type="text" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" style="width:80%;" value="<?php echo $_POST[tercero]?>">&nbsp;<img src="imagenes/find02.png" title="Lista Terceros" class="icobut" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900, height=500px'); mypop.focus();"/>
                        <input type="hidden" value="0" name="bt">
                    </td>
                    <td colspan="2"><input  id="ntercero" style="width:100%;" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  readonly></td>
                </tr>
                <tr>
                    <td class="saludo1">Detalle Orden de Pago:</td>
                    <td colspan="5">
                        <input type="text" id="detallegreso" name="detallegreso" style="width:100%;" value="<?php echo $_POST[detallegreso]?>" >
                    </td>
					<td class="saludo1" >Valor a Pagar:</td>
                    <td>
                        <input type="text" id="valor" name="valor" style="width:100%;" value="<?php echo $_POST[valor]?>" readonly> 
                        <input type="hidden" id="valorcheque" name="valorcheque" value="<?php echo $_POST[valorcheque]?>" readonly> 
                        <input type="hidden" value="1" name="oculto">
                        <input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>" >
                    </td>
                </tr>
                <tr>
                    
                </tr>
    		</table>
       		<?php
           		//***** busca tercero
			 	if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{
			  			$_POST[ntercero]=$nresul;
  						echo"
						<script>
			 				document.getElementById('codingreso').focus();
							document.getElementById('codingreso').select();
						</script>";
			  		}
					else
					{
			  			$_POST[ntercero]="";
			 			echo"
			 			<script>
							alert('Tercero Incorrecto o no Existe')				   		  	
		  					document.form2.tercero.focus();	
			  			</script>";
			  		}
			 	}
			 ?>
     		<div class="subpantalla" style="height:55.5%; width:99.6%; overflow-x:hidden;">
	   			<table class="inicio">
	   				<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
					<tr>
              			<td class="titulos2" style="width:10%;">Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2">Recurso</td>
                        <td class="titulos2">Cod SSF</td>
                        <td class="titulos2" style='width:10%;'>Valor</td>
					</tr>
					<?php
		  				$_POST[totalc]=0;
		 				for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 				{		
		 					$chk=''; 
							$ch=esta_en_array($_POST[rubros],$_POST[dcuentas][$x]);
							if($ch=='1')
			 				{
								$chk="checked";
			 					$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
			 				}
							echo "
							<input type='hidden' name='rubros[]' value='".$_POST[rubros][$x]."'/>
							<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
							<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
							<input type='hidden' name='drecursos[]' value='".$_POST[drecursos][$x]."'/>
		 					<input type='hidden' name='dnrecursos[]' value='".$_POST[dnrecursos][$x]."'/>
							<input type='hidden' name='dcodssf[]' value='".$_POST[dcodssf][$x]."'/>
		 					<input type='hidden' name='dcodssfnom[]' value='".$_POST[dcodssfnom][$x]."'/>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
							<tr>
		 						<td class='saludo2'>".$_POST[dcuentas][$x]."</td>
		 						<td class='saludo2'>".$_POST[dncuentas][$x]."</td>
		 						<td class='saludo2'>".$_POST[dnrecursos][$x]."</td>
		 						<td class='saludo2'>".$_POST[dcodssfnom][$x]."</td>
		 						<td class='saludo2'>".$_POST[dvalores][$x]."</td>
		 					</tr>";
						}
						$resultado = convertir($_POST[totalc]);
						$_POST[letras]=$resultado." PESOS M/CTE";
		 				$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
						
	    				echo "
							<input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
	    					<input type='hidden' name='totalc'  value='$_POST[totalc]'/>
							<tr>
	    						<td  class='saludo1'>Son:</td> 
	    						<td colspan='2' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' style='width:100%;'></td>
	    						<td class='saludo2'>Total</td>
	    						<td class='saludo2'>$_POST[totalcf]</td>
	    					</tr>
        					<script>
        						document.form2.valor.value=$_POST[totalc];
        						document.form2.valoregreso.value=$_POST[totalc];		
        					</script>";
					?>
				</table>
          	</div>
	  		<?php
				if($_POST[oculto]=='2')
				{
 					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$fechaf=$_POST[fecha];
					//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
					//***busca el consecutivo del comprobante contable
					$consec=$_POST[idcomp];
					$sqlr="delete from comprobante_cab where numerotipo=$consec and tipo_comp=21";
					mysql_query($sqlr,$linkbd);	
					$sqlr="delete from comprobante_det where numerotipo=$consec and tipo_comp=21";
					mysql_query($sqlr,$linkbd);	
					$sqlr="delete from tesossfingreso_cab where id_recaudo=$consec ";
					mysql_query($sqlr,$linkbd);	
					$sqlr="delete from tesossfingreso_det where id_recaudo=$consec ";
					mysql_query($sqlr,$linkbd);	
					$sqlr="delete from pptoingssf where idrecibo=$consec ";	
					mysql_query($sqlr,$linkbd);
	 				$sqlr="delete from pptocomprobante_cab where numerotipo=$consec and tipo_comp='21'";
	 				mysql_query($sqlr,$linkbd);
    				$sqlr="delete from pptocomprobante_det where  numerotipo=$consec and tipo_comp='21'";
					mysql_query($sqlr,$linkbd);		
					//***cabecera comprobante
	 				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,20,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
					mysql_query($sqlr,$linkbd);	
					$idcomp=mysql_insert_id();
					echo "<input type='hidden' name='ncomp' value='$idcomp'>";
					$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito, diferencia,estado) values($consec,21,'$fechaf','INGRESOS SSF $_POST[concepto]',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
	  				mysql_query($sqlr,$linkbd);
					//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
					for($x=0;$x<count($_POST[dcoding]);$x++)
	 				{
		 				//***** BUSQUEDA INGRESO ********
						$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$_POST[vigencia]";
	 					$res2=mysql_query($sqlri,$linkbd);
						while($row2=mysql_fetch_row($res2))
		 				{
	    					//**** busqueda concepto contable*****		
							$sqlri="Select * from conceptoscontables_det where codigo='".$row2[2]."' and modulo=4 and tipo='IS' ";
	 						$resi=mysql_query($sqlri,$linkbd);
							while($rowi=mysql_fetch_row($resi))
		 					{
								if($rowi[7]=='S')
				 				{
									$valorcred=$_POST[dvalores][$x];
									$valordeb=0;
									$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('20 $consec','$rowi[4]','$_POST[tercero]','$_POST[cc]','Ingreso sin Situacion de Fondos ".strtoupper($_POST[dncoding][$x])."','','$valordeb','$valorcred','1','$_POST[vigencia]')";
									mysql_query($sqlr,$linkbd);
				 				}
								if($rowi[6]=='S')
				 				{
			  						$valordeb=$_POST[dvalores][$x];
									$valorcred=0;				   
									$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('20 $consec','$rowi[4]','$_POST[tercero]','$_POST[cc]','Ingreso sin Situacion de Fondos ".strtoupper($_POST[dncoding][$x])."','','$valordeb','$valorcred','1','$_POST[vigencia]')";
									mysql_query($sqlr,$linkbd);
									$vi=$_POST[dvalores][$x];
				 				}
		 					}
		 				}
					}	
					//************ insercion de cabecera recaudos ************
					$sqlr="insert into tesossfingreso_cab (id_recaudo,idcomp,fecha,vigencia,concepto,tercero,cc,valortotal,estado) values($consec,$idcomp,'$fechaf','$_POST[vigencia]','".strtoupper($_POST[concepto])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S')";	  
					mysql_query($sqlr,$linkbd);
					$idrec=$consec;
					//************** insercion de consignaciones **************
					for($x=0;$x<count($_POST[dcoding]);$x++)
	 				{
						$sqlr="insert into tesossfingreso_det (id_recaudo,ingreso,valor,estado) values($consec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	
						if (!mysql_query($sqlr,$linkbd))
						{
							echo "<table ><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
							echo "Ocurrió el siguiente problema:<br>";
  	 						echo "<pre>";
     						echo "</pre></center></td></tr></table>";
						}
  						else
  		 				{
							$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$_POST[vigencia]'";
	 						$resi=mysql_query($sqlri,$linkbd);
							while($rowi=mysql_fetch_row($resi))
		 					{
		  						$vi=$_POST[dvalores][$x];
		  						$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[5].' AND VIGENCIA= '$_POST[vigencia]'";
		  						mysql_query($sqlr,$linkbd);	
				 				//****creacion documento presupuesto ingresos
			  					$sqlr="insert into pptoingssf (cuenta,idrecibo,valor,vigencia) values('$rowi[5]',$consec,$vi,'$_POST[vigencia]')";
  			  					mysql_query($sqlr,$linkbd);	
								if($rowi[5]!="" && $vi>0)
								{			
		 							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo) values('$rowi[5]','$_POST[tercero]','INGRESOS SSF','$vi',0,'$_POST[estadoc]','$_POST[vigencia]','21','$consec')";
		 							mysql_query($sqlr,$linkbd); 			  
								}
		 					}			 			 
		  					echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso SSF con Exito <img src='imagenes/confirm.png'></center></td></tr></table>
		  					<script>
		 						document.form2.numero.value='';
		  						document.form2.valor.value=0;
		 					</script>";
		 				}
					}	 
				}
			?>	
		</form>
	</body>
</html>