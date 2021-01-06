<?php 	

$arreglo=Array();
$arreglo[]=Array();
$cuentas=Array();
$cuentas[]=Array();



/////////////////////////////
$cuenta=Array('110101','110102','110201','110202','110203','110301','1201');

$cuentaPadre=Array('1','11','12','1101','1102','1103');

generaArreglo();
//cuentasPadre();
$temp=Array();
$aux=$cuenta;


$i=0;
while (list($clave, $valor) = each($aux)) { 
	//if(sizeof($aux)>1){
		if(strlen($valor)>1){
		$nuevoArreglo=generaCuenta($valor);
		echo "<br>Valor: ".$valor;
		 echo "<b>contador: ".$i."</b><br>";
		$subs=substr($valor, 0,strlen($valor)-2);
		$subs1=substr($valor, 0,strlen($valor)-1);
		if (in_array($subs1, $cuentaPadre)) {
    	$cuentas[$subs1]['ppto']+=$nuevoArreglo[0];
		$cuentas[$subs1]['cdp']+=$nuevoArreglo[1];
		$cuentas[$subs1]['rp']+=$nuevoArreglo[2];
		$temp[$i]=$subs1;
		}else{
		$cuentas[$subs]['ppto']+=$nuevoArreglo[0];
		$cuentas[$subs]['cdp']+=$nuevoArreglo[1];
		$cuentas[$subs]['rp']+=$nuevoArreglo[2];
		$temp[$i]=$subs;
		}
		
		
		if($i==sizeof($aux)-1){
		$aux=array_unique($temp);
		reset($aux);
		unset($temp);
	    $i=-1;
		}
	}else{
		break;
	}
    $i++;
}

echo $cuentas['1']['ppto']."******";
echo $cuentas['11']['ppto']."******";
echo $cuentas['12']['ppto']."******";

function cuentasPadre(){

global $cuentas;

$cuentas['1']['ppto']=0;
$cuentas['1']['cdp']=0;
$cuentas['1']['rp']=0;
$cuentas['1']['tipo']='Padre';
////////////////////////////
$cuentas['11']['ppto']=0;
$cuentas['11']['cdp']=0;
$cuentas['11']['rp']=0;
$cuentas['11']['tipo']='Padre';
////////////////////////////
$cuentas['12']['ppto']=0;
$cuentas['12']['cdp']=0;
$cuentas['12']['rp']=0;
$cuentas['12']['tipo']='Padre';
////////////////////////////
$cuentas['1101']['ppto']=0;
$cuentas['1101']['cdp']=0;
$cuentas['1101']['rp']=0;
$cuentas['1101']['tipo']='Padre';
///////////////////////////
$cuentas['1102']['ppto']=0;
$cuentas['1102']['cdp']=0;
$cuentas['1102']['rp']=0;
$cuentas['1102']['tipo']='Padre';
///////////////////////////
$cuentas['1103']['ppto']=0;
$cuentas['1103']['cdp']=0;
$cuentas['1103']['rp']=0;
$cuentas['1103']['tipo']='Padre';	
}


function generaArreglo(){
global $cuentas;
$cuentas['1']['ppto']=0;
$cuentas['1']['cdp']=0;
$cuentas['1']['rp']=0;
$cuentas['1']['tipo']='Padre';
////////////////////////////
$cuentas['11']['ppto']=0;
$cuentas['11']['cdp']=0;
$cuentas['11']['rp']=0;
$cuentas['11']['tipo']='Padre';
////////////////////////////
$cuentas['12']['ppto']=0;
$cuentas['12']['cdp']=0;
$cuentas['12']['rp']=0;
$cuentas['12']['tipo']='Padre';
////////////////////////////
$cuentas['1101']['ppto']=0;
$cuentas['1101']['cdp']=0;
$cuentas['1101']['rp']=0;
$cuentas['1101']['tipo']='Padre';
///////////////////////////
$cuentas['1102']['ppto']=0;
$cuentas['1102']['cdp']=0;
$cuentas['1102']['rp']=0;
$cuentas['1102']['tipo']='Padre';
///////////////////////////
$cuentas['1103']['ppto']=0;
$cuentas['1103']['cdp']=0;
$cuentas['1103']['rp']=0;
$cuentas['1103']['tipo']='Padre';	
$cuentas['110101']['ppto']=100000;
$cuentas['110101']['cdp']=1120000;
$cuentas['110101']['rp']=1120000;
$cuentas['110101']['tipo']='Auxiliar';
/////////////////////////////
$cuentas['110102']['ppto']=100000;
$cuentas['110102']['cdp']=1200000;
$cuentas['110102']['rp']=500000;
$cuentas['110102']['tipo']='Auxiliar';
////////////////////////
$cuentas['110201']['ppto']=100000;
$cuentas['110201']['cdp']=400000;
$cuentas['110201']['rp']=300000;
$cuentas['110201']['tipo']='Auxiliar';
///////////////////
$cuentas['110202']['ppto']=100000;
$cuentas['110202']['cdp']=45411;
$cuentas['110202']['rp']=4545454;
$cuentas['110202']['tipo']='Auxiliar';
///////////////////
$cuentas['110203']['ppto']=100000;
$cuentas['110203']['cdp']=45411;
$cuentas['110203']['rp']=4545454;
$cuentas['110203']['tipo']='Auxiliar';
///////////////////
$cuentas['110301']['ppto']=100000;
$cuentas['110301']['cdp']=45411;
$cuentas['110301']['rp']=4545454;
$cuentas['110301']['tipo']='Auxiliar';
/////////////////////////////
$cuentas['1201']['ppto']=100000;
$cuentas['1201']['cdp']=1200000;
$cuentas['1201']['rp']=500000;
$cuentas['1201']['tipo']='Auxiliar';
}

function generaCuenta($cuenta){
global $cuentas;
$arreglo=Array($cuentas[$cuenta]['ppto'],$cuentas[$cuenta]['cdp'],$cuentas[$cuenta]['rp'],$cuentas[$cuenta]['tipo']);
return $arreglo;	
}


function verArreglo($arreglo){

	foreach ($arreglo as $key => $value) {
		echo $key." : ".$value."<br>";
	}
}

?>

