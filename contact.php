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
	// reCaptcha
	if(!empty($_POST['g-recaptcha-response'])) {
		// Validate the response here
		$captcha = $_POST['g-recaptcha-response'];	    
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcZnoQUAAAAAB9l5IoN2ERJoqqgU49IcErmEd3X&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		$recaptchaResponse = json_decode($response);
		if(!$recaptchaResponse->success===true) { 
			$errors['g-recaptcha-response']="reCaptcha encountered an error. Please try again.";
		}
	} else {
		$errors['g-recaptcha-response']="Please complete the reCaptcha before submitting.";
	}
	
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
	if($errorCount==0) {
		$validation="Success";		
	}
	
}

print "<div class='row'><div class='col-md-6 col-md-offset-3 center-it'>";
print "<h1 id='contactHeading'><strong>Join Email List / Send Message</strong></h1>";
print "</div></div>";
if($validation=="Success") {
	// Set up variables for db connection
	include "../dbconfig/dbparams.php";
	// Open databaes, enter info and close
	include "../dbconfig/dbentry.php";
	
	// Successful entry
	?>
	<div id='success'>
		<div class='row'>
			<div class='col-md-6 col-md-offset-3'>	
			<table align="center">
				<tr><td>Success!</td></tr>
				<tr><td>Thank you, <?php echo $name; ?>.</td></tr>
				<tr><td>Your information has been saved. Your message, sent.</td></tr>
				<tr><td>Here's what you wrote:</td></tr>
				<tr><td><?php echo $memo; ?></td></tr>
				</table>
			</div>
		</div>
	</div>	
	<?php 
	// Send yourself email
	$headers = "From: $email";
	mail("james.secor@gmail.com", "New Art Contact from $email", $memo, $headers);
	
} else {

?>
<form id='contactForm' action="" method='post'>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
	<table align="center" class="full">
		<tr><td>Name</td></tr>
		<tr>
			<td><input type='text' class="full" name='name' value="<?php echo isset($_POST['name']) ? $_POST['name']: ''; ?>"  required="required"></td>			
		</tr>
		<tr>
			<td colspan=2><small class="errorText"><?php echo array_key_exists('name', $errors) ? $errors['name'] : ""; ?></small></td>
		</tr>
		<tr><td>Email</td></tr>
		<tr>
			<td><input type='email' class="full" name='email' value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"required="required"></td>
		</tr>
		<tr>
			<td><small class="errorText"><?php echo array_key_exists('email', $errors) ? $errors['email'] : ""; ?></small></td>
		</tr>
		<tr><td>Message</td></tr>
		<tr>
			<td><textarea rows="4" class="full" name='memo' placeholder='Enter comments here.' ><?php echo isset($_POST['memo']) ? $_POST['memo']: '' ?></textarea></td>
		</tr>
		<tr><td><div class="g-recaptcha" data-sitekey="6LcZnoQUAAAAABN4yNqWK9PTKzdLHkvqMgquBnH1"></div></td></tr>
		<tr><td style="height:.25em;"></td></tr>
		<tr>
			<td><small class="errorText"><?php echo array_key_exists('g-recaptcha-response', $errors) ? $errors['g-recaptcha-response'] : ""; ?></small></td>
		</tr>
		<tr>
			<td><input type='submit' name='submit' value='Submit' formnovalidate></td>
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