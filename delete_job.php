<?php
	session_start();

	if ($_SESSION['login'] != 1) {
	header('Location: login.php');
	exit();
	}
    require 'database.php';
     
    $job_id = $_REQUEST['job_id'];
	$emp_id = $_REQUEST['emp_id'];
	$loc_id = $_REQUEST['loc_id'];
    
     
    if ( !empty($_POST)) {
        // keep track post values
        $job_id = $_POST['job_id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM Jobs WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($job_id));
        Database::disconnect();
        header("Location: jobs.php?emp_id=".$emp_id."&loc_id=".$loc_id."");
         
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
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Delete A Job</h3>
                    </div>
                     
                    <form class="form-horizontal" action="delete_job.php?job_id=<?php echo $job_id?>&emp_id=<?php echo $emp_id?>&loc_id=<?php echo $loc_id?>" method="post">
                      <input type="hidden" name="job_id" value="<?php echo $job_id;?>"/>
                      <p class="alert alert-error">Are you sure to delete ?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="jobs.php?emp_id=<?php echo $emp_id?>&loc_id=<?php echo $loc_id?>">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>