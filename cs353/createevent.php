<?php
   include("config.php");
   session_start();
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
    
        $eventname = mysqli_real_escape_string($db, $_POST['eventname']);
        $location = mysqli_real_escape_string($db, $_POST['location']);
        $startdate = mysqli_real_escape_string($db, $_POST['event_date']);
        $starttime = mysqli_real_escape_string($db, $_POST['starttime']);
        $endtime = mysqli_real_escape_string($db, $_POST['endtime']);
        $agerestriction = mysqli_real_escape_string($db, $_POST['agerestriction']);
        $quota = mysqli_real_escape_string($db, $_POST['quota']);
        $type = mysqli_real_escape_string($db, $_POST['type']);
        $organiser = $_SESSION['user_id'];
        
    
        $sql = "INSERT INTO any_event( event_name, event_date, description, organiser, type, start_time, end_time,
            age_restriction, address, quota, 	attendance)
                VALUES ( '$eventname', '$startdate', 'desc', '$organiser', '$type', '$starttime', '$endtime', 
            '$agerestriction', '$location','$quota', '0')";

        $res = mysqli_query($db, $sql);
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
                var event_name = document.forms['eventform']['eventname'];
                var location = document.forms['eventform']['location'];
                var event_date = document.forms['eventform']['event_date'];
                var start_time = document.forms['eventform']['starttime'];
                var end_time = document.forms['eventform']['endtime'];
                var age_restriction = document.forms['eventform']['agerestriction'];
                var quota = document.forms['eventform']['quota'];
                
                if(event_name.value == "" || location.value == "" || start_time.value == "" || end_time.value == "" || age_restriction.value == "" || quota.value == "")
                {
                    alert("Please fill out all the information.");
                    return false;
                }
                else if( start_time.value > end_time.value)
                {
                    alert("Start time cannot exceed end time.");
                    return false;
                }
                else
                {
                    alert("Event has been created");
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
                <h2><b>Create Event</b></h2>
                <br>
                <form name="eventform" action="" method="post" onsubmit="return validateForm()">
                    <label><b>Event Name:</b></label>
                    <input type="eventname" name="eventname"class="form-control">
                    <br>
                    <label><b>Location:</b></label>
                    <input type="location" name="location" class="form-control">
                    <br>
                    <label><b>Event Date:</b></label>
                    <input name="event_date" class="form-control" type="date" />
                    <br>
                    <label><b>Start Time:</b></label>
                    <input type="time" name="starttime" class="form-control">
                    <br>
                    <label><b>End Time:</b></label>
                    <input type="time" name="endtime" class="form-control">
                    <br>
                    <label><b>Type:</b></label>
                    <select name="type" class="form-select">
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
                    <input type="number" min="0" name="agerestriction" class="form-control">
                    <br>
                    <label><b>Quota:</b></label>
                    <input type="number" min="1" name="quota" class="form-control">
                    <br>
                    <br>
                    <div class="form-group">
                        <div align="center">
                            <input type="submit" class="btn btn-primary" value="Publish Event">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>