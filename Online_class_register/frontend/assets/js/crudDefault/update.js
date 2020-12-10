	function update(path,data){
		const token = JSON.parse(localStorage.getItem("login")).token;
		const obj = new crudDefault;
		responseData = obj.update(path,token,data);
		responseData
		.then(res => res.json())
		.then(output => {
			if(output.status == "0"){
				swal({title: "Error!",text: output.message,icon: "error"});
				swalCorrection();
			} else {
				swal({title: "Success", text: "Item has been updated", icon: "success",})
				.then((willDelete) => {redirect();});
				swalCorrection();
			}
		})
	}
	
	function initialize(){
		const formData = new FormData(document.querySelector('form'))
		var dict = {};
		for (var pair of formData.entries())
		  dict[pair[0]] = pair[1];
		update(path,dict);
	}
	
	function redirect(){
		window.location.href = returnPath;
	}
	
	function getData(){
		const token = JSON.parse(localStorage.getItem("login")).token;
		const data = new crudDefault;
		const url = new URL(window.location.href);
		const id = url.searchParams.get("id");
		Spath += "?id="+id;
		responseData = data.readSignle(Spath,token);
		responseData.then(res => res.json())
		.then(output => {
			const formData = new FormData(document.querySelector('form'))
			for (var pair of formData.entries())
				document.getElementById(pair[0]).value = output.data[0][pair[0]];
		})
	}
	
	function swalCorrection(){
		document.getElementsByClassName("swal-button swal-button--confirm")[0].style.backgroundColor = "white";
	}