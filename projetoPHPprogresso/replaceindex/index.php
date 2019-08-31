<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style7.css"> 
		<title>Página de acompanhamento de projetos</title>
		
	</head>

	<body>
		<div class='header'>
			<h1><center>Projetos ativos</center></h1>
		</div>
		<div class='pageitself'>
			<br>
			<div id="chart_div"><center></center></div>
			<?php
				// Variaveis comuns -- Não modificar
				$arrayObjetoAtual = array ();
				$dataHoje = date("Y-m-d");
				$datacorretahoje = strtotime($dataHoje);
				$ProjectCounter = 0;
				$ArrayProjetos = array ();
				$idP = array();
				$nomeProjeto = array();
				$equipes = array ();
				$equipespontos = array ("Sol"=>0, "Lua"=>0, "Vulcano"=>0,); //Modificar nomes disso aqui manualmente
				$dificuldade = array ();
				$valueProgress = array();
				$finishedBool = array ();
				$startprojetodate = array ();
				$endprojetodate = array ();
				$finisheddate = array ();
				$timeleftcompletedarray = array ();
				$faseatualprojeto = array ();
				$fasefinalprojeto = array ();
				$spaces = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";


				//SUBSTITUIR FUTURAMENTE -- Linkar a database para um bom funcionamento (Modificar a vontade)
				/*

				foreach ($proj as $value) {
					$dbID = 0;
					ArrayProjetos.push( $SuaDatabaseDeIDs[$dbID]);
					idP.push( $SuaDatabaseDeIDs[$dbID]);
					nomeProjeto.push( $SuaDatabaseNomes[$dbID]);
					equipes.push( $SuaDatabaseDeEqpss[$dbID]);
					dificuldade.push( $SuaDatabaseDedificuldades[$dbID]);
					valueProgress.push( $SuaDatabaseDeIDs[$dbID]);
					finishedBool.push( $SuaDatabaseDeIDs[$dbID]);
					startprojetodate.push( $SuaDatabaseDeIDs[$dbID]);
					endprojetodate.push( $SuaDatabaseDeIDs[$dbID]);
					finisheddate.push( $SuaDatabaseDeIDs[$dbID]);
					timeleftcompletedarray.push( $SuaDatabaseDeIDs[$dbID]);
					faseatualprojeto.push( $SuaDatabaseDeIDs[$dbID]);
					fasefinalprojeto.push( $SuaDatabaseDeIDs[$dbID]);
					$dbID++
				}





				*/

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
					if ($numberDaystotal == 0){
						$numberDaystotal = 1;
					}
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
					elseif ($divcwidth > 799) {
						if ($arrayObjetoAtual['completo'] == 0) {
							$arrayObjetoAtual['datafinalizada'] = $dataHoje;
							$arrayObjetoAtual['timewhencompleted'] = $timeleft;
						}
						$arrayObjetoAtual['completo'] = 1;	
					}
					if ($startDateConverted > $datacorretahoje){
						$percent = ($arrayObjetoAtual['progresso'] * 100) / $max;
						$divstringtempo = "0px";
					}

					//Output final -- Cautela ao modificar
					$datainicioprint = $arrayObjetoAtual['inicio'];
					$datafimprint = $arrayObjetoAtual['final'];
					$htmldivresult = "<br><br><br><div class='bigbox'><br><b>$projectTitle</b> <br><div class='percentbar' style='width:$divstringbase'>";
					$htmldivresult2 = "<div class='progressbar' style='width:$divstringprogresso'>";
					$htmldivresult3 = "<div class='timebar' style='width:$divstringtempo'> </div> </div></div><br>";
					echo "$htmldivresult $htmldivresult2 $htmldivresult3";
					echo "Progresso atual: $percent","%";
					echo "<br><br>Iniciado em: $datainicioprint";
					echo "<br>Finalizado em: $datafimprint";
					echo "$spaces Fase do projeto: $projectphase","/","$projectlastphase<br>";	
					$arrayObjetoAtual['timeremaining'] = $timeremaining;

					$timeremaining = round($timeremaining);
					if ($divcwidth > $divbwidth && $divcwidth == 800) {
						$timeremaining = abs($timeremaining);
						$arrayObjetoAtual['atrasado'] = 1;

						echo "Em atraso por: $timeremaining"," dias <br><br> Link do projeto: $HrefLink <br><br></div>";
					}
					if ($divcwidth > $divbwidth && $divcwidth < 800) {
						$timeremaining = abs($timeremaining);
						echo "Um pouco fora do tempo esperado."," Tempo restante: $timeremaining"," dias <br><br> Link do projeto: $HrefLink <br><br></div>";
					}
					if ($divcwidth <= $divbwidth && $divbwidth < 800) {
					 	echo "Tempo restante: $timeremaining"," dias <br><br> Link do projeto: $HrefLink <br><br></div>";
					}

					if ($divcwidth <= $divbwidth && $divbwidth == 800) {
						$arrayObjetoAtual['antecedencia'] = 1;

					 	echo "Completado com antecedencia: $timeremaining"," dias antes! <br><br> Link do projeto: $HrefLink <br><br></div>";
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
						$timeremaining = intval($arrayObjetoAtual['timeremaining']);
						$timeremaining = $timeremaining/10;
						$team = strval($equipes[$ProjectCounter]);
						if ($arrayObjetoAtual['atrasado'] == 1) {
							$math2 = -40/intval($dificuldade[$ProjectCounter]);
							$math2 = $math2+$timeremaining;
							$result = strval($math2);
							$equipespontos[$team] = intval($equipespontos[$team])+intval($math2);

							echo "<div class='bigbox'>",$result," Pontos adicionados a equipe: ",$equipes[$ProjectCounter],"</div>"	;
						}
						elseif ($arrayObjetoAtual['antecedencia'] == 1) {
							$math2 = 10*intval($dificuldade[$ProjectCounter]);
							$math2 = $math2+$timeremaining;
							$result = strval($math2);
							$equipespontos[$team] = intval($equipespontos[$team])+intval($math2);
							echo "<div class='bigbox'>",$result," Pontos adicionados a equipe: ",$equipes[$ProjectCounter],"</div>";
						}
					}

					$ProjectCounter++;
				}
				echo "<div class=boxAfterLoad><center><h2>Classificação das equipes em Lista (sem tabela):</h2></center>";
				echo "Equipe Lua: ",$equipespontos["Lua"];
				echo "<br>Equipe Sol: ",$equipespontos["Sol"];
				echo "<br>Equipe Vulcano: ",$equipespontos["Vulcano"];
				echo "</div><br><br>"
			?>
		<div>
		<script type="text/javascript">
			var luapont = <?php echo $equipespontos["Lua"]?>;
			var solpont = <?php echo $equipespontos["Sol"]?>;
			var vulcanopont = <?php echo $equipespontos["Vulcano"]?>;
		</script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script src="js/graph.js"></script>
	</body>
</html>