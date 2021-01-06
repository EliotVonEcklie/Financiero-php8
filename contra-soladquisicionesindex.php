<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
	require"comun.inc";
	require"funciones.inc";
	require"conversor.php";
	require"validaciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Contrataci&oacute;n</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="botones.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script src="JQuery/jquery-2.1.4.min.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<style>
		.c1 input[type="checkbox"]:not(:checked),
		.c1 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c1 input[type="checkbox"]:not(:checked) +  #t1,
		.c1 input[type="checkbox"]:checked +  #t1 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:before,
		.c1 input[type="checkbox"]:checked +  #t1:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:after,
		.c1 input[type="checkbox"]:checked + #t1:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c1 input[type="checkbox"]:not(:checked) +  #t1:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c1 input[type="checkbox"]:checked +  #t1:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c1 input[type="checkbox"]:disabled:not(:checked) +  #t1:before,
		.c1 input[type="checkbox"]:disabled:checked +  #t1:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c1 input[type="checkbox"]:disabled:checked +  #t1:after {
		  color: #999 !important;
		}
		.c1 input[type="checkbox"]:disabled +  #t1 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c1 input[type="checkbox"]:checked:focus + #t1:before,
		.c1 input[type="checkbox"]:not(:checked):focus + #t1:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c1 #t1:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t1{
			background-color: white !important;
		}
		
		
		
		.c2 input[type="checkbox"]:not(:checked),
		.c2 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c2 input[type="checkbox"]:not(:checked) +  #t2,
		.c2 input[type="checkbox"]:checked +  #t2 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c2 input[type="checkbox"]:not(:checked) +  #t2:before,
		.c2 input[type="checkbox"]:checked +  #t2:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c2 input[type="checkbox"]:not(:checked) +  #t2:after,
		.c2 input[type="checkbox"]:checked + #t2:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c2 input[type="checkbox"]:not(:checked) +  #t2:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c2 input[type="checkbox"]:checked +  #t2:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c2 input[type="checkbox"]:disabled:not(:checked) +  #t2:before,
		.c2 input[type="checkbox"]:disabled:checked +  #t2:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c2 input[type="checkbox"]:disabled:checked +  #t2:after {
		  color: #999 !important;
		}
		.c2 input[type="checkbox"]:disabled +  #t2 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c2 input[type="checkbox"]:checked:focus + #t2:before,
		.c2 input[type="checkbox"]:not(:checked):focus + #t2:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c2 #t2:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t2{
			background-color: white !important;
		}
		
		
		.c3 input[type="checkbox"]:not(:checked),
		.c3 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c3 input[type="checkbox"]:not(:checked) +  #t3,
		.c3 input[type="checkbox"]:checked +  #t3 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c3 input[type="checkbox"]:not(:checked) +  #t3:before,
		.c3 input[type="checkbox"]:checked +  #t3:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c3 input[type="checkbox"]:not(:checked) +  #t3:after,
		.c3 input[type="checkbox"]:checked + #t3:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c3 input[type="checkbox"]:not(:checked) +  #t3:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c3 input[type="checkbox"]:checked +  #t3:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c3 input[type="checkbox"]:disabled:not(:checked) +  #t3:before,
		.c3 input[type="checkbox"]:disabled:checked +  #t3:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c3 input[type="checkbox"]:disabled:checked +  #t3:after {
		  color: #999 !important;
		}
		.c3 input[type="checkbox"]:disabled +  #t3 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c3 input[type="checkbox"]:checked:focus + #t3:before,
		.c3 input[type="checkbox"]:not(:checked):focus + #t3:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c3 #t3:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t3{
			background-color: white !important;
		}
		
		
		
		.c5 input[type="checkbox"]:not(:checked),
		.c5 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c5 input[type="checkbox"]:not(:checked) +  #t5,
		.c5 input[type="checkbox"]:checked +  #t5 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c5 input[type="checkbox"]:not(:checked) +  #t5:before,
		.c5 input[type="checkbox"]:checked +  #t5:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c5 input[type="checkbox"]:not(:checked) +  #t5:after,
		.c5 input[type="checkbox"]:checked + #t5:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c5 input[type="checkbox"]:not(:checked) +  #t5:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c5 input[type="checkbox"]:checked +  #t5:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c5 input[type="checkbox"]:disabled:not(:checked) +  #t5:before,
		.c5 input[type="checkbox"]:disabled:checked +  #t5:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c5 input[type="checkbox"]:disabled:checked +  #t5:after {
		  color: #999 !important;
		}
		.c5 input[type="checkbox"]:disabled +  #t5 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c5 input[type="checkbox"]:checked:focus + #t5:before,
		.c5 input[type="checkbox"]:not(:checked):focus + #t5:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c5 #t5:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t5{
			background-color: white !important;
		}
		
		
		
		.c6 input[type="checkbox"]:not(:checked),
		.c6 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c6 input[type="checkbox"]:not(:checked) +  #t6,
		.c6 input[type="checkbox"]:checked +  #t6 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c6 input[type="checkbox"]:not(:checked) +  #t6:before,
		.c6 input[type="checkbox"]:checked +  #t6:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c6 input[type="checkbox"]:not(:checked) +  #t6:after,
		.c6 input[type="checkbox"]:checked + #t6:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c6 input[type="checkbox"]:not(:checked) +  #t6:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c6 input[type="checkbox"]:checked +  #t6:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c6 input[type="checkbox"]:disabled:not(:checked) +  #t6:before,
		.c6 input[type="checkbox"]:disabled:checked +  #t6:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c6 input[type="checkbox"]:disabled:checked +  #t6:after {
		  color: #999 !important;
		}
		.c6 input[type="checkbox"]:disabled +  #t6 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c6 input[type="checkbox"]:checked:focus + #t6:before,
		.c6 input[type="checkbox"]:not(:checked):focus + #t6:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c6 #t6:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t6{
			background-color: white !important;
		}
		
		
		.c7 input[type="checkbox"]:not(:checked),
		.c7 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c7 input[type="checkbox"]:not(:checked) +  #t7,
		.c7 input[type="checkbox"]:checked +  #t7 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c7 input[type="checkbox"]:not(:checked) +  #t7:before,
		.c7 input[type="checkbox"]:checked +  #t7:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c7 input[type="checkbox"]:not(:checked) +  #t7:after,
		.c7 input[type="checkbox"]:checked + #t7:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c7 input[type="checkbox"]:not(:checked) +  #t7:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c7 input[type="checkbox"]:checked +  #t7:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c7 input[type="checkbox"]:disabled:not(:checked) +  #t7:before,
		.c7 input[type="checkbox"]:disabled:checked +  #t7:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c7 input[type="checkbox"]:disabled:checked +  #t7:after {
		  color: #999 !important;
		}
		.c7 input[type="checkbox"]:disabled +  #t7 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c7 input[type="checkbox"]:checked:focus + #t7:before,
		.c7 input[type="checkbox"]:not(:checked):focus + #t7:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c7 #t7:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t7{
			background-color: white !important;
		}
		
		
	
		.c8 input[type="checkbox"]:not(:checked),
		.c8 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c8 input[type="checkbox"]:not(:checked) +  #t8,
		.c8 input[type="checkbox"]:checked +  #t8 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c8 input[type="checkbox"]:not(:checked) +  #t8:before,
		.c8 input[type="checkbox"]:checked +  #t8:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c8 input[type="checkbox"]:not(:checked) +  #t8:after,
		.c8 input[type="checkbox"]:checked + #t8:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c8 input[type="checkbox"]:not(:checked) +  #t8:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c8 input[type="checkbox"]:checked +  #t8:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c8 input[type="checkbox"]:disabled:not(:checked) +  #t8:before,
		.c8 input[type="checkbox"]:disabled:checked +  #t8:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c8 input[type="checkbox"]:disabled:checked +  #t8:after {
		  color: #999 !important;
		}
		.c8 input[type="checkbox"]:disabled +  #t8 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c8 input[type="checkbox"]:checked:focus + #t8:before,
		.c8 input[type="checkbox"]:not(:checked):focus + #t8:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c8 #t8:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t8{
			background-color: white !important;
		}
		
		
		
		.c9 input[type="checkbox"]:not(:checked),
		.c9 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c9 input[type="checkbox"]:not(:checked) +  #t9,
		.c9 input[type="checkbox"]:checked +  #t9 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c9 input[type="checkbox"]:not(:checked) +  #t9:before,
		.c9 input[type="checkbox"]:checked +  #t9:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c9 input[type="checkbox"]:not(:checked) +  #t9:after,
		.c9 input[type="checkbox"]:checked + #t9:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c9 input[type="checkbox"]:not(:checked) +  #t9:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c9 input[type="checkbox"]:checked +  #t9:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c9 input[type="checkbox"]:disabled:not(:checked) +  #t9:before,
		.c9 input[type="checkbox"]:disabled:checked +  #t9:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c9 input[type="checkbox"]:disabled:checked +  #t9:after {
		  color: #999 !important;
		}
		.c9 input[type="checkbox"]:disabled +  #t9 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c9 input[type="checkbox"]:checked:focus + #t9:before,
		.c9 input[type="checkbox"]:not(:checked):focus + #t9:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c9 #t9:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t9{
			background-color: white !important;
		}
		
		
		
		.c10 input[type="checkbox"]:not(:checked),
		.c10 input[type="checkbox"]:checked {
		  position: absolute !important;
		  left: -9999px !important;
		}
		.c10 input[type="checkbox"]:not(:checked) +  #t10,
		.c10 input[type="checkbox"]:checked +  #t10 {
		  position: relative !important;
		  padding-left: 1.95em !important;
		  cursor: pointer !important;
		}

		/* checkbox aspect */
		.c10 input[type="checkbox"]:not(:checked) +  #t10:before,
		.c10 input[type="checkbox"]:checked +  #t10:before {
		  content: '' !important;
		  position: absolute !important;
		  left: 0 !important; top: 2 !important;
		  width: 1.55em !important; height: 1.55em !important;
		  border: 2px solid #ccc !important;
		  background: #fff !important;
		  border-radius: 4px !important;
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1) !important;
		}
		/* checked mark aspect */
		.c10 input[type="checkbox"]:not(:checked) +  #t10:after,
		.c10 input[type="checkbox"]:checked + #t10:after {
		  content: url(imagenes/tilde.png) !important;
		  position: absolute !important;
		  top: .1em; left: .3em !important;
		  font-size: 1.3em !important;
		  line-height: 0.8 !important;
		  color: #09ad7e !important;
		  transition: all .2s !important;
		}
		/* checked mark aspect changes */
		.c10 input[type="checkbox"]:not(:checked) +  #t10:after {
		  opacity: 0 !important;
		  transform: scale(0) !important;
		}
		.c10 input[type="checkbox"]:checked +  #t10:after {
		  opacity: 1 !important;
		  transform: scale(1) !important;
		}
		/* disabled checkbox */
		.c10 input[type="checkbox"]:disabled:not(:checked) +  #t10:before,
		.c10 input[type="checkbox"]:disabled:checked +  #t10:before {
		  box-shadow: none !important;
		  border-color: #bbb !important;
		  background-color: #ddd !important;
		}
		.c10 input[type="checkbox"]:disabled:checked +  #t10:after {
		  color: #999 !important;
		}
		.c10 input[type="checkbox"]:disabled +  #t10 {
		  color: #aaa !important;
		}
		/* accessibility */
		.c10 input[type="checkbox"]:checked:focus + #t10:before,
		.c10 input[type="checkbox"]:not(:checked):focus + #t10:before {
		  border: 2px dotted blue !important;
		}

		/* hover style just for information */
		.c10 #t10:hover:before {
		  border: 2px solid #4778d9 !important;
		}
		#t10{
			background-color: white !important;
		}
		</style>
		<script>
		function aprobartodo(vari){
			var opciones=document.getElementsByName("dproductos1[]");
			if(vari.checked){
				for(var i=0;i<opciones.length;i++){
					document.getElementById("acepta["+i+"]").checked=true;
			}
			}else{
				for(var i=0;i<opciones.length;i++){
					document.getElementById("acepta["+i+"]").checked=false;
			}
			}
			document.form2.submit();
		}
		function aprobartodobanco(vari){
			var opciones=document.getElementById("contadorsol").value;
			if(vari.checked){
				for(var i=0;i<opciones;i++){
					document.getElementById("aceptab["+i+"]").checked=true;
				}
			}else{
				for(var i=0;i<opciones;i++){
					document.getElementById("aceptab["+i+"]").checked=false;
				}
			
			}
			document.form2.submit();
		}	
		 function validatipo(e){
			var id=e.id;
			if(id=='finaliza9'){
				 document.form2.finaliza10.checked=false;
			}else if(id=='finaliza10'){
				 document.form2.finaliza9.checked=false;
			}
		 }
		 function validafinalizar(e,tipo){
		 var id=e.id;
		 var check=e.checked;
		 if(tipo=='1'){
			 
			if(id=='finaliza1'){
				var entra=false;
				var tieneVacio=false;
				
				if (!(document.form2.codigot.value!='' && document.form2.fechat.value!='' && document.form2.descripciont.value!='' && document.form2.banderin3.value!=0 && document.form2.banderin5.value!=0) || tieneVacio==true)
				{
				 document.form2.finaliza1.checked=false;	
				despliegamodalm('visible','2','Faltan datos para solicitar el certificado PAA');
				}
				
			
				
					
			 document.form2.finaliza2.checked=false;
			 }else{
				 document.form2.finaliza1.checked=false;
			 } 
			 }else if(tipo=='2'){
	
				if(id=='finaliza5'){
					var tiposcuentas=document.getElementsByName("dtipogastos[]");
					entra=false;
						for(var i=0;i<tiposcuentas.length; i++){
						if(tiposcuentas.item(i).value=='inversion'){
							entra=true;
							break;
						}
					}
					if(entra){
						var finaliza7=document.getElementById("finaliza7").value;
						if(parseInt(document.form2.banderin1.value)==0 ){
							despliegamodalm('visible','2','Faltan datos para solicitar el certificado de disponibilidad');
							document.form2.finaliza5.checked=false;	
						}else{
							if(finaliza7==''){
								despliegamodalm('visible','2','Debe primero tener el certificado BPIM');
								document.form2.finaliza5.checked=false;	
							}
						}
					}else{
						if(parseInt(document.form2.banderin1.value)==0 ){
							despliegamodalm('visible','2','Faltan datos para solicitar el certificado de disponibilidad');
							document.form2.finaliza5.checked=false;	
						}
					}
					
				 document.form2.finaliza6.checked=false;
			 }else{
				 document.form2.finaliza5.checked=false;
			 }  
			 }else if(tipo=='3'){
				if(id=='finaliza7'){
					var paaSolicitudCertificado = document.form2.finaliza1.checked;
					var paaSinCertificado  = document.form2.finaliza2.checked;
					var contador=document.getElementById("banderin4").value;
					if (!(document.form2.codigotb.value!='' && document.form2.fechatb.value!='' && document.form2.descripcionb.value!='' && document.getElementById("vigencia").value!='' && contador!=0))
					{
					document.form2.finaliza7.checked=false;	
					despliegamodalm('visible','2','Faltan datos para solicitar el certificado BPIM');
					}else if(!paaSolicitudCertificado && !paaSinCertificado){
						document.form2.finaliza7.checked=false;
						despliegamodalm('visible','2','Debe primero solicitar el certificado PAA');						
					}
				
				 document.form2.finaliza8.checked=false;
			 }else{
				 document.form2.finaliza7.checked=false;
			 }  
			}
		 
		// document.form2.submit();
	 }
	 
			function agregarchivosec(){
				if(document.form2.rutarchivosec.value!=""){
						document.form2.agregadet7.value=1;
						document.form2.submit();
				}
				else {despliegamodalm('visible','2','Debe especificar la ruta del archivo');}
			}
			function agregarchivoest(){
				if(document.form2.rutarchivoest.value!=""){
						document.form2.agregadet6.value=1;
						document.form2.submit();
				}
				else {despliegamodalm('visible','2','Debe especificar la ruta del archivo');}
			}
			function funcionmensaje(){
				
			}
            function despliegamodal2(_valor,_tip)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventana2').src="contra-soladquisicionesventana.php";break;
						case "2":
							document.getElementById('ventana2').src="contra-soladquisicionesterceros.php";break;
						case "3":
							document.getElementById('ventana2').src="contra-productos-ventana.php";break;
						case "4":
							var tipo=document.getElementById('tipocuenta').value;
							document.getElementById('ventana2').src="contra-soladquisicionescuentasppto.php?ti=2&ti2="+tipo;break;
						case "5":
							document.getElementById('ventana2').src="contra-soladquisicionesproyectos.php";break;
						case "6":
							document.getElementById('ventana2').src="contra-productos-ventana.php";break;
						case "7":
							document.getElementById('ventana2').src="contra-proyectos.php";break;

					}
				}
			}
			function despliegamodalm(_valor,_tip,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guardo la solicitud de Adqusicion con Exito";break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;	
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp=3";break;
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)-1;
								document.form2.oculto.value="1";break;
					case "2":	document.getElementById('banderin3').value=parseInt(document.getElementById('banderin3').value)-1;
								document.form2.oculto.value="2";break;
					case "3":	document.form2.oculto.value="2";break;
				}
				document.form2.submit();
			}
			function cambiobotones1()
			{
				document.getElementById('bguardar').innerHTML='<img src="imagenes/guarda.png"  onClick="guardar();"/>';
				//document.getElementById('impre').innerHTML='<img src="imagenes/print_off.png" alt="Imprimir" style="width:30px;" >';
				//document.getElementById('pesactiva').value="1";
			} 
			function cambiobotones2()
			{
				document.getElementById('bguardar').innerHTML='<img src="imagenes/guardad.png" />';
				//document.getElementById('impre').innerHTML='<img src="imagenes/print.png" alt="Imprimir" onClick="parent.venvercdp.pdf()" >';

			} 
			function cambiopestanas(ven){document.getElementById('pesactiva').value=ven;}
			function funcionmensaje()
			{
				var coden=document.getElementById('codigot').value;
				var pagina="contra-soladquisicionesindexed.php?ind=2&codid="+coden;
				//document.getElementById('indindex').value="";
				document.form2.action=pagina;
				document.form2.submit();
			}
			function cerrarventanas()
			{
				document.form2.action="contra-principal.php";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscadquisicion(e)
			{if (document.form2.codadquisicion.value!=""){document.form2.busadq.value='1';document.form2.submit();}}
			function buscater(e)
			{if (document.form2.tercero.value!=""){document.form2.bctercero.value='1';document.form2.submit();}}
			function buscacta(e)
			{if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function buscaproyectos(e)
			{if (document.form2.codigoproy.value!=""){document.form2.bcproyectos.value='1';document.form2.submit();}}
			function buscarubro(e)
 			{if (document.form2.codrubro.value!=""){document.form2.bcrubro.value='1';document.form2.submit();}}
			
			function agregardetallesol()
			{
				var cantidad=document.getElementById('banderin3').value;
				if(cantidad==0){
					if(document.form2.ntercero.value!="" )
				{
					document.form2.agregadets.value=1;
					document.getElementById('banderin3').value=parseInt(document.getElementById('banderin3').value)+1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
				}else{
					despliegamodalm('visible','2','Ya existe un Jefe de departamento');
				}
				
			}
			function eliminars(variable)
			{
				if (confirm("Esta Seguro de Eliminar "+variable))
				{
					document.form2.eliminars.value=variable;
					vvend=document.getElementById('eliminars');
					vvend.value=variable;
					document.getElementById('banderin3').value=parseInt(document.getElementById('banderin3').value)-1;
					document.form2.submit();
				}
			}
			function eliminardp(variable)
			{
				document.form2.eliminarpro.value=variable;
				despliegamodalm('visible','4','Esta seguro de eliminar el Producto de la lista','3');
			}
			function agregardetalle()
			{
				if(document.form2.ncuenta.value!="" )
				{
					document.form2.agregadet.value=1;
					document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)+1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
			}
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar "+variable))
				{
					document.form2.eliminar.value=variable;
					vvend=document.getElementById('eliminar');
					vvend.value=variable;
					document.getElementById('banderin2').value=parseInt(document.getElementById('banderin2').value)-1;
					document.form2.submit();
				}
			}
			function agregardetalle2()
			{
				if(document.form2.codrubro.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >0 && document.form2.valor.value !="")
				{ 
					if(parseFloat(document.getElementById('saldo').value)>=parseFloat(document.getElementById('valor').value))
					{
						document.form2.agregadet2.value=1;
						document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)+1;
						document.form2.submit();
					}
					else {despliegamodalm('visible','2','La Cuenta "'+document.getElementById('codrubro').value+'" no tiene saldo suficiente');}
 				}
 				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
			}
			function eliminar2(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			  	{
					document.form2.elimina.value=variable;
					document.getElementById('elimina').value=variable;
					document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)-1;
					document.form2.submit();
				}
			}
			function guardar()
			{
				var tiposcuentas=document.getElementsByName("dtipogastos[]");
				var pestana=document.getElementById("pesactiva").value;
				
				var entra=false;
				var pasa=true;
				for(var i=0;i<tiposcuentas.length; i++){
					if(tiposcuentas.item(i).value=='inversion'){
						entra=true;
						break;
					}
				}
				
				if(pasa){
					if(entra){
			
						if(pestana=='1' || pestana=='2'){
							
							var nocertifica=document.getElementById("finaliza2").value;
							if(nocertifica!=''){
								if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
							}else{
								if (!(document.form2.codigot.value!='' && document.form2.fechat.value!='' && document.form2.descripciont.value!='' && document.form2.banderin3.value!=0))
								{	
									despliegamodalm('visible','2','Faltan datos para completar el registro');
								}else{
									if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
								}
							
								
							}
						}else if(pestana=='3' || pestana=='4'){
							    var finaliza7=document.getElementById("finaliza7").value;
								if( finaliza7=='' || parseInt(document.form2.banderin1.value)==0){
									despliegamodalm('visible','2','Faltan datos para completar el registro');
								}else{
									if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
								}
								
						}else if(pestana=='5' || pestana=='6'){
							var nocertifica=document.getElementById("finaliza8").value;
							if(nocertifica!=''){
								if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
							}else{
								if (!(document.form2.codigotb.value!='' && document.form2.fechatb.value!='' && document.form2.descripcionb.value!='' && document.getElementById("vigencia").value!=''))
								{
									despliegamodalm('visible','2','Faltan datos para completar el registro');
								}else{
									if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
								}
							}
						}
				
				}else{
					if(pestana=='1' || pestana=='2'){
						var nocertifica=document.getElementById("finaliza2").value;
						if(nocertifica!=''){
							if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
						}else{
							if (!(document.form2.codigot.value!='' && document.form2.fechat.value!='' && document.form2.descripciont.value!='' && document.form2.banderin3.value!=0))
							{	
								despliegamodalm('visible','2','Faltan datos para completar el registro');
							}else{
								if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
							}
						
							
						}		
					
			
						}else if(pestana=='3' || pestana=='4'){
							var nocertifica=document.getElementById("finaliza6").value;
							if(nocertifica!=''){
									if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
							}else{
								if(parseInt(document.form2.banderin1.value)==0){
								despliegamodalm('visible','2','Faltan datos para completar el registro');
								}else{
									if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
								}
							}
							
						}else if(pestana=='5' || pestana=='6'){
							
							var nocertifica=document.getElementById("finaliza8").value;
							if(nocertifica!=''){
								if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
							}else{
								if (!(document.form2.codigotb.value!='' && document.form2.fechatb.value!='' && document.form2.descripcionb.value!='' && document.getElementById("vigencia").value!=''))
								{
									despliegamodalm('visible','2','Faltan datos para completar el registro');
								}else{
									if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
								}
							}
							
						}
						
				}
				}else{
					despliegamodalm('visible','2','No pueden existir cantidades o valores vacios');
				}
					
			}
			
			 function validar(formulario)
			{
				document.form2.action="contra-soladquisicionesindex.php";
				document.form2.submit();
			}
			function buscacuenta(){
				//alert('Entra');
			}
			/*
			function cambiatipo(valor){
				var valsec=valor.value;
				document.getElementById("tipocuenta").value=valsec;
				document.form2.submit();
			}
			*/
			function agregameta(){
				var contador=document.getElementById("contadorsol").value;
				
				var tam=document.getElementById("sumnivel").value;
				var entra=false;
				for(var i=0;i<tam;i++){
					var valor=document.getElementById("niveles["+i+"]").value;
					if(valor==''){
						entra=true;
						break;
					}
				}
				
				if(entra){
					for(var i=0;i<tam;i++){
					document.getElementById("niveles["+i+"]").value='';
					}
				
					despliegamodalm4('visible','2','No pueden existir metas vacias');
				}else{
					var exMeta=existeMeta(document.getElementById("niveles["+(tam-1)+"]").value);
					if(exMeta){
						despliegamodalm4('visible','2','Metas Repetidas');
					}else{
						document.getElementById('contadorsol').value=parseInt(document.getElementById('contadorsol').value)+1;
						document.form2.agregadet8.value=1;
						document.form2.oculto.value=1;
						document.form2.submit();
					}
					
				}
				
			}
				function existeMeta(meta){
				var contador=document.getElementById("contadorsol").value;
				var retorno=false;
				for(var x=0;x<contador; x++){
						var arreglo=document.getElementsByName("matmetas1"+x+"[]");
						for(var i=0;i<arreglo.length;i++){
							if(arreglo.item(i).value==meta){
								retorno=true;
								break;
							}
						}
					if(retorno==true){
						break;
					}
					
				}
			
				return retorno;
				
			}
		function agregarproductos(){
			var productos=document.getElementsByName("dproductos1[]");
			var cantidaduni=document.getElementsByName("dcantidad1[]");
			var valoruni=document.getElementsByName("dvaluni1[]");
			var paa=document.getElementById("codadquisicion").value;
			var tieneVacio=false;
			var contador=0;
			for(var i=0;i<productos.length;i++){
				var aprobado=document.getElementById("acepta["+i+"]").checked;
				if(aprobado==true && (cantidaduni.item(i).value=='' || valoruni.item(i).value=='') ){
					tieneVacio=true;
					break;
				}
				if(aprobado==true){
					contador++;
				}
			}
			if(paa==''){
				despliegamodalm('visible','2','No ha especificado Plan Anual de Adquisicion');
			}else{
				if(aprobado<0){
					despliegamodalm('visible','2','Debe seleccionar por lo menos un producto');
				}else{
					if(tieneVacio==true){
					despliegamodalm('visible','2','No pueden existir cantidades o valores vacios');
					}else{
						document.getElementById("agregadetprod").value='1';
						document.form2.submit();
					}
				}
			}	
		}
		function marcar(fila){
			document.form2.submit();
		}
			
		</script>
        <?php titlepag();?>
		<?php 
		//FUNCIONES
		function requiereBPIM($arreglo){
			$requiere=0;
			for($i=0;$i<count($arreglo);$i++ ){
				if($arreglo[$i]=='inversion'){
					$requiere=1;
				}
			}
			return $requiere;
		}
		?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("inve");?></tr>
            <tr>
               <td colspan="3" class="cinta">
			   <a id="bnuevo" href="contra-soladquisicionesindex.php?ind=1" class="mgbt"><img src="imagenes/add.png" title="Nuevo"></a>
			   <a id="bguardar" href="#" class="mgbt"><img src="imagenes/guarda.png"  onClick="guardar()"></a>
			   <a href="contra-soladquisicionesbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"></a>
			   <a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			   <a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			   </td>
            </tr>
        </table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" enctype="multipart/form-data">
        <?php
			$_POST[indindex]=$_GET[ind];
			$_POST[codid]=$_GET[codid];
			$cmoff='imagenes/sema_rojoOFF.jpg';
			$cmrojo='imagenes/sema_rojoON.jpg';
			$cmamarillo='imagenes/sema_amarilloON.jpg';
			$cmverde='imagenes/sema_verdeON.jpg';
			$p1luzcem1=$cmrojo;$p1luzcem2=$cmoff;$p1luzcem3=$cmoff;
			$p2luzcem1=$cmrojo;$p2luzcem2=$cmoff;$p2luzcem3=$cmoff;
			//*****************************************************************
			
				 
			if($_POST[oculgen]=="")
				{
					$_POST[fechat]=date("d/m/Y");
					$_POST[fechatb]=date("d/m/Y");
					$_POST[contadorsol]=0;
					$_POST[banderin5]=0;
					$_POST[banderin4]=0;
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$_POST[vigencia]=$vigusu;
					$sqlr="SELECT max(CAST(codsolicitud AS UNSIGNED)) FROM contrasoladquisiciones";
					$row=mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[codigot]=$row[0]+1;	
					$_POST[banderin1]="0";
					$_POST[banderin2]="0";
					$_POST[banderin3]="0";
					$_POST[pesactiva]="1";
					$_POST[oculgen]="0";
					$sqlr="SELECT max(CAST(codigo AS UNSIGNED)) FROM contrasolicitudproyecto";
					$row=mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[codigotb]=$row[0]+1;
					
				}
			//*****************************************************************
			switch($_POST[pesactiva])
					{
						case "1":
							$check1="checked";$check2="";$check3="";$check4="";$check5="";$check6="";$check7="";$check8="";break;
						case "2":
							$check1="";$check2="checked";$check3="";$check4="";$check5="";$check6="";$check7="";$check8="";break;
						case "3":
							$check1="";$check2="";$check3="checked";$check4="";$check5="";$check6="";$check7="";$check8="";break;
						case "4":
							$check1="";$check2="";$check3="";$check4="checked";$check5="";$check6="";$check7="";$check8="";break;
						case "5":
							$check1="";$check2="";$check3="";$check4="";$check5="checked";$check6="";$check7="";$check8="";break;
						case "6":
							$check1="";$check2="";$check3="";$check4="";$check5="";$check6="checked";$check7="";$check8="";break;
						case "7":
							$check1="";$check2="";$check3="";$check4="";$check5="";$check6="";$check7="checked";$check8="";break;
						case "8":
							$check1="";$check2="";$check3="";$check4="";$check5="";$check6="";$check7="";$check8="checked";break;
					}
			//*****************************************************************
			if($_POST[busadq]=='1')
			{
				$nresul=buscadquisicion($_POST[codadquisicion]);
				if($nresul[1]!='')
				{
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$sql="SELECT contraplancompras.valortotalest FROM contraplancompras WHERE contraplancompras.vigencia = '$vigusu' and contraplancompras.codplan='$_POST[codadquisicion]'  ";
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
					$totalplan=$fila[0];
					$sql="SELECT SUM(valtotalcerti) FROM contrasolicitudpaa WHERE codplan='$_POST[codadquisicion]' AND estado='CE' ";
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
					$totalcer=$fila[0];
					$_POST[saldopaa1]=$totalplan-$totalcer;
					$_POST[nadquisicion]=$nresul[1];
					$codunspsc=explode("-",$nresul[0]);
					$t=count($_POST[dproductos1]);
					for ($x=0;$x<$t;$x++)
					{
						unset($_POST[acepta][$x]);
						unset($_POST[dproductos1][$x]);
						unset($_POST[dnproductos1][$x]);
						unset($_POST[dcantidad1][$x]);
						unset($_POST[dvaluni1][$x]);
						unset($_POST[dtipos1][$x]);
					}
					$_POST[dproductos1]= array_values($_POST[dproductos1]); 
					$_POST[dnproductos1]= array_values($_POST[dnproductos1]); 
					$_POST[dcantidad1]= array_values($_POST[dcantidad1]);
					$_POST[dvaluni1]= array_values($_POST[dvaluni1]);
					$_POST[dtipos1]= array_values($_POST[dtipos1]);
					foreach ($codunspsc as &$valor)
					{
						$sqlr2="SELECT nombre FROM productospaa WHERE codigo='$valor' ORDER BY codigo";
						$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
						$_POST[dproductos1][]=$valor;
						$_POST[dnproductos1][]=$row2[0]; 
						$_POST[dcantidad1][]="0"; 
						$nt=buscaproductotipo($valor);
						$_POST[dtipos1][]=buscadominiov2("UNSPSC",$nt);
					
					}
					unset($valor);
				}
			   else
			   {
					echo"<script>parent.despliegamodalm('visible','2','Codigo de Adquisicion $_POST[codadquisicion] No Asignado'); document.form2.codadquisicion.focus();</script>";
					$_POST[nadquisicion]="";
					$_POST[codadquisicion]="";	
			   }
			}
			//*****************************************************************
			if($_POST[bctercero]=='1')
			{
				$nresul=buscatercerod($_POST[tercero]);
				if($nresul[0]!=''){$_POST[ntercero]=$nresul[0];$_POST[dependencia]=$nresul[1];$_POST[iddependencia]=$nresul[2];}
				else
				{
					$_POST[ntercero]="";
					echo"<script>despliegamodalm('visible','2','Solicitante Incorrecto o no Existe');document.form2.tercero.focus();</script>";
				}
			}
			//*****************************************************************
			if($_POST[bcrubro]=='1')
			{
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$tipo=substr($_POST[codrubro],0,1);		
				$nresul=buscacuentapres($_POST[codrubro],$tipo); 	
				if($nresul!='')
				{
					$_POST[nrubro]=$nresul;
					$linkbd=conectar_bd();
					$sqlr="SELECT * FROM pptocuentas WHERE cuenta='$_POST[codrubro]' AND (vigencia='$vigusu' OR vigenciaf='$vigusu')";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[valor]=0;		  
					$_POST[saldo]=generaSaldo($_POST[codrubro],$vigusu,$vigusu);	
					$_POST[saldov]=$_POST[saldo];
					$ind=substr($_POST[codrubro],0,1);	
				  $clasifica=$row[29];		

					if($clasifica=='regalias')
					{						
						$ind=substr($_POST[codrubro],1,1);	
						$criterio="AND (pptocuentas.vigencia='$vigusu' OR pptocuentas.vigenciaf='$vigusu') AND (pptocuentas.vigencia='$vigusu' OR  pptocuentas.vigenciaf='$vigusu')";					  
					}
					else
					{
						$criterio=" AND pptocuentas.vigencia='$vigusu' AND  pptocuentas.vigencia='$vigusu'";
					}
					if ($clasifica=='funcionamiento')
					{
						$sqlr="SELECT pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre, pptocuentas.clasificacion FROM pptocuentas,pptofutfuentefunc WHERE pptocuentas.cuenta='$_POST[codrubro]' AND pptocuentas.futfuentefunc=pptofutfuentefunc.codigo $criterio";
						
					}
					if ($clasifica=='inversion' || $clasifica=='reservas-ingresos')
					{
						$sqlr="SELECT pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre,pptocuentas.clasificacion FROM pptocuentas,pptofutfuenteinv WHERE pptocuentas.cuenta='$_POST[codrubro]' AND pptofutfuenteinv.codigo=pptocuentas.futfuenteinv $criterio";
						
					}
					
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					if($row[1]!='' || $row[1]!=0)
					{
						$_POST[tipocuenta]=$row[3];
						$_POST[cfuente]=$row[0];
						$_POST[fuente]=$row[2];
						$_POST[valor]=0;			  
						$_POST[saldo]=$row[1];			  
					}
					else
					{
						$_POST[cfuente]="";
						$_POST[fuente]=""; 
					}  
				}
				else
				{
				   $_POST[nrubro]="";	
				   $_POST[fuente]="";				   
				   $_POST[cfuente]="";				   			   
				   $_POST[valor]="";
				   $_POST[saldo]="";
				}
			}
			//*****************************************************************
			if ($_POST[agregadets]=='1')
			{
				$ch=esta_en_array($_POST[sdocumento],$_POST[tercero]);
				if($ch!='1')
				{			 
					$_POST[sdocumento][]=$_POST[tercero];
					$_POST[snombre][]=$_POST[ntercero]; 
					$_POST[sidependencia][]=$_POST[iddependencia];
					$_POST[sndependencia][]=$_POST[dependencia];
					$_POST[agregadets]=0;
					$_POST[tercero]="";
					$_POST[ntercero]="";
					$_POST[iddependencia]="";
					$_POST[dependencia]="";
					echo"<script> document.form2.tercero.value='';document.form2.ntercero.value='';document.form2.iddependencia.value=''; document.form2.dependencia.value='';</script>";
				}
					else
					{echo"<script>despliegamodalm('visible','2','Ya se ingreso Solicitante con el Documento $_POST[tercero]');</script>";}
			}
			//*****************************************************************
			if ($_POST[eliminars]!='')
			{ 
				$posi=$_POST[eliminars];
				unset($_POST[sdocumento][$posi]);
				unset($_POST[snombre][$posi]);
				unset($_POST[sidependencia][$posi]);
				unset($_POST[sndependencia][$posi]);
				$_POST[sdocumento]= array_values($_POST[sdocumento]); 
				$_POST[snombre]= array_values($_POST[snombre]); 
				$_POST[sidependencia]= array_values($_POST[sidependencia]); 
				$_POST[sndependencia]= array_values($_POST[sndependencia]);
			}
			//*****************************************************************
			if ($_POST[agregadet]=='1')
			{
				$_POST[dproductos][]=$_POST[cuenta];
				$_POST[dnproductos][]=$_POST[ncuenta]; 
				$_POST[dcantidad][]="0"; 
				$_POST[dvaluni][]="0"; 
				$nt=buscaproductotipo($_POST[cuenta]);
				$_POST[dtipos][]=buscadominiov2("UNSPSC",$nt);
				$_POST[agregadet]=0;
				$_POST[cuenta]="";
				$_POST[ncuenta]="";
				echo"<script>document.form2.cuenta.value='';document.form2.ncuenta.value='';</script>";
			}
			//*****************************************************************
			if ($_POST[eliminar]!='')
			{ 
				$posi=$_POST[eliminar];
				unset($_POST[dproductos][$posi]);
				unset($_POST[dnproductos][$posi]);
				unset($_POST[dcantidad][$posi]);
				unset($_POST[dvaluni][$posi]);
				unset($_POST[dtipos][$posi]);
				$_POST[dproductos]= array_values($_POST[dproductos]); 
				$_POST[dnproductos]= array_values($_POST[dnproductos]); 
				$_POST[dcantidad]= array_values($_POST[dcantidad]);
				$_POST[dvaluni]= array_values($_POST[dvaluni]);
				$_POST[dtipos]= array_values($_POST[dtipos]);
			}
			//*****************************************************************
			if($_POST[bc]=='1')
			{
				$nresul=buscaproducto($_POST[cuenta]);
				if($nresul!=''){$_POST[ncuenta]=$nresul;}
				else
				{
					echo"<script>despliegamodalm('visible','2','Codigo de Producto $_POST[cuenta] No es Correcto');document.form2.cuenta.focus();</script>";
					$_POST[ncuenta]="";
				}
			}
			//*****************************************************************
			if($_POST[bcproyectos]=='1')
			{
				unset($_POST[nomarchivos]);
				unset($_POST[rutarchivos]);
				unset($_POST[tamarchivos]);
				unset($_POST[patharchivos]);
				$nresul=buscaproyectos($_POST[codigoproy]);
				if($nresul[0]!=''){
					$_POST[nproyecto]=$nresul[0];$_POST[conproyec]=$nresul[1];$_POST[nomarchadj]=basename($nresul[2]);$_POST[valorproyecto]=$nresul[3];$_POST[descripcion]=$nresul[4]; 
					$codigo=$_POST[codigoproy];
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$sql="SELECT * FROM planproyectos_adj WHERE codigo='$codigo' ";
					$result=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_row($result)){
						$_POST[nomarchivos][]=$row[2];
						$_POST[rutarchivos][]=basename($row[4]);
						$_POST[tamarchivos][]=filesize($row[4]);
						$_POST[patharchivos][]=basename($row[4]);
					}
					//-----
					$_POST[contador]=0;
					$sql="SELECT MAX(cod_meta) FROM planproyectos_det WHERE codigo='$codigo' ";
					$result=mysql_query($sql,$linkbd);
					$rowc = mysql_fetch_row($result);
					if(!empty($rowc[0])){
						$_POST[contador]=$rowc[0]+1;
					}else{
						$_POST[contador]=0;
					}
				
					//----
					$sql="SELECT valor,nombre_valor,cod_meta FROM planproyectos_det WHERE codigo='$codigo' ORDER BY LENGTH(valor),cod_meta ASC";
					$result=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_row($result)){
						$j=$row[2];
						$_POST["matmetas$j"][]=$row[0];
						$_POST["matmetasnom$j"][]=$row[1];
					}
					 
					 $sql="SELECT estado FROM planproyectos_pres WHERE codigo='$codigo' ";
               	$result=mysql_query($sql,$linkbd);
               	$row = mysql_fetch_row($result);
               	if($row[0]=="C"){
					$_POST[cuenfuen]="1";
               		$sql="SELECT ppp.cuenta,ppp.valor,pc.nombre,ppp.vigencia,pc.futfuentefunc,pc.futfuenteinv,pc.clasificacion FROM planproyectos_pres AS ppp ,pptocuentas AS pc WHERE ppp.codigo=$codigo AND ppp.vigencia=$vigusu AND ppp.cuenta=pc.cuenta AND ppp.vigencia=pc.vigencia";
					$result=mysql_query($sql,$linkbd);
					while($rowp = mysql_fetch_row($result)){
						$_POST[dcuentas][]=$rowp[0];
                        $_POST[dncuentas][]=$rowp[2];
						if($rowp[4]!='' && $rowp[4]!=NULL){
							$_POST[dcfuentes][]=$rowp[4];
						}else{
							$_POST[dcfuentes][]=$rowp[5];
						}
						
                        $_POST[dfuentes][]=buscafuenteppto($rowp[0],$rowp[3]); 
                        $_POST[dgastos][]=$rowp[1];
						$_POST[dtipogastos][]=$rowp[6];
					}
               	}else{
					$_POST[cuenfuen]="0";
               		$sql="SELECT ppp.valor,(SELECT nombre FROM (SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuentefunc) AS tabla WHERE codigo=ppp.fuente) AS celda,ppp.fuente FROM planproyectos_pres AS ppp WHERE ppp.codigo=$codigo AND ppp.vigencia=$vigusu ";
					$result=mysql_query($sql,$linkbd);
					while($rowp = mysql_fetch_row($result)){
						
						$_POST[dcfuentes][]=$rowp[2];
                        $_POST[dfuentes][]=$rowp[1];
                        $_POST[dgastos][]=$rowp[0];
					}
               	}
			//------
					}
				else
				{
					echo"<script>parent.despliegamodalm('visible','2','Codigo de Poyecto $_POST[codigoproy] No es Correcto'); document.form2.cuenta.focus();</script>";
					$_POST[nproyecto]="";
				}
			}
			$sql="SELECT nombre FROM planproyectos WHERE codigo='$_POST[codproyecto]' ";
			$res=mysql_query($sql,$linkbd);
			$fila=mysql_fetch_row($res);
			$_POST[nproyecto]=$fila[0];
			//*****************************************************************
			$sqlv="select *from dominios where nombre_dominio='VIGENCIA_PD' and tipo='S'";
			$resv=mysql_query($sqlv,$linkbd);
			$wv=mysql_fetch_row($resv);
			$_POST[vigenciaini]=$wv[0];
			$_POST[vigenciafin]=$wv[1];
			if($_POST[agregadetprod]=='1'){
				
				for($x=0;$x<count($_POST[dproductos1]);$x++ ){
					
					if(isset($_POST[acepta][$x])){
						if(!in_array($_POST[dproductos1][$x],$_POST[dproductos2])){
							$_POST[dpaa][]=$_POST[codadquisicion];
							$_POST[dproductos2][]=$_POST[dproductos1][$x];
							$_POST[dnproductos2][]=$_POST[dnproductos1][$x];
							$_POST[dcantidad2][]=$_POST[dcantidad1][$x];
							$_POST[dvaluni2][]=$_POST[dvaluni1][$x];
						}
						
					}
								
					
				}
				$_POST[agregadetprod]='';
			}
		  if($_POST[eliminarpro]!=''){
			$pos=$_POST[eliminarpro];
			unset($_POST[dpaa][$pos]);
			unset($_POST[dproductos2][$pos]);
			unset($_POST[dnproductos2][$pos]);
			unset($_POST[dcantidad2][$pos]);
			unset($_POST[dvaluni2][$pos]);
			unset($_POST[dtipos2][$pos]);
			$_POST[eliminarpro]='';		 
		  }
		  $sql="SELECT valor FROM planproyectos WHERE codigo='$_POST[codproyecto]'  ";
		  $res=mysql_query($sql,$linkbd);
		  $fila=mysql_fetch_row($res);
		  $totalbanco=$fila[0];
		  $sqlb="SELECT SUM(planproyectos.valor) FROM contrasolicitudproyecto,planproyectos WHERE planproyectos.codigo='$_POST[codproyecto]' AND contrasolicitudproyecto.codproyecto=planproyectos.codigo AND  contrasolicitudproyecto.estado='CE' ";
		  $resb=mysql_query($sqlb,$linkbd);
		  $filab=mysql_fetch_row($resb);
		  $totalcerbanco=$filab[0];
		  $_POST[saldobpim]=$totalbanco-$totalcerbanco;
		?> 
		<?php  //FUNCIONES
		function existePAA($plan){
			global $linkbd;
			$sql="SELECT 1 FROM contraplancompras where codplan='$plan' ";
			$res=mysql_query($sql,$linkbd);
			$num=mysql_num_rows($res);
			return $num;
		}
		function existeProyecto($proyecto){
			global $linkbd;
			$sql="SELECT 1 FROM planproyectos where codigo='$proyecto' AND estado='S' ";
			$res=mysql_query($sql,$linkbd);
			$num=mysql_num_rows($res);
			return $num;
		}
		function existeSolicitudMeta($proyecto,$meta){
			global $linkbd;
			$sql="SELECT 1 FROM contrasolicitudproyecto,contrasolicitudproyecto_det where contrasolicitudproyecto.codproyecto='$proyecto' AND  contrasolicitudproyecto_det.valor='$meta' AND contrasolicitudproyecto.codsolicitud=contrasolicitudproyecto_det.codigosol";
			$res=mysql_query($sql,$linkbd);
			$num=mysql_num_rows($res);
			return $num;
		}
		?>
       
    	<div class="tabscontra" style="height:76.5%; width:99.6%">
   			<div class="tab"> 
  				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> onClick="cambiobotones1(); cambiopestanas('1');" >
	   			<label for="tab-1">Solicitud de Adquisiciones</label> 
                <div class="content" style="overflow:hidden">
                    <table class="inicio">
                        <tr>
                            <td colspan="8" class="titulos" style="width:94%">Solicitud de Adquisiciones</td>
                            <td class="cerrar" style="width:6%"><a href="#" onClick="cerrarventanas()"> Cerrar</a></td>
                        </tr>
                        <tr>
                            <td class="saludo1">C&oacute;digo Solicitud:</td>
                            <td><input type="text" name="codigot" id="codigot" value="<?php echo $_POST[codigot]?>" style="width:85%;" readonly></td>
                            <td class="saludo1">Fecha:</td>
                            <td>
							<input name="fechat" id="fechat" type="text" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fechat]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechat');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
							</td>
                            <td class="saludo1" style="width:10%">Destino de compra:</td>
                            <td width="21%">
								<select name="destcompra" id="destcompra" style="width: 95%">
									<?php
										$sql="SELECT * FROM almdestinocompra WHERE estado='S' ORDER BY codigo";
										$result=mysql_query($sql,$linkbd);
										while($row = mysql_fetch_row($result)){
											if($_POST[destcompra]==$row[0]){
												echo "<option value='$row[0]' SELECTED>$row[1]</option>";
											}else{
												echo "<option value='$row[0]'>$row[1]</option>";
											}
											
										}
									?>
								</select>
							</td> 
							<td class="saludo1" style="width:10%">Liberar:</td>
                            <td> <!-- <input name="finaliza" type="checkbox" value="1" style="padding: 50px !important" disabled> !--> <div class="c1"><input type="checkbox" id="finaliza" name="finaliza" value="1"  disabled/><label for="finaliza" id="t1" ></label></div></td> 
                        </tr>
                        <tr>
                            <td class="saludo1" style="width:12%;">Objeto:</td>
                            <td colspan="10" valign="middle" style="width:15%;">
                                <input type="text" id="descripciont" name="descripciont"  value="<?php echo $_POST[descripciont]?>" onKeyUp="document.getElementById('descripcionb').value=this.value" style="width:91.3%">
							</td>
                          
                           
                        </tr>   
                        <tr>
                            <td  class="saludo1">Jefe de departamento:</td>
                            <td>
                                <input id="tercero" name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)">
                                <a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;" border="0"></a>
                            </td>
                            <td colspan="2" style="width:20%;"><input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                            <td> <input type="button" name="agregas" value="  Agregar  " onClick="agregardetallesol()" ></td>
                            <td colspan="3">
								<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">Solicitar certificado</label></div>
								<div class="c2" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza1" name="finaliza1" <?php if(isset($_POST['finaliza1'])){echo "checked";} ?> value="<?php echo $_POST[finaliza1]?>"   onChange="validafinalizar(this,'1')"/><label for="finaliza1" id="t2" ></label></div>
								
								<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
								<div class="c3" style="display:inline-block; "><input type="checkbox" id="finaliza2" name="finaliza2" <?php if(isset($_POST['finaliza2'])){echo "checked";} ?> value="<?php echo $_POST[finaliza2]?>" onChange="validafinalizar(this,'1')" /><label for="finaliza2" id="t3" ></label></div>
								
								 
								
                                <input type="hidden" name="dependencia" id="dependencia" value="<?php echo $_POST[dependencia]?>">
                                <input type="hidden" name="iddependencia" id="iddependencia" value="<?php echo $_POST[iddependencia]?>">
                            </td>
                        </tr>
                    </table>
                    <div class="subpantalla" style="height:9%; width:99.6%; margin-top:0px; overflow:hidden">
                        <table class="inicio" style="width:100%">
                            <tr>
                                <td class="titulos2" style="width:10%">Documento</td>
                                <td class="titulos2" style="width:45%">Nombre</td>
                                <td class="titulos2" style="width:45%">Dependencia</td>
                                <td class="titulos2" style="width:5%" align=\"middle\">Eliminar</td>
                            </tr>
                            <?php
                                $iter='saludo1a';
                                $iter2='saludo2';
                                for ($x=0;$x<count($_POST[sdocumento]);$x++)
                                {	
                                    echo "
                            <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                                <td><input class='inpnovisibles' name='sdocumento[]' value='".$_POST[sdocumento][$x]."' type='text' readonly style='width:100%'></td>
                                <td><input class='inpnovisibles' name='snombre[]'  value='".$_POST[snombre][$x]."' type='text' style=\"width:100%\" readonly style='width:100%'></td>
                                <td><input class='inpnovisibles' name='sndependencia[]' value='".$_POST[sndependencia][$x]."' type='text' readonly style='width:100%'><input name='sidependencia[]' value='".$_POST[sidependencia][$x]."' type='hidden'></td>
                                <td align=\"middle\"><a href='#' onclick='eliminars($x)'><img src='imagenes/del.png'></a></td>
                            </tr>";	
                                $aux=$iter;
                                $iter=$iter2;
                                $iter2=$aux;
                                }	
								$sumcer=0;
								for ($x=0;$x<count($_POST[dproductos1]);$x++)
								{		 
									if(isset($_POST[acepta][$x])){
			
										$sumcer+=$_POST[dvaluni1][$x];
								
									}
								}
								$_POST[saldopaa]=$_POST[saldopaa1]-$sumcer;
                            ?>
                        </table>
                    </div>  
					<table class="inicio" style="width:100%">
                            <tr><td  class="titulos" colspan="7">Productos a Solicitar</td></tr>
							<tr>
								<td class="saludo1" style="width: 12%">C&oacute;digo Plan Anual:</td>
								<td valign="middle" style="width: 19.5%">
									<input type="text" name="codadquisicion" id="codadquisicion" onKeyPress="javascript:return solonumeros(event)" 
						  onKeyUp="return tabular(event,this)" onBlur="buscadquisicion()" value="<?php echo $_POST[codadquisicion]?>" onClick="document.getElementById('codadquisicion').focus();document.getElementById('codadquisicion').select();" style="width:85%" >
									<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" class="icobut"></a></td>
								<td style="width: 30%"><input type="text" name="nadquisicion" id="nadquisicion" value="<?php echo $_POST[nadquisicion]?>" style="width:95%"  readonly></td>
								<td  class="saludo1" >Saldo: </td>
								<td  >
									
									<input type="text" value="<?php echo $_POST[saldopaa]; ?>" name="saldopaa" id="saldopaa" <?php if($_POST[saldopaa]<0){echo "style='background-color:#EF9A9A !important' "; }else{echo "style='background-color:#BBDEFB !important' ";} ?>  readonly> 
									<input type="hidden" value="<?php echo $_POST[saldopaa1]; ?>" name="saldopaa1" id="saldopaa1" > 
									<input type="button" name="agregas" value="  Agregar Productos a Solicitud " onClick="agregarproductos()" >
								</td>
							
									
									<input type="hidden" value="<?php echo $_POST[agregadetprod]; ?>" name="agregadetprod" id="agregadetprod"> 
								
							</tr>
                        </table>
						 <div class="subpantalla" style="height:35%; width:99.5%; overflow:hidden">
						 <div class="col1" style="width: 80% !important;display:inline-block;vertical-align:top;overflow-y:scroll;overflow-x:hidden; height:100%">
						 <table class="inicio" style="width:100%">
						<tr>
						<td class="titulos2" style="width:5%"><input type="checkbox" name="todos" id="todos" <?php if(isset($_POST[todos])){echo "CHECKED"; } ?> style=
					"height:10px !important" onChange="aprobartodo(this)"/>Solicitar</td>
						<td class="titulos2" style="width:10%">Codigo</td>
						<td class="titulos2" style="width:30%">Nombre</td>
						<td class="titulos2"style="width:15%">Tipo</td>
						<td class="titulos2"style="width:10%">Cantidad</td>
						<td class="titulos2"style="width:20%">Valor Estimado</td>
						
					</tr>
					<?php
						
						if($_POST[bc]=='1')
						{
							echo"<script>document.form2.bc.value='0';</script>";
							$dosdigitos=substr($_POST[cuenta], 6);
							if($dosdigitos!="00" && $dosdigitos!="")
							{
								$nresul=buscaproducto($_POST[cuenta]);
								if($nresul!='')
								{
									echo"<script>
										document.form2.ncuenta.value='$nresul'; 
										document.getElementById('agrega').focus();
										document.getElementById('agrega').select();</script>";
								}
								else
								{
									echo"<script>
										despliegamodalm('visible','2','Codigo Incorrecto');
										document.form2.ncuenta.value='';
										document.form2.cuenta.value='';
									</script>";
								}
							}
							else
							{
								echo"<script>
									despliegamodalm('visible','2','Codigo Incorrecto');
									document.form2.ncuenta.value='';
									document.form2.cuenta.value='';
								</script>";
							}
						}

						$iter='saludo1';
						$iter2='saludo2';
						$sumcant=0;
						
						$conteval=0;
						for ($x=0;$x<count($_POST[dproductos1]);$x++)
						{		 
							if(isset($_POST[acepta][$x])){
									$check="CHECKED";
									$disabled="";
									$sumcant+=$_POST[dcantidad1][$x];
									$conteval++;
									$estilofila="style='background-color: #0277BD !important;' ";
									$estilocelda="style='color:white !important; font-weight:bold !important;width:100%' ";
								}else{
									$check="";
									$_POST[dcantidadv1][$x]="";
									$_POST[dcantidad1][$x]="";
									$_POST[dvaluni1][$x]=0;
									$disabled="READONLY";
									$estilofila="";
									$estilocelda="";
								}
							echo "
										<script>
											jQuery(function($){ $('#dvaluniv1$x').autoNumeric('init');});
											jQuery(function($){ $('#dcantidadv1$x').autoNumeric('init',{mDec:'0'});});
										</script>
								<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" id='$x' $estilofila>
									<td ><input type='checkbox' name='acepta[$x]' id='acepta[$x]'  onChange='marcar($x)' $check/></td>
									<td ><input class='inpnovisibles' name='dproductos1[]' value='".$_POST[dproductos1][$x]."' type='text' $estilocelda readonly></td>
									<td ><input class='inpnovisibles' name='dnproductos1[]'  value='".$_POST[dnproductos1][$x]."' type='text' $estilocelda readonly></td>
									<td ><input class='inpnovisibles' name='dtipos1[]' value='".$_POST[dtipos1][$x]."' type='text' $estilocelda readonly></td>
									
									<td>
												<input type='hidden' name='dcantidad1[]' id='dcantidad1$x' value='".$_POST[dcantidad1][$x]."'/>
												<input type='text' name='dcantidadv1[]' id='dcantidadv1$x' value='".$_POST[dcantidad1][$x]."' style='width:100%;text-align:right;' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dcantidad1$x','dcantidadv1$x');\" onBlur='document.form2.submit();' $disabled  />
											</td>
											<td>
												<input type='hidden' name='dvaluni1[]' id='dvaluni1$x' value='".$_POST[dvaluni1][$x]."'/>
												<input type='hidden' name='estilo[]' id='estilo$x' value='".$_POST[estilo][$x]."'/>
												<input type='text' name='dvaluniv1[]' id='dvaluniv1$x' value='".$_POST[dvaluni1][$x]."' style='width:100%;text-align:right;' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvaluni1$x','dvaluniv1$x');\" onBlur='document.form2.submit()' $disabled />												
											</td>";		
								
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							
						}	
						
					?>
				</table>
				</div>
				<div class="col2" style=" width:19.5%;display:inline-block;background-color:white;overflow:hidden">
					<img src="imagenes/seleccionar.png"  alt="Imagen de seleccionar" style="height: 98%;margin-left: 15%"/>
				</div>	 
						
				
 			</div>
			<!--
			      <div class="subpantalla" style="height:5%; width:99.5%; margin-top:0px; overflow:hidden">
                        <table class="inicio" style="width:99%">
                            <tr>
                                <td class="titulos2" style="width: 45%">Total</td>
                                <td class="titulos2" style="width:6%; text-align:right"><?php echo $sumcant; ?></td>
                                <td class="titulos2" style="width:13%; text-align:right">$ <?php echo number_format($sumtotal,2,'.',','); ?></td>
                                
                            </tr>
                        </table>
                    </div>
		     !-->
					 <div class="subpantalla" style="height:24%; width:99.5%; overflow-x:hidden">
						<table class="inicio" style="width:100%">
						 <tr><td  class="titulos" colspan="6">Productos Solicitados</td></tr>
							<tr>
								<td class="titulos2" style="width:10%">Codigo</td>
								<td class="titulos2" style="width:40%">Nombre</td>
								<td class="titulos2"style="width:15%">Tipo</td>
								<td class="titulos2"style="width:10%">Cantidad</td>
								<td class="titulos2"style="width:20%">Valor Estimado</td>
								<td class="titulos2"style="width:20%" align="middle">Eliminar</td>
								
							</tr>
				<?php
				$iter='saludo1';
				$iter2='saludo2';
				$sumtotal=0;
				for ($x=0;$x<count($_POST[dproductos2]);$x++)
					{		 
						$sumtotal+=$_POST[dvaluni2][$x];
						echo "
									<script>
										jQuery(function($){ $('#dvaluniv2$x').autoNumeric('init');});
										jQuery(function($){ $('#dcantidadv2$x').autoNumeric('init',{mDec:'0'});});
									</script>
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
								<input  type='hidden' name='dpaa[]' value='".$_POST[dpaa][$x]."'  >
								<td><input class='inpnovisibles' name='dproductos2[]' value='".$_POST[dproductos2][$x]."' type='text' readonly></td>
								<td><input class='inpnovisibles' name='dnproductos2[]'  value='".$_POST[dnproductos2][$x]."' type='text' style=\"width:100%\" readonly></td>
								<td><input class='inpnovisibles' name='dtipos2[]' value='PRODUCTO' type='text'  readonly></td>
								
								<td>
	
									<input type='hidden' name='dcantidad2[]' id='dcantidad2$x' value='".$_POST[dcantidad2][$x]."'/>
									<input type='text' class='inpnovisibles' name='dcantidadv2[]' id='dcantidadv2$x' value='".$_POST[dcantidad2][$x]."' style='width:100%;text-align:right;' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dcantidad2$x','dcantidadv2$x');\"  readonly  />
								</td>
								<td>
									<input type='hidden' name='dvaluni2[]' id='dvaluni2$x' value='".$_POST[dvaluni2][$x]."'/>
									<input type='text' class='inpnovisibles' name='dvaluniv2[]' id='dvaluniv2$x' value='".$_POST[dvaluni2][$x]."' style='width:100%;text-align:right;' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvaluni2$x','dvaluniv2$x');\"  readonly />												
								</td>
								<td align=\"middle\"><a href='#' onclick='eliminardp($x)'><img src='imagenes/del.png'></a></td>";		
								
							
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						
					}
				$_POST[banderin5]=count($_POST[dproductos2]);
				?>
				</table>
				</div>
				
                </div>
           	</div>
            <div class="tab"> 
  				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> onClick="cambiobotones1(); cambiopestanas('2');" disabled >
	   			<label for="tab-2"><img src="<?php echo $p1luzcem1;?>" width="16" height="16"><img src="<?php echo $p1luzcem2;?>" width="16" height="16"><img src="<?php echo $p1luzcem3;?>" width="16" height="16">Productos Adquisici&oacute;n</label> 
                <div class="content" style="overflow:hidden">
                    <table class="inicio">
                        <tr>
                            <td colspan="9" class="titulos">C&oacute;digo Plan Compras:</td>
                        </tr>
                        <tr>
                            <td class="saludo1" style="width:12%;">C&oacute;digo Plan Compras:</td>
                            <td valign="middle" style="width:15%;">
                                <input type="text" id="codadquisicionrep" name="codadquisicionrep"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscadquisicion(event)" value="<?php echo $_POST[codadquisicionrep]?>" onClick="documen t.getElementById('codadquisicionrep').focus();document.getElementById('codadquisicionrep').select();" style="width:85%" readonly></td>
                            <td class="saludo1" style="width:6%;">Objeto:</td>
                            <td colspan="6"><input name="nadquisicionrep" type="text" value="<?php echo $_POST[nadquisicionrep]?>" style="width:91%" readonly></td>
                        </tr> 
                    </table>
					<input type="hidden" name="vigenciaini" value="<?php echo $_POST[vigenciaini] ?>">
					<input type="hidden" name="vigenciafin" value="<?php echo $_POST[vigenciafin] ?>">
                    <div class="subpantalla" style="height:87%; width:99.6%; margin-top:0px; overflow-x:hidden">
                        <table class="inicio" style="width:100%">
                            <tr>
                                <td class="titulos2" style="width:10%">Codigo</td>
                                <td class="titulos2" >Nombre</td>
                                <td class="titulos2" style="width:10%">Cantidad</td>
                                <td class="titulos2" style="width:15%">Valor Unitario</td>
                                <td class="titulos2" style="width:20%">Tipo</td>
                            </tr>
                            <?php
                                $iter='saludo1a';
                                $iter2='saludo2';
                                for ($x=0;$x<count($_POST[dproductos]);$x++)
                                {		 
                                    echo "
										<script>
											jQuery(function($){ $('#dvaluniv$x').autoNumeric('init');});
											jQuery(function($){ $('#dcantidadv$x').autoNumeric('init',{mDec:'0'});});
										</script>
                                        <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                                            <td><input class='inpnovisibles' name='dproductos[]' value='".$_POST[dproductos][$x]."' type='text' readonly style='width:100%'></td>
                                            <td><input class='inpnovisibles' name='dnproductos[]'  value='".$_POST[dnproductos][$x]."' type='text' style='width:100%' readonly></td>
											<td>
												<input type='hidden' name='dcantidad[]' id='dcantidad$x' value='".$_POST[dcantidad][$x]."'/>
												<input type='text' name='dcantidadv[]' id='dcantidadv$x' value='".$_POST[dcantidadv][$x]."' style='width:100%;text-align:right;' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dcantidad$x','dcantidadv$x');\"  />
											</td>
											<td>
												<input type='hidden' name='dvaluni[]' id='dvaluni$x' value='".$_POST[dvaluni][$x]."'/>
												<input type='text' name='dvaluniv[]' id='dvaluniv$x' value='".$_POST[dvaluniv][$x]."' style='width:100%;text-align:right;' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvaluni$x','dvaluniv$x');\" />												
											</td>
                                            <td><input class='inpnovisibles' name='dtipos[]' value='".$_POST[dtipos][$x]."' type='text'  readonly style='width:100%'></td>";		
                                    echo "</tr>";	
                                    $aux=$iter;
                                    $iter=$iter2;
                                    $iter2=$aux;
                                }	
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab"> 
  				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> onClick="cambiobotones1(); cambiopestanas('3');" >
	   			<label for="tab-3">Solicitud CDP</label> 
                	<div class="content" style="overflow:hidden">
                   		<table class="inicio" align="center" >
                            <tr>
                                <td class="titulos" colspan="8">.: Solicitud Certificado Disponibilidad Presupuestal </td>
                                <td class="cerrar" style="width:6%"><a href="#" onClick="cerrarventanas()"> Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:10%"> Tipo de Gasto:</td>
                                <td style="width:20%" colspan="5"> 
                                    <select name="tipocuenta" id="tipocuenta" onKeyUp="return tabular(event,this)" onChange="cambiatipo(this)" style="width:100%">
                                        <option value="funcionamiento" <?php if($_POST[tipocuenta]=='funcionamiento') echo "SELECTED"; ?>>Funcionamiento</option>
                                        <option value="deuda" <?php if($_POST[tipocuenta]=='deuda') echo "SELECTED"; ?>>Deuda</option>
                                        <option value="inversion" <?php if($_POST[tipocuenta]=='inversion') echo "SELECTED"; ?>>Inversion</option>
                                    </select>
                                </td>
                                

								<!-- adding Liberar -->
								</tr>
                            <tr>  
                                <td  class="saludo1">Rubro:</td>
                                <td>
									<input type="hidden" name="cuenfuen" id="cuenfuen" value="<?php echo $_POST[cuenfuen]?>"   />
                                    <input type="text" id="codrubro" name="codrubro" onKeyUp="return tabular(event,this)" onBlur="buscarubro(event)" value="<?php echo $_POST[codrubro]?>" onClick="document.getElementById('codrubro').focus(); document.getElementById('codrubro').select();" style="width:85%" ?> 
                                    <input type="hidden" value="0" name="bcrubro" id="bcrubro"><a href="#" onClick="despliegamodal2('visible','4');"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;" border="0"></a>
                                </td>
                                <td colspan="2" style="width:26%"><input name="nrubro" id="nrubro" type="text" value="<?php echo $_POST[nrubro]?>" style="width:100%" readonly></td>
                                <td class="saludo1">Fuente:</td>
                                <td><input name="fuente" type="text" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fuente] ?>" style="width:100%" readonly><input type="hidden" name="cfuente" value="<?php echo $_POST[cfuente] ?>"></td>
                            </tr>
                            <tr> 
                            <td class="saludo1">Valor:</td>
                            <td>
                            	<script>jQuery(function($){ $('#valorv').autoNumeric('init');});</script>
                     			<input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>"   />
                          		<input type="text" id="valorv" name="valorv"  value="<?php echo $_POST[valorv]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valor','valorv');return tabular(event,this);" onBlur="validarcdp();" style="width:85%; text-align:right;" autocomplete="off" >
                     
                            </td>
							<td>
								<script>jQuery(function($){ $('#saldov').autoNumeric('init');});</script>
                     			<input type="hidden" name="saldo" id="saldo" value="<?php echo $_POST[saldo]?>"   />
                          		<input type="text" id="saldov" name="saldov"  value="<?php echo $_POST[saldov]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('saldo','saldov');return tabular(event,this);"  style="width:85%; text-align:right;" autocomplete="off" readonly>
            
                            </td>
                            <td>
                                <input type="button" name="agregar2" id="agregar2" value="   Agregar   " onClick="agregardetalle2()" >
                            </td>
                            <td colspan="3" >
								<input type="hidden" name="solbpim" id="solbpim" value="<?php echo $_POST[solbpim]; ?>" />
								
								
								
								 <div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">Solicitar certificado</label></div>
								<div class="c5" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza5" name="finaliza5" <?php if(isset($_POST['finaliza5'])){echo "checked";} ?> value="<?php echo $_POST[finaliza5]?>"  onChange="validafinalizar(this,'2')" /><label for="finaliza5" id="t5" ></label></div>
								
								<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
								<div class="c6" style="display:inline-block; "><input type="checkbox" id="finaliza6" name="finaliza6" <?php if(isset($_POST['finaliza6'])){echo "checked";} ?> value="<?php echo $_POST[finaliza6]?>"   onChange="validafinalizar(this,'2')" disabled/><label for="finaliza6" id="t6" ></label></div>

						
								</td>

                        </tr>  
                    </table>
                    <div class="subpantalla" style="height:76.5%; width:99.5%; margin-top:0px; overflow-x:hidden">
                        <table class="inicio" width="99%">
                            <tr>
                                <td class="titulos" colspan="5">Detalle CDP</td>
                            </tr>
                            <tr>
                                <td class="titulos2">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2">Fuente</td>
                                <td class="titulos2">Valor</td>
                                <td class="titulos2"><img src="imagenes/del.png"></td>
                            </tr>
                            <?php 
                            if ($_POST[elimina]!='')
                            { 
                                $posi=$_POST[elimina];
                                $cuentagas=0;
                                $cuentaing=0;
                                $diferencia=0;
                                unset($_POST[dcuentas][$posi]);
                                unset($_POST[dtipogastos][$posi]);
                                unset($_POST[dncuentas][$posi]);
                                unset($_POST[dgastos][$posi]);		 		 		 		 		 
                                unset($_POST[dcfuentes][$posi]);		 		 
                                unset($_POST[dfuentes][$posi]);		 		 
                                $_POST[dcuentas]= array_values($_POST[dcuentas]); 
                                $_POST[dtipogastos]= array_values($_POST[dtipogastos]); 
                                $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                                $_POST[dgastos]= array_values($_POST[dgastos]); 
                                $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                                $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 			 	 	
                                $_POST[elimina]='';	 		 		 		 
                            }	 
                            if ($_POST[agregadet2]=='1')
                            {
                                $ch=esta_en_array($_POST[dcuentas],$_POST[codrubro]);
                                if($ch!='1')
                                {			 
                                    $cuentagas=0;
                                    $cuentaing=0;
                                    $diferencia=0;
                                    $_POST[dcuentas][]=$_POST[codrubro];
                                    $_POST[dtipogastos][]=$_POST[tipocuenta];
                                    $_POST[dncuentas][]=$_POST[nrubro];
                                    $_POST[dfuentes][]=$_POST[fuente];
                                    $_POST[dcfuentes][]=$_POST[cfuente];		 
                                    $_POST[valor]=str_replace(".","",$_POST[valor]);
                                    $_POST[dgastos][]=$_POST[valor];	 		 
                                    $_POST[agregadet2]=0;
                           	 		echo"
                            		<script>	
										document.form2.codrubro.value='';
										document.form2.nrubro.value='';
										document.form2.fuente.value='';
										document.form2.cfuente.value='';
										document.form2.valor.value='';
										document.form2.valorv.value='';
										document.form2.saldo.value='';
                                		document.form2.codrubro.focus();	
                            		</script>";
                               	}
                                else{echo"<script>parent.despliegamodalm('visible','2','Ya se Ingreso el Rubro  $_POST[codrubro] en el CDP');</script>";}
							}
       						$itern='saludo1a';
                   			$iter2n='saludo2';
							$sololeer="readonly";
							if($_POST[cuenfuen]=="1"){
								$sololeer="readonly";
							}else{
								$sololeer="";
							}
							
                            for ($x=0;$x<count($_POST[dcuentas]);$x++)
                            {
								echo "<script>
								document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)+1;
								</script>";
								
                                echo "
                                <tr class='$itern' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                                    <td><input class='inpnovisibles' name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%' $sololeer onBlur='buscacuenta()' ></td>
                                    <td><input class='inpnovisibles' name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%' readonly></td>
                                    <td>
                                        <input class='inpnovisibles' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."' type='hidden'>
                                        <input class='inpnovisibles' name='dfuentes[]' value='".$_POST[dfuentes][$x]."' type='text' style='width:100%' readonly>
                                    </td>
                                    <td  style='width:5%;'><input class='inpnovisibles' name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text'  onDblClick='llamarventana(this,$x)'  style='text-align:right;' readonly></td>
                                    <td><a href='#' onclick='eliminar2($x)'><img src='imagenes/del.png'></a></td>
                                    <input name='dtipogastos[]' value='".$_POST[dtipogastos][$x]."' type='hidden'>
                                </tr>";
                                $auxn=$itern;
                                $itern=$itern2;
                                $itern2=$auxn;
                                $gas=$_POST[dgastos][$x];
                                $gas=$gas;
                                $cuentagas=$cuentagas+$gas;
                                $_POST[cuentagas2]=$cuentagas;
                                $total=number_format($total,2,",","");
                                $_POST[cuentagas]=$cuentagas;
                                $_POST[letras]=convertir($cuentagas)." PESOS";
                            }
                            echo "
                            <tr>
                                <td></td>
                                <td></td>
                                <td style='text-align:right;'>TOTAL:</td>
                                <td style='text-align:right;'><input type='hidden' class='inpnovisibles' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'  readonly>$".number_format($_POST[cuentagas],2,".",",")."<input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'><input id='letras' name='letras' value='$_POST[letras]' type='hidden'></td>
                            </tr>";
                             echo "
                             <tr>
                                <td class='saludo1'>Son:</td>
                                <td class='saludo1' colspan= '4'>$_POST[letras]</td>
                            </tr>";
                            ?>
                            <input type='hidden' name='elimina' id='elimina'>
                    	</table>
                    </div>
                 </div>
            </div>
			
			
            <div class="tab">
       			<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> onClick="cambiobotones2();cambiopestanas('4');" >
	   			<label for="tab-24"><img src="<?php echo $p2luzcem1;?>" width="16" height="16"><img src="<?php echo $p2luzcem2;?>" width="16" height="16"><img src="<?php echo $p2luzcem3;?>" width="16" height="16"> Informaci&oacute;n CDP</label>	
	  				<div class="content">     
                    </div>
      		</div> 
 <div class="tab"> 
  				<input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> onClick="cambiobotones1(); cambiopestanas('5');" >
	   			<label for="tab-5">Solicitud Banco Proyectos</label> 
                	<div class="content" style="overflow:hidden">
                   		<table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="9" >Ingresar Proyecto</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='plan-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
							
							<!-- add lo de la pestaña 1 -->
							<tr>
								<td class="saludo1">C&oacute;digo Solicitud:</td>
								<td><input type="text" name="codigotb" id="codigotb" value="<?php echo $_POST[codigotb]; ?>" style="width:85%;" readonly></td>
								<td class="saludo1">Fecha:</td>
								<td>
								<input name="fechatb" id="fechatb" type="text" title="DD/MM/YYYY" style="width:75%;"  value="<?php echo $_POST[fechatb]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fechatb');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;cursor:pointer;" style="width:20px;"></a>
								</td>
								<td class="saludo1" style="width:10%">Vigencia :</td>
								<td width="13%">
									<input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]; ?>" style="width:100%;"readonly>
								</td> 
								
								<td colspan="2" >
									<input type="hidden" name="solbpim" id="solbpim" value="<?php echo $_POST[solbpim]; ?>" />
									
									<?php
									$sql="SELECT COUNT(*),estado FROM contrasolicitudproyecto WHERE codsolicitud=$_POST[codigot] ";
									$res=mysql_query($sql,$linkbd);
									$row = mysql_fetch_row($res);
									if($row[0]==0){
									?>					
									 <div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">Solicitar certificado</label></div>
									 <div class="c7" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza7" name="finaliza7" <?php if(isset($_POST['finaliza7'])){echo "checked";} ?> value="<?php echo $_POST[finaliza7]?>"  onChange="validafinalizar(this,'3')"/><label for="finaliza7" id="t7" ></label></div>
									 
									 <div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
									<div class="c8" style="display:inline-block; "><input type="checkbox" id="finaliza8" name="finaliza8" <?php if(isset($_POST['finaliza8'])){echo "checked";} ?> value="<?php echo $_POST[finaliza8]?>"   onChange="validafinalizar(this,'3')"/><label for="finaliza8" id="t8" ></label></div>
									<?php
									}else{
										if($row[1]!='CO' && $row[1]!='CC' && $row[1]!='S'){
									?>
									<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">Solicitar certificado</label></div>
									 <div class="c7" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza7" name="finaliza7" <?php if(isset($_POST['finaliza7'])){echo "checked";} ?> value="<?php echo $_POST[finaliza7]?>"  onChange="validafinalizar(this,'3')" disabled/><label for="finaliza7" id="t7" ></label></div>
									 
									 <div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
									<div class="c8" style="display:inline-block; "><input type="checkbox" id="finaliza8" name="finaliza8" <?php if(isset($_POST['finaliza8'])){echo "checked";} ?> value="<?php echo $_POST[finaliza8]?>"   onChange="validafinalizar(this,'3')" disabled/><label for="finaliza8" id="t8" ></label></div>
									<?php

									}else if($row[1]=='CO' || $row[1]=='CC'){
										?>
									<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">Solicitar certificado</label></div>
									 <div class="c7" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza7" name="finaliza7" <?php if(isset($_POST['finaliza7']) || $row[1]=='CC'){echo "checked";} ?> value="<?php echo $_POST[finaliza7]?>"  onChange="validafinalizar(this,'3')" /><label for="finaliza7" id="t7" ></label></div>
									 
									 <div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
									<div class="c8" style="display:inline-block; "><input type="checkbox" id="finaliza8" name="finaliza8" <?php if(isset($_POST['finaliza8'])){echo "checked";} ?> value="<?php echo $_POST[finaliza8]?>"   onChange="validafinalizar(this,'3')" disabled/><label for="finaliza8" id="t8" ></label></div>
									<?php 
									}else{
									
									?>
									<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">Solicitar certificado</label></div>
									 <div class="c7" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza7" name="finaliza7" <?php if(isset($_POST['finaliza7']) || $row[1]=='CC'){echo "checked";} ?> value="<?php echo $_POST[finaliza7]?>"  onChange="validafinalizar(this,'3')" /><label for="finaliza7" id="t7" ></label></div>
									 
									 <div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
									<div class="c8" style="display:inline-block; "><input type="checkbox" id="finaliza8" name="finaliza8" <?php if(isset($_POST['finaliza8'])){echo "checked";} ?> value="<?php echo $_POST[finaliza8]?>"   onChange="validafinalizar(this,'3')" /><label for="finaliza8" id="t8" ></label></div>
									<?php 
									}
								}
									
									?>
								</td>
							</tr>
							<tr>
                               <td class="saludo1">Objeto:</td>
                                <td colspan="5">
                                    <input type="text" name="descripcionb" id="descripcionb"  value="<?php echo $_POST[descripcionb]?>" style="width:100%;height: 30px" readonly> 
                                </td>
								<td >
									<div style="display:inline-block; background-color: white !important;margin-left: 14%"><label style="background-color: white !important">Proyecto</label></div>
									 <div class="c9" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza9" name="finaliza9" <?php if(isset($_POST['finaliza9'])){echo "checked";} ?> value="<?php echo $_POST[finaliza9]?>"  onChange="validatipo(this)"/><label for="finaliza9" id="t9" ></label></div>
									 
									 <div style="display:inline-block; background-color: white !important;margin-right: 1% "><label style="background-color: white !important">Actividad</label></div>
									<div class="c10" style="display:inline-block; "><input type="checkbox" id="finaliza10" name="finaliza10" <?php if(isset($_POST['finaliza10'])){echo "checked";} ?> value="<?php echo $_POST[finaliza10]?>"  onChange="validatipo(this)"/><label for="finaliza10" id="t10" ></label></div>
									<input type="button" name="pdfsol4" id="pdfsol4" <?php if(!empty($_POST[descripcionb])){echo "onClick='pdfsolicitudbanco()' "; } ?> value="PDF Solicitud" style="width: 20% !important" >
								</td>
								
								
								
                             </tr>
						</table>
                        <div class="subpantalla" style="height:100%; width:99.5%; overflow:hidden">
						
							
							
							 <table class="inicio" >
							 
                            <tr>
                                <td class="titulos" colspan="9" >Metas</td>
                            </tr>
         
                            <?php
                                $sqln="SELECT nombre, orden, codigo FROM plannivelespd WHERE estado='S' ORDER BY orden";
                                $resn=mysql_query($sqln,$linkbd);
                                $n=0; $j=0;
                                while($wres=mysql_fetch_array($resn))
                                {
                                    if (strcmp($wres[0],'INDICADORES')!=0)
                                    {
                                        if($wres[1]==1){$buspad='';}
                                        elseif($_POST[arrpad][($j-1)]!=""){$buspad=$_POST[arrpad][($j-1)];}
                                        else {$buspad='';}
                                        if($n==0){echo"<tr>";}
                                        echo"
                                            <td class='saludo1'>".strtoupper($wres[0])."</td>
                                            <td colspan='3' style='width:35%;'>
                                                <select name='niveles[$j]' id='niveles[$j]'  onChange='document.form2.pesactiva.value=5; document.form2.oculto.value=1;document.form2.submit();' onKeyUp='return tabular(event,this)' style='width:100%;'>
                                                    <option value=''>Seleccione....</option>";
                                        $sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad'  ORDER BY codigo";
                                        $res=mysql_query($sqlr,$linkbd);
                                        while ($row =mysql_fetch_row($res)) 
                                        {
                                            if($row[0]==$_POST[niveles][$j])
                                            {
                                                $_POST[arrpad][$j]=$row[0];
                                                $_POST[nmeta]=$row[0];
                                                $_POST[meta]=$row[1];
                                                $_POST[codmeta]=$wres[2];
                                                echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
                                                
                                            }
                                            else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
                                        }	
                                        echo"	</select>
                                                <input type='hidden' name='arrpad[$j]' value='".$_POST[arrpad][$j]."' >
                                                <input type='hidden' name='meta' value='".$_POST[meta]."' >
                                                <input type='hidden' name='codmeta' value='".$_POST[codmeta]."' >
                                                <input type='hidden' name='codmetas[]' value='".$_POST[codmeta]."' />
                                                 <input type='hidden' name='nmetas[]' value='".$_POST[meta]."' />
                                                <input type='hidden' name='nmeta' value='".$_POST[nmeta]."' >

                                            </td>";
                                        $n++;
                                        if($n>1){$n=0;echo"</tr>";}
                                        $j++;
                                    }
                                }
                            ?>
                           
                        </table>
						<table class="inicio" style="width:100%">
								<tr><td  class="titulos" colspan="5">Proyecto</td></tr>
								<tr>
									<td class="saludo1" style="width: 12%">C&oacute;digo BPIM:</td>
										<input type="text" name="codproyecto" id="codproyecto" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="document.form2.submit()" value="<?php echo $_POST[codproyecto]?>" onClick="document.getElementById('codproyecto').focus();document.getElementById('codproyecto').select();" style="width:85%" >
										<a href="#" onClick="despliegamodal2('visible','7');"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" class="icobut"></a></td>
									<td ><input type="text" name="nproyecto" id="nproyecto" value="<?php echo $_POST[nproyecto]?>" style="width:95%"  readonly></td>
									<td  class="saludo1" >Saldo: </td>
								<td  >
									
									<input type="text" value="<?php echo $_POST[saldobpim]; ?>" name="saldobpim" id="saldobpim" <?php if($_POST[saldobpim]<0){echo "style='background-color:#EF9A9A !important' "; }else{echo "style='background-color:#BBDEFB !important' ";} ?>  readonly> 
									<input type="hidden" value="<?php echo $_POST[saldobpim1]; ?>" name="saldobpim1" id="saldobpim1" > 
								</td>
								</tr>
							</table>
						<?php
                        	$conta=0;
							$suma=0;
							
							$sql="SELECT MAX(cod_meta) FROM planproyectos_det WHERE codigo='$_POST[codproyecto]'";
							$result=mysql_query($sql,$linkbd);
							$rowc = mysql_fetch_row($result);
							if(!is_null($rowc[0])){
								$_POST[contadorsol]=$rowc[0]+1;
							}else{
								$_POST[contadorsol]=0;
							}
							for($j=0;$j<$_POST[contadorsol]; $j++){
								unset($_POST["matmetas1$j"]);
								unset($_POST["matmetasnom1$j"]);
						  }
							$sql="SELECT valor,nombre_valor,cod_meta FROM planproyectos_det WHERE  codigo='$_POST[codproyecto]'  ORDER BY LENGTH(valor),cod_meta ASC";
							$result=mysql_query($sql,$linkbd);
							while($row = mysql_fetch_row($result)){
								$n=$row[2];
								$_POST["matmetas1$n"][]=$row[0];
								$_POST["matmetasnom1$n"][]=$row[1];
							}
							
							$sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' AND nombre!='INDICADORES' ORDER BY orden";
							$resn=mysql_query($sqln,$linkbd);
							$suma=mysql_num_rows($resn)+2;
							$_POST[sumnivel]=$suma;
							$todos="";
							if(isset($_POST[todosb])){
								$todos="CHECKED";
							}
                        	 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='$suma'>Detalle Metas</td>
                                            </tr>
                                            <tr>";
                                
                                
                                $n=0; $j=0;
								echo "<td class='titulos2'><input type='checkbox' name='todosb' id='todosb' style= 'height:10px !important' onChange='aprobartodobanco(this)' $todos/>SOLICITAR</td>";
                                while($wres=mysql_fetch_array($resn))
                                {
                                    if (strcmp($wres[0],'INDICADORES')!=0)
                                    {
                         				$conta++;
                                        echo "<td class='titulos2' style='width: 18% !important'>".strtoupper($wres[0])."</td>";
                                        	
                                    }
                                }
                              		  echo "</tr>";
                 
                                $itern='saludo1a';
                                $iter2n='saludo2';
								$cont=0;
								for($x=0;$x<$_POST[contadorsol]; $x++){
									if(existeSolicitudMeta($_POST[codproyecto],$_POST["matmetas1$x"][$conta-1])>0 && $estado!="S"){
										$estilo="style='background-color: yellow !important' ";
										$disabled="DISABLED";
										$_POST[aceptab][$x]="";
									}else{
										$disabled="";
										$estilo="";
									}
									if(isset($_POST[aceptab][$x])){
										$check="CHECKED";
										$cont++;
									}else{
										$check="";
									}
									if(strcmp($check,"CHECKED")==0  && strcmp($disabled,"DISABLED")!=0){
										$estilo="style='background-color: #0277BD !important;color:white !important;' ";
									}
									
									echo "<tr class='$itern'$estilo>";
									
									if(!empty($disabled)){
										$check="";
									}
									for ($y=0;$y<$conta;$y++)
									{
										
										if(!empty($_POST["matmetas1$x"][$y])){
											if($y==0){
												echo "<td><input type='checkbox' name='aceptab[$x]' id='aceptab[$x]'  onChange='document.form2.submit()' $check $disabled/></td>";
											}
											
											echo "<td>";
											echo $_POST["matmetas1$x"][$y]." - ".$_POST["matmetasnom1$x"][$y];
											echo "<input type='hidden' name='matmetas1".$x."[]' value='".$_POST["matmetas1$x"][$y]."' />";
											echo "<input type='hidden' name='matmetasnom1".$x."[]' value='".$_POST["matmetasnom1$x"][$y]."' />";
											echo "</td>";
											
										}
										
										$auxn=$itern;
										$itern=$itern2;
										$itern2=$auxn;
									}
										
									
									echo "</tr>";
							   }
                               $_POST[banderin4]=$cont;
                                echo "
                                    </table></div>";
                         ?>
						</div>
						 
                 </div>
            </div>	

		<div class="tab">
       			<input type="radio" id="tab-6" name="tabgroup1" value="6" <?php echo $check6;?> onClick="cambiobotones2();cambiopestanas('6');" >
	   			<label for="tab-24"><img src="<?php echo $p2luzcem1;?>" width="16" height="16"><img src="<?php echo $p2luzcem2;?>" width="16" height="16"><img src="<?php echo $p2luzcem3;?>" width="16" height="16"> Informaci&oacute;n Banco Proyectos</label>	
	  				<div class="content">     
                    </div>
        </div> 
		
		<div class="tab"> 
  				<input type="radio" id="tab-7" name="tabgroup1" value="7" <?php echo $check7;?> onClick="cambiobotones1(); cambiopestanas('7');" >
	   			<label for="tab-7">Estudios previos</label> 
                	<div class="content" style="overflow:hidden">
                   		<table class="inicio" >
                       
                            <tr>
                                <td class="titulos" colspan="7" >Estudios Previos</td>
     
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:8%">Anexo:</td>
                                <td style="width:25%" ><input type="text" name="rutarchivoest" id="rutarchivoest"  style="width:100%;" value="<?php echo $_POST[rutarchivoest]?>" readonly> <input type="hidden" name="patharchivoest" id="patharchivoest" value="<?php echo $_POST[patharchivoest] ?>" />

                                 </td>
                                    <td style="width:3%">
                                      <div class='upload'> 
                                      <input type="file" name="plantillaadest" onChange="document.getElementById('pesactiva').value='7';document.form2.oculto.value=1;document.form2.submit();" />
                                      <img src="imagenes/upload01.png" style="width:18px" title="Cargar" /> 
                                    </div> 
                                    </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
            					<td width="25%"><input type="text" style="width: 100% !important; " name="descripcionest" id="descripcionest" value="<?php echo $_POST[descripcionest] ?>"/></td>
            					<td><input type='button' name='agregarest' id='agregarest' value='   Agregar   ' onClick='agregarchivoest()'/></td>
            					<td></td>
                            </tr>
                        </table>
                         <?php
                        	 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='5'>Detalle Estudios Previos</td>
                                            </tr>
                                            <tr>
                                                <td class='titulos2'>Nombre</td>
                                                <td class='titulos2'>Ruta</td>
                                                <td class='titulos2'>".utf8_decode("Descripcion")."</td>
                                                <td class='titulos2'></td>
                                                <td class='titulos2'><img src='imagenes/del.png'></td>
                                            </tr>";
                                if ($_POST[eliminarest]!='')
                                { 
                                    $posi=$_POST[eliminarest];
                                    unset($_POST[nomarchivosest][$posi]);
                                    unset($_POST[rutarchivosest][$posi]);
                                    unset($_POST[descripest][$posi]);
                                    unset($_POST[patharchivosest][$posi]);	 		 
                                    $_POST[nomarchivosest]= array_values($_POST[nomarchivosest]); 
                                    $_POST[rutarchivosest]= array_values($_POST[rutarchivosest]); 
                                    $_POST[descripest]= array_values($_POST[descripest]); 
                                    $_POST[patharchivosest]= array_values($_POST[patharchivosest]); 	
                                    $_POST[eliminarest]='';	 		 		 		 
                                }	 
                                if ($_POST[agregadet6]=='1')
                                {
                                    $ch=esta_en_array($_POST[rutarchivosest],$_POST[rutarchivoest]);
                                    if($ch!='1')
                                    {			 
                                        $_POST[nomarchivosest][]="Adjunto No. ".count($_POST[rutarchivosest]);
                                        $_POST[rutarchivosest][]=$_POST[rutarchivoest];
                                        $_POST[descripest][]=$_POST[descripcionest];
                                        $_POST[patharchivosest][]=$_POST[patharchivoest];
                                        $_POST[agregadet6]=0;
                                        echo"
                                        <script>	
                                            document.form2.rutarchivoest.value='';
                                            document.form2.descripcionest.value='';
											document.form2.patharchivoest.value='';
                                        </script>";
                                    }
                                    else {echo"<script>parent.despliegamodalm('visible','2','Ya se Ingreso el Archivo  $_POST[rutarchivoest]');</script>";}
                                }
                                $itern='saludo1a';
                                $iter2n='saludo2';
                                for ($x=0;$x<count($_POST[nomarchivosest]);$x++)
                                {
                                	$rutaarchivo="informacion/proyectos/temp/".$_POST[patharchivosest][$x];
                                    echo "
                                    <input type='hidden' name='nomarchivosest[]' value='".$_POST[nomarchivosest][$x]."'/>
                                    <input type='hidden' name='rutarchivosest[]' value='".$_POST[rutarchivosest][$x]."'/>
                                    <input type='hidden' name='descripest[]' value='".$_POST[descripest][$x]."'/>
                                    <input type='hidden' name='patharchivosest[]' value='".$_POST[patharchivosest][$x]."'/>
                                        <tr class='$itern'>
                                            <td>".$_POST[nomarchivosest][$x]."</td>
                                            <td>".$_POST[rutarchivosest][$x]."</td>
                                            <td>".$_POST[descripest][$x]." </td>
                                            <td style='text-align:center;width: 30px'><a href='$rutaarchivo' target='_blank' ><img src='imagenes/descargar.png'  title='(Descargar)' ></a></td>
                                        
                                            <td><a href='#' onclick='eliminar4($x)'><img src='imagenes/del.png'></a></td>
                                        </tr>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                                echo "
                                    </table></div>";
                         ?>
                 </div>
            </div>	
			
			<div class="tab"> 
  				<input type="radio" id="tab-8" name="tabgroup1" value="8" <?php echo $check8;?> onClick="cambiobotones1(); cambiopestanas('8');" >
	   			<label for="tab-8">Analisis del sector</label> 
                	<div class="content" style="overflow:hidden">
                   		<table class="inicio" >
                       
                            <tr>
                                <td class="titulos" colspan="7" >Analisis del sector</td>
     
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:8%">Anexo:</td>
                                <td style="width:25%" ><input type="text" name="rutarchivosec" id="rutarchivosec"  style="width:100%;" value="<?php echo $_POST[rutarchivosec]?>" readonly> <input type="hidden" name="patharchivosec" id="patharchivosec" value="<?php echo $_POST[patharchivosec] ?>" />

                                 </td>
                                    <td style="width:3%">
                                    	<div class='upload'> 
										<input type="file" name="plantillaadsec" onChange="document.getElementById('pesactiva').value='8';document.form2.oculto.value=1;document.form2.submit();" />
                                        <img src="imagenes/upload01.png" style="width:18px" title="Cargar" /> 
                                    </div> 
                                    </td>
                                <td class="saludo1" style="width:8%">Descripci&oacute;n:</td>
            					<td width="25%"><input type="text" style="width: 100% !important; " name="descripcionsec" id="descripcionsec" value="<?php echo $_POST[descripcionsec]; ?>"></td>
            					<td><input type='button' name='agregarsec' id='agregarsec' value='   Agregar   ' onClick='agregarchivosec()'/></td>
            					<td></td>
                            </tr>
                        </table>
                         <?php
                        	 echo"
                                <div class='subpantalla' style='height:46.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='5'>Detalle Analisis del Sector</td>
                                            </tr>
                                            <tr>
                                                <td class='titulos2'>Nombre</td>
                                                <td class='titulos2'>Ruta</td>
                                                <td class='titulos2'>".utf8_decode("Descripcion")."</td>
                                                <td class='titulos2'></td>
                                                <td class='titulos2'><img src='imagenes/del.png'></td>
                                            </tr>";
                                if ($_POST[eliminarsec]!='')
                                { 
                                    $posi=$_POST[eliminarest];
                                    unset($_POST[nomarchivossec][$posi]);
                                    unset($_POST[rutarchivossec][$posi]);
                                    unset($_POST[descripsec][$posi]);
                                    unset($_POST[patharchivossec][$posi]);	 		 
                                    $_POST[nomarchivossec]= array_values($_POST[nomarchivossec]); 
                                    $_POST[rutarchivossec]= array_values($_POST[rutarchivossec]); 
                                    $_POST[descripsec]= array_values($_POST[descripsec]); 
                                    $_POST[patharchivossec]= array_values($_POST[patharchivossec]); 	
                                    $_POST[eliminarsec]='';	 		 		 		 
                                }	 
                                if ($_POST[agregadet7]=='1')
                                {
                                    $ch=esta_en_array($_POST[rutarchivossec],$_POST[rutarchivosec]);
                                    if($ch!='1')
                                    {			 
                                        $_POST[nomarchivossec][]="Adjunto No. ".count($_POST[rutarchivossec]);
                                        $_POST[rutarchivossec][]=$_POST[rutarchivosec];
                                        $_POST[descripsec][]=$_POST[descripcionsec];
                                        $_POST[patharchivossec][]=$_POST[patharchivosec];
                                        $_POST[agregadet7]=0;
                                        echo"
                                        <script>	
                                            document.form2.rutarchivosec.value='';
                                            document.form2.descripcionsec.value='';
											document.form2.patharchivosec.value='';
                                        </script>";
                                    }
                                    else {echo"<script>parent.despliegamodalm('visible','2','Ya se Ingreso el Archivo  $_POST[rutarchivosec]');</script>";}
                                }
                                $itern='saludo1a';
                                $iter2n='saludo2';
                                for ($x=0;$x<count($_POST[nomarchivossec]);$x++)
                                {
                                	$rutaarchivo="informacion/proyectos/temp/".$_POST[patharchivossec][$x];
                                    echo "
                                    <input type='hidden' name='nomarchivossec[]' value='".$_POST[nomarchivossec][$x]."'/>
                                    <input type='hidden' name='rutarchivossec[]' value='".$_POST[rutarchivossec][$x]."'/>
                                    <input type='hidden' name='descripsec[]' value='".$_POST[descripsec][$x]."'/>
                                    <input type='hidden' name='patharchivossec[]' value='".$_POST[patharchivossec][$x]."'/>
                                        <tr class='$itern'>
                                            <td>".$_POST[nomarchivossec][$x]."</td>
                                            <td>".$_POST[rutarchivossec][$x]."</td>
                                            <td>".$_POST[descripsec][$x]." </td>
                                            <td style='text-align:center;width: 30px'><a href='$rutaarchivo' target='_blank' ><img src='imagenes/descargar.png'  title='(Descargar)' ></a></td>
                                        
                                            <td><a href='#' onclick='eliminar5($x)'><img src='imagenes/del.png'></a></td>
                                        </tr>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                                echo "
                                    </table></div>";
                         ?>
                 </div>
            </div>
    	</div> 
   	 
        	<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia];?>">
        	<input type="hidden" name="oculgen" id="oculgen" value="<?php echo $_POST[oculgen];?>">
        	<input type="hidden" name="indindex" id="indindex" value="<?php echo $_POST[indindex];?>">
           	<input type="hidden" name="codid" id="codid" value="<?php echo $_POST[codid];?>">
            <input type="hidden" name="pesactiva" id="pesactiva" value="<?php echo $_POST[pesactiva];?>">
            <input type="hidden" name="busadq" id="busadq" value="0">
         	<input type="hidden" name="bctercero" id="bctercero" value="0">
           	<input type="hidden" name="agregadets" id="agregadets" value="0">
            <input type='hidden' name="eliminars" id="eliminars" >
            <input type="hidden" name="bc" value="0">
            <input type="hidden" name="bcproyectos" value="0" >
            <input type="hidden" name="agregadet2" value="0">
			<input type="hidden" name="agregadet6" value="0">
			<input type="hidden" name="agregadet7" value="0">
			<input type="hidden" name="agregadet8" value="0">
            <input type="hidden" name="agregadet" value="0"> 
            <input type="hidden" name="agregadetadq" value="0">
            <input type='hidden' name='eliminar' id='eliminar'>
			<input type="hidden" name="sumnivel" id="sumnivel" value="<?php echo $_POST[sumnivel];?>">
			<input type="hidden" name="eliminarm" id="eliminarm" value="<?php echo $_POST[eliminarm]; ?>">
			<input type="hidden" name="eliminarpro" id="eliminarpro" value="<?php echo $_POST[eliminarpro];?>">
			<input type="hidden" name="contadorsol" id="contadorsol" value="<?php echo $_POST[contadorsol];?>" >
			<input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador];?>" >
			<input type="hidden" name="banderin1" id="banderin1" value="<?php echo $_POST[banderin1];?>" >
			<input type="hidden" name="banderin2" id="banderin2" value="<?php echo $_POST[banderin2];?>" >
			<input type="hidden" name="banderin3" id="banderin3" value="<?php echo $_POST[banderin3];?>" >
			<input type="hidden" name="banderin4" id="banderin4" value="<?php echo $_POST[banderin4];?>" >
			<input type="hidden" name="banderin5" id="banderin5" value="<?php echo $_POST[banderin5];?>" >
			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>" >
			<input type="hidden" name="buscameta" id="buscameta" value="<?php echo $_POST[buscameta];?>">
 			<?php
				
				if (is_uploaded_file($_FILES['plantillaadest']['tmp_name'])) 
				{
					$rutaad="informacion/proyectos/temp/";
					$nomarchivo=$_FILES['plantillaadest']['name'];
					?><script>document.getElementById('rutarchivoest').value='<?php echo $_FILES['plantillaadest']['name'];?>';document.getElementById('patharchivoest').value='<?php echo $_FILES['plantillaadest']['name'];?>';</script><?php 
					copy($_FILES['plantillaadest']['tmp_name'], $rutaad.$_FILES['plantillaadest']['name']);
					
				}
				if (is_uploaded_file($_FILES['plantillaadsec']['tmp_name'])) 
				{
					$rutaad="informacion/proyectos/temp/";
					$nomarchivo=$_FILES['plantillaadsec']['name'];
					?><script>document.getElementById('rutarchivosec').value='<?php echo $_FILES['plantillaadsec']['name'];?>';document.getElementById('patharchivosec').value='<?php echo $_FILES['plantillaadsec']['name'];?>';</script><?php 
					copy($_FILES['plantillaadsec']['tmp_name'], $rutaad.$_FILES['plantillaadsec']['name']);
					
				}
				if($_POST[oculgen]=="1")
				{
					//********almacenar adquisiciones*********
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$pestana=$_POST["pesactiva"];
					$solicitantesave="";
					$productosave="";
					$totalproductos="";
					$tvaloresuni="";
					if(!empty($_POST[fechat])){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechat],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					}else{
						$fechaf="";
					}
					
					if(!empty($_POST[fechatb])){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechatb],$fecha1);
						$fechaf1=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
					}else{
						$fechaf1="";
					}
					$valtotal=0;
					if(requiereBPIM($_POST[dtipogastos])==1){
						if(isset($_POST[finaliza7])){
							$valtotal=$_POST[cuentagas];
							for($x=0;$x<$_POST[banderin1];$x++)
							{
								if(!empty($_POST[dcuentas][$x])){
									$codplan=$codplan+1;	
								$sqlr="INSERT INTO contrasoladquisicionesgastos (codsolicitud,tipogasto,meta,rubro,fuente,valor,estado) VALUES ('$_POST[codigot]','".$_POST[dtipogastos][$x]."','".$_POST[dmetas][$x]."','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dgastos][$x]."','S') ";
								mysql_query($sqlr,$linkbd);
								//********almacenar CDP*********
								$sqlr="INSERT INTO contrasolicitudcdp_det (proceso,vigencia,rubro,fuente,meta,valor,estado) VALUES ('$_POST[codigot]','$vigusu','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dmetas][$x]."','".$_POST[dgastos][$x]."','S') ";
								mysql_query($sqlr,$linkbd);
								}
							}
						}
					}else{
						$valtotal=$_POST[cuentagas];
						for($x=0;$x<$_POST[banderin1];$x++)
						{
							if(!empty($_POST[dcuentas][$x])){
								$codplan=$codplan+1;	
							$sqlr="INSERT INTO contrasoladquisicionesgastos (codsolicitud,tipogasto,meta,rubro,fuente,valor,estado) VALUES ('$_POST[codigot]','".$_POST[dtipogastos][$x]."','".$_POST[dmetas][$x]."','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dgastos][$x]."','S') ";
							mysql_query($sqlr,$linkbd);
							//********almacenar CDP*********
							$sqlr="INSERT INTO contrasolicitudcdp_det (proceso,vigencia,rubro,fuente,meta,valor,estado) VALUES ('$_POST[codigot]','$vigusu','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dmetas][$x]."','".$_POST[dgastos][$x]."','S') ";
							mysql_query($sqlr,$linkbd);
							}
						}
					}
					
					
					

					for($x=0;$x<$_POST[banderin3];$x++)
					{
						if ($x==0){$solicitantesave=$_POST[sdocumento][$x];}
						else{$solicitantesave=$solicitantesave."-".$_POST[sdocumento][$x];} 
					}
					

					$sqlr="INSERT INTO contrasoladquisiciones (codsolicitud,fecha,objeto,codsolicitante,valortotal,codcdp,activo, estado,vigencia,codplan,coddestcompra) VALUES ('$_POST[codigot]','$fechaf','$_POST[nadquisicion]','$solicitantesave','$valtotal','',0,'S','$vigusu','','$_POST[destcompra]') ";
					if(mysql_query($sqlr,$linkbd)){
						
						if(isset($_POST[finaliza1])){
							
							$sql="INSERT INTO contrasolicitudpaa(codsolicitud,fecha,estado,vigencia,descripcion) VALUES ('$_POST[codigot]','$fechaf','A','$vigusu','$_POST[descripciont]')";
							mysql_query($sql,$linkbd);
						}else if(isset($_POST[finaliza2])){
							$sql="INSERT INTO contrasolicitudpaa(codsolicitud,fecha,estado,vigencia,descripcion) VALUES ('$_POST[codigot]','$fechaf','N','$vigusu','$_POST[descripciont]')";
							mysql_query($sql,$linkbd);
						}else{
							$sql="INSERT INTO contrasolicitudpaa(codsolicitud,fecha,estado,vigencia,descripcion) VALUES ('$_POST[codigot]','$fechaf','S','$vigusu','$_POST[descripciont]')";
							mysql_query($sql,$linkbd);
						}
					
					}else{
						echo"<script>despliegamodalm('visible','2','Error al almacenar la orden de compra');</script>";
					}
	
					$sqlr="INSERT INTO contrasolicitudcdp (proceso,vigencia,tipo,estado) VALUES ('$_POST[codigot]','$vigusu','C','S') ";
					mysql_query($sqlr,$linkbd);
					$sqlr="INSERT INTO contrasolicitudcdpppto (proceso,ndoc,tipodoc,vigencia,estado) VALUES ('$_POST[codigot]','','CDP', '$vigusu','S') ";
					mysql_query($sqlr,$linkbd);
					for($x=0;$x<count($_POST[nomarchivosest]); $x++){
						$sqlr="INSERT INTO contrasolicanexos (codsolicitud,tipo,ruta,descripcion,estado,vigencia) VALUES ('$_POST[codigot]','previo','".$_POST[rutarchivosest][$x]."','".$_POST[descripest][$x]."','S','$vigusu') ";
						mysql_query($sqlr,$linkbd);
					}
					for($x=0;$x<count($_POST[nomarchivossec]); $x++){
						$sqlr="INSERT INTO contrasolicanexos (codsolicitud,tipo,ruta,descripcion,estado,vigencia) VALUES ('$_POST[codigot]','sector','".$_POST[rutarchivossec][$x]."','".$_POST[descripsec][$x]."','S','$vigusu') ";
						mysql_query($sqlr,$linkbd);
					}
					if(isset($_POST[finaliza7])){
						$sql="INSERT INTO contrasolicitudproyecto (codsolicitud,vigencia,estado,fecha,descripcion) VALUES ('$_POST[codigot]','$vigusu','A','$fechaf1','$_POST[descripcionb]')";
						mysql_query($sql,$linkbd);
					}else if(isset($_POST[finaliza8])){
						$sql="INSERT INTO contrasolicitudproyecto (codsolicitud,vigencia,estado,fecha,descripcion) VALUES ('$_POST[codigot]','$vigusu','N','$fechaf1','$_POST[descripcionb]')";
						mysql_query($sql,$linkbd);
					}else{
						$sql="INSERT INTO contrasolicitudproyecto (codsolicitud,vigencia,estado,fecha,descripcion) VALUES ('$_POST[codigot]','$vigusu','S','$fechaf1','$_POST[descripcionb]')";
						mysql_query($sql,$linkbd);
					}
					
					
					if(isset($_POST[finaliza9])){
						$sql="UPDATE contrasolicitudproyecto SET tipo='proyecto' WHERE  codsolicitud='$_POST[codigot]'";
						mysql_query($sql,$linkbd);
					}else if(isset($_POST[finaliza9])){
						$sql="UPDATE contrasolicitudproyecto SET tipo='actividad' WHERE  codsolicitud='$_POST[codigot]'";
						mysql_query($sql,$linkbd);
					}
					$campsol="";
					$canunitario="";
					$valunitario="";
					$planes="";
					for ($x=0;$x<count($_POST[dproductos2]);$x++)
						{
							$campsol.=$_POST[dproductos2][$x]."-";
							$canunitario.=$_POST[dcantidad2][$x]."-";
							$valunitario.=$_POST[dvaluni2][$x]."-";
							$planes.=$_POST[dpaa][$x]."-";
						
						}
					$campsol=substr($campsol,0,-1);
					$valunitario=substr($valunitario,0,-1);
					$canunitario=substr($canunitario,0,-1);
					$planes=substr($planes,0,-1);
					//--INSERTANDO CODIGOS PAA SOLICITADOS
					$sql="UPDATE contrasolicitudpaa SET codigossol='$campsol',valoresunit='$valunitario',cantidadunit='$canunitario',valtotalsol='$sumtotal',codplan='$planes' WHERE codsolicitud='$_POST[codigot]' ";
					mysql_query($sql,$linkbd);
					
					/*
					if(!empty($_POST[codadquisicion]) && existePAA($_POST[codadquisicion])>0){
						$sql="UPDATE contrasolicitudpaa SET codplan='$_POST[codadquisicion]' WHERE codsolicitud='$_POST[codigot]' ";
						mysql_query($sql,$linkbd);
					}
					*/
					
					//--INSERTANDO METAS SOLICITADAS
					if($_POST[banderin4]>0){
						if(!empty($_POST[codproyecto]) && existeProyecto($_POST[codproyecto])){
							$sql="UPDATE contrasolicitudproyecto SET codproyecto='$_POST[codproyecto]' WHERE  codsolicitud='$_POST[codigot]'";
							mysql_query($sql,$linkbd);
						
						   $contmeta=0;
							for($x=0;$x<$_POST[contadorsol]; $x++){
							
							if(isset($_POST[aceptab][$x]) && !empty($_POST[aceptab][$x])){
								for ($y=0;$y<count($_POST[niveles]);$y++)
								 {
									
										$meta=$_POST["matmetas1$x"][$y];
										$codmeta=$_POST[codmetas][$y];
										$nommeta=$_POST["matmetasnom1$x"][$y];
										$sql="INSERT INTO contrasolicitudproyecto_det(codigosol,vigencia,cod_meta,cod_param,valor,nombre_valor) VALUES ('$_POST[codigot]','$vigusu',$contmeta,'$codmeta','$meta','$nommeta')";
										mysql_query($sql,$linkbd);
									
									
								 }
								 $contmeta++;
							  }
						}
					}
				}
						
					echo"<script>document.getElementById('oculgen').value='0'; parent.despliegamodalm('visible','1');</script>";
				
				} //***termina oculgen
			?> 
        </form>
        <div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
	</body>
</html>