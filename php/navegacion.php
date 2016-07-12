		 <nav>
	    	<div class="nav-wrapper  <?=$c_Header?>">
	      		<a href="#" class="brand-logo center <?=$c_Header?>"><?=$titulo ?></a>
	      		<?php if($sesion->estadoLogin()):?>
						<a class="right waves-effect waves-light" href="php/logout.php" style="margin-right:10px;"><i class="material-icons">close</i></a>
	      		<?php endif;?>
	    	</div>
	  	</nav>