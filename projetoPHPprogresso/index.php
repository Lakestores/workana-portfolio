<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style4.css"> 
		<title>Página de acompanhamento de projetos</title>
		
	</head>

	<body>
		<div class='header'>
			<h1><center>Projetos ativos</center></h1>
		</div>
		<div class='pageitself'>
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
				$equipes = array ("Sol", "Lua", "Vulcano", "Lua");
				$equipespontos = array ("Sol"=>0, "Lua"=>0, "Vulcano"=>0,);
				$dificuldade = array (1, 2, 3, 4);
				$valueProgress = array(70, 80, 100, 100);
				$finishedBool = array (0, 0, 0, 0);
				$startprojetodate = array ("2019-07-30", "2019-06-13", "2019-07-27", "2019-06-20");
				$endprojetodate = array ("2019-09-30", "2019-07-5", "2019-11-30", "2019-09-6");
				$finisheddate = array (0, 0, 0, 0);
				$timeleftcompletedarray = array (0, 0, 0, 0);
				$faseatualprojeto = array (1, 3, 5, 8);
				$fasefinalprojeto = array (3, 7, 5, 12);
				$spaces = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";



				// Função da barra de progresso
				function bargenerate() {
					global $arrayObjetoAtual, $datacorretahoje, $nomeProjeto, $dataHoje, $ProjectCounter, $spaces;
					$max = 100;
					$scale = 8.0;  // não modificar ou vai quebrar tudo
					$projectTitle = $arrayObjetoAtual['nome'];
					$projectphase = $arrayObjetoAtual['faseprojeto'];
					$projectlastphase = $arrayObjetoAtual['fasefinalprojeto'];
					$link = strval($arrayObjetoAtual['id']);
					$path = "http://www.google.com/";
					$path .= $link;
					$HrefLink = "<a href='$path'>Clique aqui </a>(Id:$link)";

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
					if ($arrayObjetoAtual['completo'] == 0) {

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
					}
					else {

						$divwidth = round(100 * $scale);
						$divstringbase = strval($divwidth);
						$divstringbase .= "px";
						$divbwidth = round(100 * $scale);
						$divstringprogresso = strval($divbwidth);
						$divstringprogresso .= "px";
						$divcwidth = round($arrayObjetoAtual['timewhencompleted'] * $scale);
						if ($divcwidth > 800){$divcwidth = 800;}
						$divstringtempo = strval($divcwidth);
						$divstringtempo .= "px";
					}

					// Define o projeto como completo se for completo nesta verificação somente após as funções rodarem para prevenir erros
					if ($divbwidth > 799) {
						if ($arrayObjetoAtual['completo'] == 0) {
							$arrayObjetoAtual['datafinalizada'] = $dataHoje;
							$arrayObjetoAtual['timewhencompleted'] = $timeleft;
						}
						$arrayObjetoAtual['completo'] = 1;	
					}
					if ($divcwidth > 799) {
						if ($arrayObjetoAtual['completo'] == 0) {
							$arrayObjetoAtual['datafinalizada'] = $dataHoje;
							$arrayObjetoAtual['timewhencompleted'] = $timeleft;
						}
						$arrayObjetoAtual['completo'] = 1;	
					}

					//Output final -- Cautela ao modificar
					$htmldivresult = "<br><br><br><div class='bigbox'><br><b>$projectTitle</b> <br><div class='percentbar' style='width:$divstringbase'>";
					$htmldivresult2 = "<div class='progressbar' style='width:$divstringprogresso'>";
					$htmldivresult3 = "<div class='timebar' style='width:$divstringtempo'> </div> </div></div><br>";
					echo "$htmldivresult $htmldivresult2 $htmldivresult3";
					echo "Progresso atual: $percent","%";
					echo "$spaces Fase do projeto: $projectphase","/","$projectlastphase<br>";	
					
					$timeremaining = round($timeremaining);
					if ($divcwidth > $divbwidth && $divcwidth == 800) {
						$timeremaining = abs($timeremaining);
						$arrayObjetoAtual['atrasado'] = 1;
						
						echo "Em atraso por: $timeremaining"," dias <br> Link do projeto: $HrefLink <br><br></div>";
					}
					if ($divcwidth > $divbwidth && $divcwidth < 800) {
						$timeremaining = abs($timeremaining);
						echo "Um pouco fora do tempo esperado."," Tempo restante: $timeremaining"," dias <br> Link do projeto: $HrefLink <br><br></div>";
					}
					if ($divcwidth <= $divbwidth && $divbwidth < 800) {
					 	echo "Tempo restante: $timeremaining"," dias <br> Link do projeto: $HrefLink <br><br></div>";
					}

					if ($divcwidth <= $divbwidth && $divbwidth == 800) {
						$arrayObjetoAtual['antecedencia'] = 1;
						
					 	echo "Completado com antecedencia: $timeremaining"," dias antes! <br> Link do projeto: $HrefLink <br><br></div>";
					}
				}



				//criação do loop -- Não modificar
				foreach ($ArrayProjetos as $value) {
					$arrayObjetoAtual['id'] = $idP[$ProjectCounter];
					$arrayObjetoAtual['nome'] = $nomeProjeto[$ProjectCounter];
					$arrayObjetoAtual['progresso'] = $valueProgress[$ProjectCounter];
					$arrayObjetoAtual['inicio'] = $startprojetodate[$ProjectCounter];
					$arrayObjetoAtual['final'] = $endprojetodate[$ProjectCounter];
					$arrayObjetoAtual['completo'] = $finishedBool[$ProjectCounter];
					$arrayObjetoAtual['datafinalizada'] = $finisheddate[$ProjectCounter];
					$arrayObjetoAtual['timewhencompleted'] = $timeleftcompletedarray[$ProjectCounter];
					$arrayObjetoAtual['atrasado'] = 0;
					$arrayObjetoAtual['antecedencia'] = 0;
					$arrayObjetoAtual['faseprojeto'] = $faseatualprojeto[$ProjectCounter];
					$arrayObjetoAtual['fasefinalprojeto'] = $fasefinalprojeto[$ProjectCounter];
					bargenerate();
					// Recompensa de pontos e atualização de dados em caso de alterações
					if ($arrayObjetoAtual['datafinalizada'] != $finisheddate[$ProjectCounter]) {
						$finisheddate[$ProjectCounter] = $arrayObjetoAtual['datafinalizada'];
						$timeleftcompletedarray[$ProjectCounter] = $arrayObjetoAtual['timewhencompleted'];
						$team = strval($equipes[$ProjectCounter]);
						if ($arrayObjetoAtual['atrasado'] == 1) {
							$math2 = -40/intval($dificuldade[$ProjectCounter]);
							$result = strval($math2);
							$equipespontos[$team] = intval($equipespontos[$team])+intval($math2);

							echo "<div class='bigbox'>",$result," Pontos adicionados a equipe: ",$equipes[$ProjectCounter],"</div>"	;
						}
						elseif ($arrayObjetoAtual['antecedencia'] == 1) {
							$math2 = 10*intval($dificuldade[$ProjectCounter]);
							$result = strval($math2);
							$equipespontos[$team] = intval($equipespontos[$team])+intval($math2);
							echo "<div class='bigbox'>",$result," Pontos adicionados a equipe: ",$equipes[$ProjectCounter],"</div>";
						}
					}

					$ProjectCounter++;
				}
				echo "<div class=boxAfterLoad><center><h2>Classificação das equipes:</h2></center>";
				echo "Equipe Lua: ",$equipespontos["Lua"];
				echo "<br>Equipe Sol: ",$equipespontos["Sol"];
				echo "<br>Equipe Vulcano: ",$equipespontos["Vulcano"];
				echo "</div><br><br>"
			?>
		<div>
	</body>
</html>