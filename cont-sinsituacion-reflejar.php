<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	$linkbd=conectar_bd();
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Contabilidad</title>

<script>
	function validar(){
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
		
	function guardar(){
		ingresos2=document.getElementsByName('dcoding[]');
		if (document.form2.fecha.value!='' && ingresos2.length>0){
			//if (confirm("Esta Seguro de Guardar")){
  				//document.form2.oculto.value=2;
  				//document.form2.submit();
  				
  			//}
  			despliegamodalm('visible','4','Esta Seguro de Guardar','1');
  		}
  		else{
  			//alert('Faltan datos para completar el registro');
	  		//document.form2.fecha.focus();
  			//document.form2.fecha.select();
  			despliegamodalm('visible','2','Faltan datos para completar el registro');
  		}
	}

	function pdf(){
		document.form2.action="teso-pdfssf.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}

	function adelante(){
		//document.form2.oculto.value=2;
		if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value)){
			document.form2.oculto.value=1;
			//document.form2.agregadet.value='';
			//document.form2.elimina.value='';
			document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
			document.form2.action="cont-sinsituacion-reflejar.php";
			document.form2.submit();
		}
	}

	function atrasc(){
		//document.form2.oculto.value=2;
		if(document.form2.idcomp.value>1){
			document.form2.oculto.value=1;
			//document.form2.agregadet.value='';
			//document.form2.elimina.value='';
			document.form2.idcomp.value=document.form2.idcomp.value-1;
			document.form2.action="cont-sinsituacion-reflejar.php";
			document.form2.submit();
 		}
	}
</script>

<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
		  <a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
		  <a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar"/></a> 
		  <a href="cont-buscasinsituacion-reflejar.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
		  <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
		  <a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
		  <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" title="Reflejar"/> 
		  <a href="#"  class="mgbt"<?php if($_POST[oculto]==2) { ?> onClick="pdf()"  <?php } ?>> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a> 
		  <a href="cont-reflejardocs.php" class="mgbt"><img src="imagenes/iratras.png" alt="nueva ventana" title="Atras"></a>
	  </td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
	//$vigencia=date(Y);
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);

	$linkbd=conectar_bd();
	$sqlr="select * from admbloqueoanio";
	$res=mysql_query($sqlr,$linkbd);
	$_POST[anio]=array();
	$_POST[bloqueo]=array();
	while ($row =mysql_fetch_row($res)){
	 	$_POST[anio][]=$row[0];
	 	$_POST[bloqueo][]=$row[1];
	}


?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if($_GET[idr]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idr];</script>";}
if(!$_POST[oculto]){
	$sqlr="select VALOR_INICIAL from dominios where dominio='CUENTA_CAJA' where VALOR_FINAL='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)){
	 	$_POST[cuentacaja]=$row[0];
	}

	$sqlr="select * from tesossfingreso_cab ORDER BY id_recaudo DESC";
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[maximo]=$r[0];

	if ($_POST[codrec]!="" || $_GET[idr]!=""){
		if($_POST[codrec]!=""){
			$sqlr="select * from tesossfingreso_cab WHERE ID_RECAUDO='$_POST[codrec]'";
		}
		else{
			$sqlr="select * from tesossfingreso_cab WHERE ID_RECAUDO='$_GET[idr]'";
		}
	}
	else{
		$sqlr="select * from tesossfingreso_cab ORDER BY id_recaudo DESC";
	}
	$res=mysql_query($sqlr,$linkbd);
	$r=mysql_fetch_row($res);
	$_POST[ncomp]=$r[0];
	$_POST[idcomp]=$r[0];

	$check1="checked";
	$fec=date("d/m/Y");
	//$_POST[vigencia]=$vigusu;
}

