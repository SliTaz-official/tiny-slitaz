<?php
include "download.php";
$static = "http://mirror1.slitaz.org/static/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tiny SliTaz - Builder</title>
	<meta name="description" content="Tiny SliTaz Linux">
	<meta name="keywords" lang="en" content="tiny slitaz, uclibx, tcc">
	<meta name="robots" content="index, follow, all">
	<meta name="revisit-after" content="7 days">
	<meta name="expires" content="never">
	<meta name="modified" content="<?php echo (date( "Y-m-d H:i:s", getlastmod())); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="SliTaz Contributors">
	<meta name="publisher" content="www.slitaz.org">
	<link rel="shortcut icon" href="/static/favicon.ico">
	<link rel="stylesheet" href="/static/slitaz.min.css">
	<link rel="stylesheet" href="tiny.css">
	<style>pre, tt, code { font-size: 0.9rem; }</style>
</head>
<body>

<script>de=document.documentElement;de.className+=(("ontouchstart" in de)?' touch':' no-touch');</script>

<header>
	<h1 id="top"><a href="http://tiny.slitaz.org/">Tiny SliTaz</a></h1>
	<div class="network">
		<a href="http://www.slitaz.org/" class="home"></a>
		<!-- Get static files from Mirror Files vhost -->
		<!-- <img src="http://mf.slitaz.org/images/people.png" alt="[ Group ]" /> -->
		Tiny:
		<!-- a href="http://scn.slitaz.org/groups/tiny">Group</a -->
		<a href="http://forum.slitaz.org/forum/tiny">Forum</a>
		Screenshots:
		<a href="tinyslitaz.png" title="Tiny SliTaz Manager">main</a>
		<a href="tinyslitaz-boot.png" title="Tiny SliTaz Manager: boot.log">boot log</a>
		<a href="tinyslitaz-httpinfo.png" title="Tiny SliTaz Manager: httpd info">httpd info</a>
	</div>
</header>


<!-- Content -->
<main>

<?php if (!empty($error)) echo "
<div class=\"nav_box\">
	<h4>Error:</h4>
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

<h3>Tiny SliTaz goals</h3>

<p>Useful software, expansible, easy to configure, runs fully in RAM, simple,
light and fast for minimum hardware resources: ie fits on one floppy disk (IDE
disk optional), runs on a 386SX processor and needs as little memory as possible
(currently 4MB with a 2.6.14 Kernel).
<a href="http://doc.slitaz.org/en:guides:pxe#why-use-pxe-the-vnc-example">Example</a>
</p>


<h3>Why this builder?</h3>

<p>Tiny SliTaz should be as small as possible. Only the necessary software is
kept. The package manager is run using this website.</p>


<h3>How is it built?</h3>

<p>Tiny SliTaz uses a Linux Kernel with an <a href="dist/rootfs.cpio"
title="See CONFIG_INITRAMFS_SOURCE">embedded filesystem</a>. An extra initramfs
can also be loaded with the configuration and extra packages.</p>

<p>The initramfs is based on <a href="http://uclibc.org/"
title="Instead of glibc">uClibc</a> and busybox with its <a
href="dist/busybox.config.txt">config</a> files and this <a
href="http://hg.slitaz.org/wok-tiny/file/tip/base-tiny/stuff">filesystem tree</a>.
</p>


<!-- End of content -->
</main>

<script>
	function QRCodePNG(str, obj) {
		try {
			obj.height = obj.width += 300;
			return QRCode.generatePNG(str, {ecclevel: 'H'});
		}
		catch (any) {
			var element = document.createElement("script");
			element.src = "/static/qrcode.min.js";
			element.type = "text/javascript";
			element.onload = function() {
				obj.src = QRCode.generatePNG(str, {ecclevel: 'H'});
			};
			document.body.appendChild(element);
		}
	}
</script>

<footer>
	<div>
		Copyright © 2015		<a href="http://www.slitaz.org/">SliTaz</a>
	</div>
	<div>
		Network:
		<a href="http://scn.slitaz.org/">Community</a> ·
		<a href="http://doc.slitaz.org/">Doc</a> ·
		<a href="http://forum.slitaz.org/">Forum</a> ·
		<a href="http://pkgs.slitaz.org/">Packages</a> ·
		<a href="http://bugs.slitaz.org">Bugs</a> ·
		<a href="http://hg.slitaz.org/?sort=lastchange">Hg</a>
	</div>
	<div>
		SliTaz @
		<a href="http://twitter.com/slitaz">Twitter</a> ·
		<a href="http://www.facebook.com/slitaz">Facebook</a> ·
		<a href="http://distrowatch.com/slitaz">Distrowatch</a> ·
		<a href="http://en.wikipedia.org/wiki/SliTaz">Wikipedia</a> ·
		<a href="http://flattr.com/profile/slitaz">Flattr</a>
	</div>
	<img src="/static/qr.png" alt="#" onmouseover="this.title = location.href"
	onclick="this.src = QRCodePNG(location.href, this)"/>
</footer>

</body>
</html>
