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
                <h3>Employees At Selected Location</h3>
            </div>
            <div class="row">
		
				
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email Address</th>
                      <th>Mobile Number</th>
					  <th>Location</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
				   $loc_id = $_REQUEST['loc_id'];
                   $sql = 'SELECT * FROM Employees where location = ' . $loc_id .'';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['mobile'] . '</td>';
							echo '<td>'. $row['location'] . '</td>';
							echo '<td width=250>';
                                echo '<a class="btn" href="jobs.php?emp_id='.$row['id'].'&loc_id='.$loc_id.'">Read</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="update_employee.php?emp_id='.$row['id'].'&loc_id='.$loc_id.'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="delete_employee.php?emp_id='.$row['id'].'&loc_id='.$loc_id.'">Delete</a>';
                                echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
				   echo '<p>
							<a class="btn" href="index.php">Back</a>
							<a href="create_employee.php?loc_id='.$loc_id.'" class="btn btn-success">Create</a>
						</p>';
				   
                  ?>
                  </tbody>
            </table>
			
        </div>
		
    </div> <!-- /container -->
	
  </body>
</html>