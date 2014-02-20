<html>
<head>
<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>
<link rel="shortcut icon" href="src/css/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="src/js/jquery.js"></script>
<script type="text/javascript" src="src/js/bootbox.js"></script>
<script type="text/javascript" src="src/js/bootstrap.js"></script>
<link rel="stylesheet" href="src/css/bootstrap.css">	
</head>
<body>
		<div id="uploadsource" style="float:left">
		<form name="form" id="form" action="upload_file2.php" method="post" enctype="multipart/form-data">
		<label for="file"><b>Upload Source Corpora</b></label>
		<input type="file" name="file1" id="file1"><br>
		<label for="file"><b>Upload Target Corpora</b></label>
		<input type="file" name="file2" id="file2"><br>
		<input class="btn btn-lg btn-success" type="submit" id="submit" name="submit" value="Upload Files">
		</form>
		<?php if (!empty($_GET['success'])) { 
			echo "<script>
					bootbox.alert(\"Your files have been imported successfully.\",function() {
																					window.close();
																				});
				</script>"; //generic success notice
		 }  
		?>
		</div>
	</body>
	<html>
