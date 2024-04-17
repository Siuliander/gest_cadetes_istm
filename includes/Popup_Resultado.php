<?php if ($Insered ):  ?>
	<center>
		<div center class="alert alert-success alert-dismissible" style="width:30%;align-items:center;"role="alert">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			Sucesso
		</div>
	</center>
<?php elseif($Insered &  !empty($Insered)):  ?>
	<center>
		<div center class="alert alert-danger alert-dismissible" style="width:30%;align-items:center;"role="alert">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			Não Registrado
		</div>
	</center>
<?php  endif;?>