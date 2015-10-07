<?php

function show_size($file)
{
	return shell_exec("du -h ".$_POST['tmp_dir'].
		"$file | awk '{ printf \"%s\",$1 }'");
	
}
 
if (isset($_POST['toconfigure']) && $_POST['toconfigure'] == ""
    && $output == "") {
	shell_exec("sudo ./helper --mkrootfs ".$_POST['tmp_dir']); 
?>

<a name="get"></a>
<h2>Get Tiny SliTaz files</h2>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="config">

<?php	post_hidden(); ?>
<h3>Bootable images</h3>
<p>
<div align="center">
<input name="download" value="Floppy image" type="submit" />
&nbsp;
<input name="download" value="DOS/EXE" type="submit" />
<?php if (file_exists("/boot/isolinux/isolinux.bin")) { ?>
&nbsp;
<input name="download" value="ISO image" type="submit" />
<?php } ?>
</div>
</p>

<h3>Files for bootloaders</h3>
<p>
<div align="center">
<input name="download" value="Kernel (<?php echo show_size("fs/boot/bzImage");
 ?>)" type="submit" />
&nbsp;
<input name="download" value="Rootfs (<?php echo show_size("rootfs.gz");
 ?>)" type="submit" />
</div>
</p>

<h3>Configuration info</h3>
<p>
<div align="center">
<input name="download" value="Configuration files" type="submit" />
&nbsp;
<input name="download" value="packages.conf (<?php 
echo show_size("fs/etc/packages.conf"); ?>)" type="submit" />
</div>
</p>

<?php if (show_size("fs/boot/System.map") != "") { ?>
<h3>Debug info</h3>
<p>
<div align="center">
<input name="download" value="System.map (<?php echo show_size("fs/boot/System.map");
 ?>)" type="submit" />
&nbsp;
<input name="download" value="linux.config (<?php echo show_size("fs/boot/config");
 ?>)" type="submit" />
</div>
</p>
<p>
<div align="center">
<input name="download" value="busybox.config (<?php echo show_size("fs/boot/config-busybox");
 ?>)" type="submit" />
&nbsp;
<input name="download" value="post_install.log (<?php echo show_size("post_install.log");
 ?>)" type="submit" />
</div>
</p>
<?php } ?>

</form>

<h2>Going further</h2>
<p>
Tiny SliTaz should be smaller to have more functionality
and/or needs less RAM.<br />
The kernel can be <a href="http://elinux.org/Linux_Tiny">tuned/patched</a>
or you can use an earlier version.
</p>
<p>
You can test Tiny SliTaz without pre-historic hardware using qemu (need the ne module) :
</p>
<pre>
qemu -cpu 486 -m 4 -net nic,model=ne2k_isa -net tap -fda slitaz.img
</pre>
<p>
Or
</p>
<pre>
qemu -cpu 486 -m 4 -net nic,model=ne2k_isa -net tap -kernel kernel -initrd rootfs.gz /dev/null
</pre>
<p>
And the executable file /etc/qemu-ifup:
</p>
<pre>
#!/bin/sh

tunctl -u $(id -un) -t $1                           
ifconfig $1 192.168.0.1 broadcast 192.168.0.255 netmask 255.255.255.0
</pre>

<?php
}
?>
