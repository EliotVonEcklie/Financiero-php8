<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
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
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
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
			function generar(){document.form2.genbal.value=1;document.form2.gbalance.value=0;document.form2.submit();}
			function guardarbalance(){document.form2.gbalance.value=1;document.form2.submit();}
			function guardarchip(){document.form2.gchip.value=1; document.form2.submit();}
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
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="cont-formatof01-agr.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a>
					<?php if($_POST[gchip]=='1'){?><a href="<?php echo "archivos/FORMATO_".$_POST[vigencias].$_POST[periodo]."_F01_AGR.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a><?php } ?>
					<a href="cont-contraloriadpto.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
         	</tr>
    	</table>
  		<form name="form2" action="cont-formatof01-agr.php"  method="post" enctype="multipart/form-data" >
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				
				if(!$_POST[oculto]){$_POST[pasos]=1;$_POST[oculto]=1;$_POST[reglas]=1;}
				if($_POST[reglas]==1){$chkchip=" checked";}
 				else {$chkchip=" ";}
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
	 		?> 
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto] ?>">
            <input type="hidden" name="pasos" id="pasos" value="<?php echo $_POST[pasos] ?>">
            <input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo] ?>"> 
    		<table class="inicio" align="center"> 
      		<tr>
        		<td class="titulos" colspan="10">FROMATOFO1_AGR</td>
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
  	  						$sqlr="Select * from chip_periodos  where estado='A' order by id";		
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
      			<td class="saludo1" style="width:15%;">
					<span style=" vertical-align:middle; width:10px"> Reglas Chip (Signos)&nbsp;
      					<input type="checkbox" name="reglas" id="reglas" class="defaultcheckbox" value="1" <?php echo $chkchip?>>
                  	</span>
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
                    <input type="hidden" name="vchip" value="<?php echo $_POST[vchip]?>"  readonly>  
                    <input type="hidden" name="gbalance" value="<?php echo $_POST[gbalance]?>"  readonly>    
        			<input type="button" name="guardabal" value="Clasificar Cuentas" onClick="guardarbalance()"> 
                    <input name="finalizar" type="button" value="Generar Archivo CSV" onClick="guardarchip()" >       
      			</td>
       		</tr>  
    	</table>   
		<div class="subpantallap" style="height:62.2%; width:99.6%; overflow-x:hidden;"> 	
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
						$_POST[fecha]='01'.'/'.$mes1.'/'.$_POST[vigencias];
						$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$_POST[vigencias];	
						//echo "Fechas:".$_POST[fecha].'  '.$_POST[fecha2];	
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						//echo "Fechas2:".$fechaf1.'  '.$fechaf2;	
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
						$f1=$fechafa2;	
						$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);	
						$fechafa=$_POST[vigencias]."-01-01";
						$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));
						//Borrar el balance de prueba anterior
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
									<td colspan='6' class='titulos'>Balance de Prueba</td>
								</tr>";
  						echo "<tr>
									<td class='titulos2'>Codigo</td>
									<td class='titulos2'>Cuenta</td>
									<td class='titulos2'>Saldo Anterior</td>
									<td class='titulos2'>Debito</td>
									<td class='titulos2'>Credito</td>
									<td class='titulos2'>Saldo Final</td>
							</tr>";
    					$tam=$niveles[$_POST[nivel]-1];
						$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";
						$sqlr2="select distinct cuenta,tipo from cuentas where estado ='S' and length(cuenta)=$tam ".$crit1." group by cuenta,tipo order by cuenta ";
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
						//echo "tc:".count($pctas);
						//******MOVIMIENTOS PERIODO
						$sqlr3="SELECT DISTINCT
						SUBSTR(comprobante_det.cuenta,1,$tam),
						sum(comprobante_det.valdebito),
						sum(comprobante_det.valcredito)
						FROM comprobante_det, comprobante_cab
						WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
						AND comprobante_det.numerotipo = comprobante_cab.numerotipo
						AND comprobante_cab.estado = 1
						AND (   comprobante_det.valdebito > 0
						OR comprobante_det.valcredito > 0)
						AND comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2'
						AND comprobante_det.tipo_comp <> 7 AND comprobante_det.tipo_comp <> 100 AND comprobante_det.tipo_comp <> 102 AND comprobante_det.tipo_comp <> 101 AND comprobante_det.tipo_comp <> 103
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
							$pctasb["$row[0]"][3]=$row[2];
						}
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
						// echo $sqlr3;
						while ($row =mysql_fetch_row($res)) 
						{
							$pctasb["$row[0]"][0]=$row[0];
							$pctasb["$row[0]"][1]=$row[1];
						}
