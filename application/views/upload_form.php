<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('upload/do_upload');?>

<input type="file" name="employee_image_edit" size="20" />

<br /><br />

<input type="submit" value="modificar" />

</form>

</body>
</html>