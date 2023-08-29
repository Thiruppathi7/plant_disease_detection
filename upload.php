<?php
include './adminheader.php';
if(!isset($_POST['submit1'])) {
    $result = mysqli_query($link, "select cname from category");
?>
<form name="f" action="" method="post" enctype="multipart/form-data" onsubmit="return check()">
    <table class="form_tab">
        <thead>
            <tr>
                <th colspan="2">UPLOAD</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Category</th>
                <td>
		    <select name="cname">
		    <?php		    
		    while($row=  mysqli_fetch_row($result)) {
			echo "<option value='$row[0]'>$row[0]</option>";
		    }
		    ?>
		    </select>
		</td>
            </tr>
            <tr>
                <th>Crop Name</th>
                <td><input type="text" name="cropname" required></td>
            </tr>	    
	    <tr>
                <th>Disease Name</th>
                <td><input type="text" name="dname" required></td>
            </tr>
	    <tr>
                <th>Description</th>
                <td><textarea name="descr" rows="3" cols="25"></textarea></td>
            </tr>
	    <tr>
                <th>Solution</th>
                <td><textarea name="solution" rows="4" cols="30"></textarea></td>
            </tr>
	    <tr>
                <th>Image</th>
                <td><input type="file" name="ff" accept="image/*" required></td>
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
    if(is_uploaded_file($_FILES['ff']['tmp_name'])) {
	$fname = "uploads/".time().$_FILES['ff']['name'];
	$ftype = $_FILES['ff']['type'];
	$fsize = $_FILES['ff']['size'];
	$cname = $_POST['cname'];
	$cropname = $_POST['cropname'];
	$dname = $_POST['dname'];
	$descr = $_POST['descr'];
	$solution = $_POST['solution'];
	move_uploaded_file($_FILES['ff']['tmp_name'], $fname) or die("<div class='center'>Cannot Move Uploaded File...!<br><a href='upload.php'>Try Again</a></div>");
	mysqli_query($link, "insert into uploads(cname,cropname,dname,descr,solution,fname,ftype,fsize) values('$cname','$cropname','$dname','$descr','$solution','$fname','$ftype','$fsize')");
	echo "<div class='center'>File Uploaded to Server...! <br><a href='upload.php'>Back</a></div>";
    } else {
	echo "<div class='center'>File not Uploaded to Server...! <br><a href='upload.php'>Back</a></div>";
    }
}
include './footer.php';
?>
<script>
function check() {
    fn = f.ff.value
    fp = /^[a-zA-Z0-9_\:\\\/]+(\.jpg|\.JPG){1}$/
    if(!fn.match(fp)) {
	alert("Upload only JPG Images...!")
	return false
    }
    return true
}
</script>