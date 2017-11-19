<?php 
 include "common/conn.php";
 include("class/datalist.php");
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
						 <td id="itemPrate:<?php echo $tableData['id'];  ?>" contenteditable="true" ><input type="hidden" id="prate<?php echo $tableData['id']; ?>" value="<?php echo $tableData['itemPrate']; ?>" /><?php echo round($tableData['itemPrate'],4); ?></td>
						 <td id="itemAper:<?php echo $tableData['id'];  ?>" contenteditable="true" onblur="calculateProfit(this);"><?php echo $tableData['itemAper']; ?> </td>
						 <td id="itemArate:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo round($tableData['itemArate'],4); ?> </td>		
						 <td id="itemBper:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo round($tableData['itemBper'],4); ?></td>	
						  <td id="itemBrate:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo round($tableData['itemBrate'],4); ?> </td>	
						 <td id="itemMRPrate:<?php echo $tableData['id'];  ?>" contenteditable="true"><?php echo round($tableData['itemMRPrate'],4); ?></td>
						 <td id="itemCdate:<?php echo $tableData['id'];  ?>" ><?php $old_date = date($tableData['itemCdate']); $old_date_timestamp = strtotime($old_date);
								$new_date = date('d/m/Y h:i', $old_date_timestamp);  echo $new_date; ?></td>	
                        <td ><?php $status=$tableData['status']; if($status==0){ echo "Enabled"; } else{ echo "Disabled"; } ?></td>
                        <td><a href='addItem.php?id=<?php echo  $tableData['id'];?>'>Edit </a></td>
                       <!-- <td><a  onClick="javascript: return confirm('Please confirm deletion');" href='deleteArea.php?id=<?php echo  $tableData['id']; ?>&url=<?php echo basename($_SERVER['PHP_SELF']) ?>' name="subDelete">Delete</a></td>-->
                      </tr>
                    <?php } } 
?> 