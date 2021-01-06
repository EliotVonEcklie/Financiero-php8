<?php //V 1000 12/12/16 ?> 
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
		//**** CARGAR PARAMETROS
 		$sqlr="select * from parametros where estado='S'";
  		$res=mysql_query($sqlr,$linkbd);
		while($r=mysql_fetch_row($res)){$vigencia=$r[1];}
 		//*** verificar el username y el pass
 		$users=$_POST['user'];
		$pass=$_POST['pass'];
	  	$sqlr="Select usuarios.nom_usu,roles.nom_rol, usuarios.id_rol, usuarios.id_usu, usuarios.foto_usu, usuarios.usu_usu, usuarios.cc_usu from usuarios, roles where usuarios.usu_usu='$users' and usuarios.pass_usu='$pass' and usuarios.id_rol=roles.id_rol and usuarios.est_usu='1'";
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
		if ($user == "") //login incorrecto 
  		{
   			
   			echo"<br><br><br><br><br><br><br><center><table border='1' cellpadding='0' cellspacing='0' bordercolor='#FFFFFF' width='50%'><tr bgcolor='#000066' colspan='1'><td><center><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif' size='4' ><b>SPID</b></font></center></td></tr>";
   			echo "<TR bgcolor='#99bbcc' colspan='1'><td>";
   			die("<center><h3><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif'>Error: Usuario o Contrase&ntilde;a Incorrecta, para volver a intentarlo da <a href=index.php >click aqui</a></font></h3></center></td></TR></table></center>");
		}
		else //login correcto
  		{
   			session_start();
   			$_SESSION["vigencia"]=$vigencia;
   			$_SESSION["usuario"]=array();
   			$_SESSION["usuario"]=$user;
   			$_SESSION["perfil"]=$perf;
   			$_SESSION["idusuario"]=$idusu;
   			$_SESSION["nickusu"]=$nick;
   			$_SESSION["cedulausu"]=$cedusu;  
   			$_SESSION["nivel"]=$niv;
   			$_SESSION["linkmod"]=array();
   			if($dirfoto==""){$dirfoto="blanco.png";}
			$_SESSION["fotousuario"]="fotos/".$dirfoto;
			$corresmensaje="1";
   			//******************* menuss ************************
			//***** NUEVO REVISION DE LOS MODULOS ***************
  	  		$sqlr="Select DISTINCT (modulos.nombre),modulos.id_modulo,modulos.libre from MODULOS, MODULO_ROL WHERE MODULO_ROL.ID_ROL=$niv and modulos.id_modulo=modulo_rol.id_modulo group by (modulos.nombre),modulos.id_modulo,modulos.libre order by modulos.id_modulo";
    		$linkset[$x]="";
	 		$res=mysql_query($sqlr,$linkbd);
			while($roww=mysql_fetch_row($res)){$_SESSION[linkmod][$roww[1]].=$roww[2];}  
		}	
	}
 	function modificar_acentos($cadena) 
	{
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ");
		$permitidas= array ("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&ntilde;","&Ntilde;");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: FINANCIERO</title>
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="funcioneshf.js"></script>
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
		<div  style="float:left; width:33%; margin-top:5%; margin-left:2%; margin-right:1%;">
    		<img src="imagenes/fondo.png"  style="width:100%;  border:0;"/>
         </div>
    	<div style="float:left;margin-top:5%; width:40%;">
    				<table>
                        <tr style="width:33%;">
                            <td style="width:33%;"><a href="<?php echo $_SESSION[linkmod][1];?>"  accesskey="1"><img src="imagenes/contabilidad.png"  onMouseOver="src='imagenes/contabilidad2.png'" onMouseOut="src='imagenes/contabilidad.png'" style="width:100%;"></a></td>
                            <td style="width:33%;"><a href="<?php echo $_SESSION[linkmod][8];?>" ><img src="imagenes/contratacion.png" onMouseOver="src='imagenes/contratacion2.png'" onMouseOut="src='imagenes/contratacion.png'" style="width:100%;"></a></td>
                            <td ><a href="<?php echo $_SESSION[linkmod][2];?>" ><img src="imagenes/nomina.png"  onMouseOut="src='imagenes/nomina.png'" onMouseOver="src='imagenes/nomina2.png'" style="width:100%;"></a></td>
                        </tr>
                        <tr>
                            <td><a href="<?php echo $_SESSION[linkmod][9];?>"><img src="imagenes/planeacion.png" alt="planeacion" onMouseOut="src='imagenes/planeacion.png'" onMouseOver="src='imagenes/planeacion2.png'"></a></td>
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
                            <td><a href="<?php echo $_SESSION[linkmod][10];?>"><img src="imagenes/mantenimiento.png" alt="mantenimiento" onMouseOut="src='imagenes/mantenimiento.png'" onMouseOver="src='imagenes/mantenimiento2.png'"></a></td>
                            <td><a href="index2.php"><img src="imagenes/salir.png" alt="salir" onMouseOut="src='imagenes/salir.png'" onMouseOver="src='imagenes/salir2.png'"></a></td>
                        </tr>
                        <tr>
                        	<td valign="top" colspan="3" style="width:100%;">
    							<div  class="inicio" style=" width:98.4%;"><img src="imagenes/soluciones.png" alt="soluciones estrategicas integrales" style=" width:55%;">
  									<?php
										echo "<label class='saludo1' style='float:right; margin-top:3px; vertical-align:central; margin-bottom:0px;'>:::: ".vigencia_usuarios($_SESSION[cedulausu])." <img src='imagenes\confirm.png'> ::::</label>";	
									anularprediales();
									?>
                    				<li style="vertical-align:bottom; line-height: 25px; float:right" ><a href="#">Ir a: <input id="atajos" name="atajos" type="search" size="11" placeholder="Digite atajo..." onKeyPress="if(validateEnter(event) == true) {abriratajo(this.value)}"></a></li>
  								</div>
							</td>
                        </tr>
					</table>
  				</div>
    		<?php
  				$sqlr="create  temporary table usr_session (cedula_usuario varchar(20))";
  				if(!mysql_query($sqlr,$linkbd)){/*echo "NO SE CREO LA TABLA:".mysql_error($linkbd); */}
				else {/*echo "EXITO SE CREO LA TABLA:";*/}
  				$sqlr="insert into usr_session values ('".$_SESSION["usuario"]."')";
  				if(!mysql_query($sqlr,$linkbd)){/*echo "NO SE INSERTO:".mysql_error($linkbd);*/}
				else 
				{
					$sqlr="select cedula_usuario from usr_session where cedula_usuario='".$_SESSION["usuario"]."'";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_array($res);
					//echo "<DIV class='resaltado'>DEVOLVIO:".$row[0]."</DIV>"; corcumare  corp social y cultural del cumare
				}  	
  				//***Tareas***
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
					echo '
					<script>
                     {
					 	infecha[contarmen]="'.$fechamen.'";
						indescripc[contarmen]="'.$desevento.'";
						idtarea[contarmen]="'.$idtarea.'";
						pagtarea[contarmen]="'.$idpag.'";
						contarmen++;
                     }
               	 	</script>';
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
				?>
				<script>
				 {
					ainfecha[acontarmen]= '<?php echo($fechamen);?>';
					ainhorain[acontarmen]= '<?php echo($fechven);?>';
					ainevento[acontarmen]= ('<?php $sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_EVENTO_AG' AND valor_inicial='$nomeven'";$res3=mysql_query($sqlr3,$linkbd);$temensa= mysql_fetch_assoc($res3);$texmensaje=$temensa[descripcion_valor];echo modificar_acentos($texmensaje);?>');
					aindescripc[acontarmen]='<?php echo($desevento);?>';
					ainprioridad[acontarmen]= '<?php echo($prioeven);?>';
					acolorprio[acontarmen]='<?php $sqlr2="SELECT valor_final FROM dominios WHERE nombre_dominio='PRIORIDAD_EVENTOS_AG' AND valor_inicial='$prioeven'"; $res2=mysql_query($sqlr2,$linkbd);$colmensa= mysql_fetch_assoc($res2);$colorevento=$colmensa[valor_final];echo $colorevento;?>';
					acontarmen++;
				 }
                </script>
                <?php
					}
				?>    
			
                
                <?php
				$fec=date("Y-m-d");
					$sqlr="SELECT * FROM infor_interes where '$fec' between fecha_inicio and fecha_fin and estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($rowEmp = mysql_fetch_assoc($res)) 
					{
						$infoid=$rowEmp['indices'];
						$infotitulos=$rowEmp['titulos'];
				?>
				<script>
                     {
					 	infid[infcontarmen]= '<?php echo($infoid);?>';
						inftitulos[infcontarmen]= '<?php echo($infotitulos);?>';
						infcontarmen++;
                     }
                </script>
                
                <?php
					}
					
				?>
<table class="inicio" style=" width:99%;">
	<tr>
		<td>
        	<div class="cmarquesina" >
            	<img src="imagenes\tareas.png">
                <a href="#" style="font-size:13px; font-weight:normal; background-color: #990; color:#FFF; font-weight:bold; font-family: Tahoma, Geneva, sans-serif" >::: Tareas Spid ::: </a>
                <label class="etiq1">(<script>document.write(contarmen);</script>)</label><br>
                <marquee  id="cmarquesina"  direction="up" scrollamount="2" scrolldelay="100" height="60" onMouseOut="arrancarmar(this.id);" onMouseMove="detenermar(this.id);">
					<script>
					 	for(var xx=0;xx<contarmen;xx++)
						{
							document.write('<div class="mmensajes"><a class="letmar" id="letmar" href="#" onClick="mypop=window.open(\'plan-actareasresponder.php?idradicado='+pagtarea[xx]+'&idresponsable='+idtarea[xx]+'\',\'\',\'\');mypop.focus();"><label>:&middot </label>'+infecha[xx]+'<label> &middot:</label><br><label style="font-size:12px; font-weight: normal;" >&nbsp;&nbsp;&nbsp;'+indescripc[xx].substring(0,30)+'...(ver mas)</label></a></div><br>');
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
							document.write('<div class="mmensajes"><a class="letmar" id="letmar" href="#" onClick="mypop=window.open(\'plan-agenda.php?pagini=principal.php&fechamen='+ainfecha[xx]+'\',\'\',\'\');mypop.focus();"><label style="color:'+acolorprio[xx]+'">:&middot </label>'+ainfecha[xx]+' - '+ainevento[xx]+'<label style="color:'+acolorprio[xx]+'"> &middot:</label><br><label style="font-size:12px; font-weight: normal;" >&nbsp;&nbsp;&nbsp;'+aindescripc[xx].substring(0,20)+'...(ver mas)</label></a></div><br>');
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
							document.write('<div class="mmensajes"><a class="letmar"  href="#" id="letmar" onClick="document.nuevomen.idoculto.value='+infid[xx]+'; cargarpagina(); despliegamodal(\'visible\');"><label>:&middot </label>'+inftitulos[xx]+'<label> &middot:</label><br></a></div><br>');
                     	}
               		</script>
 				</marquee>
            </div></td>
    </tr>
</table>

  
		<div id="bgventanamodal">
        	<div id="ventanamodal">  
            	<a href="javascript:despliegamodal('hidden');" style="position: absolute; left: 810px; top: 8px; z-index: 100;"><img src="imagenes/exit.png" alt="cerrar" width=27 height=27>Cerrar</a>
 <form id="nuevomen" name="nuevomen" method="post">
 		<input id="idoculto" name="idoculto" type="hidden" value="<?php echo $_POST[idoculto]?>">
        <div id="formdesplegable"> 
              <script> 
			  function cargarpagina(){
			  document.getElementById('formdesplegable').innerHTML=('<IFRAME src="plan-mostrainformacion.php?idinfo='+document.nuevomen.idoculto.value+'" name="otras" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana1" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>');
			  }</script> 
    </div>
            </div>
        </div>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <?php if($corresmensaje=="1")
					{echo "<script>despliegamodalm('visible','La Vigencia actual es: ".$_SESSION["vigencia"]."');</script>";}?>
<script>
document.getElementById("atajos").focus();
//mortal_strike()
</script>
</form>
</body>
</html>
