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
        <title>:: Spid - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
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
		#sep {
			border-right:none;
			
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


		
		#t7{
			background-color: white !important;
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

        <script type="text/javascript" src="botones.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <script src="JQuery/jquery-2.1.4.min.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
       
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
		 var proyecto=document.getElementById("codigoproy").value;
		 if(tipo=='1'){
			 
			if(id=='finaliza1'){
				var entra=false;
				var tieneVacio=false;
				for(var i=0;i<productos.length;i++){
					var aprobado=document.getElementById("acepta["+i+"]").checked;
					if(aprobado==true && (cantidaduni.item(i).value=='' || valoruni.item(i).value=='') ){
						tieneVacio=true;
						break;
					}
				}
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
							if(proyecto==''){
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
					if (!(document.form2.codigotb.value!='' && document.form2.fechatb.value!='' && document.form2.descripcionb.value!='' && document.getElementById("vigencia").value!='' && contador>0))
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
						document.form2.agregadet8.value=1;
						document.form2.submit();
				}
				else {despliegamodalm('visible','2','Debe especificar la ruta del archivo');}
			}
			function agregarchivoest(){
				
				if(document.getElementById("rutarchivoest").value!=""){
						document.form2.agregadet6.value=1;
						document.form2.submit();
				}
				else {despliegamodalm('visible','2','Debe especificar la ruta del archivo');}
			}
			function cambiopestanas(ven){document.getElementById('pesactiva').value=ven;}
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
							document.getElementById('ventana2').src="contra-soladquisicionescuentasppto2.php?ti=2&ti2="+tipo;break;
						case "5":
							document.getElementById('ventana2').src="contra-soladquisicionesproyectos.php";break;
						case "6":
							document.getElementById('ventana2').src="contra-productos-ventana.php";break;
						case "7":
							document.getElementById('ventana2').src="contra-proyectos.php";break;

					}
				}
			}
		
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;
						
					}
				}
			}
			function funcionmensaje(){
				
				refrescar();
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
				//document.getElementById('bguardar').innerHTML='<img src="imagenes/guarda.png"  onClick=" guardar();"/>';
				//document.getElementById('impre').innerHTML='<img src="imagenes/print_off.png" alt="Imprimir" style="width:30px;" >';
				document.getElementById('bguardar').innerHTML='<img src="imagenes/guarda.png" onClick="guardar();"/>';
				//document.getElementById('impre').innerHTML='<img src="imagenes/print.png" title="Imprimir" onClick="venvercdp.pdf()" >';
			} 
			function cambiobotones2()
			{
				document.getElementById('bguardar').innerHTML='<img src="imagenes/guarda.png" onClick="guardar();"/>';
				//document.getElementById('impre').innerHTML='<img src="imagenes/print.png" title="Imprimir" onClick="venvercdp.pdf()" >';
			} 

			function cerrarventanas()
			{
				document.form2.action="contra-principal.php";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscadquisicion(e)
			{if (document.form2.codadquisicion.value!=""){document.form2.busadq.value='1'; document.form2.submit();}}
			function buscacta(e)
			{if (document.form2.cuenta.value!=""){document.form2.bc.value='1'; document.form2.submit();}}
			function buscarubro(e)
 			{if (document.form2.codrubro.value!=""){ document.form2.pesactiva.value=3;document.form2.bcrubro.value='1'; document.form2.submit();}}
			function buscater(e)
			{if (document.form2.tercero.value!=""){document.form2.bctercero.value='1'; document.form2.submit();}}
			function buscaproyectos(e)
			{if (document.form2.codigoproy.value!=""){document.form2.bcproyectos.value='1'; document.form2.submit();}}
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
			function eliminard(variable,textdoel)
			{
				document.form2.eliminar.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar "'+textdoel+'"','1');
			}
			function agregardetallesol()
			{
				var cantidad=document.getElementById('banderin3').value;
				if(cantidad==0){
					if(document.form2.ntercero.value!="" )
				{
					document.form2.agregadets.value=1;
					document.getElementById('banderin3').value=parseInt(document.getElementById('banderin3').value)+1;
					document.form2.pesactiva.value=1;
					document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
				}else{
					despliegamodalm('visible','2','Ya existe un Jefe de departamento');
				}
				
			}
			function eliminars(variable,textdel)
			{
				document.form2.eliminars.value=variable;
				var comtexto='Esta Seguro de Eliminar "'+textdel+'"';
				despliegamodalm('visible','4',comtexto,'2');
				
			}
			function validar()
			{
				document.form2.submit();
			}
			function agregardetalle2()
			{
				if(document.form2.codrubro.value!="" && parseFloat(document.form2.valor.value) >0 && document.form2.valor.value !="")
				{ 
				document.form2.agregadet2.value=1;
				document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)+1;
				document.getElementById("pesactiva").value=3;
				document.form2.submit();
 				}
 				else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}
			}
			function eliminar2(variable)
			{
				if (confirm("Esta Seguro de Eliminarss"))
			  	{
					document.form2.elimina.value=variable;
					document.getElementById('elimina').value=variable;
					document.getElementById('banderin1').value=parseInt(document.getElementById('banderin1').value)-1;
					document.form2.submit();
				}
			}
			function guardar()
			{
				document.form2.action="";
				document.form2.target="";
				var tiposcuentas=document.getElementsByName("dtipogastos[]");
				var proyecto=document.getElementById("codigoproy").value;
				var pestana=document.getElementById("pesactiva").value;
				var liberado=document.form2.finaliza.value;
				var esliberado=document.getElementById("esliberado").value;
				if(liberado=='on' && esliberado=='1'){
				despliegamodalm('visible','2','La orden de compra ya esta liberada');
				}else{
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
								despliegamodalm('visible','2','Excede el valor del Plan Anual de Adquisicion');	
							}
						}else if(pestana=='3' || pestana=='4'){
							var finaliza7=document.getElementById("finaliza7").value;
						
								if( (finaliza7=='' && proyecto=='') || parseInt(document.form2.banderin1.value)==0){
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
						}else if(pestana=='7' || pestana=='8'){
							var solicitud=document.getElementById("codigot").value;
							if(solicitud!=''){
								if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
							}else{
								despliegamodalm('visible','2','Faltan datos para completar el registro');
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
							
						}else if(pestana=='7' || pestana=='8'){
							var solicitud=document.getElementById("codigot").value;
							if(solicitud!=''){
								if (confirm("Esta Seguro de Guardar")){document.form2.oculgen.value="1";document.form2.submit();}
							}else{
								despliegamodalm('visible','2','Faltan datos para completar el registro');
							}
						}
						
				}
				}else{
					despliegamodalm('visible','2','No pueden existir cantidades o valores vacios');
				}
				}
				
					
			}
			 function pdfsolicitud()
			 {
				document.form2.action="pdfsolcdispre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			 }
			 function pdfsolicitudbanco(){
			 	document.form2.action="pdfbancoproyecto.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			 }
			  function pdfsolicitud2()
			 {
				document.form2.action="pdfsolcdispre.php?copi=1";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			 }
			 function generabppim(){
				document.form2.action="pdfcertificabanco.php";
				document.form2.target="_blank";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function generapaa(){
				document.form2.action="pdfcertificadopaa.php";
				document.form2.target="_blank";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function refrescar(){
				var ind="<?php echo $_GET[ind]; ?>";
				var codid="<?php echo $_GET[codid]; ?>";
				window.location.href="contra-soladquisicionesindexed.php?ind="+ind+"&codid="+codid;
			}
			function redireccion(){
				var nombre=document.form2.nomarchadj.value;
				window.location.href='informacion/proyectos/temp/'+nombre ;
			}
	
			
			function eliminardp(variable)
			{
				document.form2.eliminarpro.value=variable;
				despliegamodalm('visible','4','Esta seguro de eliminar el Producto de la lista','3');
			}
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
						document.form2.agregadet7.value=1;
						document.form2.oculto.value=1;
						document.form2.pesactiva.value=5;
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

			function agregarproductos(){   //UTILIZADO
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
		function obtenerCodigoMeta($solicitud,$meta){
			global $linkbd;
			$sql="SELECT cod_meta FROM contrasolicitudproyecto_det WHERE codigosol='$solicitud' AND valor='$meta'  ";
			$res=mysql_query($sql,$linkbd);
			$fila=mysql_fetch_row($res);
			return $fila[0];
		}
		function obtenerEstado($tabla,$solicitud){
			global $linkbd;
			$sql="SELECT estado FROM $tabla WHERE codsolicitud='$solicitud'  ";
			$res=mysql_query($sql,$linkbd);
			$fila=mysql_fetch_row($res);
			return $fila[0];
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
					<a id="bguardar" href="#" class="mgbt"><img src="imagenes/guarda.png"  onClick="guardar();"></a>
					<a href="contra-soladquisicionesbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="contra-soladquisicionesbuscar.php"  class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
					<a><img class="icorot" src="imagenes/reload.png" title="Refrescar" onClick="refrescar()"/></a>
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
			$sqlr="SELECT codproyecto FROM contrasoladquisicionesgastos WHERE codsolicitud='$_POST[codid]'";
			$res=mysql_query($sqlr,$linkbd);
			$rowc=mysql_fetch_row($res);
			$codigo=$rowc[0];
			$_POST[codigoproy]=$codigo;	
			$cmoff='imagenes/sema_rojoOFF.jpg';
			$cmrojo='imagenes/sema_rojoON.jpg';
			$cmamarillo='imagenes/sema_amarilloON.jpg';
			$cmverde='imagenes/sema_verdeON.jpg';
			
			$sqlr="SELECT codcdp,vigencia FROM contrasoladquisiciones WHERE codsolicitud='$_POST[codid]'";
			$res=mysql_query($sqlr,$linkbd);
			$row =mysql_fetch_row($res);
			if($row[0]=="")
			{
				$p2luzcem1=$cmrojo;$p2luzcem2=$cmoff;$p2luzcem3=$cmoff;
				$_POST[conven2]="contra-soladquisicionescdpver.php?codcdp=0&solicitud=$_POST[codid]";
				$actiblo="";
			}
			elseif($row[0]=="S")
			{

				$p2luzcem1=$cmoff;$p2luzcem2=$cmamarillo;$p2luzcem3=$cmoff;
				$_POST[conven2]="contra-soladquisicionescdpver.php?codcdp=0&solicitud=$_POST[codid]";
				$actiblo="";
			}
			else
			{
				$p2luzcem1=$cmoff;$p2luzcem2=$cmoff;$p2luzcem3=$cmverde;
				$_POST[conven2]="contra-soladquisicionescdpver.php?is=$row[0]&vig=$row[1]&solicitud=$_POST[codid]";
				$actiblo="readonly";
			}
			
			if(isset($_POST[finaliza2])){
				$p1luzcem1=$cmoff;$p1luzcem2=$cmoff;$p1luzcem3=$cmverde;
				$actiblo="";
			}
			//*********************
			if($_POST[busadq]=='1')
			{
				$nresul=buscadquisicion($_POST[codadquisicion]);
				if($nresul[1]!='')
				{
					$sql="SELECT contraplancompras.valortotalest FROM contraplancompras WHERE contraplancompras.codplan='$_POST[codadquisicion]'  ";
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
			//*** ESTADO DE SOLICITUD PAA
			$sql="SELECT estado FROM contrasolicitudpaa WHERE codsolicitud='$_POST[codid]' ";
				$res=mysql_query($sql,$linkbd);
				$fila=mysql_fetch_row($res);
				$num=mysql_num_rows($res);
				if($num>0){
					
					if($fila[0]=='N' || $fila[0]=='CE'){
					$p1luzcem1=$cmoff;$p1luzcem2=$cmoff;$p1luzcem3=$cmverde;
					if(strcmp($fila[0],'N')==0){
						$_POST[estadoc]='NO REQUIERE CERTIFICADO';
						$color=" style='font-weight: bold; background-color:#0CD02A ;color:#fff;text-align:center'"; 
					}else{
						$_POST[estadoc]='CERTIFICADO';
						$color=" style='font-weight: bold; background-color:#0CD02A ;color:#fff;text-align:center'";
					}
				}else if($fila[0]=='A' || $fila[0]=='CO' || $fila[0]=='CC'){
					$p1luzcem1=$cmoff;$p1luzcem2=$cmamarillo;$p1luzcem3=$cmoff;
					if(strcmp($fila[0],'A')==0){
						$_POST[estadoc]='SOLICITUD ENVIADA';
						$color=" style='font-weight: bold; background-color:#0CD02A ;color:#fff;text-align:center'"; 
					}else{
						$_POST[estadoc]='CORRECCION';
						$color=" style='font-weight: bold; background-color:#aa0000 ; color:#fff;text-align:center'"; 
					}
				}else{
					$p1luzcem1=$cmrojo;$p1luzcem2=$cmoff;$p1luzcem3=$cmoff;
				}
				}else{
					$p1luzcem1=$cmrojo;$p1luzcem2=$cmoff;$p1luzcem3=$cmoff;
					$_POST[estadoc]='ACTIVO';
					$color=" style='background-color:#0CD02A ;color:#fff'"; 
				}

			//*** ESTADO DE SOLICITUD BPIM
				$sql="SELECT estado FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]' ";
				$res=mysql_query($sql,$linkbd);
				$fila=mysql_fetch_row($res);
				$num=mysql_num_rows($res);
				if($num>0){
					if($fila[0]=='N' || $fila[0]=='CE'){
					if(strcmp($fila[0],'N')==0){
						$_POST[estadob]='NO REQUIERE CERTIFICADO';
						$colorbanco=" style='font-weight: bold; background-color:#0CD02A ;color:#fff;text-align:center'"; 
					}else{
						$_POST[estadob]='CERTIFICADO';
						$colorbanco=" style='font-weight: bold; background-color:#0CD02A ;color:#fff;text-align:center'";
					}
				}else if($fila[0]=='A' || $fila[0]=='CO' || $fila[0]=='CC'){
					if(strcmp($fila[0],'A')==0){
						$_POST[estadob]='SOLICITUD ENVIADA';
						$colorbanco=" style='font-weight: bold; background-color:#0CD02A ;color:#fff;text-align:center'"; 
					}else{
						$_POST[estadob]='CORRECCION';
						$colorbanco=" style='font-weight: bold; background-color:#aa0000 ; color:#fff;text-align:center'"; 
					}
				}
			}else{
					$p1luzcem1=$cmrojo;$p1luzcem2=$cmoff;$p1luzcem3=$cmoff;
					$_POST[estadob]='ACTIVO';
					$colorbanco=" style='background-color:#0CD02A ;color:#fff'"; 
				}

			$sql="SELECT estado,codigo FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]' ";
			$res=mysql_query($sql,$linkbd);
			$rowe=mysql_fetch_row($res);
			$nume=mysql_num_rows($res);
			if($nume>0){
				if($rowe[0]=='N' || $rowe[0]=='CE')
			{
				$p4luzcem1=$cmoff;$p4luzcem2=$cmoff;$p4luzcem3=$cmverde;
				$_POST[rutabanco]="contra-soladquisicionesbancover.php?codcdp=0";
	
			}else if($rowe[0]=='A' || $rowe[0]=='CO' || $rowe[0]=='CC'){
				$p4luzcem1=$cmoff;$p4luzcem2=$cmamarillo;$p4luzcem3=$cmoff;
				$_POST[rutabanco]="contra-soladquisicionesbancover.php?codcdp=".$rowe[1];
			}else{
				$p4luzcem1=$cmrojo;$p4luzcem2=$cmoff;$p4luzcem3=$cmoff;
			}
			}else{
				$p4luzcem1=$cmrojo;$p4luzcem2=$cmoff;$p4luzcem3=$cmoff;
			}
			
			//*****************************************************************
		   
			$sql="SELECT 1 FROM contrasolicitudpaa WHERE codsolicitud='$_POST[codid]' AND estado='CE' ";
			$res=mysql_query($sql,$linkbd);
			$num=mysql_num_rows($res);
			if($num>0){
				$_POST[finaliza1]="1";
			}
			$sql="SELECT 1 FROM contrasolicitudpaa WHERE codsolicitud='$_POST[codid]' AND estado='N' ";
			$res=mysql_query($sql,$linkbd);
			$num=mysql_num_rows($res);
			if($num>0){
				$_POST[finaliza2]="1";
			}
			
			$sql="SELECT 1 FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]' AND estado='A' ";
			$res=mysql_query($sql,$linkbd);
			$num=mysql_num_rows($res);
			if($num>0){
				$_POST[finaliza7]="1";
			}
			$sql="SELECT 1 FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]' AND estado='N' ";
			$res=mysql_query($sql,$linkbd);
			$num=mysql_num_rows($res);
			if($num>0){
				$_POST[finaliza8]="1";
			}
			$sql="SELECT tipo FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]' ";
			$res=mysql_query($sql,$linkbd);
			$row=mysql_fetch_row($res);
			if(!empty($row[0])){
				if($row[0]=='proyecto'){
				  $_POST[finaliza9]="1";
				}else if($row[0]=='actividad'){
				  $_POST[finaliza10]="1";
				}
			}
			$sql="SELECT liberado FROM contrasolicitudcdp WHERE proceso='$_POST[codid]' ";
			$res=mysql_query($sql,$linkbd);
			$fila=mysql_fetch_row($res);
			$num=mysql_num_rows($res);
			if($num>0){
				if($fila[0]=='1'){
					 $_POST[finaliza5]="1";
				}
			}
			//***PROYECTO
			$_POST[codid]=$_GET[codid];
			$sqlr="SELECT codproyecto FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]'";
			//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			$rowc=mysql_fetch_row($res);
			$codigo=$rowc[0];
			$_POST[codigoproy]=$codigo;
			$_POST[codigo]=$codigo;
			$_POST[conproyec]=$codigo;
			
			$sql="SELECT fecha,codsolicitud,val_actividad,apor_convenio,apor_municipio,codigo FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]' AND codproyecto='$codigo' ";
			//echo $sql;
			$res=mysql_query($sql,$linkbd);
			$fila=mysql_fetch_row($res);
			if(!empty($fila[0])){
				$_POST[fecha]=$fila[0];
				$_POST[solproyec]=$fila[5];
				$_POST[valacti]=$fila[2];
				$_POST[aporconv]=$fila[3];
				$_POST[apormuni]=$fila[4];
			}			
			if($_POST[oculgen]=="")
			{
				$_POST[contadorsol]=0;
				$_POST[banderin5]=0;
				$_POST[banderin4]=0;
				
				$_POST[actiblo]=$actiblo;
				
				$_POST[pesactiva]="1";
				if($_POST[codid]!=0)
				{
					$_POST[oculgen]="0";
					
					$_POST[codigot]=$_POST[codid];
					$linkbd=conectar_bd();
					unset($_POST[nomarchivos]);
					unset($_POST[rutarchivos]);
					unset($_POST[tamarchivos]);
					unset($_POST[patharchivos]);
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$_POST[vigencia]=$vigusu;
					$sqlr="SELECT codproyecto FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]'";
					//echo $sqlr;
					$res=mysql_query($sqlr,$linkbd);
					$rowc=mysql_fetch_row($res);
					$codigo=$rowc[0];
					$_POST[codigoproy]=$codigo;
					$_POST[codigo]=$codigo;
					$_POST[conproyec]=$codigo;
					//-----****
					$i=0;
					$sqlr="SELECT * FROM contrasolicanexos WHERE codsolicitud='$_POST[codid]' AND vigencia='$vigusu' AND tipo='previo' ";
					$res=mysql_query($sqlr,$linkbd);
					while($row = mysql_fetch_row($res)){
						$_POST[nomarchivosest][]="Adjunto No. $i";
						$_POST[rutarchivosest][]=$row[2];
						$_POST[descripest][]=$row[3];
						$i++;
					}
					//-----****
					$i=0;
					$sqlr="SELECT * FROM contrasolicanexos WHERE codsolicitud='$_POST[codid]' AND vigencia='$vigusu' AND tipo='sector' ";
					$res=mysql_query($sqlr,$linkbd);
					while($row = mysql_fetch_row($res)){
						$_POST[nomarchivossec][]="Adjunto No. $i";
						$_POST[rutarchivossec][]=$row[2];
						$_POST[descripsec][]=$row[3];
						$i++;
					}
					//-----****
					$sql="SELECT fecha,codsolicitud,val_actividad,apor_convenio,apor_municipio,codigo FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]' AND codproyecto='$codigo' ";
					//echo $sql;
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
					if(!empty($fila[0])){
						$_POST[fecha]=$fila[0];
						$_POST[solproyec]=$fila[5];
						$_POST[valacti]=$fila[2];
						$_POST[aporconv]=$fila[3];
						$_POST[apormuni]=$fila[4];
					}
					
					$nresul=buscaproyectos($codigo);
					if($nresul[0]!=''){
					$_POST[letrasp]=convertir((int)$nresul[3])." PESOS";
					$_POST[nproyecto]=$nresul[0];$_POST[conproyec]=$nresul[1];$_POST[nomarchadj]=basename($nresul[2]);$_POST[valorproyecto]=$nresul[3];$_POST[descripcion]=$nresul[4]; 
					$_POST[nombre]=$nresul[0];
					$sql="SELECT * FROM planproyectos_adj WHERE codigo='$codigo' ";
					//echo $sql;
					$result=mysql_query($sql,$linkbd);
					while($row = mysql_fetch_row($result)){
						$_POST[nomarchivos][]=$row[2];
						$_POST[rutarchivos][]=basename($row[4]);
						$_POST[tamarchivos][]=filesize($row[4]);
						$_POST[patharchivos][]=basename($row[4]);
					}
					//-----
					$sql="SELECT metascert FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codid]' ";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
					$concameta="";
					if(!empty($row[0])){
						$arreglobanco=explode("-",$row[0]);
						$_POST[contador]=count($arreglobanco);
						for($i=0;$i<count($arreglobanco); $i++){
							$concameta.=(obtenerCodigoMeta($_POST[codid],$arreglobanco[$i]).",");
						}
					}else{
						$arreglobanco="";
						$_POST[contador]=0;
					}
					$concameta=substr($concameta,0,-1);
					$cond="";
					 if(!empty($concameta)){
						$cond ="AND cod_meta IN ($concameta)";
					 }
					$sql="SELECT valor,nombre_valor,cod_meta FROM contrasolicitudproyecto_det WHERE  codigosol='$_POST[codid]' $cond  ORDER BY LENGTH(valor),cod_meta ASC";
					$result=mysql_query($sql,$linkbd);
					$cont=0;
					while($row = mysql_fetch_row($result)){
						$j=$row[2];
						$_POST["matmetas$j"][]=$row[0];
						$_POST["matmetasnom$j"][]=$row[1];
						$cont++;
					}
				}
				
					$sql="SELECT codigo,codproyecto,vigencia,fecha,descripcion,observaciones FROM contrasolicitudproyecto where codsolicitud='$_POST[codid]'";
					$res=mysql_query($sql,$linkbd);
					while($row=mysql_fetch_row($res)){
						$_POST[codigotb]=$row[0];
						$_POST[vigencia]=$row[2];
						$_POST[fechatb]=$row[3];
						$_POST[descripcionb]=$row[4];
						$_POST[observaban]=$row[5];
						$_POST[codproyecto]=$row[1];
					}
					if(!empty($_POST[codproyecto])){
						$sql="SELECT nombre FROM planproyectos WHERE codigo='$_POST[codproyecto]' ";
						$res=mysql_query($sql,$linkbd);
						$row=mysql_fetch_row($res);
						$_POST[nproyecto]=$row[0];
					}
					
					$sql="SELECT observaciones,codplan FROM contrasolicitudpaa WHERE codsolicitud='$_POST[codid]'";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[observa]=$row[0];
					//$_POST[codadquisicion]=$row[1];
					$nresul=buscadquisicion($_POST[codadquisicion]);
					
					if($nresul[1]!='')
					{
						$_POST[nadquisicion]=$nresul[1];
						$sql="SELECT contraplancompras.valortotalest FROM contraplancompras WHERE contraplancompras.codplan='$_POST[codadquisicion]'  ";
						$res=mysql_query($sql,$linkbd);
						$fila=mysql_fetch_row($res);
						$totalplan=$fila[0];
						$sql="SELECT SUM(valtotalcerti) FROM contrasolicitudpaa WHERE codplan='$_POST[codadquisicion]' AND estado='CE' ";
						$res=mysql_query($sql,$linkbd);
						$fila=mysql_fetch_row($res);
						$totalcer=$fila[0];
						$_POST[saldopaa1]=$totalplan-$totalcer;
					}
					$sql="SELECT descripcion FROM contrasolicitudpaa WHERE contrasolicitudpaa.codsolicitud='$_POST[codid]'";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[descripciont]=$row[0];
					
	
					$sql="SELECT contrasolicitudpaa.descripcion,contrasolicitudpaa.observaciones,contrasolicitudpaa.codigosaprob,contrasolicitudpaa.codplan FROM contrasolicitudpaa where contrasolicitudpaa.codsolicitud='$_POST[codid]' ";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
					
					$codunspsc=explode("-",$row[2]);
					foreach ($codunspsc as &$valor)
					{
						if(!empty($valor)){
							$sqlr2="SELECT nombre FROM productospaa WHERE codigo='$valor'";
							$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
							$_POST[dproductos][]=$valor;
							$_POST[dnproductos][]=$row2[0]; 
							$nt=buscaproductotipo($valor);
							$_POST[dtipos][]=buscadominiov2("UNSPSC",$nt);
						}
						
					}
					//--
					unset($valor);
					$sql="SELECT codigossol,valoresunit,cantidadunit,codplan from contrasolicitudpaa WHERE codsolicitud='$_POST[codid]'";
					$res=mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					$conta=0;
					if(!empty($row[0])){
						$codunspsc1=explode("-",$row[0]);
						$valunspsc1=explode("-",$row[1]);
						$cantunspsc1=explode("-",$row[2]);
						$planunspsc1=explode("-",$row[3]);
						foreach ($codunspsc1 as &$valor)
						{
							if(!empty($valor)){
								$sqlr2="SELECT nombre FROM productospaa WHERE codigo='$valor'";
								$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
								$_POST[dproductos2][]=$valor;
								$_POST[dnproductos2][]=$row2[0]; 
								$nt=buscaproductotipo($valor);
								$_POST[dtipos2][]=buscadominiov2("UNSPSC",$nt);
								$_POST[dcantidadv2][]=$cantunspsc1[$conta];
								$_POST[dcantidad2][]=$cantunspsc1[$conta];
								$_POST[dvaluni2][]=$valunspsc1[$conta];
								$_POST[dvaluniv2][]=$valunspsc1[$conta];
								$_POST[dpaa][]=$planunspsc1[$conta];
								if(in_array($valor,$_POST[dproductos])){
									$_POST[dcantidadv][]=$cantunspsc1[$conta];
									$_POST[dcantidad][]=$cantunspsc1[$conta];
									$_POST[dvaluni][]=$valunspsc1[$conta];
									$_POST[dvaluniv][]=$valunspsc1[$conta];
								}
								$conta++;
							}
							
						}
					}
					
					$sqlr="SELECT * FROM contrasoladquisiciones WHERE codsolicitud='$_POST[codid]'";
					//echo $sqlr;
					$res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res);
					$_POST[codadqant]=$row[12];
					$_POST[finaliza]=$row[7];
					$_POST[esliberado]=$row[7];
					$_POST[fechat]=$row[1];
					$_POST[destcompra]=$row[13];
					$codsolicita=explode("-",$row[3]);
					foreach ($codsolicita as &$valor)
					{	
						$nresul=buscatercerod($valor);		 
						$_POST[sdocumento][]=$valor;
						$_POST[snombre][]=$nresul[0]; 
						$_POST[sidependencia][]=$nresul[2];
						$_POST[sndependencia][]=$nresul[1];
					}
					unset($valor);
					$_POST[banderin3]=count($_POST[snombre]);
					
					//unset($valor);
					$canpro=explode("-",$row[10]);
					foreach ($canpro as &$valor)
					{
						$_POST[dcantidad][]=$valor;
						$_POST[dcantidadv][]=$valor;
					}
					unset($valor);
					$cvaluni=explode("-",$row[11]);
					foreach ($cvaluni as &$valor)
					{
						$_POST[dvaluni][]=$valor;
						$_POST[dvaluniv][]=$valor;
					}
					unset($valor);
					$_POST[banderin2]=count($_POST[dnproductos]);
					$sqlr3="SELECT * FROM contrasoladquisicionesgastos WHERE codsolicitud='$_POST[codid]'";
					$res3=mysql_query($sqlr3,$linkbd);
					$contador1=0;
					while ($row3 =mysql_fetch_row($res3))
					{
						$contador1=$contador1+1;
						$_POST[dcuentas][]=$row3[3];
						$tipo=substr($row3[3],0,1);		
						$nresul=buscacuentapres($row3[3],$tipo); 
						$_POST[dncuentas][]=$nresul;
						$ind=substr($row3[3],0,1);
						if ($ind==2)
						{
							$sqlr4="select nombre from pptofutfuentefunc where codigo='$row3[4]'";
							$res4=mysql_query($sqlr4,$linkbd);
							$row4 =mysql_fetch_row($res4);
						}
						else
						{
							$sqlr4="select nombre from pptofutfuenteinv where codigo='$row3[4]'";
							$res4=mysql_query($sqlr4,$linkbd);
							$row4 =mysql_fetch_row($res4);
						}
						$_POST[dtipogastos][]=$row3[1];
						$_POST[dfuentes][]=$row4[0];
						$_POST[dcfuentes][]=$row3[4];
						$_POST[dgastos][]=$row3[5];
						$sqlr5="select nombre from presuplandesarrollo where codigo='$row3[2]'";
						$res5=mysql_query($sqlr5,$linkbd);
						$row5 =mysql_fetch_row($res5);
						$_POST[dmetas][]=$row3[2];
						$_POST[dnmetas][]=$row5[0];
						$_POST[dconproyec][]=$row3[7];
						$sqlr6="select codigo, nombre from planproyectos where consecutivo='$row3[7]'";
						$res6=mysql_query($sqlr6,$linkbd);
						$row6 =mysql_fetch_row($res6);
						$_POST[dcodproyec][]=$row6[0];		 
						$_POST[dnomproyec][]=$row6[1];	 
					} 
					$_POST[banderin1]=$contador1;
				}
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$_POST[ovigencia]= $vigusu;
				$_POST[oculgen]="5";
	
				$sql="SELECT MAX(cod_meta) FROM contrasolicitudproyecto_det WHERE codigosol='$_POST[codid]'";
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
				$sql="SELECT valor,nombre_valor,cod_meta FROM contrasolicitudproyecto_det WHERE  codigosol='$_POST[codid]'  ORDER BY LENGTH(valor),cod_meta ASC";
				$result=mysql_query($sql,$linkbd);
				$contab=0;
				while($row = mysql_fetch_row($result)){
					$n=$row[2];
					$_POST[aceptab][$contab]="1";
					$_POST["matmetas1$n"][]=$row[0];
					$_POST["matmetasnom1$n"][]=$row[1];
					$contab++;
				}
							
					
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
		 
			//*****************************************************************
			
			//*****************************************************************
			if($_POST[bcproyectos]=='1')
			{
				$nresul=buscaproyectos($_POST[codigoproy],$_POST[ovigencia]);
				if($nresul[0]!=''){$_POST[nproyecto]=$nresul[0];$_POST[conproyec]=$nresul[1];}
				else
				{
					echo"<script>despliegamodalm('visible','2','Codigo de Poyecto $_POST[codigoproy] No es Correcto');document.form2.cuenta.focus();</script>";
					$_POST[nproyecto]="";
				}
			}
			//*****************************************************************
	
			//*****************************************************************
			if ($_POST[oculto]=='1')
			{ 
				$posi=$_POST[eliminar];
				unset($_POST[dproductos][$posi]);
				unset($_POST[dnproductos][$posi]);
				unset($_POST[dtipos][$posi]);
				$_POST[dproductos]= array_values($_POST[dproductos]); 
				$_POST[dnproductos]= array_values($_POST[dnproductos]); 
				$_POST[dtipos]= array_values($_POST[dtipos]);
				echo"<script>document.form2.oculto.value='0'</script>";
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
					echo"<script>document.form2.tercero.value='';document.form2.ntercero.value='';document.form2.iddependencia.value=''; document.form2.dependencia.value='';</script>";
				}
				else {echo"<script>despliegamodalm('visible','2','Ya se ingreso Solicitante con el Documento $_POST[tercero]');</script>";}
			}
					
			//*****************************************************************
			if ($_POST[oculto]=='2')
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
				echo"<script>document.form2.oculto.value='0'</script>";
			}
			//*****************************************************************
			if($_POST[bcrubro]=='1')
			{
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$_POST[ovigencia]= $vigusu;
				$tipo=substr($_POST[codrubro],0,1);		
				$nresul=buscacuentapres($_POST[codrubro],$tipo); 	
				if($nresul!='')
				{
					$_POST[nrubro]=$nresul;
					$sqlr="select * from pptocuentaspptoinicial where cuenta='$_POST[codrubro]' and (vigencia='$vigusu' or   vigenciaf='$vigusu')";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[valor]=0;
					$_POST[valorv]=0;		  
					$_POST[saldo]=generaSaldo($_POST[codrubro],$vigusu,$vigusu);	
					$_POST[saldov]=$_POST[saldo];
					$ind=substr($_POST[codrubro],0,1);			
					if($ind=='R' || $ind=='r')
					{						
						$ind=substr($_POST[codrubro],1,1);	
						$criterio="and (pptocuentas.vigencia='$vigusu' or  pptocuentas.vigenciaf='$vigusu') AND (pptocuentas.vigencia='$vigusu' or  pptocuentas.vigenciaf='$vigusu')";					  
					}
					else
					{
						$criterio=" and pptocuentas.vigencia='$vigusu' AND  pptocuentas.vigencia='$vigusu'";
					}
					if ($ind=='2')
					{
						$sqlr="select pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre, pptocuentas.clasificacion from pptocuentas,pptofutfuentefunc where pptocuentas.cuenta='$_POST[codrubro]' and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo $criterio";
						
					}
					if ($ind=='3' || $ind=='4')
					{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre,pptocuentas.clasificacion from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[codrubro]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv $criterio";
						
					}
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					if($row[1]!='' || $row[1]!=0)
					{
						$_POST[tipocuenta]=$row[3];
						$_POST[cfuente]=$row[0];
						$_POST[fuente]=$row[2];
						$_POST[valor]=0;	
						$_POST[valorv]=0;		  
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
				   $_POST[valorv]="";
				   $_POST[saldo]="";
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
				unset($_POST[dmetas][$posi]);	
				unset($_POST[dnmetas][$posi]);	
				unset($_POST[dconproyec][$posi]);	
				unset($_POST[dcodproyec][$posi]);
				unset($_POST[dnomproyec][$posi]);			 
				$_POST[dcuentas]= array_values($_POST[dcuentas]); 
				$_POST[dtipogastos]= array_values($_POST[dtipogastos]);
				$_POST[dncuentas]= array_values($_POST[dncuentas]); 
				$_POST[dgastos]= array_values($_POST[dgastos]); 
				$_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
				$_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
				$_POST[dmetas]= array_values($_POST[dmetas]); 	
				$_POST[dnmetas]= array_values($_POST[dnmetas]); 
				$_POST[dconproyec]= array_values($_POST[dconproyec]); 	
				$_POST[dcodproyec]= array_values($_POST[dcodproyec]); 
				$_POST[dnomproyec]= array_values($_POST[dnomproyec]);			 		 	 	
				$_POST[elimina]='';	 		 		 		 
			}	 
			//*****************************************************************
			if($_POST[buscameta]=='1'){
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
			}
			//*****************************************************************
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
					//$_POST[valor]=str_replace(".","",$_POST[valor]);
					$_POST[dgastos][]=$_POST[valor];
					$_POST[dmetas][]=$_POST[meta];		 
					$_POST[dnmetas][]=$_POST[nmeta];
					$_POST[dconproyec][]=$_POST[conproyec];
					$_POST[dcodproyec][]=$_POST[codigoproy];		 
					$_POST[dnomproyec][]=$_POST[nproyecto];		 		 
					$_POST[agregadet2]=0;
					echo"<script>	
					document.form2.codrubro.value='';
					document.form2.nrubro.value='';
					document.form2.fuente.value='';
					document.form2.cfuente.value='';
					document.form2.valor.value='';
					document.form2.conproyec.value='';	
					document.form2.codigoproy.value='';	
					document.form2.nproyecto.value='';
					if (document.form2.tipocuenta.value=='inversion')
					{
						document.form2.eje.value='';
						document.form2.sector.value='';
						document.form2.programa.value='';
						document.form2.subprograma.value='';
						document.form2.meta.value='';	
						document.form2.nmeta.value='';		
					}
					document.form2.codrubro.focus();	
					</script>";
				}
				else{echo"<script>despliegamodalm('visible','2','Ya se Ingreso el Rubro $_POST[codrubro] en el CDP');</script>";}
			}
			$_POST[finfasblo]="disabled";
			if(isset($_POST[finaliza5])){
		
				if(requiereBPIM($_POST[dtipogastos])==1){
					if($p1luzcem3=='imagenes/sema_verdeON.jpg' && $p2luzcem3=='imagenes/sema_verdeON.jpg' && $p4luzcem3=='imagenes/sema_verdeON.jpg'){$_POST[finfasblo]="";}
				}else{
					if($p1luzcem3=='imagenes/sema_verdeON.jpg' && $p2luzcem3=='imagenes/sema_verdeON.jpg' ){ $_POST[finfasblo]="";}
				}	
			}
			
			
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
			//*****************************************************************
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
			$sql="SELECT 1 FROM contrasolicitudproyecto,contrasolicitudproyecto_det where contrasolicitudproyecto.codproyecto='$proyecto' AND  contrasolicitudproyecto_det.valor='$meta' AND contrasolicitudproyecto.codsolicitud=contrasolicitudproyecto_det.codigosol AND contrasolicitudproyecto.estado NOT IN ('CO')";
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
                            <td class="saludo1" style="width:7%">Liberar:</td>
                            <td>
								<div class="c1"><input type="checkbox" id="finaliza" name="finaliza" <?php if($_POST['finaliza']!='0' && !empty($_POST['finaliza'])){echo "checked disabled";} ?> <?php echo $_POST[finfasblo];?> /><label for="finaliza" id="t1" ></label></div>								
                            </td>  
                        </tr>
                        <tr>
                             <td class="saludo1" style="width:12%;">Objeto:</td>
                            <td colspan="10" valign="middle" style="width:15%;">
                                <input type="text" id="descripciont" name="descripciont"  value="<?php echo $_POST[descripciont]?>" style="width:89.8%">
							</td>
                            
                            
                            
                        </tr>   
                        <tr>
                            <td  class="saludo1">Jefe de departamento:</td>
                            <td>
                                <input id="tercero" name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" <?php if($_POST[actiblo]=="readonly"){echo "disabled";}?>>
                                <?php if($_POST[actiblo]=="readonly"){echo "";} ?>
								<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;" border="0"></a>
                            </td>
                            <td colspan="2" style="width:20%;">
                                <input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>"  onKeyUp="return tabular(event,this)" style="width:100%;" readonly >
                            </td>
                            <td><center><input type="button" name="agregas" value="  Agregar  " onClick="agregardetallesol()" ></center></td>
                            <td colspan="3">
								<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">Solicitar certificado</label></div>
								<?php
									$sql="SELECT COUNT(*),estado FROM contrasolicitudpaa WHERE codsolicitud=$_POST[codigot] ";
									$res=mysql_query($sql,$linkbd);
									$row = mysql_fetch_row($res);
									if($row[0]==0){


								?>
								<div class="c2" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza1" name="finaliza1" <?php if(isset($_POST['finaliza1'])){echo "checked";} ?> value="<?php echo $_POST[finaliza1]?>"   onChange="validafinalizar(this,'1')"/><label for="finaliza1" id="t2" ></label></div>
								<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
								<div class="c3" style="display:inline-block; "><input type="checkbox" id="finaliza2" name="finaliza2" <?php if(isset($_POST['finaliza2'])){echo "checked";} ?> value="<?php echo $_POST[finaliza2]?>" onChange="validafinalizar(this,'1')" /><label for="finaliza2" id="t3" ></label></div>
								<?php
									}
									else{
										if($row[1]!='CO' && $row[1]!='CC' && $row[1]!='S'){
								?>
								<div class="c2" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza1" name="finaliza1" <?php if(isset($_POST['finaliza1'])){echo "checked";} ?> value="<?php echo $_POST[finaliza1]?>"   onChange="validafinalizar(this,'1')" disabled/><label for="finaliza1" id="t2" ></label></div>
								<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
								<div class="c3" style="display:inline-block; "><input type="checkbox" id="finaliza2" name="finaliza2" <?php if(isset($_POST['finaliza2'])){echo "checked";} ?> value="<?php echo $_POST[finaliza2]?>" onChange="validafinalizar(this,'1')" disabled/><label for="finaliza2" id="t3" ></label></div>
								<?php
							}else if($row[1]=='CO' || $row[1]=='CC'){
						
								?>
								<div class="c2" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza1" name="finaliza1" <?php if(isset($_POST['finaliza1']) || $row[1]=='CC'){echo "checked";} ?> value="<?php echo $_POST[finaliza1]?>"   onChange="validafinalizar(this,'1')" /><label for="finaliza1" id="t2" ></label></div>
								<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
								<div class="c3" style="display:inline-block; "><input type="checkbox" id="finaliza2" name="finaliza2" <?php if(isset($_POST['finaliza2'])){echo "checked";} ?> value="<?php echo $_POST[finaliza2]?>" onChange="validafinalizar(this,'1')" disabled/><label for="finaliza2" id="t3" ></label></div>
								<?php
								}else{
									
								
								?>
								<div class="c2" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza1" name="finaliza1" <?php if(isset($_POST['finaliza1']) || $row[1]=='CC'){echo "checked";} ?> value="<?php echo $_POST[finaliza1]?>"   onChange="validafinalizar(this,'1')" /><label for="finaliza1" id="t2" ></label></div>
								<div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">No Requiere Certificado</label></div>
								<div class="c3" style="display:inline-block; "><input type="checkbox" id="finaliza2" name="finaliza2" <?php if(isset($_POST['finaliza2'])){echo "checked";} ?> value="<?php echo $_POST[finaliza2]?>" onChange="validafinalizar(this,'1')" /><input type="hidden" name="docu" id="docu" value="<?php echo $_POST[sdocumento]?>"><label for="finaliza2" id="t3" ></label></div>
								
								<?php
								
									
								}
							}
								?>
								 <div style="display:inline-block"><input type="button" name="pdfsol1" id="pdfsol1" value="PDF Solicitud" <?php if (!empty($_POST[descripciont]) && count($_POST[sdocumento])>0 ){echo "onClick='venvercdp.pdf()' "; }?> ></div>   
								<input type="hidden" name="dependencia" id="dependencia" value="<?php echo $_POST[dependencia]?>">
                                <input type="hidden" name="iddependencia" id="iddependencia" value="<?php echo $_POST[iddependencia]?>">
                            </td>
                        </tr>
                    </table>
                    <div class="subpantalla" style="height:12%; width:99.5%; margin-top:0px; overflow:hidden">
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
                                                <td><input class='inpnovisibles' name='sndependencia[]' value='".$_POST[sndependencia][$x]."' type='text' readonly style='width:100%'><input name='sidependencia[]' value='".$_POST[sidependencia][$x]."' type='hidden'></td>";		
                                        echo "<td align=\"middle\"><a href='#' onclick=\"eliminars($x,'".$_POST[snombre][$x]."')\"><img src='imagenes/del.png'></a></td></tr>";	
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
						  onKeyUp="return tabular(event,this)" onBlur="buscadquisicion()" value="<?php echo $_POST[codadquisicion]?>" onClick="document.getElementById('codadquisicion').focus();document.getElementById('codadquisicion').select();" style="width:85%"  >
									<a href="#" onClick="despliegamodal2('visible','1');"  ><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" class="icobut"></a></td>
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
					    <div class="subpantalla" style="height:29%; width:99.5%; overflow:hidden">
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
						//if(obtenerEstado("contrasolicitudpaa",$_POST[codid])=="A" || obtenerEstado("contrasolicitudpaa",$_POST[codid])=="CE"){
						//	for($x=0;$x<count($_POST[dproductos1]); $x++){
						//		$_POST[acepta][$x]="1";
						//	}
						//}
								
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
								//if(obtenerEstado("contrasolicitudpaa",$_POST[codid])=="A" || obtenerEstado("contrasolicitudpaa",$_POST[codid])=="CE"){$dis="DISABLED"; $disabled="READONLY"; }else{$dis="";}
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
				<div class="col2" style=" width:19.5%;display:inline-block;background-color:white;">
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
<div class="subpantalla" style="height:30%; width:99.5%; overflow-x:hidden">
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
							<input  type='hidden' name='dpaa[]' value='".$_POST[dpaa][$x]."'  >
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" >
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
  				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> onClick="cambiobotones1(); cambiopestanas('2');" >
	   			<label for="tab-2"><img src="<?php echo $p1luzcem1;?>" width="16" height="16"><img src="<?php echo $p1luzcem2;?>" width="16" height="16"><img src="<?php echo $p1luzcem3;?>" width="16" height="16">Productos Adquisici&oacute;n</label> 
                <div class="content" style="overflow:hidden">
                    <table class="inicio">
                        <tr>
                            <td colspan="3" class="titulos">Productos Adquisici&oacute;n</td>
                        </tr>
                        <tr>
                            <td >
                                <div class="informa" style="font-family: 'Oswald', sans-serif !important;font-size: 17px;padding-left: 4%">--- Informacion acerca de los productos certificados ---</div>
                            </td>
                            <td style="width:10%" >
                                <input type="button" name="agregar6" id="agregar6" value="   PDF Certificado PAA  " <?php if($_POST[estadoc]=="CERTIFICADO"){echo " onClick='generapaa()' " ; } ?> />
                            </td>
                            <td style="width:8%" >
                                <input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" <?php echo $color; ?> readonly>
                            </td>
                        </tr> 
                    </table>
                    <div class="subpantalla" style="height:55%; width:99.5%; margin-top:0px; overflow-x:hidden">
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
								$sumcant=0;
								$sumtotalc=0;
                                for ($x=0;$x<count($_POST[dproductos]);$x++)
                                {		 
                                    echo "
										<script>
											jQuery(function($){ $('#dvaluniv$x').autoNumeric('init');});
											jQuery(function($){ $('#dcantidadv$x').autoNumeric('init',{mDec:'0'});});
										</script>
                                        <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
                                            <td><input class='inpnovisibles' name='dproductos[]' value='".$_POST[dproductos][$x]."' type='text' readonly></td>
                                            <td><input class='inpnovisibles' name='dnproductos[]'  value='".$_POST[dnproductos][$x]."' type='text' style=\"width:100%\" readonly></td>
											<td>
												<input type='hidden' name='dcantidad[]' id='dcantidad$x' value='".$_POST[dcantidad][$x]."'/>
												<input type='text' name='dcantidadv[]' id='dcantidadv$x' value='".$_POST[dcantidadv][$x]."' style='width:100%;text-align:right;' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dcantidad$x','dcantidadv$x');\" readonly  />
											</td>
											<td>
												<input type='hidden' name='dvaluni[]' id='dvaluni$x' value='".$_POST[dvaluni][$x]."'/>
												<input type='text' name='dvaluniv[]' id='dvaluniv$x' value='".$_POST[dvaluniv][$x]."' style='width:100%;text-align:right;' data-a-sign='$' data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp=\"sinpuntitos('dvaluni$x','dvaluniv$x');\" readonly />												
											</td>
                                            <td><input class='inpnovisibles' name='dtipos[]' value='".$_POST[dtipos][$x]."' type='text'  readonly></td>";		
                                    $aux=$iter;
                                    $iter=$iter2;
                                    $iter2=$aux;
									$sumcant+=$_POST[dcantidad][$x];
									$sumtotalc+=$_POST[dvaluni][$x];
                                }	
                            ?>
                        </table>
                    </div>
				<div class="subpantalla" style="height:5%; width:99.5%; margin-top:0px; overflow:hidden">
                        <table class="inicio" style="width:99%">
                            <tr>
                                <td class="titulos2" colspan="2">Total</td>
                                <td class="titulos2" style="width:10%; text-align:right"><?php echo $sumcant; ?></td>
                                <td class="titulos2" style="width:15%; text-align:right">$ <?php echo number_format($sumtotalc,2,'.',','); ?></td>
                                <td class="titulos2" style="width:20%"></td>
                            </tr>
                        </table>
                    </div>					
					  <table class="inicio">
                        <tr>
                            <td class="titulos" colspan="3">Observaciones</td>
                        </tr>
                        <tr>
                            <td class="saludo1" style="width:70%;">
							<input type="text" name="observa" id="observa" value="<?php echo $_POST[observa]; ?>" style="width: 100%; height: 100px;font-weight:bold;font-size: 12px;text-transform:uppercase" readonly/>
							</td>
							
							<td class="sep"   style="width:10%;">
							<div>
							<center><h1>Anexos</h1></center>
							</div>
							</td>
							
							<td class="saludo1" style="width:20%;">
							<div style="height:100px;padding-left:2%;width:400px;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">
							
							
								
							</div>
							
							</td>
							
							
							
                            
                        </tr> 
                    </table>
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
                                <td style="width:16%" colspan="5"> 
                                    <select name="tipocuenta" id="tipocuenta" onKeyUp="return tabular(event,this)" onChange="cambiatipo(this)" style="width:100%" >
                                        <option value="funcionamiento" <?php if($_POST[tipocuenta]=='funcionamiento') echo "SELECTED"; ?>>Funcionamiento</option>
                                        <option value="deuda" <?php if($_POST[tipocuenta]=='deuda') echo "SELECTED"; ?>>Deuda</option>
                                        <option value="inversion" <?php if($_POST[tipocuenta]=='inversion') echo "SELECTED"; ?>>Inversion</option>
                                    </select>
                                </td>
								
								</tr>
                            <tr>  
                                <td  class="saludo1">Rubro:</td>
                                <td>
									<input type="hidden" name="cuenfuen" id="cuenfuen" value="<?php echo $_POST[cuenfuen]?>"   />
                                    <input type="text" id="codrubro" name="codrubro" onKeyUp="return tabular(event,this)" onBlur="buscarubro(event)" value="<?php echo $_POST[codrubro]?>" onClick="document.getElementById('codrubro').focus(); document.getElementById('codrubro').select();" style="width:85%" >
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
                            <td >
						<input type="button" name="agregar2" id="agregar2" value="   Agregar   " onClick="agregardetalle2()" <?php if($_POST[actiblo]=="readonly"){echo "style=\"display:none;\"";}?> >
                        <input type="button" name="pdfsol" id="pdfsol" value="PDF Solicitud" onClick="pdfsolicitud()" <?php if($_POST[actiblo]=="readonly"){echo "style=\"display:none;\"";}?> >
                        <input type="button" name="pdfsol2" id="pdfsol2" value="PDF Solicitud" onClick="pdfsolicitud2()" <?php if($_POST[actiblo]=="readonly"){echo "style=\"display:block;\"";} else{echo "style=\"display:none;\"";}?> >
                	</td>
					
					<!-- adding solicitar certificado y no requiere certificado  -->
					 
							<td colspan="3" >
								<input type="hidden" name="solbpim" id="solbpim" value="<?php echo $_POST[solbpim]; ?>" />
								
								
								
								 <div style="display:inline-block; background-color: white !important"><label style="background-color: white !important">Solicitar certificado</label></div>
								<div class="c5" style="display:inline-block; border-right: 1px solid gray"><input type="checkbox" id="finaliza5" name="finaliza5" <?php if(isset($_POST['finaliza5'])){echo "checked disabled";} ?> value="<?php echo $_POST[finaliza5]?>"  onChange="validafinalizar(this,'2')"/><label for="finaliza5" id="t5" ></label></div>
								
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
       			<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> onClick="cambiobotones2();cambiopestanas('4');">
	   			<label for="tab-4"><img src="<?php echo $p2luzcem1;?>" width="16" height="16"><img src="<?php echo $p2luzcem2;?>" width="16" height="16"><img src="<?php echo $p2luzcem3;?>" width="16" height="16"> Informaci&oacute;n CDP</label>	
	  			<div class="content" style="overflow:hidden">
					<IFRAME src="<?php echo $_POST[conven2];?>" name="venvercdp" marginWidth=0 marginHeight=0 frameBorder=0 id="venvercdp" frameSpacing=0 style=" width:100%; height:70%; "> 
               	</IFRAME>
				<table class="inicio">
                        <tr>
                            <td class="titulos" colspan="3">Observaciones</td>
                        </tr>
                        <tr>
                            <td class="saludo1" style="width:70%;">
							<input type="text" name="observacdp" id="observacdp" value="<?php echo $_POST[observacdp]; ?>" style="width: 100%; height: 100px;font-weight:bold;font-size: 12px;text-transform:uppercase" readonly/>
							</td>
							
							<td class="sep"   style="width:10%;">
							<div>
							<center><h1>Anexos</h1></center>
							</div>
							</td>
							
							<td class="saludo1" style="width:20%;">
							<div style="height:100px;padding-left:2%;width:400px;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">
							
							
								
							</div>
							
							</td>
							
							
							
                            
                        </tr> 
                    </table>
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
									<input type="button" name="pdfsol4" id="pdfsol4" <?php if(!empty($_POST[descripcionb])){echo "onClick='pdfsolicitudbanco()' "; } ?> value="PDF Solicitud"  style="width: 20% !important">
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
									<td valign="middle" style="width: 19.5%">
										<input type="text" name="codproyecto" id="codproyecto" onKeyPress="javascript:return solonumeros(event)" 
							  onKeyUp="return tabular(event,this)" onBlur="document.form2.buscameta.value='1';document.form2.submit()" value="<?php echo $_POST[codproyecto]?>" onClick="document.getElementById('codproyecto').focus();document.getElementById('codproyecto').select();" style="width:85%" <?php if(isset($_POST[finaliza7]) || $_POST[estadob]=='CERTIFICADO'){echo "readonly"; }?> >
										<a href="#" <?php if(!(isset($_POST[finaliza7]) || $_POST[estadob]=='CERTIFICADO')){echo "onClick=\"despliegamodal2('visible','7');\" "; }?>  ><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" class="icobut"></a></td>
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
								if(obtenerEstado("contrasolicitudproyecto",$_POST[codid])=="A" || obtenerEstado("contrasolicitudproyecto",$_POST[codid])=="CE"){
									for($x=0;$x<$_POST[contadorsol]; $x++){
										$_POST[aceptab][$x]="1";
									}
								}
								
								for($x=0;$x<$_POST[contadorsol]; $x++){
									$estado = obtenerEstado("contrasolicitudproyecto",$_POST[codid]);
									if($estado=="A" || $estado=="CE"){
										
										$dis="DISABLED"; $disabled="READONLY"; 
									}else{
										if(existeSolicitudMeta($_POST[codproyecto],$_POST["matmetas1$x"][$conta-1])>0 && $estado!="S"){ //Here
											$estilo="style='background-color: yellow !important' ";
											$dis="DISABLED";
											$_POST[aceptab][$x]="";
										}else{
											$dis="";
											$estilo="";
										}
									}
									if(isset($_POST[aceptab][$x]) && !empty($_POST[aceptab][$x])){
										$check="CHECKED";
										$cont++;
									}else{
										$check="";
									}
									
									if(strcmp($check,"CHECKED")==0  && strcmp($dis,"DISABLED")!=0){
										$estilo="style='background-color: #0277BD !important;color:white !important;' ";
									}
									echo "<tr class='$itern' $estilo>";
									
									for ($y=0;$y<$conta;$y++)
									{
										if(!empty($_POST["matmetas1$x"][$y])){
											if($y==0){
												echo "<td><input type='checkbox' name='aceptab[$x]' id='aceptab[$x]'  onChange='document.form2.submit()' $check $dis /></td>";
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
  				<input type="radio" id="tab-6" name="tabgroup1" value="6" <?php echo $check6;?> onClick="cambiobotones1(); cambiopestanas('6');" >
	   			<label for="tab-6"><img src="<?php echo $p4luzcem1;?>" width="16" height="16"><img src="<?php echo $p4luzcem2;?>" width="16" height="16"><img src="<?php echo $p4luzcem3;?>" width="16" height="16">Informaci&oacute;n Banco Proyectos</label> 
                	<div class="content" style="overflow:hidden">
					<table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="8">Solicitud BPPIM</td>
                                
                            </tr>
							<tr>
                                <td class="saludo1" style="width:5%">Fecha:</td>
                                <td width="6%"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" style="width: 80%" readonly>&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  class="icobut"/></td>
								<td class="saludo1" style="width:5%">Solicitud:</td>
                                <td colspan="4" width="50%">
									<select name="solproyec" id="solproyec" onChange="cargarproyecto(this)" style="width: 100%" >
										<option value="" >Seleccione...</option>
										<?php
										$sql="SELECT csp.codigo,csp.codsolicitud,csp.codproyecto,csp.descripcion from contrasolicitudproyecto csp,contrasoladquisiciones cs WHERE  csp.vigencia='$vigusu' AND csp.codsolicitud=cs.codsolicitud AND csp.codigo='$_POST[solproyec]' ";
										$res=mysql_query($sql,$linkbd);
										while($row = mysql_fetch_row($res)){
											if($_POST[solproyec]==$row[0]){
												echo "<option value='$row[0]' SELECTED>$row[1] - $row[3]</option>";
												$_POST[codigo]=$row[0];
												$_POST[solproyecod]=$row[1];
											}else{
												echo "<option value='$row[0]' >$row[1] - $row[3]</option>";
											}
											
										}
										echo "<input type='hidden' name='solproyecod' id='solproyecod' value='$_POST[solproyecod]' />";
										?>
									</select>
								</td>
								<td rowspan="2" width="10%">
                                	<input name="estadob" type="text" id="estadob" value="<?php echo $_POST[estadob] ?>" <?php echo $colorbanco; ?> readonly>
								</td>
                                
                            </tr>
							<tr>
                                <td class="saludo1" style="width:5%">Valor Actividad:</td>
                                <td style="width:6%">
								<input name="valacti" type="text" id="valacti"  value="$ <?php echo number_format($_POST[valacti],2,',','.'); ?>" style="width: 100%;text-align:right" readonly>
								</td>
								<td class="saludo1" style="width:5%">Aporte Convenio:</td>
                                <td style="width:10%">
								<input name="aporconv" type="text" id="aporconv"  value="$ <?php echo number_format($_POST[aporconv],2,',','.'); ?>" style="width: 100%;text-align:right" readonly>
								</td>
								<td class="saludo1" style="width:5%">Aporte Municipio:</td>
                                <td style="width:10%">
								<input name="apormuni" type="text" id="apormuni"  value="$ <?php echo number_format($_POST[apormuni],2,',','.'); ?>" style="width: 100%;text-align:right" readonly>
								</td>
                                
                            </tr>
					</table>
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="10" >Datos Proyecto</td>
                             
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:7%">Codigo:</td>
                                <td style="width:20%"><input type="text" name="codigoproy" id="codigoproy" value="<?php echo $_POST[codigoproy]?>" style="width:98%" readonly></td>
                                <td class="saludo1" style="width:7%">Vigencia:</td>
                                <td style="width:7%"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:98%" readonly></td>
                                <td class="saludo1" style="width:8%">Archivo Adjunto:</td>
                                <td style="width:42.5%" colspan="4"><input type="text" name="nomarchadj" id="nomarchadj"  style="width:95%;text-align:right" value="<?php echo $_POST[nomarchadj]?>" readonly><img <?php if(!empty($_POST[nomarchadj])){echo "src='imagenes/descargar.png' onClick='redireccion()' ";  }else{echo "src='imagenes/descargard.png' ";}; ?>  title="descargar"  style="cursor:pointer !important"/></td>
                                <td rowspan="3" width="10%" style="background-image: url('imagenes/proyecto.png'); background-repeat: no-repeat; background-position:center center;background-size: 75px 75px">
                                	
								</td>
                                
								
                            </tr>
                            <tr>
                                <td class="saludo1">Nombre:</td>
                                <td colspan="3">
                                    <input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:100%;text-transform: uppercase;" readonly> 
                                </td>
                                <td class="saludo1">Valor del proyecto:</td>
                                <td>
       
                                    <script>jQuery(function($){ $('#valorproyecto').autoNumeric('init');});</script>
                                    <input type="hidden" name="valorp" id="valorp" value="<?php echo $_POST[valorp]?>"   />
                                    <input type="text" id="valorproyecto" name="valorproyecto"  value="<?php echo $_POST[valorproyecto]?>" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('valorp','valorproyecto');return tabular(event,this);" onBlur="validarcdp();" style="width:100%; text-align:right;" autocomplete="off" readonly>
                                    <input type="hidden" name="saldo" id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" > 

                                </td>
                                <input type="hidden" name="contador" id="contador" value="<?php echo $_POST[contador];?>" >
								 <input type="hidden" name="contadorsol" id="contadorsol" value="<?php echo $_POST[contadorsol];?>" >
                            </tr>
							<tr>
                                <td class="saludo1">Descripci&oacute;n:</td>
                                <td colspan="3">
                                    <input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;text-transform: uppercase;" readonly> 
                                </td>
                                
                              
                            </tr>
                           
                            <tr><td colspan="4"></td><td colspan="4" rowspan="2" valign="middle"><input type="button" name="agregar6" id="agregar6" value="   PDF Certificado BPPIM   " <?php if($_POST[estadob]=="CERTIFICADO"){echo " onClick='generabppim()' " ; } ?> style="position: relative;top: -25px" /></td></tr>
                        </table>
                        <?php
                        	$conta=0;
							$sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' AND nombre NOT LIKE '%INDICADORES%' ORDER BY orden";
                            $resn=mysql_query($sqln,$linkbd);
							$num=mysql_num_rows($resn);	
                        	 echo"
                                <div class='subpantalla' style='height:36.5%; width:99.5%; margin-top:0px; overflow-x:hidden'>
                                        <table class='inicio' width='99%'>
                                            <tr>
                                                <td class='titulos' colspan='$num'>Detalle Metas a Certificar</td>
                                            </tr>
                                            <tr>";
                                $sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' ORDER BY orden";
                                $resn=mysql_query($sqln,$linkbd);
                                $n=0; $j=0;
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
								for($x=0;$x<$_POST[contador]; $x++){
									echo "<tr class='$itern'>";
									for ($y=0;$y<$conta;$y++)
                                {
									echo "<td>";
									if(!empty($_POST["matmetas$x"][$y])){
										echo $_POST["matmetas$x"][$y]." - ".$_POST["matmetasnom$x"][$y];
									}
									echo "<input type='hidden' name='matmetas".$x."[]' value='".$_POST["matmetas$x"][$y]."' />";
									echo "<input type='hidden' name='matmetasnom".$x."[]' value='".$_POST["matmetasnom$x"][$y]."' />";
									echo "</td>";
                                    $auxn=$itern;
                                    $itern=$itern2;
                                    $itern2=$auxn;
                                }
                            
								echo "</tr>";
								}
                                
                                echo "
                                    </table></div>";
                         ?>
						 
						 <table class="inicio">
                        <tr>
                            <td class="titulos" colspan="3">Observaciones</td>
                        </tr>
                        <tr>
                            <td class="saludo1" style="width:70%;">
							<input type="text" name="observaban" id="observaban" value="<?php echo $_POST[observaban]; ?>" style="width: 100%; height: 100px;font-weight:bold;font-size: 12px;text-transform:uppercase" readonly/>
							</td>
							
							<td class="sep"   style="width:10%;">
							<div>
							<center><h1>Anexos</h1></center>
							</div>
							</td>
							
							<td class="saludo1" style="width:20%;">
							
							<div style="height:100px;padding-left: 2%;width:400px;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">
							</div>
							</td>
						</tr> 
                    </table>
						 
						 
               	</IFRAME>
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
                                      <div class='upload' > 
                                      <input type="file" name="plantillaadest" onChange="document.getElementById('pesactiva').value='7';document.form2.oculto.value=1;document.form2.submit();" />
                                      <img src="imagenes/upload01.png" style="width:18px; " title="Cargar" /> 
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
                                	$rutaarchivo="informacion/proyectos/temp/".$_POST[rutarchivosest][$x];
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
            </div>	<!-- Fin tab -->
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
                                if ($_POST[agregadet8]=='1')
                                {
                                    $ch=esta_en_array($_POST[rutarchivossec],$_POST[rutarchivosec]);
                                    if($ch!='1')
                                    {			 
                                        $_POST[nomarchivossec][]="Adjunto No. ".count($_POST[rutarchivossec]);
                                        $_POST[rutarchivossec][]=$_POST[rutarchivosec];
                                        $_POST[descripsec][]=$_POST[descripcionsec];
                                        $_POST[patharchivossec][]=$_POST[patharchivosec];
                                        $_POST[agregadet8]=0;
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
                                	$rutaarchivo="informacion/proyectos/temp/".$_POST[rutarchivossec][$x];
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
        	<input type="hidden" name="indindex" id="indindex" value="<?php echo $_POST[indindex];?>">
           	<input type="hidden" name="codid" id="codid" value="<?php echo $_POST[codid];?>">
			<input type="hidden" name="conven2" id="conven2" value="<?php echo $_POST[conven2];?>">
			<input type="hidden" name="rutabanco" id="rutabanco" value="<?php echo $_POST[rutabanco];?>">
            <input type="hidden" name="oculgen" id="oculgen" value="<?php echo $_POST[oculgen];?>">
            <input type="hidden" name="ovigencia" id="ovigencia" value="<?php echo $_POST[ovigencia];?>">
            <input type="hidden" name="actiblo" id="actiblo" value="<?php echo $_POST[actiblo];?>">
            <input type="hidden" name="pesactiva" id="pesactiva" value="<?php echo $_POST[pesactiva];?>">
            <input type="hidden" value="0" name="busadq">
            <input type="hidden" value="0" name="bctercero">
            <input type="hidden" value="0" name="bc">
            <input type="hidden" value="0" name="bcproyectos">
            <input type="hidden" value="0" name="agregadet2">
            <input type="hidden" value="0" name="agregadet"> 
            <input type="hidden" value="0" name="agregadets">
            <input type="hidden" value="0" name="agregadetadq">
            <input type="hidden" name='eliminar' id='eliminar'>
            <input type="hidden" name='eliminars' id='eliminars'>
			<input type="hidden" name="eliminarpro" id="eliminarpro" value="<?php echo $_POST[eliminarpro];?>">
			<input type="hidden" name="agregadet6" value="0">
			<input type="hidden" name="agregadet7" value="0">
			<input type="hidden" name="agregadet8" value="0">
			<input type="hidden" name="sumnivel" id="sumnivel" value="<?php echo $_POST[sumnivel];?>">
			<input type="hidden" name="eliminarm" id="eliminarm" value="<?php echo $_POST[eliminarm]; ?>">
			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>" >
			<input type="hidden" name="esliberado" id="esliberado" value="<?php echo $_POST[esliberado]; ?>" />
			<input type="hidden" name="banderin5" id="banderin5" value="<?php echo $_POST[banderin5];?>" >
			<input type="hidden" name="banderin4" id="banderin4" value="<?php echo $_POST[banderin4];?>" >
			<input type="hidden" name="banderin3" id="banderin3" value="<?php echo $_POST[banderin3];?>" >
			<input type="hidden" name="banderin2" id="banderin2" value="<?php echo $_POST[banderin2];?>" >
			<input type="hidden" name="banderin1" id="banderin1" value="<?php echo $_POST[banderin1];?>" >
			<input type="hidden" name="finfasblo" id="finfasblo" value="<?php echo $_POST[finfasblo];?>">
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
					if(isset($_POST['finaliza'])){$cfinaliza=1;}else{$cfinaliza=0;}
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					$productosave="";
					if(!empty($_POST[fechat])){
						$pos=strpos($_POST[fechat],"-");
						if($pos===false){
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechat],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						}else{
							$fechaf=$_POST[fechat];
						}
					
					}else{
						$fechaf="";
					}
					
					if(!empty($_POST[fechatb])){
						$pos=strpos($_POST[fechatb],"-");
						if($pos===false){
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechatb],$fecha1);
							$fechaf1=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];	
						}else{
							$fechaf1=$_POST[fechatb];
						}
						
					}else{
						$fechaf1="";
					}
					$codproducto="";
					$valunitario="";
					$valtotalsol=0;
					for($i=0;$i<count($_POST[dproductos]);$i++){
						$codproducto.=$_POST[dproductos][$i]."-";
						$valunitario.=$_POST[dvaluni][$i]."-";
						$canunitario.=$_POST[dcantidad][$i]."-";
						$valtotalsol+=$_POST[dvaluni][$i];
					}
					$codproducto=substr($codproducto,0,-1);
					$valunitario=substr($valunitario,0,-1);
					$canunitario=substr($canunitario,0,-1);
					if(count($_POST[dproductos])>0){
						$sql="UPDATE contrasoladquisiciones SET codproductos='$codproducto',numproductos='$canunitario',valunitariop='$valunitario',coddestcompra='$_POST[destcompra]' WHERE codsolicitud='$_POST[codid]'  ";
						mysql_query($sql,$linkbd);
					}
					
					$solicitantesave="";
					for($x=0;$x<$_POST[banderin3];$x++)
					{
						if ($x==0){$solicitantesave=$_POST[sdocumento][$x];}
						else{$solicitantesave=$solicitantesave."-".$_POST[sdocumento][$x];} 
					}
					$codproyecto="";
					$sql="UPDATE contrasoladquisiciones SET activo='$cfinaliza' WHERE codsolicitud='$_POST[codid]'";
					mysql_query($sql,$linkbd);
					$sqlr ="DELETE FROM contrasoladquisicionesgastos WHERE codsolicitud='$_POST[codid]'";
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM contrasolicitudcdp_det WHERE proceso='$_POST[codid]'";
					mysql_query($sqlr,$linkbd);
					$sql2="DELETE FROM contrasolicanexos WHERE codsolicitud='$_POST[codid]'";
					mysql_query($sql2,$linkbd);
					$sql="SELECT codproyecto FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codigot]' ";
					$res=mysql_query($sql,$linkbd);
					$proyecto=mysql_fetch_row($res);
					$codproyecto=$proyecto[0];
					$valtotal=0;
					if(requiereBPIM($_POST[dtipogastos])==1){
						if(isset($_POST[finaliza7]) || $_POST[codigoproy]!=''){
							$valtotal=$_POST[cuentagas];
							for($x=0;$x<$_POST[banderin1];$x++)
							{
								if(!empty($_POST[dcuentas][$x])){
									if(!empty($proyecto[0])){
										$sqlr="INSERT INTO contrasoladquisicionesgastos (codsolicitud,tipogasto,meta,rubro,fuente,valor,estado,codproyecto) VALUES ('$_POST[codigot]','".$_POST[dtipogastos][$x]."','".$_POST[dmetas][$x]."','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dgastos][$x]."', 'S','".$proyecto[0]."') ";
									}else{
										$sqlr="INSERT INTO contrasoladquisicionesgastos (codsolicitud,tipogasto,meta,rubro,fuente,valor,estado) VALUES ('$_POST[codigot]','".$_POST[dtipogastos][$x]."','".$_POST[dmetas][$x]."','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dgastos][$x]."', 'S') ";
									}
									
								mysql_query($sqlr,$linkbd);
								//********almacenar CDP*********
								if(!empty($proyecto[0])){
									$sqlr="INSERT INTO contrasolicitudcdp_det (proceso,vigencia,rubro,fuente,meta,valor,estado,conproyecto) VALUES ('$_POST[codigot]','$vigusu','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dmetas][$x]."','".$_POST[dgastos][$x]."','S','".$proyecto[0]."') ";
								
								}else{
									$sqlr="INSERT INTO contrasolicitudcdp_det (proceso,vigencia,rubro,fuente,meta,valor,estado) VALUES ('$_POST[codigot]','$vigusu','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dmetas][$x]."','".$_POST[dgastos][$x]."','S') ";
								}
									mysql_query($sqlr,$linkbd);
								}
								
							}
						}
					}else{
						$valtotal=$_POST[cuentagas];
						for($x=0;$x<$_POST[banderin1];$x++)
						{
							if(!empty($_POST[dcuentas][$x])){
								if(!empty($proyecto[0])){
									$sqlr="INSERT INTO contrasoladquisicionesgastos (codsolicitud,tipogasto,meta,rubro,fuente,valor,estado,codproyecto) VALUES ('$_POST[codigot]','".$_POST[dtipogastos][$x]."','".$_POST[dmetas][$x]."','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dgastos][$x]."', 'S','".$proyecto[0]."') ";
								}else{
									$sqlr="INSERT INTO contrasoladquisicionesgastos (codsolicitud,tipogasto,meta,rubro,fuente,valor,estado) VALUES ('$_POST[codigot]','".$_POST[dtipogastos][$x]."','".$_POST[dmetas][$x]."','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dgastos][$x]."', 'S') ";
								}
								
							mysql_query($sqlr,$linkbd);
							//********almacenar CDP*********
							if(!empty($proyecto[0])){
								$sqlr="INSERT INTO contrasolicitudcdp_det (proceso,vigencia,rubro,fuente,meta,valor,estado,conproyecto) VALUES ('$_POST[codigot]','$vigusu','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dmetas][$x]."','".$_POST[dgastos][$x]."','S','".$proyecto[0]."') ";
							
							}else{
								$sqlr="INSERT INTO contrasolicitudcdp_det (proceso,vigencia,rubro,fuente,meta,valor,estado) VALUES ('$_POST[codigot]','$vigusu','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dmetas][$x]."','".$_POST[dgastos][$x]."','S') ";
							}
								mysql_query($sqlr,$linkbd);
							}
							
						}
					}
					if(isset($_POST[finaliza5])){
						$sql="UPDATE contrasolicitudcdp SET liberado=1 WHERE proceso='$_POST[codigot]' ";
						mysql_query($sql,$linkbd);
					}
					
					if($valtotal>0){
						
						$sqlr="UPDATE contrasoladquisiciones SET  codsolicitante='$solicitantesave',valortotal='$valtotal',codcdp='S',activo='$cfinaliza',coddestcompra='$_POST[destcompra]' WHERE codsolicitud='$_POST[codid]' AND  (codcdp='S' OR codcdp='') ";
					}else{
						$sqlr="UPDATE contrasoladquisiciones SET  codsolicitante='$solicitantesave',valortotal='$valtotal',activo='$cfinaliza',coddestcompra='$_POST[destcompra]' WHERE codsolicitud='$_POST[codid]' ";
					}
					
					mysql_query($sqlr,$linkbd);
					
					
					for($x=0;$x<count($_POST[nomarchivosest]); $x++){
						$sqlr="INSERT INTO contrasolicanexos (codsolicitud,tipo,ruta,descripcion,estado,vigencia) VALUES ('$_POST[codigot]','previo','".$_POST[rutarchivosest][$x]."','".$_POST[descripest][$x]."','S','$vigusu') ";
						mysql_query($sqlr,$linkbd);
					}
					for($x=0;$x<count($_POST[nomarchivossec]); $x++){
						$sqlr="INSERT INTO contrasolicanexos (codsolicitud,tipo,ruta,descripcion,estado,vigencia) VALUES ('$_POST[codigot]','sector','".$_POST[rutarchivossec][$x]."','".$_POST[descripsec][$x]."','S','$vigusu') ";
						mysql_query($sqlr,$linkbd);
					}

					if(isset($_POST[finaliza1])){
							
							$sql="SELECT estado FROM contrasolicitudpaa WHERE  codsolicitud='$_POST[codigot]'";
						$res=mysql_query($sql,$linkbd);
						$row=mysql_fetch_row($res);
						if($row[0]=='CO'){
							$sql="UPDATE contrasolicitudpaa SET estado='CC',descripcion='$_POST[descripciont]',fecha='$fechaf1' where codsolicitud='$_POST[codigot]' ";
						}elseif($row[0]=='CE'){
							$sql="UPDATE contrasolicitudpaa SET estado='CE',descripcion='$_POST[descripciont]',fecha='$fechaf1' where codsolicitud='$_POST[codigot]' ";
						}
						else{
							$sql="UPDATE contrasolicitudpaa SET estado='A',descripcion='$_POST[descripciont]',fecha='$fechaf1' where codsolicitud='$_POST[codigot]' ";
						}
						mysql_query($sql,$linkbd);
						}else if(isset($_POST[finaliza2])){
							$sql="UPDATE contrasolicitudpaa SET estado='N',descripcion='$_POST[descripciont]',fecha='$fechaf' where codsolicitud='$_POST[codigot]' ";
							mysql_query($sql,$linkbd);
						}else{
							$sql="UPDATE contrasolicitudpaa SET descripcion='$_POST[descripciont]',fecha='$fechaf' where codsolicitud='$_POST[codigot]' ";
							mysql_query($sql,$linkbd);
							$sql="SELECT estado FROM contrasolicitudpaa WHERE codsolicitud='$_POST[codigot]'";
							$res=mysql_query($sql,$linkbd);
							$num=mysql_num_rows($res);
							if($num==0){
								$sql="UPDATE contrasolicitudpaa SET estado='S',descripcion='$_POST[descripciont]',fecha='$fechaf' where codsolicitud='$_POST[codigot]' ";
								mysql_query($sql,$linkbd);
							}
							
					}
						
						
					
					//***solicitud banco
					
					if(isset($_POST[finaliza7])){
						$sql="SELECT estado FROM contrasolicitudproyecto WHERE  codsolicitud='$_POST[codigot]'";
						$res=mysql_query($sql,$linkbd);
						$row=mysql_fetch_row($res);
						if($row[0]=='CO'){
							$sql="UPDATE contrasolicitudproyecto SET estado='CC',descripcion='$_POST[descripcionb]',fecha='$fechaf1' where codsolicitud='$_POST[codigot]' ";
						}else{
							$sql="UPDATE contrasolicitudproyecto SET estado='A',descripcion='$_POST[descripcionb]',fecha='$fechaf1' where codsolicitud='$_POST[codigot]' ";
						}
						
						mysql_query($sql,$linkbd);
					}else if(isset($_POST[finaliza8])){
						$sql="UPDATE contrasolicitudproyecto SET estado='N',descripcion='$_POST[descripcionb]',fecha='$fechaf1' where codsolicitud='$_POST[codigot]' ";
						mysql_query($sql,$linkbd);
					}else{
						$sql="UPDATE contrasolicitudproyecto SET descripcion='$_POST[descripcionb]',fecha='$fechaf1' where codsolicitud='$_POST[codigot]' ";
						mysql_query($sql,$linkbd);
						$sql="SELECT estado FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codigot]'";
						$res=mysql_query($sql,$linkbd);
						$num=mysql_num_rows($res);
						if($num==0){
							$sql="UPDATE contrasolicitudproyecto SET estado='S',descripcion='$_POST[descripcionb]',fecha='$fechaf1' where codsolicitud='$_POST[codigot]' ";
							mysql_query($sql,$linkbd);
						}
						
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
					$sql="DELETE FROM contrasolicitudproyecto_det WHERE codigosol='$_POST[codigot]' ";
					mysql_query($sql,$linkbd);
					
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
					?><script>document.getElementById('oculgen').value="0";despliegamodalm('visible','3','Se Modifico la solicitud de Adqusicion con Exito');</script><?php	
					if ($cfinaliza==1){echo"<script>document.getElementById('finaliza').checked=true;</script>"; }
					
			  }	
			if($_POST[oculgen]=="5")
			{
				if ($_POST[finaliza]==1){echo"<script>document.getElementById('finaliza').checked=true;</script>"; }
				$_POST[oculgen]="0";
				echo"<script>document.getElementById('oculgen').value='0';</script>";
			}	
			?> 
		
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
            </div>
        </form>
	</body>
</html>

