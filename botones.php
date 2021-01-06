<?php //V 1000 12/12/16 ?> 
<?php
function menu_desplegable($modulo)
{
	switch ($modulo) 
	{
		case "plan":
			echo ('<td colspan="3"><ul class="mi-menu"><li><a href="principal.php">Inicio</a></li><li><a href="#">Archivos Maestros</a><ul>'.$_SESSION[linksetpl][1].'</ul></li><li><a href="#">Procesos</a><ul>'.$_SESSION[linksetpl][2].'</ul></li><li><a href="#" >Herramientas</a><ul>'.$_SESSION[linksetpl][3].'</ul></li><li><a href="#" >Informes</a><ul>'. $_SESSION[linksetpl][4].'</ul></li><li><a href="ayuda.html" target="_blank">Ayuda</a></li><li style="text-align:right; float:right"><a href="#">'.$vigusu=vigencia_usuarios($_SESSION[cedulausu]).' '.$vigusu.'</a></li><li style="vertical-align:bottom; line-height: 25px; float:right" ><a href="#">Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..."></a></li></ul></td>');
			break;
		case "adm":
			echo ('<td colspan="3"><ul class="mi-menu"><li><a href="principal.php">Inicio</a></li><li><a href="#">Sistema</a><ul>'.$_SESSION[linksetad][0].'</ul></li><li><a href="#">Parametros</a><ul>'.$_SESSION[linksetad][1].'</ul></li><li><a href="#" >Herramientas</a><ul>'.$_SESSION[linksetad][2].'</ul></li><li><a href="#" >Informes</a><ul>'. $_SESSION[linksetad][3].'</ul></li><li><a href="ayuda.html" target="_blank">Ayuda</a></li><li style="text-align:right; float:right"><a href="#">'.$vigusu=vigencia_usuarios($_SESSION[cedulausu]).' '.$vigusu.'</a></li><li style="vertical-align:bottom; line-height: 25px; float:right" ><a href="#">Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..."></a></li></ul></td>');
			break;
		case "acti":
			echo ('<td colspan="3"><ul class="mi-menu"><li><a href="principal.php">Inicio</a></li><li><a href="#">Archivos Maestros</a><ul>'.$_SESSION[linksetac][1].'</ul></li><li><a href="#">Procesos</a><ul>'.$_SESSION[linksetac][2]).'</ul></li><li><a href="#">Herramientas</a><ul>'.$_SESSION[linksetac][3].'</ul></li><li><a href="#" >Informes</a><ul>'.$_SESSION[linksetac][4]).'</ul></li><li><a href="ayuda.html" target="_blank">Ayuda</a></li><li style="text-align:right; float:right"><a href="#">'.$vigusu=vigencia_usuarios($_SESSION[cedulausu]).' '.$vigusu.'</a></li><li style="vertical-align:bottom; line-height: 25px; float:right" ><a href="#">Ir a:<input name="atajos" type="search" size="11" placeholder="Digite atajo..."></a></li></ul></td>');
			break;
		case 2:
			echo "i es igual a 2";
			break;
	}
}
function cuadro_titulos()
{
	$hora=time();
	echo('<td><table class="inicio"><tr><td  class="saludo1" >Usuario: </td><td>'.$_SESSION[usuario].'</td><td class="saludo1">Perfil: </td><td>'.$_SESSION["perfil"].'</td></tr><tr><td  class="saludo1" >Fecha ingreso:</td><td>'.' '.$fec=date("Y-m-d").'</td><td class="saludo1">Hora Ingreso: </td><td>'.' '.date ( "h:i:s" , $hora ).'</td></tr></table></td>');
}
?>

