<?php
    
	session_start();
	if ($_SESSION['login'] != 1) {
	header('Location: login.php');
	exit();
	}

    require 'database.php';
 
	$emp_id = $_REQUEST['emp_id'];
	$loc_id = $_REQUEST['loc_id'];
 
    if ( null==$emp_id ) {
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
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO Jobs (id,job_title,employee) values(NULL, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($job_title,$emp_id));
            Database::disconnect();
            header("Location: jobs.php?emp_id=".$emp_id."&loc_id=".$loc_id."");
        }
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
                        <h3>Create A New Job</h3>
                    </div>
             
					<form class="form-horizontal" action="create_job.php?emp_id=<?php echo $emp_id?>&loc_id=<?php echo $loc_id?>" method="post">
                      <div class="control-group <?php echo !empty($jobError)?'error':'';?>">
                        <label class="control-label">Job Title</label>
                        <div class="controls">
                            <input name="job_title" type="text"  placeholder="Job Title" value="<?php echo !empty($job_title)?$job_title:'';?>">
                            <?php if (!empty($jobError)): ?>
                                <span class="help-inline"><?php echo $jobError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="jobs.php?emp_id=<?php echo $emp_id?>&loc_id=<?php echo $loc_id?>">Back</a>
                        </div>
                    </form>
			 
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>