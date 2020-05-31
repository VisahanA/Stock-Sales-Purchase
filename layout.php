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

$res_pur_fromdate=$_REQUEST["res_pur_fromdate"];
$res_pur_todate=$_REQUEST["res_pur_todate"];
$res_pur_name=$_REQUEST["res_pur_name"];



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
$productwithoutspaces=str_replace(" ","",$newproductname);
$producttolower=strtolower($productwithoutspaces);
$namepur= mysqli_query($con,"select product_name from product");
$isSameName=false;
while($nameval=mysqli_fetch_array($namepur))
{
    $existingproduct=$nameval['product_name'];
    $exisproductwithoutspaces=str_replace(" ","",$existingproduct);
    $exisproducttolower=strtolower($exisproductwithoutspaces);
    if($exisproducttolower==$producttolower){
        $isSameName=true;
        break;
    }
}

if($isSameName){
    echo '<script>alert("Product name already exists")</script>';    
}else{
    $sqlcr = "insert into product(product_name) VALUES (";
    $sqlcr.= "'" . $newproductname . "')";
    mysqli_query($con,$sqlcr );
    echo '<script>alert("Product name added")</script>';
}

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
// echo $existing_quantity;

if($existing_quantity == "") {
    $sqlcr1 = "insert into warehouse_details(product_id,product_name,quantity) values (";
    $sqlcr1.= "'" . $product_id . "',";
    $sqlcr1.= "'" . $productname . "',";
    $sqlcr1.= "'" . $quantity . "')";
    mysqli_query($con,$sqlcr1 );
}
else {
    // echo $updatedquantity;
    $sqlcr2 = "update warehouse_details set quantity=$updatedquantity where product_id=$product_id";
    mysqli_query($con,$sqlcr2 );
}

echo '<script>alert("Product added successfully to warehouse.")</script>';

}

