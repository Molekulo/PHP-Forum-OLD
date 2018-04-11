<?php
require_once "config.php";

class Model extends Connect {
	
	public function register_user($username, $email, $pwd) {

		if (!$username || !$email || !$pwd) {
     		echo "<h1 class='text-center'>Niste uneli sve tražene podatke.</h1><br />"
          	."<h1 class='text-center'>Vratite se nazad i pokušajte ponovo.</h1>";
          	Page::to_registration();
     		exit;
  		}
		$username = mysqli_real_escape_string($this->conn,$username);
		$email = mysqli_real_escape_string($this->conn,$email);

  		//Upisivanje u bazu podataka: korisničko ime, email i šifra
  		$query = "INSERT INTO user (username, email, password, admin) VALUES ('".$username."', '".$email."', '".$pwd."',0)";
  		
  		$result = $this->conn->query($query);

  		if ($result) {
      		echo "<h1 class='text-center'>Registracija uspešna!</h1>";
  		} else {
			$sql = "SELECT username, email FROM user";
			$result = $this->conn->query($sql);
			while($rw = $result->fetch_object()) {
				if($rw->username == $username) {
					echo "<h1 class='text-center'>Greška, korisnik već postoji.</h1>";
				} elseif($rw->email == $email) {
					echo "<h1 class='text-center'>Greška, email već postoji.</h1>";
				} 
			}
  	  		Page::to_registration();
  		}
	}
	
	public function check_user($username, $pwd) {
		//proveriti referer
		$ref = $_SERVER["HTTP_REFERER"];
		//kreirati token
		$token = "";
		$_SESSION["token"] = $token;
  		//Pretraga baze podataka sa korisničkim imenom i lozinkom
		$query = "SELECT count(*) FROM user WHERE
              	  username = '".$username."' AND
                  password = '".$pwd."'";

        $result = $this->conn->query($query);
        
        if(!$result || ($ref!="http://localhost/Zadatak3/index.php" && $ref!="http://localhost/Zadatak3/")) {
        	echo "<h1>Došlo je do greške</h1>";
        	exit;
        }

        $row = $result->fetch_row();
    	$count = $row[0];

	    if ($count > 0) { 
		  
		  $admin_query = "SELECT admin FROM user WHERE username= '" .$username. "'";
		  // proveri administratora
		  $result_admin = $this->conn->query($admin_query);
		  if(!$result_admin) {
        	echo "<h1>Došlo je do greške</h1>";
        	exit;
		  }
		  $row_admin = $result_admin->fetch_object();
			// dodela sesije  
			if($row_admin->admin == 1) { 
			  $_SESSION["valid_admin"] = $username;
			} else {
			  $_SESSION["valid_user"] = $username;
			}   
	    } else {
	      // Korisnicko ime i šifra ne postoje u bazi podataka
	      echo "<h1 class='text-center'>Prijavite se u sistem!</h1>";
		}
	}
	
	public function select_users() {

		$query = "SELECT username, email FROM user";
		$result = $this->conn->query($query);

		if(!$result) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
			}

