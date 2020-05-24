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

  $mnthsel=$_REQUEST["mnthsel"];
  
$adold = $_REQUEST["adoldpas"];
$adnew  = $_REQUEST["adnewpas"];
$adcon = $_REQUEST["adconnpas"];

//change password

if(isset($_REQUEST["adpassub"]))
{
    
    $getad = mysqli_query($con,"select * from t_dealer where d_email='".$_SESSION['ad']."' and d_pswd='". $adold."'");
    
    if($adnew==$adcon)  
    {
      if(mysqli_num_rows($getad)>0)
      {
         mysqli_query($con,"update t_dealer set d_pswd='".$adnew."' where d_email ='".$_SESSION['ad']."'");

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
        <title>Dealer's Dashboard</title>
        
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">
        <script src="bootstrap/jquery.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="css/div.css">
        <link rel="stylesheet" href="css/dashboard.css">
        
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
                  $("#qun").hide();
                  $("#tcst").hide();
              });
              $("#orderby1").click(function(){
                  $("#brn").show();
                  $("#cat").hide();
                  $("#cst").hide();
                  $("#qun").hide();
                  $("#tcst").hide();
             }); 
             $("#orderby2").click(function(){
                 $("#cst").show();
                 $("#brn").hide();
                  $("#cat").hide();
                  $("#qun").hide();
                  $("#tcst").hide();
             }); 
             $("#orderby3").click(function(){
                 $("#qun").show();
                 $("#brn").hide();
                  $("#cat").hide();
                  $("#cst").hide();
                  $("#tcst").hide();
             }); 
             $("#orderby4").click(function(){
                 $("#tcst").show();
                 $("#brn").hide();
                  $("#cat").hide();
                  $("#qun").hide();
                  $("#cst").hide();
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
                <li><a data-toggle="tab" href="#tran">Transaction</a></li>
                <li><a data-toggle="tab" href="#chpas">Change Password</a></li>
            </ul>
            
            <div class="tab-content" style="margin-top: 30px;">
                <div class="tab-pane fade in active" id="npe">
                <div class="container">
                    
                    <div class="panel panel-default">
                            <div class="panel-heading"> 
                                <h5 class="panel-title">
                                    <center>MONTHLY PURCHASES</center>
                                </h5>
                            </div>
                            <form action="dealer.php" method="post">
                            <div class="panel-body">
                                
                                    <div class="row">
                                        <div class="col-sm-6">
                                            Select a particular month : 
                                            <select  name="mnthsel" id="mnthsel" style="width:30%">
                                                <option>----MONTH----</option>
                                                <option>Jan</option>
                                                <option>Feb</option>
                                                <option>Mar</option>
                                                <option>Apr</option>
                                                <option>May</option>
                                                <option>Jun</option>
                                                <option>Jul</option>
                                                <option>Aug</option>
                                                <option>Sep</option>
                                                <option>Oct</option>
                                                <option>Nov</option>
                                                <option>Dec</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="submit"  name="showmprd" id="showmprd" value="Show">
                                        </div>
                                    </div>
                                    <hr>
                                  
                            </div>
                            <div class="panel-footer">
                                
                                <?php
                                    $mthch= mysqli_query($con, "SELECT t_soldprd.p_sname,t_soldprd.p_sdesc,t_soldprd.p_sbrand, t_soldprd.p_scost,t_soldprd.p_squantity FROM
                                    t_saletrans INNER JOIN t_soldprd ON t_saletrans.p_sid=t_soldprd.p_sid WHERE s_tdate LIKE '%$mnthsel%' and d_email='".$_SESSION['ad']."'");
                                    
                                    echo "<hr>" ;
                                           
                                    if(isset($_REQUEST["showmprd"]))
                                    {
                                          echo "<table class='table table-bordered'>";
                                          echo "<th>Category</th>";
                                           echo "<th>Brand</th>";
                                           echo "<th>Model Details</th>";
                                           echo "<th>Cost per Item</th>";
                                           echo "<th>Quantity</th>";
                                           while($mthc = mysqli_fetch_array($mthch))              
                                           {
                                              echo "<tr>";
                                              echo "<td>". $mthc[0]."</td>";
                                              echo "<td>". $mthc[1]."</td>";
                                              echo "<td>". $mthc[2]."</td>";
                                              echo "<td>". $mthc[3]."</td>";
                                              echo "<td>". $mthc[4]."</td>";
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
                             </form>    
                        </div>
                    
                <div class="panel panel-default">
                    
                    <div class="panel-heading"> 
                        <center><h4>STOCKS PURCHASED</h4></center>
                    </div>
                    <div class="panel-body">
                        Arrange according to :
                        <input type="button" name="orderby" id="orderby" value="Category" class="btn btn-link">
                        <input type="button" name="orderby1" id="orderby1" value="Brand" class="btn btn-link">
                        <input type="button" name="orderby2" id="orderby2" value="Cost per Item" class="btn btn-link">
                        <input type="button" name="orderby3" id="orderby3" value="Quantity" class="btn btn-link">
                        <input type="button" name="orderby4" id="orderby4" value="Total Cost" class="btn btn-link">
                     </div>
                    <form class='form-horizontal' id="stockav" method="post"> 
                    
                        
                           <div class="panel-footer" id="cat">
                               
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr= mysqli_query($con, "SELECT * FROM t_soldprd INNER JOIN t_saletrans ON t_saletrans.p_sid=t_soldprd.p_sid where d_email='".$_SESSION['ad']."'");
                                             while($avprr = mysqli_fetch_array($avpr))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $avprr[1] ?></td>
                                         <td><?php echo $avprr[3] ?></td>
                                         <td><?php echo $avprr[2] ?></td>
                                         <td><?php echo $avprr[4] ?></td>
                                         <td><?php echo $avprr[5] ?></td>
                                         <td><?php echo $avprr[6] ?></td>
                                     </tr>
                                     
                                     
                                    
                                    <?php
                                             }
                                     ?>
                                  
                                 </tbody>
                             </table>     
                           </div>



                          <div class="panel-footer" id="brn" hidden>
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>
                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr1= mysqli_query($con, "SELECT * FROM t_soldprd INNER JOIN t_saletrans ON t_saletrans.p_sid=t_soldprd.p_sid where d_email='".$_SESSION['ad']."' ORDER BY `t_soldprd`.`p_sbrand` ASC");
                                                             while($avprr1 = mysqli_fetch_array($avpr1))              
                                             {
                                     ?>

                                     <tr>                                             
                                         <td><?php echo $avprr1[1] ?></td>
                                         <td><?php echo $avprr1[3] ?></td>
                                         <td><?php echo $avprr1[2] ?></td>
                                         <td><?php echo $avprr1[4] ?></td>
                                         <td><?php echo $avprr1[5] ?></td>
                                         <td><?php echo $avprr1[6] ?></td>
                                       
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                    
                                 </tbody>
                             </table>     
                           </div> 


                           <div class="panel-footer" id="cst" hidden>
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr2= mysqli_query($con, "SELECT * FROM t_soldprd INNER JOIN t_saletrans ON t_saletrans.p_sid=t_soldprd.p_sid where d_email='".$_SESSION['ad']."' ORDER BY `t_soldprd`.`p_scost` ASC");
                                             while($avprr2 = mysqli_fetch_array($avpr2))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $avprr2[1] ?></td>
                                         <td><?php echo $avprr2[3] ?></td>
                                         <td><?php echo $avprr2[2] ?></td>
                                         <td><?php echo $avprr2[4] ?></td>
                                         <td><?php echo $avprr2[5] ?></td>
                                         <td><?php echo $avprr2[6] ?></td>
                                       
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                     
                                 </tbody>
                             </table>     
                           </div>



                           <div class="panel-footer" id="qun" hidden>
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr3= mysqli_query($con, "SELECT * FROM t_soldprd INNER JOIN t_saletrans ON t_saletrans.p_sid=t_soldprd.p_sid where d_email='".$_SESSION['ad']."' ORDER BY `t_soldprd`.`p_squantity` ASC");
                                             while($avprr3 = mysqli_fetch_array($avpr3))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $avprr3[1] ?></td>
                                         <td><?php echo $avprr3[3] ?></td>
                                         <td><?php echo $avprr3[2] ?></td>
                                         <td><?php echo $avprr3[4] ?></td>
                                         <td><?php echo $avprr3[5] ?></td>
                                         <td><?php echo $avprr3[6] ?></td>
                                        
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                     
                                 </tbody>
                             </table>     
                           </div>


                           <div class="panel-footer" id="tcst" hidden>
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr4= mysqli_query($con, "SELECT * FROM t_soldprd INNER JOIN t_saletrans ON t_saletrans.p_sid=t_soldprd.p_sid where d_email='".$_SESSION['ad']."' ORDER BY `t_soldprd`.`p_stot_cost` ASC");
                                             while($avprr4 = mysqli_fetch_array($avpr4))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $avprr4[1] ?></td>
                                         <td><?php echo $avprr4[3] ?></td>
                                         <td><?php echo $avprr4[2] ?></td>
                                         <td><?php echo $avprr4[4] ?></td>
                                         <td><?php echo $avprr4[5] ?></td>
                                         <td><?php echo $avprr4[6] ?></td>
                                   
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                     
                                 </tbody>
                             </table>     
                           </div>
                        
                        
                            
                       <!--<center><input type="submit" name="pdel" value ="Remove" onclick="return validate();"></center>-->
     
                      </form>
                     </div>
                   </div>
                  </div>
                
                
                
                
                <div id="tran" class="tab-pane fade" >
                    <form id="viewtran">
                        <div class="container">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <center><h4>TOTAL SALES TRANSACTION</h4></center>
                                    </div>
                                    <div class="panel-body">
                                         <?php 
                                           $totpur = mysqli_query($con,"SELECT SUM(p_stot_cost) FROM t_soldprd INNER JOIN t_saletrans ON t_saletrans.p_sid=t_soldprd.p_sid where d_email='".$_SESSION['ad']."'");
                                                                                   
                                           while($purval=mysqli_fetch_array($totpur))
                                           {
                                                echo "<h4>Total purchase price till date :<b> Rs. ". $purval['SUM(p_stot_cost)']."</b></h4>";
                                           }
                                           echo '<br>';
                                           
                                           $namepur = mysqli_query($con,"SELECT Ucase(p_sname), SUM(p_stot_cost),AVG(p_stot_cost),MAX(p_stot_cost),
                                               MIN(p_stot_cost) FROM t_soldprd INNER JOIN t_saletrans ON t_saletrans.p_sid=t_soldprd.p_sid where d_email='".$_SESSION['ad']."' group by p_sname");
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
                                              echo "<td>". $nameval['Ucase(p_sname)'] . "</td>";
                                              echo "<td>". $nameval['SUM(p_stot_cost)']."</td>";
                                              echo "<td>". $nameval['AVG(p_stot_cost)']."</td>";
                                              echo "<td>". $nameval['MAX(p_stot_cost)']."</td>";
                                              echo "<td>". $nameval['MIN(p_stot_cost)']."</td>";
                                              echo "</tr>";
                                              
                                           }
                                           
                                          
                                              echo "<tr>";
                                              echo "<td colspan=5>";
                                            //  echo '<center><a href="tpurtrans.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                              echo "</table>";
                                           
                                           $datepur = mysqli_query($con,"SELECT Ucase(p_sname),substring(s_tdate,4,3), SUM(p_stot_cost),AVG(p_stot_cost),MAX(p_stot_cost),
                                               MIN(p_stot_cost) FROM t_soldprd INNER JOIN t_saletrans ON t_saletrans.p_sid=t_soldprd.p_sid where d_email='".$_SESSION['ad']."' group by substring(s_tdate,4,3)");
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
                                              echo "<td>". $dateval['substring(s_tdate,4,3)'] . "</td>";
                                              echo "<td>". $dateval['SUM(p_stot_cost)']."</td>";
                                              echo "<td>". $dateval['AVG(p_stot_cost)']."</td>";
                                              echo "<td>". $dateval['MAX(p_stot_cost)']."</td>";
                                              echo "<td>". $dateval['MIN(p_stot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                             // echo '<center><a href="tpurtrm.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
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
                        <form action="dealer.php" method="post">
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
                            </form>
                    </div>
                </div>
                
                
                
                      </div>
                    </div>
            </body>
        </html>
           