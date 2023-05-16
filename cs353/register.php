<?php
   include("config.php");
   session_start();
    $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $today = date('Y-m-d');
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $surname = mysqli_real_escape_string($db, $_POST['surname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phonenum = mysqli_real_escape_string($db, $_POST['phonenum']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $date_of_birth = mysqli_real_escape_string($db, $_POST['birthdate']);
    $age = (date_diff(date_create($date_of_birth), date_create($today))) -> format('%y');


    try {
        $sql = "INSERT INTO any_user(user_id, password, first_name, last_name, email, phone_num, 
        date_of_birth, gender, age)
      VALUES ('$email', '$password', '$name', '$surname', '$email', '$phonenum', '$date_of_birth', 
        '$gender', '$age')";

        $sql_civ = "INSERT INTO civilian(user_id, balance) VALUES ('$email', '0')";
        $res = mysqli_query($db, $sql);
        $res_civ = mysqli_query($db, $sql_civ);
        header("location: index.php");
        } catch (mysqli_sql_exception) {
            $error = "This email already exists!";
        }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <style type="text/css">
            body{
                font: 15px;
                position: absolute;;; top: 10%; width: 100%; height: 1px; overflow: visible;
            }
            .container{ 
                width: 600px; 
                padding: 100px;
                border-style: solid;
                border-radius: 25px;
                border-color: darkorange;
                background-color: lightgrey;
            }
            h2 
            {
                text-align: center;
                color: darkorange;
            }
            label{color: purple;}
            
        </style>
        <script>
            function validateForm()
            {
                var name = document.forms['registerform']['name'];
                var surname = document.forms['registerform']['surname'];
                var email = document.forms['registerform']['email'];
                var phonenum = document.forms['registerform']['phonenum'];
                var password = document.forms['registerform']['password'];
                var date_of_birth = document.forms['registerform']['dob'];
                
                if(name.value == "" || surname.value == "" || email.value == "" || phonenum.value == "" || password.value == "" || date_of_birth.value == "")
                {
                    alert("Please fill out all the information.");
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
                <h2><b>REGISTER</b></h2>
                <br>
                <div style = "font-size:20px; color:purple"><b><?php echo $error; ?></b></div>
                <form name="registerform" action="" method="post" onsubmit="return validateForm()">
                    <label><b>Name:</b></label>
                    <input type="name" name="name"class="form-control">
                    <br>
                    <label><b>Surname:</b></label>
                    <input type="surname" name="surname"class="form-control">
                    <br>
                    <label><b>Email Adress:</b></label>
                    <input type="email" name="email" class="form-control">
                    <br>
                    <label><b>Phone Number:</b></label>
                    <input type="phonenum" name="phonenum" class="form-control">
                    <br>
                    <label><b>Password:</b></label>
                    <input type="password" name="password" class="form-control">
                    <br>
                    <label><b>Gender:</b></label>
                    <select class="form-select" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <br>
                    <label><b>Date of Birth:</b></label>
                    <input id="dob" class="form-control" type="date" name="birthdate" />
                    <br>
                    <br>
                    <div class="form-group">
                        <div align="center">
                            <input type="submit" class="btn btn-primary" value="Register">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>