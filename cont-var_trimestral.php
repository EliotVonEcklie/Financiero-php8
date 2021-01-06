<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	ini_set('max_execution_time',3600);
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
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
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script>
		$(window).load(function () { $('#cargando').hide();});
		function despliegamodal2(_valor,v,cuenta,saldo)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				num_periodo=document.getElementById("periodo").value;

				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					if(v==1){
						document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
					}else{
						document.getElementById('ventana2').src="notascontabilidad.php?periodo1="+num_periodo+"&cuenta="+cuenta+"&saldo="+saldo;
					}
				}
				
			}
			function pdf()
			{
				document.form2.action="pdfbalance.php";
				document.form2.target="_BLANK";
				document.form2.submit();  
				document.form2.action="";
				document.form2.target="";
			}
			function validar(){document.form2.submit(); }
			function validarchip(){document.form2.vchip.value=1;document.form2.submit();}
			function next(){document.form2.pasos.value=parseFloat(document.form2.pasos.value)+1; document.form2.submit();}
			function generar(){document.form2.genbal.value=1;document.form2.submit();}
			function guardarbalance(){document.form2.gbalance.value=1;document.form2.submit();}
			function guardarchip(){
				document.form2.gchip.value=1; document.form2.submit();}
			function cargarotro(){document.form2.cargabal.value=1; document.form2.submit();}
			function checktodos()
			{
				cali=document.getElementsByName('ctes[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if (document.getElementById("todoscte").checked == true)
					{cali.item(i).checked = true;document.getElementById("todoscte").value=1;}
					else{cali.item(i).checked = false;document.getElementById("todoscte").value=0;}
				}	
			}
			
			
			
			function checktodosn()
			{
				cali=document.getElementsByName('nctes[]');
				for (var i=0;i < cali.length;i++) 
				{ 
					if (document.getElementById("todoscten").checked == true) 
					{cali.item(i).checked = true;document.getElementById("todoscten").value=1;	 }
					else{cali.item(i).checked = false;document.getElementById("todoscten").value=0;}
				}	
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<div class="loading" id="divcarga"><span>Cargando...</span></div>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="cont-var_trimestral.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
					<?php if($_POST[gchip]=='1'){?><a href="<?php echo "archivos/".$_SESSION[usuario]."VARIACIONES-TRIMESTRALES-$_POST[periodo].csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a><?php } ?>
					<a href="cont-gestioninformecgr.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
					<a><img class="icorot" src="imagenes/reload.png" title="Refrescar" onClick="generar()"/></a>
				</td>
         	</tr>
    	</table>
  		<form name="form2" action="cont-var_trimestral.php"  method="post" enctype="multipart/form-data" >
		  	
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				if($_POST[reglas]==1){$chkchip=" checked";}
 				else {$chkchip=" ";}
 				if(!$_POST[oculto]){$_POST[pasos]=1;$_POST[oculto]=1;}
   				$vact=$vigusu;    
	  			//*** PASO 2		  
				$sqlr="select *from configbasica where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	 			{
  					$_POST[nitentidad]=$row[0];
  					$_POST[entidad]=$row[1];
					$_POST[codent]=$row[8];
				}
				if($_POST[oculto]==""){echo"<script>document.getElementById('divcarga').style.display='none';</script>";}
	 		?> 
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto] ?>">
            <input type="hidden" name="pasos" id="pasos" value="<?php echo $_POST[pasos] ?>">
            <input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo] ?>"> 
			
    		<table class="inicio" align="center"> 
      		<tr>
        		<td class="titulos" colspan="10">Variacion Trimestral</td>
        		<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
     		</tr>   
      		<tr>
            	<td class="saludo3" style="width:6%;">Vigencia:</td>      
      			<td style="width:11%;">
      				<?php
      				
	   					if($_POST[pasos]>1)
	  	 				{
					?>
        			<input type="text" name="vigencias" value="<?php echo $_POST[vigencias]?>" style="width:98%;" readonly>
        			<?php  
		 				}	
						else
		 				{ 	  
	   				?>
      				<select name="vigencias" id="vigencias" style="width:98%;">
     					<option value="">Sel..</option>
						<?php	  
                            for($x=$vact;$x>=$vact-2;$x--)
                            {
                                if($x==$_POST[vigencias]){echo "<option  value=$x SELECTED>$x</option>";}
                                else {echo "<option value=$x>$x</option>";}
                            }
                        ?>
     				</select>
      				<?php
						}
	 				?>
      			</td>
      			<td class="saludo3" style="width:6%;">Periodo:</td>
      			<td  style="width:14%;">
      				<?php 
	  					if($_POST[pasos]>1)
	  	 				{
							$sqlr="Select * from chip_periodos  where id=$_POST[periodos] ";		
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
		 					{
								$_POST[periodo]=$row[1]; 
								$_POST[cperiodo]=$row[2]; 			
		 					}	 
					?>
        			<input type="hidden" name="periodos" value="<?php echo $_POST[periodos]?>">
        			<?php  
						}	
						else
		 				{ 	  
	   				?>
       				<select name="periodos" id="periodos" onChange="validar()"  style="width:45%;" >
      					<option value="">Sel..</option>
	  					<?php	  
  	  						$sqlr="Select * from chip_periodos  where estado='S' order by id";		
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
		 						if($row[0]==$_POST[periodos])
		 						{
			 						echo "<option value=$row[0] SELECTED>$row[2]</option>";
			 						$_POST[periodo]=$row[1]; 
			 						$_POST[cperiodo]=$row[2]; 	
								}
								else {echo "<option value=$row[0]>$row[2]</option>";}
							}
	 					?>
      				</select>
      				<?php
		 				}
	  				?>
                    <input type="hidden" name="periodo" value="<?php echo $_POST[periodo]?>">
                    <input type="text" name="cperiodo" value="<?php echo $_POST[cperiodo]?>"  style="width:45%;" readonly>
      			</td>
      			
                <td></td>
      			<td class="saludo3" style="width:11%;">Codigo Entidad</td>
                <td><input name="codent" type="text" value="<?php echo $_POST[codent]?>"></td>
         	</tr>
      		<tr>
            	<td class="saludo3">Nit:</td>
                <td>
                	<input type="hidden" name="nivel" value="4">
                    <input type="hidden" name="genbal"  value=" <?php echo $_POST[genbal]?>">
                    <input type="text" name="nitentidad" value="<?php echo $_POST[nitentidad]?>" style="width:98%;"readonly>
               	</td>
                <td class="saludo3">Entidad:</td>
                <td colspan="3">
                	<input type="text" name="entidad" value="<?php echo $_POST[entidad]?>" style="width:100%;"  readonly></td>
                <td colspan="2"> 
                	<input type="button" name="genera" value=" Generar " onClick="generar()"> 
					<input name="finalizar" type="button" value="Generar Archivo CSV" onClick="guardarchip()" > 
                </td>
       		</tr>  
    	</table>   
		<div id="divdet" class="subpantallap" style="height:58.2%; width:99.6%; overflow-x:hidden;"> 	
   			<?php
				//echo "$_POST[genbal]";
  				//**** para sacar la consulta del balance se necesitan estos datos ********
  				//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
				
				if($_POST[genbal]==1 && $_POST[gbalance]==0 )
				{	
 					//**** para sacar la consulta del balance se necesitan estos datos ********
  					//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
					$oculto=$_POST['oculto'];
					if($_POST[oculto])
					{
						$_POST[cuenta1]='1';
						$_POST[cuenta2]='9999999999999';
						$horaini=date('h:i:s');		
  						$niveles=array();
  						$sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)){$niveles[]=$row[4];}
						/*
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$f1=$fechafa2;	
						$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$fechafa=$vigusu."-01-01";
						$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));*/
						$mes1=substr($_POST[periodo],1,2);
						$mes2=substr($_POST[periodo],3,2);
						$vig=$_POST[vigencias]-1;
						$numero = cal_days_in_month(CAL_GREGORIAN,$mes2,$vig);
						
						$_POST[fecha]='01'.'/'.$mes1.'/'.$_POST[vigencias];
						$_POST[fecha3]=$numero.'/'.$mes2.'/'.$vig;
						$_POST[fecha4]=$numero.'/'.$mes2.'/'.$_POST[vigencias];
						$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$_POST[vigencias];	
						//echo "Fechas:".$_POST[fecha].'  '.$_POST[fecha2];	
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						//echo "Fechas2:".$fechaf1.'  '.$fechaf2;	
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha3],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$f1=$fechafa2;	
						$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);	
						$fechafa=$_POST[vigencias]."-01-01";
						$fechafa2=date('Y-m-d',$fechafa2);
						//Borrar el balance de prueba anterior
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha4],$fecha);
						$fechafa3=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$fechafa3=date('Y-m-d',$fechafa3);
						$sqlr2="select distinct digitos, posiciones from nivelesctas where estado='S' ORDER BY id_nivel DESC ";
						$resn=mysql_query($sqlr2,$linkbd);
						$rown=mysql_fetch_row($resn);
						$nivmax=$rown[0];
						$dignivmax=$rown[1];
						//continuar**** creacion balance de prueba
						//$namearch="archivos/".$_SESSION[usuario]."balanceprueba.csv";
						//$Descriptor1 = fopen($namearch,"w+"); 
						//fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
  						echo "<table class='inicio' >
								<tr>
									<td colspan='8' class='titulos'>Balance de Prueba</td>
								</tr>";
  						echo "<tr>
									<td align='center' class='titulos2'>Codigo</td>
									<td align='center' class='titulos2'>Cuenta</td>
									<td align='center' class='titulos2'>Saldo Final - Vigencia Anterior</td>
									<td align='center' class='titulos2'>Saldo Final - Vigencia Actual</td>
									<td align='center' class='titulos2'>Variacion Relativa</td>
									<td align='center' class='titulos2'>Variacion Porcentual</td>
									<td align='center' class='titulos2'>Notas</td>
							</tr>";
    					$tam=$niveles[$_POST[nivel]-1];
						$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";
						$sqlr2="select distinct cuenta,tipo from cuentasnicps where estado ='S' and length(cuenta)=$tam ".$crit1." group by cuenta,tipo order by cuenta ";
						$rescta=mysql_query($sqlr2,$linkbd);
						$i=0;
						//echo $sqlr2;
						$pctas=array();
						$pctasb[]=array();
						while ($row =mysql_fetch_row($rescta)) 
						{
							$pctas[]=$row[0];
							$pctasb["$row[0]"][0]=$row[0];
						  	$pctasb["$row[0]"][1]=0;
						  	$pctasb["$row[0]"][2]=0;
						  	$pctasb["$row[0]"][3]=0;
						}
						mysql_free_result($rescta);
						$tam=$niveles[$_POST[nivel]-1];
