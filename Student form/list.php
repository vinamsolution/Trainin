<?php
include "MysqlDatabase.php";
include "Student.php";

$database= new MysqlDatabase();
$student  = new Student();
$student->setDebug(1);
$stud=$student->insertStudent($_POST);
$students_list   = $student->stdentList();
?>
<!DOCTYPE html>
<html>
<head>
	<title>LISTING</title>
</head>
<body>
	<?php

	echo "<table border=1>";
	echo "<tr>";
	echo "<th>"; echo "NAME";  echo "</th>";
	echo "<th>"; echo "AGE";  echo "</th>";
	echo "<th>"; echo "GENDER";  echo "</th>";
	echo "</tr>";
	foreach ($students_list as $key => $value) {
		
	 	echo "<tr>";
		echo "<td>"; echo $value["name"];  echo "</td>";
		echo "<td>"; echo $value["age"];  echo "</td>";
		echo "<td>"; echo $value["gender"];  echo "</td>";
		echo "</tr>";
	}
	echo "</table> ";

	?>
</body>
</html>