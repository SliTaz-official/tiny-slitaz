<?php

if (isset($_POST['kernel']) && !isset($_POST['modules'])) {
	if (isset($_POST['selected'])) {
		$_POST['modules'] = implode(" ",$_POST['selected']);
		unset($_POST['selected']);
	}
}

if (isset($_POST['kernel']) && !isset($_POST['modules'])) {

?>

<div class="box">
<h3>[Step 2/5] Additional modules</h3>

<form enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="packages">
	<?php
	echo shell_exec("./helper --list-modules ".$_POST["tmp_dir"]);
	post_hidden();
?>

	<div align="center">
		<input name="continue" value="Continue" type="submit" />
	</div>

</form>
</div>

<?php
}
?>
