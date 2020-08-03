<?php
require_once "./config.php";

session_start();
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  header('Location: /login');
}
$uid = $_SESSION['id'];
$username = $_SESSION["username"];
$country = $email = $birthday = $description = "";

$sql = "SELECT name FROM countries";
$result = mysqli_query($link, $sql);
$countries = array();
while($row = mysqli_fetch_assoc($result)) {
  array_push($countries,utf8_encode($row["name"]));
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $sql = "SELECT id FROM users WHERE username = ?";

  $error = "";
  if(empty(trim($_POST["username"]))){
    if(strlen($error)>0){
      $error .= "<br>";
    }
    $error .= "Username error: Username cant be empty.";
  }else if(strlen(trim($_POST["username"])) > 50){
    if(strlen($error)>0){
      $error .= "<br>";
    }
    $error .= "Username error: Username cant have more than 50 characters.";
  }else if($username !== $_POST["username"]){
    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);
      // Set parameters
      $param_username = trim($_POST["username"]);
      
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          
          if(mysqli_stmt_num_rows($stmt) == 1){
            $error .= "Username error: This username is already taken.";
          }
      } else{
          echo "Oops! Something went wrong. Please try again later.1";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }
  $sql = "UPDATE users SET username=?, country= ?, email= ?, birthday= ?, description = ? WHERE id='$uid'";
  if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_country, $param_email, $param_birthday, $param_description);
    $param_country = htmlspecialchars(trim($_POST["country"]));
    $param_email = htmlspecialchars(trim($_POST["email"]));
    $param_birthday = htmlspecialchars(trim($_POST["birthday"]));
    $param_description = htmlspecialchars(trim($_POST["description"]));
    $param_username = trim($_POST["username"]);

    if (!filter_var($param_email, FILTER_VALIDATE_EMAIL) || strlen($param_email) > 40) {
      if(strlen($error)>0){
        $error .= "<br>";
      }
      $error .= "E-mail error: You need to input a valid E-mail.";
    }
    if(!in_array($param_country,$countries)){
      if(strlen($error)>0){
        $error .= "<br>";
      }
      $error .= "Country error: This country is not valid.";
    }
    if(DateTime::createFromFormat('Y-m-d', $param_birthday) == FALSE){
      if(strlen($error)>0){
        $error .= "<br>";
      }
      $error .= "Birthday error: Date format not valid";
    }
    if(strlen($param_description) > 250){
      if(strlen($error)>0){
        $error .= "<br>";
      }
      $error .= "Description error: The description must have at most 250 characters";
    }
    if(strlen($error)==0){
      mysqli_stmt_execute($stmt);
      $username = $_POST["username"];
      $_SESSION["username"] = $username; 
    }
    mysqli_stmt_close($stmt);
  }
}

$sql = "SELECT country, email, birthday, description FROM users WHERE id = '$uid'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$country = $row["country"];
$email = $row["email"];
$birthday = $row["birthday"];
$description = $row["description"];

if(isset($country)){
  array_unshift($countries,$country);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WWBuddy</title>
</head>
<body>
  <?php include("./header.html"); ?>
  <div class="content">
    <div class="profile">
      <img class="profilePic" src="images/profile.jpg">
      <p class="profileName"><a href="/profile?uid=<?php echo $uid ?>"><?php echo htmlspecialchars($username); ?></a></p>
    </div>
    <div class="info">
      <div class="aboutdiv">
        <h2>About me</h2>
        <a href="/change">Change Password</a>
      </div>
      <p><strong>Country:</strong><?php echo $country; ?></p>
      <p><strong>E-mail:</strong><?php echo $email; ?></p>
      <p><strong>Birthday:</strong><?php if($date = DateTime::createFromFormat('Y-m-d', $birthday)){echo $date->format('m/d/Y');} ?></p>
      <p><strong>Description:</strong><?php echo $description; ?></p>
      <div class="error has-error">
        <span class="help-block"><?php echo $error; ?></span>
        <button class="editBtn" type="button" onclick="showPage()">Edit Info</button>
      </div>
    </div>
  </div>
  <div id="editPage">
    <form action="" class="edit" method="post">
      <h2>Edit your info</h2>
      <div class="item">
        <p><strong>Change username:</strong></p>
        <input class="input" type="text" name="username" value="<?php echo htmlspecialchars($username);?>">
      </div>
      <div class="item">
        <p><strong>Select country:</strong></p>
        <select class="input" id="country" name="country"></select>
      </div>
      <div class="item">
        <p><strong>Change E-mail:</strong></p>
        <input class="input" type="text" name="email" value="<?php echo $email;?>">
      </div>
      <div class="item">
        <p><strong>Change Birthday:</strong></p>
        <input class="input" type="date" name="birthday" value="<?php echo $birthday;?>">
      </div>
      <div class="item">
        <p><strong>Change Description:</strong></p>
        <textarea class="input" name="description"><?php echo $description; ?></textarea>
      </div>
      <div class="buttons">
        <button type="button" onclick="hidePage()">Cancel</button>
        <button type="submit">Save</button>
      </div>
    </form>
  </div>
  <?php include("./chat.php"); ?>
  <?php include("./footer.html"); ?>
  <script>
    var x = document.getElementById("country");
    var countries =  <?php echo json_encode($countries) ?>;
    countries.forEach(element  => {
      var option = document.createElement("option");
      option.text = element;
      option.value = element;
      x.add(option);
      })
  </script>
  <script src="./js/editinfo.js"></script>
</body>
</html>