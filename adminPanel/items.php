<?php
include("controller/pages_controller.php");
$menuType = "gallery";
?>
<script>
$(function(){
	//acknowledgement message
    $(document).on("blur","td[contenteditable=true]",function(){
		$("#overlay").show();
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        $.post('ajax.php' , field_userid + "=" + value, function(data)
		{
            if(data != '')
			{
				setInterval(function() {$("#overlay").hide(); },500);
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
	// alert(calculation);
	 $("td[contenteditable=true]#Arate:"+user_id).text(calculation);
	 
}	
 $.ajax({    //create an ajax request to load_page.php
        type: "GET",
        url: "getItems.php",            
		beforeSend: function(){$("#overlay").show();},	
        dataType: "html",   //expect html to be returned                
        success: function(response)
		{                    
            $("#tableData").html(response);
			sortTableData();
			setInterval(function() {$("#overlay").hide(); },500);	
        }
 });
function sortTableData()
{
    $('#category').DataTable( {
        "pagingType": "full_numbers"
    });
}
</script>
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
					<tbody id="tableData">
                
					
					  </tbody>
                  </table>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
            
            </div><!-- /.col -->
            
          </div><!-- /.row -->
          
          
        </section><!-- /.content -->
      </div>
<?php include("common/adminFooter.php");?>
