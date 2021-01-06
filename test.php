<?php //V 1000 12/12/16 ?> 
<!doctype html>
<?php
session_start();
?>
<html>
<head>
  <meta charset="UTF-8"/>
  <title>Foto web</title>
    <script language="JavaScript">
    function camEnviar(){
		<?php
if($_GET[cc]!="")
{
		$_SESSION[otro]=$_GET[cc];
	}
$nombref=$_SESSION[otro];
			  $filename = "fotos/$nombref.jpg";
  			  $filename2 = "equivida-hc/fotos/$nombref.jpg";
		 ?>
 //variablejs=document.getElementById('nfoto').value;
 	  webcam.upload();
	<?php 
	  $jpeg_data = file_get_contents('php://input');
	  $result = file_put_contents($filename,$jpeg_data );
	  $result2 = file_put_contents($filename2,$jpeg_data );	  
	?>
	  document.getElementById('btnGrabar').style.display = '';
      document.getElementById('btnCancelar').style.display = 'none';
      document.getElementById('btnEnviar').style.display = 'none';
	        webcam.reset();
			  setTimeout('retardo()',3000);
			    }
				function retardo()
				{
					opener.document.fotosn.src ='<?php echo $filename; ?>'
						      window.close() ;
					}

  </script>
    <script type="text/javascript" src="webcam.js"></script>
<link href="cssjs/css2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="saludo1">TOMAR FOTOS</div>
<div id='camara'>
  <script language="JavaScript">
    webcam.set_api_url('test.php');
    webcam.set_swf_url('webcam.swf');
    webcam.set_quality(90); // JPEG quality (1 - 100)
    webcam.set_shutter_sound(true); // play shutter click sound
    webcam.shutter_url = 'shutter.mp3';
    webcam.set_hook("onLoad", null);
    webcam.set_hook("onComplete", null);
    webcam.set_hook("onError", null);
    document.write(webcam.get_html(320, 240));
  </script>
    <script language="JavaScript">
    function camGrabar(){
      webcam.reset();
      webcam.freeze();
      document.getElementById('btnGrabar').style.display = 'none';
      document.getElementById('btnCancelar').style.display = 'block';
      document.getElementById('btnEnviar').style.display = '';
    }  </script>
	  <script language="JavaScript">
    function camCancelar(){
      webcam.reset();
      document.getElementById('btnGrabar').style.display = '';
      document.getElementById('btnCancelar').style.display = 'none';
      document.getElementById('btnEnviar').style.display = 'none';
    }
	</script>  
</div>
<p>

<input type="hidden" id="oculto" value="<?php echo $_GET[cc]?>">
<div class="saludo1">  <button onClick="camGrabar(); return false;" id='btnGrabar' value="<?php echo $_GET[cc]?>">Grabar</button>
  <button onClick="camCancelar(); return false;" id='btnCancelar' style='display:none'>Cancelar</button>
  <button onClick="camEnviar(); return false" id='btnEnviar' style='display:none'>Enviar</button>
 </div>
</p>
</body>
</html> 