$sqlr="select * from tesossfingreso_cab WHERE ID_RECAUDO='$_POST[idcomp]'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res)){
	$_POST[idcomp]=$row[0];
	$_POST[fecha]=$row[2];
	$_POST[vigencia]=$row[3];
	$_POST[concepto]=$row[4];			 
	$_POST[tercero]=$row[5];	
	$_POST[ntercero]=buscatercero($row[5]);		 
	$_POST[cc]=$row[6];			 	 	 
	$_POST[valortotal]=$row[7];			
	$_POST[estado]=$row[8];			 	 	 	  	 	 	 
	if($_POST[estado]=='S')
		$_POST[estadoc]="ACTIVO";
	if($_POST[estado]=='N')
		$_POST[estadoc]="ANULADO";
}
$sqlr="select * from tesossfingreso_det WHERE ID_RECAUDO='$_POST[idcomp]'";
$res=mysql_query($sqlr,$linkbd);
$_POST[dcoding]=array();
$_POST[dncoding]=array();
$_POST[dvalores]=array();				
while($r=mysql_fetch_row($res)){
	$_POST[dcoding][]=$r[2];
	$codssf=buscacodssf($r[2],$_POST[vigencia]);
	//	 $nomcodssf= buscacodssfnom($codssf);
	$_POST[dncoding][]=buscaingresossf($r[2]);
	$_POST[dvalores][]=$r[3];
}

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
<table class="inicio" align="center" >
	<tr >
    	<td class="titulos" colspan="6"> Ingresos Sin Situacion de Fondos - SSF</td>
        <td style="width:7%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
   	</tr>
    <tr  >
    	<td style="width:2.5cm"  class="saludo1" >Numero Ingreso:</td>
        <td style="width:10%">
           	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
        	<input name="idcomp" type="text" style="width:60%" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  readonly>
            <a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
      	</td>
	  	<td style="width:2.5cm" class="saludo1">Fecha:</td>
        <td style="width:10%">
        	<input name="fecha" type="text" style="width:100%; text-align:center;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)" readonly > 
      	</td>
        <td style="width:2.5cm" class="saludo1">Vigencia:</td>
		<td style="width:40%">
        	<input type="text" id="vigencia" name="vigencia" style="width:20%" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly> 
            <?php 
	            if($_POST[estado]=="S"){
				    $valuees="ACTIVO";
				    $stylest="width:20%; background-color:#0CD02A; color:white; text-align:center;";
				}else if($_POST[estado]=="N"){
				    $valuees="ANULADO";
				    $stylest="width:20%; background-color:#FF0000; color:white; text-align:center;";
				}else if($_POST[estado]=="P"){
				    $valuees="PAGO";
				    $stylest="width:20%; background-color:#0404B4; color:white; text-align:center;";
				}

				echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
            ?>    
       	</td>
   	</tr>       
    <tr>
    	<td  class="saludo1">Concepto Ingreso:</td>
        <td colspan="5" >
        	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly>
       	</td>
  	</tr>  
   	<tr>
       	<td  class="saludo1">NIT: </td>
       	<td>
        	<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:100%" onKeyUp="return tabular(event,this)" readonly>
		</td>
		<td class="saludo1">Contribuyente:</td>
	  	<td colspan="3"  >
        	<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" onKeyUp="return tabular(event,this) "  readonly>
            <input type="hidden" value="0" name="bt"><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
            <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	    	<input type="hidden" value="1" name="oculto">
	    	<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
	    	<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
       	</td>
  	</tr>
	<tr>
        <td class="saludo1">Centro Costo:</td>
	  	<td>
			<select name="cc" onKeyUp="return tabular(event,this)">
				<?php
				$linkbd=conectar_bd();
				$sqlr="select *from centrocosto where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){
					if($row[0]==$_POST[cc]){
						echo "<option value=$row[0] SELECTED>".$row[0]." - ".$row[1]."</option>";
					}
				}	 	
				?>
   			</select>
	 	</td>
        <td class="saludo1">Valor:</td>
       	<td >
            	<input type="text" id="valor" name="valor" value="<?php echo number_format($_POST[valortotal],2,',','.') ?>" style="width:100%; text-align:right;" onKeyUp="return tabular(event,this)" readonly >
		</td>
 	</tr>
