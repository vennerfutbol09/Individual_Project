<?php
	session_start();
	if ($_SESSION['login'] != 1) {
	header('Location: login.php');
	exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Current Jobs Of Selected Employee</h3>
            </div>
            <div class="row">
				
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Job Title</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
				   $emp_id = $_REQUEST['emp_id'];
				   $loc_id = $_REQUEST['loc_id'];
                   $sql = 'SELECT * FROM Jobs where employee = ' . $emp_id .'';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['job_title'] . '</td>';
							echo '<td width=250>';
                                //echo '<a class="btn" href="update.php?id='.$row['id'].'">Read</a>';
                                //echo ' ';
                                echo '<a class="btn btn-success" href="update_job.php?job_id='.$row['id'].'&emp_id='.$emp_id.'&loc_id='.$loc_id.'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="delete_job.php?job_id='.$row['id'].'&emp_id='.$emp_id.'&loc_id='.$loc_id.'">Delete</a>';
                                echo '</td>';
                            echo '</tr>';
                   }
				   Database::disconnect();
				   
				   echo '<p>
							<a class="btn" href="employees.php?loc_id='.$loc_id.'">Back</a>
							<a href="create_job.php?emp_id='.$emp_id.'&loc_id='.$loc_id.'" class="btn btn-success">Create</a>
						</p>';
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>