<?php //V 1000 12/12/16 ?> 
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
		<type="text/javascript" src="jquery-1.11.0.min.js"></script>
		<script>
		$(window).load(function () {
				$('#cargando').hide();
			});
			function pdf()
			{
				document.form2.action="pdfvalidarchip.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excel()
			{
				document.form2.action="xlsvalidarchip.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
			}
			function validar(){document.form2.submit(); }
			function validarchip(){document.form2.vchip.value=1;document.form2.submit();}
			function next(){document.form2.pasos.value=parseFloat(document.form2.pasos.value)+1; document.form2.submit();}
			function generar(){
				document.form2.oculto.value=2;
				document.form2.genbal.value=1;
//				document.form2.gbalance.value=0;
				document.form2.submit();
			}
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
			function direccionaCuentaGastos(row)
			{
				var cell = row.getElementsByTagName("td")[0];
				var id = cell.innerHTML;
				var fech=document.getElementById("fecha").value;
				var fech1=document.getElementById("fecha2").value;
				window.open("cont-auxiliarcuenta.php?cod="+id+"&fec="+fech+"&fec1="+fech1);
			}
			function buscacta()
			{
					document.form2.bc.value='1';
					document.form2.submit();
			}
			function guarda()
			{
				if (confirm("Esta Seguro de Guardar"))
				{
					document.form2.oculto.value='3';
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
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="cont-homologacionprueba.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt" onClick="guarda();"><img src="imagenes/guarda.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
         	</tr>
    	</table>
  		<form name="form2" action="cont-homologacionprueba.php"  method="post" enctype="multipart/form-data" >
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
	 		?> 
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto] ?>">
            <input type="hidden" name="pasos" id="pasos" value="<?php echo $_POST[pasos] ?>">
            <input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo] ?>"> 
   		  <table class="inicio" align="center"> 
      		<tr>
        		<td class="titulos" colspan="10">Homologacion de cuentas para convergencia a NICSP</td>
        		<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
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
					<input type="hidden" value="" name="bc" id="bc">
					<input type="hidden" value="" name="cuentan" id="cuentan">
      			</td>
				<td>
					<input type="button" name="genera" value=" Validar cuentas Nicsp " onClick="buscacta()"> 
				</td>
       		</tr>  
    	</table>   
		<div class="subpantallap" style="height:62.2%; width:99.6%; overflow-x:hidden;"> 	
        <?php
   			$oculto=$_POST['oculto'];
			$_POST[vigencias]='2017';
			if($_POST[oculto]==2)
			{
				$_POST[cuenta1]='1';
				$_POST[cuenta2]='9999999999999';
				$horaini=date('h:i:s');		
  				$niveles=array();
  				$sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)){$niveles[]=$row[4];}
				
				$mes1=substr($_POST[periodo],1,2);
				$mes2=substr($_POST[periodo],3,2);
				$_POST[fecha]='01'.'/'.'10'.'/'.$_POST[vigencias];
				$_POST[fecha2]=intval(date("t",$mes2)).'/'.'12'.'/'.$_POST[vigencias];
				?>
				<input name="fecha" type="hidden" id="fecha" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">  <input id="periodonom1" name="periodonom1" type="hidden" value="<?php echo $_POST[periodonom1]?>" > 
				<input name="fecha2" type="hidden" id="fecha2" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">  <input id="periodo2" name="periodo2" type="hidden" value="<?php echo $_POST[periodo2]?>" >
				<?php
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
				//TRIMESTRE Y VIGENCIA CHIP
				$arrper=array('','Ene-Mar','Abr-Jun','Jul-Sep','Oct-Dic');
				if($_POST[nperiodo]!=""){
					if($_POST[nperiodo]>1){
						$trimchip=$_POST[nperiodo]-1;
						$vigchip=$_POST[vigencias];
					}
					else{
						$trimchip=4;
						$vigchip=$_POST[vigencias]-1;
					}
				}
				//FIN CHIP
				if($_POST[bc]=='1')
				{
					for($i=0;$i<count($_POST[cuentanicsp]);$i++)
					{
						if ($_POST[cuentanicsp][$i]!='')
						{
							$nresul=buscacuenta($_POST[cuentanicsp][$i]);
							if($nresul!='')
							{
								$_POST[nomcuentanicsp][$i]=$nresul;
							}
							else
							{
								$_POST[nomcuentanicsp][$i]="";
							}
						}
						
					}
				}
				echo "<table class='inicio' >
					<tr>
						<td colspan='6' class='titulos'>Homologar Cuentas</td>
					</tr>
					<tr>
						<td class='titulos2'  align='center'>Cuenta</td>
						<td class='titulos2' align='center'>Nombre</td>
						<td class='titulos2' align='center'>Saldo Final</td>
						<td class='titulos2'  align='center'>Cuenta NICSP</td>
						<td class='titulos2'  align='center'>Nombre Cuenta NICSP</td>
					</tr>";
				$linkbd=conectar_bd();
    			$tam=$niveles[$_POST[nivel]]; // largor? 6
				//echo $tam;
				$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";
				$sqlr2="select distinct cuenta,tipo,naturaleza from cuentas where estado ='S' and left(cuenta,1)<'4' and length(cuenta)=$tam ".$crit1." group by cuenta,tipo order by cuenta ";
				$rescta=mysql_query($sqlr2,$linkbd);
				$i=0;
				$pctas=array();
				$pctasb[]=array();
				while ($row =mysql_fetch_row($rescta)) 
				{
					$pctas[]=$row[0];
					$pctasb["$row[0]"][0]=$row[0];
				  	$pctasb["$row[0]"][1]=0;
				  	$pctasb["$row[0]"][2]=0;
				  	$pctasb["$row[0]"][3]=0;
				  	$pctasb["$row[0]"][4]='';
				}
				mysql_free_result($rescta);
				$tam=$niveles[$_POST[nivel]];
				//$tam=$niveles[$_POST[nivel]-1];
				//echo "tc:".count($pctas);
				//******MOVIMIENTOS PERIODO
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito),
				sum(comprobante_det.valcredito),
				comprobante_cab.fecha
				FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (   comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)
				AND comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2'
				AND comprobante_det.tipo_comp <> 7 
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'	
				AND left(comprobante_det.cuenta,1)<'4'
				AND comprobante_det.centrocosto like '%$_POST[cc]%'
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				//echo $sqlr3;
				$res=mysql_query($sqlr3,$linkbd);
				// echo $sqlr3;
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][2]=$row[1];
					$pctasb["$row[0]"][3]=$row[2];
					$pctasb["$row[0]"][4]=$row[3];
				}
				//**** SALDO INICIAL ***
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito)-
				sum(comprobante_det.valcredito),
				comprobante_cab.fecha
				FROM comprobante_det, comprobante_cab
				WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (   comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)         
				AND comprobante_det.tipo_comp = 7 
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'      
		  		AND comprobante_det.centrocosto like '%$_POST[cc]%'
				AND left(comprobante_det.cuenta,1)<'4'
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				//echo $sqlr3;
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][1]=$row[1];
					$pctasb["$row[0]"][4]=$row[2];
				}
				$fechafa2='2018-01-01';
				//*******MOVIMIENTOS PREVIOS PERIODO
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito)-
				sum(comprobante_det.valcredito),
				comprobante_cab.fecha
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
				AND left(comprobante_det.cuenta,1)<'4'
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][1]+=$row[1]; 
					$pctasb["$row[0]"][4]=$row[2];
				} 
				for ($y=0;$y<$_POST[nivel];$y++)
				{ 
					$lonc=count($pctasb);
					$k=0;
					foreach($pctasb as $k => $valores )
					{
						if (strlen($pctasb[$k][0])>=$niveles[$y])
						{		 
							$ncuenta=substr($pctasb[$k][0],0,$niveles[$y]);
							if($ncuenta!='')
							{
								$pctasb["$ncuenta"][0]=$ncuenta;
								$pctasb["$ncuenta"][1]+=$pctasb[$k][1];
								$pctasb["$ncuenta"][2]+=$pctasb[$k][2];
								$pctasb["$ncuenta"][3]+=$pctasb[$k][3];
								$pctasb["$ncuenta"][4]+=$pctasb[$k][4];
							}
						}
						$k++;
					}
				}
				$sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),saldoinicial double,debito double,credito double,saldofinal double, fecha date)";
				//echo $sqlr;
				mysql_query($sqlr,$linkbd);
				$i=1;
				foreach($pctasb as $k => $valores )
				{	 
					if(($pctasb[$k][1]<0 || $pctasb[$k][1]>0) || ($pctasb[$k][2]<0 || $pctasb[$k][2]>0) || ($pctasb[$k][3]<0 || $pctasb[$k][3]>0))
					{
						$saldofinal=$pctasb[$k][1]+$pctasb[$k][2]-$pctasb[$k][3];
						$nomc=existecuenta($pctasb[$k][0]);	 
						$sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,debito,credito,saldofinal, fecha) values($i,'".$pctasb[$k][0]."','".$nomc."',".$pctasb[$k][1].",".$pctasb[$k][2].",".$pctasb[$k][3].",".$saldofinal.",".$pctasb[$k][4].")";
						mysql_query($sqlr,$linkbd);
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
				$co='saludo1a';
				$co2='saludo2';
				$x=0;
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
						}
					}
					$negrilla="style='font-weight:bold'";
					$dobleclick="";
					$cuentanegrita=$niveles[$_POST[nivel]]-1;
					if($cuentanegrita==strlen($row[1]))
					{
						$negrilla=" ";  
						$dobleclick="ondblclick='direccionaCuentaGastos(this)'";
						$_POST[tsaldoant]+=$row[3];
						$_POST[tdebito]+=$row[4];
						$_POST[tcredito]+=$row[5];			  
						$_POST[tsaldofinal]+=$row[6];			  	
					
						$sqlc="select * from cuentasaldos where cuenta='$row[1]' and trimestre='$trimchip' and vigencia='$vigchip'";
						$resc=mysql_query($sqlc, $linkbd);
						$rowc=mysql_fetch_array($resc);
						// se quita la division entre 1000
						$miles=$row[3];
						//echo $row[1];echo " ";
						//echo $rowc[2]; echo "<br>";
						
						/*echo $row[1];echo "<br>"; // id
						echo $row[2];echo "<br>"; // nombre 
						echo $row[3];echo "<br>"; 
						echo $row[4];echo "<br>";
						echo $row[5];echo "<br>";
						echo $row[6];echo "<br>"; // valor final */
						$sql="SELECT naturaleza from cuentas WHERE cuenta='$row[1]' ";
						$res2=mysql_query($sql,$linkbd);
						$ro=mysql_fetch_row($res2);
						$signo=cuenta_colocar_signo($row[1]);
						
						$sqlr4="SELECT cuentaexterna,nombrecuenta FROM contcuentashomologacion WHERE cuentacentral='$row[1]'";
						$res4=mysql_query($sqlr4,$linkbd);
						$ro4=mysql_fetch_row($res4);
						if($_POST[cuentanicsp][$x]=='')
						{
							$_POST[cuentanicsp][$x]=$ro4[0];
							$_POST[nomcuentanicsp][$x]=$ro4[1];
						}
						
						//$miles=abs($miles); 
						//$miles=$miles*$signo;				
						//$rowc[2]=abs($rowc[2]); 
						//$rowc[2]=$rowc[2]*$signo;
						
						//$newvalor=0;
						//$newvalor=number_format($miles,$row[6],",",".");
						//echo $newvalor;
						if(round($row[6],2)!='0')
						{
							echo "<tr class='$co' style='text-transform:uppercase; $estilo' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td $negrilla width='10%'>$row[1]</td>
							<td $negrilla width='30%'>$row[2]</td>
							<td $negrilla align='right' width='15%'>".number_format($row[6],2,".",",")."</td>
							<td $negrilla align='center' width='10%' ><input type='text' name='cuentanicsp[]' id='cuentanicsp[]' value= '".$_POST[cuentanicsp][$x]."'> </td>
							<td ><input type='text' style='width:100%' name='nomcuentanicsp[]' class='inpnovisibles' value= '".$_POST[nomcuentanicsp][$x]."'></td>";
								echo "<input type='hidden' name='dcuentas[]' value= '".$row[1]."'> 
								<input type='hidden' name='dncuentas[]' value= '".$row[2]."'>
								<input type='hidden' name='dsaldoant[]' value= '".$row[3]."'> 
								<input type='hidden' name='dsaldochip[]' value= '".$rowc[2]."'> 
								<input type='hidden' name='saldfinal[]' value= '".round($row[6],2)."'> 
							</td>
							</tr>" ;	 
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							$i=1+$i;
							$x=$x+1;
						}
					}
				}
				//$sqld="SELECT cuenta, count(*) as total FROM (SELECT cuenta FROM cuentasaldos UNION ALL SELECT cuenta FROM usr_session WHERE fecha BETWEEN '$fechaf1' AND '$fechaf2') as list GROUP BY cuenta HAVING total=1";
				$sqld="SELECT cuenta, count(*) as total FROM ( SELECT cuenta FROM usr_session  NOT IN (SELECT cuenta FROM cuentasaldos)) as list GROUP BY cuenta HAVING total=1";
				$resd=mysql_query($sqld, $linkbd);
				if(mysql_num_rows($resd)!=0){
					echo "<table class='inicio' >
						<tr>
							<td colspan='5' class='titulos'>Cuentas Faltantes</td>
						</tr>
						<tr>
							<td class='titulos2' width='10%' align='center'>Cuenta</td>
						</tr>";
					while($wd=mysql_fetch_array($resd)){
						echo "<tr class='$co'>
							<td class='$co' align='right'>".$wd[0]."</td>
						</tr>";  
					}
					echo"</table>";
				}
  $horafin=date('h:i:s');	
  echo "<DIV class='ejemplo'>INICIO:$horaini FINALIZO: $horafin</DIV>";
				
				
			}
			if($_POST[oculto]=='3') //**********guardar la configuracion de la cuenta
			{
				$link=conectar_bd();
				for($x=0;$x<count($_POST[cuentanicsp]);$x++)
				{
					if($_POST[cuentanicsp][$x]!='')
					{
						$sql="DELETE FROM contcuentashomologacion WHERE cuentacentral=".$_POST[dcuentas][$x]."";
						mysql_query($sql,$link);
						$arreglo=explode("-",$_POST[concecausa][$x]);
						$sqlr="insert into contcuentashomologacion (cuentacentral,cuentaexterna,nombrecuenta,vigencia,saldo) values ('".$_POST[dcuentas][$x]."','".$_POST[cuentanicsp][$x]."','".$_POST[nomcuentanicsp][$x]."','$vigusu','".$_POST[saldfinal][$x]."')";
						mysql_query($sqlr,$link);
					}
					
				}
				?>
				<script>
					document.form2.oculto.value='2';
					document.form2.submit();
				</script>
				<?php
			}
        ?> 
		</div>
     
  
<!--	<div class='inicio'>Formato CHIP da Click <a href="<?php //echo "archivos/".$_SESSION[usuario]."chip-$_POST[periodo].csv"; ?>" target="_blank"><img src="imagenes/csv.png"  alt="csv"></a> </div>-->
	 

</form></td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>