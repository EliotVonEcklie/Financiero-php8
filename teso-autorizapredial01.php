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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
   		<script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
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
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
//************* genera reporte ************
//***************************************
function guardar()
{
 if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
}
function pdf()
{
document.form2.action="pdfautorizacionl.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function buscar()
 {
	// alert("dsdd");
 document.form2.buscav.value='1';
 document.form2.submit();
 }
function buscarc()
 {
// alert("dsdd");
 document.form2.brc.value='1';
 document.form2.submit();
 }
function buscavigencias(objeto)
 {
	
 //document.form2.buscarvig.value='1';
vvigencias=document.getElementsByName('dselvigencias[]');
vtotalpred=document.getElementsByName("dpredial[]"); 	
vtotaliqui=document.getElementsByName("dhavaluos[]"); 	
vtotalbomb=document.getElementsByName("dimpuesto1[]"); 	
vtotalmedio=document.getElementsByName("dimpuesto2[]"); 	
vtotalintp=document.getElementsByName("dipredial[]"); 	
vtotalintb=document.getElementsByName("dinteres1[]"); 	
vtotalintma=document.getElementsByName("dinteres2[]"); 	
vtotaldes=document.getElementsByName("ddescuentos[]"); 	
sumar=0;
sumarp=0;
sumarb=0;
sumarma=0;
sumarint=0;
sumarintp=0;
sumarintb=0;
sumarintma=0;
sumardes=0;
for(x=0;x<vvigencias.length;x++)
 {
	 if(vvigencias.item(x).checked)
	 {
	 sumar=sumar+parseFloat(vtotaliqui.item(x).value);
	 sumarp=sumarp+parseFloat(vtotalpred.item(x).value);
	 sumarb=sumarb+parseFloat(vtotalbomb.item(x).value);
	 sumarma=sumarma+parseFloat(vtotalmedio.item(x).value);
	 sumarint=sumarint+parseFloat(vtotalintp.item(x).value)+parseFloat(vtotalintb.item(x).value)+parseFloat(vtotalintma.item(x).value);
	 sumarintp=sumarintp+parseFloat(vtotalintp.item(x).value);
	 sumarintb=sumarintb+parseFloat(vtotalintb.item(x).value);
	 sumarintma=sumarintma+parseFloat(vtotalintma.item(x).value);	 	 
	 sumardes=sumardes+parseFloat(vtotaldes.item(x).value);
	 }
 }

document.form2.totliquida.value=sumar;
document.form2.totliquida2.value=sumar;
document.form2.totpredial.value=sumarp;
document.form2.totbomb.value=sumarb;
document.form2.totamb.value=sumarma;
document.form2.totint.value=sumarint;
document.form2.intpredial.value=sumarintp;
document.form2.intbomb.value=sumarintb;
document.form2.intamb.value=sumarintma;
document.form2.totdesc.value=sumardes;
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
          		<td colspan="3" class="cinta"><a href="teso-autorizapredial.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="teso-buscaautorizapredial.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><?php if($_POST[oculto]==2) {echo "<a href='#' onClick='pdf()' class='mgbt'><img src='imagenes/print.png' title='Imprimir' /></a>";}else{echo "<a class='mgbt'><img src='imagenes/print_off.png'/></a>";}?></td>
        	</tr>		  
        </table>
		<?php
			$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu;
	  		//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
			//if(!$_POST[oculto])
			//{
				$fec=date("d/m/Y");
				//$_POST[fecha]=$fec; 		 		  			 
				$_POST[vigencia]=$vigusu; 		
				$check1="checked";
				$sqlr="select *from tesotasainteres where vigencia=".$vigusu;
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$tasam=array();
				$tasam[0]=$r[6];									
				$tasam[1]=$r[7];
				$tasam[2]=$r[8];
				$tasam[3]=$r[9];
				$tasamoratoria[0]=0;
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechav],$fecha);
				if($fecha[2]<=3){$tasamoratoria[0]=$tasam[0];}
				else
				{
					if($fecha[2]<=6){$tasamoratoria[0]=$tasam[1];}
					else
					{
						if($fecha[2]<=6){$tasamoratoria[0]=$tasam[2];}
						else{$tasamoratoria[0]=$tasam[3];}						
					 }
				}
				$_POST[tasamora]=$tasamoratoria[0];   
				$_POST[tasa]=0;
				$_POST[predial]=0;
				$_POST[descuento]=0;
				//***** BUSCAR FECHAS DE INCENTIVOS
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechav],$fecha);
				$fechaactual=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
				ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fechav],$fecha);
				$fechaactual=$fecha[1]."-".$fecha[2]."-".$fecha[3];		
				$vigproy=$fecha[1];	
				//$vigproy=$fecha[3];
				//$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigusu." and ingreso='01' and estado='S'";
				$sqlr="select *from tesodescuentoincentivo where vigencia=".$vigproy." and ingreso='01' and estado='S'";
				//echo $sqlr;
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res))
				{	
					if($r[7]<=$fechaactual && $fechaactual <= $r[8]){$fdescuento=$r[2];$_POST[descuento]=$r[2];}
				  	if($fechaactual>$r[9] && $fechaactual <= $r[10]){$fdescuento=$r[2];$_POST[descuento]=$r[3];}
				  	if($fechaactual>$r[11] && $fechaactual <= $r[12]){$fdescuento=$r[2];$_POST[descuento]=$r[4];}  
				}
				//*************cuenta caja
				$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[1];}
				/*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='8' and EXTRACT(YEAR FROM fecha)=".$vigusu;
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
				$consec+=1;
				$_POST[idcomp]=$consec;	
 		 		$fec=date("d/m/Y");
		 		$_POST[valor]=0;		 */
			//}
			switch($_POST[tabgroup1])
			{
				case 1:$check1='checked';break;
				case 2:$check2='checked';break;
				case 3:$check3='checked';
			}
		?>
 		<form name="form2" method="post" action="">
  		<?php
			$sqlr="Select max(id_auto) from tesoautorizapredial";
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
  			$_POST[numpredial]=$row[0]+1;  
			if($_POST[buscav]=='1')
 			{
			 	$_POST[dcuentas]=array();
			 	$_POST[dncuentas]=array();
				$_POST[dtcuentas]=array();		 
			 	$_POST[dvalores]=array();
	 			$sqlr="select *from tesopredios where cedulacatastral=".$_POST[codcat]."  and tesopredios.ord='".$_POST[ord]."'  and tesopredios.tot='".$_POST[tot]."' ";
	 			$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	  			{
		  			//$_POST[vigencia]=$row[0];
					$_POST[catastral]=$row[0];
					$_POST[ntercero]=$row[6];
					$_POST[tercero]=$row[5];
					$_POST[direccion]=$row[7];
					$_POST[ha]=$row[8];
					$_POST[mt2]=$row[9];
					$_POST[areac]=$row[10];
					$_POST[avaluo]=number_format($row[11],2);
					$_POST[avaluo2]=number_format($row[11],2);
					$_POST[vavaluo]=$row[11];
					$_POST[tipop]=$row[14];
					$_POST[ord]=$row[1];
					$_POST[tot]=$row[2];
		  			if($_POST[tipop]=='urbano'){$_POST[estrato]=$row[15];$tipopp=$row[15];}
					else{$_POST[rangos]=$row[15];$tipopp=$row[15];}
					// $_POST[dcuentas][]=$_POST[estrato];		
				 	$_POST[dtcuentas][]=$row[1];		 
				   	$_POST[dvalores][]=$row[5];
				   	$_POST[buscav]="";
		 			$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$_POST[tipop]' and estratos=$tipopp";
		 			$res2=mysql_query($sqlr2,$linkbd);
	 				while($row2=mysql_fetch_row($res2))
			  		{
			   			$_POST[tasa]=$row2[5];
			   			$_POST[predial]=($row2[5]/1000)*$_POST[vavaluo];
			   			$_POST[predial]=number_format($_POST[predial],2);
			  		}
	  			}
  			}
	  		if($_POST[brc]=='1' and $_POST[recibo]!='')
	   		{
				$sqlr="select tesoreciboscaja.id_recibos,tesorecaudos.concepto from tesoreciboscaja,tesorecaudos where tesoreciboscaja.id_recibos= '$_POST[recibo]' and tesoreciboscaja.id_recaudo=tesorecaudos.id_recaudo and tesoreciboscaja.tipo='3' and tesoreciboscaja.estado='S'";
				$_POST[detallerc]='';
		 		$_POST[recibo]='';
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)) {$_POST[recibo]=$row[0];$_POST[detallerc]=$row[1];		  }	  
				if ($_POST[detallerc]=='')
		 		{
		 		?><script>
          			alert("Recibo de Caja Incorrecto");
		  			document.form2.recibo.focus();
		  			document.form2.recibo.select();
          		</script><?php 
		  		}
	   		}
	  	?>
		<table class="inicio" align="center" >
      		<tr>
       	 		<td class="titulos" colspan="6">Autorizacion Liquidacion Predial</td>
                <td class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      		</tr>
     		<tr>
       			<td class="saludo1">No Autorizacion:</td>
       			<td width="52"><input name="numpredial" type="text" value="<?php echo $_POST[numpredial]?>"  size="8" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
                <td class="saludo1">Fecha:</td><td><input name="fecha" type="date" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" ></td>
                <td class="saludo1">Vigencia:</td>
                <td><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly></td>
       		</tr>
	  		<tr>
            	<td class="saludo1">Proyeccion Liquidacion:</td>
                <td><input name="fechav" type="date" value="<?php echo $_POST[fechav]?>" maxlength="10" size="10"></td>
                <td colspan="2"><input type="text" name="detallerc" size="50" value='<?php echo $_POST[detallerc] ?>'></td> 
                <td  class="saludo1">Codigo Catastral:</td>
          		<td><input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" ><input id="ord" type="text" name="ord" size="3"  value="<?php echo $_POST[ord]?>" readonly><input id="tot" type="text" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly><input type="hidden" value="0" name="bt"><a href="#" onClick="mypop=window.open('catastral-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a><input type="hidden" name="chacuerdo" value="1"><input type="hidden" value="1" name="oculto"> <input type="hidden" value="<?php echo $_POST[buscav]?>" name="buscav"><input type="button" name="buscarb" id="buscarb" value="   Buscar   " onClick="buscar()" ></td>
        	</tr>     
			<tr>
				<td class="saludo1">Descripcion Pago:</td>
                <td><input type="text" name="descripcion" value="<?php echo $_POST[descripcion] ?>" size="40"></td>
				<td class="saludo1">Autoriza Pago:</td>
                <td><input type="text" name="autoriza" value="<?php echo $_POST[autoriza] ?>" size="40"></td>
				<td class="saludo1">Valor Pago:</td>
                <td><input type="text" name="valor" value="<?php echo $_POST[valor] ?>" size="10"></td>
			</tr>	  
		</table>
  		<table class="inicio">
	  		<tr><td class="titulos" colspan="8">Informacion Predio</td></tr>
			<tr>
				<td width="119" class="saludo1">Codigo Catastral:</td>
	  			<td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"><input name="catastral" type="text" id="catastral" onBlur="buscater(event)"  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[catastral]?>" size="20" readonly></td>			   
				<td width="82" class="saludo1">Avaluo:</td>
	  			<td colspan="5"><input name="avaluo" type="text" id="avaluo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[avaluo]?>" size="20" readonly></td>
			</tr>
      		<tr> 
            	<td width="82" class="saludo1">Documento:</td>
	  			<td><input name="tercero" type="text" id="tercero" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[tercero]?>" size="20" readonly></td>
	  			<td width="119" class="saludo1">Propietario:</td>
	  			<td width="202" colspan="5" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="ntercero" type="text" id="propietario" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ntercero]?>" size="76" readonly></td>		   
			</tr>
      		<tr>
	  			<td width="119" class="saludo1">Direccion:</td>
	  			<td width="202" ><input type="hidden" value="<?php echo $_POST[nbanco]?>" name="nbanco"> <input name="direccion" type="text" id="direccion" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[direccion]?>" size="40" readonly></td>		   
		 		<td width="82" class="saludo1">Ha:</td>
	  			<td width="124"><input name="ha" type="text" id="ha" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ha]?>" size="6" readonly></td>
 				<td width="72" class="saludo1">Mt2:</td>
            	<td width="144"><input name="mt2" type="text" id="mt2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[mt2]?>" size="6" readonly></td>
              	<td width="76" class="saludo1">Area Cons:</td>
	  			<td width="206"><input name="areac" type="text" id="areac" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[areac]?>" size="6" readonly></td>
      		</tr>
	  		<tr>
	     		<td width="119" class="saludo1">Tipo:</td>
                <td width="202">
                	<select name="tipop" onChange="validar();" disabled>
       					<option value="">Seleccione ...</option>
				  		<option value="urbano" <?php if($_POST[tipop]=='urbano') echo "SELECTED"?>>Urbano</option>
                        <option value="rural" <?php if($_POST[tipop]=='rural') echo "SELECTED"?>>Rural</option>
				  	</select>
         		</td>
         		<?php
		 			if($_POST[tipop]=='urbano')
		 			{
		  		?> 
        				<td class="saludo1">Estratos:</td>
                    	<td>
                            <select name="estrato"  disabled>
                                <option value="">Seleccione ...</option>
                                <?php
                                    $sqlr="select *from estratos where estado='S'";
                                    $res=mysql_query($sqlr,$linkbd);
                                    while ($row =mysql_fetch_row($res)) 
                                    {
                                        echo "<option value=$row[0] ";
                                        $i=$row[0];
                                        if($i==$_POST[estrato]){echo "SELECTED"; $_POST[nestrato]=$row[1];}
                                        echo ">".$row[1]."</option>";	 	 
                                    }	 	
                                ?>            
                            </select>  
                            <input type="hidden" value="<?php echo $_POST[nestrato]?>" name="nestrato">
            			</td>  
        		<?php
		 			}
		 			else
		  			{
				?>  
						<td class="saludo1">Rango Avaluo:</td>
            			<td>
            				<select name="rangos" >
       							<option value="">Seleccione ...</option>
            					<?php
									$sqlr="select *from rangoavaluos where estado='S'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
				    				{
										echo "<option value=$row[0] ";
										$i=$row[0];
					 					if($i==$_POST[rangos]){echo "SELECTED";$_POST[nrango]=$row[1]." - ".$row[2]." SMMLV";}
					  					echo ">Entre ".$row[1]." - ".$row[2]." SMMLV</option>";	 	 
									}	 	
								?>            
							</select>
            				<input type="hidden" value="<?php echo $_POST[nrango]?>" name="nrango">            
                            <input type="hidden" value="0" name="agregadet"></td>
				<?php
		  			}
		  		?> 
        	</tr> 
		</table>
	<div class="subpantallac" style="height:40.5%; width:99.6%;">
      <table class="iniciop">
	   	   <tr>
	   	     <td colspan="12" class="titulos">Periodos Sin Pagar  </td>
	   	   </tr>                  
		<tr>
		  <td class="titulos2">Vigencia</td>
		  <td class="titulos2">Codigo Catastral</td>
   		  
          <td class="titulos2">Dias Mora</td>
		  <td width="3%" class="titulos2">Sel
				<input type='hidden' name='buscarvig' id='buscarvig'> </td></tr>
            	<?php			
					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fechav],$fecha);
					$fechaactual=$fecha[1]."-".$fecha[2]."-".$fecha[3];		
					$vigproy=$fecha[1];			
			  		$tasaintdiaria=(pow((1+$_POST[tasamora]/100),(1/365))-1);
			  		$cuentavigencias=0;
			  		$tdescuentos=0;
					$sqlr="Select *from tesoprediosavaluos,tesopredios where tesoprediosavaluos.codigocatastral=$_POST[catastral] and   tesoprediosavaluos.estado='S' and tesoprediosavaluos.pago='N' and tesoprediosavaluos.codigocatastral=tesopredios.cedulacatastral and tesoprediosavaluos.ord='".$_POST[ord]."'  and tesoprediosavaluos.tot='".$_POST[tot]."' and tesopredios.ord='".$_POST[ord]."'  and tesopredios.tot='".$_POST[tot]."' and tesoprediosavaluos.vigencia<='$vigproy' order by tesoprediosavaluos.vigencia ASC";		
					$res=mysql_query($sqlr,$linkbd);
	//				$cuentavigencias = mysql_num_rows($res);
					$cuentavigencias =count($_POST[dselvigencias]);
					while($r=mysql_fetch_row($res))
					{		 
						$cuentavigencias =count($_POST[dselvigencias]);
						//$sqlr2="select *from tesotarifaspredial where vigencia='".$vigusu."' and tipo='$r[19]' and estratos=$r[20]";
						$sqlr2="select *from tesotarifaspredial where vigencia='".$r[0]."' and tipo='$r[21]' and estratos=$r[22]";
						$res2=mysql_query($sqlr2,$linkbd);
	 					$row2=mysql_fetch_row($res2);
						$base=$r[2];
						$valorperiodo=$base*($row2[5]/1000);
						$tasav=$row2[5];
						$predial=$base*($row2[5]/1000);
						$valoringresos=0;
						$sidescuentos=0;
						//****buscar en el concepto del ingreso *******
						$intereses=array();
						$valoringreso=array();
						$in=0;
						if($cuentavigencias>1)
			 			{
							if($vigproy==$r[0] && ($_POST[descuento]>0  or $condes==1))
				 			{
				 				$diasd=0;
				 				$totalintereses=0; 
			  	 				$sidescuentos=0;
				  			}
				  			else
				   			{
								//  echo "<br>ini:".$r[0]." a". $_POST[fechav]." fin:".$fecha[2]."-".$fecha[1]."-".$fecha[3].''.$fechaactual;
								$fechaini=mktime(0,0,0,1,1,$r[0]);
								$fechafin=mktime(0,0,0,$fecha[2],$fecha[3],$fecha[1]);
								$difecha=$fechafin-$fechaini;
								$diasd=$difecha/(24*60*60);
								$diasd=floor($diasd);
			 					$totalintereses=0; 
				   			}
					 	}
			 			else
			 			{ //********* si solo debe la actual vigencia
			  				$diasd=0;
			  				$totalintereses=0; 
			   				$tdescuentos=0;
			  				$sidescuentos=1;
			 				// echo "Aqui";
			   				if($vigproy==$r[0] && ($_POST[descuento]>0  or $condes==1))
				 			{
								$pdescuento=$_POST[descuento]/100; 					
								$tdescuentos+=ceil(($valorperiodo)*$pdescuento);
				 			}
			 			}
						$sqlr2="select *from tesoingresos_det where codigo='01' and modulo='4' and  estado='S' and vigencia='$vigusu' order by concepto";
						//echo $sqlr2;
						$res3=mysql_query($sqlr2,$linkbd);
						while($r3=mysql_fetch_row($res3))
						{
							if($r3[5]>0 && $r3[5]<100)
					 		{
								//	 echo $valoringresos."-";
					  			if($r3[2]=='03')
					   			{
								  	$valoringreso[0]=ceil($valorperiodo*($r3[5]/100));
								  	$valoringresos+=ceil($valorperiodo*($r3[5]/100));
								  	$intereses[0]=ceil($valoringreso[0]*(pow(1+$tasaintdiaria,$diasd)-1));
								  	$totalintereses+=$intereses[0];						
					    		}
					    		if($r3[2]=='02')
					    		{
					 	 			$valoringreso[1]=ceil($valorperiodo*($r3[5]/100));
					  				$valoringresos+=ceil($valorperiodo*($r3[5]/100));
					  				$intereses[1]=ceil($valoringreso[1]*(pow(1+$tasaintdiaria,$diasd)-1));
					  				$totalintereses+=$intereses[1];						 
					    		}	
					  			if($sidescuentos==1 && '03'==$r3[2]){$tdescuentos+=ceil($valoringreso[0]*$pdescuento);}			
					 		}
						}
						$valorperiodo+=$valoringresos;		
						$ipredial=ceil($predial*(pow(1+$tasaintdiaria,$diasd)-1));
						$totalpredial=ceil($valorperiodo+$totalintereses+$ipredial);
						$totalpagar=ceil($totalpredial- ceil($tdescuentos));
						$ch=esta_en_array($_POST[dselvigencias], $r[0]);
						$chk="";
						if($ch==1){$chk="checked";}
						//*************	
						echo "<tr><td class='saludo1'><input name='dvigencias[]' value='".$r[0]."' type='text' size='4' readonly></td><td class='saludo1'><input name='dcodcatas[]' value='".$r[1]."' type='text' size='16' readonly><input name='dvaloravaluo[]' value='".$base."' type='hidden' ><input name='dtasavig[]' value='".$tasav."' type='hidden' ></td><td class='saludo1'><input type='text' name='dias[]' value='$diasd' size='4' readonly></td><td class='saludo1'><input type='checkbox' name='dselvigencias[]' value='$r[0]' onClick='buscavigencias(this)' $chk></td></tr>";
						$_POST[totalc]=$_POST[totalc]+$_POST[davaluos][$x];
		 				$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 				//$ageliqui=$ageliqui." ".$_POST[dselvigencias][$x];
		 			}
 					$resultado = convertir($_POST[totliquida]);
					$_POST[letras]=$resultado." PESOS M/CTE";	
				?> 
      		</table>
      	</div>
	<?php
	if ($_POST[oculto]=='2')
	 {
		//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$linkbd=conectar_bd();
		$sqlr="insert into tesoautorizapredial (codcatastral,fecha_auto,fecha_pago,valor_pago,detalle_pago,autoriza,liquidacion,recibocaja,elabora,estado,ord,tot) values ('$_POST[codcat]','$_POST[fecha]','$_POST[fechav]',$_POST[valor],'$_POST[descripcion]','$_POST[autoriza]',0,0,'".$_SESSION[cedulausu]."','S','$_POST[ord]','$_POST[tot]')";
		if(!mysql_query($sqlr,$linkbd))
		 {
		 echo "<table class='inicio'><tr><td class='saludo1'>No Se ha podido Generar la Autorizacion <img src='imagenes\alert.png'>".mysql_error($linkbd)."</td></tr></table>";  	
		 
		 	 }
		  else
	   		{
				$npaz=mysql_insert_id();
		 		echo "<table class='inicio'><tr><td class='saludo1'>Se ha  Generado La Autorizacion N° $npaz <img src='imagenes\confirm.png'></td></tr></table>";			
				$idps=mysql_insert_id();
				$_POST[numpredial]=$idps;
				for($x=0;$x<count($_POST[dselvigencias]);$x++)
				{
			 	$sqlr="insert into tesoautorizapredial_det (id_auto,codcatastral,vigencia,estado) values ($npaz,'$_POST[codcat]','".$_POST[dselvigencias][$x]."','S')";
				mysql_query($sqlr,$linkbd);
				//echo $sqlr;
				}
			}
	 }
    ?>
</form>
</body>
</html>