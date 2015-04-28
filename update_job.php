<?php
	session_start();

	if ($_SESSION['login'] != 1) {
	header('Location: login.php');
	exit();
	}
    require 'database.php';
 
    $loc_id = null;
	$emp_id = null;
	$job_id = null;
    if ( !empty($_GET['job_id'])) {
        $job_id = $_REQUEST['job_id'];
		$emp_id = $_REQUEST['emp_id'];
		$loc_id = $_REQUEST['loc_id'];
    }
     
    if ( null==$job_id ) {
        header("Location: jobs.php?emp_id=".$emp_id."&loc_id=".$loc_id."");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $jobError = null;
         
        // keep track post values
        $job_title = $_POST['job_title'];
         
        // validate input
        $valid = true;
        if (empty($job_title)) {
            $jobError = 'Please enter a job title';
            $valid = false;
        }
         
        
         
     
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE Jobs set job_title = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($job_title, $job_id));
            Database::disconnect();
            header("Location: jobs.php?emp_id=".$emp_id."&loc_id=".$loc_id."");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Jobs where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($job_id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $job_title = $data['job_title'];
        Database::disconnect();
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
                        <h3>Update Job Title</h3>
                    </div>
             
                    <form class="form-horizontal" action="update_job.php?job_id=<?php echo $job_id?>&emp_id=<?php echo $emp_id?>&loc_id=<?php echo $loc_id?>" method="post">
                      <div class="control-group <?php echo !empty($jobError)?'error':'';?>">
                        <label class="control-label">New Job Title</label>
                        <div class="controls">
                            <input name="job_title" type="text"  placeholder="Job Title" value="<?php echo !empty($job_title)?$job_title:'';?>">
                            <?php if (!empty($jobError)): ?>
                                <span class="help-inline"><?php echo $jobError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="jobs.php?emp_id=<?php echo $emp_id?>&loc_id=<?php echo $loc_id?>">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>