</table>
<div class="subpantalla">
	<table class="inicio">
		<tr>
   	    	<td colspan="3" class="titulos">Detalle  Ingresos Sin Situacion de Fondos</td>
      	</tr>                  
		<tr>
        	<td class="titulos2">Codigo</td>
            <td class="titulos2">Ingreso</td>
            <td class="titulos2">Valor</td>
       	</tr>
		<?php 		
	  	$_POST[totalc]=0;
		$iter='saludo1a';
		$iter2='saludo2';
		for ($x=0;$x<count($_POST[dcoding]);$x++){		 
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
				<td style='width:10%'>
					<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='hidden'>".$_POST[dcoding][$x]."
				</td>
				<td style='width:70%'>
					<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='hidden'>".$_POST[dncoding][$x]."
				</td>
				<td align='right'>
					<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='hidden'>".number_format($_POST[dvalores][$x],2,',','.')."
				</td>
			</tr>";
		 	$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 	$_POST[totalcf]=number_format($_POST[totalc],2);
		 	$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;	
		}
 		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." Pesos";
		echo "<tr class='titulos2'>
			<td></td>
			<td>Total</td>
			<td align='right'>
				<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
				<input name='totalc' type='hidden' value='$_POST[totalc]'>".number_format($_POST[totalc],2,',','.')."
			</td>
		</tr>
		<tr class='titulos2'>
			<td>Son:</td>
			<td colspan='5' >
				<input name='letras' type='hidden' value='$_POST[letras]'>".$_POST[letras]."
			</td>
		</tr>";
		?> 
	</table>
