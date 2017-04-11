<div class="full col-sm-9">
	<div class="row">
	<div class="panel panel-default">
	<?php
		$id=$_SESSION['id'];
		$fr=$_GET['fr'];
		$idto="";
		$connection->query("UPDATE snmessages SET readen = 1 WHERE friends = $fr");
		$query=$connection->query("SELECT * FROM snmessages WHERE friends=$fr");
		if($row=$query->fetch_object()){
			if($row->user_id==$id){
				$idto=$row->sender_id;
			}else{
				$idto=$row->user_id;
			}
		}
		$query=$connection->query("SELECT * FROM snfriends WHERE id=$fr");
		if($row=$query->fetch_object()){
			$friendship=$row->id;
			$query_msg=$connection->query("SELECT * FROM snmessages WHERE friends=$friendship ORDER BY sent_date");
			while($row_msg=$query_msg->fetch_object()){
				$ids=$row_msg->sender_id;
				$query_last=$connection->query("SELECT * FROM snuser_profile WHERE user_id=$ids");
				if($row_last=$query_last->fetch_object()){
					echo '<div class="panel-heading">';
					echo '<img src="assets/img/'.$row_last->avatar_url.'" class="img-circle pull-right">';
					echo '<h4>'.$row_last->name.' '.$row_last->surname.'</h4><h5>'.$row_msg->sent_date.'</h5></div>';
					if($row_msg->readen){
						echo '<br><div class="panel-heading">'.$row_msg->text.'</div>';
					}else{
						echo '<br><div class="panel-heading" style="background-color: #9fa6b7">'.$row_msg->text.'</div>';
					}
				}
			}
		}
		?>
		</div>
		<form method="post" action="engine.php?act=sendmsg">
		<div class="input-group">
		  <div class="input-group-btn">
		  <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-share"></i></button>
		  </div>
		  <input name="value" class="form-control" placeholder="Send message.." type="text">
		  <input type="hidden" name="idto" value="<?php echo $idto; ?>">
		  <input type="hidden" name="page" value="dialog"></input>
		</div>
		</form>
	</div>
</div>