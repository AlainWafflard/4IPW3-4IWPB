<?php

const SEUIL = 50;

/**
 * Retourne le nom, l'âge et l'état du solde de l'utilisateur
 * Si âge inconnu alors return string "inconnu"
 * @param bool detail 
 *    true si tous les détails, 
 *    false uniquement le nom 
 * @return array nom, age, a_paye
 */
function get_user($detail=false)
{
	$nom = "Philippe";
	if( ! $detail )
	{
		return [ $nom ];
	}
	
	$age = 27;

	$solde = 150;
	// $a_paye = $solde <= SEUIL ? true : false ; 
	$a_paye = $solde <= SEUIL ;

	return [ $nom, $age ?? "inconnu", $a_paye ];
}


function display_form()
{
	?>
	<form>
		<label>Votre nom : </label>
		<input type="text" name="username">
	</form>
	<?php
}

