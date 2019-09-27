<?php
    
    require "connection12.php";
    
    if(isset($_POST["Subject_Name"]))
    {
        $Subject_Name = $_POST["Subject_Name"]; //takes the username
      
        $boolean=1;
        $count=0;
        
        //  $sql="INSERT INTO  package_train_mapping values (,b,123,0,,)";
        
      

    $sql1="UPDATE subject_lecturetaken set Lectures_Taken=Lectures_Taken+1 where Subject_Name='$Subject_Name'";
                    $result=mysqli_query($con,$sql1);
                    // if($result)
                    // {
                    //     echo "success";
                    // }

                    // else
                    //     echo "mysqli_error($con)";

                    if ($Subject_Name=='SC')
                    {
                            $sql2 = "SELECT * FROM student_rfid where Boolean='".$boolean."'";
                            $result2=mysqli_query($con,$sql2);

//                             if ($con->query($sql2) == TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql2 . "<br>" . $con->error;
// }


                            $array = array();

// look through query
while($row = mysqli_fetch_array($result2)){

  // add each row returned into an array
$sql3="UPDATE class_subjects set SC_Attended=SC_Attended+1 where Roll_No='".$row['Roll_No']."'";
                            $result3=mysqli_query($con,$sql3);

  $count++;
  // echo $row['Roll_No']; // etc
  // echo "<br>";

}

// debug:

}   






 if ($Subject_Name=='ERP')
                    {
                            $sql2 = "SELECT * FROM student_rfid where Boolean='".$boolean."'";
                            $result2=mysqli_query($con,$sql2);

//                             if ($con->query($sql2) == TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql2 . "<br>" . $con->error;
// }


                            $array = array();

// look through query
while($row = mysqli_fetch_array($result2)){

  // add each row returned into an array
$sql3="UPDATE class_subjects set ERP_Attended=ERP_Attended+1 where Roll_No='".$row['Roll_No']."'";
                            $result3=mysqli_query($con,$sql3);

  $count++;
  // echo $row['Roll_No']; // etc
  // echo "<br>";

}

// debug:

}




if ($Subject_Name=='CSM')
                    {
                            $sql2 = "SELECT * FROM student_rfid where Boolean='".$boolean."'";
                            $result2=mysqli_query($con,$sql2);

                            // if ($con->query($sql2) == TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql2 . "<br>" . $con->error;
// }


                            $array = array();

// look through query
while($row = mysqli_fetch_array($result2)){

  // add each row returned into an array
$sql3="UPDATE class_subjects set CSM_Attended=CSM_Attended+1 where Roll_No='".$row['Roll_No']."'";
                            $result3=mysqli_query($con,$sql3);

  $count++;
  // echo $row['Roll_No']; // etc
  // echo "<br>";

}

// debug:

}    




if ($Subject_Name=='BDA')
                    {
                            $sql2 = "SELECT * FROM student_rfid where Boolean='".$boolean."'";
                            $result2=mysqli_query($con,$sql2);

//                             if ($con->query($sql2) == TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql2 . "<br>" . $con->error;
// }


                            $array = array();

// look through query
while($row = mysqli_fetch_array($result2)){

  // add each row returned into an array
$sql3="UPDATE class_subjects set BDA_Attended=BDA_Attended+1 where Roll_No='".$row['Roll_No']."'";
                            $result3=mysqli_query($con,$sql3);

  $count++;
  // echo $row['Roll_No']; // etc
  // echo "<br>";

}

// debug:

}                




if ($Subject_Name=='SNMR')
                    {
                            $sql2 = "SELECT * FROM student_rfid where Boolean='".$boolean."'";
                            $result2=mysqli_query($con,$sql2);

//                             if ($con->query($sql2) == TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql2 . "<br>" . $con->error;
// }


                            $array = array();

// look through query
while($row = mysqli_fetch_array($result2)){

  // add each row returned into an array
$sql3="UPDATE class_subjects set SNMR_Attended=SNMR_Attended+1 where Roll_No='".$row['Roll_No']."'";
                            $result3=mysqli_query($con,$sql3);

  $count++;
  // echo $row['Roll_No']; // etc
  // echo "<br>";

}

// debug:

}
// $result9==0;
//  $sql4 = "SELECT * FROM people_inside";
//   $stmt=mysqli_query($con,$sql4);
//   while($row2 = mysqli_fetch_array($stmt))
//     if($count==$row2['people_count'])
// {

//   $stmt->bind_result($result9);
    
//     $user = array(); 

//     while($stmt->fetch()){
//         // $temp['Subject_Name'] = $Subject_Name; 
//                     $user['result']="success";

//         // array_push($products, $temp);
//     }


// }






$stmt = $con->prepare("SELECT * FROM people_inside");
    
    //executing the query 
    $stmt->execute();
    
    //binding results to the query 
    $stmt->bind_result($result9);
    
    $user = array(); 

    while($stmt->fetch()){
        // $temp['Subject_Name'] = $Subject_Name; 
                    $user['people_count']=$result9;

        // array_push($products, $temp);
    }
    if($user['people_count']==$count)

    {
      $user['result']="success";
    }
    else
            $user['result']="fail";

    //displaying the result in json format 


    echo json_encode($user);

    
    //displaying the result in json fo
}


    
      // mysqli_stmt_close($stmt);
        //mysqli_query($con,$sql2);
        mysqli_close($con);
 
  
    ?>



