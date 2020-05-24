<?php

session_start();
error_reporting(0);

include 'db.php';
include_once 'dbconfig.php';
$con = GetConn();
if(!isset($con))
{
die("Database Not Found");
}

/* $sc=  mysqli_query($con, "select p_tdate from t_purtrans where p_id='PRD0001'");
$date = date_create($sc);
echo date_format($date, "d/M/Y");*/

$phid=$_REQUEST["phid"];
$pname=$_REQUEST["pname"];
$pdesc=$_REQUEST["pdesc"];
$pprice=$_REQUEST["pprice"];
$pbrand=$_REQUEST["pbrand"];
$pquan=$_REQUEST["pquan"];
$pemail=$_REQUEST["pemail"];
$totcst=$pprice * $pquan;

$phid1=$_REQUEST["phid1"];
$pname1=$_REQUEST["pname1"];
$pdesc1=$_REQUEST["pdesc1"];
$pprice1=$_REQUEST["pprice1"];
$pbrand1=$_REQUEST["pbrand1"];
$pquan1=$_REQUEST["pquan1"];
$pemail1=$_REQUEST["pemail1"];
$totcst1=$pprice1 * $pquan1;

$productname=$_REQUEST["productname"];
$quantity=$_REQUEST["quantity"];
$price=$_REQUEST["price"];
$date=$_REQUEST["date"];
$costperunit=$price / $quantity;

$newproductname=$_REQUEST["newproductname"];

$newrestaurantname=$_REQUEST["newrestaurantname"];
$restaurantaddress=$_REQUEST["address"];
$restaurantmobile=$_REQUEST["mobile"];

$restaurant_name=$_REQUEST["restaurant_name"];
$restaurantproductname=$_REQUEST["restaurantproductname"];
$restaurantquantity=$_REQUEST["restaurantquantity"];
$restaurantpurchasedate=$_REQUEST["restaurantpurchasedate"];

$warehousefromdate=$_REQUEST["warehousefromdate"];
$warehousetodate=$_REQUEST["warehousetodate"];

$mnthsel=$_REQUEST["mnthsel"];

$q=mysqli_query($con,"select c_name from t_category where c_id='".$pname."'");
$n=  mysqli_fetch_assoc($q);
$cname= $n['c_name'];

$q1=mysqli_query($con,"select b_name from t_brand where b_id='".$pbrand."'");
$n1=  mysqli_fetch_assoc($q1);
$bname= $n1['b_name'];

$q2=mysqli_query($con,"select m_name from t_model where m_id='".$pdesc."'");
$n2=  mysqli_fetch_assoc($q2);
$mname= $n2['m_name'];

if(isset($_REQUEST["new-product"]))
{

$sqlcr = "insert into product(product_name) VALUES (";
$sqlcr.= "'" . $newproductname . "')";

mysqli_query($con,$sqlcr );

echo '<script>alert("Product name added")</script>';
}

if(isset($_REQUEST["product-submit"]))
{

$p_id= mysqli_query($con,"select product_id from product WHERE product_name='$productname'");
$p_id1=  mysqli_fetch_assoc($p_id);
$product_id= $p_id1['product_id'];

// if($phid == "")
// $phid = PrdctCode();

$sqlcr = "insert into productprice(date,product_id,price,quantity) VALUES (";
$sqlcr.= "'" . $date . "',";
$sqlcr.= "'" . $product_id . "',";
$sqlcr.= "'" . $costperunit . "',";
$sqlcr.= "'" . $quantity . "')";

mysqli_query($con,$sqlcr );

$avail= mysqli_query($con,"select quantity from warehouse_details where product_id=$product_id");
$avail1=  mysqli_fetch_assoc($avail);
$existing_quantity= $avail1['quantity'];
$updatedquantity=$existing_quantity + $quantity;
echo $existing_quantity;

if($existing_quantity == "") {
    $sqlcr1 = "insert into warehouse_details(product_id,product_name,quantity) values (";
    $sqlcr1.= "'" . $product_id . "',";
    $sqlcr1.= "'" . $productname . "',";
    $sqlcr1.= "'" . $quantity . "')";
    mysqli_query($con,$sqlcr1 );
}
else {
    echo $updatedquantity;
    $sqlcr2 = "update warehouse_details set quantity=$updatedquantity where product_id=$product_id";
    mysqli_query($con,$sqlcr2 );
}

echo '<script>alert("Product added successfully to warehouse.")</script>';

}

if(isset($_REQUEST["new-restaurant"]))
{

$sqlcr = "insert into restaurant(restaurant_name,address,mobile) VALUES (";
$sqlcr.= "'" . $newrestaurantname . "',";
$sqlcr.= "'" . $restaurantaddress . "',";
$sqlcr.= "'" . $restaurantmobile . "')";

mysqli_query($con,$sqlcr );

echo '<script>alert("Restaurant details added")</script>';
}

