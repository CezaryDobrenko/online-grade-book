	function deleted(path,data){
		const token = JSON.parse(localStorage.getItem("login")).token;
		const obj = new crudDefault;
		responseData = obj.deleted(path,token,data);
		responseData
		.then(res => res.json())
		.then(output => {
			if(output.status == "0"){
				swal({title: "Error!",text: output.message,icon: "error"});
				swalCorrection();
			} else {
				swal({title: "Success", text: "Item has been deleted", icon: "success",})
				.then((willDelete) => {redirect();});
				swalCorrection();
			}
		})
	}
	
	function initialize(){
		deleted(path,fdata);
	}
	
	function redirect(){
		window.location.href = returnPath;
	}
	
	function swalCorrection(){
		document.getElementsByClassName("swal-button swal-button--confirm")[0].style.backgroundColor = "white";
	}