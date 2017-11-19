<?php
include("controller/pages_controller.php");
$menuType =+"gallery";
$msg='';
$pageHrefLink='';
$id="";
if(isset($_REQUEST['id']))
{
	$edit = true;
	$id=$_REQUEST['id'];
}	
if(isset($_REQUEST['addItem']))
{
	 $itemName = trim($_REQUEST['itemName']);
	 $itemCode = trim($_REQUEST['itemCode']);
	 $groupId = trim($_REQUEST['groupId']);
	 $fastSearch = trim($_REQUEST['itemFastSearch']);
	 $itemUnit = trim($_REQUEST['itemUnit']);
	 $itemPrate = round(trim($_REQUEST['pRate']),4);
	 $itemMRPrate = round(trim($_REQUEST['mrpRate']),4);
	 $itemArate = round(trim($_REQUEST['aRate']),4);
	 $itemAper = round(trim($_REQUEST['aPer']),4);
	 $itemBrate = round(trim($_REQUEST['bRate']),4);
	 $itemBper = round(trim($_REQUEST['bPer']),4);
	 $status = $_REQUEST['status'];
	 date_default_timezone_set('UTC');
	 $cDate = date('Y-m-d H:i:s');
	 
			if($_REQUEST['id'] && $edit)
			{
					$sql=mysql_query("update items set itemName='$itemName',itemCode='$itemCode',groupId='$groupId',fastSearch='$fastSearch', itemUnit='$itemUnit', itemPrate='$itemPrate', itemArate='$itemArate', itemAper='$itemAper', itemBrate='$itemBrate',itemBper='$itemBper',itemMRPrate='$itemMRPrate',status='$status',updateTimestamp='$cDate' where id='$id'");
					$msg=updated;
			}
			else
			{	
				$sql = "select itemName from items where itemName='$itemName' and deleted ='0' ";
				$res = mysql_query($sql);
				if(mysql_num_rows($res))
				{
					$msg="Items ".$itemName." Already exists.";
				}
				else
				{
					$sql=mysql_query("INSERT INTO items(itemName,itemCode,groupId,fastSearch,itemUnit,itemPrate,itemArate,itemAper,itemBrate,itemBper,itemMRPrate,status,itemCdate) VALUES('$itemName','$itemCode','$groupId','$fastSearch','$itemUnit','$itemPrate','$itemArate','$itemAper','$itemBrate','$itemBper','$itemMRPrate','$status' ,'$cDate')");
					$msg="Data Sucessfully Submited";
				}	
			}	
				$pageHrefLink="items.php";
}

?>
<script type="text/javascript">

