<?php
include './adminheader.php';
if(!isset($_POST['submit'])) {
?>
<form name="f" action="" method="post">
    <table class="left_tab">
        <thead>
            <tr>
                <th colspan="2">CROP CATEGORY</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Category Name</th>
                <td><input type="text" name="cname" required></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Submit">
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<?php
if(isset($_GET['cname'])) {
    mysqli_query($link, "delete from category where cname='$_GET[cname]'");
}
$result = mysqli_query($link, "select * from category order by cname") or die(mysqli_error($link));
    echo "<table class='right_tab'><thead><tr><th colspan='2'>CATEGORY NAMES";
    echo "<tr><th>Name<th>Task<tbody>";
        while($row = mysqli_fetch_row($result)) {
            echo "<tr>";
            foreach($row as $r) {
                echo "<td>$r";
            }
            echo "<td><a href='adminhome.php?cname=$row[0]' onclick=\"javascript:return confirm('Are You Sure to Delete ?')\">Delete</a>";
        }
    echo "</table>";
mysqli_free_result($result);
} else {
    extract($_POST);
    mysqli_query($link, "insert into category(cname) values('$cname')") or die("<div class='center'>Category Already Exists...! <br> <a href='adminhome.php'>Back</a></div>");
    echo "<div class='center'>Category Name Stored...! <br> <a href='adminhome.php'>Back</a></div>";
}
include './footer.php';
?>