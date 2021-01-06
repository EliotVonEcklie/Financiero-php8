<?php //V 1000 12/12/16 ?> 
<?php
require('fpdf.php');
session_start();
date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
class PDF extends FPDF
{

//Cabecera de página
function Header()
{
    //Logo
 //   $this->Image('imagenes/logo-web.jpg',21,12,58,18);
	
				$this->SetFont('Arial','B',10);
	$this->SetY(10);
    $this->Cell(10);
    $this->Cell(60,21,' ',1,0,'L'); //CUADRO LOGO
	
    //*****************************************************************************************************************************
	$this->SetFont('Arial','B',10);
	$this->SetY(10);
    $this->Cell(70);
    $this->Cell(90,21,'LABORATORIO EQUIVIDA',1,1,'C'); 
	//************************************
    $this->SetFont('times','B',12);
	$this->SetY(30);
    $this->Cell(70);
	$this->Cell(90,10,'Cod Lab '.$_POST[codlab].' - No. 0'.$_POST[idlab],0,0,'C');
//********************************************************************************************************************************
	$this->SetFont('Arial','',9);
	$this->SetY(10);
    $this->Cell(160);
    $this->Cell(35,7,'Código: ',1,1,'L'); 

	$this->SetFont('Arial','',9);
	$this->SetY(17);
    $this->Cell(160);
    $this->Cell(35,7,'Versión: ',1,1,'L'); 

	$this->SetFont('Arial','',9);
	$this->SetY(24);
    $this->Cell(160);
    $this->Cell(35,7,'Página: 1 de 1',1,1,'L'); 
//********************************************************************************************************************************
	$this->SetFont('Arial','B',10);
	$this->SetY(42);
    $this->Cell(10);
    $this->Cell(105,5,'Trabajador: ',0,1,'L'); 
		$this->SetY(42);
    	$this->Cell(115);
		$this->Cell(40,5,'CC: ',0,0,'L');
			$this->SetY(42);
        	$this->Cell(155);
			$this->Cell(40,5,'Fecha: ',0,0,'L');
//.......................................................................
	$this->SetFont('Arial','I',10);
	$this->SetY(42);
    $this->Cell(30);
    $this->Cell(105,5,''.$_POST[nombre],0,1,'L'); 
		$this->SetY(42);
    	$this->Cell(125);
		$this->Cell(40,5,''.$_POST[cc],0,0,'L');
			$this->SetY(42);
        	$this->Cell(168);
			$this->Cell(40,5,''.$_POST[fecha],0,0,'L');
//********************************************************************
	$this->SetFont('Arial','B',10);
			$this->SetY(47);
        	$this->Cell(10);
			$this->Cell(40,5,'Empresa: ',0,0,'L');
		$this->SetFont('Arial','B',10);
				$this->SetY(47);
   				$this->Cell(155);
				$this->Cell(40,5,'Edad: ',0,0,'L');
//.........................................................................
		$this->SetFont('Arial','I',10);
				$this->SetY(47);
   				$this->Cell(30);
				$this->Cell(40,5,''.$_POST[empresas],0,0,'L');
		$this->SetFont('Arial','I',10);
				$this->SetY(47);
   				$this->Cell(166);
				$this->Cell(40,5,''.$_POST[edad],0,0,'L');

						$this->SetY(42);
   						$this->Cell(10);
						$this->Cell(185,10,'',1,0,'L');//cuadro
//***********************************************************************************************************************************

}



//Pie de página
function Footer()
{
    $this->SetY(-15);
	$this->SetFont('Arial','I',10);
	$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
}
}

//Creación del objeto de la clase heredada

//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',10);
$pdf->SetAutoPageBreak(true,20);
//**** inicio de seleccion de examenes
$pdf->SetY(54);   
$p=0;

