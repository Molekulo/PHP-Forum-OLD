<?php require "config.php";
$page = new Page();
$model = new Model();
$page->display_header("Dodaj vesti");
if(isset($_SESSION["valid_admin"])) { //korisnik je prijavljen kao admin
	$user = $_SESSION["valid_admin"];
	echo "<h3 class='text-right'>Prijavljeni ste kao: " .$user. "</h3>";
	echo "<h1 class='text-center'>Dodavanje vesti</h1>";
        $model->select_news_cat();
	$page->logout();
} else { //korisnik nije prijavljen kao admin
	echo "<h3 class='text-center'>Da biste videli ovu stranicu, morate da budete prijavljeni u sistem kao administrator</h3>";
}
$page->back_to_home();
$page->display_footer();