function calculateARate(ele)
{
	var aRate = parseFloat($("#pRate").val()*($(ele).val())/100)+parseFloat($("#pRate").val());
	$("#aRate").val(aRate);
}
function calculateAPer(ele)
{
	$("#errorMsgDiv").addClass("hide");
	if(parseFloat($(ele).val()) > parseFloat($("#pRate").val()))
	{
		var diff = parseFloat($(ele).val()) - parseFloat($("#pRate").val());	
		var aPer = parseFloat(diff/parseFloat($("#pRate").val())*100);
		$("#aPer").val(aPer);
	}
	else
	{
		$("#errorMsgDiv").removeClass("hide");
		$("#errorMsg").text("A Rate should be greater than P Rate");
	}	
}
function calculateBRate(ele)
{
	var aRate = parseFloat($("#pRate").val()*($(ele).val())/100)+parseFloat($("#pRate").val());
	$("#bRate").val(aRate);
}
function calculateBPer(ele)
{
	$("#errorMsgDiv").addClass("hide");
	if(parseFloat($(ele).val()) > parseFloat($("#pRate").val()))
	{
		var diff = parseFloat($(ele).val()) - parseFloat($("#pRate").val());	
		var aPer = parseFloat(diff/parseFloat($("#pRate").val())*100);
		$("#bPer").val(aPer);
	}
	else
	{
		$("#errorMsgDiv").removeClass("hide");
		$("#errorMsg").text("B Rate should be greater than P Rate");
	}	
}		
$(document).ready(function () {
$(".digitsOnly").keypress(function (e) 
{
	$("#errorMsgDiv").addClass("hide");
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57)) 
	 {
        $("#errorMsgDiv").removeClass("hide");
		$("#errorMsg").text("Please use only numeric values.");
         return false;
    }
  });	
});  
</script>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
    	<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
            	<div class="box box-primary">
                	<div class="box-header with-border">
                  		<h3 class="box-title">Item Details</h3>
						<div class="alert alert-warning hide" id="errorMsgDiv">
						<strong>Warning!</strong> <span id="errorMsg"> </span>
						</div>
                	</div><!-- /.box-header -->
                <!-- form start -->
                <form role="form"  action="<?php if($edit) { echo htmlspecialchars($_SERVER['PHP_SELF']).'?id='.$_REQUEST['id']; } else { echo htmlspecialchars($_SERVER['PHP_SELF']); }?>" method="post" enctype="multipart/form-data">
				<?php 
					if($edit) 
					{	
						$query="SELECT * FROM items where id='$id' and deleted='0'";
						$pagesData=fetchData($query);
						foreach($pagesData as $pageData)
						{
						}
					}		
					?>
                 <div class="box-body">
					<div class="form-group col-md-6">
                        <label for="pageTitle">Item Name</label>
                        <input type="text" class="form-control" id="itemName" name="itemName" placeholder="Item Name" maxlength="50" value="<?php if($edit) echo $pageData['itemName']; ?>" required />                   
                     </div>
					 <div class="form-group col-md-6">
                        <label for="pageTitle">Item Code</label>
                        <input type="text" class="form-control" id="itemCode" name="itemCode" placeholder="Item Name" maxlength="15" value="<?php if($edit) echo $pageData['itemCode']; ?>"  />                   
                     </div>
					 <div class="form-group col-md-6">
                        <label for="pageTitle">Group Name</label>
                         <select class="form-control" name="groupId" id="groupId" required>
						<option value="0" >Select Group</option>
						 <?php 
						$query="SELECT * FROM groups where deleted='0' and status='0'";
						$stateData=fetchData($query);
						$selected ="";
						foreach($stateData as $tableData)
						{ if($pageData['groupId'] == $tableData['id']) { $selected  ="selected"; } else {$selected =""; } ?><option <?php echo $selected ; ?>  value="<?php echo $tableData['id']; ?>"><?php  echo $tableData['groupName'] ?></option> <?php } ?>
						  </select>                 
                     </div>
                     <div class="form-group col-md-6">
                      <label for="pageTitle">Item Fast Search  </label>
                      <input type="text" class="form-control" id="itemFastSearch" name="itemFastSearch" placeholder="Item fast search  " maxlength="20" value="<?php if($edit) echo $pageData['fastSearch']; ?>" />  
					 </div>
					 <div class="form-group col-md-6">
                        <label for="pageTitle">P Rate</label>
                        <input type="text" class="form-control digitsOnly" id="pRate" name="pRate" placeholder="P Rate" maxlength="10" required value="<?php if($edit) echo round($pageData['itemPrate'],4); ?>" />                   
                     </div>
					 <div class="form-group col-md-6">
                        <label for="pageTitle">MRP Rate</label>
                        <input type="text" class="form-control digitsOnly" id="mrpRate" name="mrpRate" placeholder="MRP Rate" maxlength="10" required value="<?php if($edit) echo round($pageData['itemMRPrate'],4); ?>"  />                   
                     </div>
					 <div class="form-group col-md-6">
                        <label for="pageTitle">A Rate</label>
                        <input type="text" class="form-control digitsOnly " id="aRate" name="aRate" placeholder="A Rate" maxlength="10" required onkeyup="calculateAPer(this)" value="<?php if($edit) echo round($pageData['itemArate'],4); ?>" />                   
                     </div>
					 <div class="form-group col-md-6">
                        <label for="pageTitle">A %</label>
                        <input type="text" class="form-control digitsOnly" id="aPer" name="aPer" placeholder="A %" maxlength="10" required onkeyup="calculateARate(this)" value="<?php if($edit) echo round($pageData['itemAper'],4); ?>"  />                   
                     </div>
					 <div class="form-group col-md-6">
                        <label for="pageTitle">B Rate</label>
                        <input type="text" class="form-control digitsOnly" id="bRate" name="bRate" placeholder="B Rate" maxlength="10" required onkeyup="calculateBPer(this)" value="<?php if($edit) echo $pageData['itemBrate']; ?>" />                   
                     </div>
					 <div class="form-group col-md-6">
                        <label for="pageTitle">B %</label>
                        <input type="text" class="form-control digitsOnly" id="bPer" name="bPer" placeholder="B %" maxlength="10" required onkeyup="calculateBRate(this)" value="<?php if($edit) echo round($pageData['itemBper'],4); ?>"  />                   
                     </div>
					  <div class="form-group col-md-6">
                        <label for="pageTitle">Item Unit</label>
                        <input type="text" class="form-control" id="itemUnit" name="itemUnit" placeholder="Item unit" maxlength="30" required  value="<?php if($edit) echo $pageData['itemUnit']; ?>"  />                   
                     </div>
                        <div class="form-group col-md-6">
                        <label>Status</label>
                        <select class="form-control" name="status">
						<?php $status=$pageData['status']; ?>
                        <option value="0" <?php if($status ==0) echo 'selected'; ?>>Enabled </option>
                        <option value="1" <?php if($status ==1) echo 'selected'; ?> >Disabled</option>
                        </select>
                        </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="addItem">Submit</button>
                  </div>
				  
                </form>
              </div><!-- /.box -->
            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>   
</div>
      <!-- /.content-wrapper -->
<?php include("common/adminFooter.php");?>