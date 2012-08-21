<?php

$sizes = array(
	"1474560" => "1.44 MB", "1720320" => "1.68 MB",
	"1966080" => "1.92 MB", "2949120" => "2.88 MB"
);
?>
<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<table>
	<tr>
	<td>Initramfs :</td>
	<td><select name="initrd">
		 <option value="">No configuration</option>
		 <option value="upload">Use my configuration ----></option>
<?php
//		 <option value="builder">Use online rootfs builder</option>

function blocksize($file)
{
	global $use_sectors;
	if ($use_sectors)
		return floor((filesize($file) + 511) / 512)." sectors";
	else
		return "use ".((filesize($file) + 511) & -512)." bytes";
}

foreach ($demos as $name)
	echo "<option value=\"demos/$name\">Demo $name (".blocksize("demos/".$name).
		")</option>\n";
closedir($dir);
?>
	</select></td>
	<td><input type="file" name="uploadinitrd" /></td>
	</tr>
	<tr>
	<td>Kernel :</td>
	<td><select name="kernel">
		<option value="dist/bzImage.lzma">LZMA (<?php echo blocksize("dist/bzImage.lzma") ?>)</option>
		<option value="dist/bzImage.gz">GZIP (<?php echo blocksize("dist/bzImage.gz") ?>)</option>
		<option value="upload">Use my kernel ----></option>
	</select></td>
	<td><input type="file" name="uploadkernel" /></td>
	</tr>
	<tr>
	<td>Floppy :</td>
	<td><select name="size">
<?php
	foreach ($sizes as $key => $value) {
		if ($use_sectors)
			echo "		<option value=\"$key\">$value (".($key/512)." sectors)</option>\n";
		else
			echo "		<option value=\"$key\">$value ($key bytes)</option>\n";
	}
?>
	</select></td>
	<td align="center">
	<input name="build" value="Build floppy" type="submit" />
<?php if (file_exists("/boot/isolinux/isolinux.bin")) { ?>
	<input name="buildiso" value="Build ISO image" type="submit" />
<?php } ?>
	</td>
	</tr>
</table>
</form>
