<div class="full col-sm-9">
<script>
	function like(id, div_id){

	$.post("?ajax_act=like",
	{pid:id},
	function(data){
	$("#"+div_id).html(data);
	});

	}
</script>
<?php
if(isset($_GET['ajax_act'])){
	if($_GET['ajax_act']=='like'){

		if(isset($_POST['pid'])&&is_numeric($_POST['pid'])){

			$user_id = $_SESSION['user']['id'];

			$post_id = $_POST['pid'];

			$query = $connection->query(" SELECT * FROM likes WHERE post_id = $post_id AND user_id = $user_id ");

			if($row = $query->fetch_object()){

			}else{

				$connection->query("INSERT INTO likes VALUES (NULL, $user_id, $post_id) ");

				$query = $connection->query(" SELECT COUNT(*) likes_amnt FROM likes WHERE post_id = $post_id LIMIT 1 ");

				if($row=$query->fetch_object()){

				$size = $row->likes_amnt;

				$connection->query("UPDATE walls SET like_value = $size WHERE id = $post_id");

				}

			}
		}
	}
}

	$asd=$_SESSION['id'];
	$id=$_GET['id'];
	$query=$connection->query("SELECT * FROM snuser_profile WHERE user_id = \"$id\"");
	if($row=$query->fetch_object()){
		$idctry=$row->country_id;
		$idcty=$row->city_id;
		$query_ctry=$connection->query("SELECT * FROM sncountries WHERE id = \"$idctry\"");
		if($row_ctry=$query_ctry->fetch_object()){
			$query_cty=$connection->query("SELECT * FROM sncities WHERE id = \"$idcty\"");
			if($row_cty=$query_cty->fetch_object()){
?>
	<!-- content -->
	<div class="row">

	 <!-- main col left -->
	 <div class="col-sm-5">

		  <div class="panel panel-default">
			<div class="panel-thumbnail"><img src='assets/img/<?php echo $row->avatar_url; ?>' class="img-responsive">
			<?php if($row->user_id==$asd){ ?>
				<a href="#avatarChange" role="button" data-toggle="modal" class="list-group-item" style="text-align: center;">Change avatar</a>
			<?php }else{
					$query_friend=$connection->query("SELECT * FROM snfriend_requests WHERE user_id=\"$asd\" AND friend_id=\"$id\"");
					if($row_friend=$query_friend->fetch_object()){ ?>
						<p class="list-group-item" style="text-align: center;">Request sended</p>
				<?php }else{?>
						<a href="engine.php?act=request&idu=<?php echo $asd; ?>&id=<?php echo $id; ?>" role=button data-toggle="modal" class="list-group-item" style="text-align: center;">Add to friends</a>
			<?php } ?>
				<a href="#sendmsg" role=button data-toggle="modal" class="list-group-item" style="text-align: center;">Send message</a>
			<?php }?></div>
			<div class="panel-body">
			  <p class="lead"><?php echo $row->name.' '.$row->surname; ?></p>
			  <?php $query_status=$connection->query("SELECT * FROM snuser_status WHERE user_id=\"$id\"");
			  		if($row_status=$query_status->fetch_object()){ echo '<hr><p>'.$row_status->value.'</p><hr>';}?>
			  <p>45 Followers, 13 Posts</p>
			  <p>
				<img src="assets/img/uFp_tsTJboUY7kue5XAsGAs28.png" height="28px" width="28px">
			  </p>
			</div>
		  </div>


		  <div class="panel panel-default">
			<div class="panel-heading"><?php if($row->user_id==$asd){ ?><a href="#edit" role="button" data-toggle="modal" class="pull-right">edit</a><?php } ?><h4>Personal Information</h4></div>
			  <div class="panel-body">
				<div class="list-group">
				  <a href="#" class="list-group-item">Birth date: <?php echo $row->birth_date?></a>
				  <a href="#" class="list-group-item">Age: <?php echo $row->age?></a>
				  <a href="#" class="list-group-item">Gender: <?php if($row->gender==1){echo 'Male';}else{echo 'Female';}?></a>
				  <a href="#" class="list-group-item">Country: <?php echo $row_ctry->name ?></a>
				  <a href="#" class="list-group-item">City: <?php echo $row_cty->name ?></a>
				</div>
			  </div>
		  </div>
	   	<?php if($row->user_id==$asd){ ?>
		  <div class="well">
			   <form class="form-horizontal" action="engine.php?act=addstatus&id=<?php echo $id;?>" method="post">
				<h4>What's New</h4>
				 <div class="form-group" style="padding:14px;">
				  <textarea name="textfld" class="form-control" placeholder="Update your status"></textarea>
				</div>
				<input class="btn btn-primary pull-right" type="submit">Post</input><ul class="list-inline"><li><a href="#"><i class="glyphicon glyphicon-upload"></i></a></li><li><a href="#"><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
			  </form>
		  </div>
		<?php } ?>

	  </div>

	  <!-- main col right -->
	  <div class="col-sm-7">

		<?php
			$query_post=$connection->query("SELECT * FROM snwalls WHERE user_id=\"$id\" ORDER BY post_date DESC");
			while($row_post=$query_post->fetch_object()){
				if($row_post->active){
		?>

		   <div class="panel panel-default">
			 <div class="panel-heading"><?php if($row->user_id==$asd){ ?><a href="engine.php?act=deletepost&id=<?php echo $row_post->id?>" class="pull-right">delete</a> <?php } ?> <h4><?php echo $row->name.' '.$row->surname?></h4></div>
			  <div class="panel-body">
				<img src='assets/img/<?php echo $row->avatar_url; ?>' class="img-circle pull-right"><p><?php echo $row_post->post_date?></p>
				<div class="clearfix"></div>
				<hr>
				<p><?php echo $row_post->text?></p>
				<hr>
				<form method="post" action="engine.php?act=addcomment&idpost=<?php echo $row_post->id;?>&id=<?php echo $asd;?>">
				<div class="input-group">
				  <div class="input-group-btn">
				  	<?php
				  	$query2=$connection->query("SELECT * FROM snlikes WHERE post_id=$row_post->id");
				  	if($row2=$query2->fetch_object()){
				  	?>
				  <button style="float:left; margin-right:10px; margin-top:-8px;" type="button" onclick="like(<?php echo $id; ?>,'like_<?php echo $row->id; ?>')" class="btn btn-primary btn-lg btn3d">
					<span class="glyphicon glyphicon-thumbs-up"></span> +
					<span id="like_<?php echo $row->id; ?>" ><?php echo $row2->like_value;?></span>
				  </button>
				  	<?php
				  	}else{
				  	?>
				  <button style="float:left; margin-top:-8px; margin-right:10px;" type="button" onclick="like(<?php echo $id; ?>,'like_<?php echo $row->id; ?>')" class="btn btn-primary btn-lg btn3d">
					<span class="glyphicon glyphicon-thumbs-up"></span>
					<span id="like_<?php echo $row->id; ?>" >0</span>
				  </button>
				  <?php
				  	}
				  	?>
				  <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-share"></i></button>
				  </div>
				  <input style="margin-left: 28px; width: 720px" name="comment" class="form-control" placeholder="Add a comment.." type="text">
				</div>
				</form>
				<?php
				$id_post=$row_post->id;
				$query_com=$connection->query("SELECT * FROM snwall_comments WHERE wall_id=\"$id_post\" ORDER BY post_date DESC");
				while($row_com=$query_com->fetch_object()){
						if($row_com->active){
							$id_user_com=$row_com->user_id;
							$query_user_com=$connection->query("SELECT * FROM snuser_profile WHERE user_id=\"$id_user_com\"");
							?>
							<?php if($asd==$row_com->user_id){ ?><a href="engine.php?act=deletecom&id=<?php echo $row_com->id?>&from=profile" style="margin-top: 25px" class="pull-right">delete</a><?php }?>
							<?php
							if($row_user_com=$query_user_com->fetch_object()){
								echo '<div class=""><img  class="img-circle " style="float:left" src="assets/img/'.$row_user_com->avatar_url.'"></div>';
								echo '<div style="margin:25px 0 5px 5px"><b>'.$row_user_com->name.' '.$row_user_com->surname.'</b></div>';
								echo '<div>'.$row_com->text.'</div>';
							}
							echo '<div class="clearfix"></div><hr>';
					}
				}
				?>
			  </div>
		   </div>
		<?php

				}
			}
		?>

	  </div>

   </div><!--/row-->

	<div class="row">
	  <div class="col-sm-6">
		<a href="#">Twitter</a> <small class="text-muted">|</small> <a href="#">Facebook</a> <small class="text-muted">|</small> <a href="#">Google+</a>
	  </div>
	</div>

	<div class="row" id="footer">
	  <div class="col-sm-6">

	  </div>
	  <div class="col-sm-6">
		<p>
		<a href="#" class="pull-right">©Copyright 2016</a>
		</p>
	  </div>
	</div>

  <hr>

  <h4 class="text-center">
  <a href="http://bitlab.kz" target="ext">Developed by Bitlab</a>
  </h4>

  <hr>
<?php
		}
	}
}
?>

</div><!-- /col-9 -->
