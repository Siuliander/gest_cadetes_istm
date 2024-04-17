<?php 
	
	$permissao_cookie = @$_SESSION['permissao'] ;
	$nivel_cookie = @$_SESSION['nivel'] ;
	$nome_cookie = @$_SESSION['nome'] ;
	
	switch( DecodificarTexto($pagina) ) : 
		
			case "viewbackups":
				require_once("./paginas/Views/View_Backups.php");
				break;

			case "inicio": case "":
				require_once("./paginas/Views/View_Estatistica.php");
				break;
					 
			case "view": case "":
				require_once("./paginas/View/verEstudante.php");
				break;


				
			case "formresetsenha":
				require_once("./paginas/Forms/Form_Reset_Senha.php");
				break;
				
					
			case "viewadmins":
				require_once("./paginas/Views/View_Admins.php");
				// echo Error_505();
				break;
				
			case "formadmin":
				require_once("./paginas/Forms/Form_Admin.php");
				// echo Error_505();
				break;
			  
			case "viewdocentes":
				require_once("./paginas/Views/View_Professor.php");
				break;
				
			case "formdocente":
				require_once("./paginas/Forms/Form_Professor.php");
				break;

			case "viewdisciplinas":
				require_once("./paginas/Views/View_Disciplinas.php");
				break;
					
			case "formdisciplina":
				require_once("./paginas/Forms/Form_Disciplina.php");
				break;

			case "viewcursos":
				require_once("./paginas/Views/View_Cursos.php");
				break;

			case "formcurso":
				require_once("./paginas/Forms/Form_Curso.php");
				break;
					
			case "formturma":
				require_once("./paginas/Forms/Form_Turma.php");
				break;

			case "viewturmas":
				require_once("./paginas/Views/View_Turmas.php");
				break;

			case "formcomunicado":
				require_once("./paginas/Forms/Form_Comunicado.php");
				break;

			case "viewcomunicados":
				require_once("./paginas/Views/View_Comunicados.php");
				break;
					  



			case "formaluno":
				require_once("./paginas/Forms/Form_Aluno.php");
				break;
				
			case "viewalunos":
				require_once("./paginas/Views/View_Alunos.php");
				break;
				
			case "formmatricula":
				require_once("./paginas/Forms/Form_Matricula.php");
				break;
				
			case "viewmatriculas":
				require_once("./paginas/Views/View_Matriculas.php");
				break;

			case "formdisciplinaturma":
				require_once("./paginas/Forms/Form_Disciplina_Turma.php");
				break;

			case "viewdisciplinasturmas":
				require_once("./paginas/Views/View_Disciplinas_Turma.php");
				break;

			case "formmilitar":
				require_once("./paginas/Forms/Form_Militar.php");
				break;

			case "viewmilitares":
				require_once("./paginas/Views/View_Militares.php");
				break;

			case "formnota":
				require_once("./paginas/Forms/Form_Nota.php");
				break;

			case "formeditenota":
				require_once("./paginas/Forms/Form_Edite_Nota.php");
				break;

			case "viewnotas":
				require_once("./paginas/Views/View_Notas.php");
				break;

			case "inicio": case "":
				require_once("./paginas/Views/View_Estatistica.php");
				break;
					 
			case "view": case "":
				require_once("./paginas/View/verEstudante.php");
				break;


			case "formcomunicado":
				require_once("./paginas/Forms/Form_Comunicado.php");
				break;

			case "viewcomunicados":
				require_once("./paginas/Views/View_Comunicados.php");
				break;
					
			case "formaluno":
				require_once("./paginas/Forms/Form_Aluno.php");
				break;
				
			case "viewalunos":
				require_once("./paginas/Views/View_Alunos.php");
				break;
				
			case "formmatricula":
				require_once("./paginas/Forms/Form_Matricula.php");
				break;
				
			case "viewmatriculas":
				require_once("./paginas/Views/View_Matriculas.php");
				break;

			case "formmilitar":
				require_once("./paginas/Forms/Form_Militar.php");
				break;

			case "viewmilitares":
				require_once("./paginas/Views/View_Militares.php");
				break;

			case "formnota":
				require_once("./paginas/Forms/Form_Nota.php");
				break;

			case "formeditenota":
				require_once("./paginas/Forms/Form_Edite_Nota.php");
				break;

			case "viewnotas":
				require_once("./paginas/Views/View_Notas.php");
				break;

			case "inicio": case "":
				require_once("./paginas/Views/View_Estatistica.php");
				break;
				
	
			case "formnota":
				require_once("./paginas/Forms/Form_Nota.php");
				break;

			case "formeditenota":
				require_once("./paginas/Forms/Form_Edite_Nota.php");
				break;

			case "viewnotas":
				require_once("./paginas/Views/View_Notas.php");
				break;

			
			case "inicio": case "":
				require_once("./paginas/Views/View_Estatistica.php");
				break;
					 
			case "view": case "":
				require_once("./paginas/View/verEstudante.php");
				break;

			case "formnota":
				require_once("./paginas/Forms/Form_Nota.php");
				break;

			case "viewnotas":
				require_once("./paginas/Views/View_Notas.php");
				break;

			case "inicio": case "":
				require_once("./paginas/Views/View_Estatistica.php");
				break;
					 
			case "view": case "":
				require_once("./paginas/View/verEstudante.php");
				break;
				
			case "viewAdmin": case "":
				require_once("./paginas/View/verAdmin.php");
				break;
				
			case "viewDocente": case "":
				require_once("./paginas/View/verDocente.php");
				break;
				
			case "viewMilitar": case "":
				require_once("./paginas/View/verMilitar.php");
				break;
					 
			case "viewMatricula": case "":
				require_once("./paginas/View/verMatricula.php");
				break;
					 
			case "viewComunicado": case "":
				require_once("./paginas/View/verComunicado.php");
				break;
			 
			case "formsenha": case "":
				require_once("./paginas/Forms/Form_Edite_Senha.php");
				break;
	
			case "formnota":
				require_once("./paginas/Forms/Form_Nota.php");
				break;

			case "formeditenota":
				require_once("./paginas/Forms/Form_Edite_Nota.php");
				break;

			case "viewnotas":
				require_once("./paginas/Views/View_Notas.php");
				break;
				
					
			case "formturma":
				require_once("./paginas/Forms/Form_Turma.php");
				break;

			case "viewturmas":
				require_once("./paginas/Views/View_Turmas.php");
				break;


			case "inicio": case "":
				require_once("./paginas/Views/View_Estatistica.php");
				break;
					 
			case "view": case "":
				require_once("./paginas/View/verEstudante.php");
				break;

			default:
				// echo Error_404();
				require_once("./paginas/Views/View_Estatistica.php");
				break;
		endswitch;
		
?>