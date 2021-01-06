<?php
    require('fpdf.php');
    require_once('barras/tcpdf_include.php');
    require('comun.inc');
    date_default_timezone_set("America/Bogota");
    //**********pdf*******
    $link=conectar_bd();
    $sqlr="Select * from configbasica";
    $resp = mysql_query($sqlr,$link);
    while ($row =mysql_fetch_row($resp))
    {
         $nit=$row[0];
         $razon=$row[1];
         $direccion=$row[2];
         $telefono=$row[3];
         $web=$row[4];
         $_POST[email]=$row[5];
         $ntercero=$row[6];
         $fecharesol=$row[8];
         $resolucion=$row[9];
         $tipofact=$row[11];
         $rangofact=$row[12];
         $tercero=$row[13];
         $dpto=$row[14];
         $mnpio=$row[15];
    }
    $sqlr = "Select codver,direccion,telefono,celular,email,depto,mnpio from terceros where cedulanit='$_POST[tercero]'";
    $resp = mysql_query($sqlr,$link);
    while ($r = mysql_fetch_row($resp))
    {
         $_POST[codver]=$r[0];
         $_POST[dircli]=$r[1];
         $_POST[telcli]=$r[2];
         $_POST[telcli].=" ".$r[3];
         $_POST[emailcli]=$r[4];
         $_POST[deptocli]=$r[5];
         $_POST[mnpiocli]=$r[6];
    }
    if($_POST[codver]!="")
    {
        $_POST[tercero].='-'.$_POST[codver];
    }
    //$pdf=new FPDF('P','mm','Letter');
    class PDF extends FPDF
    {
        //Cabecera de p�gina
        function Header()
        {
            //Logo
            $this->Image('imagenes/eng.jpg',25,10,25,25);
            $this->SetFont('Arial','B',18);
            $this->SetY(5);
            $this->Cell(180,20,''.$razon,0,0,'C');
            $this->SetFont('Arial','B',12);
            $this->SetY(17);
            $this->Cell(42);
            $this->Cell(96,6,'SECRETARIA DE HACIENDA MUNICIPAL',0,0,'C');
            $this->SetFont('Arial','B',10);
            $this->SetY(22);
            $this->Cell(42);
            $this->Cell(96,6,'DIRECCION DE IMPUESTOS MUNICIPALES',0,0,'C');
	
	
            if ($_SESSION[cabec][8]==1){
                   // $this->Image('anulado.jpg',60,75,100,100);
            }
            //******************
            $this->SetFont('Arial','B',14);
            $this->SetY(14);
            $this->Cell(138);
            $this->Cell(55,10,' FACTURA DE VENTA',1,1,'L','0');
            //************************************
            $this->SetFont('times','B',14);
            $this->SetY(24);
            $this->Cell(138);
            $this->Cell(55,10,'MC 27',1,0,'C',0);

            //*****************************************************************************************************************************************
            //*************************************************************************************************************************************
            $this->SetFont('Arial','B',11);
            $this->SetY(45);
            $this->Cell(10);
            $this->Cell(185,7,'Se'.utf8_decode('ñ').'ores: ',1,1,'L');
            //...................................................................
            $this->SetFont('Arial','I',8);
            $this->SetY(45);
            $this->Cell(27);
            $this->Cell(170,7,''.$_POST[ntercero],0,1,'L');
            //*************************************************************
            $this->SetFont('Arial','B',11);
            $this->SetY(52);
            $this->Cell(10);
            $this->Cell(140,7,'Direccion: ',1,0,'L');

            $this->SetFont('Arial','B',11);
            $this->SetY(52);
            $this->Cell(70);
            $this->Cell(80,7,'Correo: ',1,0,'L');

            $this->SetFont('Arial','I',12);
            $this->SetY(52);
            $this->Cell(85);
            $this->Cell(80,7,''.$_POST[emailcli],0,0,'L');
            //.................................................................
            $this->SetFont('Arial','I',8);
            $this->SetY(52);
            $this->Cell(30);
            $this->Cell(140,7,''.$_POST[dircli],0,0,'L');
	        //***************************************************************
            $this->SetFont('Arial','B',11);
            $this->SetY(59);
            $this->Cell(10);
            $this->Cell(60,7,'NIT: ',1,0,'L');
            //...................................................................
            $this->SetFont('Arial','I',8);
            $this->SetY(59);
            $this->Cell(20);
            $this->Cell(60,7,''.$_POST[tercero],0,0,'L');
            //***************************************************************
            $this->SetFont('Arial','B',11);
            $this->SetY(66);
            $this->Cell(10);
            $this->Cell(185,10,'Concepto: ',1,0,'L');
            //*******
            $this->SetFont('Arial','I',7);
            $this->SetY(66);
            $this->Cell(35);
            $this->MultiCell(160,3.5,''.$_POST[concepto],'','J',false);

	        //******************************************************************
            $this->SetFont('Arial','B',11);
            $this->SetY(59);
            $this->Cell(70);
            $this->Cell(80,7,'Tel: ',1,0,'L');
            //...........................................................
            $this->SetFont('Arial','I',12);
            $this->SetY(59);
            $this->Cell(80);
            $this->Cell(80,7,''.$_POST[telcli],0,0,'L');
		    //***************************************************************
            $this->SetY(45);
            $this->Cell(150);
            $this->Cell(45,14,' ',1,0,'L');//CUADRO
            $this->SetFont('Arial','B',11);
            $this->SetY(45);
            $this->Cell(150);
            $this->Cell(45,7,'Fecha:',0,0,'L');
		    //.......................................................
            $this->SetFont('Arial','I',8);
            //            $this->SetY(45);
            //            $this->Cell(165);
            //            $this->Cell(45,7,''.$_POST[fecha],0,0,'L');
            //            //****************************************************************
	    	$this->SetFont('Arial','B',11);
			$this->SetY(52);
        	$this->Cell(150);
			$this->Cell(45,7,' ',0,0,'L');//vence
			//............................................................
	    	$this->SetFont('Arial','I',12);
			$this->SetY(52);
        	$this->Cell(165);
			$this->Cell(45,7,'Bogota',0,0,'L');
	//***********************************************************************************************************
	$this->SetFont('Arial','B',11);
	$this->SetY(77);
    $this->Cell(10);
	$this->Cell(15,7,'Cod. ',1,0,'C','0');
	//************************************
 	$this->SetY(77);
    $this->Cell(25);
	$this->Cell(105,7,'Descripcion ',1,0,'C','0');
		//************************************
	$this->SetY(77);
    $this->Cell(130);
	$this->Cell(15,7,'Cant. ',1,0,'C','0');
	//************************************
	$this->SetY(77);
    $this->Cell(145);
	$this->Cell(25,7,'V/Unit.',1,0,'C','0');
	//************************************
	$this->SetY(77);
    $this->Cell(170);
	$this->Cell(25,7,'V/Total',1,1,'C','0');
	//************************************
	
	
	//***********************************************************************************************************

	
}

//Pie de p�gina
function Footer()
{
	$this->SetY(-15);
	$this->Cell(10);
	$this->SetFont('Arial','I',9);
	$this->Cell(185,7,''.$_POST[email].'  '.$_POST[web],0,1,'C');
}
}