//*******MOVIMIENTOS PREVIOS PERIODO
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
							AND comprobante_det.tipo_comp <> 104
							AND comprobante_det.tipo_comp <> 102
							AND comprobante_det.tipo_comp <> 7  ".$critcons."  
							AND comprobante_cab.fecha BETWEEN '$fecini' AND '$fechafa2'
							AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'		 
							AND comprobante_det.centrocosto like '%$_POST[cc]%'
							GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
							ORDER BY comprobante_det.cuenta";
							//echo $sqlr3;
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
						//  echo $sqlr3;
						//  sort($pctasb[]);
						while ($row =mysql_fetch_row($res)) 
						{
						$pctasb["$row[0]"][0]=$row[0];
						$pctasb["$row[0]"][1]+=$row[1]; 
						} */
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
 	 $pctasb["$ncuenta"][3]+=$pctasb[$k][3];
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
	if(($pctasb[$k][1]<0 || $pctasb[$k][1]>0) || ($pctasb[$k][2]<0 || $pctasb[$k][2]>0) || ($pctasb[$k][3]<0 || $pctasb[$k][3]>0))
 	{
	$saldofinal=$pctasb[$k][1]+$pctasb[$k][2]-$pctasb[$k][3];
	 $nomc=existecuentanicsp($pctasb[$k][0]);	 
	 $sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,debito,credito,saldofinal) values($i,'".$pctasb[$k][0]."','".$nomc."','".$pctasb[$k][1]."','".$pctasb[$k][2]."','".$pctasb[$k][3]."','".$saldofinal."')";
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
	 $_POST[tdebito]=0;
	 $_POST[tcredito]=0;
	 $_POST[tsaldofinal]=0;
	  $cuentachipno=array();
	 $namearch="archivos/".$_SESSION[usuario]."balanceprueba-nivel$_POST[nivel].csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"CODIGO;CUENTA;SALDO ANTERIOR;DEBITO;CREDITO;SALDO FINAL\r\n");
	 $co='saludo1a';
	 $co2='saludo2';
  while($row=mysql_fetch_row($res))
  {	  
	  if(strlen($row[1])==6)
	  {
	   $sqlrchip="select count(*) from chipcuentas where cuenta=$row[1]";
	   $reschip=mysql_query($sqlrchip,$linkbd);
	   $rowchip=mysql_fetch_row($reschip);
	   if($rowchip[0]==0)
	    {
		 $cuentachipno[]=$row[1];
		// $ncuentachipno[]=buscacuenta($row[1]);		 
		}
	  }
	   $negrilla="style='font-weight:bold'";
	  if (strlen($row[1])==($dignivmax))
		{
		// $negrilla=" "; 
		 //$_POST[tsaldoant]+=$row[3];
		 //$_POST[tdebito]+=$row[4];
		 //$_POST[tcredito]+=$row[5];
		 }
	 if($niveles[$_POST[nivel]-1]==strlen($row[1]))
		  {
			$negrilla=" ";  
			$_POST[tsaldoant]+=$row[3];
			 $_POST[tdebito]+=$row[4];
	 		$_POST[tcredito]+=$row[5];			  
	 		$_POST[tsaldofinal]+=$row[6];			  	
		  }
	echo "<tr class='$co' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
			<td $negrilla>$row[1]</td>
			<td $negrilla>$row[2]</td>
			<td $negrilla align='right'>".number_format($row[3],2,".",",")."</td>
			<td $negrilla align='right'>".number_format($row[4],2,".",",")."</td>
			<td $negrilla align='right'>".number_format($row[5],2,".",",")."</td>
			<td $negrilla align='right'>".number_format($row[6],2,".",",")."";
		echo "<input type='hidden' name='dcuentas[]' value= '".$row[1]."'> 
				<input type='hidden' name='dncuentas[]' value= '".$row[2]."'>
				<input type='hidden' name='dsaldoant[]' value= '".round($row[3],2)."'> 
				<input type='hidden' name='ddebitos[]' value= '".round($row[4],2)."'> 
				<input type='hidden' name='dcreditos[]' value= '".round($row[5],2)."'>
				<input type='hidden' name='dsaldo[]' value= '".round($row[6],2)."'>
			</td>
		</tr>" ;	 
	  fputs($Descriptor1,$row[1].";".$row[2].";".number_format($row[3],3,",","").";".number_format($row[4],3,",","").";".number_format($row[5],3,",","").";".number_format($row[6],3,",","")."\r\n");
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
			<td class='$co' align='right'>".number_format($_POST[tdebito],2,".",",")."
				<input type='hidden' name='tdebito' value= '$_POST[tdebito]'>
			</td>
			<td class='$co' align='right'>".number_format($_POST[tcredito],2,".",",")."
				<input type='hidden' name='tcredito' value= '$_POST[tcredito]'>
			</td>
			<td class='$co' align='right'>".number_format($_POST[tsaldofinal],2,".",",")."
				<input type='hidden' name='tsaldofinal' value= '$_POST[tsaldofinal]'>
			</td>
			</tr>";  
  $horafin=date('h:i:s');	
  echo "<DIV class='ejemplo'>INICIO:$horaini FINALIZO: $horafin</DIV>";
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
	</div>
 <?php
     }
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
	   } 
	//**FIN PASO 2
	//***** PASO 3 ****			 
	 //**** FIN PASO 3 ****
	//***** PASO 3 ****		 
	  if($_POST[gbalance]==1)
	 {
	  ?>      	
      <div class="subpantalla" style="height:100%;"> 	
      <table class="inicio">
      <tr><td class="titulos" colspan="8">CLASIFICAR CUENTAS</td></tr>
      <tr><td class="titulos2">CUENTA</td><td class="titulos2">NOMBRE</td><td class="titulos2">SALDO INICIAL</td><td class="titulos2">DEBITOS</td><td class="titulos2">CREDITOS</td>
	  <td class="titulos2">SALDO FINAL</td>
	 

	 
	 <td class="titulos2">CTE 
     
	 <input id="todoscte" name="todoscte" type="checkbox" value="1" onClick="checktodos()">
	 
	 </td>


	 
	 <td class="titulos2">NOCTE <input id="todoscten"  name="todoscten" type="checkbox" value="1" onClick="checktodosn()"></td></tr>
      <?php
	  $totalsalini=0;
	  $totaldeb=0;
	  $totalcred=0;
	  $totalsalfin=0;	  	  	  
	  $linkbd=conectar_bd();
	  $sqlrc="select distinct cuenta, sum(saldoinicial),sum(debitos), sum(creditos), sum(saldofinal) from chipcarga_det where vigencia=$_POST[vigencias] and periodo=$_POST[periodo] group by cuenta";
	  $resc=mysql_query($sqlrc,$linkbd);
	  
	  while($rowc=mysql_fetch_row($resc))
	   {
		   $ncta=existecuentanicsp($rowc[0]);		   
	  echo "<tr class='saludo3'><td ><input type='hidden' name='cuentac[]' value='$rowc[0]'>$rowc[0]</td><td >$ncta</td><td><input type='hidden' name='saldoinic[]' value='$rowc[1]'>$rowc[1]</td><td ><input type='hidden' name='debitosc[]' value='$rowc[2]'>$rowc[2]</td><td ><input type='hidden' name='creditosc[]' value='$rowc[3]'>$rowc[3]</td><td ><input type='hidden' name='saldofinc[]' value='$rowc[4]'>$rowc[4]</td>";
	  $chk='';
	  $chk2='';
	  if(strlen($rowc[0])==6)
	  {
		$noCorrienteDosDigitos = [16,17,18,27];
		$noCorrienteUnDigito = [3,4,5,6,7,8,9];
		$estaEnArrayNocorrienteDosDigitos = esta_en_array($noCorrienteDosDigitos,substr($rowc[0],0,2));
		$estaEnArrayNocorrienteUnDigito = esta_en_array($noCorrienteUnDigito,substr($rowc[0],0,1));
		if($estaEnArrayNocorrienteDosDigitos == 1 || $estaEnArrayNocorrienteUnDigito == 1)
		{
			$chk2="checked";
		}
		else
		{
			$chk="checked";
		}

		 /* $ch=esta_en_array($_POST[ctes], $rowc[0]);
			if($ch==1)
			 {
			 $chk="checked";
			 }
		  $ch2=esta_en_array($_POST[nctes], $rowc[0]);
			if($ch2==1)
			 {
			 $chk2="checked";
			 }	*/  
 	  $totalsalini+=$rowc[1]; 
	  $totaldeb+=$rowc[2]; 	  
	  $totalcred+=$rowc[3]; 
	  $totalsalfin+=$rowc[4]; 
		echo "<td ><center><input type='checkbox' name='ctes[]' value='$rowc[0]' onClick='actdes($rowc[0],1)' $chk></center></td><td><center><input type='checkbox' name='nctes[]' value='$rowc[0]' onClick='actdes($rowc[0],2)' $chk2></center></td></tr>";  
	  }
	  else 
	   {
	  	echo "<td ></td><td></td></tr>";
	   }
	   }
	  ?>
      <tr class="saludo3"><td></td><td></td><td><?php echo $totalsalini ?></td><td><?php echo $totaldeb ?></td><td><?php echo $totalcred ?></td><td><?php echo $totalsalfin ?>  <input type="hidden" name="gchip" value="<?php //echo $_POST[gchip] ?>"></td></tr>
      </table>
          </div>      
    <!-- <div class='inicio'>Guardar y Finalizar Consolidado <input name="finalizar" type="button" value="Finalizar" onClick="guardarchip()" ></div>      --> 
        
		<?php
		if($_POST[gchip]=='1')
		 {
		 $namearch="archivos/FORMATO_$_POST[vigencias]$_POST[periodo]_FO1_AGR.csv";
		 $Descriptor1 = fopen($namearch,"w+"); 
		 fputs($Descriptor1,"(S) Codigo Contable;(C) Nombre De La Cuenta;(D) Saldo Anterior;(D) Debito;(D) Credito;(D) Saldo Corriente;(D) Saldo No Corriente\r\n");
		for($x=0;$x<count($_POST[cuentac]);$x++)
		 {	 
		  $signo=cuenta_colocar_signo($_POST[cuentac][$x]);
		  if(strlen($_POST[cuentac][$x])==6)
		  {
			$chk="";  
		    $chk2="";
			$salfinal=0;
			$noCorrienteDosDigitos = [16,17,18,27];
			$noCorrienteUnDigito = [3,4,5,6,7,8,9];
			$estaEnArrayNocorrienteDosDigitos = esta_en_array($noCorrienteDosDigitos,substr($_POST[cuentac][$x],0,2));
			$estaEnArrayNocorrienteUnDigito = esta_en_array($noCorrienteUnDigito,substr($_POST[cuentac][$x],0,1));
		   $ch=esta_en_array($_POST[ctes], $_POST[cuentac][$x]);
		   $sq="SELECT nombre FROM cuentasnicsp WHERE cuenta='".$_POST[cuentac][$x]."'";
		   $resc=mysql_query($sq,$linkbd);
		   $rowc=mysql_fetch_row($resc);
		   $saldoinicial=$_POST[saldoinic][$x];
		   $debitos=$_POST[debitosc][$x];
		   $creditos=$_POST[creditosc][$x];
		   $salfinal=($saldoinicial+$debitos-$creditos); 
		   if($_POST[reglas]=='1')
			 {
				 if(substr($_POST[cuentac][$x],0,1)>1 && substr($_POST[cuentac][$x],0,1)<5)
				   {
						$saldoinicial=$saldoinicial*(-1);
						$salfinal=$salfinal*(-1);
				   }
					 
				   else
				   {
						$saldoinicial=$saldoinicial;
						$salfinal=$salfinal;
				   }
			 }		
			if($estaEnArrayNocorrienteDosDigitos == 1 || $estaEnArrayNocorrienteUnDigito == 1)
			{				
				$ncuentas=substr($_POST[cuentac][$x],0,1).".".substr($_POST[cuentac][$x],1,1).".".substr($_POST[cuentac][$x],2,2).".".substr($_POST[cuentac][$x],4,2); 
				fputs($Descriptor1,"".$ncuentas.";".$rowc[0].";".round($saldoinicial).";". round($debitos).";". round($creditos).";0;".round($salfinal).";\r\n");
				$chk2="checked";
				//echo "<br>D;".$ncuentas.";".abs($saldoinicial).";".round($_POST[debitosc][$x]/1000,0).";".round($_POST[creditosc][$x]/1000,0).";".$salfinal.";".$salfinal.";0";
			}
			// $ch2=esta_en_array($_POST[nctes], $_POST[cuentac][$x]);
			//if($ch2==1)
			else
			{
				//$salfinal=($_POST[saldoinic][$x]+$_POST[debitosc][$x]-$_POST[creditosc][$x])/1000; 
				
				$ncuentas=substr($_POST[cuentac][$x],0,1).".".substr($_POST[cuentac][$x],1,1).".".substr($_POST[cuentac][$x],2,2).".".substr($_POST[cuentac][$x],4,2); 
				fputs($Descriptor1,"".$ncuentas.";".$rowc[0].";".round($saldoinicial).";".round($debitos).";". round($creditos).";".round($salfinal).";0\r\n");
				$chk="checked";
				//  echo "<br>D;".$ncuentas.";".abs($saldoinicial).";".($_POST[debitosc][$x]/1000).";".($_POST[creditosc][$x]/1000).";".$salfinal.";".$salfinal.";0";
			}	  			 
		  }
		  fclose($namearch);
		 }
		?>
	  <?php
		 }
	 }
  ?>

</form></td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>