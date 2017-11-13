<?php
include("controller/pages_controller.php");
$menuType = "gallery";
?>
<script>
$(function(){
	//acknowledgement message
    var message_status = $("#status");
    $("td[contenteditable=true]").blur(function(){
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        $.post('ajax.php' , field_userid + "=" + value, function(data){
            if(data != '')
			{
				//message_status.show();
				//message_status.text(data);
				//hide the message
				setTimeout(function(){message_status.hide()},1000);
			}
        });
    });
});
function calculateProfit(data)
{
	 var fieldId = $(data).attr("id");
	 var split_data = fieldId.split(":");
	 var user_id = split_data[1];
     var value = parseInt($(data).text());
	 var pRate = parseInt($("#prate"+user_id).val());
	 var calculation = pRate+parseInt((pRate*value/100)); 
	 alert(calculation);
	 $("td[contenteditable=true]#Arate:"+user_id).text(calculation);
	 
}	
</script>
<style>
#status { padding:10px; background:#88C4FF; color:#000; font-weight:bold; font-size:12px; margin-bottom:10px; display:none; width:90%; }
</style>
<div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
          <h1>&nbsp;          </h1>
          <ol class="breadcrumb">
            <li><b><a href="addItem.php"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Item</a></b></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Items List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				  <div id="status"></div>	
                  <table id="category" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="col-md-1">Sr. no.</th>
                        <th class="col-md-2">Item Name</th>
						<th class="col-md-1">P Rate</th>
						<th class="col-md-1">A %</th>
						<th class="col-md-1">A Rate</th>
						<th class="col-md-1">B %</th>
						<th class="col-md-1">B Rate</th>
						<th class="col-md-1">MRP Rate</th>
						<th class="col-md-2">Create Date</th>
                        <th class="col-md-1">Status</th>
                        <th class="col-md-1">Edit</th>
                        <!--<th class="col-md-1">Delete</th> -->
                      </tr>
                    </thead>
					<tbody>
                     <?php
					$query="SELECT * FROM items where deleted='0' ";
					$pageData=fetchData($query);
					if (is_array($pageData) || is_object($pageData))
					{
					$i=1;
					foreach($pageData as $tableData)
					{
					?>
                      <tr>
                         <td><?php echo  $i++; ?></td>
						 <td id="itemName:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo $tableData['itemName']; ?></td>
						 <td id="itemPrate:<?php echo $tableData['id'];  ?>" contenteditable="true" ><input type="hidden" id="prate<?php echo $tableData['id']; ?>" value="<?php echo $tableData['itemPrate']; ?>" /><?php echo $tableData['itemPrate']; ?></td>
						 <td id="itemAper:<?php echo $tableData['id'];  ?>" contenteditable="true" onblur="calculateProfit(this);"><?php echo $tableData['itemAper']; ?> </td>
						 <td id="itemArate:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo $tableData['itemArate']; ?> </td>		
						 <td id="itemBper:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo $tableData['itemBper']; ?></td>	
						  <td id="itemBrate:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo $tableData['itemBrate']; ?> </td>	
						 <td id="itemMRPrate:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo $tableData['itemMRPrate']; ?></td>
						 <td id="itemCdate:<?php echo $tableData['id'];  ?>" ><?php echo $tableData['itemCdate']; ?></td>	
                        <td ><?php $status=$tableData['status']; if($status==0){ echo "Enabled"; } else{ echo "Disabled"; } ?></td>
                        <td><a href='editGroup.php?id=<?php echo  $tableData['id'];?>'>Edit </a></td>
                       <!-- <td><a  onClick="javascript: return confirm('Please confirm deletion');" href='deleteArea.php?id=<?php echo  $tableData['id']; ?>&url=<?php echo basename($_SERVER['PHP_SELF']) ?>' name="subDelete">Delete</a></td>-->
                      </tr>
                    <?php } } ?>
					  </tbody>
                  </table>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
            
            </div><!-- /.col -->
            
          </div><!-- /.row -->
          
          
        </section><!-- /.content -->
      </div>
<?php include("common/adminFooter.php");?>
