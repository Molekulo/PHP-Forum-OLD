<?php require "config.php";
$page = new Page();
$model = new Model();
$page->display_header("Svi korisnici");
 if(isset($_SESSION["valid_admin"])) {
	echo "<h3 class='text-right'>Prijavljeni ste kao: " .$_SESSION["valid_admin"]. "</h3>";
	$model->select_users();
	$page->logout();
} else {
	echo "<h3 class='text-center'>Da biste videli ovu stranicu, morate da budete prijavljeni u sistem kao administrator</h3>";
}
$page->back_to_home();
$page->display_footer();
?>