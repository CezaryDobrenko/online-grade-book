class CustomMenu {

	userMenu() {
		menu = `
			<header class="major">
				<h2>Your menu</h2>
			</header>
			<ul>
				<li><a href="/front/site/user/absences/read.html">Preview absences</a></li>
				<li><a href="/front/site/user/grades/read.html">Preview grades</a></li>
				<li><a href="/front/site/user/notes/read.html">Preview notes</a></li>
				<li><a href="/front/site/user/subjects/read.html">Preview subjects</a></li>
				<li><a href="/front/site/user/groups/read.html">Preview group</a></li>
				<li><a href="/front/site/user/announcements/read.html">Preview announcements</a></li>
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
				<li><a href="/front/site/teacher/announcements/read.html">Announcements</a></li>
				<li><a href="/front/site/teacher/tutor/read.html">Tutor tasks</a></li>
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
				<li><a href="/front/site/dashboard/announcements/read.html">Manage announcements</a></li>
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

