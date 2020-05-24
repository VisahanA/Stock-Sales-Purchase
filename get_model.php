<?php
include('dbconfig.php');
if($_POST['id'])
{
	$id=$_POST['id'];
	
	$stmt = $DB_con->prepare("SELECT * FROM t_model WHERE b_id=:id");
	$stmt->execute(array(':id' => $id));
	?><option selected="selected">Select Model No :</option><?php
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
		<option value="<?php echo $row['m_id']; ?>"><?php echo $row['m_name']; ?></option>
		<?php
	}
}
?>