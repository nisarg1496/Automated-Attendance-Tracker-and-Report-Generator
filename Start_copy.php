<?php
    
    require "connection12.php";
           

    if(isset($_POST["Roll_NO"], $_POST["newString"]))
    {
        $Subject_Name = $_POST["newString"]; //takes the username
        $Roll_No=$_POST["Roll_NO"];

        $result="success";
        $user=array();

if ($Subject_Name=='SC')
                    {
                            $sql2 = "UPDATE class_subjects set SC_Attended=SC_Attended-1 where Roll_No='".$Roll_No."'";
                            $result2=mysqli_query($con,$sql2);

                            if ($con->query($sql2) == TRUE) {
$user['result']="success";
} else {
    echo "Error: " . $sql2 . "<br>" . $con->error;
}
}

if ($Subject_Name=='ERP')
                    {
                            $sql2 = "UPDATE class_subjects set ERP_Attended=ERP_Attended-1 where Roll_No='".$Roll_No."'";
                            $result2=mysqli_query($con,$sql2);

                            if ($con->query($sql2) == TRUE) {
$user['result']="success";
} else {
    echo "Error: " . $sql2 . "<br>" . $con->error;
}


                            
}


if ($Subject_Name=='SNMR')
                    {
                            $sql2 = "UPDATE class_subjects set SNMR_Attended=SNMR_Attended-1 where Roll_No='".$Roll_No."'";
                            $result2=mysqli_query($con,$sql2);

                            if ($con->query($sql2) == TRUE) {
$user['result']="success";
} else {
    echo "Error: " . $sql2 . "<br>" . $con->error;
}
}

if ($Subject_Name=='BDA')
                    {
                            $sql2 = "UPDATE class_subjects set BDA_Attended=BDA_Attended-1 where Roll_No='".$Roll_No."'";
                            $result2=mysqli_query($con,$sql2);

                            if ($con->query($sql2) == TRUE) {
$user['result']="success";
} else {
    echo "Error: " . $sql2 . "<br>" . $con->error;
}

    }

 if ($Subject_Name=='CSM')
                    {
                            $sql2 = "UPDATE class_subjects set CSM_Attended=CSM_Attended-1 where Roll_No='".$Roll_No."'";
                            $result2=mysqli_query($con,$sql2);

                            if ($con->query($sql2) == TRUE) {
$user['result']="success";
} else {
    echo "Error: " . $sql2 . "<br>" . $con->error;
}
      // mysqli_stmt_close($stmt);
        //mysqli_query($con,$sql2);
       
 
  }

  echo json_encode($user);

        mysqli_close($con);

}
    ?>



