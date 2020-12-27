async function readFromDatabase(){
	const token = JSON.parse(localStorage.getItem("login")).token;
	const data = new crudDefault;
	responseData = data.read(path,token);
	responseData.then(res => res.json())
	.then(output => {
		table = "";
		table += tablehead();
		table += tablebody(output);
		document.getElementById("table_content").innerHTML = table;
	})
}

function tablehead(){
	return `<thead>
				<tr>
					<th>Nr.</th>
					<th>Subject name</th>
					<th>Semester 1</th>
					<th title="Propose middle grade">PM</th>
					<th title="Final middle grade">FM</th>
					<th>Semester 2</th>
					<th title="Propose final grade">PF</th>
					<th title="Final final grade">FF</th>
				</tr>
			</thead>`
}

function tablebody(output){
	content = "";
	counter = 1;
	Object.keys(output.data).forEach(e => {
		content += "<tr>"
		content += "<td>"+counter+"</td>"
		content += "<td>"+e+"</td>"
		content += creategrades(output.data[e],"Semester 1","S")
		content += creategrades(output.data[e],"Semester 1","M")
		content += creategrades(output.data[e],"Semester 1","F")
		content += creategrades(output.data[e],"Semester 2","S")
		content += creategrades(output.data[e],"Semester 2","M")
		content += creategrades(output.data[e],"Semester 2","F")
		content += "</tr>"
		counter++;
	})
	return content;
}

function creategrades(data,semester,kind){
	gradesData = "<td>";
	for(i = 0; i < data.length; i++){
		if(data[i].grade_semester == semester){
			if(data[i].grade_kind == kind){
				gradesData += '<div class="grade_block" style = "background-color: ';
				gradesData += data[i].grade_category_color;
				gradesData += ';" title="Value: ';
				gradesData += data[i].grade_value + ' &#13;Weight: ';
				if(data[i].grade_category_weight != null)
					gradesData += data[i].grade_category_weight + ' &#13;Created by: ';
				else
					gradesData += 'undefined &#13;Created by: ';
				if(data[i].grade_teacher_fullname != null)
					gradesData += data[i].grade_teacher_fullname + ' &#13;Date: ';
				else
					gradesData += 'undefined &#13;Date: ';
				gradesData += data[i].grade_created_at + ' &#13;Comment: ';
				gradesData += data[i].grade_comment + ' &#13;Category: ';
				if(data[i].grade_category_name != null)
					gradesData += data[i].grade_category_name + '">';
				else
					gradesData += ' undefined">';
				gradesData += '<a style = "border-bottom: none; color: white;" href="http://127.0.0.1/front/site/user/grades/single_grade.html?id=';
				gradesData += data[i].grade_id;
				gradesData += '">&nbsp;';
				gradesData += data[i].grade_value;
				gradesData += '</a>';
				gradesData += '</div>';
			}
		}
	}
	gradesData += "</td>";
	return gradesData;
}

readFromDatabase();