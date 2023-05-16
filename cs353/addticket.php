<?php
    include("config.php");
    session_start();
    $error = "";

    if (isset($_POST['add_ticket'])) 
    {
        $event_id = mysqli_real_escape_string($db, $_GET['id']);
        $glob_name = $_SESSION['user_id'];

        $ticket_type = mysqli_real_escape_string($db, $_POST['ticket_type']);
        $ticket_price = mysqli_real_escape_string($db, $_POST['price']);
        try {
            $sql = "INSERT INTO ticket( event_id, ticket_type, ticket_price )
                    VALUES ( '$event_id', '$ticket_type', '$ticket_price' )";
            $res = mysqli_query($db, $sql);
        } catch (mysqli_sql_exception) {
            $error = "Ticket Type Already Exists!";
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
        <script>
            function validateForm()
            {
                var ticket_type = document.forms['add_ticket_form']['ticket_type'];
                var price = document.forms['add_ticket_form']['price'];
                
                if(ticket_type.value == "" || price.value == "")
                {
                    alert("Please fill out all the information.");
                    return false;
                }
                else if ($error == "")
                {
                    alert("Ticket has been created");
                    return true;
                }
            }
        </script>
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
                <h2><b>Add Ticket</b></h2>
                <br>
                <form name="add_ticket_form" action="" method="post" onsubmit="return validateForm()">
                    <label><b>Ticket Type:</b></label>
                    <input type="ticket_type" name="ticket_type"class="form-control">
                    <br>
                    <label><b>Price:</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input name="price" type="number" min="0" class="form-control" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text">.00</span>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <div align="center">
                            <input type="submit" class="btn btn-primary" name="add_ticket" value="Add Ticket">
                        </div>
                        <div style = "font-size:20px; text-align:center; margin-top:20px; color:purple"><b><?php echo $error; ?></b></div>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>