<?php
include('dbconfig.php');
if($_POST['id'])
{
	$id=$_POST['id'];
		
	$stmt = $DB_con->prepare("SELECT * FROM t_brand WHERE c_id=:id");
	$stmt->execute(array(':id' => $id));
	?><option selected="selected">Select Brand :</option><?php
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
        <option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>
        <?php
	}
}
?>