if(isset($_REQUEST["new-restaurant"]))
{
    $reswithoutspaces=str_replace(" ","",$newrestaurantname);
    $restolower=strtolower($reswithoutspaces);
    $namepur= mysqli_query($con,"select restaurant_name from restaurant");
    $isSameName=false;
    while($nameval=mysqli_fetch_array($namepur))
    {
        $existingres=$nameval['restaurant_name'];
        $exisreswithoutspaces=str_replace(" ","",$existingres);
        $exisrestolower=strtolower($exisreswithoutspaces);
        if($exisrestolower==$restolower){
            $isSameName=true;
            break;
        }
    }
    
    if($isSameName){
        echo '<script>alert("Restaurant name already exists")</script>';    
    }else{
        $sqlcr = "insert into restaurant(restaurant_name,address,mobile) VALUES (";
        $sqlcr.= "'" . $newrestaurantname . "',";
        $sqlcr.= "'" . $restaurantaddress . "',";
        $sqlcr.= "'" . $restaurantmobile . "')";

        mysqli_query($con,$sqlcr );

        echo '<script>alert("Restaurant details added")</script>';
    }

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
echo '<script>alert("Shortage of quantity.")</script>';
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
        
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin's Dashboard</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="dashboard.css">
<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<body onload="catdisplay()">
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top text-white">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img src="images/sanstechno.jpeg" width="30" height="30" class="d-inline-block align-top" alt="">
        <span class="menu-collapsed"></span>
    </a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" data-toggle="pill" href="#stock_available">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">New User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#change_password">Change Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>

            <!-- This menu is hidden in bigger devices with d-sm-none. 
           The sidebar isn't proper for smaller screens imo, so this dropdown menu can keep all the useful sidebar itens exclusively for smaller screens  -->
        </ul>
    <span class="navbar-text">
      Username 
    </span>
    </div>
</nav>
<!-- NavBar END -->
<!-- Bootstrap row -->
<div class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block col-2">
        <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group sticky-top sticky-offset">
            <!-- Separator with title -->
            <!-- /END Separator -->
            <!-- Menu with submenu  -->
            <!-- Submenu content -->
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>Item</small>
            </li>
            <!-- Adding Product and restaurant  -->
            <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-dashboard fa-fw mr-3"></span>
                    <span class="menu-collapsed">Add New Items</span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="submenu1" class="collapse sidebar-submenu nav flex-column">
                <a href="#add_product" data-toggle="pill"  class=" list-group-item-action bg-dark text-white nav-link "  aria-controls="add_product" aria-selected="false">
                    <span class="menu-collapsed">Add Products</span>
                </a>
                <a href="#add_restaurant" data-toggle="pill" class=" list-group-item-action bg-dark text-white nav-link"  aria-controls="add_restaurant" aria-selected="false">
                    <span class="menu-collapsed">Add Restaurants</span>
                </a>
                <a href="#stock_available" data-toggle="pill"  class=" list-group-item-action bg-dark text-white nav-link "  aria-controls="stock_available" aria-selected="false">
                    <span class="menu-collapsed">View Stock</span>
                </a>
            </div>
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>Purchase</small>
            </li>
            <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-user fa-fw mr-3"></span>
                    <span class="menu-collapsed">Purchase </span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="submenu2" class="collapse sidebar-submenu nav flex-column">
                    <a href="#warehouse_purchase" data-toggle="pill"  class="list-group-item-action bg-dark text-white nav-link "  aria-controls="warehouse_purchase" aria-selected="false">
                        <span class="menu-collapsed">Warehouse Purchase </span>
                    </a>
                    <a href="#warehouse_report" data-toggle="pill" class=" list-group-item-action bg-dark text-white nav-link"  aria-controls="warehouse_report" aria-selected="false">
                        <span class="menu-collapsed">Warehouse Report</span>
                    </a>
            </div>
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>Sales</small>
            </li>
            <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-user fa-fw mr-3"></span>
                    <span class="menu-collapsed">Sales </span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="submenu3" class="collapse sidebar-submenu nav flex-column">
                    <a href="#restaurant_purchase" data-toggle="pill"  class="list-group-item-action bg-dark text-white nav-link "  aria-controls="restaurant_purchase" aria-selected="false">
                        <span class="menu-collapsed">Restaurant Purchase </span>
                    </a>
                    <a href="#restaurant_report" data-toggle="pill" class=" list-group-item-action bg-dark text-white nav-link"  aria-controls="restaurant_report" aria-selected="false">
                        <span class="menu-collapsed">Restaurant Report</span>
                    </a>
                    <a href="#restaurant_details" data-toggle="pill" class=" list-group-item-action bg-dark text-white nav-link"  aria-controls="restaurant_details" aria-selected="false">
                        <span class="menu-collapsed">Restaurant Details</span>
                    </a>
            </div>
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>Bill Details</small>
            </li>
            <a href="#submenu4" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-user fa-fw mr-3"></span>
                    <span class="menu-collapsed">Transaction Report </span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="submenu4" class="collapse sidebar-submenu nav flex-column">
                    <a href="#warehouse_transaction" data-toggle="pill"  class="list-group-item-action bg-dark text-white nav-link "  aria-controls="warehouse_transaction" aria-selected="false">
                        <span class="menu-collapsed">Warehouse Transaction </span>
                    </a>
                    <a href="#restaurant_transaction" data-toggle="pill" class=" list-group-item-action bg-dark text-white nav-link"  aria-controls="restaurant_transaction" aria-selected="false">
                        <span class="menu-collapsed">Restaurant Transaction</span>
                    </a>
            </div>
        </ul>
    </div>
<!-- List Group END-->
<!-- Main Page -->
<div class="col py-3 tab-content">
    <div id="change_password" class="tab-pane fade ">
        <p style="color: #999999 ;font-family:Verdana; font-weight: bold;margin-top:2px; font-size: xx-large ">
            Get a new password !
        </p>
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
                <input type="submit" name="adpassub" class="form-control bt btn-primary" value="Change" > 
                </div>
            </div>  
    </div>
    <!-- Stock Availability -->
    <div id="stock_available" class="tab-pane fade show active" onClick="catdisplay">
        <div class="panel-body">
            Arrange according to :
            <input type="button"  id="orderby" value="Product ID" class="btn btn-link" onClick="catdisplay()">
            <input type="button"  id="orderby1" value="Product Name" class="btn btn-link" onClick="brndisplay()">
            <input type="button"  id="orderby2" value="Quantity" class="btn btn-link" onClick="cstdisplay()">
        </div>
        <form class='form-horizontal' id="stockav" method="post">    
                    <div class="panel-footer" id="cat" >
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

                        <div class="panel-footer" id="brn"  >
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


                            <div class="panel-footer" id="cst" >
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
    <!-- Add product Name -->
    <div id="add_product" class="tab-pane fade " >
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Enter the Product Name</label>
                <input type='text' class="form-control" id='newproductname' name='newproductname'>
            </div>
            <input type="submit" name="new-product" id="new-product"
                                                class=" btn btn-primary" value="Submit">
        </form>  
    </div>
    <!-- Add Restaurant Name -->
    <div id="add_restaurant" class="tab-pane fade" >
        <form>
            <div class="form-group">
                <label for="#">Enter the Restaurant Name</label>
                <input type='text'  class="form-control" id='newrestaurantname' name='newrestaurantname'>
            </div>
            <div class="form-group">
                <label for="#">Address</label>
                <input type='text'  class="form-control" id='address' name='address'>
            </div>
            <div class="form-group">
                <label for="#">Mobile</label>
                <input type='number'  class="form-control" id='mobile' name='mobile'>
            </div>
            <input type="submit" name="new-restaurant" id="new-restaurant"
                                            class="btn btn-primary" value="Submit">
        </form>  
    </div>
    <!-- Warehouse Purchase -->
    <div id="warehouse_purchase" class="tab-pane fade" >
        <form class="form-horizontal"  action=""  method="post">
            <div class='form-group'>
                <div class='col-sm-5'>
                    <label class='#' > Product's Name :</label>
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
                                <option value="<?php echo $row['product_name']; ?>"><?php echo $row['product_name']; ?></option><?php
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
                    <input type="submit" name="product-submit" id="product-submit"
                    class=" btn btn-primary" value="Submit">
                </div>  
            </div>
        </form>
    </div>
    <!-- Warehouse Purchase Report -->
    <div id="warehouse_report" class="tab-pane fade" >
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
                    <input type="submit" name="showmprd" id="showmprd" class="btn btn-primary" value="Show">
                </div>
            </div>
        </form>
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
                            echo "<td>". round($mthc[2],2)."</td>";
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
    </div>  
    <!-- Restaurant Purchase -->
    <div id="restaurant_purchase" class="tab-pane fade" >
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
                    <input type="submit" name="product-submit1" id="product-submit1"
                            class=" btn btn-primary" value="Submit">
                </div>
            </div>
        </form>
    </div>
    <!-- Restaurant Sales Report -->
    <div id="restaurant_report" class="tab-pane fade" >
        <form class='form-horizontal'  id="productsold" method="post" action="">
                    <div class='form-group'>
                        <div class='col-sm-5'>
                            <label class='control-label' for='pname1' > Restaurant Name :</label>
                        </div>
                        <div class='col-sm-7'>
                            <select  id='res_pur_name' name="res_pur_name" class="pname1">
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
                            <label class='control-label ' for='pbrand1'>From Date :</label>
                        </div>
                        <div class='col-sm-7'>
                            <input type='date' class="form-control" id='res_pur_fromdate' name='res_pur_fromdate'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-5'>
                            <label class='control-label ' for='pbrand1'>To Date :</label>
                        </div>
                        <div class='col-sm-7'>
                            <input type='date' class="form-control" id='res_pur_todate' name='res_pur_todate'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-10'>
                            <input type="submit" name="showrespur" id="showrespur"
                                    class=" btn btn-primary" value="Show">
                        </div>
                    </div>
                </form>
                <div class="panel-footer">
                    <?php
                        if(isset($_REQUEST["showrespur"]))
                        {
                            $r_id= mysqli_query($con,"select restaurant_id from restaurant WHERE restaurant_name='$res_pur_name'");
                            $r_id1=  mysqli_fetch_assoc($r_id);
                            $restaurant_id= $r_id1['restaurant_id'];

                            $mthch= mysqli_query($con, "select a.purchase_date AS 'Date',b.product_name AS 'Product Name',a.quantity as 'Quantity' from restaurant_stock a left join product b on a.product_id=b.product_id WHERE a.restaurant_id=$restaurant_id AND a.purchase_date BETWEEN '$res_pur_fromdate' AND '$res_pur_todate'");

                            echo "<hr>" ;
                            echo "<table class='table table-bordered'>";
                            echo "<th>Date</th>";
                            echo "<th>Product Name</th>";
                            echo "<th>Quantity</th>";
                            while($mthc = mysqli_fetch_array($mthch))
                            {
                                echo "<tr>";
                                echo "<td>". $mthc[0]."</td>";
                                echo "<td>". $mthc[1]."</td>";
                                echo "<td>". $mthc[2]."</td>";
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
            </div>
    <!-- Restaurant Details -->
    <div id=restaurant_details class="tab-pane fade">
        <table class="table table-striped" style="width:100%">
            <thead >
                <tr>
                    <th>Restaurant Name</th>
                    <th>Address</th>
                    <th>Mobile</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    $dea= mysqli_query($con, "select * from restaurant");
                    while($deal = mysqli_fetch_array($dea))              
                    {
                ?>
                <tr>
                    <td><?php echo $deal[1] ?></td>
                    <td><?php echo $deal[2] ?></td>
                    <td><?php echo $deal[3] ?></td>
                </tr>
                    <?php } ?> 
            </tbody>
        </table>     
    </div>
    <!-- Warehouse_Transaction -->
    <div id="warehouse_transaction"  class="tab-pane fade"> 
        <center><h4>TOTAL PURCHASE TRANSACTION</h4><center>     
        <?php 
        $totpur = mysqli_query($con,"select b.product_name as 'Product Name',SUM(a.quantity) as 'Quantity',SUM(a.quantity*a.price) as 'Total Cost' from productprice a inner join product b on a.product_id=b.product_id GROUP BY a.product_id");
        $totalcost = 0;
        while($purval=mysqli_fetch_array($totpur))
        {
            $totalcost=$totalcost+$purval['Total Cost'];
        }
        echo "<h4>Total purchase price till date :<b> Rs. ". $totalcost."</b></h4>";
        
        echo '<br>';
        $namepur = mysqli_query($con,"select b.product_name as 'Product Name',SUM(a.quantity) as 'Quantity',SUM(a.quantity*a.price) as 'Total Cost',AVG(a.price) as 'Average Cost per Unit',MAX(a.price) as 'Maximum Cost per Unit',MIN(a.price) as 'Minimum Cost per Unit' from productprice a inner join product b on a.product_id=b.product_id GROUP BY a.product_id");
        echo "<br><center>TOTAL PURCHASE TILL DATE (ACCORDING TO PRODUCT)</center>";
        ?>
        <?php       
        echo "<hr>" ;
        echo "<table class='table table-bordered'>";
        echo "<th> Product Name </th>";
        echo "<th> Quantity </th>";
        echo "<th> Total Cost (Rs.)</th>";
        echo "<th> Average Cost (Rs.)</th>";
        echo "<th> Maximum Cost (Rs.)</th>";
        echo "<th> Minimum Cost (Rs.)</th>";
        while($nameval=mysqli_fetch_array($namepur))
        {
            echo "<tr>";
            echo "<td>". $nameval['Product Name'] . "</td>";
            echo "<td>". $nameval['Quantity'] . "</td>";
            echo "<td>". round($nameval['Total Cost'],2)."</td>";
            echo "<td>". round($nameval['Average Cost per Unit'],2)."</td>";
            echo "<td>". round($nameval['Maximum Cost per Unit'],2)."</td>";
            echo "<td>". round($nameval['Minimum Cost per Unit'],2)."</td>";
            echo "</tr>";
            
        }
        
        
            echo "<tr>";
            echo "<td colspan=6>";
            echo '<center><a href="tpurtrans.php" class="btn btn-dark text-white" style="color:black;"> Download Excel File </a></center>';
            echo "</td>";
            echo "</tr>";
            echo "</table>";                                          
        ?>
    </div>
    <!-- Sales_Transaction -->
    <div id="restaurant_transaction"  class="tab-pane fade"> 
        <center><h4>TOTAL SALES TRANSACTION</h4><center>     
        <?php                                              
                $namesal = mysqli_query($con,"select b.restaurant_name as 'Restaurant Name',c.product_name as 'Product Name',SUM(a.quantity) as 'Quantity' from restaurant_stock a inner join restaurant b on a.restaurant_id=b.restaurant_id inner join product c on c.product_id=a.product_id GROUP BY a.product_id");
                echo "<br><center>TOTAL PURCHASE TILL DATE(ACCORDING TO PRODUCT)</center>" ;
                ?>
                
                <?php
                echo "<hr>" ;
                echo "<table class='table table-bordered'>";
                echo "<th> Restaurant Name </th>";
                echo "<th> Product Name </th>";
                echo "<th> Quantity </th>";
                while($nameva=mysqli_fetch_array($namesal))
                {
                    echo "<tr>";
                    echo "<td>". $nameva['Restaurant Name'] . "</td>";
                    echo "<td>". $nameva['Product Name']."</td>";
                    echo "<td>". $nameva['Quantity'] . "</td>";
                    echo "</tr>";
                }
                
                echo "<tr>";
                    echo "<td colspan=3>";
                    echo '<center><a href="tsaletrans.php" class="btn btn-dark text-white" style="color:black;"> Download Excel File </a></center>';
                    echo "</td>";
                    echo "</tr>";
                echo "</table>";   
                ?>
    </div>   
</div>
<script>
// Hide submenus
$('#body-row .collapse').collapse('hide'); 

// Collapse/Expand icon
$('#collapse-icon').addClass('fa-angle-double-left'); 

// Collapse click
$('[data-toggle=sidebar-colapse]').click(function() {
    SidebarCollapse();
});

function SidebarCollapse () {
    $('.menu-collapsed').toggleClass('d-none');
    $('.sidebar-submenu').toggleClass('d-none');
    $('.submenu-icon').toggleClass('d-none');
    $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
    
    // Treating d-flex/d-none on separators with title
    var SeparatorTitle = $('.sidebar-separator-title');
    if ( SeparatorTitle.hasClass('d-flex') ) {
        SeparatorTitle.removeClass('d-flex');
    } else {
        SeparatorTitle.addClass('d-flex');
    }
    
    // Collapse/Expand icon
    $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
}
function catdisplay(){
    show('cat');
    hide('brn');
    hide('cst');
}
function brndisplay(){
    hide('cat');
    show('brn');
    hide('cst');
}
function cstdisplay(){
    hide('cat');
    hide('brn');
    show('cst');
}
function hide(obj){
    var el = document.getElementById(obj);
    el.style.display = 'none';
}
function show(obj){
    var el = document.getElementById(obj);
    el.style.display = 'block';
}
</script>
<style>
    body {
        padding-top: 56px;
        overflow: hidden;
    }

    .sticky-offset {
        top: 56px;
    }

    #body-row {
        margin-left:0;
        margin-right:0;
    }
    #sidebar-container {
        min-height: 100vh;   
        background-color: #333;
        padding: 0;
    }

    /* Sidebar sizes when expanded and expanded */
    .sidebar-expanded {
        width: 230px;
    }
    .sidebar-collapsed {
        width: 60px;
    }

    /* Menu item*/
    #sidebar-container .list-group a {
        height: 50px;
        color: white;
    }

    /* Submenu item*/
    #sidebar-container .list-group .sidebar-submenu a {
        height: 45px;
        padding-left: 30px;
    }
    .sidebar-submenu {
        font-size: 0.9rem;
    }

    /* Separators */
    .sidebar-separator-title {
        background-color: #333;
        height: 35px;
    }
    .sidebar-separator {
        background-color: #333;
        height: 25px;
    }
    .logo-separator {
        background-color: #333;    
        height: 60px;
    }

    /* Closed submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="false"] .submenu-icon::after {
    content: " \f0d7";
    font-family: FontAwesome;
    display: inline;
    text-align: right;
    padding-left: 10px;
    }
    /* Opened submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="true"] .submenu-icon::after {
    content: " \f0da";
    font-family: FontAwesome;
    display: inline;
    text-align: right;
    padding-left: 10px;
    }
</style>
</body>
</html>