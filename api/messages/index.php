<?php 
    require_once "../../config.php";
    session_start();
    $logid = $_SESSION['id'];

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $uid = $_GET["uid"];
        $messages = array();
        $sql = "SELECT id,sender,receiver,content FROM messages WHERE (sender = ? AND receiver = '$logid') OR (sender = '$logid' AND receiver = ?) ORDER BY id";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_id,$param_id);
            $param_id = $uid;
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt,$id, $sender, $receiver, $content);

            if(mysqli_stmt_num_rows($stmt)==0){
                die("User could not be found");
            }

            while (mysqli_stmt_fetch($stmt)) {
                $message = array(
                    "sender"=>$sender, "receiver"=>$receiver, "content"=>$content
                );
                array_push($messages,$message);
            }
        }
        echo json_encode($messages);
    }else if($_SERVER["REQUEST_METHOD"] == "POST"){
        $sendto= $_POST["sendto"];
        $message = $_POST["message"];
        if($message == "" || !isset($message)){
            die("Not Executed");
        }
        $sql = "INSERT INTO messages (sender, receiver, content) VALUES ('$logid', ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_sendto,$param_message);
            $param_sendto = $sendto;
            $param_message = $message;
            if(mysqli_stmt_execute($stmt)){
                $response = "Executed";
            }else{
                $response = "Not executed";
            }
        }
        echo json_encode($response);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
?>