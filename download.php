<?php

function download($file,$name='')
{
	if ($name == '')
		$name = basename($file);
	if (isset($_POST['tmp_dir']))
		$file = $_POST['tmp_dir'].$file;
	$cmd = "cat ".$file;
	$size = filesize($file);
	header("Content-Type: application/octet-stream");
	header("Content-Length: ".$size);
	header("Content-Disposition: attachment; filename=".$name);
	print `$cmd`;
	exit;
}

if (isset($_POST['download'])) {
	switch (substr($_POST['download'],0,6)) {
	case "Kernel" : download("fs/boot/bzImage","kernel");
	case "Rootfs" : download("rootfs.gz");
	case "packag" : download("fs/etc/packages.conf");
	case "Config" : shell_exec("sudo ./helper --mkcfg ".$_POST['tmp_dir']); 
			download("config_files.cpio.gz");
	case "Floppy" : shell_exec("./helper --mkimg ".$_POST['tmp_dir']); 
			download("slitaz.img");
	case "ISO im" : shell_exec("sudo ./helper --mkiso ".$_POST['tmp_dir']); 
			download("slitaz.iso");
	case "System" : download("fs/boot/System.map");
	case "linux." : download("fs/boot/config","linux.config");
	case "busybo" : download("fs/boot/config-busybox","busybox.config");
	case "post_i" : download("post_install.log");
	}
}
if (isset($_GET['dl'])) {
	download(shell_exec("./helper --get-pkg ".$_GET['dl']." ".$_GET['tmp'])); 
}
?>
