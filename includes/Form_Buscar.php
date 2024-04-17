<form method="post" action="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo $pagina;?>">
	<?php // echo isset( $_POST['nomebusca'] ) ? $_POST['nomebusca'] : NULL; ?>
	
    <?php if( isset($matricula) & @$matricula != NULL): ?>
		<input class="form-control" hidden type="hidden" value="<?php echo @$matricula; ?>" name="matricula">
	<?php endif;?>
	
    <div class="form-group label-floating">
        <label class="control-label">Buscar</label>
        <input class="form-control" type="text" name="nomebusca">
        <button href="#!" class="btn btn-info btn-raised btn-sm" name="btn">Procurar!</button>
    </div>
</form>