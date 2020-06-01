<?php
session_start();
error_reporting(0);
include 'db.php';
$con = GetConn();
if(!isset($con))
{
    die("Database Not Found");
    echo "not connected";
}

if(isset($_REQUEST["newlogin"]))
{
    $slgid = $_REQUEST["aid"];
    $slgps= $_REQUEST["apas"];
    

    if($slgid!=''&& $slgps!=='')
    {
        $query = mysqli_query($con, "select * from t_user where a_email ='$slgid' and a_pswd ='$slgps'");
        $res   = mysqli_fetch_row($query);
        
        $query1 = mysqli_query($con, "select * from t_supplier where s_email ='" .$slgid. "' and s_pswd ='" .$slgps. "'");
        $res1  = mysqli_fetch_row($query1);
        
        $query2 = mysqli_query($con, "select * from t_dealer where d_email ='" .$slgid. "' and d_pswd ='" .$slgps. "'");
        $res2   = mysqli_fetch_row($query2);

    echo $res;

        if($res)
        {
            $_SESSION['ad'] = $slgid;
            header('location:layout.php');
        }
        
        else if($res1)
        {
            $_SESSION['ad'] = $slgid;
            header('location:supplier.php');
        }
        
        else if($res2)
        {
            $_SESSION['ad'] = $slgid;
            header('location:dealer.php');
        }
        else
        {
            echo '<script> alert("Invalid Login ! Please try again. ")</script>';
        }
    }
    else
    {
        echo '<script>';
        echo 'alert("Enter both username and password")';
        echo '</script>';
 
    }
}

    

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        
        <title>WAREHOUSE MANAGEMENT SYSTEM</title>
        
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
            input[type="text"]:focus,input[type="email"]:focus,input[type="password"]:focus
            
            {
                border: #000;
                box-shadow: 0 0 10px  #000;
                
            }   
            
            input[type="text"],input[type="email"],input[type="password"]
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
            </style>
        
    </head>
    <body>
    <center>
        <div class="container">
          <img src="images/sanstechno.jpeg">
        </div>
       </center> <br>
        
            <form name="login" method="post" action="index.php">
                 <center>   
        <div class="container">
  <div class="jumbotron">
    <h4>Please Login</h4> 

        <input type='text' class="form-control" id='aid' name='aid' placeholder="Enter your email"><br>
    <input type='password' class="form-control" id='apas' name='apas' placeholder="Enter your password"><br>
    
     <center><input type="submit" name="newlogin" id="newlogin" class="form-control btn btn-login" value="LOGIN"></center>
  </div>
  
</div>
     </center>   
        </form>

    </body>
</html>
