
<!-- SideBar -->
	<section class="full-box cover dashboard-sideBar">
		<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
		<div class="full-box dashboard-sideBar-ct">
			<!--SideBar Title -->
			<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
			<?php 
				if( isset($nivel_cookie) & (@$nivel_cookie == '1') ):
					if( $permissao_cookie == "1"):
						echo "Administrador" ;
					elseif( $permissao_cookie == "2"):
						echo "daac" ;
					elseif( $permissao_cookie == "3"):
						echo "saac" ;
					endif;
					
				elseif( isset($nivel_cookie) & (@$nivel_cookie == '2') ):
					echo "Professor" ;
				elseif( isset($nivel_cookie) & (@$nivel_cookie == '3') ):
					echo "Cadete" ;
				endif;
			?>
				
				<i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
			</div>
			<!-- SideBar User info -->
			<div class="full-box dashboard-sideBar-UserInfo">
				<figure class="full-box">
					<img class="img"  src="assets/perfil/user/<?php echo "user.png"  ?>">
					<figcaption class="text-center text-titles">
						<?php echo @$nome_cookie; ?>	</figcaption>
				</figure>
				<ul class="full-box list-unstyled text-center">
					
					<li>
						<a href="<?php echo '?btn='. CodificarTexto('deletelogin'); ?>">
							<i class="zmdi zmdi-power"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- SideBar Menu -->
			<ul class="list-unstyled full-box dashboard-sideBar-Menu">
				<li>
					<a href="?pg=<?php echo CodificarTexto('inicio');?>">
						<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Painel de Controle
					</a>
				</li>
				
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-case zmdi-hc-fw"></i>Administradores<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewadmins');?>"><i class="zmdi zmdi-timer zmdi-hc-fw"></i>Ver Lista</a>
							</li>
							<li>
								<a href="?pg=<?php echo CodificarTexto('formadmin');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Adicionar</a>
							</li>
							
						</ul>
					</li>
				<?php endif;?>

				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-case zmdi-hc-fw"></i>Docentes<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewdocentes');?>"><i class="zmdi zmdi-timer zmdi-hc-fw"></i>Ver Lista</a>
							</li>
							<li>
								<a href="?pg=<?php echo CodificarTexto('formdocente');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Adicionar</a>
							</li>						
						</ul>
					</li>
				<?php endif;?>
				
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2,3]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i>Cursos<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewcursos');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Ver Lista</a>
							</li>
							
							<?php if( isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
								<li>
									<a href="?pg=<?php echo CodificarTexto('formcurso');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Adicionar</a>
								</li>
							<?php endif;?>
						</ul>
					</li>
				<?php endif;?>
				
				
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i>Turmas<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewturmas');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Ver Lista</a>
							</li>
							<li>
								<a href="?pg=<?php echo CodificarTexto('formturma');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Adicionar</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>
				
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2,3]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i>Disciplinas<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewdisciplinas');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Ver Lista</a>
							</li>
							<li>
								<a href="?pg=<?php echo CodificarTexto('formdisciplina');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Adicionar</a>
							</li>
						</ul>
					</li>
				<?php endif;?>

				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2,3]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i>Disciplina / Ano<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewdisciplinasturmas');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Ver Lista</a>
							</li>
							<li>
								<a href="?pg=<?php echo CodificarTexto('formdisciplinaturma');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Adicionar</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>
				
				<?php if( !in_array(@$permissao_cookie , [1]) ):?>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-book zmdi-hc-fw"></i>Comunicados<i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="?pg=<?php echo CodificarTexto('viewcomunicados');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Ver Lista</a>
						</li>
						
						<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):?>
							<li>
								<a href="?pg=<?php echo CodificarTexto('formcomunicado');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Adicionar</a>
							</li>
						<?php endif;?>
					</ul>
				</li>
				<?php endif;?>
				
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2,3]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i>Cadetes<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
								<li>
									<a href="?pg=<?php echo CodificarTexto('formaluno');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Inscrição</a>
								</li>
							<?php endif; ?>
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewmatriculas');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Matriculados</a>
							</li>
						
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewalunos');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Ver Lista</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>
				
				<?php if( !in_array(@$permissao_cookie , [1]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i>Notas<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<li>
								<a href="?pg=<?php echo CodificarTexto('formnota');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Consultar</a>
							</li>
						</ul>
					</li>
				<?php endif;?>
				
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2]) ):?>
					<li>
						<a href="#!" class="btn-sideBar-SubMenu">
							<i class="zmdi zmdi-book zmdi-hc-fw"></i>Militares<i class="zmdi zmdi-caret-down pull-right"></i>
						</a>
						<ul class="list-unstyled full-box">
							<li>
								<a href="?pg=<?php echo CodificarTexto('formmilitar');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Adicionar</a>
							</li>
							
							<li>
								<a href="?pg=<?php echo CodificarTexto('viewmilitares');?>"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Ver Lista</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>
				
				<li>
					<a href="?pg=<?php echo CodificarTexto('formsenha');?>"><i class="zmdi zmdi-look zmdi-hc-fw"></i>Alterar Senha</a>
						
				</li>
				
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1]) ):?>
					<li>
						<a href="?pg=<?php echo CodificarTexto('formresetsenha');?>"><i class="zmdi zmdi-look zmdi-hc-fw"></i>Reset Senhas</a>
					</li>
				<?php endif; ?>
				
			</ul>
		</div>
	</section>
