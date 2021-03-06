<?php

ob_end_clean();

/**
 * Function to retrieve database connection data.
 * 
 * Returns an array with the data as follows:
 * 
 *  - $datin[0] = Database Name.
 *  - $datin[1] = Database Host.
 *  - $datin[2] = Database User.
 *  - $datin[3] = Database Password.
 * 
 * @return String[] $datin[0]
 */
function datosiniciales(){
	$datin[0] = 'cubarral';		// Nombre de la base
	$datin[1] = 'financiero8.test'; // Host
	$datin[2] = 'financiero8';      // Usuario  
	$datin[3] = 'financiero8';      // Contraseña
	return $datin;
}

function sesion()
{
	date_default_timezone_set("America/Bogota");
	//pregunta si se ha inicado por la principal
	if (!isset($_SESSION["usuario"]))
        die(<<<DIEMSG
            <br><br><br>
            <div style='background-color:#0555aa;color:fff';>
                <h4>
                    <img src='imagenes/gyc.png' align='middle'>
                    &nbsp;&nbsp;
                    <img src='imagenes/pagar.png' widht='100' height='100' align='middle'>
                    &nbsp;&nbsp; &iexcl;&iexcl;&iexcl;
                    SESION CADUCADA, VUELVA A INGRESAR EL USUARIO Y CONTRASEÑA 
                    &nbsp;&nbsp;
                    <img src='imagenes/alert.png' align='middle'>
                </h4>
            </div>"
            DIEMSG);
}

/*
function conectar_bd()
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	return $conexion;
}
*/

function conectar_v7()
{
	$datin = datosiniciales();
	$conexion = mysqli_connect($datin[1], $datin[2], $datin[3], $datin[0]);
    if (!$conexion)
    {
        die("no se puede conectar: " . mysqli_connect_error());
    }
	return $conexion;
}

/*
function conectar()
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
		if(!mysql_select_db($datin[0]))
		die("no se puede seleccionar bd");
	return $conexion;
}
*/

/**
 * Function to close the connection to the database.
 * 
 * @param mysqli $linkbd
 * A link identifier returned by mysqli_connect() or mysqli_init() 
 * 
 * @return void
 */
function desconectar_bd($linkbd)
{
    mysqli_close($linkbd);
    return;
}

function esta_en_array($objetos, $elemento)
{
    $i=0;
    
    $encontrado=false;

    while(($i < count($objetos)) && !$encontrado)
    {
        if(0 == strcmp($objetos[$i], $elemento))
        $encontrado = true;
	    //echo  "<br>".$objetos[$i]." ".$elemento." ".$encontrado;	
        $i++;
    }

    return $encontrado;
}

/**
 * Returns the position of an element in an array.
 * 
 * Returns -1 if the element is not found in the array.
 * 
 * @param Array $objetos
 * @param Mixed $elemento
 * 
 * @return Integer $pos
 */
function pos_en_array($objetos, $elemento)
{
    $i = 0;
    $pos = -1;

    while($i < count($objetos))
    {
        if ($objetos[$i] == $elemento)
        {
            $pos = $i;
            break;
        }

        $i++;
    }

    return $pos;
}

function titlepag()
{
	echo '<link rel="shortcut icon" href="favicon.ico"/>';
}

function validasusuarioypass($usuario, $passw)
{
    $conexion = conectar_v7();
    
    $sqlr = 'SELECT us.nom_usu FROM usuarios us, roles ro WHERE us.usu_usu=\''.$usuario.'\' AND us.pass_usu=\''.$passw.'\' AND us.id_rol = ro.id_rol AND us.est_usu=\'1\'';
    
    $res = mysqli_query($conexion, $sqlr);
    
    $r = mysqli_fetch_assoc($res);
    
	return (isset($r['nom_usu']) ? $r['nom_usu'] : null);
}

function view($sql,$return=''){
	$linkbd = conectar_v7();
	$query = mysqli_query($linkbd, $sql);
    if($return=='$id')
        $data = mysqli_insert_id($linkbd);
    else if ($return=='confirm')
        $data = $query;
    else
    
        while($row = mysqli_fetch_assoc($query))
            $data[] = $row;

	return $data;
	
}
?>
