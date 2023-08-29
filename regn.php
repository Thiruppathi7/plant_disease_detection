<?php
include './db.php';
    $name = $_POST['name'];
    $g = $_POST['gender'];
    $addr = $_POST['addr'];
    $city = $_POST['city'];
    $userid = $_POST['userid'];
    $pwd = $_POST['pwd'];
    mysqli_query($link, "insert into newuser(name,gender,addr,city,userid,pwd) values('$name','$g','$addr','$city','$userid','$pwd')") or die(mysqli_error($link));    
    echo "ok";
    mysqli_close($link);
?>