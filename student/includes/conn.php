<?php
error_reporting(E_ALL ^ E_DEPRECATED);
	//CONNECTING HOST
$conn = mysqli_connect("localhost", "root", "");
//CONNECTING DATABASE
mysqli_select_db($conn, "online_enroll");