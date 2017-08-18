<?php

if (isset($_POST['packages']) && !isset($_POST['toconfigure'])) {
	$_POST['toconfigure'] = shell_exec("./helper --depends ".
				$_POST['tmp_dir']." ".$_POST['packages']);
}

if (isset($_POST['configuring'])) {
	$pkg = $_POST['configuring'];
	$fp = fopen($_POST['tmp_dir']."vars","w");
	foreach ($_POST as $key => $val) {
		if (in_array($key, $usedvars)) continue;
		if (is_array($val)) $val = implode(",",$val);
		fwrite($fp,"export ".$key."='".$val."'\n");
	}
	fclose($fp);
	shell_exec("sudo ./helper --post-install $pkg ".$_POST['tmp_dir']); 
}

if (isset($_POST['suggested'])) {
	foreach ($_POST['suggested'] as $pkg) {
		if (!strstr(" ".$_POST['toconfigure']." ", " ".$pkg." "))
			$_POST['toconfigure'] .= " ".$pkg;
	}
	unset($_POST['suggested']);
}

$output = '';
if (!empty($_POST['toconfigure'])) {
	$pkgs = explode(" ",$_POST['toconfigure']);
	foreach ($pkgs as $key => $pkg) {
		shell_exec("sudo ./helper --pre-install $pkg ".$_POST['tmp_dir']); 
		$output = shell_exec("./helper --get-form $pkg ".
				$_POST['tmp_dir']); 
		unset($pkgs[$key]);
		$_POST['toconfigure'] = implode(" ", $pkgs);
		$suggested = shell_exec("./helper --get-suggested $pkg ".
					$_POST['tmp_dir']); 
		if ($suggested != "") {
			$sugghead = <<<EOT
	<hr />
	<p>
	You may want to install the following package(s) too:
	</p>
	<ol>
EOT;
			$checked = "checked=\"checked\" ";
			if (file_exists($_POST["tmp_dir"]."uploadconf")) $checked = "";
			foreach (explode(" ", $suggested) as $sug)
				if (!strstr(" ".$_POST['packages']." ",
				    " ".$sug." ")) {
					$output .= $sugghead ;
					$sugghead = "";
					$output .= <<<EOT
		<li>
		<input type="checkbox" name="suggested[]" value="$sug" $checked/>$sug
		</li>
EOT;
			}
			if ($sugghead == "")
				$output .= "	</ol>\n";
		}
		if ($output == "") {
			shell_exec("sudo ./helper --post-install $pkg ".
				   $_POST['tmp_dir']); 
			continue;
		}
?>

<div class="box">
<h3>[Step 4/5] <?php echo $pkg; ?> configuration</h3>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

	<input name="configuring" value="<?php echo $pkg; ?>" type="hidden" />
	<div class="large">
		<?php
		echo $output;
		post_hidden();
		?>
	</div>

	<div align="center">
		<input name="continue" value="Continue" type="submit" />
	</div>

</form>
</div>

<?php
		echo shell_exec("./helper --get-note $pkg ".$_POST['tmp_dir']); 
		break;
	}

}
?>
