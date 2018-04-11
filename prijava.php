<?php require "config.php";
$username = htmlentities(trim($_POST["username"]));
$pwd = sha1($_POST["pwd"]);

$p = new Page(); 
$m = new Model();
$m->check_user($username, $pwd);
$p->display_header("Prijava");

if(isset($_SESSION["token"]) && (isset($_SESSION["valid_admin"]) || isset($_SESSION["valid_user"]))) {
	if (isset($_SESSION["valid_admin"])) { 
		echo "<h3 class='text-center'>Prijavljeni ste kao: " .$_SESSION["valid_admin"]. "</h3>";
		$p->display_secret_page_admin();
	} elseif(isset($_SESSION["valid_user"])) {
		echo "<h3 class='text-center'>Prijavljeni ste kao: " .$_SESSION["valid_user"]. "</h3>";
		$p->display_secret_page_user();
	}
	$p->back_to_home();
	$p->logout();
} else { 
	$p->error_check_user();
	$p->back_to_home(); 
	$p->to_registration(); 
}
$p->display_footer();
?>
