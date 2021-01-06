<?php
	require"comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$fec=date("d/m/Y"); 
	software();	
	if (!isset($_SESSION["usuario"]))
	{
 		$sqlr="select * from parametros where estado='S'";
  		$res=mysql_query($sqlr,$linkbd);
		while($r=mysql_fetch_row($res)){$vigencia=$r[1];}
 		//*** verificar el username y el pass
 		$users=$_POST['user'];
 		$pass=$_POST['pass'];
  		$sqlr="Select U.nom_usu, R.nom_rol, U.id_rol, U.id_usu, U.foto_usu, U.usu_usu, U.cc_usu from usuarios U, roles R where U.usu_usu='$users' and U.pass_usu='$pass' and U.id_rol=R.id_rol and U.est_usu='1'";
 		$res=mysql_query($sqlr,$linkbd);
		while($r=mysql_fetch_row($res))
		{
 			$user=$r[0];
    		$perf=$r[1];
    		$niv=$r[2];
 			$idusu=$r[3];
			$nick=$r[5];
			$dirfoto=$r[4];
			$cedusu=$r[6];
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
   			session_start(); 
   			$_SESSION["vigencia"]=$vigencia;
   			$_SESSION["usuario"]=array();
     		//session_register("usuario");
   			//$usuario=array();
			$_SESSION["usuario"]=$user;
		   	$_SESSION["perfil"]=$perf;
		  	$_SESSION["idusuario"]=$idusu;
		   	$_SESSION["nickusu"]=$nick;
		   	$_SESSION["cedulausu"]=$cedusu;  
   			//session_register("perfil");
   			//$perfil="";
   			//$perfil=$perf;
   			$_SESSION["nivel"]=$niv;
   			//session_register("nivel");
   			//$nivel="";
   			//$nivel=$niv;
			//$_SESSION["linkset"]=array();
   			$_SESSION["linkmod"]=array();
   			if($dirfoto==""){$_SESSION["fotousuario"]="imagenes/usuario_on.png"; }
			else {$_SESSION["fotousuario"]="informacion/fotos_usuarios/$dirfoto";}
			$corresmensaje="1";
			$sqlr="SELECT * FROM usuarios_privilegios WHERE id_usu='$idusu'";
			$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
			//$_SESSION["prcrear"]=$row[1];
			//$_SESSION["preditar"]=$row[2];
			//$_SESSION["prdesactivar"]=$row[3];
			//$_SESSION["preliminar"]=$row[4];
			$_SESSION["prcrear"]=1;
			$_SESSION["preditar"]=1;
			$_SESSION["prdesactivar"]=1;
			$_SESSION["preliminar"]=1;
			$sqlr="SELECT valor_inicial, valor_final, descripcion_valor FROM dominios WHERE nombre_dominio='SEPARADOR_NUMERICO'";
			$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
			if($row[0]!=''){$_SESSION["spdecimal"]=$row[0];}
			else {$_SESSION["spdecimal"]='.';}
			if($row[1]!=''){$_SESSION["spmillares"]=$row[1];}
			else {$_SESSION["spmillares"]=',';}
			if($row[2]!=''){$_SESSION["ndecimales"]=$row[2];}
			else {$_SESSION["ndecimales"]=2;}
   			//******************* menuss ************************
			//***** NUEVO REVISION DE LOS MODULOS ***************
  	  		$sqlr="Select DISTINCT (modulos.nombre),modulos.id_modulo,modulos.libre from MODULOS, MODULO_ROL WHERE MODULO_ROL.ID_ROL=$niv and modulos.id_modulo=modulo_rol.id_modulo group by (modulos.nombre),modulos.id_modulo,modulos.libre order by modulos.id_modulo";
   			//$sqlr="Select DISTINCT (opciones.nom_opcion),opciones.ruta_opcion, opciones.niv_opcion from rol_priv, opciones where rol_priv.id_rol=$niv and opciones.id_opcion=rol_priv.id_opcion group by (opciones.nom_opcion), opciones.ruta_opcion, opciones.niv_opcion order by opciones.orden";
			//  echo "<div>ESTES es el sql".$sqlr."</div>";
    		$linkset[$x]="";
	 		$res=mysql_query($sqlr,$linkbd);
			while($roww=mysql_fetch_row($res)){ $_SESSION[linkmod][$roww[1]].=$roww[2];}  
		}	
	}
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <meta http-equiv="expira" content="no-cache">
		<title>:: FINANCIERO</title>
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="funcioneshf.js"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="css/cssrefresh.js"></script>
        <script language="javascript"> 
			var infecha= new Array();
			var idtarea= new Array();
			var pagtarea= new Array();
			var inhorain= new Array();
			var inevento= new Array();
			var indescripc=new Array();
			var inprioridad= new Array();
			var colorprio= new Array();
			var contarmen=0;
			var ainfecha= new Array();
			var ainhorain= new Array();
			var ainevento= new Array();
			var aindescripc=new Array();
			var ainprioridad= new Array();
			var acolorprio= new Array();
			var acontarmen=0;
			var infid=new Array();
			var inftitulos=new Array();
			var infcontarmen=0;
			var idgeneral;
			var idgeneral;
			function detenermar(marqid){document.getElementById(marqid).scrollAmount=0;}
			function arrancarmar(marqid){document.getElementById(marqid).scrollAmount=2;}
			function despliegamodal(_valor){document.getElementById("bgventanamodal").style.visibility=_valor;}
			function despliegamodalm(_valor,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else{document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;}
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<br><br><br><br>
		<table class="tablaprin">
			<tr>
    			<td rowspan="2" valign="top"><img src="imagenes/fondo.png" align="texttop" style="width:100%" ></td>
    			<td>
    				<table>
        				<tr>
            				<td><a href="<?php echo $_SESSION[linkmod][1];?>"  accesskey="1"><img src="imagenes/contabilidad.png" alt="contabilidad" border="0" onMouseOver="src='imagenes/contabilidad2.png'" onMouseOut="src='imagenes/contabilidad.png'" style=" width:100%;"></a></td>
	 						<td><a href="<?php echo $_SESSION[linkmod][8];?>" ><img src="imagenes/contratacion.png" alt="contratacion" border="0" onMouseOver="src='imagenes/contratacion2.png'" onMouseOut="src='imagenes/contratacion.png'"></a></td>
    						<td><a href="<?php echo $_SESSION[linkmod][2];?>" ><img src="imagenes/nomina.png" alt="nomina" onMouseOut="src='imagenes/nomina.png'" onMouseOver="src='imagenes/nomina2.png'"></a></td>
      					</tr>
  						<tr>
							<td><a href="<?php echo $_SESSION[linkmod][9];?>" ><img src="imagenes/planeacion.png" alt="planeacion" onMouseOut="src='imagenes/planeacion.png'" onMouseOver="src='imagenes/planeacion2.png'"></a></td>
    						<td><a href="<?php echo $_SESSION[linkmod][3];?>" ><img src="imagenes/presupuesto.png" alt="presupuesto" onMouseOut="src='imagenes/presupuesto.png'" onMouseOver="src='imagenes/presupuesto2.png'"></a></td>
							<td><a href="<?php echo $_SESSION[linkmod][7];?>" ><img src="imagenes/meci.png" alt="meci" onMouseOut="src='imagenes/meci.png'" onMouseOver="src='imagenes/meci2.png'"></a></td>	
  						</tr>
  						<tr>
    						<td><a href="<?php echo $_SESSION[linkmod][4];?>" accesskey="7"><img src="imagenes/tesoreria.png" alt="tesoreria" onMouseOut="src='imagenes/tesoreria.png'" onMouseOver="src='imagenes/tesoreria2.png'"></a></td>
							<td><a href="<?php echo $_SESSION[linkmod][0];?>"><img src="imagenes/administracion.png" alt="administracion" onMouseOut="src='imagenes/administracion.png'" onMouseOver="src='imagenes/administracion2.png'"></a></td>
    						<td><a href="<?php echo $_SESSION[linkmod][5];?>" ><img src="imagenes/almacen.png" alt="almacen" onMouseOut="src='imagenes/almacen.png'" onMouseOver="src='imagenes/almacen2.png'"></a></td>
      					</tr>
  						<tr>
      						<td><a href="<?php echo $_SESSION[linkmod][6];?>" ><img src="imagenes/activosfijos.png" onMouseOut="src='imagenes/activosfijos.png'" onMouseOver="src='imagenes/activosfijos2.png'"></a></td>
							<td><a href="<?php echo $_SESSION[linkmod][10];?>" title="Archivo"><img src="imagenes/mantenimiento.png"  onMouseOut="src='imagenes/mantenimiento.png'" onMouseOver="src='imagenes/mantenimiento2.png'"></a></td>
    						<td><a href="index2.php" title="salir"><img src="imagenes/salir.png"  onMouseOut="src='imagenes/salir.png'" onMouseOver="src='imagenes/salir2.png'"></a></td>
  						</tr>
					</table>
  				</td>
			</tr> 
    		<?php
  				$sqlr="create  temporary table usr_session (cedula_usuario varchar(20))";
  				//if(!mysql_query($sqlr,$linkbd)) {echo "NO SE CREO LA TABLA:".mysql_error($linkbd); }
				//else {echo "EXITO SE CREO LA TABLA:";}
 				$sqlr="insert into usr_session values ('".$_SESSION["usuario"]."')";
  				if(!mysql_query($sqlr,$linkbd))
  				{
					//echo "NO SE INSERTO:".mysql_error($linkbd); 
				}
				else 
				{
					$sqlr="select cedula_usuario from usr_session where cedula_usuario='".$_SESSION["usuario"]."'";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_array($res);
					//echo "<DIV class='resaltado'>DEVOLVIO:".$row[0]."</DIV>"; corcumare  corp social y cultural del cumare
				}  	
  			?>
			<tr>
  				<td valign="top" colspan="1">
    				<div  class="inicio" style=" width:98.4%;"><img src="imagenes/soluciones.png" alt="soluciones estrategicas integrales" style=" width:55%;">
  						<?php
						echo "<label class='saludo1' style='float:right; margin-top:3px; vertical-align:central; margin-bottom:0px;'>:::: ".vigencia_usuarios($_SESSION[cedulausu])." <img src='imagenes\confirm.png'> ::::</label>";	
						?>
                        <li style="vertical-align:bottom; line-height: 25px; float:right" ><a href="#">Ir a: <input id="atajos" name="atajos" type="search" size="11" placeholder="Digite atajo..." onKeyPress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li>
  					</div>
				</td>
			</tr>
    		<?php //***Tareas***
				$sqlr="SELECT res.fechasig,res.codigo,res.codradicacion,rad.descripcionr,rad.numeror FROM planacresponsables res, planacradicacion rad WHERE res.codradicacion=codigobarras AND res.estado='A' AND res.usuariocon='$_SESSION[cedulausu]' ORDER BY res.codigo ASC";
				$res=mysql_query($sqlr,$linkbd);
				while ($rowEmp = mysql_fetch_row($res)) 
				{
					$fechamen=$rowEmp[0];
					$rescod=$rowEmp[1]-1;
					$idtarea=$rowEmp[1];
					$idpag=$rowEmp[4];
					$sqlr2="SELECT respuesta FROM planacresponsables WHERE codradicacion='$rowEmp[2]' AND codigo='$rescod'";
					$res2=mysql_query($sqlr2,$linkbd);
					$row2 = mysql_fetch_row($res2);
					if (($row2[0]!="") && ($row2[0]!=NULL) && ($rescod!=0)){$desevento=$row2[0];}
					else {$desevento=$rowEmp[3];}
					echo"
					<script>
                     {
					 	infecha[contarmen]= '$fechamen';
						indescripc[contarmen]='$desevento';
						idtarea[contarmen]='$idtarea';
						pagtarea[contarmen]='$idpag';
						contarmen++;
                     }
                	</script>";
				}
				$sqlr="SELECT * FROM agenda WHERE fechaevento>=CURDATE() AND usrecibe='$_SESSION[cedulausu]'";
				$res=mysql_query($sqlr,$linkbd);
				while ($rowEmp = mysql_fetch_assoc($res)) 
				{
					$fechamen=$rowEmp['fechaevento'];
					$fechven=$rowEmp['horainicial'];
					$nomeven=$rowEmp['evento'];
					$desevento=$rowEmp['descripcion'];
					$prioeven=$rowEmp['prioridad'];
					$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_EVENTO_AG' AND valor_inicial='$nomeven'";
					$res3=mysql_query($sqlr3,$linkbd);
					$temensa= mysql_fetch_assoc($res3);
					$texmensaje=$temensa[descripcion_valor];
					$sqlr2="SELECT valor_final FROM dominios WHERE nombre_dominio='PRIORIDAD_EVENTOS_AG' AND valor_inicial='$prioeven'"; 
					$res2=mysql_query($sqlr2,$linkbd);
					$colmensa= mysql_fetch_assoc($res2);
					$colorevento=$colmensa[valor_final];
					echo"
					<script>
               		{
						ainfecha[acontarmen]= '$fechamen';
						ainhorain[acontarmen]= '$fechven';
						ainevento[acontarmen]= '$texmensaje';
						aindescripc[acontarmen]='$desevento';
						ainprioridad[acontarmen]= '$prioeven';
						acolorprio[acontarmen]='$colorevento';
						acontarmen++;
                     }
                	</script>";
				}
				$fec=date("Y-m-d");
				$sqlr="SELECT * FROM infor_interes where '$fec' between fecha_inicio and fecha_fin and estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($rowEmp = mysql_fetch_assoc($res)) 
				{
					$infoid=$rowEmp['indices'];
					$infotitulos=$rowEmp['titulos'];
					echo"
					<script>
               		{
					 	infid[infcontarmen]= '$infoid';
						inftitulos[infcontarmen]= '$infotitulos';
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
                                    <img src="imagenes\tareas.png">
                                    <a href="#" style="font-size:13px; font-weight:normal; background-color: #990; color:#FFF; font-weight:bold; font-family: Tahoma, Geneva, sans-serif" >::: Tareas Spid ::: </a>
                                    <label class="etiq1">(<script>document.write(contarmen);</script>)</label><br>
                                    <marquee  id="cmarquesina"  direction="up" scrollamount="2" scrolldelay="100" height="60">
                                        <script>
                                            for(var xx=0;xx<contarmen;xx++)
                                            {
                                                document.write('<div class="mmensajes"><a class="letmar" id="letmar" href="#" onClick="mypop=window.open(\'plan-actareasresponder.php?idradicado='+pagtarea[xx]+'&idresponsable='+idtarea[xx]+'\',\'\',\'\');mypop.focus();" onMouseOver="document.getElementById(\'cmarquesina\').stop()" onMouseOut="document.getElementById(\'cmarquesina\').start()"><label>:&middot </label>'+infecha[xx]+'<label> &middot:</label><br><label style="font-size:12px; font-weight: normal;" >&nbsp;&nbsp;&nbsp;'+indescripc[xx].substring(0,30)+'...(ver mas)</label></a></div><br>');
                                            }
                                        </script>
                                    </marquee>
                                </div>
                            </td>
                            <td>
                                <div class="cmarquesina">
                                    <img src="imagenes\agenda.png">
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
                                <div class="cmarquesina"><img src="imagenes\infoma.png">
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
        </table><form id="nuevomen" name="nuevomen" method="post">
		<div id="bgventanamodal">
        	<div id="ventanamodal">  
            	<a href="javascript:despliegamodal('hidden');" style="position: absolute; left: 810px; top: 8px; z-index: 100;"><img src="imagenes/exit.png" alt="cerrar" width=27 height=27>Cerrar</a>
 				
 					<input id="idoculto" name="idoculto" type="hidden" value="<?php echo $_POST[idoculto]?>">
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
        <?php if($corresmensaje=="1") {echo "<script>despliegamodalm('visible','La Vigencia actual es: ".vigencia_usuarios($_SESSION[cedulausu])."');</script>";}?>
		<script>
			document.getElementById("atajos").focus();
			//mortal_strike()
		</script>
		</form>
	</body>
</html>
