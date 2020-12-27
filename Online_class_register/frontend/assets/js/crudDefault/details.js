async function readFromDatabase(){
	const token = JSON.parse(localStorage.getItem("login")).token;
	const data = new crudDefault;
	responseData = data.readSignle(path,token);
	responseData.then(res => res.json())
	.then(output => {
		document.getElementById("val").innerHTML += output.data.grade_value;
		if(output.data.grade_category_weight != null)
			document.getElementById("wei").innerHTML += output.data.grade_category_weight;
		else
			document.getElementById("wei").innerHTML += "undefined";
		document.getElementById("com").innerHTML += output.data.grade_comment;
		document.getElementById("cre").innerHTML += output.data.grade_created_at;
		document.getElementById("sem").innerHTML += output.data.grade_semester;
		if(output.data.grade_category_name != null)
			document.getElementById("cat").innerHTML += output.data.grade_category_name;
		else
			document.getElementById("cat").innerHTML += "undefined";
		document.getElementById("sub").innerHTML += output.data.grade_subject_name;
		if(output.data.grade_teacher_fullname != null)
			document.getElementById("tec").innerHTML += output.data.grade_teacher_fullname;
		else
			document.getElementById("tec").innerHTML += "undefined";
	})
}

readFromDatabase();