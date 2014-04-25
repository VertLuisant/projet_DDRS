<?php
	include_once "../connectBD.php";
	include_once "../calculMoyenne.php";
	
	$donneesHistogramme = array(
		labels => array("January","February","March","April","May","June","July"),
		datasets => array(
			array(
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				data : [65,59,90,81,56,55,40]
			),
			array(
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,1)",
			data : [28,48,40,19,96,27,100]
			)
		)	
	)
	echo json_encode (donneesHistogramme);
?>