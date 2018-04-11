<?php require "config.php";
$page = new Page();
$model = new Model();
$page->display_header("Sve vesti");
if(isset($_SESSION["valid_admin"]) || isset($_SESSION["valid_user"])) { //korisnik je prijavljen
	$user = isset($_SESSION["valid_admin"]) ? $_SESSION["valid_admin"] : $_SESSION["valid_user"];
	echo "<h3 class='text-right'>Prijavljeni ste kao: " .$user. "</h3>";
	$model->select_category();
	if(empty($_GET['cat'])) {
		$model->select_all_news();
	} else {
		$model->display_category($_GET['cat']);
	}
	$page->logout();
	$page->back_to_home();
} else { //korisnik nije prijavljen
	echo "<h3 class='text-center'>Da biste videli ovu stranicu, morate da budete prijavljeni u sistem</h3>";
}
$page->display_footer();


