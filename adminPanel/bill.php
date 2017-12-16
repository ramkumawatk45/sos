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
$i =2;
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
function deleteRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}	
function appendNewRow()
{
	var rows= $('tbody#itemList tr.items').length+1;
	 $.ajax({    //create an ajax request to load_page.php
        type: "GET",
        url: "searchItem.php?srNo="+rows,            
		beforeSend: function(){$("#overlay").show();},	
        dataType: "html",   //expect html to be returned                
        success: function(response)
		{     
			console.log(response);
			$("#itemList").append(response);
			setInterval(function() {$("#overlay").hide(); },500);	
        }
	});
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
	var rowNumber = $(ele).attr("rownumber");
	var aRate = parseFloat($(ele).find("option:selected").attr("scrollTop"));
	var bRate = parseFloat($(ele).find("option:selected").attr("scrollBottom"));
	var unit = $(ele).find("option:selected").attr("scrollWidth");
	var itemCode = $(ele).find("option:selected").val();
	if($("#billType").val() =="retail")
	{
		$(".itemRate_"+rowNumber).val(aRate);
		$(".itemUnit_"+rowNumber).val(unit);
		$(".itemTotalAmount_"+rowNumber).val(parseFloat($(".itemQuantity_"+rowNumber).val()*(aRate)));
		subTotal();	
	}
	else if($("#billType").val() =="wholesale")
	{
		$(".itemRate_"+rowNumber).val(bRate);
		$(".itemUnit_"+rowNumber).val(unit);
		$(".itemTotalAmount_"+rowNumber).val(parseFloat($(".itemQuantity_"+rowNumber).val()*(bRate)));
		subTotal();	
	}	
	$(".itemCode_"+rowNumber).val(itemCode);
}
function selectItem(ele,value)
{
	if(value > 0)
	{	
		var eleArray = ele.split("_");
		$("#itemName_"+eleArray[1]).val(value).change();
		subTotal();	
	}
	else
	{
		 $("#errorMsgDiv").removeClass("hide");
		$("#errorMsg").text("Item code is invalid.");
         return false;
	}	
}
function selectQuan(ele,value)
{
	if(value && value > 0)
	{	
		var eleArray  = $(ele).attr("id");
		var id = eleArray.split("_");
		var rowNumber = id[1];
		var itemRate = $(".itemRate_"+rowNumber).val();
		var itemUnit = $("select#itemUnit_"+rowNumber+" option:selected").val();
		var itemAmount = 0;
		if(itemUnit.toUpperCase() =="GRAM")
		{	
			itemAmount = (value/1000)*itemRate;
		}
		else if(itemUnit.toUpperCase() =="KG")
		{
			itemAmount = value*itemRate;
		}
		else
		{
			itemAmount = value*itemRate;
		}	
		$(".itemTotalAmount_"+rowNumber).val(roundTo(itemAmount,2));
		subTotal();	
	}
	else
	{
		 $("#errorMsgDiv").removeClass("hide");
		$("#errorMsg").text("Could not process.");
         return false;
	}	
}
function selectAmount(ele,value)
{
	var eleArray  = $(ele).attr("id");
	var id = eleArray.split("_");
	var rowNumber = id[1];
	var itemRate = $(".itemRate_"+rowNumber).val();
	var itemUnit = $("select#itemUnit_"+rowNumber+" option:selected").val();
	var itemQuantity = 0;
	if(value && value > 0)
	{	
		if(itemUnit.toUpperCase() =="GRAM")
		{	
			itemQuantity = (value/itemRate)*1000;
		}
		else if(itemUnit.toUpperCase() =="KG")
		{
			itemQuantity = value/itemRate;
		}
		else
		{
			itemQuantity = value/itemRate;
		}	
		$(".itemQuantity_"+rowNumber).val(roundTo(itemQuantity,2));
		subTotal();	
	}
	else
	{
		 $("#errorMsgDiv").removeClass("hide");
		$("#errorMsg").text("Could not process.");
         return false;
	}	
}
function selectUnit(ele,value)
{
	if(value)
	{	
		var rowNumber = $(ele).attr("rownumber");
		var itemRate = $(".itemRate_"+rowNumber).val();
		var itemQuantity = $(".itemQuantity_"+rowNumber).val();
		var itemAmount = 0;
		if(value.toUpperCase() =="GRAM")
		{	
			itemAmount = (itemQuantity/1000)*itemRate;
		}
		else if(value.toUpperCase() =="KG")
		{
			itemAmount = itemQuantity*itemRate;
		}
		else
		{
			itemAmount = itemQuantity*itemRate;
		}	
		$(".itemTotalAmount_"+rowNumber).val(roundTo(itemAmount,2));
	}
	else
	{
		 $("#errorMsgDiv").removeClass("hide");
		$("#errorMsg").text("Could not process.");
         return false;
	}
	subTotal();	
}
function subTotal()
{
	$("#errorMsgDiv").addClass("hide");
	var subTot = 0;
	$('tbody#itemList tr.items').each(function (index, value) 
	{ 
		index = index+1; 
		var subSubTot= $(".itemTotalAmount_"+index).val();
		subTot = roundTo(parseFloat(subTot)+parseFloat(subSubTot),2);
	});
	$("#subTotal").val(subTot);
	$("#errorMsgDiv").addClass("hide");
	var subTotal = $("#subTotal").val();
	var discount = parseFloat(subTotal)-parseFloat($("#billAfterDiscount").val());
	if(subTotal)
	{
		if(parseFloat($("#billAfterDiscount").val()) < parseFloat(subTotal))
		{	
			$("#billAfterDiscount").val(parseFloat($("#billAfterDiscount").val()));
			$("#billTotalAmount").val(roundTo(discount,2));
		}
		else
		{
			$("#errorMsgDiv").removeClass("hide");
			$("#errorMsg").text("Discount not allowed grethar than total amount.Please review the discount amount.");
			return false;
		}
	}	
}	
function billDiscounts(value)
{
	$("#errorMsgDiv").addClass("hide");
	if(value)
	{
		var subTotal = $("#subTotal").val();
		var discount = parseFloat(subTotal)-parseFloat(value);
		if(subTotal)
		{
			if(parseFloat(value) < parseFloat(subTotal))
			{	
				$("#billAfterDiscount").val(parseFloat(value));
				$("#billTotalAmount").val(roundTo(discount,2));
			}
			else
			{
				$("#errorMsgDiv").removeClass("hide");
				$("#errorMsg").text("Discount not allowed grethar than total amount.Please review the discount amount.");
				return false;
			}
		}		
	}
	else
	{
		$("#billAfterDiscount").val('0');
	}	
}	
function roundTo(n, digits) 
{
     if (digits === undefined) {
       digits = 0;
     }

     var multiplicator = Math.pow(10, digits);
     n = parseFloat((n * multiplicator).toFixed(11));
     var test =(Math.round(n) / multiplicator);
     return +(test.toFixed(digits));
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
                        <input type="text" class="form-control" id="vendorName" name="vendorName" value="Cash" placeholder="Vendor Name" maxlength="50" value="<?php if($edit) echo $pageData['vendorName']; ?>" required />                   
                     </div>
					  <div class="form-group col-md-3">
                        <label for="pageTitle">Bill Date</label>
                        <input type="text" class="form-control date" id="billDate" name="billDate" value="<?php echo Date("d/m/Y"); ?>" placeholder="Bill Date" maxlength="15" value="<?php if($edit) echo $pageData['billDate']; ?>"  />                   
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
							<th class="col-md-5">ITEMS & DESCRIPTION</th>
							<th class="col-md-1">QUANTITY</th>
							<th class="col-md-1"></th>
							<th class="col-md-1">RATE</th>
							<th class="col-md-1">AMOUNT </th>
							<th class="col-md-1"></th>
						  </tr>
						</thead>
						<tbody id="itemList">
						<tr class="items">
						<td class='col-md-1'>1</td> 
						<td class='col-md-4'>
						<div class="itemSelect">
						<input class='form-control itemCode_1 digitsOnly' placeholder="Item Code" onkeyup="selectItem(this.id,this.value)" type='text' name='itemCode' id='itemCode_1'/>
						</div>
						<div class="selectItemDiv">
						<select class="itemSelect_1"  rownumber='1' placeholder='Type or click to select an item' id='itemName_1' name='itemName' onchange="setItemValues(this)">
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
									<option value="<?php echo $tableData['itemCode']; ?>" scrollWidth="<?php echo $tableData['itemUnit']; ?>" scrollBottom="<?php echo $tableData['itemBrate']; ?>" scrollTop="<?php echo $tableData['itemArate']; ?>"><?php echo $tableData['itemName']; ?></option>
								<?php 	
								} 
							
							} 
						?>	
						 </select>
						 </div>
						</td>
						<td class='col-md-1'>
						<input class='form-control itemQuantity_1 digitsOnly' rownumber='1' value='1' type='text' onkeyup="selectQuan(this,this.value)" name='itemQuantity' id='itemQuantity_1'/>
						</td>
						<td class='col-md-1'>
						<select class="form-control itemUnit_1" rownumber='1' name="itemUnit" id="itemUnit_1" onchange="selectUnit(this,this.value)">
                        <option value="KG" >KG</option>
                        <option value="GRAM" >GRAM</option>
						 <option value="PCS" >PCS</option>
                        </select>
						</td>
						<td class='col-md-2'><input class='form-control itemRate_1 digitsOnly' value='0' type='text' name='itemRate' id='itemRate_1' readonly /></td>
						<td class='col-md-2'><input class='form-control itemTotalAmount_1 digitsOnly' value='0' type='text'  name='itemTotalAmount' onkeyup="selectAmount(this,this.value)" id='itemTotalAmount_1'/></td>
						<td class='col-md-1'><a onclick='javascript:deleteRow(this);'><span class='glyphicon glyphicon-remove'></span></a></td></tr>
						
						 </tbody>
                  </table>
                    <a onclick="appendNewRow()" class="add-new-item"><small><i class="icon-plus"></i></small> Add another line</a>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
					 <table id="category" class="table table-bordered table-striped">
					 <tr>
						<td class='col-md-6'>&nbsp;</td>
						<td class='col-md-6'><span> Sub total </span> <span class="pull-right"><input type='text' id="subTotal" class='form-control  digitsOnly' value="0.00" readonly /></span></td>
					 </tr>
					  <tr>
						<td class='col-md-6'>&nbsp;</td>
						<td class='col-md-6'><span> Discount </span>  <span> <input type='text' placeholder="" class='digitsOnly' id="billDiscount" onkeyup="billDiscounts(this.value);" /> </span><span class="pull-right"><input type='text' value="0.00" id="billAfterDiscount" class='form-control digitsOnly' readonly /></span></td>
					 </tr>
					 <tr>
						<td class='col-md-6'>&nbsp;</td>
						<td class='col-md-6'><span> Total </span> <span class="pull-right"><input type='text' class='form-control digitsOnly' value="0.00" readonly id="billTotalAmount" /></span></td>
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