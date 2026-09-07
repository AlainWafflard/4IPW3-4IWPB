<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Exo11 AJAX et SESSION</title>
	<style type="text/css">
	  div.produit { width: 400px; margin: 5px; background-color: #F6E497; }
	  div.panier { width: 400px; margin: 5px; background-color:whitesmoke; }
	</style>
	<script
	 src="https://code.jquery.com/jquery-3.4.1.js"
	 integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	 crossorigin="anonymous"></script>
	<script>
	
	/*
	 * Mise à jour du panier à l'écran
	 */
	function display_cart(cart_data)
	{
		// on efface le panier actuel
		$("ul#panier_contenu").html("");
		
		// on recrée les balises <li> 
		// boucle sur le panier avec string et méthode .html()
		s = '';
        // $.each(JSON.parse(cart_data), function( i, v ) {
        $.each(cart_data, function( i, v ) {
			s += "<li>" + v + "</li>"
		});
		$("ul#panier_contenu").html(s);
	}

	/* 
	 * au chargement de la page
	 */
	$( function() {

		// URL du serveur 
		var server_url = 'exo11_cart_server.php';

		// évènement associé aux boutons 
		$('button.add').click(function() {
			// alert('button clicked' + $(this).attr('for') );
			var param = {  
				product_id : $(this).attr('for') , 
				action:"add" 
			};
			$.post( server_url, param, display_cart, "json" );
		});
		
		// afficher le panier au chargement de la page
		$.post( server_url, display_cart, "json" );

	});
	
	</script>
  </head>
  <body>

	<h1>Mon catalogue</h1>
	
	<?php
	$product_count = 6;
	
	for( $i=1 ; $i<=$product_count ; $i++ )
	{
		echo <<< PRODUCT
		<div id="produit{$i}" class="produit">
			Produit {$i}
		</div>
		<button class="add" for="produit{$i}">
			Ajouter au panier
		</button>
		<hr />
PRODUCT;
	}
	?>

	<div id="panier">
		Dans votre panier :
		<ul id="panier_contenu"></ul>
	</div>
	<button class="del">Effacer le panier</button>

  </body>
</html>