for($z=0;$z<count($_POST[tipoexa]);$z++)
{
$ve=$_POST[tipoexa][$z];
switch($ve)
 {
  case 1://***QUIMICA SANGUINEA
//.............................................................
	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(85,10,"QUIMICA SANGUINEA",0,1);
		$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Glicemia (mg/dl): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[glicemia]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Colesterol Total (mg/dl): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[colesteroltotal]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Colesterol HDL (mg/dl):",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[colesterolhdl]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Colesterol LDL (mg/dl):",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[colesterolldl]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Trigliceridos (mg/dl):",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[trigliceridos]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Urea (BUN): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[urea]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Creatinina: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[creatinina]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"TGO (ASAT): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[tgo]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"TGP (ALAT): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[tgp]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Colinesterasa (U/L): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[colinesterasa]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Obs: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[obsqs]),0,1);
		$pdf->ln(4);
	$t=$pdf->GetY();
	$pdf->line(10.1,$t,209,$t);
		$pdf->ln(4);  	
	break;
  case 2://*****CUADRO HEMATICO
	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(85,10,"CUADRO HEMATICO",0,1);
		$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Globulos Blancos (Leu/mm3): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[globlan]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Hemoglobina (g/dl): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[hemoglo]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Hematocrito (%): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[hemato]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Neutofilos (%): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[neutofi]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Linfocitos (%): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[linfo]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Eosinofilos (%): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[eosino]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Monocitos (%): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[monoci]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Recuento Manual Plaquetas (/mm3): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[plaquetas]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Obs: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[obsch]),0,1);
		$pdf->ln(4);
	$t=$pdf->GetY();
	$pdf->line(10.1,$t,209,$t);  
			$pdf->ln(4);  
  break;		 
  case 3://*****PARCIAL DE ORINA
  	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(85,10,"CUADRO HEMATICO",0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"FISICO - QUIMICOS",0,1);
		$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Color: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[color]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Aspecto: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[aspecto]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"PH: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[ph]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Densidad: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[densidad]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Sangre (RBC/ul): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[sangre]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Bilirrubina (mg/dl): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[bilirrubina]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Urubilinogeno (mg/dl): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[urubilinogeno]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Cetonas (mg/dl): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[cetonas]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Proteinas (mg/dl): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[proteinas]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Nitritos : ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[nitritos]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Glucosa (mg/dl): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[glucosa]),0,1);
		$pdf->ln(4);
    $pdf->Cell(85,10,"Leucocitos (WBC/ul): ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[leucocitosf]),0,1);
		$pdf->ln(4);

	$pdf->SetFont('Arial','B',10);
    $pdf->Cell(85,10,"SEDIMENTO",0,1);
			$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Celulas: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[celulas]),0,1);
	$pdf->ln(4);
    $pdf->Cell(85,10,"Leucocitos: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[leucocitos]),0,1);
	$pdf->ln(4);
    $pdf->Cell(85,10,"Bacterias: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[bacterias]),0,1);
	$pdf->ln(4);
    $pdf->Cell(85,10,"Hematies: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[hematies]),0,1);
	$pdf->ln(4);
    $pdf->Cell(85,10,"Moco: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[moco]),0,1);
	$pdf->ln(4);
    $pdf->Cell(85,10,"Cristales: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[cristales]),0,1);
	$pdf->ln(4);
    $pdf->Cell(85,10,"Cilindros: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[cilindros]),0,1);
	$pdf->ln(4);
    $pdf->Cell(85,10,"Obs: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[obspo]),0,1);
	$pdf->ln(4);

	$t=$pdf->GetY();
	$pdf->line(10.1,$t,209,$t);  
		$pdf->ln(4);  
  break;		 
  case 4://*****BACILOSCOPIA
  	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(85,10,"BACILOSCOPIA",0,1);
	$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Muestra: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[muestrab]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Resultado: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[resultadob]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Obs: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[obsb]),0,1);
	$pdf->ln(4);  
	$t=$pdf->GetY();
	$pdf->line(10.1,$t,209,$t);  
	$pdf->ln(4);  
  break;		 
  case 5://*****COPROLOGICO
  	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(85,10,"COPROLOGICO",0,1);
	$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Color: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[colorc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Aspecto: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[aspectoc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Grasas: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[grasasc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Almidones: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[almidonesc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Hematies: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[hematiesc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Leucocitos: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[leucocitosc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Moco: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[mococ]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Flora: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[florac]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Parasitos: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[parasitosc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Otros: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[otrosc]),0,1);
	$pdf->ln(4);  

    $pdf->Cell(85,10,"Obs: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[obsco]),0,1);
	$pdf->ln(4);  
	$t=$pdf->GetY();
	$pdf->line(10.1,$t,209,$t);  
  	$pdf->ln(4);  
  break;		 
  case 6://*****EMBARAZO
  	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(85,10,"PRUEBA DE EMBARAZO",0,1);
	$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"HCG: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[muestrae]),0,1);
	$pdf->ln(4);  
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Tecnica: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[resultadoe]),0,1);
	$pdf->ln(4);  

    $pdf->Cell(85,10,"Obs: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[obse]),0,1);
	$pdf->ln(4);  
	$t=$pdf->GetY();
	$pdf->line(10.1,$t,209,$t);  
  	$pdf->ln(4);  
  break;		 
  case 7://*****HEMOCLASIFICACION
  	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(85,10,"HEMOCLASIFICACION",0,1);
	$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Grupo: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[grupo]),0,1);
	$pdf->ln(4);  
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Factor: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[factor]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Obs: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[obshe]),0,1);
	$pdf->ln(4);  
	
	$t=$pdf->GetY();
	$pdf->line(10.1,$t,209,$t);  
  	$pdf->ln(4);  
  break;		 
  case 8://*****MANIPULACION DE ALIMENTOS	
  	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(85,10,"MANIPULACION DE ALIMENTOS",0,1);
	$pdf->ln(4);

  	$pdf->SetFont('Arial','B',10);
    $pdf->Cell(85,10,"COPROLOGICO",0,1);
	$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Color: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[colorc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Aspecto: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[aspectoc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Grasas: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[grasasc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Almidones: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[almidonesc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Hematies: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[hematiesc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Leucocitos: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[leucocitosc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Moco: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[mococ]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Flora: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[florac]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Parasitos: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[parasitosc]),0,1);
	$pdf->ln(4);  
    $pdf->Cell(85,10,"Otros: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[otrosc]),0,1);
	$pdf->ln(4); 
	 
  	$pdf->SetFont('Arial','B',10);
    $pdf->Cell(85,10,"KOH",0,1);
	$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Koh: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[Koh]),0,1);
	$pdf->ln(4);  
  	$pdf->SetFont('Arial','B',10);
    $pdf->Cell(85,10,"FROTIS DE GARGANTA",0,1);
	$pdf->ln(4);
	$pdf->SetFont('Arial','',10);
    $pdf->Cell(85,10,"Frotis de Garganta: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[frotisgarganta]),0,1);
	$pdf->ln(4);  

    $pdf->Cell(85,10,"Obs: ",0,1);
    $pdf->Cell(85,10,strtoupper($_POST[obsma]),0,1);
	$pdf->ln(4);  
	$t=$pdf->GetY();
	$pdf->line(10.1,$t,209,$t);  
  	$pdf->ln(4);  
  
  break;		 
  case 9://*****VDRL
  
  break;		 
  case 10://*****TOXICOLOGICO
  
  break;		 
//*************************************************************
 }
}
//********************************************************************************************************************************
	//$pdf->SetY(77); //**********CUADRO
    //$pdf->Cell(5);
   // $pdf->Cell(185,44,'',1,0,'R');

//***********************************************************************************************************************************************
//************************************************************************************************************************************************
				$pdf->ln(4);
	    		$pdf->Cell(10);
				$pdf->Cell(70,10,'________________________________',0,0,'C');  //cuadro de " "
					$pdf->ln(4);
    				$pdf->Cell(10);
							$pdf->Cell(70,20,'LABORATORIO EQUIVIDA',0,0,'C');  //cuadro de " "

//**********************************************************************************************************
$pdf->Output();
?> 

