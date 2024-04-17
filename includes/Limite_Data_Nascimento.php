<?php
	date_default_timezone_set('Africa/Luanda');

	$Formato = 'Y-m-d';

	// tempo actual
	$Data_Actual = date($Formato);

	// tempo máximo permitido
	$Futuro_Dia = 0;
	$Futuro_Mes = 0;
	$Futuro_Ano = 18;

	$Data_Max = date( $Formato , strtotime(" -$Futuro_Dia days - $Futuro_Mes months -$Futuro_Ano years ") );

	// tempo mínimo permitido
	$Passado_Dia = 0;
	$Passado_Mes = 0;
	$Passado_Ano = 32;

	$Data_Min = date( $Formato , strtotime(" -$Passado_Dia days - $Passado_Mes months -$Passado_Ano years ") );
?>
