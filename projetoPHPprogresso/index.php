<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style2.css"> <!-- style2.css contém Transparência, para remover troque para style.css -->
		<title>Página de acompanhamento de projetos</title>
	</head>

	<body>
		<h1><center>Projetos ativos</center></h1>
		<?php
			// Variaveis comuns -- Não modificar
			$arrayObjetoAtual = array ();
			$dataHoje = date("Y-m-d");
			$datacorretahoje = strtotime($dataHoje);
			$ProjectCounter = 0;


			//SUBSTITUIR FUTURAMENTE -- Linkar a database para um bom funcionamento (Modificar a vontade)
			$ArrayProjetos = array ("1", "2", "3", "4");
			$idP = array(1, 2, 3, 4);
			$nomeProjeto = array("Projeto A", "Projeto B", "Projeto C", "Projeto D");
			$valueProgress = array(70, 80, 100, 60);
			$startprojetodate = array ("2019-07-30", "2019-06-13", "2019-07-27", "2019-06-20");
			$endprojetodate = array ("2019-09-30", "2019-07-5", "2019-11-30", "2019-09-6");

			// Função da barra de progresso
			function bargenerate() {
				global $arrayObjetoAtual, $datacorretahoje, $nomeProjeto;
				$max = 100;
				$scale = 8.0;
				$projectTitle = $arrayObjetoAtual['nome'];


				// Bloco da definição de tempo -- Não modificar
				$percent = ($arrayObjetoAtual['progresso'] * 100) / $max;
				$endDateConverted = strtotime($arrayObjetoAtual['final']);
				$startDateConverted = strtotime($arrayObjetoAtual['inicio']);
				$timedifftotal = ($endDateConverted - $startDateConverted);
				$numberDaystotal = $timedifftotal/86400;
				$timedifftoday = ($endDateConverted - $datacorretahoje);
				$timeremaining = $timedifftoday/86400;
				$numberDayscurrent = $numberDaystotal - $timeremaining;
				$timeleft = ($numberDayscurrent*100)/$numberDaystotal; 

				// Bloco da definição de proporções  -- Não modificar
				$divwidth = round(100 * $scale);
				$divstringbase = strval($divwidth);
				$divstringbase .= "px";
				$divbwidth = round($percent * $scale);
				$divstringprogresso = strval($divbwidth);
				$divstringprogresso .= "px";
				$divcwidth = round($timeleft * $scale);
				if ($divcwidth > 800){$divcwidth = 800;}
				$divstringtempo = strval($divcwidth);
				$divstringtempo .= "px";

				//Output final -- Cautela ao modificar
				$htmldivresult = "<div class='bigbox'><br><b>$projectTitle</b> <br><div class='percentbar' style='width:$divstringbase'>";
				$htmldivresult2 = "<div class='progressbar' style='width:$divstringprogresso'>";
				$htmldivresult3 = "<div class='timebar' style='width:$divstringtempo'> </div> </div></div><br>";
				echo "$htmldivresult $htmldivresult2 $htmldivresult3";
				echo "Progresso atual: $percent","% <br>";
				$timeremaining = round($timeremaining);
				if ($divcwidth > $divbwidth && $divcwidth == 800) {
					$timeremaining = abs($timeremaining);
					echo "Em atraso por: $timeremaining"," dias<br><br></div><br>";
				}
				if ($divcwidth > $divbwidth && $divcwidth < 800) {
					$timeremaining = abs($timeremaining);
					echo "Um pouco fora do tempo esperado."," Tempo restante: $timeremaining"," dias<br><br></div><br>";
				}
				if ($divcwidth <= $divbwidth && $divbwidth < 800) {
				 	echo "Tempo restante: $timeremaining"," dias<br><br></div><br>";
				}

				if ($divcwidth <= $divbwidth && $divbwidth == 800) {
				 	echo "Completado com antecedencia: $timeremaining"," dias antes!<br><br></div><br>";
				}
			}



			//criação do loop -- Não modificar
			foreach ($ArrayProjetos as $value) {
				$arrayObjetoAtual['id'] = $idP[$ProjectCounter];
				$arrayObjetoAtual['nome'] = $nomeProjeto[$ProjectCounter];
				$arrayObjetoAtual['progresso'] = $valueProgress[$ProjectCounter];
				$arrayObjetoAtual['inicio'] = $startprojetodate[$ProjectCounter];
				$arrayObjetoAtual['final'] = $endprojetodate[$ProjectCounter];
				bargenerate();
				$ProjectCounter++;
			}
		?>
	</body>
</html>