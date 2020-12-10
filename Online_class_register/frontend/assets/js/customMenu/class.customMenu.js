class CustomMenu {

	userMenu() {
		menu = `
			<header class="major">
				<h2>Your menu</h2>
			</header>
			<ul>
				<li><a href="/front/site/user/test.html">Check Grades</a></li>
				<li><a href="/front/site/user/test.html">test user</a></li>
				<li><a href="/front/site/user/test.html">test user</a></li>
			</ul>
		` + this.siteMenu;
		return menu;
	}
	
	teacherMenu() {
		menu = `
			<header class="major">
				<h2>Your menu</h2>
			</header>
			<ul>
				<li><a href="/front/site/teacher/test.html">test teacher</a></li>
			</ul>
		` + this.siteMenu;
		return menu;
	}
	
	administratorMenu(){
		menu = `
			<header class="major">
				<h2>Your menu</h2>
			</header>
			<ul>
				<li><a href="/front/site/dashboard/subject/read.html">Manage subjects</a></li>
				<li><a href="/front/site/dashboard/grades_category/read.html">Manage grade category</a></li>
			</ul>
		` + this.siteMenu;
		return menu;
	}
	
	panel(email){
		panel = `
			<header class="major">
				<h2>Welcome: `+email+`</h2>
			</header>
			<ul class="actions fit">
				<li><button class="button primary fit" onclick="logOut()">log out</button></li>
			</ul>
		`
		return panel;
	}
	
	siteMenu = `
			<br><br>
			<header class="major">
				<h2>Site menu</h2>
			</header>
			<ul>
				<li><a href="/front/index.html">Homepage</a></li>
				<li><a href="/front/site/guest/about.html">About us</a></li>
				<li><a href="/front/site/guest/contact.html">Contact</a></li>
			</ul>
	`
	
}

