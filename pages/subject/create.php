<?php
// Include config file
require_once "../../config.php";
 
// Define variables and initialize with empty values
$subject_tag = $subject_descriptive_title = $subject_units = $subject_semester_offered = $subject_code = "";
$subject_tag_err = $subject_descriptive_title_err = $subject_units_err = $subject_semester_offered_err = $subject_code_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate subject_tag
    $input_subject_tag = trim($_POST["subject_tag"]);
    if(empty($input_subject_tag)){
        $subject_tag_err = "Please enter a subject_tag.";
    } elseif(!filter_var($input_subject_tag, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $subject_tag_err = "Please enter a valid subject_tag.";
    } else{
        $subject_tag = $input_subject_tag;
    }
    
    // Validate subject_descriptive_title
    $input_subject_descriptive_title = trim($_POST["subject_descriptive_title"]);
    if(empty($input_subject_descriptive_title)){
        $subject_descriptive_title_err = "Please enter an subject_descriptive_title.";     
    } else{
        $subject_descriptive_title = $input_subject_descriptive_title;
    }
    
    // Validate subject_units
    $input_subject_units = trim($_POST["subject_units"]);
    if(empty($input_subject_units)){
        $subject_units_err = "Please enter an subject_units.";     
    } else{
        $subject_units = $input_subject_units;
    }

	
	// Validate subject_semester_offered
    $input_subject_semester_offered = trim($_POST["subject_semester_offered"]);
    if(empty($input_subject_semester_offered)){
        $subject_semester_offered_err = "Please enter an subject_semester_offered.";     
    } else{
        $subject_semester_offered = $input_subject_semester_offered;
    }

	// Validate pre_status
    $input_subject_code = trim($_POST["subject_code"]);
    if(empty($input_subject_code)){
        $subject_code_err = "Please enter an subject_code.";     
    } else{
        $subject_code = $input_subject_code;
    }
    
	
	

    // Check input errors before inserting in database
    if(empty($subject_tag_err) && empty($subject_descriptive_title_err) && empty($subject_units_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO subject (subject_tag, subject_descriptive_title, subject_units, subject_semester_offered, subject_code) VALUES (:subject_tag, :subject_descriptive_title, :subject_units, :subject_semester_offered, :subject_code)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":subject_tag", $param_subject_tag);
            $stmt->bindParam(":subject_descriptive_title", $param_subject_descriptive_title);
            $stmt->bindParam(":subject_units", $param_subject_units);
			$stmt->bindParam(":subject_semester_offered", $param_subject_semester_offered);
			
			$stmt->bindParam(":subject_code", $param_subject_code);
            
            // Set parameters
            $param_subject_tag = $subject_tag;
            $param_subject_descriptive_title = $subject_descriptive_title;
            $param_subject_units = $subject_units;
			$param_subject_semester_offered = $subject_semester_offered;
			
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
                            <label>subject_tag</label>
                            <input type="text" name="subject_tag" class="form-control <?php echo (!empty($subject_tag_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject_tag; ?>">
                            <span class="invalid-feedback"><?php echo $subject_tag_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="subject_descriptive_title" class="form-control <?php echo (!empty($subject_descriptive_title_err)) ? 'is-invalid' : ''; ?>"><?php echo $subject_descriptive_title; ?></textarea>
                            <span class="invalid-feedback"><?php echo $subject_descriptive_title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>subject_units</label>
                            <input type="text" name="subject_units" class="form-control <?php echo (!empty($subject_units_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject_units; ?>">
                            <span class="invalid-feedback"><?php echo $subject_units_err;?></span>
                        </div>

						
						<div class="form-group">
                            <label>subject_semester_offered</label>
                            <input type="text" name="subject_semester_offered" class="form-control <?php echo (!empty($subject_semester_offered_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject_semester_offered; ?>">
                            <span class="invalid-feedback"><?php echo $subject_semester_offered_err;?></span>
                        </div>
						
						
						
						<div class="form-group">
                            <label>subject_code</label>
                            <input type="text" name="subject_code" class="form-control <?php echo (!empty($subject_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject_code; ?>">
                            <span class="invalid-feedback"><?php echo $subject_code_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>