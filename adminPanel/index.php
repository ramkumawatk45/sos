<?php
ob_start();
if(!empty($_POST['userName']) || !empty($_POST['password']))
{
	include "common/conn.php";	
	 include("class/datalist.php");
}
?>
 <?php
  $error='';
  if(isset($_REQUEST['submit']))
  {
	 	 $username = trim($_REQUEST['username']);
	 	 $password = trim($_REQUEST['password']);
		 $sql="SELECT * FROM user WHERE username='$username' and password='$password' and deleted='0' and status='0'";
		 $result=mysql_query($sql);
		 $userType='';
		 $shopCode='';
		 $branchId='';
		 $userData=fetchData($sql);
		if (is_array($userData) || is_object($userData))
		{
			foreach($userData as $tableData)
			{
				$userType = $tableData['usertype'];
				$shopCode = $tableData['shopCode'];
			}
		}
			if($userType && $shopCode)
			{
				$_SESSION['login_user']= $username;
				$_SESSION['userType'] = $userType;
				$_SESSION['shopCode'] = $shopCode;
				header("location:dashboard.php");
			}	
			else {
		$error="Wrong Username or Password";
				}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--META-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>
<!--STYLESHEETS-->
<link href="css/style_login.css" rel="stylesheet" type="text/css" />
<!--SCRIPTS-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<!--Slider-in icons-->
<script type="text/javascript">
$(document).ready(function() {
	$(".username").focus(function() {
		$(".user-icon").css("left","2px");
	});
	$(".username").blur(function() {
		$(".user-icon").css("left","0px");
	});
	
	$(".password").focus(function() {
		$(".pass-icon").css("left","2px");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","0px");
	});
});
</script>
</head>
<body>
<!--WRAPPER-->
<div id="wrapper">
	<!--SLIDE-IN ICONS-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END SLIDE-IN ICONS-->
<!--LOGIN FORM-->
<form name="login-form" class="login-form" action="" method="post">
	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Log in</h1><!--END TITLE-->
    <!--DESCRIPTION--><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	<!--CONTENT-->
    <div class="content">
	<!--USERNAME--><input name="username" type="text" class="input username" placeholder="Username" onfocus="this.value=''" required="required" /><!--END USERNAME-->
	<!--USERNAME--><input name="loginType" type="hidden" class="input username" value="admin"  /> <!--END USERNAME-->
    <!--PASSWORD--><input name="password" type="password" class="input password" placeholder="Password" onfocus="this.value=''" required="required" /><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    <!--FOOTER-->
    <div class="footer">
	    <span style="color:red; font-size:15px; padding-left:20px; margin-bottom:20px;"><?php echo $error;?> </span>
    <!--LOGIN BUTTON--> <br><input type="submit" name="submit" value="Login" class="button"  /><!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->
</form>
<!--END LOGIN FORM-->
</div>
<!--END WRAPPER-->
<!--GRADIENT--><div class="gradient"></div><!--END GRADIENT-->
</body>
</html>
<?php
 ob_flush();
?>