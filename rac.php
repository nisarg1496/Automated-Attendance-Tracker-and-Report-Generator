 <?php

    require('connection12.php');
    
    	//$val  $_GET['code']


    $uid = $_GET['code'];
    echo $uid;
    $sql1= "SELECT Boolean from student_rfid where Rfid_No = '$uid'";
    $result=mysqli_query($con,$sql1);
    if($result)
    {
    	echo "successful";
    	//echo $result;
    }
    else
    	echo "mysqli_error($con)";

   /* if (!$sql1) 
    {
    	echo 'Could not run query: ' . mysql_error();
    	exit;
	}
	$row = mysql_fetch_row($sql1);
    $result=$row['0'];
    echo $result;*/
    	//$con->query($sql1);
    	//mysqli_query($con,$sql1);
    if ($result->num_rows > 0)
    	{
    		 while($row = $result->fetch_assoc())
    		 {
    		 	if($row["Boolean"]==0)
      			{
      		 		$sql5= "UPDATE student_rfid set Boolean = 1 where Rfid_No='$uid' " ;
             		mysqli_query($con,$sql5);
             		echo "succesful";
        		}
        		else
        		{
	        	$sql2="UPDATE student_rfid set Boolean = 0 where Rfid_No='$uid'" ;
             	mysqli_query($con,$sql2);
             	echo "succesful";
        		}
        	}
        }
mysqli_close($con);

    
?>
    