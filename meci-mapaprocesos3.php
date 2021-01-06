<?php //V 1000 12/12/16 ?> 
<?php
  require"comun.inc";
  require"funciones.inc";
  session_start();
  $linkbd=conectar_bd();  
  cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  header("Cache-control: private"); // Arregla IE 6
  date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
  <head>
  <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
  <meta http-equiv="X-UA-Compatible" content="IE=9"/>
  <title>:: Spid - Calidad</title>
  

  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="css/programas.js"></script>

  <script src="JQuery/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
  <?php titlepag();?>
</head>
<body>
    <?php
      $procesos[]=array();
      $tprocesos[]=array();
        $linkbd=conectar_bd();  
      $sqlr="Select * from dominios where dominios.nombre_dominio='PROCESOS_CALIDAD' order by valor_final ";
      	$resp = mysql_query($sqlr,$linkbd);
          while ($row =mysql_fetch_row($resp))
      	{
      	 $tprocesos[$row[1]][0]=$row[0];
      		 $tprocesos[$row[1]][1]=$row[1];
      		 $tprocesos[$row[1]][2]=$row[2];
       		 $tprocesos[$row[1]][4]=$row[4];
      	}
      	
      	$sqlr="Select calprocesos.id, calprocesos.nombre, DOMINIOS.TIPO,calprocesos.clasificacion, calprocesos.prefijo from calprocesos, dominios where dominios.nombre_dominio='PROCESOS_CALIDAD' AND calprocesos.clasificacion=DOMINIOS.VALOR_FINAL AND calprocesos.estado='S' ";
      	$resp = mysql_query($sqlr,$linkbd);
          while ($row =mysql_fetch_row($resp))
      	{
      	 $procesos[$row[0]][0]=$row[0];
      	 $procesos[$row[0]][2]=$row[2];
      		 $procesos[$row[0]][1]=$row[1];
      		 $procesos[$row[0]][3]=$row[3];
      	 $procesos[$row[0]][4]=$row[4];
      	}
      	$_POST[codigo]=$mx+1;	
    ?>
  <div class="row">}
        <div class="panel panel-primary" style="margin-left: 20px;margin-right: 20px;  height: 95%"> <!-- panel panel-primary-->
          <div class="panel-heading"> 
            <h5 class="panel-title">
              <?php echo "PORCESOS"?>                
            </h5>
          </div> 
          <div class="panel-body center">
      <div class="col-lg-2" style="padding-right: 0px;left: 0.5%;">
        <!- Inicio Entradas ->
        <div class="panel panel-sapote"> <!-- panel panel-primary-->
          <div class="panel-heading"> 
            <h5 class="panel-title">
              <?php echo "ENTRADAS"?>                
            </h5>
          </div> 
          <div class="panel-body center">
            <div class="well">
              <?php
                $cv=count($procesos);
                $ct=count($tprocesos);
              //   echo "sss".$ct;
                for($t=1;$t<$ct;$t++) {// For 2
            	//   echo "t:".$tprocesos[$t][4];
                  if($tprocesos[$t][4]=='E' ) {// IF 2
                      //   echo "sss".$cv;
                    for($x=1;$x<=$cv;$x++ ) { // FOr 1
                	   	   //echo "t:".$tprocesos[$t][1];
                      if($procesos[$x][2]=='E' && $procesos[$x][3]==$tprocesos[$t][1]){ //IF 1
                        echo "<P class='text-primary'>".$procesos[$x][1]." (".$procesos[$x][4].")</P>";
                          //echo "<img class='valign' />".$procesos[$x][1]." (".$procesos[$x][4].")";
                      }//If 1
                   	}//FOR 1
                  }//IF2
                }//FR 2
              ?>
            </div>
          </div> 
        </div>  <!-- Fin macroproceso -->
        <!- Fin Entradas ->
      </div>
      <div class="col-lg-8">
        <!- Inicio Procesos ->
        

        
            <?php
              $cv=count($procesos);
              $ct=count($tprocesos);
              // echo "sss".$ct;
              for($t=1;$t<$ct;$t++){ // INICIO For 1
                //   echo "t:".$tprocesos[$t][4];
                if($tprocesos[$t][4]=='P' ){ // Inicio if 1
          	?>

            <div class="imagenFondo btn-proceso col-lg-6" style='background-image: url(imagenes/ajustes256.png);height: 256px;width: 256px;' data-id="P<?php echo $tprocesos[$t][0]?>" data-toggle="modal" data-target="#exampleModal">
            <label style='padding-top: 45%;' class=''><?php echo "".$tprocesos[$t][2] ?></label>
            </div>
         

            <div class="hidden"> <!-- panel panel-primary-->
              
                <div class="form-group" id="P<?php echo $tprocesos[$t][0]?>">
                    <?php	   
                      // echo "sss".$cv;
                      for($x=1;$x<=$cv;$x++ ){
                  	   	   //echo "t:".$tprocesos[$t][1];
                        if($procesos[$x][2]=='P' && $procesos[$x][3]==$tprocesos[$t][1]) {
                  	      echo "<div class='text-center'>";                        
                          echo "<button type='button' style='margin-bottom: 3px;' class='btn btn-success btn-sm'>".$procesos[$x][1]." (".$procesos[$x][4].")</button>";
                          //echo "<img class='valign' />".$procesos[$x][1]." (".$procesos[$x][4].")";
                          echo "</div>";
                	      }
                     	}
                    ?>
                </div>
            </div> <!-- FIn panel panel-primary-->
              <?php  
                  } // Fin if 1
                }//Fin fr 1
              ?>
        <!- Inicio Procesos ->
        <div class="modal fade" id='exampleModal' role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalproceso"></h4>
              </div>
              <div class="modal-body">

              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
            </div>
            </div>
          </div>
        </div>
      </div>
      
  <script type="text/javascript">
    $('.btn-proceso').click(function(event) {
      console.log();
      $('#modalproceso').text($(this).text());
      var id = $(this).data('id');
      var html = $('#'+id).html();
      $('.modal-body').html(html);
    });
  </script>
      <div class="col-lg-2" style='right: 0.5%; padding-left: 0px;'>
        <!- Inicio Salidas ->
        <div class="panel panel-verde"> <!-- panel panel-primary-->
          <div class="panel-heading"> 
            <h5 class="panel-title">
              <?php echo "SALIDAS"?>                
            </h5>
          </div> 
          <div class="panel-body" >
            <div class="well">
            <?php
              $cv=count($procesos);
              $ct=count($tprocesos);
              //   echo "sss".$ct;
              for($t=1;$t<$ct;$t++) { // Inicio For 3
            	  //   echo "t:".$tprocesos[$t][4];
                if($tprocesos[$t][4]=='S' ) { //inicio if 3
                  //   echo "sss".$cv;
                  for($x=1;$x<=$cv;$x++ ) { // Inicio For 4
                	   	   //echo "t:".$tprocesos[$t][1];
              	    if($procesos[$x][2]=='S' && $procesos[$x][3]==$tprocesos[$t][1]) { //inicio if 4
                      //echo "<img class='valign' />".$procesos[$x][1]." (".$procesos[$x][4].")";
                       echo "<P class='text-primary'>".$procesos[$x][1]." (".$procesos[$x][4].")</P>";
                	  } //fin if 4
                  } //Fin for 4
           	    } //fin if 3
              } //Fin for 3
            ?>
            </div>
          </div>
        </div>
        <!- Fin Salidas ->
      </div>
      </div>
    </div>
  </div> 
   
</body>
</html>

