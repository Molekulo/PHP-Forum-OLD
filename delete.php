<?php require "config.php";
$page = new Page();
$model = new Model();
$page->display_header("Brisanje komentara i vesti");

if(isset($_SESSION["valid_admin"]) || isset($_SESSION["valid_user"])) { //korisnik je prijavljen
	$user = isset($_SESSION["valid_admin"]) ? $_SESSION["valid_admin"] : $_SESSION["valid_user"];
	echo "<h3 class='text-right'>Prijavljeni ste kao: " .$user. "</h3>";
        $comm_id = isset($_GET["comm_id"]) ? $_GET["comm_id"] : "";
        $news_id = isset($_GET["news_id"]) && isset($_SESSION["valid_admin"]) ? $_GET["news_id"] : "";
        
        if(!empty($comm_id)) {
            $model->remove_comment($comm_id);           
        }
        
        if(isset($_SESSION["valid_admin"])&&!empty($news_id)) {
            if($model->check_news_category($model->get_category($news_id))) {
                $model->remove_news($news_id);
            } else {
                echo "<h3 class='text-center'>Ne možete da obrišete vest jer morate imati bar jednu vest iz kategorije</h3>";
            } 
        } 
}        
else { //korisnik nije prijavljen
            echo "<h3 class='text-center'>Da biste videli ovu stranicu, morate da budete prijavljeni u sistem</h3>";
}

$page->back_to_home();
$page->display_footer();