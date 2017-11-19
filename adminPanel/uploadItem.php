<?php  ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		error_reporting(E_ALL ^ E_DEPRECATED);
include("controller/pages_controller.php");
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
$msg = '';	
if(isset($_POST['Submit']))
{
	$mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']; 
	if(in_array($_FILES["file"]["type"],$mimes))
	{
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
				$groupName = isset($Row[1]) ? $Row[1] : '';
				$itemName = isset($Row[2]) ? $Row[2] : '';
				$itemUnit = isset($Row[3]) ? $Row[3] : '';
				$itemPrate = isset($Row[4]) ? $Row[4] : '';
				$itemArate = isset($Row[5]) ? $Row[5] : '';
				$itemBrate = isset($Row[6]) ? $Row[6] : '';
				$itemMRPrate = isset($Row[7]) ? $Row[7] : '';
				$groupName = strtoupper($groupName);
				$query="SELECT * FROM groups where groupName='$groupName' and  deleted='0' and status='0' ";
				$menuData=fetchData($query);
				$groupId = "";
				$groupPercentage = "";
				if(is_array($menuData) || is_object($menuData))
				{
					foreach($menuData as $tableData)
					{
						$groupId = $tableData['id'];
						$groupPercentage = $tableData['groupPercentage'];
					}
				}
				$alreadyExit = true;
				$sql = "select itemName from items where itemName='$itemName' and deleted ='0' ";
				$res = mysql_query($sql);
				if(mysql_num_rows($res))
				{
					var_dump("Items ".$itemName." Already exists.");
					$alreadyExit = false;
				}
				else
				{	
				
					$query = "insert into items(itemCode,groupId,itemName,itemUnit,itemPrate,itemArate,itemBrate,itemMRPrate,itemAper,itemBper) values('".$itemCode."','".$groupId."','".$itemName."',	'".$itemUnit."','".$itemPrate."','".$itemArate."','".$itemBrate."','".$itemMRPrate."','".$groupPercentage."','".$groupPercentage."')";
					//var_dump($query);
					if($itemCode && $groupId &&  $itemName &&  $itemUnit &&  $itemPrate && $itemArate && $itemBrate && $itemMRPrate)
					{	
						mysql_query($query);
						if($alreadyExit)
						{	
							$pageHrefLink="uploadItem.php";
						}	
					}	
				}		
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