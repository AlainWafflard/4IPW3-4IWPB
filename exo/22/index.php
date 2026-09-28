<?php
session_start();
require_once "library.php";

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



// OUTPUT 
require_once "header.html";

echo '<pre> GET = ';
var_dump($_GET);
echo '</pre>';

$msg ='';

if( isset($_GET['logout_b']))
{
    // l'utilisateur a cliqué sur "logout";
    unset($_SESSION['user_identified']);
}

if( isset($_GET['login_b']) )
{
    // l'utilisateur se loggue, a cliqué sur "envoyer"
    if( does_user_exist($_GET['username']) )
    {
        // login ok
        $_SESSION['user_identified'] = true;
        $_SESSION['username'] = $_GET['username'];
    }
    else
    {
        // login ko
        $_SESSION['user_identified'] = false;
        $msg = 'login incorrect';
    }
}

$is_user_identified = $_SESSION['user_identified'] ?? false;

if( $is_user_identified )
{
    // il est identifié => msg de bienvenue
    list( $nom, $age, $a_paye ) = get_user_info($_SESSION['username']);
    display_welcome( $nom, $age );
    display_form_logout();
}
else 
{
    // il n'est pas identifié => login form
    display_form_login($msg);
	// $_SESSION['user_identified'] = true;
}

require_once "footer.html";


