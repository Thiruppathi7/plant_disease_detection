<?php
include './header.php';
if(!isset($_POST['submit1'])) {
?>
<form name="f" action="" method="post">
    <table class="form_tab">
        <thead>
            <tr>
                <th colspan="2">LOGIN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>UserId</th>
                <td><input type="text" name="userid" required></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><input type="password" name="pwd" required></td>
            </tr>
            <tr>
                <th>Type</th>
                <td>
                    <select name="utype">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit1" value="Submit">
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<?php
} else {
    extract($_POST);
    if(strcasecmp($utype, "admin")==0) {
        if(strcasecmp($userid, "admin")==0 && strcmp($pwd, "admin")==0) {
            $_SESSION['adminuserid']=$userid;
            header("Location:adminhome.php");
        } else {
            echo "<div class='center'>Invalid Userid/Password...!<br></div>";
        }
    } else {
        $result = mysqli_query($link, "select * from newuser where userid='$userid' and pwd='$pwd'") or die(mysqli_error($link));
        if(mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_row($result);
            $_SESSION['userid']=$userid;
            $_SESSION['username']=$row[0];
            header("Location:userhome.php");
        } else {
            echo "<div class='center'>Invalid Userid/Password...!<br></div>";
        }
        mysqli_free_result($result);
    }
    echo "<div class='center'><a href='login.php'>Back</a></div>";
}
include './footer.php';
?>