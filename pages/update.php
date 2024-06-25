<?php
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$name = $address = $role = $status = "";
$name_err = $address_err = $role_err = $status_err = "";

// Flag to check if the form was submitted successfully
$form_submitted = false;
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address address
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

       // Prepare an update statement
       $sql = "UPDATE employees SET name=:name, address=:address, role=:role, status=:status WHERE id=:id";

       if($stmt = $pdo->prepare($sql)){
           // Set parameters
           $param_name = $name;
        $param_address = $address;
        $param_role = $role;
		$param_status = $status;
           $param_id = $id;

           // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
        $stmt->bindParam(":address", $param_address);
        $stmt->bindParam(":role", $param_role);
		$stmt->bindParam(":status", $param_status);
           $stmt->bindParam(":id", $param_id);
           
          // Attempt to execute the prepared statement
           if($stmt->execute()){

               $form_submitted = true;

               // Reload data to forms
               if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                   // Get URL parameter
                   $id =  trim($_GET["id"]);
                   
                   // Prepare a select statement
                   $sql = "SELECT * FROM employees WHERE id = :id";
                   if($stmt = $pdo->prepare($sql)){

                        // Set parameters
                        $param_id = $id;
                       
                       // Bind variables to the prepared statement as parameters
                       $stmt->bindParam(":id", $param_id);
                       
                       // Attempt to execute the prepared statement
                       if($stmt->execute()){
                           if($stmt->rowCount() == 1){
                              
                               $row = $stmt->fetch(PDO::FETCH_ASSOC);
                           
                               // Retrieve individual field value
                               $name = $row["name"];
                               $address = $row["address"];
                               $role = $row["role"];
                               
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
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $name = $row["name"];
                    $address = $row["address"];
                    $role = $row["role"];
					$status = $row["status"];
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                            <label>Role</label>
                            <input type="text" name="role" class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $role; ?>">
                            <span class="invalid-feedback"><?php echo $role_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $status; ?>">
                            <span class="invalid-feedback"><?php echo $status_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
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
            Changes Saved!
        </div>
    </div>
</div>

<?php if ($form_submitted): ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var successToastEl = document.getElementById('successToast');
            var successToast = new bootstrap.Toast(successToastEl);
            successToast.show();
            document.getElementById('facultyForm').reset();
        });
    </script>
<?php endif; ?>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>