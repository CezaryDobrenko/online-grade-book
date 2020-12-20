async function readFromDatabase(){
	const token = JSON.parse(localStorage.getItem("login")).token;
	const data = new crudDefault;
	responseData = data.read(path,token);
	responseData.then(res => res.json())
	.then(output => {
		if(output["message"] != "No data found"){
			head  = generateTableHead(output,ignoreField);
			content = generateTableBody(output,ignoreField);
			document.getElementById("table_content").innerHTML = content;
			var script = document.createElement("script");
			script.innerHTML = 'document.getElementsByClassName("color_page")[0].click();';
			script.innerHTML += 'document.getElementById("index_native").style.display = "";';
			document.body.appendChild(script);
		} else {
			document.getElementById("table_content").innerHTML = '<br><br><header class="major"><h2>No data recived for this view</h2></header>';
		}
	})
}

function FilterTableRow(interstingWord) {
	var input, filter, table, tr, td, i, txtValue;
	var words = interstingWord.value.split(/(\s+)/).filter( e => e.length > 1);
	words = words.map(val => val.toUpperCase());
	table = document.getElementById("table_content");
	tr = table.getElementsByTagName("tr");

	for (i = 1; i < tr.length; i++) {
		counter = 0;
		for(j = 0; j < tr[i].getElementsByTagName("td").length; j++){
			td = tr[i].getElementsByTagName("td")[j];
			txtValue = td.textContent || td.innerText;
			for(k = 0; k < words.length; k++){
				if(txtValue.toUpperCase().indexOf(words[k]) > -1){
					counter++;
				}
			}
		}
		if(counter == words.length){
			tr[i].style.display = "";
		} else {
			tr[i].style.display = "none";
		}
	}
	if(words.length == 0){
		document.getElementsByClassName("color_page")[0].click();
	}
}

function generateTableHead(output,ignoreField){
	table  = "<thead>";
		table += "<tr>";
			iterator = 0;
			Object.keys(output.data[0]).forEach(e => {
				counterH = 0;
				for(j = 0; j < ignoreField.length; j++){
					if(e != ignoreField[j]){
						counterH++;
					}
				}
				if(counterH == ignoreField.length){
					table += '<th>'+headersNames[iterator];
					iterator++;
				}
			});
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
				counterz = 0;
				if(counterC == ignoreField.length){
					table += '<td>';
					if(output.data[i][e] != null){
						for(k = 0; k < output.data[i][e].length; k++){
							counterz++;
							if(counterz > 15){
								if(output.data[i][e][k] != ' ' && (counterz < 20 || output.data[i][e].length - counterz < 4)){
									table += output.data[i][e][k]
								}
								else {
									table += output.data[i][e][k] +"<br>";
									counterz = 0;
								}
							}
							else{
								table += output.data[i][e][k]
							}
						}
					} else {
						table += "None";
					}
				}
			});
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