if(isset($_REQUEST["product-submit1"]))
{
$p_id= mysqli_query($con,"select product_id from product WHERE product_name='$restaurantproductname'");
$p_id1=  mysqli_fetch_assoc($p_id);
$product_id= $p_id1['product_id'];

$r_id= mysqli_query($con,"select restaurant_id from restaurant WHERE restaurant_name='$restaurant_name'");
$r_id1=  mysqli_fetch_assoc($r_id);
$restaurant_id= $r_id1['restaurant_id'];

$avail= mysqli_query($con,"select quantity from warehouse_details where product_id=$product_id");
$avail1=  mysqli_fetch_assoc($avail);
$existing_quantity= $avail1['quantity'];

echo $existing_quantity;
echo $restaurantquantity;
echo $productname;


if($restaurantquantity <= $existing_quantity)
{
    $sqlcr = "insert into restaurant_stock(product_id,quantity,restaurant_id,purchase_date) VALUES (";
    $sqlcr.= "'" . $product_id . "',";
    $sqlcr.= "'" . $restaurantquantity . "',";
    $sqlcr.= "'" . $restaurant_id . "',";
    $sqlcr.= "'" . $restaurantpurchasedate . "')";

    mysqli_query($con,$sqlcr );

    $updatedquantity=$existing_quantity - $restaurantquantity;
    $sqlcr2 = "update warehouse_details set quantity=$updatedquantity where product_id=$product_id";
    mysqli_query($con,$sqlcr2 );

echo '<script>alert("Restaurant purchase done successful")</script>';
}
else
{
echo '<script>alert("Shortage of quantity. Available quantity is ")</script>';
}

}


$shid=$_REQUEST["shid"];
$scom=$_REQUEST["scom"];
$sph=$_REQUEST["sph"];
$sph1=$_REQUEST["sph1"];
$snm=$_REQUEST["snm"];
$seml=$_REQUEST["seml"];

if(isset($_REQUEST["newsup-submit"]))
{

if($shid == "")
$shid = SupCode();

$sqlcr = "insert into t_supplier(`s_id`, `s_name`, `s_pswd`, `s_email`, `s_comp`, `s_phno`,`s_phno1`, `s_regdate`) values (";
$sqlcr.= "'" . $shid . "',";
$sqlcr.= "'" . $snm . "',";
$sqlcr.= "'123',";
$sqlcr.= "'" . $seml . "',";
$sqlcr.= "'" . $scom . "',";
$sqlcr.= "'" . $sph . "',";
$sqlcr.= "'" . $sph1 . "',";
$sqlcr.= "'" . $date . "')";

mysqli_query($con,$sqlcr);

echo '<script>alert("Supplier details added")</script>';
}


$dhid=$_REQUEST["dhid"];
$dcom=$_REQUEST["dcom"];
$dph=$_REQUEST["dph"];
$dph1=$_REQUEST["dph1"];
$dnm=$_REQUEST["dnm"];
$deml=$_REQUEST["deml"];

if(isset($_REQUEST["newdea-submit"]))
{

if($dhid == "")
$dhid = DeaCode();

$sqlcr = "insert into t_dealer(`d_id`, `d_name`, `d_pswd`, `d_email`, `d_comp`, `d_phno`, `d_phno1`,`d_regdate`) values (";
$sqlcr.= "'" . $dhid . "',";
$sqlcr.= "'" . $dnm . "',";
$sqlcr.= "'123',";
$sqlcr.= "'" . $deml . "',";
$sqlcr.= "'" . $dcom . "',";
$sqlcr.= "'" . $dph . "',";
$sqlcr.= "'" . $dph1 . "',";
$sqlcr.= "'" . $date . "')";

mysqli_query($con,$sqlcr);

echo '<script>alert("Dealer details added")</script>';
}


/* if(isset($_REQUEST['pdel']))
{
for($i=0;$i<count($_REQUEST['checkbox']);$i++)
{
$del_id=$_REQUEST['checkbox'][$i];
mysqli_query($con,"DELETE FROM t_purtrans WHERE p_id='$del_id'");
mysqli_query($con,"DELETE FROM t_product WHERE p_id='$del_id'");

}
}  */

if(isset($_REQUEST['pdel']))
{
$sqldel  = "CREATE TRIGGER trgbdel BEFORE DELETE ON t_product  FOR EACH ROW";
$sqldel .= "INSERT INTO log_prd_delete(`p_id`, `p_name`, `p_desc`, `p_brand`, `p_cost`, `p_quantity`, `tot_cost`, `audit_action`, `audit_trans`) values (";
$sqldel .= "OLD.p_id,OLD.p_name,OLD.p_desc,OLD.p_brand,OLD.p_cost,OLD.p_quantity,OLD.tot_cost,'Product details deleted',SYSDATE())";
for($i=0;$i<count($_REQUEST['checkbox']);$i++)
{
$del_id=$_REQUEST['checkbox'][$i];
mysqli_query($con,"DELETE FROM t_purtrans WHERE p_id='$del_id'");
mysqli_query($con,"DELETE FROM t_product WHERE p_id='$del_id'");
mysqli_query($con,$sqldel);

}
}

//change password

$adold = $_REQUEST["adoldpas"];
$adnew  = $_REQUEST["adnewpas"];
$adcon = $_REQUEST["adconnpas"];

