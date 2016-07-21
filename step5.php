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

<div class="box">
<h3 id="get">[Step 5/5] Get Tiny SliTaz files</h3>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="config">

	<?php	post_hidden(); ?>

<table>
	<tr><td class="first">Bootable images:</td><td>

<?php
      $title="Neither Windows nor emm386 supported. Needs a real mode DOS";
      if ((filesize($_POST['tmp_dir']."rootfs.gz") + 
	   filesize($_POST['tmp_dir']."fs/boot/bzImage")) <= 18*80*1024) {
	   $title .= ". Tip: can be split in several boot floppies too";
	    ?>
		<input name="download" value="Floppy image" type="submit"
		       title="You can use dd or rawrite to create the 1.44M floppy disk" />
<?php } ?>
		<input name="download" value="DOS/EXE" type="submit"
		       title="<?php echo $title; ?>" />
<?php if (file_exists("/boot/isolinux/isolinux.bin")) {
	  $title="Can be burnt on to a CD-ROM or written on to a USB Key / memory card";
	  if (file_exists("/usr/bin/iso2exe"))
	  	$title .= ", or renamed with the .exe suffix and run with DOS or Windows";
	   ?>
		<input name="download" value="ISO image" type="submit"
		       title="<?php echo $title; ?>" />
<?php } ?>
	</td></tr>


	<tr><td class="first">Files for bootloaders:</td><td>

		<input name="download" value="Kernel (<?php echo show_size("fs/boot/bzImage");
					 ?>)" type="submit" />
		<input name="download" value="Rootfs (<?php echo show_size("rootfs.gz");
			 ?>)" title="For the initrd= parameter" type="submit" />
	</td></tr>


	<tr><td class="first">Configuration info:</td><td>

		<input name="download" value="Configuration files" type="submit" />
		<input name="download" value="packages.conf (<?php 
					echo show_size("fs/etc/packages.conf"); ?>)" type="submit" />
	</td></tr>


<?php if (show_size("fs/boot/System.map") != "") { ?>
	<tr><td class="first">Debug info:</td><td>

		<input name="download" value="System.map (<?php echo show_size("fs/boot/System.map");
					?>)" type="submit" />
		<input name="download" value="linux.config (<?php echo show_size("fs/boot/config");
					?>)" type="submit" />
		<br>
		<input name="download" value="busybox.config (<?php echo show_size("fs/boot/config-busybox");
					?>)" type="submit" />
		<input name="download" value="post_install.log (<?php echo show_size("post_install.log");
					?>)" type="submit" />
	</td></tr>

<?php } ?>

</table>
</form>
</div>

<h2>Going further</h2>

<p>Tiny SliTaz should be smaller to have more functionality and/or needs less
RAM.<br>
The kernel can be <a href="http://elinux.org/Linux_Tiny">tuned/patched</a> or
you can use an earlier version.</p>

<p>You can test Tiny SliTaz without pre-historic hardware using qemu (needs the
<tt>net</tt> module):</p>

<pre>
qemu -cpu 486 -m 4 -net nic,model=ne2k_isa -net tap -fda slitaz.img
</pre>

<p>Or</p>

<pre>
qemu -cpu 486 -m 4 -net nic,model=ne2k_isa -net tap -kernel kernel -initrd rootfs.gz /dev/null
</pre>

<p>And the executable file <code>/etc/qemu-ifup</code>:</p>

<pre>
#!/bin/sh

tunctl -u $(id -un) -t $1
ifconfig $1 192.168.0.1 broadcast 192.168.0.255 netmask 255.255.255.0
</pre>

<?php
}
?>
