<?php
include("controller/pages_controller.php");
$menuType =+"viewPages";
$id=$_REQUEST['id'];
$msg='';
if(isset($_REQUEST['editGroup']))
{
	$groupName = $_REQUEST['groupName'];
	$groupPercentage = $_REQUEST['groupPercentage'];
	$groupDescription = $_REQUEST['groupDescription'];
	$status = $_REQUEST['status'];
	date_default_timezone_set('UTC');
	$updateTimestamp = date('Y-m-d H:i:s');
	$sql=mysql_query("update groups set groupName='$groupName',groupPercentage='$groupPercentage',groupDescription='$groupDescription', status='$status',updateTimestamp='$updateTimestamp' where id='$id'");
	$msg=updated;
	$pageHrefLink="groups.php";
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
                <form role="form"  action="<?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                	<?php $query="SELECT * FROM groups where id='$id' and deleted='0'";
					$pagesData=fetchData($query);
					foreach($pagesData as $pageData)
					?>
                  <div class="box-body"> 
				  <div class="form-group col-md-6">
                        <label for="pageTitle">Group Name</label>
                        <input type="text" class="form-control" id="groupName" name="groupName" value="<?php echo $pageData['groupName']; ?>" maxlength="50" required />                   
                     </div>
                    <div class="form-group col-md-6">
                      <label for="pageTitle">Group profit(%)  </label>
                      <input type="text" class="form-control" id="groupPercentage" name="groupPercentage" value="<?php echo $pageData['groupPercentage']; ?>" maxlength="3" required />                  
                    </div>
					<div class="form-group col-md-12">
                      <label for="pageTitle">Description</label>
                      <textarea class="form-control" id="groupDescription" name="groupDescription" placeholder="Description " maxlength="100"  required><?php echo $pageData['groupDescription']; ?></textarea>                  
                    </div>
					<div class="form-group col-md-12">
                      <label>Status</label>
                      <select class="form-control" name="status">
                      <?php $status=$pageData['status'];
					   ?>
					  <option value="0"<?php if($status ==0) echo 'selected'; ?>>Enabled</option>
    				<option value="1"<?php if( $status == 1) echo 'selected'; ?>>Disabled</option>
                      </select>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="editGroup">Update</button>
                  </div>
                </form>
              </div><!-- /.box -->



            </div><!--/.col (left) -->

          </div>   <!-- /.row -->
        </section>      
</div>
      <!-- /.content-wrapper -->
<?php include("common/adminFooter.php");?>
<script>
CKEDITOR.replace('editor1', {
"filebrowserImageUploadUrl": "<?php echo BaseUrl;?>admin/plugins/ckeditor/plugins/imgupload.php",
"filebrowserBrowseUrl": "<?php echo BaseUrl;?>admin/plugins/ckeditor/plugins/imgupload.php",
"filebrowserUploadUrl": "<?php echo BaseUrl;?>admin/plugins/ckeditor/plugins/imgupload.php"
});
</script>
