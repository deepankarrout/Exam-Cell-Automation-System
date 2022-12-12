<?php
include('includes/check.php');
if(!empty($_FILES["fileUpload"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "srms");  
      $file_array = explode(".", $_FILES["fileUpload"]["name"]);  
      if($file_array[1] == "xls")  
      {  
           include("Classes/PHPExcel/IOFactory.php");
           $output = '';  
           $output .= "  
           <label class='text-success'>Data Inserted</label>  
                <table class='table table-bordered'>  
                     <tr>  
                          <th>Regd. No.</th>  
                          <th>Name</th>  
                          <th>D.O.B</th>  
                          <th>Y.O.A</th>  
                          <th>Phone</th>  
                     </tr>  
                     ";  
           $object = PHPExcel_IOFactory::load($_FILES["fileUpload"]["tmp_name"]);  
           foreach($object->getWorksheetIterator() as $worksheet)  
           {  
                $highestRow = $worksheet->getHighestRow();  
                for($row=2; $row<=$highestRow; $row++)  
                {  
                     //$sid = '';  
                     $academicyear = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());  
                     $sname = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());  
                     $sregdno = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  
                     $semail = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());  
                     $sphone = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());  
                     $sgender = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());  
                     $dob = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());  
                     $deptid = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());  
                     $semid = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
                     $islateral = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
                     // $ndob = strtotime($dob);
                     // $sdob = date('Y-m-d',$ndob);
                     // $regdate = '';  
                     // $updationdate = '';  
                     $status = 1;  
                     $query = " INSERT INTO tblstudents (academicyear, StudentName, RollId, StudentEmail, phoneno, Gender, DOB, deptid, ClassId, islateral, Status) VALUES ('".$academicyear."', '".$sname."', '".$sregdno."', '".$semail."','".$sphone."', '".$sgender."', '".$dob."', '".$deptid."', '".$semid."','".$islateral."', '".$status."') ";
                     if ($connect->query($query) === TRUE) {
                        //echo "File Uploaded successfully";
                      } else {
                        echo "Error: " . $query . "<br>" . $connect->error;
                      }
                     // $run = mysqli_query($connect, $query);
                     // print_r($query);
                     $output .= '  
                     <tr>  
                          <td>'.$sregdno.'</td>  
                          <td>'.$sname.'</td>  
                          <td>'.$dob.'</td>  
                          <td>'.$academicyear.'</td>
                          <td>'.$semail.'</td>  
                     </tr>  
                     ';  
                }
           }  
           $output .= '</table>';  
           echo $output;  
      }  
      else  
      {  
           echo '<label class="text-danger">Invalid File</label>';  
      }  
 }
?>