//**** SALDO INICIAL ***
$sqlr3="SELECT DISTINCT
          SUBSTR(comprobante_det.cuenta,1,$tam),
          sum(comprobante_det.valdebito)-
          sum(comprobante_det.valcredito)
     FROM comprobante_det, comprobante_cab
    WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
          AND comprobante_det.numerotipo = comprobante_cab.numerotipo
          AND comprobante_cab.estado = 1
          AND (   comprobante_det.valdebito > 0
               OR comprobante_det.valcredito > 0)         
          AND comprobante_det.tipo_comp = 102 
          AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'      
		  		  AND comprobante_det.centrocosto like '%$_POST[cc]%'
		  GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
   ORDER BY comprobante_det.cuenta";
   $res=mysql_query($sqlr3,$linkbd);
while ($row =mysql_fetch_row($res)) 
 {
  $pctasb["$row[0]"][0]=$row[0];
   $pctasb["$row[0]"][1]=$row[1];
 }
//*******MOVIMIENTOS PREVIOS PERIODO
if($fechafa2>='2018-01-01')
	{
		$fecini='2018-01-01';
		$sqlr3="SELECT DISTINCT
		SUBSTR(comprobante_det.cuenta,1,$tam),
		sum(comprobante_det.valdebito)-
		sum(comprobante_det.valcredito)
		FROM comprobante_det, comprobante_cab
		WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
		AND comprobante_det.numerotipo = comprobante_cab.numerotipo
		AND comprobante_cab.estado = 1
		AND (comprobante_det.valdebito > 0
		OR comprobante_det.valcredito > 0)
		AND comprobante_det.tipo_comp <> 100
		AND comprobante_det.tipo_comp <> 101
		AND comprobante_det.tipo_comp <> 103
		AND comprobante_det.tipo_comp <> 102
		AND comprobante_det.tipo_comp <> 104
		AND comprobante_det.cuenta!=''
		AND comprobante_det.tipo_comp <> 7  $critcons $critcons2
		AND comprobante_cab.fecha BETWEEN '$fecini' AND '$fechafa2'
		AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'
		AND comprobante_det.centrocosto like '%$_POST[cc]%'
		GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
		ORDER BY comprobante_det.cuenta";
		$res=mysql_query($sqlr3,$linkbd);
		//  sort($pctasb[]);
		while ($row =mysql_fetch_row($res)) 
		{
			$pctasb["$row[0]"][0]=$row[0];
			$pctasb["$row[0]"][1]+=$row[1]; 
		} 
	}
