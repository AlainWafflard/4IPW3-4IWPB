<?php
session_start();
require_once "library.php";

/*
$user = get_user(true);
$nom = $user[0];
$age = $user[1];
$a_paye = $user[2];
*/
list( $nom, $age, $a_paye ) = get_user(true);

// $age_out = $age ?? "inconnu";
$out = <<< HTML
	<p>
		Bonjour, $nom (age $age) !
	</p>
HTML;

$greetings = $a_paye 
	? "Merci pour votre paiement" 
	: "Pas d'accès, facture impayée" ;
$out .= "<p>$greetings</p>";

$star = '';
for( $i=0 ; $i<10 ; $i++ )
{
	$star .= '*';
}
$out .= "<p>$star</p>";

$fruits = [ "pomme", "poire", "orange" ];
foreach( $fruits as $f )
{
	$out .= $f . "<br>";
}

/*
foreach( array(5,6,'A','E',5,9,6) as $val )
{
	$out .= <<< HTML
		<div style="background-color:#$val$val$val;">
		$val
		</div>
	HTML;
}
*/

/*
 * nom | note 
 * Arthur : 95,
 * Bidoule : 75,
 * Chery : 45
 */
$points = [
	[
		'nom'	=> 'Arthur',
		'note'	=> 95
	],
	[
		'nom'	=> 'Bidoule',
		'note'	=> 75
	],
	[
		'nom'	=> 'Chery',
		'note'	=> 45
	],	
];

$note_out = '<table border=1>';
foreach( $points as $line )
{
	$note_out .= <<< HTML
		<tr>
			<td>{$line['nom']}</td>
			<td>{$line['note']}</td>
		</tr>
	HTML;
}
$note_out .= '</table>';
// $out .= $note_out;

// OUTPUT 
require_once "header.html";

$user_identified = $_SESSION['user_identified'] ?? false; 

if( $user_identified )
{
	echo $out;
}
else 
{
	display_form();
	$_SESSION['user_identified'] = true;
}

require_once "footer.html";


