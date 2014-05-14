<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  <link rel="stylesheet" href="design/style.css"/>
  <link rel="stylesheet" type="text/css" media="all" href="design/jsDatePick_ltr.min.css" />
  <link href="design/ui.fancytree.css" rel="stylesheet" type="text/css">
  <title></title>

  <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="js/jsDatePick.jquery.min.1.3.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/jquery.fancytree.js" ></script>
  <script type="text/javascript" src="js/Chart.min.js" ></script>
  <script type="text/javascript" src="test.js" ></script>
  <!-- (Irrelevant source removed.) -->

<style type="text/css">
.box{ margin:0 auto; float:right;}
.cacheElem{ margin : 5px; padding:10px; border:1px solid #E4E4E4; color:#333 }
.infoElem{margin-left: 5px; display: inline-block;}
</style>

<script type="text/javascript">

</script>
</head>

<body>

 
  <form id="form1" name="form1" method="post" action="">
  <label for="dateDebut">Date Debut</label>
  <div> <input type="text" size="12" id="calendarDateDebut" /> </div>
  <label for="dateFin">Date Fin</label>
  <div> <input type="text" size="12" id="calendarDateFin" /> </div>
  <!-- Tree -->
  <label for="capteur">Capteur</label>
  <div id="tree"> </div>
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
 </form>
 <div id="module"></div>
  <!-- (Irrelevant source removed.) -->
</body>
</html>