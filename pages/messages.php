<div class="full col-sm-9">
	<div class="row">
	<?php
		$id=$_SESSION['id'];
		$query=$connection->query("SELECT * FROM snfriends");
		while($row=$query->fetch_object()){
			$friendship=$row->id;
			$query_msg=$connection->query("SELECT * FROM snmessages WHERE friends=$friendship ORDER BY sent_date DESC");
			if($row_msg=$query_msg->fetch_object()){
				$ids=$row_msg->sender_id;
				$query_last=$connection->query("SELECT * FROM snuser_profile WHERE user_id=$ids");
				if($row_last=$query_last->fetch_object()){
					echo '<div class="panel panel-default"><div class="panel-heading">';
					echo '<img src="assets/img/'.$row_last->avatar_url.'" class="img-circle pull-right">';
					echo '<h4>'.$row_last->name.' '.$row_last->surname.'</h4><h5>'.$row_msg->sent_date.'</h5></div>';
					if($row_msg->readen){
						echo '<br><div class="panel-heading">'.$row_msg->text.'</div></div>';
					}else{
						echo '<br><div class="panel-heading" style="background-color: #9fa6b7">'.$row_msg->text.'</div></div>';
					}
					echo '<a class="pull-right" style="margin-top:-60px; margin-right: 15px" href="home.php?page=dialog&fr='.$row_msg->friends.'">view</a>';
				}
			}
		}
	?>
	</div>
</div>