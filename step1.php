<?php 

shell_exec("sudo ./helper --chkdist"); 
$usedvars = array( "kernel", "modules", "packages", "toconfigure",
	"continue", "configuring", "tmp_dir" );

function set_tmp_dir()
{
	$dir = opendir("/tmp");
	while (($name = readdir($dir)) !== false) {
		if (preg_match('/^tiny_webgen/',$name) == 0) continue;
		if (filemtime("/tmp/$name") > strtotime("-1 hour")) continue;
		shell_exec("sudo ./helper --remove /tmp/$name"); 
	}
	closedir($dir);
	if (isset($_POST["tmp_dir"])) return;
	$_POST["tmp_dir"] = tempnam('','tiny_webgen');
	if (file_exists($_POST["tmp_dir"])) unlink($_POST["tmp_dir"]);
	mkdir($_POST["tmp_dir"]);
	$_POST["tmp_dir"] .= '/';
}

set_tmp_dir();

function post_hidden()
{
	global $usedvars;
	foreach ($usedvars as $var) {
		if (isset($_POST[$var]) && $var != "continue" && 
		    $var != "configuring") {
?>
<input name="<?php echo $var; ?>" value="<?php echo $_POST[$var]; ?>" type="hidden" />
<?php
		 }
	 }
}

function upload($var, $file = "")
{
	if ($file == "") $file = $var;
	if (isset($_FILES[$var])) {
		$tmp_name = $_FILES[$var]['tmp_name'];
		if (is_uploaded_file($tmp_name)) {
			move_uploaded_file($tmp_name, $_POST["tmp_dir"].$file);
		}
	}
}

if (isset($_POST['mykernel']) && !isset($_POST['packages'])) {
        $_POST['kernel'] = "custom";
	upload("uploadkernel","kernel");
}

if (!isset($_POST['kernel'])) {
	shell_exec("sudo ./helper --init"); 
	if (isset($_POST['config'])) {
		upload("uploadconf");
	}
	if (!file_exists($_POST["tmp_dir"]."uploadconf")) {
?>

<div class="box">
<h3>[Step 1/5] Packages and Kernel</h3>

<p>The file <tt>/etc/packages.conf</tt> in the initramfs holds all information
to rebuild your Tiny SliTaz system. You should upload your
<tt>/etc/packages.conf</tt> first if you only want to upgrade your system.</p>

<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
	Packages configuration:
	<input type="file" name="uploadconf" />
	<input name="config" value="Get config" type="submit" />
	<?php post_hidden(); ?>
</form>
<?php
	}
	if (isset($_POST['mypackages'])) {
		upload("uploadpkgs");
		shell_exec("./helper --pkgs-extract uploadpkgs ".$_POST['tmp_dir']); 
	}
	if (!file_exists($_POST["tmp_dir"]."uploadpkgs")) {
?>

<hr>

<p>You can upload a tazpkg file (.tazpkg) or a tarball of tazpkg files (.tar).
These packages will extend the official packages list and will be chosen when
the package names are found to be matching. You can find some examples in the
<a href="http://hg.slitaz.org/wok-tiny/file/">Tiny SliTaz repository</a>.</p>

<div>
	<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
		Additional packages:
		<input type="file" name="uploadpkgs" />
		<input name="mypackages" value="Get packages" type="submit" />
		<?php post_hidden(); ?>
	</form>
</div>

<hr>
<?php
	}
?>

<p id="kernel">You can upload a custom Kernel or use an official one. Your
Kernel should have an embedded initramfs with busybox like <a
href="dist/rootfs.cpio" title="See CONFIG_INITRAMFS_SOURCE">this</a>.</p>

<div>
	<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
		Custom kernel (bzImage file):
		<input type="file" name="uploadkernel" />
		<input name="mykernel" value="Get kernel" type="submit" />
		<?php post_hidden(); ?>
	</form>
</div>

<hr>

<div>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="kernels">
		<input type="hidden" name="kernel" value="linux" />

		<div align="center">
			<input name="continue" value="Continue" type="submit" />
		</div>
	</form>
</div>
</div>

<?php
}
?>

