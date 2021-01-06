<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota"); 
	$vig=$_GET[vig];
	$anio=$_GET[anio];
	$mes=$_GET[mes];
	$mes0=$_GET[mes0];
	$mes1=$_GET[mes1];
	
	
	require_once ('jpgraph/src/jpgraph.php');
	require_once ('jpgraph/src/jpgraph_line.php');
	
	$dias1=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30);
	$dias2=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
	$dias3=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28);
	$dias4=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29);
	if($vig!=''){
		$sqlr="SELECT count(fecha), substring_index(substring_index(fecha,'-',-2),'-',1) as mes FROM `tesoegresos` WHERE vigencia=$vig group by mes";
		$ejex=array('Ene','Feb','Mar','Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Nov', 'Oct', 'Dic');
		$titulo='Registros de Egresos por mes';
		$resp=mysql_query($sqlr,$linkbd);
		$regs=array();
		$cont=0;
		while ($row =mysql_fetch_row($resp)) 
		{
			//echo "mes ".$cont." :".$row[0]."<br>";
			$regis[]=$row[0];
			$cont+=1;
		}
		if(count($regis)<12){
			while($cont<12){
				$regis[]=0;
				$cont+=1;
			}
		}
	}
	if($anio!='' and $mes==''){
		// $sqlr="SELECT count(fecha), substring_index(substring_index(fecha,'-',-2),'-',1) as mes FROM `tesoegresos` WHERE vigencia=$vig group by mes";
		// if((($anio%4)==0) and (mes<02<mes1)){
			
		// }
		
		// $titulo='Registros de Egresos por mes';
	}
	if($mes!=''){
		if($mes<10){$mes='0'.$mes;}
		$sqlr="SELECT COUNT( fecha ) , SUBSTRING_INDEX( SUBSTRING_INDEX( fecha,  '-', -2 ) ,  '-', 1 ) AS mes, SUBSTRING_INDEX( fecha,  '-', -1 ) AS dia FROM  tesoegresos WHERE vigencia =2016 AND SUBSTRING_INDEX( SUBSTRING_INDEX( fecha,  '-', -2 ) ,  '-', 1 ) =$mes GROUP BY dia, mes";
		if((($anio%4)==0) and ($mes==02)){
			$ejex=$dias4;
		}else{
			$ejex=$dias3;
		}
		if($mes==(1 or 3 or 5 or 7 or 8 or 10 or 12)){
			$ejex=$dias2;
		}
		if($mes==(4 or 6 or 9 or 11)){
			$ejex=$dias1;
		}
		$titulo='Registros de Egresos por Dias';
		$resp=mysql_query($sqlr,$linkbd);
		$regs=array();
		$cont=0;
		while ($cont<count($ejex)) 
		{
			$regis[]=0;
			$cont+=1;
		}
		while($row =mysql_fetch_row($resp)){
			$regis[intval($row[2])-1]=$row[0];
		}
	}
	
	
	$cc=0;
	while($cc<count($regis)){
		//echo $regis[$cc]."<br>";
		$cc+=1;
	}
	$datay1 = $regis;
	//$datay1 = array(20,15,23,15,80,20,45,10,5,45,60);
	$datay2 = array(12,9,12,8,41,15,30,8,48,36,14,25);
	$datay3 = array(5,17,32,24,4,2,36,2,9,24,21,23);
	
	// Setup the graph
	$graph = new Graph(900,350);
	$graph->SetScale("textlin");

	$theme_class=new UniversalTheme;

	$graph->SetTheme($theme_class);
	$graph->img->SetAntiAliasing(false);
	$graph->title->Set($titulo);
	$graph->SetBox(false);

	$graph->img->SetAntiAliasing();

	$graph->yaxis->HideZeroLabel();
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false);

	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle("solid");
	$graph->xaxis->SetTickLabels($ejex);
	$graph->xgrid->SetColor('#E3E3E3');

	// Create the first line
	$p1 = new LinePlot($datay1);
	$graph->Add($p1);
	$p1->SetColor("#6495ED");
	$p1->SetLegend('Numero de Egresos');

	// // Create the second line
	// $p2 = new LinePlot($datay2);
	// $graph->Add($p2);
	// $p2->SetColor("#B22222");
	// $p2->SetLegend('Tienda 2');

	// // Create the third line
	// $p3 = new LinePlot($datay3);
	// $graph->Add($p3);
	// $p3->SetColor("#FF1493");
	// $p3->SetLegend('Tienda 3');

	$graph->legend->SetFrameWeight(1);

	// Output line
	$graph->Stroke();
?>