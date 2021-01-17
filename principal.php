<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
    header("Content-Type: text/html;charset=iso-8859-1");
    
	require 'include/comun.php';
    require 'include/funciones.php';
    
    session_start();
    
    $linkbd = conectar_v7();
    
    //cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
    
    date_default_timezone_set('America/Bogota');
    
	error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    $fec = date('d/m/Y');
    
    software();
    
	if (!isset($_SESSION['usuario']))
	{
		$sqlr = "SELECT * FROM parametros WHERE estado='S'";
        
        $res = mysqli_query($linkbd,$sqlr);
        
        while($r = mysqli_fetch_row($res))
        {
            $vigencia = $r[1];
        }
        
        
        //*** verificar el username y el pass
        
        $users = $_POST['user'];
        
        $pass = $_POST['pass'];
        
        $sqlr = "SELECT U.nom_usu, R.nom_rol, U.id_rol, U.id_usu, U.foto_usu, U.usu_usu, U.cc_usu FROM usuarios U, roles R WHERE U.usu_usu='$users' AND U.pass_usu='$pass' AND U.id_rol = R.id_rol AND U.est_usu='1'";
        
        $res = mysqli_query($linkbd,$sqlr);
        
        while($r = mysqli_fetch_row($res))
		{
			$user = $r[0];
			$perf = $r[1];
			$niv = $r[2];
			$idusu = $r[3];
			$nick = $r[5];
			$dirfoto = $r[4];
			$cedusu = $r[6];
		}
		if ($user == "")
		{
			//login incorrecto
			echo"<br><br><br><br><br><br><br><center><table border='1' cellpadding='0' cellspacing='0' bordercolor='#FFFFFF' width='50%'><tr bgcolor='#000066' colspan='1'><td><center><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif' size='4' ><b>SPID</b></font></center></td></tr>";
			echo "<TR bgcolor='#99bbcc' colspan='1'><td>";
			die("<center><h3><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif'>Error: Usuario o Contrase&ntilde;a Incorrecta, para volver a intentarlo da <a href=index.php >click aqui</a></font></h3></center></td></TR></table></center>");
		}
		else
		{
			//login correcto
			$_SESSION['vigencia'] = $vigencia;
			$_SESSION['usuario'] = array();
			$_SESSION['usuario'] = $user;
			$_SESSION['perfil'] = $perf;
			$_SESSION['idusuario'] = $idusu;
			$_SESSION['nickusu'] = $nick;
			$_SESSION['cedulausu'] = $cedusu;
			$_SESSION['nivel'] = $niv;
            $_SESSION['linkmod'] = array();
            
            if($dirfoto == '')
            {
                $_SESSION['fotousuario'] = '../../img/icons/usuario_on.png';
            }
            else
            {
                $_SESSION["fotousuario"] = '../../img/user_profile_photos/'.$dirfoto;
            }

			$corresmensaje = "1";
			$sqlr = "SELECT * FROM usuarios_privilegios WHERE id_usu = '$idusu'";
			$row = mysqli_fetch_row(mysqli_query($linkbd,$sqlr)); 
			//$_SESSION["prcrear"]=$row[1];
			//$_SESSION["preditar"]=$row[2];
			//$_SESSION["prdesactivar"]=$row[3];
			//$_SESSION["preliminar"]=$row[4];
			$_SESSION['prcrear'] = 1;
			$_SESSION['preditar'] = 1;
			$_SESSION['prdesactivar'] = 1;
            $_SESSION['preliminar'] = 1;
            
            $sqlr = "SELECT valor_inicial, valor_final, descripcion_valor FROM dominios WHERE nombre_dominio = 'SEPARADOR_NUMERICO'";
            
            $row = mysqli_fetch_assoc(mysqli_query($linkbd,$sqlr));
            
            if(isset($row))
            {
                if($row[0]!='')
                {
                    $_SESSION['spdecimal'] = $row['valor_inicial'];
                }
                else 
                {
                    $_SESSION['spdecimal'] = '.';
                }
                if($row[1]!='')
                {
                    $_SESSION['spmillares'] = $row['valor_final'];
                }
                else 
                {
                    $_SESSION['spmillares'] = ',';
                }
                if($row[2]!='')
                {
                    $_SESSION['ndecimales'] = $row['descripcion_valor'];
                }
                else 
                {
                    $_SESSION['ndecimales'] = 2;
                }
            }

            //******************* menuss ************************
			//***** NUEVO REVISION DE LOS MODULOS ***************
			$sqlr = "SELECT DISTINCT (modulos.nombre),modulos.id_modulo,modulos.libre FROM modulos, modulo_rol WHERE modulo_rol.id_rol=$niv AND modulos.id_modulo=modulo_rol.id_modulo GROUP BY (modulos.nombre),modulos.id_modulo,modulos.libre ORDER BY modulos.id_modulo";
			//$linkset[$x]="";
			$res = mysqli_query($linkbd,$sqlr);
            while($roww = mysqli_fetch_row($res))
            {
                @$_SESSION['linkmod'][$roww[1]] .= $roww[2];
            }

			//verificaci�n de tipo de caracteres
			$sqlr = "SELECT valor_inicial, valor_final FROM dominios WHERE nombre_dominio = 'TIPO_CARACTER_VERPHP'";
			$row =mysqli_fetch_row(mysqli_query($linkbd,$sqlr));
			$_SESSION['VERCARPHPINI'] = $row[0];
			$_SESSION['VERCARPHPFIN'] = $row[1];
			$sqlr = "SELECT valor_inicial, valor_final FROM dominios WHERE nombre_dominio = 'TIPO_CARACTER_VERPDF'";
			$row = mysqli_fetch_row(mysqli_query($linkbd,$sqlr));
			$_SESSION['VERCARPDFINI'] = $row[0];
			$_SESSION['VERCARPDFFIN'] = $row[1];
			//registro log
			$accion = "USUARIO INICIA SESION EN EL SISTEMA";
			$origen = getUserIpAddr();
			generaLogs($_SESSION['nickusu'],'PRI','V',$accion,$origen);
		}
	}
