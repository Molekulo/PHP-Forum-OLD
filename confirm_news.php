<?php require "config.php";
$page = new Page();
$model = new Model();
$page->display_header("Unos vesti");
$news_cat = $_POST["news_cat"];
$news_text = $_POST["news_text"];
if(isset($_SESSION["valid_admin"])) { //korisnik je prijavljen kao admin
	$user = $_SESSION["valid_admin"];
	echo "<h3 class='text-right'>Prijavljeni ste kao: " .$user. "</h3>";
	$model->add_news($news_text, $news_cat, $user);
	$page->logout();
} else { //korisnik nije prijavljen
	echo "<h3 class='text-center'>Da biste videli ovu stranicu, morate da budete prijavljeni u sistem kao administrator</h3>";
}
$page->back_to_home();
$page->display_footer();

