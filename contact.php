<?PHP
// CONTACT PAGE
session_start();
$_SESSION['activetab'] = 'contact';
include "header.php";

$validation="failed";
$firstname="";
$lastname="";
$email="";
$memo="";
$errors=array();

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
			$errors['name']="Name cannot include special characters";
	} else {
		$errors['name']="This field is required";
	}
	
	// Email
	if(!empty($_POST['email'])) {
		$email=$_POST['email'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email']="Invalid email address";
		}
	} else {
		$errors['email']="This field is required";
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

?>
<div class="spacer-row"></div>
<div class="container">
	<div class="row">
		<div class="col-lg-6 offset-lg-3 text-center">
			<h1 id='contactHeading'><strong>Join Email List / Send Message</strong></h1>
		</div>
	</div>
<?php
if($validation=="Success") {
	// Set up variables for db connection
	include "../dbconfig/dbparams.php";
	// Open databaes, enter info and close
	include "../dbconfig/dbentry.php";
	
	// Successful entry
	?>
	<div id='success'>
		<div class='row'>
			<div class='col-lg-8 col-lg-offset-2'>	
			<table>
				<tr><td>Success!</td></tr>
				<tr><td>Thank you, <?php echo $name; ?>.</td></tr>
				<tr><td>Your message has been sent.</td></tr>
				</table>
			</div>
		</div>
	</div>	
	<?php 
	// Send yourself email
	$memo .= "\r\n\r\nsender: $email"
	$headers = "From: james@jamessecor.com" . "\r\n" 
		. "Cc: $email" . "\r\n";
	mail("james.secor@gmail.com", "New Art Contact", $memo, $headers);
	
} else {

?>

	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<form action="" id="contactForm" method='post'>
				<div class="row col-lg-8 offset-lg-2">
					<div class="form-group full">
						<label for="name" class="bold-with-color">Name</label>
						<small class="errorText"><?php echo array_key_exists('name', $errors) ? $errors['name'] : ""; ?></small>
						<input type='text' class="form-control full" name='name' value="<?php echo isset($_POST['name']) ? $_POST['name']: ''; ?>"  required="required">
					</div>
					
					<div class="form-group full">
						<label for="email" class="bold-with-color">Email</label>
						<small class="errorText"><?php echo array_key_exists('email', $errors) ? $errors['email'] : ""; ?></small>
						<input type='email' class="form-control full" name='email' value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"required="required">
					</div>

					<div class="form-group full">
						<label for="message" class="bold-with-color">Message</label>
						<textarea rows="4" class="full" name='memo' placeholder='Enter comments here.' ><?php echo isset($_POST['memo']) ? $_POST['memo']: '' ?></textarea>
					</div>
					
					<div class="form-group">
						<small class="errorText"><?php echo array_key_exists('g-recaptcha-response', $errors) ? $errors['g-recaptcha-response'] : ""; ?></small>
						<div class="g-recaptcha" data-sitekey="6LcZnoQUAAAAABN4yNqWK9PTKzdLHkvqMgquBnH1"></div>
					</div>
					
					<div class="form-group">
						<input type='submit' name='submit' value='Submit' formnovalidate>
					</div>	
				</div>	
			</form>		
		</div>
	</div>
</div>

<?PHP

}

include "footer.php"
?>