<?php 
class Page { // klasa koja omogucava prikaz na stranicama i startovanje sesije
	
	public function __construct() {
		session_start();
	}
	
	public function display_header($title) {
		$output = <<<HEADER
		<!DOCTYPE html>
			<html>
			<head>
				<title>{$title}</title>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
				<link rel="stylesheet" type="text/css" href="style.css">
			</head>
			<body>
HEADER;
		echo $output;
	}
	
	public function display_footer() {
		$output = <<<FOOTER
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
				<script type="text/javascript" src="lib/bootstrap/js/bootstrap.min.js"></script>
			</body>
			</html>
FOOTER;
		echo $output;
	}
	
	public function display_registration_form() {
		$output = <<<REGFORM
		<div class="container">
			<form role="form" method="post" action="potvrda_registracije.php">
			  <div class="form-group">
			    <label for="username">Odaberite korisničko ime:</label>
			    <input name="username" type="username" class="form-control" id="username">
			  </div>
			  <div class="form-group">
			    <label for="email">Vaša e-mail adresa:</label>
			    <input name="email" type="email" class="form-control" id="email">
			  </div>
			  <div class="form-group">
			    <label for="pwd">Šifra:</label>
			    <input name="pwd" type="password" class="form-control" id="pwd">
			  </div>
			  <div class="text-center">
			  	<button type="submit" class="btn btn-default">Unesi</button>
			  </div>
			</form>
		</div>
REGFORM;
		echo $output;
	}
	
	public function back_to_home() {
		$output = <<<BACK
		<h5 class="text-center"><a href="index.php">Povratak na početnu stranicu</a></h5>
BACK;
		echo $output;
	}
	
	public static function to_registration() {
		$output = <<<REGIST
		<h3 class="text-center"><a href="registracija.php">Registrujte se</a></h3>
REGIST;
		echo $output;
	}
        
	public function display_login_form() {
		$token = md5(rand(1, 1000)*rand(200,20000)*2.5);
		$_POST["token"] = $token;
		$_SESSION["token"] = $_POST["token"];
		$output = <<<LOGIN
		<div class="container">
			<form role="form" method="post" action="prijava.php">
			  <input type="hidden" name="token" value={$token}>
			  <div class="form-group">
			    <label for="username">Korisničko ime:</label>
			    <input name="username" type="username" class="form-control" id="username" placeholder="Ime">
			  </div>
			  <div class="form-group">
			    <label for="pwd">Šifra:</label>
			    <input name="pwd" type="password" class="form-control" id="pwd" placeholder="Šifra">
			  </div>
			  <div class="text-center">
			  	<button type="submit" class="btn btn-default">Potvrdi</button>
			  </div>
			</form>
		</div>
LOGIN;
		echo $output;
	}
	
	public function display_secret_page_admin() {
		$output = <<<SECRETADMIN
		<div class="container">
			<div class="jumbotron">
				<h1>Dobrodošli u sistem!</h1>
				<p class='text-center'><a class="btn btn-primary btn-lg" href="all_users.php" role="button">Pogledaj sve korisnike</a></p>
				<p class='text-center'><a class="btn btn-primary btn-lg" href="all_news.php" role="button">Pogledaj sve vesti</a></p>
				<p class='text-center'><a class="btn btn-primary btn-lg" href="add_news.php" role="button">Dodaj vesti</a></p>
				<p class='text-center'><a class="btn btn-primary btn-lg" href="create_admin.php" role="button">Dodaj administratora</a></p>
			</div>
		</div>
SECRETADMIN;
		echo $output;
	}
	
	public function display_secret_page_user() {
		$output = <<<SECRETUSER
		<div class="container">
			<div class="jumbotron">
				<h1>Dobrodošli u sistem!</h1>
					<p class='text-center'><a class="btn btn-primary btn-lg" href="all_news.php" role="button">Pogledaj sve vesti</a></p>
			</div>
		</div>
SECRETUSER;
		echo $output;
	}
	
	public function secret_page() {
		$this->display_header("Dobrodošli u sistem");
		if(isset($_SESSION["valid_user"])) {
			echo "<h3 class='text-right'>Prijavljeni ste kao: " .$_SESSION["valid_user"]. "</h3>";
			$this->display_secret_page_user();
		} else if(isset($_SESSION["valid_admin"])) {
			echo "<h3 class='text-right'>Prijavljeni ste kao: " .$_SESSION["valid_admin"]. "</h3>";
			$this->display_secret_page_admin();
		}
	}
	
	public function logout() { 
		$output = <<<LOGOUT
		<h4 class="text-center"><a href="odjava.php">Odjavite se</a></h4>
LOGOUT;
		echo $output;
	}

	public function error_check_user() { 
		$output = <<<CHECKUSER
		<h3 class="text-center" style="color: red">Korisničko ime ili šifra nisu tačni. Probajte ponovo!</h3>
CHECKUSER;
		echo $output;
	}
}