if(isset($_REQUEST["adpassub"]))
{

$getad = mysqli_query($con,"select * from t_user where a_email='".$_SESSION['ad']."' and a_pswd='". $adold."'");

if($adnew==$adcon)
{
if(mysqli_num_rows($getad)>0)
{
mysqli_query($con,"update t_user set a_pswd='".$adnew."' where a_email ='".$_SESSION['ad']."'");

echo "<script> alert('Password has been changed successfully');</script>";
}

else
{
echo "<script> alert('Old password is incorrect. Please try again.');</script>";
}
}

else
{
echo "<script> alert('New password and confirm password should match. Please try again');</script>";
}
}

//change password over



?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin's Dashboard</title>

<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">
<script src="bootstrap/jquery.min.js"></script>
<script src="bootstrap/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/div.css">
<link rel="stylesheet" href="css/dashboard.css">

<!-- Dropdown brand, model -->

<script type="text/javascript" src="jquery-1.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(".pname").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "get_brand.php",
data: dataString,
cache: false,
success: function(html)
{
$(".pbrand").html(html);
}
});
});


$(".pbrand").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "get_model.php",
data: dataString,
cache: false,
success: function(html)
{
$(".pdesc").html(html);
}
});
});

});


$(document).ready(function()
{
$(".pname1").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "get_brand_1.php",
data: dataString,
cache: false,
success: function(html)
{
$(".pbrand1").html(html);
}
});
});


$(".pbrand1").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "get_model_1.php",
data: dataString,
cache: false,
success: function(html)
{
$(".pdesc1").html(html);
}
});
});

});
</script>
<style>

form
{
margin-left:3%;
}

input[type="search"]
{
width: 90%;
}
input[type="text"]:focus,input[type="search"]:focus,input[type="search"]:focus,select:focus,input[type="email"]:focus,input[type="password"]:focus

{
border: #000;
box-shadow: 0 0 10px  #000;

}

input[type="text"],input[type="search"],input[type="search"],select,input[type="email"],input[type="password"]
{
width:60%;
}
input[type="submit"]
{
width:20%;
background-color:#000;
border:#000;
color:#fff;
}

input[type="submit"]:hover
{
width:20%;
background-color:  #b0acac;
border:#000;
color:#000;
}


hr
{
height:7px;
border:0;
box-shadow: 0 10px 10px -10px #cccccc inset;
}

</style>

