


<?php
    require('connection12.php');
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,"SELECT Roll_No,ERP_Attended,CSM_Attended,BDA_Attended,SNMR_Attended FROM class_subjects");
while($row1 = mysqli_fetch_array($result1))
{
	$rollno = $row1['Roll_No'];
	$erpatt = $row1['ERP_Attended'];
	$csmatt = $row1['CSM_Attended'];
	$bdaatt = $row1['BDA_Attended'];
	$snmratt = $row1['SNMR_Attended'];

	$result2 = mysqli_query($con,"SELECT Lectures_Taken FROM subject_lecturetaken WHERE Subject_Name = 'ERP'" );
	$row2 = mysqli_fetch_array($result2);
	$erptak = $row2['Lectures_Taken'];

	$result3 = mysqli_query($con,"SELECT Lectures_Taken FROM subject_lecturetaken WHERE Subject_Name = 'CSM'" );
	$row3 = mysqli_fetch_array($result3);
	$csmtak = $row3['Lectures_Taken'];

	$result4 = mysqli_query($con,"SELECT Lectures_Taken FROM subject_lecturetaken WHERE Subject_Name = 'BDA'" );
	$row4 = mysqli_fetch_array($result4);
	$bdatak = $row4['Lectures_Taken'];

	$result5 = mysqli_query($con,"SELECT Lectures_Taken FROM subject_lecturetaken WHERE Subject_Name = 'SNMR'" );
	$row5 = mysqli_fetch_array($result5);
	$snmrtak = $row5['Lectures_Taken'];

	$erpper = ($erpatt / $erptak) * 100;
	$csmper = ($csmatt / $csmtak) * 100;
	$bdaper = ($bdaatt / $bdatak) * 100;
	$snmrper = ($snmratt / $snmrtak) * 100; 

	$sql9 = "UPDATE attendance_report SET ERP_Attended = '$erpatt', ERP_Lectures = '$erptak', ERP_Percentage = '$erpper', CSM_Attended = '$csmatt', CSM_Lectures = '$csmtak', CSM_Percentage = '$csmper', BDA_Attended = '$bdaatt', BDA_Lectures = '$bdatak', BDA_Percentage = '$bdaper', SNMR_Attended = '$snmratt', SNMR_Lectures = '$snmrtak', SNMR_Percentage = '$snmrper' WHERE Roll_No = '$rollno'";
	if(mysqli_query($con,$sql9))
		{echo "Record Inserted Successfully";}
	else{
    echo "ERROR: Could not able to execute $sql9. ";
}

}

$result = mysqli_query($con,"SELECT * FROM attendance_report");

echo "<table border='1'>
<tr>
<th>Roll_No</th>

<th>ERP_Attended</th>
<th>ERP_Lectures</th>
<th>ERP_Percentage</th>

<th>CSM_Attended</th>
<th>CSM_Lectures</th>
<th>CSM_Percentage</th>

<th>BDA_Attended</th>
<th>BDA_Lectures</th>
<th>BDA_Percentage</th>

<th>SNMR_Attended</th>
<th>SNMR_Lectures</th>
<th>SNMR_Percentage</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['Roll_No'] . "</td>";

echo "<td>" . $row['ERP_Attended'] . "</td>";
echo "<td>" . $row['ERP_Lectures'] . "</td>";
echo "<td>" . $row['ERP_Percentage'] . "</td>";

echo "<td>" . $row['CSM_Attended'] . "</td>";
echo "<td>" . $row['CSM_Lectures'] . "</td>";
echo "<td>" . $row['CSM_Percentage'] . "</td>";

echo "<td>" . $row['BDA_Attended'] . "</td>";
echo "<td>" . $row['BDA_Lectures'] . "</td>";
echo "<td>" . $row['BDA_Percentage'] . "</td>";

echo "<td>" . $row['SNMR_Attended'] . "</td>";
echo "<td>" . $row['SNMR_Lectures'] . "</td>";
echo "<td>" . $row['SNMR_Percentage'] . "</td>";

echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>