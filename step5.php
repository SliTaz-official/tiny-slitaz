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
		<div id="floppyset">
		<select name="fdsize" id="fdsize" onchange="floppy_form()"
			title="Select the size of the floppies">
<?php
      $title="Neither Windows nor emm386 supported. Needs a real mode DOS";
      if (!file_exists($_POST['tmp_dir']."out")) 
	   shell_exec("sudo ./helper --mkimg ".$_POST['tmp_dir']);
      if (!isset($_POST['fdsize'])) $_POST['fdsize']="1474560";
      foreach(array("737280" => "720K", "1228800" => "1.2M",
		    "1474560" => "1.44M", "1720320" => "1.68M",
		    "1966080" => "1.92M", "2949120" => "2.88M") as $sz => $nm) {
	  echo "		<option value=\"$sz\"";
	  if ($sz == $_POST['fdsize']) echo " selected";
	  echo ">$nm</option>\n";
      } ?>
		</select>
		</div>
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
			 ?>)" title="A bzImage with a basic embbeded initramfs.
Can boot from floppy or DOS in real mode." type="submit" />
		<input name="download" value="Rootfs (<?php echo show_size("rootfs.gz");
			 ?>)" title="Extra initramfs for the initrd= parameter" type="submit" />
<?php echo shell_exec("sudo ./helper --boot-files ".$_POST['tmp_dir']); ?>
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

<script>
function floppy_form()
{
	var element;
	var fds=document.getElementById("fdsize");
	for (i=1;;i++) {
		element=document.getElementById("Floppy"+i);
		if (element) document.getElementById("floppyset").removeChild(element);
		else break;
	}
	for (i=<?php echo filesize($_POST['tmp_dir']."out"); ?>, j=1; i > 0; j++, i -= fds.value) {
		element = document.createElement("input");
		element.name = "download";
		element.type = "submit";
		element.value = element.id = "Floppy"+j;
		element.title = "You can use dd or rawrite to create the floppy disk";
		document.getElementById("floppyset").appendChild(element);
	}
	if (j == 2) element.value = "Floppy image";
}

floppy_form();
</script>

<h2>Going further</h2>

<p>Tiny SliTaz should be smaller to have more functionality and/or needs less
RAM.<br>
The kernel can be <a href="http://elinux.org/Linux_Tiny">tuned/patched</a> or
you can use an earlier version.</p>

<p>You can test Tiny SliTaz without pre-historic hardware using qemu (needs the
<tt>ne.ko</tt> module, i.e select ne - Kernel module for the ne2000 driver in
Step 2/5):</p>

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
