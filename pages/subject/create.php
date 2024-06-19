<?php
// Include config file
require_once "../../config.php";
 
// Define variables and initialize with empty values
$subject_name = $subject_description = $unit = $status = $sub_class = $year_level = $pre_rel = $pre_order = $pre_status = $subject_code = "";
$subject_name_err = $subject_description_err = $unit_err = $status_err = $sub_class_err = $sub_year_level_err = $pre_rel_err = $pre_order_err = $pre_status_err = $subject_code_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate subject_name
    $input_subject_name = trim($_POST["subject_name"]);
    if(empty($input_subject_name)){
        $subject_name_err = "Please enter a subject_name.";
    } elseif(!filter_var($input_subject_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $subject_name_err = "Please enter a valid subject_name.";
    } else{
        $subject_name = $input_subject_name;
    }
    
    // Validate subject_description
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
    
	// Validate sub_class
    $input_sub_class = trim($_POST["sub_class"]);
    if(empty($input_sub_class)){
        $sub_class_err = "Please enter an sub_class.";     
    } else{
        $sub_class = $input_sub_class;
    }
	// Validate year_level
    $input_year_level = trim($_POST["year_level"]);
    if(empty($input_year_level)){
        $year_level_err = "Please enter an year_level.";     
    } else{
        $year_level = $input_year_level;
    }
	
	// Validate pre_rel
    $input_pre_rel = trim($_POST["pre_rel"]);
    if(empty($input_pre_rel)){
        $pre_rel_err = "Please enter an pre_rel.";     
    } else{
        $pre_rel = $input_pre_rel;
    }
	
	// Validate pre_order
    $input_pre_order = trim($_POST["pre_order"]);
    if(empty($input_pre_order)){
        $pre_order_err = "Please enter an pre_order.";     
    } else{
        $pre_order = $input_pre_order;
    }
	
	// Validate pre_status
    $input_pre_status = trim($_POST["pre_status"]);
    if(empty($input_pre_status)){
        $pre_status_err = "Please enter an pre_status.";     
    } else{
        $pre_status = $input_pre_status;
    }
	
	// Validate pre_status
    $input_subject_code = trim($_POST["subject_code"]);
    if(empty($input_subject_code)){
        $subject_code_err = "Please enter an subject_code.";     
    } else{
        $subject_code = $input_subject_code;
    }
	
    // Check input errors before inserting in database
    if(empty($subject_name_err) && empty($subject_description_err) && empty($unit_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO subject (subject_name, subject_description, unit, status, sub_class, year_level, pre_rel, pre_order, pre_status, subject_code) VALUES (:subject_name, :subject_description, :unit, :status, :sub_class, :year_level, :pre_rel, :pre_order, :pre_status, :subject_code)";
 
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
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Subject Record</title>
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
                    <h2 class="mt-5">Create Record For Subject</h2>
                    <p>Please fill this form and submit to add Subject record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>subject_name</label>
                            <input type="text" name="subject_name" class="form-control <?php echo (!empty($subject_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject_name; ?>">
                            <span class="invalid-feedback"><?php echo $subject_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Discription</label>
                            <textarea name="subject_description" class="form-control <?php echo (!empty($subject_description_err)) ? 'is-invalid' : ''; ?>"><?php echo $subject_description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $subject_description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>unit</label>
                            <input type="text" name="unit" class="form-control <?php echo (!empty($unit_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $unit; ?>">
                            <span class="invalid-feedback"><?php echo $unit_err;?></span>
                        </div>
						 <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $status; ?>">
                            <span class="invalid-feedback"><?php echo $status_err;?></span>
                        </div>
						 <div class="form-group">
                            <label>sub_class</label>
                            <input type="text" name="sub_class" class="form-control <?php echo (!empty($sub_class_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sub_class; ?>">
                            <span class="invalid-feedback"><?php echo $sub_class_err;?></span>
                        </div>
												 <div class="form-group">
                            <label>year_level</label>
                            <input type="text" name="year_level" class="form-control <?php echo (!empty($year_level_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year_level; ?>">
                            <span class="invalid-feedback"><?php echo $year_level_err;?></span>
                        </div>
						
												 <div class="form-group">
                            <label>pre_rel</label>
                            <input type="text" name="pre_rel" class="form-control <?php echo (!empty($pre_rel_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pre_rel; ?>">
                            <span class="invalid-feedback"><?php echo $pre_rel_err;?></span>
                        </div>
						
												 <div class="form-group">
                            <label>pre_order</label>
                            <input type="text" name="pre_order" class="form-control <?php echo (!empty($pre_order_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pre_order; ?>">
                            <span class="invalid-feedback"><?php echo $pre_order_err;?></span>
                        </div>
						
												 <div class="form-group">
                            <label>pre_status</label>
                            <input type="text" name="pre_status" class="form-control <?php echo (!empty($pre_status_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pre_status; ?>">
                            <span class="invalid-feedback"><?php echo $pre_status_err;?></span>
                        </div>
						
																		 <div class="form-group">
                            <label>subject_code</label>
                            <input type="text" name="subject_code" class="form-control <?php echo (!empty($subject_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject_code; ?>">
                            <span class="invalid-feedback"><?php echo $subject_code_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="crud.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>