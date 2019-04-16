<?php
include "header.php";
include "utility.php";
require "../includes/artsiteConfig.php";
require "../includes/artsiteConnect.php";

// Returns an array of email addresses
function getEmailAddr() {
	global $db;
	$query = "SELECT c_email FROM contacts;";
	$result = mysqli_query($db, $query);
	$emails = "";
	while($email = mysqli_fetch_array($result))
		$emails .= "$email[0]; ";	
	return $emails;
}

if(isset($_POST['login'])) {
	// Username
	if(!empty($_POST['artsiteusername'])) {
		$username = addslashes(trim(($_POST['artsiteusername'])));
	}
	
	// Password
	if(!empty($_POST['password'])) {
		$password = addslashes(trim(($_POST['password'])));
		/* Debugging Password Hash
			echo $password . "<br>";
			echo password_hash($password, PASSWORD_DEFAULT);
			echo "<br>";		
			die();
		*/
	}	
	
	// Check them
	if($username===$adminU && password_verify($password, $adminP)) {
		$_SESSION['artsiteusername'] = $username;
	}
}

// Log out button
if(isset($_POST['logout'])) {
	logout();	
}
?>
<script>
$(document).ready(function() {
	$(".showPeeps").click(function() {
		$(".peeps").html("<?php if(isLoggedIn()) echo getEmailAddr(); ?>");
	});
});
</script>

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
							<tr><td><input type="text" name="artsiteusername"></td></tr>						
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
					print "<hr>";
					include "editcontacts.php";
					?>
					&nbsp;
					<div class="row">
						<div class="col-md-8 col-md-offset-2">						
							<button class="showPeeps">SHOW emails</button>
							<div class="peeps"></div>
						</div>
					</div>
					<?php
					} ?>					
				</div>
			</div>	
		</div>
	</div>
	<!-- <div class='row'>-->
		<div class='col-md-2 col-md-offset-8 center-it'>
			<form method="post" action="">
				<table>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							<input type="submit" name="logout" value="Log Out">
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
				</table>
			</form>
		</div>
</div>
<?php
include "footer.php";
?>
