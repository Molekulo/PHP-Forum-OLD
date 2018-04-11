<?php require "config.php";
$page = new Page();
// provera ako je korisnik prethodno bio prijavljen
if(isset($_SESSION['valid_user'])) {
	$old_user = $_SESSION['valid_user'];
	unset($_SESSION['valid_user']);
}
if(isset($_SESSION['valid_admin'])) {
	$old_admin = $_SESSION['valid_admin'];
	unset($_SESSION['valid_admin']);
}
session_destroy();

$page->display_header("Odjava");

if (!empty($old_user) || !empty($old_admin)) {
	echo "<h3 class='text-center'>Odjava uspešna.</h3><br />";
} else {
	// korisnik nije bio prijavljen ali je došao do ove stranice
	echo "<h3 class='text-center'>Niste bili prijavljeni, ne možete da budete odjavljeni.<br />"; 
}

$page->back_to_home();
$page->display_footer();
?>