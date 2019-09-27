

<?php

   // require "connection.php";
        require('connection12.php');

    
if(isset($_POST["name"], $_POST["password"]))
    {     
 
    $name = $_POST["name"]; //takes the username
       //$name _PO_POSTST="admin";
        $password = $_POST["password"];  //takes the password
      //$password = "pass";
        
      
        mysqli_stmt_init($con);

        // if($con)
        //   echo "true";
        // else
        //   echo "false";
        $stmt=mysqli_prepare($con,"SELECT Faculty_Name, password FROM teacher_subject WHERE Faculty_Name= ? AND   password= ?");

        $executedata=mysqli_stmt_bind_param($stmt,"ss",$name,$password);

        mysqli_stmt_execute($stmt);
       // mysqli_stmt_POST_result($stmt);
        mysqli_stmt_bind_result($stmt,$name1,$password1);
        $user=array();
// if($name1==NULL)
// {
//     echo "invalid user";
// }
// else{

        if(mysqli_stmt_fetch($stmt))
        {
           
           
            $user['result']="success";

        }
        else{

            $user['result']="failed";
        }
        
       // echo json_encode($user);
        mysqli_stmt_close($stmt);
  //sql query used for checking login
        
        }

        else
          echo "stop";
        
        // if(!mysqli_num_rows($result1) > 0 ) // check if the number of row return is not greater than 1
        // {
            
        //     echo "invalid user";      // print invalid user
        // }
 // 

      $stmt = $con->prepare("SELECT Subject_Name FROM teacher_subject where Faculty_Name='$name' ;");
    
    //executing the query 
    $stmt->execute();
    
    //binding results to the query 
    $stmt->bind_result($Subject_Name);
    
    $products = array(); 

    while($stmt->fetch()){
        // $temp['Subject_Name'] = $Subject_Name; 
                    $user['Subject_Name']=$Subject_Name;

        // array_push($products, $temp);
    }
    
    //displaying the result in json format 
    echo json_encode($user);



mysqli_close($con);


?>