/*$sqlr3="SELECT DISTINCT
          SUBSTR(comprobante_det.cuenta,1,$tam),
          sum(comprobante_det.valdebito)-
          sum(comprobante_det.valcredito)
     FROM comprobante_det, comprobante_cab
    WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
          AND comprobante_det.numerotipo = comprobante_cab.numerotipo
          AND comprobante_cab.estado = 1
          AND (   comprobante_det.valdebito > 0
               OR comprobante_det.valcredito > 0)
          AND comprobante_det.tipo_comp <> 7  
		   AND comprobante_cab.fecha BETWEEN '' AND '$fechafa2'
          AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'		
		  AND comprobante_det.centrocosto like '%$_POST[cc]%'
		  GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
   ORDER BY comprobante_det.cuenta";
   $res=mysql_query($sqlr3,$linkbd);
  // echo $sqlr3;
 //  sort($pctasb[]);
while ($row =mysql_fetch_row($res)) 
 {
  $pctasb["$row[0]"][0]=$row[0];
  $pctasb["$row[0]"][1]+=$row[1]; 
 } */
 
 //**** SALDO INICIAL ***
$sqlr3="SELECT DISTINCT
          SUBSTR(comprobante_det.cuenta,1,$tam),
          sum(comprobante_det.valdebito)-
          sum(comprobante_det.valcredito)
     FROM comprobante_det, comprobante_cab
    WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
          AND comprobante_det.numerotipo = comprobante_cab.numerotipo
          AND comprobante_cab.estado = 1
          AND (   comprobante_det.valdebito > 0
               OR comprobante_det.valcredito > 0)         
          AND comprobante_det.tipo_comp = 7 
          AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'      
		  		  AND comprobante_det.centrocosto like '%$_POST[cc]%'
		  GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
   ORDER BY comprobante_det.cuenta";
   $res=mysql_query($sqlr3,$linkbd);
  // echo $sqlr3;
