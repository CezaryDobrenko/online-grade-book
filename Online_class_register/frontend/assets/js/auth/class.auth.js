class Auth {
	
	sign_in(){
		switch (this.dict["input_type"]) {
		  case 'Student':
			this.student_sign_in()
			break;
		  case 'Parent':
			this.parent_sign_in()
			break;
		  case 'Teacher':
			this.teacher_sign_in()
			break;
		}
	}
	
	teacher_sign_in(){
		fetch('http://192.168.8.156:80/dashboard/backend/index.php/class_register_api/login/teacher_login/teacher_login',{
			method:"POST",
			body: JSON.stringify({"teacher_email":this.dict["input_email"],"teacher_password":this.dict["input_password"]})
		  }).then((responce)=>{
			responce.json().then((result)=>{
			  if(result["status"] === 1){
				const response_data = JSON.parse(atob(result.token.split(".")[1]))["data"];
				localStorage.setItem('login',JSON.stringify({
					login:true,
					token:result.token,
					id: response_data["teacher_id"],
					email: response_data["teacher_email"],
					role: response_data["user_role"]
				}))
				this.go_back();
			  } else {
				swal({title: "Error!", text: "Wrong credentials", icon: "error"});
				this.swalCorrection();
			  }
			})
		  }).catch(function(error) {
			console.log(error);
		});
	}

	parent_sign_in(){
		fetch('http://192.168.8.156:80/dashboard/backend/index.php/class_register_api/login/parent_login/parent_login',{
			method:"POST",
			body: JSON.stringify({"parent_email":this.dict["input_email"],"parent_password":this.dict["input_password"]})
		  }).then((responce)=>{
			responce.json().then((result)=>{
			  if(result["status"] === 1){
				const response_data = JSON.parse(atob(result.token.split(".")[1]))["data"];
				localStorage.setItem('login',JSON.stringify({
					login:true,
					token:result.token,
					id: response_data["parent_id"],
					email: response_data["parent_email"],
					role: response_data["user_role"]
				}))
				this.go_back();
			  } else {
				swal({title: "Error!", text: "Wrong credentials", icon: "error"});
				this.swalCorrection();
			  }
			})
		  }).catch(function(error) {
			console.log(error);
		});
	}

	student_sign_in(){
		fetch('http://192.168.8.156:80/dashboard/backend/index.php/class_register_api/login/student_login/student_login',{
			method:"POST",
			body: JSON.stringify({"student_email":this.dict["input_email"],"student_password":this.dict["input_password"]})
		  }).then((responce)=>{
			responce.json().then((result)=>{
			  if(result["status"] === 1){
				const response_data = JSON.parse(atob(result.token.split(".")[1]))["data"];
				localStorage.setItem('login',JSON.stringify({
					login:true,
					token:result.token,
					id: response_data["student_id"],
					email: response_data["student_email"],
					role: response_data["user_role"]
				}))
				this.go_back();
			  } else {
				swal({title: "Error!", text: "Wrong credentials", icon: "error"});
				this.swalCorrection();
			  }
			})
		  }).catch(function(error) {
			console.log(error);
		});
	}
			
	get_data_from_form(){
		const formData = new FormData(document.querySelector('form'))
		var dict = {};
		for (var pair of formData.entries())
		  dict[pair[0]] = pair[1];
		this.dict = dict;
	}
	
	go_back(){
		location.replace("/front/index.html");
	}
	
	swalCorrection(){
		document.getElementsByClassName("swal-button swal-button--confirm")[0].style.backgroundColor = "white";
	}
	
}

