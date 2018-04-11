<?php require "config.php";
$page = new Page(); 	
if (!isset($_SESSION["valid_user"]) && !isset($_SESSION["valid_admin"])) {
	 $page->display_header("Registracija");
	 echo "<h3 class='text-center'>Registrujte se!</h3>";
	 $page->display_registration_form();
	 $page->back_to_home();
} else {
	 $page->secret_page();
	 $page->logout();	
}
$page->display_footer(); 
?>