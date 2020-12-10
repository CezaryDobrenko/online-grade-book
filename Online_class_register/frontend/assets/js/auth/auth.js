function check_if_logged(){
	if(localStorage.getItem("login")){
		location.replace("/front/index.html")
	}
}

function signIn(){
	let authorize = new Auth();
	authorize.get_data_from_form();
	authorize.sign_in();
}

check_if_logged();