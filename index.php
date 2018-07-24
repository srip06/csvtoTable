<!DOCTYPE html>
<html>
<head>
	<title>CSV File to Table</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col" id="centerForm">
			<form action='uploadFile.php' method='POST' enctype= 'multipart/form-data'>
				<div class="form-group">
					<label for="file">Upload a CSV File</label>
					<input type="file" name="csvFile" class="form-control-file">
					<button type="submit" class="btn btn-primary" name="submit">Save</button>
				</div>
			</form>		
		</div>
	</div>
</div>
</body>
</html>

