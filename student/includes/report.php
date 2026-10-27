<?php
session_start();
require_once __DIR__ . '/../conn.php';

/** @var mysqli $conn */
?>
<html>
	<head>
	<SCRIPT LANGUAGE="JavaScript"> 
if (window.print) {
document.write('<form><input type=button name=print value="Print" onClick="window.print()"></form>');
}
</script>
	</head>
	
	<body>
		
		<div align='center'><img width='200' height='150' src='logo.jpg'></div><div align='center' style='margin-top:20px;'>DE OCAMPO MEMORIAL MEDICAL CENTER<br>2921 Nagtahan St. Sta. Mesa Manila</div></div><br>
		<div align='center'>Nurse Listing:</div><br>
		<div align='center' width='600px' style='margin-top:30px;'>
		<table border="2" align='center' width='1000'>
		<tr>
				<td width="100" align="center"><b>Nurse Num</b></td>
             	<td width="200" align="center"><b>Nurse Name</b></td>
				<td width="100" align="center"><b>Shift</b></td>
             	<td width="300" align="center"><b>Rest Days</b></td>
				
			
          </tr>
              <tbody>
			  <?php
			
				$queryrequest=mysqli_query($conn, "SELECT * FROM nurse_tbl");
				while($rowshift=mysqli_fetch_array($queryrequest))
				{
				echo	"<tr>";
				echo	"<td>$rowshift[nurse_num]</td>";
				echo	"<td>$rowshift[nurse_fname] $rowshift[nurse_minitial]. $rowshift[nurse_lname]</td>";
				echo	"<td>$rowshift[nurse_department]</td>";
				
				$querygetoffs=mysqli_query($conn, "SELECT * FROM dayoffs WHERE nurse_num='$rowshift[nurse_num]' AND status='1' LIMIT 1");
				$getoff=mysqli_fetch_array($querygetoffs);
				if(mysqli_num_rows($querygetoffs)==0)
				{
					echo	"<td>No Assigned Schedules Yet</td>";
					echo	"</tr>";
				}
				else
				{
					echo	"<td>$getoff[dayoff1], $getoff[dayoff2], $getoff[dayoff3]<br>
								 $getoff[dayoff4], $getoff[dayoff5], $getoff[dayoff6]<br>
								 $getoff[dayoff7]</td>";
					echo	"</tr>";
				}
				}
			  ?>
			</tbody>
			</table>
		</div>
		<div align='center' style='margin-top:500px;' >
		<form>
			<input type='button' onclick='window.print()'>
		</form>
		</div>
	</body>

</html>