<script>
$(document).ready(function(){
$("#orderby").click(function(){
$("#cat").show();
$("#brn").hide();
$("#cst").hide();
});
$("#orderby1").click(function(){
$("#brn").show();
$("#cat").hide();
$("#cst").hide();
});
$("#orderby2").click(function(){
$("#cst").show();
$("#brn").hide();
$("#cat").hide();
});
});
</script>
        
    </head>
    <body>
        
        <center>
        <div class="container">
            <a href='logout.php'>
                             LOGOUT
                            </a>
        <img src="images/catergory-banner-electronics.png">
        </div>
       </center> <br>
        
        <div class="container">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#npe">Home</a></li>
                <li><a data-toggle="tab" href="#sup">Suppliers</a></li>
                <li><a data-toggle="tab" href="#dea"> Dealers</a></li>
                <li><a data-toggle="tab" href="#tran">Transaction</a></li>
                <li><a data-toggle="tab" href="#chpas">Change Password</a></li>
            </ul>
        
            <div class="tab-content" style="margin-top: 30px;">
                <div class="tab-pane fade in active" id="npe">
                    <div class="container">
                              <div class="panel-group">
                                 <div class="panel panel-default">
                                      <div class="panel-heading">
                                      <h5 class="panel-title ">
                                        <a data-toggle="collapse" href="#coo3"><center>Add New Product</center></a>
                                      </h5>
                                      </div>
                                      <div id="coo3" class="panel-collapse collapse">
                                          <div class="panel-body">Enter the product name to be added</div>
                                            <div class="panel-footer">
                                                <form class='form-horizontal'  id="productentry" method="post" action="">
                                                <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label ' for='pquan'> Product's Name :</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <input type='text' class="form-control" id='newproductname' name='newproductname'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-sm-10'>
                                                <center><input type="submit" name="new-product" id="new-product"
                                                class="form-control btn btn-login" value="Submit"></center>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                      
                    
                    <div class="container">
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                      <h5 class="panel-title">
                                         <a data-toggle="collapse" href="#coo1"><center>Warehouse Stock Purchase</center></a>
                                      </h5>
                                      </div>
                                      
                                      <div id="coo1" class="panel-collapse collapse">
                                          <div class="panel-body">Enter the details of the purchased product</div>
                                            <div class="panel-footer">
                                            <form class='form-horizontal'  id="productentry" method="post" action="dashboard.php">
                                        <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label ' for='pbrand'> Product's Name :</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <select id='productname' name="productname" class="pname">
                                                    <option selected="selected">--Select Category--</option>
                                                        <?php
                                                            $stmt = $DB_con->prepare("SELECT * FROM product");
                                                            $stmt->execute();
                                                            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                                                            {
                                                                    ?>
                                                            <option value="<?php echo $row['product_name']; ?>"><?php echo $row['product_name']; ?></option>
                                                            <?php
                                                            }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                         <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label ' for='pquan'> Product's Quantity :</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <input type='number' min='1' class="form-control" id='quantity' name='quantity'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label ' for='pquan'> Price :</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <input type='number' min='1' class="form-control" id='price' name='price'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label ' for='pquan'> Date :</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <input type='date' class="form-control" id='date' name='date'>
                                            </div>
                                        </div>

                                        <div class='form-group'>
                                            <div class='col-sm-10'>
                                                <center><input type="submit" name="product-submit" id="product-submit"
                                                        class="form-control btn btn-login" value="Submit"></center>
                                             </div>  
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <h5 class="panel-title">
                        <a data-toggle="collapse" href="#coo6"><center>Add New Restaurant</center></a>
                        </h5>
                        </div>
                        <div id="coo6" class="panel-collapse collapse">
                            <div class="panel-body">Enter the details of the restaurant</div>
                                <div class="panel-footer">
                                    <form class='form-horizontal'  id="productentry" method="post" action="">
                                        <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label ' for='pbrand'> Restaurant Name :</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <input type='text'  class="form-control" id='newrestaurantname' name='newrestaurantname'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                        <div class='col-sm-5'>
                                            <label class='control-label ' for='pquan'> Address:</label>
                                        </div>
                                        <div class='col-sm-7'>
                                            <input type='text'  class="form-control" id='address' name='address'>
                                        </div>
                                        </div>
                                        <div class='form-group'>
                                        <div class='col-sm-5'>
                                            <label class='control-label ' for='pquan'> Mobile number :</label>
                                        </div>
                                        <div class='col-sm-7'>
                                            <input type='number'  class="form-control" id='mobile' name='mobile'>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='col-sm-10'>
                                            <center><input type="submit" name="new-restaurant" id="new-restaurant"
                                            class="form-control btn btn-login" value="Submit"></center>
                                        </div>
                                    </div>
                                    </form> 
                                        </div>
                                </div>
                            </div>
                        </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a data-toggle="collapse" href="#coo2"><center>Restaurant Stock Purchase</center></a>
                            </h5>
                        </div>

                        <div id="coo2" class="panel-collapse collapse">
                            <div class="panel-body">Enter the details of restaurant stock purchase</div>
                                <div class="panel-footer">
                                    <form class='form-horizontal'  id="productentry" method="post" action="">
                                    <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label' for='pname1' > Product Name :</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <select id='restaurantproductname' name="restaurantproductname" class="pname">
                                                    <option selected="selected">--Select Category--</option>
                                                    <?php
                                                            $stmt = $DB_con->prepare("SELECT * FROM product");
                                                            $stmt->execute();
                                                            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                                                            {
                                                                    ?>
                                                            <option value="<?php echo $row['product_name']; ?>"><?php echo $row['product_name']; ?></option>
                                                            <?php
                                                            }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label' for='pname1' > Restaurant Name :</label>
                                            </div>
                                            <div class='col-sm-7'>

                                                <select  id='restaurant_name' name="restaurant_name" class="pname1">
                                                    <option selected="selected">--Select Category--</option>
                                                    <?php
                                                            $stmt1 = $DB_con->prepare("SELECT * FROM restaurant");
                                                            $stmt1->execute();
                                                            while($row=$stmt1->fetch(PDO::FETCH_ASSOC))
                                                            {
                                                                    ?>
                                                            <option value="<?php echo $row['restaurant_name']; ?>"><?php echo $row['restaurant_name']; ?></option>
                                                            <?php
                                                            }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label ' for='pbrand1'>Quantity</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <input type='text' class="form-control" id='restaurantquantity' name='restaurantquantity'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-sm-5'>
                                                <label class='control-label ' for='pbrand1'>Date</label>
                                            </div>
                                            <div class='col-sm-7'>
                                                <input type='date' class="form-control" id='restaurantpurchasedate' name='restaurantpurchasedate'>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='col-sm-10'>
                                                <center><input type="submit" name="product-submit1" id="product-submit1"
                                                        class="form-control btn btn-login" value="Submit"></center>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>                 
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" href="#coo7"><center>Warehouse Purchase Report</center></a>
                                </h5>
                            </div>
                        </div>
                        <div id="coo7" class="panel-collapse collapse">
                    <div class="panel-body">Select the range</div>
                        <div>
                            <form class='form-horizontal'  id="productsold" method="post" action="">
                                <div class='form-group'>
                                    <div class='col-sm-5'>
                                        <label class='control-label ' for='pbrand1'>From Date :</label>
                                    </div>
                                    <div class='col-sm-7'>
                                        <input type='date' class="form-control" id='warehousefromdate' name='warehousefromdate'>
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <div class='col-sm-5'>
                                        <label class='control-label ' for='pbrand1'>To Date :</label>
                                    </div>
                                    <div class='col-sm-7'>
                                        <input type='date' class="form-control" id='warehousetodate' name='warehousetodate'>
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <div class='col-sm-10'>
                                        <center><input type="submit" name="showmprd" id="showmprd"
                                                class="form-control btn btn-login" value="Show"></center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <?php
                            $mthch= mysqli_query($con, "select a.date,b.product_name,a.price,a.quantity from productprice a left join product b on a.product_id=b.product_id where a.date BETWEEN '$warehousefromdate' AND '$warehousetodate'");

                            echo "<hr>" ;

                            if(isset($_REQUEST["showmprd"]))
                            {
                                echo "<table class='table table-bordered'>";
                                echo "<th>Date</th>";
                                echo "<th>Product Name</th>";
                                echo "<th>Cost per Item</th>";
                                echo "<th>Quantity</th>";
                                while($mthc = mysqli_fetch_array($mthch))
                                {
                                    echo "<tr>";
                                    echo "<td>". $mthc[0]."</td>";
                                    echo "<td>". $mthc[1]."</td>";
                                    echo "<td>". $mthc[2]."</td>";
                                    echo "<td>". $mthc[3]."</td>";
                                    echo "</tr>";
                                }
                                echo "<tr>";
                                    echo "<td colspan=5>";
                                    //echo '<center><a href="mnthlyrcd.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                    echo "</td>";
                                    echo "</tr>";
                                echo "</table>";
                                }
                        ?>
                    </div>
                    <div class="panel panel-default">
                <div class="panel-heading">
                    <center><h4>Stocks Available</h4></center>
                </div>
                <div class="panel-body">
                    Arrange according to :
                    <input type="button" name="orderby" id="orderby" value="Product ID" class="btn btn-link">
                    <input type="button" name="orderby1" id="orderby1" value="Product Name" class="btn btn-link">
                    <input type="button" name="orderby2" id="orderby2" value="Quantity" class="btn btn-link">
                </div>
                <form class='form-horizontal' id="stockav" method="post">
                    <span>
                        <?php
                            $av= mysqli_query($con, "select COUNT(*) AS rows from warehouse_details");
                            $res=  mysqli_fetch_assoc($av);
                            $row=$res['rows'];
                            echo "<center>Total No. of rows fetched <b>: $row</b></center>";
                        ?>
                    </span>
                        
                    <div class="panel-footer" id="cat">

                    <table class="table table-striped" style="width:100%">
                        <thead >
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $avpr= mysqli_query($con, "select * from warehouse_details ORDER BY `warehouse_details`.`product_id` ASC");
                        while($avprr = mysqli_fetch_array($avpr))
                        {
                        ?>
                        <tr>
                        <td><?php echo $avprr[0] ?></td>
                        <td><?php echo $avprr[1] ?></td>
                        <td><?php echo $avprr[2] ?></td>
                        <td><input name="checkbox[]" type="checkbox" id="checkbox[]"
                        value="<?php echo  $avprr[0] ; ?>"></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                        <td colspan="7">
                        <center><a href="stockscategory.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        </div>

                        <div class="panel-footer" id="brn" hidden>
                        <table class="table table-striped" style="width:100%">
                            <thead >
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>


                            <?php
                            $avpr1= mysqli_query($con, "select * from warehouse_details ORDER BY `warehouse_details`.`product_name` ASC");
                                            while($avprr1 = mysqli_fetch_array($avpr1))
                            {
                            ?>

                            <tr>
                            <td><?php echo $avprr1[0] ?></td>
                            <td><?php echo $avprr1[1] ?></td>
                            <td><?php echo $avprr1[2] ?></td>
                            <td><input name="checkbox[]" type="checkbox" id="checkbox[]"
                            value="<?php echo  $avprr1[0] ; ?>"></td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td colspan="7">
                            <center><a href="stocksbrand.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </div>


                            <div class="panel-footer" id="cst" hidden>
                        <table class="table table-striped" style="width:100%">
                            <thead >
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php

                            $avpr2= mysqli_query($con, "select * from warehouse_details ORDER BY `warehouse_details`.`quantity` ASC");
                            while($avprr2 = mysqli_fetch_array($avpr2))
                            {
                            ?>
                            <tr>
                            <td><?php echo $avprr2[0] ?></td>
                            <td><?php echo $avprr2[1] ?></td>
                            <td><?php echo $avprr2[2] ?></td>
                            <td><input name="checkbox[]" type="checkbox" id="checkbox[]"
                            value="<?php echo  $avprr2[0] ; ?>"></td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td colspan="7">
                            <center><a href="stockscostpi.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </div>                            
                      </form>
                </div>            
            </div>
        </div>
            
        
                <div id="sup" class="tab-pane fade" >
                    <div class="container">
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#co1"><center>ADD A NEW SUPPLIER</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="co1" class="panel-collapse collapse">
                                          <div class="panel-body">Enter the details of the new supplier</div>
                                            <div class="panel-footer">
                                                <form id="addsup" class="form-horizontal"  action=""  method="post">
                        
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="snm">Name : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='snm' name='snm' placeholder="Enter Supplier's Name">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="seml">Email : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='email' class="form-control" id='seml' name='seml' placeholder="Enter Supplier's Email">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="sph">Contact : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='sph' name='sph'  placeholder="Enter Supplier's 1st Contact">
                                                            <br>    <input type='text' class="form-control" id='sph1' name='sph1' placeholder="Enter Supplier's 2nd Contact">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="scom">Company : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='scom' name='scom' placeholder="Enter Supplier's Company">
                                                            <input type='hidden' class="form-control" id='shid' name='shid' >
                                                        </div>
                                                    </div>

                                                    <div class='form-group'>
                                                        <div class='col-sm-10'>
                                                            <center><input type="submit" name="newsup-submit" id="newsup-submit" 
                                                                    class="form-control btn btn-login" value="Submit"></center>
                                                        </div>
                                                    </div>


                                                 </form>
                                            </div>
                                      </div>
                                  </div>
                              </div>
                    </div>
                    
                          <div class="container" >
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#col1"><center>LIST OF SUPPLIERS</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="col1" class="panel-collapse collapse">
                                          <div class="panel-body"></div>
                                          <div class="panel-footer">
                                             <table class="table table-striped" style="width:100%">
                                                <thead >
                                                    <tr>
                                                        <th>ID.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Contact</th>
                                                        <th>Company</th>
                                                       <!-- <th>Total Cost</th>-->
                                                        <th>Registered On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sup= mysqli_query($con, "select * from t_supplier ORDER BY `t_supplier`.`s_id` ASC");
                                                        while($supp = mysqli_fetch_array($sup))              
                                                        {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $supp[0] ?></td>
                                                        <td><?php echo $supp[1] ?></td>
                                                        <td><?php echo $supp[3] ?></td>
                                                        <td><?php echo $supp[4]; echo " , "; echo $supp[5] ?></td>
                                                        <td><?php echo $supp[6] ?></td>
                                                        <td><?php echo $supp[7] ?></td>
                                                        <!--<td>rs.getString("s_regdate")</td>-->
                                                    </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table> 
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>     
                      </div>
                            
                            
                            
                       
                     <div id="dea" class="tab-pane fade" >
                         <div class="container">
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#co2"><center>ADD A NEW DEALER</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="co2" class="panel-collapse collapse">
                                          <div class="panel-body">Enter the details of the new dealer</div>
                                          <div class="panel-footer">
                                              <form id="adddlr" class="form-horizontal" action="dashboard.php"  method="post">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="snm">Name : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='dnm' name='dnm' placeholder="Enter Dealer's Name">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="deml">Email : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='email' class="form-control" id='deml' name='deml' placeholder="Enter Dealer's Email">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="dph">Contact : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='dph' name='dph'  placeholder="Enter Dealer's 1st Contact">
                                                            <br>    <input type='text' class="form-control" id='dph1' name='dph1' placeholder="Enter Dealer's 2nd Contact">
                                                          </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="dcom">Company : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='dcom' name='dcom' placeholder="Enter Dealer's Company">
                                                            <input type='hidden' class="form-control" id='dhid' name='dhid'>
                                                        </div>
                                                    </div>

                                                    <div class='form-group'>
                                                        <div class='col-sm-10'>
                                                            <center><input type="submit" name="newdea-submit" id="newdea-submit" 
                                                                    class="form-control btn btn-login" value="Submit"></center>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         
                        
                        <div class="container">
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#col2"><center>LIST OF DEALERS</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="col2" class="panel-collapse collapse">
                                          <div class="panel-body"></div>
                                          <div class="panel-footer">
                                             <table class="table table-striped" style="width:100%">
                                                <thead >
                                                    <tr>
                                                        <th>ID.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Company</th>
                                                        <th>Contact</th>
                                                        
                                                        <!--<th>Total Cost</th>-->
                                                        <th>Registered On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                   <?php
                                                        $dea= mysqli_query($con, "select * from t_dealer ORDER BY `t_dealer`.`d_id` ASC");
                                                        while($deal = mysqli_fetch_array($dea))              
                                                        {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $deal[0] ?></td>
                                                        <td><?php echo $deal[1] ?></td>
                                                        <td><?php echo $deal[3] ?></td>
                                                        <td><?php echo $deal[4];?></td>
                                                        <td><?php echo $deal[6];  echo " , "; echo $deal[5] ?></td>
                                                        <td><?php echo $deal[7] ?></td>
                                                        <!--<td>rs.getString("s_regdate")</td>-->
                                                    </tr>
                                                        <?php } ?>
                                                   
                                                </tbody>
                                            </table>     
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>      
                        </div>
            
                  <div id="tran" class="tab-pane fade" >
                    <form id="viewtran">
                        <div class="container">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <center><h4>TOTAL PURCHASE TRANSACTION</h4></center>
                                    </div>
                                    <div class="panel-body">
                                         <?php 
                                           $totpur = mysqli_query($con,"SELECT SUM(tot_cost) FROM `t_product`");
                                          
                                         
                                           while($purval=mysqli_fetch_array($totpur))
                                           {
                                           echo "<h4>Total purchase price till date :<b> Rs. ". $purval['SUM(tot_cost)']."</b></h4>";
                                           }
                                           echo '<br>';
                                           
                                           $namepur = mysqli_query($con,"SELECT Ucase(p_name), SUM(tot_cost),AVG(tot_cost),MAX(tot_cost),
                                               MIN(tot_cost) FROM `t_product` group by p_name");
                                           echo "<br><center>TOTAL PURCHASE TILL DATE (ACCORDING TO PRODUCT'S CATEGORY)</center>";
                                            ?>
                                           
                                           <?php       
                                           echo "<hr>" ;
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Product's Category </th>";
                                           echo "<th> Total Cost (Rs.)</th>";
                                           echo "<th> Average Cost (Rs.)</th>";
                                           echo "<th> Maximum Cost (Rs.)</th>";
                                           echo "<th> Minimum Cost (Rs.)</th>";
                                           while($nameval=mysqli_fetch_array($namepur))
                                           {
                                              echo "<tr>";
                                              echo "<td>". $nameval['Ucase(p_name)'] . "</td>";
                                              echo "<td>". $nameval['SUM(tot_cost)']."</td>";
                                              echo "<td>". $nameval['AVG(tot_cost)']."</td>";
                                              echo "<td>". $nameval['MAX(tot_cost)']."</td>";
                                              echo "<td>". $nameval['MIN(tot_cost)']."</td>";
                                              echo "</tr>";
                                              
                                           }
                                           
                                          
                                              echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tpurtrans.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                              echo "</table>";
                                           
                                           $datepur = mysqli_query($con,"SELECT substring(p_tdate,4,3), SUM(tot_cost),AVG(tot_cost),
                                               MAX(tot_cost),MIN(tot_cost) FROM t_purtrans INNER JOIN t_product ON 
                                               t_purtrans.p_id=t_product.p_id group by substring(p_tdate,4,3)");
                                           echo "<br><hr><center>TOTAL PURCHASE TILL DATE(ACCORDING TO MONTHS)</center>" ;
                                                  
                                           echo "<hr>" ;
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Month </th>";
                                           echo "<th> Total Cost (Rs.)</th>";
                                           echo "<th> Average Cost (Rs.)</th>";
                                           echo "<th> Maximum Cost (Rs.)</th>";
                                           echo "<th> Minimum Cost (Rs.)</th>";
                                           while($dateval=mysqli_fetch_array($datepur))
                                           {
                                              echo "<tr>";
                                              echo "<td>". $dateval['substring(p_tdate,4,3)'] . "</td>";
                                              echo "<td>". $dateval['SUM(tot_cost)']."</td>";
                                              echo "<td>". $dateval['AVG(tot_cost)']."</td>";
                                              echo "<td>". $dateval['MAX(tot_cost)']."</td>";
                                              echo "<td>". $dateval['MIN(tot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tpurtrm.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                          ?>
                                      </div>
                                </div><br>
                                <div class="panel panel-default">
                                    <div class="panel-heading"> <center><h4>TOTAL SALES TRANSACTION</h4></center></div>
                                    <div class="panel-body">
                                        <?php 
                                           $totsal = mysqli_query($con,"SELECT SUM(p_stot_cost) FROM `t_soldprd`");
                                           
                                           while($salval=mysqli_fetch_array($totsal))
                                           {
                                           echo "<h4>Total sales till date :<b> Rs. ". $salval['SUM(p_stot_cost)']."</b></h4>";
                                           }
                                           echo '<br>';
                                                                                  
                                           $namesal = mysqli_query($con,"SELECT Ucase(p_sname), SUM(p_stot_cost),AVG(p_stot_cost),MAX(p_stot_cost),MIN(p_stot_cost) FROM `t_soldprd` group by p_sname");
                                           echo "<br><center>TOTAL PURCHASE TILL DATE(ACCORDING TO PRODUCT'S CATEGORY)</center>" ;
                                            ?>
                                           
                                           <?php
                                           echo "<hr>" ;
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Product's Category </th>";
                                           echo "<th> Total Cost (Rs.)</th>";
                                           echo "<th> Average Cost (Rs.)</th>";
                                           echo "<th> Maximum Cost (Rs.)</th>";
                                           echo "<th> Minimum Cost (Rs.)</th>";
                                           while($nameva=mysqli_fetch_array($namesal))
                                           {
                                              echo "<tr>";
                                              echo "<td>". $nameva['Ucase(p_sname)'] . "</td>";
                                              echo "<td>". $nameva['SUM(p_stot_cost)']."</td>";
                                              echo "<td>". $nameva['AVG(p_stot_cost)']."</td>";
                                              echo "<td>". $nameva['MAX(p_stot_cost)']."</td>";
                                              echo "<td>". $nameva['MIN(p_stot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tsaletrans.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                           
                                           $datesal = mysqli_query($con,"SELECT substring(s_tdate,4,3), SUM(p_stot_cost),AVG(p_stot_cost),MAX(p_stot_cost),MIN(p_stot_cost) FROM t_saletrans INNER JOIN t_soldprd ON t_saletrans.p_sid=t_soldprd.p_sid group by substring(s_tdate,4,3)");
                                           echo "<br><hr><center>TOTAL SALES TILL DATE (ACCORDING TO MONTHS)</center>" ;
                                           ?>
                                          
                                           <?php       
                                           echo "<hr>" ;
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Month </th>";
                                           echo "<th> Total Cost (Rs.)</th>";
                                           echo "<th> Average Cost (Rs.)</th>";
                                           echo "<th> Maximum Cost (Rs.)</th>";
                                           echo "<th> Minimum Cost (Rs.)</th>";
                                           while($datesa=mysqli_fetch_array($datesal))
                                           {
                                              echo "<tr>";
                                              echo "<td>". $datesa['substring(s_tdate,4,3)'] . "</td>";
                                              echo "<td>". $datesa['SUM(p_stot_cost)']."</td>";
                                              echo "<td>". $datesa['AVG(p_stot_cost)']."</td>";
                                              echo "<td>". $datesa['MAX(p_stot_cost)']."</td>";
                                              echo "<td>". $datesa['MIN(p_stot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center> <a href="tsalem.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                           
                                            ?>
                                    </div>
                                </div><br>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><center><h4> BEST SUPPLIER</h4></center>   </div>
                                    <div class="panel-body">
                                    <?php 
                                           $bestsp = mysqli_query($con,"SELECT s_email, SUM(tot_cost),MAX(tot_cost),MIN(tot_cost) FROM t_purtrans INNER JOIN t_product ON t_purtrans.p_id=t_product.p_id group by (s_email) order by sum(tot_cost) DESC");
                                           $trcount=0;                                           
                                           echo "<br><center>PURCHASES FROM THE SUPPLIERS</center>" ;
                                           ?>
                                           
                                           <?php       
                                           echo "<hr>";
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Rank </th>";
                                           echo "<th> Supplier's Name</th>";
                                           echo "<th> Total Purchase(Rs.)</th>";
                                           echo "<th> Maximum Purchase Price (Rs.)</th>";
                                           echo "<th> Minimum Purchase Price (Rs.)</th>";
                                          
                                           while($bests=mysqli_fetch_array($bestsp))
                                           {
                                               $s2=mysqli_query($con,"select s_name from t_supplier where s_email='".$bests['s_email']."'");
                                               $ss2=  mysqli_fetch_assoc($s2);
                                               $spname= $ss2['s_name'];
                                              echo "<tr>";
                                              echo "<td>". ++$trcount .".</td>";
                                              echo "<td>". $spname . "</td>";
                                              echo "<td>". $bests['SUM(tot_cost)']."</td>";
                                              echo "<td>". $bests['MAX(tot_cost)']."</td>";
                                              echo "<td>". $bests['MIN(tot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tsupl.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                           
                                            ?>
                                    
                                    </div>
                                </div><br>
                                <div class="panel panel-default">
                                    <div class="panel-heading"> <center><h4>BEST DEALER </h4></center></div>
                                    <div class="panel-body">
                                        <?php 
                                           $bestdl = mysqli_query($con,"SELECT d_email, SUM(p_stot_cost),MAX(p_stot_cost),MIN(p_stot_cost) FROM t_saletrans INNER JOIN t_soldprd ON t_saletrans.p_sid=t_soldprd.p_sid group by (d_email) order by sum(p_stot_cost) DESC");
                                           $dlcount=0;                                           
                                           echo "<br><hr><center> SALES TO THE DEALERS</center>" ;
                                           ?>
                                           
                                           <?php       
                                           echo "<hr>";
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Rank </th>";
                                           echo "<th> Dealer's Name</th>";
                                           echo "<th> Total Sales(Rs.)</th>";
                                           echo "<th> Maximum Sales Price (Rs.)</th>";
                                           echo "<th> Minimum Sales Price (Rs.)</th>";
                                          
                                           while($bestd=mysqli_fetch_array($bestdl))
                                           {
                                               $d2=mysqli_query($con,"select d_name from t_dealer where d_email='".$bestd['d_email']."'");
                                               $dd2=  mysqli_fetch_assoc($d2);
                                               $dlname= $dd2['d_name'];
                                              echo "<tr>";
                                              echo "<td>". ++$dlcount .".</td>";
                                              echo "<td>". $dlname . "</td>";
                                              echo "<td>". $bestd['SUM(p_stot_cost)']."</td>";
                                              echo "<td>". $bestd['MAX(p_stot_cost)']."</td>";
                                              echo "<td>". $bestd['MIN(p_stot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tdeal.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                           
                                            ?>
                                    
                                    </div>
                                </div><br>
                             </div>
                        </div>
                    </form>
                </div>            
                
                
                <div id="chpas" class="tab-pane fade" >
                    <div class="jumbotron">
                       <center>   
                            <div class="container-fluid">    
                                <div class="row">
                                   <div class="col-sm-12">
                                        <p style="color: #999999 ;font-family:Verdana; font-weight: bold;margin-top:2px; font-size: xx-large ">
                                           Get a new password !
                                       </p>
                                    </div> 
                                </div>    

                                   <div class="row">
                                        <div class="col-sm-12">
                                           <input type="password" class="form-control" name="adoldpas" placeholder="What's The Old Password ?">
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-sm-12">
                                           <input type="password" class="form-control" name="adnewpas" placeholder="Enter your new password">
                                        </div>
                                    </div><br>


                                   <div class="row">
                                        <div class="col-sm-12">
                                           <input type="password" name="adconnpas" class="form-control" placeholder="Confirm New Password">
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-sm-12">
                                       <input type="submit" name="adpassub" class="form-control" value="Change" > 
                                        </div>
                                    </div>
                                 </div>
                           </center>
                    </div>
                </div>
            
            </div>                     
        </div>
    </body>
</html>