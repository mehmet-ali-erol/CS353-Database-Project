<?php
    include("config.php");
    session_start();
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
            
            .table{
                width: 70%; 
                margin-left: auto;
                margin-right: auto;
            }
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
            <div>
                <h2><b>My Souvenirs</b></h2>
                <br>
                <table class="table table-striped align-middle">
                    <thead>
                        <tr style="background-color: #621F87; color: white;">
                            <th>Event ID</th>
                            <th>Purchase ID</th>
                            <th>Souvenir Name</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $glob_name = $_SESSION['user_id'];
                        $sql = "WITH souvenir_ids as (SELECT DISTINCT souvenir_id, purchase_id FROM buy_souvenir WHERE user_id = '$glob_name')
                        SELECT event_id, souvenir_ids.purchase_id, souvenir_name FROM souvenir_ids, souvenir T WHERE T.souvenir_id = souvenir_ids.souvenir_id";
                        $res = mysqli_query($db, $sql);

                        while($row = $res-> fetch_assoc())
                        {
                            ?>
                            <tr>
                                <td><?= $row["event_id"]; ?></td>
                                <td><?= $row["purchase_id"]; ?></td>
                                <td><?= $row["souvenir_name"]; ?></td>
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