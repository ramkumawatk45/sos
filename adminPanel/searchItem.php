<?php 
 include "common/conn.php";
 include("class/datalist.php");
 $searchValue = trim($_REQUEST['searchValue']);
 $query="SELECT * FROM items where itemName like'%$searchValue%' ||  itemCode like'%$searchValue%' and deleted='0' ";
					$pageData=fetchData($query);
					$datainfo ='';
					if (is_array($pageData) || is_object($pageData))
					{
						foreach($pageData as $tableData)
						{
							echo"<option value=".$tableData['id'].">".$tableData['itemName']."</option>";
						} 
					
					} 
?> 