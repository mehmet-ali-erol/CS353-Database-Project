<?php
    include("config.php");
    $error = "";
    $fil_age_lower = '0';
    $fil_age_upper = '200';
    $fil_date = "date_non";
    $fil_type = "type_non";
    $fil_search = "empty_search";
    session_start();
    if(isset($_POST['join_event']))
    {
        $insert_pass = true;
        $glob_name = $_SESSION['user_id'];
        $event_id = mysqli_real_escape_string($db, $_POST['join_event']);

        $sql_time_check = "WITH time_values as (SELECT E.start_time, E.end_time, E.event_date FROM any_event E,
                joins J WHERE J.user_id = '$glob_name' and E.event_id = J.event_id) 
                SELECT * FROM time_values, any_event E WHERE E.event_id = '$event_id' and 
                E.event_date = time_values.event_date and ((time_values.end_time > E.start_time and  
                E.start_time > time_values.start_time) or (time_values.end_time > E.end_time and 
                E.end_time > time_values.start_time))";

        $res_time_check = mysqli_query($db, $sql_time_check);
        $count = mysqli_num_rows($res_time_check);

        if( $count >= 1)
        {
            $error = "Timeslot Error!";
            $insert_pass = false;
        }

        if ($insert_pass == true) 
        {
            try {
                $sql = "INSERT INTO joins( user_id, event_id )
                        VALUES ( '$glob_name', '$event_id' )";
                $res = mysqli_query($db, $sql);
            } catch (mysqli_sql_exception) {
                $error = "Constraint Error!";
            }
        }
    }
    if(isset($_POST['apply_filter']))
    {
        $fil_age_lower = mysqli_real_escape_string($db, $_POST['age_lower']);
        $fil_age_upper = mysqli_real_escape_string($db, $_POST['age_upper']);
        $fil_search = mysqli_real_escape_string($db, $_POST['search']);
        if ( $fil_age_lower == null)
        {
            $fil_age_lower = '0';
        }
        if ( $fil_age_upper == null)
        {
            $fil_age_upper = '200';
        }
        if ( $fil_search == null)
        {
            $fil_search = "empty_search";;
        }
        $fil_date = mysqli_real_escape_string($db, $_POST['date_sel']);
        $fil_type = mysqli_real_escape_string($db, $_POST['type_sel']);
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

    <body>
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
                <h2><b>Available Events</b></h2>
                <br>
                <div style = "font-size:20px; color:purple"><b><?php echo $error; ?></b></div>
                <br>
                <form method ="POST" class="d-inline" action="eventlist.php">
                <div class="row g-4 align-items-center">
                    <div class="col-auto">
                        <label for="selections" class="col-form-label">Filter By:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" min="0" name="age_lower" placeholder="Age lower limit..." class="form-control">
                    </div>
                    <div class="col-auto">
                        <input type="number" min="0" name="age_upper" placeholder="Age upper limit..." class="form-control">
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="date_sel">
                            <option selected="date_non">Event Date</option>
                            <option value="date_asc">Ascending</option>
                            <option value="date_desc">Descending</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" name="type_sel">
                            <option selected="type_non">Type</option>
                            <option value="Social Gathering">Social Gathering</option>
                            <option value="Art">Art</option>
                            <option value="Sports">Sports</option>
                            <option value="Music">Music</option>
                            <option value="Seminar">Seminar</option>
                            <option value="Tournament">Tournament</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="search" name="search" placeholder="Search..." class="form-control">
                    </div>
                    <div class="col-auto">
                    <button type="submit" name="apply_filter" class="btn btn-primary">Apply</button>
                    </div>
                </div>
                </form>
                <br>
                <table class="table table-striped align-middle">
                    <thead>
                        <tr style="background-color: #621F87; color: white;">
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Location</th>
                            <th>Event Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Type</th>
                            <th>Age Restriction</th>
                            <th>Attendance</th>
                            <th>Quota</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $glob_name = $_SESSION['user_id'];
                        $sql_get_age_user = "SELECT age FROM any_user WHERE user_id = '$glob_name'";
                        $age_res = mysqli_query($db, $sql_get_age_user);
                        $user_age = $age_res -> fetch_array();

                        $sql = apply_filter($fil_age_lower, $fil_age_upper, $fil_date, $fil_type, $glob_name, $fil_search, $user_age[0]);
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
                                    <form method ="POST" class="d-inline" action="eventlist.php">
                                    <button type="submit" name="join_event" value="<?=$row['event_id'];?>" class="btn btn-primary">Join Event</button>
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

<?php
    function apply_filter($fil_age_lower, $fil_age_upper, $fil_date, $fil_type, $user_name, $search, $user_age )
    {
        $sort_stat = " ";
        $type_stat =  " ";
        $search_stat = " ";
        if ( $search !== "empty_search")
        {
        $search_stat = "and E.event_name LIKE '" . $search . "%'";
        }
        if( $fil_type !== "Type" and $fil_type !== 'type_non')
        {
            $type_stat = " and E.type = '$fil_type' ";
        }
        if( $fil_date == "date_asc")
        {
            $sort_stat = " " . $sort_stat . " ORDER BY event_date";
        }
        else if( $fil_date == "date_desc")
        {
            $sort_stat = " " . $sort_stat . " ORDER BY event_date DESC";
        }

        return $default_sql = "(SELECT DISTINCT E.event_id, E.event_name, E.description, E.address, 
        E.start_time, E.event_date, E.start_time, E.end_time, E.type, E.age_restriction, 
        E.attendance, E.quota FROM any_event E, joins J WHERE E.age_restriction < '$user_age' and organiser <> '$user_name' and 
        event_date > CAST(CURRENT_TIMESTAMP AS DATE) ". $search_stat . " and E.age_restriction > " . $fil_age_lower . "
        and E.age_restriction < " . $fil_age_upper . " " . $type_stat . ")
        except
        (SELECT DISTINCT E.event_id, E.event_name, E.description, E.address, 
        E.start_time, E.event_date, E.start_time, E.end_time, E.type, E.age_restriction, 
        E.attendance, E.quota FROM any_event E, joins J WHERE J.event_id = E.event_id and 
        J.user_id = '$user_name' )" . $sort_stat . "  ";
    }
?>