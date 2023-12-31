
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">TSE Comments Details</h2>
                    </div>
                    <?php
                    // Include config file
                  require_once "C:\Users\Jasa8\OneDrive\Työpöytä\oikeudet.php"; 
                    // Attempt select query execution
                    $sql = "SELECT comments.comment_id, comments.user_id,comments.message,comments.date, users.username as username FROM comments LEFT JOIN users ON comments.user_id=users.id";

                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#comment id</th>";
                                        echo "<th>Users id</th>";
                                        echo "<th>Username</th>";
                                        echo "<th>date</th>";
                                        echo "<th>message </th>";
                                       echo "<th>Action</th>";
                                       echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['comment_id'] . "</td>";
                                        echo "<td>" . $row['user_id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        echo "<td>" . $row['message'] . "</td>";
                                        echo "<td>";
                                        echo '<a href="readcomment.php?id='. $row['comment_id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="delete_comments.php?id='. $row['comment_id'] .'" title="Delete Comment" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    // Close connection
                    mysqli_close($link);
                    ?>
              <a href="adminpanel.php" class="btn btn-danger ml-3">return</a>   <!--Kirjaudu ulos admin paneelista painike --> 
              </div>
            </div>        
        </div>
    </div>
</body>
</html>