<?php //V 1000 12/12/16 ?> 
<?php
	ini_set('max_execution_time',3600);
	require "comun.inc";
	require "funciones.inc";
	require "validaciones.inc";
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
		<title>:: Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="JQuery/jquery-1.12.0.min.js"></script> 
		
		<script>
			$(window).load(function () { $('#cargando').hide();});
			
			function excel()
			{
				document.form2.action="xlsvalidarchip.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
			}
			function validar(){document.form2.submit(); }
			function generar(){
				document.form2.oculto.value=2;
				document.form2.genbal.value=1;
//				document.form2.gbalance.value=0;
				document.form2.submit();
			}
			function direccionaCuentaGastos(row)
			{
				var cell = row.getElementsByTagName("td")[0];
				var id = cell.innerHTML;
				var fech=document.getElementById("fecha").value;
				var fech1=document.getElementById("fecha2").value;
				window.open("cont-auxiliarcuenta.php?cod="+id+"&fec="+fech+"&fec1="+fech1);
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
					<a href="cont-razonabilidadsaldo.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="excel()" class="mgbt"><img src="imagenes/csv.png" title="A Excel"></a>
					<a href="cont-gestioninformecgr.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
         	</tr>
    	</table>
  		<form name="form2" action="cont-razonabilidadsaldo.php"  method="post" enctype="multipart/form-data" >
		<div class="loading" id="divcarga"><span>Cargando...</span></div>
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				if($_POST[reglas]==1){$chkchip=" checked";}
 				else {$chkchip=" ";}
				if(!$_POST[oculto])
				{
					$_POST[oculto]=1;
					echo"<script>document.getElementById('divcarga').style.display='none';</script>";
				}
				if($_POST[oculto] == 1)
				{
					echo"<script>document.getElementById('divcarga').style.display='none';</script>";
				}
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
            <input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo] ?>"> 
   		  <table class="inicio" align="center"> 
      		<tr>
        		<td class="titulos" colspan="10">Razonabilidad del Saldo</td>
        		<td class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
     		</tr>   
      		<tr>
            	<td class="saludo3" style="width:6%;">Vigencia:</td>      
      			<td style="width:11%;">
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
      			</td>
      			<td class="saludo3" style="width:6%;">Periodo:</td>
      			<td  style="width:14%;">
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
			 						$_POST[nperiodo]=$row[0]; 
			 						$_POST[periodo]=$row[1]; 
			 						$_POST[cperiodo]=$row[2]; 	
								}
								else {echo "<option value=$row[0]>$row[2]</option>";}
							}
	 					?>
      				</select>
                    <input type="hidden" name="periodo" value="<?php echo $_POST[periodo]?>">
                    <input type="hidden" name="nperiodo" value="<?php echo $_POST[nperiodo]?>">
                    <input type="text" name="cperiodo" value="<?php echo $_POST[cperiodo]?>"  style="width:45%;" readonly>
      			</td>
      			
                <td></td>
      			<td class="saludo3" style="width:11%;">Codigo Entidad</td>
                <td><input name="codent" type="text" value="<?php echo $_POST[codent]?>"></td>
         	</tr>
      		<tr>
            	<td class="saludo3">Nit:</td>
                <td>
                	<input type="hidden" name="nivel" value="3">
                    <input type="hidden" name="genbal"  value=" <?php echo $_POST[genbal]?>">
                    <input type="text" name="nitentidad" value="<?php echo $_POST[nitentidad]?>" style="width:98%;"readonly>
               	</td>
                <td class="saludo3">Entidad:</td>
                <td colspan="3">
                	<input type="text" name="entidad" value="<?php echo $_POST[entidad]?>" style="width:100%;"  readonly></td>
                <td colspan="2"> 
                	<input type="button" name="genera" value=" Generar " onClick="generar()">         
      			</td>
       		</tr>  
    	</table>   
        
        
		<div class="subpantallap" style="height:62.2%; width:99.6%; overflow-x:hidden;"> 	
        <?php
   			$oculto=$_POST['oculto'];
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
				$_POST[fecha]='01'.'/'.$mes1.'/'.$_POST[vigencias];
				$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$_POST[vigencias];
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
				echo "<table class='inicio' >
					<tr>
						<td colspan='5' class='titulos'>Validar Saldos - Valores en miles</td>
					</tr>
					<tr>
						<td class='titulos2'  align='center'>Cuenta</td>
						<td class='titulos2' align='center'>Nombre</td>
						<td class='titulos2' align='center'>Saldo Final</td>
						<td class='titulos2'  align='center'>Estado Saldo</td>
					</tr>";
				$linkbd=conectar_bd();
				$tam=$niveles[$_POST[nivel]]; // largor? 6
				
				//echo $tam;
				$crit1=" and left(cuenta,$tam)>='$_POST[cuenta1]' and left(cuenta,$tam)<='$_POST[cuenta2]' ";
				$sqlr2="select distinct cuenta,tipo,naturaleza from cuentas where estado ='S' and length(cuenta)=$tam ".$crit1." group by cuenta,tipo order by cuenta ";
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
				AND comprobante_det.tipo_comp <> 7 AND comprobante_det.tipo_comp <> 102 AND comprobante_det.tipo_comp <> 100 AND comprobante_det.tipo_comp <> 101 AND comprobante_det.tipo_comp <> 103 AND comprobante_det.tipo_comp<>104
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'
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
				$sqlrTipoComp = "SELECT codigo FROM tipo_comprobante WHERE codigo=102";
				$resTipoComp=mysql_query($sqlrTipoComp,$linkbd);
				$rowTipoComp =mysql_fetch_row($resTipoComp);
				if($rowTipoComp[0]!='')
				{
					$tipo_comp = 102;
				}
				else
				{
					$tipo_comp = 7;
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
				AND comprobante_det.tipo_comp = $tipo_comp 
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'
		  		AND comprobante_det.centrocosto like '%$_POST[cc]%'
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

				if($fechafa2>='2018-01-01')
				{
					//*******MOVIMIENTOS PREVIOS PERIODO
					$fecini='2018-01-01';
					$sqlr3="SELECT DISTINCT
					SUBSTR(comprobante_det.cuenta,1,$tam),
					sum(comprobante_det.valdebito)-
					sum(comprobante_det.valcredito),
					comprobante_cab.fecha
					FROM comprobante_det, comprobante_cab
					WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
					AND comprobante_det.numerotipo = comprobante_cab.numerotipo
					AND comprobante_cab.estado = 1
					AND comprobante_det.tipo_comp <> 100
					AND comprobante_det.tipo_comp <> 101
					AND comprobante_det.tipo_comp <> 103
					AND comprobante_det.tipo_comp <> 102
					AND comprobante_det.tipo_comp <> 104
					AND comprobante_det.cuenta!=''
					AND (   comprobante_det.valdebito > 0
					OR comprobante_det.valcredito > 0)
					AND comprobante_det.tipo_comp <> 7 
					AND comprobante_cab.fecha BETWEEN '$fecini' AND '$fechafa2'
					AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'		
					AND comprobante_det.centrocosto like '%$_POST[cc]%'
					GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
					ORDER BY comprobante_det.cuenta";
					$res=mysql_query($sqlr3,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$pctasb["$row[0]"][0]=$row[0];
						$pctasb["$row[0]"][1]+=$row[1]; 
						$pctasb["$row[0]"][4]=$row[2];
					}
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
						$nomc=existecuentanicsp($pctasb[$k][0]);	 
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
					$puntero="";
					$dobleclick="";
					//echo $niveles[$_POST[nivel]]." -- ".strlen($row[1]);
					if($niveles[$_POST[nivel]]==strlen($row[1]))
					{
						$negrilla=" ";  
						$puntero='cursor: hand';
						$dobleclick="ondblclick='direccionaCuentaGastos(this)'";
						$_POST[tsaldoant]+=$row[3];
						$_POST[tdebito]+=$row[4];
						$_POST[tcredito]+=$row[5];			  
						$_POST[tsaldofinal]+=$row[6];			  	
					}
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
					$sql="SELECT naturaleza from cuentasnicsp WHERE cuenta='$row[1]' ";
					$res2=mysql_query($sql,$linkbd);
					$ro=mysql_fetch_row($res2);
					
					if (substr($row[1],0,1)=='2' || substr($row[1],0,1)=='3' || substr($row[1],0,1)=='4')
					{
						$var1=number_format($miles,0,",",".");
						$var2=number_format($rowc[2],0,",",".");
						$sumvar=$var1 + $var2;
						if((strlen($row[1])==6)&& $row[6]>'0.1' && ($ro[0]=='CREDITO' or $ro[0]=='credito')){
							$estilo='background-color:yellow;';
							$var1=str_replace(',','.',str_replace('.','',$var1));
							$var2=str_replace(',','.',str_replace('.','',$var2));
							$dif="REVISAR SALDO  O NATURALEZA DE LA CUENTA &nbsp &nbsp <img src='imagenes/burro_contador.jpg' height='60' width='60' >";
							//echo "IF se pinta: "; echo $row[1]; echo "<br>";
						}
						else{
							$estilo="";
							$dif="";
						}	
					}
					else
					{
						$var1=number_format($miles,0,",",".");
						$var2=number_format($rowc[2],0,",",".");
						if((strlen($row[1])==6)&& $row[6]<'-0.1' && ($ro[0]=='DEBITO' or $ro[0]=='debito')){
							$estilo='background-color:yellow;';
							$var1=str_replace(',','.',str_replace('.','',$var1));
							$var2=str_replace(',','.',str_replace('.','',$var2));
							
							$dif="REVISAR SALDO  O NATURALEZA DE LA CUENTA  &nbsp &nbsp   <img src='imagenes/burro_contador.jpg' height='60' width='60'>";
						}
						else{
							
							$estilo="";
							$dif="";
						}
					}
						
					$signo=cuenta_colocar_signo($row[1]);
					//$miles=abs($miles); 
					//$miles=$miles*$signo;				
					//$rowc[2]=abs($rowc[2]); 
					//$rowc[2]=$rowc[2]*$signo;
					
					//$newvalor=0;
					//$newvalor=number_format($miles,$row[6],",",".");
					//echo $newvalor;
					
					echo "<tr class='$co' $dobleclick style='text-transform:uppercase; $estilo $puntero' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
						<td $negrilla width='10%'>$row[1]</td>
						<td $negrilla width='30%'>$row[2]</td>
						<td $negrilla align='right' width='15%'>".number_format($row[6],2,".",",")."</td>
						<td $negrilla align='center' width='30%' >$dif</td>";
							echo "<input type='hidden' name='dcuentas[]' value= '".$row[1]."'> 
							<input type='hidden' name='dncuentas[]' value= '".$row[2]."'>
							<input type='hidden' name='dsaldoant[]' value= '".$row[3]."'> 
							<input type='hidden' name='dsaldochip[]' value= '".$rowc[2]."'> 
						</td>
					</tr>" ;	 
					$aux=$co;
					$co=$co2;
					$co2=$aux;
					$i=1+$i;
				}
				echo "<script>document.getElementById('divcarga').style.display='none';</script>";
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
        ?> 
		</div>
     
  
<!--	<div class='inicio'>Formato CHIP da Click <a href="<?php //echo "archivos/".$_SESSION[usuario]."chip-$_POST[periodo].csv"; ?>" target="_blank"><img src="imagenes/csv.png"  alt="csv"></a> </div>-->
	 

</form></td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>