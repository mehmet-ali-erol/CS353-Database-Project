<?php
    include("config.php");
    $asc_att = "Non";
    $desc_att = "Non";
    $type_att = "Non";
    $max_att = "Non";
    $min_att = "Non";
    session_start();

    if(isset($_POST['order_descend']))
    {
        $asc_att = "Non";
        $desc_att = mysqli_real_escape_string($db, $_POST['order_descend']);
        $type_att = "Non";
        $max_att = "Non";
        $min_att = "Non";
    }
    if(isset($_POST['order_ascend']))
    {
        $asc_att = mysqli_real_escape_string($db, $_POST['order_ascend']);
        $desc_att = "Non";
        $type_att = "Non";
        $max_att = "Non";
        $min_att = "Non";
    }
    if(isset($_POST['order_type']))
    {
        $asc_att = "Non";
        $desc_att = "Non";
        $type_att = mysqli_real_escape_string($db, $_POST['order_type']);
        $max_att = "Non";
        $min_att = "Non";
    }
    if(isset($_POST['max_attend']))
    {
        $asc_att = "Non";
        $desc_att = "Non";
        $type_att = "Non";
        $max_att = mysqli_real_escape_string($db, $_POST['max_attend']);
        $min_att = "Non";
    }
    if(isset($_POST['min_attend']))
    {
        $asc_att = "Non";
        $desc_att = "Non";
        $type_att = "Non";
        $max_att = "Non";
        $min_att = mysqli_real_escape_string($db, $_POST['min_attend']);
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
                color: slateblue;
            }
            label{color: darkgreen;}
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
        <!-- top navbar -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: darkgreen;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Event Application</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
            <h2><b>Event List</b></h2>
                <br>
                <div class="row g-4 align-items-center">
                    <div class="col-auto">
                        <label for="selections" class="col-form-label">System Reports:</label>
                    </div>
                    <div class="col-auto">
                    <form method ="POST" class="d-inline" action="adminpage.php">
                    <button type="submit" name="order_descend" value="<?="ord_desc";?>" class="btn btn-secondary">Order events by descending attendance</a>
                    </div>
                    <div class="col-auto">
                    <form method ="POST" class="d-inline" action="adminpage.php">
                    <button type="submit" name="order_ascend" value="<?="ord_asc";?>" class="btn btn-secondary">Order events by ascending attendance</a>
                    </div>
                    <div class="col-auto">
                    <form method ="POST" class="d-inline" action="adminpage.php">
                    <button type="submit" name="order_type" value="<?="ord_type";?>" class="btn btn-secondary">Order events by type</a>
                    </div>
                    <form method ="POST" class="d-inline" action="adminpage.php">
                    <div class="col-auto">
                    <button type="submit" name="max_attend" value="<?="max_att";?>" class="btn btn-secondary">Max Attendance</a>
                    </div>
                    <div class="col-auto">
                    <form method ="POST" class="d-inline" action="adminpage.php">
                    <button type="submit" name="min_attend" value="<?="min_att";?>" class="btn btn-secondary">Min Attendance</button>
                    </div>
                </div>
                <br>
                </div>
                </form>
                <br>
                <table class="table table-striped align-middle">
                    <thead>
                        <tr style="background-color: darkgreen; color: white;">
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
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $sql = apply_filter($asc_att, $desc_att, $type_att, $max_att, $min_att);
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
    function apply_filter($asc_att, $desc_att, $type_att, $max_att, $min_att)
    {

        if ( $desc_att == "ord_desc" )
        {
            return "SELECT * FROM any_event ORDER BY attendance DESC";
        } 
        else if ( $asc_att == "ord_asc" )
        {
            return "SELECT * FROM any_event ORDER BY attendance ASC";
        } 
        else if ( $type_att == "ord_type" )
        {
            return "SELECT * FROM any_event ORDER BY type";
        } 
        else if ( $max_att == "max_att" )
        {
            return "SELECT * FROM any_event WHERE attendance in (SELECT MAX(attendance) FROM any_event)";
        } 
        else if ( $min_att == "min_att" )
        {
            return "SELECT * FROM any_event WHERE attendance in (SELECT MIN(attendance) FROM any_event)";
        } 
        else
        {
            return "SELECT * FROM any_event";
        }
    }
?>