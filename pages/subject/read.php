<?php
// Check existence of Subject_ID parameter before processing further
if(isset($_GET["Subject_ID"]) && !empty(trim($_GET["Subject_ID"]))){
    // Include config file
    require_once "../../config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM subject WHERE Subject_ID = :Subject_ID";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":Subject_ID", $param_Subject_ID);
        
        // Set parameters
        $param_Subject_ID = trim($_GET["Subject_ID"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $name = $row["subject_name"];
                $subject_description = $row["subject_description"];
                
				$status = $row["status"];
				$semester = $row["semester"];
				$unit = $row["unit"];
				$semester = $row["semester"];
				$sub_class = $row["sub_class"];
				$year_level = $row["year_level"];
				$pre_rel = $row["pre_rel"];
				$pre_order = $row["pre_order"];
				$pre_status = $row["pre_status"];
				$date_created = $row["date_created"];
				$date_updated = $row["date_updated"];
				
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Subject Name</label>
                        <p><b><?php echo $row["subject_name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>subject_description</label>
                        <p><b><?php echo $row["subject_description"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>unit</label>
                        <p><b><?php echo $row["unit"]; ?></b></p>
                    </div>
					<div class="form-group">
                        <label>Status</label>
                        <p><b><?php echo $row["status"]; ?></b></p>
                    </div>
					<div class="form-group">
                        <label>Date Created</label>
                        <p><b><?php echo $row["date_created"]; ?></b></p>
                    </div>
					<div class="form-group">
                        <label>Date Updated</label>
                        <p><b><?php echo $row["date_updated"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>