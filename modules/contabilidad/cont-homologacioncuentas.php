<?php //V 1000 12/12/16 ?> 
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
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
				document.form2.action="cont-homologacioncuentascsv.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function validar(){document.form2.submit(); }
			function validarchip(){document.form2.vchip.value=1;document.form2.submit();}
			function next(){document.form2.pasos.value=parseFloat(document.form2.pasos.value)+1; document.form2.submit();}
			function generar(){
				document.form2.oculto.value=2;
				document.form2.oculto1.value=2;
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
					document.form2.oculto1.value='1';
					document.form2.inserte.value='';
					document.form2.submit();
			}
			function insertcuentas()
			{
					document.form2.inserte.value='1';
					document.form2.submit();
			}
			function crearcomp()
			{
					document.form2.oculto.value='4';
					document.form2.submit();
			}
			function guarda()
			{
				if (confirm("Esta Seguro de Guardar"))
				{
					document.form2.bc.value='1';
					document.form2.oculto.value='3';
					document.form2.submit();
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
			function funcionmensaje()
			{
				alert();
				document.location.href = "cont-homologacioncuentas.php";
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
			<?php
				if($_POST[inserte]=='1')
				{
					$dire="cont-homologacioncuentas.php";
					$imagen="imagenes/add.png";
					$guardad="imagenes/guardad.png";
					$guar="#";
				}
				else
				{
					$dire="#";
					$imagen="imagenes/add2.png";
					$guar="guarda()";
					$guardad="imagenes/guarda.png";
				}
			?>
			<tr>
  				<td colspan="3" class="cinta">
				<a href="<?php echo "$dire"; ?>" class="mgbt"><img src="<?php echo "$imagen"; ?>" title="Nuevo" /></a><a class="mgbt" onClick="<?php echo "$guar"; ?>"><img src="<?php echo "$guardad"; ?>"/></a><a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="excel();" class="mgbt"><img src="imagenes/excel.png" title="excel"></a></td>
         	</tr>
    	</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
			<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
		</div>
  		<form name="form2" action="cont-homologacioncuentas.php"  method="post" enctype="multipart/form-data" >
 			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				if($_POST[reglas]==1){$chkchip=" checked";}
 				else {$chkchip=" ";}
 				if(!$_POST[oculto]){$_POST[pasos]=1;$_POST[oculto]=1;$_POST[oculto1]=1;}
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
			<input type="hidden" name="oculto1" id="oculto1" value="<?php echo $_POST[oculto1] ?>">
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
                
				<?php
				if($_POST[inserte]!='1')
				{
					?>
					<td colspan="2"> 
						<input type="button" name="genera" value=" Generar " onClick="generar()">  
					</td>
					<td>
						<input type="button" name="genera" value=" Validar cuentas Nicsp " onClick="buscacta()"> 
					</td>
					<td>
						<input type="button" name="genera" value=" Insertar Cuentas " onClick="insertcuentas()"> 
					</td>
					<?php
				}
				?>
                	 
				<td>
					<input type="button" name="generacomp" value=" Generar Comprobante Inicial NICSP " onClick="crearcomp()"> 
					<input type="hidden" value="" name="inserte" id="inserte">
					<input type="hidden" value="" name="bc" id="bc">
					<input type="hidden" value="" name="cuentan" id="cuentan">
				</td>
       		</tr>  
    	</table>   
		<div class="subpantallap" style="height:62.2%;width:99.6%; overflow-x:hidden;"> 	
        <?php
   			$oculto=$_POST['oculto'];
			$_POST[vigencias]='2017';
			if($_POST[oculto]==2)
			{
				$sqlrcc="select id_cc from centrocosto where entidad='N'";
				$rescc=mysql_query($sqlrcc,$linkbd);
				while($rowcc=mysql_fetch_row($rescc)){$critcons.=" and comprobante_det.centrocosto <> '".$rowcc[0]."' ";}
				$_POST[cuenta1]='1';
				$_POST[cuenta2]='9999999999999';
				$horaini=date('h:i:s');		
  				$niveles=array();
  				$sqlr="Select * from nivelesctas  where estado='S' order by id_nivel";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)){$niveles[]=$row[4]-1;}
				
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
				echo "<table class='inicio' >
					<tr>
						<td colspan='12' class='titulos'>Homologar Cuentas</td>
					</tr>
					<tr>
						<td class='titulos2' style='width:5%;' align='center'>Cuenta</td>
						<td class='titulos2' style='width:20%;' align='center'>Nombre</td>
						<td class='titulos2'  align='center'>Saldo Final</td>
						<td class='titulos2'  style='width:7%;' align='center'>Debito 100 y 101</td>
						<td class='titulos2'  style='width:7%;' align='center'>Credito 100 y 101</td>
						<td class='titulos2'  style='width:7%;' align='center'>Debito Por Convergencia</td>
						<td class='titulos2'  style='width:7%;' align='center'>Credito Por Convergencia</td>
						<td class='titulos2'  align='center'>Debito</td>
						<td class='titulos2'  align='center'>Credito</td>
						<td class='titulos2'  align='center'>Saldo Final</td>
						<td class='titulos2'  align='center'>Cuenta NICSP</td>
						<td class='titulos2' style='width:30%;' align='center'>Nombre Cuenta NICSP</td>
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
					$pctasb["$row[0]"][5]=0;
					$pctasb["$row[0]"][6]=0;
					$pctasb["$row[0]"][7]=0;
					$pctasb["$row[0]"][8]=0;
					$pctasb["$row[0]"][9]=0; 
				}
				mysql_free_result($rescta);
				$tam=$niveles[$_POST[nivel]];
				//$tam=$niveles[$_POST[nivel]-1];
				//echo "tc:".count($pctas);
				//$fechaf2='2018-01-01';
				//******MOVIMIENTOS PERIODO
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito),
				sum(comprobante_det.valcredito),
				comprobante_cab.fecha,
				comprobante_det.centrocosto
				FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (   comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)
				AND comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2'
				AND comprobante_det.tipo_comp <> 7  
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'	
				AND (left(comprobante_det.cuenta,1)<'4' OR left(comprobante_det.cuenta,1)>'8')
				AND comprobante_det.centrocosto like '%$_POST[cc]%'
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				
				$res=mysql_query($sqlr3,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][2]=$row[1];
					$pctasb["$row[0]"][3]=$row[2];
					$pctasb["$row[0]"][4]=$row[3];
					$pctasb["$row[0]"][9]=$row[4];
				}
				//**** SALDO INICIAL ***
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito)-
				sum(comprobante_det.valcredito),
				comprobante_cab.fecha,
				comprobante_det.centrocosto
				FROM comprobante_det, comprobante_cab
				WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (   comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)         
				AND comprobante_det.tipo_comp = 7 
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'      
		  		AND comprobante_det.centrocosto like '%$_POST[cc]%' 
				AND (left(comprobante_det.cuenta,1)<'4' OR left(comprobante_det.cuenta,1)>'8')
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				$res=mysql_query($sqlr3,$linkbd);
				//echo $sqlr3;
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][1]=$row[1];
					$pctasb["$row[0]"][4]=$row[2];
					$pctasb["$row[0]"][9]=$row[3];
				}
				//$fechafa2='2018-01-01';
				//*******MOVIMIENTOS PREVIOS PERIODO
				$sqlr3="SELECT comprobante_det.cuenta,
				(sum(comprobante_det.valdebito)-
				sum(comprobante_det.valcredito)),
				comprobante_cab.fecha,
				comprobante_det.centrocosto
				FROM comprobante_det, comprobante_cab
				WHERE     comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND comprobante_det.tipo_comp <> 7
				AND comprobante_cab.fecha BETWEEN '' AND '$fechafa2'
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'
				AND comprobante_det.centrocosto like '%$_POST[cc]%'
				AND (left(comprobante_det.cuenta,1)<'4' OR left(comprobante_det.cuenta,1)>'8')
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				//echo $sqlr3;
				$res=mysql_query($sqlr3,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][1]+=$row[1]; 
					$pctasb["$row[0]"][4]=$row[2];
					$pctasb["$row[0]"][9]=$row[3];
				}
				
				//MOVIMIENTOS DEL COMPROBANTE 100 Y 101
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito),
				sum(comprobante_det.valcredito),
				comprobante_cab.fecha,
				comprobante_det.centrocosto
				FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (   comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)
				AND (comprobante_det.tipo_comp='100' or comprobante_det.tipo_comp='101')
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'	
				AND (left(comprobante_det.cuenta,1)<'4' OR left(comprobante_det.cuenta,1)>'8')
				AND comprobante_det.centrocosto like '%$_POST[cc]%'
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				//echo $sqlr3;
				$res=mysql_query($sqlr3,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][5]=$row[1];
					$pctasb["$row[0]"][6]=$row[2];
					$pctasb["$row[0]"][4]=$row[3];
					$pctasb["$row[0]"][9]=$row[4];
				}
				//MOVIMIENTOS DEL COMPROBANTE 104
				$sqlr3="SELECT DISTINCT
				SUBSTR(comprobante_det.cuenta,1,$tam),
				sum(comprobante_det.valdebito),
				sum(comprobante_det.valcredito),
				comprobante_cab.fecha,
				comprobante_det.centrocosto
				FROM comprobante_det, comprobante_cab
				WHERE comprobante_cab.tipo_comp = comprobante_det.tipo_comp
				AND comprobante_det.numerotipo = comprobante_cab.numerotipo
				AND comprobante_cab.estado = 1
				AND (   comprobante_det.valdebito > 0
				OR comprobante_det.valcredito > 0)
				AND (comprobante_det.tipo_comp='104')
				AND SUBSTR(comprobante_det.cuenta,1,$tam) >= '$_POST[cuenta1]' AND SUBSTR(comprobante_det.cuenta,1,$tam) <='$_POST[cuenta2]'	
				AND (left(comprobante_det.cuenta,1)<'4' OR left(comprobante_det.cuenta,1)>'8')
				AND comprobante_det.centrocosto like '%$_POST[cc]%'
				GROUP BY SUBSTR(comprobante_det.cuenta,1,$tam)
				ORDER BY comprobante_det.cuenta";
				//echo $sqlr3;
				$res=mysql_query($sqlr3,$linkbd);
				while ($row =mysql_fetch_row($res)) 
				{
					$pctasb["$row[0]"][0]=$row[0];
					$pctasb["$row[0]"][7]=$row[1];
					$pctasb["$row[0]"][8]=$row[2];
					$pctasb["$row[0]"][4]=$row[3];
					$pctasb["$row[0]"][9]=$row[4];
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
								$pctasb["$ncuenta"][5]+=$pctasb[$k][5];
								$pctasb["$ncuenta"][6]+=$pctasb[$k][6];
								$pctasb["$ncuenta"][7]+=$pctasb[$k][7];
								$pctasb["$ncuenta"][8]+=$pctasb[$k][8];
								$pctasb["$ncuenta"][9]+=$pctasb[$k][9];
							}
						}
						$k++;
					}
				}
				$sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),saldoinicial double,debito double,credito double,saldofinal double, fecha date,debitocien double,creditocien double,debitoconver double,creditoconver double,cc varchar(2))";
				//echo $sqlr;
				mysql_query($sqlr,$linkbd);
				$i=1;
				foreach($pctasb as $k => $valores )
				{
					//echo $pctasb[$k][0]."<br>";
					$saldofinal=$pctasb[$k][1]+$pctasb[$k][2]-$pctasb[$k][3];
					
					$nomc=existecuenta($pctasb[$k][0]);	 
					$sqlr="insert into usr_session (id,cuenta,nombrecuenta,saldoinicial,debito,credito,saldofinal, fecha,debitocien,creditocien,debitoconver,creditoconver,cc) values($i,'".$pctasb[$k][0]."','".$nomc."','".$pctasb[$k][1]."','".$pctasb[$k][2]."','".$pctasb[$k][3]."','".$saldofinal."','".$pctasb[$k][4]."','".$pctasb[$k][5]."','".$pctasb[$k][6]."','".$pctasb[$k][7]."','".$pctasb[$k][8]."','".$pctasb[$k][9]."')";
					mysql_query($sqlr,$linkbd);
					$i+=1;
					//echo "<br>cuenta:".$k."  ".$pctasb[$k][7]."  ".$pctasb[$k][8];	
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
				$suma='';
				$sumadebcien='';
				$sumacrecien='';
				$sumadebcover='';
				$sumacrecover='';
				$sumacre=0;
				$sumadeb=0;
				$sumfin='';
				//echo "hola".$sqlr;
				while($row=mysql_fetch_row($res))
				{	
					//echo $row[1]."-".$row[10]."-".$row[12]."<br>"; 
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
					if($niveles[$_POST[nivel]]==strlen($row[1]))
					{
						$negrilla=" ";  
						$dobleclick="ondblclick='direccionaCuentaGastos(this)'";
						$_POST[tsaldoant]+=$row[3];
						$_POST[tdebito]+=$row[4];
						$_POST[tcredito]+=$row[5];			  
						$_POST[tsaldofinal]+=$row[6];			  	
						//$_POST[cc][$x] = $row[12];
						$sqlc="select * from cuentasaldos where cuenta='$row[1]' and trimestre='$trimchip' and vigencia='$vigchip'";
						$resc=mysql_query($sqlc, $linkbd);
						$rowc=mysql_fetch_array($resc);
						// se quita la division entre 1000
						$miles=$row[3];
						//echo $row[12];echo "<br> ";
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
						
						$sqlr4="SELECT cuentaexterna,nombrecuenta,cc FROM contcuentashomologacion WHERE cuentacentral='$row[1]'";
						$res4=mysql_query($sqlr4,$linkbd);
						$ro4=mysql_fetch_row($res4);
						
						if($_POST[cuentanicsp][$x]=='' && $_POST[oculto1]=='2')
						{
							$_POST[cuentanicsp][$x]=$ro4[0];
							$_POST[nomcuentanicsp][$x]=$ro4[1];
							$_POST[ccnicsp][$x]=$ro4[2];
						}
						
						//$miles=abs($miles); 
						//$miles=$miles*$signo;				
						//$rowc[2]=abs($rowc[2]); 
						//$rowc[2]=$rowc[2]*$signo;
						
						//$newvalor=0;
						//$newvalor=number_format($miles,$row[6],",",".");
						//echo $newvalor;
						if(round($row[6],2)!='0' || round($row[8],2)!='0' || round($row[9],2)!='0' || round($row[10],2)!='0' || round($row[11],2)!='0')
						{
							$sald='';
							$nomcuenta='';
							$saldof=$row[6];
							$saldebcien=$row[8];
							$salcrecien=$row[9];
							$saldebconver=$row[10];
							$salcreconver=$row[11];
							$saldeb='';
							$salcred='';
							$signon=1;
							if($_POST[inserte]=='1')
							{
								$sald=$saldof+$saldebcien-$salcrecien+$saldebconver-$salcreconver;
								if($sald<0)
								{
									$signon=-1;
									$saldofcre=$saldof*(-1);
									$saldeb=$sald*(-1);
								}
								else
								{
									$salcred=$saldof+$saldebcien-$salcrecien+$saldebconver-$salcreconver;
								}
							}
							$nomcuenta=buscacuenta($_POST[cuentanicsp][$x]);
							$saldofinal1=$saldof+$saldebcien-$salcrecien+$saldeb-$salcred+$saldebconver-$salcreconver;
							echo "<tr class='$co' style='text-transform:uppercase; $estilo' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td $negrilla>$row[1]</td>
							<td $negrilla>$row[2]</td>
							<td $negrilla align='right'>".number_format($saldof,2,".",",")."</td>
							<td $negrilla align='right'>".number_format($saldebcien,2,".",",")."</td>
							<td $negrilla align='right'>".number_format($salcrecien,2,".",",")."</td>
							<td $negrilla align='right'>".number_format($saldebconver,2,".",",")."</td>
							<td $negrilla align='right'>".number_format($salcreconver,2,".",",")."</td>";
							if($_POST[inserte]=='1')
							{
								echo "<!---datos excel --->
								<input type='hidden' name='dexcelc[]' value= '".$row[1]."'>
								<input type='hidden' name='dexcel1[]' value= '".$saldof."'>
								<input type='hidden' name='dexcel2[]' value= '".$saldebcien."'>
								<input type='hidden' name='dexcel3[]' value= '".$salcrecien."'>
								<input type='hidden' name='dexcel7[]' value= '".$saldebconver."'>
								<input type='hidden' name='dexcel8[]' value= '".$salcreconver."'>
							<!---datos excel --->";
							}
							if($_POST[inserte]=='1')
							{
								echo"
									<td $negrilla align='right'>".number_format($saldeb,2,".",",")."</td>
									<td $negrilla align='right'>".number_format($salcred,2,".",",")."</td>
									<td $negrilla align='right'>".number_format($saldofinal1,2,".",",")."</td>
									<!---datos excel --->
										<input type='hidden' name='dexcel4[]' value= '".$saldeb."'>
										<input type='hidden' name='dexcel5[]' value= '".$salcred."'>
										<input type='hidden' name='dexcel6[]' value= '".$saldofinal1."'>
									<!---datos excel --->
									";
									if($salcred!=0)
										$sumacre+=$salcred;
									else
										$sumadeb+=$saldeb;
							}
							else
							{
								echo"
									<td $negrilla align='right'></td>
									<td $negrilla align='right'></td>
									<td $negrilla align='right'>".number_format($saldofinal1,2,".",",")."</td>
									";
							}
							echo"
							<td $negrilla align='center'><input type='text' name='cuentanicsp[]' id='cuentanicsp[]' value= '".$_POST[cuentanicsp][$x]."'> </td>
							<td style='width:100%'>
								<input type='text' style='width:100%' name='nomcuentanicsp[]' class='inpnovisibles' value= '".$nomcuenta."'>
								<input type='hidden' name='ccnicsp[]' value= '".$_POST[ccnicsp][$x]."'> 
							</td>";
							if($_POST[inserte]=='1')
							{
								$saldotot=($saldeb+$salcred)*$signon;
								echo "<tr class='$co' style='text-transform:uppercase; $estilo' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" >
								<td $negrilla>".$_POST[cuentanicsp][$x]."</td>
								<td $negrilla>$row[2]</td>
								<td $negrilla align='right'></td>
								<td $negrilla align='right'></td>
								<td $negrilla align='right'></td>
								<td $negrilla align='right'></td>
								<td $negrilla align='right'></td>
								<td $negrilla align='right'>".number_format($salcred,2,".",",")."</td>
								<td $negrilla align='right'>".number_format($saldeb,2,".",",")."</td>
								<td $negrilla align='right'>".number_format($saldotot,2,".",",")."</td>
								<td $negrilla align='center'><input type='text' name='cuentanicsp[]' id='cuentanicsp[]' value= ''> </td>
								<td style='width:100%'><input type='text' style='width:100%' name='nomcuentanicsp[]' class='inpnovisibles' value= ''><input type='hidden' name='ccnicsp[]' value= '".$_POST[ccnicsp][$x]."'> </td>
								<!---datos excel --->
									<input type='hidden' name='dexcelc[]' value= '".$_POST[cuentanicsp][$x]."'>
									<input type='hidden' name='dexcel1[]' value= '0'>
									<input type='hidden' name='dexcel2[]' value= '0'>
									<input type='hidden' name='dexcel3[]' value= '0'>
									<input type='hidden' name='dexcel7[]' value= '0'>
									<input type='hidden' name='dexcel8[]' value= '0'>
									<input type='hidden' name='dexcel4[]' value= '".$salcred."'>
									<input type='hidden' name='dexcel5[]' value= '".$saldeb."'>
									<input type='hidden' name='dexcel6[]' value= '".$saldotot."'>
								<!---datos excel --->
								";
								//echo $salcred." - ".$saldeb."<br>";
								if($salcred!=0)
									$sumacre+=$salcred;
								else
									$sumadeb+=$saldeb;
							}
							
							$suma+=$row[6];
							$sumadebcien+=$row[8];
							$sumacrecien+=$row[9];
							$sumadebcover+=$row[10];
							$sumacrecover+=$row[11];
								echo "<input type='hidden' name='dcuentas[]' value= '".$row[1]."'> 
								<input type='hidden' name='dncuentas[]' value= '".$row[2]."'>
								<input type='hidden' name='dsaldoant[]' value= '".$row[3]."'>
								<input type='hidden' name='dsaldochip[]' value= '".$rowc[2]."'> 
								<input type='hidden' name='saldfinal[]' value= '".round($row[6],2)."'> 
								<input type='hidden' name='cc1[]' value= '".$row[12]."'> 
							</td>
							</tr>
							" ;	 
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							$i=1+$i;
							$x=$x+1;
						}
					}
				}
				$sumafin=$suma+$sumadebcien-$sumacrecien+$sumadebcover-$sumacrecover+$sumadeb-$sumacre;
				//echo $sumafin." - ".$suma." + ".$sumadebcien." - ".$sumacrecien." + ".$sumadeb." - ".$sumacre;
				echo "<tr>
						<td></td>
						<td></td>
						<td align='right'>".number_format($suma,2,".",",")."</td>
						<td align='right'>".number_format($sumadebcien,2,".",",")."</td>
						<td align='right'>".number_format($sumacrecien,2,".",",")."</td>
						<td align='right'>".number_format($sumadebcover,2,".",",")."</td>
						<td align='right'>".number_format($sumacrecover,2,".",",")."</td>
						<td align='right'>".number_format($sumadeb,2,".",",")."</td>
						<td align='right'>".number_format($sumacre,2,".",",")."</td>
						<td align='right'>".number_format($sumafin,2,".",",")."</td>

						</tr>
					</table>";
  $horafin=date('h:i:s');	
  echo "<DIV class='ejemplo'>INICIO:$horaini FINALIZO: $horafin</DIV>";
				
				
			}
			if($_POST[oculto]=='3') //**********guardar la configuracion de la cuenta
			{
				
				$link=conectar_bd();
				$sql="DELETE FROM contcuentashomologacion ";
				mysql_query($sql,$link);
				for($x=0;$x<count($_POST[cuentanicsp]);$x++)
				{
					if($_POST[cuentanicsp][$x]!='')
					{
						$arreglo=explode("-",$_POST[concecausa][$x]);
						$sqlr="insert into contcuentashomologacion (cuentacentral,cuentaexterna,nombrecuenta,vigencia,saldo,cc) values ('".$_POST[dcuentas][$x]."','".$_POST[cuentanicsp][$x]."','".$_POST[nomcuentanicsp][$x]."','$vigusu','".$_POST[saldfinal][$x]."','".$_POST[cc1][$x]."')";
						mysql_query($sqlr,$link);
					}
					
				}
				?>
				<script>
					document.form2.oculto.value='2';
					document.form2.oculto1.value='2';
					document.form2.submit();
				</script>
				<?php
			}
			if($_POST[oculto]=='4') //**********Generar comprobante Inicial NICSP
			{
				$link=conectar_bd();
				$sql="DELETE FROM comprobante_det where tipo_comp='102' AND numerotipo='1'";
				mysql_query($sql,$link);
				$sql="DELETE FROM comprobante_cab where tipo_comp='102' AND numerotipo='1'";
				mysql_query($sql,$link);
				$consec='1';
				$sql="insert into comprobante_cab(numerotipo, tipo_comp, fecha, concepto, total,total_debito,total_credito,diferencia,estado) values ('$consec','102','2018-01-01','Comprobante inicial NICSP',0,0,0,0,'1')";
				mysql_query($sql,$link);
				$sql="Select nit from configbasica where estado='S'";
				$res=mysql_query($sql,$link);
				$row=mysql_fetch_row($res);
				$tercero=$row[0];
				for($x=0;$x<count($_POST[cuentanicsp]);$x+=2)
				{
					$valdebito=$_POST[dexcel5][$x];
					$valcredito=$_POST[dexcel4][$x];
					if($_POST[cuentanicsp][$x]!='')
					{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('102 $consec','".$_POST[cuentanicsp][$x]."','".$tercero."' ,'".$_POST[ccnicsp][$x]."' , 'Comprobante inicial NICSP','','".round($valdebito,2)."',".round($valcredito,2).",'1' ,'2018')";
						mysql_query($sqlr,$link);
					}
					
				}
				$sql="DELETE FROM comprobante_det where tipo_comp='103' AND numerotipo='1'";
				mysql_query($sql,$link);
				$sql="DELETE FROM comprobante_cab where tipo_comp='103' AND numerotipo='1'";
				mysql_query($sql,$link);
				$consec='1';
				$sql="insert into comprobante_cab(numerotipo, tipo_comp, fecha, concepto, total,total_debito,total_credito,diferencia,estado) values ('$consec','103','2018-01-01','Comprobante inicial NICSP',0,0,0,0,'1')";
				mysql_query($sql,$link);
				for($x=0;$x<count($_POST[dexcelc]);$x+=2)
				{
					$valdebito=$_POST[dexcel4][$x];
					$valcredito=$_POST[dexcel5][$x];
					if($_POST[dexcelc][$x]!='')
					{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('103 $consec','".$_POST[dexcelc][$x]."','".$tercero."' ,'01' , 'Comprobante inicial NICSP','','".round($valdebito,2)."',".round($valcredito,2).",'1' ,'2018')";
						mysql_query($sqlr,$link);
					}
					
				}
				echo "<script>despliegamodalm('visible','1','Se ha almacenado el CDP con Exito');</script>";
			}
        ?> 
		</div>
     
  
<!--	<div class='inicio'>Formato CHIP da Click <a href="<?php //echo "archivos/".$_SESSION[usuario]."chip-$_POST[periodo].csv"; ?>" target="_blank"><img src="imagenes/csv.png"  alt="csv"></a> </div>-->
	 

</form></td></tr>
<tr><td></td></tr>      
</body>
</html>