?>
<!DOCTYPE >
<html xmlns = "http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>

		<title>:: FINANCIERO</title>

		<link href="css/css2.css" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css" rel="stylesheet" type="text/css"/>

		<!-- Start of  Zendesk Widget script -->
		<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=b8b9a1b1-9a0e-4e76-bbf2-bd209c380d4e"></script>
		<!-- End of  Zendesk Widget script -->

		<style>
			body
			{
				background: url("img/modules_background.jpg");
				background-size: cover !important;
				margin: 0 !important;
			}
		</style>
		<script type = "text/javascript" src = "js/programas.js"></script>
		<script type = "text/javascript" src = "js/funcioneshf.js"></script>
		<script type = 'text/javascript' src = "js/JQuery/jquery-2.1.4.min.js"></script>
		<script type = "text/javascript" src = "js/JQuery/jquery.ripples.js"></script>
		<script>$(document).ready(function(){$('body').ripples({resolution: 512,dropRadius: 10,perturbance: 0.04});});</script>
		<script language="javascript">
			var infecha= new Array();
			var idtarea= new Array();
			var tiptarea= new Array();
			var pagtarea= new Array();
			var inhorain= new Array();
			var inevento= new Array();
			var indescripc=new Array();
			var inprioridad= new Array();
			var colorprio= new Array();
			var contarmen = 0;
			var ainfech = new Array();
			var ainhorain = new Array();
			var ainevento = new Array();
			var aindescripc =new Array();
			var ainprioridad = new Array();
			var acolorprio = new Array();
			var acontarmen = 0;
			var infid=new Array();
			var inftitulos = new Array();
			var infcontarmen = 0;
			var idgeneral;
			var idgeneral;
			function detenermar(marqid){document.getElementById(marqid).scrollAmount = 0;}
			function arrancarmar(marqid){document.getElementById(marqid).scrollAmount = 2;}
			function despliegamodal(_valor){document.getElementById("bgventanamodal").style.visibility = _valor;}
			function despliegamodalm(_valor,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility = _valor;
				if(_valor == "hidden"){document.getElementById('ventanam').src="";}
                else
                {
                    document.getElementById('ventanam').src = "modules/modals/ventana-mensaje3.php?titulos=" + mensa;
                }
			}
			function tipopresupuesto(_valor)
			{
				document.getElementById("bgventanamodalm").style.visibility = _valor;
				if(_valor == "hidden"){document.getElementById('ventanam').src = "";}
				else
				{
					document.getElementById('ventanam').src = "modules/modals/ventana-tipopresupuesto.php";
				}
			}
			function presupuesto_normal()
			{
				if(document.getElementById('npresupuesto').value!= '')
				{location.href = document.getElementById('npresupuesto').value;}
			}
			function presupuesto_ccpet()
			{
				if(document.getElementById('npresupuestoccpet').value!= '')
				{location.href = document.getElementById('npresupuestoccpet').value;}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src = "alertas.php" name = "alertas" id = "alertas" style = "display:none"></IFRAME>
		<span id="todastablas2"></span>
		<br><br><br><br>
		<table class="tablaprin">
			<tr></tr>
			<tr>
				<td rowspan="2" margin-top="100px;" style="padding-left: 7px;"><img src="img/ideal_logo_dark.png" align="texttop" style="width:100%; height:85%; opacity: 0.5;border-radius: 10px;"/></td>
				<td>
					<table>
						<tr>
							<td><a href="<?php echo @$_SESSION['linkmod'][1];?>"  accesskey="1"><img src="img/modules/contabilidad.png" alt="contabilidad" border="0" onMouseOver="src='img/modules/contabilidad2.png'" onMouseOut="src='img/modules/contabilidad.png'" style=" width:100%;"></a></td>
							<td><a href="<?php echo @$_SESSION['linkmod'][8];?>" ><img src="img/modules/contratacion.png" alt="contratacion" border="0" onMouseOver="src='img/modules/contratacion2.png'" onMouseOut="src='img/modules/contratacion.png'"></a></td>
							<td><a href="<?php echo @$_SESSION['linkmod'][2];?>" ><img src="img/modules/nomina.png" alt="nomina" onMouseOut="src='img/modules/nomina.png'" onMouseOver="src='img/modules/nomina2.png'"></a></td>
						</tr>
						<tr>
							<td><a href="<?php echo @$_SESSION['linkmod'][9];?>" ><img src="img/modules/planeacion.png" alt="planeacion" onMouseOut="src='img/modules/planeacion.png'" onMouseOver="src='img/modules/planeacion2.png'"></a></td>
							<td onClick="tipopresupuesto('visible');"><img src="img/modules/presupuesto.png" alt="presupuesto" onMouseOut="src='img/modules/presupuesto.png'" onMouseOver="src='img/modules/presupuesto2.png'"></a></td>
							<td><a href="<?php echo @$_SESSION['linkmod'][7];?>" ><img src="img/modules/meci.png" alt="meci" onMouseOut="src='img/modules/meci.png'" onMouseOver="src='img/modules/meci2.png'"></a></td>
						</tr>
						<tr>
							<td><a href="<?php echo @$_SESSION['linkmod'][4];?>" accesskey="7"><img src="img/modules/tesoreria.png" alt="tesoreria" onMouseOut="src='img/modules/tesoreria.png'" onMouseOver="src='img/modules/tesoreria2.png'"></a></td>
							<td><a href="<?php echo @$_SESSION['linkmod'][6];?>" ><img src="img/modules/activosfijos.png" onMouseOut="src='img/modules/activosfijos.png'" onMouseOver="src='img/modules/activosfijos2.png'"></a></td>
							<td><a href="<?php echo @$_SESSION['linkmod'][5];?>" ><img src="img/modules/almacen.png" alt="almacen" onMouseOut="src='img/modules/almacen.png'" onMouseOver="src='img/modules/almacen2.png'"></a></td>
						</tr>
						<tr>
							<td><a href="<?php echo @$_SESSION['linkmod'][10];?>" title="Archivo"><img src="img/modules/serviciospublicos.png"  onMouseOut="src='img/modules/serviciospublicos.png'" onMouseOver="src='img/modules/serviciospublicos2.png'"></a></td>
							<td><a href="<?php echo @$_SESSION['linkmod'][0];?>"><img src="img/modules/administracion.png" alt="administracion" onMouseOut="src='img/modules/administracion.png'" onMouseOver="src='img/modules/administracion2.png'"></a></td>
							<td><a href="login.php" title="salir"><img src="img/modules/salir.png"  onMouseOut="src='img/modules/salir.png'" onMouseOver="src='img/modules/salir2.png'"></a></td>
						</tr>
					</table>
				</td>
			</tr>
			<input type="hidden" name="npresupuesto" id="npresupuesto" value="<?php echo @$_SESSION['linkmod'][3];?>"/>
			<input type="hidden" name="npresupuestoccpet" id="npresupuestoccpet" value="<?php echo @$_SESSION['linkmod'][11];?>"/>
			<?php
				$sqlr = "CREATE TEMPORARY TABLE usr_session (cedula_usuario varchar(20))";
				$sqlr = "INSERT INTO usr_session values ('".$_SESSION['usuario']."')";
				if(!mysqli_query($linkbd,$sqlr))
				{
					//echo "NO SE INSERTÓ:".mysql_error($linkbd);
				}
				else
				{
					$sqlr = "SELECT cedula_usuario FROM usr_session WHERE cedula_usuario = '".$_SESSION['usuario']."'";
					$res = mysqli_query($linkbd,$sqlr);
					$row = mysqli_fetch_array($res);
					//echo "<DIV class='resaltado'>DEVOLVIO:".$row[0]."</DIV>"; corcumare  corp social y cultural del cumare
				}
			?>
			<tr>
			</tr>
			<tr>
				<td valign="top" colspan="2">
				<div  class="inicio" style=" width:99.2%; height:10%;" ><img src="img/modules/soluciones.png" alt="soluciones estrategicas integrales" style=" width:55%; height:100%;">
						<?php
						echo "<label class='saludo1' style='float:right; margin-top:3px; vertical-align:central; margin-bottom:0px;'>:::: ".vigencia_usuarios($_SESSION['cedulausu'])." <img src='img\icons\confirm.png'> ::::</label>";
						?>
						<li style="vertical-align:bottom; line-height: 25px; float:right" ><a href="#">Ir a: <input id="atajos" name="atajos" type="search" size="11" placeholder="Digite atajo..." onKeyPress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li>
					</div>
				</td>
			</tr>
			<?php //***Tareas***
				$sqlr = "SELECT fechasig,codigo,codradicacion,proceso,tipot FROM planacresponsables WHERE estado='AN' AND usuariocon = '".$_SESSION['cedulausu']."' ORDER BY codigo ASC;";
				
				if($res = mysqli_query($linkbd,$sqlr))
				{
					while ($rowEmp = mysqli_fetch_row($res))
					{
						$fechamen = $rowEmp[0];
						$rescod = $rowEmp[1] - 1;
						$idtarea = $rowEmp[1];
						$idpag = $rowEmp[2];
						$tipotarea = $rowEmp[4];
						$desevento = $rowEmp[3];
						echo"
						<script>
						{
							infecha[contarmen] = '$fechamen';
							indescripc[contarmen] = '$desevento';
							idtarea[contarmen] = '$idtarea';
							pagtarea[contarmen] = '$idpag';
							tiptarea[contarmen] = '$tipotarea';
							contarmen++;
						}
						</script>";
					}

				}
				
				$sqlr = "SELECT * FROM agenda WHERE fechaevento >= CURDATE() AND usrecibe='".$_SESSION['cedulausu']."'";
				
				$res = mysqli_query($linkbd,$sqlr);
				
				while ($rowEmp = mysqli_fetch_assoc($res))
				{
					$fechamen = $rowEmp['fechaevento'];
					$fechven = $rowEmp['horainicial'];
					$nomeven = $rowEmp['evento'];
					$desevento = $rowEmp['descripcion'];
					$prioeven = $rowEmp['prioridad'];
					$sqlr3 = "SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_EVENTO_AG' AND valor_inicial='$nomeven'";
					$res3 = mysqli_query($linkbd,$sqlr3);
					$temensa = mysqli_fetch_assoc($res3);
					$texmensaje = $temensa['descripcion_valor'];
					$sqlr2 = "SELECT valor_final FROM dominios WHERE nombre_dominio='PRIORIDAD_EVENTOS_AG' AND valor_inicial='$prioeven'";
					$res2 = mysqli_query($linkbd,$sqlr2);
					$colmensa = mysqli_fetch_assoc($res2);
					$colorevento = $colmensa['valor_final'];
					echo"
					<script>
					{
						ainfecha[acontarmen] = '$fechamen';
						ainhorain[acontarmen] = '$fechven';
						ainevento[acontarmen] = '$texmensaje';
						aindescripc[acontarmen] ='$desevento';
						ainprioridad[acontarmen] = '$prioeven';
						acolorprio[acontarmen] = '$colorevento';
						acontarmen++;
					}
					</script>";
				}
				$fec = date("Y-m-d");
				$sqlr = "SELECT * FROM infor_interes WHERE '$fec' BETWEEN fecha_inicio AND fecha_fin AND estado='S'";
				$res = mysqli_query($linkbd,$sqlr);
				while ($rowEmp = mysqli_fetch_assoc($res))
				{
					$infoid = $rowEmp['indices'];
					$infotitulos = $rowEmp['titulos'];
					echo"
					<script>
					{
						infid[infcontarmen] = '$infoid';
						inftitulos[infcontarmen] = '$infotitulos';
						infcontarmen++;
					}
					</script>";
				}
			?>
			<tr>
				<td colspan="2">
					<table class="inicio" style=" width:99%;">
						<tr>
							<td>
								<div class="cmarquesina" >
									<img src="img\icons\tareas.png">
									<a href="plan-actareasbusca.php" style="font-size:13px; font-weight:normal; background-color: #990; color:#FFF; font-weight:bold; font-family: Tahoma, Geneva, sans-serif" >::: Tareas Spid ::: </a>
									<label class="etiq1">(<script>document.write(contarmen);</script>)</label><br>
									<marquee  id="cmarquesina"  direction="up" scrollamount="2" scrolldelay="100" height="60">
										<script>
											for(var xx=0;xx<contarmen;xx++)
											{
												document.write('<div class="mmensajes"><a class="letmar" id="letmar" href="#" onClick="mypop=window.open(\'plan-actareasresponder.php?idradicado='+pagtarea[xx]+'&idresponsable='+idtarea[xx]+'&tipoe=AN&tiporad='+tiptarea[xx]+'\',\'\',\'\');mypop.focus();" onMouseOver="document.getElementById(\'cmarquesina\').stop()" onMouseOut="document.getElementById(\'cmarquesina\').start()"><label>:&middot </label>'+infecha[xx]+'<label> &middot:</label><br><label style="font-size:12px; font-weight: normal;" >&nbsp;&nbsp;&nbsp;'+indescripc[xx].substring(0,100)+'...(ver mas)</label></a></div><br>');
											}
										</script>
									</marquee>
								</div>
							</td>
							<td>
								<div class="cmarquesina">
									<img src="img\icons\agenda.png">
									<a href="plan-agenda.php?pagini=principal.php" style="font-size:13px; font-weight:normal; background-color: #39F;color:#FFF; font-weight:bold; font-family: Tahoma, Geneva, sans-serif">::: Agenda Spid ::: </a>
									<label class="etiq1">(<script>document.write(acontarmen);</script>)</label>
									<marquee  id="cmarquesina2"  direction="up" scrollamount="2" scrolldelay="100" height="60" onMouseOut="arrancarmar(this.id);" onMouseMove="detenermar(this.id);">
										<script>
											for(var xx=0;xx<acontarmen;xx++)
											{
												document.write('<div class="mmensajes"><a class="letmar" id="letmar" href="#" onClick="mypop=window.open(\'plan-agenda.php?pagini=principal.php&fechamen='+ainfecha[xx]+'\',\'\',\'\');mypop.focus();" onMouseOver="document.getElementById(\'cmarquesina2\').stop()" onMouseOut="document.getElementById(\'cmarquesina2\').start()"><label style="color:'+acolorprio[xx]+'">:&middot </label>'+ainfecha[xx]+' - '+ainevento[xx]+'<label style="color:'+acolorprio[xx]+'"> &middot:</label><br><label style="font-size:12px; font-weight: normal;" >&nbsp;&nbsp;&nbsp;'+aindescripc[xx].substring(0,20)+'...(ver mas)</label></a></div><br>');
											}
										</script>
									</marquee>
								</div>
							</td>
							<td>
								<div class="cmarquesina"><img src="img\icons\infoma.png">
									<a href="#" style="font-size:13px; font-weight:normal; background-color: #F90; color:#FFF; font-weight:bold; font-family: Tahoma, Geneva, sans-serif">::: Publicaciones Spid :::</a>
									<label class="etiq1">(<script>document.write(infcontarmen);</script>)</label><br>
									<marquee  id="cmarquesina3"  direction="up" scrollamount="2" scrolldelay="100" height="60" onMouseOut="arrancarmar(this.id);" onMouseMove="detenermar(this.id);">
										<script>
											for(var xx=0;xx<infcontarmen;xx++)
											{
												document.write('<div class="mmensajes"><a class="letmar"  href="#" id="letmar"  onClick="document.nuevomen.idoculto.value='+infid[xx]+'; cargarpagina(); despliegamodal(\'visible\');"  onMouseOver="document.getElementById(\'cmarquesina3\').stop()" onMouseOut="document.getElementById(\'cmarquesina3\').start()"><label>:&middot </label>'+inftitulos[xx]+'<label> &middot:</label><br></a></div><br>');
											}
										</script>
									</marquee>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden; border-radius:5px;"></IFRAME>
			</div>
		</div>
		<form id="nuevomen" name="nuevomen" method="post">
		<div id="bgventanamodal">
			<div id="ventanamodal">
				<a href="javascript:despliegamodal('hidden');" style="position: absolute; left: 810px; top: 8px; z-index: 100;"><img src="img/icons/exit.png" alt="cerrar" width=27 height=27>Cerrar</a>
 				<input id="idoculto" name="idoculto" type="hidden" value="<?php echo @$_POST['idoculto']?>"/>
				<div id="formdesplegable">
					<script>
						function cargarpagina()
						{
							document.getElementById('formdesplegable').innerHTML=('<IFRAME src="plan-mostrainformacion.php?idinfo='+document.nuevomen.idoculto.value+'" name="otras" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>');
						}
					</script>
				</div>
			</div>
		</div>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;">
				</IFRAME>
			</div>
		</div>
		<?php if(@$corresmensaje=="1") {echo "<script>despliegamodalm('visible','La Vigencia actual es: ".vigencia_usuarios($_SESSION['cedulausu'])."');</script>";}?>
		<script>
			document.getElementById("atajos").focus();
			//mortal_strike()
		</script>
		</form>
	</body>
</html>
