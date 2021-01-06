<?php
	class cuentascontables
	{
		public static function cuentadebito_tipomov($tipmov,$cc,$vigen,$fecha)
		{
			$linkbd=conectar_v7();
			$sqlrcp="SELECT DISTINCT concepto FROM humvariables_det WHERE modulo = 2 AND codigo = '$tipmov' AND CC = '$cc' AND vigencia = '$vigen'";
			$respcp=mysqli_query($linkbd,$sqlrcp);
			$rowcp =mysqli_fetch_row($respcp);
			$sqlrcu="SELECT DISTINCT cuenta FROM conceptoscontables_det WHERE modulo = '2' AND tipo = 'H' AND CC = '$cc' AND tipocuenta = 'N' AND codigo='$rowcp[0]' AND debito = 'S' AND fechainicial = (SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <= '$fecha' AND modulo = '2' AND tipo = 'H' AND CC = '$cc' AND tipocuenta = 'N' AND codigo='$rowcp[0]' AND debito = 'S')";
			$respcu = mysqli_query($linkbd,$sqlrcu);
			while ($rowcu =mysqli_fetch_row($respcu))
			{$ctacont=$rowcu[0];}
			return($ctacont);
		}
		public static function cuentacredito_tipomov($tipmov,$cc,$vigen,$fecha)
		{
			$linkbd=conectar_v7();
			$sqlrcp="SELECT DISTINCT concepto FROM humvariables_det WHERE modulo = 2 AND codigo = '$tipmov' AND CC = '$cc' AND vigencia = '$vigen'";
			$respcp=mysqli_query($linkbd,$sqlrcp);
			$rowcp =mysqli_fetch_row($respcp);
			$sqlrcu="SELECT DISTINCT cuenta FROM conceptoscontables_det WHERE modulo = '2' AND tipo = 'H' AND CC = '$cc' AND tipocuenta = 'N' AND codigo='$rowcp[0]' AND credito = 'S' AND fechainicial = (SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <= '$fecha' AND modulo = '2' AND tipo = 'H' AND CC = '$cc' AND tipocuenta = 'N' AND codigo='$rowcp[0]' AND credito = 'S')";
			$respcu = mysqli_query($linkbd,$sqlrcu);
			while ($rowcu =mysqli_fetch_row($respcu))
			{$ctacont=$rowcu[0];}
			return($ctacont);
		}
		public static function cuentadebito_parafiscales($tipara,$cc,$vigen,$fecha)
		{
			$linkbd=conectar_v7();
			$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo = '$tipara' AND CC = '$cc' AND vigencia = '$vigen'";
			$respcp=mysqli_query($linkbd,$sqlrcp);
			$rowcp =mysqli_fetch_row($respcp);
			$sqlrcu="SELECT DISTINCT cuenta FROM conceptoscontables_det WHERE modulo = '2' AND tipo = 'H' AND CC = '$cc' AND tipocuenta = 'N' AND codigo = '$rowcp[0]' AND debito = 'S' AND fechainicial = (SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <=  '$fecha' AND modulo = '2' AND tipo = 'H' AND CC = '$cc' AND tipocuenta = 'N' AND codigo = '$rowcp[0]' AND debito = 'S')";
			$respcu = mysqli_query($linkbd,$sqlrcu);
			while ($rowcu =mysqli_fetch_row($respcu))
			{$ctacont=$rowcu[0];}
			return($ctacont);
		}
		public static function cuentacredito_parafiscales($tipara,$cc,$vigen,$fecha)
		{
			$linkbd=conectar_v7();
			$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo = '$tipara' AND CC = '$cc' AND vigencia = '$vigen'";
			$respcp=mysqli_query($linkbd,$sqlrcp);
			$rowcp =mysqli_fetch_row($respcp);
			$sqlrcu="SELECT DISTINCT cuenta FROM conceptoscontables_det WHERE modulo = '2' AND tipo = 'H' AND CC = '$cc' AND tipocuenta = 'N' AND codigo = '$rowcp[0]' AND credito = 'S' AND fechainicial = (SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <=  '$fecha' AND modulo = '2' AND tipo = 'H' AND CC = '$cc' AND tipocuenta = 'N' AND codigo = '$rowcp[0]' AND credito = 'S')";
			$respcu = mysqli_query($linkbd,$sqlrcu);
			while ($rowcu =mysqli_fetch_row($respcu))
			{$ctacont=$rowcu[0];}
			return($ctacont);
		}
	}
?>