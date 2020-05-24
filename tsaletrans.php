<?php 
error_reporting(0);
$con = mysqli_connect("localhost", "root", "", "warehouse");
if(!isset($con))
{
    die("Database Not Found");
}

/*$gtrdet= mysqli_query($con, "select * from t_tevent where e_id= 'EVT0001'");
$gtrdet1 = mysqli_fetch_assoc($gtrdet);
$setExcelName = $gtrdet1["e_title"];
*/			
$setExcelName = "TOTAL SALES TRANSACTION(Category)";
$setSql = mysqli_query($con,  "SELECT Ucase(p_sname) AS 'PRODUCT CATEGORY', SUM(p_stot_cost) AS 'Total Cost (Rs.)',AVG(p_stot_cost) AS 'Average Cost (Rs.)' ,MAX(p_stot_cost) AS 'Maximum Cost (Rs.)'
                                ,MIN(p_stot_cost) AS 'Minimum Cost (Rs.)' FROM `t_soldprd` group by p_sname");
    
$setCounter = mysqli_num_fields($setSql);

if ($setSql)
  {
  // Get field information for all fields
 $fieldinfo=mysqli_fetch_fields($setSql);
 foreach ($fieldinfo as $val)
    {
       $setMainHeader .= ($val->name)."\t";
    }
  }  

while($rec = mysqli_fetch_row($setSql))  {
  $rowLine = '';
  foreach($rec as $value)       {
    if(!isset($value) || $value == "")  {
      $value = "\t";
    }   else  {
//It escape all the special charactor, quotes from the data.
      $value = strip_tags(str_replace('"', '""', $value));
      $value = '"' . $value . '"' . "\t";
    }
    $rowLine .= $value;
  }
  $setData .= trim($rowLine)."\n";
}
  $setData = str_replace("\r", "", $setData);

if ($setData == "") {
  $setData = "\nNo records found\n";
}

//$setCounter = mysql_num_fields($setRec);



//This Header is used to make data download instead of display the data
 header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=".$setExcelName."_Report.xls");

header("Pragma: no-cache");
header("Expires: 0");

//It will print all the Table row as Excel file row with selected column name as header.
echo ucwords($setMainHeader)."\n\n".$setData."\n";



?>

