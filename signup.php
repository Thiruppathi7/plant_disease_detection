<?php
include './header.php';
if(!isset($_POST['submit1'])) {
?>
<form name="f" action="" method="post" onsubmit="return check()">
    <table class="form_tab">
        <thead>
            <tr>
                <th colspan="2">SIGNUP</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Name</th>
                <td><input type="text" name="name" required autofocus></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><input type="radio" name="gender" value="Male" checked>Male 
                    <input type="radio" name="gender" value="Female">Female</td>
            </tr>
            <tr>
                <th>Address</th>
                <td><textarea name="addr" cols="21" required></textarea></td>
            </tr>
            <tr>
                <th>City</th>
                <td><input type="text" name="city" required></td>
            </tr>
            <tr>
                <th>Email (Userid)</th>
                <td><input type="text" name="userid" required></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><input type="password" name="pwd" required></td>
            </tr>
            <tr>
                <th>Confirm Pwd</th>
                <td><input type="password" name="cpwd" required></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit1" value="Register">
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<?php
} else {
    extract($_POST);
    mysqli_query($link, "insert into newuser(name,gender,addr,city,userid,pwd) values('$name','$gender','$addr','$city','$userid','$pwd')") or die(mysqli_error($link));
    echo "<div class='center'>UserId Registered Successfully...! <br> <a href='login.php'>Back</a></div>";
}
include './footer.php';
?>
<script>
    function check() {
        var userid = f.userid.value
        var p1 = f.pwd.value
        var p2 = f.cpwd.value
        
        if(!check_email(userid)) {
            alert("Invalid Email")            
            return false
        }
        if(p1!=p2) {
            alert("Confirm Password not match")
            f.cpwd.focus()
            return false
        }
        return true
    }
    function check_email(e) {
	var ep = /^\w+\.{0,1}\w+\@[a-z]+\.([a-z]{3}|[a-z]{2}\.[a-z]{2}){1}$/
	return e.match(ep)
    }
    function check_mobile(m) {
	var mp = /^[987]\d{9}$/
	return m.match(mp)
    }
</script>