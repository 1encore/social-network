<?php
/*--------------------------database---------------------------------*/
	$connection=new mysqli("localhost", "root", "", "mydatabase");
	if($connection->connect_error){
		echo "Error with db connection.";
	}
	$page="";
	session_start();

/*--------------------------actions---------------------------------*/
	if(isset($_GET['act'])){
		if($_GET['act']=="login"){
			$login=$_POST['login'];
			$password=$_POST['password'];
			$query=$connection->query("SELECT * FROM snusers WHERE login=\"$login\" AND password=\"$password\"");
			if($row=$query->fetch_object()){
				if($row->active){
					$_SESSION['id']=$row->id;
					$_SESSION['pas']=$password;
					$page="home.php";
				}else{
					$page="index.php?error=1";
				}
			}else{
				$page="index.php?error=1";
			}
		}else if($_GET['act']=="reg"){
			$name=$_POST['name'];
			$surname=$_POST['surname'];
			$login=$_POST['login'];
			$password=$_POST['password'];
			$email=$_POST['email'];
			$age=$_POST['age'];
			$date=$_POST['date'];
			$gender=$_POST['gender'];
			$city=$_POST['city'];
			$country="";
			$city_id="";
			$query=$connection->query("SELECT * FROM sncities WHERE name=\"$city\"");
			if($row=$query->fetch_object()){
				$city_id=$row->id;
				$country=$row->country_id;
			}
			$avatar="simple.png";
			$query_check=$connection->query("SELECT * FROM snusers WHERE login = \"$login\"");
			if($row=$query_check->fetch_object()){

			}else{
				$query=$connection->query("INSERT INTO snusers(id,login,password,email,active) VALUES(NULL,\"$login\",\"$password\",\"$email\",1)");
				$query_id=$connection->query("SELECT * FROM snusers WHERE login = \"$login\"");
				if($row_id=$query_id->fetch_object()){
					$id_user=$row_id->id;
					$query=$connection->query("INSERT INTO snuser_profile(id,user_id,name,surname,birth_date,country_id,city_id,age,gender,avatar_url) VALUES(NULL,\"$id_user\",\"$name\",\"$surname\",\"$date\",\"$country\",\"$city_id\",\"$age\",\"$gender\",\"$avatar\")");
					$query=$connection->query("INSERT INTO snuser_pictures(id,user_id,url,post_date,is_avatar,active) VALUES(NULL,\"$id_user\",\"$avatar\",NULL,1,1)");
					$page="index.php";
				}
			}
		}else if($_GET['act']=="edit"){
			$id=$_GET['id'];
			$name=$_POST['name'];
			$surname=$_POST['surname'];
			$login=$_POST['login'];
			$password=$_POST['password'];
			$email=$_POST['email'];
			$age=$_POST['age'];
			$gender=$_POST['gender'];
			$date=$_POST['date'];
			$query=$connection->query("UPDATE snusers SET login =\"$login\",email=\"$email\" WHERE id=\"$id\"");
			if($password!=""){
				$query=$connection->query("UPDATE snusers SET password = \"$password\"");
			}
			$query=$connection->query("UPDATE snuser_profile SET name=\"$name\",surname=\"$surname\",age=\"$age\",birth_date=\"$date\",gender=\"$gender\" WHERE user_id=\"$id\"");
			$page="home.php?page=profile&id=".$id;
		}else if($_GET['act']=="editavatar"){
			$id=$_GET['id'];
			$temp_file = $_FILES['picture_upload'];
		    $salt = "dratuti";
		    $query=$connection->query("SELECT id FROM snuser_pictures WHERE id = (SELECT MAX(id) FROM snuser_pictures)");
		    if($row=$query->fetch_object()){
			    $file_name = sha1(($row->id+1)+$salt).".jpg";
			    move_uploaded_file($_FILES['picture_upload']['tmp_name'],"assets/img/$file_name");
			    $query_ch=$connection->query("UPDATE snuser_pictures SET is_avatar = 0 WHERE user_id=\"$id\"");
			    $query=$connection->query("INSERT INTO snuser_pictures(id,user_id,url,post_date,is_avatar,active) VALUES(NULL,\"$id\",\"$file_name\",NULL,1,1)");
			    $query=$connection->query("UPDATE snuser_profile SET avatar_url=\"$file_name\" WHERE user_id=\"$id\"");
			}else{
			    $file_name = sha1("1"+$salt).".jpg";
			    move_uploaded_file($_FILES['picture_upload']['tmp_name'],"assets/img/$file_name");
			    $id=$_SESSION['id'];
			    $query_ch=$connection->query("UPDATE snuser_pictures SET is_avatar = 0 WHERE user_id=\"$id\"");
			    $query=$connection->query("INSERT INTO snuser_pictures(id,user_id,url,post_date,active) VALUES(NULL,\"$id\",\"$file_name\",NULL,1,1)");
			    $query=$connection->query("UPDATE snuser_profile SET avatar_url=\"$file_name\"");
			}
			$page="home.php?page=profile&id=".$id;
		}else if($_GET['act']=="posttext"){
			$id=$_GET['id'];
			$value=$_POST['value'];
			$query=$connection->query("INSERT INTO snwalls(id,user_id,text,post_date,active) VALUES(NULL,\"$id\",\"$value\",NULL,1)");
			$page="home.php?page=profile&id=".$id;
		}else if($_GET['act']=="deletepost"){
			$id=$_GET['id'];
			$id_user = $_SESSION['id'];
			$password_user = $_SESSION['pas'];
			$query_ch=$connection->query("SELECT * FROM snusers WHERE id = \"$id_user\" AND password=\"$password_user\"");
			if($row_ch=$query_ch->fetch_object()){
				$query=$connection->query("UPDATE snwalls SET active=0 WHERE id=\"$id\"");
			}
			$page="home.php?page=profile&id=".$id;
		}else if($_GET['act']=="addstatus"){
			$id=$_GET['id'];
			$text=$_POST['textfld'];
			$id_user = $_SESSION['id'];
			$password_user = $_SESSION['pas'];
			$query_ch=$connection->query("SELECT * FROM snusers WHERE id = \"$id_user\" AND password=\"$password_user\"");
			if($row_ch=$query_ch->fetch_object()){
				$query_status_ch=$connection->query("SELECT * FROM snuser_status WHERE user_id = \"$id\"");
				if($row_status_ch=$query_status_ch->fetch_object()){
					$query=$connection->query("UPDATE snuser_status SET value = \"$text\"");
				}else{
					$query=$connection->query("INSERT INTO snuser_status(id,user_id,value) VALUES(NULL,\"$id\",\"$text\")");
				}

			}
			$page="home.php?page=profile&id=".$id;
		}else if($_GET['act']=="addcomment"){
			$id_post=$_GET['idpost'];
			$id=$_GET['id'];
			$comment=$_POST['comment'];
			$id_user = $_SESSION['id'];
			$password_user = $_SESSION['pas'];
			$query_ch=$connection->query("SELECT * FROM snusers WHERE id = \"$id_user\" AND password=\"$password_user\"");
			if($row_ch=$query_ch->fetch_object()){
				$query=$connection->query("INSERT INTO snwall_comments(id,wall_id,user_id,text,post_date,active) VALUES(NULL,\"$id_post\",\"$id\",\"$comment\",NULL,1)");
			}
			$page="home.php?page=profile&id=".$id;
		}else if($_GET['act']=="deletecom"){
			$id=$_GET['id'];
			$pagefrom=$_GET['from'];
			$id_user = $_SESSION['id'];
			$password_user = $_SESSION['pas'];
			$query_ch=$connection->query("SELECT * FROM snusers WHERE id = \"$id_user\" AND password=\"$password_user\"");
			if($row_ch=$query_ch->fetch_object()){
				$query=$connection->query("UPDATE snwall_comments SET active = 0 WHERE id=\"$id\"");
			}
			if($pagefrom=="posts"){
				$page="home.php?page=posts";
			}else{
				$page="home.php?page=profile&id=".$id_user;
			}
		}else if($_GET['act']=="request"){
			$idu=$_GET['idu'];
			$id=$_GET['id'];
			$query=$connection->query("INSERT INTO snfriend_requests(id,user_id,friend_id,sent_date) VALUES(NULL,\"$idu\",\"$id\",NULL)");
			$page="home.php?page=profile&id=".$id;
		}else if($_GET['act']=="accept"){
			$id=$_GET['id'];
			$from=$_GET['from'];
			$req=$_GET['req'];
			$query=$connection->query("INSERT INTO snfriends(id,user_id,friend_id) VALUES(NULL,\"$id\",\"$from\")");
			$query=$connection->query("DELETE FROM snfriend_requests WHERE id=\"$req\"");
			$page="home.php?page=friends";
		}else if($_GET['act']=="sendmsg"){
			$idto=$_POST['idto'];
			$id=$_SESSION['id'];
			$text=$_POST['value'];
			$friendship="";
			$pagesent=$_POST['page'];
			$query=$connection->query("SELECT * FROM snfriends WHERE (user_id=$idto AND friend_id=$id) OR (user_id=$id AND friend_id=$idto)");
			if($row=$query->fetch_object()){
				$friendship=$row->id;
			}
			$connection->query("INSERT INTO `snmessages`(`id`, `user_id`, `sender_id`, `text`, `readen`, `user_deleted`, `sender_deleted`, `sent_date`, `friends`) VALUES (NULL,$idto,$id,\"$text\",0,0,0,NOW(),$friendship)");
			if($pagesent=="profile"){
				$page="home.php?page=profile&id=".$idto;
			}else if($pagesent=="dialog"){
				$page="home.php?page=dialog&fr=".$friendship;
			}
		}else if($_GET['act']=="deletephoto"){
			$id=$_GET['id'];
			$connection->query("UPDATE snuser_pictures SET active=0 WHERE id=$id");
			$page="home.php?page=photos";
		}else if($_GET['act']=="search"){
			
		}else if($_GET['act']=="logout"){
			session_destroy();
			$page="index.php";
		}
		header("Location:".$page);
	}
?>