<?php

namespace View;

class Login {

	/**
	 * bouton logout à afficher
	 */
	public static function logout_button():string
	{
		ob_start();
		?>
      <a href="?page=login&action=logout">log out</a>
      <!--<button type="submit" name="logout">log out</button>-->
      <!--
			Remarque : On peut aussi utiliser un hyper-lien pour se délogguer, par ex.
			<a href="?action=logout">log out</a>
			-->
		<?php
		return ob_get_clean();
	}

	/**
	 * bouton login à afficher
	 */
	public static function login_button($user="inconnu"):string
	{
		ob_start();
		?>
      <a href="?page=login&action=login">log in</a>
		<?php
		return ob_get_clean();
	}

	/**
	 * open form
	 */
	public static function open_form():string
	{
		ob_start();
		?>
      <form method="post">
		<?php
		return ob_get_clean();
	}

	/**
	 * close form
	 */
	public static function close_form():string
	{
		ob_start();
		?>
      </form>
		<?php
		return ob_get_clean();
	}

	/**
	 *
	 */
	public static function unidentified_user():string
	{
		return <<< HTML
            Identifiez-vous :
            <input type="text" name="identifier">
            <button type="submit">log in</button>
        HTML;
	}

	public static function link_home():string
	{
		ob_start();
		?>
      <p>
          <a href=".">go to HOME</a>
      </p>
		<?php
		return ob_get_clean();
	}

}


?>