<?php error_reporting( E_ALL ); ob_start(); ?>
<?php
 include("conn.php");
 include("sms.php");
 include("constant.php");
 include("class/datalist.php");
 include("session.php");

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/style.css">   
	<link rel="stylesheet" href="bootstrap/css/bootstrap-iso.css" />
	<link rel="stylesheet" href="bootstrap/css/bootstrap-datepicker3.css"/>
	<script src="js/jquery.min.js"></script> 	 
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
          <a href="dashboard.php" class="logo">
          <span class="logo-lg"><b><big>S</big>OS</b></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <!--<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>-->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="btn dropdown-toggle" data-toggle="dropdown">
<!--                  <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
-->                  <span class="glyphicon glyphicon-user"> <?php echo $_SESSION['login_user']; ?></span>
                  <span class="caret"></span>
                  <span class="hidden-xs"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-footer">
                    <div class="pull-left">
                    <?php  $_SESSION['login_user']; ?>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
           
            </ul>
			 <div class="pull-right">
                      <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          
          <!-- search form -->
          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            
            <li class="active treeview">
            
		
                  <a href="#">
                    <!--<i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>-->
                  </a>
              <ul class="treeview-menu">
               <li class="index <?php if(basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php'){echo 'active'; }else { echo basename($_SERVER['SCRIPT_NAME']); } ?>"><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			   <li class="index <?php if(basename($_SERVER['SCRIPT_NAME']) == 'changePassword.php'){echo 'active'; }else { echo basename($_SERVER['SCRIPT_NAME']); } ?>"><a href="changePassword.php"><i class="fa fa-bars"></i> Change Password</a></li>	 
				<li class="groups  <?php if(basename($_SERVER['SCRIPT_NAME']) == 'groups.php'){echo 'active'; }else { echo basename($_SERVER['SCRIPT_NAME']); } ?>" ><a href="groups.php"><i class="fa fa-paperclip"></i>Groups</a></li>
				<li class="uploadItem  <?php if(basename($_SERVER['SCRIPT_NAME']) == 'uploadItem.php'){echo 'active'; }else { echo basename($_SERVER['SCRIPT_NAME']); } ?>" ><a href="uploadItem.php"><i class="fa fa-paperclip"></i>Upload Items</a></li>
				<li class="items  <?php if(basename($_SERVER['SCRIPT_NAME']) == 'items.php'){echo 'active'; }else { echo basename($_SERVER['SCRIPT_NAME']); } ?>" ><a href="items.php"><i class="fa fa-paperclip"></i>Items</a></li>
				<li class="bill  <?php if(basename($_SERVER['SCRIPT_NAME']) == 'bill.php'){echo 'active'; }else { echo basename($_SERVER['SCRIPT_NAME']); } ?>" ><a href="bill.php"><i class="fa fa-paperclip"></i>Generate Bill</a></li>
               </ul>  
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
	 <div id="overlay"><div><img src="images/loading.gif" width="64px" height="64px"/></div></div>
<style>
.logo-lg img {
    width: 50%;
    height:auto ;
}
ol.breadcrumb-student {
    list-style: none;
    text-align: center;
    font-size: 20px;
}
.card.card-block.studentCard {
    border: 1px solid #ccc;
    border-radius: 5px;
    float: left;
    margin-bottom: 10px;
    padding: 0 10px 10px;
    width: 100%;
}
h3.title {
    font-size: 21px;
    font-family: Roboto-Medium;
    text-align: center;
	color:#fff;
}
p.titleDes {
 	color: #2c3b41;
    font-family: CALIST_1;
    font-size: 16px;
    text-align: justify;
}
.studentCard a.btn {
    margin: 0;
}
ol.breadcrumb-student li {
    float: left;
    padding: 0 0 5px;
    width: 7%;
}
.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {
    background-color: #00588D;
}
.skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a {
    color: #fff;
    background: #00588D;
    border-left-color: #00588D;
}
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.0);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 13px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

table.dataTable thead th, table.dataTable thead td {
    padding: 4px 4px;
    border-bottom: 1px solid #111;
}

div.dt-buttons {
    position: relative;
    float: right;
}
.dataTables_wrapper .dataTables_filter {
    float: left;
    text-align: right;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    box-sizing: border-box;
    display: inline-block;
    min-width: 1.5em;
    padding: 0em 0em;
    margin-left: 2px;
    text-align: center;
    text-decoration: none !important;
    cursor: pointer;
    color: #333 !important;
    border: 1px solid transparent;
    border-radius: 2px;
}
table.dataTable.select tbody tr,
table.dataTable thead th:first-child {
  cursor: pointer;
}
body {
    font-size: 12px;
}
.sidebar {
    padding-bottom: 8px;
    padding-top: 0px;
    margin-top: -22px;
}
.skin-blue .treeview-menu>li.active>a, .skin-blue .treeview-menu>li>a:hover {
    color: #fff;
    background: #3071a8;
    border-left: 3px solid #fff;
}
.sidebar-menu .treeview-menu>li>a {
    padding: 8px 0px 8px 15px;
    display: block;
    font-size: 14px;
}
.link {padding: 10px 15px;background: transparent;border:#bccfd8 1px solid;border-left:0px;cursor:pointer;color:#607d8b}
.disabled {cursor:not-allowed;color: #bccfd8;}
.current {background: #bccfd8;}
.first{border-left:#bccfd8 1px solid;}
.question {font-weight:bold;}
.answer{padding-top: 10px;}
#pagination{margin-top: 20px;padding-top: 30px;border-top: #F0F0F0 1px solid;}
.dot {padding: 10px 15px;background: transparent;border-right: #bccfd8 1px solid;}
#overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left: 0;top: 0;width: 100%;height: 100%;display: none;}
#overlay div {position:absolute;left:50%;top:50%;margin-top:-32px;margin-left:-32px;}
.page-content {padding: 20px;margin: 0 auto;}
.pagination-setting {padding:10px; margin:5px 0px 10px;border:#bccfd8  1px solid;color:#607d8b;}
.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
}
.bill-box-section 
{
	height:375px;
	overflow:auto;
}
select.bs-select-hidden, select.selectpicker 
{
    display: block!important;
}
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 250px;
    float: right;
    margin-top: -25px;
}
div.itemSelect
{
	width:80px;
}
.selectItemDiv
{	
    float: right;
    margin-top: -25px;
}
.selectItemDiv select
{
	border-radius:5px;
	width: 280px;
	font-size: 15px;
}	
a.add-new-item {
    font-size: 16px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 4px;
    color: #fff;
    background: #00588D;
    line-height: 40px;
}
</style>
