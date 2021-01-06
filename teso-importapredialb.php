<?php //V 1000 12/12/16 ?>
<?php
require"comun.inc";
require"funciones.inc";
require('php-excel-reader/excel_reader2.php');
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function pdf()
{
document.form2.action="pdfbalance.php";
document.form2.target="_BLANK";
document.form2.submit();
document.form2.action="";
document.form2.target="";
}
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
}
</script>

<script src="css/calendario.js"></script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-importapredial.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" title="Nuevo"/></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" alt="Guardar" /></a>
			<a href="#" class="mgbt"><img src="imagenes/buscad.png" alt="Buscar" title="Buscar"/> </a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt" ><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana" ></a>
			<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir" title="Imprimir"></a>
			<a href="teso-gestionpredial.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>
</table>
<script type="text/javascript">
var documentoCargado = false;
function cargarDocumento() {
  document.form2.submit();
  documentoCargado = true;
}
var guardarCambios = false;
function guardarCambios() {
  if (confirm("¿Esta seguro de guardar?"))
    {
    // document.form2.oculto.value=2;
    document.form2.submit();
    }
    guardarCambios = true;
}
</script>

<tr><td colspan="3" class="tablaprin">
 <form action="teso-importapredial.php" method="post" enctype="multipart/form-data" name="form2">
  <?php
  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
  ?>
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="5">.: Importar Predial</td><td width="72" class="cerrar"><a href="teso-principal.php">Cerrar</a></td>
      </tr>
       <tr> <td width="142"  class="saludo1">Seleccione Archivo: </td>
        <td width="273" >
          <input type="file" name="archivotexto" id="archivotexto"></td>
        <td width="555" >
          <input type="button" name="generar" value="Cargar" onClick="cargarDocumento()">
          <input type="button" name="guardar" value="Guardar" onClick="guardarCambios()">
          <input name="oculto" type="hidden" value="1">
        </td>
       </tr>
    </table>
    <script type="text/javascript">
      var vigusu = "<?php echo $vigusu; ?>";
    </script>
    <script> console.log('PHP: ',vigusu);</script>

	<div class="subpantalla" id="subpantallaPredial">
  <?php
  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final