//Creaci�n del objeto de la clase heredada

//$pdf=new PDF();
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();
$totalSinIva=0;
//$totaliva = 0;

		$pdf->SetFont('Arial','',9);
		for($i=0;$i<count($_POST[dcoding]);$i++)
		{
		 if($_POST[dcoding][$i]!="" && $_POST[dcoding][$i] != 'P08')
		  {	
			$pdf->SetY(81+($i*3.7));
			$pdf->Cell(10);
			$pdf->Cell(15,10,$_POST[dcoding][$i],0,1,'C');//codigo
			$pdf->SetY(81+($i*3.7));
			$pdf->Cell(25);
			$pdf->Cell(105,10,ucfirst(strtolower($_POST[dncoding][$i])),0,1);//descrip
			$pdf->SetY(81+($i*3.7));
			$pdf->Cell(130);
			$pdf->Cell(15,10,$_POST[dcan][$i],0,1,'C');//cant
			$pdf->SetY(81+($i*3.7));
			$pdf->Cell(145);
			$pdf->Cell(25,10,number_format($_POST[dvalores][$i],2,",","."),0,1,'R');//v/u
			$pdf->SetY(81+($i*3.7));
			$pdf->Cell(170);
			$pdf->Cell(25,10,number_format($_POST[dvalores][$i],2,",","."),0,1,'R');//v/tot
            $totalSinIva += $_POST[dvalores][$i];
		  }
		 else
         {
             $totaliva = $_POST[dvalores][$i];
         }
            //echo  $totaliva."holadfeda <br>";
		}
