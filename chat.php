<?php
    require_once "./config.php";

    session_start();
    $uid = $_SESSION['id'];
    $username = $_SESSION["username"];

    $sql = "SELECT * FROM messages WHERE sender = '$uid' OR receiver = '$uid'";
    $result = mysqli_query($link, $sql);
    $ids = array();
    while($row = mysqli_fetch_assoc($result)) {
        $sender = $row["sender"];
        $receiver = $row["receiver"];
        if($uid == $sender && !in_array($receiver, $ids)){
            array_push($ids,$receiver);
        }else if($uid == $receiver && !in_array($sender, $ids)){
            array_push($ids,$sender);
        }
    }

    $ids = join("', '", $ids);
    $sql = "SELECT id,username FROM users WHERE id IN ('$ids') ORDER BY username";
    $result = mysqli_query($link, $sql);
    $users = array();
    while($row = mysqli_fetch_assoc($result)) {
        $users[$row["id"]] = $row["username"];
    }

    if(isset($_GET["send"])){
        $send = $_GET["send"];
        $sql = "SELECT username FROM users WHERE id = ?";
        $user = "";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            $param_id = $send;
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $user);
            
            mysqli_stmt_fetch($stmt);
            if(mysqli_stmt_num_rows($stmt)!==0){
                $users[$send] = $user;
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/styles/chat.css">
    </head>
    <body>
        <div class="chatwindow">
            <div class="chatheader">
            Chat Box
            </div>
            <div class="chatbox">
            <div class="chatpeople">
                <div id="people">
                </div>
            </div>
            <div class="messagebox">
                <div id="scroll">
                <ul id="messages">
                </ul>
                </div>
                <div id="sender" action="./chat.php" method="post">
                    <input id="sendto" type="hidden" name ="sendto" value =""/>
                    <input type="text" name="message" autocomplete="off" placeholder="Type a message">
                    <button id="btnSend">Send</button>
                </div>
            </div>
            </div>
        </div>
        <script>
            var users = <?php echo json_encode($users); ?>;
            var uid = <?php echo json_encode($uid); ?>;
        </script>
        <script type="text/javascript" src="./js/chat.js"></script>
        <script>
            <?php
                if(isset($user)){
                    echo "
            button = document.querySelector(\"[value='" . $send . "']\");
            setActive(button);
            getMessages(button.value);
                    ";
                }
            ?>
        </script>
    </body>
</html>