if (documentoCargado) {
  $oculto=$_POST['oculto'];
  if(is_uploaded_file($_FILES['archivotexto']['tmp_name']))
  {
    $archivo = $_FILES['archivotexto']['name'];
    $archivoF = "./archivos/$archivo";
    $archivoSubido = move_uploaded_file($_FILES['archivotexto']['tmp_name'],$archivoF);
    $contenidos = fopen($archivoF,"r+") or die("No fue posible abrir el archivo...");
    //La extensión del archivo determina su método de lectura.
    $ext = pathinfo($archivo, PATHINFO_EXTENSION);

    if ($ext == "xls") {  //Si el archivo es .xls (Excel 97-2003)
      $data = new Spreadsheet_Excel_Reader("$archivoF",false);

      // Imprime la tabla con el contenido del archivo de Excel
      echo $data->dump($row_numbers=false,$col_letters=false,$sheet=0,$table_class='excel predial inicio');

      $dataRows = $data->rowcount();
      $linkbd=conectar_bd();

      for ($i=2; $i <= $dataRows; $i++) {
        $ord = $data->val($i,'E');
        //Proceso de llenado tabla tesoprediosavaluos
        if ($ord == 1) { //Se realiza un solo registro por cedula catastral
          $vigencia = $data->val($i,'R');
          $vigencia = substr($vigencia, -4);
          $codigocatastral = $data->val($i,'C');
          $avaluo = $data->val($i,'P');
          $tot = $data->val($i,'F');
          //Damos formato a tot de un string de tres caracteres "001"
          switch (strlen($tot)) {
              case 0:
                  $tot = '000';
                  break;
              case 1:
                  $tot = '00' . $tot;
                  break;
              case 2:
                  $tot = '0' . $tot;
                  break;
              case 3:
                  $tot = '' . $tot;
                  break;
          }
          $met2 = $data->val($i,'N');
          $areacon = $data->val($i,'O');
          $consulta = sprintf("INSERT INTO tesoprediosavaluos (vigencia, codigocatastral, avaluo, pago, estado, tot, ord, met2, areacon)
          VALUES (%s, '%s', %F, 'N', 'S', '%s', '001', %u, %u)", mysql_real_escape_string($vigencia),
          mysql_real_escape_string($codigocatastral), mysql_real_escape_string($avaluo),
          mysql_real_escape_string($tot), mysql_real_escape_string($met2), mysql_real_escape_string($areacon));

          if (guardarCambios) {
            $resultado = mysql_query($consulta);
            confirm("Aja");
          }

          //LA IINSERCION AUN NO FUNCIONA. FALTA REVISAR EL CAMPO AVALUO PUES ESTA TRAYENDO EL SIGNO $ A UN CAMPO NUMERICO
          if (!$resultado) {
            $mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
            $mensaje .= 'Consulta completa: ' . $consulta;
            die($mensaje);
          }


        }
      }
    }
    else {
      echo "El archivo debe tener extension .xls (Excel 97-2003)";
    }
    fclose($contenidos);
  }
}
// if($_POST[oculto])
// {
//
//   $linkbd=conectar_bd();
//   //Borrar el balance de prueba anterior
//   //$sqlr="Delete from cuentas";
//   //mysql_query($sqlr,$linkbd);
//   $fich=$archivoF;
//   //echo "Archivo: $fich <br>";
//   $contenido = fopen($fich,"r+") or die("Unable to open file!");
//   $exito=0;
//   $errores=0;
//   echo "<table class='inicio'>";
//   $i=0;
//   $enc=0;
//   $predial[]=array();
//    while(!feof($contenido))
//    {
//      $buffer = fgets($contenido,4096);
//      $buffer=ereg_replace("[/*]", "", $buffer);
//      $datos =  split("[\t\n\r;,'$'  ]+",$buffer);
//     //echo "<br>Linea ".trim($datos[0])." ".trim($datos[1])." ".trim($datos[2])." ".trim($datos[3])." " ;
//     //$arrayDatos = explode(",", $linea);
//     //echo "<br>Linea ".implode(',', trim($datos)) ;
//     $tama=count($datos);
//     $pl=strlen($datos[1]);
//     //strpos($datos,"[' C ']",
//     //echo "c:".$tama;
//
//     if(substr($datos[1],0,2)=='TA' && $enc==0)
//     {
//     	echo "<tr><td class='saludo1'>0</td>";
//     	$predial[0][0]=0;
//         echo "<td class='saludo1'>$datos[1]</td>";
//     	$predial[0][1]=$datos[1];
//         echo "<td class='saludo1'>$datos[2]</td>";
//     	$predial[0][2]=$datos[2];
//         echo "<td class='saludo1'>$datos[3]</td>";
//     	$predial[0][3]=$datos[3];
//         echo "<td class='saludo1'>$datos[4] $datos[5] $datos[6]</td>";
//     	$predial[0][4]=$datos[4]." ".$datos[5]." ".$datos[6];
//         echo "<td class='saludo1'>$datos[7]</td>";
//     	$predial[0][5]=$datos[7];
//         echo "<td class='saludo1'>$datos[8]</td>";
//     	$predial[0][6]=$datos[8];
//         echo "<td class='saludo1'>$datos[9]</td>";
//     	$predial[0][7]=$datos[9];
//         echo "<td class='saludo1'>$datos[10]</td>";
//     	$predial[0][8]=$datos[10];
//     	echo "<td class='saludo1'>$datos[11]</td>";
//     	$predial[0][9]=$datos[11];
//         echo "<td class='saludo1'>$datos[12]</td>";
//     	$predial[0][10]=$datos[12];
//     	echo "<td class='saludo1'>$datos[13]</td>";
//     	$predial[0][11]=$datos[13];
//         echo "<td class='saludo1'>$datos[14]$datos[15]$datos[16]$datos[17]$datos[18]$datos[19]$datos[20]$datos[21]</td>";
//     	$predial[0][12]="$datos[14]$datos[15]$datos[16]$datos[17]$datos[18]$datos[19]$datos[20]$datos[21]";
//         echo "</tr>";
//       $enc=1;
//     }
//
//     if(($pl==15 && substr($datos[1],0,2)=='00' || substr($datos[1],0,2)=='01') && $tama>7)
//      {
//
//       echo "<tr><td class='saludo1'>$i</td>";
//       $i+=1;
//       	$predial[$i][0]=$i;
//       $posicion=0;
//        $nombre="";
//       	 $nombres="";
//       	 $cuenta=0;
//       $direcciones="";
//       $conc=1;
//       for($x=1;$x<$tama-1;$x++)
//         {
//         //echo "<td>$x $nombres</td>";
//
//           if($x>3 && ($datos[$x]!='C' && $datos[$x]!='N' && $datos[$x]!='X' ) && $nombre!='1')
//       	  {
//       		  $nombres=$nombres." ".$datos[$x];
//       		  $cuenta+=1;
//       		  //$nombre='1';
//       		 //echo "<td class='saludo1'>$nombres-----</td>";
//       	   }
//       	  else
//       	  {
//       		  if(($datos[$x]=='C' || $datos[$x]=='N' || $datos[$x]=='X' ) &&  $posicion<($x) &&  $nombre!='1')
//       		   {
//       			echo "<td class='saludo1'>$nombres</td>";
//       				$predial[$i][$conc]=$nombres;
//       				$conc+=1;
//       			if(strlen($datos[$x-1])==1 || strlen($datos[$x-1])==0)
//       			 {
//       			echo "<td class='saludo1'>".$datos[$x-1]."</td>";
//       				$predial[$i][$conc]=$datos[$x-1];
//       				$conc+=1;
//       			 }
//       			 else
//       			 {
//       			 echo "<td class='saludo1'></td>";
//       			 $predial[$i][$conc]="";
//       				$conc+=1;
//       			 }
//       		    echo "<td class='saludo1'>$datos[$x] </td>";
//       			$predial[$i][$conc]=$datos[$x];
//       				$conc+=1;
//       		    $posicion=$x;
//       		    $nombre="1";
//       		 	$nombres="";
//          			}
//       	   else{
//       		     if(($tama-5)==$x ||($tama-4)==$x || ($tama-2)==$x || ($tama-3)==$x )
//       		     {
//       			  if($x==($tama-5))
//       			   {echo "<td class='saludo1'>$direcciones</td>";
//       			   $predial[$i][$conc]=$direcciones;
//       				$conc+=1;}
//       				 echo "<td class='saludo1'>$datos[$x]</td>";
//       				 $predial[$i][$conc]=$datos[$x];
//       				$conc+=1;
//       			 }
//       			else
//       			 {
//        				 if($x<4)
//       				   {
//       					   echo "<td class='saludo1'>$datos[$x]</td>";
//       					   $predial[$i][$conc]=$datos[$x];
//       				$conc+=1;
//       				   }
//       				   else
//       				   {
//       				 if($x>=($posicion+2) && $x<($tama-3))
//       				 {
//       				 $direcciones=$direcciones." ".$datos[$x];
//       //				 echo "<td class='saludo1'>$datos[$x]</td>";
//       				 }
//       			     else
//       				 {
//       				 if($x==($tama-5))
//       				   {echo "<td class='saludo1'>$direcciones </td>";
//       				   $predial[$i][$conc]=$direcciones;
//       				$conc+=1;}
//       				   else
//       				   {
//       				 echo "<td class='saludo1'>$datos[$x]</td>";
//       				 $predial[$i][$conc]=$datos[$x];
//       				$conc+=1;
//       				   }
//       				 }
//       				}
//       			  }
//       	   		 //	$nombres="";
//       		 	 //$nombre="";
//       			}
//            	}
//         }
//         echo "</tr>";
//       }
//    //echo "<tr><td class='saludo1'><center>Se han Insertado con Exito: $exito <img src='imagenes/confirm.png' ></center></td></tr>";
//    //echo "<tr><td class='saludo1'><center>Errores: $errores <img src='imagenes/alert.png' ></center></td></tr>";
//   }
//  echo "</table>";
// }
// ?>
  <!-- // </div></form></td></tr>
  // <tr><td>
  // <table class="inicio"> -->
