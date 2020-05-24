<?php
include('dbconfig.php');
if($_POST['id'])
{
	$id=$_POST['id'];
		
	$stmt1 = $DB_con->prepare("SELECT * FROM t_product WHERE p_name=:id");
	$stmt1->execute(array(':id' => $id));
	?><option selected="selected">Select Brand :</option><?php
	while($row=$stmt1->fetch(PDO::FETCH_ASSOC))
	{
		?>
        <option value="<?php echo $row['p_brand']; ?>"><?php echo $row['p_brand']; ?></option>
        <?php
	}
}
?>