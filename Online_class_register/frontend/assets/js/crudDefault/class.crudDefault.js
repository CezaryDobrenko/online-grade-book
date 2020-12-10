class crudDefault {

	create(path, token, data){
		const output = fetch(path, {
		  method: 'POST',
		  headers: {
			Authorization: token,
			"Content-Type": "application/json"
		  },
		  body: JSON.stringify(data)
		})
		.catch(err => { console.log(err) })
		return output;
	}

	read(path, token){
		const output = fetch(path, {
		  method: 'GET',
		  headers: {
			Authorization: token,
			"Content-Type": "application/json"
		  }
		})
		.catch(err => { console.log(err) })
		return output;
	}
	
	readSignle(path, token){
		const output = fetch(path, {
		  method: 'GET',
		  headers: {
			Authorization: token,
			"Content-Type": "application/json"
		  },
		})
		return output;
	}
	
	update(path, token, data){
		const output = fetch(path, {
		  method: 'PUT',
		  headers: {
			Authorization: token,
			"Content-Type": "application/json"
		  },
		  body: JSON.stringify(data)
		})
		.catch(err => { console.log(err) })
		return output;
	}


	deleted(path, token, data){
		const output = fetch(path, {
		  method: 'DELETE',
		  headers: {
			Authorization: token,
			"Content-Type": "application/json"
		  },
		  body: JSON.stringify(data)
		})
		.catch(err => { console.log(err) })
		return output;
	}
	
	
}

