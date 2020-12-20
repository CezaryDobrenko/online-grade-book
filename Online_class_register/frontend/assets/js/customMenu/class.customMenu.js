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
				<li><a href="/front/site/teacher/grade/read.html">Manage grades</a></li>
				<li><a href="/front/site/teacher/absence/read.html">Manage absences</a></li>
				<li><a href="/front/site/teacher/note/read.html">Manage notes</a></li>
				<li><a href="/front/site/teacher/subject/read.html">Your subjects</a></li>
				<li><a href="/front/site/teacher/group/read.html">Student groups</a></li>
				<li><a href="/front/site/teacher/student/read.html">Students preview</a></li>
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
			
				<li><a href="/front/site/dashboard/student/read.html">Manage students</a></li>
				<li><a href="/front/site/dashboard/teacher/read.html">Manage teachers</a></li>
				<li><a href="/front/site/dashboard/parent/read.html">Manage parents</a></li>
				
				<li><a href="/front/site/dashboard/absence/read.html">Manage absences</a></li>
				<li><a href="/front/site/dashboard/group/read.html">Manage groups</a></li>
				<li><a href="/front/site/dashboard/lesson/read.html">Manage lessons</a></li>
				<li><a href="/front/site/dashboard/grades/read.html">Manage grades</a></li>
				<li><a href="/front/site/dashboard/note/read.html">Manage notes</a></li>
				<li><a href="/front/site/dashboard/subject/read.html">Manage subjects</a></li>
				
				<li><a href="/front/site/dashboard/grades_category/read.html">Manage grade category</a></li>
				<li><a href="/front/site/dashboard/teacher_subjects/read.html">Manage teacher subjects</a></li>
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

