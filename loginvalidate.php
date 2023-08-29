<?php
include './db.php';
    $userid = $_POST['userid'];
    $pwd = $_POST['pwd'];
    $res = mysqli_query($link, "select * from newuser where userid='$userid' and pwd='$pwd'") or die(mysqli_error($link));
    if(mysqli_num_rows($res)>0) {
        $r = mysqli_fetch_row($res);
        echo "ok~$r[0]";
    } else {
        echo "Invalid Userid/Password";
    }
mysqli_free_result($res);
    mysqli_close($link);
?>