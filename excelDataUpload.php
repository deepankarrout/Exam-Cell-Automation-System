<?php
$connect = mysqli_connect("localhost","root","","student_info");
if (isset($_POST['submit'])) 
{
	if ($_FILES['file']['name']) 
	{
		# code...
		$filename = explode(".",$_FILES['file']['name']);
		//print_r($filename);
		if (($filename[1] == "csv") || ($filename[1] == "xlsx")) //File Format Check
			{

				$handle = fopen($_FILES['file']['tmp_name'],"r");
				while ($data = fgetcsv($handle))
				{
					$item1 = mysqli_real_escape_string($connect,$data[0]);
					$item2 = mysqli_real_escape_string($connect,$data[1]);
					$item3 = mysqli_real_escape_string($connect,$data[2]);
					echo $item1.'<br>'.$item2.'<br>'.$item3.'<br>';
	
    				mysqli_query($connect,"INSERT INTO `excel_upload`(`Name`,`Regd_id`,`Email`) values('".$item1."','".$item2."','".$item3."')");
				}
			}
			fclose($handle);
			print("import done sucessfully");
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Data</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
	<div align="center">
		<p>Upload file:<input type="file" name="file"></p>
		<p><input type="submit" name="submit" value="import"></p>
	</div>
</form>
</body>
</html>