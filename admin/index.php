<?php
    session_start();

    if ($_SESSION["username"] !== "Henry") {
        $logfile = fopen("./access.log", "a") or die("Unable to open file!");
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d H:i:s");
        $username = $_SESSION["username"];
        $id = $_SESSION["id"];
        $txt = "$ip   $date   $username $id\n";
        fwrite($logfile, $txt);
        fclose($logfile);
        header('HTTP/1.1 403 Forbidden');
        die("You dont have permissions to access this file, this incident will be reported.");     
    }

    echo "Hey Henry, i didn't made the admin functions for this page yet, but here at least you can see who's trying to sniff into our site here.<br>";

    echo "<pre>" . htmlspecialchars(file_get_contents("access.log")) . "</pre>";
?>