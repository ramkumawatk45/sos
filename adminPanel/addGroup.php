<?php
include("controller/pages_controller.php");
$menuType =+"gallery";
$msg='';
$pageHrefLink='';
if(isset($_REQUEST['addGroup']))
{
	 $groupName = $_REQUEST['groupName'];
	 $groupPercentage = $_REQUEST['groupPercentage'];
	 $groupDescription = $_REQUEST['groupDescription'];
	 $status = $_REQUEST['status'];
	 date_default_timezone_set('UTC');
	 $cDate = date('Y-m-d H:i:s');
	 $sql = "select groupName from groups where groupName='$groupName' and deleted ='0' ";
	 $res = mysql_query($sql);
		if(mysql_num_rows($res))
		{
		$msg="Group ".$groupName." Already exists.";
		}
		else
		{
		$sql=mysql_query("INSERT INTO groups(groupName,groupPercentage,groupDescription,status,groupCdate) VALUES('$groupName','$groupPercentage','$groupDescription','$status' ,'$cDate')");
		$msg="Data Sucessfully Submited";
		$pageHrefLink="groups.php";

		}
}

?>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
    	<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
            	<div class="box box-primary">
                	<div class="box-header with-border">
                  		<h3 class="box-title">Group Details</h3>
                	</div><!-- /.box-header -->
                <!-- form start -->
                <form role="form"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">
                 <div class="box-body">
					<div class="form-group col-md-6">
                        <label for="pageTitle">Group Name</label>
                        <input type="text" class="form-control" id="groupName" name="groupName" placeholder="Group Name" maxlength="50" required />                   
                     </div>
                    <div class="form-group col-md-6">
                      <label for="pageTitle">Group profit(%)  </label>
                      <input type="text" class="form-control" id="groupPercentage" name="groupPercentage" placeholder="Group profit percentage  " maxlength="3" required />                  
                    </div>
					<div class="form-group col-md-12">
                      <label for="pageTitle">Description</label>
                      <textarea class="form-control" id="groupDescription" name="groupDescription" placeholder="Description " maxlength="100"  required></textarea>                  
                    </div>
                        <div class="form-group col-md-12">
                        <label>Status</label>
                        <select class="form-control" name="status">
                        <option value="0">Enabled </option>
                        <option value="1" >Disabled</option>
                        </select>
                        </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="addGroup">Submit</button>
                  </div>
				  
                </form>
              </div><!-- /.box -->
            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>   
</div>
      <!-- /.content-wrapper -->
<?php include("common/adminFooter.php");?>