<?php
// if($_POST[oculto]==2)
// {
//     $nt=count($predial[0]);
//     $nf=count($predial);
//     //echo "f:$nt C:$nf";
//     $ai=0;
//     $na=0;
//     $err=0;
//     for($nx=1;$nx<$nf;$nx++)
//      {
//
//
//     	$sqlr="select count(*) from tesopredios where cedulacatastral='".$predial[$nx][1]."' and estado ='S'";
//     	$resp = mysql_query($sqlr,$linkbd);
//     	$ntr = mysql_fetch_row($resp);
//     	if($ntr[0]==0)
//     	 {
//     		 $naval=ereg_replace("[.]","",$predial[$nx][12]);
//     	$sqlr2="insert into tesopredios (cedulacatastral,ord,tot,e,d,documento,nombrepropietario,direccion,ha,met2,areacon,avaluo,vigencia,estado,tipopredio,clasifica,estratos) values ('".$predial[$nx][1]."','".$predial[$nx][2]."','".$predial[$nx][3]."','".$predial[$nx][5]."','".$predial[$nx][6]."','".$predial[$nx][7]."','".$predial[$nx][4]."','".$predial[$nx][8]."','".$predial[$nx][9]."','".$predial[$nx][10]."','".$predial[$nx][11]."','".$naval."','".$vigusu."','S','','','')";
//     	$na+=1;
//     	 //echo "<br><div class='saludo1'>$sqlr2</div>";
//     	//echo "$sqlr2";
//     		if(!mysql_query($sqlr2,$linkbd))
//     		 {
//     			$err+=1;
//     		 }
//     		 else
//     		 {
//     	$sqlr="insert into tesoprediosavaluos (vigencia,codigocatastral,avaluo,pago,estado,ord,tot) values('".$vigusu."','".$predial[$nx][1]."','".$naval."','N','S','".$predial[$nx][2]."','".$predial[$nx][3]."') ";
//     		mysql_query($sqlr,$linkbd);
//     			$ai+=1;
//     			//echo "<br>$ntr $sqlr";
//     		 }
//     	//
//     	 }
//     	 else
//     	  {
//     	  $naval=ereg_replace("[.]","",$predial[$nx][12]);
//     	  $sqlr="update tesopredios set vigencia='".$vigusu."', documento='".$predial[$nx][7]."', nombrepropietario='".$predial[$nx][4]."', ha='".$predial[$nx][9]."', met2='".$predial[$nx][10]."', direccion='".$predial[$nx][8]."', areacon='".$predial[$nx][10]."', avaluo='".$naval."'  where cedulacatastral='".$predial[$nx][1]."' ";
//     	//  echo "$sqlr --- ";
//     	  mysql_query($sqlr,$linkbd);
//     	  $sqlr="insert into tesoprediosavaluos (vigencia,codigocatastral,avaluo,pago,estado,ord,tot) values('".$vigusu."','".$predial[$nx][1]."','".$naval."','N','S','".$predial[$nx][2]."','".$predial[$nx][3]."') ";
//     	  // echo "<br>$sqlr";
//     	  mysql_query($sqlr,$linkbd);
//     	  $ai+=1;
//     		//echo "<br>$ntr $sqlr";
//     	  }
//
//     	//echo "<tr> ";
//     //for ($x=0;$x<$nt;$x++)
//       //{
//      	//echo "<td class='saludo1'>".$predial[$nx][$x]."</td>";
//        //}
//        //echo"</tr>";
//
//      }
//       echo "<tr><td class='saludo1'>Avaluos Actualizados: $ai <img src='imagenes\confirm.png'></td></tr>";
//       echo "<tr><td class='saludo1'>Nuevos Predios: $na <img src='imagenes\confirm.png'></td></tr>";
//   }
// ?>

<!-- // </table>
// </td></tr> -->
</table>
</body>
</html>