while ($row =mysql_fetch_row($res)) 
 {
  $pctasb["$row[0]"][0]=$row[0];
   $pctasb["$row[0]"][2]=$row[1];
 }
//*******MOVIMIENTOS PREVIOS PERIODO
$sqlr3="SELECT DISTINCT
          SUBSTR(comprobante_det.cuenta,1,$tam),
          sum(comprobante_det.valdebito)-
          sum(comprobante_det.valcredito)
     FROM comprobante_det, comprobante_cab
    WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
          AND comprobante_det.numerotipo = comprobante_cab.numerotipo
          AND comprobante_cab.estado = 1
          AND (   comprobante_det.valdebito > 0
               OR comprobante_det.valcredito > 0)
          AND comprobante_det.tipo_comp <> 7 
		   AND comprobante_cab.fecha BETWEEN '' AND '$fechafa3'
          AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'		
		  AND comprobante_det.centrocosto like '%$_POST[cc]%'
		  GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
   ORDER BY comprobante_det.cuenta";
   $res=mysql_query($sqlr3,$linkbd);
  // echo $sqlr3;
 //  sort($pctasb[]);
while ($row =mysql_fetch_row($res)) 
 {
  $pctasb["$row[0]"][0]=$row[0];
  $pctasb["$row[0]"][2]+=$row[1]; 
 } 
 
 for ($y=0;$y<$_POST[nivel];$y++)
 { 
   $lonc=count($pctasb);
   //foreach($pctasb as $k => $valores )
   $k=0;
  // echo "lonc:".$lonc;
//   while($k<$lonc)
	foreach($pctasb as $k => $valores )
    {
	if (strlen($pctasb[$k][0])>=$niveles[$y-1])
	 {		 
	 $ncuenta=substr($pctasb[$k][0],0,$niveles[$y-1]);
	 if($ncuenta!='')
	  {
	 $pctasb["$ncuenta"][0]=$ncuenta;
	 $pctasb["$ncuenta"][1]+=$pctasb[$k][1];
	 $pctasb["$ncuenta"][2]+=$pctasb[$k][2];
	 //echo "<br>N:".$niveles[$y-1]." : cuenta:".$k." NC:".$ncuenta."  ".$pctasb["$ncuenta"][1]."  ".$pctasb["$ncuenta"][2]."  ".$pctasb["$ncuenta"][3];	
	  }
	 }
	   $k++;
	}
 }
 $sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),saldoinicial double,debito double,credito double,saldofinal double)";
 mysql_query($sqlr,$linkbd);
 $i=1;
    foreach($pctasb as $k => $valores )
    {	 
	if(($pctasb[$k][1]<0 || $pctasb[$k][1]>0) || ($pctasb[$k][2]<0 || $pctasb[$k][2]>0))
 	{
	//echo "hola ".$pctasb[$k][2];
	 $nomc=existecuentanicsp($pctasb[$k][0]);	 
	 $sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,saldofinal) values($i,'".$pctasb[$k][0]."','".$nomc."',".$pctasb[$k][1].",".$pctasb[$k][2].")";
	// $sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,debito,credito,saldofinal) values($i,'".$pctasb[$k][0]."','".$nomc."',".$viva.",".$pctasb[$k][2].",".$pctasb[$k][3].",".$saldofinal.")";
	 mysql_query($sqlr,$linkbd);
	 //echo "<br>".$sqlr;
	 $i+=1;
	}
	 //echo "<br>cuenta:".$k."  ".$pctasb[$k][1]."  ".$pctasb[$k][2]."  ".$pctasb[$k][3];	
	}
	$sqlr="select *from usr_session order by cuenta";
 $res=mysql_query($sqlr,$linkbd);
 $_POST[tsaldoant]=0;
	 $_POST[tsaldofinal]=0;
	  $cuentachipno=array();
	 $namearch="archivos/".$_SESSION[usuario]."balanceprueba-nivel$_POST[nivel].csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;SALDO FINAL\r\n");
	 $co='saludo1a';
	 $co2='saludo2';
	 $totalrelativo = 0;
  while($row=mysql_fetch_assoc($res))
  {	  //echo "hola ".$row["saldofinal"];
	  if(strlen($row["cuenta"])==6)
	  {
	   $sqlrchip="select count(*) from chipcuentas where cuenta='".$row['cuenta']."'";
	   $reschip=mysql_query($sqlrchip,$linkbd);
	   $rowchip=mysql_fetch_row($reschip);
	   if($rowchip[0]==0)
	    {
		 $cuentachipno[]=$row["cuenta"];
		// $ncuentachipno[]=buscacuenta($row[1]);		 
		}
	  }
	   $negrilla="style='font-weight:bold'";
	  $notas="";
	  if (strlen($row["cuenta"])==($dignivmax) )
		{
			
		// $negrilla=" "; 
		 //$_POST[tsaldoant]+=$row[3];
		 //$_POST[tdebito]+=$row[4];
		 //$_POST[tcredito]+=$row[5];
		 }
		 $totalrelativo=$row["saldofinal"]-$row["saldoinicial"];
	 if($niveles[$_POST[nivel]-1]==strlen($row["cuenta"]))
		  {
			  $notas="<a onClick=\"despliegamodal2('visible',2,'".$row['cuenta']."','".abs($totalrelativo)."');\" title='Notas'><img src='imagenes/notavariaciones.png' style='width:20px; cursor:pointer'></a>";
			  $sq="SELECT cuenta FROM conta_notas WHERE vigencia='$vigusu' AND cuenta='".$row['cuenta']."' AND periodo='$_POST[periodo]'";
			  $re=mysql_query($sq,$linkbd);
			  $ro=mysql_fetch_row($re);
			  if($ro[0]=='')
			  {
				  $notas="<a onClick=\"despliegamodal2('visible',2,'".$row['cuenta']."','".abs($totalrelativo)."');\" title='Notas'><img src='imagenes/notaf.png' style='width:20px; cursor:pointer'></a>";
			  }
			   
			$negrilla=" ";  
			$_POST[tsaldoant]+=$row["saldoinicial"];			  
	 		$_POST[tsaldofinal]+=$row["saldofinal"];			  	
		  }
		  $total=(($row["saldofinal"]-$row["saldoinicial"])/$row["saldoinicial"])*100;
		  $estilo='';
		  if(abs($total)>15)
		  {
			  $estilo='background-color:yellow;';
		  }
		  
		  
	echo "<tr class='$co' style='text-transform:uppercase; $estilo' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
			<td align='center' width='8%' $negrilla>".$row['cuenta']."</td>
			<td align='center'  width='25%' $negrilla>".$row['nombrecuenta']."</td>
			<td align='center'  width='12%' $negrilla align='right'>".number_format($row["saldoinicial"],2,".",",")."</td>
			<td align='center' width='12%' $negrilla align='right'>".number_format($row["saldofinal"],2,".",",")."</td>
			<td align='center' width='7%' $negrilla> ".number_format($totalrelativo,2,",",".")." </td>
			<td align='center' width='7%' $negrilla> ".number_format($total,2,",",".")." %</td>
			<td align='center' width='7%'>$notas</td>";
		echo "<input type='hidden' name='dcuentas[]' value= '".$row["cuenta"]."'> 
				<input type='hidden' name='dncuentas[]' value= '".$row["nombrecuenta"]."'>
				<input type='hidden' name='dsaldoant[]' value= '".round($row["saldoinicial"],2)."'> 
				<input type='hidden' name='dsaldo[]' value= '".round($row["saldofinal"],2)."'>
			</td>
		</tr>" ;	 
	  fputs($Descriptor1,$row["cuenta"].";".$row["nombrecuenta"].";".number_format($row["saldoinicial"],3,",","").";".number_format($row["saldofinal"],3,",","")."\r\n");
		$aux=$co;
        $co=$co2;
        $co2=$aux;
		$i=1+$i;
  }
