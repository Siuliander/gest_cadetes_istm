<?php 

    function add_perfil( $id_pessoa , $arquivo)
	{
		// extensões permitidas
		// ...

		if( @$arquivo['name'] != ''):
			$directorio = "../assets/perfil/".base64_encode($id_pessoa).'/';
			if( !is_dir($directorio)):
				mkdir($directorio);
			endif;

			move_uploaded_file( @$arquivo['tmp_name'] , $directorio . md5(random_int(1111,time())) .'.jpg' );
		endif;
	}

?>