<?php //V 1000 12/12/16 ?> 
<?php 
 $allowedExts = array("gif", "jpeg", "jpg", "png");
 $temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
 || ($_FILES["file"]["type"] == "image/jpeg")
 || ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
 || ($_FILES["file"]["type"] == "image/png"))
 && ($_FILES["file"]["size"] < 20000)
 && in_array($extension, $allowedExts)) {
   if ($_FILES["file"]["error"] > 0) {
     echo "Error: " . $_FILES["file"]["error"] . "<br>";
   } else {
     echo "Upload: " . $_FILES["file"]["name"] . "<br>";
     echo "Type: " . $_FILES["file"]["type"] . "<br>";
     echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
     echo "Stored in: " . $_FILES["file"]["tmp_name"];
   }
 } else {
   echo "Invalid file";
 }
 ?> 
 
 <?php /*?>
 <form action="plan-cargainformacion.php" method="post"
         enctype="multipart/form-data">
         <label for="file">Filename:</label>
         <input type="file" name="file" id="file"><br>
         <input type="submit" name="submit" value="Submit">
         </form>

 
  <?php */?>