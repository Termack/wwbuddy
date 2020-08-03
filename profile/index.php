<?php
require_once "../config.php";

session_start();
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  header('Location: /login');
}

$username = $country = $email = $birthday = $description = "";

$uid = $_GET["uid"];
$sql = "SELECT username, country, email, birthday, description FROM users WHERE id = ?";

if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $param_id);
    $param_id = $uid;
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $username, $country, $email, $birthday, $description);
    
    mysqli_stmt_fetch($stmt);

    if(mysqli_stmt_num_rows($stmt)==0){
        die("User could not be found");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WWBuddy</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="/styles/profile.css">
</head>
<body>
  <?php include("../header.html"); ?>
  <div class="profilecontent">
    <div class="profcontent">
      <img class="profilePic2" src="../images/profile.jpg">
      <p class="profileName2"><?php echo htmlspecialchars($username); ?></p>
    </div>
    <div class="proinfo">
      <p><strong>Country:</strong><?php echo $country; ?></p>
      <p><strong>E-mail:</strong><?php echo $email; ?></p>
      <p><strong>Birthday:</strong><?php if($date = DateTime::createFromFormat('Y-m-d', $birthday)){echo $date->format('m/d/Y');} ?></p>
      <p><strong>Description:</strong><?php echo $description; ?></p>
    </div>
  </div>
  <div class="center"><a class="sendmessage" href="/?send=<?php echo $uid ?>">Send me a message</a></div>
  <?php include("../footer.html"); ?>
</body>
</html>