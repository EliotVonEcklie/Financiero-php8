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
		<title>:: Spid - Presupuesto</title>
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
					document.form2.action="presu-recibocaja-reflejar.php";
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
					document.form2.action="presu-recibocaja-reflejar.php";
					document.form2.submit();
 				}
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="presu-recibocaja-reflejar.php";
				document.form2.submit();
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("presu");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="presu-buscarecibocaja-reflejar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/reflejar1.png" title="Reflejar" style="width:24px;"/></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  title="Imprimir" /></a>
					<a href="presu-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
				</td>
			</tr>		  
		</table>
 		<form name="form2" method="post" action=""> 
        	<input type="hidden" name="codrec" id="codrec" value="<?php echo $_POST[codrec];?>" />
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
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
				}
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
			?>
			<input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
			<input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
 			<input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
 			<input type="hidden" name="encontro"  value="<?php echo $_POST[encontro]?>" >
  			<input type="hidden" name="codcatastral"  value="<?php echo $_POST[codcatastral]?>" >
 			<?php 
				switch($_POST[tiporec]) 
  	 			{
	  			case 1:
					$sql="SELECT FIND_IN_SET($_POST[idcomp],recibo),idacuerdo FROM tesoacuerdopredial ";
					$result=mysql_query($sql,$linkbd);
					$val=0;
					$compro=0;
					while($fila = mysql_fetch_row($result)){
					if($fila[0]!=0){
						$val=$fila[0];
						$compro=$fila[1];
						break;
					 }
					}
					if($val>0){
						$_POST[tipo]="1";
						$_POST[idrecaudo]=$compro;	
						$sqlr="select vigencia from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo]  ";
						$res=mysql_query($sqlr,$linkbd);
						$vigencias="";
						while($row = mysql_fetch_row($res)){
							$vigencias.=($row[0]."-");
						}
						$vigencias=utf8_decode("Años liquidados: ".substr($vigencias,0,-1));
						$sql="select * from tesoacuerdopredial where tesoacuerdopredial.idacuerdo=$_POST[idrecaudo] and estado='S' ";
						$result=mysql_query($sql,$linkbd);
						$_POST[encontro]="";
						while($row = mysql_fetch_row($result)){
								$_POST[cuotas]=$row[10]+1;
								$_POST[tcuotas]=$row[4];
								$_POST[codcatastral]=$row[1];	
								if($_POST[concepto]==""){$_POST[concepto]=$vigencias.' Cod Catastral No '.$row[1];}	
									$_POST[valorecaudo]=$row[7];		
									$_POST[totalc]=$row[7];	
									$_POST[tercero]=$row[13];										
									$_POST[encontro]=1;
						}
					$sqlr1="select nombrepropietario from tesopredios where cedulacatastral='$_POST[codcatastral]' and estado='S'";
						$resul=mysql_query($sqlr1,$linkbd);
						$row1 =mysql_fetch_row($resul);
	  					$_POST[ntercero]=$row1[0];
						if ($_POST[ntercero]=='')
		 				{
		  					$sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
		  					$resc=mysql_query($sqlr2,$linkbd);
		  					$rowc =mysql_fetch_row($resc);
		   					$_POST[ntercero]=$rowc[6];
		 				}	
					}else{
					$_POST[tipo]="2";
					$sqlr="select *from tesoliquidapredial, tesoreciboscaja where tesoliquidapredial.idpredial=tesoreciboscaja.id_recaudo and tesoreciboscaja.estado !=''  and tesoreciboscaja.id_recibos=".$_POST[idcomp];
  	 				$_POST[encontro]="";
					//echo $sqlr."<br>";
	  				$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
	 				{
						$_POST[codcatastral]=$row[1];
						//$_POST[idcomp]=$row[19];	
						$_POST[idrecaudo]=$row[25];	
						$_POST[fecha]=$row[23];
						$_POST[vigencia]=$row[3];			
						$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];	
						$_POST[valorecaudo]=$row[8];		
						$_POST[totalc]=$row[8];	
						$_POST[tercero]=$row[4];		
						$_POST[modorec]=$row[24];
						$_POST[banco]=$row[25];
						if($row[28]=='S') {$_POST[estadoc]='ACTIVO';} 	 				  
		 				if($row[28]=='N'){$_POST[estadoc]='ANULADO';} 	
						$sqlr1="select nombrepropietario from tesopredios where cedulacatastral='$_POST[codcatastral]' and estado='S'";
						$resul=mysql_query($sqlr1,$linkbd);
						$row1 =mysql_fetch_row($resul);
	  					$_POST[ntercero]=$row1[0];
						if ($_POST[ntercero]=='')
		 				{
		  					$sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
		  					$resc=mysql_query($sqlr2,$linkbd);
		  					$rowc =mysql_fetch_row($resc);
		   					$_POST[ntercero]=$rowc[6];
		 				}			
	  					$_POST[encontro]=1;
					}
					}
	  				
	  				$sqlr="select *from tesoreciboscaja where tipo='1' and id_recaudo=$_POST[idrecaudo] ";
					//echo $sqlr;
					$res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res); 
					//$_POST[idcomp]=$row[0];
					$_POST[estadoc]=$row[9];
					$_POST[fecha]=$row[2];
		   			if ($_POST[estadoc]=='N') {$_POST[estado]="ANULADO";}
		   			else {$_POST[estado]="ACTIVO";}
					$_POST[modorec]=$row[5];
					$_POST[banco]=$row[7];
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
    		<table class="inicio" style="width:99.7%;">
                <tr>
                    <td class="titulos" colspan="9">Reflejar Recibo de Caja</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
        			<td class="saludo1" style="width:2cm;">No Recibo:</td>
        			<td style="width:20%;" colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>"> 
                    	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="anterior" align="absmiddle"/></a> 
                        <input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>" />
                        <input type="text" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  style="width:50%;" />
                        <a href="#" onClick="adelante()"><img src="imagenes/next.png" title="siguiente" align="absmiddle"/></a> 
                        <input type="hidden" value="a" name="atras"/>
                        <input type="hidden" value="s" name="siguiente"/>
                        <input type="hidden" name="maximo" value="<?php echo $_POST[maximo]?>" />
               		</td>
	 				<td class="saludo1" style="width:2.3cm;">Fecha:</td>
        			<td style="width:18%;"><input type="text" name="fecha"  value="<?php echo $_POST[fecha]?>"  onKeyUp="return tabular(event,this)" style="width:45%;" readonly />
					<?php 
							if($_POST[estado]=='ACTIVO'){
								echo "<input name='estado' type='text' value='ACTIVO' size='5' style='width:52%; background-color:#0CD02A; color:white; text-align:center;' readonly >";
							}
							else
							{
								echo "<input name='estado' type='text' value='ANULADO' size='5' style='width:40%; background-color:#FF0000; color:white; text-align:center;' readonly >";
							}
						?>
					</td>
         			<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
		  			<td style="width:12%;">
                    	<input type="text" id="vigencia" name="vigencia" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" readonly>
                   	</td>
                  	<td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>     
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
						<?php 
					if($_POST[tiporec]=='1'){
					?>
					<td class="saludo1"> Tipo:</td>
                    <td>
                    	<select name="tipo" id="tipo" onKeyUp="return tabular(event,this)" style="width:100%;" onChange="document.form2.submit()">
							<option value=""> Seleccione ...</option>
         					<option value="1" <?php if($_POST[tipo]=='1'){echo 'SELECTED'; }?> >Por Acuerdo</option>
          					<option value="2" <?php if($_POST[tipo]=='2'){echo 'SELECTED'; }?> >Por Liquidacion</option>
  
        				</select>
          			</td>
					<?php 
					
					}
					
					?>
					
        			<td class="saludo1"><?php if($_POST[tipo]=='1') {echo 'No. Acuerdo:'; }else{echo 'No Liquidaci&oacute;n:'; } ?></td>
                    <td><input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;" readonly></td>
					<td class="saludo1">Recaudado en:</td>
     				<td> 
                    	<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" style="width:100%;" >
                        	<?php
								if($_POST[modorec]=='banco'){echo"<option value='banco' SELECTED>Banco</option>";}
								else{echo"<option value='caja' SELECTED>Caja</option>";}
							?>
        				</select>
          			</td>
       			</tr>
                <?php
					if ($_POST[modorec]=='banco')
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta:</td>
							<td>
								<select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%'>
									<option value=''>Seleccione....</option>";
						$sqlr="select TB1.estado,TB1.cuenta,TB1.ncuentaban,TB1.tipo,TB2.razonsocial,TB1.tercero from tesobancosctas TB1,terceros TB2 where TB1.tercero=TB2.cedulanit and TB1.estado='S' ";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							if("$row[1]"==$_POST[banco])
							{
								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
								$_POST[nbanco]=$row[4];
								$_POST[ter]=$row[5];
								$_POST[cb]=$row[2];
							}
							else{echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}
						}	 	
						echo"
								</select>
							</td>
							<input type='hidden' name='cb' value='$_POST[cb]'/>
							<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/></td>
							<td class='saludo1'>Banco:</td>
							<td colspan='3'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%;' readonly></td>
						</tr>";
					}
					
					$sqlr="select nota from teso_notasrevelaciones where modulo='teso' and tipo_documento='5' and numero_documento='$_POST[idcomp]'";
					// echo $sqlr;
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[notaf]=$row[0];
				?> 
	  			<tr>
                	<td class="saludo1">Concepto:</td>
                    <td colspan="<?php if($_POST[tiporec]==2){echo '3';}else{echo'5';}?>">
						<input name="concepto" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style="width:95%;" readonly>
						<input type="hidden" name="notaf" id="notaf" value="<?php echo $_POST[notaf]?>" >
						<?php 
							if($_POST[notaf]==''){
						?>
						<a onClick="despliegamodal2('visible',2);" title="Notas"><img src="imagenes/notad.png" style="width:20px; cursor:pointer"></a>
						<?php
							}else{
						?>
						<a onClick="despliegamodal2('visible',2);" title="Notas"><img src="imagenes/notaf.png" style="width:20px; cursor:pointer"></a>
						<?php
							}
						?>
					</td>
              	</tr>
                <tr>
                	<td  class="saludo1"  >Documento: </td>
        			<td colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>"><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
			  		<td class="saludo1">Contribuyente:</td>
	  				<td colspan="3">
                    	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this) " style="width:100%;" readonly>
                        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  				</td>
                </tr>
      			<tr>
                	<td class="saludo1" >Valor:</td>
                    <td colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>"><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly /></td>
                     
            	</tr>
                <?php if ($_POST[modorec]!='banco'){echo"<tr style='height:20;'><tr>";}?>
			</table>
      		<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    	<input type="hidden" value="0" name="agregadet">
     		<div class="subpantalla" style="height:49.2%; width:99.6%; overflow-x:hidden;">
      			<?php 
	      			function obtenerTipoPredio($catastral){
						global $linkbd;
						$sql="SELECT tesopredios.tipopredio FROM tesoreciboscaja,tesoliquidapredial,tesopredios WHERE tesoreciboscaja.id_recaudo=tesoliquidapredial.idpredial AND tesoliquidapredial.codigocatastral=tesopredios.cedulacatastral AND tesopredios.estado='S' AND tesopredios.cedulacatastral='$catastral' ";
						$res=mysql_query($sql,$linkbd);
						$row=mysql_fetch_row($res);
						return $row[0];
					} 
 					if($_POST[oculto] && $_POST[encontro]=='1')
 					{
  						switch($_POST[tiporec]) 
  	 					{
	  						case 1: //********PREDIAL

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
 	 								if($_POST[tipo]=='1'){
								$sqlr="select * from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo] ";
								$res=mysql_query($sqlr,$linkbd);
							//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
								while ($row =mysql_fetch_row($res)) 
								{
								$vig=$row[13];
								if($vig==$vigusu)
								{
									$sqlr2="select * from tesoingresos where codigo='01'";
									$res2=mysql_query($sqlr2,$linkbd);
									$row2 =mysql_fetch_row($res2); 
									$_POST[dcoding][]=$row2[0];
									$_POST[dncoding][]=$row2[1]." ".$vig;			 		
									$_POST[dvalores][]=($row[10]/$_POST[tcuotas]);		 
									//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
								}
								else
								{	
									$sqlr2="select * from tesoingresos where codigo='03'";
									$res2=mysql_query($sqlr2,$linkbd);
									$row2 =mysql_fetch_row($res2); 
									$_POST[dcoding][]=$row2[0];
									$_POST[dncoding][]=$row2[1]." ".$vig;			 		
									$_POST[dvalores][]=($row[10]/$_POST[tcuotas]);		
								}
							}
								
								
							}else{
								$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
								
							
							
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
									//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
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
							
							}
							   
	  								break;
	  						case 2:	//***********INDUSTRIA Y COMERCIO
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
				<input type="hidden" name="ncomp" value="<?php echo $_POST[ncomp]; ?>" id="ncomp" />	
				
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
	  
		if($_POST[oculto]=='2')
		{
			
			$concecc='';
			
			if($_POST[tiporec]!='1')
			{				 
				
				
				if(strpos($_POST[fecha],"-")===false){
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				}else{
					$fechaf=$_POST[fecha];
				}
			
				$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
				
			}
			else
			{				 
				$bloq=bloqueos($_SESSION[cedulausu],$_POST[fecha]);	
			}
		
			if($bloq>=0)
			{						
				//************VALIDAR SI YA FUE GUARDADO ************************
				switch($_POST[tiporec]) 
  		 		{
	  				case 1://***** PREDIAL *****************************************
	 							$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
	  							if($numerorecaudos>=0)
	   							{ 	
									$concecc=$_POST[idcomp]; 
	   								$sql="DELETE FROM pptorecibocajappto WHERE idrecibo=$_POST[idcomp] ";
	   								mysql_query($sql,$linkbd);

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

									echo "<input type='hidden' name='concec' value='$concecc'>";	
									echo "<script>
											despliegamodalm('visible','1','>Se ha almacenado el Recibo de Caja con Exito');
											document.form2.vguardar.value='1';
											
										</script>";
		  							
		 							echo"
		  							<script>
		  								document.form2.numero.value='';
		  								document.form2.valor.value=0;
		  							</script>";
									//**********************CREANDO COMPROBANTE CONTABLE ********************************	 
	 						
		 							//******parte para el recaudo del cobro por recibo de caja
									
		 							for($x=0;$x<count($_POST[dcoding]);$x++)
		 							{
		 									//***** BUSQUEDA INGRESO ********
											$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 										$resi=mysql_query($sqlri,$linkbd);
											//echo "$sqlri <br>";	    
											while($rowi=mysql_fetch_row($resi))
		 									{
	    										//**** busqueda cuenta presupuestal*****
												//busqueda concepto contable
			 									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='".$rowi[2]."' and tipo='C'";
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
			 												$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 												$respto=mysql_query($sqlrpto,$linkbd);	  
			 												//echo "con: $sqlrpto <br>";	      
															$rowpto=mysql_fetch_row($respto);
															$vi=$_POST[dvalores][$x]*($porce/100);
			  															
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
			   								
															//echo "Conc: $sqlr <br>";					
														}
													}
		 										}
		 									}
									}
									
	 								//*************** fin de cobro de recibo
									
									$sql="select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo] and (estado ='S' OR estado ='P')";																		 
									$resul=mysql_query($sql,$linkbd);
									$rowcod=mysql_fetch_row($resul);
									$tipopre=obtenerTipoPredio($rowcod[0]);
									
									if($_POST[tipo]=='1'){
										$sqlrs="select *from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo] ";
										$res=mysql_query($sqlrs,$linkbd);	
										$rowd==mysql_fetch_row($res);
										$tasadesc=(($rowd[5]/$_POST[tcuotas])/100);
										$sqlr="select *from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo]";
									}else{
										$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
										$res=mysql_query($sqlrs,$linkbd);	
										$rowd==mysql_fetch_row($res);
										$tasadesc=($rowd[6]/100);
										$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
										
									}
									
									$res=mysql_query($sqlr,$linkbd);
		 							//echo "<BR>".$sqlr;
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									while ($row =mysql_fetch_row($res)) 
									{
										
										if($_POST[tipo]=='1'){
											$vig=$row[13];
											$vlrdesc=($row[9]/$_POST[tcuotas]);
										}else{
											$vig=$row[1];
											$vlrdesc=$row[10];	
										}
									
										if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
		 								{
			 								// $tasadesc=$row[10]/($row[4]+$row[6]);		
											// echo "<BR>".$sqlr;
		 									$idcomp=$_POST[idcomp];
		 									
											$sqlr2="select * from tesoingresos_DET where codigo='01' AND MODULO='4' and vigencia=$vigusu GROUP BY concepto";
											$res2=mysql_query($sqlr2,$linkbd);
											 //echo "<BR>".$sqlr2;				 
				 							//****** $cuentacb   ES LA CUENTA CAJA O BANCO
											while($rowi =mysql_fetch_row($res2))
		 									{
		  										switch($rowi[2])
		   										{
													
													case '01': //***
													
														$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P01' AND MODULO='4' and vigencia=$vigusu";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds))
		   												{
					 										$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);
															//echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
														}
				 										$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 		 								//echo "<BR>".$sqlrc;
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{	
																if($_POST[tipo]=='1'){
																	$valorcred=($row[2]/$_POST[tcuotas]);
																}else{
																	$valorcred=$row[4];
																}
																
																$valordeb=$valorcred;				
																if($rowc[3]=='N')
				   												{
				 	 												if($valorcred>0)
					  												{
																		
																		// echo "<BR>".$sqlr;
					     												//******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO ******
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valorcred-$descpredial;
																
			 	 														//****creacion documento presupuesto ingresos
			  															
																	$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='01' AND vigencia=$vigusu";
																		//echo $sql;
																		$resul=mysql_query($sql,$linkbd);
																		$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
			  															while($rowp = mysql_fetch_row($resul)){
																		if($rowp[0]!=$rowi[6] && $vi>0){
																			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','01')";
																			//echo $sqlr;
																			mysql_query($sqlr,$linkbd);	
																			$sqlr="";
																		  }
																	   }
																	   if($numreg==0 ){
																		  
																		   if($vi>0){
																			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','01')";
																			  //echo $sqlr;
																			  mysql_query($sqlr,$linkbd);  
																			  $sqlr="";
																		   }
																		 	 
																	   }
																		//echo "ppt:$sqlr";
																		//************ FIN MODIFICACION PPTAL		
					  												}
																}
				  											}
														}
														break; 
															
													case '02': //***
			 											$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										// echo "<BR>".$sqlrc;
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{	
																if($_POST[tipo]=='1'){
																	$valorcred=($row[7]/$_POST[tcuotas]);
																}else{
																	$valorcred=$row[8];
																}
																
																$valordeb=$valorcred;					
																if($rowc[3]=='N')
				    											{
				 	 												if($valorcred>0)
					  												{
				 												
																		// echo "<BR>".$sqlr;
					  													//*******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *******
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																		
			  															//****creacion documento presupuesto ingresos
			  															
  			  															mysql_query($sqlr,$linkbd);	
																	$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND  tipo NOT LIKE '%$tipopre%' AND concepto='02' AND vigencia=$vigusu";
																		//echo $sql;
																	$resul=mysql_query($sql,$linkbd);
																	$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
																	while($rowp = mysql_fetch_row($resul)){
																	if($rowp[0]!=$rowi[6] && $vi>0){
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','02')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	  }
																   }
																   if($numreg==0 ){
																	  
																		  if($vi>0 && $rowi[6]!="")
			   															{
																			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','02')";
																			//echo $sqlr;
																			mysql_query($sqlr,$linkbd); 
																			$sqlr="";
			 															
		  																}
																		 
																   }
																	 
																	 
			  															
																		//echo "ppt:$sqlr";
																		//************ FIN MODIFICACION PPTAL			
					  												}
																}
				  											}
														}
														break;
													
													case '03': 
														$sqlrds="select * from tesoingresos_DET where codigo='01' and concepto='P10' AND MODULO='4' and vigencia='$vigusu'";
														$resds=mysql_query($sqlrds,$linkbd);
														while($rowds =mysql_fetch_row($resds))
		   												{
					 										$descpredial=round($vlrdesc*(round($rowds[5]/100,2)),2);
															//echo "<BR>$vlrdesc*($rowds[5]/100) desc".$descpredial;
														}
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										// echo "<BR>".$sqlrc;
														while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{	
																if($_POST[tipo]=='1'){
																	$valorcred=($row[5]/$_POST[tcuotas]);
																}else{
																	$valorcred=$row[6];
																}
																
																$valordeb=$valorcred;					
																if($rowc[3]=='N')
				    											{
				 	 												if($valorcred>0)
					  												{
				 													
																		//echo "<BR>".$sqlr;
					  													//*********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb-$descpredial;
																	
			  															//****creacion documento presupuesto ingresos
			  																
			 	 														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='03' AND vigencia=$vigusu";
																		//echo $sql;
																	$resul=mysql_query($sql,$linkbd);
																	$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
																	while($rowp = mysql_fetch_row($resul)){
																	if($rowp[0]!=$rowi[6] && $vi>0){
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','03')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	  }
																   }
																   if($numreg==0 ){
																	  
																		  if($vi>0 && $rowi[6]!="")
			   															{
																			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','03')";
																			//echo $sqlr;
																			mysql_query($sqlr,$linkbd); 
																			$sqlr="";
			 															
		  																}
																		 
																   }
																		//echo "ppt:$sqlr";
																		//************ FIN MODIFICACION PPTAL			
					  												}
																}
				  											}
				 										}
														break;  
															
													case 'P10': 
														$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 										$resc=mysql_query($sqlrc,$linkbd);	  
				 										// echo "<BR>".$sqlrc;
				 										while($rowc=mysql_fetch_row($resc))
				 										{
			  												$porce=$rowi[5];
															if($rowc[6]=='S')
			 	  											{	
																if($_POST[tipo]=='1'){
																	$valordeb=round(($row[9]/$_POST[tcuotas])*round(($porce/100),2),2);
																}else{
																	$valordeb=round($row[10]*round(($porce/100),2),2);
																}
																
																$valorcred=$valordeb;		
																//echo "<BR>$row[10] $porce ".$valordeb;			
																if($rowc[3]=='N')
				    											{
				 	 												if($valordeb>0)
					  												{						
				 												
																		//echo "<BR>".$sqlr;
							  											//********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 															//echo "con: $sqlrpto <br>";	      
																		$rowpto=mysql_fetch_row($respto);
																		$vi=$valordeb;
																
			  															//****creacion documento presupuesto ingresos
			  															
			  															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P10' AND vigencia=$vigusu";
																		//echo $sql;
																	$resul=mysql_query($sql,$linkbd);
																	$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
																	while($rowp = mysql_fetch_row($resul)){
																	if($rowp[0]!=$rowi[6] && $vi>0){
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P10')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	  }
																   }
																   if($numreg==0 ){
																	  
																		  if($vi>0 && $rowi[6]!="")
			   															{
																			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P10')";
																			//echo $sqlr;
																			mysql_query($sqlr,$linkbd); 
																			$sqlr="";
			 															
		  																}
																		 
																   }
																		//echo "ppt:$sqlr";
																		//************ FIN MODIFICACION PPTAL	
					  												}
																}
				 											}
				 										}
													break;  
												case 'P01': 
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C'";
	 			 									$resc=mysql_query($sqlrc,$linkbd);	  
				 									//echo "<BR>".$sqlrc;
				 									while($rowc=mysql_fetch_row($resc))
													{
			  											$porce=$rowi[5];
														if($rowc[6]=='S')
			 	  										{	
															if($_POST[tipo]=='1'){
																	$valordeb=round(($row[9]/$_POST[tcuotas])*round(($porce/100),2),2);
																}else{
																	$valordeb=round($row[10]*round($porce/100,2),2);
																}
																
															
															// $descpredial=round($vlrdesc*round($rowds[5]/100,2),2);
															$valorcred=0;					
															if($rowc[3]=='N')
				    										{
				 												if($valordeb>0)
					  											{						
				 											
																	// echo "<BR>".$sqlr;
							  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 														$respto=mysql_query($sqlrpto,$linkbd);	  
			 														//echo "con: $sqlrpto <br>";	      
																	$rowpto=mysql_fetch_row($respto);
																	$vi=$valordeb;
																
			  														//****creacion documento presupuesto ingresos
			  															
			  														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P01' AND vigencia=$vigusu";
																		//echo $sql;
																	$resul=mysql_query($sql,$linkbd);
																	$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
																	while($rowp = mysql_fetch_row($resul)){
																	if($rowp[0]!=$rowi[6] && $vi>0){
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P01')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	  }
																   }
																   if($numreg==0 ){
																	  
																		  if($vi>0 && $rowi[6]!="")
			   															{
																			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P01')";
																			//echo $sqlr;
																			mysql_query($sqlr,$linkbd); 
																			$sqlr="";
			 															
		  																}
																		 
																   }	
																	//echo "ppt:$sqlr";
																	//************ FIN MODIFICACION PPTAL	
					  											}
															}
				  										}
				 									}
													break;
																								
												case 'P02': 
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo = '$rowi[2]' and tipo='C'";
	 			 									$resc=mysql_query($sqlrc,$linkbd);	  
				 									// echo "<BR>".$sqlrc;
				 									while($rowc=mysql_fetch_row($resc))
				 									{
			  											$porce=$rowi[5];
														if($rowc[6]=='S')
			 	  										{	
															if($_POST[tipo]=='1'){
																$valorcred=($row[3]/$_POST[tcuotas]);
															}else{
																$valorcred=$row[5];
															}
															
															$valordeb=$valorcred;					
															if($rowc[3]=='N')
				    										{
				 	 											if($valorcred>0)
					  											{
				 											
																	// echo "<BR>".$sqlr;
							  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 															$respto=mysql_query($sqlrpto,$linkbd);	  
			 														//echo "con: $sqlrpto <br>";	      
																	$rowpto=mysql_fetch_row($respto);
																	$vi=$valordeb;
																
			  														//****creacion documento presupuesto ingresos
			  														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P02' AND vigencia=$vigusu";
																		//echo $sql;
																	$resul=mysql_query($sql,$linkbd);
																	$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
																	while($rowp = mysql_fetch_row($resul)){
																	if($rowp[0]!=$rowi[6] && $vi>0){
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P02')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	  }
																   }
																   if($numreg==0 ){
																	  
																		  if($vi>0 && $rowi[6]!="")
																			{
																				$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P02')";
																				//echo "P02: ".$sqlr;
																				mysql_query($sqlr,$linkbd);
																				$sqlr="";
																			
																			}
																		 
																   }
																	   
			  														
																	//echo "ppt:$sqlr";
																	//************ FIN MODIFICACION PPTAL	
					  											}
															}
				  										}
				 									}
													break;  
												case 'P04': 
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 									$resc=mysql_query($sqlrc,$linkbd);	  
				 									// echo "<BR>".$sqlrc;
				 									while($rowc=mysql_fetch_row($resc))
				 									{
			  											$porce=$rowi[5];
														if($rowc[6]=='S')
			 	  										{		
															if($_POST[tipo]=='1'){
																$valorcred=($row[6]/$_POST[tcuotas]);
															}else{
																$valorcred=$row[7];
															}
															
															$valordeb=$valorcred;					
															if($rowc[3]=='N')
				    										{
				 	 											if($valorcred>0)
					  											{						
				 													
																	$valordeb=$valorcred;
															
																	// echo "<BR>".$sqlr;
							  										//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 		 													$respto=mysql_query($sqlrpto,$linkbd);	  
			 														//echo "con: $sqlrpto <br>";	      
																	$rowpto=mysql_fetch_row($respto);
																	$vi=$valordeb;
																
			  														//****creacion documento presupuesto ingresos
			  															
			  														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P04' AND vigencia=$vigusu";
																		//echo $sql;
																	$resul=mysql_query($sql,$linkbd);
																	$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
																	while($rowp = mysql_fetch_row($resul)){
																	if($rowp[0]!=$rowi[6] && $vi>0){
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P04')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	  }
																   }
																   if($numreg==0 ){
																	  
																		  if($vi>0 && $rowi[6]!="")
			   															{
																			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tip,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P04')";
																			//echo $sqlr;
																			mysql_query($sqlr,$linkbd); 
																			$sqlr="";
			 															
		  																}
																		 
																   }
																	//echo "ppt:$sqlr";
																	//************ FIN MODIFICACION PPTAL	
					 											}
															}
				  										}
					 								}
												break;  
											case 'P05': 
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 								$resc=mysql_query($sqlrc,$linkbd);	  
				 								// echo "<BR>".$sqlrc;
				 								while($rowc=mysql_fetch_row($resc))
				 								{
			  										$porce=$rowi[5];
													if($rowc[6]=='S')
			 	  									{	
														if($_POST[tipo]=='1'){
															$valorcred=($row[5]/$_POST[tcuotas]);
														}else{
															$valorcred=$row[6];
														}
														
														$valordeb=$valorcred;					
														if($rowc[3]=='N')
				    									{
				 	 										if($valorcred>0)
					  										{						
				 												
																// echo "<BR>".$sqlr;
							 									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
		 	 													$respto=mysql_query($sqlrpto,$linkbd);	  
			 													//echo "con: $sqlrpto <br>";	      
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																
			  													//****creacion documento presupuesto ingresos
			  														
			  													$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND  tipo NOT LIKE '%$tipopre%' AND concepto='P05' AND vigencia=$vigusu";
																		//echo $sql;
																	$resul=mysql_query($sql,$linkbd);
																	$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
																	while($rowp = mysql_fetch_row($resul)){
																	if($rowp[0]!=$rowi[6] && $vi>0){
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	  }
																   }
																   if($numreg==0 ){
																	  
																		  if($vi>0 && $rowi[6]!="")
			   															{
																			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
																			//echo $sqlr;
																			mysql_query($sqlr,$linkbd); 
																			$sqlr="";
			 															
		  																}
																		 
																   }
																//echo "ppt:$sqlr";
																//************ FIN MODIFICACION PPTAL	
					  										}
														}
				  									}
				 								}
												break;  
										 
										case 'P07': 
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 								$resc=mysql_query($sqlrc,$linkbd);	  
				 								// echo "<BR>".$sqlrc;
												while($rowc=mysql_fetch_row($resc))
				 								{
			  										$porce=$rowi[5];
													if($rowc[6]=='S')
			 	  									{		
														if($_POST[tipo]=='1'){
															$valorcred=($row[8]/$_POST[tcuotas]);	
														}else{
															$valorcred=$row[9];	
														}
														
														$valordeb=$valorcred;					
														if($rowc[3]=='N')
				    									{
				 											if($valorcred>0)
					  										{						
				 												
																// echo "<BR>".$sqlr;
							  									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 													$respto=mysql_query($sqlrpto,$linkbd);	  
			 													//echo "con: $sqlrpto <br>";	      
																$rowpto=mysql_fetch_row($respto);
																$vi=$valordeb;
																			
			  													//****creacion documento presupuesto ingresos
			 													
			  													$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='01' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P07' AND vigencia=$vigusu";
																		//echo $sql;
																	$resul=mysql_query($sql,$linkbd);
																	$numreg=mysql_num_rows($resul);
			 	 														//****creacion documento presupuesto ingresos
																	while($rowp = mysql_fetch_row($resul)){
																	if($rowp[0]!=$rowi[6] && $vi>0){
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P07')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd);	
																		$sqlr="";
																	  }
																   }
																   if($numreg==0 ){
																	  
																		  if($vi>0 && $rowi[6]!="")
			   															{
																			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P07')";
																			//echo $sqlr;
																			mysql_query($sqlr,$linkbd); 
																			$sqlr="";
			 															
		  																}
																		 
																   }
																//echo "ppt:$sqlr";
																//************ FIN MODIFICACION PPTAL	
					  										}
														}
				  									}
				 								}
											break;
											
											case 'P08': 
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 								$resc=mysql_query($sqlrc,$linkbd);	  
				 								// echo "<BR>".$sqlrc;
												while($rowc=mysql_fetch_row($resc))
				 								{
			  										$porce=$rowi[5];
													if($rowc[6]=='S')
													  {	
														$valorcred=0;
														if($_POST[tipo]=='1'){
															$valordeb=($row[7]/$_POST[tcuotas]);	
														}else{
															$valordeb=$row[8];	
														}			  
																			
													  }
													 if($rowc[6]=='N')
													  {				 
														$valordeb=0;
														if($_POST[tipo]=='1'){
															$valorcred=($row[7]/$_POST[tcuotas]);	
														}else{
															$valorcred=$row[8];	
														}					
													  }	
													  
														if($rowc[3]=='N')
														{
															
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);	        
															$rowpto=mysql_fetch_row($respto);			
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
															//****creacion documento presupuesto ingresos
															
																$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P08' AND vigencia=$vigusu";
																						//echo $sql;
																$resul=mysql_query($sql,$linkbd);
																$numreg=mysql_num_rows($resul);
																	//****creacion documento presupuesto ingresos
																while($rowp = mysql_fetch_row($resul)){
																if($rowp[0]!=$rowi[6] && $vi>0){
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','S','P08')";
																	//echo $sqlr;
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																  }
															   }
															   if($numreg==0 ){
																  
																	  if($vi>0 && $rowi[6]!="")
																	{
																		$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','S','P08')";
																		//echo $sqlr;
																		mysql_query($sqlr,$linkbd); 
																		$sqlr="";
																	
																	}
																	 
															   }
									
														}
				  									}
				 							
											break;
											
											
									} 
									//echo "<br>".$sqlr;
		 						}
								$_POST[dcoding][]=$row2[0];
								$_POST[dncoding][]=$row2[1]." ".$vig;
								if($_POST[tipo]=='1'){
									$_POST[dvalores][]=($row[10]/$_POST[tcuotas]);	
								}else{
									$_POST[dvalores][]=$row[11];	
								}
    								 
								//	echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
	 						}
		 					else  ///***********OTRAS VIGENCIAS ***********
	   	 					{	
						
								if($_POST[tipo]=='1'){
									$tasadesc=($row[9]/$_POST[tcuotas])/(($row[2]/$_POST[tcuotas])+($row[5]/$_POST[tcuotas]));
								}else{
									$tasadesc=$row[10]/($row[4]+$row[6]);	
								}
			 		 			
				
								$idcomp=$_POST[idcomp];
		 			
		  						$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
		  						mysql_query($sqlr,$linkbd);
								$sqlr2="select * from tesoingresos_DET where codigo='03' AND MODULO='4' and vigencia=$vigusu GROUP BY concepto";
								$res2=mysql_query($sqlr2,$linkbd);

				 				//****** $cuentacb   ES LA CUENTA CAJA O BANCO
								while($rowi =mysql_fetch_row($res2))
		 						{
									
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
												if($_POST[tipo]=='1'){
													$valorcred=($row[2]/$_POST[tcuotas]);
												}else{
													$valorcred=$row[4];
												}
												
												$valordeb=$valorcred;					
												if($rowc[3]=='N')
				    							{
				 	 								if($valorcred>0)
					  								{						
				 									
														// echo "<BR>".$sqlr;
							
						  							//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
													$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
												
			
			  										//****creacion documento presupuesto ingresos
			  											
			  										$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P03' AND vigencia=$vigusu";
																		//echo $sql;
													$resul=mysql_query($sql,$linkbd);
													$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
													while($rowp = mysql_fetch_row($resul)){
													if($rowp[0]!=$rowi[6] && $vi>0){
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P03')";
														//echo $sqlr;
														mysql_query($sqlr,$linkbd);	
														$sqlr="";
													  }
												   }
												   if($numreg==0 ){
													  
														  if($vi>0 && $rowi[6]!="")
														{
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P03')";
															//echo $sqlr;
															mysql_query($sqlr,$linkbd); 
															$sqlr="";
														
														}
														 
												   }
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
											if($_POST[tipo]=='1'){
												$valorcred=($row[7]/$_POST[tcuotas]);
											}else{
												$valorcred=$row[8];
											}
											
											$valordeb=$valorcred;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 								
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 										$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
												
													//****creacion documento presupuesto ingresos
														
													$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P06' AND vigencia=$vigusu";
																		//echo $sql;
													$resul=mysql_query($sql,$linkbd);
													$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
													while($rowp = mysql_fetch_row($resul)){
													if($rowp[0]!=$rowi[6] && $vi>0){
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P06')";
														//echo $sqlr;
														mysql_query($sqlr,$linkbd);	
														$sqlr="";
													  }
												   }
												   if($numreg==0 ){
													  
														  if($vi>0 && $rowi[6]!="")
														{
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P06')";
															//echo $sqlr;
															mysql_query($sqlr,$linkbd); 
															$sqlr="";
														
														}
														 
												   }
													//echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
					  							}
											}
				  						}
									}
									break; 
																	
								case '03': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{	
											if($_POST[tipo]=='1'){
												$valorcred=($row[5]/$_POST[tcuotas]);
											}else{
												$valorcred=$row[6];
											}
											
											$valordeb=$valorcred;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 								
													// echo "<BR>".$sqlr;
							 						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
		 	 										$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
											
			  										//****creacion documento presupuesto ingresos
														
			  										$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='03' AND vigencia=$vigusu";
																		//echo $sql;
													$resul=mysql_query($sql,$linkbd);
													$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
													while($rowp = mysql_fetch_row($resul)){
													if($rowp[0]!=$rowi[6] && $vi>0){
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','03')";
														//echo $sqlr;
														mysql_query($sqlr,$linkbd);	
														$sqlr="";
													  }
												   }
												   if($numreg==0 ){
													  
														  if($vi>0 && $rowi[6]!="")
														{
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','03')";
															//echo $sqlr;
															mysql_query($sqlr,$linkbd); 
															$sqlr="";
														
														}
														 
												   }
													//			echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
					  							}
											}
				 						}
				 					}
									break;  
								case 'P01': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{		
											if($_POST[tipo]=='1'){
												$valordeb=($row[9]/$_POST[tcuotas]);
											}else{
												$valordeb=$row[10];
											}
											
											$valorcred=0;					
											
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
											if($_POST[tipo]=='1'){
												$valorcred=($row[3]/$_POST[tcuotas]);
											}else{
												$valorcred=$row[5];
											}
											
											$valordeb=$valorcred;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					 							{
				 							
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia=$vigusu";
												 	$respto=mysql_query($sqlrpto,$linkbd);	  
													//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
												
													//****creacion documento presupuesto ingresos
													
													$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P02' AND vigencia=$vigusu";
																		//echo $sql;
													$resul=mysql_query($sql,$linkbd);
													$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
													while($rowp = mysql_fetch_row($resul)){
													if($rowp[0]!=$rowi[6] && $vi>0){
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P02')";
														//echo $sqlr;
														mysql_query($sqlr,$linkbd);	
														$sqlr="";
													  }
												   }
												   if($numreg==0 ){
													  
														  if($vi>0 && $rowi[6]!="")
														{
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P02')";
															//echo $sqlr;
															mysql_query($sqlr,$linkbd); 
															$sqlr="";
														
														}
														 
												   }
													//			echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
												}
				   							}
				  						}
				 					}
									break;  
								case 'P04': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{	
											if($_POST[tipo]=='1'){
												$valorcred=($row[6]/$_POST[tcuotas]);
											}else{
												$valorcred=$row[7];
											}
											
											$valordeb=$valorcred;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 								
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 										$respto=mysql_query($sqlrpto,$linkbd);	  
			 										//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
													
			  										//****creacion documento presupuesto ingresos
			  										
													$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P04' AND vigencia=$vigusu";
																		//echo $sql;
													$resul=mysql_query($sql,$linkbd);
													$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
													while($rowp = mysql_fetch_row($resul)){
													if($rowp[0]!=$rowi[6] && $vi>0){
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P04')";
														//echo $sqlr;
														mysql_query($sqlr,$linkbd);	
														$sqlr="";
													  }
												   }
												   if($numreg==0 ){
													  
														  if($vi>0 && $rowi[6]!="")
														{
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P04')";
															//echo $sqlr;
															mysql_query($sqlr,$linkbd); 
															$sqlr="";
														
														}
														 
												   }
													//echo "ppt:$sqlr";
													//************ FIN MODIFICACION PPTAL	
					  							}
											}
				  						}
				 					}
									break;  
									
								case 'P05': 
									$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
	 			 					$resc=mysql_query($sqlrc,$linkbd);	  
				 					// echo "<BR>".$sqlrc;
				 					while($rowc=mysql_fetch_row($resc))
				 					{
			  							$porce=$rowi[5];
										if($rowc[6]=='S')
			 	  						{		
											if($_POST[tipo]=='1'){
												$valorcred=($row[5]/$_POST[tcuotas]);
											}else{
												$valorcred=$row[6];
											}
											
											$valordeb=$valorcred;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{
				 								
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
			 										$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
													$respto=mysql_query($sqlrpto,$linkbd);	  
													//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
										
			  										//****creacion documento presupuesto ingresos
												  		
												  $sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P05' AND vigencia=$vigusu";
																		//echo $sql;
													$resul=mysql_query($sql,$linkbd);
													$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
													while($rowp = mysql_fetch_row($resul)){
													if($rowp[0]!=$rowi[6] && $vi>0){
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
														//echo $sqlr;
														mysql_query($sqlr,$linkbd);	
														$sqlr="";
													  }
												   }
												   if($numreg==0 ){
													  
														  if($vi>0 && $rowi[6]!="")
														{
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
															//echo $sqlr;
															mysql_query($sqlr,$linkbd); 
															$sqlr="";
														
														}
														 
												   }
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
											if($_POST[tipo]=='1'){
												$valorcred=($row[8]/$_POST[tcuotas]);
											}else{
												$valorcred=$row[9];
											}
											
											$valordeb=$valorcred;					
											if($rowc[3]=='N')
				    						{
				 	 							if($valorcred>0)
					  							{						
				 								
													// echo "<BR>".$sqlr;
							  						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
													$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
												 	$respto=mysql_query($sqlrpto,$linkbd);	  
													//echo "con: $sqlrpto <br>";	      
													$rowpto=mysql_fetch_row($respto);
													$vi=$valordeb;
						
			  										//****creacion documento presupuesto ingresos
			  											
			  										$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P07' AND vigencia=$vigusu";
																		//echo $sql;
													$resul=mysql_query($sql,$linkbd);
													$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
													while($rowp = mysql_fetch_row($resul)){
													if($rowp[0]!=$rowi[6] && $vi>0){
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P07')";
														//echo $sqlr;
														mysql_query($sqlr,$linkbd);	
														$sqlr="";
													  }
												   }
												   if($numreg==0 ){
													  
														  if($vi>0 && $rowi[6]!="")
														{
															$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P07')";
															//echo $sqlr;
															mysql_query($sqlr,$linkbd); 
															$sqlr="";
														
														}
														 
												   }
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
										if($_POST[tipo]=='1'){
											$valnu=($row[7]/$_POST[tcuotas]);
										}else{
											$valnu=$row[8];
										}
										if($rowc[6]=='S')
			 	  						{				 
											$valorcred=0;
											$valordeb=$valnu;				
				  						}
				 						if($rowc[6]=='N')
			 	  						{				 
											$valorcred=$valnu;
											$valordeb=0;					
				  						}
										if($rowc[3]=='N')
				    					{
				 										
										
							  				//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
											$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
		 	 								$respto=mysql_query($sqlrpto,$linkbd);	  
			 								//echo "con: $sqlrpto <br>";	      
											$rowpto=mysql_fetch_row($respto);			
											$vi=$valordeb;
									
			 								//****creacion documento presupuesto ingresos
			  								
			  								$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso='03' AND cod_ingreso IN (01,03) AND tipo NOT LIKE '%$tipopre%' AND concepto='P08' AND vigencia=$vigusu";
																		//echo $sql;
												$resul=mysql_query($sql,$linkbd);
												$numreg=mysql_num_rows($resul);
													//****creacion documento presupuesto ingresos
												while($rowp = mysql_fetch_row($resul)){
												if($rowp[0]!=$rowi[6] && $vi>0){
													$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P08')";
													//echo $sqlr;
													mysql_query($sqlr,$linkbd);	
													$sqlr="";
												  }
											   }
											   if($numreg==0 ){
												  
													  if($vi>0 && $rowi[6]!="")
													{
														$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P08')";
														//echo $sqlr;
														mysql_query($sqlr,$linkbd); 
														$sqlr="";
													
													}
													 
											   }
											//			echo "ppt:$sqlr";
											//************ FIN MODIFICACION PPTAL		
				   						}
				 					}
									break;  
									
							} 
							//echo "<br>".$sqlr;
		 				}
						//$_POST[dcoding][]=$row2[0];
						//$_POST[dncoding][]=$row2[1]." ".$vig;			 		
    					//$_POST[dvalores][]=$row[11];	

						//echo "Vig:$vig valor:$row[11] codigo:".$row2[0];
		 			}
				}
				//*******************  
				if($_POST[tipo]=='1'){
					$sqlr="Select *from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]";
		  		$resp=mysql_query($sqlr,$linkbd);
		 		while($row=mysql_fetch_row($resp,$linkbd))
		   		{
		    		$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[13]";
					mysql_query($sqlr2,$linkbd);
		   		}
				
				}else{
				$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
		  		$resp=mysql_query($sqlr,$linkbd);
		 		while($row=mysql_fetch_row($resp,$linkbd))
		   		{
		    		$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[1]";
					mysql_query($sqlr2,$linkbd);
		   		}
				
				}
	 			echo "<table class='inicio'><tr><td class='saludo1'><center>Se Reflejo de Manera Correcta el Recibo de Caja <img src='imagenes/confirm.png'></center></td></tr></table>"; 	  
   	 		} //fin de la verificacion
	 		else
	 		{
				echo"<script>despliegamodalm('visible','2','Ya Existe un Recibo de Caja para esta Liquidacion Predial');</script>";
			 }//***FIN DE LA VERIFICACION
			 
	   		break;
	   case 2:  //********** INDUSTRIA Y COMERCIO
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

		$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
		//echo $sqlr;		
         
	if (!mysql_query($sqlr,$linkbd))
		{
	 	echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	 	echo "Ocurrió el siguiente problema:<br>";
  	 	echo "<pre>";
     	echo "</pre></center></td></tr></table>";
		}
  		else
  		 {
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
		 $concecc=$_POST[idcomp]; 
		 //*************COMPROBANTE CONTABLE INDUSTRIA
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

		 //******parte para el recaudo del cobro por recibo de caja
		 
		 for($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		 if($_POST[dcoding][$x]==$_POST[cobrorecibo])
		 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
	 	$resi=mysql_query($sqlri,$linkbd);
		while($rowi=mysql_fetch_row($resi))
		 {
	    //**** busqueda cuenta presupuestal*****
			//busqueda concepto contable
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C'";
	 	 $resc=mysql_query($sqlrc,$linkbd);	  
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
				$rowpto=mysql_fetch_row($respto);
			$vi=$_POST[dvalores][$x]*($porce/100);
	
			
			  //****creacion documento presupuesto ingresos
			  $sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo) values('$rowi[6]',$concecc,$vi,'".$vigusu."','N')";
  			  mysql_query($sqlr,$linkbd);	
			//************ FIN MODIFICACION PPTAL
			
		
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
		$sqlr="Select * from tesoindustria_det where id_industria='$_POST[idrecaudo]'";
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
		$industria=$industria+$antivigact-$antivigant-$retenciones;
		$descuenindus=$industria*($row[13]/100);
		$descuenaviso=$avisos*($row[13]/100);	
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
	 	$res=mysql_query($sqlri,$linkbd);
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
						 			$valorcred=$industria+$sanciones+$intereses-$retenciones-$antivigant-$descuenindus;
						 		
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
											
											}
										}
					  				}
					  				//**fin rete ica
						 			$valordeb=$industria+$sanciones+$intereses-$retenciones-$antivigant-$descuenindus;
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
						 			else {$cuentacbr=$cuentacb;}
								
								
						 			$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$row[6]','$concecc','$industria', '$vigusu','N','04')";
  						  			mysql_query($sqlr,$linkbd);	
						 		}
							}
					  	}
			  		}
					if($row[2]=='05')//************avisos
			  		{
						if($avisos>0)
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
										$valorcred=$avisos-$descuenaviso;					
									
										//********** CAJA O BANCO
										$valordeb=$avisos-$descuenaviso;
										$valorcred=0;
										
							
										$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$row[6]',$concecc,$avisos, '$vigusu','N','05')";
										mysql_query($sqlr,$linkbd);	
									}
								}						
							}
						}
			  		}		 
					if($row[2]=='06') //*********bomberil ********
			  		{
						if($bomberil>0)
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
										 
										//********** CAJA O BANCO
										$valordeb=$bomberil;
										$valorcred=0;
									
										//***MODIFICAR PRESUPUESTO
							
										$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$row[6]','$concecc','$bomberil', '$vigusu','N','06')";
										mysql_query($sqlr,$linkbd);	
									}
								}
							}
						}
					}
		    	}
		  	
			
			}
		}
		echo "<table class='inicio'><tr><td class='saludo1'><center>Se Reflejo de Manera Correcta el Recibo de Caja <img src='imagenes/confirm.png'></center></td></tr></table>"; 
		 
   }
  
	 else
	 {
	  echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
	 }
	 
		 
		break;
		
	  case 3: //**************OTROS RECAUDOS
	
	$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
	mysql_query($sqlr,$linkbd);
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];


	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	{
		//***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$vigusu'";
		$resi=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
		while($rowi=mysql_fetch_row($resi))
		{
			//**** busqueda cuenta presupuestal*****
			//busqueda concepto contable
			$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C'";
			$resc=mysql_query($sqlrc,$linkbd);	  
			// 		echo "concc: $sqlrc - $_POST[cobrorecibo]<br>";	      
			while($rowc=mysql_fetch_row($resc))
			{
				$porce=$rowi[5];
				if($_POST[dcoding][$x]==$_POST[cobrorecibo])
				{
						  
					if($rowc[7]=='S'){$columna= $rowc[7];}
					else{$columna= 'N';}
					$cuentacont=$rowc[4];
				}
				else
				{
					$columna= $rowc[6];	
					$cuentacont=$rowc[4];			 
				}
				if($columna=='S')
				{				 
					$valorcred=$_POST[dvalores][$x]*($porce/100);
					$valordeb=0;
							  
					if($rowc[3]=='N')
					{
						//*****inserta del concepto contable  
						//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
						$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
						$respto=mysql_query($sqlrpto,$linkbd);	  
						//echo "con: $sqlrpto <br>";	      
						$rowpto=mysql_fetch_row($respto);
						$vi=$_POST[dvalores][$x]*($porce/100);
		
						//****creacion documento presupuesto ingresos
						$sql="SELECT terceros FROM tesoingresos WHERE codigo=".$_POST[dcoding][$x] ;
						$res=mysql_query($sql,$linkbd);
						$row= mysql_fetch_row($res);
						if($row[0]!="R"){
							$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]','$concecc','$vi','".$vigusu."','N','".$_POST[dcoding][$x]."')";
							mysql_query($sqlr,$linkbd);	
						}else{
							$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]','$concecc','$vi','".$vigusu."','R','".$_POST[dcoding][$x]."')";
							mysql_query($sqlr,$linkbd);	
						}					
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
	
							
					}
				}
			}
		}
	}	
	echo "<table class='inicio'><tr><td class='saludo1'><center>Se Reflejo de Manera Correcta el Recibo de Caja <img src='imagenes/confirm.png'></center></td></tr></table>"; 
	   break;
	   
	   //********************* INDUSTRIA Y COMERCIO
	  } //*****fin del switch		
	}//***bloqueo
		else
	   {
    	echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
	   }

   }//**fin del oculto 
   
?>	
</form><?php if($_POST[oculto]==""){echo"<script>validar2();</script>";}
?>
 </td></tr>
</table>
</body>
</html>