<?php
    include("config.php");
    session_start();
    $glob_name = $_SESSION['user_id'];
    $sql_original_balance = "SELECT balance FROM civilian WHERE user_id = '$glob_name'"; 
    $res_balance = mysqli_query($db, $sql_original_balance);
    $original_balance = ($res_balance -> fetch_array())[0];

    $souvenir_id = mysqli_real_escape_string($db, $_GET['id']);
    $souvenir_sql = "SELECT souvenir_name, souvenir_price FROM souvenir WHERE souvenir_id = '$souvenir_id' ";
    $res_souvenir = mysqli_query($db, $souvenir_sql);
    $first_row = $res_souvenir->fetch_assoc();
    $souvenir_name = $first_row['souvenir_name'];
    $souvenir_price = $first_row['souvenir_price'];


    $error = "";

    if (isset($_POST['add_balance'])) 
    {
        $balance_to_add= mysqli_real_escape_string($db, $_POST['add_balance_val']);
        echo $balance_to_add;

        $sql = "UPDATE civilian SET balance = balance + '$balance_to_add' WHERE user_id = '$glob_name'";
        $res = mysqli_query($db, $sql);

        header("location: checkout_souvenir.php?id=" . $souvenir_id );
    }

    if (isset($_POST['confirm_purch'])) 
    {
        if( $souvenir_price > $original_balance )
        {
            $error = "Not enough balance.";
        }
        else
        {
            $sql = "UPDATE civilian SET balance = balance - '$souvenir_price' WHERE user_id = '$glob_name'";
            $res = mysqli_query($db, $sql);

            $sql = "INSERT INTO buy_souvenir( user_id, souvenir_id )
                    VALUES ( '$glob_name', '$souvenir_id' )";
            $res = mysqli_query($db, $sql);
            header("location: souvenirlist.php?id=" . $souvenir_id );
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
                position: absolute;;; top: 10%; width: 100%; height: 1px; overflow: visible;
            }
            .container{ 
                width: 600px; 
                padding: 100px;
                border-style: solid;
                border-radius: 25px;
                border-color: purple;
                background-color: lightgrey;
            }
            h2 {
                text-align: center;
                color: darkorange;
            }
            label{color: purple;}
            
        </style>
    </head>

    <body>
    <body>
        <!-- top navbar -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: #621F87;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Event Application</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="eventlist.php">Available Events</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="upcomingevents.php">Upcoming Events</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="myevents.php">My Events</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="createevent.php">Create Event</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="ticketlist.php">My Tickets</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="souvenirlist.php">My Souvenirs</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class = "offset-md-0 col-md-0">
                <h2><b>Checkout Page</b></h2>
                <br>
                <form name="eventform" action="" method="post">
                    <label><b>Select a Payment Method:</b></label>
                    <select name="type" class="form-select">
                        <option value="Balance">Balance</option>
                        <option value="EFT">EFT</option>
                        <option value="Paypal">Paypal</option>
                        <option value="Credit Card">Credit Card</option>
                    </select>
                    <br>
                    <label><b>Add Balance:</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" name="add_balance_val" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text">.00</span>
                    </div>
                    <div style = "font-size:25px; color:purple; margin-top:50px; text-align:center"><b>Balance: $<?=$original_balance;?></b></div>
                    <br>
                    <br>
                    <div class="form-group">
                        <div align="center">
                            <input type="submit" class="btn btn-success" name= "add_balance" value="Add Balance">
                        </div>
                    </div>
                    <div style = "font-size:25px; color:purple; margin-top:50px; text-align:center"><b>Purchase Details: </b></div>
                    <div style = "font-size:15px; color:black; margin-top:10px; text-align:center"><b>Souvenir Name: <?=$souvenir_name;?></b></div>
                    <div style = "font-size:15px; color:black; margin-top:10px; text-align:center"><b>Price: $<?=$souvenir_price;?></b></div>
                    <br>
                    <div class="form-group">
                        <div align="center">
                            <input  name= "confirm_purch" type="submit" value="Confirm and Purchase" class="btn btn-primary btn">
                        </div>
                        <div style = "font-size:20px; text-align:center; margin-top:20px; color:purple"><b><?php echo $error; ?></b></div>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>