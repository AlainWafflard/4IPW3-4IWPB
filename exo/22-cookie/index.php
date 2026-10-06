<?php
session_start();
require_once "library.php";

// gestion des cookies

$msg ='';

if( isset($_POST['logout_b']))
{
	// l'utilisateur a cliqué sur "logout";
	// unset($_SESSION['user_identified']);
	setcookie('user_identified', "false", 1, "/" );
	setcookie( 'username', "", 1, "/" );
	$is_user_identified = false;
}

if( isset($_POST['login_b']) )
{
	// l'utilisateur se loggue, a cliqué sur "envoyer"
	if( does_user_exist($_POST['username']) )
	{
		// login ok
		// $_SESSION['user_identified'] = true;
		setcookie( 'user_identified', "true", time() + 180, "/" );
		// $_SESSION['username'] = $_POST['username'];
		setcookie( 'username',  $_POST['username'], time() + 180, "/" );
		$is_user_identified = true;
		$username = $_POST['username'];
	}
	else
	{
		// login ko
		// $_SESSION['user_identified'] = false;
		setcookie('user_identified', "false", 1, "/" );
		setcookie( 'username', "", 1, "/" );
		$msg = 'login incorrect';
		$is_user_identified = false;
	}
}

if( ! isset($is_user_identified) )
{
	$is_user_identified = ( isset($_COOKIE['user_identified']) && $_COOKIE['user_identified']=="true" ) ? true : false;
}

if( $is_user_identified)
{
	setcookie( 'user_identified', "true", time() + 180, "/" );
}

if( $is_user_identified && ! isset($username) ) {
	$username = $_COOKIE['username'];
	setcookie('username', $username, time() + 180, "/");
}


// OUTPUT
require_once "header.html";

echo '<pre> GET = ';
var_dump($_GET);
echo '</pre>';
echo '<pre> POST = ';
var_dump($_POST);
echo '</pre>';


if( $is_user_identified )
{
    // il est identifié => msg de bienvenue
    list( $nom, $age, $a_paye ) = get_user_info($username);
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


