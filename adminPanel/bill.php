 <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-select.min.css" />
	<script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-select.min.js"></script>
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
function deleteRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}	
function appendNewRow()
{
	var itemList = "<select class='selectpicker' data-show-subtext='true' data-live-search='true' placeholder='Type or click to select an item' id='itemName' name='itemName'><option>Type or click to select an item</option>";
	itemList = itemList+"</select>";
	$("#itemList").append("<tr><td class='col-md-1'></td> <td class='col-md-4'>"+itemList+"</td><td class='col-md-2'><input class='form-control digitsOnly' value='1.00' type='text' name='itemQuantity' id='itemQuantity'/></td><td class='col-md-2'><input class='form-control digitsOnly' value='0.00' type='text' name='itemRate' id='itemRate'/></td><td class='col-md-2'><input class='form-control digitsOnly' value='0.00' type='text' name='itemTotalAmount' id='itemTotalAmount' readonly/></td><td class='col-md-1'><a onclick='javascript:deleteRow(this);'><span class='glyphicon glyphicon-remove'></span></a></td></tr>");
	return false;
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
function setItemValues(ele)
{
	if($("#billType").val() =="retail")
	{
		$(".itemRate_1").val($(ele).val());
		$(".itemTotalAmount_1").val(parseFloat($(".itemQuantity_1").val()*($(ele).val())));
	}	
}
</script>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
    	<div class="row">
            <!-- left column -->
            <div class="col-md-12 ">
              <!-- general form elements -->
            	<div class="box box-primary">
                	<div class="box-header with-border">
                  		<h3 class="box-title">New Bill</h3>
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
                 <div class="box-body ">
					<div class="form-group col-md-3">
                        <label for="pageTitle">Vendor Name</label>
                        <input type="text" class="form-control" id="vendorName" name="vendorName" placeholder="Vendor Name" maxlength="50" value="<?php if($edit) echo $pageData['vendorName']; ?>" required />                   
                     </div>
					  <div class="form-group col-md-3">
                        <label for="pageTitle">Bill Date</label>
                        <input type="text" class="form-control date" id="billDate" name="billDate" placeholder="Bill Date" maxlength="15" value="<?php if($edit) echo $pageData['billDate']; ?>"  />                   
                     </div>
					 <div class="form-group col-md-3">
                        <label>Bill Type</label>
                        <select class="form-control" name="billType" id="billType">
                        <option value="retail" >Retail Bill</option>
                        <option value="wholesale" >Whole Sale Bill</option>
                        </select>
                        </div>
					 <div class="form-group col-md-3">
                        <label for="pageTitle">Bill #</label>
                        <input type="text" class="form-control" id="billId" name="billId" placeholder="Bill Id" maxlength="15" value="<?php if($edit) echo $pageData['itemCode']; ?>"  />                   
                     </div>
					  <table id="category" class="table table-bordered table-striped">
						<thead>
						  <tr>
							<th class="col-md-1">Sr. no.</th>
							<th class="col-md-4">ITEMS & DESCRIPTION</th>
							<th class="col-md-2">QUANTITY</th>
							<th class="col-md-2">RATE</th>
							<th class="col-md-2">AMOUNT </th>
							<th class="col-md-1"></th>
						  </tr>
						</thead>
						<tbody id="itemList">
						<tr>
						<td class='col-md-1'>1</td> 
						<td class='col-md-4'>
						<select class="selectpicker" data-show-subtext="true" data-live-search="true" placeholder='Type or click to select an item' id='itemName' name='itemName' onchange="setItemValues(this)">
						   <option>Type or click to select an item</option>
						   <?php 
							$query="SELECT * FROM items where deleted='0' ";
							$pageData=fetchData($query);
							$datainfo ='';
							if (is_array($pageData) || is_object($pageData))
							{
								foreach($pageData as $tableData)
								{
								?>
									<option value="<?php echo $tableData['id']; ?>" alt="<?php echo $tableData['itemUnit']; ?>" brate="<?php echo $tableData['itemBrate']; ?>" arate="<?php echo $tableData['itemArate']; ?>"><?php echo $tableData['itemName']; ?></option>
								<?php 	
								} 
							
							} 
						?>	
						 </select>
						</td>
						<td class='col-md-2'><input class='form-control itemQuantity_1 digitsOnly' value='1.00' type='text' name='itemQuantity' id='itemQuantity'/></td>
						<td class='col-md-2'><input class='form-control itemRate_1 digitsOnly' value='0.00' type='text' name='itemRate' id='itemRate'/></td>
						<td class='col-md-2'><input class='form-control itemTotalAmount_1 digitsOnly' value='0.00' type='text' name='itemTotalAmount' id='itemTotalAmount' readonly/></td>
						<td class='col-md-1'><a onclick='javascript:deleteRow(this);'><span class='glyphicon glyphicon-remove'></span></a></td></tr>
						
						 </tbody>
                  </table>
                    <a onclick="appendNewRow()"><small><i class="icon-plus"></i></small> Add another line</a>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
					 <table id="category" class="table table-bordered table-striped">
					 <tr>
						<td class='col-md-6'>&nbsp;</td>
						<td class='col-md-6'><span> Sub total </span> <span class="pull-right"><input type='text' class='form-control digitsOnly' value="0.00" readonly /></span></td>
					 </tr>
					  <tr>
						<td class='col-md-6'>&nbsp;</td>
						<td class='col-md-6'><span><input type='text' class='digitsOnly' placeholder="Discount" /> </span>  <span> <input type='text' placeholder="" class='digitsOnly' /> </span><span class="pull-right"><input type='text' value="0.00" class='form-control digitsOnly' readonly /></span></td>
					 </tr>
					 <tr>
						<td class='col-md-6'>&nbsp;</td>
						<td class='col-md-6'><span> Total </span> <span class="pull-right"><input type='text' class='form-control digitsOnly' value="0.00" readonly /></span></td>
					 </tr>
					</table>		
                  </div>
				  
                </form>
              </div><!-- /.box -->
            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section>   
</div>
<div class="row">
      
    
    </div>
      <!-- /.content-wrapper -->
<?php include("common/adminFooter.php");?>