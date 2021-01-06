$nomcap= "C:\xampp\htdocs\financieroser\backups\cubarral"+ (Get-Date -format yyyy) + (Get-Date -format MM) + (Get-Date -format dd) + "_" + (Get-Date -format HH) + (Get-Date -format mm) + (Get-Date -format ss)
$cbase="C:\xampp\mysql\data\contable"
$cdocum="C:\xampp\htdocs\financieroser\informacion"
Compress-Archive -Path $cbase, $cdocum -CompressionLevel Fastest -DestinationPath $nomcap