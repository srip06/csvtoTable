
<?php 
	if(isset($_POST['submit'])){
		$file = $_FILES['csvFile'];
		$fileExt = $_FILES['csvFile']['type'];
		$fileName = $_FILES['csvFile']['name'];
		$fileExt = explode('.', $fileName);
		//to store extension which is the last string after divding then use end()
		$fileActualExt = strtolower(end($fileExt));
		//store every extension we want to allow for upload
		$allowed = array('text', 'csv');
		//check the actualfileextension with allowed once
		if(in_array($fileActualExt, $allowed)){
			echo '<h4>CSV File converted into Data Table</h4>';
		} else {
			echo 'File Extension not allowed';
			header("Location: index.php?unSuccess");
		}
	} else
			header("Location: index.php?fileNotUploaded");
?>
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
			<div class="col">

				<div class="addCol">
					Enter New Colum: <input type="text" name="colName"></br>
					Enter formula: <input type="text" name="colFormula"></br>
					<button class="btn btn-primary" id="addCol">AddColum</button>
				</div>
				<?php					
					$fileObj = fopen($_FILES['csvFile']['tmp_name'], 'r');
					
					//store all the column headers of the table from the 1st line of the file
					$colHeaders =  explode(',', fgets($fileObj));

					//store all the row values from the rest of the lines of the file
					$rows = [];
					$count = 0;
					while(!feof($fileObj)){
						$rows[$count] = explode(',', fgets($fileObj));
						$count += 1;
					}

					//remove special characters from the strings in both colHeadders and rows
					//and also add the headers and rows to the table						
					echo '<table id="csvTable" class="table table-bordered">';
					echo '<thead><tr>';
					foreach ($colHeaders as $key => $value) {
						$value = str_replace("\n", "", $value);
						$value = str_replace("\r", "", $value);
						$colHeaders[$key] = $value;
						echo '<th>'. $value .'</th>';
					}
					echo '</tr></thead><tbody>';
					foreach ($rows as $key => $value) {
						echo '<tr>';
						foreach ($value as $k => $v) {
							$v = str_replace("\n", "", $v);
							$v = str_replace("\r", "", $v);
							$rows[$key][$k] = $v;
							echo '<td>'.$v.'</td>';
						}
						echo '</tr>';
					}
					echo '</tbody></table>';
					fclose($fileObj);
				?>
			</div>
		</div>
	</div>
</body>
<footer>
	
	<script
	  src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="uploadFile.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<script type="text/javascript">
		colHeaders = JSON.parse('<?php echo json_encode($colHeaders); ?>')
		rows = JSON.parse('<?php echo json_encode($rows); ?>')
	</script>
	
</footer>
</html>