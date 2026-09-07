<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Exo16-37 : TIMER EVENT</title>
	<style type="text/css">
		div#color_changing 
		{
		  border 			: 1px solid green;
		  background-color 	: rgb(255, 255, 0);
		  text-align:center;
		}
	</style>
	<script
	 src="https://code.jquery.com/jquery-3.4.1.js"   
	 integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	 crossorigin="anonymous"></script>
	<script>
	
	// Afficher l'heure courante 
	// avec deux digits pour les heures, minutes et secondes
	function Horloge() 
	{
		var laDate = new Date();
		var hou = String(laDate.getHours()).padStart(2, "0");
		var min = String(laDate.getMinutes()).padStart(2, "0");
		var sec = String(laDate.getSeconds()).padStart(2, "0");
		var h = hou + ":" + min + ":" + sec ;
		$('#heure').text(h);
	}
	
	// changer la couleur d'un div 
	// rotation jaune, magenta, cyan
	function ChangingColor()
	{
		var bgColor = $("#color_changing").css("background-color");
		if (bgColor == "rgb(255, 255, 0)") 
		{
			$("#color_changing").css("background-color", "rgb(255, 0, 255)");
		}
		else if (bgColor == "rgb(255, 0, 255)")
		{
			$("#color_changing").css("background-color", "rgb(0, 255, 255)");
		}
		else
		{
			$("#color_changing").css("background-color", "rgb(255, 255, 0)");
		}
	}

	// au chargement de la page
	$( function() 
	{
		// Color changing every 3 seconds
		setInterval(ChangingColor, 3000);

		// Horloge, rafraîchie chaque seconde
		setInterval(Horloge, 1000);
	});

	</script>
  </head>
  <body>

	<h1>Exo16-37 : TIMER EVENT</h1>
	<h2>Horloge</h2>
	<div id="heure"></div>

	<h2>Changing color</h2>
	<div id="color_changing">My color changes automatically</div>
  
  </body>
</html>