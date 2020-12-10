class AccessPermision {
	userAccess(){
		if(localStorage.getItem("login")){
			let role = JSON.parse(localStorage.getItem("login")).role;
			if(role == "Student" || role == "Parent")
				return;
		}
		this.go_back();
	}
	
	teacherAccess(){
		if(localStorage.getItem("login")){
			let role = JSON.parse(localStorage.getItem("login")).role;
			if(role == "Nauczyciel" || role == "Dyrektor")
				return;
		}
		this.go_back();
	}
	
	administratorAccess(){
		if(localStorage.getItem("login")){
			let role = JSON.parse(localStorage.getItem("login")).role;
			if(role == "Administrator")
				return;
		}
		this.go_back();
	}
	
	go_back(){
		location.replace("/front/index.html");
	}
	
}

