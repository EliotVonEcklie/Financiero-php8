<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";  
$linkbd=conectar_bd();
$sqlr="select id_recibos,id_recaudo, estado, tipo from tesoreciboscaja where vigencia='2014'";
echo "<br>".$sqlr;
$res=mysql_query($sqlr,$linkbd);
while($r=mysql_fetch_row($res))
 {
  switch ($r[3])
  {
	case 3:  //********** busca otros recaudos *************
	echo "<br>RC:$r[0] ORdo:$r[1]  Tipo:$r[3]";
	$sqlr="select * from tesorecaudos_det where id_recaudo=$r[1]";
	$res3=mysql_query($sqlr,$linkbd);
	while($r3=mysql_fetch_row($res3))
	{
	 echo "<br>$r3[1]  $r3[2]   $r3[3] ";
	 $sqlr="insert into tesoreciboscaja_det (id_recibos,ingreso,valor,estado) values ($r[0],'$r3[2]',$r3[3],'$r[2]')";
	 mysql_query($sqlr,$linkbd);
	 echo "<br>$sqlr";
	}
	 break;
	 case 1: //*************PREDIAL *************
	 $sqlr="select * from tesoliquidapredial_det where id_predial=$r[1]";
	$res3=mysql_query($sqlr,$linkbd);
	while($r3=mysql_fetch_row($res3))
	{
	 echo "<br>$r3[1]  $r3[2]   $r3[3] ";
	 if($r3[1]=='2014')
	 $coding='01';
	 else
 	 $coding='03';
	 $sqlr="insert into tesoreciboscaja_det (id_recibos,ingreso,valor,estado) values ($r[0],'$coding',$r3[11],'$r[2]')";
	 mysql_query($sqlr,$linkbd);
	 echo "<br>$sqlr";	 
	 break;
	}
	 case 2: //*************INDUSTRIA Y COMERCIO*************
	 $sqlr="select * from tesoindustria_det where id_industria=$r[1]";
	$res3=mysql_query($sqlr,$linkbd);
	while($r3=mysql_fetch_row($res3))
	{
	 echo "<br>$r3[1]  $r3[2]   $r3[3] ";
	 $sqlr="insert into tesoreciboscaja_det (id_recibos,ingreso,valor,estado) values ($r[0],'02',$r3[8],'$r[2]')";
	 mysql_query($sqlr,$linkbd);
	 echo "<br>$sqlr";	 
	 break;
	}
  }
 }
?>