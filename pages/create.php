<?php
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$name = $address = $role = $status = "";
$name_err = $address_err = $role_err = $status_err = "";

// Flag to check if the form was submitted successfully
$form_submitted = false;
$duplicate_record = false;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate role
    $input_role = trim($_POST["role"]);
    if(empty($input_role)){
        $role_err = "Please enter an role.";     
    } else{
        $role = $input_role;
    }
	// Validate status
    $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = "Please enter an status.";     
    } else{
        $status = $input_status;
    }
    
 // Check input errors before inserting in database
 if(empty($name_err) && empty($address_err) && empty($role_err)){

    // Check if the record already exists
    $sql = "SELECT COUNT(*) FROM employees WHERE name = :name AND address=:address AND role=:role AND status=:status";

    if($stmt = $pdo->prepare($sql)){
        // Set parameters
        $param_name = $name;
        $param_address = $address;
        $param_role = $role;
		$param_status = $status;

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":name", $param_name);
        $stmt->bindParam(":address", $param_address);
        $stmt->bindParam(":role", $param_role);
		$stmt->bindParam(":status", $param_status);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if ($stmt->fetchColumn() > 0) {
                // Duplicate record found
                $duplicate_record = true;
            } else {
                
                $sql = "INSERT INTO employees (name, address, role, status) VALUES (:name, :address, :role, :status)";

                if ($stmt = $pdo->prepare($sql)) {
                    // Set parameters
                    $param_name = $name;
                    $param_address = $address;
                    $param_role = $role;
					$param_status = $status;

                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":name", $param_name);
                    $stmt->bindParam(":address", $param_address);
                    $stmt->bindParam(":role", $param_role);
					$stmt->bindParam(":status", $param_status);

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        // Set the form submission flag to true
                        $form_submitted = true;
                        $name = $address = $role = $status = "";
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                }    
            }
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
    <title>Create Record</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        .toast-container {
        position: fixed;
        top: 25%;
        left: 50%;
        transform: translate(-50%, -50%);
}
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                          
								  <label for="sel1">Role:</label>
								  <select id="sel1" type="text" name="role" class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $role; ?>">
									<option>Student</option>
									<option>Admin</option>
								  </select>
							<span class="invalid-feedback"><?php echo $role_err;?></span>
                        </div>
						 <div class="form-group">
                            <label>Status</label>
							<select id="sel1" type="text" name="status" class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $status; ?>">
									<option>Pending</option>
									<option>Active</option>
								  </select>
                            <span class="invalid-feedback"><?php echo $status_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="crud.php" class="btn btn-secondary ml-2">Cancel</a>
                        <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Toast HTML -->
<div class="toast-container">
   <div id="successToast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
       <div class="toast-header">
           <strong class="me-auto">Success</strong>
           <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
       </div>
       <div class="toast-body">
       New record added successfully!
       </div>
   </div>

   <div id="duplicateToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
       <div class="toast-header">
           <strong class="me-auto">Duplicate</strong>
           <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
       </div>
       <div class="toast-body">
           Duplicate record found. No new record added.
       </div>
   </div>
</div>

<!-- Trigger Toast JS -->
<?php if ($form_submitted): ?>
   <script type="text/javascript">
       var successToastEl = document.getElementById('successToast');
       var successToast = new bootstrap.Toast(successToastEl);
       successToast.show();
       document.getElementById('facultyForm').reset();
</script>

<?php elseif ($duplicate_record): ?>
   <script type="text/javascript">
       var duplicateToastEl = document.getElementById('duplicateToast');
       var duplicateToast = new bootstrap.Toast(duplicateToastEl);
       duplicateToast.show();
   </script>
<?php endif; ?>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    
</body>
</html>