fclose($Descriptor1);
  echo "<tr class='$co'>
			<td colspan='2'>
			</td>
			<td class='$co' align='right'>".number_format($_POST[tsaldoant],2,".",",")."
				<input type='hidden' name='tsaldoant' value= '$_POST[tsaldoant]'>
			</td>
			<td class='$co' align='right'>".number_format($_POST[tsaldofinal],2,".",",")."
				<input type='hidden' name='tsaldofinal' value= '$_POST[tsaldofinal]'>
			</td>
			
			
			</tr>";  
  $horafin=date('h:i:s');	
  //echo "<DIV class='ejemplo'>INICIO:$horaini FINALIZO: $horafin</DIV>";
}
?> 
<?php
if ($_POST[vchip]==1)
 {
?>
 <div class="inicio"> 
<div class="titulos">ERROR CUENTAS INEXISTENTES VALIDACION CHIP: <input type="text" name="erroresent" size="5" value="<?php echo count($cuentachipno) ?>" readonly></div>
<?php
 }
?>
    <?php
	foreach($cuentachipno as $cch)
	 {		
	  $ncta=existecuenta($cch);
	  //echo "<div class='saludo3'>".strtoupper($cch)."  -  ".strtoupper($ncta)."</div>";		
	 }
?>
	</div>
 <?php
	
	 }
	 echo "<script>document.getElementById('divcarga').style.display='none';</script>";
	 if($_POST[gbalance]==1 && $_POST[gchip]!='1' )
	  {
		    $fechab=date('Y-m-d');
		 $linkbd=conectar_bd();
		 $sqlr="Delete from chipcarga_cab where vigencia=$_POST[vigencias] and periodo=$_POST[periodo]";
		 mysql_query($sqlr,$linkbd);
		 $sqlr="Delete from chipcarga_det where vigencia=$_POST[vigencias] and periodo=$_POST[periodo]";
		 mysql_query($sqlr,$linkbd);	
 		 $sqlr="insert into chipcarga_cab (entidad, nombre_entidad, vigencia, fecha, periodo, estado) values ('$_POST[nitentidad]','$_POST[entidad]','$_POST[vigencias]','$fechab','$_POST[periodo]','S') ";
		 mysql_query($sqlr,$linkbd);	
		 //echo "Error".mysql_error($linkbd); 
		 $cerror=0;
		 $cexit=0;
		 for($x=0;$x<count($_POST[dcuentas]);$x++)
		  {
			$sqlr="insert into chipcarga_det (entidad, vigencia, periodo, cuenta, saldoinicial, debitos, creditos, saldofinal, saldofincte, saldofincteno) values ('$_POST[nitentidad]','$_POST[vigencias]','$_POST[periodo]',".$_POST[dcuentas][$x].",".$_POST[dsaldoant][$x].",".$_POST[ddebitos][$x].",".$_POST[dcreditos][$x].",".$_POST[dsaldo][$x].",'','') ";
		 if(mysql_query($sqlr,$linkbd))	
		   {
			$cexit+=1;
		   }
		   else
		    {
			$cerror+=1;
			//echo "$sqlr<br>Error".mysql_error($linkbd); 
			}
		  }	
		  echo "<div class='inicio'>CUENTAS INSERTADAS:".$cexit." <img src='imagenes\confirm.png'></div>";
  		  echo "<div class='inicio'>CUENTAS NO INSERTADAS:".$cerror." <img src='imagenes\alert.png'></div>";		 
	   } 
	//**FIN PASO 2
	//***** PASO 3 ****			 
	 //**** FIN PASO 3 ****
	//***** PASO 3 ****		 
	  ?>      	
     	
      <table class="inicio">
      <tr class="saludo3"><td></td><td></td><td><?php echo $totalsalini ?></td><td><?php echo $totaldeb ?></td><td><?php echo $totalcred ?></td><td><?php echo $totalsalfin ?>  <input type="hidden" name="gchip" value="<?php //echo $_POST[gchip] ?>"></td></tr>
      </table>
	</div>
		
		
		
		
	<!--    Archivo CSV    -->
		<?php 
		if($_POST[gchip]=='1')
		 {
		 $namearch="archivos/".$_SESSION[usuario]."VARIACIONES-TRIMESTRALES-$_POST[periodo].csv";
		 $Descriptor1 = fopen($namearch,"w+"); 
		 fputs($Descriptor1,"S;".$_POST[codent].";".$_POST[periodo].";".$_POST[vigencias].";CGN2016C01_VARIACIONES_TRIMESTRALES_SIGNIFICATIVAS\r\n");
		 $sqlr="SELECT cuenta,notas,saldofinal FROM conta_notas WHERE vigencia='".$_POST[vigencias]."' AND periodo='".$_POST[periodo]."'";
		 $res=mysql_query($sqlr,$linkbd);
		 while($row=mysql_fetch_row($res))
		 {
			 $ncuentas=substr($row[0],0,1).".".substr($row[0],1,1).".".substr($row[0],2,2).".".substr($row[0],4,2); 
			 fputs($Descriptor1,"D;".$ncuentas.";1;".$row[1].";".round($row[2],0)."\r\n");

		 }
		?> 
	<div class='inicio'>Formato CHIP da Click <a href="<?php echo "archivos/".$_SESSION[usuario]."VARIACIONES-TRIMESTRALES-$_POST[periodo].csv"; ?>" target="_blank"><img src="imagenes/csv.png"  alt="csv"></a> </div>
	  <?php
		 }
  ?>
  
    <!-- <div class='inicio'>Guardar y Finalizar Consolidado <input name="finalizar" type="button" value="Finalizar" onClick="guardarchip()" ></div>      --> 

		<div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
       	</div>
		

		
</form></td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>