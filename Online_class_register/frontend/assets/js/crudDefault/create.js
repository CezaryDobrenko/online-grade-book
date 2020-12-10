	function create(path,data){
		const token = JSON.parse(localStorage.getItem("login")).token;
		const obj = new crudDefault;
		responseData = obj.create(path,token,data);
		responseData
		.then(res => res.json())
		.then(output => {
			if(output.status == "0"){
				swal({title: "Error!", text: output.message, icon: "error"});
				swalCorrection();
			} else {
				swal({title: "Success", text: "Item has been created", icon: "success"})
				.then((willDelete) => {redirect()});
				swalCorrection();
			}
		})
	}
	
	function initialize(){
		const formData = new FormData(document.querySelector('form'))
		var dict = {};
		for (var pair of formData.entries())
		  dict[pair[0]] = pair[1];
		create(path,dict);
	}
	
	function redirect(){
		window.location.href = returnPath;
	}
	
	function swalCorrection(){
		document.getElementsByClassName("swal-button swal-button--confirm")[0].style.backgroundColor = "white";
	}