<?php
include './adminheader.php';
if(isset($_GET['upid'])) {
    $result = mysqli_query($link, "select fname from uploads where id='$_GET[upid]'");
    $r = mysqli_fetch_row($result);
    mysqli_query($link, "delete from uploads where id='$_GET[upid]'");
    unlink($r[0]);
}
$result = mysqli_query($link, "select id,cname,cropname,dname,fname from uploads") or die(mysqli_error($link));
    echo "<table class='report_tab'><thead><tr><th colspan='6'>UPLOADED FILE LIST";
    echo "<tr><th>Id<th>Category<th>Name<th>Disease<th>Image<th>Task<tbody>";
        while($row = mysqli_fetch_row($result)) {
            echo "<tr>";
            foreach($row as $k=>$r) {
		if($k==4)
		    echo "<td><img src='$r' width='50px' height='40px'>";
		else
		    echo "<td>$r";
            }
            echo "<td><a href='upload.php?upid=$row[0]' onclick=\"javascript:return confirm('Are You Sure to Delete ?')\">Delete</a>";
        }
    echo "</table>";
mysqli_free_result($result);
include './footer.php';
?>