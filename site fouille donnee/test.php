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
	  <form id="form1" name="form1" method="get" action="">
		  <label for="dateDebut">Date Debut</label>
		  <div> <input type="text" size="12" id="calendarDateDebut" name="dateDebut" /> </div>
		  <label for="dateFin">Date Fin</label>
		  <div> <input type="text" size="12" id="calendarDateFin" /> </div>
		  <!-- Tree -->
		  <label for="capteur">Capteur</label>
		   <div class="box">
				<img class="image" id="question" src="design/image/question.png" />
				<div id="hide">
				  <p> Total :</p>
				  <p> Batiment est : </p>
				  <p> serveur est :</p>
				  <p> Extension ouest :</p>
			</div><!--end:hide-->
			 <div id="tree"> </div>
		  </div>

		  <label for="labelMoyenne">moyenne</label>
		  <div>
		  <select id="moyenne" name="moyenne">
				<option value="Heure">Heure</option>
				<option value="Jour">Jour</option>
				<option value="Semaine">Semaine</option>
				<option value="Mois">Mois</option>
		   </select>
		   </div>
		  <input name="submit" type="button" onclick="javascript:getss();" value="submit" />

		<div id="module"></div>
		 
		 <input name="export" type="button" onclick="exportDonnees();" value="Export" />
	 </form>
	</body>
</html>