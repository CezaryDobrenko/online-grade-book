let menu = new CustomMenu();
let panel = new CustomMenu();

function logOut(){
	localStorage.clear();
	location.replace("/front/index.html");
}

function getMenu(){
	if(localStorage.getItem("login")){
		user = JSON.parse(localStorage.getItem("login"));
		switch (user.role) {
		  case 'Student':
			recived = menu.userMenu();
			break;
		  case 'Parent':
			recived = menu.userMenu();
			break;
		  case 'Teacher':
			recived = menu.teacherMenu();
			break;
		  case 'Headmaster':
			recived = menu.teacherMenu();
			break;
		  case 'Administrator':
			recived = menu.administratorMenu();
			break;
		}
		panel = panel.panel(user.email);
		document.getElementById("menu").innerHTML = recived;
		document.getElementById("login").innerHTML = panel;
	}
}

getMenu();
