<?php 
 include "common/conn.php";
 include("class/datalist.php");
 $srNo =  $_REQUEST['srNo'];
	$query="SELECT * FROM items where deleted='0' ";
	$pageData=fetchData($query);
	$datainfo ='';
	if (is_array($pageData) || is_object($pageData))
	{
		?>
		<tr class="items" ><td class='col-md-1'> <?php echo $srNo; ?></td> 
		<td class='col-md-4'>
			<div class="itemSelect">
				<input class='form-control itemCode_<?php echo $srNo; ?> digitsOnly' placeholder="Item Code" onkeyup="selectItem(this.id,this.value)" type='text' name='itemCode' id='itemCode_<?php echo $srNo; ?>'/>
			</div>
			<div class="selectItemDiv">
				<select  class="itemSelect_<?php echo $srNo; ?>"  rownumber='<?php echo $srNo; ?>' placeholder='Type or click to select an item' id='itemName_<?php echo $srNo; ?>' name='itemName' onchange="setItemValues(this)">
				<option>Type or click to select an item</option>

				<?php 
				foreach($pageData as $tableData)
				{
				?>
					<option value="<?php echo $tableData['itemCode']; ?>" scrollWidth="<?php echo $tableData['itemUnit']; ?>" scrollBottom="<?php echo $tableData['itemBrate']; ?>" scrollTop="<?php echo $tableData['itemArate']; ?>"><?php echo $tableData['itemName']; ?></option>
				<?php 	
				} 
				?> 
				</select>
			</div>	
		</td>
		<td class='col-md-1'>
			<input class='form-control itemQuantity_<?php echo $srNo; ?> digitsOnly' rownumber='1' value='1' type='text' onkeyup="selectQuan(this,this.value)" name='itemQuantity' id='itemQuantity_<?php echo $srNo; ?>'/>
		</td>
		<td class='col-md-1'>
			<select class="form-control itemUnit_<?php echo $srNo; ?>" rownumber='<?php echo $srNo; ?>' name="itemUnit" id="itemUnit_<?php echo $srNo; ?>" onchange="selectUnit(this,this.value)">
			<option value="KG" >KG</option>
			<option value="GRAM" >GRAM</option>
			 <option value="PCS" >PCS</option>
			</select>
		</td>
		<td class='col-md-2'><input class='form-control itemRate_<?php echo $srNo; ?> digitsOnly' value='0' type='text' name='itemRate' id='itemRate_<?php echo $srNo; ?>' readonly /></td>
		<td class='col-md-2'><input class='form-control itemTotalAmount_<?php echo $srNo; ?> digitsOnly' value='0' type='text'  name='itemTotalAmount' onkeyup="selectAmount(this,this.value)" id='itemTotalAmount_<?php echo $srNo; ?>'/></td>
		<td class='col-md-1'><a onclick='javascript:deleteRow(this);'><span class='glyphicon glyphicon-remove'></span></a></td></tr>
		<?php
	
	} 
?>	