		if ($result->num_rows > 0) { 
		  echo " 
					<table class='table table-bordered'>
						<tr>
						  <th>Korisnik</th>
						  <th>E-mail</th> 
						</tr>";
						while($row = $result->fetch_assoc()) { 
						  echo "<tr>
							  <td>{$row['username']}</td>
							  <td>{$row['email']}</td> 
						  </tr>";
						 }  
			echo "  </table>";
		} else {
			  echo "0 rezultata";
		}
	}
	
	public function select_users_to_admin() {
		$query = "SELECT user_id, username, email FROM user";
		$result = $this->conn->query($query);
		if(!$result && !$result_admin) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
			}
		
		if ($result->num_rows > 0) { 
		  echo " 
					<table class='table table-bordered'>
						<tr>
						  <th>Korisnik</th>
						  <th>E-mail</th> 
						</tr>";
						while($row = $result->fetch_assoc()) { 
						  $query_admin = "SELECT admin from user WHERE username='".$row["username"]."'";
						  $result_admin = $this->conn->query($query_admin);
						  $row_admin = $result_admin->fetch_object();
						  echo "<tr>
							  <td>{$row['username']}</td>
							  <td>{$row['email']}</td>"; 
							  if($row["username"] == $_SESSION["valid_admin"] || $row_admin->admin == 1) {
								  echo "<td>Administrator</td>";
							  }	else {
									echo "<td><a href='add_admin.php?user_id=".$row["user_id"]."'><strong>Dodaj kao administratora</strong></a></td>"; 
							  }
						      echo "</tr>";    
						 }  
			echo "  </table>";
		} else {
			  echo "0 rezultata";
		}
	}
	
	public function create_admin($user) {
		$query = "UPDATE user SET admin=1 WHERE user_id=".$user;
		$result = $this->conn->query($query);
		if(!$result) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
		} else {
			echo "<h1 class='text-center'>Korisnik je postao administrator</h1>";
		}	
	}
	
	public function select_category() {
		$query = "SELECT DISTINCT category FROM news";
		$result = $this->conn->query($query);
		if(!$result) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
		}
		echo "<h1 style='text-align:center;'>Odaberite kategoriju vesti</h1>";
		echo "<div class='navigacija'>";
		echo "<a href='all_news.php'>Sve</a>";
		while($row = $result->fetch_object()) {
			echo "<a href='all_news.php?cat={$row->category}'>" .$row->category . "</a>";
		}
		echo "</div>";
	}
	
        public function select_news_cat() {
                $query = "SELECT DISTINCT category FROM news";
		$result = $this->conn->query($query);
                if(!$result) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
		}
                echo '<div class="container">
			<form role="form" method="post" action="confirm_news.php">
			  <div class="form-group">
			    <label for="news_cat">Odaberite kategoriju vesti:</label>
                            <select name="news_cat" class="form-control" id="news_cat">';
                               while($row = $result->fetch_object()) {
                                    echo "<option value='{$row->category}'>{$row->category}</option>";
                                }
                            echo '</select>    
			  </div>
			  <div class="form-group">
			    <label for="news_text">Unesite Vašu vest:</label>
			    <textarea rows="5" name="news_text" class="form-control" id="news_text" placeholder="Unesite vesti"></textarea>
			  </div>
			  <div class="text-center">
			  	<button type="submit" class="btn btn-default">Potvrdi</button>
			  </div>
			</form>
	    </div>';
                
        }
        
	public function display_category($cat) {
		$query = "SELECT news_text, news_id FROM news WHERE category='{$cat}'";
		$result = $this->conn->query($query);
		if(!$result) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
		}
		echo "<h1 style='text-align:center;'>".$cat."</h1>";
		while($row = $result->fetch_object()) {
			echo "<div class='container'><h2>".$row->news_text."</h2><hr>
			<h3>Komentari</h3><hr>
			{$this->get_comments($row->news_id)}";
			if(isset($_SESSION["valid_admin"])) {
				echo "<a href='delete.php?news_id=".$row->news_id."'>Obriši vesti</a>";
			}
			echo "<a href='add_comment.php?news_id={$row->news_id}' style='float:right;'>Dodaj komentar</a></div>";
		}
		
	}
	
	public function select_all_news() {    
		
		$query = "SELECT news_text, news_id FROM news";
		$result = $this->conn->query($query); 
		
		if(!$result) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
		}
		echo "<h1 style='text-align:center;'>Sve vesti</h1>";
		while($row = $result->fetch_object()) {
			echo "<div class='container'><h2>".$row->news_text."</h2><hr>
			<h3>Komentari</h3><hr>
			{$this->get_comments($row->news_id)}";
			if(isset($_SESSION["valid_admin"])) {
				echo "<a href='delete.php?news_id=".$row->news_id."'>Obriši vesti</a>";
			}
			echo "<a href='add_comment.php?news_id={$row->news_id}' style='float:right;'>Dodaj komentar</a></div>";
		}     
    }
	
	public function select_one_news($id) {
		$query = "SELECT news_text FROM news WHERE news_id={$id}";
		$result = $this->conn->query($query);
		if(!$result) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
		}
		echo "<h1 style='text-align:center;'>Dodaj komentar na vesti</h1>";
		$row = $result->fetch_object();
		echo "<div class='container'><h2>".$row->news_text."</h2><hr>
			<h3>Komentari</h3>
			<p>".$this->get_comments($id)."</p><hr>
			<form method='post' action='confirm_comment.php?news_id={$id}'>
			<textarea name='comment' rows='4' cols='64' placeholder='Ovde ostavite svoj komentar'></textarea>
			<input type='submit' value='Dodaj komentar'>
			</form>
			";
	}
	
	public function get_comments($id) {
		$query = "SELECT * FROM comments WHERE news_id={$id}";
		$result = $this->conn->query($query);
		if(!$result) {
			  echo "<h1>Došlo je do greške</h1>";
			  exit;
		}
		$output = "";
		while($row = $result->fetch_object()) {
			$output .= "<p>Komentar ostavio: <strong>{$row->username}</strong></p>";
			$output .= "<p>".$row->comment_text."</p><br>";
			if(isset($_SESSION["valid_admin"]) || $row->username == $_SESSION["valid_user"]) {
				$output .= "<a href='delete.php?comm_id={$row->comm_id}'>Obriši komentar</a><br><hr>";
			}
			$output .= "<hr>";
		}
		return $output;
	}
	
	public function add_comment($news_id, $comm_text, $username) {
		if(empty($comm_text)) {
			echo "<h1 class='text-center'>Greška, komentar nije dodat jer ste ostavili prazno polje.</h1>";
		} else {
			$query = "INSERT INTO comments (news_id, comment_text, username) VALUES ({$news_id},'{$comm_text}', '{$username}')";
			$result = $this->conn->query($query);
			if ($result) {
				echo "<h1 class='text-center'>Komentar uspešno dodat!</h1>";
			} else {
				echo "<h1 class='text-center'>Greška, komentar nije dodat.</h1>";
				Page::to_registration();
			}
		}
	}
        
        public function remove_comment($comm_id) {
             $query = "DELETE FROM comments WHERE comm_id = $comm_id";
             $result = $this->conn->query($query);
             if($result) {
                 echo "<h1 class='text-center'>Komentar uspešno obrisan!</h1>";
             } else {
                 echo "<h1 class='text-center'>Komentar nije obrisan!</h1>";
             }
        }
        
        public function add_news($news_text, $news_cat, $user) {
            if(empty($news_text)) {
				echo "<h1 class='text-center'>Niste uneli vesti</h1>";
			} else {
				$q = "SELECT user_id from user WHERE username = '{$user}'";
				$res = $this->conn->query($q);
				$row = $res->fetch_object(); 
				$user_id = $row->user_id;
				$query = "INSERT INTO news (user_id, news_text, category) VALUES ($user_id,'{$news_text}', '{$news_cat}')";
				$result = $this->conn->query($query);
				if ($result) {
					echo "<h1 class='text-center'>Vesti uspešno dodate!</h1>";
				} else {
					echo "<h1 class='text-center'>Greška, vesti nisu dodate.</h1>";
				}	
			}
        }
        
        public function remove_news($news_id) {
            $query = "DELETE FROM news WHERE news_id = $news_id";
             $result = $this->conn->query($query);
             if($result) {
                 $q = "DELETE FROM comments WHERE news_id = $news_id";
				 $res = $this->conn->query($q);
				 echo "<h1 class='text-center'>Vesti uspešno obrisane!</h1>";
             } else {
                 echo "<h1 class='text-center'>Vesti nisu obrisane!</h1>";
             }
        }
        
        public function check_news_category($category) {
            $query = "SELECT category FROM news WHERE category = '$category'";
            $result = $this->conn->query($query);
            if($result->num_rows == 1) {
                return false;
            } else {
                return true;
            }
        }
        
        public function get_category($news_id) {
            $query = "SELECT DISTINCT category FROM news WHERE news_id = $news_id";
            $result = $this->conn->query($query);
            $categ = $result->fetch_object();
            $category = $categ->category;
            return $category;
        }
        
}