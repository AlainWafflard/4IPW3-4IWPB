<?php
session_start();
require_once "library.php";

// OUTPUT
require_once "header.html";

echo '<pre> GET = ';
var_dump($_GET);
echo '</pre>';
echo '<pre> POST = ';
var_dump($_POST);
echo '</pre>';

$msg ='';

if( isset($_POST['logout_b']))
{
    // l'utilisateur a cliqué sur "logout";
    unset($_SESSION['user_identified']);
}

if( isset($_POST['login_b']) )
{
    // l'utilisateur se loggue, a cliqué sur "envoyer"
    if( does_user_exist($_POST['username']) )
    {
        // login ok
        $_SESSION['user_identified'] = true;
        $_SESSION['username'] = $_POST['username'];
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


