<?php //V 1001 22/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private");
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID- Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function validar(){document.form2.submit();}
			function pdf()
			{
				document.form2.action="teso-pdfrecaja01.php";
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
					location.href="teso-recibocajaver.php?idrecibo="+document.form2.idcomp.value;
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
					location.href="teso-recibocajaver.php?idrecibo="+document.form2.idcomp.value;
 				}
			}
			function validar2(){location.href="teso-recibocajaver.php?idrecibo="+document.form2.idcomp.value;}
			function iratras()
			{
				var id=<?php echo $_GET[idrecibo] ?>;
				location.href="teso-buscarecibocaja.php?idcta="+id;
			}
			function crearexcel()
			{
				document.form2.action="teso-buscarecibocajaexcel1.php";
				document.form2.target="_BLANK";
				document.form2.submit();
			}
			function despliegamodal2(_valor,v)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					if(v==1)
					{
						document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
					}
					else
					{
						var url="notaspararevelacioneditar.php?nota="+document.form2.notaf.value+"&modulo=teso&doc="+document.form2.idcomp.value+"&tdoc=5&valor="+document.form2.valorecaudo.value+"";
						document.getElementById('ventana2').src=url;
					}
					
				}
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-recibocaja.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscarecibocaja.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt" style="width:29px;height:25px;"/><img src="imagenes/iratras.png" title="Atr&aacute;s" class="mgbt" onClick="iratras()"/><img src="imagenes/excel.png" onClick="crearexcel()" class="mgbt" style="width:29px;height:25px;" title="csv"></td>
			</tr>		  
		</table>
		<?php
			$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			$sqlr="select *from cuentacaja where estado='S' and vigencia=".$_SESSION["vigencia"];
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[1];}
	  		//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
			if(!$_POST[oculto])
			{
				$sqlr="select max(id_recibos) from  tesoreciboscaja ORDER BY id_recibos DESC";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
	 			$_POST[ncomp]=$_GET[idrecibo];
				$_POST[idcomp]=$_GET[idrecibo];
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
			switch($_POST[tabgroup1])
			{
				case 1:	$check1='checked';break;
				case 2:	$check2='checked';break;
				case 3:	$check3='checked';
			}
 			$sqlr="select * from tesoreciboscaja where id_recibos=$_POST[idcomp]";
 			$res=mysql_query($sqlr,$linkbd); 
			while($r=mysql_fetch_row($res)) {$_POST[tiporec]=$r[10]; }
			switch($_POST[tiporec]) 
  	 		{
	  			case 1: //Predial
				{
					$sql="SELECT FIND_IN_SET($_POST[idcomp],recibo),idacuerdo FROM tesoacuerdopredial ";
					$result=mysql_query($sql,$linkbd);
					$val=0;
					$compro=0;
					while($fila = mysql_fetch_row($result))
					{
						if($fila[0]!=0)
						{
							$val=$fila[0];
							$compro=$fila[1];
							break;
						}
					}
					if($val>0)
					{
						$_POST[tipo]="1";
						$_POST[idrecaudo]=$compro;	
						$sqlr="select vigencia from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]  ";
						$res=mysql_query($sqlr,$linkbd);
						$vigencias="";
						while($row = mysql_fetch_row($res)){$vigencias.=($row[0]."-");}
						$vigencias=utf8_decode("Años liquidados: ".substr($vigencias,0,-1));
						$sql="select * from tesoacuerdopredial where idacuerdo=$_POST[idrecaudo] and estado<>'N' ";
						$result=mysql_query($sql,$linkbd);
						$_POST[encontro]="";
						while($row = mysql_fetch_row($result))
						{
							$_POST[cuotas]=$row[10]+1;
							$_POST[tcuotas]=$row[4];
							$_POST[codcatastral]=$row[1];	
							if($_POST[concepto]==""){$_POST[concepto]=$vigencias.' Cod Catastral No '.$row[1];}	
							$_POST[valorecaudo]=$row[7];		
							$_POST[totalc]=$row[7];	
							$_POST[tercero]=$row[13];	
							$_POST[fecha]=$row[5];
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
					}
					else
					{
						$_POST[tipo]="2";
						$sqlr="select *from tesoliquidapredial, tesoreciboscaja where tesoliquidapredial.idpredial=tesoreciboscaja.id_recaudo and tesoreciboscaja.estado !=''  and tesoreciboscaja.id_recibos='$_POST[idcomp]'";
						$_POST[encontro]="";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							$_POST[codcatastral]=$row[1];
							$_POST[idrecaudo]=$row[25];	
							$_POST[fecha]=$row[18];
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
					$sqlr="select *from tesoreciboscaja where tipo='1' and id_recaudo=$_POST[idrecaudo] AND id_recibos='$_POST[idcomp]' ";
					$res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res); 
					$_POST[estadoc]=$row[9];
					$_POST[fecha]=$row[2];
		   			if ($_POST[estadoc]=='N') {$_POST[estado]="ANULADO";}
		   			else {$_POST[estado]="ACTIVO";}
					$_POST[modorec]=$row[5];
					$_POST[banco]=$row[7];
	  				
				}break;
	  			case 2: //Industria y Comercio
				{
	  				$sqlr="select *from tesoindustria,tesoreciboscaja where tesoreciboscaja.id_recibos=$_POST[idcomp] and tesoreciboscaja.id_recaudo=tesoindustria.id_industria";
	  				$_POST[encontro]="";
	  				$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
	 				{
		 				preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$row[18],$fecha);
	   					//$_POST[fecha]="$fecha[3]-$fecha[2]-$fecha[1]";
						$_POST[fecha]=$row[18];
						$_POST[idrecaudo]=$row[0];
						$_POST[vigencia]=$row[2];
						$_POST[tiporec]=$row[26];
						$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - $row[3]";
						$_POST[valorecaudo]=$row[24];
						$_POST[totalc]=$row[24];
						$_POST[tercero]=$row[5];
						$_POST[ntercero]=buscatercero($row[5]);
						$_POST[modorec]=$row[21];
						$_POST[banco]=$row[23];
						$_POST[encontro]=1;
						$_POST[estadoc]=$row[25];
						if ($_POST[estadoc]=='N'){$_POST[estado]="ANULADO";}
						else {$_POST[estado]="ACTIVO";}
						$_POST[tcuotas]=$row[8];
					}
				}break;
				case 3: //Otros Recaudos
				{
	 				$sqlr="select *from tesoreciboscaja,tesorecaudos where tesorecaudos.id_recaudo=tesoreciboscaja.id_recaudo and tesoreciboscaja.id_recibos='$_POST[idcomp]'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[idrecaudo]=$row[11];	
						$_POST[fecha]=$row[2];
						$_POST[vigencia]=$row[3];		
						$_POST[concepto]=$row[11];	
						$_POST[tiporec]=$row[10];	
						$_POST[modorec]=$row[5];		
						$_POST[banco]=$row[7];
						$_POST[cb]=$row[6];
						$_POST[estadoc]=$row[9];
		   				if ($_POST[estadoc]=='N'){$_POST[estado]="ANULADO";}
		   				else {$_POST[estado]="ACTIVO";} 		
						$_POST[valorecaudo]=$row[8];				
						$_POST[tercero]=$row[17];				
						$_POST[ntercero]=buscatercero($_POST[tercero]);	
						$_POST[encontro]=1;						
					}
					
				}break;	
			}
		?>
 		<form name="form2" method="post" action=""> 
  			<input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
            <input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
            <input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
            <input type="hidden" name="encontro" value="<?php echo $_POST[encontro]?>" >
            <input type="hidden" name="codcatastral" value="<?php echo $_POST[codcatastral]?>" >
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
					{$sqlr="select id_recibos,id_recaudo from tesoreciboscaja ORDER BY id_recibos DESC";}
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
	 				//$_POST[maximo]=$r[0];
				 	$_POST[ncomp]=$r[0];
	 				$_POST[idcomp]=$r[0];
	 				$_POST[idrecaudo]=$r[1];
	 				$_POST[oculto]=0;
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
  			<input type="hidden" name="codcatastral"  value="<?php echo $_POST[codcatastral]?>" >

    		<div class="tabsic" style="height:36%; width:99.6%;">
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	  				<label for="tab-1">Recibo Caja</label>
					<div class="content" style="overflow-x:hidden;">
						<table class="inicio" style="width:99.7%;">
							<tr>
								<td class="titulos" colspan="9">Recibo de Caja</td>
                                <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class="saludo1" style="width:2cm;">No Recibo:</td>
								<td style="width:20%;" colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>"><img src="imagenes/back.png" title="anterior" onClick="atrasc()" class="icobut"/>&nbsp;<input type="text" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) " onBlur="validar2()"  style="width:50%;" /><img src="imagenes/next.png" title="siguiente" class="icobut" onClick="adelante()"/></td>
								<input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>" />
								<input type="hidden" name="ncomp"  value="<?php echo $_POST[ncomp]?>"/>
								<input type="hidden" value="a" name="atras"/>
								<input type="hidden" value="s" name="siguiente"/>
								<input type="hidden" name="maximo" value="<?php echo $_POST[maximo]?>" />
								<td class="saludo1" style="width:2.3cm;">Fecha:</td>
								<td style="width:18%;">
									<input type="text" name="fecha"  value="<?php echo $_POST[fecha]?>"  onKeyUp="return tabular(event,this)" style="width:45%;" readonly />
									<?php 
										if($_POST[estado]=='ACTIVO')
										{
											echo "<input name='estado' type='text' value='ACTIVO' size='5' style='width:52%; background-color:#0CD02A; color:white; text-align:center;' readonly >";
										}
										else
										{
											echo "<input name='estado' type='text' value='ANULADO' size='5' style='width:40%; background-color:#FF0000; color:white; text-align:center;' readonly >";
										}
									?>
								</td>
								<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
								<td style="width:12%;"><input type="text" id="vigencia" name="vigencia" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" readonly></td>
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
							if($_POST[tiporec]=='1')
							{
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
                    <?php
	  					if($_POST[tiporec]==2 || $_POST[tiporec]==1)
	   					{
							echo" 
      						<td class='saludo1'>No Cuota:</td>
							<td><input type='text' name='cuotas' size='1' value='$_POST[cuotas]' readonly>/<input type='text' id='tcuotas' name='tcuotas' value='$_POST[tcuotas]' size='1' readonly ></td>";
	   					}
	  				?>
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
			
			</div>
			</div>
			<div class="tab">
       			<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       			<label for="tab-2">Afectacion Presupuestal</label>
       				<div class="content" style="overflow-x:hidden;"> 
         				<table class="inicio" style="overflow:scroll">
         					<tr><td class="titulos" colspan="4">Detalle Comprobantes</td></tr>
        					<tr>
                            	<td class="titulos2" style="width:15%">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2" style="width:15%">Valor</td>
                                <td class="titulos2" style="width:30%"></td>
                         	</tr>
                            <input type="hidden" id="totaldes" name="totaldes" value="<?php echo $_POST[totaldes]?>" readonly>
							
      						<?php
							
								if ($_POST[oculto]=='0')
		 						{
									$totaldes=0;
									$_POST[dcuenta]=array();
									$_POST[ncuenta]=array();
									$_POST[rvalor]=array();
									$sqlr="select *from pptorecibocajappto where idrecibo=$_POST[idcomp] and vigencia=$vigusu and cuenta!=''";
									//echo $sqlr;
									$resd=mysql_query($sqlr,$linkbd);
									
									$iter='saludo1a';
									$iter2='saludo2';
									$cr=0;
									$iter='saludo1a';
									$iter2='saludo2';
									while($rowd=mysql_fetch_row($resd))
									{
								    	$nresult=buscacuentapres($rowd[1],$rowd[4]);
										echo "
										<input type='hidden' name='dcuenta[]' value='$rowd[1]'/>
										<input type='hidden' name='ncuenta[]' value='$nresult'/>
										<input type='hidden' name='rvalor[]' value='".number_format($rowd[3],2)."'/>
										<tr class=$iter>
											<td class='icoop'>$rowd[1]</td>
											<td class='icoop'>$nresult</td>
											<td class='icoop' style='text-align:right;'>".number_format($rowd[3],2)."</td>
											<td></td>
										</tr>";
										$var1=$rowd[3];
										$var1=$var1;
										$cuentavar1=$cuentavar1+$var1;
										$_POST[varto]=number_format($cuentavar1,2,".",",");
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									 }
									echo "
										<input type='hidden' name='varto' id='varto' value='$_POST[varto]'/>
										<tr >
											<td ></td>
											<td style='text-align:left;'>Total:</td>
											<td class='icoop' style='text-align:right;'>$_POST[varto]</td>
										 </tr>";
								}
							?>
							<input type='hidden' name='contrete' value="<?php echo $_POST[contrete] ?>" />
        				</table>
						
	   				</div>
  			 	</div> 
			
      		</div>
      		<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    	<input type="hidden" value="0" name="agregadet">
     		<div class="subpantalla" style="height:38.0%; width:99.5%; overflow-x:hidden;">
      			<?php	 
 					if($_POST[oculto]>=0 && $_POST[encontro]=='1')
 					{
  						switch($_POST[tiporec]) 
  	 					{
	  						case 1: //********PREDIAL
							{
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
 	 							if($_POST[tipo]=='1')
								{
									$sqlr="select * from tesoacuerdopredial_det where idacuerdo='$_POST[idrecaudo]'";
									$res = view($sqlr);
									//OBTENER VALOR DE LA COUTA
									$sql = "select valor from tesoreciboscaja_det where id_recibos=$_POST[idcomp]";
									$cuot = view($sql);
									//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
									foreach ($res as $key => $row) 
									{
										$vig = $row[vigencia];
										if($vig==$vigusu)
										{
											$sqlr2 = "select * from tesoingresos where codigo='01'";
											$row2 = view($sqlr2);
											$_POST[dcoding][]=$row2[0][codigo];
											$_POST[dncoding][]=$row2[0][nombre]." ".$vig;
											$_POST[dvalores][]=$cuot[$key][valor];
										}
										else
										{
											$sqlr2="select * from tesoingresos where codigo='03'";
											$row2 = view($sqlr2); 
											$_POST[dcoding][]=$row2[0][codigo];
											$_POST[dncoding][]=$row2[0][nombre]." ".$vig;
											$_POST[dvalores][]=$cuot[$key][valor];	
										}
									}
									$res=mysql_query($sqlr,$linkbd);
								}
								else
								{
									$sqlr="select * from tesoliquidapredial_det where idpredial='$_POST[idrecaudo]' and estado ='S'  and 1=$_POST[tiporec]"; 
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
							   
							}break;
	  						case 2:	//***********INDUSTRIA Y COMERCIO
							{
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
									$_POST[dvalores][]=$row[6]/$_POST[tcuotas];
								}
							}break;
	  						case 3:	//*****************otros recaudos *******************
	  			 			{	
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
							}break;
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
						$namearch="archivos/".$_SESSION[usuario]."-reporterecibos.csv";
						$Descriptor1 = fopen($namearch,"w+"); 
						fputs($Descriptor1,"CODIGO;VALOR\r\n");
		 				for ($x=0;$x<count($_POST[dcoding]);$x++)
		 				{		 
		 					echo "
							<input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'>
							<input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."' style='width:100%;'>
							<tr class='$iter'>
								<td class='icoop' style='width:10%;'>".$_POST[dcoding][$x]."</td>
								<td class='icoop'>".$_POST[dncoding][$x]."</td>
								<td class='icoop' style='width:20%;text-align:right;'>$ ".number_format($_POST[dvalores][$x],2,',','.')."</td>				
							</tr>";
							$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
							$_POST[totalcf]=number_format($_POST[totalc],2);
							$totalg=number_format($_POST[totalc],2,'.','');
							$aux=$iter;
	 						$iter=$iter2;
	 						$iter2=$aux;
							
		 				}
						if ($_POST[totalc]!='' && $_POST[totalc]!=0){$_POST[letras] = convertirdecimal($totalg,'.');}
						else{$_POST[letras]=''; $_POST[totalcf]=0;}
		 				echo "
						<input type='hidden' name='totalcf' value='$_POST[totalcf]'>
						<input name='totalc' type='hidden' value='$_POST[totalc]'>
						<input type='hidden' name='letras' value='$_POST[letras]'>
						<tr class='$iter' >
							<td style='text-align:right;' colspan='2'>Total:</td>
							<td style='text-align:right;'>$ ".number_format($_POST[totalc],2,',','.')."</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='5'>$_POST[letras]</td>
						</tr>";
					?>  
	   			</table>
			</div>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>