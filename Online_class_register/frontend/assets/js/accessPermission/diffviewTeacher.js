if(JSON.parse(localStorage.getItem("login")).role == "Teacher"){
	var Newscript=document.createElement('script');
	Newscript.src='/front/assets/js/crudDefault/readonly.js';
	Newscript.type='text/javascript';
	document.getElementById("createButton").style.display = "none";
} else {
	var Newscript=document.createElement('script');
	Newscript.src='/front/assets/js/crudDefault/read.js';
	Newscript.type='text/javascript';
}
document.body.appendChild(Newscript);