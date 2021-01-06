<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start(); //hola
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Presupuesto</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
<script>
	function verep(idfac)
	{
		document.form1.oculto.value=idfac;
		document.form1.submit();
	}
	function genrep(idfac)
	{
		document.form2.oculto.value=idfac;
		document.form2.submit();
	}
	function buscacta(e)
	{
		if (document.form2.cuenta.value!="")
		{
			document.form2.bc.value='1';
			document.form2.submit();
		}
	}
	function validar()
	{
		document.form2.submit();
	}
	function buscater(e)
	{
		if (document.form2.tercero.value!="")
		{
			document.form2.bt.value='1';
			document.form2.submit();
		}
	}
	function agregardetalle()
	{
		if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!="")
		{ 
			document.form2.agregadet.value=1;
			document.form2.submit();
		}
		else 
		{
			alert("Falta informacion para poder Agregar");
		}
	}
	function eliminar(variable)
	{
		if (confirm("Esta Seguro de Eliminar"))
		{
			document.form2.elimina.value=variable;
			vvend=document.getElementById('elimina');
			vvend.value=variable;
			document.form2.submit();
		}
	}
	function guardar()
	{
		if (document.form2.fecha.value!='')
		{
			if(confirm("Esta Seguro de Guardar"))
			{
				document.form2.oculto.value=2;
				document.form2.submit();
			}
		}
  		else{
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
			document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
			document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
			document.form2.action="presu-recibocaja-reflejarppto.php";
			document.form2.submit();
		}
	}
	function atrasc()
	{
		if(document.form2.ncomp.value>1)
		{
			document.form2.oculto.value=1;
			document.form2.ncomp.value=document.form2.ncomp.value-1;
			document.form2.idcomp.value=document.form2.idcomp.value-1;
			document.form2.action="presu-recibocaja-reflejarppto.php";
			document.form2.submit();
 		}
	}
	function validar2()
	{
		document.form2.oculto.value=1;
		document.form2.ncomp.value=document.form2.idcomp.value;
		document.form2.action="presu-recibocaja-reflejarppto.php";
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
			<a class="mgbt" href="#" ><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a> 
			<a class="mgbt" href="#" onClick="#"><img src="imagenes/guardad.png"  alt="Guardar" /></a> 
			<a class="mgbt" href="presu-buscarecibocaja-reflejar.php"> <img src="imagenes/busca.png"  alt="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a class="mgbt" href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> 
			<a class="mgbt" href="#" onClick="guardar()"><img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" /></a> 
			<a class="mgbt" href="#"onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a> 
			<a class="mgbt" href="presu-reflejardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
	<form name="form2" method="post" action=""> 
		<?php
		function obtenerTipoPredio($catastral)
		{
			$tipo="";
			$digitos=substr($catastral,5,2);
			if($digitos=="00"){$tipo="rural";}
			else {$tipo="urbano";}
			return $tipo;
		} 
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$vigencia=$vigusu;
		$linkbd=conectar_bd();
		$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res))
		{
			$_POST[cuentacaja]=$row[0];
		}
		?>
		<?php
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
		$sqlr="SELECT tmindustria,desindustria,desavisos,desbomberil,intindustria,intavisos,intbomberil FROM tesoparametros";
		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res))
		{
			$_POST[salariomin]=$row[0];
			$_POST[descunidos]="$row[1]$row[2]$row[3]";
			$_POST[intecunidos]="$row[4]$row[5]$row[6]";
		}
	  	//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
		if ($_GET[idrecibo]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idrecibo];</script>";}
		$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja ORDER BY id_recibos DESC";
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
	 	$_POST[maximo]=$r[0];
		if(!$_POST[oculto]){
			$check1="checked";
			$fec=date("d/m/Y");
			$_POST[vigencia]=$vigencia;
			if ($_POST[codrec]!="" || $_GET[idrecibo]!="")
			{
				if($_POST[codrec]!="")
				{
					$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_POST[codrec]'";
				}
				else
				{
					$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja where id_recibos='$_GET[idrecibo]'";
				}
			}
			else
			{
				$sqlr="select id_recibos,id_recaudo from  tesoreciboscaja ORDER BY id_recibos DESC";
			}
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
//			$_POST[maximo]=$r[0];
			$_POST[ncomp]=$r[0];
			$_POST[idcomp]=$r[0];
			$_POST[idrecaudo]=$r[1];
		}
		if ($_POST[codrec]!="")
		{
			$sqlr="select * from tesoreciboscaja where id_recibos='$_POST[codrec]'";
		}
		else
		{
			$sqlr="select * from tesoreciboscaja where id_recibos=$_POST[idcomp]";
		}
 		$res=mysql_query($sqlr,$linkbd);
		while($r=mysql_fetch_row($res))
		{
			$_POST[tiporec]=$r[10];
			$_POST[idrecaudo]=$r[4];
			$_POST[ncomp]=$r[0];
			$_POST[modorec]=$r[5];	
		}
		//echo	 $sqlr;
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
		<input name="codrec" id="codrec" type="hidden" value="<?php echo $_POST[codrec]?>" >
		<input name="cobrorecibo" type="hidden" value="<?php echo $_POST[cobrorecibo]?>" >
	 	<input name="vcobrorecibo" type="hidden" value="<?php echo $_POST[vcobrorecibo]?>" >
 		<input name="tcobrorecibo" type="hidden" value="<?php echo $_POST[tcobrorecibo]?>" > 
 		<input name="encontro" type="hidden" value="<?php echo $_POST[encontro]?>" >
 		<input name="codcatastral" type="hidden" value="<?php echo $_POST[codcatastral]?>" >
 		<?php 
 		$_POST[concepto]="";
		switch($_POST[tiporec])
		{
			case 1:
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
					$sqlr="select vigencia from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo]  ";

					$res=mysql_query($sqlr,$linkbd);
					$vigencias="";
					while($row = mysql_fetch_row($res))
					{
						$vigencias.=($row[0]."-");
					}
					$vigencias=("A�os liquidados: ".substr($vigencias,0,-1));
					$sql="select * from tesoacuerdopredial where tesoacuerdopredial.idacuerdo=$_POST[idrecaudo] and estado<>'N' ";
					//OBTENER CUOTA ACTUAL
					$sqlr = "SELECT FIND_IN_SET($_POST[idcomp],recibo) as cuota FROM tesoacuerdopredial WHERE idacuerdo=$_POST[idrecaudo]";
					$data = view($sqlr);
					$_POST[cuotas] = $data[0][cuota]-1;
					$result=mysql_query($sql,$linkbd);
					$_POST[encontro]="";
					while($row = mysql_fetch_row($result))
					{
						//$_POST[cuotas]=$row[10]+1;
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
				}else{
					$_POST[tipo]="2";
		  			$sqlr="select *from tesoliquidapredial where tesoliquidapredial.idpredial=$_POST[idrecaudo] and  1=$_POST[tiporec]";
	  	  			$_POST[encontro]="";
		  			$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){
						$_POST[codcatastral]=$row[1];		
		  				$_POST[concepto]=$row[17].' Cod Catastral No '.$row[1];	
						//		$_POST[modorec]=$row[24];
						$_POST[valorecaudo]=$row[8];		
						$_POST[totalc]=$row[8];	
						$_POST[tercero]=$row[4];	
						$_POST[ntercero]=buscatercero($row[4]);		
						if ($_POST[ntercero]==''){
							$sqlr2="select *from tesopredios where cedulacatastral='".$row[1]."' ";
							$resc=mysql_query($sqlr2,$linkbd);
							$rowc =mysql_fetch_row($resc);
							$_POST[ntercero]=$rowc[6];
			 			}	
		  				$_POST[encontro]=1;
					}
		   		}	
		   		$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
				$res=mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($res); 
				//$_POST[idcomp]=$row[0];
				$_POST[fecha]=$row[2];
				$_POST[estadoc]=$row[9];
		   		if ($row[9]=='N'){
					$_POST[estado]="ANULADO";
		   			$_POST[estadoc]='0';
		   		}
		   		else{
			   		$_POST[estadoc]='1';
			   		$_POST[estado]="ACTIVO";
		   		}
				$_POST[modorec]=$row[5];
				$_POST[banco]=$row[7];	
        		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   			$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	  		break;
			case 2:
	  			$sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo]  and 2=$_POST[tiporec]";
				$_POST[encontro]="";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){
					$_POST[concepto]="Liquidacion Industria y Comercio avisos y tableros - ".$row[3];	
					$_POST[valorecaudo]=$row[6];		
					$_POST[totalc]=$row[6];	
					$_POST[tercero]=$row[5];	
					$_POST[ntercero]=buscatercero($row[5]);	
			//				$_POST[modorec]=$row[13];
					$_POST[encontro]=1;
				}
				$sqlr="select *from tesoreciboscaja where  id_recibos=$_POST[idcomp] ";
				$res=mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($res); 
				//$_POST[idcomp]=$row[0];
				$_POST[fecha]=$row[2];
				$_POST[estadoc]=$row[9];
				if ($row[9]=='N'){
					$_POST[estado]="ANULADO";
				   	$_POST[estadoc]='0';
		   		}
		   		else{
			   		$_POST[estadoc]='1';
			   		$_POST[estado]="ACTIVO";
		   		}
        		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   			$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	   			$_POST[modorec]=$row[5];
				$_POST[banco]=$row[7];
	  			break;
	  		case 3:
	  			$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo=$_POST[idrecaudo] and 3=$_POST[tiporec]";
  	  			$_POST[encontro]="";
	  			$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){
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
				//echo "$sqlr";
				//$_POST[idcomp]=$row[0];
				$_POST[fecha]=$row[2];
				$_POST[estadoc]=$row[9];
			   	if ($row[9]=='N'){
					$_POST[estado]="ANULADO";
		   			$_POST[estadoc]='0';
		   		}
		   		else{
			   		$_POST[estadoc]='1';
			   		$_POST[estado]="ACTIVO";
		   		}
				$_POST[modorec]=$row[5];
				$_POST[banco]=$row[7];
        		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	   			$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	   			//echo "mre:".$_POST[modorec];
				break;	
		}
 		?>
    	<table class="inicio" style="width:99.7%;">
      		<tr >
        		<td class="titulos" colspan="9">Reflejar Recibo de Caja Ppto</td>
        		<td class="cerrar" style="width:7%"><a href="teso-principal.php">Cerrar</a></td>
      		</tr>
      		<tr>
	        	<td class="saludo1" style="width:2cm;">No Recibo:</td>
    	    	<td  style="width:20%" colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>" > 
        	    	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
            	    <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" >
                	<input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()" style="width: 50%;">
	                <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
    	            <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
        	        <input type="hidden" value="a" name="atras" >
            	    <input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
	          	</td>
		  		<td class="saludo1" style="width:2.3cm;">Fecha:</td>
        		<td style="width:18%">
            		<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" readonly style="width: 45%;">  
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
			  	<td  style="width:12%">
            		<input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>   
                	<input type="hidden" name="estado" value="<?php echo $_POST[estado] ?>" size="5" readonly>  
	                <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">
	                <input type="hidden" name="cuotas" value="<?php echo $_POST[cuotas] ?>" size="5" readonly>  
	                <input type="hidden" name="tcuotas" value="<?php echo $_POST[tcuotas] ?>">
    	      	</td>
        		<td rowspan="6" colspan="<?php if($_POST[tiporec]=='1'){echo '1'; }else{echo '2';}?>" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
     		</tr>
	      	<tr>
    	    	<td class="saludo1"> Recaudo:</td>
        	    <td> 
            		<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;">
                    	<?php
						if($_POST[tiporec]=='1'){
							echo'<option value="1">Predial</option>';
						}
						else
						   if($_POST[tiporec]=='2'){
							echo'<option value="2">Industria y Comercio</option>';
						}
						else{
							echo'<option value="3">Otros Recuados</option>';
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
          		<?php
			  	$sqlr="";
			  	?>
        		<td class="saludo1"><?php if($_POST[tipo]=='1') {echo 'No. Acuerdo:'; }else{echo 'No Liquidaci&oacute;n:'; } ?></td>
            	<td>
            		<input type="text" id="idrecaudo" name="idrecaudo" value="<?php echo $_POST[idrecaudo]?>" style="width:100%" onKeyUp="return tabular(event,this)" onChange="validar()" readonly> 
	           	</td>
		 		<td class="saludo1">Recaudado en:</td>
        	    <td> 
            		<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" onChange="validar()" >
                    	<?php
							if($_POST[modorec]=='caja'){
								echo'<option value="caja">Caja</option>';
							}
							else{
								echo'<option value="banco">Banco</option>';
							}
						?>
	        		</select>
	        	</td>
	        </tr>
    		<?php
	  			if ($_POST[modorec]=='banco'){
			?>
			<tr>
				<td class='saludo1'>Cuenta :</td>
				<td>
     				<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)" style='width:100%;'>
	  					<?php
							$linkbd=conectar_bd();
							$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)){
								$i=$row[1];
						 		if($i==$_POST[banco]){
									echo "<option value=$row[1] ";
							 		echo "SELECTED";
						 			$_POST[nbanco]=$row[4];
						  			$_POST[ter]=$row[5];
							 		$_POST[cb]=$row[2];
							  		echo ">".$row[2]." - Cuenta ".$row[3]."</option>";	 	 
							 	}
							}	 	
						?>
        			</select>
	       			<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
    	            <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
        	 	</td>
            	<td colspan="<?php if($_POST[tiporec]=='1'){echo '6'; }else{echo '4';}?>"> 
            		<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>"  style="width:100%" readonly>
	          	</td>
	        </tr>
    	    <?php
				}
			?> 
		  	<tr>
        		<td class="saludo1">Concepto:</td>
            	<td colspan="<?php if($_POST[tiporec]=='1'){echo '7'; }else{echo '5';}?>">
            		<input name="concepto" type="text" value="<?php echo $_POST[concepto] ?>" onKeyUp="return tabular(event,this)" style='width:100%;'>
	           	</td>
    	  	</tr>
      		<tr>
            	<td class="saludo1">Documento: </td>
	        	<td>
    	        	<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" size="20" onKeyUp="return tabular(event,this)" readonly
    	        	style="width:100%">
        	 	</td>
				<td class="saludo1">Contribuyente:</td>
		  		<td colspan="<?php if($_POST[tiporec]=='1'){echo '5'; }else{echo '3';}?>">
    	        	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" size="50" onKeyUp="return tabular(event,this) " readonly style="width:100%">
        	        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
            	    <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
            	    <input type="hidden" value="1" name="oculto">
					<input type="hidden" value="<?php echo $_POST[trec]?>"  name="trec">
	    			<input type="hidden" value="0" name="agregadet">
		  		</td>
    	  	</tr>
    	  	<tr>
    	  		<td class="saludo1">Valor:</td>
				<td colspan="<?php if($_POST[tiporec]=='1'){echo '3'; }else{echo '1';}?>">
					<input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo $_POST[valorecaudo]?>" size="30" onKeyUp="return tabular(event,this)" readonly style="width:100%">
				</td>
    	  	</tr>
    	  	<?php if ($_POST[modorec]!='banco'){echo"<tr style='height:20;'><tr>";}?>
		</table>
    	<div class="subpantallac7" style="height:40%">
	    	<?php 
		 	if($_POST[encontro]=='1')
			{
		 	//echo "trr".$_POST[tiporec];
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
							$sqlr="select * from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo] ";
							$res = view($sqlr);
							//OBTENER VALOR DE LA COUTA RECIBO DE CAJA
							$sql = "select tesoreciboscaja_det.valor from tesoreciboscaja_det where tesoreciboscaja_det.id_recibos=$_POST[idcomp]";
							$cuot = view($sql);
							//OBTENER VALOR DE LA COUTA VERDADERO
							$sql = "SELECT * FROM tesoacuerdopredial_pagos T1 WHERE T1.idacuerdo=$_POST[idrecaudo] AND T1.cuota=$_POST[cuotas]";
							$datico = view($sql);
							//VALOR DE LOS INGRESOS
							$dvalorTRUE = round($datico[0][valor_pago]/count($res),2);
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
									$_POST[dvalores][]=$dvalorTRUE;
									$_POST[dvaloresREC][]=$cuot[$key][valor];
								}
								else
								{
									$sqlr2="select * from tesoingresos where codigo='03'";
									$row2 = view($sqlr2); 
									$_POST[dcoding][]=$row2[0][codigo];
									$_POST[dncoding][]=$row2[0][nombre]." ".$vig;
									$_POST[dvalores][]=$dvalorTRUE;	
									$_POST[dvaloresREC][]=$cuot[$key][valor];
								}
							}
							$res=mysql_query($sqlr,$linkbd);
						}
						else
						{
							$sqlr="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
	 	 					$res=mysql_query($sqlr,$linkbd);
							//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
							while ($row =mysql_fetch_row($res))
							{
								$vig=$row[1];
								if($vig==$vigusu){
									$sqlr2="select * from tesoingresos where codigo='01'";
									$res2=mysql_query($sqlr2,$linkbd);
									$row2=mysql_fetch_row($res2); 
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
						}
					}break;
					case 2: //***********INDUSTRIA Y COMERCIO
					{
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
						$sqlr="select *from tesoindustria where tesoindustria.id_industria=$_POST[idrecaudo] and 2=$_POST[tiporec]";
						$res=mysql_query($sqlr,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$sqlr2="select * from tesoingresos where codigo='02'";
							$res2=mysql_query($sqlr2,$linkbd);
							$row2 =mysql_fetch_row($res2);
							$_POST[dcoding][]=$row2[0];
							$_POST[dncoding][]=$row2[1];
							$_POST[dvalores][]=$row[6];
						}
					}break;
					case 3: ///*****************otros recaudos *******************
					{
						$_POST[trec]='OTROS RECAUDOS';
						$sqlr="Select *from tesoreciboscaja_det where tesoreciboscaja_det.id_recibos=$_POST[idcomp]";
						$_POST[dcoding]= array();
						$_POST[dncoding]= array(); 
						$_POST[dvalores]= array(); 	
						$res=mysql_query($sqlr,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$_POST[dcoding][]=$row[2];
							$sqlr2="select nombre from tesoingresos where  codigo='".$row[2]."'";
							$res2=mysql_query($sqlr2,$linkbd);
							$row2 =mysql_fetch_row($res2);
							$_POST[dncoding][]=$row2[0];
							$_POST[dvalores][]=$row[3];
						}break;
					}
				}
			}
 				?>
				<table class="inicio">
					<tr>
						<td colspan="4" class="titulos">Detalle Recibo de Caja</td>
					</tr>                  
					<tr>
						<td class="titulos2">Codigo</td><td class="titulos2">Ingreso</td><td class="titulos2">Valor</td>
					</tr>
					<?php 
					if ($_POST[elimina]!='')
					{
						$posi=$_POST[elimina];
						unset($_POST[dcoding][$posi]);
						unset($_POST[dncoding][$posi]);
						unset($_POST[dvalores][$posi]);
						$_POST[dcoding]= array_values($_POST[dcoding]);
						$_POST[dncoding]= array_values($_POST[dncoding]);
						$_POST[dvalores]= array_values($_POST[dvalores]);
					}
					if($_POST[agregadet]=='1')
					{
						$_POST[dcoding][]=$_POST[codingreso];
						$_POST[dncoding][]=$_POST[ningreso];
						$_POST[dvalores][]=$_POST[valor];
						$_POST[agregadet]=0;
						echo"
						<script>
							document.form2.codingreso.value='';
							document.form2.valor.value='';
							document.form2.ningreso.value='';
							document.form2.codingreso.select();
							document.form2.codingreso.focus();
						</script>";
					}
				$_POST[totalc]=0;
				$iter='saludo1a';
				$iter2='saludo2';
				$most = 'dvalores';
				if($_POST[tipo]=='1'){
					$most = 'dvaloresREC';
				}
				for ($x=0;$x<count($_POST[dcoding]);$x++)
				{
					echo "<tr class='$iter' >
						<td style='width:10%;'>
							<input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."' size='4'>".$_POST[dcoding][$x]."
						</td>
						<td>
							<input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."' size='90'>".$_POST[dncoding][$x]."
						</td>
						<td align='right' style='width:20%;'>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."' size='15'>$ ".number_format($_POST[$most][$x],2,',','.')."
						</td>
					</tr>";
					$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
					$_POST[totalcf]=number_format($_POST[totalc],2);
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
				}
				$resultado = convertir($_POST[totalc]);
				$_POST[letras]=$resultado." PESOS M/CTE";
				echo "<tr class='$iter'>
					<td></td>
					<td align='right'>Total</td>
					<td align='right'>
						<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
						<input name='totalc' type='hidden' value='$_POST[totalc]'>$ ".number_format($_POST[totalc],2,',','.')."
					</td>
				</tr>
				<tr class='titulos2'>
					<td>Son:</td><td colspan='5' >
						<input name='letras' type='hidden' value='$_POST[letras]' size='90'>".$_POST[letras]."
					</td>
				</tr>";
				?> 
			</table>
		</div>
		<?php
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
						{
							$sql="select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo] and estado !='N'";
							$resul=mysql_query($sql,$linkbd);
							$rowcod=mysql_fetch_row($resul);
							$tipopre=obtenerTipoPredio($rowcod[0]);
							$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='1' ";
							$res=mysql_query($sqlr,$linkbd);
							while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
							if($numerorecaudos>=0)
							{
								$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
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
								echo "<input type='hidden' name='concec' value='$concecc'>";	
								echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recibo de Caja con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
								if($_POST[tipo]=='1')
								{
									$cuotas=intval($_POST[cuotas]);
									$totcuotas=intval($_POST[tcuotas]);
									if(($totcuotas-$cuotas)==0)
									{
										$sqlr="update tesoacuerdopredial set estado='P' WHERE idacuerdo=$_POST[idrecaudo]";
										mysql_query($sqlr,$linkbd);
										$sqlrp="Select tesoacuerdopredial_det.vigencia,tesoacuerdopredial.codcatastral from tesoacuerdopredial_det,tesoacuerdopredial where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo] AND tesoacuerdopredial_det.idacuerdo=tesoacuerdopredial.idacuerdo";
										$resq=mysql_query($sqlrp,$linkbd);
										while($rq=mysql_fetch_row($resq))
										{
											$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral='".$rq[1]."' AND vigencia='".$rq[0]."' ";
											mysql_query($sqlr2,$linkbd);
										}
									}
									else
									{
										/*$sqlr="update tesoacuerdopredial set cuota_pagada=cuota_pagada+1,abono=abono+$_POST[totalc] WHERE idacuerdo=$_POST[idrecaudo]";
										mysql_query($sqlr,$linkbd);*/
									}
								}
								else
								{
									$sqlr="update tesoliquidapredial set estado='P' WHERE idpredial=$_POST[idrecaudo]";
									mysql_query($sqlr,$linkbd);
									$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
									$resq=mysql_query($sqlr,$linkbd);
									while($rq=mysql_fetch_row($resq))
									{
										$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE   idpredial=$_POST[idrecaudo]) AND vigencia=$rq[1]";
										mysql_query($sqlr2,$linkbd);
									}
								}
								echo"
								<script>
									document.form2.numero.value='';
									document.form2.valor.value=0;
								</script>";
								if($_POST[tipo]=='1')
								{
									$sql = "SELECT T1.porcentaje_valor,T1.valor_pago FROM tesoacuerdopredial_pagos T1 WHERE T1.idacuerdo=$_POST[idrecaudo] AND T1.cuota=$_POST[cuotas]";
									$dat = view($sql);
									$sqlrs="select *from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo] ";
									$res=mysql_query($sqlrs,$linkbd);	
									$rowd==mysql_fetch_row($res);
									$tasadesc=round(($rowd[5]*$dat[0][porcentaje_valor])/100,2);
									$sqlr="select *from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[idrecaudo]";
								}
								else
								{
									$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
									$res=mysql_query($sqlrs,$linkbd);	
									$rowd==mysql_fetch_row($res);
									$tasadesc=($rowd[6]/100);
									$sqlrs="select *from tesoliquidapredial_det where tesoliquidapredial_det.idpredial=$_POST[idrecaudo] and estado ='S'  and 1=$_POST[tiporec]";
								}
								$res=mysql_query($sqlrs,$linkbd);
								//*******************CREANDO EL RECIBO DE CAJA DE PREDIAL ***********************
								$query="DELETE FROM pptorecibocajappto WHERE idrecibo=$concecc";
								mysql_query($query,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if($_POST[tipo]=='1')
									{
										$vig=$row[13];
										$vlrdesc=round($row[9]*$dat[0][porcentaje_valor],2);
									}
												else{
										$vig=$row[1];
										$vlrdesc=$row[10];
									}
									if($vig==$vigusu) //*************VIGENCIA ACTUAL *****************
									{
										$idcomp=mysql_insert_id();
										$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
										mysql_query($sqlr,$linkbd);
										$sqlr2="select * from tesoingresos_det where codigo='01' AND MODULO='4' and vigencia=$vigusu group by concepto";
										$res2=mysql_query($sqlr2,$linkbd);
										//****** $cuentacb   ES LA CUENTA CAJA O BANCO
										while($rowi =mysql_fetch_row($res2))
										{
											switch($rowi[2])
											{
												case '01': //***  VALOR PREDIAL
												{
													//**** busca descuento PREDIAL
													$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P01' AND MODULO='4' and vigencia=$vigusu";
													$resds=mysql_query($sqlrds,$linkbd);
													while($rowds =mysql_fetch_row($resds))
													{$descpredial=round($vlrdesc*round($rowds[5]/100,2),2);}
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[2]*$dat[0][porcentaje_valor],2);
														$valordeb=round($row[2]*$dat[0][porcentaje_valor],2);
													}else{
														$valorcred=$row[4];
														$valordeb=$row[4];
													}
													if($valorcred>0)
													{
														//******MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO 
														if($_POST[tipo]=='1')
														{
															$vi=$valordeb-$descpredial;
														}
														else
														{
															$vi=$row[4]-$descpredial;
														}
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='01' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);
															}
														}
														//************ FIN MODIFICACION PPTAL
													}
												}break;  
												case '02':
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1')
													{
														$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);
														$valordeb=round($row[7]*$dat[0][porcentaje_valor],2);
													}
													else
													{
														$valorcred=$row[8];
														$valordeb=$row[8];	
													}
													if($valorcred>0)
													{
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														if($_POST[tipo]=='1')
														{
															$vi=$valordeb;
														}
														else
														{
															$vi=$row[8];
														}
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='02' AND vigencia='$vigusu'";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
													}
												}break;  
												case '03': 	
												{		
													$sqlrds="select * from tesoingresos_det where codigo='01' and concepto='P10' AND MODULO='4' and vigencia=$vigusu";
													$resds=mysql_query($sqlrds,$linkbd);
													while($rowds =mysql_fetch_row($resds))
													{$descpredial=round($vlrdesc*round($rowds[5]/100,2),2);}
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);
														$valordeb=round($row[5]*$dat[0][porcentaje_valor],2);
													}else{
														$valorcred=$row[6];
														$valordeb=$row[6];
													}			 	
													if($valorcred>0)
													{							
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														if($_POST[tipo]=='1'){
															$vi=$valordeb-$descpredial;
														}else{
															$vi=$row[6]-$descpredial;
														}
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='03' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL			
													}
												}break;  
												case 'P10':
												{
													if($_POST[tipo]=='1')
													{$valordeb=round(($row[9]*$dat[0][porcentaje_valor])*round(($porce/100),2),2);}
													else{$valordeb=round($row[10]*round(($porce/100),2),2);}
													if($valordeb>0){
														$vi=$valordeb;
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P10' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','P10')";
																mysql_query($sqlr,$linkbd);	
																$sqlr="";
															}
														}
													   if($numreg==0 )
													   {
															if($vi>0 && $rowi[6]!="")
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P10')";
																mysql_query($sqlr,$linkbd); 
																$sqlr="";
															}

													   }
													}
												}break;
												case 'P01':
												{
													if($_POST[tipo]=='1')
													{$valordeb=round(($row[9]*$dat[0][porcentaje_valor])*round(($porce/100),2),2);}
													else {$valordeb=round($row[10]*round($porce/100,2),2);}
													if($valordeb>0)
													{
														$vi=$valordeb;
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P01' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','P01')";
																mysql_query($sqlr,$linkbd);
																$sqlr="";
															}
														}
														if($numreg==0 )
														{
															if($vi>0 && $rowi[6]!="")
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P10')";
																mysql_query($sqlr,$linkbd); 
																$sqlr="";
															}
														}
														//************ FIN MODIFICACION PPTAL
													}
												}break;
												case 'P02': 
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1')
													{
														$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);
													}
													else
													{
														$valorcred=$row[5];
													}
													$valordeb=$valorcred;
													if($valorcred>0)
													{
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														if($_POST[tipo]=='1')
														{
															$vi=$valordeb;
														}
														else
														{
															$vi=$row[5];
														}
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P02' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL	
													}
												}break;
												case 'P04':
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);
													}else{
														$valorcred=$row[7];
													}	
													$valordeb=$valorcred;
													if($valorcred>0)
													{			
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														if($_POST[tipo]=='1'){
															$vi=$valordeb;
														}else{
															$vi=$row[7];
														}
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);	
														  //****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P04' AND vigencia=$vigusu";
														//echo $sql;
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}	
														//************ FIN MODIFICACION PPTAL	
													}
												}break; 
												case 'P05':
												{
													if($_POST[tipo]=='1'){$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);}
														$valordeb=$valorcred;
														$vi=$valordeb;
														if($valorcred>0){
														//****creacion documento presupuesto ingresos

														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND  tipo  LIKE '%$tipopre%' AND concepto='P05' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														//****creacion documento presupuesto ingresos
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','P05')";
																mysql_query($sqlr,$linkbd);	
																$sqlr="";
															}
														}
														if($numreg==0 )
														{
															if($vi>0 && $rowi[6]!="")
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P05')";
																mysql_query($sqlr,$linkbd); 
																$sqlr="";
															}
														}
														//************ FIN MODIFICACION PPTAL
													}
												}
												break;
												case 'P07': 
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[8]*$dat[0][porcentaje_valor],2);	
													}else{
														$valorcred=$row[9];
													}	 
													$valordeb=$valorcred;
													if($valorcred>0)
													{			
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														if($_POST[tipo]=='1'){
															$vi=$valordeb;
														}else{
															$vi=$row[9];
														}
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P07' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL	
													}
												}break; 
												case 'P08':
												{
													$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
													$re=mysql_query($sq,$linkbd);
													while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
													$resc=mysql_query($sqlrc,$linkbd);	  
													while($rowc=mysql_fetch_row($resc))
													{
														$porce=$rowi[5];
														if($rowc[6]=='S')
														{
															$valorcred=0;
															if($_POST[tipo]=='1'){$valordeb=round($row[7]*$dat[0][porcentaje_valor],2);}
															else{$valordeb=$row[8];}			  
														}
														if($rowc[6]=='N')
														{
															$valordeb=0;
															if($_POST[tipo]=='1'){$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);}
															else{$valorcred=$row[8];}					
														}	
														if($rowc[3]=='N')
														{

															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
															$respto=mysql_query($sqlrpto,$linkbd);
															$rowpto=mysql_fetch_row($respto);
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
															//****creacion documento presupuesto ingresos

															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P08' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia, tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','P08')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','P08')";
																	//echo $sqlr;
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";

																}
															}
														}
													}
												}break;
												case 'P18': //***
												{
													$siAlumbrado=0;
													$sqlrDesc = "SELECT val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='$row[0]' AND vigencia=$vig ORDER BY vigencia ASC";
													$resDesc = mysql_query($sqlrDesc,$linkbd);
													while ($rowDesc =mysql_fetch_assoc($resDesc))
													{
														$siAlumbrado = $rowDesc['val_alumbrado'];
													}
													if($siAlumbrado>0)
													{
														$valorAlumbrado=round($siAlumbrado,0);
														//$valorAlumbrado=round($row[2]*($vcobroalumbrado/1000),0);
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$valorcred=$valorAlumbrado;
														$valordeb=0;
														if($valorcred>0)
														{
															$vi=$valorcred;
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND  tipo LIKE '%$tipopre%' AND concepto='P18' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','02')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','02')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															}
														}
													}
												}break;
											} 
										}
										if($_POST[tipo]=='1')
										{
											$_POST[dcoding][]=$row2[0][codigo];
											$_POST[dncoding][]=$row2[0][nombre]." ".$vig;
											$_POST[dvalores][]=$dvalorTRUE;	
										}
										else
										{
											$_POST[dcoding][]=$row2[0];
											$_POST[dncoding][]=$row2[1]." ".$vig;
											$_POST[dvalores][]=$row[11];
										}
									}
									else  ///***********OTRAS VIGENCIAS ***********
									{
										if($_POST[tipo]=='1')
										{
											$tasadesc=round(($row[9]*$dat[0][porcentaje_valor])/(($row[2]*$dat[0][porcentaje_valor])+($row[5]*$dat[0][porcentaje_valor])),2);
										}
										else
										{
											$tasadesc=$row[10];
										}
										$idcomp=mysql_insert_id();
										$sqlr="update tesoreciboscaja set id_comp=$idcomp WHERE id_recaudo=$_POST[idrecaudo] and tipo='1'";
										mysql_query($sqlr,$linkbd);
										$sqlr2="select * from tesoingresos_det where codigo='03' AND MODULO='4' and vigencia=$vigusu GROUP BY concepto";

										$res2=mysql_query($sqlr2,$linkbd);
										//****** $cuentacb   ES LA CUENTA CAJA O BANCO
										while($rowi =mysql_fetch_row($res2))
										{
											switch($rowi[2])
											{
												case 'P03': //***
												{
													$porce=$rowi[5];	
													if($_POST[tipo]=='1'){
														$valorcred=round($row[2]*$dat[0][porcentaje_valor],2);
													}else{
														$valorcred=$row[4];
													}
													$valordeb=$valorcred;
													if($valorcred>0)
													{
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='".$rowi[6]."' and vigencia=$vigusu";
														$respto=mysql_query($sqlrpto,$linkbd);	     
														$rowpto=mysql_fetch_row($respto);
														if($_POST[tipo]=='1'){
															$vi=$valordeb;
														}else{
															$vi=$row[4]-$tasadesc;
														}
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P03' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL		
													}
												}break;  
												case 'P06': //***
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[7]*$dat[0][porcentaje_valor],2);	
													}else{		 
														$valorcred=$row[8];
													}
													$valordeb=$valorcred;	
													if($valorcred>0)
													{						
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														if($_POST[tipo]=='1'){
															$vi=$valordeb;
														}else{
															$vi=$row[8];
														}
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P06' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL	
													}
												}break;  
												case '03': 
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);	
													}else{
														$valorcred=$row[6];
													}		 
													$valordeb=$valorcred;	
													if($valorcred>0)
													{			
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														$vi=$valordeb;
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='03' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'".$vigusu."')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL	
													}
												}break;  
												case 'P01':
												{
													$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
													$re=mysql_query($sq,$linkbd);
													while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
													$resc=mysql_query($sqlrc,$linkbd);	  
													while($rowc=mysql_fetch_row($resc))
													{
														$porce=$rowi[5];
														if($rowc[6]=='S')
														{			
															if($_POST[tipo]=='1'){
																$valordeb=round($row[9]*$dat[0][porcentaje_valor],2);	
															}else{ 
																$valordeb=$row[10];
															}
															$valorcred=0;					
															if($rowc[3]=='N')
															{
																if($valorcred>0)
																{}
															}
														}
													}
												}break;  
												case 'P02':
												{ 
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[3]*$dat[0][porcentaje_valor],2);	
													}else{
														$valorcred=$row[5];
													}		 
													$valordeb=$valorcred;
													if($valorcred>0)
													{
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														$vi=$valordeb;
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P02' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]',$concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
													}
												}break;  
												case 'P04': 
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[6]*$dat[0][porcentaje_valor],2);	
													}else{
														$valorcred=$row[7];
													}			 
													$valordeb=$valorcred;	
													if($valorcred>0)
													{						
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														$vi=$valordeb;
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P04' AND vigencia='$vigusu'";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL	
													}
												}break;  
												case 'P05':
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[5]*$dat[0][porcentaje_valor],2);
													}else{
														$valorcred=$row[6];
													}			 
													$valordeb=$valorcred;
													if($valorcred>0)
													{
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														if($_POST[tipo]=='1'){
															$vi=$valordeb;
														}else{
															$vi=$row[6];
														}
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo  LIKE '%$tipopre%' AND concepto='P05' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL	
													}
												}break;  
												case 'P07': 
												{
													$porce=$rowi[5];
													if($_POST[tipo]=='1'){
														$valorcred=round($row[8]*$dat[0][porcentaje_valor],2);
													}else{
														$valorcred=$row[9];
													}			 
													$valordeb=$valorcred;	
													if($valorcred>0)
													{			
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														$sqlrpto="Select * from pptocuentas where estado='S' and cuenta='$rowi[6]' and vigencia='$vigusu'";
														$respto=mysql_query($sqlrpto,$linkbd);   
														$rowpto=mysql_fetch_row($respto);
														$vi=$valordeb;
														$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia='$vigusu'";
														mysql_query($sqlr,$linkbd);	
														//****creacion documento presupuesto ingresos
														$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P07' AND vigencia=$vigusu";
														$resul=mysql_query($sql,$linkbd);
														$numreg=mysql_num_rows($resul);
														while($rowp = mysql_fetch_row($resul))
														{
															if($rowp[0]!="" && $vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowp[0]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														if($numreg==0 )
														{
															if($vi>0)
															{
																$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]', $concecc,$vi,'$vigusu')";
																mysql_query($sqlr,$linkbd);	
															}
														}
														//************ FIN MODIFICACION PPTAL	
													}
												}break; 
												case 'P08':
												{
													$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
													$re=mysql_query($sq,$linkbd);
													while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
													$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
													$resc=mysql_query($sqlrc,$linkbd);
													while($rowc=mysql_fetch_row($resc))
													{
														$porce=$rowi[5];
														if($_POST[tipo]=='1'){$valnu=round($row[7]*$dat[0][porcentaje_valor],2);}
														else{$valnu=$row[8];}
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
															$rowpto=mysql_fetch_row($respto);
															$vi=$valordeb;
															$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='$rowi[6]' and vigencia=$vigusu";
															mysql_query($sqlr,$linkbd);	
															//****creacion documento presupuesto ingresos
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P08' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','S','P08')";
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','S','P08')";
																	mysql_query($sqlr,$linkbd); 
																	$sqlr="";
																}
															 }
															//************ FIN MODIFICACION PPTAL		
														}
													}
												}break;
												case 'P18': //***
												{
													$siAlumbrado=0;
													$sqlrDesc = "SELECT val_alumbrado FROM tesoliquidapredial_desc WHERE id_predial='$row[0]' AND vigencia=$vig ORDER BY vigencia ASC";
													$resDesc = mysql_query($sqlrDesc,$linkbd);
													while ($rowDesc =mysql_fetch_assoc($resDesc))
													{
														$siAlumbrado = $rowDesc['val_alumbrado'];
													}
													if($siAlumbrado>0)
													{
														$valorAlumbrado=round($siAlumbrado,0);
														//$valorAlumbrado=round($row[2]*($vcobroalumbrado/1000),0);
														$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$valorcred=$valorAlumbrado;
														$valordeb=0;
														if($valorcred>0)
														{
															$vi=$valorcred;
															$sql="SELECT cuentapres FROM tesoingresos_tipo WHERE cod_ingreso IN (01,03) AND tipo LIKE '%$tipopre%' AND concepto='P18' AND vigencia=$vigusu";
															$resul=mysql_query($sql,$linkbd);
															$numreg=mysql_num_rows($resul);
															//****creacion documento presupuesto ingresos
															while($rowp = mysql_fetch_row($resul))
															{
																if($rowp[0]!="" && $vi>0)
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor, vigencia,tipo,ingreso) values('$rowp[0]',$concecc,$vi,'$vigusu','N','02')";
																	
																	mysql_query($sqlr,$linkbd);	
																	$sqlr="";
																}
															}
															if($numreg==0 )
															{
																//echo "$vi --> $rowi[6]";
																if($vi>0 && $rowi[6]!="")
																{
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$concecc,$vi,'$vigusu','N','02')";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="";
																}
															}
														}
													}
												}break;
											} 
		 								}
		 							}
								}
								if($_POST[tipo]=='1')
								{
									$sqlr="Select *from tesoacuerdopredial_det where idacuerdo=$_POST[idrecaudo]";
									$resp=mysql_query($sqlr,$linkbd);
									while($row=mysql_fetch_row($resp,$linkbd))
									{
										$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial=$_POST[idrecaudo]) AND vigencia=$row[13]";
										mysql_query($sqlr2,$linkbd);
									}
									//ACTUALIZAR CUOTA PAGADA
									$sql = "UPDATE tesoacuerdopredial_pagos T1 SET T1.estado='N' WHERE T1.idacuerdo=$_POST[idrecaudo] AND T1.cuota=$_POST[cuotas]";
									view($sql);
								}
								else
								{
									$sqlr="Select *from tesoliquidapredial_det where idpredial=$_POST[idrecaudo]";
									$resp=mysql_query($sqlr,$linkbd);
									while($row=mysql_fetch_row($resp,$linkbd))
									{
										$sqlr2="update tesoprediosavaluos set pago='S' where codigocatastral=(select codigocatastral from tesoliquidapredial WHERE idpredial='$_POST[idrecaudo]') AND vigencia='$row[1]'";
										mysql_query($sqlr2,$linkbd);
									}
								}
   	 						} //fin de la verificacion
							else
							{
								echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion Predial<img src='imagenes/alert.png'></center></td></tr></table>";
							}//***FIN DE LA VERIFICACION
						}break;
						case 2:  //********** INDUSTRIA Y COMERCIO
						{	
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							$sqlr="select count(*) from tesoreciboscaja where id_recaudo=$_POST[idrecaudo] and tipo='2'";
							$res=mysql_query($sqlr,$linkbd);
							while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
							if($numerorecaudos>=0)
							{
								$sqlr="delete from pptorecibocajappto where idrecibo='$_POST[idcomp]'";
								if (!mysql_query($sqlr,$linkbd))
								{
									echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
									echo "Ocurri� el siguiente problema:<br>";
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
									//**********************CREANDO COMPROBANTE CONTABLE *****************************
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
												$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
												$re=mysql_query($sq,$linkbd);
												while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='$_POST[fechacausa]'";
												$resc=mysql_query($sqlrc,$linkbd);
												while($rowc=mysql_fetch_row($resc))
												{
													$porce=$rowi[5];
													if($rowc[7]=='S')
													{
														$vi=$_POST[dvalores][$x];
														$valordeb=0;
														if($rowc[3]=='N')
														{
															//*****inserta del concepto contable  
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$rowi[6]','$_POST[tercero]','RECIBO DE CAJA PREDIAL','$vi',0, '$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
															//mysql_query($sqlr,$linkbd); 				
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
										
										if((substr($_POST[descunidos], -3, 1)=='S')||($row[22]>0))
										{
											if($row[22]>0){$_POST[descuenindus]=$row[22];}
											else {$_POST[descuenindus]=$row[1]*($row[13]/100);}
										}
										else{$_POST[descuenindus]=0;}
										if((substr($_POST[descunidos], -2, 1)=='S')||($row[23]>0))
										{
											if($row[23]>0){$_POST[descuenaviso]=$row[23];}
											else{$_POST[descuenaviso]=$row[2]*($row[13]/100);}
										}
										else {$_POST[descuenaviso]=0;}
										if((substr($_POST[descunidos], -1, 1)=='S')||($row[24]>0))
										{
											if($row[24]>0){$_POST[descuenbombe]=$row[24];}
											else {$_POST[descuenbombe]=$row[3]*($row[13]/100);}
										}
										else{$_POST[descuenbombe]=0;}
										$descuentogeneral=$row[4]+$row[18];
										$recargosgeneral=$row[5]+$row[25];
										$industria=round($row[1]-$_POST[descuenindus],-3);
										$avisos=round($row[2]-$_POST[descuenaviso],-3);
										$bomberil=round($row[3]-$_POST[descuenbombe],-3);
										$retenciones=$row[4];
										$sanciones=$row[5];
										$intereses=$row[25];
										$interesesind=$row[26];
										$interesesavi=$row[27];
										$interesesbom=$row[28];
										$antivigact=$row[11];
										$antivigant=$row[10];
										if($intereses>0)
										{
											$intetodos=(float)$interesesind+(float)$interesesavi+(float)$interesesbom;
											if($intetodos>0)
											{
												$indinteres=$interesesind;
												$aviinteres=$interesesavi;
												$bominteres=$interesesbom;
											}
											else
											{
												$indinteres=$intereses;
												$aviinteres=0;
												$bominteres=0;
											}
										}
										$sqlri="SELECT * FROM tesoingresos_det WHERE codigo='".$_POST[dcoding][$x]."' AND vigencia='$vigusu' ORDER BY concepto";
										$res=mysql_query($sqlri,$linkbd);
										while($row=mysql_fetch_row($res))
										{
											switch($row[2])
											{
												case '00': //*****SANCIONES
												{
													if($sanciones>0)
													{
														$valordeb=$sanciones;
														$valorcred=0;
														$sqlr="UPDATE pptocuentaspptoinicial SET ingresos=ingresos+$industria WHERE cuenta='$row[6]' AND vigencia= '$vigusu'";
														mysql_query($sqlr,$linkbd);
														$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc,$sanciones, '$vigusu')";
														mysql_query($sqlr,$linkbd);
													}
												}break;
												case '04': //*****INDUSTRIA
												{
													$saldoindustria=$industria+$recargosgeneral-$descuentogeneral;
													if($saldoindustria>=0)
													{
														$totalindustria=$saldoindustria;
														$descuentogeneral=0;
														$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc, $totalindustria,'$vigusu')";
														mysql_query($sqlr,$linkbd);
													}
													else
													{
														$totalindustria=$industria+$recargosgeneral;
														$descuentogeneral=$descuentogeneral-$totalindustria;
														$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc,'0','$vigusu')";
														mysql_query($sqlr,$linkbd);
														/*$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc, $totalindustria,'$vigusu')";
														mysql_query($sqlr,$linkbd);
														$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc, -$totalindustria,'$vigusu')";
														mysql_query($sqlr,$linkbd);*/
														
													}
												}break;
												case '05'://************AVISOS
												{
													$saldoavisos= $avisos-$descuentogeneral;
													if($saldoavisos>0)
													{
														$totalavisos=$saldoavisos;
														$descuentogeneral=0;
														$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc,$totalavisos,'".$vigusu."')";
														mysql_query($sqlr,$linkbd);
													}
													else
													{
														$totalavisos=$avisos;
														$descuentogeneral=$descuentogeneral-$totalavisos;
														$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc,'0','".$vigusu."')";
														mysql_query($sqlr,$linkbd);
														/*$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc,$totalavisos,'".$vigusu."')";
														mysql_query($sqlr,$linkbd);
														$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES ('$row[6]',$concecc,-$totalavisos,'".$vigusu."')";
														mysql_query($sqlr,$linkbd);*/
													}
												}break;
												case '06': //*********BOMBERIL ********
												{
													$saldobomberil=$bomberil-$descuentogeneral;
													$sqlr="INSERT INTO pptorecibocajappto (cuenta,idrecibo,valor,vigencia) VALUES('$row[6]','$concecc', '$saldobomberil','$vigusu')";
													mysql_query($sqlr,$linkbd);
													
												}break;
												case 'P04': //*********INTERESES BOMBERIL********
												{
													if($bominteres>0)
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='P04' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P04' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															if($row2[3]=='N')
															{
																if($row2[6]=='S')
																{
																	$valordeb=0;
																	$valorcred=$bominteres;
																	//********** CAJA O BANCO
																	$valordeb=$bominteres;
																	$valorcred=0;
																	//***MODIFICAR PRESUPUESTO
																	$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$bominteres WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]', '$concecc','$bominteres','$vigusu')";
																	//echo "<br> intereses bomberil: ".$sqlr;
																	mysql_query($sqlr,$linkbd);	
																	if($row[6]!="")
																	{
																		//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[6]', '$_POST[tercero]','RECIBO DE CAJA',$bominteres,0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
																		//mysql_query($sqlr,$linkbd); 		
																	}
																}
															}
														}
													}
												}break;
												case 'P12'://************ANTICIPOS VIG ACTUAL ****************** 
												{
													if($antivigact>0)
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='P11' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															if($row2[3]=='N')
															{				 					  		
																if($row2[7]=='S')
																{				 
																	$valordeb=0;
																	$valorcred=$antivigact;					
																	//$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','ANTICIPO VIGENCIA ACTUAL $_POST[ageliquida]', '',0,$valorcred,'1','$_POST[vigencia]')";
																	//mysql_query($sqlr,$linkbd);	 
																	//********** CAJA O BANCO
																	$valordeb=$antivigact;
																	$valorcred=0;
																	//$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$cuentacb','$_POST[tercero]','$row2[5]','ANTICIPO VIGENCIA ACTUAL $_POST[modorec]','', '$valordeb',0,'1','$_POST[vigencia]')";
																	//mysql_query($sqlr,$linkbd);											
																}
															}						
														}
													}
												}break;
												case 'P13'://************ANTICIPOS VIG ANTERIOR ****************** 
												{
													if($antivigant>0)
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='P11' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P11' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															if($row2[3]=='N')
															{				 					  		
																if($row2[7]=='S')
																{				 
																	$valorcred=0;
																	$valordeb=$antivigant;					
																	//$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('5 $concecc','$row2[4]','$_POST[tercero]','$row2[5]','ANTICIPO VIGENCIA ANTERIOR $_POST[ageliquida]', '',$valordeb,$valorcred,'1','$_POST[vigencia]')";
																	//mysql_query($sqlr,$linkbd);	 
																	//********** CAJA O BANCO									
																}
															}						
														}
													}
												}break;
												case 'P16'://*****INTERESES INDUSTRIA
												{
													if($indinteres>0)
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='P16' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P16' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															if($row2[3]=='N')
															{				 					  		
																if($row2[6]=='S')
																{				 
																	$valordeb=0;
																	$valorcred=$indinteres;					
																	//********** CAJA O BANCO
																	$valordeb=$indinteres;
																	$valorcred=0;
																	//***MODIFICAR PRESUPUESTO
																	$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$indinteres WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]', '$concecc','$indinteres','$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																	if($row[6]!="")
																	{
																		//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[6]', '$_POST[tercero]','RECIBO DE CAJA',$indinteres,0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
																		//mysql_query($sqlr,$linkbd); 		
																	}
																}
															}
														}
													}
												}break;
												case 'P17'://*****INTERESES AVISOS Y TABLEROS
												{
													if($aviinteres>0)
													{
														$sq="select fechainicial from conceptoscontables_det where codigo='P17' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
														$sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='P17' and tipo='C' and fechainicial='$_POST[fechacausa]'";
														$res2=mysql_query($sqlr2,$linkbd);
														while($row2=mysql_fetch_row($res2))
														{
															if($row2[3]=='N')
															{
																if($row2[6]=='S')
																{				 
																	$valordeb=0;
																	$valorcred=$aviinteres;
																	//********** CAJA O BANCO
																	$valordeb=$aviinteres;
																	$valorcred=0;
																	//***MODIFICAR PRESUPUESTO
																	$sqlr="UPDATE pptocuentaspptoinicial set ingresos=ingresos+$aviinteres WHERE cuenta='$row[6]' and vigencia='$vigusu'";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia) values('$row[6]', '$concecc','$aviinteres','$vigusu')";
																	mysql_query($sqlr,$linkbd);	
																	if($row[6]!="")
																	{
																		//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[6]', '$_POST[tercero]','RECIBO DE CAJA',$aviinteres,0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concecc',1,'','','$fechaf')";
																		//mysql_query($sqlr,$linkbd); 		
																	}
																}
															}
														}
													}
												}break;
											}
										}
									}
								}
							}
							else
							{
								echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo de Caja para esta Liquidacion <img src='imagenes/alert.png'></center></td></tr></table>";
							}
			}break; 
			case 3: //**************OTROS RECAUDOS
			$sqlr="delete from pptorecibocajappto where idrecibo=$_POST[idcomp]";
			//echo $sqlr;		
			mysql_query($sqlr,$linkbd);
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
			//***busca el consecutivo del comprobante contable
			$consec=$_POST[idcomp];
			//***cabecera comprobante
			//$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,5,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'$_POST[estadoc]')";
  

			//**********************CREANDO COMPROBANTE CONTABLE ********************************	 		 
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
						$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
						$re=mysql_query($sq,$linkbd);
						while($ro=mysql_fetch_assoc($re))
						{
							$_POST[fechacausa]=$ro["fechainicial"];
						}
						$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
		
						$resc=mysql_query($sqlrc,$linkbd);	  
						//echo "concc: $sqlrc <br>";	      
						while($rowc=mysql_fetch_row($resc))
						{
							$porce=$rowi[5];
							if($rowc[7]=='S')
							{				 
								$vi=$_POST[dvalores][$x];
								$valordeb=0;
								if($rowc[3]=='N')
								{
									//*****inserta del concepto contable  
									//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
									//$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$rowi[6]."','".$_POST[tercero]."','RECIBO DE CAJA PREDIAL',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',16,'$concec',1,'','','$fechaf')";
									//mysql_query($sqlr,$linkbd); 				
								}
			
							}
						}
					}
				}
			}			 	 
			//*************** fin de cobro de recibo
			//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
			for($x=0;$x<count($_POST[dcoding]);$x++)
			{
				//***** BUSQUEDA INGRESO ********
				$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
				$resi=mysql_query($sqlri,$linkbd);
				//	echo "$sqlri <br>";	    
				while($rowi=mysql_fetch_row($resi))
				{
					if($rowi[6]!="")
					{
						//**** busqueda cuenta presupuestal*****
						$porce=$rowi[5];
						$valorcred=$_POST[dvalores][$x]*($porce/100);
						$valordeb=0;
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
						$sql="SELECT terceros FROM tesoingresos WHERE codigo=".$_POST[dcoding][$x] ;
						$res=mysql_query($sql,$linkbd);
						$row= mysql_fetch_row($res);	
						
						if($row[0]!="R"){
							$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$consec,'$vi','$vigusu','N','".$_POST[dcoding][$x]."')";
							mysql_query($sqlr,$linkbd);	
						}else{
							$sqlr="insert into pptorecibocajappto (cuenta,idrecibo,valor,vigencia,tipo,ingreso) values('$rowi[6]',$consec,'$vi','$vigusu','R','".$_POST[dcoding][$x]."')";
							mysql_query($sqlr,$linkbd);	
						}	
	  
					}
				}
			}	
			echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado el Recibo de caja con Exito<img src='imagenes/confirm.png'><script></script></center></td></tr></table>";
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
</form>
 </td></tr>
</table>
</body>
</html>