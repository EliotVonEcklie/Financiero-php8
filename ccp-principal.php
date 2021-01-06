<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	$linkbd=conectar_v7();
	date_default_timezone_set("America/Bogota");
	software(); 
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	if (!isset($_SESSION["usuario"]))//*** verificar el username y el pass
	{
		$users=$_POST['user'];
		$pass=$_POST['pass'];
		$sqlr="SELECT T1.nom_usu, T2.nom_rol, T1.id_rol, T1.id_usu, T1.foto_usu, T1.usu_usu FROM usuarios AS T1, roles AS T2 WHERE T1.usu_usu='$users' AND T1.pass_usu='$pass' AND T1.id_rol=T2.id_rol AND T1.est_usu='1'";
		$res=mysqli_query($linkbd,$sqlr);
		while($r=mysqli_fetch_row($res))
		{
			$user=$r[0];
			$perf=$r[1];
			$niv=$r[2];
			$idusu=$r[3];
			$nick=$r[5];
			$dirfoto=$r[4];
		}
		if ($user == "")//login incorrecto 
		{
			echo"<br><br><br><br><br><br><br><center><table border='1' cellpadding='0' cellspacing='0' bordercolor='#FFFFFF' width='50%'><tr bgcolor='#000066' colspan='1'><td><center><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif' size='4' ><b>Contabilidad</b></font></center></td></tr>";
			echo "<TR bgcolor='#F7E39C' colspan='1'><td>";
			die("<center><h3><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif'>Error: Usuario o contraseña Incorrecta, para volver a intentarlo da <a href=index2.php >click aqui</a></font></h3></center></td></TR></table></center>");
		}
		else //login correcto
		{
			$_SESSION["usuario"]=array();
			$_SESSION["usuario"]=$user;
			$_SESSION["perfil"]=$perf;
			$_SESSION["idusuario"]=$idusu;
			$_SESSION["nickusu"]=$nick;
			$_SESSION["nivel"]=$niv;
			$_SESSION["linksetccp"]=array();
			if($dirfoto=="")
			{
				$dirfoto="blanco.png";
			}
			$_SESSION["fotousuario"]="fotos/".$dirfoto;
			//******************* menuss ************************
			$sqlr="SELECT DISTINCT (T2.nom_opcion), T2.ruta_opcion, T2.niv_opcion, T2.comando FROM rol_priv AS T1, opciones AS T2 WHERE T1.id_rol=$niv AND T2.id_opcion=T1.id_opcion GROUP BY (T2.nom_opcion), T2.ruta_opcion, T2.niv_opcion ORDER BY T2.orden";
			$linksetccp[$x]="";
			$res=mysqli_query($linkbd,$sqlr);
			while($roww=mysqli_fetch_row($res))
			{
				$_SESSION['linksetccp'][$roww[2]].='<li> <a href="'.$roww[1].'" style="cursor:pointer;">'.$roww[0].'  <span style="float:right">'.$roww[3].'</span></a></li>';
			}
		}
	}
	else
	{
		$_SESSION["linksetccp"]=array();
		$niv=$_SESSION["nivel"];
		$sqlr="SELECT DISTINCT (T2.nom_opcion), T2.ruta_opcion, T2.niv_opcion, T2.comando FROM rol_priv AS T1, opciones AS T2 WHERE T1.id_rol=$niv AND T2.id_opcion=T1.id_opcion AND T2.modulo=11 GROUP BY (T2.nom_opcion), T2.ruta_opcion, T2.niv_opcion ORDER BY T2.orden";
		$linksetccp[$x]="";
		$res=mysqli_query($linkbd,$sqlr);
		while($roww=mysqli_fetch_row($res))
		{
			$_SESSION['linksetccp'][$roww[2]].='<li> <a href="'.$roww[1].'" style="cursor:pointer;">'.$roww[0].'  <span style="float:right">'.$roww[3].'</span></a></li>';
		}
	}
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Presupuesto</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("ccpet");?></tr>
		</table>
</body>
</html>