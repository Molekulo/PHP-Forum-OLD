<?php require"config.php";

if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["pwd"])) {
	$username = htmlentities(trim($_POST["username"]));
	$email = htmlentities(trim($_POST["email"]));
	$pwd = sha1($_POST["pwd"]);
} else {
	$username = "";
	$email = "";
	$pwd = "";
}

$page = new Page();
$model = new Model();

$page->display_header("Potvrda registracije"); 	
$model->register_user($username, $email, $pwd); 
$page->back_to_home(); 
$page->display_footer();
?> 