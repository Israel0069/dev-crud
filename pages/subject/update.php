<?php
// Include config file
require_once "../../config.php";
 
// Define variables and initialize with empty values
$subject_name = $subject_description = $unit = $status = $sub_class = $year_level = $pre_rel = $pre_order = $pre_status = $subject_code = "";
$subject_name_err = $subject_description_err = $unit_err = $status_err = $sub_class_err = $sub_year_level_err = $pre_rel_err = $pre_order_err = $pre_status_err = $subject_code_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["Subject_ID"]) && !empty($_POST["Subject_ID"])){
    // Get hidden input value
    $Subject_ID = $_POST["Subject_ID"];
    
    // Validate subject_name
    $input_name = trim($_POST["subject_subject_name"]);
    if(empty($input_subject_name)){
        $subject_name_err = "Please enter a subject_name.";
    } elseif(!filter_var($input_subject_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $subject_name_err = "Please enter a valid subject_name.";
    } else{
        $subject_name = $input_subject_name;
    }
    
    // Validate subject_description subject_description
    $input_subject_description = trim($_POST["subject_description"]);
    if(empty($input_subject_description)){
        $subject_description_err = "Please enter an subject_description.";     
    } else{
        $subject_description = $input_subject_description;
    }
    
    // Validate unit
    $input_unit = trim($_POST["unit"]);
    if(empty($input_unit)){
        $unit_err = "Please enter an unit.";     
    } else{
        $unit = $input_unit;
    }
	// Validate status
    $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = "Please enter an status.";     
    } else{
        $status = $input_status;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($subject_description_err) && empty($unit_err)){
        // Prepare an update statement
        $sql = "UPDATE subject SET subject_name=:subject_name, subject_description=:subject_description, unit=:unit, status=:status, sub_class=:sub_class WHERE Subject_ID=:Subject_ID";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":subject_name", $param_subject_name);
            $stmt->bindParam(":subject_description", $param_subject_description);
            $stmt->bindParam(":unit", $param_unit);
			$stmt->bindParam(":status", $param_status);
			$stmt->bindParam(":sub_class", $param_sub_class);
			$stmt->bindParam(":year_level", $param_year_level);
			$stmt->bindParam(":pre_rel", $param_pre_rel);
			$stmt->bindParam(":pre_order", $param_pre_order);
			$stmt->bindParam(":pre_status", $param_pre_status);
			$stmt->bindParam(":subject_code", $param_subject_code);
            $stmt->bindParam(":Subject_ID", $param_Subject_ID);
            
            // Set parameters
            $param_subject_name = $subject_name;
            $param_subject_description = $subject_description;
            $param_unit = $unit;
			$param_status = $status;
			$param_sub_class = $sub_class;
			$param_year_level = $year_level; 
			$param_pre_rel = $pre_rel;
			$param_pre_order = $pre_order;
			$param_pre_status = $pre_status;
			$param_subject_code = $subject_code;
            $param_Subject_ID = $Subject_ID;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["Subject_ID"]) && !empty(trim($_GET["Subject_ID"]))){
        // Get URL parameter
        $Subject_ID =  trim($_GET["Subject_ID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM subject WHERE Subject_ID = :Subject_ID";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":Subject_ID", $param_Subject_ID);
            
            // Set parameters
            $param_Subject_ID = $Subject_ID;
            
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
				$sub_class = $row["sub_class"];
				$year_level = $row["year_level"];
				$pre_rel = $row["pre_rel"];
				$pre_order = $row["pre_order"];
				$pre_status = $row["pre_status"];
				$date_created = $row["date_created"];
				$date_updated = $row["date_updated"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Subject Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Subject Description</label>
                            <textarea name="subject_description" class="form-control <?php echo (!empty($subject_description_err)) ? 'is-invalid' : ''; ?>"><?php echo $subject_description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $subject_description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" name="unit" class="form-control <?php echo (!empty($unit_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $unit; ?>">
                            <span class="invalid-feedback"><?php echo $unit_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $status; ?>">
                            <span class="invalid-feedback"><?php echo $status_err;?></span>
                        </div>
						
												<div class="form-group">
                            <label>semester</label>
                            <input type="text" name="semester" class="form-control <?php echo (!empty($semester_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $semester; ?>">
                            <span class="invalid-feedback"><?php echo $semester_err;?></span>
                        </div>
						
												<div class="form-group">
                            <label>sub_class</label>
                            <input type="text" name="sub_class" class="form-control <?php echo (!empty($sub_class_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sub_class; ?>">
                            <span class="invalid-feedback"><?php echo $sub_class_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>