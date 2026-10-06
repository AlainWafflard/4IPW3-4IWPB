<?php

const SEUIL = 50;

$user_full_info = [
    'anonymous' => [
        'name'  => 'Philippe',
        'age'   => 27,
        'solde' => 150
    ],
    'prof'  => [
        'name'  => 'Merlin',
        'age'   => 127,
        'solde' => 0
    ]
];


/**
 * l'utilisateur existe-t-il ?
 */
function does_user_exist($un)
{
    global $user_full_info;
    $ak = array_keys($user_full_info);
    return in_array( $un, $ak );
}

/**
 * Retourne le nom, l'âge et l'état du solde de l'utilisateur
 * Si âge inconnu alors return string "inconnu"
 * @param bool detail 
 *    true si tous les détails, 
 *    false uniquement le nom 
 * @return array nom, age, a_paye
 */
function get_user_info($un)
{
    global $user_full_info;

    $user_info = $user_full_info[$un];
	$a_paye = $user_info['solde'] <= SEUIL ;

	return [
        $user_info['name'],
        $user_info['age'],
        $a_paye
    ];
}

function display_welcome($nom, $age )
{
    ?>
    <p>
		Bonjour, <?=$nom?> (age <?=$age?>) !
	</p>
    <?php
}


function display_form_login($msg)
{
    if( ! empty($msg) )
    {
        echo "<p style='color:red;'>$msg</p>";
    }
	?>

    <p>Identifiez-vous !</p>
	<form method="post" action="index.php">
		<label>Votre nom : </label>
		<input type="text" name="username">
        <button name="login_b" type="submit">Envoyer</button>
	</form>
	<?php
}

function display_form_logout()
{
    ?>
    <form method="post" action="index.php">
        <label>Délogguez-vous :</label>
        <button name="logout_b" type="submit">Log out !</button>
    </form>
    <?php
}

