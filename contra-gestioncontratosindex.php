<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
$linkbd=conectar_bd();	
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Contrataci&oacute;n</title>
		<script>
            function despliegamodal(_valor,_tip)
			{
				document.getElementById("bgventanamodal1").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana1').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventana1').src="contra-soladquisicionesventana.php";break;
						case "2":
							document.getElementById('ventana1').src="contra-soladquisicionesterceros.php";break;
						case "3":
							document.getElementById('ventana1').src="contra-productos-ventana2.php";break;
						case "4":
							var tipo=parent.venguardar.document.getElementById('tipocuenta').value;
							document.getElementById('ventana1').src="contra-soladquisicionescuentasppto.php?ti=2&ti2="+tipo;break;
						case "5":
							document.getElementById('ventana1').src="contra-soladquisicionesproyectos.php";break;
					}
				}
			}
			function despliegamodalm(_valor,_tip,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guardo la solicitud de Adqusici\xf3n con Exito";break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;	
					}
				}
			}
			function cambiobotones1()
			{
				document.getElementById('bguardar').innerHTML='<img src="imagenes/guarda.png"  onClick=" parent.venguardar.guardar(\'hidden\');"/>';
				document.getElementById('impre').innerHTML='<img src="imagenes/print_off.png" alt="Imprimir" style="width:30px;" >';
			} 
			function cambiobotones2()
			{
				document.getElementById('bguardar').innerHTML='<img src="imagenes/guardad.png" />';
				document.getElementById('impre').innerHTML='<img src="imagenes/print.png" alt="Imprimir" onClick="parent.venvercdp.pdf()" >';
				

			} 
			function funcionmensaje(){parent.venguardar.funcionmensaje();}
			function cerrarventanas()
			{
				document.form2.action="contra-principal.php";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			
			}
		</script>
		<script type="text/javascript" src="botones.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
            <tr>
				<td colspan="3" class="cinta">
					<a id="bnuevo" href="contra-soladquisicionesindex.php?ind=1" class="mgbt"><img src="imagenes/add.png" title="Nuevo"></a>
					<a id="bguardar" href="#" class="mgbt"><img src="imagenes/guarda.png"  onClick="parent.venguardar.guardar('hidden')"></a>
					<a href="contra-soladquisicionesbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a id="impre" href="#" class="mgbt"><img src="imagenes/print_off.png" title="Imprimir" style="width:30px;"></a>
				</td>
            </tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post">
        <?php
			if($_POST[indindex]=="")
			{
				$_POST[indindex]=$_GET[ind];
				$_POST[codid]=$_GET[codid];
				$cmoff='imagenes/sema_rojoOFF.jpg';
				$cmrojo='imagenes/sema_rojoON.jpg';
				$cmamarillo='imagenes/sema_amarilloON.jpg';
				$cmverde='imagenes/sema_verdeON.jpg';
				
				if($_POST[indindex]==1)
				{
					$_POST[conven1]="contra-soladquisiciones1.php";
					$_POST[conven3]="contra-soladquisiciones2.php";
					$_POST[conven4]="contra-soladquisiciones3.php";
					$_POST[conven2]="contra-soladquisicionescdpver.php?codcdp=0";
					$check1="checked";
					$p1luzcem1=$cmrojo;$p1luzcem2=$cmoff;$p1luzcem3=$cmoff;
					$p2luzcem1=$cmrojo;$p2luzcem2=$cmoff;$p2luzcem3=$cmoff;
				}
				if($_POST[indindex]==2)
				{
					
					$linkbd=conectar_bd();
					$sqlr="SELECT codcdp,vigencia FROM contrasoladquisiciones WHERE codsolicitud='".$_POST[codid]."'";
					$res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res);
					if($row[0]=="")
					{
						$p1luzcem1=$cmoff;$p1luzcem2=$cmamarillo;$p1luzcem3=$cmoff;
						$p2luzcem1=$cmrojo;$p2luzcem2=$cmoff;$p2luzcem3=$cmoff;
						$_POST[conven2]="contra-soladquisicionescdpver.php?codcdp=0";
						$actiblo="";
					}
					elseif($row[0]=="S")
					{
						$p1luzcem1=$cmoff;$p1luzcem2=$cmoff;$p1luzcem3=$cmverde;
						$p2luzcem1=$cmoff;$p2luzcem2=$cmamarillo;$p2luzcem3=$cmoff;
						$_POST[conven2]="contra-soladquisicionescdpver.php?codcdp=0";
						$actiblo="";

					}
					else
					{
						$p1luzcem1=$cmoff;$p1luzcem2=$cmoff;$p1luzcem3=$cmverde;
						$p2luzcem1=$cmoff;$p2luzcem2=$cmoff;$p2luzcem3=$cmverde;
						$_POST[conven2]="contra-soladquisicionescdpver.php?is=".$row[0]."&vig=".$row[1];
						$actiblo="readonly";
					}
					$_POST[conven1]="contra-soladquisicioneseditar.php?codid=".$_POST[codid]."&bloqueo=".$actiblo;
					$check1="checked";
				}
			}
		?>
    	<div class="tabscontra" style="height:76.5%; width:99.6%">
   			<div class="tab"> 
  				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> onClick="cambiobotones1()" >
	   			<label for="tab-1"><img src="<?php echo $p1luzcem1;?>" width="16" height="16"><img src="<?php echo $p1luzcem2;?>" width="16" height="16"><img src="<?php echo $p1luzcem3;?>" width="16" height="16">Datos Prescontractuales</label> 
                	<div class="content" style="overflow:hidden">
                   		<IFRAME src="<?php echo $_POST[conven1];?>" name="venguardar" marginWidth=0 marginHeight=0 frameBorder=0 id="venguardar" frameSpacing=0 style=" width:100%; height:100%;"> 
               			</IFRAME>
                 </div>
            </div>
            <div class="tab"> 
  				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check1;?> onClick="cambiobotones1()" >
	   			<label for="tab-2"><img src="<?php echo $p1luzcem1;?>" width="16" height="16"><img src="<?php echo $p1luzcem2;?>" width="16" height="16"><img src="<?php echo $p1luzcem3;?>" width="16" height="16">Datos Prescontractuales</label> 
                	<div class="content" style="overflow:hidden">
                   		<IFRAME src="<?php echo $_POST[conven3];?>" name="venguardar" marginWidth=0 marginHeight=0 frameBorder=0 id="venguardar" frameSpacing=0 style=" width:100%; height:100%;"> 
               			</IFRAME>
                 </div>
            </div>
            <div class="tab">
       			<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check2;?> onClick="cambiobotones2()"  >
	   			<label for="tab-3"><img src="<?php echo $p2luzcem1;?>" width="16" height="16"><img src="<?php echo $p2luzcem2;?>" width="16" height="16"><img src="<?php echo $p2luzcem3;?>" width="16" height="16"> Anexos Precontractuales</label>	
	  				<div class="content">
						<IFRAME src="<?php echo $_POST[conven2];?>" name="venvercdp" marginWidth=0 marginHeight=0 frameBorder=0 id="venvercdp" frameSpacing=0 style=" width:100%; height:100%;"> 
               			</IFRAME>
                    
                    </div>
      		</div>  
    	</div> 
   	 <div id="bgventanamodal1" class="bgventanamodal" >
            <div id="ventanamodal1" class="ventanamodal">
            	<a href="javascript:despliegamodal('hidden','0');" style="position: absolute; left: 810px; top: 5px; z-index: 100;">		<img src="imagenes/exit.png" alt="cerrar" width=22 height=22>Cerrar</a>
                <IFRAME src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
 		
        	<input type="hidden" name="indindex" id="indindex" value="<?php echo $_POST[indindex];?>">
           	<input type="hidden" name="codid" id="codid" value="<?php echo $_POST[codid];?>">
            <input type="hidden" name="conven1" id="conven1" value="<?php echo $_POST[conven1];?>">
			<input type="hidden" name="conven2" id="conven2" value="<?php echo $_POST[conven2];?>">
            <input type="hidden" name="conven3" id="conven3" value="<?php echo $_POST[conven3];?>">
            <input type="hidden" name="conven4" id="conven4" value="<?php echo $_POST[conven4];?>">
        </form>
</body>
</html>

