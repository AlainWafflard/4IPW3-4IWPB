<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Exo1X AJAX et SESSION</title>
	<style type="text/css">
	  div.produit { width: 400px; margin: 5px; background-color: #F6E497; }
	  div.panier { width: 400px; margin: 5px; background-color:whitesmoke; }
	</style>
	<script
	 src="https://code.jquery.com/jquery-3.4.1.js"
	 integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	 crossorigin="anonymous"></script>
	<script>

	$( function() {
		
		// URL du serveur 
		var server_url = 'exo11_cart_server_solution.php';

		// évènement associé aux boutons "add product to cart"
		$('button.add').click(function() {
			var param = {
				action		: "add",
				product_id  : $(this).attr('for')
			};
			$.post( server_url, param, display_cart, "json" );
		});
		
		// évènement associé aux boutons "delete product from cart"
		$('button.del').click(function() {
			var param = {
				action		: "del",
				product_id  : $(this).attr('for')
			};
			$.post( server_url, param, display_cart, "json" );
		});
		
		// évènement associé au bouton "effacer panier"
		$('button.del_cart').click(function() {
			if(confirm( "Are you sure ?"))
			{
				var param = {
					action : "del_cart",
				};
				$.post( server_url, param, display_cart, "json" );
			}
		});
		
		// afficher le panier au chargement de la page
		$.post( server_url, display_cart, "json" );

	});

	/*
	 * Mise à jour du panier à l'écran
	 */
	function display_cart(cart_data)
	{
		// on efface le panier courant 
		$("ul#panier_contenu").html("");

		// on recrée les balises <li> 
		// boucle sur le panier avec string et méthode .html()
		s = '';
		$.each( cart_data, function( i, v )
		{
			s += "<li>" + v + "</li>"
		});
		$("ul#panier_contenu").html(s);

		// activer / désactiver les boutons add/del correspondant
		// https://stackoverflow.com/questions/6116474/how-to-find-if-an-array-contains-a-specific-string-in-javascript-jquery
		$.each( $('div.produit'), function( i, el ) {
			var id = $(this).attr('id');
			var foundPresent = cart_data.includes( id );
			console.log(foundPresent);
			if(foundPresent)
			{
				// produit in panier => add KO, del OK
				$('button.add[for="'+id+'"]').attr('disabled','disabled');
				$('button.del[for="'+id+'"]').removeAttr('disabled');
			}
			else
			{
				// produit out panier => add OK, del KO
				$('button.del[for="'+id+'"]').attr('disabled','disabled');
				$('button.add[for="'+id+'"]').removeAttr('disabled');
			}
		});

		/*
		// autre solution : 
		// écrire une boucle sur tous les boutons "ajouter"
		$.each( $("button.add"), function() {
			var prod = $(this).attr('for') ;
			// alert(prod);
			var foundPresent = cart_data.includes(prod); // true/false
			if(foundPresent) 
			{
				$(this).attr( 'disabled', 'disabled' );
			}
			else
			{
				$(this).removeAttr( 'disabled');
			}
		});

		// mais alors il faut aussi écrire une boucle 
		// sur tous les boutons "retirer"
		// => solution plus longue et moins maintenable
		$.each( $("button.delete_product"), function( i, v ) {
			...
		});
		*/
	}

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
		<button class="del" for="produit{$i}">
			Retirer du panier
		</button>
		<hr />
PRODUCT;
	}
	?>

	<div id="panier">
		Dans votre panier :
		<ul id="panier_contenu"></ul>
	</div>
	<button class="del_cart">Effacer le panier</button>

  </body>
</html>