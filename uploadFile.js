$(document).ready(function(){

	dt = $('#csvTable').DataTable();

	$('#addCol').on('click', function(event){
		event.preventDefault();

		// fetch value from the field - calFormula
		calStr = $('[name="colFormula"]').val() //.replace("&", "+");

		// define the separators needed, match and store the order of the operations 
		// in an array from the given calculation formula
		separators = ['\\*', '-', '/', '\\+', '&'];
		calStrArr = calStr.split(new RegExp(separators.join('|')));
		operationsArr = calStr.match(/[&/\\\*\\+-]/g)

		// define the row values for the next column
		nextColumnName = $('[name="colName"]').val();
		nextColumnValues = [];
		numberOfRows = rows.length;

		// loop through each row to find the next column row value
		for (var i = 0; i < numberOfRows; i++) {

			// loop through the calculation script to calculate the value
			calStrArr.map(function(val, index){

				if(index == 0){
					if(val.search('"') != -1){

						res = val

					} else if(Number(val) >= 0 || Number(val) < 0){

						res = Number(val)

					}else if(val.search('"') == -1) {

						colHeadersIndex  = colHeaders.indexOf(val);
						dataValue = rows[i][colHeadersIndex];
							res = dataValue;

					}
				} else if(index > 0){

					op = operationsArr[index-1];
					if(val.search('"') == 0){

						res = calculate(res.replace('"',''), val.replace('"',''), op);

					} else if(Number(val) >= 0 || Number(val) < 0){

						res = calculate(res, Number(val), op);

					} else if(val.search('"') == -1) {

						colHeadersIndex  = colHeaders.indexOf(val);
						dataValue = rows[i][colHeadersIndex];
						res = calculate(res, dataValue, op);

					}
				}
			});
			// store calculated values in an array
			nextColumnValues.push(res);
		}

		colHeaders.push(nextColumnName);
		// push to the last column value for each row
		rows.map(function(val, index){
			rows[index].push(nextColumnValues[index]);
		})

		// re-intialize the datatable
		dt.clear().draw();
		// display the table again
		displayNewTable(colHeaders, rows);
	});
});

function calculate(val1, val2, op){
	if(op == '+'){

		if(Number(val1) == NaN || Number(val2) == NaN || val1 == 'none' || val2 == 'none')
			return 'NA';
		return Number(val1)+Number(val2)

	}
	if(op == '*'){

		if(Number(val1) == NaN || Number(val2) == NaN || val1 == 'none' || val2 == 'none')
			return 'NA';
		return Number(val1)*Number(val2)

	}
	if(op == '-'){
		if(Number(val1) == NaN || Number(val2) == NaN || val1 == 'none' || val2 == 'none')
			return 'NA';
		return Number(val1)-Number(val2)

	}
	if(op == '/'){

		if(Number(val1) == NaN || Number(val2) == NaN || val1 == 'none' || val2 == 'none')
			return 'NA';
		return Number(val1)/Number(val2)

	}
	if(op == '&'){

		return (val1+val2).replace('"', '')

	}
	
	return 'NA'
}

function displayNewTable(colHeaders, rows){
	theadData = '<tr>';
	colHeaders.map(function(val, index){
		theadData += '<th>'+val+'</th>';
	});
	theadData += '<tr>';
	tbodyData = '';
	rows.map(function(val, index){
		tbodyData += '<tr>'
		val.map(function(v,i){
			tbodyData += '<td>'+v+'</td>'
		})
		tbodyData += '</tr>';
	});
	$('#csvTable thead').html(theadData);
	$('#csvTable tbody').html(tbodyData);
}