//********************************************************************
	 //$pdf->SetFont('Arial','B',8);
	 //$pdf->Cell(30);
	 //$pdf->Cell(20,5,'Empresa:',0,0,'R');//
	 //$pdf->SetFont('Arial','I',9);
	 //$pdf->Cell(20,5,''.$_SESSION[cabec][20],0,1,'L');// 
	 
	  //$pdf->SetFont('Arial','B',8);
	  //$pdf->Cell(30);
	  //$pdf->Cell(20,5,'Tipo de Servicio:',0,0,'R');//
	  //$pdf->SetFont('Arial','I',9);
	  //$pdf->Cell(20,5,'.'.$_SESSION[cabec][11],0,1,'L');//
		 
	  
	   

//********************************************************************************************************************************

		$pdf->SetFont('Arial','B',11);
	$pdf->SetY(205); //****SUBTOTAL
    $pdf->Cell(165);
    $pdf->Cell(30,6,'$ '.number_format($totalSinIva,1,",","."),1,0,'R');
    $pdf->SetY(211); //****IVA
    $pdf->Cell(165);
    $pdf->Cell(30,6,'$ '.number_format($totaliva,1,",","."),1,0,'R');
	$pdf->SetFont('Arial','B',12);
    $pdf->SetY(217); //***TOTAL
    $pdf->Cell(165);
    $pdf->Cell(30,6,'$ '.$_POST[totalcf],1,0,'R');
		
	$pdf->SetFont('Arial','',11);
	$pdf->SetY(205); //****SUBTOTAL
    $pdf->Cell(140);
    $pdf->Cell(25,6,'Subtotal',1,0,'R');
    $pdf->SetY(211); //****IVA
    $pdf->Cell(140);
    $pdf->Cell(25,6,'IVA',1,0,'R');
    $pdf->SetY(217); //***TOTAL
    $pdf->Cell(140);
    $pdf->Cell(25,6,'TOTAL',1,0,'R');

	$pdf->SetY(77); //**********CUADRO
    $pdf->Cell(10);
    $pdf->Cell(185,128,'',1,0,'R');

    $pdf->SetY(205); 
    $pdf->Cell(10);
    $pdf->Cell(30,5,'Son:',0,0,'L');
		$pdf->SetFont('Arial','',9);
		$conson=strlen($_POST[letras]);
		if($conson<60){$pdf->SetFont('Arial','',9);}
		else{$pdf->SetFont('Arial','',7);}
		$pdf->SetY(203); //**********CUADRO "son:"
    	$pdf->Cell(10);
   		$pdf->Cell(130,18,"$_POST[letras] MCTE",0,'2','L');
			   $pdf->SetY(213); 
 		   	  $pdf->Cell(10);
  			  //$pdf->Cell(30,5,' MCTE',0,0,'L');
		$pdf->SetFont('Arial','',9);
		$pdf->SetY(205); //**********CUADRO "son:"
    	$pdf->Cell(10);
   		$pdf->Cell(130,18,'',1,'2','L');
