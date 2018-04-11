<?php 
require "config.php";
$page = new Page();	
if (!isset($_SESSION["valid_user"]) && !isset($_SESSION["valid_admin"])) { //korisnik nije prijavljen 
	$page->display_header("Validacija");
	echo "<h3 class='text-center'>Prijavite se u sistem!</h3>";
	$page->display_login_form(); 
	$page->to_registration(); 
} else { //korisnik prijavljen
	$page->secret_page();
	$page->logout(); 
}
$page->display_footer();
?>
