async function addDataToField(rpath, id, name, field, condition){
	const token = JSON.parse(localStorage.getItem("login")).token;
	const data = new crudDefault;
	responseData = data.read(rpath,token);
	responseData.then(res => res.json())
	.then(output => {
		for(i = 0; i < output.data.length; i++){
			fullOptionString = "";
			for(j = 0; j < name.length; j++){
				fullOptionString += output.data[i][name[j]]+" ";
			}
			document.getElementById(field).innerHTML += '<option value="'+output.data[i][id]+'">'+fullOptionString+'</option>';
		}
		if(condition == true){
			getData();
		} else {
			document.getElementById(field).value = "";
		}
	})
}