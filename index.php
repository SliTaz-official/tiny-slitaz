<?php
include "download.php";
$static = "http://mirror.slitaz.org/static/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<title>Tiny SliTaz - Builder</title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<meta name="description" content="Tiny SliTaz Linux" />
	<meta name="keywords" lang="en" content="tiny slitaz, uclibx, tcc" />
	<meta name="robots" content="index, follow, all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="expires" content="never" />
	<meta name="modified" content="<?php echo (date( "Y-m-d H:i:s", getlastmod())); ?>" />
	<meta name="author" content="SliTaz Contributors" />
	<meta name="publisher" content="www.slitaz.org" />
	<link rel="shortcut icon" href="<?php echo "$static"; ?>favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo "$static"; ?>slitaz.css" />
	<link rel="stylesheet" type="text/css" href="tiny.css" />
</head>
<body>

<!-- Header -->
<div id="header">
	<a name="top"></a>
	<div id="logo"></div>
	<div id="network">
		<a href="http://www.slitaz.org/">
		<img src="<?php echo "$static"; ?>/home.png" alt="[ Home ]" /></a>
		<!-- Get static files from Mirror Files vhost -->
		<!-- <img src="http://mf.slitaz.org/images/people.png" alt="[ Group ]" /> -->
		Tiny:
		<a href="http://scn.slitaz.org/groups/tiny">Group</a>
		<a href="http://forum.slitaz.org/forum/tiny">Forum</a>
		Screenshots:
		<a href="tinyslitaz.png" title="Tiny SliTaz Manager">main</a>
		<a href="tinyslitaz-boot.png" title="Tiny SliTaz Manager: boot.log">boot log</a>
		<a href="tinyslitaz-httpinfo.png" title="Tiny SliTaz Manager: httpd info">httpd info</a>
	</div>
	<h1><a href="http://tiny.slitaz.org/">Tiny SliTaz</a></h1>
</div>


<!-- Content -->
<div id="content">

<?php if (isset($error) && $error != "") echo "
<div class=\"nav_box\">
	<h4>Error :</h4>
	<p>$error</p>
</div>
"; ?>

<h2>Build your configuration from binary packages</h2>

<?php
proc_nice(10);
include "step1.php";
include "step2.php";
include "step3.php";
include "step4.php";
include "step5.php";
?>


<div class="box">
<h4>Tiny SliTaz goals</h4>
<p>
	Useful software, expansible, easy to configure, runs fully in RAM, 
	simple, light and fast for minimum hardware resources: ie fits on
	one floppy disk (IDE disk optional), runs on a 386sx processor and
	needs as little memory as possible (currently 8 MB with a 2.6.34 
	kernel).
	<a href="http://doc.slitaz.org/en:guides:pxe#why-use-pxe-the-vnc-example">
	Example</a>
</p>
</div>

<div class="box">
<h4>Why this builder ?</h4>
<p>
	Tiny SliTaz should be as small as possible. Only the necessary
	software is kept. The package manager is run using this website.
</p>
</div>

<div class="box">
<h4>How is it built ?</h4>
<p>
	Tiny SliTaz uses a Linux kernel
	with an <a href="dist/rootfs.cpio" title="See CONFIG_INITRAMFS_SOURCE">
	embedded filesystem</a>. An extra initramfs can also be loaded with 
	the configuration and extra packages.
</p>
<p>
	The initramfs is based on <a href="http://uclibc.org/"
	title="Instead of glibc">uClibc</a> and 
	busybox with its <a href="dist/busybox.config.txt">config</a>
	files and the packages 
	<a href="http://pkgs.slitaz.org/search.cgi?filelist=slitaz-base-files">
	slitaz-base-files</a> and 
	<a href="http://pkgs.slitaz.org/search.cgi?filelist=slitaz-boot-scripts">
	slitaz-boot-scripts</a>.
</p>
</div>

<!-- End of content -->
</div>

<!-- Footer -->
<div id="footer">
	Copyright &copy; <span class="year"></span>
	<a href="http://www.slitaz.org/">SliTaz</a> - Network:
	<a href="http://scn.slitaz.org/">Community</a>
	<a href="http://doc.slitaz.org/">Doc</a>
	<a href="http://forum.slitaz.org/">Forum</a>
	<a href="http://pkgs.slitaz.org/">Packages</a>
	<a href="http://bugs.slitaz.org">Bugs</a>
	<a href="http://hg.slitaz.org/">Hg</a>
	<p>
		SliTaz @
		<a href="http://twitter.com/slitaz">Twitter</a>
		<a href="http://www.facebook.com/slitaz">Facebook</a>
		<a href="http://distrowatch.com/slitaz">Distrowatch</a>
		<a href="http://en.wikipedia.org/wiki/SliTaz">Wikipedia</a>
		<a href="http://flattr.com/profile/slitaz">Flattr</a>
	</p>
</div>

</body>
</html>
