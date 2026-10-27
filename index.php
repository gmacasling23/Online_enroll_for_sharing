<?php
session_start();
include('conn.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT * FROM usertbl WHERE username = ? AND password = ? LIMIT 1");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check->num_rows == 0) {
        echo "<script>window.alert('User does not exist, please try again.');</script>";
    } else {
        while ($rowval = $check->fetch_array()) {
            if ($rowval['user_type'] == 'admin') {
                // FIX: dati '$rowval[username]' (literal text ang nase-save)
                $_SESSION['username'] = $rowval['username'];
                $_SESSION['type'] = 'admin';
                $_SESSION['logcheck'] = 1;
                echo "<script>window.alert('Successfully log in as Administrator');
                      window.location='Admin/adminindex.php';</script>";
                exit;
            } else {
                $_SESSION['username'] = $rowval['username'];
                $_SESSION['type'] = 'student';
                $_SESSION['logcheck'] = 1;
                $_SESSION['userID'] = $rowval['ID'];
                echo "<script>window.alert('Successfully log in as Student');
                      window.location='student/studentindex.php';</script>";
                exit;
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
<title>LOGIN PAGE</title>

<link href="style.css" rel="stylesheet" type="text/css"/>

</head>
<body>

	<div class="loginForm" align="center">

	<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;System Login</h1>

<form method="POST">
<div style="float:left; margin-top: -40px; margin-left: 40px;">
<img src="logo.jpg" width="160" height="110">
</div>
<div style="margin-left: auto; margin-right: auto;">

	<br>
	<b>Username:</b>
	<input type="text" class="text" required="required" name="username"/>
	<br><br>
	<b>Password :</b>

	<input type="password" class="text" required="required" name="password"/>
	<br><br>
	<input type="submit" name="submit" value="Login" class="btn"/>
</div>
</form>
</div>
</body>
</html>