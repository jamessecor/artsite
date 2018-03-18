<?php
include "header.php";
session_start();
include "checkLogin.php";
require "../includes/artsiteConfig.php";
require "../includes/artsiteConnect.php";


if(isset($_POST['login'])) {
	// Username
	if(!empty($_POST['username'])) {
		$username = addslashes(trim(($_POST['username'])));
	}
	
	// Password
	if(!empty($_POST['password'])) {
		$password = addslashes(trim(($_POST['password'])));
	}	
	
	// Check them
	if($username===$adminU && $password===$adminP) {
		$_SESSION['username'] = $username;
	}
}

// Log out button
if(isset($_POST['logout'])) {
	unset($_SESSION['username']);
	header('Location: admin.php');
}
?>

	

<div class='container'>
	<div class='row'>
		<div class='col-md-8 col-md-offset-2 center-it'>
			<h1 id='contactHeading'><strong>Admin Page</strong></h1>
			<div id='success'>
				<div class='row'>
					<?php 
					// Not Logged In
					if(!isLoggedIn()) { 
					?>

					<form id="login" method="post" action="" autocomplete='off'>
						<table align="center">
							<tr><td>Username</td></tr>
							<tr><td><input type="text" name="username"></td></tr>						
							<tr><td>Password</td></tr>
							<tr><td><input type="password" name="password"></td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td><input type="submit" name="login" value="Log In"></td></tr>							
						</table>
					</form>
					<?php 
					} else { 
					// Logged In
					include "editartwork.php";
					} ?>					
				</div>
			</div>	
		</div>
	</div>
	<!-- <div class='row'>-->
		<div class='col-md-8 col-md-offset-8 center-it'>
			<form method="post" action="">
				<table>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							<input type="submit" name="logout" value="Log Out"</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	<!-- </div>-->
</div>
<?php
include "footer.php";
?>
