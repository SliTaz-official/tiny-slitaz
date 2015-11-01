<?php

if (isset($_POST['kernel']) && 
   (isset($_POST['modules'])) &&
   !isset($_POST['packages'])) {
	if (isset($_POST['selected'])) {
		upload("mypackages");
		$last = count($_POST['selected'])-1;
		if ($_POST['selected'][$last] == "uploaded") {
			unset($_POST['selected'][$last]);
		}
		$_POST['packages'] = $_POST['modules'].' '.implode(" ",$_POST['selected']);
		unset($_POST['selected']);
	}
}

if (isset($_POST['kernel']) && 
   (isset($_POST['modules'])) &&
   !isset($_POST['packages'])) {

	mkdir($_POST["tmp_dir"]."/fs");
	if ($_POST['kernel'] != "custom") {
		shell_exec("sudo ./helper --pre-install ".$_POST['kernel'].
			   " ".$_POST['tmp_dir']); 
	}
?>

<div class="box">
<h3>[Step 3/5] Additional RAM filesystem</h3>

<form enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="packages">

	<?php
	echo shell_exec("./helper --list-pkgs ".$_POST["tmp_dir"]);
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
