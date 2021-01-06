<?php //V 1000 12/12/16 ?> 
<?php
 $dbhost = 'localhost'; 
 $dbuser = 'jacavi81';
 $dbpass = '86070388';
 $dbname = 'prueba';
  
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to database.");
    mysql_select_db($dbname, $db) or die ("Couldn't select the database.");
    
    $date = date('mdY');
    $backupFile = 'backups\dbBackup-servicios-20150506-164605.sql';
    $mysqldumppath = '"C:\xampp\mysql\bin\mysql.exe"';
    //$command = "$mysqldumppath --opt -h $dbhost -u$dbuser -p$dbpass $dbname > $backupFile"; //| gzip
    $command = "$mysqldumppath -h $dbhost -u$dbuser -p$dbpass $dbname < $backupFile";

    echo $command; 

    system($command);

    mysql_close($db);
?>