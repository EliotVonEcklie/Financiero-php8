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
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID- Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
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
					document.form2.action="teso-recibocajaver.php";
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
					document.form2.action="teso-recibocajaver.php";
					document.form2.submit();
 				}
			}
			function validar2()
			{
				//alert("Balance Descuadrado");
				document.form2.oculto.value=1;
				//document.form2.idcomp.value=document.form2.idcomp.value;
				//document.form2.ncomp.value=document.form2.idcomp.value;
				//document.form2.agregadet.value='';
				//document.form2.elimina.value='';
				//document.form2.action="teso-recibocajaver.php";
				document.form2.submit();
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('ncomp').value;
				location.href="teso-buscarecibocaja.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
			$scrtop=34*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta"> 
				<a  onClick="location.href='teso-recibocaja.php'"  class="mgbt"><img src="imagenes/add.png" title="Nuevo"/> 
				</a><a class="mgbt1"><img src="imagenes/guardad.png"/></a> 
				<a onClick="location.href='teso-buscarecibocaja.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a> 
				<a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir" style="width:29px;height:25px;"/></a> 
				<a class="mgbt" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>		  
		</table>
		<?php
			$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			$sqlr="select *from cuentacaja where estado='S' and vigencia=".$_SESSION["vigencia"];
			//	echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[1];}
	  		//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
			if(!$_POST[oculto])
			{
				$sqlr="select max(id_recibos) from  tesoreciboscaja ORDER BY id_recibos DESC";
				$res=mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				$r=mysql_fetch_row($res);
	 			$_POST[maximo]=$r[0];
	 			$_POST[ncomp]=$_GET[idrecibo];
				$_POST[idcomp]=$_GET[idrecibo];
			}
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
				$sqlr="select descripcion from tesoreciboscaja where id_recibos=$_POST[idcomp]";
 				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{$_POST[concepto]=$row[0];}
			}
 			$sqlr="select * from tesoreciboscaja where id_recibos=$_POST[idcomp]";
 			$res=mysql_query($sqlr,$linkbd); //echo $sqlr;
			while($r=mysql_fetch_row($res)) {$_POST[tiporec]=$r[10]; }
			switch($_POST[tiporec]) 
  	 		{
	  			case 1:
	  				$sqlr="select *from tesoliquidapredial, tesoreciboscaja where tesoliquidapredial.idpredial=tesoreciboscaja.id_recaudo and tesoreciboscaja.estado !=''  and tesoreciboscaja.id_recibos=".$_POST[idcomp];
  	 				$_POST[encontro]="";
	  				$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
	 				{
						$_POST[codcatastral]=$row[1];
						//$_POST[idcomp]=$row[19];	
						$_POST[idrecaudo]=$row[23];	
						$_POST[fecha]=$row[21];
						$_POST[vigencia]=$row[3];	
						if($_POST[concepto]==""){
							$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];
					}	
						$_POST[valorecaudo]=$row[8];		
						$_POST[totalc]=$row[8];	
						$_POST[tercero]=$row[4];		
						$_POST[modorec]=$row[24];
						$_POST[banco]=$row[25];
						if($row[28]=='S') {$_POST[estadoc]='ACTIVO';} 	 				  
		 				if($row[28]=='N'){$_POST[estadoc]='ANULADO';} 			
	  					$_POST[ntercero]=buscatercero($row[4]);	
						if ($_POST[ntercero]=='')
		 				{
		  					$sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
		  					$resc=mysql_query($sqlr2,$linkbd);
		  					$rowc =mysql_fetch_row($resc);
		   					$_POST[ntercero]=$rowc[6];
		 				}			
	  					$_POST[encontro]=1;
					}
	  				$sqlr="select *from tesoreciboscaja where tipo='1' and id_recaudo=$_POST[idrecaudo] ";
					$res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res); 
					//$_POST[idcomp]=$row[0];
					$_POST[fecha]=$row[2];
					$_POST[estadoc]=$row[9];
		   			if ($_POST[estadoc]=='N') {$_POST[estado]="ANULADO";}
		   			else {$_POST[estado]="ACTIVO";}
					$_POST[modorec]=$row[5];
					$_POST[banco]=$row[7];
       				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   				$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	  				break;
	  			case 2:
	  				$sqlr="select *from tesoindustria,tesoreciboscaja where tesoreciboscaja.id_recibos=$_POST[idcomp] and tesoreciboscaja.id_recaudo=tesoindustria.id_industria";
  					//echo "$sqlr";
  	 				$_POST[encontro]="";
	  				$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
	 				{
						//$_POST[idcomp]=$row[8];				
						$_POST[fecha]=$row[12];
		 				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   					$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
						$_POST[idrecaudo]=$row[0];	
						$_POST[vigencia]=$row[2];
						$_POST[tiporec]=$row[20];	
						if($_POST[concepto]==""){$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];}
						$_POST[valorecaudo]=$row[18];		
						$_POST[totalc]=$row[18];	
						$_POST[tercero]=$row[5];	
						$_POST[ntercero]=buscatercero($row[5]);	
						$_POST[modorec]=$row[15];
						$_POST[banco]=$row[16];
						$_POST[encontro]=1;
						$_POST[estadoc]=$row[19];
		   				if ($_POST[estadoc]=='N'){$_POST[estado]="ANULADO";}
		  				else {$_POST[estado]="ACTIVO";}
	 				}
	  				break;
	  			case 3:
	 				$sqlr="select *from tesoreciboscaja,tesorecaudos where tesorecaudos.id_recaudo=tesoreciboscaja.id_recaudo and tesoreciboscaja.id_recibos='$_POST[idcomp]'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						//$_POST[idcomp]=$row[0];	
						$_POST[idrecaudo]=$row[11];	
						$_POST[fecha]=$row[2];
						$_POST[vigencia]=$row[3];		
						if($_POST[concepto]==""){$_POST[concepto]=$row[17];}
						$_POST[tiporec]=$row[10];	
						$_POST[modorec]=$row[5];		
						$_POST[banco]=$row[7];
						$_POST[cb]=$row[6];
						$_POST[estadoc]=$row[9];
		   				if ($_POST[estadoc]=='N'){$_POST[estado]="ANULADO";}
		   				else {$_POST[estado]="ACTIVO";} 		
						$_POST[valorecaudo]=$row[8];				
						$_POST[tercero]=$row[15];				
						$_POST[ntercero]=buscatercero($_POST[tercero]);						
					}
					break;	
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
					{$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja ORDER BY id_recibos DESC";}
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
	  							if($_POST[concepto]==""){$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];}	
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
	  							if($_POST[concepto]==""){$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];}	
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
	  							if($_POST[concepto]==""){$_POST[concepto]=$row[6];}
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
                    <td class="titulos" colspan="7">Reflejar Recibo de Caja</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
        			<td class="saludo1" style="width:2cm;">No Recibo:</td>
        			<td style="width:20%;"> 
                    	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="anterior" align="absmiddle"/></a> 
                        <input type="hidden" name="cuentacaja" value="<?php echo $_POST[cuentacaja]?>" />
                        <input type="text" name="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  style="width:40%;" />
                        <input type="hidden" name="ncomp" id="ncomp"  value="<?php echo $_POST[ncomp]?>"/>
                        <a href="#" onClick="adelante()"><img src="imagenes/next.png" title="siguiente" align="absmiddle"/></a> 
                        <input type="hidden" value="a" name="atras"/>
                        <input type="hidden" value="s" name="siguiente"/>
                        <input type="hidden" name="maximo" value="<?php echo $_POST[maximo]?>" />
               		</td>
	 				<td class="saludo1" style="width:2.3cm;">Fecha:</td>
        			<td style="width:15%;"><input type="text" name="fecha"  value="<?php echo $_POST[fecha]?>"  onKeyUp="return tabular(event,this)" style="width:45%;" readonly/>
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
        			<td class="saludo1">No Liquid:</td>
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
								<select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%'>";
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
				?> 
	  			<tr>
                	<td class="saludo1">Concepto:</td>
                    <td colspan="<?php if($_POST[tiporec]==2){echo '3';}else{echo'5';}?>"><input name="concepto" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
              	</tr>
                <tr>
                	<td  class="saludo1">Documento: </td>
        			<td ><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
			  		<td class="saludo1">Contribuyente:</td>
	  				<td colspan="3">
                    	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this) " style="width:100%;" readonly>
                        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  				</td>
                </tr>
      			<tr>
                	<td class="saludo1" >Valor:</td>
                    <td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly/></td>
                    <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>"> 
            	</tr>
                <?php if ($_POST[modorec]!='banco'){echo"<tr style='height:20;'><tr>";}?>
      		</table>
      		<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    	<input type="hidden" value="0" name="agregadet">
     		<div class="subpantalla" s style="height:49.3%; width:99.6%; overflow-x:hidden;">
      			<?php	 
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
						if($_POST[oculto]>=0 && $_POST[encontro]=='1')
						{
							$_POST[totalc]=0;
							$iter='saludo1a';
							$iter2='saludo2';
							$sqlrg="SELECT ingreso,valor FROM tesoreciboscaja_det WHERE id_recibos='$_POST[idcomp]'";
							$resg=mysql_query($sqlrg,$linkbd);
							/*for ($x=0;$x<count($_POST[dcoding]);$x++)
									{		 
									 	echo "<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='hidden' style='width:100%;' readonly>
									 	<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='hidden' style='width:100%;' readonly>
									 	<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden' style='width:100%;' readonly>";
									 			
									}*/
							while ($rowg =mysql_fetch_row($resg)) 
							{
								$sqlr2="SELECT nombre FROM tesoingresos WHERE codigo='$rowg[0]'";
	  							$res2=mysql_query($sqlr2,$linkbd);
								$row2 =mysql_fetch_row($res2);
								
								if($rowg[0]=="01" || $rowg[0]=="03")
								{
									$sqlrv="SELECT vigliquidada FROM tesoliquidapredial_det WHERE idpredial='$_POST[idrecaudo]' AND totaliquidavig='$rowg[1]'";
									$resv=mysql_query($sqlrv,$linkbd);
									$rowv =mysql_fetch_row($resv);
									$descrip=$row2[0]." ".$rowv[0];
								}
								else {$descrip=$row2[0];}
								echo"
									<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
										<td style='width:10%;'><input name='dcoding[]' value='$rowg[0]' type='text' style='width:100%;' readonly></td>
										<td><input name='dncoding[]' value='$descrip' type='text' style='width:100%;' readonly></td>
										<td style='width:20%;text-align:right;'><input name='dvalores[]' value='$rowg[1]' type='text' style='width:100%;' readonly></td></tr>";
								$_POST[totalc]=$_POST[totalc]+$rowg[1];
								$_POST[totalcf]=number_format($_POST[totalc],2);
								$totalg=number_format($_POST[totalc],2,'.','');
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}	
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
		</form>
	</body>
</html>