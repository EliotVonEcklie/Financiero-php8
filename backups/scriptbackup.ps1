$fecnom= (Get-Date -format yyyy) + (Get-Date -format MM) + (Get-Date -format dd) + "_" + (Get-Date -format HH) + (Get-Date -format mm) + (Get-Date -format ss)
$nombas= "C:\xampp\htdocs\financiero\backups\ptoricobase" + $fecnom
$nomarc= "C:\xampp\htdocs\financiero\backups\ptoricoarch" + $fecnom
$baszip=$nombas+".zip"
$arczip=$nomarc+".zip"
$cbase="C:\xampp\mysql\data\ptorico"
$cdocum="C:\xampp\htdocs\financiero\informacion"
Invoke-Expression -Command “C:\xampp\mysql_stop.bat”
Compress-Archive -Path $cbase -CompressionLevel Optimal -DestinationPath $nombas
Invoke-Expression -Command “C:\xampp\mysql_start.bat”
Copy-Item -path $baszip -Destination "C:\Users\Spid\OneDrive - G&C TECNOINVERSIONES SAS"
Compress-Archive -Path $cdocum -CompressionLevel Optimal -DestinationPath $nomarc
Copy-Item -path $arczip -Destination "C:\Users\Spid\OneDrive - G&C TECNOINVERSIONES SAS"