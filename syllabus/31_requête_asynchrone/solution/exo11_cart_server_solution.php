<?php
// créer la session
session_start();
// print_r($_POST);

// créer panier par défaut (vide, évidemment)
if(empty($_SESSION['cart']))
{
	$_SESSION['cart'] = array();
}

// si action = effacer tout le panier 
if( isset($_POST['action']) and 
	$_POST['action']=="del_cart" )
{
	$_SESSION['cart'] = array();
}

// si action = retirer un élément du panier 
if( isset($_POST['action']) and 
	$_POST['action']=="del" and 
	! empty($_POST['product_id']))
{
	foreach( $_SESSION['cart'] as $k => $v )
	{
		if( $v == $_POST['product_id'] )
		{
			unset( $_SESSION['cart'][$k]);
		}
	}
}

// si action = ajouter un produit au panier 
// ajouter un élément au panier 
if( isset($_POST['action']) and 
	$_POST['action']=="add" and 
	! empty($_POST['product_id']))
{
	// on ajoute $_POST['product_id'] à SESSION 
	$_SESSION['cart'][] = $_POST['product_id'];
}

// si l'utilisateur a cliqué deux fois sur le même produit
// alors SESSION ne dédouble pas le nom du produit.
$_SESSION['cart'] = array_unique($_SESSION['cart']);

// et puis le tableau est trié
sort($_SESSION['cart']);

// conversion JSON 
// on utilise array_values() pour réindexer le tableau
// important dans le cas où on a supprimé un produit :
// il faut que les index se suivent, donc les recalculer 
$cart_json = json_encode(array_values($_SESSION['cart']));
// print_r($_SESSION['cart']);
echo $cart_json;

