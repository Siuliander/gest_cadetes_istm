<?php
	
	function AddAtribuirNotas($Turma = NULL , $Conexao)
	{
		$query = "select * from tb_matricula as matricula
				join tb_turma_curso as turma_curso on turma_curso.id_turma_curso = matricula.id_turma_curso
				join tb_turma as turma on turma.id_turma = turma_curso.id_turma
                join tb_curso as curso on curso.id_curso = turma_curso.id_curso
				 WHERE estado_matricula = 2 AND turma_curso.id_turma_curso = :turma";
		$result = @$Conexao->prepare(@$query);
		$result -> bindParam(":turma", $Turma, PDO::PARAM_STR);
		$result->execute(); 
		
        if (@$result and (@$result->rowCount() > 0)):  
			
            while( $matriculado = $linha = $result->fetchobject() ):
			
				$query2 = "INSERT INTO tb_nota (id_matricula,id_disciplina_turma) 
						select :matricula , id_disciplina_turma from tb_disciplina_turma as disciplina_turma 
							join tb_turma as turma on turma.id_turma = disciplina_turma.id_turma
							WHERE turma.id_turma = :turma AND id_curso = :curso";
				$result = @$Conexao->prepare(@$query2);
				$result -> bindParam(":matricula", $matriculado->id_matricula, PDO::PARAM_STR);
				$result -> bindParam(":turma", $matriculado->id_turma, PDO::PARAM_STR);
				$result -> bindParam(":curso", $matriculado->id_curso, PDO::PARAM_STR);
				$result->execute(); 
				
			endwhile;
        endif;
	}
	

	
	
	function AddRestringirAtribuirNotas($Turma = NULL , $Conexao)
	{
		
		$query = "select * from tb_matricula as matricula
				join tb_turma_curso as turma_curso on turma_curso.id_turma_curso = matricula.id_turma_curso
				join tb_turma as turma on turma.id_turma = turma_curso.id_turma
				 WHERE estado_matricula = 2 AND turma_curso.id_turma_curso = :turma";
		$result = @$Conexao->prepare(@$query);
		$result -> bindParam(":turma", $Turma, PDO::PARAM_STR);
		$result->execute(); 
		
        if (@$result and (@$result->rowCount() > 0)):  
			
            while( $matriculado = $linha = $result->fetchobject() ):
			
				$query2 = "UPDATE tb_nota SET estado_nota = 1 WHERE id_matricula = :matricula";
				$result = @$Conexao->prepare(@$query2);
				$result -> bindParam(":matricula", $matriculado->id_matricula, PDO::PARAM_STR);
				$result->execute(); 
				
			endwhile;
        endif;
	}
	
?>