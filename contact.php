<?PHP
// CONTACT PAGE

include "header.php";

$validation="failed";
$firstname="";
$lastname="";
$email="";
$memo="";
$errors=array();

print "<div class='container'>";


if(isset($_POST['submit'])) {
	// Name
	if(!empty($_POST['name'])) {
		$name=$_POST['name'];
		if(strlen(trim($name))==0)
			$errors['name']="Name cannot be blank.";
		else if(!preg_match("/^[a-zA-Z '-.]+$/", $name))
			$errors['name']="Name cannot include special characters.";
	} else {
		$errors['name']="This field is required.";
	}
	
	// Email
	if(!empty($_POST['email'])) {
		$email=$_POST['email'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email']="Invalid email address.";
		}
	} else {
		$errors['email']="This field is required.";
	}
	
	// Memo
	if(!empty($_POST['memo']))
		$memo=$_POST['memo'];
	
	// Show errors
	$errorCount=count($errors);
	if($errorCount==0)
		$validation="Success";		
	
}

print "<div class='row'><div class='col-md-6 col-md-offset-3 center-it'>";
print "<h1 id='contactHeading'><strong>Join Email List / Send Message</strong></h1>";
print "</div></div>";
if($validation=="Success") {
	// Set up variables for db connection
	include "../dbconfig/dbparams.php";
	// Open databaes, enter info and close
	include "../dbconfig/dbentry.php";
	
	/*  TODO: use or remove
	
	?>
	<script>
	$(document).ready(function(){
		$("#succes").fadeIn();
	});
	</script>
	<?php 
	
	*/
	
	// Successful entry
	print "<div class='row'><div class='col-md-6 col-md-offset-3'";
	print "<div id='success'>";
	print "<p>Success!<br><br>Thank you, $name.</p>";
	print "<p>Your information has been saved.</p>";
	print "</div></div></div>";
	//print "</table>";
	
	// Send yourself email
	$headers = 'From: $email';
	mail("james.secor@gmail.com", "New Art Contact", $memo, $headers);
	
} else {

?>

<form id='contactForm' action="" method='post'>
	<!-- Maybe take out
	<div style='width:50%; margin:auto;'>
	<div class='form-group'>
		<label for="name">Name:</label>
		<input type="text" name="name" class="form-control">
	</div>
	<div class='form-group'>
		<label for="email">Email:</label>
		<input type="email" name="email" class="form-control">
	</div>
	</div>
	
	-->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
	
	<table>
		<tr>
			<td>Name</td>
			<td><input type='text' name='name' value="<?php echo isset($_POST['name']) ? $_POST['name']: ''; ?>"  required="required"></td>			
		</tr>
		<tr>
			<td colspan=2><small class="errorText"><?php echo array_key_exists('name', $errors) ? $errors['name'] : ""; ?></small></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type='email' name='email' value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"required="required"></td>
		</tr>
		<tr>
			<td colspan=2><small class="errorText"><?php echo array_key_exists('email', $errors) ? $errors['email'] : ""; ?></small></td>
		</tr>
		<tr>
			<td>Message</td>
			<td><textarea rows="6"  name='memo' placeholder='Enter comments here.' ><?php echo isset($_POST['memo']) ? $_POST['memo']: '' ?></textarea></td>
		</tr>
		<tr>
			<td></td><td colspan="3"><input type='submit' name='submit' value='Submit' formnovalidate></td>
		</tr>
	</table>
	
		</div>
	</div>
	
</form>


<?PHP

}

print "</div>";

include "footer.php"
?>