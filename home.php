<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Facebook Theme</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" src="assets/js/script.js"></script>
        <link href="assets/css/facebook.css" rel="stylesheet">
    </head>
    <body>
    <?php
     	session_start();
    	$page="posts.php";
    	$id=$_SESSION['id'];
    	if(isset($_GET['page'])){
    		if($_GET['page']=="profile"){
    			$page="profile.php";
    		}else if($_GET['page']=="posts"){
    			$page="posts.php";
    		}else if($_GET['page']=="photos"){
    			$page="photos.php";
    		}else if($_GET['page']=="friends"){
    			$page="friends.php";
    		}else if($_GET['page']=="messages"){
    			$page="messages.php";
    		}else if($_GET['page']=="dialog"){
    			$page="dialog.php";
    		}
    	}
		$connection=new mysqli("localhost", "root", "", "myDatabase");
		 if($connection->connect_error){
		 	echo "Error with db connection.";
		 }
    ?>
        <div class="wrapper">
			<div class="box">
				<div class="row row-offcanvas row-offcanvas-left">			
					<!-- sidebar -->
					<div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar" style="overflow: hidden;">
						<ul class="nav">
							<li><a href="#" data-toggle="offcanvas" class="visible-xs text-center"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
						</ul>
						<ul class="nav hidden-xs" id="lg-menu">
							<li class="active"><a href="home.php?page=profile&id=<?php echo $id; ?>"><i class="glyphicon glyphicon-list-alt"></i> Profile</a></li>
							<li><a href="home.php?page=friends"><i class="glyphicon glyphicon-plus"></i> Friends</a></li>
							<li><a href="home.php?page=messages"><i class="glyphicon glyphicon-envelope"></i> Messages</a></li>
							<li><a href="home.php?page=photos"><i class="glyphicon glyphicon-picture"></i> Photos</a></li>
						</ul>
						<ul class="list-unstyled hidden-xs" id="sidebar-footer" style="margin-bottom: -20px">
							<li style="margin-bottom: -20px"><h4>Contacts</h4></li>
							<li>
							  <a href="http://vk.com/hg1zadr"><h5><i class="glyphicon glyphicon-bullhorn"></i>  VK</h5></a>
							</li>
						</ul>
						<!-- tiny only nav-->
					  <ul class="nav visible-xs" id="xs-menu">
							<li><a href="#featured" class="text-center"><i class="glyphicon glyphicon-list-alt"></i></a></li>
							<li><a href="#stories" class="text-center"><i class="glyphicon glyphicon-list"></i></a></li>
							<li><a href="#" class="text-center"><i class="glyphicon glyphicon-paperclip"></i></a></li>
							<li><a href="#" class="text-center"><i class="glyphicon glyphicon-refresh"></i></a></li>
						</ul>
					</div>
					<!-- /sidebar -->
					<!-- main right col -->
					<div class="column col-sm-10 col-xs-11" id="main">
						<!-- top nav -->
						<div class="navbar navbar-blue navbar-static-top">  
							<div class="navbar-header">
							  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							  </button>
							  <a href="http://usebootstrap.com/theme/facebook" class="navbar-brand logo">b</a>
							</div>
							<nav class="collapse navbar-collapse" role="navigation">
							<form class="navbar-form navbar-left">
								<div class="input-group input-group-sm" style="max-width:360px;">
								  <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
								  <div class="input-group-btn">
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								  </div>
								</div>
							</form>
							<ul class="nav navbar-nav">
							  <li>
								<a href="home.php"><i class="glyphicon glyphicon-home"></i> Home</a>
							  </li>
							  <li>
								<a href="#postModal" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Post</a>
							  </li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
							  <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
								<ul class="dropdown-menu">
								  <li><a href="home.php?page=profile&id=<?php echo $id; ?>">Profile</a></li>
								  <li><a href="engine.php?act=logout">Log out</a></li>
								</ul>
							  </li>
							</ul>
							</nav>
						</div>
						<!-- /top nav -->
						<div class="padding" style="margin-top: 2%">
						<?php include "pages/".$page; ?>
						</div><!-- /padding -->
					</div>
					<!-- /main -->	  
				</div>
			</div>
		</div>
		<!--post modal-->
		<div id="sendmsg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog">
		  <div class="modal-content">
			  <div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					Send message
			  </div>
			  <div class="modal-body">
			  <?php $idto = $_GET['id'];?>
				  <form class="form center-block" method="post" action="engine.php?act=sendmsg">
					<div class="form-group">
					  <textarea class="form-control input-lg" autofocus="" placeholder="Type message." name="value"></textarea>
					</div>
					<div class="modal-footer">
					  <div>
					  <input type="hidden" name="idto" value="<?php echo $idto; ?>"></input>
					  <input type="hidden" name="page" value="profile"></input>
					  <input type="submit" class="btn btn-primary btn-sm" value="Send"></input>
						<ul class="pull-left list-inline"><li><a href="#"><i class="glyphicon glyphicon-upload"></i></a></li><li><a href="#"><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
					  </div>	
				    </div>
				  </form>
			  </div>

		  </div>
		  </div>
		</div>
		<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog">
		  <div class="modal-content">
			  <div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					Add post
			  </div>
			  <div class="modal-body">
				  <form class="form center-block" method="post" action="engine.php?act=posttext&id=<?php echo $id; ?>">
					<div class="form-group">
					  <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?" name="value"></textarea>
					</div>
					<div class="modal-footer">
					  <div>
					  <input type="submit" class="btn btn-primary btn-sm" value="Post"></input>
						<ul class="pull-left list-inline"><li><a href="#"><i class="glyphicon glyphicon-upload"></i></a></li><li><a href="#"><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
					  </div>	
				    </div>
				  </form>
			  </div>

		  </div>
		  </div>
		</div>
		<div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog">
		  <div class="modal-content">
			  <div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					Edit Profile
			  </div>
			  <div class="modal-body" style="padding: 10px 0px 15px 35px;">
				<form class="form" action="engine.php?act=edit&id=<?php echo $id ?>" method="POST">
				<?php
					$query=$connection->query("SELECT * FROM snuser_profile WHERE user_id = \"$id\"");
					if($row=$query->fetch_object()){
						$query_us=$connection->query("SELECT * FROM snusers WHERE id =\"$id\"");
						if($row_us=$query_us->fetch_object()){
				?>
	                  <div class="form-group" style="width: 500px">
	                    <label for="usr">Name:</label>
	                    <input required type="text" class="form-control" name="name" value="<?php echo $row->name?>" />
	                  </div>
	                  <div class="form-group" style="width: 500px">
	                    <label for="usr">Surname:</label>
	                    <input required type="text" class="form-control" name="surname" value="<?php echo $row->surname?>"/>
	                  </div>
	                  <div class="form-group" style="width: 500px">
	                    <label for="usr">Login:</label>
	                    <input required type="text" class="form-control" id="usr" name="login" value="<?php echo $row_us->login?>"/>
	                  </div>
	                  <div class="form-group" style="width: 500px">
	                    <label for="pwd">Password:</label>
	                    <input type="password" class="form-control" id="pwd" name="password"/>
	                  </div>
	                  <div class="form-group" style="width: 500px">
	                    <label for="usr">Email:</label>
	                    <input required type="email" class="form-control" name="email" value="<?php echo $row_us->email?>"/>
	                  </div>
	                  <div class="form-group" style="width: 500px">
	                    <label for="usr">Age:</label>
	                    <select required name="age" class="form-control input-lg">
	                      <?php for($i=0;$i<150;$i++){
	                      	if($row->age!=$i){
	                        	echo '<option value="'.$i.'">'.$i.'</option>';
	                        }else{
	                        	echo '<option selected value="'.$i.'">'.$i.'</option>';
	                        }
	                      }?>
	                    </select>
	                  </div>
	                  <div class="form-group" style="width: 500px">
	                    <label for="usr">Gender:</label>
	                    <select required name="gender" class="form-control input-lg" size="1">
	                    <?php if($row->gender==1){?>
	                      <option selected value="1">Male</option>
	                      <option value="2">Female</option>
	                    <?php }else{ ?>
	                      <option value="1">Male</option>
	                      <option selected value="2">Female</option>
	                    <?php } ?>
	                    </select>
	                  </div>
	                  <div class="form-group" style="width: 500px">
	                    <label for="usr">Date:</label>
	                    <input required type="date" max="2016-08-13" min="1940-01-01" class="form-control" name="date" value="<?php echo $row->birth_date?>" />
	                  </div>
	                  <input type="submit" style="margin-left: 225px;" value="edit" class="btn btn-success"/>
	                  <?php
	                  		}
	                  	}
	                  ?>
	            </form>
			  </div>

		  </div>
		  </div>
		</div>
		<div id="avatarChange" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog">
		  <div class="modal-content">
			  <div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					Change avatar
			  </div>
			  <div class="modal-body" style="padding: 10px 10px 0px 15px">
				  <form class="form center-block" action="engine.php?act=editavatar&id=<?php echo $id; ?>" method="post" enctype = "multipart/form-data">
						<input type="file" name="picture_upload" value="Choose image" class="btn btn-info"/>
						<input style="margin-left: 475px; margin-top:-55px" type="submit" value="Update" class="btn btn-success"/>
				  </form>
			  </div>

		  </div>
		  </div>
		</div>
        
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
			$('[data-toggle=offcanvas]').click(function() {
				$(this).toggleClass('visible-xs text-center');
				$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
				$('.row-offcanvas').toggleClass('active');
				$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
				$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
				$('#btnShow').toggle();
			});
        });
        </script>
</body></html>