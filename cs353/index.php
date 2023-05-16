<?php
   include("config.php");
   session_start();
    $error = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
  
        $email = mysqli_real_escape_string($db,$_POST['email']);
        $password = mysqli_real_escape_string($db,$_POST['password']);
  
        $sql = "SELECT user_id FROM any_user WHERE user_id = '$email' and password = '$password' ";
        $sql_civ = "SELECT user_id FROM civilian WHERE user_id = '$email'";
        $sql_admin = "SELECT user_id FROM admin WHERE user_id = '$email'";

        $res = mysqli_query($db,$sql);
        $res_civ = mysqli_query($db,$sql_civ);
        $res_admin = mysqli_query($db,$sql_admin);

        $count = mysqli_num_rows($res);
        $count_civ = mysqli_num_rows($res_civ);
        $count_admin = mysqli_num_rows($res_admin);
  
        if($count == 1) 
        {
           $_SESSION['user_id'] = $email;
           if($count_civ == 1)
           {
                header("location: eventlist.php");
           }
           else if($count_admin == 1)
           {
                header("location: adminpage.php");
           }
        }
        else 
        {
           $error = "Login Error";
        }
     }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Login Page</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        
        <style type="text/css">
            body{
                font: 15px;
                position: absolute;;; top: 25%; width: 100%; height: 1px; overflow: visible;
            }
            .container{ 
                width: 600px; 
                padding: 100px;
                border-style: solid;
                border-radius: 25px;
                border-color: darkorange;
                background-color: lightgrey;
            }
            h2 {
                text-align: center;
                color: darkorange;
            }
            label{color: purple;}
        </style>
        
        <script>
            function validateForm()
            {
                var email = document.forms['loginform']['email'];
                var password = document.forms['loginform']['password'];
                
                if(email.value == "" || password.value == "")
                {
                    alert("Email and Password must be filled out.");
                    return false;
                }
                
                else
                {
                    return true;
                }
            }
        </script>

    </head>

    <body>
        <div class="container">
            <div class = "offset-md-0 col-md-0">
                <h2><b>LOG IN</b></h2>
                <br>
                <form name="loginform" action="" method="post" onsubmit="return validateForm()">
                    <label><b>Email:</b></label>
                    <input type="email" name="email" class="form-control">
                    <br>
                    <label><b>Password:</b></label>
                    <input type="password" name="password" class="form-control">
                    <br>
                    <br>
                    <div class="form-group">
                        <div align="center">
                            <input type="submit" class="btn btn-primary" value="Login">
                            <a href="register.php" class="btn btn-secondary">Register</a>
                            <div style = "font-size:20px; color:purple; margin-top:40px"><b><?php echo $error; ?></b></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>