//**************************************************
//set_locale(LC_ALL,"es_ES@euro","es_ES","esp");
$m=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pdf->SetY(59); //observaciones
    	$pdf->Cell(150);
   		$pdf->Cell(45,7,'Pago: '.$_SESSION[cabec][21],1,'2','L');

		$pdf->SetY(217); //observaciones
    	$pdf->Cell(10);
   		$pdf->Cell(130,6,'Observaciones: '.ucfirst(strtolower($_SESSION[cabec][16])),1,'2','L');
//***********************************************************************************************************************************************
	   	$pdf->SetFont('Arial','B',9);
  		$pdf->SetY(24);
    	$pdf->Cell(10);
		//$pdf->Cell(99,10,'ASESORIAS EN SALUD OCUPACIONAL DE LOS LLANOS LTDA',0,2,'L','L');

		$pdf->SetFont('Arial','B',18);
		$pdf->SetY(10);
		$pdf->SetX(52);
		$pdf->Cell(96,7,''.$razon,0,0,'C'); 
		$pdf->SetFont('Arial','B',11);
  		$pdf->SetY(27);
		$pdf->SetX(52);
		$pdf->Cell(96,6,'Nit. '.$nit.'',0,0,'C','0');
		$pdf->SetFont('Arial','B',9);
		$pdf->SetY(32); 
		$pdf->SetX(52);
		$pdf->Cell(96,6,''.$direccion,0,0,'C');
		$pdf->SetY(36); 
		$pdf->SetX(52);
		$pdf->Cell(96,6,'Tels: '.$telefono,0,0,'C');
		//$pdf->Cell(50,10,'Calle 33 No. 39-30 Barrio Barzal Alto Tels: 670 18 80 - 670 53 02 Cel: 314 443 89 42 - Villavicencio - Colombia');
		 $pdf->SetFont('Arial','',9);
		
		 $pdf->SetY(229);
		 $pdf->Cell(10);
		 $pdf->Cell(185,5,'Autoriza DIAN 18764007966121, Fecha: 2020-11-24, Prefijo MC, Factura 1 al 500.',0,0,'J');
		$pdf->SetY(232);
		$pdf->Cell(10);
	

//************************************************************************************************************************************************
		$pdf->SetFont('Arial','',10);		

		$pdf->SetY(239);
    	$pdf->Cell(10);
		$pdf->Cell(110,5,'Aceptada:',0,1,'L');
			$pdf->SetY(239);
    		$pdf->Cell(10);
			$pdf->Cell(112,10,' ',1,0,'C');  //cuadro de "recibi"

		$pdf->SetY(239);
    	$pdf->Cell(123);
		$pdf->Cell(90,5,'Firma Autorizada:',0,1,'L');
			$pdf->SetY(239);
    		$pdf->Cell(123);
			$pdf->Cell(72,20,' ',1,0,'C');//cuadro de "firma autorizada"

		$pdf->SetY(249);
    	$pdf->Cell(10);
		$pdf->Cell(28,5,'Fecha:AA/MM/DD',0,1,'L');
			$pdf->SetY(249);
    		$pdf->Cell(10);
			$pdf->Cell(30,10,' ',1,0,'C');//cuadro de " Elabor�"
		
		$pdf->SetY(249);
    	$pdf->Cell(40);
		$pdf->Cell(27,5,'Elaboro',0,1,'L');
			$pdf->SetY(249);
    		$pdf->Cell(40);
			$pdf->Cell(26,10,' ',1,0,'C');//cuadro de "reviso"

		$pdf->SetY(249);
    	$pdf->Cell(66);
		$pdf->Cell(27,5,'Aprobo:',0,1,'L');
			$pdf->SetY(249);
    		$pdf->Cell(66);
			$pdf->Cell(28,10,' ',1,0,'C');//cuadro de "aprobo"

		$pdf->SetY(249);
    	$pdf->Cell(94);
		$pdf->Cell(27,5,'Contabilizo:',0,1,'L');
			$pdf->SetY(249);
    		$pdf->Cell(94);
			$pdf->Cell(28,10,' ',1,0,'C');//cuadro de "contabilizo"
//*****************************************************************************************************	
//**********************************************************************************************************
//**********************************************************************************************************
$pdf->Output();
?>