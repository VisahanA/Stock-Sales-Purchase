<?php 
                          /*  $date = date_create(2013-03-15);
                            echo date_format($date, "d/M/Y")*/
                          
?>
<?php
             
function GetConn()
{
     $con = mysqli_connect("localhost","root","","warehouse_management");
     return $con;
}


function PrdctCode()
{
     $con = GetConn();
     $crc = mysqli_query($con,"select CONCAT('PRD',LPAD(RIGHT(ifnull(max(p_id),'PRD0000'),4) + 1,4,'0')) from t_product");
     return mysqli_fetch_array($crc)[0];
}

function PrdctSCode()
{
     $con = GetConn();
     $crc = mysqli_query($con,"select CONCAT('SRD',LPAD(RIGHT(ifnull(max(p_sid),'SRD0000'),4) + 1,4,'0')) from t_soldprd");
     return mysqli_fetch_array($crc)[0];
}

function SupCode()
{
     $con = GetConn();
     $crc = mysqli_query($con,"select CONCAT('SUP',LPAD(RIGHT(ifnull(max(s_id),'SUP0000'),4) + 1,4,'0')) from t_supplier");
     return mysqli_fetch_array($crc)[0];
}

function DeaCode()
{
     $con = GetConn();
     $crc = mysqli_query($con,"select CONCAT('DEA',LPAD(RIGHT(ifnull(max(d_id),'DEA0000'),4) + 1,4,'0')) from t_dealer");
     return mysqli_fetch_array($crc)[0];
}

?>
