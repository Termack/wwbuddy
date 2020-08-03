<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
 
// Include config file
require_once "../config.php";
 
$uid = $_SESSION['id'];
$username = $_SESSION["username"];

// Define variables and initialize with empty values
$password = $new_password = "";
$password_err = $new_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your current password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter your new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Your new password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate credentials
    if(empty($new_password_err) && empty($password_err)){
        // Prepare a select statement

        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Store data in session variables
                            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                            $sql = "UPDATE users SET password='$new_password_hashed' WHERE id='$uid'";
                            if(mysqli_query($link, $sql)){
                                $class = "success";
                                $message = "Password has changed successfully!";
                            }else{
                                $class = "danger";
                                $message = "Something went wrong.";
                            }

                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WWBuddy</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="/styles/profile.css">
    <link rel="stylesheet" href="/styles/login.css">
</head>
<body>
    <?php include("../header.html"); ?>

    <div class="passwrapper">
        <h2>Change your password</h2>
        <?php if (isset($message)){echo "<div class=\"alert alert-$class\">$message</div>";} ?>
        <form action="/change/" method="post">
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Old password</label>
                <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($password); ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo htmlspecialchars($new_password); ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="formButton" value="Submit">
            </div>
    </form>
    </div>
    <?php include("../footer.html"); ?>
</body>
</html>