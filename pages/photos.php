<div class="row">
	<div class="full col-sm-9" style="">
		<?php
	    	$query=$connection->query("SELECT * FROM snuser_pictures WHERE user_id=\"$id\" ORDER BY post_date DESC ");
	    	while($row=$query->fetch_object()){
	            if($row->active && $row->url!="simple.png"){
	        		$query_user=$connection->query("SELECT * FROM snuser_profile WHERE user_id = $row->user_id");
	        		if($row_user=$query_user->fetch_object()){
	        			echo '<div style="" class="col-md-9"><label for="usr">posted by <a href="#">'.$row_user->name.'</a></label>';
	                    echo '<a style="" class="pull-right" href="engine.php?act=deletephoto&id='.$row->id.'">delete</a><br>';
	        			echo '<img alt="Image not found." style="" class="img-thumbnail"  src="assets/img/'.$row->url.'"></img><br></div><div class="clearfix"></div><hr>';
	                }
	        	}
	        }
		?>
	</div>
</div>
