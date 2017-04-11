<div class="full col-sm-9">
	<div class="row">
	<?php
	$id=$_SESSION['id'];
		$query=$connection->query("SELECT * FROM snfriend_requests WHERE friend_id =\"$id\" ");
		$null=true;
		while($row=$query->fetch_object()){
			echo '<div class="panel panel-default">';
			if($null){
				echo '<div class="well"><h4>Friend requests</h4></div>';
				$null=false;
			}
			$id_from=$row->user_id;
			$query_from=$connection->query("SELECT * FROM snuser_profile WHERE user_id= \"$id_from\"");
			if($row_from=$query_from->fetch_object()){
	?>
			<div class="panel-heading">
				<?php echo $row_from->name.' '.$row_from->surname ?>
			</div>
			<div class="panel-body">
				<img src='assets/img/<?php echo $row_from->avatar_url; ?>' class="img-circle pull-right"><p><?php echo $row->sent_date?></p>
				<div class="clearfix"></div>
				<hr>
				I want to add you to my friend list.
				<a href="engine.php?act=accept&req=<?php echo $row->id; ?>&id=<?php echo $id?>&from=<?php echo $row->user_id?>" class="pull-right btn btn-success">Accept</a>
				<hr>
			</div>
		</div>
	<?php
			}
		}
	?>
		<div class="clearfix"></div>
		<div class="panel panel-default">
			<div class="well"><h4>Friends</h4></div>
	<?php
			$query=$connection->query("SELECT u.name, u.surname,u.avatar_url,u.user_id 
			FROM snuser_profile u,snfriends f 
			WHERE (f.user_id = u.user_id AND f.friend_id=$id ) OR (f.friend_id = u.user_id AND f.user_id=$id)");
			while($row=$query->fetch_object()){
				echo '<div class="panel panel-default"><div class="panel-heading">';
				echo '<img src="assets/img/'.$row->avatar_url.'" class="img-circle pull-right">';
				echo '<h4>'.$row->name.' '.$row->surname.'</h4></div>';
				echo '<br><div class="panel-heading">Write</div></div>';
			}
	?>
		</div>
	</div>
</div>