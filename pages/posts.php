<div class="full col-sm-9">

	<!-- content -->
	<div class="row">
	  <!-- main col right -->
	  <div class="col-sm-12">

			<div class="well">
			   <form class="form">
				<h4>Search by author</h4>
				<div class="input-group text-center">
				<input class="form-control input-lg" placeholder="Enter name of the author" type="text">
				  <span class="input-group-btn"><button class="btn btn-lg btn-primary" type="button">OK</button></span>
				</div>
			  </form>
			</div>
		<?php
			$query_post=$connection->query("SELECT * FROM snwalls ORDER BY post_date DESC");
			while($row_post=$query_post->fetch_object()){
				if($row_post->active){
					$id_wall_author=$row_post->user_id;
					$query=$connection->query("SELECT * FROM snuser_profile WHERE user_id=\"$id_wall_author\"");
					if($row=$query->fetch_object()){
		?>

			<div class="panel panel-default">
			 <div class="panel-heading"><?php $id=$_SESSION['id']; if($id==$row_post->user_id){ ?><a href="engine.php?act=deletepost&id=<?php echo $row_post->id?>" class="pull-right">delete</a><?php }?> <a href='home.php?page=profile&id=<?php echo $row->user_id; ?>'><h4><?php echo $row->name.' '.$row->surname?></h4></a></div>
			  <div class="panel-body">
				<img src='assets/img/<?php echo $row->avatar_url; ?>' class="img-circle pull-right"><p><?php echo $row_post->post_date?></p>
				<div class="clearfix"></div>
				<hr>
				<p><?php echo $row_post->text?></p>
				<hr>
				<form method="post" action="engine.php?act=addcomment&idpost=<?php echo $row_post->id;?>&id=<?php echo $id;?>">
				<div class="input-group">
				  <div class="input-group-btn">
				  <button id="addComment" class="btn btn-default">+1</button><button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-share"></i></button>
				  </div>
				  <input name="comment" class="form-control" placeholder="Add a comment.." type="text">
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
						<?php $id=$_SESSION['id']; if($id==$row_post->user_id){ ?><a style="margin-top:15px" href="engine.php?act=deletecom&id=<?php echo $row_com->id?>&from=posts" class="pull-right">delete</a><?php }?>
						<?php
						if($row_user_com=$query_user_com->fetch_object()){
							echo '<div class=""><img  class="img-circle " style="float:left" src="assets/img/'.$row_user_com->avatar_url.'"></div>';
							echo '<div style="margin:25px 0 5px 5px"><b>'.$row_user_com->name.' '.$row_user_com->surname.'</b></div>';
							echo '<div>' .$row_com->text.'</div>';
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


</div><!-- /col-9 -->
