<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<link rel="stylesheet" type="text/css" href="design/style.css" />
		<link rel="stylesheet" type="text/css" href="design/jsDatePick_ltr.min.css" />
		<link rel="stylesheet" type="text/css" href="design/ui.fancytree.css" />
		
		<title>Site fouille de données - Consommation électrique bâtiment 31</title>

		<script type="text/javascript" src="test.js" ></script>
		<!-- JQuery -->
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js" ></script>
	  
		<!-- librairies -->
	  
		<!-- librairie calendrier -->
		<script type="text/javascript" src="js/jsDatePick.jquery.min.1.3.js"></script>
	  
		<!-- librairie arbre checkbox -->
		<script type="text/javascript" src="js/jquery.fancytree.js" ></script>
	  
		<!-- librairie graphique -->
		<script type="text/javascript" src="js/Chart.min.js" ></script>
	</head>

	<body>
		<h1>Fouille de données sur la consommation électrique bâtiment 31</h1>
		
		<form id="form1" name="form1" method="get" action="">
			<div class="date"> 
				<label for="dateDebut">Date Début</label>
				<br />
				<input type="text" size="12" id="calendarDateDebut" />
			</div>
			<div class="date"> 
				<span class="marge1 margeDroite">=></span>
			</div>
			<div class="date"> 
				<label for="dateFin">Date Fin</label>	
				<br />
				<input type="text" size="12" id="calendarDateFin" /> 
			</div>
		 
			<div class="aide">
				<img class="image" id="question" src="design/image/question.png" />
			</div>
			<div class="aide" id="hide">
				<h3>Definitions des capteurs</h3>
				<p><span class="nomADefinir">Total :</span> Consommation électrique totale du bâtiment 31<br />
					<span class="nomADefinir marge1">-Batiment est :</span> Consommation électrique du bâtiment est<br />
					<span class="nomADefinir marge2">--Serveur est :</span> Consommation électrique des serveur situés au 2ème étage du batiment est<br />
					<span class="nomADefinir marge1">-Extension ouest :</span> Consommation électrique de l'extension ouest (au niveau des salles STX)<br />
					<span class="nomADefinir marge2">--Capteur 1,2,3 :</span> Correspondent aux 3 relevées fait sur l'extension ouest. Nous n'avons pas plus de renseignement quand à leur significations.
				</p>
			</div>
			
			<div id="granularite">
				<label for="labelMoyenne">Granularité moyenne</label>
				<select id="moyenne" name="moyenne">
					<option value="Heure">Heure</option>
					<option value="Jour">Jour</option>
					<option value="Semaine">Semaine</option>
					<option value="Mois">Mois</option>
				</select>
			</div>
			
			<!-- arborescence capteur -->
			<div class="box">			
				<label for="capteur">Choix des capteurs</label>
				<div id="listeCapteur"></div>
			</div>
			
			<input type="button" onclick="javascript:getss();" value="Recherche" />
		</form>
		<div id="messageErreur"></div>
		<div id="messageAttention"></div>
		<div id="graphique"></div>
	</body>
</html>