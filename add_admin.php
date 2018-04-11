<?php require "config.php";
$page = new Page();
$model = new Model();
if (isset($_SESSION["valid_admin"])) {
	$user_id = $_GET["user_id"];
	$page->display_header("Registracija");
	echo "<h3 class='text-right'>Prijavljeni ste kao: " .$_SESSION["valid_admin"]. "</h3>";
	$model->create_admin($user_id);
	$page->back_to_home();
} else {
	$page->display_header("Validacija"); 
	echo "<h3 class='text-center'>Prijavite se u sistem!</h3>";
	$page->display_login_form(); 
	$page->to_registration(); 
}
$page->display_footer();