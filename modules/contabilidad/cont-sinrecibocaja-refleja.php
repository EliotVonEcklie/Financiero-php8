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
			function validar(){document.form2.submit();}
			function guardar()
			{
				if (document.form2.fecha.value!='' && ((document.form2.modorec.value=='banco' && document.form2.banco.value!='') || (document.form2.modorec.value=='caja')))
  				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
					// if (confirm("Esta Seguro de Guardar"))
  					// {
  						// document.form2.oculto.value=2;
  						// document.form2.submit();
  					// }
  				}
  				else
				{
  					// alert('Faltan datos para completar el registro');
  					// document.form2.fecha.focus();
  					// document.form2.fecha.select();
					despliegamodalm('visible','2','Faltan datos para completar el registro');
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
					{document.getElementById('codrec').value=parseFloat(document.getElementById('codrec').value)+1;}
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					document.form2.action="cont-sinrecibocaja-refleja.php";
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
 				{
					document.form2.oculto.value=1;
					if(document.getElementById('codrec').value!="")
					{document.getElementById('codrec').value=parseFloat(document.getElementById('codrec').value)-1;}
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					document.form2.action="cont-sinrecibocaja-refleja.php";
					document.form2.submit();
				 }
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="cont-sinrecibocaja-refleja.php";
				document.form2.submit();
			}
			
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.form2.oculto.value=2;
						document.form2.submit();
					break;
				}
			}
			function funcionmensaje()
			{
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
					<a class="mgbt"><img src="imagenes/guardad.png" /></a>
					<a href="cont-buscasinrecibocaja-rgreflejar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/reflejar1.png" title="Reflejar" style="width:24px;"/></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" style="width:29px;height:25px;" title="Imprimir" /></a>
					<a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
			</tr>		  
		</table>
		<?php 
		$sqlr="select * from admbloqueoanio";
		$res=mysql_query($sqlr,$linkbd);
		$_POST[anio]=array();
		$_POST[bloqueo]=array();
		while ($row =mysql_fetch_row($res)){
			$_POST[anio][]=$row[0];
			$_POST[bloqueo][]=$row[1];
		}
		?>
		
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action=""> 
		<input type="hidden" name="anio[]" id="anio[]" value="<?php echo $_POST[anio] ?>">
		<input type="hidden" name="anioact" id="anioact" value="<?php echo $_POST[anioact] ?>">
		<input type="hidden" name="bloqueo[]" id="bloqueo[]" value="<?php echo $_POST[bloqueo] ?>">
        	<input type="hidden" name="codrec" id="codrec" value="<?php echo $_POST[codrec];?>" />
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				$sqlr="SELECT cuentacaja FROM tesoparametros";
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
				$sqlr="select id_recibos,id_recaudo from  tesosinreciboscaja ORDER BY id_recibos DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
				if(!$_POST[oculto])
				{
					$fec=date("d/m/Y");
					if ($_POST[codrec]!="" || $_GET[idrecibo]!="")
						if($_POST[codrec]!="")
						{$sqlr="select id_recibos,id_recaudo from tesosinreciboscaja where id_recibos='$_POST[codrec]'";}
						else 
						{$sqlr="select id_recibos,id_recaudo from tesosinreciboscaja where id_recibos='$_GET[idrecibo]'";}
					else
					{$sqlr="select id_recibos,id_recaudo from  tesosinreciboscaja ORDER BY id_recibos DESC";}	
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
	 				//$_POST[maximo]=$r[0];
	 				$_POST[ncomp]=$r[0];
					$_POST[idcomp]=$r[0];
	 				$_POST[idrecaudo]=$r[1];	 
	 				if($_GET[idrecibo]!="")
					{
	 	 				$_POST[idcomp]=$_GET[idrecibo];
		  				$_POST[ncomp]=$_GET[idrecibo];
					}
				}
 				$sqlr="select * from tesosinreciboscaja where id_recibos=$_POST[idcomp]";
 				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
		 		{		  
		  			$_POST[tiporec]=$r[10];
		  			$_POST[idrecaudo]=$r[4];
		  			$_POST[ncomp]=$r[0];
		  			$_POST[modorec]=$r[5];	
		 		}
			?>
			<input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
            <input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
            <input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
            <input type="hidden" name="encontro" value="<?php echo $_POST[encontro]?>" >
  			<input type="hidden" name="codcatastral" value="<?php echo $_POST[codcatastral]?>" >
			<?php 
				switch($_POST[tiporec]) 
  				{
	  				case 3:	$sqlr="select * from tesosinrecaudos where id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
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
								$_POST[cc]=$row[8];
							}
							$sqlr="select *from tesosinreciboscaja where id_recibos=$_POST[idcomp] ";
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
							//echo $_POST[banco];
        					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   						$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
							$_POST[vigencia]=$fecha[1];
							break;	
				}
 			?>
    		<table class="inicio">
      			<tr>
       				<td class="titulos" colspan="9">Interfaz Cont. Ingresos Propios</td>
        			<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
        			<td class="saludo1" style="width:2.5cm;">No Recibo:</td>
        			<td style="width:10%;">
                    	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                        <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" >
                        <input name="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()" style="width:50%;">
                        <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
                        <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
                        <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
                        <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
                  	</td>
	  				<td class="saludo1" style="width:2.5cm;">Fecha:</td>
        			<td style="width:10%;"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
         			<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
		  			<td style="width:38%;">
                    	<input type="text" id="vigencia" name="vigencia"onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" readonly>   
                        <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">  
						<?php 
							if($_POST[estadoc]=="1"){
								$valuees="ACTIVO";
								$stylest="width:30%; background-color:#0CD02A; color:white; text-align:center;";
							}else if($_POST[estadoc]=="0"){
								$valuees="ANULADO";
								$stylest="width:30%; background-color:#FF0000; color:white; text-align:center;";
							}else if($_POST[estadoc]=="P"){
								$valuees="PAGO";
								$stylest="width:30%; background-color:#0404B4; color:white; text-align:center;";
							}

							echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
						?>
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
                    <td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" onKeyUp="return tabular(event,this)" readonly></td>
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
                	<td class="saludo1" width="71">Concepto:</td>
                    <td colspan="5"><input type="text" name="concepto"  value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly ></td>
            	</tr>
      			<tr>
                	<td class="saludo1" width="71">Valor:</td>
                    <td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" onKeyUp="return tabular(event,this)" readonly ></td>
                    <td  class="saludo1">Documento: </td>
        			<td ><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" readonly> </td>
			 		<td class="saludo1">Contribuyente:</td>
	  				<td>
                    	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;"  readonly>
                        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  				</td>
      				<td>
	    				
             	</tr>
      		</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    	<input type="hidden" value="0" name="agregadet"></td>
     		<div class="subpantalla" style="height:59.2%; width:99.6%; overflow-x:hidden;">
      		<?php 
 				if($_POST[oculto] && $_POST[encontro]=='1')
 				{
 				 	switch($_POST[tiporec]) 
  	 				{
	 					case 3:	///*****************otros recaudos *******************
	  		 					$_POST[trec]='OTROS RECAUDOS';	 
  								$sqlr="select * from tesosinrecaudos_det where id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
								$_POST[dcoding]= array(); 		 
								$_POST[dncoding]= array();
								$_POST[dncc]= array();
		 						$_POST[dvalores]= array(); 				 
  								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{	
									$_POST[dcoding][]=$row[2];
									$_POST[dncc][]=$row[5];
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
							<td style='width:10%;>
								<input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'><input type='hidden' name='dncc[]' value='".$_POST[dncc][$x]."'>".$_POST[dcoding][$x]."</td>
							<td><input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'>".$_POST[dncoding][$x]."</td>
							<td style='width:20%;text-align:right;'><input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'>$ ".number_format($_POST[dvalores][$x],2,',','.')."</td>
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
						<tr class='$iter'>
							<td  style='text-align:right;' colspan='2'>Total:</td>
							<td  style='text-align:right;'>
								<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
								<input name='totalc' type='hidden' value='$_POST[totalc]'>$ ".number_format($_POST[totalc],2,',','.')."
							</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='5'><input type='hidden' name='letras' value='$_POST[letras]'>$_POST[letras]</td>
						</tr>";
				?> 
	   		</table>
	  		<?php
			if($_POST[oculto]=='2')
			{
				$linkbd=conectar_bd();
	
				$anioact=split("/", $_POST[fecha]);
				$_POST[anioact]=$anioact[2];
				for($x=0;$x<count($_POST[anio]);$x++)
				{
					if($_POST[anioact]==$_POST[anio][$x])
					{
						if($_POST[bloqueo][$x]=='S')
						{
							$bloquear="S";
						}else
						{
							$bloquear="N";
						}
					}
				}
				if($bloquear=="N")
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
					if($bloq>=1)
					{						
						//************VALIDAR SI YA FUE GUARDADO ************************
						switch($_POST[tiporec]) 
						{	  
							case 3: //**************OTROS RECAUDOS	
								$sqlr="delete from comprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='25'";
								mysql_query($sqlr,$linkbd);
								$sqlr="delete from comprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='25'";
								//echo $sqlr;
								mysql_query($sqlr,$linkbd);
								$sqlr="delete from pptosinrecibocajappto where idrecibo=$_POST[idcomp]";
								//	echo $sqlr;		
								mysql_query($sqlr,$linkbd);
								//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
								preg_match('/^([0-9]{1,2})[\/.-]([0-9]{1,2})[\/.-]([0-9]{4})$/',  $_POST[fecha],$fecha);
								$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								$fechavige=$fecha[3];
								//$fechavige=$fecha[1];
								//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
								//***busca el consecutivo del comprobante contable
								$consec=$_POST[idcomp];
								//***cabecera comprobante
								$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,25,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";
								mysql_query($sqlr,$linkbd);
								//echo $sqlr;	
								$idcomp=mysql_insert_id();
								//	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
			
								$sqlr="delete from pptosinrecibocajappto where idrecibo=$consec ";
								//  mysql_query($sqlr,$linkbd);	
								//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
								for($x=0;$x<count($_POST[dcoding]);$x++)
								{
									//***** BUSQUEDA INGRESO ********
									$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$fechavige";
									$resi=mysql_query($sqlri,$linkbd);
									//	echo "$sqlri <br>";	    
									while($rowi=mysql_fetch_row($resi))
									{
										//**** busqueda cuenta presupuestal*****
										//busqueda concepto contable
										$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and cc=".$_POST[dncc][$x]." and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
										$re=mysql_query($sq,$linkbd);
										while($ro=mysql_fetch_assoc($re))
										{
											$_POST[fechacausa]=$ro["fechainicial"];
										}
										$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and cc=".$_POST[dncc][$x]." and fechainicial='".$_POST[fechacausa]."'";
										$resc=mysql_query($sqlrc,$linkbd);	  
										//echo "concc: $sqlrc <br>";	      
										while($rowc=mysql_fetch_row($resc))
										{
											$porce=$rowi[5];
											if($rowc[6]=='S')
											{
												$valorcred=$_POST[dvalores][$x]*($porce/100);
												$valordeb=0;
						
												if($rowc[3]=='N')
												{
												   //*****inserta del concepto contable  
												   //***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$fechavige";
													$respto=mysql_query($sqlrpto,$linkbd);	  
													//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
				
													$vi=$_POST[dvalores][$x]*($porce/100);
													$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$fechavige";
													//mysql_query($sqlr,$linkbd);	
				
													//****creacion documento presupuesto ingresos
			
													$sqlr="insert into pptosinrecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$consec,$vi,'".$fechavige."')";
													mysql_query($sqlr,$linkbd);	
													//echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL
				
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $consec','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
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
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('25 $consec','".$cuentacb."','".$_POST[tercero]."','".$rowc[5]."','Ingreso ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",0,'1','".$_POST[vigencia]."')";
													mysql_query($sqlr,$linkbd);
													//echo "Conc: $sqlr <br>";					
												}
				
											}
										}
									}
								}
							break;
							//********************* INDUSTRIA Y COMERCIO
						} //*****fin del switch
					}//***bloqueo
					else
					{
						//echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
						?>
						<script>
							//alert("¡No se puede reflejar por Bloqueo de Fecha!");
							despliegamodalm('visible','2',"No Tiene los Permisos para Modificar este Documento");
						</script>
						<?php
					}
				}
				else
				{
					?>
					<script>
						//alert("¡No se puede reflejar por Bloqueo de Fecha!");
						despliegamodalm('visible','2',"No se puede reflejar por Cierre de Año");
					</script>
					<?php

				}
			}//**fin del oculto 

				?>
			</div>
		</form><?php if($_POST[oculto]==""){echo"<script>validar2();</script>";}?>
	</body>
</html>