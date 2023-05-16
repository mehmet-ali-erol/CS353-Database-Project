<?php
    include("config.php");
    session_start();

    if(isset($_POST['delete_event']))
    {
        $event_id = mysqli_real_escape_string($db, $_POST['delete_event']);

        $query = "DELETE FROM joins WHERE event_id ='$event_id'";
        $query_run = mysqli_query($db, $query);

        $query = "DELETE FROM buy_souvenir 
                    WHERE souvenir_id in (SELECT souvenir_id FROM souvenir WHERE event_id ='$event_id')";
        $query_run = mysqli_query($db, $query);

        $query = "DELETE FROM souvenir WHERE event_id ='$event_id'";
        $query_run = mysqli_query($db, $query);

        $query = "DELETE FROM buy_ticket 
                    WHERE ticket_id in (SELECT ticket_id FROM ticket WHERE event_id ='$event_id')";
        $query_run = mysqli_query($db, $query);

        $query = "DELETE FROM ticket WHERE event_id ='$event_id'";
        $query_run = mysqli_query($db, $query);

        $query = "DELETE FROM any_event WHERE event_id ='$event_id'";
        $query_run = mysqli_query($db, $query);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        
        <style type="text/css">
            body{
                font: 15px;
                position: absolute;;; top: 10%; width: 100%; height: 1px; overflow: visible;
                margin-left: auto;
                margin-right: auto;
            }

            h2 {
                text-align: center;
                color: darkorange;
            }
            label{color: purple;}
            .container{text-align: center;}
        </style>
        
        <script>
            function validateForm()
            {
                alert("Selected event has been deleted");
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
            <div>
                <h2><b>My Events</b></h2>
                <br>
                <table class="table table-striped align-middle">
                    <thead>
                        <tr style="background-color: #621F87; color: white;">
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Location</th>
                        <th class="col-sm-1">Event Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Type</th>
                        <th>Age Rest.</th>
                        <th>Att.</th>
                        <th>Quota</th>
                        <th class="col-sm-4">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $glob_name = $_SESSION['user_id'];
                        $sql = "SELECT * FROM any_event WHERE organiser = '$glob_name' ";
                        $res_list = mysqli_query($db, $sql);
                        
                        while($row = $res_list-> fetch_assoc())
                        {
                            ?>
                            <tr>
                                <td><?= $row["event_id"]; ?></td>
                                <td><?= $row["event_name"]; ?></td>
                                <td><?= $row["address"]; ?></td>
                                <td><?= $row["event_date"]; ?></td>
                                <td><?= $row["start_time"]; ?></td>
                                <td><?= $row["end_time"]; ?></td>
                                <td><?= $row["type"]; ?></td>
                                <td><?= $row["age_restriction"]; ?></td>
                                <td><?= $row["attendance"]; ?></td>
                                <td><?= $row["quota"]; ?></td>
                                <td>
                                    <a href ="updateevent.php?id=<?=$row["event_id"];?>" class="btn btn-primary btn">Update</a>
                                    <a href ="addsouvenir.php?id=<?=$row["event_id"];?>" class="btn btn-success">Add Souvenir</a>
                                    <a href ="addticket.php?id=<?=$row["event_id"];?>" class="btn btn-secondary">Add Ticket</a>

                                    <form method ="POST" class="d-inline" onsubmit="return validateForm()">
                                        <button type="submit" name="delete_event" value="<?=$row['event_id'];?>" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>