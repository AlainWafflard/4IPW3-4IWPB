<?php
$proverbe = array(
	"On ne rassasie pas un chameau en le nourrissant à la cuillère.",
	"Connaître son ignorance est la meilleure part de la connaissance.",
	"Une maison en paille où l'on rit, vaut mieux qu'un palais où l'on pleure.",
	"Le vrai voyageur ne sait pas où il va.",
	"Point n'est besoin d'élever la voix quand on a raison.",
	"Un ami c'est une route, un ennemi c'est un mur.",
	"Un peu de parfum demeure toujours sur la main qui te donne des roses.",
	"Si élevé que soit l'arbre, ses feuilles tombent toujours à terre.",
	"Si ce que tu as à dire n'est pas plus beau que le silence, tais toi.",
	"Trois coupes de vin font saisir une doctrine profonde."
);

$number=$_POST["number"];
// print_r($_POST);

if( empty($number) or $number<=0 or $number>=11 )
{
	echo <<< H
	<span style="color:red;">Entrez un nombre compris entre 1 et 10 !</span>
H;
	exit;
}

echo <<< I
	Proverbe chinois N° $number <br/><br/>
	<span style="color:green;background-color:white;">{$proverbe[$number-1]}</span>
I;

?>