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
                          <th>Name</th>
                          <th>Teacher Id</th>
                          <th>Department</th>
                          <th>Contact No</th>
                          <th>Email Id</th>  
                     </tr>  
                     ";  
           $object = PHPExcel_IOFactory::load($_FILES["fileUpload"]["tmp_name"]);  
           foreach($object->getWorksheetIterator() as $worksheet)  
           {  
                $highestRow = $worksheet->getHighestRow();  
                for($row=2; $row<=$highestRow; $row++)  
                {  
                     $fid = '';  
                     $eid = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());  
                     $designation = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());  
                     $username = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  
                     $fname = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());  
                     $femail = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());  
                     $fcontact = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());  
                     $gender = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());  
                     $dob = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());  
                     $dept = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
                     //$profile = '';  
                     //$creationdate = '';  
                     //$updationdate = '';  
                     $status = 1;
                     $password = 1234;
                     $utype = 'faculty';
                     $query = " INSERT INTO tblfaculties (e_id, e_type, username, e_name, e_email, e_contact, gender, dob, dept, status) VALUES ('".$eid."', '".$designation."', '".$username."', '".$fname."','".$femail."', '".$fcontact."', '".$gender."', '".$dob."', '".$dept."', '".$status."')";
                     if ($connect->query($query) === TRUE) {
                        //echo "File Uploaded successfully";
                      } else {
                        echo "Error: " . $query . "<br>" . $connect->error;
                      }
                     // $run = mysqli_query($connect, $query);
                     // print_r($query);
                     $output .= '  
                     <tr>  
                          <td>'.$fname.'</td>  
                          <td>'.$eid.'</td>  
                          <td>'.$dept.'</td>  
                          <td>'.$fcontact.'</td>  
                          <td>'.$femail.'</td> 
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