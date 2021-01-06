<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SOFTWARE SPID</title>
        <link rel="shortcut icon" href="favicon.ico"/>
		<style type="text/css">
			html, body, div, iframe {
                margin:0; padding:0; height:100%;
            }
			iframe {
                display:block; width:100%; border:none;
            }
		</style>
	</head>
	<body>
    	<form name="form2" method="post" action="Spid.php">
            <?php 
                if($_GET['pagina'] != "")
                {
                    $_POST['oculto'] = $_GET['pagina'];
                }
            ?>

			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST['oculto'];?>"/>
            <?php 
                if($_GET['pagina']!="")
                {
                    echo "<script>document.form2.submit();</script>";
                }

                echo $_POST['oculto'];
            ?>
		</form>
		
		<iframe src="<?php echo $_POST['oculto'];?>"></iframe>
      
	</body>
</html>
