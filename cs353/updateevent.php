<?php
   include("config.php");
   session_start();
    $error = "";

    if(isset($_POST['update_event']))
    {
        $event_id = mysqli_real_escape_string($db, $_GET['id']);
        $event_name = mysqli_real_escape_string($db, $_POST['event_name']);
        $location = mysqli_real_escape_string($db, $_POST['location']);
        $event_date = mysqli_real_escape_string($db, $_POST['event_date']);
        $start_time = mysqli_real_escape_string($db, $_POST['start_time']);
        $end_time = mysqli_real_escape_string($db, $_POST['end_time']);
        $type = mysqli_real_escape_string($db, $_POST['type_sel']);
        $age_restriction = mysqli_real_escape_string($db, $_POST['age_restriction']);
        $quota = mysqli_real_escape_string($db, $_POST['quota']);

        $query = "UPDATE any_event SET event_name='$event_name', address ='$location', event_date ='$event_date', start_time ='$start_time', end_time ='$end_time', type= '$type', age_restriction = '$age_restriction', quota ='$quota' 
                    WHERE event_id ='$event_id'";
        $query_run = mysqli_query($db, $query);

        header("location: myevents.php");
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
                var event_name = document.forms['update_event_form']['event_name'];
                var location = document.forms['update_event_form']['location'];
                var event_date = document.forms['update_event_form']['event_date'];
                var start_time = document.forms['update_event_form']['start_time'];
                var end_time = document.forms['update_event_form']['end_time'];
                var age_restriction = document.forms['update_event_form']['age_restriction'];
                var quota = document.forms['update_event_form']['quota'];
                
                if(event_name.value == "" || location.value == "" || event_date.value == "" ||start_time.value == "" || end_time.value == "" || age_restriction.value == "" || quota.value == "")
                {
                    alert("Please fill out all the information.");
                    return false;
                }
                
                else
                {
                    alert("Selected event has been updated successfully");
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
            <?php
            if(isset($_GET['id']))
            {
                $event_id = mysqli_real_escape_string($db, $_GET['id']);
                $query = "SELECT * FROM any_event WHERE event_id ='$event_id '";
                $query_run = mysqli_query($db, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    $event = mysqli_fetch_array($query_run);
                    ?>
                    <div class = "offset-md-0 col-md-0">
                        <h2><b>Update Event</b></h2>
                        <br>
                        <form name="update_event_form" action="" method="post" onsubmit="return validateForm()">
                            <label><b>Event Name:</b></label>
                            <input type="event_name" name="event_name" value="<?=$event['event_name']?>" class="form-control">
                            <br>
                            <label><b>Location:</b></label>
                            <input type="location" name="location" value="<?=$event['address']?>" class="form-control">
                            <br>
                            <label><b>Event Date:</b></label>
                            <input name="event_date" class="form-control" value="<?=$event['event_date']?>" type="date" />
                            <br>
                            <label><b>Start Time:</b></label>
                            <input type="time" name="start_time" value="<?=$event['start_time']?>" class="form-control">
                            <br>
                            <label><b>End Time:</b></label>
                            <input type="time" name="end_time" value="<?=$event['end_time']?>" class="form-control">
                            <br>
                            <label><b>Type:</b></label>
                            <select name="type_sel" class="form-select">
                                <option selected="<?=$event['type']?>"><?=$event['type']?></option>
                                <option value="Social Gathering">Social Gathering</option>
                                <option value="Art">Art</option>
                                <option value="Sports">Sports</option>
                                <option value="Music">Music</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Tournament">Tournament</option>
                                <option value="Other">Other</option>
                            </select>
                            <br>
                            <label><b>Age Restriction:</b></label>
                            <input type="number" min="0" name="age_restriction" value="<?=$event['age_restriction']?>" class="form-control">
                            <br>
                            <label><b>Quota:</b></label>
                            <input type="number" min="0" name="quota" value="<?=$event['quota']?>"  class="form-control">
                            <br>
                            <br>
                            <div class="form-group">
                                <div align="center">
                                    <input type="submit" name="update_event" class="btn btn-primary" value="Update Event">
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                }
            }
            ?>

        </div>
    </body>

</html>