</div>
	  <?php
		if($_POST[oculto]=='2')
		{
			$linkbd=conectar_bd();
		 	//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$anioact=split("-", $_POST[fecha]);
			$_POST[anioact]=$anioact[0];
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
			if($bloquear=="N"){
				$fechaf=$_POST[fecha];
				//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
				//***busca el consecutivo del comprobante contable
				$consec=$_POST[idcomp];
				$sqlr="delete from comprobante_cab where numerotipo=$consec and tipo_comp=20";
				mysql_query($sqlr,$linkbd);	
				$sqlr="delete from comprobante_det where numerotipo=$consec and tipo_comp=20";
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
				if($_POST[estado]=='N')
				{
					$estad='0';
				}
				else
				{
					$estad='1';
				}
		 		$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,20,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'$estad')";
		
				mysql_query($sqlr,$linkbd);	
				$idcomp=mysql_insert_id();
				echo "<input type='hidden' name='ncomp' value='$idcomp'>";
				$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($consec,20,'$fechaf','INGRESOS SSF $_POST[concepto]',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
		
		  		mysql_query($sqlr,$linkbd);
				//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
				for($x=0;$x<count($_POST[dcoding]);$x++)
				{
					 //***** BUSQUEDA INGRESO ********
					$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$_POST[vigencia]' GROUP BY conceing";
				 	$res2=mysql_query($sqlri,$linkbd);
					//	echo "$sqlri <br>";	    
					while($row2=mysql_fetch_row($res2))
					{
					    //**** busqueda concepto contable*****
						$sq="select fechainicial from conceptoscontables_det where codigo='".$row2[2]."' and modulo='4' and tipo='IS' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
						$re=mysql_query($sq,$linkbd);
						while($ro=mysql_fetch_assoc($re))
						{
							$_POST[fechacausa]=$ro["fechainicial"];
						}
						$sqlri="Select * from conceptoscontables_det where codigo='".$row2[2]."' and modulo=4 and tipo='IS' and fechainicial='".$_POST[fechacausa]."'";
					 	$resi=mysql_query($sqlri,$linkbd);
						//	echo "$sqlri <br>";	    
						while($rowi=mysql_fetch_row($resi))
					 	{
							if($rowi[7]=='S')
							{
								$valorcred=$_POST[dvalores][$x];
								$valordeb=0;
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('20 $consec','".$rowi[4]."','".$_POST[tercero]."','".$_POST[cc]."','Ingreso sin Situacion de Fondos ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
								//echo $sqlr;
					            mysql_query($sqlr,$linkbd);
				//					echo "<br>".$sqlr;
							}
							if($rowi[6]=='S')
							{
							  	$valordeb=$_POST[dvalores][$x];
								$valorcred=0;				   
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('20 $consec','".$rowi[4]."','".$_POST[tercero]."','".$_POST[cc]."','Ingreso sin Situacion de Fondos ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
								//echo $sqlr;
								mysql_query($sqlr,$linkbd);
					//			echo "<br>".$sqlr;
								$vi=$_POST[dvalores][$x];
							}
					 	}
			//			$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta =".$rowi[5]."";
						//mysql_query($sqlr,$linkbd);	
							 //****creacion documento presupuesto ingresos
				//		  $sqlr="insert into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[5]',$consec,$vi,'".$_SESSION[vigencia]."')";
			  			 // mysql_query($sqlr,$linkbd);				  
					}
				}	
				//************ insercion de cabecera recaudos ************
				$sqlr="insert into tesossfingreso_cab (id_recaudo,idcomp,fecha,vigencia,concepto,tercero,cc,valortotal,estado) values($consec,$idcomp,'$fechaf','".$_POST[vigencia]."','".strtoupper($_POST[concepto])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','$_POST[estado]')";	  
				mysql_query($sqlr,$linkbd);
				$idrec=$consec;
				//echo "Conc: $sqlr <br>";
				//************** insercion de consignaciones **************
				for($x=0;$x<count($_POST[dcoding]);$x++)
		 		{
					$sqlr="insert into tesossfingreso_det (id_recaudo,ingreso,valor,estado) values($consec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'$_POST[estado]')";	
					if (!mysql_query($sqlr,$linkbd))
					{
		 				echo "<table ><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	//	 				$e =mysql_error($respquery);
		 				echo "Ocurrió el siguiente problema:<br>";
	  	 				//echo htmlentities($e['message']);
	  	 				echo "<pre>";
	     				///echo htmlentities($e['sqltext']);
	    				// printf("\n%".($e['offset']+1)."s", "^");
	     				echo "</pre></center></td></tr></table>";
					}
	  				else
	  		 		{
						$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia='$_POST[vigencia]'";
		 				$resi=mysql_query($sqlri,$linkbd);
						//	echo "$sqlri <br>";	    
						while($rowi=mysql_fetch_row($resi))
			 			{
			  				$vi=$_POST[dvalores][$x];
							$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[5]."' AND VIGENCIA='".$_POST[vigencia]."'";
							mysql_query($sqlr,$linkbd);	
					 		//****creacion documento presupuesto ingresos
				  			$sqlr="insert into pptoingssf (cuenta,idrecibo,valor,vigencia) values('$rowi[5]',$consec,$vi,'".$_POST[vigencia]."')";
	  			  			mysql_query($sqlr,$linkbd);	
				  
							if($rowi[5]!="" && $vi>0)
							{			
			 					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$rowi[5]."','".$_POST[tercero]."','INGRESOS SSF',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',21,$consec)";
			 					mysql_query($sqlr,$linkbd); 			  
							}
			 			}			 			 
			  			//echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Ingreso SSF con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
						?>
						<script>
							//alert("¡No se puede reflejar por Bloqueo de Fecha!");
							despliegamodalm('visible','1',"Se ha almacenado el Ingreso SSF con Exito");
						</script>
						<?php
					  ?>
					  <script>
					  document.form2.numero.value="";
					  document.form2.valor.value=0;
					  </script>
					  <?php
			  		}
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
		}
?>	
</form>
 </td></tr>
</table>
</body>
</html>