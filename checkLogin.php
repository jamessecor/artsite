<?php
function isLoggedIn() {
	if(isset($_SESSION['artsiteusername']))
		return TRUE;
	else
		return FALSE;
}

function logout() {
	unset($_SESSION['artsiteusername']);
}
?>