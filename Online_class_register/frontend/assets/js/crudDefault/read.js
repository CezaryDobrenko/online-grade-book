async function readFromDatabase(){
	const token = JSON.parse(localStorage.getItem("login")).token;
	const data = new crudDefault;
	responseData = data.read(path,token);
	responseData.then(res => res.json())
	.then(output => {
		head  = generateTableHead(output,ignoreField);
		content = generateTableBody(output,ignoreField);
		document.getElementById("table_content").innerHTML = content;
		var script = document.createElement("script");
		script.innerHTML = 'document.getElementsByClassName("color_page")[0].click();';
		document.body.appendChild(script);
	})
}

function FilterTableRow(interstingWord) {
	var input, filter, table, tr, td, i, txtValue;
	filter = interstingWord.value.toUpperCase();
	table = document.getElementById("table_content");
	tr = table.getElementsByTagName("tr");

	for (i = 1; i < tr.length; i++) {
		counter = 0;
		for(j = 0; j < tr[i].getElementsByTagName("td").length; j++){
			td = tr[i].getElementsByTagName("td")[j];
			txtValue = td.textContent || td.innerText;
			if(txtValue.toUpperCase().indexOf(filter) > -1){
				counter++;
			}
		}
		if(counter > 0){
			tr[i].style.display = "";
		} else {
			tr[i].style.display = "none";
		}
	}
	if(filter == ""){
		document.getElementsByClassName("color_page")[0].click();
	}
}

function generateTableHead(output,ignoreField){
	table  = "<thead>";
		table += "<tr>";
			Object.keys(output.data[0]).forEach(e => {
				counterH = 0;
				for(j = 0; j < ignoreField.length; j++){
					if(e != ignoreField[j]){
						counterH++;
					}
				}
				if(counterH == ignoreField.length)
					table += '<th>'+e;
			});
			table += "<th>operations";
		table += "</tr>";
	table  += "</thead>";
	return table;
}

function generateTableBody(output,ignoreField){
	table += '<tbody>'
	for(i = 0; i < output.data.length; i++){
			table += "<tr>"
			var key;
			Object.keys(output.data[i]).forEach(e => {
				if(key == null)
					key=e;
				counterC = 0;
				for(j = 0; j < ignoreField.length; j++){
					if(e != ignoreField[j]){
						counterC++;
					}
				}
				if(counterC == ignoreField.length)
					table += '<td>'+output.data[i][e];
			});
			table += `<td><a href="`+updatePath+`?id=`+output.data[i][key]+`">Update</a> 
					      <a href="`+deletePath+`?id=`+output.data[i][key]+`">Delete</a>`;
		table += "</tr>"
	}
	table += "</tbody>"
	return table;
}

readFromDatabase();

window.addEventListener("load", function () {
	paginator({
		table: document.getElementById("table_content"),
		box: document.getElementById("index_native"),
		active_class: "color_page"
	});
}, true);

document.getElementById("createButton").href = createPath;
