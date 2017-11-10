<?php
include("controller/pages_controller.php");
?>
<?php
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
require('common/conn.php');
$msg = '';	
if(isset($_POST['Submit']))
{
	$groupId = $_REQUEST['groupId'];
	$mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']; 
	if(in_array($_FILES["file"]["type"],$mimes))
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
		move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
		$Reader = new SpreadsheetReader($uploadFilePath);
		$totalSheet = count($Reader->sheets());
		/* For Loop for all sheets */
		for($i=0;$i<$totalSheet;$i++) 
		{
			$Reader->ChangeSheet($i);
			foreach ($Reader as $Row)
	        {
				$itemCode = isset($Row[0]) ? $Row[0] : '';
				$itemName = isset($Row[1]) ? $Row[1] : '';
				$itemUnit = isset($Row[2]) ? $Row[2] : '';
				$itemPrate = isset($Row[3]) ? $Row[3] : '';
				$itemArate = isset($Row[4]) ? $Row[4] : '';
				$itemBrate = isset($Row[5]) ? $Row[5] : '';
				$itemMRPrate = isset($Row[6]) ? $Row[6] : '';
				
				$query = "insert into items(itemCode,groupId,itemName,itemUnit,itemPrate,itemArate,itemBrate,itemMRPrate) values('".$itemCode."','".$groupId."','".$itemName."',	'".$itemUnit."','".$itemPrate."','".$itemArate."','".$itemBrate."','".$itemMRPrate."')";
				mysql_query($query);	
	        }
		}
		$msg = "Data Inserted in database";

	}
	else 
	{ 
		$msg = "Sorry, File type is not allowed. Only Excel file."; 
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
               <form method="POST"  enctype="multipart/form-data">
			   <div class="form-group col-md-12">
					<label>Group Name</label>
					<select class="form-control" name="groupId" id="groupId" required >
						<?php 
                    	$query="SELECT * FROM groups where deleted='0' and status='0' ";
						$menuData=fetchData($query);
						foreach($menuData as $tableData)
						{ ?><option  value="<?php echo $tableData['id']; ?>"><?php  echo $tableData['groupName']; ?></option>	<?php } ?>
						</select>
				</div>		
				<div class="form-group col-md-12">
					<label>Upload Excel File</label>
					<input type="file" name="file" class="form-control" required>
				</div>
				<div class="form-group">
					<button type="submit" name="Submit" class="btn btn-primary">Upload</button>
				</div>
				</form>          
				</div><!-- /.box -->
            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>   
</div>
      <!-- /.content-wrapper -->
<?php include("common/adminFooter.php");?>